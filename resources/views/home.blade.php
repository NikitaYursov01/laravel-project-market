@extends('componet.shablon')

@section('title', 'DetailDeal — Платформа для металлообработки и поставок металла')
@section('description', 'Найдите исполнителей для металлообработки: лазерная резка, сварка, гибка. Или поставщиков металлопроката. Маркетплейс заказчиков и подрядчиков.')

@section('content')

                    @include('componet/content.header')
                    @use(App\Services\Functions)

                    <style>
                        .float-card {
                            animation: float 6s ease-in-out infinite;
                            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
                        }

                        .float-card:nth-child(2) {
                            animation-delay: -2s;
                        }

                        .float-card:nth-child(3) {
                            animation-delay: -4s;
                        }

                        @keyframes float {

                            0%,
                            100% {
                                transform: translateY(0px) rotate(0deg);
                            }

                            50% {
                                transform: translateY(-20px) rotate(2deg);
                            }
                        }

                        .glass-card {
                            background: rgba(255, 255, 255, 0.9);
                            backdrop-filter: blur(10px);
                            border: 1px solid rgba(255, 255, 255, 0.5);
                        }

                        .hero-gradient {
                            background: linear-gradient(135deg, #ffffff 0%, #E1F1FE 30%, #E1F1FE 70%, #ffffff 100%);
                            background-size: 200% 200%;
                            will-change: background-position;
                            animation: gradientBG 15s ease-in-out infinite alternate;
                        }

                        @keyframes gradientBG {
                            0% {
                                background-position: 200% 200%;
                            }

                            50% {
                                background-position: 150% 150%;
                            }

                            100% {
                                background-position: 100% 100%;
                            }
                        }

                        .sphere {
                            position: absolute;
                            border-radius: 50%;
                            filter: blur(40px);
                            opacity: 0.4;
                        }

                        .product-card {
                            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                        }

                        .product-card:hover {
                            transform: translateY(-8px);
                            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
                        }

                        .category-pill {
                            transition: all 0.3s ease;
                        }

                        .category-pill:hover {
                            transform: scale(1.05);
                            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
                        }
                    </style>

                    <!-- Hero Section -->
                    <section class="relative hero-gradient min-h-[90vh] flex items-center overflow-hidden">
                        <!-- Decorative Spheres -->
                        <div class="sphere w-96 h-96 bg-blue-300 top-20 -left-20"></div>
                        <div class="sphere w-80 h-80 bg-indigo-200 bottom-20 right-10"></div>
                        <div class="sphere w-64 h-64 bg-sky-200 top-1/2 right-1/3"></div>

                        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                            <div class="grid lg:grid-cols-2 gap-16 items-center">
                                <!-- Left Content -->
                                <div class="text-center lg:text-left space-y-8">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full">
                                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        @php
    $activeOrdersCount = \App\Models\Order::where('status', 'active')->count();
                                        @endphp
                                        <span class="text-sm font-medium text-gray-700">{{ $activeOrdersCount }}
                                            {{ trans_choice('активный заказ|активных заказа|активных заказов', $activeOrdersCount) }}
                                            сейчас</span>
                                    </div>

                                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 leading-[1.1]">
                                        Найдите<br>
                                        <span
                                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">исполнителя</span>
                                    </h1>

                                    <p class="text-xl text-gray-600 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                                        Платформа для связи заказчиков и подрядчиков. Разместите заказ на металлообработку или найдите
                                        исполнителя за 5 минут.
                                    </p>

                                    <!-- Modern Search -->
                                    <div class="glass-card rounded-2xl p-2 max-w-xl mx-auto lg:mx-0 shadow-xl">
                                        <form action="{{ route('orders.feed') }}" method="GET" class="flex gap-2">
                                            <div class="flex-1 relative">
                                                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                                <input type="text" name="q"
                                                    placeholder="Поиск заказов и исполнителей (например: лазерная резка)"
                                                    class="border border-dashed border-blue-400 w-full pl-12 pr-4 py-4 bg-white/50 rounded-xl text-base">
                                            </div>
                                            <button type="submit"
                                                class="px-8 py-4 bg-white text-blue-600 border border-dashed border-blue-400 rounded-full font-medium transition-colors flex items-center gap-2">
                                               <i class="fa fa-search"></i> Найти
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Quick Categories -->
                                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                                        @foreach(['Лазерная резка', 'Сварка', 'Гибка металла', 'Токарные работы', 'Лист стальной', 'Трубы ВГП'] as $tag)
                                            <a href="{{ route('orders.feed', ['q' => $tag]) }}"
                                                class="category-pill px-4 py-2 bg-white/80 hover:bg-white text-gray-700 text-sm rounded-full border border-gray-200/60 shadow-sm">
                                                {{ $tag }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Right - 3D Floating Cards -->
                                <div class="hidden lg:block relative h-[600px]">
                                    <!-- Card 1 - Active Order -->
                                    <div class="float-card absolute top-10 right-10 w-72 bg-white rounded-3xl p-6 z-30">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Новый
                                                заказ</span>
                                            <span class="text-xs text-gray-400">2 мин назад</span>
                                        </div>
                                        <div class="flex items-center gap-4 mb-4">
                                            <div
                                                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                <i class="fa fa-cut text-white text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">Лазерная резка</p>
                                                <p class="text-sm text-gray-500">Лист 3 мм, 500 деталей</p>
                                            </div>
                                        </div>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-bold text-gray-900">до <span class="count-up" data-target="45000" data-suffix=" "></span></span>
                                            <span class="text-gray-500">₽</span>
                                        </div>
                                        <div class="mt-4 flex items-center gap-2 text-sm text-blue-600">
                                            <i class="fa fa-map-marker"></i>
                                            <span>Москва, откликов: 3</span>
                                        </div>
                                    </div>

                                    <!-- Card 2 - Performer -->
                                    <div class="float-card absolute top-40 left-0 w-64 bg-white rounded-3xl p-5 z-20"
                                        style="animation-delay: -2s;">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div
                                                class="w-12 h-12 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-xl flex items-center justify-center ring-4 ring-blue-50/50">
                                                <i class="fa fa-fire text-blue-700"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 text-sm">ООО "МеталлСвар"</p>
                                                <p class="text-xs text-slate-500">Сварочные работы</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 mb-4">
                                            @foreach([1, 2, 3, 4, 5] as $i)
                                                <i class="fa fa-star text-amber-400 text-xs"></i>
                                            @endforeach
                                            <span class="text-xs text-slate-500 ml-1">4.9 (27 отзывов)</span>
                                        </div>
                                        <div class="flex -space-x-2">
                                            @foreach([1, 2, 3] as $i)
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 border-2 border-white flex items-center justify-center text-xs text-gray-600">
                                                    {{ chr(64 + $i) }}
                                                </div>
                                            @endforeach
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white flex items-center justify-center text-xs font-semibold text-slate-600">
                                                +12
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card 3 - Photo -->
                                    <div class="float-card absolute bottom-20 right-20 w-64 h-44 rounded-3xl overflow-hidden shadow-xl z-10"
                                        style="animation-delay: -4s;">
                                        <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=300&fit=crop"
                                            alt="Metalworking" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/80 via-slate-900/20 to-transparent">
                                        </div>
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <p class="font-bold text-white text-lg">1 200+ сделок</p>
                                            <p class="text-sm text-white/80">Проверенные подрядчики</p>
                                        </div>
                                    </div>

                                    <!-- Decorative Elements -->
                                    <div
                                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-blue-200/50 rounded-full">
                                    </div>
                                    <div
                                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 border border-indigo-200/30 rounded-full">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Bento Grid Section (Bionova Style) -->
                    <section class="py-20 bg-white">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="grid lg:grid-cols-2 gap-8 items-start">
                                <!-- Left - Content -->
                                <div class="space-y-8">
                                    <div class="space-y-6">
                                        <h2 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight">
                                            Найдите подрядчиков для
                                            <span class="text-blue-700">металлообработки</span>
                                        </h2>
                                        <p class="text-lg text-slate-600 max-w-lg">
                                            Платформа для связи заказчиков и исполнителей. Разместите заказ или найдите подрядчика за 5
                                            минут.
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('orders.create') }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-semibold transition-colors">
                                            Разместить заказ <i class="fa fa-arrow-right text-sm"></i>
                                        </a>
                                        <a href="{{ route('orders.feed') }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-900 rounded-xl font-semibold transition-colors">
                                            Найти исполнителя
                                        </a>
                                    </div>

                                    <div class="pt-8 border-t border-slate-100">
                                        <p class="text-sm text-slate-500 mb-4">Нам доверяют</p>
                                        <div class="flex flex-wrap items-center gap-6 text-slate-500">
                                            <div class="flex items-center gap-2 font-semibold">
                                                <i class="fa fa-industry"></i> МеталлПром
                                            </div>
                                            <div class="flex items-center gap-2 font-semibold">
                                                <i class="fa fa-cog"></i> СтальСервис
                                            </div>
                                            <div class="flex items-center gap-2 font-semibold">
                                                <i class="fa fa-wrench"></i> ТехноМеталл
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right - Bento Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Large Card - CTA -->
                                    <div
                                        class="col-span-2 bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden border border-slate-800">
                                        <div class="relative z-10">
                                            <p class="text-2xl font-semibold mb-4 max-w-xs">Если вам нужна металлообработка любой сложности
                                            </p>
                                            <p class="text-white/75 text-sm mb-6">Разместите заказ и получите предложения от проверенных
                                                подрядчиков</p>
                                            <a href="{{ route('orders.create') }}"
                                                class="inline-flex items-center justify-center w-12 h-12 bg-white text-slate-900 rounded-full hover:bg-slate-100 transition-colors">
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                        <div class="absolute top-4 right-4 w-40 h-40 bg-blue-600/15 rounded-full blur-2xl"></div>
                                        <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white/5 rounded-full blur-3xl"></div>
                                    </div>

                                    <!-- Locations Card -->
                                    <div class="bg-white rounded-3xl p-6 relative border border-dashed border-gray-500 shadow-sm">
                                        <div
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-700 mb-4 shadow-sm">
                                            <i class="fa fa-map-marker text-blue-700"></i> Регионы
                                        </div>
                                        <p class="text-lg font-semibold text-gray-900 mb-2">Работаем по всей России</p>
                                        <p class="text-sm text-gray-600">Более 50 городов присутствия</p>
                                        <div
                                            class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">
                                            <i class="fa fa-arrow-up-right text-xs text-gray-600"></i>
                                        </div>
                                    </div>

                                    <!-- Stats Card -->
                                    <div class="bg-white rounded-3xl p-6 relative border border-dashed border-gray-500 shadow-sm">
                                        <div
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-700 mb-4 shadow-sm">
                                            <i class="fa fa-users text-blue-700"></i> Подрядчики
                                        </div>
                                        <p class="text-4xl font-bold text-gray-900 mb-2 count-up" data-target="200" data-suffix="+">0</p>
                                        <p class="text-sm text-gray-600">Проверенных исполнителей с рейтингом</p>
                                        <div class="flex -space-x-2 mt-4">
                                            @foreach([1, 2, 3] as $i)
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-semibold text-gray-600">
                                                    {{ chr(64 + $i) }}
                                                </div>
                                            @endforeach
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-xs font-semibold text-gray-500">
                                                +197
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Stats Bar -->
                    <section class="bg-white border-b border-gray-100">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                                @php
    $stats_data = [
        ['value' => $stats['total_orders'] ?? '500+', 'label' => 'Активных заказов', 'icon' => 'fa-clipboard-list'],
        ['value' => $stats['performers'] ?? '200+', 'label' => 'Исполнителей', 'icon' => 'fa-users'],
        ['value' => $stats['completed'] ?? '1.2K', 'label' => 'Совершённых сделок', 'icon' => 'fa-check-circle'],
        ['value' => $stats['categories'] ?? '12', 'label' => 'Видов услуг', 'icon' => 'fa-layer-group'],
    ];
                                @endphp

                                @foreach($stats_data as $stat)
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center shadow-sm">
                                            <i class="fa {{ $stat['icon'] }} text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold text-gray-900 count-up" data-target="{{ preg_replace('/[^0-9]/', '', $stat['value']) }}" data-suffix="{{ preg_replace('/[0-9]/', '', $stat['value']) }}">0</p>
                                            <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- Categories -->
                    <section class="py-20 bg-slate-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-white text-blue-700 rounded-full text-sm font-semibold mb-4 border border-slate-200 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-linear-to-br from-slate-400 to-blue-500"></span>
                                    Категории заказов
                                </span>
                                <h2 class="text-4xl font-bold text-slate-900 mb-4">Какие услуги ищут?</h2>
                                <p class="text-slate-600 text-lg max-w-2xl mx-auto">Выберите категорию металлообработки или металлопроката
                                    для поиска заказов и исполнителей</p>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <!-- Featured Category - Metal Processing -->
                                <a href="{{ route('orders.feed', ['category' => 'metal_processing']) }}"
                                    class="col-span-2 md:col-span-1 lg:col-span-1 group bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden border border-slate-800 h-full flex flex-col">
                                    <div class="relative z-10 flex-1">
                                        <div
                                            class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6 ring-4 ring-white/5">
                                            <i class="fa fa-fire text-white text-2xl"></i>
                                        </div>
                                        <h3 class="text-2xl font-bold mb-3">Обработка металла</h3>
                                        <p class="text-white/70 text-sm leading-relaxed">Лазерная резка, сварка, гибка и другие виды
                                            металлообработки любой сложности</p>
                                    </div>
                                    <div
                                        class="relative z-10 mt-6 inline-flex items-center gap-2 text-sm font-semibold text-white/90 group-hover:gap-3 transition-all">
                                        Смотреть заказы <i class="fa fa-arrow-right"></i>
                                    </div>
                                    <div class="absolute top-4 right-4 w-32 h-32 bg-blue-600/20 rounded-full blur-2xl"></div>
                                    <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                                </a>

                                <!-- Category Cards -->
                                <a href="{{ route('orders.feed', ['category' => 'metal_sheet']) }}"
                                    class="group bg-white rounded-3xl p-6 relative border border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all h-full flex flex-col">
                                    <div
                                        class="w-14 h-14 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-blue-50/50 shadow-sm">
                                        <i class="fa fa-layer-group text-blue-700 text-xl"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">Листовой прокат</h3>
                                    <p class="text-sm text-slate-600 mt-auto">ГК, ХК, оцинкованный</p>
                                    <div
                                        class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                                        <i class="fa fa-arrow-right text-xs text-slate-500"></i>
                                    </div>
                                </a>

                                <a href="{{ route('orders.feed', ['category' => 'metal_pipe']) }}"
                                    class="hero-gradient group bg-white rounded-3xl p-6 relative border border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all h-full flex flex-col">
                                    <div
                                        class="w-14 h-14 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-blue-50/50 shadow-sm">
                                        <i class="fa fa-grip-lines text-blue-700 text-xl"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">Трубы</h3>
                                    <p class="text-sm text-slate-600 mt-auto">ВГП, профильные</p>
                                    <div
                                        class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                                        <i class="fa fa-arrow-right text-xs text-slate-500"></i>
                                    </div>
                                </a>

                                <a href="{{ route('orders.feed', ['category' => 'metal_beam']) }}"
                                    class="group bg-white rounded-3xl p-6 relative border border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all h-full flex flex-col">
                                    <div
                                        class="w-14 h-14 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-blue-50/50 shadow-sm">
                                        <i class="fa fa-ruler-horizontal text-blue-700 text-xl"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">Балки</h3>
                                    <p class="text-sm text-slate-600 mt-auto">Двутавры, швеллеры</p>
                                    <div
                                        class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                                        <i class="fa fa-arrow-right text-xs text-slate-500"></i>
                                    </div>
                                </a>

                                <a href="{{ route('orders.feed', ['category' => 'metal_rebar']) }}"
                                    class="hero-gradient group bg-white rounded-3xl p-6 relative border border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all h-full flex flex-col">
                                    <div
                                        class="w-14 h-14 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-blue-50/50 shadow-sm">
                                        <i class="fa fa-bezier-curve text-blue-700 text-xl"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">Арматура</h3>
                                    <p class="text-sm text-slate-600 mt-auto">Рифленая, сетка</p>
                                    <div
                                        class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                                        <i class="fa fa-arrow-right text-xs text-slate-500"></i>
                                    </div>
                                </a>

                                <a href="{{ route('orders.feed', ['category' => 'delivery']) }}"
                                    class="hero-gradient group bg-white rounded-3xl p-6 relative border border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all h-full flex flex-col">
                                    <div
                                        class="w-14 h-14 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-blue-50/50 shadow-sm">
                                        <i class="fa fa-truck text-blue-700 text-xl"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">Доставка</h3>
                                    <p class="text-sm text-slate-600 mt-auto">Перевозка металла</p>
                                    <div
                                        class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                                        <i class="fa fa-arrow-right text-xs text-slate-500"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </section>

                    <!-- Featured Orders - Premium Masonry Style -->
                    <section class="py-12 bg-slate-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <!-- Header -->
                            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8">
                                <div class="max-w-xl">
                                    <span
                                        class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-3">Актуальные
                                        заказы</span>
                                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-3 leading-tight">Новые объявления</h2>
                                    <p class="text-slate-600 text-lg">Подберите подрядчика или поставщика металлопроката по вашим
                                        требованиям</p>
                                </div>
                                <a href="{{ route('orders.feed') }}"
                                    class="group inline-flex items-center gap-3 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-full font-medium transition-all">
                                    <span>Смотреть все</span>
                                    <span
                                        class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-slate-900 transition-all">
                                        <i class="fa fa-arrow-right text-sm"></i>
                                    </span>
                                </a>
                            </div>

                            @if($latestOrders->count() > 0)
                                @php
        $orders = $latestOrders->take(5)->values();
        $leftOrders = collect([$orders->get(0), $orders->get(3)])->filter();
        $rightOrders = collect([$orders->get(1), $orders->get(2), $orders->get(4)])->filter();
                                @endphp

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">
                                    <div class="space-y-4">
                                        @foreach($leftOrders as $order)
                                            @php
            $responses = \App\Models\Chat::where('order_id', $order->id)->count();
            $isService = $order->type === 'performer_service';
                                            @endphp
                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                class="group relative h-80 lg:h-105 rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-lg transition-all duration-500 block">
                                                <div class="absolute inset-0">
                                                    @if($order->images && $order->images->count() > 0)
                                                        <img src="{{ $order->images->first()->getUrl() }}" alt=""
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                                            loading="lazy">
                                                        <div
                                                            class="absolute inset-0 bg-linear-to-t from-slate-900 via-slate-900/40 to-transparent opacity-90">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="w-full h-full {{ $isService ? 'bg-linear-to-br from-orange-500 to-red-600' : 'bg-linear-to-br from-blue-600 to-indigo-700' }}">
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <i class="fa {{ $isService ? 'fa-fire' : 'fa-cube' }} text-6xl text-white/20"></i>
                                                            </div>
                                                        </div>
                                                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/80 to-transparent"></div>
                                                    @endif
                                                </div>

                                                <div class="absolute inset-0 p-5 lg:p-6 flex flex-col justify-between">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <span
                                                                class="px-3 py-1.5 bg-white/95 text-slate-900 text-xs font-bold rounded-full shadow-sm">
                                                                {{ $isService ? 'Услуга' : 'Металлопрокат' }}
                                                            </span>
                                                            @if($order->status === 'active')
                                                                <span
                                                                    class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-semibold rounded-full shadow-sm flex items-center gap-1">
                                                                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                                                    Ищет исполнителя
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <i class="fa fa-arrow-up-right"></i>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="mb-3">
                                                            <span
                                                                class="text-white/70 text-sm font-medium uppercase tracking-wider">{{ Functions::getCategoryName($order->category) }}</span>
                                                        </div>
                                                        <h3
                                                            class="font-bold text-white text-lg lg:text-xl mb-1.5 line-clamp-2 group-hover:text-blue-200 transition-colors">
                                                            {{ $order->title }}
                                                        </h3>
                                                        <p class="text-white/80 text-sm line-clamp-3 mb-3">
                                                            {{ Str::limit($order->description, 120) }}
                                                        </p>

                                                        <div class="flex items-center justify-between pt-3 border-t border-white/20">
                                                            <div class="flex items-center gap-4 text-sm text-white/70">
                                                                <span class="flex items-center gap-1.5">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ $order->created_at->diffForHumans() }}
                                                                </span>
                                                                <span class="flex items-center gap-1.5">
                                                                    <i class="fa fa-comment-o"></i>
                                                                    {{ $responses }} {{ trans_choice('отклик|отклика|откликов', $responses) }}
                                                                </span>
                                                            </div>
                                                            <div class="text-right">
                                                                <span class="block text-xs text-white/60 mb-0.5">Бюджет</span>
                                                                <span
                                                                    class="font-bold text-white text-lg">{{ Functions::formatBudget($order->budget) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>

                                    <div class="space-y-4">
                                        @foreach($rightOrders as $order)
                                            @php
            $responses = \App\Models\Chat::where('order_id', $order->id)->count();
            $isService = $order->type === 'performer_service';
                                            @endphp
                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                class="group relative h-64 rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-lg transition-all duration-500 block">
                                                <div class="absolute inset-0">
                                                    @if($order->images && $order->images->count() > 0)
                                                        <img src="{{ $order->images->first()->getUrl() }}" alt=""
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                                            loading="lazy">
                                                        <div
                                                            class="absolute inset-0 bg-linear-to-t from-slate-900 via-slate-900/40 to-transparent opacity-90">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="w-full h-full {{ $isService ? 'bg-linear-to-br from-orange-500 to-red-600' : 'bg-linear-to-br from-blue-600 to-indigo-700' }}">
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <i class="fa {{ $isService ? 'fa-fire' : 'fa-cube' }} text-5xl text-white/20"></i>
                                                            </div>
                                                        </div>
                                                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/80 to-transparent"></div>
                                                    @endif
                                                </div>

                                                <div class="absolute inset-0 p-5 flex flex-col justify-between">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <span
                                                                class="px-3 py-1.5 bg-white/95 text-slate-900 text-xs font-bold rounded-full shadow-sm">
                                                                {{ $isService ? 'Услуга' : 'Металлопрокат' }}
                                                            </span>
                                                            @if($order->status === 'active')
                                                                <span
                                                                    class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-semibold rounded-full shadow-sm flex items-center gap-1">
                                                                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                                                    Ищет исполнителя
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="mb-2">
                                                            <span
                                                                class="text-white/70 text-sm font-medium uppercase tracking-wider">{{ Functions::getCategoryName($order->category) }}</span>
                                                        </div>
                                                        <h3
                                                            class="font-bold text-white text-lg mb-1.5 line-clamp-2 group-hover:text-blue-200 transition-colors">
                                                            {{ $order->title }}
                                                        </h3>
                                                        <p class="text-white/80 text-sm line-clamp-2 mb-3">{{ Str::limit($order->description, 70) }}
                                                        </p>

                                                        <div class="flex items-center justify-between pt-3 border-t border-white/20">
                                                            <div class="flex items-center gap-4 text-sm text-white/70">
                                                                <span class="flex items-center gap-1.5">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    {{ $order->created_at->diffForHumans() }}
                                                                </span>
                                                                <span class="flex items-center gap-1.5">
                                                                    <i class="fa fa-comment-o"></i>
                                                                    {{ $responses }}
                                                                </span>
                                                            </div>
                                                            <div class="text-right">
                                                                <span class="block text-xs text-white/60 mb-0.5">Бюджет</span>
                                                                <span
                                                                    class="font-bold text-white">{{ Functions::formatBudget($order->budget) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="relative rounded-2xl overflow-hidden bg-slate-100 p-10 text-center border border-slate-200">
                                    <div class="relative z-10 max-w-md mx-auto">
                                        <div class="w-20 h-20 bg-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-3">
                                            <i class="fa fa-inbox text-slate-500 text-3xl"></i>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900 mb-3">Пока нет заказов</h3>
                                        <p class="text-slate-600 mb-6">Будьте первым, кто разместит заказ на металлопрокат или услуги
                                            металлообработки</p>
                                        <a href="{{ route('orders.create') }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-full font-medium hover:bg-slate-800 transition-colors">
                                            <i class="fa fa-plus"></i>
                                            Разместить заказ
                                        </a>
                                    </div>
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>
                                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-400/20 rounded-full blur-3xl"></div>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- Services -->
                    <section class="py-20 bg-slate-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="grid lg:grid-cols-2 gap-16 items-center">
                                <div>
                                    <span
                                        class="inline-flex items-center gap-2 px-4 py-1.5 bg-white text-blue-700 rounded-full text-sm font-semibold mb-6 border border-slate-200 shadow-sm">
                                        <span class="w-2 h-2 rounded-full bg-linear-to-br from-slate-400 to-blue-500"></span>
                                        Услуги исполнителей
                                    </span>
                                    <h2 class="text-4xl font-bold text-slate-900 mb-4 leading-tight">Найдите исполнителя для
                                        металлообработки</h2>
                                    <p class="text-slate-600 text-lg mb-10 max-w-xl">Наши подрядчики выполняют работы любой сложности — от
                                        резки листового металла до сварки сложных конструкций. Выбирайте по рейтингу и отзывам.</p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @php
    $services = [
        ['icon' => 'fa-cut', 'title' => 'Резка металла', 'desc' => 'Лазерная, плазменная, газовая'],
        ['icon' => 'fa-fire', 'title' => 'Сварочные работы', 'desc' => 'MIG/MAG, TIG сварка'],
        ['icon' => 'fa-compress-arrows-alt', 'title' => 'Гибка и вальцовка', 'desc' => 'Листовой прокат, трубы'],
        ['icon' => 'fa-paint-brush', 'title' => 'Покраска', 'desc' => 'Порошковая, цинкование'],
    ];
                                        @endphp

                                        @foreach($services as $service)
                                            <div
                                                class="group flex items-start gap-4 p-5 bg-white rounded-2xl transition-all border border-slate-200 hover:border-slate-300 hover:shadow-lg">
                                                <div
                                                    class="w-12 h-12 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center shrink-0 shadow-sm ring-4 ring-blue-50/50">
                                                    <i class="fa {{ $service['icon'] }} text-blue-700"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="font-semibold text-slate-900 mb-1">{{ $service['title'] }}</h4>
                                                    <p class="text-sm text-slate-600">{{ $service['desc'] }}</p>
                                                    <div
                                                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        Подробнее <i class="fa fa-arrow-right text-xs"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-3 mt-10">
                                        <a href="{{ route('orders.feed', ['type' => 'performer_service']) }}"
                                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 text-blue-800 rounded-xl font-semibold hover:from-slate-50 hover:via-sky-50 hover:to-blue-100 transition-all shadow-sm border border-blue-100">
                                            Найти исполнителя <i class="fa fa-arrow-right"></i>
                                        </a>
                                        <a href="{{ route('orders.create') }}"
                                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-900 rounded-xl font-semibold hover:bg-slate-50 transition-colors border border-slate-200">
                                            Разместить заказ <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="relative">
                                    <div
                                        class="aspect-square bg-slate-900 rounded-3xl p-10 flex items-center justify-center shadow-xl border border-slate-800 relative overflow-hidden">
                                        <div class="relative z-10 text-center">
                                            <div class="w-24 h-24 bg-white/10 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                                <i class="fa fa-industry text-5xl text-white"></i>
                                            </div>
                                            <h3 class="text-3xl text-white/75 font-bold mb-3"><span class="count-up" data-target="200" data-suffix="+" style="color: inherit;">0</span> подрядчиков</h3>
                                            <p class="text-white/75 mb-8">Готовы принять ваш заказ</p>
                                            <div class="grid grid-cols-2 gap-3 max-w-xs mx-auto mb-8">
                                                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-3 text-left">
                                                    <p class="text-xs text-white/75">Средний отклик</p>
                                                    <p class="text-lg font-bold text-white">~ 1 час</p>
                                                </div>
                                                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-3 text-left">
                                                    <p class="text-xs text-white/75">Покрытие</p>
                                                    <p class="text-lg font-bold text-white"><span class="count-up" data-target="50" data-suffix="+"></span> городов</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-center -space-x-3">
                                                @foreach([1, 2, 3, 4, 5] as $i)
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-slate-800 border-2 border-white/10 flex items-center justify-center text-sm font-bold text-white">
                                                        {{ chr(64 + $i) }}
                                                    </div>
                                                @endforeach
                                                <div
                                                    class="w-10 h-10 rounded-full bg-slate-800 border-2 border-white/10 flex items-center justify-center text-sm font-bold text-white">
                                                    +
                                                </div>
                                            </div>
                                        </div>

                                        <div class="absolute top-4 right-4 w-40 h-40 bg-blue-600/15 rounded-full blur-2xl"></div>
                                        <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white/5 rounded-full blur-3xl"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                    <!-- How It Works -->
                    <section class="py-20 bg-white">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-16">
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-slate-100 text-slate-700 rounded-full text-sm font-semibold mb-4">
                                    <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                    Простой процесс
                                </span>
                                <h2 class="text-4xl font-bold text-slate-900 mb-4">Как работает DetailDeal</h2>
                                <p class="text-slate-600 text-lg max-w-2xl mx-auto">От размещения заказа до получения металла — всего 4 шага
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                                @php
    $steps = [
        ['num' => '1', 'title' => 'Создайте заказ', 'desc' => 'Опишите нужный металл или услуги, прикрепите фото и документы'],
        ['num' => '2', 'title' => 'Получите цены', 'desc' => 'Поставщики предложат свои условия и цены в течение часа'],
        ['num' => '3', 'title' => 'Выберите лучшее', 'desc' => 'Сравните предложения по цене, рейтингу и срокам доставки'],
        ['num' => '4', 'title' => 'Получите металл', 'desc' => 'Оплатите и получите заказ с доставкой или самовывозом'],
    ];
                                @endphp

                                @foreach($steps as $i => $step)
                                    <div class="rounded-xl relative text-center group">
                                        <div
                                            class="hero-gradient w-16 h-16 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm ring-4 ring-blue-50/50 group-hover:scale-105 transition-transform">
                                            <span class="text-2xl font-bold text-blue-700 count-up" data-target="{{ $step['num'] }}" data-suffix=""></span>
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-lg mb-3">{{ $step['title'] }}</h3>
                                        <p class="text-slate-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <script>
                        document.querySelectorAll('.count-up').forEach(el => {
                            new IntersectionObserver((entries, obs) => {
                                entries.forEach(e => {
                                    if (!e.isIntersecting) return;
                                    const t = +e.target.dataset.target, s = e.target.dataset.suffix || '', d = 2e3;
                                    let st = performance.now();
                                    const step = n => {
                                        const p = Math.min((n - st) / d, 1);
                                        e.target.textContent = Math.round((1 - Math.pow(2, -10 * p)) * t) + s;
                                        p < 1 ? requestAnimationFrame(step) : e.target.textContent = t + s;
                                    };
                                    requestAnimationFrame(step);
                                    obs.unobserve(e.target);
                                });
                            }, { threshold: 0.3 }).observe(el);
                        });
                    </script>

                    <!-- CTA Section -->
                    <section class="py-20 bg-slate-950">
                        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">Ищете заказы<br>или исполнителя?</h2>
                            <p class="text-slate-300 text-lg mb-10">Присоединяйтесь к тысячам компаний, которые используют DetailDeal для
                                поиска заказов и подрядчиков по металлообработке</p>

                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                @auth
                                    <a href="{{ route('orders.create') }}"
                                        class="px-8 py-4 bg-white text-slate-900 rounded-xl font-bold hover:bg-slate-100 transition-colors flex items-center justify-center gap-2 border border-white/10">
                                        <i class="fa fa-plus"></i> Разместить заказ
                                    </a>
                                @else
                                    <a href="{{ route('register.form') }}"
                                        class="px-8 py-4 bg-white text-slate-900 rounded-xl font-bold hover:bg-slate-100 transition-colors flex items-center justify-center gap-2 border border-white/10">
                                        <i class="fa fa-user-plus"></i> Зарегистрироваться
                                    </a>
                                @endauth
                                <a href="{{ route('orders.feed') }}"
                                    class="px-8 py-4 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 hover:from-slate-50 hover:via-sky-50 hover:to-blue-100 text-white rounded-xl font-bold transition-all flex items-center justify-center gap-2 border border-blue-100">
                                    <i class="fa fa-search text-white"></i> Смотреть заказы
                                </a>
                            </div>
                        </div>
                    </section>

@endsection