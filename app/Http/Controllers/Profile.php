<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Functions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Profile extends Controller
{
    /**
     * Показать профиль с объявлениями пользователя
     */
    public function index()
    {
        $userOrders = Order::with('user')
            ->byUser(auth()->id())
            ->latest()
            ->get();

        $userStats = Functions::getUserStats(auth()->id());

        return view('auth.profile', compact('userOrders', 'userStats'));
    }
    public function UpdateProfile(Request $data)
    {
        $user = auth()->user();

        $validated = $data->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Поле имя обязательно для заполнения',
            'name.string' => 'Поле имя должно быть строкой',
            'name.max' => 'Длина поля имя не должна превышать 255 символов',
            'email.required' => 'Поле адрес электронной почты обязательно для заполнения',
            'email.string' => 'Поле адрес электронной почты должно быть строкой',
            'email.email' => 'Поле адрес электронной почты должно быть действительным адресом электронной почты',
            'email.max' => 'Длина поля адрес электронной почты не должна превышать 255 символов',
            'email.unique' => 'Такой адрес электронной почты уже зарегистрирован',
            'password.string' => 'Поле пароль должно быть строкой',
            'password.min' => 'Длина пароля не должна быть меньше 8 символов',
            'password.confirmed' => 'Пароли не совпадают'
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен');
    }
}
