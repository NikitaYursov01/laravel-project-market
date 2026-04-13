@extends('componet.shablon')

@section('title', 'Лента заказов')

@section('content')

    @include('componet/content.header')

    @use(App\Services\Functions)

    @php
        $user = auth()->user();
        $feedTitle = 'Лента заказов';
        $feedDescription = 'Доступные заказы и объявления';

        if ($user) {
            if ($user->isPerformer()) {
                $feedTitle = 'Заказы от заказчиков';
                $feedDescription = 'Найдите подходящий заказ и предложите свои услуги';
            } elseif ($user->isClient()) {
                $feedTitle = 'Услуги исполнителей';
                $feedDescription = 'Найдите исполнителя для вашего проекта';
            } elseif ($user->isManager()) {
                $feedTitle = 'Все объявления';
                $feedDescription = 'Просмотр всех заказов и услуг';
            }
        }
    @endphp

    <div class="max-w-6xl mx-auto px-3 sm:px-4 py-5 sm:py-8">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">{{ $feedTitle }}</h2>
                    <p class="text-gray-600 text-sm">{{ $feedDescription }}</p>
                </div>

                @auth
                    <!-- Переключатель типов объявлений -->
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        @php
                            $currentQuery = request()->except('type', 'page');
                        @endphp
                        <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'client_request'])) }}"
                            class="px-3 py-1.5 rounded-md text-sm font-medium transition-all {{ $viewType === 'client_request' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <i class="fa fa-shopping-cart mr-1"></i>Заказы
                        </a>
                        <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'performer_service'])) }}"
                            class="px-3 py-1.5 rounded-md text-sm font-medium transition-all {{ $viewType === 'performer_service' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <i class="fa fa-wrench mr-1"></i>Услуги
                        </a>
                        @if(auth()->user()->isManager())
                            <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'all'])) }}"
                                class="px-3 py-1.5 rounded-md text-sm font-medium transition-all {{ $viewType === 'all' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                <i class="fa fa-list mr-1"></i>Все
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Поиск -->
            <form method="GET" action="{{ route('orders.feed') }}" class="mb-6">
                <div class="flex gap-2">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск по заказам..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fa fa-search"></i>
                    </button>
                    @if(request('q') || request('category'))
                        <a href="{{ route('orders.feed', request()->only('type')) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Статистика -->
            @isset($stats)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Всего заказов</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['active'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Активных</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['completed'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Выполнено</div>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ $stats['today'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Сегодня</div>
                    </div>
                </div>
            @endisset

            <!-- Категории -->
            @isset($categories)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Категории:</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('orders.feed') }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded-full text-sm hover:bg-blue-700">
                            Все
                        </a>
                        @foreach($categories as $cat)
                            @if($cat['count'] > 0)
                                <a href="{{ route('orders.feed') }}?category={{ $cat['slug'] }}"
                                    class="px-3 py-1 {{ Functions::getCategoryColor($cat['slug']) }} rounded-full text-sm hover:opacity-80">
                                    {{ $cat['name'] }} ({{ $cat['count'] }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endisset

            <p class="text-sm sm:text-base text-gray-600 mb-5 sm:mb-6">
                @if($viewType === 'client_request')
                    Найдено заказов от заказчиков: {{ $orders->total() }}
                @elseif($viewType === 'performer_service')
                    Найдено услуг исполнителей: {{ $orders->total() }}
                @else
                    Доступные объявления. Всего: {{ $orders->total() }}
                @endif
            </p>

            @if($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($orders as $order)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-300 transition-all group flex flex-col">
                            <div class="flex justify-between items-start gap-2 p-4 pb-2">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        class="px-2 py-1 rounded-md text-xs font-medium {{ Functions::getCategoryColor($order->category) }}">
                                        {{ Functions::getCategoryName($order->category) }}
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-md text-xs font-medium border {{ Functions::getOrderTypeColor($order->type) }}">
                                        {{ Functions::getOrderTypeLabel($order->type) }}
                                    </span>
                                </div>
                                <span
                                    class="px-2 py-1 rounded-full text-xs {{ $order->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $order->status === 'active' ? 'Активно' : 'Завершено' }}
                                </span>
                            </div>
                            <div class="px-4 pb-2">
                                <h3
                                    class="text-base font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <a href="{{ route('orders.detail', $order->id) }}">{{ $order->title }}</a>
                                </h3>
                            </div>
                            <div class="px-4 pb-3">
                                <div class="text-xl font-bold text-blue-600">{{ Functions::formatBudget($order->budget) }}</div>
                            </div>
                            <div class="px-4 pb-3 flex flex-wrap gap-2">
                                @if($order->location)
                                    <span class="flex items-center gap-1 text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        <i class="fa fa-map-marker"></i>{{ $order->location }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1 text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    <i class="fa fa-calendar"></i>до {{ Functions::formatDate($order->completion_date) }}
                                </span>
                            </div>
                            <div class="px-4 pb-4 flex-1">
                                <p class="text-gray-600 text-sm line-clamp-3">{{ Str::limit($order->description, 120) }}</p>
                            </div>
                            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 {{ Functions::getAvatarColor($order->user->name) }} rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ Functions::getInitials($order->user->name) }}
                                    </div>
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900 truncate max-w-[100px]">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 pt-2">
                                <a href="{{ route('orders.detail', $order->id) }}"
                                    class="block w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg text-center transition-colors">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">
                        @if($viewType === 'performer_service')
                            🔍
                        @else
                            📭
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        @if($viewType === 'client_request')
                            Пока нет заказов от заказчиков
                        @elseif($viewType === 'performer_service')
                            Пока нет услуг исполнителей
                        @else
                            Пока нет объявлений
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-6">
                        @if($viewType === 'client_request')
                            Загляните позже или переключитесь на просмотр услуг исполнителей
                        @elseif($viewType === 'performer_service')
                            Будьте первым, кто найдёт исполнителя. Создайте свой заказ!
                        @else
                            Станьте первым, кто разместит заказ
                        @endif
                    </p>
                    <a href="{{ route('orders.create') }}"
                        class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        @if($viewType === 'performer_service')
                            Создать заказ
                        @elseif($user && $user->isPerformer())
                            Разместить услугу
                        @else
                            Создать заказ
                        @endif
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection