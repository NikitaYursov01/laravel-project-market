@extends('componet.shablon')

@section('title', 'Помощь — Справочный центр DETAIL-DEAL')
@section('description', 'FAQ по безопасной сделке, возвратам, модерации, рейтингам на платформе DETAIL-DEAL')

@section('content')
    @include('componet.content.header')

    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 text-center mb-4">
                    Справочный центр
                </h1>
                <p class="text-lg text-gray-600 text-center max-w-2xl mx-auto">
                    Ответы на частые вопросы по работе платформы DETAIL-DEAL
                </p>
            </div>
        </div>

        <!-- FAQ Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
            
            <!-- Section 1: General Concept -->
            <div class="mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-600">
                    1. Общая концепция и роль менеджера
                </h2>
                
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">В чем главная особенность сервиса?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                На DETAIL-DEAL вы не общаетесь с исполнителем или клиентом напрямую. Все коммуникации проходят через персонального менеджера. Это гарантирует, что ваши договоренности будут зафиксированы, а условия сделки — соблюдены.
                            </p>
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <strong>Важное правило:</strong> Обмен прямыми контактами (телефон, email, ссылки) запрещен и блокируется автоматически. Это сделано для вашей безопасности, чтобы все этапы сделки находились под защитой системы.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Safe Deal -->
            <div class="mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-600">
                    2. Безопасная сделка
                </h2>
                
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Как обеспечивается безопасность?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Когда вы нажимаете кнопку «Связаться», создается чат, в который подключается менеджер. Он модерирует обсуждение, помогает уточнить техническое задание и контролирует финансовые вопросы. Если возникнет спорная ситуация, история переписки в системе станет основой для справедливого решения.
                            </p>
                            
                            <!-- Steps Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border border-gray-200 rounded-lg">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-900 border-b">Этап</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-900 border-b">Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">1. Заказ</td>
                                            <td class="px-4 py-3 text-gray-700">Клиент создает заказ или выбирает услугу исполнителя.</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">2. Обсуждение</td>
                                            <td class="px-4 py-3 text-gray-700">Менеджер передает уточнения между сторонами, фиксирует цену и сроки.</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">3. Фиксация</td>
                                            <td class="px-4 py-3 text-gray-700">Любые изменения в заказе вносятся только через интерфейс с подтверждением менеджера.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Moderation -->
            <div class="mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-600">
                    3. Модерация и публикация
                </h2>
                
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Почему мое объявление еще не опубликовано?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Все объявления (и от клиентов, и от исполнителей) проходят проверку менеджером. Мы проверяем корректность описания, наличие чертежей и соответствие категории «Металлообработка».
                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Что такое «Срочное» объявление?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Вы можете пометить свой заказ или услугу значком «Срочно». Такие объявления поднимаются в начало списка поиска и привлекают больше внимания. Это платный функционал, активируемый в личном кабинете.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Returns & Conflicts -->
            <div class="mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-600">
                    4. Возвраты и конфликты
                </h2>
                
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Что делать, если работа выполнена некачественно?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Если результат не соответствует согласованному в чате ТЗ, вы можете подать жалобу через кнопку в профиле или прямо в чате. Менеджер проанализирует ситуацию, изучит историю сообщений и примет решение (предупреждение, отмена заказа или блокировка нарушителя).
                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Можно ли вернуть деньги за услуги платформы?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Денежные средства за доступ к сервису или услуги продвижения (статус «Срочно») не возвращаются, так как услуга считается оказанной в момент активации функционала.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Ratings -->
            <div class="mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-blue-600">
                    5. Рейтинги и отзывы
                </h2>
                
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between p-4 sm:p-5 text-left hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900 pr-4">Как формируется рейтинг?</span>
                            <i class="fa fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                        </button>
                        <div class="faq-content hidden px-4 sm:px-5 pb-4 sm:pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Рейтинг — это показатель надежности пользователя. Он строится на основе истории выполненных заказов и оценок других участников. Оставить отзыв можно только <strong>после завершения сделки</strong> и его обязательного подтверждения менеджером. Это исключает накрутки и несправедливые оценки.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="mt-12 p-6 sm:p-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl text-white text-center">
                <h3 class="text-lg sm:text-xl font-bold mb-3">Техническая поддержка</h3>
                <p class="text-blue-100 mb-4">
                    Остались вопросы? Напишите своему менеджеру в разделе «Чаты» или воспользуйтесь формой обратной связи в профиле.
                </p>
                <a href="{{ route('chats.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-blue-50 transition">
                    <i class="fa fa-comments"></i>
                    Перейти в чаты
                </a>
            </div>
        </div>
    </div>

    @include('componet.content.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.faq-toggle');
            
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.fa-chevron-down');
                    const isHidden = content.classList.contains('hidden');
                    
                    // Close all others (optional - accordion style)
                    // document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                    // document.querySelectorAll('.faq-toggle .fa-chevron-down').forEach(i => i.style.transform = 'rotate(0deg)');
                    
                    if (isHidden) {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });
    </script>
@endsection
