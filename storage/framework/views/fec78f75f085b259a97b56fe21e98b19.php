<!DOCTYPE html>
<html lang="ru">

<head>
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <!-- cdn tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- cdn icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- cdn CSS Swiper (слайдер) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- CSS с сайта -->
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>;
</head>

<body>

  <!-- here content -->
  <?php echo $__env->yieldContent('content'); ?>

  <?php echo $__env->make('componet/content.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- cdn Swiper (слайдер) -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\Users\Huawei Matebook\Desktop\Проект\laravel-project-market\resources\views/componet/shablon.blade.php ENDPATH**/ ?>