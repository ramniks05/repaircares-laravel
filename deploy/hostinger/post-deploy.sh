#!/usr/bin/env bash
# RepairCares on Hostinger — run from project root after .env is configured.
set -euo pipefail

APP_PATH="${APP_PATH:-$HOME/domains/digitalcreatorss.com/repaircares}"
PHP="${PHP_BIN:-php}"

cd "$APP_PATH"

if [[ ! -f .env ]]; then
  echo "Missing .env — run: cp .env.hostinger.example .env && nano .env"
  exit 1
fi

if command -v composer >/dev/null 2>&1; then
  composer install --no-dev --optimize-autoloader --no-interaction
else
  echo "Composer not in PATH — run composer install manually."
fi

$PHP artisan migrate --force
$PHP artisan db:seed --class=CmsSeeder --force || true
$PHP artisan db:seed --class=RepairCaresBrandImagesSeeder --force || true
$PHP artisan storage:link --force 2>/dev/null || $PHP artisan storage:link

chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

echo "Done: https://digitalcreatorss.com/repaircares"
