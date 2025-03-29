# Laravel Project Setup

## Requirements
- PHP 8.x
- Composer
- MySQL / PostgreSQL (sesuai konfigurasi database)
- Node.js & npm (jika menggunakan frontend asset)

## Installation Steps

### 1. Clone Repository
```bash
git clone <repository-url>
cd <project-folder>
```

### 2. Install Dependencies
```bash
composer install
npm install  # Jika ada frontend assets
```

### 3. Copy Environment File
```bash
cp .env.example .env
```

### 4. Configure Environment
Edit file `.env` dan sesuaikan dengan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

## Database Setup

### 6. Run Migrations & Seeders
Untuk menghindari error, jalankan perintah berikut agar database terisi dengan data awal:
```bash
php artisan migrate --seed
```

> **Note:** Pastikan database sudah dibuat sebelum menjalankan perintah ini.

### 7. Run The Application
```bash
php artisan serve
```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

## Initiate Data Sales
Jika ingin menginisialisasi data penjualan, pastikan sudah menjalankan **migrate** dan **seeder**:
```bash
php artisan migrate --seed
```
Seeder ini akan mengisi database dengan contoh data sales agar fitur berjalan dengan baik.

Jika ingin menjalankan ulang seeder saja, gunakan:
```bash
php artisan db:seed
```

---

## Troubleshooting
Jika terjadi error:
- **Cek konfigurasi database:** Pastikan koneksi database di `.env` sudah benar.
- **Cek perintah migrate & seeder:** Pastikan tidak ada error saat menjalankan `php artisan migrate --seed`.
- **Bersihkan cache Laravel:**
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```

Jika masih ada error, coba jalankan ulang perintah berikut:
```bash
composer dump-autoload
php artisan migrate:fresh --seed
```

Semoga membantu! 🚀

