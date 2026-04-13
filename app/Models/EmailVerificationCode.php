<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Генерирует новый код подтверждения
     */
    public static function generateCode(string $email): string
    {
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Удаляем старые коды для этого email
        self::where('email', $email)->delete();

        // Создаем новый код
        self::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10), // Код действителен 10 минут
            'used' => false,
        ]);

        return $code;
    }

    /**
     * Проверяет валидность кода
     */
    public static function verifyCode(string $email, string $code): bool
    {
        $verification = self::where('email', $email)
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($verification) {
            $verification->update(['used' => true]);
            return true;
        }

        return false;
    }

    /**
     * Проверяет валидность кода без пометки как использованный (для реальной проверки)
     */
    public static function checkCode(string $email, string $code): bool
    {
        return self::where('email', $email)
            ->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }

    /**
     * Очищает просроченные коды
     */
    public static function cleanupExpired()
    {
        self::where('expires_at', '<', now())->delete();
    }
}
