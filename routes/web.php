<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Profile;

// главная
Route::get('/', function () {
  return view('home');
})->name('main');

  //политика и соглашение
  Route::view('/term/politic', 'term.politic')->name('term.politic');
  Route::view('/term/access', 'term.access')->name('term.access');

// маршруты авторизации (prefix - это заранее написанный первый путь /auth/... а дальше группа запросов)
Route::prefix('auth')->group(function () {

  // профиль (только для авторизованных - middleware проверяет заранее атворизован или нет по классу встроенном в laravel - "auth")
  Route::get('/profile', function () {
    return view('auth.profile');
  })->name('profile')->middleware('auth');

  // вход
  Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('login.form');
  Route::post('/signin', [AuthController::class, 'login'])->name('login');
  Route::post('/login-with-code', [AuthController::class, 'loginWithCode'])->name('login.code');
  Route::post('/send-code', [AuthController::class, 'sendCode'])->name('send.code');

  // регистрация
  Route::get('/signup', [AuthController::class, 'showRegisterForm'])->name('register.form');
  Route::post('/signup', [AuthController::class, 'register'])->name('register');
  Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode'])->name('send.verification.code');
  Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code');
  Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');

  // выход
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  //обновления данных в профиле
  Route::post('/profile/update', [Profile::class, 'UpdateProfile'])->name('profile.update');
});
