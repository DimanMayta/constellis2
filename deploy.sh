#!/bin/bash
# ═══════════════════════════════════════════════
# Constellis — Docker Deploy Script
# ═══════════════════════════════════════════════
set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}═══════════════════════════════════════════${NC}"
echo -e "${GREEN}  🚀 Constellis Docker Deploy${NC}"
echo -e "${GREEN}═══════════════════════════════════════════${NC}"

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}📋 No .env found. Creating from .env.docker...${NC}"
    cp .env.docker .env
    echo -e "${RED}⚠️  IMPORTANT: Edit .env with your production values!${NC}"
    echo -e "${RED}   - Set APP_URL to your public IP${NC}"
    echo -e "${RED}   - Change DB_PASSWORD${NC}"
    echo -e "${RED}   - Change DB_ROOT_PASSWORD${NC}"
    echo ""
    read -p "Press Enter after editing .env, or Ctrl+C to cancel..."
fi

# Build and start containers
echo -e "\n${GREEN}🔨 Building containers...${NC}"
docker compose build --no-cache

echo -e "\n${GREEN}🚀 Starting containers...${NC}"
docker compose up -d

# Wait for MySQL to be ready
echo -e "\n${YELLOW}⏳ Waiting for MySQL to be ready...${NC}"
sleep 10
docker compose exec app php -r "
\$tries = 0;
while(\$tries < 30) {
    try {
        new PDO('mysql:host=mysql;port=3306;dbname=constellis', 'constellis', getenv('DB_PASSWORD') ?: 'CambiaEstaPorUnaSegura123!');
        echo 'MySQL is ready!' . PHP_EOL;
        exit(0);
    } catch(Exception \$e) {
        \$tries++;
        echo 'Waiting for MySQL... (' . \$tries . '/30)' . PHP_EOL;
        sleep(2);
    }
}
echo 'MySQL failed to start!' . PHP_EOL;
exit(1);
" 2>/dev/null || true

# First-time setup: generate key if empty
APP_KEY=$(grep "^APP_KEY=" .env | cut -d'=' -f2)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo -e "\n${GREEN}🔑 Generating application key...${NC}"
    docker compose exec app php artisan key:generate --force
fi

# Run migrations
echo -e "\n${GREEN}📦 Running migrations...${NC}"
docker compose exec app php artisan migrate --force

# Check if database is empty (first deploy)
USERS_COUNT=$(docker compose exec app php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tr -d '[:space:]')
if [ "$USERS_COUNT" = "0" ] || [ -z "$USERS_COUNT" ]; then
    echo -e "\n${GREEN}🌱 Seeding database (first deploy)...${NC}"
    docker compose exec app php artisan db:seed --force
fi

# Storage link
echo -e "\n${GREEN}🔗 Creating storage link...${NC}"
docker compose exec app php artisan storage:link --force 2>/dev/null || true

# Cache optimization
echo -e "\n${GREEN}⚡ Optimizing for production...${NC}"
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan filament:cache-components 2>/dev/null || true

# Fix permissions
echo -e "\n${GREEN}🔒 Setting permissions...${NC}"
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

# Status
echo -e "\n${GREEN}═══════════════════════════════════════════${NC}"
echo -e "${GREEN}  ✅ Deploy completado!${NC}"
echo -e "${GREEN}═══════════════════════════════════════════${NC}"
echo ""

# Get public port
APP_PORT=$(grep "^APP_PORT=" .env | cut -d'=' -f2)
APP_PORT=${APP_PORT:-8088}

echo -e "  🌐 Web:    ${YELLOW}http://$(curl -s ifconfig.me 2>/dev/null || echo 'TU_IP'):${APP_PORT}${NC}"
echo -e "  🔧 Admin:  ${YELLOW}http://$(curl -s ifconfig.me 2>/dev/null || echo 'TU_IP'):${APP_PORT}/admin${NC}"
echo ""
echo -e "  📊 Status:     ${GREEN}docker compose ps${NC}"
echo -e "  📜 Logs:       ${GREEN}docker compose logs -f${NC}"
echo -e "  🛑 Parar:      ${GREEN}docker compose down${NC}"
echo -e "  🔄 Actualizar: ${GREEN}git pull && bash deploy.sh${NC}"
echo ""

docker compose ps
