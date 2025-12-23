# LMS BIMBEL - Rumba Athaya

Bimbingan belajar dengan konsep "Belajar Asyik, Prestasi Terbaik".

## 🚀 Quick Deploy

Lihat file **DEPLOY.md** untuk panduan deployment lengkap.

### Quick Commands:

**Di Lokal (sebelum upload):**
```bash
npm run build
```

**Di Server (setelah upload):**
```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan storage:link
chmod -R 775 storage public/storage bootstrap/cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📋 Requirements

- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & npm (hanya untuk build assets di lokal)

## 🌐 Website

**Production:** https://rumbaathaya.id/

---

Untuk detail lengkap, lihat **DEPLOY.md**



