@extends('componet.shablon')

@section('title', $feedTitle ?? 'Объявления')

@section('content')

    @include('componet/content.header')
    @use(App\Services\Functions)

    @php
        $user = auth()->user();
        $feedTitle = 'Маркетплейс металлопроката';
        $feedDescription = 'Найдите поставщика металла или заказ на металлообработку';

        if ($user) {
            if ($user->isPerformer()) {
                $feedTitle = 'Заказы на металлопрокат';
                $feedDescription = 'Найдите заказы на поставку металла и услуги обработки';
            } elseif ($user->isClient()) {
                $feedTitle = 'Поставщики и исполнители';
                $feedDescription = 'Найдите поставщика металлопроката или услуги обработки';
            } elseif ($user->isManager()) {
                $feedTitle = 'Все объявления металлоторговли';
                $feedDescription = 'Просмотр всех заказов и предложений металлопроката';
            }
        }
    @endphp

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $feedTitle }}</h1>
                        <p class="text-gray-500 mt-1">{{ $feedDescription }}</p>
                    </div>
                    
                    @auth
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            @php $currentQuery = request()->except('type', 'page'); @endphp
                            <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'client_order'])) }}"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewType === 'client_order' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Заказы
                            </a>
                            <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'performer_service'])) }}"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewType === 'performer_service' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Услуги
                            </a>
                            @if(auth()->user()->isManager())
                                <a href="{{ route('orders.feed', array_merge($currentQuery, ['type' => 'all'])) }}"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $viewType === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                    Все
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Search & Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('orders.feed') }}" class="flex flex-col sm:flex-row gap-3">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <div class="flex-1 relative">
                        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}" 
                            placeholder="Поиск: лист стальной, труба ВГП, резка плазмой..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition-colors">
                            Найти
                        </button>
                        @if(request('q') || request('category'))
                            <a href="{{ route('orders.feed', request()->only('type')) }}"
                                class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fa fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Categories -->
                @isset($categories)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('orders.feed') }}"
                                class="px-4 py-2 {{ !request('category') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition-colors">
                                Все
                            </a>
                            @foreach($categories as $cat)
                                @if($cat['count'] > 0)
                                    <a href="{{ route('orders.feed') }}?category={{ $cat['slug'] }}"
                                        class="px-4 py-2 {{ request('category') === $cat['slug'] ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium transition-colors">
                                        {{ $cat['name'] }}
                                        <span class="ml-1 opacity-70">({{ $cat['count'] }})</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endisset
            </div>

            <!-- Stats -->
            @isset($stats)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Всего объявлений</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['active'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Активных</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Выполнено</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="text-2xl font-bold text-orange-600">{{ $stats['today'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Сегодня новых</div>
                    </div>
                </div>
            @endisset

            <!-- Results Count -->
            <div class="mb-4">
                <p class="text-gray-600">
                    Найдено: <span class="font-semibold text-gray-900">{{ $orders->total() }}</span> 
                    {{ trans_choice('объявление|объявления|объявлений', $orders->total()) }}
                </p>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        @php
                            $responses = \App\Models\Chat::where('order_id', $order->id)->count();
                            $isService = $order->type === 'performer_service';
                        @endphp
                        <a href="{{ route('orders.detail', $order->id) }}" class="group flex gap-5 p-5 bg-white border border-gray-200 hover:border-gray-400 transition-all hover:shadow-lg rounded-xl">
                            <!-- Image -->
                            <div class="w-40 h-40 shrink-0 bg-gray-100 relative overflow-hidden rounded-lg">
                                @if($order->images && $order->images->count() > 0)
                                    <img src="{{ $order->images->first()->getUrl() }}" alt="" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy" decoding="async" width="160" height="160">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                        <i class="fa {{ $isService ? 'fa-fire' : 'fa-cube' }} text-4xl text-gray-300"></i>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 py-1.5 {{ $isService ? 'bg-orange-500' : 'bg-blue-600' }} text-white text-center text-xs font-medium">
                                    {{ $isService ? 'Услуга' : 'Металл' }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">{{ Functions::getCategoryName($order->category) }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-xs {{ $order->status === 'active' ? 'text-green-600' : 'text-gray-400' }} font-medium">
                                            {{ $order->status === 'active' ? 'Ищет исполнителя' : 'Завершено' }}
                                        </span>
                                    </div>
                                    <span class="text-xl font-bold text-gray-900 whitespace-nowrap">{{ Functions::formatBudget($order->budget) }}</span>
                                </div>
                                
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">{{ $order->title }}</h3>
                                <p class="text-gray-600 mb-3 line-clamp-2">{{ Str::limit($order->description, 120) }}</p>
                                
                                <!-- Meta -->
                                <div class="flex items-center gap-4 text-sm text-gray-400">
                                    <span class="flex items-center gap-1"><i class="fa fa-user-o"></i> {{ Str::limit($order->user->name, 20) }}</span>
                                    <span class="flex items-center gap-1"><i class="fa fa-clock-o"></i> {{ $order->created_at->diffForHumans() }}</span>
                                    <span class="flex items-center gap-1"><i class="fa fa-comment-o"></i> {{ $responses }} {{ trans_choice('отклик|отклика|откликов', $responses) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Объявлений не найдено</h3>
                    <p class="text-gray-500 mb-4">Попробуйте изменить параметры поиска</p>
                    <a href="{{ route('orders.feed') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fa fa-refresh"></i> Сбросить фильтры
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
