@extends('layouts.app')

@section('title', 'Детали заказа')

@section('content')
<div class="max-w-6xl mx-auto px-3 sm:px-4 py-5 sm:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8">
        <!-- Основная информация -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-5 sm:mb-6">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 leading-snug">
                            Разработка лендинга для компании
                        </h1>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Программирование</span>
                            <span>📅 Опубликовано: 10.04.2024</span>
                            <span>⏰ Дедлайн: 25.04.2024</span>
                        </div>
                    </div>
                    <div class="text-left lg:text-right">
                        <div class="text-2xl sm:text-3xl font-bold text-blue-600 mb-2">10 000 ₽</div>
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs sm:text-sm">Активный</span>
                    </div>
                </div>

                <!-- Описание -->
                <div class="mb-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3">Описание заказа</h3>

                    <div class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-relaxed">
                        <p class="mb-4">
                            Требуется создать современный лендинг для компании по оказанию консалтинговых услуг.
                            Сайт должен быть адаптивным, быстрым, с SEO-оптимизацией.
                        </p>

                        <strong class="block mb-2 text-gray-900">Основные требования:</strong>
                        <ul class="list-disc pl-5 mb-4 space-y-1">
                            <li>Современный минималистичный дизайн</li>
                            <li>Адаптивная верстка (mobile-first)</li>
                            <li>Форма обратной связи с валидацией</li>
                            <li>Секция с портфолио/кейсами</li>
                            <li>Интеграция с Google Analytics</li>
                            <li>Оптимизация скорости загрузки (PageSpeed 85+)</li>
                        </ul>

                        <strong class="block mb-2 text-gray-900">Технические требования:</strong>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>HTML5, CSS3, JavaScript (ES6+)</li>
                            <li>Bootstrap или Tailwind CSS</li>
                            <li>Кроссбраузерность (Chrome, Firefox, Safari, Edge)</li>
                            <li>Валидность кода (W3C)</li>
                        </ul>
                    </div>
                </div>

                <!-- Изображения (если есть) -->
                <div class="mb-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3">Прикрепленные файлы</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                        <div class="border rounded-lg p-2">
                            <img src="/placeholder-image.jpg" alt="Пример дизайна" class="w-full h-32 object-cover rounded">
                            <p class="text-xs text-gray-600 mt-1 text-center">пример-дизайна.jpg</p>
                        </div>
                        <div class="border rounded-lg p-2">
                            <img src="/placeholder-image.jpg" alt="Логотип" class="w-full h-32 object-cover rounded">
                            <p class="text-xs text-gray-600 mt-1 text-center">логотип.png</p>
                        </div>
                    </div>
                </div>

                <!-- Навыки и теги -->
                <div class="mb-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3">Требуемые навыки</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">HTML5</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">CSS3</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">JavaScript</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">Tailwind CSS</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">Figma</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs sm:text-sm">SEO</span>
                    </div>
                </div>
            </div>

            <!-- Форма отклика -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-5 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold mb-4">Отправить отклик</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">>Ваше предложение</label>
                        <textarea 
                            rows="4" 
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Расскажите, почему вы подходите для этого заказа..."
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Срок выполнения</label>
                        <input 
                            type="text" 
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Например: 5 дней"
                        >
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Бюджет</label>
                        <input 
                            type="text" 
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Например: 10 000 ₽"
                        >
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Примеры работ (ссылки)</label>
                        <textarea 
                            rows="2" 
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://example1.com&#10;https://example2.com"
                        ></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium text-sm sm:text-base">
                        Отправить отклик
                    </button>
                </form>
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
