<?php
/**
 * ==========================================================
 * FruitController.php - Controller Utama Manajemen Buah
 * ==========================================================
 * 
 * FUNGSI:
 * Controller ini menghubungkan Model (Buah/Mangga) dengan View (tampilan).
 * Setiap metode publik di sini mewakili satu "aksi" yang bisa dipanggil
 * oleh Front Controller (api/index.php) berdasarkan parameter URL.
 * 
 * ALUR MVC:
 * 1. User mengakses URL → api/index.php (Front Controller) menerima request
 * 2. Front Controller menentukan aksi yang diminta (misal: ?action=index)
 * 3. Front Controller memanggil metode yang sesuai di FruitController
 * 4. FruitController berinteraksi dengan Model untuk mengambil/menyimpan data
 * 5. FruitController merender View yang sesuai dengan data dari Model
 * 
 * AKSI YANG TERSEDIA:
 * - index()   : Menampilkan dashboard dengan daftar semua buah
 * - store()   : Menyimpan data buah baru dari form
 * - update()  : Mengupdate data buah yang sudah ada
 * - delete()  : Menghapus data buah
 * - answer()  : Menampilkan halaman jawaban UTS (output program + teori)
 */

// Include Model yang dibutuhkan
require_once __DIR__ . '/../Models/Buah.php';
require_once __DIR__ . '/../Models/Mangga.php';

class FruitController
{
    /**
     * index() - Menampilkan halaman dashboard utama
     * 
     * Mengambil semua data buah dari database menggunakan Model Buah,
     * lalu mengirimkannya ke view dashboard.php untuk ditampilkan.
     */
    public function index(): void
    {
        // Ambil semua data buah dari database via Model
        $fruits = Buah::getAll();

        // Tentukan judul halaman untuk layout
        $pageTitle = 'Dashboard';

        // Tentukan file view yang akan dirender (relatif terhadap Views/)
        $contentView = __DIR__ . '/../Views/dashboard.php';

        // Render layout utama (layout.php akan meng-include $contentView)
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * store() - Menyimpan data buah baru ke database
     * 
     * Menerima data dari form POST, melakukan validasi sederhana,
     * lalu menyimpan ke database menggunakan Model Buah.
     * Setelah berhasil, redirect kembali ke dashboard.
     */
    public function store(): void
    {
        // Pastikan request menggunakan metode POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
            return;
        }

        // Ambil dan sanitasi input dari form
        $nama       = trim($_POST['nama'] ?? '');
        $jenis      = trim($_POST['jenis'] ?? '');
        $tahunPanen = (int) ($_POST['tahun_panen'] ?? 0);

        // Validasi: semua field harus diisi
        if (empty($nama) || empty($jenis) || $tahunPanen <= 0) {
            // Redirect dengan pesan error via session
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Semua field harus diisi dengan benar!'];
            $this->redirect('index');
            return;
        }

        // Simpan ke database menggunakan Model
        Buah::save($nama, $jenis, $tahunPanen);

        // Set pesan sukses
        $_SESSION['flash'] = ['type' => 'success', 'message' => "Buah \"$nama\" berhasil ditambahkan!"];

        // Redirect kembali ke dashboard
        $this->redirect('index');
    }

    /**
     * update() - Mengupdate data buah yang sudah ada
     * 
     * Menerima data dari form POST termasuk ID buah yang akan diupdate,
     * lalu mengupdate data di database menggunakan Model Buah.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
            return;
        }

        // Ambil data dari form
        $id         = (int) ($_POST['id'] ?? 0);
        $nama       = trim($_POST['nama'] ?? '');
        $jenis      = trim($_POST['jenis'] ?? '');
        $tahunPanen = (int) ($_POST['tahun_panen'] ?? 0);

        // Validasi
        if ($id <= 0 || empty($nama) || empty($jenis) || $tahunPanen <= 0) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data tidak valid!'];
            $this->redirect('index');
            return;
        }

        // Update di database
        Buah::update($id, $nama, $jenis, $tahunPanen);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "Buah \"$nama\" berhasil diupdate!"];
        $this->redirect('index');
    }

    /**
     * delete() - Menghapus data buah dari database
     * 
     * Menerima ID buah yang akan dihapus dari form POST,
     * lalu menghapusnya dari database.
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
            return;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'ID tidak valid!'];
            $this->redirect('index');
            return;
        }

        Buah::delete($id);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Buah berhasil dihapus!'];
        $this->redirect('index');
    }

    /**
     * answer() - Menampilkan halaman jawaban UTS
     * 
     * Halaman ini berisi:
     * 1. Instansiasi objek Buah dan Mangga
     * 2. Output dari metode informasiBuah() (asli dan override)
     * 3. Penjelasan alur program (Soal 1)
     * 4. Penjelasan konsep Object Type (Soal 2)
     */
    public function answer(): void
    {
        // === DEMONSTRASI SOAL 1 ===
        
        // Instansiasi objek Buah (Soal 1.a)
        // Memanggil konstruktor Buah dengan jenis "Fuji" dan tahun panen 2024
        $buah = new Buah("Fuji", 2024);

        // Instansiasi objek Mangga (Soal 1.b)
        // Memanggil konstruktor Mangga yang meneruskan ke parent::__construct()
        $mangga = new Mangga("Harum Manis", 2025);

        // Panggil informasiBuah() pada kedua objek untuk menunjukkan polymorphism
        // (Soal 1.c) $buah->informasiBuah() → versi dari kelas Buah
        $outputBuah = $buah->informasiBuah();

        // (Soal 1.d) $mangga->informasiBuah() → versi override dari kelas Mangga
        $outputMangga = $mangga->informasiBuah();

        // Tentukan judul halaman
        $pageTitle = 'Jawaban UTS';

        // Kirim data ke view
        $contentView = __DIR__ . '/../Views/exam_answer.php';

        // Render layout
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * redirect() - Helper untuk melakukan redirect ke aksi lain
     * 
     * @param string $action Nama aksi tujuan redirect
     */
    private function redirect(string $action): void
    {
        header("Location: index.php?action=$action");
        exit;
    }
}
