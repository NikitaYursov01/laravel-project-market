<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_performer',
        'role',
        'specialization',
        'skills',
        'about',
        'hourly_rate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_performer' => 'boolean',
            'role' => 'string',
        ];
    }

    /**
     * Уведомления пользователя
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class)->orderByDesc('created_at');
    }

    /**
     * Непрочитанные уведомления
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Проверка ролей
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isPerformer(): bool
    {
        return $this->role === 'performer';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Получить название роли для отображения
     */
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'client' => 'Заказчик',
            'performer' => 'Исполнитель',
            'manager' => 'Администратор',
            default => 'Пользователь',
        };
    }

    /**
     * Получить цвет роли
     */
    public function getRoleColor(): string
    {
        return match ($this->role) {
            'client' => 'bg-blue-100 text-blue-800',
            'performer' => 'bg-green-100 text-green-800',
            'manager' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
