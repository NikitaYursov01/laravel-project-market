<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="structure h-18 py-4 z-50">

    <!-- descktop version -->
    <div class="flex justify-between items-center" id="descktop">

        <!-- contetn 1 -->
        <div class="flex items-center gap-4">

            <div class="w-10 h-12 sm:w-12 sm:h-12 bg-blue-600 rounded-full flex items-center justify-center p-2">
                <img src="/src/logo/logo.svg" alt="Logo" loading="lazy" class="w-10 h-10">
            </div>
            <nav>
                <ul class="flex items-center gap-4">
                    <li class="li active"><a href="{{ route('main') }}">Главная</a></li>
                    @auth
                        {{-- Меню для менеджера --}}
                        @if(auth()->user()->role === 'manager')
                            <li class="li"><a href="{{ route('orders.feed') }}">Все объявления</a></li>
                            <li class="li"><a href="{{ route('performers.index') }}">Исполнители</a></li>
                            <li class="li"><a href="{{ route('chats.index') }}">Все чаты</a></li>
                            <li class="li"><a href="#">Клиенты</a></li>
                            <li class="li"><a href="#">Жалобы</a></li>
                        @else
                            {{-- Меню для клиента/исполнителя --}}
                            <li class="li"><a href="{{ route('profile') }}">Профиль</a></li>
                            <li class="li"><a href="{{ route('orders.feed') }}">Объявления</a></li>
                            <li class="li"><a href="{{ route('chats.index') }}">Чаты</a></li>
                            <li class="li"><a href="{{ route('orders.my') }}">Заказы</a></li>
                        @endif
                    @else
                        {{-- Меню для гостей --}}
                        <li class="li"><a href="{{ route('orders.feed') }}">Объявления</a></li>
                        <li class="li"><a href="{{ route('performers.index') }}">Исполнители</a></li>
                    @endauth
                </ul>
            </nav>
        </div>

        <!-- contetn 2 -->
        <div class="relative flex items-center gap-4">

            <!-- notification -->
            @auth
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    $recentNotifications = auth()->user()->notifications()->take(5)->get();
                @endphp
                <li class="li relative cursor-pointer list-none flex items-center justify-center gap-2"
                    data-menu="notification">
                    <div class="menu-trigger relative">
                        <i class="fa fa-bell text-xl"></i>
                        @if($unreadCount > 0)
                            <span id="notification-badge"
                                class="absolute -top-2 -right-2 bg-red-500 rounded-full w-5 h-5 text-xs text-center flex items-center justify-center font-bold text-white">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </div>
                    <nav>
                        <ul
                            class="absolute bg-white text-black w-96 rounded-lg p-4 py-2 flex flex-col gap-2 opacity-0 menu-dropdown right-0 shadow-lg border border-gray-200 z-50">
                            <li class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-semibold">Уведомления</span>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifications.markAllRead') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">Отметить все прочитанными</button>
                                    </form>
                                @endif
                            </li>
                            
                            @forelse($recentNotifications as $notification)
                                <li class="cursor-pointer menu-li hover:bg-gray-50 rounded-lg p-2 {{ $notification->isRead() ? 'opacity-60' : 'bg-blue-50' }}"
                                    data-menu-item="notification">
                                    <div class="flex justify-between items-start gap-2">
                                        <a href="{{ $notification->link ?? '#' }}" class="flex-1" onclick="markNotificationRead({{ $notification->id }})">
                                            <div class="flex items-start gap-2">
                                                <div class="w-8 h-8 rounded-full {{ $notification->is_important ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center flex-shrink-0">
                                                    <i class="fa fa-{{ $notification->type === 'order_created' ? 'shopping-cart' : ($notification->type === 'chat_message' ? 'comment' : ($notification->type === 'order_closed' ? 'check-circle' : 'info')) }}"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium truncate">{{ $notification->title }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($notification->message, 50) }}</p>
                                                    <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 p-1" title="Удалить">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li class="py-8 text-center text-gray-400">
                                    <i class="fa fa-bell-slash text-3xl mb-2"></i>
                                    <p class="text-sm">Нет уведомлений</p>
                                </li>
                            @endforelse
                            
                            <li class="border-t border-gray-100 pt-2">
                                <a href="{{ route('notifications.index') }}" class="text-center block text-blue-600 hover:text-blue-800 text-sm py-2">
                                    Все уведомления →
                                </a>
                            </li>
                        </ul>
                    </nav>
                </li>
            @endauth

            @auth
                {{-- Быстрая кнопка создания --}}
                <a href="{{ route('orders.create') }}"
                    class="li text-white relative cursor-pointer list-none flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 transition rounded-xl px-4 py-2">
                    <i class="fa fa-plus"></i> Создать
                </a>
            @else
                <!-- Вход/Регистрация для неавторизованных -->
                <a href="{{ route('login.form') }}"
                    class="li relative cursor-pointer list-none flex items-center justify-center gap-2 text-gray-700 hover:text-blue-600 transition">
                    <i class="fa fa-sign-in"></i> Войти
                </a>
                <a href="{{ route('register.form') }}">
                    <li
                        class="li text-white relative cursor-pointer list-none flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 transition rounded-xl px-4 py-2">
                        <i class="fa fa-user-plus"></i> Регистрация
                    </li>
                </a>
            @endauth

            <!-- burger -->
            @auth
                <li class="li relative cursor-pointer list-none" data-menu="burger">
                    <ul class="menu-trigger flex flex-col gap-2 haburger-list">
                        <li class="w-10 h-px bg-black haburger-1 transition-all duration-500"></li>
                        <li class="w-10 h-px bg-black haburger-2 transition-all duration-500"></li>
                        <li class="w-10 h-px bg-black haburger-3 transition-all duration-500"></li>
                    </ul>
                    <nav>
                        <ul
                            class="absolute bg-white text-black w-[250px] rounded-lg p-4 py-2 flex flex-col gap-2 opacity-0 menu-dropdown right-0">
                            <li class="cursor-pointer menu-li bg-red-200/50 hover:bg-red-300/50 hover:text-black flex justify-between items-center"
                                data-menu-item="burger" onclick="document.getElementById('logout-form').submit();">Выйти <i
                                    class="fa fa-door-open text-red-400"></i></li>
                        </ul>
                    </nav>
                </li>
            @endauth
        </div>
    </div>

    <!-- Mobile version -->
    <!-- Mobile version -->
    <div class="justify-between items-center gap-2 px-1" id="mobile">

        <!-- left -->
        <a href="{{ route('main') }}" class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center p-2 shadow-sm">
                <img src="/src/logo/logo.svg" alt="Logo" loading="lazy" class="w-full h-full object-contain">
            </div>
        </a>

        <!-- right -->
        <div class="relative flex items-center gap-2">

            <div class="relative" data-menu="mobileburger">
                <button type="button"
                    class="menu-trigger w-10 h-10 rounded-xl border border-gray-200 bg-white/70 flex items-center justify-center text-black shadow-sm">
                    <i class="fa fa-bars text-[22px] transition-transform duration-300"></i>
                </button>

                <nav>
                    <ul
                        class="absolute right-0 top-[calc(100%+10px)] w-[min(320px,calc(100vw-16px))] bg-white/95 backdrop-blur rounded-3xl p-3 flex flex-col gap-2 opacity-0 menu-dropdown shadow-[0_16px_40px_rgba(0,0,0,0.12)] border border-white/70 z-[60]">

                        <li class="px-2 pt-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                            Меню
                        </li>

                        <li><a href="{{ route('main') }}" class="mobile-menu-link">Главная</a></li>

                        @auth
                            @if(auth()->user()->role === 'manager')
                                {{-- Меню для менеджера --}}
                                <li class="border-t border-gray-100 mt-1 pt-2">
                                    <span class="px-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                        Административная панель
                                    </span>
                                </li>
                                <li><a href="{{ route('profile') }}" class="mobile-menu-link">Профиль</a></li>
                                <li><a href="{{ route('orders.feed') }}" class="mobile-menu-link">Все объявления</a></li>
                                <li><a href="{{ route('performers.index') }}" class="mobile-menu-link">Исполнители</a></li>
                                <li><a href="{{ route('chats.index') }}" class="mobile-menu-link">Все чаты</a></li>
                                <li><a href="#" class="mobile-menu-link">Клиенты</a></li>
                                <li><a href="#" class="mobile-menu-link">Жалобы / Конфликты</a></li>
                            @else
                                {{-- Меню для клиента/исполнителя --}}
                                <li class="border-t border-gray-100 mt-1 pt-2">
                                    <span class="px-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                        Личный кабинет
                                    </span>
                                </li>
                                <li><a href="{{ route('profile') }}" class="mobile-menu-link">Профиль</a></li>
                                <li><a href="{{ route('orders.feed') }}" class="mobile-menu-link">Объявления</a></li>
                                <li><a href="{{ route('messages.index') }}" class="mobile-menu-link">Чаты</a></li>
                                <li><a href="{{ route('orders.my') }}" class="mobile-menu-link">Мои заказы</a></li>
                                <li><a href="{{ route('orders.create') }}" class="mobile-menu-link">Создать заказ</a></li>
                            @endif

                            <li class="mt-1 pt-2 border-t border-gray-100">
                                <button type="button"
                                    class="mobile-menu-link mobile-menu-link--danger w-full text-left flex justify-between items-center"
                                    onclick="document.getElementById('logout-form').submit();">
                                    Выйти
                                    <i class="fa fa-door-open text-red-400"></i>
                                </button>
                            </li>
                        @else
                            <li class="border-t border-gray-100 mt-1 pt-2">
                                <span class="px-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                                    Аккаунт
                                </span>
                            </li>

                            <li><a href="{{ route('login.form') }}" class="mobile-menu-link">Войти</a></li>
                            <li><a href="{{ route('register.form') }}" class="mobile-menu-link">Регистрация</a></li>
                        @endauth

                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const activeClass = 'li-active';

        // Универсальная функция для анимации меню
        function animateMenuTrigger(trigger, isOpen) {
            // Анимация иконки (только для стрелок, не для колокольчика)
            const icon = trigger.querySelector('i');
            if (icon && icon.classList.contains('fa-angle-down')) {
                icon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }

            // Анимация бургера
            const haburger1 = trigger.querySelector('.haburger-1');
            const haburger2 = trigger.querySelector('.haburger-2');
            const haburger3 = trigger.querySelector('.haburger-3');
            if (haburger1 && haburger2 && haburger3) {
                if (isOpen) {
                    // Превращаем бургер в крестик
                    haburger1.classList.remove('w-10');
                    haburger1.classList.add('w-0');
                    setTimeout(() => {
                        haburger1.classList.remove('w-0');
                        haburger1.classList.add('w-10');

                        setTimeout(() => {
                            haburger1.classList.remove('h-px');
                            haburger1.classList.add('h-10');
                            setTimeout(() => {
                                haburger1.classList.add('flex', 'justify-center', 'items-center');
                                haburger1.innerHTML = '<i class="fa fa-times text-white"></i>';
                            }, 200);
                        }, 200);
                    }, 500);
                    haburger2.classList.add('opacity-0', 'absolute');
                    haburger3.classList.add('opacity-0', 'absolute');
                } else {

                    setTimeout(() => {
                        haburger1.classList.remove('w-0');
                        haburger1.classList.add('w-10');
                        setTimeout(() => {
                            haburger1.classList.remove('h-10');
                            haburger1.classList.add('h-px');
                            setTimeout(() => {
                                haburger1.classList.remove('flex', 'justify-center', 'items-center');
                                haburger1.innerHTML = '';
                                haburger2.classList.remove('opacity-0', 'absolute');
                                haburger3.classList.remove('opacity-0', 'absolute');
                            }, 200);
                        }, 200);
                    }, 500);
                }
            }
        }

        // Закрыть все меню кроме указанного и сбросить анимации
        function closeAllMenusExcept(exceptDropdown) {
            document.querySelectorAll('.menu-dropdown').forEach(d => {
                if (d !== exceptDropdown) {
                    d.classList.remove(activeClass);
                    const trigger = d.closest('[data-menu]').querySelector('.menu-trigger');
                    animateMenuTrigger(trigger, false);
                }
            });
        }

        // Закрыть все меню и сбросить анимации
        function closeAllMenus() {
            document.querySelectorAll('.menu-dropdown').forEach(d => {
                d.classList.remove(activeClass);
                const trigger = d.closest('[data-menu]').querySelector('.menu-trigger');
                animateMenuTrigger(trigger, false);
            });
        }

        // Находим все меню
        document.querySelectorAll('[data-menu]').forEach(menu => {
            const trigger = menu.querySelector('.menu-trigger');
            const dropdown = menu.querySelector('.menu-dropdown');

            if (!trigger || !dropdown) return;

            // Восстанавливаем сохраненное значение
            const saved = localStorage.getItem('menu_' + menu.dataset.menu);
            if (saved) trigger.innerHTML = saved + `<i class="fa fa-angle-down text-black" style="transition: transform 0.3s ease;"></i>`;

            // Клик по триггеру
            trigger.addEventListener('click', function (e) {
                e.stopPropagation();

                // Закрываем другие меню
                closeAllMenusExcept(dropdown);

                // Переключаем текущее
                dropdown.classList.toggle(activeClass);

                // Анимируем текущий триггер
                animateMenuTrigger(trigger, dropdown.classList.contains(activeClass));

            });
        });

        // Закрыть меню при клике на любую ссылку внутри меню
        document.querySelectorAll('.menu-dropdown a').forEach(link => {
            link.addEventListener('click', function () {
                closeAllMenus();
            });
        });

        // Глобальный клик
        document.addEventListener('click', function (e) {
            // Клик по элементу меню с data-menu-item
            if (e.target.dataset.menuItem) {
                const menuId = e.target.dataset.menuItem;
                const menu = document.querySelector(`[data-menu="${menuId}"]`);
                const trigger = menu?.querySelector('.menu-trigger');
                const value = e.target.dataset.value;
                const href = e.target.dataset.href;

                // Обновляем текст если есть value
                if (value && trigger) {
                    trigger.innerHTML = value + `<i class="fa fa-angle-down text-black" style="transition: transform 0.3s ease;"></i>`;
                    localStorage.setItem('menu_' + menuId, value);
                }

                // Переходим по ссылке
                if (href) window.location.href = href;

                // Закрываем меню
                closeAllMenus();
            }

            // Клик вне меню - закрыть все меню
            if (!e.target.closest('[data-menu]') && !e.target.classList.contains('menu-trigger')) {
                closeAllMenus();
            }
        });

        // Logout function
        function logout() {
            document.getElementById('logout-form').submit();
        }

        // Отметить уведомление как прочитанное
        function markNotificationRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json',
                }
            }).then(() => {
                // Обновляем бейдж
                const badge = document.getElementById('notification-badge');
                if (badge) {
                    const count = parseInt(badge.textContent) - 1;
                    if (count <= 0) {
                        badge.remove();
                    } else {
                        badge.textContent = count;
                    }
                }
            });
        }

        // Обновление счетчика уведомлений каждые 30 секунд
        setInterval(() => {
            fetch('{{ route("notifications.unreadCount") }}')
                .then(r => r.json())
                .then(data => {
                    let badge = document.getElementById('notification-badge');
                    if (data.count > 0) {
                        if (!badge) {
                            const menuTrigger = document.querySelector('[data-menu="notification"] .menu-trigger');
                            if (menuTrigger) {
                                badge = document.createElement('span');
                                badge.id = 'notification-badge';
                                badge.className = 'absolute -top-2 -right-2 bg-red-500 rounded-full w-5 h-5 text-xs text-center flex items-center justify-center font-bold text-white';
                                menuTrigger.appendChild(badge);
                            }
                        }
                        if (badge) badge.textContent = data.count;
                    } else if (badge) {
                        badge.remove();
                    }
                });
        }, 30000);
    });
</script>