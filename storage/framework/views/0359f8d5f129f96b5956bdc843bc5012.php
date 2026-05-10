<!-- HEAD ADD CONTENT -->
<?php $__env->startSection('title', 'Личный кабинет'); ?>
<?php $__env->startSection('description', 'Личный кабинет пользователя на платформе'); ?>

<!-- BODY CONTENT -->
<?php $__env->startSection('content'); ?>
  <?php if(auth()->guard()->check()): ?>
    <div class="min-h-screen">
      <!-- header -->
      <?php echo $__env->make('componet.content.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <!-- structure - содережание по контейнеру  -->
      <div class="flex justify-between items-start structure px-4 sm:px-0 py-[40px] gap-10">

        <aside class="flex w-full justify-start items-start max-w-[400px] flex-col">

          <h4 class="title-h4">Мой профиль</h4>
          <nav class="w-full">
            <ul class="flex flex-col gap-1 justify-start items-center">
              <li data-toggle-section="main"
                class="block font-semibold font-sans cursor-pointer w-full p-3.5 profile_li profile_active hover:bg-blue-400/10 transition">Мой профиль
              </li>
              <li data-toggle-section="data"
                class="block font-semibold font-sans cursor-pointer w-full p-3.5 profile_li hover:bg-blue-400/10 transition">Личные данные
              </li>
            </ul>
          </nav>

        </aside>

        <section class="flex-1 flex flex-col gap-2">

        <!-- block 1 -->
          <div data-section="main" class="bg-white rounded-xl mb-6"
            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
            <div class="p-5 pb-2">
            <div class="flex items-center gap-4 mb-4">
              <img class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center"
                src="/src/tester/profile/avatar/avatar.webp">
              </img>
                <h3 class="text-xl font-semibold"><?php echo Auth::user()->name; ?></h3>
            </div>
            </div>
            <hr class="bg-[#e8e8f4] h-px">
            <div class="p-5 flex items-center gap-2">
            <i class="fa fa-solid fa-check-circle text-green-500"></i><p class="text-green-600">Номер и соцсети подтверждены</p>
            </div>
          </div>

           <!-- block 2 -->
          <div data-section="data" class="bg-white rounded-xl mb-6"
            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
            <div class="p-5 pb-2">

            <?php if(session('success')): ?>
              <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                <?php echo e(session('success')); ?>

              </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
              <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <form action="<?php echo e(route('profile.update')); ?>" method="POST">
              <?php echo csrf_field(); ?>

              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Имя</label>
                <input type="text" name="name" id="name" value="<?php echo e(Auth::user()->name); ?>" class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500" required>
              </div>
              <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Email</label>
                <input type="email" name="email" id="email" value="<?php echo e(Auth::user()->email); ?>" class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500" required>
              </div>
              <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Новый пароль (оставьте пустым, если не хотите менять)</label>
                <input type="password" name="password" id="password" value="" class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500">
              </div>
              <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 ui_3Oq5V">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" value="" class="profile_input mt-2 block w-full border border-solid focus:border-indigo-500 focus:ring-indigo-500">
              </div>
              <div class="mb-4">
                <button type="submit" class="profile_btn w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                  Сохранить
                </button>
              </div>
            </form>

            </div>
          </div>


          <!-- block N -->
          <!-- <div data-section="main" class="bg-white rounded-xl mb-6"
            style="box-shadow: 0 5px 30px rgba(0, 0, 0, .05);">
            <div class="p-5 pb-2">

            ...

            </div>
          </div> -->

        </section>

      </div>

      <!-- footer -->
      <?php echo $__env->make('componet.content.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <script>
        document.querySelectorAll('[data-toggle-section]').forEach(button => {
          button.addEventListener('click', function () {

            document.querySelectorAll('[data-toggle-section]').forEach(button => {
              button.classList.remove('profile_active');
            });
            button.classList.add('profile_active');

            var sectionId = button.getAttribute('data-toggle-section');
            // Скрыть все секции с плавным исчезновением
            document.querySelectorAll('[data-section]').forEach(section => {
              //анимации исчезнавения
              section.style.transition = 'opacity 0.3s';
              section.style.opacity = 0;
              setTimeout(function () {
                section.classList.add('hidden');
              }, 300);
            });
            // Показать выбранную секцию с плавным появлением
            var targetSection = document.querySelector('[data-section="' + sectionId + '"]');
            if (targetSection) {
              // Сначала убираем класс hidden, выставляем прозрачность
              setTimeout(function () {
                targetSection.classList.remove('hidden');
                targetSection.style.transition = 'opacity 0.3s';
                targetSection.style.opacity = 0;
                // Затем заставляем браузер "увидеть" 0, и только потом плавно делаем 1
                setTimeout(function () {
                  targetSection.style.opacity = 1;
                }, 10);
              }, 300);
            }
          });
        });
      </script>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('componet.shablon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Huawei Matebook\Desktop\Проект\laravel-project-market\resources\views/auth/profile.blade.php ENDPATH**/ ?>