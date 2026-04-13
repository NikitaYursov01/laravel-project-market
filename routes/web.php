<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PerformersController;
use App\Http\Controllers\Profile;
use App\Http\Controllers\OrderController;

// главная
Route::get('/', [HomeController::class, 'index'])->name('main');

// маршруты авторизации (prefix - это заранее написанный первый путь /auth/... а дальше группа запросов)
Route::prefix('auth')->group(function () {

    // профиль (только для авторизованных)
    Route::get('/profile', [Profile::class, 'index'])->name('profile')->middleware('auth');

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

// Заказы и маркетплейс
Route::prefix('orders')->group(function () {
    // лента заказов (доступна всем)
    Route::get('/feed', [OrderController::class, 'feed'])->name('orders.feed');

    // детальная страница заказа
    Route::get('/{id}', [OrderController::class, 'detail'])->name('orders.detail')->where('id', '[0-9]+');

    // принять заказ исполнителем
    Route::post('/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept')->middleware('auth');

    // отправить отклик (создает чат)
    Route::post('/{order}/respond', [OrderController::class, 'respond'])->name('orders.respond')->middleware('auth');

    // создание заказа (только авторизованным)
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create')->middleware('auth');

    // обработка формы заказа (только авторизованным)
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');

    // мои заказы (только авторизованным)
    Route::get('/my', [OrderController::class, 'my'])->name('orders.my')->middleware('auth');

    // редактирование заказа (только автору или админу)
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('auth');
    Route::put('/{order}/update', [OrderController::class, 'update'])->name('orders.update')->middleware('auth');

    // удаление (закрытие) заказа (только автору или админу)
    Route::delete('/{order}/delete', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('auth');
});

// Исполнители
Route::prefix('performers')->group(function () {
    Route::get('/', [PerformersController::class, 'index'])->name('performers.index');
});

// Уведомления
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
});

// Условия использования и политика конфиденциальности
Route::get('/term/access', function () {
    return view('term.access');
})->name('term.access');

Route::get('/term/politic', function () {
    return view('term.politic');
})->name('term.politic');

Route::get('/privacy', function () {
    return view('home.privacy');
})->name('privacy');

// Чаты (только для авторизованных) - простой AJAX чат
Route::middleware(['auth'])->group(function () {
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chat}/message', [ChatController::class, 'storeMessage'])->name('chats.message');
    Route::get('/chats/{chat}/poll', [ChatController::class, 'poll'])->name('chats.poll');
    Route::post('/chats/{chat}/close', [ChatController::class, 'close'])->name('chats.close');
    Route::post('/chats/{chat}/assign-manager', [ChatController::class, 'assignManager'])->name('chats.assign-manager');
});
