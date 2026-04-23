<?php
/**
 * ==========================================================
 * Buah.php - Kelas Induk (Parent Class) Buah
 * ==========================================================
 * 
 * MENJAWAB SOAL 1.a & 1.c:
 * (1.a) Kelas 'Buah' dengan dua atribut public: 'jenis' dan 'tahunPanen',
 *       beserta konstruktor untuk menginisialisasi atribut tersebut.
 * (1.c) Metode 'informasiBuah()' yang mencetak informasi umum tentang buah.
 * 
 * KONSEP OOP YANG DIGUNAKAN:
 * - Encapsulation: Atribut dan metode dibungkus dalam satu class.
 * - Constructor: Metode khusus __construct() untuk inisialisasi objek.
 * - Inheritance: Class ini dirancang sebagai parent class yang bisa diwariskan.
 * 
 * ALUR PROGRAM:
 * 1. Saat objek Buah di-instansiasi dengan `new Buah($jenis, $tahunPanen)`,
 *    konstruktor __construct() akan dipanggil secara otomatis.
 * 2. Konstruktor menerima parameter $jenis dan $tahunPanen, lalu menyimpannya
 *    ke dalam atribut public milik objek tersebut.
 * 3. Metode informasiBuah() dapat dipanggil kapan saja untuk mendapatkan
 *    string informasi umum tentang buah tersebut.
 * 4. Selain logika OOP, class ini juga berfungsi sebagai Model yang berinteraksi
 *    dengan database untuk operasi CRUD (menggunakan PDO).
 */

// Include konfigurasi database untuk operasi CRUD
require_once __DIR__ . '/../Config/Database.php';

class Buah
{
    /**
     * Atribut public: jenis buah (misal: "Harum Manis", "Fuji", dll.)
     * Dibuat public sesuai permintaan soal.
     */
    public string $jenis;

    /**
     * Atribut public: tahun panen buah (misal: 2024, 2025, dll.)
     * Dibuat public sesuai permintaan soal.
     */
    public int $tahunPanen;

    /**
     * Konstruktor - Menginisialisasi atribut saat objek dibuat
     * 
     * MENJAWAB SOAL 1.a:
     * Konstruktor ini menerima dua parameter dan langsung menyimpannya
     * ke dalam atribut objek. Dipanggil otomatis saat `new Buah(...)`.
     * 
     * @param string $jenis      Jenis/varietas buah
     * @param int    $tahunPanen  Tahun panen buah
     */
    public function __construct(string $jenis, int $tahunPanen)
    {
        // Simpan parameter ke atribut objek menggunakan $this
        $this->jenis      = $jenis;
        $this->tahunPanen = $tahunPanen;
    }

    /**
     * informasiBuah() - Menampilkan informasi umum tentang buah
     * 
     * MENJAWAB SOAL 1.c:
     * Metode ini mencetak informasi umum tentang buah menggunakan
     * atribut yang sudah diinisialisasi oleh konstruktor.
     * 
     * Format output: "Ini adalah sebuah buah jenis {jenis} yang panen tahun {tahunPanen}."
     * 
     * @return string Informasi umum tentang buah
     */
    public function informasiBuah(): string
    {
        return "Ini adalah sebuah buah jenis $this->jenis yang panen tahun $this->tahunPanen.";
    }

    // ================================================================
    // METODE DATABASE (CRUD) - Untuk interaksi dengan tabel 'fruits'
    // ================================================================

    /**
     * getAll() - Mengambil semua data buah dari database
     * 
     * Menggunakan query SELECT sederhana dan mengurutkan berdasarkan
     * ID terbaru (DESC) agar data terbaru tampil di atas.
     * 
     * @return array Array berisi semua baris data buah
     */
    public static function getAll(): array
    {
        $db   = Database::getConnection();
        $stmt = $db->query("SELECT * FROM fruits ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    /**
     * findById() - Mencari satu data buah berdasarkan ID
     * 
     * Menggunakan prepared statement untuk mencegah SQL Injection.
     * 
     * @param int $id ID buah yang dicari
     * @return array|false Data buah atau false jika tidak ditemukan
     */
    public static function findById(int $id): array|false
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM fruits WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * save() - Menyimpan data buah baru ke database
     * 
     * Menggunakan prepared statement dengan named parameter
     * untuk keamanan terhadap SQL Injection.
     * 
     * @param string $nama       Nama buah (misal: "Mangga", "Apel")
     * @param string $jenis      Jenis/varietas buah
     * @param int    $tahunPanen  Tahun panen buah
     * @return bool True jika berhasil disimpan
     */
    public static function save(string $nama, string $jenis, int $tahunPanen): bool
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO fruits (nama, jenis, tahun_panen) VALUES (:nama, :jenis, :tahun_panen)"
        );
        return $stmt->execute([
            'nama'        => $nama,
            'jenis'       => $jenis,
            'tahun_panen' => $tahunPanen,
        ]);
    }

    /**
     * update() - Mengupdate data buah yang sudah ada
     * 
     * @param int    $id          ID buah yang akan diupdate
     * @param string $nama        Nama buah baru
     * @param string $jenis       Jenis buah baru
     * @param int    $tahunPanen  Tahun panen baru
     * @return bool True jika berhasil diupdate
     */
    public static function update(int $id, string $nama, string $jenis, int $tahunPanen): bool
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE fruits SET nama = :nama, jenis = :jenis, tahun_panen = :tahun_panen WHERE id = :id"
        );
        return $stmt->execute([
            'id'          => $id,
            'nama'        => $nama,
            'jenis'       => $jenis,
            'tahun_panen' => $tahunPanen,
        ]);
    }

    /**
     * delete() - Menghapus data buah dari database berdasarkan ID
     * 
     * @param int $id ID buah yang akan dihapus
     * @return bool True jika berhasil dihapus
     */
    public static function delete(int $id): bool
    {
        $db   = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM fruits WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
