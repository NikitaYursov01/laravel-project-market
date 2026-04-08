<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>

<div class="structure relative h-18 py-4 z-50">

  <!-- descktop version -->
  <div class="flex justify-between items-center" id="descktop">

    <!-- contetn 1 -->
    <div class="flex items-center gap-4">

      <div class="w-10 h-12 sm:w-12 sm:h-12 bg-blue-600 rounded-full flex items-center justify-center p-2">
        <img src="/src/logo/logo.svg" alt="Logo" loading="lazy" class="w-10 h-10">
      </div>
      <nav>
        <ul class="flex items-center gap-4">
          <li class="li active"><a href="/">Главная</a></li>
          <li class="li relative cursor-pointer flex items-center" data-menu="work">
            <!-- текст который будет менятся -->
            <p class="menu-trigger">Для бизнеса</p>
            <nav>
              <!-- меню -->
              <ul
                class="absolute bg-white text-black w-[150px] rounded-lg p-4 py-2 flex flex-col gap-2 opacity-0 menu-dropdown">
                <li class="cursor-pointer menu-li" data-menu-item="work" data-value="Для бизнеса" data-href="#">
                  Для
                  бизнеса</li>
                <li class="cursor-pointer menu-li" data-menu-item="work" data-value="Заказать" data-href="#">
                  Заказать
                </li>
                <li class="cursor-pointer menu-li" data-menu-item="work" data-value="Выставить" data-href="#">
                  Выставить
                </li>
              </ul>
            </nav>
          </li>
          <li class="li">Начать поиск</li>
          <li class="li">Помощь</li>
        </ul>
      </nav>
    </div>

    <!-- contetn 2 -->
    <div class="relative flex items-center gap-4">

      <!-- search -->
      <li class="li relative cursor-pointer list-none flex items-center justify-center gap-2">
        <i class="fa fa-search"></i> Поиск
      </li>

      <!-- notification -->
      <li class="li relative cursor-pointer list-none flex items-center justify-center gap-2" data-menu="notification">
        <div class="menu-trigger">
          <i class="fa fa-bell"></i>
          <!-- <span
            class="absolute bg-red-400 rounded-full w-3 h-3 p-2 -left-1 -bottom-1 text-[12px] text-center flex items-center justify-center font-bold text-white">
            1</span> -->
        </div>
        <nav>
          <ul
            class="absolute bg-white text-black w-[450px] rounded-lg p-4 py-2 flex flex-col gap-2 opacity-0 menu-dropdown right-0">
            <li class="cursor-pointer menu-li hover:bg-transparent hover:text-black" data-menu-item="notification"
              data-href="/">
              <div class="flex justify-between items-center gap-4">
                <i
                  class="border mr-4 border-solid text-black border-gray-200 p-4 w-[48px] h-[48px] rounded-xl flex items-center justify-center bg-gray-200 fa fa-info"></i>
                <p class="text-lg">Работодатели не знают ваш статус поиска<br><span class="text-blue-400">Узнать
                    статус</span></p>
                <i class="fa-solid fa-trash text-gray-200 text-xl"></i>
              </div>
            </li>
          </ul>
        </nav>
      </li>

      @auth
        <!-- search -->
        <a href="{{ route('profile') }}"><li
          class="li text-white relative cursor-pointer list-none flex items-center justify-center gap-2 bg-blue-500/50 hover:bg-blue-400/50 transition rounded-xl p-2">
          <i class="fa fa-user-circle"></i> Профиль
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
              <li
                class="cursor-pointer menu-li bg-red-200/50 hover:bg-red-300/50 hover:text-black flex justify-between items-center"
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

    <a href="{{ route('search') }}"
      class="w-10 h-10 rounded-xl border border-gray-200 bg-white/70 flex items-center justify-center text-black shadow-sm">
      <i class="fa fa-search"></i>
    </a>

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
          <li><a href="{{ route('orders.create') }}" class="mobile-menu-link">Заказать</a></li>
          <li><a href="{{ route('search') }}" class="mobile-menu-link">Начать поиск</a></li>
          <li><a href="{{ route('performers.index') }}" class="mobile-menu-link">Исполнители</a></li>
          <li><a href="#" class="mobile-menu-link">Помощь</a></li>

          @auth
            <li class="border-t border-gray-100 mt-1 pt-2">
              <span class="px-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">
                Профиль
              </span>
            </li>

            <li><a href="{{ route('profile') }}" class="mobile-menu-link">Профиль</a></li>
            <li><a href="{{ route('messages.index') }}" class="mobile-menu-link">Сообщения</a></li>
            <li><a href="{{ route('orders.my') }}" class="mobile-menu-link">Мои заказы</a></li>
            <li><a href="{{ route('orders.feed') }}" class="mobile-menu-link">Лента заказов</a></li>
            <li><a href="{{ route('service.create') }}" class="mobile-menu-link">Выставить услугу</a></li>

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
      // Анимация иконки
      const icon = trigger.querySelector('i');
      if (icon) {
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

        // Backdrop
        const backdrop = document.querySelector('.closebg');
        if (dropdown.classList.contains(activeClass)) {
          if (!backdrop) {
            const bg = document.createElement('div');
            bg.className = 'closebg fixed inset-0 z-0 w-full h-full';
            document.body.appendChild(bg);
          }
        } else {
          if (backdrop) backdrop.remove();
        }
      });
    });

    // Глобальный клик
    document.addEventListener('click', function (e) {
      // Клик по элементу меню
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
        const backdrop = document.querySelector('.closebg');
        if (backdrop) backdrop.remove();
      }

      // Клик по backdrop
      if (e.target.classList.contains('closebg')) {
        closeAllMenus();
        e.target.remove();
      }
    });

    // Logout function
    function logout() {
      document.getElementById('logout-form').submit();
    }
  });
</script>
