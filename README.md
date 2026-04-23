# 🍎 Fruit Management System — UTS PBO

Sistem Manajemen Buah sederhana berbasis web yang dibangun menggunakan arsitektur **MVC (Model-View-Controller)** dengan **PHP Native 8.3** dan **MySQL**.

## 📋 Deskripsi

Project ini merupakan UTS mata kuliah **Pemrograman Berorientasi Objek (PBO)** yang mengimplementasikan:
- Kelas `Buah` (parent class) dengan atribut, konstruktor, dan metode `informasiBuah()`
- Kelas `Mangga` (child class) dengan inheritance dan method overriding
- Sistem CRUD (Create, Read, Update, Delete) untuk manajemen data buah
- Penjelasan konsep Object Type dalam OOP

## 🛠️ Tech Stack

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| PHP | 8.3 | Backend (Native MVC) |
| MySQL | - | Database |
| Tailwind CSS | v3 (CDN) | Styling UI |
| Alpine.js | v3 (CDN) | Interaktivitas frontend |
| Laragon | - | Local development server |

## 📁 Struktur Folder (MVC)

```
├── app/
│   ├── Config/Database.php       # Koneksi PDO + .env loader
│   ├── Controllers/FruitController.php  # Logika routing & aksi
│   ├── Models/
│   │   ├── Buah.php              # Parent class + CRUD
│   │   └── Mangga.php            # Child class (extends Buah)
│   └── Views/
│       ├── layout.php            # Template utama
│       ├── dashboard.php         # Halaman dashboard
├── public/index.php              # Front Controller (entry point)
├── migrate.php                   # Script migrasi database
├── .env                          # Konfigurasi environment (JANGAN commit)
├── .env.example                  # Contoh konfigurasi
├── .gitignore                    # File yang diabaikan Git
└── README.md                     # Dokumentasi (file ini)
```

## 🚀 Cara Setup & Menjalankan

### 1. Clone / Download Project
Letakkan folder project di dalam direktori `www` Laragon.

### 2. Buat Database
Buat database bernama `fruits_db` di MySQL (bisa via phpMyAdmin atau HeidiSQL di Laragon).

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`, lalu sesuaikan kredensial:
```
DB_HOST=127.0.0.1
DB_NAME=fruits_db
DB_USER=root
DB_PASS=password_anda
```

### 4. Jalankan Migrasi Database
Buka terminal di root folder project, lalu jalankan:
```bash
php migrate.php
```
Script ini akan membuat tabel `fruits` dan mengisi data contoh.

### 5. Menjalankan Aplikasi

Ada dua cara untuk menjalankan aplikasi ini:

**Cara 1: Menggunakan PHP Built-in Server (Rekomendasi)**
Buka terminal di root folder project, lalu jalankan perintah berikut:
```bash
php -S localhost:8000 -t api/
```
Kemudian buka browser dan akses `http://localhost:8000`.
*(Untuk menghentikan server, tekan `Ctrl + C` di terminal tersebut).*

**Cara 2: Menggunakan Laragon/XAMPP**
Pastikan folder project berada di dalam `www` (Laragon) atau `htdocs` (XAMPP).
Buka browser dan akses:
```
http://localhost/fruits-management-system/api/
```
Atau sesuaikan dengan konfigurasi virtual host Anda.

## 📖 Fitur

- **Dashboard** — Menampilkan statistik dan tabel data buah
- **Tambah Buah** — Form modal untuk menambah data baru
- **Edit Buah** — Form modal untuk mengubah data
- **Hapus Buah** — Hapus data dengan konfirmasi

## 📝 Konsep OOP yang Digunakan

1. **Class & Object** — Pembuatan kelas Buah dan instansiasi objek
2. **Constructor** — Inisialisasi atribut saat objek dibuat
3. **Inheritance** — Kelas Mangga mewarisi dari kelas Buah
4. **Method Overriding** — Mangga meng-override metode informasiBuah()
5. **Polymorphism** — Perilaku berbeda pada metode yang sama
6. **Encapsulation** — Pembungkusan data dan fungsi dalam class
