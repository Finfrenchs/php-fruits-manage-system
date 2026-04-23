# Rencana Implementasi Sistem Manajemen Buah (UTS PBO)

## Deskripsi Tujuan
Membangun Sistem Manajemen Buah sederhana berbasis web menggunakan arsitektur **MVC (Model-View-Controller)** murni dengan **PHP Native 8.3** dan **MySQL**. Tampilan antar muka akan dibangun menggunakan **Tailwind CSS** dan **AlpineJS** untuk memberikan UI yang modern, dinamis, dan berkualitas tinggi. 

Selain aplikasi CRUD (Create, Read, Update, Delete) sederhana untuk mendemonstrasikan sistem, saya juga akan mengimplementasikan secara eksplisit kelas-kelas yang diminta dalam soal UTS (`Buah` dan `Mangga`), serta membuat halaman khusus ("Halaman Jawaban UTS") untuk menampilkan output program dan penjelasan teoritis.

Setiap file kode akan dilengkapi dengan komentar mendetail yang menjelaskan fungsi serta alur program sesuai dengan permintaan Anda.

## Decisions Made

- **Database Configuration**: Menggunakan file `.env` (seperti Laravel) untuk memuat kredensial koneksi. Database akan bernama `fruits_db` dengan user `root` dan password `password`.
- **UI Stack**: Tailwind CSS dan AlpineJS akan dimuat menggunakan **CDN** agar setup lebih sederhana dan fokus ke pengembangan PHP Native tanpa node modules.
- **Database Migration**: Akan dibuatkan file script khusus (misalnya `migrate.php`) agar Anda tinggal menjalankannya sekali untuk men-setup tabel.
- **Documentation & Git**: Akan disertakan file `README.md` untuk dokumentasi dan `.gitignore` agar `.env` dan file sistem operasi lainnya tidak ikut ke-push.

## Arsitektur Proyek (MVC)

Sistem akan dikelompokkan ke dalam struktur folder MVC berikut:

```text
/
├── app/
│   ├── Config/
│   │   └── Database.php         # Koneksi ke MySQL (PDO) menggunakan .env
│   ├── Controllers/
│   │   └── FruitController.php  # Menangani alur request
│   ├── Models/
│   │   ├── Buah.php             # (Menjawab Soal 1.a & 1.c) Base Model
│   │   └── Mangga.php           # (Menjawab Soal 1.b & 1.d) Child Model
│   └── Views/
│       ├── layout.php           # Template utama dengan Tailwind & AlpineJS (CDN)
│       ├── dashboard.php        # UI Dashboard Manajemen
│       └── exam_answer.php      # UI Khusus menampilkan jawaban & penjelasan teori
├── public/
│   └── index.php                # Front Controller / Entry point aplikasi
├── migrate.php                  # Script khusus untuk migrasi/setup database
├── .env.example                 # Contoh file konfigurasi environment
├── .gitignore                   # Ignore .env dan file tidak penting lainnya
└── README.md                    # Dokumentasi cara setup dan menjalankan project
```

## Rincian Perubahan & Implementasi

### 1. Database (MySQL) & .env
Akan dibuat file `.env` (berdasarkan `.env.example`) yang berisi:
- DB_NAME=fruits_db
- DB_USER=root
- DB_PASS=Hkayat100897

Dan pembuatan script `migrate.php` untuk mengotomatisasi pembuatan tabel `fruits` yang menyimpan id, nama, jenis, dan tahun_panen.

### 2. Models (Menjawab Soal 1)
- **`app/Models/Buah.php`**
  Akan berisi class `Buah` dengan atribut `jenis` dan `tahunPanen`, sebuah **konstruktor**, serta metode `informasiBuah()`. Class ini juga akan menangani interaksi dasar ke database.
- **`app/Models/Mangga.php`**
  Akan me-mewarisi (extend) class `Buah`, mengimplementasikan `parent::__construct()`, dan melakukan **overriding** pada metode `informasiBuah()`.

### 3. Controller
- **`app/Controllers/FruitController.php`**
  Akan mengatur logika routing, seperti `index` (menampilkan data), `store` (menyimpan data baru), dan `answer` (menjalankan program yang diminta pada Soal 1 untuk mendapatkan output teksnya).

### 4. Views (UI/UX)
- Akan dibuat dengan desain **Modern & Premium**:
  - Menggunakan palet warna modern (misalnya sentuhan dashboard modern minimalis).
  - Menggunakan font modern (Inter dari Google Fonts).
  - Interaktivitas (seperti modal untuk tambah buah) menggunakan Alpine.js.
  - Layout rapi menggunakan utilitas Grid/Flexbox dari Tailwind.

### 5. Penjelasan Teoritis (Menjawab Soal 2 & Alur Soal 1)
Pada halaman *exam_answer.php*, saya akan menuliskan:
- Penjelasan alur program dari pembuatan class hingga instansiasi objek.
- Penjelasan mendalam tentang konsep "Object Type" vs "Tipe Data Konvensional".

## Verification Plan
1. Menyiapkan file `.env` yang benar, lalu menjalankan perintah `php migrate.php` di terminal untuk setup DB.
2. Membaca `README.md` dan memverifikasi instruksi sudah lengkap.
3. Memeriksa `.gitignore` bekerja dengan tidak men-track `.env`.
4. Menjalankan server internal PHP Laragon untuk mengeksekusi aplikasi.
5. Membuka dashboard dan halaman "Jawaban UTS" untuk memastikan UI modern, fungsionalitas CRUD berjalan, dan output soal UTS PBO sudah benar.
