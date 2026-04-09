<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Market') - Платформа для поиска исполнителей и размещения заказов</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-gray-900">
                        <a href="{{ route('main') }}" class="hover:text-blue-600">Market</a>
                    </h1>
                    <nav class="hidden md:flex space-x-6">
                        <a href="{{ route('orders.feed') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('orders.feed') ? 'text-blue-600 font-medium' : '' }}">Лента заказов</a>
                        <a href="{{ route('performers.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('performers.*') ? 'text-blue-600 font-medium' : '' }}">Исполнители</a>
                        <a href="{{ route('orders.my') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('orders.my') ? 'text-blue-600 font-medium' : '' }}">Мои заказы</a>
                        <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('messages.*') ? 'text-blue-600 font-medium' : '' }}">Сообщения</a>
                        <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('profile') ? 'text-blue-600 font-medium' : '' }}">Профиль</a>
                    </nav>
                </div>
                <button onclick="window.location.href='{{ route('orders.create') }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Создать заказ
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h4 class="font-semibold mb-4">О платформе</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white">О нас</a></li>
                        <li><a href="#" class="hover:text-white">Как это работает</a></li>
                        <li><a href="#" class="hover:text-white">Контакты</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Для исполнителей</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white">Стать исполнителем</a></li>
                        <li><a href="#" class="hover:text-white">Правила</a></li>
                        <li><a href="#" class="hover:text-white">Рейтинги</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Для заказчиков</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="{{ route('orders.create') }}" class="hover:text-white">Создать заказ</a></li>
                        <li><a href="#" class="hover:text-white">Безопасность</a></li>
                        <li><a href="#" class="hover:text-white">Поддержка</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Подписка</h4>
                    <p class="text-sm text-gray-300 mb-4">Получайте новости и обновления</p>
                    <form class="flex flex-col sm:flex-row gap-2 sm:gap-0">
                        <input
                            type="email"
                            placeholder="Email"
                            class="min-w-0 w-full bg-gray-700 text-white px-3 py-2 rounded-lg sm:rounded-l-lg sm:rounded-r-none outline-none focus:bg-gray-600"
                        >
                        <button
                            type="submit"
                            class="w-full sm:w-auto bg-blue-600 px-4 py-2 rounded-lg sm:rounded-r-lg sm:rounded-l-none hover:bg-blue-700 transition-colors"
                        >
                            →
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>© 2024 Market. Все права защищены.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
