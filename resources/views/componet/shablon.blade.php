<!DOCTYPE html>
<html lang="ru">

<head>
  <title>@yield('title')</title>
  <meta name="description" content="@yield('description')">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- cdn tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- cdn icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- cdn CSS Swiper (слайдер) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- CSS с сайта -->
  @vite(['resources/css/app.css']);
</head>

<body>

  <!-- here content -->
  @yield('content')

  @include('componet/content.footer')

  <!-- cdn Swiper (слайдер) -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
