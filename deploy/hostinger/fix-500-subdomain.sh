#!/usr/bin/env bash
# Run on server: bash deploy/hostinger/fix-500-subdomain.sh
set -euo pipefail

APP="$HOME/domains/digitalcreatorss.com/public_html/repaircares"
cd "$APP"

echo "=== .env (subdomain) ==="
grep -E '^APP_URL|^SESSION_PATH|^DB_USERNAME|^APP_DEBUG|^APP_KEY' .env || true

echo "=== Clear caches ==="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
rm -f bootstrap/cache/*.php 2>/dev/null || true

echo "=== Permissions ==="
chmod -R ug+rwx storage bootstrap/cache

echo "=== Storage link ==="
cd public
rm -rf storage
ln -sf ../storage/app/public storage
ls -la storage
cd "$APP"

echo "=== Re-cache ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Done. Test: https://repaircares.digitalcreatorss.com/"
echo "If still 500: tail -40 storage/logs/laravel.log"
