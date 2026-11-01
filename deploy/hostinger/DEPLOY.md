# Deploy RepairCares on Hostinger (live path)

**Server path:**  
`/home/u922228303/domains/digitalcreatorss.com/public_html/repaircares`

**Public URL (subfolder):**  
`https://digitalcreatorss.com/repaircares`

**Admin:**  
`https://digitalcreatorss.com/repaircares/admin/login`  
Default after seed: `admin@techrepair.local` / `password` — change password after go-live.

---

## 1. PHP version (hPanel)

1. **Websites** → **digitalcreatorss.com** → **PHP Configuration**
2. Select **PHP 8.2** or **8.3**
3. Enable extensions: `openssl`, `mbstring`, `fileinfo`, `pdo_mysql`, `curl`, `zip`

---

## 2. MySQL database

1. hPanel → **Databases** → **MySQL Databases**
2. Create database + user (note host, name, user, password)
3. Assign user to database with **All privileges**

---

## 3. Upload the project

### Option A — Git (recommended)

SSH into Hostinger (hPanel → **Advanced** → **SSH Access**), then:

```bash
cd /home/u922228303/domains/digitalcreatorss.com/public_html/repaircares

# First time only (empty folder):
git clone https://github.com/ramniks05/repaircares-laravel.git .

# Updates later:
git pull origin main
```

### Option B — File Manager / FTP

Upload the whole Laravel project **into** `public_html/repaircares/` so you have:

```
repaircares/
  app/
  bootstrap/
  config/
  public/
  routes/
  vendor/          ← run composer on server, or upload vendor from local
  .htaccess        ← routes traffic into public/
  ...
```

Do **not** put `.env` in Git; create it on the server (step 4).

---

## 4. Environment file

On the server:

```bash
cd /home/u922228303/domains/digitalcreatorss.com/public_html/repaircares
cp .env.hostinger.example .env
nano .env   # or edit in File Manager
```

Set:

- `APP_URL=https://digitalcreatorss.com/repaircares`
- MySQL `DB_*` values from hPanel
- `APP_DEBUG=false` on production

Generate key:

```bash
php artisan key:generate
```

---

## 5. Install dependencies & Laravel setup

```bash
cd /home/u922228303/domains/digitalcreatorss.com/public_html/repaircares

composer install --no-dev --optimize-autoloader

php artisan migrate --force
php artisan db:seed --class=CmsSeeder --force

php artisan storage:link

chmod -R ug+rwx storage bootstrap/cache
```

If `composer` is not in PATH:

```bash
/usr/local/bin/composer install --no-dev --optimize-autoloader
```

Or install dependencies locally and upload the `vendor/` folder.

---

## 6. Optimize for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

After changing `.env`, run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

## 7. Subfolder URL fixes (if you see 404 on links or CSS)

1. Root `.htaccess` already uses `RewriteBase /repaircares/`.
2. If assets still fail, edit `public/.htaccess` and **uncomment**:
   ```apache
   RewriteBase /repaircares/public/
   ```
3. Confirm `APP_URL` in `.env` matches exactly (no trailing slash).

---

## 8. Better URL (optional): subdomain

In hPanel, create **subdomain** `repaircares.digitalcreatorss.com` with document root:

`/home/u922228303/domains/digitalcreatorss.com/public_html/repaircares/public`

Then set:

```env
APP_URL=https://repaircares.digitalcreatorss.com
SESSION_PATH=/
```

Remove or simplify root `.htaccess` `RewriteBase` (document root is already `public/`).

---

## 9. Quick checklist

| Step | Done |
|------|------|
| PHP 8.2+ & extensions | ☐ |
| MySQL created & `.env` updated | ☐ |
| `composer install --no-dev` | ☐ |
| `php artisan key:generate` | ☐ |
| `migrate` + `db:seed` | ☐ |
| `storage:link` + folder permissions | ☐ |
| `APP_DEBUG=false` | ☐ |
| Site opens at `/repaircares` | ☐ |
| Admin login works | ☐ |

---

## 10. One-shot script (SSH)

From project root on server:

```bash
bash deploy/hostinger/post-deploy.sh
```

Edit `APP_PATH` inside the script if your path differs.
