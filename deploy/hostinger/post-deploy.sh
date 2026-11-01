#!/usr/bin/env bash
set -euo pipefail

APP_PATH="/home/u922228303/domains/digitalcreatorss.com/public_html/repaircares"
PHP="${PHP_BIN:-php}"

cd "$APP_PATH"

if [[ ! -f .env ]]; then
  echo "Missing .env — copy .env.hostinger.example to .env and configure MySQL first."
  exit 1
fi

if command -v composer >/dev/null 2>&1; then
  composer install --no-dev --optimize-autoloader --no-interaction
else
  echo "Composer not found in PATH; install dependencies manually."
fi

$PHP artisan migrate --force
$PHP artisan db:seed --class=CmsSeeder --force || true
$PHP artisan storage:link --force 2>/dev/null || $PHP artisan storage:link

chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

echo "Done. Open: https://digitalcreatorss.com/repaircares"
