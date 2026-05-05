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
            'messages' => function ($q) use ($user) {
                $q->where(function ($qq) use ($user) {
                    $qq->whereNull('recipient_id')
                        ->orWhere('recipient_id', $user->id);
                })
                    ->latest()
                    ->limit(1);
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

        // Отметить видимые сообщения как прочитанные
        $chat->messages()
            ->where('sender_id', '!=', $user->id)
            ->where(function ($q) use ($user) {
                $q->whereNull('recipient_id')
                    ->orWhere('recipient_id', $user->id);
            })
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Загрузить только видимые сообщения
        $chat->load([
            'messages' => function ($q) use ($user) {
                $q->where(function ($qq) use ($user) {
                    $qq->whereNull('recipient_id')
                        ->orWhere('recipient_id', $user->id);
                })->orderBy('created_at');
            },
            'messages.sender',
            'order',
            'client',
            'performer',
            'manager'
        ]);

        // Получить все чаты пользователя для левой панели
        $chats = Chat::with([
            'order',
            'client',
            'performer',
            'messages' => function ($q) use ($user) {
                $q->where(function ($qq) use ($user) {
                    $qq->whereNull('recipient_id')
                        ->orWhere('recipient_id', $user->id);
                })
                    ->latest()
                    ->limit(1);
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

        $recipientId = null;

        // Политика: заказчик/исполнитель пишут менеджеру, менеджер отвечает выбранному участнику
        if (!$user->isManager() && !$user->isAdmin()) {
            // Клиент/исполнитель -> менеджеру
            if (!$chat->manager_id) {
                return back()->with('error', 'Менеджер еще не назначен. Попробуйте позже.');
            }
            $recipientId = $chat->manager_id;
        } else {
            // Менеджер/админ -> активному участнику
            $participant = $request->input('participant');
            if (!$participant) {
                $participant = session('chat_' . $chat->id . '_participant', 'client');
            }
            $recipientId = $participant === 'performer' ? $chat->performer_id : $chat->client_id;
        }

        // Создаем сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'recipient_id' => $recipientId,
            'content' => $request->input('content'),
            'type' => 'text',
        ]);

        // Обновить время последнего сообщения
        $chat->update(['last_message_at' => now()]);

        return redirect()->route('chats.show', $chat);
    }

    /**
     * Переключение между участниками для менеджера
     * Сохраняет выбор в сессии для отображения сообщений от конкретного участника
     */
    public function switchParticipant(Request $request, Chat $chat)
    {
        $user = auth()->user();

        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403);
        }

        $participant = $request->get('participant'); // 'client' или 'performer'

        // Сохраняем выбор в сессии
        session(['chat_' . $chat->id . '_participant' => $participant]);

        return redirect()->route('chats.show', $chat)
            ->with('participant', $participant);
    }

    /**
     * Создать чат при назначении исполнителя на заказ
     * Автоматически назначает свободного менеджера (лимит 2 заказа)
     */
    public static function createChatForOrder(Order $order, int $performerId): Chat
    {
        // Найти свободного менеджера (лимит 2 заказа)
        $manager = User::findAvailableManager();

        $chat = Chat::create([
            'order_id' => $order->id,
            'client_id' => $order->user_id,
            'performer_id' => $performerId,
            'manager_id' => $manager?->id,
            'status' => 'active',
        ]);

        // Системное сообщение о создании чата
        if ($manager) {
            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $manager->id,
                'content' => "Менеджер {$manager->name} назначен на заказ. Все вопросы через менеджера.",
                'type' => 'system',
            ]);
        }

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $performerId,
            'content' => 'Я принял заказ и готов к работе.',
            'type' => 'system',
        ]);

        $chat->update(['last_message_at' => now()]);

        return $chat;
    }

    /**
     * Назначить менеджера на чат вручную (для админов)
     */
    public function assignManager(Chat $chat)
    {
        $user = auth()->user();

        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403);
        }

        // Проверка лимита менеджера
        if (!$user->canTakeMoreOrders()) {
            return back()->with('error', 'Лимит заказов исчерпан (максимум 2)');
        }

        $chat->update(['manager_id' => $user->id]);

        // Системное сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => "Менеджер {$user->name} назначен на заказ.",
            'type' => 'system',
        ]);

        return back()->with('success', 'Вы назначены менеджером этого чата');
    }

    /**
     * Отклонить исполнителя менеджером (заказ возвращается в ленту)
     */
    public function rejectPerformer(Chat $chat)
    {
        $user = auth()->user();

        // Только менеджер этого чата или админ
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Только менеджер может отклонить исполнителя');
        }

        if ($chat->manager_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Вы не назначены менеджером этого чата');
        }

        $performer = $chat->performer;
        $order = $chat->order;

        // Закрываем чат
        $chat->update(['status' => 'closed']);

        // Системное сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => "Менеджер отклонил исполнителя {$performer?->name}. Заказ возвращен в ленту.",
            'type' => 'system',
        ]);

        // Уведомляем исполнителя
        if ($performer) {
            \App\Models\Notification::create([
                'user_id' => $performer->id,
                'type' => 'performer_rejected',
                'title' => 'Менеджер отклонил вашу кандидатуру',
                'message' => "По заказу \"{$order->title}\" менеджер отклонил исполнителя",
                'link' => route('orders.feed'),
                'is_important' => true,
            ]);
        }

        // Если менеджер освободился - автоматически возьмём новые чаты без менеджера
        if ($user->isManager()) {
            $this->autoAssignWaitingChatsToManager($user);
        }

        return redirect()->route('chats.index')
            ->with('success', 'Исполнитель отклонен. Заказ возвращен в ленту.');
    }

    /**
     * Возобновить заказ (администратором) - заказ снова доступен
     */
    public function reopenOrder(Chat $chat)
    {
        $user = auth()->user();

        // Только админ может возобновить заказ
        if (!$user->isAdmin()) {
            abort(403, 'Только администратор может возобновить заказ');
        }

        $order = $chat->order;

        // Закрываем текущий чат
        $chat->update(['status' => 'closed']);

        // Возвращаем заказ в активный статус
        $order->update(['status' => 'active']);

        // Системное сообщение
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => "Администратор возобновил заказ. Заказ доступен для новых откликов.",
            'type' => 'system',
        ]);

        // Уведомляем заказчика
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'type' => 'order_reopened',
            'title' => 'Заказ возобновлен',
            'message' => "Заказ \"{$order->title}\" снова доступен для откликов.",
            'link' => route('orders.detail', $order->id),
            'is_important' => false,
        ]);

        return redirect()->route('admin.chats')
            ->with('success', 'Заказ возобновлен и доступен для новых откликов.');
    }

    /**
     * Закрыть чат - только администратор
     */
    public function close(Chat $chat)
    {
        $user = auth()->user();

        // Закрывать может менеджер этого чата или админ
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Только менеджер или администратор может закрывать заказы');
        }

        if ($user->isManager() && $chat->manager_id !== $user->id) {
            abort(403, 'Вы не назначены менеджером этого чата');
        }

        $chat->update(['status' => 'closed']);

        // Закрываем также заказ
        $chat->order->update(['status' => 'completed']);

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => '✅ ЗАКАЗ ЗАКРЫТ МЕНЕДЖЕРОМ. Работа завершена.',
            'type' => 'system',
        ]);

        // Автоназначение новых чатов менеджеру при освобождении
        if ($user->isManager()) {
            $this->autoAssignWaitingChatsToManager($user);
        }

        return redirect()->route('chats.index')->with('success', 'Заказ закрыт');
    }

    /**
     * Автоматически назначить текущему менеджеру чаты без менеджера (если есть свободный лимит)
     */
    private function autoAssignWaitingChatsToManager(User $manager): void
    {
        if (!$manager->isManager() || !$manager->canTakeMoreOrders()) {
            return;
        }

        $availableSlots = 2 - $manager->activeManagedChatsCount();
        if ($availableSlots <= 0) {
            return;
        }

        $waitingChats = Chat::with(['order'])
            ->whereNull('manager_id')
            ->where('status', 'active')
            ->orderBy('created_at')
            ->limit($availableSlots)
            ->get();

        /** @var Chat $waitingChat */
        foreach ($waitingChats as $waitingChat) {
            $waitingChat->update(['manager_id' => $manager->id]);

            Message::create([
                'chat_id' => $waitingChat->id,
                'sender_id' => $manager->id,
                'content' => "Менеджер {$manager->name} назначен на заказ. Все вопросы через менеджера.",
                'type' => 'system',
            ]);

            $waitingChat->update(['last_message_at' => now()]);
        }
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

        $count = $chat->messages()
            ->where(function ($q) use ($user) {
                $q->whereNull('recipient_id')
                    ->orWhere('recipient_id', $user->id);
            })
            ->count();
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
