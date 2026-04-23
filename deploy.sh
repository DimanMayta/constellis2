#!/bin/bash
# ═══════════════════════════════════════════════════════════════
# Constellis — Production Server Deploy Script
# ═══════════════════════════════════════════════════════════════
# Usage:
#   1. Upload project to server (git clone, scp, rsync, etc.)
#   2. cd /path/to/constellis
#   3. chmod +x deploy.sh
#   4. sudo bash deploy.sh
#
# This script:
#   ✅ Installs PHP 8.2 + extensions, Composer, Node 20, Supervisor
#   ✅ Installs and configures MySQL 8.0
#   ✅ Creates database and user automatically
#   ✅ Installs dependencies (Composer + NPM)
#   ✅ Builds frontend assets (Vite)
#   ✅ Runs migrations and seeds (first deploy)
#   ✅ Configures Supervisor queue worker
#   ✅ Sets correct permissions
#   ❌ Does NOT configure Nginx (handled separately)
# ═══════════════════════════════════════════════════════════════
set -e

# ── Colors ─────────────────────────────────────────────────────
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

# ── Helpers ────────────────────────────────────────────────────
info()    { echo -e "${GREEN}  ✅ $1${NC}"; }
warn()    { echo -e "${YELLOW}  ⚠️  $1${NC}"; }
error()   { echo -e "${RED}  ❌ $1${NC}"; }
step()    { echo -e "\n${CYAN}${BOLD}── $1 ──${NC}"; }
divider() { echo -e "${GREEN}═══════════════════════════════════════════════════${NC}"; }

# ── Pre-flight checks ─────────────────────────────────────────
divider
echo -e "${GREEN}${BOLD}  🚀 Constellis — Production Server Deploy${NC}"
divider

# Must be root
if [ "$EUID" -ne 0 ]; then
    error "This script must be run as root (sudo bash deploy.sh)"
    exit 1
fi

# Must be Linux
if [ "$(uname)" != "Linux" ]; then
    error "This script is designed for Linux servers (Ubuntu/Debian)"
    exit 1
fi

# Get the project directory (where this script lives)
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"

echo -e "  📁 Project directory: ${YELLOW}${PROJECT_DIR}${NC}"

# Detect web server user
WEB_USER="www-data"
WEB_GROUP="www-data"

# ══════════════════════════════════════════════════════════════
# STEP 1: Install System Dependencies
# ══════════════════════════════════════════════════════════════
step "1/10 — Installing system dependencies"

# Update package lists
apt-get update -qq

# Add PHP 8.2 repository if not available
if ! apt-cache show php8.2 &>/dev/null; then
    warn "Adding PHP 8.2 repository (ppa:ondrej/php)..."
    apt-get install -y -qq software-properties-common
    add-apt-repository -y ppa:ondrej/php
    apt-get update -qq
fi

# Install PHP 8.2 and required extensions + MySQL
PACKAGES=(
    php8.2-fpm
    php8.2-cli
    php8.2-mysql
    php8.2-mbstring
    php8.2-xml
    php8.2-gd
    php8.2-zip
    php8.2-bcmath
    php8.2-intl
    php8.2-curl
    php8.2-opcache
    php8.2-readline
    php8.2-tokenizer
    php8.2-fileinfo
    php8.2-sqlite3
    mysql-server
    mysql-client
    unzip
    curl
    git
    supervisor
    acl
)

# Install all packages
apt-get install -y -qq "${PACKAGES[@]}" 2>/dev/null
info "PHP 8.2, MySQL and extensions installed"

# Verify PHP version
PHP_VERSION=$(php -v | head -1 | cut -d' ' -f2)
info "PHP version: ${PHP_VERSION}"

# ── Install Composer (if not present) ──────────────────────────
if ! command -v composer &>/dev/null; then
    warn "Installing Composer..."
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi
info "Composer: $(composer --version 2>/dev/null | head -1)"

# ── Install Node.js 20 LTS (if not present) ───────────────────
if ! command -v node &>/dev/null || [ "$(node -v | cut -d. -f1 | tr -d 'v')" -lt 18 ]; then
    warn "Installing Node.js 20 LTS..."
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt-get install -y -qq nodejs
fi
info "Node: $(node -v) | NPM: $(npm -v)"

# ══════════════════════════════════════════════════════════════
# STEP 2: Configure PHP for production
# ══════════════════════════════════════════════════════════════
step "2/10 — Configuring PHP for production"

PHP_INI="/etc/php/8.2/fpm/conf.d/99-constellis.ini"
cat > "$PHP_INI" << 'EOF'
; ── Constellis Production PHP Settings ──
upload_max_filesize = 64M
post_max_size = 64M
memory_limit = 256M
max_execution_time = 120
max_input_time = 120

; OPcache
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
opcache.validate_timestamps = 0
opcache.revalidate_freq = 0
opcache.save_comments = 1
EOF

# Also apply to CLI
cp "$PHP_INI" "/etc/php/8.2/cli/conf.d/99-constellis.ini"

# Restart PHP-FPM
systemctl restart php8.2-fpm
systemctl enable php8.2-fpm
info "PHP-FPM configured and running"

# ══════════════════════════════════════════════════════════════
# STEP 3: MySQL Database Setup
# ══════════════════════════════════════════════════════════════
step "3/10 — Configuring MySQL"

# Ensure MySQL is running
systemctl start mysql
systemctl enable mysql

# Read DB credentials from .env.production or .env (if exists)
if [ -f .env ]; then
    ENV_FILE=".env"
elif [ -f .env.production ]; then
    ENV_FILE=".env.production"
else
    ENV_FILE=""
fi

# Default values (override from .env if available)
DB_DATABASE="nsggroup"
DB_USERNAME="nsggroup"
DB_PASSWORD="Nsg\$ecur3_Pr0d!2026"

if [ -n "$ENV_FILE" ]; then
    _DB=$(grep "^DB_DATABASE=" "$ENV_FILE" 2>/dev/null | cut -d'=' -f2- | tr -d '"' | tr -d "'")
    _USER=$(grep "^DB_USERNAME=" "$ENV_FILE" 2>/dev/null | cut -d'=' -f2- | tr -d '"' | tr -d "'")
    _PASS=$(grep "^DB_PASSWORD=" "$ENV_FILE" 2>/dev/null | cut -d'=' -f2- | tr -d '"' | tr -d "'")
    [ -n "$_DB" ] && DB_DATABASE="$_DB"
    [ -n "$_USER" ] && DB_USERNAME="$_USER"
    [ -n "$_PASS" ] && DB_PASSWORD="$_PASS"
fi

# If no password was set in .env, use the default secure one
if [ -z "$DB_PASSWORD" ]; then
    DB_PASSWORD="Nsg\$ecur3_Pr0d!2026"
    warn "Using default MySQL password (set DB_PASSWORD in .env to override)"
fi

# Create database and user (idempotent)
mysql -u root <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS \`${DB_DATABASE}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USERNAME}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON \`${DB_DATABASE}\`.* TO '${DB_USERNAME}'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

info "MySQL database '${DB_DATABASE}' and user '${DB_USERNAME}' ready"

# Verify MySQL connection
if php -r "new PDO('mysql:host=127.0.0.1;port=3306;dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); echo 'OK';" 2>/dev/null | grep -q "OK"; then
    info "MySQL connection verified ✓"
else
    error "Could not connect to MySQL! Check credentials."
    exit 1
fi

# ══════════════════════════════════════════════════════════════
# STEP 4: Environment Configuration
# ══════════════════════════════════════════════════════════════
step "4/10 — Environment configuration"

if [ ! -f .env ]; then
    if [ -f .env.production ]; then
        cp .env.production .env
        warn ".env created from .env.production"
    else
        error "No .env or .env.production found!"
        error "Create .env.production or copy .env.example and configure it."
        exit 1
    fi
fi

# Ensure DB credentials in .env match what we set up
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=mysql|" .env
sed -i "s|^DB_HOST=.*|DB_HOST=127.0.0.1|" .env
sed -i "s|^DB_PORT=.*|DB_PORT=3306|" .env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env

info ".env configured with MySQL credentials"

# Check if APP_URL needs to be set
APP_URL_VAL=$(grep "^APP_URL=" .env | cut -d'=' -f2-)
if [ "$APP_URL_VAL" = "https://TU_DOMINIO_O_IP" ] || [ -z "$APP_URL_VAL" ]; then
    echo ""
    echo -e "  ${RED}${BOLD}⚠️  IMPORTANT: Edit APP_URL in .env!${NC}"
    echo -e "  ${RED}   Current: ${APP_URL_VAL}${NC}"
    echo -e "  ${RED}   Set it to your domain or public IP${NC}"
    echo ""
    read -p "  Press Enter after editing .env, or Ctrl+C to cancel..."
fi

# Generate APP_KEY if empty
APP_KEY=$(grep "^APP_KEY=" .env | cut -d'=' -f2-)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    info "Generating application key..."
    php artisan key:generate --force
fi

# ══════════════════════════════════════════════════════════════
# STEP 5: Install PHP Dependencies
# ══════════════════════════════════════════════════════════════
step "5/10 — Installing PHP dependencies (Composer)"

# Install without dev dependencies, optimized autoloader
composer install --no-dev --optimize-autoloader --no-interaction --no-progress
info "Composer dependencies installed"

# ══════════════════════════════════════════════════════════════
# STEP 6: Build Frontend Assets
# ══════════════════════════════════════════════════════════════
step "6/10 — Building frontend assets (Vite)"

# Install NPM dependencies and build
npm ci --no-audit --no-fund
npm run build

# Remove hot file if it exists (ensures production build is used)
rm -f public/hot

info "Frontend assets built"

# ══════════════════════════════════════════════════════════════
# STEP 7: Database Migrations & Seed
# ══════════════════════════════════════════════════════════════
step "7/10 — Running database migrations"

# Run migrations
php artisan migrate --force
info "Migrations completed"

# ── Migrate data from SQLite (if database.sqlite exists) ────────
SQLITE_PATH="${PROJECT_DIR}/database/database.sqlite"
if [ -f "$SQLITE_PATH" ]; then
    step "7b/10 — Migrating data from SQLite → MySQL"

    # Install SQLite PHP extension if not present
    if ! php -m | grep -qi sqlite; then
        warn "Installing php8.2-sqlite3 for data migration..."
        apt-get install -y -qq php8.2-sqlite3
    fi

    info "SQLite database found at: ${SQLITE_PATH}"
    info "Running data migration..."

    php artisan app:migrate-sqlite-to-mysql \
        --sqlite-path="${SQLITE_PATH}" \
        --force

    if [ $? -eq 0 ]; then
        info "✅ Data migrated from SQLite → MySQL successfully!"

        # Rename SQLite file so it doesn't re-import on next deploy
        mv "$SQLITE_PATH" "${SQLITE_PATH}.migrated"
        info "SQLite file renamed to database.sqlite.migrated (won't re-import)"
    else
        warn "Data migration had issues — check output above"
        warn "You can retry manually: php artisan app:migrate-sqlite-to-mysql"
    fi
else
    # Seed if first deploy (no users exist)
    USERS_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tr -d '[:space:]')
    if [ "$USERS_COUNT" = "0" ] || [ -z "$USERS_COUNT" ]; then
        warn "Empty database detected — running seeders..."
        php artisan db:seed --force
        info "Database seeded"
    else
        info "Database has ${USERS_COUNT} users — skipping seed"
    fi
fi

# ══════════════════════════════════════════════════════════════
# STEP 8: Laravel Optimization
# ══════════════════════════════════════════════════════════════
step "8/10 — Laravel production optimization"

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache 2>/dev/null || true
php artisan filament:cache-components 2>/dev/null || true

info "All caches built (config, routes, views, events, filament)"

# ══════════════════════════════════════════════════════════════
# STEP 9: Supervisor (Queue Worker)
# ══════════════════════════════════════════════════════════════
step "9/10 — Configuring Supervisor (queue worker)"

SUPERVISOR_CONF="/etc/supervisor/conf.d/constellis-worker.conf"
cat > "$SUPERVISOR_CONF" << EOF
[program:constellis-worker]
process_name=%(program_name)s_%(process_num)02d
command=php ${PROJECT_DIR}/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=${WEB_USER}
numprocs=1
redirect_stderr=true
stdout_logfile=${PROJECT_DIR}/storage/logs/queue.log
stopwaitsecs=3600
EOF

supervisorctl reread
supervisorctl update
supervisorctl restart constellis-worker:* 2>/dev/null || supervisorctl start constellis-worker:* 2>/dev/null || true
info "Queue worker configured and running"

# ══════════════════════════════════════════════════════════════
# STEP 10: Permissions
# ══════════════════════════════════════════════════════════════
step "10/10 — Setting file permissions"

# Ownership on writable directories
chown -R ${WEB_USER}:${WEB_GROUP} storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Log directory
mkdir -p storage/logs
chown -R ${WEB_USER}:${WEB_GROUP} storage/logs

info "Permissions set for www-data"

# ══════════════════════════════════════════════════════════════
# DONE
# ══════════════════════════════════════════════════════════════
echo ""
divider
echo -e "${GREEN}${BOLD}  ✅ Deploy completado exitosamente!${NC}"
divider
echo ""

# Get APP_URL from .env
APP_URL=$(grep "^APP_URL=" .env | cut -d'=' -f2-)
APP_URL=${APP_URL:-"http://TU_IP"}

echo -e "  🌐 Web:       ${YELLOW}${APP_URL}${NC}"
echo -e "  🔧 Admin:     ${YELLOW}${APP_URL}/admin${NC}"
echo -e "  📁 Project:   ${YELLOW}${PROJECT_DIR}${NC}"
echo -e "  🗄️  Database:  ${YELLOW}MySQL → ${DB_DATABASE}@127.0.0.1${NC}"
echo ""
echo -e "  ${CYAN}${BOLD}Comandos útiles:${NC}"
echo -e "  📊 Queue status:     ${GREEN}sudo supervisorctl status constellis-worker:*${NC}"
echo -e "  📜 App logs:         ${GREEN}tail -f ${PROJECT_DIR}/storage/logs/laravel.log${NC}"
echo -e "  📜 Queue logs:       ${GREEN}tail -f ${PROJECT_DIR}/storage/logs/queue.log${NC}"
echo -e "  🔄 Re-deploy:        ${GREEN}cd ${PROJECT_DIR} && sudo bash deploy.sh${NC}"
echo -e "  🧹 Clear caches:     ${GREEN}php artisan optimize:clear${NC}"
echo -e "  🗄️  MySQL console:   ${GREEN}mysql -u ${DB_USERNAME} -p ${DB_DATABASE}${NC}"
echo -e "  🗄️  DB backup:       ${GREEN}mysqldump -u ${DB_USERNAME} -p ${DB_DATABASE} > backup_\$(date +%Y%m%d).sql${NC}"
echo ""
echo -e "  ${RED}${BOLD}⚠️  RECUERDA: Configurar Nginx por separado${NC}"
echo -e "  ${RED}   PHP-FPM socket: /run/php/php8.2-fpm.sock${NC}"
echo -e "  ${RED}   Document root:  ${PROJECT_DIR}/public${NC}"
echo ""
