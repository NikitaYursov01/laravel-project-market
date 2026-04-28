@extends('componet.shablon')

@section('title', 'Мои заказы')
@section('description', 'Управление вашими заказами на DetailDeal')

@section('content')
    @include('componet/content.header')
    @use(App\Services\Functions)

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Мои заказы</h1>
                    <p class="text-gray-500 mt-1">Управляйте вашими активными и завершенными заказами</p>
                </div>
                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                    <i class="fa fa-plus"></i>
                    Создать заказ
                </a>
            </div>

            <!-- Stats -->
            @php
                $inProgress = $orders->where('status', 'active')->filter(function ($o) {
                    return \App\Models\Chat::where('order_id', $o->id)->exists();
                })->count();
                $totalSpent = $orders->where('status', 'completed')->sum('budget');
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="text-3xl font-bold text-blue-600">{{ $activeCount }}</div>
                    <div class="text-sm text-gray-500 mt-1">Активных</div>
                </div>
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="text-3xl font-bold text-yellow-600">{{ $inProgress }}</div>
                    <div class="text-sm text-gray-500 mt-1">В работе</div>
                </div>
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="text-3xl font-bold text-green-600">{{ $completedCount }}</div>
                    <div class="text-sm text-gray-500 mt-1">Завершено</div>
                </div>
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="text-3xl font-bold text-gray-900">{{ Functions::formatBudget($totalSpent) }}</div>
                    <div class="text-sm text-gray-500 mt-1">Потрачено</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex gap-1 p-2">
                        <a href="{{ route('orders.my', ['status' => 'active']) }}"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-lg text-sm font-medium text-center transition-colors {{ request('status') !== 'completed' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                            Активные ({{ $activeCount }})
                        </a>
                        <a href="{{ route('orders.my', ['status' => 'completed']) }}"
                            class="flex-1 sm:flex-none px-6 py-3 rounded-lg text-sm font-medium text-center transition-colors {{ request('status') === 'completed' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                            Завершенные ({{ $completedCount }})
                        </a>
                    </nav>
                </div>

                <!-- Orders List -->
                <div class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        @php
                            $responses = \App\Models\Chat::where('order_id', $order->id)->count();
                            $isService = $order->type === 'performer_service';
                        @endphp
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col lg:flex-row gap-5">
                                <!-- Image -->
                                <div class="w-full lg:w-44 h-36 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                    @if($order->images && $order->images->count() > 0)
                                        <img src="{{ $order->images->first()->getUrl() }}" alt="" class="w-full h-full object-cover"
                                            loading="lazy" decoding="async" width="200" height="150">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                            <i class="fa {{ $isService ? 'fa-fire' : 'fa-cube' }} text-4xl text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">
                                                {{ Functions::getCategoryName($order->category) }}
                                            </span>
                                            <span class="px-2.5 py-1 {{ $order->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded-md text-xs font-medium">
                                                {{ $order->status === 'active' ? 'Активный' : 'Завершён' }}
                                            </span>
                                            <span class="px-2.5 py-1 {{ $isService ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }} rounded-md text-xs font-medium">
                                                {{ $isService ? 'Услуга' : 'Заказ' }}
                                            </span>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ Functions::formatBudget($order->budget) }}
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('orders.detail', $order->id) }}" class="hover:text-blue-700 transition-colors">
                                            {{ $order->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                        {{ Str::limit($order->description, 120) }}
                                    </p>

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa fa-calendar text-gray-400"></i>
                                            Создан {{ $order->created_at->format('d.m.Y') }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa fa-clock text-gray-400"></i>
                                            Дедлайн {{ $order->completion_date?->format('d.m.Y') ?? '—' }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa fa-comments text-gray-400"></i>
                                            {{ $responses }} {{ trans_choice('отклик|отклика|откликов', $responses) }}
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('orders.detail', $order->id) }}"
                                            class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                            Просмотреть
                                        </a>

                                        @if($order->status === 'active')
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                                                <i class="fa fa-edit mr-1"></i>Редактировать
                                            </a>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Закрыть заказ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">
                                                    <i class="fa fa-times mr-1"></i>Закрыть
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Удалить заказ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors">
                                                    <i class="fa fa-trash mr-1"></i>Удалить
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa fa-shopping-bag text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">У вас пока нет заказов</h3>
                            <p class="text-gray-500 mb-6">Создайте свой первый заказ и найдите исполнителей</p>
                            <a href="{{ route('orders.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                <i class="fa fa-plus"></i>
                                Создать заказ
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($orders->count() > 0)
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
