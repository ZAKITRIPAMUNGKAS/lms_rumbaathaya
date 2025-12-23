# Panduan Pindah Storage ke Public (Tanpa Symbolic Link)

## Masalah
Server cPanel memblokir symbolic link, menyebabkan error 403 untuk semua file di `/storage/`

## Solusi
Pindahkan storage langsung ke folder `public/uploads/` dan update konfigurasi Laravel.

## Langkah-Langkah di Terminal cPanel

```bash
cd ~/public_html

# 1. Hapus symbolic link
rm -f public/storage

# 2. Buat folder uploads di public
mkdir -p public/uploads

# 3. Copy semua file dari storage ke uploads
cp -r storage/app/public/* public/uploads/

# 4. Set permission
chmod -R 755 public/uploads

# 5. Test akses
curl https://rumbaathaya.id/uploads/test.txt
```

## Update Konfigurasi Laravel

Edit file `config/filesystems.php` di server, ubah disk 'public':

```php
'public' => [
    'driver' => 'local',
    'root' => public_path('uploads'),  // Ubah dari storage_path('app/public')
    'url' => env('APP_URL').'/uploads',  // Ubah dari /storage
    'visibility' => 'public',
    'throw' => false,
],
```

## Setelah Update Config

```bash
php artisan config:clear
php artisan config:cache
```

## Test Upload

1. Login admin panel
2. Upload gambar baru
3. Gambar akan tersimpan di `public/uploads/` dan bisa diakses via `https://rumbaathaya.id/uploads/...`

## Keuntungan

✅ Tidak perlu symbolic link  
✅ Tidak ada error 403  
✅ File langsung accessible  
✅ Lebih simple di cPanel  

## Catatan

File yang sudah ada di database masih referensi ke `/storage/`, perlu update:

```sql
UPDATE posts SET thumbnail = REPLACE(thumbnail, 'posts/thumbnails/', 'posts/thumbnails/');
UPDATE documentations SET file_path = REPLACE(file_path, 'documentations/', 'documentations/');
```

Atau bisa copy file manual:
```bash
cp -r storage/app/public/posts public/uploads/
cp -r storage/app/public/documentations public/uploads/
```
