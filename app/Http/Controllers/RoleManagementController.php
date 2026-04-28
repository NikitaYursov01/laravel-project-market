<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleManagementController extends Controller
{
    /**
     * Список доступных ролей
     */
    protected array $availableRoles = [
        'client' => 'Заказчик',
        'performer' => 'Исполнитель',
        'manager' => 'Менеджер',
        'admin' => 'Администратор',
    ];

    /**
     * Показать панель управления ролями
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('auth.role-management', [
            'users' => $users,
            'roles' => $this->availableRoles,
        ]);
    }

    /**
     * Обновить роль пользователя
     */
    public function updateRole(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|in:' . implode(',', array_keys($this->availableRoles)),
        ], [
            'role.required' => 'Выберите роль',
            'role.in' => 'Выбрана недопустимая роль',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Ошибка при обновлении роли');
        }

        // Нельзя изменить роль самому себе
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя изменить свою собственную роль');
        }

        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        return back()->with('success', "Роль пользователя {$user->name} изменена с \"{$this->availableRoles[$oldRole]}\" на \"{$this->availableRoles[$request->role]}\"");
    }

    /**
     * Поиск пользователей
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('auth.role-management', [
            'users' => $users,
            'roles' => $this->availableRoles,
            'searchQuery' => $query,
        ]);
    }
}
