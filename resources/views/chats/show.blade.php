@extends('componet.shablon')

@section('title', 'Чат — ' . ($chat->getOtherParticipant(auth()->id())?->name ?? 'Диалог'))

@section('content')
    @php
        $user = auth()->user();
        $otherUser = $chat->getOtherParticipant($user->id);
    @endphp

    <div class="max-w-4xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="bg-white rounded-t-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('chats.index') }}" class="text-gray-500 hover:text-gray-700">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ $otherUser ? substr($otherUser->name, 0, 2) : '??' }}
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">{{ $otherUser?->name ?? 'Диалог' }}</h2>
                        <p class="text-xs text-gray-500">{{ $chat->order->title ?? 'Заказ не найден' }}</p>
                    </div>
                </div>
                <span
                    class="px-2 py-1 {{ $chat->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded text-xs">
                    {{ $chat->status === 'active' ? 'Активен' : 'Закрыт' }}
                </span>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-gray-50 border-x border-gray-200 p-4 h-[400px] overflow-y-auto" id="messages-container">
            @forelse($chat->messages as $message)
                @if($message->type === 'system')
                    <div class="flex justify-center my-3">
                        <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs">
                            {{ $message->content }}
                        </span>
                    </div>
                @elseif($message->sender_id === $user->id)
                    <div class="flex justify-end mb-3">
                        <div class="max-w-[70%] bg-blue-600 text-white rounded-2xl rounded-tr-sm px-4 py-2">
                            <p>{{ $message->content }}</p>
                            <span class="text-xs text-blue-200 block mt-1 text-right">
                                {{ $message->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start mb-3">
                        <div class="max-w-[70%] bg-white border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-2">
                            <p class="text-sm text-gray-600 mb-1">{{ $message->sender->name }}</p>
                            <p class="text-gray-900">{{ $message->content }}</p>
                            <span class="text-xs text-gray-400 block mt-1">
                                {{ $message->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p>Начните диалог...</p>
                </div>
            @endforelse
        </div>

        <!-- Input -->
        @if($chat->status === 'active')
            <div class="bg-white rounded-b-xl shadow-sm border border-t-0 border-gray-200 p-4">
                <form action="{{ route('chats.message', $chat) }}" method="POST" class="flex gap-2" id="message-form">
                    @csrf
                    <input type="text" name="content" id="message-input" placeholder="Введите сообщение..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        @endif

        <!-- Order Info -->
        <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="font-semibold text-gray-900 mb-2">Информация о заказе</h3>
            <p class="text-sm text-gray-600">{{ $chat->order->title ?? '—' }}</p>
            <a href="{{ route('orders.detail', $chat->order_id) }}"
                class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm">
                Перейти к заказу <i class="fa fa-external-link"></i>
            </a>
        </div>
    </div>

    <script>
        // Прокрутка вниз при загрузке
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;

            // Фокус на поле ввода
            document.getElementById('message-input')?.focus();

            // AJAX polling - обновление каждые 3 секунды
            const chatId = {{ $chat->id }};
            let lastMessageCount = {{ $chat->messages->count() }};

            setInterval(function () {
                fetch(`/chats/${chatId}/poll`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.message_count > lastMessageCount) {
                            // Есть новые сообщения - перезагружаем страницу
                            window.location.reload();
                        }
                    })
                    .catch(err => console.log('Poll error:', err));
            }, 3000);
        });
    </script>
@endsection