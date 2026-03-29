<!-- footer -->
<footer class="structure text-gray-700">
  <div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">

      <!-- Клиентам -->
      <div>
        <h3 class="font-semibold text-gray-900 mb-4">Клиентам</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Новая задача</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Все услуги</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Все отзывы</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Условия использования</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Каталог ссылок</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Мобильная версия</a></li>
        </ul>
      </div>

      <!-- Специалистам -->
      <div>
        <h3 class="font-semibold text-gray-900 mb-4">Специалистам</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Сайт для специалистов</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Вход для специалистов</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Работа в Москве</a></li>
        </ul>
      </div>

      <!-- О компании -->
      <div>
        <h3 class="font-semibold text-gray-900 mb-4">О компании</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">О компании</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Реклама на DetailDeal.ру</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Для прессы</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Партнёрская программа</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Вакансии</a></li>
          <li><a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Блог</a></li>
        </ul>
      </div>

      <!-- Поддержка -->
      <div>
        <h3 class="font-semibold text-gray-900 mb-4">Поддержка</h3>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors mb-3 w-full">
          Чат с поддержкой
        </button>
        <p class="text-sm text-gray-600 mb-4">Отвечаем круглосуточно</p>
        <div class="flex space-x-3">
          <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
            <iconify-icon icon="simple-icons:telegram" width="24" height="24"></iconify-icon>
          </a>
          <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
            <iconify-icon icon="simple-icons:vk" width="24" height="24"></iconify-icon>
          </a>
          <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
            <iconify-icon icon="simple-icons:odnoklassniki" width="24" height="24"></iconify-icon>
          </a>
          <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
            <iconify-icon icon="simple-icons:youtube" width="24" height="24"></iconify-icon>
          </a>
        </div>
      </div>

      <!-- Мобильное приложение -->
      <div>
        <h3 class="font-semibold text-gray-900 mb-4">Мобильное приложение</h3>
        <div class="mb-4">
          <div class="w-24 h-24 bg-white border-2 border-gray-200 rounded-lg flex items-center justify-center mb-2">
            <iconify-icon icon="mdi:qrcode" width="48" height="48" class="text-gray-400"></iconify-icon>
          </div>
          <p class="text-xs text-gray-600">Наведите камеру на QR-код и скачайте наше мобильное приложение</p>
        </div>
        <div class="space-y-2">
          <a href="#" class="block">
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
              alt="Google Play" class="h-8">
          </a>
          <a href="#" class="block">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg"
              alt="App Store" class="h-8">
          </a>

        </div>
      </div>
    </div>

    <!-- Нижняя часть футера -->
    <div class="border-t border-gray-200 mt-12 pt-8">
      <div class="flex flex-col md:flex-row justify-end items-center">
        <div class="text-center md:text-right space-y-1">
          <p class="text-sm text-gray-600">© DETAIL-DEAL.RU, <?php echo date('Y'); ?></p>
          <p class="text-xs text-gray-500">ООО «DETAIL-DEAL.RU» осуществляет деятельность в области информационных
            технологий. Вид деятельности (код): 2.01. На информационном ресурсе применяются рекомендательные
            технологии. <a href="{{ route('term.politic') }}" class="text-blue-600 hover:text-blue-700 transition-colors">Политика
              конфиденциальности</a>.</p>
        </div>
      </div>
    </div>
  </div>
</footer>
