# Manajemen Data Siswa

Aplikasi **Manajemen Data Siswa** adalah sebuah aplikasi yang dibuat sebagai bagian dari technical test untuk posisi **Fullstack Developer** di **Bratamedia**. Aplikasi ini dibangun menggunakan **Laravel** sebagai backend dan **React.js** sebagai frontend.

## Persyaratan

Sebelum menjalankan project ini, pastikan perangkat Anda sudah terinstal dengan:

### Backend (Laravel)

- [PHP](https://www.php.net/) (Minimal versi 8.x)
- [Composer](https://getcomposer.org/) untuk mengelola dependensi Laravel

### Frontend (React.js)

- [Node.js](https://nodejs.org/) (Minimal versi 16.x)
- [npm](https://www.npmjs.com/) untuk mengelola dependensi React.js

## Instalasi & Menjalankan Project

### 1. Clone Repository

```sh
https://github.com/HaikalRFadhilahh/bratamedia-fullstack-test.git bratamedia-test
cd bratamedia-test
```

### 2. Setup Backend (Laravel)

```sh
cd bratamedia-api
cp .env.example .env
```

- Pastikan .env dan database konfigurasi pada .env file sudah di sesuaikan dan di konfigurasi dengan baik

```sh
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --port 8000
```

### 3. Setup Frontend (React.js)

Silahkan untuk membuka sesi terminal baru untuk running project React Js

```sh
cd bratamedia-ui
npm install
cp .env.example .env
```

- Sesuaikan dengan endpoint pada laravel Backend API, yang defaultnya di port 8000. Berikut isi dari .env

```sh
VITE_API_ENDPOINT=http://127.0.0.1:8000
```

- Jalankan perintah `npm run dev` untuk menjalankan project react js

```sh
npm run dev
```

Aplikasi frontend akan berjalan di `http://localhost:5173`, dan backend di `http://127.0.0.1:8000` secara default.

## Kredendial Untuk Login

- **Email:** admin@gmail.com
- **Password:** admin

## Teknologi yang Digunakan

- **Backend:** Laravel 11
- **Frontend:** React.js dengan Vite
- **Database:** MySQL
- **State Management:** Zustand
- **Authentication:** Laravel Sanctum

### Created By

Dibuat oleh **Haikal Raditya Fadhilah** untuk Bratamedia.
