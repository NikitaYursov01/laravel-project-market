<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Список чатов пользователя
     */
    public function index()
    {
        $user = auth()->user();

        $chats = Chat::with([
            'order',
            'client',
            'performer',
            'messages' => function ($q) {
                $q->latest()->limit(1);
            }
        ])
            ->forUser($user->id)
            ->orderByDesc('last_message_at')
            ->orderByDesc('created_at')
            ->get();

        return view('chats.index', compact('chats'));
    }

    /**
     * Показать конкретный чат (split-view слева список, справа чат)
     */
    public function show(Chat $chat)
    {
        $user = auth()->user();

        // Проверка доступа
        if (!$this->hasAccess($chat, $user->id)) {
            abort(403, 'Доступ запрещен');
        }

        // Отметить сообщения как прочитанные
        $chat->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Загрузить все сообщения
        $chat->load(['messages.sender', 'order', 'client', 'performer', 'manager']);

        // Получить все чаты пользователя для левой панели
        $chats = Chat::with([
            'order',
            'client',
            'performer',
            'messages' => function ($q) {
                $q->latest()->limit(1);
            }
        ])
            ->forUser($user->id)
            ->orderByDesc('last_message_at')
            ->orderByDesc('created_at')
            ->get();

        return view('chats.index', compact('chats', 'chat'));
    }

    /**
     * Отправить сообщение
     */
    public function storeMessage(Request $request, Chat $chat)
    {
        $user = auth()->user();

        if (!$this->hasAccess($chat, $user->id)) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Обновить время последнего сообщения
        $chat->update(['last_message_at' => now()]);

        return redirect()->route('chats.show', $chat);
    }

    /**
     * Переключение между участниками для менеджера
     */
    public function switchParticipant(Request $request, Chat $chat)
    {
        $user = auth()->user();

        if (!$user->isManager()) {
            abort(403);
        }

        $participant = $request->get('participant'); // 'client' или 'performer'
        $orderId = $chat->order_id;

        // Найти или создать чат с нужным участником
        if ($participant === 'client') {
            $targetChat = Chat::firstOrCreate(
                [
                    'order_id' => $orderId,
                    'client_id' => $chat->client_id,
                    'manager_id' => $user->id,
                ],
                [
                    'performer_id' => $chat->performer_id,
                    'status' => 'active',
                ]
            );
        } else {
            $targetChat = Chat::firstOrCreate(
                [
                    'order_id' => $orderId,
                    'performer_id' => $chat->performer_id,
                    'manager_id' => $user->id,
                ],
                [
                    'client_id' => $chat->client_id,
                    'status' => 'active',
                ]
            );
        }

        return redirect()->route('chats.show', $targetChat)
            ->with('participant', $participant);
    }

    /**
     * Создать чат при назначении исполнителя на заказ
     * Вызывается автоматически при назначении
     */
    public static function createChatForOrder(Order $order, int $performerId): Chat
    {
        // Найти или назначить менеджера (первый админ или null)
        $manager = User::where('role', 'manager')->first();

        $chat = Chat::create([
            'order_id' => $order->id,
            'client_id' => $order->user_id,
            'performer_id' => $performerId,
            'manager_id' => $manager?->id,
            'status' => 'active',
        ]);

        // Системное сообщение о создании чата
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $performerId,
            'content' => 'Я принял заказ и готов к работе. Есть вопросы по заданию?',
            'type' => 'system',
        ]);

        $chat->update(['last_message_at' => now()]);

        return $chat;
    }

    /**
     * Назначить менеджера на чат
     */
    public function assignManager(Chat $chat)
    {
        $user = auth()->user();

        if (!$user->isManager()) {
            abort(403);
        }

        $chat->update(['manager_id' => $user->id]);

        // Системное сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => "Менеджер {$user->name} подключился к диалогу",
            'type' => 'system',
        ]);

        return back()->with('success', 'Вы назначены менеджером этого чата');
    }

    /**
     * Закрыть чат - только администратор
     */
    public function close(Chat $chat)
    {
        $user = auth()->user();

        // ТОЛЬКО менеджер может закрыть заказ
        if (!$user->isManager()) {
            abort(403, 'Только администратор может закрывать заказы');
        }

        $chat->update(['status' => 'closed']);

        // Закрываем также заказ
        $chat->order->update(['status' => 'completed']);

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => '✅ ЗАКАЗ ЗАКРЫТ АДМИНИСТРАТОРОМ. Работа завершена.',
            'type' => 'system',
        ]);

        return redirect()->route('chats.index')->with('success', 'Заказ закрыт администратором');
    }

    /**
     * AJAX polling endpoint для проверки новых сообщений
     */
    public function poll(Chat $chat)
    {
        $user = auth()->user();

        if (!$this->hasAccess($chat, $user->id)) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $count = $chat->messages()->count();
        $unread = $chat->unreadCount($user->id);

        return response()->json([
            'message_count' => $count,
            'unread_count' => $unread,
        ]);
    }

    /**
     * Проверка доступа к чату
     */
    private function hasAccess(Chat $chat, int $userId): bool
    {
        return in_array($userId, [
            $chat->client_id,
            $chat->performer_id,
            $chat->manager_id,
        ]);
    }
}
