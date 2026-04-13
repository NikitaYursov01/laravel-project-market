<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class Functions
{
    // Кэширование на 5 минут
    private static int $cacheTtl = 300;

    /**
     * Получить последние заказы для главной страницы
     * @param int $limit Количество заказов
     * @return Collection
     */
    public static function getLatestOrders(int $limit = 6): Collection
    {
        return Cache::remember('latest_orders_' . $limit, self::$cacheTtl, function () use ($limit) {
            return Order::with('user')
                ->active()
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Поиск заказов по ключевым словам
     * @param string $query Поисковый запрос
     * @param int $limit Количество результатов
     * @return Collection
     */
    public static function searchOrders(string $query, int $limit = 20): Collection
    {
        if (empty(trim($query))) {
            return collect([]);
        }

        $cacheKey = 'search_orders_' . md5($query) . '_' . $limit;

        return Cache::remember($cacheKey, 60, function () use ($query, $limit) {
            return Order::with('user')
                ->active()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%')
                        ->orWhere('category', 'like', '%' . $query . '%');
                })
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Получить заказы по категории
     * @param string $category Категория
     * @param int $limit Количество
     * @return Collection
     */
    public static function getOrdersByCategory(string $category, int $limit = 20): Collection
    {
        return Cache::remember('orders_category_' . $category . '_' . $limit, self::$cacheTtl, function () use ($category, $limit) {
            return Order::with('user')
                ->active()
                ->where('category', $category)
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Получить заказы пользователя
     * @param int $userId ID пользователя
     * @param int $limit Количество
     * @return Collection
     */
    public static function getUserOrders(int $userId, int $limit = 20): Collection
    {
        return Order::with('user')
            ->byUser($userId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Получить статистику заказов
     * @return array
     */
    public static function getOrdersStats(): array
    {
        return Cache::remember('orders_stats', self::$cacheTtl, function () {
            return [
                'total' => Order::count(),
                'active' => Order::where('status', 'active')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'today' => Order::whereDate('created_at', today())->count(),
            ];
        });
    }

    /**
     * Получить статистику пользователя
     * @param int $userId ID пользователя
     * @return array
     */
    public static function getUserStats(int $userId): array
    {
        return Cache::remember('user_stats_' . $userId, self::$cacheTtl, function () use ($userId) {
            return [
                'orders_count' => Order::byUser($userId)->count(),
                'active_orders' => Order::byUser($userId)->where('status', 'active')->count(),
                'completed_orders' => Order::byUser($userId)->where('status', 'completed')->count(),
                'member_since' => User::find($userId)?->created_at?->format('d.m.Y') ?? 'N/A',
            ];
        });
    }

    /**
     * Получить категории с количеством заказов
     * @return array
     */
    public static function getCategoriesWithCount(): array
    {
        return Cache::remember('categories_count', self::$cacheTtl, function () {
            $categories = [
                'programming' => 'Программирование',
                'design' => 'Дизайн',
                'marketing' => 'Маркетинг',
                'writing' => 'Копирайтинг',
                'other' => 'Другое',
            ];

            $result = [];
            foreach ($categories as $key => $name) {
                $result[] = [
                    'slug' => $key,
                    'name' => $name,
                    'count' => Order::where('category', $key)->where('status', 'active')->count(),
                ];
            }

            return $result;
        });
    }

    /**
     * Форматирование бюджета для отображения
     * @param string $budget Бюджет
     * @return string
     */
    public static function formatBudget(string $budget): string
    {
        // Убираем пробелы и ₽ если есть
        $value = preg_replace('/[^\d]/', '', $budget);

        if (empty($value)) {
            return $budget;
        }

        return number_format((int) $value, 0, '', ' ') . ' ₽';
    }

    /**
     * Получить цвет категории для отображения
     * @param string $category Категория
     * @return string CSS классы
     */
    public static function getCategoryColor(string $category): string
    {
        $colors = [
            'metal_sheet' => 'bg-slate-100 text-slate-800',
            'metal_pipe' => 'bg-zinc-100 text-zinc-800',
            'metal_beam' => 'bg-stone-100 text-stone-800',
            'metal_rebar' => 'bg-orange-100 text-orange-800',
            'metal_wire' => 'bg-amber-100 text-amber-800',
            'metal_processing' => 'bg-blue-100 text-blue-800',
            'metal_products' => 'bg-indigo-100 text-indigo-800',
            'delivery' => 'bg-green-100 text-green-800',
            'other' => 'bg-gray-100 text-gray-800',
        ];

        return $colors[$category] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Получить название категории
     * @param string $category Категория
     * @return string Название
     */
    public static function getCategoryName(string $category): string
    {
        $names = [
            'metal_sheet' => 'Листовой металл',
            'metal_pipe' => 'Трубы металлические',
            'metal_beam' => 'Балки / Швеллер',
            'metal_rebar' => 'Арматура / Сетка',
            'metal_wire' => 'Проволока / Канаты',
            'metal_processing' => 'Обработка металла',
            'metal_products' => 'Металлические изделия',
            'delivery' => 'Доставка / Логистика',
            'other' => 'Другое',
        ];

        return $names[$category] ?? $category;
    }

    /**
     * Очистить кэш заказов
     * @return void
     */
    public static function clearOrdersCache(): void
    {
        Cache::forget('latest_orders_6');
        Cache::forget('orders_stats');
        Cache::forget('categories_count');
        Cache::flush(); // Очистить весь кэш (или можно сделать по паттерну)
    }

    /**
     * Получить название типа объявления
     * @param string $type Тип (client_order или performer_service)
     * @return string Название для отображения
     */
    public static function getOrderTypeLabel(string $type): string
    {
        return match ($type) {
            'client_order' => 'Заказ',
            'performer_service' => 'Услуга',
            default => 'Объявление',
        };
    }

    /**
     * Получить цвет типа объявления
     * @param string $type Тип
     * @return string CSS классы
     */
    public static function getOrderTypeColor(string $type): string
    {
        return match ($type) {
            'client_order' => 'bg-blue-100 text-blue-800 border-blue-200',
            'performer_service' => 'bg-green-100 text-green-800 border-green-200',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Генерация slug из строки
     * @param string $text Исходный текст
     * @param string $separator Разделитель
     * @return string
     */
    public static function slugify(string $text, string $separator = '-'): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        $map = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ы' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ь' => '',
            'ъ' => '',
        ];

        $result = '';
        $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($chars as $char) {
            if (isset($map[$char])) {
                $result .= $map[$char];
            } elseif (preg_match('/[a-z0-9]/', $char)) {
                $result .= $char;
            } else {
                $result .= $separator;
            }
        }

        return trim(preg_replace('/' . preg_quote($separator, '/') . '+/', $separator, $result), $separator);
    }

    public static function getPerformerCategories(): array
    {
        return Cache::remember('performers_categories', self::$cacheTtl, function () {
            $specLabels = [
                'programming' => 'Разработка',
                'design' => 'Дизайн',
                'marketing' => 'Маркетинг',
                'writing' => 'Тексты',
                'other' => 'Управление',
            ];

            $counts = User::query()
                ->where('is_performer', true)
                ->selectRaw('specialization, COUNT(*) as cnt')
                ->groupBy('specialization')
                ->pluck('cnt', 'specialization')
                ->toArray();

            $result = [];
            foreach ($specLabels as $slug => $name) {
                $result[] = [
                    'slug' => $slug,
                    'name' => $name,
                    'count' => (int) ($counts[$slug] ?? 0),
                ];
            }

            return $result;
        });
    }

    /**
     * Получить список исполнителей с поиском по специализации/задаче
     * @param int $limit Количество
     * @param string|null $search Поиск по задаче/специализации/навыкам
     * @param string|null $specialization Фильтр по специализации
     * @param int $page Номер страницы
     * @return array
     */
    public static function getPerformers(int $limit = 12, ?string $search = null, ?string $specialization = null, int $page = 1): array
    {
        $cacheKey = 'performers_' . md5($search . $specialization) . '_' . $limit . '_' . $page;

        return Cache::remember($cacheKey, self::$cacheTtl, function () use ($limit, $search, $specialization, $page) {
            $query = User::query()->where('is_performer', true);

            if ($specialization) {
                $query->where('specialization', $specialization);
            }

            if ($search) {
                $q = mb_strtolower(trim($search));
                $query->where(function ($sub) use ($q) {
                    $sub->whereRaw('LOWER(COALESCE(specialization, "")) LIKE ?', ['%' . $q . '%'])
                        ->orWhereRaw('LOWER(COALESCE(skills, "")) LIKE ?', ['%' . $q . '%'])
                        ->orWhereRaw('LOWER(COALESCE(about, "")) LIKE ?', ['%' . $q . '%']);
                });
            }

            $paginator = $query->orderByDesc('id')->paginate(perPage: $limit, page: $page);

            $data = [];
            foreach ($paginator->items() as $user) {
                $skills = [];
                if (!empty($user->skills)) {
                    $skills = array_values(array_filter(array_map('trim', preg_split('/[,\n]/', (string) $user->skills) ?: [])));
                }

                $data[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'specialization' => $user->specialization ?: 'Специалист',
                    'spec_slug' => $user->specialization ?: 'other',
                    'rating' => 5.0,
                    'reviews' => 0,
                    'experience' => null,
                    'projects' => null,
                    'hourly_rate' => (int) ($user->hourly_rate ?? 0),
                    'tasks' => $user->about ?: '',
                    'skills' => $skills,
                    'avatar_color' => self::getAvatarColor($user->name),
                    'initials' => self::getInitials($user->name),
                ];
            }

            return [
                'data' => $data,
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ];
        });
    }

    /**
     * Получить инициалы пользователя
     * @param string $name Полное имя
     * @return string Инициалы
     */
    public static function getInitials(string $name): string
    {
        $parts = explode(' ', $name);
        $initials = '';

        foreach ($parts as $part) {
            if (!empty($part)) {
                $initials .= mb_substr($part, 0, 1);
            }
        }

        return mb_strtoupper($initials);
    }

    /**
     * Форматирование даты для отображения
     * @param \Illuminate\Support\Carbon|null $date
     * @return string
     */
    public static function formatDate(?\Illuminate\Support\Carbon $date): string
    {
        if (!$date) {
            return 'N/A';
        }

        return $date->format('d.m.Y');
    }

    /**
     * Получить контрастный цвет для аватара
     * @param string $name Имя пользователя
     * @return string CSS цвет фона
     */
    public static function getAvatarColor(string $name): string
    {
        $colors = [
            'bg-red-500',
            'bg-orange-500',
            'bg-amber-500',
            'bg-green-500',
            'bg-emerald-500',
            'bg-teal-500',
            'bg-blue-500',
            'bg-indigo-500',
            'bg-violet-500',
            'bg-purple-500',
            'bg-fuchsia-500',
            'bg-pink-500',
        ];

        // Простая хеш-функция для выбора цвета
        $index = array_sum(array_map('ord', str_split($name))) % count($colors);
        return $colors[$index];
    }
}
