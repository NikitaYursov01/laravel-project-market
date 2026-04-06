@extends('layouts.app')

@section('title', 'Исполнители')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Исполнители</h2>
        
        <p class="text-gray-600 mb-6">Каталог проверенных исполнителей для ваших проектов.</p>

        <!-- Фильтры и поиск -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Специализация</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Все специализации</option>
                        <option>Веб-разработка</option>
                        <option>Мобильная разработка</option>
                        <option>Дизайн</option>
                        <option>Маркетинг</option>
                        <option>Копирайтинг</option>
                        <option>Другое</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Рейтинг</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Любой рейтинг</option>
                        <option>4.5 и выше</option>
                        <option>4.0 и выше</option>
                        <option>3.5 и выше</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Опыт</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option>Любой опыт</option>
                        <option>Более 5 лет</option>
                        <option>3-5 лет</option>
                        <option>1-3 года</option>
                        <option>До 1 года</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Поиск</label>
                    <input 
                        type="text" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                        placeholder="Поиск по имени или навыкам"
                    >
                </div>
            </div>
        </div>

        <!-- Список исполнителей -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Исполнитель 1 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Иван Иванов</h3>
                        <p class="text-gray-600">Веб-разработчик</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <span class="text-sm text-gray-600">4.8 (47 отзывов)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 5 лет
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 52
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Full-stack разработчик с опытом создания сложных веб-приложений. Специализируюсь на Laravel, React, Vue.js.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">PHP</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Laravel</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">React</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Vue.js</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">MySQL</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">2 500 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
                    </button>
                </div>
            </div>

            <!-- Исполнитель 2 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Мария Петрова</h3>
                        <p class="text-gray-600">UI/UX Дизайнер</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <span class="text-sm text-gray-600">4.9 (89 отзывов)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 3 года
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 34
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Создаю современные и удобные интерфейсы для веб и мобильных приложений. Работаю с Figma, Sketch, Adobe XD.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Figma</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Sketch</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Adobe XD</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">UI Design</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">UX Design</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">1 800 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
                    </button>
                </div>
            </div>

            <!-- Исполнитель 3 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Алексей Смирнов</h3>
                        <p class="text-gray-600">Копирайтер</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★☆</span>
                        <span class="text-sm text-gray-600">4.7 (23 отзыва)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 4 года
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 67
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Пишу продающие тексты для бизнеса, блогов, соцсетей. Специализируюсь на IT, финансах, маркетинге.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Копирайтинг</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">SEO</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">SMM</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Рерайтинг</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">1 200 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
                    </button>
                </div>
            </div>

            <!-- Исполнитель 4 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Елена Козлова</h3>
                        <p class="text-gray-600">Маркетолог</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <span class="text-sm text-gray-600">4.6 (31 отзыв)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 6 лет
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 45
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Разрабатываю и реализую маркетинговые стратегии для бизнеса. Контекстная реклама, SMM, email-маркетинг.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Google Ads</span>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Facebook Ads</span>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">SMM</span>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Analytics</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">2 000 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
                    </button>
                </div>
            </div>

            <!-- Исполнитель 5 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Дмитрий Новиков</h3>
                        <p class="text-gray-600">Мобильный разработчик</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <span class="text-sm text-gray-600">4.8 (19 отзывов)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 4 года
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 28
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Разрабатываю нативные и кроссплатформенные мобильные приложения для iOS и Android.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">React Native</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Flutter</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Swift</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Kotlin</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">3 000 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
                    </button>
                </div>
            </div>

            <!-- Исполнитель 6 -->
            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-lg">Ольга Белова</h3>
                        <p class="text-gray-600">Project Manager</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <span class="text-sm text-gray-600">4.9 (56 отзывов)</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Опыт:</span> 7 лет
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Проектов:</span> 73
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 line-clamp-3">
                        Управляю IT-проектами любой сложности. Agile, Scrum, Waterfall. Сертифицированный PMP.
                    </p>
                </div>

                <div class="mb-4">
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs">Agile</span>
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs">Scrum</span>
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs">PMP</span>
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs">Jira</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-blue-600">2 800 ₽/час</div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Написать
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
