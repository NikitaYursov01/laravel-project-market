<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Services\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Показать форму создания заказа
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Сохранить новый заказ
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Валидация данных
        $validator = Validator::make($request->all(), [
            'order_name' => 'required|string|max:255',
            'category' => 'required|string|in:metal_sheet,metal_pipe,metal_beam,metal_rebar,metal_wire,metal_processing,metal_products,delivery,other',
            'budget' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'materials' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'required|date|after:today',
            'technical_requirements' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // до 10MB
        ], [
            'order_name.required' => 'Название заказа обязательно для заполнения',
            'order_name.max' => 'Название заказа не должно превышать 255 символов',
            'category.required' => 'Выберите категорию',
            'category.in' => 'Выбрана недопустимая категория',
            'budget.required' => 'Укажите бюджет',
            'budget.max' => 'Бюджет не должен превышать 100 символов',
            'description.required' => 'Описание заказа обязательно',
            'description.min' => 'Описание должно содержать минимум 10 символов',
            'completion_date.required' => 'Укажите срок выполнения',
            'completion_date.date' => 'Укажите корректную дату',
            'completion_date.after' => 'Срок выполнения должен быть позже сегодняшней даты',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: JPEG, PNG, JPG, GIF',
            'images.*.max' => 'Размер изображения не должен превышать 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('orders.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Определяем тип объявления по роли пользователя
        $orderType = auth()->user()->isPerformer() ? 'performer_service' : 'client_order';

        // Сохраняем заказ в базу данных
        $order = Order::create([
            'title' => $request->order_name,
            'category' => $request->category,
            'budget' => $request->budget,
            'description' => $request->description,
            'materials' => $request->materials,
            'location' => $request->location,
            'completion_date' => $request->completion_date,
            'technical_requirements' => $request->technical_requirements,
            'user_id' => auth()->id(),
            'status' => 'active',
            'type' => $orderType,
        ]);

        // Создаем уведомление для пользователя
        \App\Models\Notification::create([
            'user_id' => auth()->id(),
            'type' => 'order_created',
            'title' => $user->isPerformer() ? 'Ваша услуга размещена' : 'Ваш заказ размещен',
            'message' => '"' . $request->order_name . '" теперь доступен в ленте',
            'link' => route('orders.detail', $order->id),
            'is_important' => false,
        ]);

        // Сохраняем изображения
        if ($request->hasFile('images')) {
            $orderNumber = 0;
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('order-images/' . $order->id, 'public');
                    \App\Models\OrderImage::create([
                        'order_id' => $order->id,
                        'path' => $path,
                        'original_name' => $image->getClientOriginalName(),
                        'order' => $orderNumber++,
                    ]);
                }
            }
        }

        // Очищаем кэш после создания заказа
        Functions::clearOrdersCache();

        return redirect()
            ->route('orders.my')
            ->with('success', 'Заказ успешно размещен!' . ($request->hasFile('images') ? ' Изображения загружены.' : ''));
    }

    /**
     * Показать ленту заказов с фильтрацией по роли
     * - Исполнитель видит объявления заказчиков (type = client_request)
     * - Заказчик видит объявления исполнителей (type = performer_service)
     * - Администратор видит всё
     * - Пользователь может переключать тип через параметр ?type=
     */
    public function feed(Request $request)
    {
        $query = Order::with('user')->active()->latest();

        $user = auth()->user();

        // Определяем умолчание по роли
        $defaultType = 'all';
        if ($user) {
            if ($user->isPerformer()) {
                $defaultType = 'client_request'; // Исполнитель по умолчанию видит заказы
            } elseif ($user->isClient()) {
                $defaultType = 'performer_service'; // Заказчик по умолчанию видит услуги
            }
        }

        // Получаем выбранный тип из запроса или используем умолчание
        $selectedType = $request->filled('type') ? $request->type : $defaultType;

        // Фильтрация по типу (если не "all")
        if ($selectedType !== 'all') {
            $query->where('type', $selectedType);
        }

        // Фильтр по категории
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Поиск по названию и описанию
        if ($request->filled('q')) {
            $q = mb_strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(title) LIKE ?', ['%' . $q . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $q . '%']);
            });
        }

        $orders = $query->paginate(10)->withQueryString();
        $categories = Functions::getCategoriesWithCount();
        $stats = Functions::getOrdersStats();

        // Тип просматриваемой ленты для UI
        $viewType = $selectedType;
        $canSwitchType = $user && ($user->isManager() || true); // Все авторизованные могут переключать

        return view('orders.feed', compact('orders', 'categories', 'stats', 'viewType'));
    }

    /**
     * Показать мои заказы
     */
    public function my(Request $request)
    {
        $user = auth()->user();
        $userStats = Functions::getUserStats($user->id);

        // Общие счётчики для всех заказов пользователя
        $activeCount = Order::byUser($user->id)->where('status', 'active')->count();
        $completedCount = Order::byUser($user->id)->where('status', 'completed')->count();

        $query = Order::with('user')
            ->byUser($user->id)
            ->latest();

        // Фильтр по статусу (по умолчанию активные)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active');
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.my', compact('orders', 'userStats', 'activeCount', 'completedCount'));
    }

    /**
     * Показать детальную страницу заказа
     */
    public function detail($id)
    {
        $order = Order::with(['user', 'images'])->findOrFail($id);

        return view('orders.detail', compact('order'));
    }

    /**
     * Принять заказ (создает чат автоматически)
     * Проверка: исполнитель может принимать только заказы заказчиков
     *           заказчик может принимать только объявления исполнителей
     */
    public function accept(Order $order)
    {
        $user = auth()->user();

        // Проверки
        if ($order->status !== 'active') {
            return back()->with('error', 'Заказ не активен');
        }

        if ($order->user_id === $user->id) {
            return back()->with('error', 'Нельзя принять свой собственный заказ');
        }

        // Проверка соответствия роли и типа объявления
        if (!$user->isManager()) {
            if ($user->isPerformer() && $order->type !== 'client_request') {
                return back()->with('error', 'Исполнитель может принимать только заказы заказчиков');
            }
            if ($user->isClient() && $order->type !== 'performer_service') {
                return back()->with('error', 'Заказчик может принимать только объявления исполнителей');
            }
        }

        // Проверка существующего чата
        $existingChat = Chat::where('order_id', $order->id)
            ->where(function ($q) use ($user) {
                $q->where('performer_id', $user->id)
                    ->orWhere('client_id', $user->id);
            })
            ->first();

        if ($existingChat) {
            return redirect()->route('chats.show', $existingChat)
                ->with('info', 'Вы уже приняли этот заказ');
        }

        // Создать чат
        $chat = \App\Http\Controllers\ChatController::createChatForOrder($order, $user->id);

        return redirect()->route('chats.show', $chat)
            ->with('success', 'Заказ принят! Чат создан автоматически.');
    }

    /**
     * Отправить отклик на заказ (создает чат автоматически)
     * Проверка: исполнитель может откликаться только на заказы заказчиков
     *           заказчик может откликаться только на объявления исполнителей
     */
    public function respond(Request $request, Order $order)
    {
        $user = auth()->user();

        // Проверки
        if ($order->status !== 'active') {
            return back()->with('error', 'Заказ не активен');
        }

        if ($order->user_id === $user->id) {
            return back()->with('error', 'Нельзя откликаться на свой заказ');
        }

        // Проверка соответствия роли и типа объявления
        if (!$user->isManager()) {
            if ($user->isPerformer() && $order->type !== 'client_request') {
                return back()->with('error', 'Исполнитель может откликаться только на заказы заказчиков');
            }
            if ($user->isClient() && $order->type !== 'performer_service') {
                return back()->with('error', 'Заказчик может откликаться только на объявления исполнителей');
            }
        }
        // Администратор может откликаться на любые типы

        // Проверка существующего чата
        $existingChat = Chat::where('order_id', $order->id)
            ->where(function ($q) use ($user) {
                $q->where('performer_id', $user->id)
                    ->orWhere('client_id', $user->id);
            })
            ->first();

        if ($existingChat) {
            return redirect()->route('chats.show', $existingChat)
                ->with('info', 'Вы уже откликнулись на этот заказ');
        }

        // Валидация
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'price' => 'nullable|string|max:50',
            'deadline' => 'nullable|string|max:50',
        ]);

        // Создать чат
        $chat = \App\Http\Controllers\ChatController::createChatForOrder($order, $user->id);

        // Добавить сообщение с откликом
        $responseText = $validated['message'];
        if ($validated['price'] || $validated['deadline']) {
            $responseText .= "\n\n";
            if ($validated['price']) {
                $responseText .= "💰 Предлагаемая цена: {$validated['price']}₽\n";
            }
            if ($validated['deadline']) {
                $responseText .= "⏰ Срок выполнения: {$validated['deadline']}";
            }
        }

        \App\Models\Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'content' => $responseText,
            'type' => 'text',
        ]);

        // Обновить время последнего сообщения
        $chat->update(['last_message_at' => now()]);

        return redirect()->route('chats.show', $chat)
            ->with('success', 'Отклик отправлен! Чат создан. Заказчик увидит ваше сообщение.');
    }

    /**
     * Показать форму редактирования заказа
     */
    public function edit(Order $order)
    {
        $user = auth()->user();

        // Только автор или админ может редактировать
        if ($order->user_id !== $user->id && !$user->isManager()) {
            abort(403, 'У вас нет прав на редактирование этого заказа');
        }

        // Нельзя редактировать закрытые заказы
        if ($order->status === 'completed' || $order->status === 'closed') {
            return back()->with('error', 'Нельзя редактировать закрытый заказ');
        }

        // Загружаем заказ с изображениями
        $order->load('images');

        return view('orders.edit', compact('order'));
    }

    /**
     * Обновить заказ
     */
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();

        // Только автор или админ может обновлять
        if ($order->user_id !== $user->id && !$user->isManager()) {
            abort(403, 'У вас нет прав на обновление этого заказа');
        }

        // Нельзя обновлять закрытые заказы
        if ($order->status === 'completed' || $order->status === 'closed') {
            return back()->with('error', 'Нельзя обновлять закрытый заказ');
        }

        // Валидация
        $validator = Validator::make($request->all(), [
            'order_name' => 'required|string|max:255',
            'category' => 'required|string|in:metal_sheet,metal_pipe,metal_beam,metal_rebar,metal_wire,metal_processing,metal_products,delivery,other',
            'budget' => 'required|string|max:100',
            'description' => 'required|string|min:20|max:5000',
            'materials' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'completion_date' => 'required|date|after:today',
            'technical_requirements' => 'nullable|string|max:2000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: JPEG, PNG, JPG, GIF',
            'images.*.max' => 'Размер изображения не должен превышать 10MB',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Определяем тип объявления на основе роли
        $orderType = $user->isPerformer() ? 'performer_service' : 'client_request';

        // Обновляем заказ
        $order->update([
            'title' => $request->order_name,
            'category' => $request->category,
            'budget' => $request->budget,
            'description' => $request->description,
            'materials' => $request->materials,
            'location' => $request->location,
            'completion_date' => $request->completion_date,
            'technical_requirements' => $request->technical_requirements,
            'type' => $orderType,
        ]);

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            $orderNumber = $order->images()->count();
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('order-images/' . $order->id, 'public');
                    \App\Models\OrderImage::create([
                        'order_id' => $order->id,
                        'path' => $path,
                        'original_name' => $image->getClientOriginalName(),
                        'order' => $orderNumber++,
                    ]);
                }
            }
        }

        // Очищаем кэш
        Functions::clearOrdersCache();

        return redirect()
            ->route('orders.my')
            ->with('success', 'Заказ успешно обновлен!' . ($request->hasFile('images') ? ' Изображения добавлены.' : ''));
    }

    /**
     * Удалить (закрыть) заказ
     */
    public function destroy(Order $order)
    {
        $user = auth()->user();

        // Только автор или админ может удалять
        if ($order->user_id !== $user->id && !$user->isManager()) {
            abort(403, 'У вас нет прав на удаление этого заказа');
        }

        // Если заказ уже закрыт - удаляем полностью
        if ($order->status === 'completed' || $order->status === 'closed') {
            $order->delete();
            return redirect()
                ->route('orders.my')
                ->with('success', 'Заказ удален');
        }

        // Иначе закрываем (мягкое удаление через статус)
        $order->update(['status' => 'completed']);

        // Закрываем связанные чаты
        Chat::where('order_id', $order->id)->update(['status' => 'closed']);

        return redirect()
            ->route('orders.my')
            ->with('success', 'Заказ закрыт. Вы можете удалить его полностью позже.');
    }
}
