<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegisterForm()
    {
        return view('auth.signup');
    }

    // Показать форму входа
    public function showLoginForm()
    {
        return view('auth.signin');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:8|confirmed',
            'verifycode' => 'required|string|size:4',
            'role' => 'required|string|in:client,performer',
        ], [
            'role.required' => 'Выберите роль: заказчик или исполнитель',
            'role.in' => 'Неверная роль выбрана',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Проверяем код
        if (!EmailVerificationService::verifyCode($request->email, $request->verifycode)) {
            return back()
                ->withErrors(['verifycode' => 'Неверный или просроченный код']);
        }

        // Создаем пользователя с ролью
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_performer' => $request->role === 'performer',
        ]);

        // НЕ авторизуем пользователя сразу, а перенаправляем на вход
        return redirect()->route('login.form');
    }

    // Отправка кода подтверждения при регистрации
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Отправляем код подтверждения
        EmailVerificationService::sendVerificationCode($request->email);

        return response()->json(['success' => true]);
    }

    // Проверка кода в реальном времени
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['valid' => false, 'message' => 'Неверный формат кода'], 422);
        }

        // Проверяем код без пометки как использованный
        $isValid = EmailVerificationService::checkCode($request->email, $request->code);

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Код верный' : 'Неверный или просроченный код'
        ]);
    }

    // Проверка существования email в реальном времени
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['exists' => false, 'message' => 'Некорректный формат email'], 422);
        }

        // Проверяем существование email в базе данных
        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Этот email уже зарегистрирован' : 'Email доступен для регистрации'
        ]);
    }

    // Отправка кода на email
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Отправляем код подтверждения
        EmailVerificationService::sendVerificationCode($request->email);

        return response()->json(['success' => true]);
    }

    // Вход по коду
    public function loginWithCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verifycode' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Проверяем код
        if (!EmailVerificationService::verifyCode($request->email, $request->verifycode)) {
            return back()
                ->withErrors(['verifycode' => 'Неверный или просроченный код'])
                ->withInput();
        }

        // Находим пользователя и авторизуем
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()
                ->withErrors(['email' => 'Пользователь не найден'])
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('profile');
    }

    // Обработка входа по паролю
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
        ]);

        // Проверяем существование пользователя
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()
                ->withErrors(['email' => 'Пользователь с таким email не найден'])
                ->withInput();
        }

        // Пытаемся авторизовать
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Успешный вход - перенаправляем в профиль
            return redirect()->route('profile');
        }

        // Неудачная попытка входа
        return back()
            ->withErrors(['email' => 'Неверный email или пароль'])
            ->withInput();
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}
