# Upgrade Guide

Panduan ini menerangkan cara untuk mengemaskini Sistem Affiliate ke versi terbaru.

## Kaedah 1: Melalui Web UI (Disyorkan untuk Shared Hosting)

Untuk pengguna yang tidak mempunyai akses SSH atau terminal, sistem menyediakan antaramuka web untuk upgrade.

### Langkah-langkah:

1. **Log masuk sebagai Admin**
   - Pastikan anda log masuk dengan akaun admin

2. **Akses Halaman Upgrade**
   - Pergi ke **Settings** → **System Upgrade** di sidebar
   - Atau akses terus: `https://yourdomain.com/admin/upgrade`

3. **Semak Status Sistem**
   - Halaman akan memaparkan:
     - Versi semasa yang dipasang
     - Versi terbaru yang tersedia
     - Senarai migration yang belum dijalankan
     - Changelog untuk setiap versi

4. **Jalankan Upgrade**
   - Klik butang **"Run System Upgrade"** untuk:
     - Menjalankan semua migration yang pending
     - Membersihkan cache sistem
     - Mengemaskini versi yang direkodkan

5. **Sahkan Upgrade**
   - Selepas selesai, sistem akan memaparkan mesej kejayaan
   - Versi akan dikemaskini dalam pangkalan data

### Operasi Manual (Jika Diperlukan)

Di halaman upgrade, anda juga boleh:
- **Run Migrations Only** - Hanya jalankan migration tanpa clear cache
- **Clear Cache** - Bersihkan cache sahaja (config, route, view, application)
- **Check for Updates** - Semak jika ada kemaskini tersedia

---

## Kaedah 2: Manual via Terminal (Untuk Developer)

Untuk developer atau pengguna dengan akses SSH/terminal.

### Langkah 1: Backup Data

```bash
# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Backup files (optional)
tar -czvf backup_files_$(date +%Y%m%d).tar.gz .
```

### Langkah 2: Pull Latest Code

```bash
# Pastikan tiada perubahan lokal yang belum commit
git status

# Pull perubahan terbaru
git pull origin master
```

### Langkah 3: Update Dependencies

```bash
# Update PHP dependencies
composer install --no-dev --optimize-autoloader

# Update Node.js dependencies (jika ada perubahan frontend)
npm install
npm run build
```

### Langkah 4: Jalankan Migration

```bash
# Semak migration yang pending
php artisan migrate:status

# Jalankan migration
php artisan migrate --force
```

### Langkah 5: Clear Cache

```bash
# Clear semua cache
php artisan optimize:clear

# Atau clear satu persatu
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Langkah 6: Rebuild Cache (Production)

```bash
# Rebuild cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Kaedah 3: Manual File Upload (Tanpa Git)

Untuk pengguna yang tidak menggunakan Git.

### Langkah 1: Download Versi Terbaru

- Muat turun fail zip dari repository atau sumber rasmi

### Langkah 2: Backup Fail Penting

Sebelum upload, backup fail berikut:
- `.env` - Konfigurasi environment
- `storage/installed` - Marker pemasangan
- `storage/app/` - Fail yang dimuat naik pengguna

### Langkah 3: Upload Fail Baru

Upload fail baru **KECUALI**:
- `.env` (guna yang sedia ada)
- `storage/` folder (guna yang sedia ada)
- `vendor/` (akan dijana semula)

### Langkah 4: Update Dependencies

Melalui hosting panel (jika ada Composer support):
```bash
composer install --no-dev
```

Atau muat naik folder `vendor/` dari development environment.

### Langkah 5: Jalankan Migration

Akses halaman upgrade melalui web UI:
`https://yourdomain.com/admin/upgrade`

---

## Troubleshooting

### Error: "Migration failed"

1. Semak log error di `storage/logs/laravel.log`
2. Pastikan database credentials betul dalam `.env`
3. Pastikan database user ada permission untuk ALTER table

### Error: "Class not found"

```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: "View not found"

```bash
php artisan view:clear
php artisan view:cache
```

### Halaman kosong / Error 500

1. Semak `storage/logs/laravel.log`
2. Pastikan folder `storage/` dan `bootstrap/cache/` boleh ditulis:
```bash
chmod -R 775 storage bootstrap/cache
```

### Cache tidak clear

Restart PHP-FPM atau web server:
```bash
# Untuk PHP-FPM
sudo systemctl restart php8.2-fpm

# Untuk Apache
sudo systemctl restart apache2

# Untuk Nginx
sudo systemctl restart nginx
```

---

## Version History

Semak fail `config/version.php` untuk senarai lengkap perubahan setiap versi.

| Versi | Tarikh | Perubahan Utama |
|-------|--------|-----------------|
| 1.1.0 | 2024-12-29 | Sistem upgrade via UI, Convert ENUM ke VARCHAR |
| 1.0.0 | 2024-12-15 | Versi awal sistem |

---

## Sokongan

Jika menghadapi masalah:
1. Semak dokumentasi di folder `docs/`
2. Semak GitHub Issues
3. Hubungi pembangun sistem
