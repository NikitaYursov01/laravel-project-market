@extends('componet.shablon')

@section('title', 'Мои чаты')

@section('content')

    @include('componet/content.header')

    @php
        $user = auth()->user();
        $activeChat = isset($chat) ? $chat : null;
    @endphp

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Мои чаты</h1>
                    <p class="text-gray-500">Общайтесь с заказчиками и исполнителями</p>
                </div>
                <a href="{{ route('orders.feed') }}"
                    class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                    <i class="fa fa-search mr-1"></i>Найти заказ
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:h-[calc(100vh-280px)]">

                <!-- Chat List -->
                <div
                    class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <!-- Search -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="relative">
                            <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text"
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"
                                placeholder="Поиск по чатам...">
                        </div>
                    </div>

                    <!-- Chats -->
                    <div class="flex-1 overflow-y-auto">
                        @forelse($chats as $chatItem)
                            @php
                                $otherUser = $chatItem->getOtherParticipant($user->id);
                                $unreadCount = $chatItem->unreadCount($user->id);
                                $lastMessage = $chatItem->messages->first();
                                $isActive = $activeChat && $activeChat->id === $chatItem->id;
                            @endphp
                            <a href="{{ route('chats.show', $chatItem) }}"
                                class="block p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors {{ $isActive ? 'bg-primary-50 border-l-4 border-l-primary-500' : '' }}">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar -->
                                    <div class="relative">
                                        <div
                                            class="w-12 h-12 {{ $isActive ? 'bg-primary-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $otherUser ? substr($otherUser->name, 0, 2) : '??' }}
                                        </div>
                                        @if($unreadCount > 0)
                                            <span
                                                class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-[10px] text-white flex items-center justify-center font-bold">
                                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-0.5">
                                            <h4 class="font-semibold text-sm text-gray-900 truncate">
                                                {{ $otherUser?->name ?? 'Участник' }}
                                            </h4>
                                            <span
                                                class="text-xs text-gray-400">{{ $chatItem->last_message_at?->diffForHumans() ?? '' }}</span>
                                        </div>
                                        <p
                                            class="text-sm text-gray-500 truncate {{ $unreadCount > 0 ? 'font-medium text-gray-700' : '' }}">
                                            {{ $lastMessage?->content ?? 'Нет сообщений' }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="text-xs text-gray-400">Заказ #{{ $chatItem->order_id }}</span>
                                            <span
                                                class="text-xs px-2 py-0.5 {{ $chatItem->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded-full">
                                                {{ $chatItem->status === 'active' ? 'Активен' : 'Закрыт' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa fa-comments text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Нет чатов</h3>
                                <p class="text-sm text-gray-500 mb-4">Начните диалог из карточки заказа</p>
                                <a href="{{ route('orders.feed') }}"
                                    class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                                    Найти заказ
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area -->
                <div
                    class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    @if($activeChat)
                        @php
                            $order = $activeChat->order;
                        @endphp

                        @php
                            $client = $activeChat->getClient();
                            $performer = $activeChat->getPerformer();
                            $manager = $activeChat->manager;
                            $activeParticipant = session('chat_' . $activeChat->id . '_participant', 'client');
                            $orderCreator = $order->user;

                            // Политика безопасности: заказчик/исполнитель общаются через менеджера
                            $otherUser = ($user->isManager() || $user->isAdmin())
                                ? $activeChat->getOtherParticipant($user->id)
                                : $manager;
                        @endphp

                        <!-- Chat Header -->
                        <div class="p-4 border-b border-gray-100">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    @if($user->isManager() || $user->isAdmin())
                                        {{-- Для менеджера - показываем обоих участников --}}
                                        <div class="flex -space-x-2 mr-2">
                                            <div
                                                class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm border-2 border-white">
                                                {{ $client ? substr($client->name, 0, 2) : '??' }}
                                            </div>
                                            <div
                                                class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm border-2 border-white">
                                                {{ $performer ? substr($performer->name, 0, 2) : '??' }}
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">
                                                Заказ #{{ $activeChat->order_id }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $client?->name ?? 'Клиент' }} ↔ {{ $performer?->name ?? 'Исполнитель' }}
                                            </p>
                                        </div>
                                    @else
                                        {{-- Обычный пользователь --}}
                                        <div
                                            class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $otherUser ? substr($otherUser->name, 0, 2) : '??' }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $otherUser?->name ?? 'Диалог' }}</h3>
                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                class="text-sm text-primary-600 hover:text-primary-700">
                                                {{ Str::limit($order?->title ?? 'Заказ', 40) }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    {{-- Менеджер чата --}}
                                    @if($manager)
                                        <span
                                            class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium flex items-center gap-1">
                                            <i class="fa fa-user-tie"></i>
                                            {{ $manager->name }}
                                        </span>
                                    @endif
                                    <span
                                        class="px-3 py-1 {{ $activeChat->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded-full text-xs font-medium">
                                        {{ $activeChat->status === 'active' ? 'Активен' : 'Закрыт' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Информация о заказе для менеджера --}}
                            @if($user->isManager() || $user->isAdmin())
                                <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                class="font-medium text-gray-900 hover:text-blue-600 text-sm block mb-1">
                                                {{ $order->title }}
                                            </a>
                                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                                <span
                                                    class="px-2 py-0.5 bg-white rounded border">{{ \App\Services\Functions::getCategoryName($order->category) }}</span>
                                                <span
                                                    class="font-semibold text-gray-700">{{ \App\Services\Functions::formatBudget($order->budget) }}</span>
                                                <span>Создатель: <span class="font-medium">{{ $orderCreator->name }}</span></span>
                                                <span>Дедлайн: {{ $order->completion_date?->format('d.m.Y') ?? 'Не указан' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Кнопки управления для менеджера --}}
                            @if(($user->isManager() || $user->isAdmin()) && $activeChat->status === 'active')
                                <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100 flex-wrap">
                                    {{-- Переключатель режима общения --}}
                                    <span class="text-xs text-gray-500 mr-2">Режим общения:</span>
                                    <form action="{{ route('chats.switch-participant', $activeChat) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <input type="hidden" name="participant" value="client">
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1.5
                                                                                    {{ $activeParticipant === 'client' ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                            <div
                                                class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center text-white text-[8px] font-bold">
                                                {{ $client ? substr($client->name, 0, 1) : 'C' }}
                                            </div>
                                            {{ $client?->name ?? 'Заказчик' }}
                                            @if($activeParticipant === 'client')
                                                <i class="fa fa-check ml-1"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('chats.switch-participant', $activeChat) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <input type="hidden" name="participant" value="performer">
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1.5
                                                                                    {{ $activeParticipant === 'performer' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                            <div
                                                class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-white text-[8px] font-bold">
                                                {{ $performer ? substr($performer->name, 0, 1) : 'I' }}
                                            </div>
                                            {{ $performer?->name ?? 'Исполнитель' }}
                                            @if($activeParticipant === 'performer')
                                                <i class="fa fa-check ml-1"></i>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Разделитель --}}
                                    <span class="w-px h-4 bg-gray-300 mx-2"></span>

                                    {{-- Кнопка отклонения исполнителя (только менеджер этого чата) --}}
                                    @if($user->isManager() && $activeChat->manager_id === $user->id)
                                        <form action="{{ route('chats.reject-performer', $activeChat) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Отклонить исполнителя? Заказ вернется в ленту.')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-lg text-xs font-medium hover:bg-orange-200 transition-colors flex items-center gap-1">
                                                <i class="fa fa-user-times"></i>
                                                Отклонить исполнителя
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Кнопка закрытия заказа --}}
                                    <form action="{{ route('chats.close', $activeChat) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Закрыть заказ?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-medium hover:bg-red-200 transition-colors flex items-center gap-1">
                                            <i class="fa fa-lock"></i>
                                            Закрыть заказ
                                        </button>
                                    </form>

                                    {{-- Кнопка возобновления (только админ) --}}
                                    @if($user->isAdmin())
                                        <form action="{{ route('chats.reopen-order', $activeChat) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Возобновить заказ? Текущий чат будет закрыт, заказ станет доступен.')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-lg text-xs font-medium hover:bg-purple-200 transition-colors flex items-center gap-1">
                                                <i class="fa fa-refresh"></i>
                                                Возобновить заказ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Messages -->
                        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                            @forelse($activeChat->messages as $message)
                                @if($message->type === 'system')
                                    <!-- System Message -->
                                    <div class="flex justify-center">
                                        <span class="bg-gray-100 text-gray-500 text-xs px-4 py-2 rounded-full">
                                            {{ $message->content }}
                                        </span>
                                    </div>
                                @elseif($message->sender_id === $user->id)
                                    <!-- My Message -->
                                    <div class="flex items-end justify-end">
                                        <div
                                            class="max-w-[70%] bg-primary-600 text-white rounded-2xl rounded-br-md px-4 py-3 shadow-sm">
                                            <p class="text-sm">{{ $message->content }}</p>
                                        </div>
                                        <span class="text-xs text-gray-400 ml-2 mb-1">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                @else
                                    <!-- Other Message -->
                                    <div class="flex items-end">
                                        <div
                                            class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2 shrink-0">
                                            {{ substr($message->sender->name, 0, 1) }}
                                        </div>
                                        <div class="max-w-[70%]">
                                            <div class="bg-gray-100 rounded-2xl rounded-bl-md px-4 py-3 shadow-sm">
                                                <p class="text-xs text-gray-500 mb-1">
                                                    {{ $message->sender->name }}
                                                    @if($user->isManager() || $user->isAdmin())
                                                        @if($message->sender_id === $activeChat->client_id)
                                                            <span class="text-blue-600">(Клиент)</span>
                                                        @elseif($message->sender_id === $activeChat->performer_id)
                                                            <span class="text-green-600">(Исполнитель)</span>
                                                        @endif
                                                    @endif
                                                </p>
                                                <p class="text-sm text-gray-800">{{ $message->content }}</p>
                                            </div>
                                            <span class="text-xs text-gray-400 ml-1">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa fa-comments text-2xl text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-500">Начните диалог...</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Message Input -->
                        @if($activeChat->status === 'active')
                            <div class="p-4 border-t border-gray-100">
                                <form action="{{ route('chats.message', $activeChat) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @if($user->isManager() || $user->isAdmin())
                                        <input type="hidden" name="participant"
                                            value="{{ session('chat_' . $activeChat->id . '_participant', 'client') }}">
                                    @endif
                                    <button type="button"
                                        class="p-2.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                                        <i class="fa fa-paperclip"></i>
                                    </button>
                                    <input type="text" name="content"
                                        class="flex-1 px-4 py-3 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-primary-500"
                                        placeholder="Введите сообщение..." required autocomplete="off">
                                    <button type="submit"
                                        class="p-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="p-4 border-t border-gray-100 text-center">
                                <span class="text-gray-500 text-sm"><i class="fa fa-lock mr-2"></i>Чат закрыт</span>
                            </div>
                        @endif

                        <!-- Auto Scroll & Polling -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const container = document.getElementById('messages-container');
                                if (container) {
                                    container.scrollTop = container.scrollHeight;
                                }

                                @if($activeChat)
                                    setInterval(function () {
                                        fetch('{{ route("chats.poll", $activeChat) }}')
                                            .then(r => r.json())
                                            .then(data => {
                                                if (data.message_count > {{ $activeChat->messages->count() }}) {
                                                    window.location.reload();
                                                }
                                            });
                                    }, 5000);
                                @endif
                                                            });
                        </script>
                    @else
                        <!-- Empty State -->
                        <div class="flex-1 flex items-center justify-center">
                            <div class="text-center p-8">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fa fa-comments text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Выберите чат</h3>
                                <p class="text-gray-500 mb-6">Выберите диалог слева или начните новый</p>
                                <a href="{{ route('orders.feed') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-colors">
                                    <i class="fa fa-search"></i>
                                    Найти заказ
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection