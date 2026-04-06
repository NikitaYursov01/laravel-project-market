@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Мои заказы</h2>
        
        <p class="text-gray-600 mb-6">Управление вашими активными и завершенными заказами.</p>

        <!-- Табы -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button class="py-2 px-1 border-b-2 border-blue-500 font-medium text-blue-600">
                    Активные (3)
                </button>
                <button class="py-2 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    В работе (2)
                </button>
                <button class="py-2 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Завершенные (12)
                </button>
            </nav>
        </div>

        <!-- Список заказов -->
        <div class="space-y-4">
            <!-- Активный заказ 1 -->
            <div class="border rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 1) }}" class="text-blue-600 hover:text-blue-800">
                                Разработка лендинга для компании
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Программирование</span>
                            <span>📅 Создан: 10.04.2024</span>
                            <span>⏰ Дедлайн: 25.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">10 000 ₽</div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Активный</span>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Создание сайта для продвижения услуг компании. Нужен современный дизайн, адаптивная верстка, форма обратной связи, SEO-оптимизация.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Откликов:</span> 5
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Просмотров:</span> 45
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Просмотреть отклики
                        </button>
                        <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                            Редактировать
                        </button>
                    </div>
                </div>
            </div>

            <!-- Активный заказ 2 -->
            <div class="border rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 2) }}" class="text-blue-600 hover:text-blue-800">
                                Дизайн логотипа для бренда
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Дизайн</span>
                            <span>📅 Создан: 12.04.2024</span>
                            <span>⏰ Дедлайн: 20.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">5 000 ₽</div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Активный</span>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Разработка уникального логотипа для нового бренда. Нужны 3 концепции, векторные исходники, руководство по стилю.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Откликов:</span> 8
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Просмотров:</span> 32
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Просмотреть отклики
                        </button>
                        <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                            Редактировать
                        </button>
                    </div>
                </div>
            </div>

            <!-- Активный заказ 3 -->
            <div class="border rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('orders.detail', 3) }}" class="text-blue-600 hover:text-blue-800">
                                Написание статей для блога
                            </a>
                        </h3>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Копирайтинг</span>
                            <span>📅 Создан: 14.04.2024</span>
                            <span>⏰ Дедлайн: 30.04.2024</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-blue-600 mb-2">6 000 ₽</div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Активный</span>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">
                    Написание 5 SEO-оптимизированных статей для корпоративного блога на темы маркетинга и продаж.
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Откликов:</span> 3
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Просмотров:</span> 18
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Просмотреть отклики
                        </button>
                        <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                            Редактировать
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Статистика -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Статистика заказов</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">3</div>
                    <div class="text-gray-600">Активных</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">2</div>
                    <div class="text-gray-600">В работе</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">12</div>
                    <div class="text-gray-600">Завершено</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">23 000 ₽</div>
                    <div class="text-gray-600">Потрачено</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
