<?php

namespace App\Services;

use App\Models\EmailVerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class EmailVerificationService
{
    /**
     * Отправляет код подтверждения на email
     */
    public static function sendVerificationCode(string $email): string
    {
        // Очищаем просроченные коды
        EmailVerificationCode::cleanupExpired();

        // Генерируем новый код
        $code = EmailVerificationCode::generateCode($email);

        // Отправляем код
        try {
            Mail::raw("Ваш код подтверждения: {$code}", function ($message) use ($email) {
                $message->to($email)
                    ->subject('Код подтверждения');
            });
        } catch (Throwable $e) {
            Log::error('Failed to send verification code email', [
                'email' => $email,
                'exception' => $e,
            ]);

            throw new RuntimeException('Не удалось отправить письмо с кодом подтверждения. Проверьте настройки почты (MAIL_*) и доступность SMTP.', 0, $e);
        }

        return $code;
    }

    /**
     * Проверяет код подтверждения
     */
    public static function verifyCode(string $email, string $code): bool
    {
        return EmailVerificationCode::verifyCode($email, $code);
    }

    /**
     * Проверяет код подтверждения без пометки как использованный (для реальной проверки)
     */
    public static function checkCode(string $email, string $code): bool
    {
        return EmailVerificationCode::checkCode($email, $code);
    }
}
