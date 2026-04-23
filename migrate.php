<?php
/**
 * ==========================================================
 * migrate.php - Script Migrasi Database
 * ==========================================================
 * 
 * FUNGSI:
 * Script ini dijalankan SATU KALI untuk membuat tabel 'fruits' 
 * di database MySQL. Jalankan via terminal:
 * 
 *     php migrate.php
 * 
 * PRASYARAT:
 * - Database 'fruits_db' sudah dibuat di MySQL (bisa via phpMyAdmin/Laragon)
 * - File .env sudah dikonfigurasi dengan benar
 * 
 * ALUR:
 * 1. Load konfigurasi dari .env
 * 2. Buat koneksi ke database
 * 3. Jalankan SQL CREATE TABLE
 * 4. Tampilkan pesan sukses/gagal di terminal
 */

// Load konfigurasi database
require_once __DIR__ . '/app/Config/Database.php';

// Load variabel environment
Database::loadEnv(__DIR__ . '/.env');

echo "========================================\n";
echo " Migrasi Database - Fruits Management  \n";
echo "========================================\n\n";

try {
    // Dapatkan koneksi database
    $db = Database::getConnection();
    echo "[✓] Koneksi ke database berhasil!\n\n";

    // SQL untuk membuat tabel 'fruits'
    $sql = "
        CREATE TABLE IF NOT EXISTS fruits (
            -- Primary key dengan auto increment
            id INT AUTO_INCREMENT PRIMARY KEY,
            
            -- Nama buah (misal: Mangga, Apel, Jeruk)
            nama VARCHAR(100) NOT NULL,
            
            -- Jenis/varietas buah (misal: Harum Manis, Fuji, Sunkist)
            jenis VARCHAR(100) NOT NULL,
            
            -- Tahun panen buah
            tahun_panen INT NOT NULL,
            
            -- Timestamp otomatis saat data dibuat
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            -- Timestamp otomatis saat data diupdate
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";

    // Jalankan SQL
    $db->exec($sql);
    echo "[✓] Tabel 'fruits' berhasil dibuat/sudah ada!\n\n";

    // Tambahkan beberapa data contoh (seed) jika tabel masih kosong
    $count = $db->query("SELECT COUNT(*) FROM fruits")->fetchColumn();

    if ($count == 0) {
        echo "[i] Tabel kosong, menambahkan data contoh...\n";

        $seeds = [
            ['Mangga',  'Harum Manis',   2024],
            ['Mangga',  'Gedong Gincu',  2025],
            ['Apel',    'Fuji',          2024],
            ['Apel',    'Malang',        2023],
            ['Jeruk',   'Sunkist',       2025],
        ];

        $stmt = $db->prepare(
            "INSERT INTO fruits (nama, jenis, tahun_panen) VALUES (:nama, :jenis, :tahun_panen)"
        );

        foreach ($seeds as $seed) {
            $stmt->execute([
                'nama'        => $seed[0],
                'jenis'       => $seed[1],
                'tahun_panen' => $seed[2],
            ]);
            echo "   → Ditambahkan: {$seed[0]} - {$seed[1]} ({$seed[2]})\n";
        }

        echo "\n[✓] Data contoh berhasil ditambahkan!\n";
    } else {
        echo "[i] Tabel sudah berisi $count data. Seed dilewati.\n";
    }

    echo "\n========================================\n";
    echo " Migrasi selesai! Silakan buka aplikasi.\n";
    echo "========================================\n";

} catch (Exception $e) {
    echo "[✗] ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
