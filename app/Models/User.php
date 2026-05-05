<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Chat;
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверка доступа к управлению ролями по email
     */
    public function canManageRoles(): bool
    {
        $allowedEmails = [
            'timqwees@gmail.com',
        ];

        return in_array($this->email, $allowedEmails);
    }

    /**
     * Получить название роли для отображения
     */
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'client' => 'Заказчик',
            'performer' => 'Исполнитель',
            'manager' => 'Менеджер',
            'admin' => 'Администратор',
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
            'manager' => 'bg-amber-100 text-amber-800',
            'admin' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Получить активные чаты менеджера (только для менеджеров)
     */
    public function managedChats()
    {
        return $this->hasMany(Chat::class, 'manager_id')->where('status', 'active');
    }

    /**
     * Количество активных заказов у менеджера
     */
    public function activeManagedChatsCount(): int
    {
        if (!$this->isManager() && !$this->isAdmin()) {
            return 0;
        }
        return $this->managedChats()->count();
    }

    /**
     * Проверка: может ли менеджер взять еще заказ (лимит 2)
     */
    public function canTakeMoreOrders(): bool
    {
        if (!$this->isManager() && !$this->isAdmin()) {
            return false;
        }
        return $this->activeManagedChatsCount() < 2;
    }

    /**
     * Найти свободного менеджера для автоназначения
     * Приоритет: меньше всего активных заказов
     */
    public static function findAvailableManager(): ?self
    {
        return self::whereIn('role', ['manager', 'admin'])
            ->withCount([
                'managedChats as active_managed_chats_count' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->having('active_managed_chats_count', '<', 2)
            ->orderBy('active_managed_chats_count')
            ->orderBy('id')
            ->first();
    }

    /**
     * Получить загрузку менеджера для отображения
     */
    public function getWorkload(): array
    {
        $active = $this->activeManagedChatsCount();
        return [
            'active' => $active,
            'limit' => 2,
            'available' => 2 - $active,
            'is_full' => $active >= 2,
            'percentage' => ($active / 2) * 100,
        ];
    }
}
