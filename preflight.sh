#!/bin/bash
# ═══════════════════════════════════════════════════════════════
# Constellis / NSG — Server Preflight Check
# ═══════════════════════════════════════════════════════════════
# This script verifies the server is ready for deployment.
# It does NOT install or modify anything — only reads and reports.
#
# Usage:
#   chmod +x preflight.sh
#   sudo bash preflight.sh
#
# Exit codes:
#   0 = All checks passed — safe to run deploy.sh
#   1 = One or more checks failed — fix issues before deploying
# ═══════════════════════════════════════════════════════════════

# ── Colors ─────────────────────────────────────────────────────
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m'

PASS=0
WARN=0
FAIL=0

# ── Helpers ────────────────────────────────────────────────────
pass()  { echo -e "  ${GREEN}✅ PASS${NC}  $1"; ((PASS++)); }
warn_c(){ echo -e "  ${YELLOW}⚠️  WARN${NC}  $1"; ((WARN++)); }
fail_c(){ echo -e "  ${RED}❌ FAIL${NC}  $1"; ((FAIL++)); }
info()  { echo -e "  ${CYAN}ℹ️  INFO${NC}  $1"; }
divider() { echo -e "${GREEN}═══════════════════════════════════════════════════════════${NC}"; }

divider
echo -e "${GREEN}${BOLD}  🔍 Constellis / NSG — Server Preflight Check${NC}"
divider
echo ""

# ══════════════════════════════════════════════════════════════
# CHECK 1: Operating System
# ══════════════════════════════════════════════════════════════
echo -e "${CYAN}${BOLD}── 1. Operating System ──${NC}"

if [ "$(uname)" != "Linux" ]; then
    fail_c "Not a Linux system ($(uname)). This deploy requires Ubuntu/Debian."
else
    pass "Linux detected"
fi

# Check distro
if [ -f /etc/os-release ]; then
    . /etc/os-release
    OS_NAME="$NAME $VERSION"
    echo -e "       OS: ${YELLOW}${OS_NAME}${NC}"

    if [[ "$ID" == "ubuntu" || "$ID" == "debian" ]]; then
        pass "Compatible distro: ${ID}"
    else
        warn_c "Non-standard distro: ${ID}. Script designed for Ubuntu/Debian."
    fi
else
    warn_c "Cannot detect OS distribution"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 2: Running as root
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 2. User Privileges ──${NC}"

if [ "$EUID" -eq 0 ]; then
    pass "Running as root"
else
    fail_c "Not running as root. Run with: sudo bash preflight.sh"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 3: System Resources
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 3. System Resources ──${NC}"

# RAM
TOTAL_RAM_KB=$(grep MemTotal /proc/meminfo | awk '{print $2}')
TOTAL_RAM_MB=$((TOTAL_RAM_KB / 1024))
AVAILABLE_RAM_KB=$(grep MemAvailable /proc/meminfo | awk '{print $2}')
AVAILABLE_RAM_MB=$((AVAILABLE_RAM_KB / 1024))

echo -e "       RAM Total: ${YELLOW}${TOTAL_RAM_MB} MB${NC} | Available: ${YELLOW}${AVAILABLE_RAM_MB} MB${NC}"
if [ "$TOTAL_RAM_MB" -ge 1024 ]; then
    pass "RAM ≥ 1 GB (${TOTAL_RAM_MB} MB)"
elif [ "$TOTAL_RAM_MB" -ge 512 ]; then
    warn_c "RAM is ${TOTAL_RAM_MB} MB — minimum 1 GB recommended"
else
    fail_c "RAM is ${TOTAL_RAM_MB} MB — at least 512 MB required"
fi

# Disk
DISK_AVAILABLE=$(df -BM "$PWD" | tail -1 | awk '{print $4}' | tr -d 'M')
DISK_TOTAL=$(df -BG "$PWD" | tail -1 | awk '{print $2}' | tr -d 'G')
echo -e "       Disk Free: ${YELLOW}${DISK_AVAILABLE} MB${NC} (Total: ${DISK_TOTAL} GB)"
if [ "$DISK_AVAILABLE" -ge 2048 ]; then
    pass "Disk free ≥ 2 GB"
elif [ "$DISK_AVAILABLE" -ge 1024 ]; then
    warn_c "Only ${DISK_AVAILABLE} MB free — 2 GB recommended"
else
    fail_c "Only ${DISK_AVAILABLE} MB free — at least 1 GB required"
fi

# CPU
CPU_CORES=$(nproc 2>/dev/null || echo "?")
echo -e "       CPU Cores: ${YELLOW}${CPU_CORES}${NC}"
if [ "$CPU_CORES" -ge 1 ]; then
    pass "CPU: ${CPU_CORES} core(s)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 4: PHP
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 4. PHP ──${NC}"

if command -v php &>/dev/null; then
    PHP_VERSION=$(php -v | head -1 | grep -oP '\d+\.\d+\.\d+')
    PHP_MAJOR=$(echo "$PHP_VERSION" | cut -d. -f1)
    PHP_MINOR=$(echo "$PHP_VERSION" | cut -d. -f2)
    echo -e "       Version: ${YELLOW}${PHP_VERSION}${NC}"

    if [ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -ge 1 ]; then
        pass "PHP ${PHP_VERSION} (>= 8.1 required)"
    elif [ "$PHP_MAJOR" -ge 9 ]; then
        pass "PHP ${PHP_VERSION}"
    else
        fail_c "PHP ${PHP_VERSION} is too old. Minimum: 8.1"
    fi

    # Check critical extensions
    REQUIRED_EXTS=("pdo_mysql" "mbstring" "xml" "gd" "zip" "bcmath" "intl" "curl" "opcache" "fileinfo" "tokenizer")
    MISSING_EXTS=()

    for ext in "${REQUIRED_EXTS[@]}"; do
        if php -m 2>/dev/null | grep -qi "^${ext}$"; then
            : # installed
        else
            MISSING_EXTS+=("$ext")
        fi
    done

    if [ ${#MISSING_EXTS[@]} -eq 0 ]; then
        pass "All required PHP extensions installed"
        info "Extensions: ${REQUIRED_EXTS[*]}"
    else
        fail_c "Missing PHP extensions: ${MISSING_EXTS[*]}"
        info "Install with: apt install ${MISSING_EXTS[*]/#/php8.2-}"
    fi

    # Check PHP-FPM
    if systemctl is-active --quiet php8.2-fpm 2>/dev/null || systemctl is-active --quiet php8.1-fpm 2>/dev/null; then
        pass "PHP-FPM service is running"
    else
        warn_c "PHP-FPM is not running (deploy.sh will start it)"
    fi
else
    warn_c "PHP is not installed (deploy.sh will install it)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 5: MySQL
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 5. MySQL ──${NC}"

if command -v mysql &>/dev/null; then
    MYSQL_VERSION=$(mysql --version 2>/dev/null | grep -oP '\d+\.\d+\.\d+' | head -1)
    echo -e "       Version: ${YELLOW}${MYSQL_VERSION}${NC}"
    pass "MySQL ${MYSQL_VERSION} installed"

    if systemctl is-active --quiet mysql 2>/dev/null || systemctl is-active --quiet mysqld 2>/dev/null; then
        pass "MySQL service is running"

        # Check if we can connect
        if mysql -u root -e "SELECT 1;" &>/dev/null; then
            pass "MySQL root access works"

            # Check if database exists
            if mysql -u root -e "USE nsggroup;" &>/dev/null; then
                pass "Database 'nsggroup' exists"
                TABLES=$(mysql -u root -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='nsggroup';" 2>/dev/null)
                info "Tables in database: ${TABLES:-0}"
            else
                warn_c "Database 'nsggroup' does not exist (deploy.sh will create it)"
            fi
        else
            warn_c "Cannot connect as root (may need password or auth plugin config)"
        fi
    else
        warn_c "MySQL is not running (deploy.sh will start it)"
    fi
else
    warn_c "MySQL is not installed (deploy.sh will install it)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 6: Composer
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 6. Composer ──${NC}"

if command -v composer &>/dev/null; then
    COMPOSER_VER=$(composer --version 2>/dev/null | grep -oP '\d+\.\d+\.\d+')
    echo -e "       Version: ${YELLOW}${COMPOSER_VER}${NC}"
    pass "Composer ${COMPOSER_VER} installed"
else
    warn_c "Composer not installed (deploy.sh will install it)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 7: Node.js & NPM
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 7. Node.js & NPM ──${NC}"

if command -v node &>/dev/null; then
    NODE_VER=$(node -v 2>/dev/null)
    NODE_MAJOR=$(echo "$NODE_VER" | tr -d 'v' | cut -d. -f1)
    echo -e "       Node: ${YELLOW}${NODE_VER}${NC}"

    if [ "$NODE_MAJOR" -ge 18 ]; then
        pass "Node ${NODE_VER} (>= 18 required)"
    else
        fail_c "Node ${NODE_VER} is too old. Minimum: v18"
    fi
else
    warn_c "Node.js not installed (deploy.sh will install it)"
fi

if command -v npm &>/dev/null; then
    NPM_VER=$(npm -v 2>/dev/null)
    echo -e "       NPM:  ${YELLOW}v${NPM_VER}${NC}"
    pass "NPM ${NPM_VER} installed"
else
    warn_c "NPM not installed (comes with Node.js)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 8: Nginx
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 8. Nginx ──${NC}"

if command -v nginx &>/dev/null; then
    NGINX_VER=$(nginx -v 2>&1 | grep -oP '\d+\.\d+\.\d+')
    echo -e "       Version: ${YELLOW}${NGINX_VER}${NC}"
    pass "Nginx ${NGINX_VER} installed"

    if systemctl is-active --quiet nginx 2>/dev/null; then
        pass "Nginx service is running"
    else
        warn_c "Nginx is not running"
        info "Start with: sudo systemctl start nginx"
    fi

    # Check if constellis site config exists
    if [ -f /etc/nginx/sites-available/nsggroup ] || [ -f /etc/nginx/sites-enabled/nsggroup ]; then
        pass "Nginx site config 'nsggroup' found"
    else
        warn_c "No Nginx site config for 'nsggroup' (configure separately)"
    fi
else
    warn_c "Nginx not installed (install separately — NOT handled by deploy.sh)"
    info "Install with: sudo apt install nginx"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 9: Supervisor
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 9. Supervisor ──${NC}"

if command -v supervisord &>/dev/null; then
    pass "Supervisor installed"
    if systemctl is-active --quiet supervisor 2>/dev/null; then
        pass "Supervisor service is running"
    else
        warn_c "Supervisor is not running (deploy.sh will start it)"
    fi
else
    warn_c "Supervisor not installed (deploy.sh will install it)"
fi

# ══════════════════════════════════════════════════════════════
# CHECK 10: Network & Ports
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 10. Network & Ports ──${NC}"

# Check if ports 80/443 are available or in use by nginx
for PORT in 80 443; do
    PID=$(ss -tlnp 2>/dev/null | grep ":${PORT} " | head -1)
    if [ -n "$PID" ]; then
        PROCESS=$(echo "$PID" | grep -oP 'users:\(\("\K[^"]+')
        info "Port ${PORT}: in use by ${PROCESS:-unknown}"
    else
        info "Port ${PORT}: available"
    fi
done

# Check MySQL port
MYSQL_PID=$(ss -tlnp 2>/dev/null | grep ":3306 " | head -1)
if [ -n "$MYSQL_PID" ]; then
    pass "Port 3306 (MySQL): active"
else
    warn_c "Port 3306 (MySQL): not active"
fi

# Public IP
PUBLIC_IP=$(curl -s --connect-timeout 5 ifconfig.me 2>/dev/null || echo "N/A")
echo -e "       Public IP: ${YELLOW}${PUBLIC_IP}${NC}"

# ══════════════════════════════════════════════════════════════
# CHECK 11: Project Files
# ══════════════════════════════════════════════════════════════
echo ""
echo -e "${CYAN}${BOLD}── 11. Project Files ──${NC}"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if [ -f "${SCRIPT_DIR}/artisan" ]; then
    pass "Laravel project found in ${SCRIPT_DIR}"
else
    fail_c "No artisan file found — is this the right directory?"
fi

if [ -f "${SCRIPT_DIR}/deploy.sh" ]; then
    pass "deploy.sh found"
else
    fail_c "deploy.sh not found!"
fi

if [ -f "${SCRIPT_DIR}/.env" ]; then
    pass ".env file exists"
elif [ -f "${SCRIPT_DIR}/.env.production" ]; then
    warn_c "No .env but .env.production exists (deploy.sh will copy it)"
else
    fail_c "No .env or .env.production found!"
fi

if [ -f "${SCRIPT_DIR}/composer.json" ]; then
    pass "composer.json found"
fi

if [ -f "${SCRIPT_DIR}/package.json" ]; then
    pass "package.json found"
fi

if [ -d "${SCRIPT_DIR}/vendor" ]; then
    info "vendor/ directory exists (Composer deps already installed)"
else
    info "vendor/ not found (deploy.sh will run composer install)"
fi

if [ -d "${SCRIPT_DIR}/node_modules" ]; then
    info "node_modules/ exists (NPM deps already installed)"
else
    info "node_modules/ not found (deploy.sh will run npm ci)"
fi

if [ -d "${SCRIPT_DIR}/public/build" ]; then
    pass "public/build/ exists (Vite assets compiled)"
else
    warn_c "public/build/ not found (deploy.sh will run npm run build)"
fi

# ══════════════════════════════════════════════════════════════
# SUMMARY
# ══════════════════════════════════════════════════════════════
echo ""
divider
echo -e "${BOLD}  📊 PREFLIGHT SUMMARY${NC}"
divider
echo ""
echo -e "  ${GREEN}✅ Passed:  ${PASS}${NC}"
echo -e "  ${YELLOW}⚠️  Warnings: ${WARN}${NC}  (deploy.sh handles these)"
echo -e "  ${RED}❌ Failed:  ${FAIL}${NC}"
echo ""

if [ "$FAIL" -eq 0 ]; then
    echo -e "  ${GREEN}${BOLD}🟢 SERVER IS READY — You can run deploy.sh${NC}"
    echo ""
    echo -e "  Next step: ${YELLOW}sudo bash deploy.sh${NC}"
    echo ""
    exit 0
else
    echo -e "  ${RED}${BOLD}🔴 FIX THE FAILURES ABOVE BEFORE DEPLOYING${NC}"
    echo ""
    echo -e "  After fixing, re-run: ${YELLOW}sudo bash preflight.sh${NC}"
    echo ""
    exit 1
fi
