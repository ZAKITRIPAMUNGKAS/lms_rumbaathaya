# Fix 403 Forbidden Error - Storage Images

## Masalah
Gambar di `/storage/posts/thumbnails/` mengembalikan error 403 Forbidden.

## Penyebab
1. Symbolic link `public/storage` belum dibuat
2. Permission folder storage salah
3. File gambar tidak ada

## Solusi

### 1. Buat Symbolic Link
```bash
cd ~/public_html

# Hapus link lama jika ada
rm -rf storage

# Buat link baru
php artisan storage:link
```

### 2. Set Permission yang Benar
```bash
# Set permission storage
chmod -R 755 ../storage/app/public

# Set permission public/storage link
chmod -R 755 storage
```

### 3. Verifikasi Link
```bash
ls -la storage
```

Output yang benar:
```
lrwxrwxrwx ... storage -> ../../storage/app/public
```

### 4. Test Upload Gambar
Upload gambar test via admin panel untuk memastikan:
- File tersimpan di `storage/app/public/posts/thumbnails/`
- Bisa diakses via `https://rumbaathaya.id/storage/posts/thumbnails/namafile.jpg`

### 5. Jika Masih 403
Cek `.htaccess` di folder `public_html/storage/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine Off
</IfModule>

# Allow access to all files
<FilesMatch ".*">
    Order allow,deny
    Allow from all
</FilesMatch>
```

Atau lebih simple, pastikan tidak ada file `.htaccess` yang memblokir akses di folder `storage/`.

### 6. Alternative: Cek Ownership
```bash
# Pastikan owner file adalah user cPanel Anda
chown -R rumbaath:rumbaath ../storage/app/public
```

## Setelah Fix
- Clear browser cache
- Test akses: `https://rumbaathaya.id/storage/posts/thumbnails/test.jpg`
- Upload gambar baru via admin panel
