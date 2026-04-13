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
    class="relative w-full max-w-md flex flex-col items-center justify-center border border-blue-600 border-dashed py-6 sm:py-8 px-4 sm:px-10 rounded-3xl bg-white">
      <div class="w-full">

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
            Регистрация для поиска исполнителя
          </h1>

          <p class="text-sm sm:text-base text-center text-gray-500 mb-6 sm:mb-8">
            Введите данные для регистрации<br>в личном кабинете
          </p>


          <!-- ФОРМА РЕГИСТРАЦИИ -->
          <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="email" id="hidden_email" value="{{ old('email') ?? session('email') }}">

            <!-- ПОЧТА -->
            <div class="flex flex-col transition-all duration-500" id="first">
              <div class="relative">
                <input id="email" type="email" placeholder="Электронная почта"
                  value="{{ old('email') ?? session('email') }}"
                  class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors ">
                <span id="errorEmail" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>
              @error('email')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
              @enderror

              <button id="next_btn" onclick="next(); event.preventDefault();"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg transition-colors"
                disabled>
                Продолжить
              </button>
            </div>

            <!-- КОНТАКНТЫЕ ДАННЫЕ -->
            <div class="flex flex-col space-y-4 hidden transition-all duration-500" id="end">
              <div class="relative">
                <input id="name" name="name" type="text" placeholder="Как вас называть?" value="{{ old('name') }}"
                  class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors @error('name') border-red-500 @enderror">
                <span id="errorName" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>
              @error('name')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
              @enderror

              <!-- Выбор роли -->
              <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Кем вы хотите быть?</label>
                <div class="grid grid-cols-2 gap-3">
                  <label class="cursor-pointer">
                    <input type="radio" name="role" value="client" class="peer hidden" {{ old('role', 'client') == 'client' ? 'checked' : '' }}>
                    <div class="px-4 py-3 border-2 border-gray-300 rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-center">
                      <i class="fa fa-briefcase text-blue-600 mb-1"></i>
                      <div class="font-medium text-sm">Заказчик</div>
                      <div class="text-xs text-gray-500">Ищу исполнителей</div>
                    </div>
                  </label>
                  <label class="cursor-pointer">
                    <input type="radio" name="role" value="performer" class="peer hidden" {{ old('role') == 'performer' ? 'checked' : '' }}>
                    <div class="px-4 py-3 border-2 border-gray-300 rounded-lg peer-checked:border-green-600 peer-checked:bg-green-50 transition-all text-center">
                      <i class="fa fa-hammer text-green-600 mb-1"></i>
                      <div class="font-medium text-sm">Исполнитель</div>
                      <div class="text-xs text-gray-500">Ищу заказы</div>
                    </div>
                  </label>
                </div>
                @error('role')
                  <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                @enderror
              </div>

              <div class="relative">
                <input id="password" name="password" type="password" placeholder="Придумайте пароль"
                  class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors @error('password') border-red-500 @enderror">
                <span id="errorPassword" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>
              @error('password')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
              @enderror

              <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password"
                  placeholder="Подтвердите пароль"
                  class="w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors @error('password_confirmation') border-red-500 @enderror">
                <span id="errorPasswordConfirmation" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>
              @error('password_confirmation')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
              @enderror

              <button type="button" id="confirm_btn"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg transition-colors"
                disabled>
                Подтвердить почту
              </button>
            </div>

            <!-- ПОДТВЕРЖДЕНИЕ ПОЧТЫ -->
            <div class="flex flex-col space-y-4 hidden transition-all duration-500" id="confirm">
              <div class="relative">
                <input id="verifycode" name="verifycode" type="text" placeholder="****" maxlength="4"
                  class="tracking-[5px] w-full px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none transition-colors text-center text-lg font-mono @error('verifycode') border-red-500 @enderror">
                <span id="errorVerifyCode" class="text-red-500 text-sm mt-2 block hidden"></span>
              </div>
              @error('verifycode')
                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
              @enderror

              <button type="submit" id="register_btn"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 text-sm sm:text-base rounded-lg transition-colors">
                Зарегистрироваться
              </button>
            </div>

          </form>

          <button onclick="location.href = '{{ route('main') }}'"
            class="hover:scale-95 transition-all duration-500 mt-4 w-full border border-dashed border-blue-600 text-blue-600 font-medium py-3 px-4 text-sm sm:text-base rounded-lg">
            <i class="fas fa-angle-left text-lg text-blue-600"></i> На главную
          </button>

          <!-- Links -->
          <div class="absolute top-5 left-5 mt-6">
            <a href="{{ route('login.form') }}"
              class="text-blue-600 hover:text-blue-700 text-md font-medium items-center flex gap-1">
              <i class="fas fa-angle-left text-lg text-blue-600"></i>
              Войти
            </a>
          </div>

          <!-- Terms -->
          <p class="mt-8 text-center text-sm text-gray-500 leading-relaxed">
            Нажимая «Зарегистрироваться», вы подтверждаете, что принимаете
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
  </div>
</section>

  <script>
    const email = document.getElementById('email');
    const name = document.getElementById('name');
    const password = document.getElementById('password');
    const password_confirmation = document.getElementById('password_confirmation');
    const verifycode = document.getElementById('verifycode');
    const hidden_email = document.getElementById('hidden_email');

    //errors
    const errorEmail = document.getElementById('errorEmail');
    const errorName = document.getElementById('errorName');
    const errorPassword = document.getElementById('errorPassword');
    const errorVerifyCode = document.getElementById('errorVerifyCode');

    //toggle
    let checkpoint_email = 0
    let checkpoint_name = 0
    let checkpoint_password = 0
    let checkpoint_password_confirmation = 0
    let checkpoint_verifycode = 0

    //buttons
    const next_btn = document.getElementById('next_btn');
    const confirm_btn = document.getElementById('confirm_btn');
    const register_btn = document.getElementById('register_btn');

    // Изначально отключаем все кнопки кроме первой
    confirm_btn.disabled = true;
    register_btn.disabled = true;

    //авто смена цвета
    function setBorderState(el, isValid) {
      el.classList.replace(
        isValid ? 'border-red-500' : 'border-green-500',
        isValid ? 'border-green-500' : 'border-red-500'
      );
    }

    email.addEventListener('input', async () => {
      if (!email.value) {
        errorEmail.classList.add('hidden');//скрываем ошибку
        email.classList.add('border-[#D1D5DB]');
        checkpoint_email = 0; //доступ заприщен
      } else if (!email.value.includes('@')) {
        errorEmail.classList.remove('hidden');
        setBorderState(email, false);
        errorEmail.textContent = 'Укажите обязательно @';
        email.classList.add('border-red-500');
        checkpoint_email = 0; //доступ заприщен дальще
      } else if (!(/^[\w.-]+@\w[\w.-]+\.\w{2,}$/.test(email.value))) {
        errorEmail.classList.remove('hidden');
        setBorderState(email, false);
        errorEmail.textContent = 'Некорректный формат почты';
        email.classList.add('border-red-500');
        checkpoint_email = 0; //доступ заприщен дальще
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
            if (data.exists) {
              errorEmail.classList.remove('hidden');
              setBorderState(email, false);
              errorEmail.textContent = data.message;
              email.classList.add('border-red-500');
              checkpoint_email = 0; //доступ заприщен - email уже существует
            } else {
              errorEmail.classList.add('hidden');
              setBorderState(email, true);
              email.classList.add('border-green-500');
              checkpoint_email = 1; //доступ разрешен - email доступен
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

    name.addEventListener('input', () => {
      if (!name.value) {
        errorName.classList.remove('hidden');
        errorName.textContent = 'Поле обязательно';
        setBorderState(name, false);
        name.classList.add('border-red-500');
        checkpoint_name = 0; //доступ заприщен дальшее
      } else {
        errorName.classList.add('hidden');
        setBorderState(name, true);
        name.classList.add('border-green-500');
        checkpoint_name = 1; //доступ разрешен дальшее
      }
    });

    password.addEventListener('input', () => {
      if (!password.value) {
        errorPassword.classList.remove('hidden');
        errorPassword.textContent = 'Поле обязательно';
        setBorderState(password, false);
        password.classList.add('border-red-500');
        checkpoint_password = 0; //доступ заприщен дальще
      } else if (password.value.length < 8) {
        errorPassword.classList.remove('hidden');
        errorPassword.textContent = 'Поле менее 8 символов';
        setBorderState(password, false);
        password.classList.add('border-red-500');
        checkpoint_password = 0; //доступ заприщен дальще
      } else {
        errorPassword.classList.add('hidden');
        setBorderState(password, true);
        password.classList.add('border-green-500');
        checkpoint_password = 1; //доступ разрешен дальше
      }
    });

    password_confirmation.addEventListener('input', () => {
      let errorConfirm = document.getElementById('errorPasswordConfirmation');

      if (!password_confirmation.value) {
        errorConfirm.classList.remove('hidden');
        errorConfirm.textContent = 'Поле обязательно';
        setBorderState(password_confirmation, false);
        password_confirmation.classList.add('border-red-500');
        checkpoint_password_confirmation = 0;
      } else if (password.value !== password_confirmation.value) {
        errorConfirm.classList.remove('hidden');
        errorConfirm.textContent = 'Пароли не совпадают';
        setBorderState(password_confirmation, false);
        password_confirmation.classList.add('border-red-500');
        checkpoint_password_confirmation = 0;
      } else {
        errorConfirm.classList.add('hidden');
        setBorderState(password_confirmation, true);
        password_confirmation.classList.add('border-green-500');
        checkpoint_password_confirmation = 1;
      }
    });

    verifycode.addEventListener('input', async () => {
      // Сбрасываем состояние кнопки при любом изменении поля
      register_btn.disabled = true;
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

          // Обновляем состояние кнопки регистрации
          register_btn.disabled = checkpoint_verifycode !== 1;
        } catch (error) {
          console.error('Error verifying code:', error);
          errorVerifyCode.textContent = 'Ошибка проверки кода';
          errorVerifyCode.classList.remove('hidden');
          verifycode.classList.remove('border-green-500', 'border-gray-300');
          verifycode.classList.add('border-red-500');
          checkpoint_verifycode = 0;

          // Отключаем кнопку регистрации при ошибке
          register_btn.disabled = true;
        }
      }
    });

    document.addEventListener('input', () => {
      if (checkpoint_email === 1) {
        next_btn.disabled = false;
      } else {
        next_btn.disabled = true;
      }

      if (checkpoint_email === 1 && checkpoint_name === 1 && checkpoint_password === 1 && checkpoint_password_confirmation === 1) {
        confirm_btn.disabled = false;
      } else {
        confirm_btn.disabled = true;
      }

      if (checkpoint_verifycode === 1) {
        register_btn.disabled = false;
      } else {
        register_btn.disabled = true;
      }
    });

    function next() {
      const first = document.getElementById('first');
      const end = document.getElementById('end');

      first.classList.add('opacity-0');

      setTimeout(() => {
        first.classList.add('hidden');
        end.classList.add('opacity-0');
        end.classList.remove('hidden');
        setTimeout(() => {
          end.classList.remove('opacity-0');
        }, 10);
      }, 500);
    }

    async function confirm() {
      // Показываем состояние загрузки
      confirm_btn.disabled = true;
      confirm_btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Отправка кода...';
      confirm_btn.classList.add('opacity-75', 'cursor-not-allowed');

      try {
        const response = await fetch('{{ route("send.verification.code") }}', {
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
          errorVerifyCode.textContent = 'Код отправлен на почту';
          errorVerifyCode.classList.remove('hidden');
          errorVerifyCode.classList.remove('text-red-500');
          errorVerifyCode.classList.add('text-green-500');

          // Восстанавливаем кнопку
          confirm_btn.disabled = false;
          confirm_btn.innerHTML = 'Подтвердить почту';
          confirm_btn.classList.remove('opacity-75', 'cursor-not-allowed');

          // Через 1 секунду скрываем сообщение и выполняем переход
          setTimeout(() => {
            errorVerifyCode.classList.add('hidden');
            errorVerifyCode.classList.remove('text-green-500');
            errorVerifyCode.classList.add('text-red-500');

            // Выполняем переход к форме подтверждения
            const end = document.getElementById('end');
            const confirm = document.getElementById('confirm');

            end.classList.add('opacity-0');

            setTimeout(() => {
              end.classList.add('hidden');
              confirm.classList.add('opacity-0');
              confirm.classList.remove('hidden');
              setTimeout(() => {
                confirm.classList.remove('opacity-0');
              }, 10);
            }, 300); // Ускорили анимацию
          }, 1000); // Ускорили ожидание
        } else {
          // Восстанавливаем кнопку при ошибке
          confirm_btn.disabled = false;
          confirm_btn.innerHTML = 'Подтвердить почту';
          confirm_btn.classList.remove('opacity-75', 'cursor-not-allowed');

          if (data.errors && data.errors.email) {
            errorEmail.textContent = data.errors.email[0];
            errorEmail.classList.remove('hidden');
            email.classList.add('border-red-500');
          }
        }
      } catch (error) {
        console.error('Error:', error);

        // Восстанавливаем кнопку при ошибке сети
        confirm_btn.disabled = false;
        confirm_btn.innerHTML = 'Подтвердить почту';
        confirm_btn.classList.remove('opacity-75', 'cursor-not-allowed');

        errorVerifyCode.textContent = 'Ошибка отправки кода. Попробуйте еще раз.';
        errorVerifyCode.classList.remove('hidden');
      }
    }

    // Назначаем обработчик на кнопку "Подтвердить почту"
    confirm_btn.addEventListener('click', () => {
      confirm();
    });
  </script>

@endsection
