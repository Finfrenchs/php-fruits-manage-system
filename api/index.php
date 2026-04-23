<?php
/**
 * ==========================================================
 * index.php - Front Controller (Entry Point Aplikasi)
 * ==========================================================
 * 
 * FUNGSI:
 * File ini adalah satu-satunya entry point untuk semua request HTTP.
 * Semua URL diarahkan ke file ini, dan file ini yang menentukan
 * Controller dan aksi mana yang harus dijalankan berdasarkan
 * parameter ?action= pada URL.
 * 
 * ALUR:
 * 1. Mulai session untuk flash messages
 * 2. Load konfigurasi database (.env)
 * 3. Load FruitController
 * 4. Baca parameter ?action= dari URL
 * 5. Jalankan metode yang sesuai di FruitController
 * 
 * CONTOH URL:
 * - index.php              → Dashboard (default)
 * - index.php?action=index → Dashboard
 * - index.php?action=store → Simpan buah baru (POST)
 * - index.php?action=answer → Halaman jawaban UTS
 */

// ===========================================
// 1. Mulai Session
// ===========================================
// Session digunakan untuk menyimpan flash messages (pesan sukses/error)
// yang ditampilkan setelah redirect.
session_start();

// ===========================================
// 2. Load Konfigurasi Database
// ===========================================
// Include class Database dan load file .env dari root project
require_once __DIR__ . '/../app/Config/Database.php';

// Load variabel environment dari file .env
// __DIR__ . '/..' mengarah ke root project (satu level di atas folder api/)
Database::loadEnv(__DIR__ . '/../.env');

// ===========================================
// 3. Load Controller
// ===========================================
require_once __DIR__ . '/../app/Controllers/FruitController.php';

// Buat instance FruitController
$controller = new FruitController();

// ===========================================
// 4. Routing - Tentukan aksi berdasarkan URL
// ===========================================
// Baca parameter ?action= dari query string
// Jika tidak ada, default ke 'index' (dashboard)
$action = $_GET['action'] ?? 'index';

// ===========================================
// 5. Jalankan aksi yang sesuai
// ===========================================
// Daftar aksi yang diizinkan (whitelist untuk keamanan)
$allowedActions = ['index', 'store', 'update', 'delete', 'answer'];

// Cek apakah aksi ada dalam whitelist dan metode tersebut ada di controller
if (in_array($action, $allowedActions) && method_exists($controller, $action)) {
    // Jalankan metode controller yang sesuai
    $controller->$action();
} else {
    // Jika aksi tidak dikenal, tampilkan halaman 404
    http_response_code(404);
    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
    echo "<p>Aksi '$action' tidak tersedia.</p>";
    echo "<a href='index.php'>Kembali ke Dashboard</a>";
}
