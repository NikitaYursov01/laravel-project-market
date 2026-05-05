@php
    $unassignedCount = $unassignedChats->count();
    $myCount = $myChats->count();
    $workload = auth()->user()?->getWorkload();
@endphp

<div class="profile-section bg-white rounded-xl border border-gray-200 p-6" data-section="admin-chats">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Управление чатами</h2>
            <p class="text-sm text-gray-500 mt-1">Назначайте себя на диалоги между заказчиками и исполнителями</p>
        </div>
        <div class="flex gap-2">
            @if($workload)
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                    <i class="fa fa-tasks mr-1"></i>{{ $workload['active'] }}/{{ $workload['limit'] }} занято
                </span>
            @endif
            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm font-medium">
                <i class="fa fa-clock-o mr-1"></i>{{ $unassignedCount }} ожидают
            </span>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                <i class="fa fa-user mr-1"></i>{{ $myCount }} мои
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Нуждаются в назначении -->
    @if($unassignedCount > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fa fa-bell text-amber-500 mr-2"></i>
                Чаты без менеджера
            </h3>
            <div class="space-y-3">
                @foreach($unassignedChats as $chat)
                    <div class="flex items-center justify-between p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->client->name ?? '??', 0, 2) }}
                                </div>
                                <div
                                    class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->performer->name ?? '??', 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    Заказ #{{ $chat->order_id }}: {{ Str::limit($chat->order->title ?? 'Без названия', 40) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    <span class="text-blue-600">{{ $chat->client->name ?? 'Клиент' }}</span>
                                    ↔
                                    <span class="text-green-600">{{ $chat->performer->name ?? 'Исполнитель' }}</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Создан: {{ $chat->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('chats.show', $chat) }}" target="_blank"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                <i class="fa fa-eye mr-1"></i>Просмотр
                            </a>
                            <form action="{{ route('admin.chats.assign', $chat) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 transition-colors">
                                    <i class="fa fa-user-plus mr-1"></i>Взять в работу
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Мои чаты -->
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fa fa-comments text-blue-500 mr-2"></i>
            Мои активные чаты
        </h3>
        @if($myChats->count() > 0)
            <div class="space-y-3">
                @foreach($myChats as $chat)
                    <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->client->name ?? '??', 0, 2) }}
                                </div>
                                <div
                                    class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->performer->name ?? '??', 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    Заказ #{{ $chat->order_id }}: {{ Str::limit($chat->order->title ?? 'Без названия', 40) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    <span class="text-blue-600">{{ $chat->client->name ?? 'Клиент' }}</span>
                                    ↔
                                    <span class="text-green-600">{{ $chat->performer->name ?? 'Исполнитель' }}</span>
                                </p>
                                @php
                                    $unreadCount = $chat->unreadCount(auth()->id());
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs mt-1">
                                        {{ $unreadCount }} новых сообщений
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('chats.show', $chat) }}" target="_blank"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                <i class="fa fa-comments mr-1"></i>Открыть чат
                            </a>
                            <form action="{{ route('admin.chats.unassign', $chat) }}" method="POST" class="inline"
                                onsubmit="return confirm('Отключиться от чата? Другой менеджер сможет взять его в работу.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Отказаться от чата">
                                    <i class="fa fa-user-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <i class="fa fa-check-circle text-3xl text-green-500 mb-3"></i>
                <p class="text-gray-500">У вас нет активных чатов</p>
                <p class="text-sm text-gray-400 mt-1">Возьмите чат из списка выше или дождитесь новых заказов</p>
            </div>
        @endif
    </div>

    <!-- Все чаты (для админа) -->
    @if($allChats && auth()->user()->isAdmin())
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fa fa-list text-gray-500 mr-2"></i>
                Все активные чаты
            </h3>
            <div class="space-y-2">
                @foreach($allChats as $chat)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->client->name ?? '??', 0, 2) }}
                                </div>
                                <div
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold border-2 border-white">
                                    {{ substr($chat->performer->name ?? '??', 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    Заказ #{{ $chat->order_id }}: {{ Str::limit($chat->order->title ?? 'Без названия', 30) }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    @if($chat->manager)
                                        <span class="text-amber-600">Менеджер: {{ $chat->manager->name }}</span>
                                    @else
                                        <span class="text-red-500">Без менеджера</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('chats.show', $chat) }}" target="_blank"
                            class="text-sm text-blue-600 hover:text-blue-800">
                            Открыть →
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>