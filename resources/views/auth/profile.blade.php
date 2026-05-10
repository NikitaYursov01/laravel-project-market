@extends('componet.shablon')

@section('title', 'Профиль — ' . Auth::user()->name)
@section('description', 'Личный кабинет пользователя DetailDeal')

@section('content')
    @include('componet/content.header')
    @use(App\Services\Functions)
    @auth

        <div class="min-h-screen bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- Profile Header -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Avatar -->
                        <div class="relative">
                            <div
                                class="w-20 h-20 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <button
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full shadow-sm flex items-center justify-center text-gray-600 hover:text-blue-600 transition-colors border border-gray-200">
                                <i class="fa fa-camera text-xs"></i>
                            </button>
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">
                                    {{ Auth::user()->getRoleLabel() }}
                                </span>
                                @if(Auth::user()->isPerformer())
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-sm font-medium">
                                        <i class="fa fa-check mr-1"></i>Принимает заказы
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500">
                                    <i class="fa fa-envelope mr-1"></i>{{ Auth::user()->email }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="{{ route('orders.create') }}"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                <i class="fa fa-plus mr-1"></i>Создать заказ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Sidebar -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden sticky top-24">
                            <nav class="p-2">
                                <button data-toggle-section="main"
                                    class="profile-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium transition-all bg-gray-100 text-gray-900">
                                    <i class="fa fa-user w-5"></i>
                                    Профиль
                                </button>
                                <button data-toggle-section="orders"
                                    class="profile-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium text-gray-600 hover:bg-gray-50 transition-all">
                                    <i class="fa fa-shopping-bag w-5"></i>
                                    Мои объявления
                                    <span
                                        class="ml-auto px-2 py-0.5 bg-gray-100 text-gray-600 rounded-md text-xs">{{ $userOrders->count() }}</span>
                                </button>
                                <button data-toggle-section="settings"
                                    class="profile-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium text-gray-600 hover:bg-gray-50 transition-all">
                                    <i class="fa fa-cog w-5"></i>
                                    Настройки
                                </button>

                                {{-- Управление ролями (только для разрешенных email) --}}
                                @if(Auth::user()->canManageRoles())
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="{{ route('admin.roles') }}"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium text-red-600 hover:bg-red-50 transition-all">
                                        <i class="fa fa-shield w-5"></i>
                                        Управление ролями
                                        <span class="ml-auto px-2 py-0.5 bg-red-100 text-red-600 rounded-md text-xs">Admin</span>
                                    </a>
                                @endif

                                {{-- Управление чатами (для менеджеров и админов) --}}
                                @if(Auth::user()->isManager() || Auth::user()->isAdmin())
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <button data-toggle-section="admin-chats"
                                        class="profile-nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium text-amber-600 hover:bg-amber-50 transition-all">
                                        <i class="fa fa-comments w-5"></i>
                                        Управление чатами
                                        <span
                                            class="ml-auto px-2 py-0.5 bg-amber-100 text-amber-600 rounded-md text-xs">{{ \App\Models\Chat::whereNull('manager_id')->where('status', 'active')->count() }}</span>
                                    </button>
                                @endif

                                <div class="border-t border-gray-100 my-2"></div>
                                <button onclick="document.getElementById('logout-form').submit()"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left font-medium text-red-600 hover:bg-red-50 transition-all">
                                    <i class="fa fa-sign-out w-5"></i>
                                    Выйти
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="lg:col-span-9 space-y-6">

                        <!-- Profile Section -->
                        <div data-section="main" class="profile-section bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Личная информация</h2>

                            @if(session('success'))
                                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                                    <ul class="list-disc list-inside text-sm">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Имя</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            required>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 pt-6">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Сменить пароль</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Новый пароль</label>
                                            <input type="password" name="password"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                                placeholder="Оставьте пустым, если не меняете">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Подтвердите
                                                пароль</label>
                                            <input type="password" name="password_confirmation"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                                placeholder="Повторите новый пароль">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition-colors">
                                        Сохранить изменения
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Orders Section -->
                        <div data-section="orders"
                            class="profile-section hidden bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">Мои объявления</h2>
                                <a href="{{ route('orders.create') }}"
                                    class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                    <i class="fa fa-plus mr-1"></i>Создать
                                </a>
                            </div>

                            @if($userOrders->count() > 0)
                                <div class="space-y-4">
                                    @foreach($userOrders as $order)
                                        <div
                                            class="flex flex-col sm:flex-row gap-4 p-4 {{ $order->status === 'active' ? 'bg-gray-50 hover:bg-gray-100' : 'bg-red-50 hover:bg-red-100' }} rounded-lg transition-colors">
                                            <!-- Image -->
                                            <div class="w-full sm:w-24 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($order->images && $order->images->count() > 0)
                                                    <img src="{{ $order->images->first()->getUrl() }}" alt=""
                                                        class="w-full h-full object-cover" loading="lazy" decoding="async" width="150"
                                                        height="150">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fa fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span
                                                                class="px-2 py-0.5 {{ Functions::getCategoryColor($order->category) }} rounded text-xs">
                                                                {{ Functions::getCategoryName($order->category) }}
                                                            </span>
                                                            <span
                                                                class="px-2 py-0.5 {{ $order->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-gray-600' }} rounded text-xs">
                                                                {{ $order->status === 'active' ? 'Активный' : 'Завершен' }}
                                                            </span>
                                                        </div>
                                                        <h3 class="font-semibold text-gray-900 mb-1">
                                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                                class="hover:text-blue-700 transition-colors">
                                                                {{ $order->title }}
                                                            </a>
                                                        </h3>
                                                        <p class="text-sm text-gray-500 line-clamp-2">
                                                            {{ Str::limit($order->description, 100) }}
                                                        </p>
                                                    </div>
                                                    <span class="font-bold text-lg text-gray-900 whitespace-nowrap">
                                                        {{ Functions::formatBudget($order->budget) }}
                                                    </span>
                                                </div>

                                                <!-- Actions -->
                                                <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-200">
                                                    <a href="{{ route('orders.detail', $order->id) }}"
                                                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                                        Подробнее
                                                    </a>
                                                    @if($order->status === 'active')
                                                        <a href="{{ route('orders.edit', $order->id) }}"
                                                            class="text-sm text-gray-600 hover:text-gray-900">
                                                            Редактировать
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fa fa-shopping-bag text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">У вас пока нет объявлений</h3>
                                    <p class="text-gray-500 mb-6">Создайте свой первый заказ и найдите исполнителей</p>
                                    <a href="{{ route('orders.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                        <i class="fa fa-plus"></i>
                                        Создать объявление
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Settings Section -->
                        <div data-section="settings"
                            class="profile-section hidden bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Настройки уведомлений</h2>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Email уведомления</h3>
                                        <p class="text-sm text-gray-500">Получать уведомления на email о новых откликах</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Уведомления в браузере</h3>
                                        <p class="text-sm text-gray-500">Показывать push-уведомления</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Управление чатами (для менеджеров и админов) --}}
                        @if(Auth::user()->isManager() || Auth::user()->isAdmin())
                            @include('auth.admin-chats')
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('[data-toggle-section]').forEach(button => {
                button.addEventListener('click', function () {
                    // Remove active from all buttons
                    document.querySelectorAll('[data-toggle-section]').forEach(btn => {
                        btn.classList.remove('bg-primary-50', 'text-primary-700');
                        btn.classList.add('text-gray-600', 'hover:bg-gray-50');
                    });

                    // Add active to clicked button
                    this.classList.remove('text-gray-600', 'hover:bg-gray-50');
                    this.classList.add('bg-primary-50', 'text-primary-700');

                    // Hide all sections
                    var sectionId = this.getAttribute('data-toggle-section');
                    document.querySelectorAll('[data-section]').forEach(section => {
                        section.style.transition = 'opacity 0.3s';
                        section.style.opacity = 0;
                        setTimeout(function () {
                            section.classList.add('hidden');
                        }, 300);
                    });

                    // Show selected section
                    var targetSection = document.querySelector('[data-section="' + sectionId + '"]');
                    if (targetSection) {
                        setTimeout(function () {
                            targetSection.classList.remove('hidden');
                            targetSection.style.transition = 'opacity 0.3s';
                            targetSection.style.opacity = 0;
                            setTimeout(function () {
                                targetSection.style.opacity = 1;
                            }, 10);
                        }, 300);
                    }
                });
            });
        </script>

    @endauth
@endsection