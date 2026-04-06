@extends('layouts.app')

@section('title', 'Лента заказов')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Лента заказов</h2>
        
        <p class="text-gray-600 mb-6">Здесь будут отображаться доступные заказы от других пользователей.</p>
        
        <!-- Фильтры -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Все категории</option>
                        <option>Программирование</option>
                        <option>Дизайн</option>
                        <option>Маркетинг</option>
                        <option>Копирайтинг</option>
                        <option>Другое</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Бюджет</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Любой бюджет</option>
                        <option>До 5 000 ₽</option>
                        <option>5 000 - 15 000 ₽</option>
                        <option>15 000 - 30 000 ₽</option>
                        <option>Более 30 000 ₽</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Срок</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Любой срок</option>
                        <option>Срочно (до 3 дней)</option>
                        <option>Средний (3-7 дней)</option>
                        <option>Долгий (более 7 дней)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Применить фильтры
                    </button>
                </div>
            </div>
        </div>

        <!-- Список заказов -->
        <div class="space-y-4">
            <!-- Заказ 1 -->
            <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 1) }}" class="text-blue-600 hover:text-blue-800">
                                Нужен сайт для небольшого бизнеса
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Программирование</span>
                            <span>📍 Москва</span>
                            <span>📅 До 15.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">5 000 ₽</div>
                        <div class="text-sm text-gray-500">2 часа назад</div>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Требуется создать лендинг для компании по оказанию услуг. Нужен современный дизайн, адаптивная верстка, форма обратной связи. Предпочтительно использовать React или Vue.js.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <span class="text-sm text-gray-600">Иван П.</span>
                        <span class="text-yellow-500 text-sm">★ 4.8</span>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Откликнуться
                    </button>
                </div>
            </div>

            <!-- Заказ 2 -->
            <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 2) }}" class="text-blue-600 hover:text-blue-800">
                                Требуется дизайн логотипа для стартапа
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Дизайн</span>
                            <span>📍 Удаленно</span>
                            <span>📅 До 20.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">3 000 ₽</div>
                        <div class="text-sm text-gray-500">5 часов назад</div>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Ищем дизайнера для создания уникального логотипа для IT стартапа. Нужны 3 варианта, векторная графика, исходники. Стиль - минималистичный, современный.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <span class="text-sm text-gray-600">Анна С.</span>
                        <span class="text-yellow-500 text-sm">★ 4.9</span>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Откликнуться
                    </button>
                </div>
            </div>

            <!-- Заказ 3 -->
            <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 3) }}" class="text-blue-600 hover:text-blue-800">
                                Написать статьи для блога о технологиях
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Копирайтинг</span>
                            <span>📍 Удаленно</span>
                            <span>📅 До 25.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">8 000 ₽</div>
                        <div class="text-sm text-gray-500">1 день назад</div>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Нужно написать 5 статей для технического блога. Темы: искусственный интеллект, блокчейн, кибербезопасность. Объем 2000-3000 символов каждая. SEO-оптимизация.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <span class="text-sm text-gray-600">Михаил К.</span>
                        <span class="text-yellow-500 text-sm">★ 4.7</span>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Откликнуться
                    </button>
                </div>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="mt-8 flex justify-center">
            <nav class="flex space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">←</button>
                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg">1</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">→</button>
            </nav>
        </div>
    </div>
</div>
@endsection
