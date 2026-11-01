# Hostinger — go live (digitalcreatorss.com)

On Hostinger SSH, projects live under:

```bash
cd ~/domains/digitalcreatorss.com/<folder>
```

| Project      | Folder        | Example URL                                      |
|-------------|---------------|--------------------------------------------------|
| RepairCares | `repaircares` | https://digitalcreatorss.com/repaircares         |
| Other site  | `jagdamba`    | https://digitalcreatorss.com/jagdamba *(example)* |

Replace `<folder>` with your project directory name (same idea as `jagdamba`).

---

## RepairCares — copy/paste (SSH)

**First-time deploy:**

```bash
cd ~/domains/digitalcreatorss.com/repaircares

git clone https://github.com/ramniks05/repaircares-laravel.git .

cp .env.hostinger.example .env
nano .env

php artisan key:generate
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan db:seed --class=CmsSeeder --force
php artisan storage:link
chmod -R ug+rwx storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Updates after code changes:**

```bash
cd ~/domains/digitalcreatorss.com/repaircares

git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Or one script (after `.env` exists):**

```bash
cd ~/domains/digitalcreatorss.com/repaircares
bash deploy/hostinger/post-deploy.sh
```

**Admin:** https://digitalcreatorss.com/repaircares/admin/login  
(After seed: `admin@techrepair.local` / `password` — change on production.)

---

## `.env` (RepairCares)

```env
APP_URL=https://digitalcreatorss.com/repaircares
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
SESSION_PATH=/repaircares
```

Create MySQL in hPanel → **Databases**, then paste credentials into `.env`.

---

## PHP (hPanel)

**Websites** → **digitalcreatorss.com** → **PHP 8.2+**  
Extensions: `openssl`, `mbstring`, `fileinfo`, `pdo_mysql`, `curl`, `zip`

---

## Another Laravel project (same server pattern)

Use the same steps; only change folder name, git repo, and `APP_URL`:

```bash
cd ~/domains/digitalcreatorss.com/jagdamba

git clone https://github.com/YOUR_USER/YOUR_REPO.git .

cp .env.example .env
nano .env
# APP_URL=https://digitalcreatorss.com/jagdamba
# SESSION_PATH=/jagdamba

php artisan key:generate
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
chmod -R ug+rwx storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Edit root `.htaccess` `RewriteBase` to match the folder (e.g. `/jagdamba/` for that project).

---

## If CSS or links 404 (subfolder)

In `public/.htaccess`, uncomment:

```apache
RewriteBase /repaircares/public/
```

(`/jagdamba/public/` for the jagdamba folder, etc.)

---

## Optional: subdomain (no subfolder in URL)

Point document root to `~/domains/digitalcreatorss.com/repaircares/public` and set:

```env
APP_URL=https://repaircares.digitalcreatorss.com
SESSION_PATH=/
```
