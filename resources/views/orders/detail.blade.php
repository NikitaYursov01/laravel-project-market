@extends('componet.shablon')

@section('title', 'Детали заказа — ' . $order->title)

@use(App\Services\Functions)

@section('content')
    @include('componet/content.header')

    <div class="max-w-6xl mx-auto px-3 sm:px-4 py-5 sm:py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8">
            <!-- Основная информация -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-5 sm:mb-6">
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 leading-snug">
                                {{ $order->title }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                                <span
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ Functions::getCategoryName($order->category) }}</span>
                                <span>📅 Опубликовано: {{ $order->created_at->format('d.m.Y') }}</span>
                                <span>⏰ Дедлайн: {{ $order->completion_date?->format('d.m.Y') ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <div class="text-2xl sm:text-3xl font-bold text-blue-600 mb-2">
                                {{ Functions::formatBudget($order->budget) }}
                            </div>
                            <span
                                class="inline-block px-2 py-1 rounded text-xs sm:text-sm {{ $order->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }} mb-2">
                                {{ $order->status === 'active' ? 'Активный' : 'Завершён' }}
                            </span>

                            @auth
                                @if(auth()->id() === $order->user_id || auth()->user()->isManager())
                                    <div class="flex gap-2 justify-end">
                                        @if($order->status === 'active')
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                                <i class="fa fa-edit"></i> Редактировать
                                            </a>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Закрыть заказ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                                    <i class="fa fa-times"></i> Закрыть
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Удалить заказ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                                    <i class="fa fa-trash"></i> Удалить
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Описание -->
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3">Описание заказа</h3>
                        <div class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-relaxed whitespace-pre-line">
                            {{ $order->description }}
                        </div>
                    </div>

                    <!-- Материалы -->
                    @if($order->materials)
                        <div class="mb-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-3">Материалы</h3>
                            <div class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-relaxed whitespace-pre-line">
                                {{ $order->materials }}
                            </div>
                        </div>
                    @endif

                    <!-- Технические требования -->
                    @if($order->technical_requirements)
                        <div class="mb-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-3">Технические требования</h3>
                            <div class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-relaxed whitespace-pre-line">
                                {{ $order->technical_requirements }}
                            </div>
                        </div>
                    @endif

                    <!-- Изображения (если есть) -->
                    @if($order->images && $order->images->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-3">Прикрепленные файлы ({{ $order->images->count() }})</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                                @foreach($order->images as $image)
                                    <div class="border rounded-lg p-2 hover:shadow-md transition-shadow">
                                        <a href="{{ $image->getUrl() }}" target="_blank" class="block">
                                            <img src="{{ $image->getUrl() }}" alt="{{ $image->original_name }}"
                                                class="w-full h-32 object-cover rounded hover:opacity-90 transition-opacity">
                                        </a>
                                        <p class="text-xs text-gray-600 mt-1 text-center truncate">{{ $image->original_name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Навыки и теги -->
                    <div class="mb-6">
                        <h3 class="text-base sm:text-lg font-semibold mb-3">Требуемые навыки</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">HTML5</span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">CSS3</span>
                            <span
                                class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">JavaScript</span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">Tailwind
                                CSS</span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">Figma</span>
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">SEO</span>
                        </div>
                    </div>
                </div>

                <!-- Форма отклика -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-4">Отправить отклик</h3>

                    {{-- Заказ закрыт --}}
                    @if($order->status === 'completed' || $order->status === 'closed')
                        <div class="text-center py-6 bg-gray-50 rounded-lg">
                            <i class="fa fa-lock text-3xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 font-medium">Заказ закрыт</p>
                            <p class="text-sm text-gray-500 mt-1">Этот заказ уже выполнен и закрыт администратором</p>
                        </div>
                    @else
                        @auth
                            @php
                                $user = auth()->user();
                                $canRespond = false;
                                $respondError = '';

                                // Проверка возможности отклика
                                if ($order->user_id === $user->id) {
                                    $respondError = 'Это ваш заказ';
                                } elseif ($user->isManager()) {
                                    $canRespond = true; // Админ может откликаться на всё
                                } elseif ($user->isPerformer() && $order->type === 'client_request') {
                                    $canRespond = true; // Исполнитель на заказ заказчика
                                } elseif ($user->isClient() && $order->type === 'performer_service') {
                                    $canRespond = true; // Заказчик на услугу исполнителя
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
                            @endphp

                            @if($existingChat)
                                <div class="text-center py-4">
                                    <p class="text-green-600 mb-3"><i class="fa fa-check-circle mr-2"></i>Вы уже откликнулись на этот
                                        заказ</p>
                                    <a href="{{ route('chats.show', $existingChat) }}"
                                        class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">
                                        Перейти в чат
                                    </a>
                                </div>
                            @elseif($canRespond)
                                <form action="{{ route('orders.respond', $order) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                            Ваше сообщение {{ $order->type === 'client_request' ? 'заказчику' : 'исполнителю' }}
                                        </label>
                                        <textarea name="message" rows="3" required
                                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Здравствуйте! Я заинтересован. Могу начать работу сразу..."></textarea>
                                    </div>
                                    <div class="flex gap-3">
                                        <input type="text" name="price"
                                            class="w-1/2 px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Ваша цена (₽)">
                                        <input type="text" name="deadline"
                                            class="w-1/2 px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Срок (дней)">
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium text-sm sm:text-base">
                                        <i class="fa fa-paper-plane mr-2"></i>Отправить отклик и начать чат
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-500 text-center py-4">{{ $respondError }}</p>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="lg:col-span-1">
                <!-- Информация о заказчике -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                    <h3 class="text-lg font-semibold mb-4">О заказчике</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                        <div>
                            <div class="font-semibold">Иван Петров</div>
                            <div class="text-sm text-gray-600">На платформе с 2023</div>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Заказов размещено:</span>
                            <span class="font-medium">15</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Заказов выполнено:</span>
                            <span class="font-medium">12</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Рейтинг:</span>
                            <span class="text-yellow-500">★ 4.8</span>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-gray-100 text-gray-800 py-2 rounded-lg hover:bg-gray-200">
                        Написать сообщение
                    </button>
                </div>

                <!-- Статистика заказа -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                    <h3 class="text-lg font-semibold mb-4">Статистика</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Просмотров:</span>
                            <span class="font-medium">156</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Откликов:</span>
                            <span class="font-medium">8</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">В избранном:</span>
                            <span class="font-medium">12</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Осталось дней:</span>
                            <span class="font-medium text-orange-600">5</span>
                        </div>
                    </div>
                </div>

                <!-- Похожие заказы -->
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                    <h3 class="text-lg font-semibold mb-4">Похожие заказы</h3>
                    <div class="space-y-3">
                        <div class="border-b pb-3">
                            <h4 class="font-medium text-sm mb-1">
                                <a href="#" class="text-blue-600 hover:text-blue-800">Создать сайт-визитку</a>
                            </h4>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Программирование</span>
                                <span class="text-blue-600 font-medium">8 000 ₽</span>
                            </div>
                        </div>
                        <div class="border-b pb-3">
                            <h4 class="font-medium text-sm mb-1">
                                <a href="#" class="text-blue-600 hover:text-blue-800">Редизайн корпоративного сайта</a>
                            </h4>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Дизайн</span>
                                <span class="text-blue-600 font-medium">12 000 ₽</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-medium text-sm mb-1">
                                <a href="#" class="text-blue-600 hover:text-blue-800">Landing page для продукта</a>
                            </h4>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Программирование</span>
                                <span class="text-blue-600 font-medium">15 000 ₽</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection