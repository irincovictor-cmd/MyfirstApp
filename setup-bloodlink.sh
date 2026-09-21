#!/usr/bin/env bash
# =============================================================================
# BloodLink / MyfirstApp — one-shot setup for WSL Ubuntu
# Run later (not during a tight deadline):
#   bash setup-bloodlink.sh
# =============================================================================
set -euo pipefail

REPO_URL="https://github.com/irincovictor-cmd/MyfirstApp.git"
PROJECT_DIR="${HOME}/project2/myFirstApp"
COMPOSE_DIR="${HOME}/project2"

echo "=============================================="
echo " BloodLink setup"
echo "=============================================="

# --- basic packages ---
if ! command -v git >/dev/null 2>&1; then
  echo "[+] Installing git..."
  sudo apt-get update -y
  sudo apt-get install -y git
fi

if ! command -v curl >/dev/null 2>&1; then
  sudo apt-get update -y
  sudo apt-get install -y curl
fi

# --- Docker ---
if ! command -v docker >/dev/null 2>&1; then
  echo "[+] Docker not found. Install Docker Desktop for Windows,"
  echo "    enable WSL integration, then re-run this script."
  echo "    https://docs.docker.com/desktop/setup/install/windows-install/"
  exit 1
fi

if ! docker info >/dev/null 2>&1; then
  echo "[!] Docker is installed but the daemon is not running."
  echo "    Start Docker Desktop, wait until it is green, re-run."
  exit 1
fi

echo "[+] Docker OK"

# --- project folder ---
mkdir -p "${HOME}/project2"

if [ -d "${PROJECT_DIR}/.git" ]; then
  echo "[+] Repo exists — pulling latest..."
  cd "${PROJECT_DIR}"
  git pull origin main || true
else
  echo "[+] Cloning MyfirstApp..."
  git clone "${REPO_URL}" "${PROJECT_DIR}"
  cd "${PROJECT_DIR}"
fi

# --- start docker compose if present ---
if [ -f "${COMPOSE_DIR}/docker-compose.yml" ]; then
  echo "[+] Starting project2 docker compose..."
  cd "${COMPOSE_DIR}"
  docker compose up -d
elif [ -f "${PROJECT_DIR}/docker-compose.yml" ]; then
  echo "[+] Starting app docker compose..."
  cd "${PROJECT_DIR}"
  docker compose up -d
else
  echo "[!] No docker-compose.yml found in:"
  echo "    ${COMPOSE_DIR}"
  echo "    ${PROJECT_DIR}"
  echo "    If you use the school docker stack, start it the usual way,"
  echo "    then run the artisan steps below manually."
fi

echo "[+] Waiting for containers..."
sleep 5

if docker ps --format '{{.Names}}' | grep -q 'laravel_php'; then
  echo "[+] Using container: laravel_php"
  docker exec -it laravel_php php artisan config:clear || true
  docker exec -it laravel_php php artisan route:clear || true
  docker exec -it laravel_php php artisan view:clear || true
  docker exec -it laravel_php php artisan migrate --force || true
  echo ""
  echo "=============================================="
  echo " DONE"
  echo " Open:  http://localhost:8000/blood"
  echo " Admin: http://localhost:8000/blood/admin"
  echo "=============================================="
  exit 0
fi

if command -v php >/dev/null 2>&1 && [ -f "${PROJECT_DIR}/artisan" ]; then
  echo "[+] No laravel_php container — trying local PHP..."
  cd "${PROJECT_DIR}"
  if [ ! -d vendor ]; then
    if command -v composer >/dev/null 2>&1; then
      composer install
    else
      echo "[!] Install Composer: https://getcomposer.org/"
      exit 1
    fi
  fi
  if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate || true
  fi
  php artisan migrate --force || true
  echo "[+] Starting php artisan serve on :8000"
  echo "    Open http://127.0.0.1:8000/blood"
  php artisan serve --host=127.0.0.1 --port=8000
  exit 0
fi

echo "[!] Could not find laravel_php container or local PHP."
echo "    Install Docker Desktop + school compose stack, or PHP 8.2+ and Composer."
exit 1
