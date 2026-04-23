<?php
/**
 * ==========================================================
 * Mangga.php - Kelas Turunan (Child Class) dari Buah
 * ==========================================================
 * 
 * MENJAWAB SOAL 1.b & 1.d:
 * (1.b) Kelas 'Mangga' yang diturunkan (extends) dari kelas 'Buah'.
 *       Memiliki konstruktor yang menginisialisasi atribut warisan dari Buah.
 * (1.d) Override metode 'informasiBuah()' agar mencetak informasi spesifik mangga.
 * 
 * KONSEP OOP YANG DIGUNAKAN:
 * - Inheritance (Pewarisan): Mangga mewarisi semua atribut & metode dari Buah.
 * - Method Overriding: Metode informasiBuah() di-override untuk memberikan
 *   perilaku yang berbeda (polimorfisme).
 * - parent::__construct(): Memanggil konstruktor kelas induk dari kelas anak.
 * 
 * ALUR PROGRAM:
 * 1. Saat objek Mangga di-instansiasi dengan `new Mangga($jenis, $tahunPanen)`,
 *    konstruktor Mangga dipanggil.
 * 2. Di dalam konstruktor Mangga, `parent::__construct()` dipanggil untuk
 *    menjalankan logika inisialisasi dari kelas induk (Buah).
 * 3. Atribut $jenis dan $tahunPanen yang dimiliki oleh Buah kini juga
 *    dimiliki oleh objek Mangga berkat pewarisan.
 * 4. Ketika informasiBuah() dipanggil pada objek Mangga, PHP akan menggunakan
 *    versi yang sudah di-override di kelas Mangga (bukan versi dari Buah).
 *    Inilah yang disebut polimorfisme (polymorphism).
 */

// Include kelas induk Buah
require_once __DIR__ . '/Buah.php';

class Mangga extends Buah
{
    /**
     * Konstruktor Mangga - Menginisialisasi atribut yang diwarisi dari Buah
     * 
     * MENJAWAB SOAL 1.b:
     * Konstruktor ini menerima parameter $jenis dan $tahunPanen, lalu
     * meneruskannya ke konstruktor kelas induk (Buah) menggunakan
     * parent::__construct(). Dengan cara ini, semua logika inisialisasi
     * yang ada di Buah tetap dijalankan tanpa duplikasi kode.
     * 
     * @param string $jenis      Jenis/varietas mangga (misal: "Harum Manis")
     * @param int    $tahunPanen  Tahun panen mangga
     */
    public function __construct(string $jenis, int $tahunPanen)
    {
        // Panggil konstruktor kelas induk (Buah) untuk inisialisasi atribut
        parent::__construct($jenis, $tahunPanen);
    }

    /**
     * informasiBuah() - Override metode dari kelas Buah
     * 
     * MENJAWAB SOAL 1.d:
     * Metode ini meng-override (menimpa) metode informasiBuah() milik
     * kelas induk Buah. Output-nya berbeda: menggunakan kata "mangga"
     * bukan "buah" untuk memberikan informasi yang lebih spesifik.
     * 
     * Ini mendemonstrasikan konsep POLYMORPHISM dalam OOP:
     * - Objek Buah  → memanggil informasiBuah() versi Buah
     * - Objek Mangga → memanggil informasiBuah() versi Mangga (yang ini)
     * 
     * Format output: "Ini adalah mangga jenis {jenis} yang panen tahun {tahunPanen}."
     * 
     * @return string Informasi spesifik tentang mangga
     */
    public function informasiBuah(): string
    {
        return "Ini adalah mangga jenis $this->jenis yang panen tahun $this->tahunPanen.";
    }
}
