@extends('componet.shablon')

@section('title', 'Мои заказы')

@use(App\Services\Functions)

@section('content')

    @include('componet/content.header')

    <div class="max-w-6xl mx-auto px-3 sm:px-4 py-5 sm:py-8">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Мои заказы</h2>

            <p class="text-sm sm:text-base text-gray-600 mb-5 sm:mb-6">Управление вашими активными и завершенными заказами.
            </p>

            <!-- Табы -->
            <div class="border-b border-gray-200 mb-5 sm:mb-6 overflow-x-auto">
                <nav class="-mb-px flex gap-6 sm:gap-8 min-w-max">
                    <a href="{{ route('orders.my', ['status' => 'active']) }}"
                        class="py-2 px-1 border-b-2 {{ request('status') !== 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} font-medium text-sm sm:text-base whitespace-nowrap">
                        Активные ({{ $activeCount }})
                    </a>
                    <a href="{{ route('orders.my', ['status' => 'completed']) }}"
                        class="py-2 px-1 border-b-2 {{ request('status') === 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} font-medium text-sm sm:text-base whitespace-nowrap">
                        Завершенные ({{ $completedCount }})
                    </a>
                </nav>
            </div>

            <!-- Список заказов -->
            <div class="space-y-4">
                @forelse($orders as $order)
                    <div class="border rounded-lg p-4 sm:p-6 {{ $order->status === 'completed' ? 'bg-gray-50 border-gray-300' : '' }}">
                        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-4">
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold mb-2 leading-snug">
                                    <a href="{{ route('orders.detail', $order->id) }}" class="text-blue-600 hover:text-blue-800 {{ $order->status === 'completed' ? 'text-gray-500' : '' }}">
                                        {{ $order->title }}
                                    </a>
                                    @if($order->status === 'completed')
                                        <span class="ml-2 text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">ЗАВЕРШЁН</span>
                                    @endif
                                </h3>
                                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ Functions::getCategoryName($order->category) }}</span>
                                    <span>📅 Создан: {{ $order->created_at->format('d.m.Y') }}</span>
                                    <span>⏰ Дедлайн: {{ $order->completion_date?->format('d.m.Y') ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="text-left lg:text-right">
                                <div class="text-xl sm:text-2xl font-bold {{ $order->status === 'completed' ? 'text-gray-500' : 'text-blue-600' }} mb-2">{{ Functions::formatBudget($order->budget) }}</div>
                                <span class="inline-block px-2 py-1 rounded text-xs sm:text-sm {{ $order->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $order->status === 'active' ? 'Активный' : 'Завершён' }}
                                </span>
                            </div>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600 mb-4 leading-6">
                            {{ Str::limit($order->description, 150) }}
                        </p>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                                <div class="text-sm text-gray-600">
                                    @php
                                        $responses = \App\Models\Chat::where('order_id', $order->id)->count();
                                    @endphp
                                    <span class="font-medium">Откликов:</span> {{ $responses }}
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row w-full sm:w-auto gap-2">
                                @if($order->status === 'active')
                                    <a href="{{ route('orders.detail', $order->id) }}"
                                        class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm sm:text-base text-center">
                                        Просмотреть отклики
                                    </a>
                                    <a href="{{ route('orders.edit', $order->id) }}"
                                        class="w-full sm:w-auto bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm sm:text-base text-center">
                                        <i class="fa fa-edit mr-1"></i>Редактировать
                                    </a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Закрыть заказ? Заказ будет помечен как выполненный.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm sm:text-base text-center">
                                            <i class="fa fa-times mr-1"></i>Закрыть
                                        </button>
                                    </form>
                                @else
                                    <span class="w-full sm:w-auto bg-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm sm:text-base text-center">
                                        <i class="fa fa-lock mr-2"></i>Заказ закрыт
                                    </span>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Удалить заказ полностью? Это действие нельзя отменить.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full sm:w-auto bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm sm:text-base text-center">
                                            <i class="fa fa-trash mr-1"></i>Удалить
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <i class="fa fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p>У вас пока нет заказов</p>
                        <a href="{{ route('orders.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Создать заказ
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Статистика -->
            <div class="mt-8 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Статистика заказов</h3>
                @php
                    $inProgress = $orders->where('status', 'active')->filter(function($o) {
                        return \App\Models\Chat::where('order_id', $o->id)->exists();
                    })->count();
                    $totalSpent = $orders->where('status', 'completed')->sum('budget');
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $activeCount }}</div>
                        <div class="text-gray-600">Активных</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $inProgress }}</div>
                        <div class="text-gray-600">В работе</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $completedCount }}</div>
                        <div class="text-gray-600">Завершено</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ Functions::formatBudget($totalSpent) }}</div>
                        <div class="text-gray-600">Потрачено</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection