<header x-data="{ mobileMenu: false, profileOpen: false, notifOpen: false, searchOpen: false }" 
    class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('main') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="p-2 w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center">
                    <img src="/src/logo/logo.svg" alt="Logo">
                </div>
                <span class="font-bold text-xl text-gray-900 tracking-tight">DetailDeal</span>
            </a>
            
            <!-- Search Bar - Pill style with icon -->
            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <form action="{{ route('orders.feed') }}" method="GET" class="w-full relative">
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" name="q" placeholder="Поиск заказов и исполнителей..." 
                            class="w-full pl-11 pr-4 py-2.5 bg-gray-100 border border-transparent rounded-full text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                    </div>
                </form>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-0.5">
                <a href="{{ route('main') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors {{ request()->routeIs('main') ? 'text-blue-700 bg-blue-50' : '' }}">
                    Главная
                </a>
                <a href="{{ route('orders.feed') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors {{ request()->routeIs('orders.feed') && !request('type') ? 'text-blue-700 bg-blue-50' : '' }}">
                    Заказы
                </a>
                <a href="{{ route('orders.feed', ['type' => 'performer_service']) }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors {{ request()->routeIs('orders.feed') && request('type') === 'performer_service' ? 'text-blue-700 bg-blue-50' : '' }}">
                    Исполнители
                </a>
                <a href="{{ route('help') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors {{ request()->routeIs('help') ? 'text-blue-700 bg-blue-50' : '' }}">
                    Помощь
                </a>
            </nav>
            
            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <!-- Mobile Search Toggle -->
                <button @click="searchOpen = !searchOpen" class="md:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fa fa-search"></i>
                </button>
                
                @auth
                    <!-- Notifications -->
                    <div class="relative">
                        <button @click="notifOpen = !notifOpen; profileOpen = false" 
                            class="relative p-2 text-gray-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-colors">
                            <i class="fa fa-bell"></i>
                            @php
                                $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div x-show="notifOpen" 
                            @click.away="notifOpen = false"
                            x-transition
                            class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden"
                            style="display: none;">
                            <div class="p-4 border-b border-gray-100">
                                <span class="font-semibold text-gray-900">Уведомления</span>
                            </div>
                            @php
                                $notifications = auth()->user()->notifications()->latest()->limit(5)->get();
                            @endphp
                            @if($notifications->count() > 0)
                                <div class="max-h-72 overflow-y-auto">
                                    @foreach($notifications as $notification)
                                        <a href="{{ route('notifications.index') }}" 
                                            class="block p-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 {{ $notification->is_read ? '' : 'bg-blue-50/50' }}">
                                            <p class="text-sm text-gray-800 {{ $notification->is_read ? '' : 'font-medium' }}">
                                                {{ $notification->title }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="p-3 border-t border-gray-100 bg-gray-50">
                                    <a href="{{ route('notifications.index') }}" class="block text-center text-sm text-blue-700 hover:text-blue-800 font-medium">
                                        Все уведомления
                                    </a>
                                </div>
                            @else
                                <div class="p-8 text-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fa fa-bell-slash text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-500">Нет уведомлений</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Create Order Button -->
                    <a href="{{ route('orders.create') }}" class="hidden sm:flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium text-sm transition-colors">
                        Создать
                    </a>
                    
                    <!-- Profile Icon Button with Dropdown -->
                    <div class="relative ml-1">
                        <button @click="profileOpen = !profileOpen; notifOpen = false"
                            class="flex items-center justify-center w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors">
                            <i class="fa fa-user-circle text-gray-600 text-lg"></i>
                        </button>
                        
                        <!-- Profile Dropdown Menu -->
                        <div x-show="profileOpen"
                            @click.away="profileOpen = false"
                            x-transition
                            class="absolute right-0 top-full mt-2 w-56 bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden"
                            style="display: none;">
                            <!-- User Info Header -->
                            <div class="p-4 border-b border-gray-100 bg-gray-50">
                                <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="p-2">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors">
                                    <i class="fa fa-user text-gray-400 w-5"></i>
                                    Профиль
                                </a>
                                <a href="{{ route('orders.my') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors">
                                    <i class="fa fa-list-alt text-gray-400 w-5"></i>
                                    Мои объявления
                                </a>
                                <a href="{{ route('chats.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors">
                                    <i class="fa fa-comments text-gray-400 w-5"></i>
                                    Сообщения
                                </a>
                                <a href="{{ route('orders.create') }}" class="sm:hidden flex items-center gap-3 px-3 py-2.5 text-sm text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fa fa-plus-circle text-blue-600 w-5"></i>
                                    Создать заказ
                                </a>
                                <a href="{{ route('help') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors">
                                    <i class="fa fa-question-circle text-gray-400 w-5"></i>
                                    Помощь
                                </a>
                            </div>
                            
                            <!-- Settings & Logout -->
                            <div class="p-2 border-t border-gray-100">
                                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                    <i class="fa fa-cog text-gray-400 w-5"></i>
                                    Настройки
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors w-full">
                                        <i class="fa fa-sign-out text-red-500 w-5"></i>
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login.form') }}" class="hidden sm:block px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Войти
                    </a>
                    <a href="{{ route('register.form') }}" class="px-4 py-2 bg-blue-700 text-white rounded-xl font-medium text-sm transition-colors hover:bg-blue-800">
                        Регистрация
                    </a>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search -->
        <div x-show="searchOpen" class="md:hidden py-3 border-t border-gray-100" style="display: none;">
            <form action="{{ route('orders.feed') }}" method="GET" class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search"></i>
                </div>
                <input type="text" name="q" placeholder="Поиск..." 
                    class="w-full pl-11 pr-4 py-2.5 bg-gray-100 border border-transparent rounded-full text-sm focus:ring-2 focus:ring-blue-600">
            </form>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenu"
        @click.away="mobileMenu = false"
        x-transition
        class="lg:hidden bg-white border-t border-gray-200"
        style="display: none;">
        <div class="max-w-7xl mx-auto px-4 py-3 space-y-1">
            <a href="{{ route('main') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('main') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                <i class="fa fa-home w-5 text-center"></i>
                Главная
            </a>
            <a href="{{ route('orders.feed') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('orders.feed') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                <i class="fa fa-search w-5 text-center"></i>
                Заказы
            </a>
            <a href="{{ route('orders.feed', ['type' => 'performer_service']) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fa fa-users w-5 text-center"></i>
                Исполнители
            </a>
            <a href="{{ route('help') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('help') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                <i class="fa fa-question-circle w-5 text-center"></i>
                Помощь
            </a>
            @auth
                <div class="border-t border-gray-200 pt-3 mt-3 space-y-1">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fa fa-user w-5 text-center"></i>
                        Профиль
                    </a>
                    <a href="{{ route('orders.my') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fa fa-list-alt w-5 text-center"></i>
                        Мои объявления
                    </a>
                    <a href="{{ route('chats.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fa fa-comments w-5 text-center"></i>
                        Сообщения
                    </a>
                    <a href="{{ route('orders.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 text-blue-800 rounded-lg font-medium transition-all border border-blue-100 mt-2">
                        <i class="fa fa-plus-circle w-5 text-center text-blue-700"></i>
                        Создать заказ
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
<div class="h-16"></div>
