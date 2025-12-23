# Fix Error 419 "Page Expired" - Solusi Permanen

## Masalah
Error "This page has expired. Would you like to refresh the page?" muncul terus-menerus saat menggunakan aplikasi.

## Penyebab
1. Session timeout terlalu cepat (default 120 menit)
2. CSRF token expired
3. Cookie session tidak tersimpan dengan benar
4. Session domain tidak di-set

## Solusi Permanen

### 1. Update File `.env` di Server

Edit file `.env` dan tambahkan/update setting berikut:

```env
# Session Settings - PENTING!
SESSION_DRIVER=database
SESSION_LIFETIME=43200
SESSION_EXPIRE_ON_CLOSE=false
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=rumbaathaya.id
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# App Settings
APP_URL=https://rumbaathaya.id
APP_ENV=production
APP_DEBUG=false

# Sanctum (untuk API & SPA)
SANCTUM_STATEFUL_DOMAINS=rumbaathaya.id,www.rumbaathaya.id
```

**Penjelasan:**
- `SESSION_LIFETIME=43200` → Session bertahan 30 hari (43200 menit)
- `SESSION_DOMAIN=rumbaathaya.id` → Cookie bisa diakses di seluruh domain
- `SESSION_SECURE_COOKIE=true` → Cookie hanya dikirim via HTTPS
- `SESSION_SAME_SITE=lax` → Mengizinkan cross-site request yang aman

### 2. Clear Cache di Server

```bash
cd ~/public_html

# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache ulang dengan config baru
php artisan config:cache
php artisan route:cache
```

### 3. Pastikan Tabel Sessions Ada

```bash
# Cek apakah tabel sessions ada
php artisan migrate:status

# Jika belum ada, buat tabel sessions
php artisan session:table
php artisan migrate --force
```

### 4. Set Permission Storage

```bash
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/framework/cache
```

### 5. Clear Browser Cache

Di browser user:
1. Tekan `Ctrl + Shift + Delete`
2. Pilih "Cookies and other site data"
3. Pilih "Cached images and files"
4. Klik "Clear data"

Atau gunakan **Incognito/Private mode** untuk test.

---

## Solusi Tambahan (Jika Masih Error)

### A. Tambahkan Exception untuk Route Tertentu

Edit `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    // Temporary untuk debugging
    // 'livewire/*',  // Uncomment jika Livewire sering error
];
```

### B. Extend Session Lifetime di Middleware

Buat middleware baru untuk auto-extend session:

```bash
php artisan make:middleware ExtendSession
```

Edit `app/Http/Middleware/ExtendSession.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtendSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Extend session lifetime on every request
        config(['session.lifetime' => 43200]); // 30 days
        
        return $next($request);
    }
}
```

Register di `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // ... existing middleware
        \App\Http\Middleware\ExtendSession::class,
    ],
];
```

### C. Gunakan Remember Me

Di form login, tambahkan checkbox "Remember Me":

```blade
<input type="checkbox" name="remember" id="remember">
<label for="remember">Ingat Saya</label>
```

Di controller login:

```php
Auth::attempt($credentials, $request->filled('remember'));
```

---

## Verifikasi Fix Berhasil

### 1. Test Session Lifetime

```bash
# Di terminal server
php artisan tinker

# Jalankan:
config('session.lifetime')
// Output harus: 43200
```

### 2. Test Cookie di Browser

1. Login ke aplikasi
2. Buka Developer Tools (F12)
3. Tab **Application** → **Cookies**
4. Cari cookie `laravel_session` atau `rumba-athaya-session`
5. Cek:
   - **Domain:** `rumbaathaya.id`
   - **Secure:** ✅ Yes
   - **HttpOnly:** ✅ Yes
   - **SameSite:** Lax
   - **Expires:** 30 hari dari sekarang

### 3. Test Idle Time

1. Login ke aplikasi
2. Biarkan browser terbuka tanpa aktivitas selama 1-2 jam
3. Klik menu/link apapun
4. Jika tidak muncul error "Page Expired", berarti FIX BERHASIL! ✅

---

## Monitoring & Maintenance

### Cek Session di Database

```sql
-- Lihat jumlah session aktif
SELECT COUNT(*) FROM sessions;

-- Lihat session detail
SELECT * FROM sessions ORDER BY last_activity DESC LIMIT 10;

-- Hapus session expired (otomatis oleh Laravel)
-- Tapi bisa manual juga:
DELETE FROM sessions WHERE last_activity < UNIX_TIMESTAMP(NOW() - INTERVAL 30 DAY);
```

### Log Error

Jika masih ada error, cek log:

```bash
tail -50 storage/logs/laravel.log | grep -i "419\|csrf\|session"
```

---

## Kesimpulan

Dengan setting di atas:
- ✅ Session bertahan 30 hari
- ✅ Cookie tersimpan dengan benar
- ✅ CSRF token tidak expired
- ✅ User tidak perlu login ulang terus-menerus
- ✅ Error "Page Expired" tidak muncul lagi

**Setelah apply semua setting, clear cache, dan test - error seharusnya HILANG PERMANEN!** 🎉
