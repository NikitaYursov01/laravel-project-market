<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Profile;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\OrderController;

// главная
Route::get('/', function () {
  return view('home');
})->name('main');

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

// Service Provider Routes (только для авторизованных исполнителей)
Route::prefix('service')->middleware('auth')->group(function () {
  // создание объявления
  Route::get('/create', [ServiceProviderController::class, 'create'])->name('service.create');
  Route::post('/store', [ServiceProviderController::class, 'store'])->name('service.store');
});

// Заказы и маркетплейс
Route::prefix('orders')->group(function () {
  // создание заказа
  Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
  
  // обработка формы заказа
  Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
  
  // лента заказов
  Route::get('/feed', [OrderController::class, 'feed'])->name('orders.feed');
  
  // мои заказы
  Route::get('/my', [OrderController::class, 'my'])->name('orders.my');
  
  // детальная страница заказа
  Route::get('/{id}', [OrderController::class, 'detail'])->name('orders.detail');
});

// Исполнители
Route::prefix('performers')->group(function () {
  // список исполнителей
  Route::get('/', function () {
    return view('performers.index');
  })->name('performers.index');
  
  // профиль исполнителя
  Route::get('/{id}', function ($id) {
    return view('performers.profile', ['performerId' => $id]);
  })->name('performers.profile');
});

// Сообщения
Route::prefix('messages')->group(function () {
  Route::get('/', function () {
    return view('messages.index');
  })->name('messages.index');
  
  Route::get('/{id}', function ($id) {
    return view('messages.chat', ['chatId' => $id]);
  })->name('messages.chat');
});

// Категории
Route::get('/category/{slug}', function ($slug) {
  return view('category', ['categorySlug' => $slug]);
})->name('category');

// Поиск
Route::get('/search', function () {
  return view('search');
})->name('search');

// Условия использования и политика конфиденциальности
Route::get('/term/access', function () {
  return view('term.access');
})->name('term.access');

Route::get('/term/politic', function () {
  return view('term.politic');
})->name('term.politic');
