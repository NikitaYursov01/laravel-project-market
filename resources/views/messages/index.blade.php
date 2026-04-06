@extends('componet.shablon')

<!-- HEAD ADD CONTENT -->
@section('title', 'Найдите лучших специалистов')
@section('description', 'Платформа для поиска профессионалов и специалистов')

<!-- BODY CONTENT -->
@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Список чатов -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg">Чаты</h3>
                    <button class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 text-sm">
                        Новый чат
                    </button>
                </div>

                <!-- Поиск по чатам -->
                <div class="mb-4">
                    <input 
                        type="text" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                        placeholder="Поиск по сообщениям..."
                    >
                </div>

                <!-- Список чатов -->
                <div class="space-y-2">
                    <!-- Чат 1 - активный -->
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-lg cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-sm">Иван Иванов</h4>
                                    <span class="text-xs text-gray-500">2 мин</span>
                                </div>
                                <p class="text-xs text-gray-600">Веб-разработчик</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 truncate">
                            Да, я готов приступить к работе над проектом. Когда можно начать?
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">2</span>
                            <span class="text-xs text-blue-600 font-medium">Заказ: #1234</span>
                        </div>
                    </div>

                    <!-- Чат 2 -->
                    <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-sm">Мария Петрова</h4>
                                    <span class="text-xs text-gray-500">1 час</span>
                                </div>
                                <p class="text-xs text-gray-600">UI/UX Дизайнер</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 truncate">
                            Отправила варианты дизайна на утверждение. Посмотрите, пожалуйста.
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-500">Прочитано</span>
                            <span class="text-xs text-gray-600">Заказ: #1235</span>
                        </div>
                    </div>

                    <!-- Чат 3 -->
                    <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-sm">Алексей Смирнов</h4>
                                    <span class="text-xs text-gray-500">3 часа</span>
                                </div>
                                <p class="text-xs text-gray-600">Копирайтер</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 truncate">
                            Статья готова. Прикрепляю файл для проверки.
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">📎</span>
                            <span class="text-xs text-gray-600">Заказ: #1236</span>
                        </div>
                    </div>

                    <!-- Чат 4 -->
                    <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-sm">Елена Козлова</h4>
                                    <span class="text-xs text-gray-500">Вчера</span>
                                </div>
                                <p class="text-xs text-gray-600">Маркетолог</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 truncate">
                            Спасибо за сотрудничество! Проект завершен успешно.
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-green-600">✓ Завершен</span>
                            <span class="text-xs text-gray-600">Заказ: #1230</span>
                        </div>
                    </div>

                    <!-- Чат 5 -->
                    <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-sm">Дмитрий Новиков</h4>
                                    <span class="text-xs text-gray-500">2 дня</span>
                                </div>
                                <p class="text-xs text-gray-600">Мобильный разработчик</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 truncate">
                            Пришлите, пожалуйста, техническое задание подробнее.
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-500">Прочитано</span>
                            <span class="text-xs text-gray-600">Заказ: #1229</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Область чата -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md h-full flex flex-col">
                <!-- Заголовок чата -->
                <div class="border-b p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <h3 class="font-semibold">Иван Иванов</h3>
                                <p class="text-sm text-gray-600">Веб-разработчик • В сети</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Сообщения -->
                <div class="flex-1 p-4 overflow-y-auto">
                    <div class="space-y-4">
                        <!-- Дата -->
                        <div class="text-center text-sm text-gray-500 my-4">
                            Сегодня, 14:30
                        </div>

                        <!-- Сообщение от собеседника -->
                        <div class="flex items-start mb-4">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-8 h-8 rounded-full mr-3">
                            <div class="max-w-md">
                                <div class="bg-gray-100 rounded-lg p-3">
                                    <p class="text-sm text-gray-800">
                                        Здравствуйте! Я видел ваш заказ по разработке лендинга. Готов взяться за проект. У меня есть опыт создания подобных сайтов.
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">14:30</span>
                            </div>
                        </div>

                        <!-- Мое сообщение -->
                        <div class="flex items-start mb-4 justify-end">
                            <div class="max-w-md">
                                <div class="bg-blue-600 text-white rounded-lg p-3">
                                    <p class="text-sm">
                                        Здравствуйте! Рад вашему интересу. Расскажите подробнее о вашем опысте и покажите примеры работ, пожалуйста.
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block text-right">14:32</span>
                            </div>
                        </div>

                        <!-- Сообщение от собеседника -->
                        <div class="flex items-start mb-4">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-8 h-8 rounded-full mr-3">
                            <div class="max-w-md">
                                <div class="bg-gray-100 rounded-lg p-3">
                                    <p class="text-sm text-gray-800">
                                        Конечно! Вот несколько примеров моих работ: site1.com, site2.com, site3.com. Все сайты сделаны на Laravel + Vue.js.
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">14:35</span>
                            </div>
                        </div>

                        <!-- Мое сообщение -->
                        <div class="flex items-start mb-4 justify-end">
                            <div class="max-w-md">
                                <div class="bg-blue-600 text-white rounded-lg p-3">
                                    <p class="text-sm">
                                        Отлично! Ваши работы выглядят профессионально. Какой у вас примерный срок выполнения и стоимость?
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block text-right">14:38</span>
                            </div>
                        </div>

                        <!-- Сообщение от собеседника с файлом -->
                        <div class="flex items-start mb-4">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-8 h-8 rounded-full mr-3">
                            <div class="max-w-md">
                                <div class="bg-gray-100 rounded-lg p-3">
                                    <p class="text-sm text-gray-800 mb-2">
                                        Прикрепляю коммерческое предложение с подробным расчетом.
                                    </p>
                                    <div class="bg-white rounded p-2 border">
                                        <div class="flex items-center">
                                            <svg class="w-8 h-8 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">коммерческое_предложение.pdf</p>
                                                <p class="text-xs text-gray-500">245 КБ</p>
                                            </div>
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">14:40</span>
                            </div>
                        </div>

                        <!-- Мое сообщение -->
                        <div class="flex items-start mb-4 justify-end">
                            <div class="max-w-md">
                                <div class="bg-blue-600 text-white rounded-lg p-3">
                                    <p class="text-sm">
                                        Спасибо! Посмотрю предложение и вернусь с ответом в ближайшее время.
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block text-right">14:42</span>
                            </div>
                        </div>

                        <!-- Последнее сообщение -->
                        <div class="flex items-start mb-4">
                            <img src="/placeholder-avatar.jpg" alt="Аватар" class="w-8 h-8 rounded-full mr-3">
                            <div class="max-w-md">
                                <div class="bg-gray-100 rounded-lg p-3">
                                    <p class="text-sm text-gray-800">
                                        Да, я готов приступить к работе над проектом. Когда можно начать?
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block">14:45</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Форма отправки сообщения -->
                <div class="border-t p-4">
                    <form class="flex space-x-2">
                        <button type="button" class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </button>
                        <input 
                            type="text" 
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Введите сообщение..."
                        >
                        <button type="button" class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

