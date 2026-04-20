@extends('componet.shablon')

<!-- HEAD ADD CONTENT -->
@section('title', 'Регистрация нового профиля')
@section('description', 'Регистрация нового профиля')

<!-- BODY CONTENT -->
@section('content')

  <!-- фон -->
  <div
    class="flex flex-col justify-center items-center w-full h-screen bg-[url('/src/background/auth/background/bg.avif')] bg-center bg-fit">

    <section
      class="relative flex flex-col items-center justify-center border border-blue-600 border-dashed py-6 md:py-8 px-4 md:px-10 rounded-2xl md:rounded-3xl bg-white w-full max-w-lg mx-4">
      <div class="w-full max-w-md px-2 md:px-0">

        <!-- Logo -->
        <div class="flex justify-center mb-8">
          <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-600 rounded-full flex justify-center items-center p-3 sm:p-4">
            <span class="bg-[url('/src/logo/logo.svg')] bg-no-repeat w-full h-full bg-contain"></span>
          </div>
        </div>

        <!-- Card -->
        <div class="bg-white">

          <!-- Title -->
          <h1 class="text-xl sm:text-2xl font-semibold text-center text-gray-900 mb-3 leading-snug">
            Войдите, чтобы работать<br>с заказами
          </h1>

          <!-- ФОРМА ВХОДА ПО КОДУ -->
          <form method="POST" action="{{ route('login.code') }}" id="code_form" class="space-y-4">
            @csrf
            <input type="hidden" name="email" id="hidden_email" value="{{ old('email') ?? session('email') }}">

            <!-- ОСНОВНОЕ СОДЕРЖАНИЕ -->
            <div class="flex flex-col transition-all duration-500" id="main_content">

              <!-- email -->
              <input id="email" name="email" type="email" placeholder="Электронная почта"
                value="{{ old('email') ?? session('email') }}"
                class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors ">
              <span id="errorEmail" class="text-red-500 text-sm mt-2 hidden"></span>
              <button id="next_btn"
                class="hover:scale-95 transition-all duration-500 mt-4 w-full bg-[#0070ff] hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg"
                disabled>
                Продолжить
              </button>

              <button onclick="next_password(); event.preventDefault();"
                class="hover:scale-95 transition-all duration-500 mt-4 w-full bg-[#edf6ff] text-[#0070ff] font-medium py-3 px-4 text-sm sm:text-base rounded-lg">
                Войти по паролю
              </button>

            </div>

            <!-- СОДЕРЖАНИЕ ВВОДА КОДА -->
            <div class="flex flex-col space-y-4 hidden transition-all duration-500" id="end">

              <!-- ВВОД КОДА -->
              <div class="relative">
                <input id="verifycode" name="verifycode" type="text" placeholder="****"
                  class="tracking-[5px] w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors text-center text-lg font-mono"
                  maxlength="4">
                <span id="errorVerifyCode" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>

              <button type="submit" id="login_btn"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg transition-colors"
                disabled>
                Войти
              </button>
            </div>
          </form>

          <!-- ФОРМА ВХОДА ПО ПАРОЛЮ -->
          <form method="POST" action="{{ route('login') }}" id="password_form" class="space-y-4 hidden">
            @csrf

            @error('email')
              <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ $message }}
              </div>
            @enderror

            @error('password')
              <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ $message }}
              </div>
            @enderror

            <!-- email -->
            <input id="check_email" name="email" type="email" placeholder="Электронная почта" value="{{ old('email') }}"
              class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ">

            <!-- password -->
            <input id="password" name="password" type="password" placeholder="Введите свой пароль"
              class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ">

            <button type="submit" id="password_submit_btn"
              class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg transition-colors flex items-center justify-center">
              <span id="btn_text">Войти</span>
            </button>

            <button type="button" onclick="back_to_code(); event.preventDefault();"
              class="hover:scale-95 transition-all duration-500 mt-4 w-full bg-[#edf6ff] text-[#0070ff] font-medium py-3 px-4 text-sm sm:text-base rounded-lg">
              Войти по почте
            </button>
          </form>

          <button onclick="location.href = '{{ route('main') }}'"
            class="hover:scale-95 transition-all duration-500 mt-4 w-full border border-dashed border-blue-600 text-blue-600 font-medium py-3 px-4 text-sm sm:text-base rounded-lg">
            <i class="fas fa-angle-left text-lg text-blue-600"></i> На главную
          </button>

          <!-- Links -->
          <div class="static mt-5 mb-2 sm:absolute sm:top-5 sm:left-5 sm:mt-6">
            <a href="{{ route('register.form') }}"
              class="text-blue-600 hover:text-blue-700 text-md font-medium items-center flex gap-1">
              <i class="fas fa-angle-left text-lg text-blue-600"></i>
              Зарегистрироваться
            </a>
          </div>

          <!-- Terms -->
          <p class="mt-8 text-center text-sm text-gray-500 leading-relaxed">
            Нажимая «Дальше», вы подтверждаете, что принимаете
            <a href="#" class="text-blue-600 hover:underline">правила сервиса</a>
            и ознакомились с
            <a href="#" class="text-blue-600 hover:underline">политикой конфиденциальности</a>
          </p>
        </div>

      </div>

      <!-- Footer -->
      <p class="bottom-5 mt-5 text-center text-sm text-gray-500">
        © <?php echo date('Y'); ?> ООО «DetailDeal»
      </p>
    </section>

  </div>


  <script>
    const email = document.getElementById('email');
    const verifycode = document.getElementById('verifycode');
    const hidden_email = document.getElementById('hidden_email');

    // Переменные для формы пароля
    const check_email = document.getElementById('check_email');
    const password = document.getElementById('password');
    const password_submit_btn = document.getElementById('password_submit_btn');

    //errors
    const errorEmail = document.getElementById('errorEmail');
    const errorVerifyCode = document.getElementById('errorVerifyCode');
    const errorEmailPassword = document.getElementById('errorEmailPassword');
    const errorPassword = document.getElementById('errorPassword');

    //toggle
    let checkpoint_email = 0
    let checkpoint_verifycode = 0
    let checkpoint_password_email = 0
    let checkpoint_password = 0

    //buttons
    const next_btn = document.getElementById('next_btn');
    const login_btn = document.getElementById('login_btn');

    // Изначально отключаем кнопки
    login_btn.disabled = true;
    password_submit_btn.disabled = false;

    // Восстановление состояния формы при загрузке страницы
    document.addEventListener('DOMContentLoaded', function () {
      // Упрощенная валидация формы пароля
      function updatePasswordButton() {
        const email = check_email.value.trim();
        const password = password.value.trim();

        // Простая проверка - оба поля должны быть заполнены
        const isValid = email && password && email.includes('@') && password.length >= 6;

        password_submit_btn.disabled = !isValid;
      }

      // Упрощенная обработка формы пароля
      const passwordForm = document.getElementById('password_form');
      const passwordSubmitBtn = document.getElementById('password_submit_btn');
      const btnText = document.getElementById('btn_text');

      if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
          // Показываем загрузку
          btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Вход...';
          passwordSubmitBtn.disabled = true;
        });
      }
    });

    const savedForm = localStorage.getItem('authForm');
    if (savedForm === 'password') {
      // Показываем форму пароля
      const code_form = document.getElementById('code_form');
      const password_form = document.getElementById('password_form');

      code_form.classList.add('hidden');
      password_form.classList.remove('hidden');

      // Восстанавливаем значения полей
      const savedEmail = localStorage.getItem('authEmail');
      if (savedEmail) {
        check_email.value = savedEmail;
        // Проверяем email после восстановления
        check_email.dispatchEvent(new Event('input'));
      }

      // Проверяем состояние кнопки после восстановления формы
      updatePasswordButton();
    }

    // Сохранение состояния формы
    function saveFormState(formType) {
      localStorage.setItem('authForm', formType);
      if (formType === 'password' && check_email.value) {
        localStorage.setItem('authEmail', check_email.value);
      }
    }

    //авто смена цвета
    function setBorderState(el, isValid) {
      el.classList.replace(
        isValid ? 'border-red-500' : 'border-green-500',
        isValid ? 'border-green-500' : 'border-red-500'
      );
    }

    //ПРОВЕРКА ПОЧТЫ
    email.addEventListener('input', async () => {
      if (!email.value) {//пустая
        errorEmail.classList.add('hidden');//скрываем ошибку
        email.classList.add('border-[#D1D5DB]');
        checkpoint_email = 0; //доступ заприщен
      } else if (!email.value.includes('@')) {//нету @
        errorEmail.classList.remove('hidden');//раскрываем ошибку
        setBorderState(email, false);//делаем красным поле
        errorEmail.textContent = 'Укажите обязательно @';
        email.classList.add('border-red-500');//красное поле
        checkpoint_email = 0; //доступ заприщен
      } else if (!(/^[\w.-]+@\w[\w.-]+\.\w{2,}$/.test(email.value))) {//некорректный формат
        errorEmail.classList.remove('hidden');//раскрываем ошибку
        setBorderState(email, false);//делаем красным поле
        errorEmail.textContent = 'Некорректный формат почты';
        email.classList.add('border-red-500');//красное поле
        checkpoint_email = 0; //доступ заприщен
      } else {
        // Проверяем существование email на сервере
        try {
          const response = await fetch('{{ route("check.email") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              email: email.value
            })
          });

          const data = await response.json();

          if (response.ok) {
            if (!data.exists) {
              errorEmail.classList.remove('hidden');
              setBorderState(email, false);
              errorEmail.textContent = 'Этот email не зарегистрирован';
              email.classList.add('border-red-500');
              checkpoint_email = 0; //доступ заприщен - email не существует
            } else {
              errorEmail.classList.add('hidden');
              setBorderState(email, true);
              email.classList.add('border-green-500');
              checkpoint_email = 1; //доступ разрешен - email существует
            }
          } else {
            errorEmail.classList.remove('hidden');
            setBorderState(email, false);
            errorEmail.textContent = data.message || 'Ошибка проверки email';
            email.classList.add('border-red-500');
            checkpoint_email = 0;
          }
        } catch (error) {
          console.error('Error checking email:', error);
          errorEmail.classList.remove('hidden');
          setBorderState(email, false);
          errorEmail.textContent = 'Ошибка проверки email';
          email.classList.add('border-red-500');
          checkpoint_email = 0;
        }
      }
    });

    document.addEventListener('input', () => {
      if (checkpoint_email === 1) {
        next_btn.disabled = false;
      } else {
        next_btn.disabled = true;
      }

      if (checkpoint_verifycode === 1) {
        login_btn.disabled = false;
      } else {
        login_btn.disabled = true;
      }
    });

    // Валидация кода в реальном времени
    verifycode.addEventListener('input', async () => {
      // Сбрасываем состояние кнопки при любом изменении поля
      login_btn.disabled = true;
      checkpoint_verifycode = 0;

      if (!verifycode.value) {
        errorVerifyCode.classList.add('hidden');
        verifycode.classList.remove('border-red-500', 'border-green-500');
        verifycode.classList.add('border-gray-300');
        checkpoint_verifycode = 0;
      } else if (verifycode.value.length !== 4) {
        errorVerifyCode.classList.remove('hidden');
        errorVerifyCode.textContent = 'Код должен состоять из 4 цифр';
        verifycode.classList.remove('border-green-500', 'border-gray-300');
        verifycode.classList.add('border-red-500');
        checkpoint_verifycode = 0;
      } else if (!/^\d{4}$/.test(verifycode.value)) {
        errorVerifyCode.classList.remove('hidden');
        errorVerifyCode.textContent = 'Код должен содержать только цифры';
        verifycode.classList.remove('border-green-500', 'border-gray-300');
        verifycode.classList.add('border-red-500');
        checkpoint_verifycode = 0;
      } else {
        // Проверяем код на сервере в реальном времени
        try {
          const response = await fetch('{{ route("verify.code") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              email: email.value,
              code: verifycode.value
            })
          });

          const data = await response.json();

          if (response.ok && data.valid) {
            errorVerifyCode.textContent = 'Код верный';
            errorVerifyCode.classList.remove('hidden');
            errorVerifyCode.classList.remove('text-red-500');
            errorVerifyCode.classList.add('text-green-500');
            verifycode.classList.remove('border-red-500', 'border-gray-300');
            verifycode.classList.add('border-green-500');
            checkpoint_verifycode = 1;
          } else {
            errorVerifyCode.textContent = data.message || 'Неверный код';
            errorVerifyCode.classList.remove('hidden');
            errorVerifyCode.classList.remove('text-green-500');
            errorVerifyCode.classList.add('text-red-500');
            verifycode.classList.remove('border-green-500', 'border-gray-300');
            verifycode.classList.add('border-red-500');
            checkpoint_verifycode = 0;
          }

          // Обновляем состояние кнопки входа
          login_btn.disabled = checkpoint_verifycode !== 1;
        } catch (error) {
          console.error('Error verifying code:', error);
          errorVerifyCode.textContent = 'Ошибка проверки кода';
          errorVerifyCode.classList.remove('hidden');
          verifycode.classList.remove('border-green-500', 'border-gray-300');
          verifycode.classList.add('border-red-500');
          checkpoint_verifycode = 0;

          // Отключаем кнопку входа при ошибке
          login_btn.disabled = true;
        }
      }
    });

    // Проверка email в форме входа по паролю
    check_email.addEventListener('input', () => {
      saveFormState('password');
      checkpoint_password_email = 0;

      if (!check_email.value) {
        errorEmailPassword.classList.add('hidden');
        check_email.classList.remove('border-red-500', 'border-green-500');
        check_email.classList.add('border-gray-300');
      } else if (!check_email.value.includes('@')) {
        errorEmailPassword.classList.remove('hidden');
        errorEmailPassword.textContent = 'Укажите обязательно @';
        check_email.classList.remove('border-green-500', 'border-gray-300');
        check_email.classList.add('border-red-500');
      } else if (!(/^[\w.-]+@\w[\w.-]+\.\w{2,}$/.test(check_email.value))) {
        errorEmailPassword.classList.remove('hidden');
        errorEmailPassword.textContent = 'Некорректный формат почты';
        check_email.classList.remove('border-green-500', 'border-gray-300');
        check_email.classList.add('border-red-500');
      } else {
        errorEmailPassword.classList.add('hidden');
        check_email.classList.remove('border-red-500', 'border-gray-300');
        check_email.classList.add('border-green-500');
        checkpoint_password_email = 1;
      }

      updatePasswordButton();
    });

    // Проверка пароля
    password.addEventListener('input', () => {
      saveFormState('password');
      checkpoint_password = 0;

      if (!password.value) {
        errorPassword.classList.add('hidden');
        password.classList.remove('border-red-500', 'border-green-500');
        password.classList.add('border-gray-300');
      } else if (password.value.length < 8) {
        errorPassword.classList.remove('hidden');
        errorPassword.textContent = 'Пароль должен содержать минимум 8 символов';
        password.classList.remove('border-green-500', 'border-gray-300');
        password.classList.add('border-red-500');
      } else {
        errorPassword.classList.add('hidden');
        password.classList.remove('border-red-500', 'border-gray-300');
        password.classList.add('border-green-500');
        checkpoint_password = 1;
      }

      updatePasswordButton();
    });

    // Обновление состояния кнопки входа по паролю
    function updatePasswordButton() {
      // Активируем кнопку если оба поля заполнены и email валидный
      // const isEmailValid = check_email.value && check_email.value.includes('@') && /^[\w.-]+@\w[\w.-]+\.\w{2,}$/.test(check_email.value);
      // const isPasswordValid = password.value && password.value.length >= 8;

      // password_submit_btn.disabled = !(isEmailValid && isPasswordValid);

      password_submit_btn.disabled = false;
    }

    async function next() {
      // Показываем состояние загрузки
      next_btn.disabled = true;
      next_btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Отправка кода...';
      next_btn.classList.add('opacity-75', 'cursor-not-allowed');

      try {
        const response = await fetch('{{ route("send.code") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            email: email.value
          })
        });

        const data = await response.json();

        if (response.ok) {
          // Сохраняем email в скрытое поле
          hidden_email.value = email.value;

          // Показываем сообщение об успешной отправке
          errorEmail.textContent = 'Код отправлен на почту';
          errorEmail.classList.remove('hidden');
          errorEmail.classList.remove('text-red-500');
          errorEmail.classList.add('text-green-500');

          // Восстанавливаем кнопку
          next_btn.disabled = false;
          next_btn.innerHTML = 'Продолжить';
          next_btn.classList.remove('opacity-75', 'cursor-not-allowed');

          // Через 1 секунду скрываем сообщение и выполняем переход
          setTimeout(() => {
            errorEmail.classList.add('hidden');
            errorEmail.classList.remove('text-green-500');
            errorEmail.classList.add('text-red-500');

            // Выполняем переход к форме ввода кода
            const main_content = document.getElementById('main_content');
            const end = document.getElementById('end');

            main_content.classList.add('opacity-0');

            setTimeout(() => {
              main_content.classList.add('hidden');
              end.classList.add('opacity-0');
              end.classList.remove('hidden');
              setTimeout(() => {
                end.classList.remove('opacity-0');
              }, 10);
            }, 300);
          }, 1000);
        } else {
          // Восстанавливаем кнопку при ошибке
          next_btn.disabled = false;
          next_btn.innerHTML = 'Продолжить';
          next_btn.classList.remove('opacity-75', 'cursor-not-allowed');

          if (data.errors && data.errors.email) {
            errorEmail.textContent = data.errors.email[0];
            errorEmail.classList.remove('hidden');
            email.classList.add('border-red-500');
          } else {
            errorEmail.textContent = 'Ошибка отправки кода';
            errorEmail.classList.remove('hidden');
          }
        }
      } catch (error) {
        console.error('Error:', error);

        // Восстанавливаем кнопку при ошибке сети
        next_btn.disabled = false;
        next_btn.innerHTML = 'Продолжить';
        next_btn.classList.remove('opacity-75', 'cursor-not-allowed');

        errorEmail.textContent = 'Ошибка отправки кода. Попробуйте еще раз.';
        errorEmail.classList.remove('hidden');
      }
    }

    // Назначаем обработчик на кнопку "Продолжить"
    next_btn.addEventListener('click', () => {
      next();
    });

    function next_password() {
      const code_form = document.getElementById('code_form');
      const password_form = document.getElementById('password_form');

      // Сохраняем состояние
      saveFormState('password');

      code_form.style.transition = 'opacity 0.5s ease-in-out';
      password_form.style.transition = 'opacity 0.5s ease-in-out';

      code_form.classList.add('opacity-0');

      setTimeout(() => {
        code_form.classList.add('hidden');
        password_form.classList.remove('hidden');
        password_form.classList.add('opacity-0');

        setTimeout(() => {
          password_form.classList.remove('opacity-0');
          // Проверяем состояние кнопки после показа формы
          updatePasswordButton();
        }, 50);
      }, 500);
    }

    function back_to_code() {
      const code_form = document.getElementById('code_form');
      const password_form = document.getElementById('password_form');

      // Очищаем сохраненное состояние при возврате к коду
      localStorage.removeItem('authForm');
      localStorage.removeItem('authEmail');

      password_form.style.transition = 'opacity 0.5s ease-in-out';
      code_form.style.transition = 'opacity 0.5s ease-in-out';

      password_form.classList.add('opacity-0');

      setTimeout(() => {
        password_form.classList.add('hidden');
        code_form.classList.remove('hidden');
        code_form.classList.add('opacity-0');

        setTimeout(() => {
          code_form.classList.remove('opacity-0');
        }, 50);
      }, 500);
    }
  </script>

@endsection
