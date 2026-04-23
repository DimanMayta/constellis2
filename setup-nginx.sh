#!/bin/bash
# ═══════════════════════════════════════════════════════════════
# NSG Group — Nginx Setup Script
# ═══════════════════════════════════════════════════════════════
# Usage:
#   chmod +x setup-nginx.sh
#   sudo bash setup-nginx.sh
#
# This script:
#   ✅ Installs Nginx (if not present)
#   ✅ Creates the site configuration with security headers
#   ✅ Enables Gzip compression
#   ✅ Configures PHP-FPM socket
#   ✅ Sets up static asset caching (30 days)
#   ✅ Activates the site and removes default
#   ✅ Tests the configuration
#   ✅ Optionally installs SSL via Certbot
# ═══════════════════════════════════════════════════════════════
set -e

# ── Colors ─────────────────────────────────────────────────────
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m'

info()    { echo -e "${GREEN}  ✅ $1${NC}"; }
warn()    { echo -e "${YELLOW}  ⚠️  $1${NC}"; }
error()   { echo -e "${RED}  ❌ $1${NC}"; }
step()    { echo -e "\n${CYAN}${BOLD}── $1 ──${NC}"; }
divider() { echo -e "${GREEN}═══════════════════════════════════════════════════${NC}"; }

# ── Pre-flight checks ─────────────────────────────────────────
divider
echo -e "${GREEN}${BOLD}  🌐 NSG Group — Nginx Setup${NC}"
divider

if [ "$EUID" -ne 0 ]; then
    error "Este script debe ejecutarse como root (sudo bash setup-nginx.sh)"
    exit 1
fi

# ── Get project directory ──────────────────────────────────────
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if [ ! -f "${PROJECT_DIR}/artisan" ]; then
    error "No se encontró el archivo 'artisan'. ¿Estás en el directorio del proyecto?"
    exit 1
fi

echo -e "  📁 Directorio del proyecto: ${YELLOW}${PROJECT_DIR}${NC}"

# ══════════════════════════════════════════════════════════════
# STEP 1: Get domain/IP
# ══════════════════════════════════════════════════════════════
step "1/6 — Configuración del dominio"

# Try to read from .env
if [ -f "${PROJECT_DIR}/.env" ]; then
    APP_URL=$(grep "^APP_URL=" "${PROJECT_DIR}/.env" | cut -d'=' -f2- | tr -d '"' | tr -d "'")
    DOMAIN=$(echo "$APP_URL" | sed 's|https\?://||' | sed 's|/.*||')
fi

# If no domain found, ask
if [ -z "$DOMAIN" ] || [ "$DOMAIN" = "TU_DOMINIO_O_IP" ] || [ "$DOMAIN" = "localhost" ]; then
    PUBLIC_IP=$(curl -s --connect-timeout 5 ifconfig.me 2>/dev/null || echo "")
    echo ""
    echo -e "  ${YELLOW}¿Cuál es tu dominio o IP pública?${NC}"
    if [ -n "$PUBLIC_IP" ]; then
        echo -e "  ${CYAN}(IP pública detectada: ${PUBLIC_IP})${NC}"
    fi
    echo ""
    read -p "  Dominio o IP (ej: nsggroup.com o $PUBLIC_IP): " DOMAIN
    
    if [ -z "$DOMAIN" ] && [ -n "$PUBLIC_IP" ]; then
        DOMAIN="$PUBLIC_IP"
    fi
fi

if [ -z "$DOMAIN" ]; then
    error "No se proporcionó dominio ni IP."
    exit 1
fi

echo -e "  🌐 Dominio/IP: ${YELLOW}${DOMAIN}${NC}"

# Check if it's an IP or domain (for SSL decision later)
IS_IP=false
if [[ "$DOMAIN" =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
    IS_IP=true
fi

info "Dominio configurado: ${DOMAIN}"

# ══════════════════════════════════════════════════════════════
# STEP 2: Install Nginx
# ══════════════════════════════════════════════════════════════
step "2/6 — Instalando Nginx"

if command -v nginx &>/dev/null; then
    NGINX_VER=$(nginx -v 2>&1 | grep -oP '\d+\.\d+\.\d+')
    info "Nginx ${NGINX_VER} ya está instalado"
else
    apt-get update -qq
    apt-get install -y -qq nginx
    info "Nginx instalado"
fi

# Ensure it's running
systemctl start nginx 2>/dev/null || true
systemctl enable nginx 2>/dev/null || true
info "Nginx servicio activo y habilitado"

# ══════════════════════════════════════════════════════════════
# STEP 3: Detect PHP-FPM socket
# ══════════════════════════════════════════════════════════════
step "3/6 — Detectando PHP-FPM"

# Find the PHP-FPM socket
PHP_SOCKET=""
for sock in /run/php/php8.2-fpm.sock /run/php/php8.1-fpm.sock /var/run/php/php-fpm.sock; do
    if [ -S "$sock" ]; then
        PHP_SOCKET="$sock"
        break
    fi
done

if [ -z "$PHP_SOCKET" ]; then
    # Try to find any PHP-FPM socket
    PHP_SOCKET=$(find /run/php/ -name "*.sock" 2>/dev/null | head -1)
fi

if [ -z "$PHP_SOCKET" ]; then
    warn "No se encontró PHP-FPM socket. Usando default: /run/php/php8.2-fpm.sock"
    PHP_SOCKET="/run/php/php8.2-fpm.sock"
else
    info "PHP-FPM socket: ${PHP_SOCKET}"
fi

# ══════════════════════════════════════════════════════════════
# STEP 4: Create Nginx site configuration
# ══════════════════════════════════════════════════════════════
step "4/6 — Creando configuración del sitio"

NGINX_CONF="/etc/nginx/sites-available/nsggroup"

# Backup existing config if present
if [ -f "$NGINX_CONF" ]; then
    BACKUP="${NGINX_CONF}.backup.$(date +%Y%m%d_%H%M%S)"
    cp "$NGINX_CONF" "$BACKUP"
    warn "Configuración anterior respaldada en: ${BACKUP}"
fi

cat > "$NGINX_CONF" << NGINX_EOF
# ═══════════════════════════════════════════════════════════════
# NSG Group — Nginx Configuration
# Generated: $(date '+%Y-%m-%d %H:%M:%S')
# Domain: ${DOMAIN}
# ═══════════════════════════════════════════════════════════════

server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN} www.${DOMAIN};

    root ${PROJECT_DIR}/public;
    index index.php index.html;

    charset utf-8;

    # ── Upload size (match PHP config) ──
    client_max_body_size 64M;

    # ── Security Headers ──────────────────────────────────────
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "camera=(), microphone=(), geolocation=()" always;

    # ── Gzip Compression ──────────────────────────────────────
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 5;
    gzip_min_length 256;
    gzip_types
        text/plain
        text/css
        text/javascript
        application/json
        application/javascript
        application/x-javascript
        application/xml
        application/xml+rss
        image/svg+xml
        font/woff2;

    # ── Static Assets — Cache 30 days ─────────────────────────
    location ~* \.(jpg|jpeg|png|gif|ico|svg|webp|avif|woff2|woff|ttf|eot|otf)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
        access_log off;
        try_files \$uri =404;
    }

    # ── Vite Build Assets — Cache 1 year (hashed filenames) ───
    location /build/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        try_files \$uri =404;
    }

    # ── CSS & JS files ────────────────────────────────────────
    location ~* \.(css|js)$ {
        expires 7d;
        add_header Cache-Control "public";
        access_log off;
        try_files \$uri =404;
    }

    # ── Main Laravel Route ────────────────────────────────────
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # ── PHP-FPM Processing ────────────────────────────────────
    location ~ \.php$ {
        fastcgi_pass unix:${PHP_SOCKET};
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;

        # Performance tuning
        fastcgi_buffering on;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 16 16k;
        fastcgi_connect_timeout 60;
        fastcgi_send_timeout 120;
        fastcgi_read_timeout 120;

        # Hide PHP version
        fastcgi_hide_header X-Powered-By;
    }

    # ── Block dot files (except .well-known for Certbot) ──────
    location ~ /\.(?!well-known) {
        deny all;
    }

    # ── Block access to sensitive files ───────────────────────
    location ~* (\.env|\.git|composer\.(json|lock)|package(-lock)?\.json|artisan)$ {
        deny all;
        return 404;
    }

    # ── Favicon & robots.txt (no logging) ─────────────────────
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    # ── Error pages ───────────────────────────────────────────
    error_page 404 /index.php;

    # ── Logs ──────────────────────────────────────────────────
    access_log /var/log/nginx/nsggroup-access.log;
    error_log  /var/log/nginx/nsggroup-error.log warn;
}
NGINX_EOF

info "Configuración creada: ${NGINX_CONF}"

# Show the config for verification
echo ""
echo -e "  ${CYAN}Configuración generada:${NC}"
echo -e "  ${YELLOW}────────────────────────────────────────${NC}"
echo -e "  server_name:  ${YELLOW}${DOMAIN}${NC}"
echo -e "  root:         ${YELLOW}${PROJECT_DIR}/public${NC}"
echo -e "  php-fpm:      ${YELLOW}${PHP_SOCKET}${NC}"
echo -e "  max upload:   ${YELLOW}64 MB${NC}"
echo -e "  gzip:         ${YELLOW}habilitado${NC}"
echo -e "  cache assets: ${YELLOW}30 días${NC}"
echo -e "  seguridad:    ${YELLOW}headers activados${NC}"
echo -e "  ${YELLOW}────────────────────────────────────────${NC}"

# ══════════════════════════════════════════════════════════════
# STEP 5: Enable site & test
# ══════════════════════════════════════════════════════════════
step "5/6 — Activando sitio"

# Enable the site
ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/nsggroup

# Remove default site if it exists
if [ -f /etc/nginx/sites-enabled/default ]; then
    rm -f /etc/nginx/sites-enabled/default
    info "Sitio default de Nginx deshabilitado"
fi

# Test Nginx configuration
echo ""
echo -e "  ${CYAN}Verificando configuración de Nginx...${NC}"
if nginx -t 2>&1; then
    info "Configuración de Nginx válida ✓"
else
    error "Error en la configuración de Nginx. Revisa el archivo:"
    echo -e "  ${YELLOW}nano ${NGINX_CONF}${NC}"
    exit 1
fi

# Reload Nginx
systemctl reload nginx
info "Nginx recargado con la nueva configuración"

# ══════════════════════════════════════════════════════════════
# STEP 6: SSL (Certbot) — Optional
# ══════════════════════════════════════════════════════════════
step "6/6 — Certificado SSL (HTTPS)"

if [ "$IS_IP" = true ]; then
    warn "Estás usando una IP (${DOMAIN}). Certbot requiere un dominio."
    warn "Para SSL con IP, necesitarás un certificado autofirmado o uno comprado."
    info "Sitio disponible en: http://${DOMAIN}"
else
    echo ""
    echo -e "  ${YELLOW}¿Deseas instalar un certificado SSL gratuito con Certbot?${NC}"
    echo -e "  ${CYAN}(Requiere que el dominio ${DOMAIN} ya apunte a esta IP)${NC}"
    echo ""
    read -p "  Instalar SSL? (s/n): " INSTALL_SSL

    if [[ "$INSTALL_SSL" =~ ^[sS]$ ]]; then
        # Install Certbot
        if ! command -v certbot &>/dev/null; then
            apt-get install -y -qq certbot python3-certbot-nginx
            info "Certbot instalado"
        fi

        echo ""
        read -p "  Email para notificaciones SSL: " SSL_EMAIL

        if [ -z "$SSL_EMAIL" ]; then
            SSL_EMAIL="admin@${DOMAIN}"
        fi

        # Run Certbot
        certbot --nginx \
            -d "${DOMAIN}" \
            -d "www.${DOMAIN}" \
            --non-interactive \
            --agree-tos \
            --email "${SSL_EMAIL}" \
            --redirect

        if [ $? -eq 0 ]; then
            info "✅ Certificado SSL instalado correctamente!"
            info "Renovación automática configurada (certbot renew)"

            # Update APP_URL in .env
            if [ -f "${PROJECT_DIR}/.env" ]; then
                sed -i "s|^APP_URL=http://|APP_URL=https://|" "${PROJECT_DIR}/.env"
                info "APP_URL actualizado a HTTPS en .env"
            fi
        else
            error "Error al instalar SSL. Verifica que el dominio apunte a esta IP."
            warn "Puedes intentar manualmente: sudo certbot --nginx -d ${DOMAIN}"
        fi
    else
        info "SSL omitido. Sitio disponible en: http://${DOMAIN}"
        warn "Puedes instalar SSL después con: sudo certbot --nginx -d ${DOMAIN}"
    fi
fi

# ══════════════════════════════════════════════════════════════
# DONE
# ══════════════════════════════════════════════════════════════
echo ""
divider
echo -e "${GREEN}${BOLD}  ✅ Nginx configurado exitosamente!${NC}"
divider
echo ""

# Determine protocol
if [ -f "/etc/letsencrypt/live/${DOMAIN}/fullchain.pem" ] 2>/dev/null; then
    PROTOCOL="https"
else
    PROTOCOL="http"
fi

echo -e "  🌐 Web:       ${YELLOW}${PROTOCOL}://${DOMAIN}${NC}"
echo -e "  🔧 Admin:     ${YELLOW}${PROTOCOL}://${DOMAIN}/admin${NC}"
echo -e "  🛍️  Store:     ${YELLOW}${PROTOCOL}://${DOMAIN}/store${NC}"
echo ""
echo -e "  ${CYAN}${BOLD}Archivos:${NC}"
echo -e "  📄 Nginx config: ${GREEN}${NGINX_CONF}${NC}"
echo -e "  📄 Access log:   ${GREEN}/var/log/nginx/nsggroup-access.log${NC}"
echo -e "  📄 Error log:    ${GREEN}/var/log/nginx/nsggroup-error.log${NC}"
echo ""
echo -e "  ${CYAN}${BOLD}Comandos útiles:${NC}"
echo -e "  🔄 Recargar:     ${GREEN}sudo systemctl reload nginx${NC}"
echo -e "  🔍 Test config:  ${GREEN}sudo nginx -t${NC}"
echo -e "  📜 Ver logs:     ${GREEN}sudo tail -f /var/log/nginx/nsggroup-error.log${NC}"
echo -e "  ✏️  Editar config: ${GREEN}sudo nano ${NGINX_CONF}${NC}"
if [ "$IS_IP" = false ]; then
    echo -e "  🔒 Renovar SSL:  ${GREEN}sudo certbot renew --dry-run${NC}"
fi
echo ""
