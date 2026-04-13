composer update && php artisan migrate:fresh --force 2>&1 && php artisan cache:clear 2>&1 && php artisan config:clear 2>&1 && php artisan view:clear 2>&1 && php artisan route:clear 2>&1

## Очищено:

* **Таблицы** — все данные удалены, структура сохранена
* **Кэш** — очищен полностью
* **Конфиг** — очищен
* **Вью** — очищены
* **Роуты** — очищены
