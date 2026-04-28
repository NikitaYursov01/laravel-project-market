<footer class="bg-slate-950 text-slate-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center">
                        <img src="/src/logo/logo.svg" alt="Logo">
                    </div>
                    <span class="font-bold text-2xl text-white">DetailDeal</span>
                </div>
                <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                    Маркетплейс металлопроката и металлообработки. Находим поставщиков и исполнителей для ваших проектов
                    по всей России.
                </p>
                <div class="flex gap-3">
                    <a href="#"
                        class="w-10 h-10 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa fa-telegram"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa fa-vk"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- For Clients -->
            <div>
                <h3 class="font-bold text-white mb-5 text-lg">Заказчикам</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('orders.create') }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Разместить заказ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.feed') }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Найти поставщика
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.feed', ['type' => 'performer_service']) }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Услуги обработки
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Калькулятор металла
                        </a>
                    </li>
                </ul>
            </div>

            <!-- For Suppliers -->
            <div>
                <h3 class="font-bold text-white mb-5 text-lg">Поставщикам</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('register.form') }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Стать поставщиком
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Тарифы и условия
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            API интеграция
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Документация
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support & Contact -->
            <div>
                <h3 class="font-bold text-white mb-5 text-lg">Поддержка</h3>
                <ul class="space-y-3 text-sm mb-6">
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Помощь и FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Контакты
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('term.access') }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Правила пользования
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('term.politic') }}"
                            class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            <i
                                class="fa fa-chevron-right text-xs text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            Политика конфиденциальности
                        </a>
                    </li>
                </ul>

                <!-- Contact Info -->
                <div class="p-4 bg-white/5 rounded-xl border border-white/10">
                    <p class="text-xs text-gray-500 mb-2">Служба поддержки</p>
                    <a href="mailto:support@detaildeal.ru"
                        class="text-white font-semibold hover:text-blue-400 transition-colors">
                        support@detaildeal.ru
                    </a>
                </div>
            </div>
        </div>

        <!-- Newsletter -->
        <div class="py-8 border-t border-white/10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="font-bold text-white mb-1">Будьте в курсе</h4>
                    <p class="text-sm text-gray-400">Получайте уведомления о новых заказах и лучших ценах</p>
                </div>
                <form class="flex gap-3 w-full md:w-auto">
                    <input type="email" placeholder="Ваш email"
                        class="px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                    <button type="submit"
                        class="px-5 py-3 bg-linear-to-br from-slate-100 via-sky-100 to-blue-200 hover:from-slate-50 hover:via-sky-50 hover:to-blue-100 rounded-xl font-medium text-sm transition-all border border-blue-100">
                        Подписаться
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-white/10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} DetailDeal — Маркетплейс металлопроката и металлообработки
                </p>
                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-shield text-green-500"></i>
                        Безопасные сделки
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fa fa-check-circle text-blue-500"></i>
                        Проверенные поставщики
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>