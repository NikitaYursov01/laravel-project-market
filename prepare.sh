#!/bin/bash

set -e

echo "✅ Подготовка к отправке в репозиторий..."
echo ""

# Очистка кэша Laravel
echo "🧹 Очистка кэша..."
php artisan cache:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

echo ""

# Проверка изменений
echo "📊 Статус изменений:"
git status -s

echo ""

# Git commit/push
if [ -d ".git" ]; then
    read -p "📝 Сделать commit и push? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        read -p "💬 Сообщение коммита [изменения]: " msg
        msg=${msg:-изменения}

        git add .
        git commit -m "$msg" || echo "Нет изменений для коммита"
        git push || echo "Push не удался"

        echo ""
        echo "✅ Отправлено в репозиторий!"
    else
        echo "⏹️  Отправка отменена"
    fi
else
    echo "❌ Git репозиторий не найден"
fi