#!/bin/bash

set -e

echo "🔍 Проверка окружения перед подготовкой проекта..."
echo ""

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Функция проверки команды
command_exists() {
    command -v "$1" &> /dev/null
}

# Проверка PHP
echo "➡️  Проверка PHP..."
if ! command_exists php; then
    printf "${RED}❌ PHP не установлен${NC}\n"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
if [ "$PHP_MAJOR" -lt 8 ]; then
    printf "${RED}❌ Требуется PHP 8.1+, текущая версия: $PHP_VERSION${NC}\n"
    exit 1
fi
printf "${GREEN}✅ PHP $PHP_VERSION${NC}\n"

# Проверка Composer
echo "➡️  Проверка Composer..."
COMPOSER_CMD="composer"
if ! command_exists composer; then
    if [ -f "composer.phar" ]; then
        COMPOSER_CMD="php composer.phar"
        printf "${YELLOW}⚠️  Composer не найден в PATH, использую composer.phar${NC}\n"
    else
        printf "${RED}❌ Composer не установлен${NC}\n"
        exit 1
    fi
fi
printf "${GREEN}✅ Composer найден${NC}\n"

# Проверка .env
echo "➡️  Проверка .env..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        printf "${YELLOW}⚠️  .env создан из .env.example${NC}\n"
    else
        printf "${RED}❌ .env не найден и .env.example отсутствует${NC}\n"
        exit 1
    fi
else
    printf "${GREEN}✅ .env существует${NC}\n"
fi

# Проверка APP_KEY
echo "➡️  Проверка APP_KEY..."
if ! grep -qE '^APP_KEY=base64:' .env; then
    printf "${YELLOW}⚠️  APP_KEY не задан, генерирую...${NC}\n"
    php artisan key:generate --force
else
    printf "${GREEN}✅ APP_KEY задан${NC}\n"
fi

# Проверка vendor
echo "➡️  Проверка зависимостей Composer..."
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    printf "${YELLOW}⚠️  vendor не найден, устанавливаю зависимости...${NC}\n"
    $COMPOSER_CMD install --no-interaction --prefer-dist --optimize-autoloader
else
    printf "${GREEN}✅ vendor существует${NC}\n"
fi

# Проверка базы данных
echo "➡️  Проверка базы данных..."
DB_CONNECTION=$(php -r "require 'vendor/autoload.php'; echo \$_ENV['DB_CONNECTION'] ?? 'sqlite';")
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f "database/database.sqlite" ]; then
        touch database/database.sqlite
        printf "${YELLOW}⚠️  SQLite база создана${NC}\n"
    fi
fi

# Проверка миграций
echo "➡️  Проверка миграций..."
php artisan migrate:status > /dev/null 2>&1 || {
    printf "${YELLOW}⚠️  Выполняю миграции...${NC}\n"
    php artisan migrate --force
}
printf "${GREEN}✅ Миграции в порядке${NC}\n"

echo ""
echo "🧹 Очистка кэша..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Очистка storage
rm -rf storage/framework/views/*
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/logs/*

# Очистка env
rm -rf .env.backup
rm -rf .env

# Очистка временных файлов
find . -name ".*" -type f ! -name ".env*" ! -name ".env.example" -delete 2>/dev/null || true

echo ""
printf "${GREEN}✅ Подготовка завершена!${NC}\n"
echo ""

# Git операции (опционально)
if [ -d ".git" ]; then
    read -p "📝 Сделать git commit и push? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git add .
        git commit -m "изменения" || echo "Нет изменений для коммита"
        git push || echo "Push не удался"
    fi
fi