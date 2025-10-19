# MiniCommerce - Laravel E-Commerce Application

Link Drive : https://drive.google.com/drive/folders/1-ul8cDbVuHhOEz5kkHB3Pi2LgIYHQm24

MiniCommerce adalah aplikasi e-commerce sederhana yang dibangun dengan Laravel, dilengkapi dengan fitur checkout, manajemen produk, dan stock management.

## 🚀 Fitur Utama

-   ✅ **Autentikasi Multi-Role** (Admin & User)
-   🛍️ **Katalog Produk** dengan kategori
-   🛒 **Shopping Cart** dengan manajemen item
-   💳 **Checkout System** dengan form alamat pengiriman
-   📦 **Stock Management** otomatis saat checkout
-   👨‍💼 **Admin Dashboard** untuk kelola produk & order
-   🎨 **Responsive Design** dengan TailwindCSS

## 📋 Persyaratan Sistem

-   PHP >= 8.1
-   Composer
-   MySQL >= 5.7
-   Node.js & NPM

## ⚙️ Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/wirapatigilang/PBP_Laravel.git
cd minicommerce
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minicommerce
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration & Seeder

```bash
php artisan migrate:fresh --seed
```

**Seeder akan otomatis membuat:**

-   ✅ 2 User (Admin & User biasa)
-   ✅ 6 Kategori produk
-   ✅ 4 Produk sample dengan gambar

### 6. Build Assets

```bash
npm run dev
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👤 Default Login Credentials

### Admin Account

-   **Email:** admin@gmail.com
-   **Password:** admin123

### User Account

-   **Email:** wirapatigilang@gmail.com
-   **Password:** password123

## 📦 Data Seeder

Seeder sudah mencakup:

### Users

-   Admin dengan akses penuh
-   User biasa untuk testing

### Categories

-   Celana
-   T-Shirt
-   Kemeja
-   Accesioris
-   Orang Hilang
-   Outerwear

### Products

1. **T-Shirt Oversized Putih** - Rp109.000 (Stock: 10)
2. **Regular Fit Textured Short Sleeve Shirt** - Rp325.000 (Stock: 10)
3. **Slim Fit Basic Long Pants** - Rp365.415 (Stock: 15)
4. **Knitted Bomber Jacket** - Rp499.999 (Stock: 8)

## 🛠️ Cara Reset Database

Jika ingin reset database ke kondisi awal (dengan data seeder):

```bash
php artisan migrate:fresh --seed
```

⚠️ **Peringatan:** Perintah ini akan menghapus semua data yang ada!

## 📁 Struktur Proyek

```
minicommerce/
├── app/
│   ├── Http/Controllers/
│   │   ├── CheckoutController.php
│   │   ├── CartController.php
│   │   ├── ProductController.php
│   │   └── Admin/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── CartItem.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       └── ProductSeeder.php
├── resources/
│   └── views/
│       ├── products/
│       ├── checkout/
│       └── cart/
└── routes/
    └── web.php
```

## 🎯 Fitur Checkout

Form checkout mencakup:

-   ✅ Input Nama Penerima
-   ✅ Input No. Telepon
-   ✅ Input Alamat Lengkap
-   ✅ Pilihan Metode Pembayaran (Transfer Bank, QRIS, COD)
-   ✅ Auto-fill dari data user (dapat diedit)
-   ✅ Validasi form lengkap

## 🔐 Security Features

-   CSRF Protection
-   Password Hashing (bcrypt)
-   Database Transaction untuk stock management
-   Row Locking untuk mencegah race condition

## 🤝 Contributing

Kontribusi selalu diterima! Silakan buat pull request atau laporkan issue.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Developed with ❤️ by Gilang Wirapati**
