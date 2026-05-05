@extends('componet.shablon')

@section('title', $order->title)
@section('description', Str::limit($order->description, 150))

@section('content')

    @include('componet/content.header')
    @use(App\Services\Functions)

    @php
        $user = auth()->user();
        $canRespond = false;
        $respondError = '';
        $existingChat = null;

        if ($user) {
            if ($order->user_id === $user->id) {
                $respondError = 'Это ваш заказ';
            } elseif ($user->isManager()) {
                $canRespond = true;
            } elseif ($user->isPerformer() && $order->type === 'client_order') {
                $canRespond = true;
            } elseif ($user->isClient() && $order->type === 'performer_service') {
                $canRespond = true;
            } elseif ($user->isPerformer()) {
                $respondError = 'Исполнитель может откликаться только на заказы заказчиков';
            } elseif ($user->isClient()) {
                $respondError = 'Заказчик может откликаться только на объявления исполнителей';
            }

            $existingChat = \App\Models\Chat::where('order_id', $order->id)
                ->where(function ($q) use ($user) {
                    $q->where('performer_id', $user->id)
                        ->orWhere('client_id', $user->id);
                })
                ->first();
        }
    @endphp

    <div class="min-h-screen bg-gray-50 pb-20">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('main') }}" class="hover:text-gray-900">Главная</a>
                    <i class="fa fa-chevron-right text-xs"></i>
                    <a href="{{ route('orders.feed') }}" class="hover:text-gray-900">Объявления</a>
                    <i class="fa fa-chevron-right text-xs"></i>
                    <span class="text-gray-900 truncate max-w-[200px]">{{ $order->title }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Gallery -->
                    @if($order->images && $order->images->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                <!-- Main Image -->
                                <div class="aspect-square md:aspect-auto md:row-span-2 relative bg-gray-100">
                                    <img src="{{ $order->images->first()->getUrl() }}"
                                        alt="{{ $order->title }}"
                                        class="w-full h-full object-cover"
                                        id="main-image"
                                        loading="eager"
                                        decoding="async"
                                        width="800"
                                        height="600">
                                </div>
                                <!-- Thumbnails -->
                                @foreach($order->images->skip(1)->take(4) as $image)
                                    <div class="aspect-square relative bg-gray-100 cursor-pointer hover:opacity-90 transition-opacity"
                                        onclick="document.getElementById('main-image').src='{{ $image->getUrl() }}'">
                                        <img src="{{ $image->getUrl() }}"
                                            alt=""
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                            decoding="async"
                                            width="400"
                                            height="400">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Title & Info -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">
                                {{ Functions::getCategoryName($order->category) }}
                            </span>
                            <span class="px-3 py-1 {{ $order->type === 'client_order' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }} rounded-md text-sm font-medium">
                                {{ $order->type === 'client_order' ? 'Заказ' : 'Услуга' }}
                            </span>
                            <span class="px-3 py-1 {{ $order->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded-md text-sm font-medium">
                                {{ $order->status === 'active' ? 'Ищет исполнителя' : 'Завершено' }}
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">{{ $order->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <i class="fa fa-calendar text-gray-400"></i>
                                {{ $order->created_at->format('d.m.Y') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="fa fa-clock text-gray-400"></i>
                                Дедлайн: {{ $order->completion_date?->format('d.m.Y') ?? 'Не указан' }}
                            </span>
                            @if($order->location)
                                <span class="flex items-center gap-1.5">
                                    <i class="fa fa-map-marker text-gray-400"></i>
                                    {{ $order->location }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Описание</h2>
                        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $order->description }}
                        </div>
                    </div>

                    <!-- Materials -->
                    @if($order->materials)
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Материалы</h2>
                            <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $order->materials }}
                            </div>
                        </div>
                    @endif

                    <!-- Technical Requirements -->
                    @if($order->technical_requirements)
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Технические требования</h2>
                            <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $order->technical_requirements }}
                            </div>
                        </div>
                    @endif

                    <!-- Author Card (Mobile) -->
                    <div class="lg:hidden bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">О {{ $order->type === 'client_order' ? 'заказчике' : 'исполнителе' }}</h2>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 {{ Functions::getAvatarColor($order->user->name) }} rounded-full flex items-center justify-center text-white text-lg font-bold">
                                {{ Functions::getInitials($order->user->name) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">На платформе с {{ $order->user->created_at->format('Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="px-3 py-1 bg-gray-100 rounded-md text-gray-600">
                                {{ $order->user->role === 'client' ? 'Заказчик' : ($order->user->role === 'performer' ? 'Исполнитель' : 'Менеджер') }}
                            </span>
                            <span class="text-gray-500">
                                {{ \App\Models\Order::byUser($order->user->id)->count() }} {{ trans_choice('заказ|заказа|заказов', \App\Models\Order::byUser($order->user->id)->count()) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Price & Action Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 lg:sticky lg:top-24">
                        <div class="mb-6">
                            <p class="text-sm text-gray-500 mb-1">Бюджет</p>
                            <p class="text-4xl font-bold text-gray-900">{{ Functions::formatBudget($order->budget) }}</p>
                        </div>

                        @if($order->status === 'completed' || $order->status === 'closed')
                            <div class="text-center py-4 bg-gray-50 rounded-lg">
                                <i class="fa fa-lock text-2xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600 font-medium">Заказ закрыт</p>
                            </div>
                        @elseif($existingChat)
                            <div class="space-y-3">
                                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                    <div class="flex items-center gap-2 text-green-700">
                                        <i class="fa fa-check-circle"></i>
                                        <span class="font-medium">Вы откликнулись</span>
                                    </div>
                                </div>
                                <a href="{{ route('chats.show', $existingChat) }}" 
                                    class="block w-full py-3 bg-gray-900 text-white text-center rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                    Перейти в чат
                                </a>
                            </div>
                        @elseif($canRespond)
                            <form action="{{ route('orders.respond', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <textarea name="message" rows="3" required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                                        placeholder="Ваше сообщение..."></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="price"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                                        placeholder="Ваша цена">
                                    <input type="text" name="deadline"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                                        placeholder="Срок (дней)">
                                </div>
                                <button type="submit" 
                                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                    Отправить отклик
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <i class="fa fa-info-circle text-yellow-600 mb-2"></i>
                                <p class="text-sm text-yellow-700">{{ $respondError }}</p>
                            </div>
                        @endif

                        <!-- Owner Actions -->
                        @auth
                            @if(auth()->id() === $order->user_id || auth()->user()->isManager())
                                <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                                    @if($order->status === 'active')
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="block w-full py-2.5 text-center border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                            Редактировать
                                        </a>

                                        @php
                                            $activePerformerChat = \App\Models\Chat::where('order_id', $order->id)
                                                ->where('status', 'active')
                                                ->with('performer')
                                                ->first();
                                        @endphp

                                        @if($activePerformerChat)
                                            <!-- Информация об исполнителе -->
                                            <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                                <p class="text-xs text-gray-500 mb-1">Исполнитель:</p>
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                        {{ substr($activePerformerChat->performer->name ?? '??', 0, 2) }}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="font-medium text-sm text-gray-900 truncate">
                                                            {{ $activePerformerChat->performer->name ?? 'Исполнитель' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Кнопка перехода в чат с исполнителем -->
                                            <a href="{{ route('chats.show', $activePerformerChat) }}"
                                                class="block w-full py-2.5 text-center bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                                <i class="fa fa-comments mr-1"></i> Чат с исполнителем
                                            </a>

                                            <!-- Кнопка отклонения исполнителя -->
                                            <form action="{{ route('orders.cancel-performer', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Отклонить исполнителя? Заказ вернется в ленту и станет доступен для других.')">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full py-2.5 text-center border border-orange-200 text-orange-600 rounded-lg hover:bg-orange-50 transition-colors text-sm">
                                                    <i class="fa fa-user-times mr-1"></i> Отклонить исполнителя
                                                </button>
                                            </form>
                                        @else
                                            <p class="text-xs text-gray-500 text-center py-2">Ожидание откликов...</p>
                                        @endif

                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Закрыть заказ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-2.5 text-center border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm">
                                                Закрыть заказ
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Удалить заказ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-2.5 text-center border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm">
                                                Удалить
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Author Card (Desktop) -->
                    <div class="hidden lg:block bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">О {{ $order->type === 'client_order' ? 'заказчике' : 'исполнителе' }}</h2>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 {{ Functions::getAvatarColor($order->user->name) }} rounded-full flex items-center justify-center text-white text-lg font-bold">
                                {{ Functions::getInitials($order->user->name) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">На платформе с {{ $order->user->created_at->format('Y') }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">Роль</span>
                                <span class="px-3 py-1 bg-gray-100 rounded-md text-sm text-gray-700">
                                    {{ $order->user->role === 'client' ? 'Заказчик' : ($order->user->role === 'performer' ? 'Исполнитель' : 'Менеджер') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">Заказов</span>
                                <span class="font-semibold text-gray-900">{{ \App\Models\Order::byUser($order->user->id)->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Other Orders -->
                    @php
                        $otherOrders = \App\Models\Order::with('user')
                            ->where('id', '!=', $order->id)
                            ->where('status', 'active')
                            ->latest()
                            ->limit(4)
                            ->get();
                    @endphp

                    @if($otherOrders->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Другие заказы</h2>
                            <div class="space-y-4">
                                @foreach($otherOrders as $otherOrder)
                                    <a href="{{ route('orders.detail', $otherOrder->id) }}" class="block group">
                                        <div class="flex items-start gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($otherOrder->images && $otherOrder->images->count() > 0)
                                                    <img src="{{ $otherOrder->images->first()->getUrl() }}"
                                                        alt=""
                                                        class="w-full h-full object-cover"
                                                        loading="lazy"
                                                        decoding="async"
                                                        width="100"
                                                        height="100">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fa fa-image text-gray-300 text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                                    {{ $otherOrder->title }}
                                                </h4>
                                                <p class="text-sm font-semibold text-gray-900 mt-1">
                                                    {{ Functions::formatBudget($otherOrder->budget) }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
