#!/bin/bash

set -e

echo "🚀 Инициализация Laravel проекта..."

# Определение ОС
OS="unknown"
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    OS="linux"
    if [ -f /etc/os-release ]; then
        . /etc/os-release
        DISTRO=$ID
    fi
elif [[ "$OSTYPE" == "darwin"* ]]; then
    OS="macos"
elif [[ "$OSTYPE" == "cygwin" ]] || [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    OS="windows"
fi

echo "📍 Обнаружена ОС: $OS"

# Функция проверки команды
command_exists() {
    command -v "$1" &> /dev/null
}

# Проверка CloudPanel
IS_CLOUDPANEL=false
if command_exists clpctl && [ -d /etc/nginx/sites-enabled ]; then
    IS_CLOUDPANEL=true
    echo "☁️ Обнаружен CloudPanel"
fi

# Автоопределение серверного режима
if [[ "$OS" == "linux" ]] && [[ "$IS_CLOUDPANEL" == true || "$1" == "--server" || -n "$IS_SERVER" ]]; then
    echo "🔧 Активирован режим сервера (автоустановка зависимостей)"
    AUTO_INSTALL=true
else
    AUTO_INSTALL=false
fi

# Автоустановка зависимостей (CloudPanel/сервер)
if [[ "$AUTO_INSTALL" == true ]]; then
    echo "🔧 Проверка зависимостей..."
    
    # Проверка и установка PHP (если нет)
    if ! command_exists php; then
        echo "⬇️ Установка PHP..."
        if [[ "$DISTRO" == "ubuntu" ]] || [[ "$DISTRO" == "debian" ]]; then
            sudo apt-get update
            sudo apt-get install -y php8.3 php8.3-cli php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-curl php8.3-zip php8.3-sqlite3 php8.3-json
        elif [[ "$DISTRO" == "centos" ]] || [[ "$DISTRO" == "rhel" ]] || [[ "$DISTRO" == "fedora" ]]; then
            sudo dnf install -y php php-cli php-mbstring php-xml php-bcmath php-curl php-zip php-pdo php-json
        elif [[ "$DISTRO" == "alpine" ]]; then
            apk add php php-cli php-mbstring php-xml php-bcmath php-curl php-zip php-pdo_sqlite php-json
        else
            echo "⚠️ Неизвестный дистрибутив. Установите PHP вручную."
            exit 1
        fi
    fi
    
    # Проверка и установка Composer
    if ! command_exists composer; then
        echo "⬇️ Установка Composer..."
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php composer-setup.php --install-dir=/usr/local/bin --filename=composer
        php -r "unlink('composer-setup.php');"
        sudo chmod +x /usr/local/bin/composer 2>/dev/null || true
        export PATH="/usr/local/bin:$PATH"
        echo "✓ Composer установлен в /usr/local/bin/composer"
    fi
    
    # Проверка и установка SQLite
    if ! command_exists sqlite3; then
        echo "⬇️ Установка SQLite..."
        if [[ "$DISTRO" == "ubuntu" ]] || [[ "$DISTRO" == "debian" ]]; then
            sudo apt-get install -y sqlite3
        elif [[ "$DISTRO" == "centos" ]] || [[ "$DISTRO" == "rhel" ]] || [[ "$DISTRO" == "fedora" ]]; then
            sudo dnf install -y sqlite
        elif [[ "$DISTRO" == "alpine" ]]; then
            apk add sqlite
        fi
    fi
    
    # Проверка unzip (нужен для Composer)
    if ! command_exists unzip; then
        echo "⬇️ Установка unzip..."
        if [[ "$DISTRO" == "ubuntu" ]] || [[ "$DISTRO" == "debian" ]]; then
            sudo apt-get install -y unzip
        elif [[ "$DISTRO" == "centos" ]] || [[ "$DISTRO" == "rhel" ]] || [[ "$DISTRO" == "fedora" ]]; then
            sudo dnf install -y unzip
        elif [[ "$DISTRO" == "alpine" ]]; then
            apk add unzip
        fi
    fi
    
    echo "✅ Все зависимости установлены"
fi

# Проверка наличия PHP
if ! command_exists php; then
    echo "❌ PHP не установлен. Пожалуйста, установите PHP 8.1+"
    echo "   macOS: brew install php"
    echo "   Ubuntu/Debian: sudo apt install php"
    exit 1
fi

# Проверка наличия Composer (с попыткой локальной установки)
if ! command_exists composer; then
    echo "⚠️ Composer не найден в системе"
    
    # Попытка установить локально для проекта
    echo "⬇️ Попытка локальной установки Composer..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --quiet
    php -r "unlink('composer-setup.php');"
    
    if [ -f composer.phar ]; then
        echo "✓ Composer установлен локально (composer.phar)"
        # Создаем алиас для текущей сессии
        composer() {
            php composer.phar "$@"
        }
        export -f composer 2>/dev/null || true
    else
        echo "❌ Не удалось установить Composer автоматически"
        echo "   Установите вручную: https://getcomposer.org/download/"
        exit 1
    fi
fi

echo "✅ PHP и Composer найдены"

# Установка зависимостей Composer
echo "📦 Установка зависимостей Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader
sleep 1

# Настройка .env
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✓ .env создан из .env.example"
    sleep 1
    if ! grep -qE '^APP_KEY=base64:' .env; then
        php artisan key:generate --force
        echo "✓ APP_KEY сгенерирован"
    else
        echo "✓ APP_KEY уже задан (пропускаю генерацию)"
    fi
else
    echo "✓ .env уже существует"
    if ! grep -qE '^APP_KEY=base64:' .env; then
        php artisan key:generate --force
        echo "✓ APP_KEY сгенерирован"
    else
        echo "✓ APP_KEY уже задан (пропускаю генерацию)"
    fi
fi

sleep 1

# Создание SQLite базы
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "✓ SQLite база создана"
else
    echo "✓ SQLite база уже существует"
fi

sleep 1

# Миграции и сиды
echo "🗄️ Выполнение миграций и сидеров..."
php artisan migrate:fresh --force --seed

sleep 1

# Очистка кэша
echo "🧹 Очистка кэша..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

sleep 1

# Storage link
if [ ! -L public/storage ]; then
    php artisan storage:link
    echo "✓ storage:link создан"
else
    echo "✓ storage:link уже существует"
fi

sleep 1

echo ''
echo '✅ ПРОЕКТ ГОТОВ К РАБОТЕ!'
echo ''
echo '🚀 Запуск: php artisan serve'
echo ''
