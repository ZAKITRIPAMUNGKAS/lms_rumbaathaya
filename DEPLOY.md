# 🚀 DEPLOY KE https://rumbaathaya.id/

## ✅ PERSIAPAN (Di Lokal)

### 1. Build Assets
```bash
npm run build
```

**Verifikasi:**
- ✅ Folder `public/build/` ada
- ✅ File `public/build/manifest.json` ada
- ✅ Folder `public/build/assets/` berisi `.css` dan `.js`

### 2. File yang TIDAK Perlu Di-upload:
- ❌ `node_modules/`
- ❌ `vendor/` (akan diinstall di server)
- ❌ `.git/`
- ❌ `frontend/` (sudah dihapus)
- ❌ `frontend_temp/` (sudah dihapus)
- ❌ `storage/framework/views/*.php` (cache, akan dibuat otomatis)
- ❌ `storage/logs/*.log`

---

## 📤 UPLOAD KE SERVER

### Via cPanel File Manager:
1. Upload semua file kecuali yang disebutkan di atas
2. **PENTING:** Pastikan folder `public/build/` ter-upload

---

## ⚙️ SETUP DI SERVER

### 1. Install Dependencies
```bash
cd /home/rumbaath/public_html
composer install --optimize-autoloader --no-dev
```

### 2. Setup Environment
```bash
# Edit .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rumbaathaya.id

# Database (sesuaikan)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Generate Key & Setup
```bash
php artisan key:generate
php artisan storage:link
chmod -R 775 storage public/storage bootstrap/cache
```

**Verifikasi Storage Link:**
```bash
# Cek apakah symlink sudah benar
ls -la public/storage

# Harus menunjukkan:
# public/storage -> /home/rumbaath/public_html/storage/app/public
# atau
# public/storage -> ../storage/app/public

# Jika symlink salah atau tidak ada, hapus dan buat ulang:
rm public/storage  # Hapus symlink yang salah (jika ada)
php artisan storage:link  # Buat symlink baru

# Verifikasi lagi
readlink -f public/storage
# Harus mengarah ke: /home/rumbaath/public_html/storage/app/public
```

### 4. Clear & Rebuild Cache
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Set Document Root
Di cPanel → Domains → Manage → Set Document Root ke: `/home/rumbaath/public_html/public`

**PENTING:** Setelah set Document Root, pastikan:
- Symlink `public/storage` mengarah ke `storage/app/public`
- Verifikasi dengan: `readlink -f public/storage`
- Harus menunjukkan: `/home/rumbaath/public_html/storage/app/public`

---

## 🔧 FIX CSS TIDAK TER-LOAD

### Masalah: CSS tidak ter-load

**Solusi:**

1. **Pastikan APP_ENV=production di .env:**
   ```bash
   grep APP_ENV .env
   # Harus: APP_ENV=production
   ```

2. **Pastikan build assets ada:**
   ```bash
   ls -la public/build/assets/
   # Harus ada file .css dan .js
   ```

3. **Clear cache:**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan view:cache
   ```

4. **Verifikasi manifest.json:**
   ```bash
   cat public/build/manifest.json
   # Harus ada entry untuk app.css dan app.js
   ```

---

## ✅ CHECKLIST FINAL

- [ ] Build assets (`npm run build`)
- [ ] Upload file ke server (termasuk `public/build/`)
- [ ] Install Composer (`composer install --no-dev`)
- [ ] Setup `.env` (APP_ENV=production, APP_DEBUG=false)
- [ ] Generate key (`php artisan key:generate`)
- [ ] Create storage link (`php artisan storage:link`)
- [ ] Set permissions (`chmod -R 775 storage public/storage bootstrap/cache`)
- [ ] Clear & rebuild cache
- [ ] Set Document Root ke `public/`
- [ ] Test website: https://rumbaathaya.id

---

## 🔗 FIX STORAGE SYMLINK

### Masalah: Storage symlink salah arah atau tidak ada

**Langkah-langkah perbaikan:**

1. **Login ke server via SSH atau Terminal cPanel**

2. **Masuk ke root directory:**
   ```bash
   cd /home/rumbaath/public_html
   ```

3. **Cek symlink saat ini:**
   ```bash
   ls -la public/storage
   # Jika ada, lihat kemana arahnya
   readlink -f public/storage
   ```

4. **Hapus symlink yang salah (jika ada):**
   ```bash
   rm public/storage
   # atau jika tidak bisa:
   unlink public/storage
   ```

5. **Pastikan folder target ada:**
   ```bash
   ls -la storage/app/public
   # Harus ada folder ini
   ```

6. **Buat symlink baru:**
   ```bash
   # Opsi 1: Menggunakan artisan (disarankan)
   php artisan storage:link
   
   # Opsi 2: Manual dengan path relatif
   ln -s ../storage/app/public public/storage
   
   # Opsi 3: Manual dengan absolute path (jika relatif tidak bekerja)
   ln -s /home/rumbaath/public_html/storage/app/public public/storage
   ```

7. **Verifikasi symlink:**
   ```bash
   # Cek apakah symlink sudah benar
   ls -la public/storage
   # Harus menunjukkan: public/storage -> ../storage/app/public
   # atau: public/storage -> /home/rumbaath/public_html/storage/app/public
   
   # Test apakah bisa diakses
   readlink -f public/storage
   # Harus: /home/rumbaath/public_html/storage/app/public
   
   # Test apakah file bisa diakses
   test -r storage/app/public && echo "OK" || echo "ERROR"
   ```

8. **Set permissions:**
   ```bash
   chmod -R 775 storage public/storage bootstrap/cache
   ```

9. **Clear cache:**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   ```

10. **Test di browser:**
    - Buka: `https://rumbaathaya.id/storage/`
    - Harus bisa diakses (tidak 403 atau 404)

---

## 🚨 TROUBLESHOOTING

### CSS tidak ter-load?
1. Cek `APP_ENV=production` di `.env`
2. Cek `public/build/manifest.json` ada
3. Clear cache: `php artisan optimize:clear`
4. Rebuild cache: `php artisan config:cache`

### Storage 403 atau symlink salah arah?
1. **Cek symlink:**
   ```bash
   ls -la public/storage
   # Harus menunjukkan: public/storage -> ../storage/app/public
   # atau: public/storage -> /home/rumbaath/public_html/storage/app/public
   ```

2. **Jika symlink salah arah:**
   ```bash
   # Hapus symlink yang salah
   rm public/storage
   
   # Pastikan berada di root directory
   cd /home/rumbaath/public_html
   
   # Buat symlink baru dengan path relatif (lebih aman)
   php artisan storage:link
   
   # Atau manual jika perlu:
   ln -s ../storage/app/public public/storage
   
   # Verifikasi
   readlink -f public/storage
   # Harus: /home/rumbaath/public_html/storage/app/public
   ```

3. **Set permissions:**
   ```bash
   chmod -R 775 storage public/storage bootstrap/cache
   ```

4. **Cek file `.htaccess` di `public/storage/` ada**

5. **Jika masih error, cek path storage:**
   ```bash
   # Pastikan folder storage/app/public ada
   ls -la storage/app/public
   
   # Pastikan bisa diakses
   test -r storage/app/public && echo "OK" || echo "ERROR"
   ```

---

**Website:** https://rumbaathaya.id/

