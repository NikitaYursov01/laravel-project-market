<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAdminMiddleware
{
    /**
     * Список email, имеющих доступ к управлению ролями
     */
    protected array $allowedEmails = [
        'timqwees@gmail.com',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Проверяем, есть ли у пользователя доступ
        if (!$user || !in_array($user->email, $this->allowedEmails)) {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }
}
