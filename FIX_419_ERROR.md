# Fix Error 419 Page Expired - Login Issue

## Penyebab Utama
Error 419 terjadi karena CSRF token tidak valid atau session tidak tersimpan dengan benar di production.

## Solusi 1: Update .env di Server (PALING PENTING)

Edit file `.env` di server, pastikan setting ini ada dan benar:

```env
APP_URL=https://rumbaathaya.id
APP_ENV=production
APP_DEBUG=false

# Session Settings - PENTING!
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_DOMAIN=rumbaathaya.id
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Sanctum (untuk API)
SANCTUM_STATEFUL_DOMAINS=rumbaathaya.id,www.rumbaathaya.id
```

## Solusi 2: Jalankan Command di Terminal cPanel

```bash
cd ~/public_html

# Set permission
chmod -R 775 ../storage/framework/sessions
chmod -R 775 ../storage/framework/cache

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Cache ulang
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Solusi 3: Cek Tabel Sessions di Database

Pastikan tabel `sessions` ada di database. Jika tidak ada, buat dengan:

```bash
php artisan session:table
php artisan migrate --force
```

## Solusi 4: Temporary Disable CSRF (HANYA UNTUK TESTING)

**JANGAN PAKAI DI PRODUCTION!** Ini hanya untuk testing apakah masalahnya di CSRF.

Edit `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    'login',  // Temporary untuk testing
];
```

Jika setelah ini login berhasil, berarti masalahnya di CSRF token generation.

## Solusi 5: Clear Browser Completely

1. Buka Developer Tools (F12)
2. Klik kanan pada Refresh button → "Empty Cache and Hard Reload"
3. Atau buka Incognito/Private window
4. Clear semua cookies untuk `rumbaathaya.id`

## Solusi 6: Cek Laravel Log

Lihat error detail di:
```bash
tail -50 ../storage/logs/laravel.log
```

## Solusi 7: Pastikan APP_KEY Sudah Di-generate

```bash
php artisan key:generate --force
php artisan config:cache
```

## Urutan Troubleshooting

1. ✅ Update `.env` dengan setting di atas
2. ✅ Jalankan semua command clear cache
3. ✅ Clear browser cache & cookies
4. ✅ Test login di Incognito mode
5. ✅ Cek `storage/logs/laravel.log` untuk error detail
6. ✅ Jika masih error, coba disable CSRF temporary untuk testing

## Kemungkinan Besar Masalahnya

**SESSION_DOMAIN tidak di-set dengan benar!**

Pastikan di `.env`:
```env
SESSION_DOMAIN=rumbaathaya.id
```

Atau gunakan:
```env
SESSION_DOMAIN=.rumbaathaya.id
```

(dengan titik di depan untuk support subdomain)

Setelah edit `.env`, WAJIB jalankan:
```bash
php artisan config:clear
php artisan config:cache
```
