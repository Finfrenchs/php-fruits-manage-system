<?php
/**
 * ==========================================================
 * Database.php - Konfigurasi Koneksi Database
 * ==========================================================
 * 
 * FUNGSI:
 * File ini bertanggung jawab untuk membuat koneksi ke database MySQL
 * menggunakan PDO (PHP Data Objects). Kredensial dibaca dari file .env
 * agar tidak di-hardcode dalam source code (best practice keamanan).
 * 
 * ALUR:
 * 1. Fungsi loadEnv() membaca file .env baris per baris.
 * 2. Setiap baris diparsing menjadi key=value dan dimasukkan ke $_ENV.
 * 3. Fungsi getConnection() menggunakan nilai dari $_ENV untuk membuat
 *    koneksi PDO ke MySQL dengan error mode EXCEPTION.
 * 4. Koneksi yang berhasil akan dikembalikan sebagai objek PDO.
 */

class Database
{
    /**
     * Menyimpan instance koneksi PDO (singleton pattern sederhana)
     * agar tidak membuat koneksi baru setiap kali dipanggil.
     */
    private static ?PDO $connection = null;

    /**
     * loadEnv() - Memuat variabel dari file .env ke $_ENV
     * 
     * Cara kerja:
     * - Membaca file .env dari root project
     * - Mengabaikan baris kosong dan baris komentar (#)
     * - Memecah setiap baris menjadi key dan value
     * - Menyimpannya ke superglobal $_ENV
     * 
     * @param string $path Path ke file .env
     * @return void
     */
    public static function loadEnv(string $path): void
    {
        // Cek apakah file .env ada
        if (!file_exists($path)) {
            // Jika tidak ada (misal di Vercel/Production), abaikan saja
            // karena variabel environment biasanya diset di dashboard hosting.
            return;
        }

        // Baca file .env baris per baris
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Lewati baris komentar (diawali #)
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // Pecah baris menjadi key=value
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key   = trim($parts[0]);
                $value = trim($parts[1]);
                // Simpan ke superglobal $_ENV agar bisa diakses di seluruh aplikasi
                $_ENV[$key] = $value;
            }
        }
    }

    /**
     * getConnection() - Mendapatkan koneksi PDO ke database MySQL
     * 
     * Cara kerja:
     * - Mengecek apakah koneksi sudah pernah dibuat (singleton)
     * - Jika belum, membuat koneksi baru dengan kredensial dari $_ENV
     * - Mengatur PDO agar melempar exception saat terjadi error
     * - Mengatur charset ke utf8mb4 untuk mendukung karakter Unicode
     * 
     * @return PDO Instance koneksi database
     */
    public static function getConnection(): PDO
    {
        // Jika koneksi belum ada, buat koneksi baru (singleton pattern)
        if (self::$connection === null) {
            // Ambil kredensial dari berbagai sumber environment
            $host = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ?? '127.0.0.1';
            $port = $_ENV['DB_PORT'] ?? $_SERVER['DB_PORT'] ?? getenv('DB_PORT') ?? '4000';
            $name = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? getenv('DB_NAME') ?? 'fruits_db';
            $user = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? getenv('DB_USER') ?? 'root';
            $pass = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? getenv('DB_PASS') ?? '';

            // DSN (Data Source Name) - Menambahkan port
            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

            try {
                // Buat koneksi PDO baru dengan dukungan SSL
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    // Paksa menggunakan SSL (Wajib untuk TiDB Cloud Serverless)
                    PDO::MYSQL_ATTR_SSL_CA       => '', 
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                ]);
            } catch (PDOException $e) {
                // Tampilkan pesan error jika koneksi gagal
                die("ERROR: Gagal terhubung ke database. Detail: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
