@extends('componet.shablon')

@section('title', 'Уведомления')

@section('content')

    @include('componet/content.header')

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fa fa-bell mr-2"></i>Уведомления
                </h2>
                @if(auth()->user()->unreadNotifications()->count() > 0)
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="fa fa-check-double mr-1"></i>Отметить все прочитанными
                        </button>
                    </form>
                @endif
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-3">
                @forelse($notifications as $notification)
                    <div class="flex items-start gap-4 p-4 rounded-lg {{ $notification->isRead() ? 'bg-gray-50' : 'bg-blue-50 border border-blue-200' }}">
                        <div class="w-10 h-10 rounded-full {{ $notification->is_important ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-{{ $notification->type === 'order_created' ? 'shopping-cart' : ($notification->type === 'chat_message' ? 'comment' : ($notification->type === 'order_closed' ? 'check-circle' : 'info')) }}"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold {{ $notification->isRead() ? 'text-gray-700' : 'text-gray-900' }}">
                                        {{ $notification->title }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-2">
                                    @if(!$notification->isRead())
                                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800" title="Отметить прочитанным">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Удалить уведомление?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Удалить">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-800">
                                    Перейти →
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa fa-bell-slash text-5xl mb-4"></i>
                        <p class="text-lg">Нет уведомлений</p>
                        <p class="text-sm mt-2">Здесь будут появляться уведомления о ваших заказах и чатах</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

        <!-- Настройки уведомлений -->
        <div class="bg-gray-50 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold mb-4">
                <i class="fa fa-cog mr-2"></i>Настройки уведомлений
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                Управляйте типами уведомлений, которые вы хотите получать.
            </p>
            <div class="space-y-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" checked disabled class="rounded text-blue-600">
                    <span class="text-sm">Уведомления о создании заказа (всегда включено)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" checked class="rounded text-blue-600">
                    <span class="text-sm">Новые сообщения в чатах</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" checked class="rounded text-blue-600">
                    <span class="text-sm">Изменения статуса заказа</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded text-blue-600">
                    <span class="text-sm">Email-уведомления</span>
                </label>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                * Настройки сохраняются автоматически (в разработке)
            </p>
        </div>
    </div>
@endsection
