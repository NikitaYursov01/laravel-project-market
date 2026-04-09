@extends('componet.shablon')

<!-- HEAD ADD CONTENT -->
@section('title', 'Найдите лучших специалистов')
@section('description', 'Платформа для поиска профессионалов и специалистов')

<!-- BODY CONTENT -->
@section('content')

  <!-- BANNER -->
  <section
    class="bg-[url('/src/background/main/main.jpg')] bg-cover bg-center bg-no-repeat relative overflow-hidden mx-2 sm:mx-5 rounded-[20px] sm:rounded-[40px] mt-5 sm:mt-10">

    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent"></div>
    <!-- Content -->
    <div class="structure relative z-10 mx-auto px-3 sm:px-4 py-6 sm:py-10">

      <!-- Header -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-16 gap-4 sm:gap-0">
        <div class="flex items-center gap-4 sm:gap-6">

          <!-- logo -->
          <div class="w-10 h-12 sm:w-12 sm:h-12 bg-blue-600 rounded-full flex items-center justify-center p-2">
            <span class="bg-[url('/src/logo/logo.svg')] bg-no-repeat w-full h-full bg-contain"></span>
          </div>

          <!-- logo_name -->
          <a href="{{ route('main') }}"
            class="text-white text-base sm:text-lg border-b border-dashed border-white hover:border-blue-500 hover:text-blue-500 transition-colors">
            Detail-Deal
          </a>
        </div>
        <div class="flex gap-2 sm:gap-3 w-full sm:w-auto">
          @auth
            <button onclick="location.href = '{{ route('profile') }}'"
              class="flex-1 sm:flex-none px-4 sm:px-6 py-2 border border-green-400 text-green-400 rounded-full hover:bg-green-400/10 transition-colors text-sm sm:text-base">
              Профиль
            </button>
          @else
            <button onclick="location.href = '{{ route('register.form') }}'"
              class="flex-1 sm:flex-none px-4 sm:px-6 py-2 border border-green-400 text-green-400 rounded-full hover:bg-green-400/10 transition-colors text-sm sm:text-base">
              Создать профиль
            </button>
            <button onclick="location.href = '{{ route('login.form') }}'"
              class="flex-1 sm:flex-none px-4 sm:px-6 py-2 border border-white text-white rounded-full hover:bg-white/10 transition-colors text-sm sm:text-base">
              Войти
            </button>
          @endauth
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-2xl">
        <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-6 sm:mb-8 leading-tight">
          Начните <span class="text-blue-400">быстрый</span> поиск <font class="text-blue-400">нужной детали</font> прямо
          сейчас!
        </h3>

        <!-- Phone Input Form -->
        <div class="mb-4">
          <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" placeholder="Какую деталь вы ищете?"
              class="flex-1 bg-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl text-gray-900 text-base sm:text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button
              class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors text-base sm:text-lg">
              Продолжить
            </button>
          </div>
          <p class="text-white text-xs sm:text-sm mt-3 sm:mt-4">
            Продолжая, вы принимаете
            <a href="{{ route('term.access') }}" class="underline hover:text-white">соглашение</a> и
            <a href="{{ route('term.politic') }}" class="underline hover:text-white">политику конфиденциальности</a>
          </p>
        </div>

        <!-- Bottom Link -->
        <div class="mt-12 sm:mt-20">
          <a href="#" class="text-white underline hover:no-underline text-sm sm:text-base">
            Ищите работу рядом с домом
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTENT #1 -->
  <section class="relative my-16">
    <div class="structure px-4 sm:px-0">

      <h3 class="title-h3 text-center">Поможем подобрать подходящего исполнителя</h3>

      <!-- сетка блоков -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">

        <!-- block 1 -->
        <div
          class="relative p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl">
          <!-- icon -->
          <span class="rounded-full bg-gray-100 w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center mb-4 sm:mb-6">
            <i class="fas fa-user text-black text-lg sm:text-xl"></i>
          </span>
          <h4 class="title-h4 text-2xl">Большая база
            кандидатов</h4>
          <p class="text-gray-400 description text-xs sm:text-sm">Вам открыт доступ к более
            60 млн проверенных резюме в стране</p>
        </div>

        <!-- block 2 -->
        <div
          class="relative p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl">
          <!-- icon -->
          <span class="rounded-full  bg-gray-100 w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center mb-4 sm:mb-6">
            <i class="fas fa-user text-black text-lg sm:text-xl"></i>
          </span>
          <h4 class="title-h4 text-2xl">Большая база
            кандидатов</h4>
          <p class="text-gray-400 description text-xs sm:text-sm">Вам открыт доступ к более
            60 млн проверенных резюме в стране</p>
        </div>

        <!-- block 3 -->
        <div
          class="relative p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl row-span-1 lg:row-span-2 flex flex-col justify-end bg-[url('/src/background/main/banner.jpg')] bg-cover">
          <!-- затемнение -->
          <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
          <!-- текст -->
          <h4 class="title-h4 text-2xl text-white z-10">Большая база
            кандидатов</h4>
          <p class="text-gray-200 description text-xs sm:text-sm z-10">Вам открыт доступ к более
            60 млн проверенных резюме в стране</p>
        </div>

        <!-- block 4 -->
        <div
          class="relative p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl col-span-1 lg:col-span-2">
          <!-- icon -->
          <span class="rounded-full bg-gray-100 w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center mb-4 sm:mb-6">
            <i class="fas fa-user text-black text-lg sm:text-xl"></i>
          </span>
          <h4 class="title-h4 text-2xl">Большая база
            кандидатов</h4>
          <p class="text-gray-400 description text-xs sm:text-sm">Вам открыт доступ к более
            60 млн проверенных резюме в стране</p>
        </div>

      </div>

    </div>
  </section>

  <!-- CONTENT #2 -->
  <section class="relative my-16">
    <div class="structure px-4 sm:px-0">

      <h3 class="title-h3 text-center">Удобный интерфейс для исполнителя и заказчика</h3>

      <div class="flex justify-center items-stretch gap-4 sm:gap-6 lg:gap-10 flex-wrap lg:flex-nowrap">

        <!-- block 1 -->
        <div
          class="bg-[#E8F9EC] border border-solid p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl lg:w-[calc(50%-12px)]">
          <span class="text-green-400">Для заказчика</span>
          <h4 class="title-h4">Размещение объявления</h4>
          <p class="description mb-4">Разместите объявление — и вам напишут или позвонят те, кто уже хочет с вами
            работать</p>
          <picture>
            <source class="rounded-xl" srcset="https://hhcdn.ru/icms/10324760.jpg" type="image/webp"
              media="(max-width: 630px)">
            <img class="rounded-xl" src="https://hhcdn.ru/icms/10324759.jpg" alt="обьявление пример">
          </picture>
        </div>

        <!-- block 2 -->
        <div
          class="bg-[#f0e8f9] border border-solid p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl lg:w-[calc(50%-12px)]">
          <span class="text-purple-400">Для заказчика</span>
          <h4 class="title-h4">Размещение объявления</h4>
          <p class="description mb-4">Разместите объявление — и вам напишут или позвонят те, кто уже хочет с вами
            работать</p>
          <picture>
            <source class="rounded-xl" srcset="https://hhcdn.ru/icms/10324760.jpg" type="image/webp"
              media="(max-width: 630px)">
            <img class="rounded-xl" src="https://hhcdn.ru/icms/10324759.jpg" alt="обьявление пример">
          </picture>
        </div>

      </div>

    </div>
  </section>

  <!-- CONTENT #3 -->
  <section class="relative my-16">
    <div class="structure px-4 sm:px-0">

      <h3 class="title-h3 text-center">Начни поиск сейчас — <br>в раз-два-три</h3>

      <div class="flex justify-center items-stretch gap-4 sm:gap-6 lg:gap-8 flex-wrap lg:flex-nowrap">

        <!-- block 1 -->
        <div
          class="flex flex-col justify-between p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl lg:w-[calc(50%-12px)]">
          <span class="bg-green-400 text-white px-2 py-1 rounded-lg w-fit">Шаг 1</span>
          <h4 class="title-h4 mt-4 mb-0 font-bold">Зарегистрируйтесь</h4>
          <p class="description mb-4 text-gray-600">Откройте себе профиль!</p>
          <picture>
            <source class="rounded-xl" srcset="/src/background/main_services/part1.jpg" type="image/webp"
              media="(max-width: 630px)">
            <img class="rounded-xl" src="/src/background/main_services/part1.jpg" alt="обьявление пример">
          </picture>
        </div>

        <!-- block 2 -->
        <div
          class="flex flex-col justify-between p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl lg:lg:w-[calc(50%-12px)]">
          <span class="bg-green-400 text-white px-2 py-1 rounded-lg w-fit">Шаг 2</span>
          <h4 class="title-h4 mt-4 mb-0 font-bold">Найдите товар</h4>
          <p class="description mb-4 text-gray-600">Отыщите нужный вам товар</p>
          <picture>
            <source class="rounded-xl" srcset="/src/background/main_services/part2.jpg" type="image/webp"
              media="(max-width: 630px)">
            <img class="rounded-xl" src="/src/background/main_services/part2.jpg" alt="обьявление пример">
          </picture>
        </div>

        <!-- block 3 -->
        <div
          class="flex flex-col justify-between p-4 sm:p-6 lg:p-8 text-sm sm:text-base lg:text-base leading-5 sm:leading-6 lg:leading-6 text-gray-700 bg-white rounded-xl sm:rounded-2xl lg:w-[calc(50%-12px)]">
          <span class="bg-green-400 text-white px-2 py-1 rounded-lg w-fit">Шаг 3</span>
          <h4 class="title-h4 mt-4 mb-0 font-bold">Сформируйте заказ</h4>
          <p class="description mb-4 text-gray-600">Начните общение с исполнителем</p>
          <picture>
            <source class="rounded-xl" srcset="/src/background/main_services/part3.jpg" type="image/webp"
              media="(max-width: 630px)">
            <img class="rounded-xl" src="/src/background/main_services/part3.jpg" alt="обьявление пример">
          </picture>
        </div>

      </div>

    </div>
  </section>

@endsection
