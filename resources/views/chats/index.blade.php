@extends('componet.shablon')

@section('title', 'Мои чаты')

@section('content')

    @include('componet/content.header')

    @php
        $user = auth()->user();
        $activeChat = isset($chat) ? $chat : null;
    @endphp

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Левая панель — список чатов -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-900">Мои чаты</h3>
                        <a href="{{ route('orders.feed') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 text-sm">
                            Новый чат
                        </a>
                    </div>

                    <!-- Поиск по чатам -->
                    <div class="mb-4">
                        <input 
                            type="text" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Поиск по сообщениям..."
                        >
                    </div>

                    <!-- Список чатов -->
                    <div class="space-y-2 max-h-[500px] overflow-y-auto">
                        @forelse($chats as $chatItem)
                            @php
                                $otherUser = $chatItem->getOtherParticipant($user->id);
                                $unreadCount = $chatItem->unreadCount($user->id);
                                $lastMessage = $chatItem->messages->first();
                                $isActive = $activeChat && $activeChat->id === $chatItem->id;
                            @endphp
                            <a href="{{ route('chats.show', $chatItem) }}" 
                               class="block p-3 {{ $isActive ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50' }} rounded-lg cursor-pointer transition-colors">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 {{ $isActive ? 'bg-blue-500' : 'bg-gray-400' }} rounded-full mr-3 flex items-center justify-center text-white text-sm font-bold">
                                        {{ $otherUser ? substr($otherUser->name, 0, 2) : '??' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-semibold text-sm truncate {{ $isActive ? 'text-blue-900' : 'text-gray-900' }}">{{ $otherUser?->name ?? 'Участник' }}</h4>
                                            <span class="text-xs text-gray-500">{{ $chatItem->last_message_at?->diffForHumans() ?? '' }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600 truncate">
                                            {{ $lastMessage?->content ?? 'Нет сообщений' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    @if($unreadCount > 0)
                                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">{{ $chatItem->status === 'closed' ? 'Закрыт' : 'Прочитано' }}</span>
                                    @endif
                                    <span class="text-xs {{ $isActive ? 'text-blue-600' : 'text-gray-600' }} font-medium">Заказ: #{{ $chatItem->order_id }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fa fa-comments text-4xl mb-3 text-gray-300"></i>
                                <p class="text-sm">Нет чатов</p>
                                <p class="text-xs mt-1">Начните диалог из заказа</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Область чата -->
            <div class="lg:col-span-2">
                @if($activeChat)
                    @php
                        $otherUser = $activeChat->getOtherParticipant($user->id);
                        $order = $activeChat->order;
                    @endphp
                    <div class="bg-white rounded-lg shadow-md h-[600px] flex flex-col">
                        <!-- Заголовок чата -->
                        <div class="border-b p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                                        {{ $otherUser ? substr($otherUser->name, 0, 2) : '??' }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $otherUser?->name ?? 'Диалог' }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order?->title ?? 'Заказ' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 {{ $activeChat->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded text-xs">
                                        {{ $activeChat->status === 'active' ? 'Активен' : 'Закрыт' }}
                                    </span>
                                    @if($user->isManager() && $activeChat->status === 'active')
                                        <form action="{{ route('chats.close', $activeChat) }}" method="POST" class="inline" onsubmit="return confirm('Закрыть заказ?')">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Закрыть заказ">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Сообщения -->
                        <div class="flex-1 p-4 overflow-y-auto" id="messages-container">
                            <div class="space-y-4">
                                @forelse($activeChat->messages as $message)
                                    @if($message->type === 'system')
                                        <!-- Системное сообщение -->
                                        <div class="text-center">
                                            <span class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full">
                                                {{ $message->content }}
                                            </span>
                                        </div>
                                    @elseif($message->sender_id === $user->id)
                                        <!-- Мое сообщение -->
                                        <div class="flex items-start justify-end mb-4">
                                            <div class="max-w-[70%]">
                                                <div class="bg-blue-600 text-white rounded-lg p-3">
                                                    <p class="text-sm">{{ $message->content }}</p>
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1 block text-right">{{ $message->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Сообщение от собеседника -->
                                        <div class="flex items-start mb-4">
                                            <div class="w-8 h-8 bg-gray-400 rounded-full mr-3 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                {{ substr($message->sender->name, 0, 1) }}
                                            </div>
                                            <div class="max-w-[70%]">
                                                <div class="bg-gray-100 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</p>
                                                    <p class="text-sm text-gray-800">{{ $message->content }}</p>
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="flex items-center justify-center h-full">
                                        <div class="text-center text-gray-400">
                                            <i class="fa fa-comments text-5xl mb-4 text-gray-300"></i>
                                            <p>Начните диалог...</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Форма отправки сообщения -->
                        @if($activeChat->status === 'active')
                            <div class="border-t p-4">
                                <form action="{{ route('chats.message', $activeChat) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <button type="button" class="p-2 hover:bg-gray-100 rounded-lg text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <input 
                                        type="text" 
                                        name="content"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Введите сообщение..."
                                        required
                                    >
                                    <button type="button" class="p-2 hover:bg-gray-100 rounded-lg text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="border-t p-4 text-center">
                                <span class="text-gray-500 text-sm"><i class="fa fa-lock mr-2"></i>Чат закрыт</span>
                            </div>
                        @endif

                        <!-- AJAX polling -->
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
                                }, 3000);
                                @endif
                            });
                        </script>
                    </div>
                @else
                    <!-- Пустое состояние -->
                    <div class="bg-white rounded-lg shadow-md h-[600px] flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <div class="text-6xl mb-4">📭</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Выберите чат</h3>
                            <p class="text-gray-600 mb-6">Выберите диалог слева или начните новый</p>
                            <a href="{{ route('orders.feed') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                                Найти заказ
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection