@extends('componet.shablon')

<!-- HEAD ADD CONTENT -->
@section('title', 'Личный кабинет')
@section('description', 'Личный кабинет пользователя на платформе')

<!-- BODY CONTENT -->
@section('content')
    @include('componet/content.header')
        @use(App\Services\Functions)
        @auth
            <div class="min-h-screen">

                <!-- structure - содережание по контейнеру  -->
                <div class="flex justify-between items-start structure px-4 sm:px-0 py-[40px] gap-10">

                    <aside class="flex w-full justify-start items-start max-w-[400px] flex-col">

                        <h4 class="title-h4">Мой профиль</h4>
                        <nav class="w-full">
                            <ul class="flex flex-col gap-1 justify-start items-center">
                                <li data-toggle-section="main"
                                    class="block font-semibold font-sans cursor-pointer w-full p-3.5 profile_li profile_active hover:bg-blue-400/10 transition">
                                    Мой профиль
                                </li>
                                <li data-toggle-section="data"
                                    class="block font-semibold font-sans cursor-pointer w-full p-3.5 profile_li hover:bg-blue-400/10 transition">
                                    Личные данные
                                </li>
                                <li data-toggle-section="orders"
                                    class="block font-semibold font-sans cursor-pointer w-full p-3.5 profile_li hover:bg-blue-400/10 transition">
                                    Мои объявления <span
                                        class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">{{ $userOrders->count() }}</span>
                                </li>
                            </ul>
                        </nav>

                    </aside>

                    <section class="flex-1 flex flex-col gap-2">

                        <!-- block 1 -->
                        <div data-section="main" class="bg-white rounded-xl mb-6"
                            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
                            <div class="p-5 pb-2">
                                <div class="flex items-center gap-4 mb-4">
                                    <img class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center"
                                        src="/src/tester/profile/avatar/avatar.webp">
                                    </img>
                                    <div>
                                        <h3 class="text-xl font-semibold">{{ Auth::user()->name }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-medium {{ Auth::user()->getRoleColor() }}">
                                                {{ Auth::user()->getRoleLabel() }}
                                            </span>
                                            @if(Auth::user()->isPerformer())
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs">
                                                    <i class="fa fa-check mr-1"></i>Принимает заказы
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-[#e8e8f4] h-px">
                            <div class="p-5 flex items-center gap-2">
                                <i class="fa fa-solid fa-check-circle text-green-500"></i>
                                <p class="text-green-600">Email подтвержден</p>
                            </div>
                        </div>

                        <!-- block 2 -->
                        <div data-section="data" class="bg-white rounded-xl mb-6"
                            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
                            <div class="p-5 pb-2">

                                @if(session('success'))
                                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                                        <ul class="list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Имя</label>
                                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                            class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Email</label>
                                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                                            class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Новый пароль
                                            (оставьте пустым, если не хотите менять)</label>
                                        <input type="password" name="password" id="password" value=""
                                            class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 ui_3Oq5V">Подтверждение пароля</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" value=""
                                            class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit"
                                            class="profile_btn w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                                            Сохранить
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>


                        <!-- block 3 - Мои объявления -->
                        <div data-section="orders" class="bg-white rounded-xl mb-6 hidden"
                            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
                            <div class="p-5 pb-2">
                                <h3 class="text-xl font-semibold mb-4">Мои объявления</h3>

                                @if($userOrders->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($userOrders as $order)
                                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                                <div class="flex justify-between items-start gap-4 mb-3">
                                                    <div>
                                                        <h4 class="font-semibold text-lg mb-1">
                                                            <a href="{{ route('orders.detail', $order->id) }}"
                                                                class="text-blue-600 hover:text-blue-800">
                                                                {{ $order->title }}
                                                            </a>
                                                        </h4>
                                                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                                                            <span
                                                                class="{{ Functions::getCategoryColor($order->category) }} px-2 py-1 rounded text-xs">
                                                                {{ Functions::getCategoryName($order->category) }}
                                                            </span>
                                                            <span>📅 {{ Functions::formatDate($order->completion_date) }}</span>
                                                            <span
                                                                class="px-2 py-1 rounded text-xs {{ $order->status === 'active' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                                {{ $order->status === 'active' ? 'Активный' : 'Завершен' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-lg font-bold text-blue-600">
                                                            {{ Functions::formatBudget($order->budget) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $order->description }}</p>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('orders.detail', $order->id) }}"
                                                        class="text-blue-600 hover:text-blue-800 text-sm">Подробнее</a>
                                                    @if($order->status === 'active')
                                                        <span class="text-gray-400">|</span>
                                                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm">Редактировать</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div class="text-5xl mb-3">📭</div>
                                        <p class="text-gray-600 mb-4">У вас пока нет объявлений</p>
                                        <a href="{{ route('orders.create') }}"
                                            class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                            Создать объявление
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </section>

                </div>

                <script>
                    document.querySelectorAll('[data-toggle-section]').forEach(button => {
                        button.addEventListener('click', function () {

                            document.querySelectorAll('[data-toggle-section]').forEach(button => {
                                button.classList.remove('profile_active');
                            });
                            button.classList.add('profile_active');

                            var sectionId = button.getAttribute('data-toggle-section');
                            // Скрыть все секции с плавным исчезновением
                            document.querySelectorAll('[data-section]').forEach(section => {
                                //анимации исчезнавения
                                section.style.transition = 'opacity 0.3s';
                                section.style.opacity = 0;
                                setTimeout(function () {
                                    section.classList.add('hidden');
                                }, 300);
                            });
                            // Показать выбранную секцию с плавным появлением
                            var targetSection = document.querySelector('[data-section="' + sectionId + '"]');
                            if (targetSection) {
                                // Сначала убираем класс hidden, выставляем прозрачность
                                setTimeout(function () {
                                    targetSection.classList.remove('hidden');
                                    targetSection.style.transition = 'opacity 0.3s';
                                    targetSection.style.opacity = 0;
                                    // Затем заставляем браузер "увидеть" 0, и только потом плавно делаем 1
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