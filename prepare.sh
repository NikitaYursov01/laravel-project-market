#!/bin/bash

# ═══════════════════════════════════════════════════════════════
# Профессиональная система подготовки Laravel-проекта к отправке
# ═══════════════════════════════════════════════════════════════

set -euo pipefail

# ─── Цвета ─────────────────────────────────────────────────────
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
GRAY='\033[0;90m'
NC='\033[0m' # No Color
BOLD='\033[1m'

# ─── Переменные ────────────────────────────────────────────────
DRY_RUN=false
SKIP_CHECKS=false
VERBOSE=false

# ─── Функции ─────────────────────────────────────────────────────
log_info() { echo -e "${BLUE}ℹ️  $1${NC}"; }
log_success() { echo -e "${GREEN}✅ $1${NC}"; }
log_warn() { echo -e "${YELLOW}⚠️  $1${NC}"; }
log_error() { echo -e "${RED}❌ $1${NC}"; }
log_step() { echo -e "${CYAN}${BOLD}▸ $1${NC}"; }
log_detail() { echo -e "${GRAY}   $1${NC}"; }

show_help() {
    cat << EOF
Использование: $0 [ОПЦИИ]

Опции:
    -d, --dry-run      Режим симуляции (без реальных изменений)
    -s, --skip-checks  Пропустить проверки окружения
    -v, --verbose      Подробный вывод
    -h, --help         Показать эту справку

Примеры:
    $0                 Обычный запуск
    $0 -d              Проверить что будет сделано
    $0 -v              Подробный режим
EOF
    exit 0
}

parse_args() {
    while [[ $# -gt 0 ]]; do
        case $1 in
            -d|--dry-run) DRY_RUN=true; shift ;;
            -s|--skip-checks) SKIP_CHECKS=true; shift ;;
            -v|--verbose) VERBOSE=true; shift ;;
            -h|--help) show_help ;;
            *) log_error "Неизвестная опция: $1"; exit 1 ;;
        esac
    done
}

cmd() {
    if [ "$DRY_RUN" = true ]; then
        log_detail "[DRY-RUN] $*"
        return 0
    fi
    if [ "$VERBOSE" = true ]; then
        log_detail "→ $*"
    fi
    "$@"
}

check_requirements() {
    log_step "Проверка окружения"
    
    local errors=0
    
    if [ ! -d ".git" ]; then
        log_error "Git репозиторий не найден"
        ((errors++))
    else
        log_detail "Git репозиторий найден"
    fi
    
    if [ ! -f "composer.json" ]; then
        log_warn "composer.json не найден — не Laravel проект?"
    else
        log_detail "composer.json найден"
    fi
    
    if [ ! -f ".env.example" ] && [ ! -f ".env" ]; then
        log_warn "Ни .env, ни .env.example не найдены"
    fi
    
    if [ $errors -gt 0 ]; then
        log_error "Исправьте ошибки и повторите"
        exit 1
    fi
    
    log_success "Окружение проверено"
}

clear_laravel_cache() {
    if [ ! -d "vendor" ]; then
        log_warn "Vendor не установлен — пропускаем очистку кэша"
        return 0
    fi
    
    log_step "Очистка кэша Laravel"
    
    local caches=("cache" "config" "view" "route")
    for cache in "${caches[@]}"; do
        if cmd php artisan "${cache}:clear" 2>/dev/null; then
            log_detail "✓ ${cache}:clear"
        else
            log_detail "○ ${cache}:clear (не требуется)"
        fi
    done
    
    log_success "Кэш очищен"
}

cleanup_git_index() {
    log_step "Очистка git-индекса от локальных файлов"
    
    local items=("vendor" "node_modules" ".env" 
                 "storage/logs" "storage/framework/cache" 
                 "storage/framework/sessions" "storage/framework/views" 
                 "bootstrap/cache")
    
    for item in "${items[@]}"; do
        if git check-ignore -q "$item" 2>/dev/null || true; then
            if cmd git rm -r --cached "$item" 2>/dev/null; then
                log_detail "✓ $item удалён из индекса"
            else
                log_detail "○ $item не в индексе"
            fi
        fi
    done
    
    # Добавляем .env.example если есть
    if [ -f ".env.example" ]; then
        if cmd git add -f ".env.example"; then
            log_detail "✓ .env.example добавлен в индекс"
        fi
    fi
    
    log_success "Индекс очищен"
}

show_changes() {
    log_step "Анализ изменений"
    
    local staged=$(git diff --cached --name-only 2>/dev/null | wc -l | tr -d ' ')
    local unstaged=$(git diff --name-only 2>/dev/null | wc -l | tr -d ' ')
    local untracked=$(git ls-files -o --exclude-standard 2>/dev/null | wc -l | tr -d ' ')
    
    echo ""
    echo -e "${GRAY}┌────────────────────────────────────────${NC}"
    echo -e "${GRAY}│${NC} ${BOLD}Статус репозитория:${NC}"
    echo -e "${GRAY}│${NC}   В индексе:     ${CYAN}${staged}${NC} файлов"
    echo -e "${GRAY}│${NC}   Изменены:      ${YELLOW}${unstaged}${NC} файлов"
    echo -e "${GRAY}│${NC}   Новые:         ${GREEN}${untracked}${NC} файлов"
    echo -e "${GRAY}└────────────────────────────────────────${NC}"
    echo ""
    
    if [ "$staged" -eq 0 ] && [ "$unstaged" -eq 0 ] && [ "$untracked" -eq 0 ]; then
        log_info "Нет изменений для коммита"
        return 1
    fi
    
    # Показываем детальный статус если verbose
    if [ "$VERBOSE" = true ]; then
        echo -e "${GRAY}Детальный статус:${NC}"
        git status -s
        echo ""
    fi
    
    return 0
}

commit_and_push() {
    if [ "$DRY_RUN" = true ]; then
        log_info "DRY-RUN: коммит и push пропущены"
        return 0
    fi
    
    # Добавляем все новые и изменённые файлы (кроме игнорируемых)
    log_step "Добавление файлов в индекс"
    
    # Добавляем untracked файлы
    git ls-files -o --exclude-standard | while read file; do
        if [[ ! "$file" =~ ^(vendor/|node_modules/|\.env) ]]; then
            if cmd git add -f "$file"; then
                log_detail "+ $file"
            fi
        fi
    done
    
    # Добавляем изменённые файлы
    git diff --name-only | while read file; do
        if cmd git add "$file"; then
            log_detail "~ $file"
        fi
    done
    
    # Проверяем есть ли что коммитить
    if git diff --cached --quiet; then
        log_info "Нет изменений для коммита"
        return 0
    fi
    
    # Запрашиваем сообщение коммита
    echo ""
    read -p "💬 Сообщение коммита: " msg
    
    if [ -z "$msg" ]; then
        log_error "Сообщение коммита обязательно"
        return 1
    fi
    
    # Коммит
    log_step "Создание коммита"
    if ! cmd git commit -m "$msg"; then
        log_error "Не удалось создать коммит"
        return 1
    fi
    log_success "Коммит создан: ${CYAN}${msg}${NC}"
    
    # Push
    log_step "Отправка в удалённый репозиторий"
    
    local branch=$(git branch --show-current)
    if cmd git push origin "$branch"; then
        log_success "Отправлено в origin/${CYAN}${branch}${NC}"
    else
        log_error "Push не удался"
        return 1
    fi
}

main() {
    parse_args "$@"
    
    echo ""
    echo -e "${BOLD}╔════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${BOLD}║${NC}     ${CYAN}Подготовка Laravel-проекта к отправке${NC}                 ${BOLD}║${NC}"
    if [ "$DRY_RUN" = true ]; then
        echo -e "${BOLD}║${NC}     ${YELLOW}[DRY-RUN РЕЖИМ]${NC}                                        ${BOLD}║${NC}"
    fi
    echo -e "${BOLD}╚════════════════════════════════════════════════════════════╝${NC}"
    echo ""
    
    # Проверки
    if [ "$SKIP_CHECKS" = false ]; then
        check_requirements
    fi
    
    # Очистка кэша
    clear_laravel_cache
    
    # Очистка индекса
    cleanup_git_index
    
    # Показать изменения
    if ! show_changes; then
        echo ""
        log_info "Работа завершена — нет изменений для отправки"
        exit 0
    fi
    
    # Подтверждение
    if [ "$DRY_RUN" = false ]; then
        echo ""
        read -p "🚀 Выполнить commit и push? (y/N): " -n 1 -r
        echo ""
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            log_info "Отправка отменена пользователем"
            exit 0
        fi
    fi
    
    # Коммит и пуш
    if commit_and_push; then
        echo ""
        echo -e "${GREEN}${BOLD}✨ Проект успешно отправлен в репозиторий!${NC}"
        echo ""
    else
        echo ""
        log_error "Отправка не завершена"
        exit 1
    fi
}

main "$@"