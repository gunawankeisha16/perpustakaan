<?php
// Memanggil Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil model Peminjaman untuk mengelola transaksi peminjaman
require_once __DIR__ . '/../models/Peminjaman.php';

// Memanggil model Buku untuk mengelola data buku
require_once __DIR__ . '/../models/Buku.php';

// Controller untuk mengelola peminjaman buku
class PeminjamanController extends Controller {
    
    // Menyimpan instance model Peminjaman
    private $peminjamanModel;
    
    // Menyimpan instance model Buku
    private $bukuModel;
    
    // Constructor dijalankan saat controller dipanggil
    public function __construct() {
        
        // Membuat object model Peminjaman
        $this->peminjamanModel = new Peminjaman();
        
        // Membuat object model Buku
        $this->bukuModel = new Buku();
    }
    
    // ================= USER =================
    
    // User: Melihat riwayat peminjaman buku
    public function index() {
        
        // Memastikan hanya user yang bisa mengakses
        $this->requireRole('user');
        
        // Mengambil ID user dari session
        $userId = $_SESSION['user']['id_user'] ?? 0;
        
        // Mengambil data peminjaman milik user
        $peminjamans = $this->peminjamanModel->getByUser($userId);
        
        // Menampilkan halaman riwayat peminjaman
        $this->view('user/peminjaman/index', [
            'user' => $this->getCurrentUser(),
            'peminjamans' => $peminjamans,
            'flash' => $this->getFlash()
        ]);
    }
    
    // User: Menampilkan form peminjaman buku
    public function pinjam() {
        
        // Validasi role user
        $this->requireRole('user');
        
        // Mengambil daftar buku yang tersedia
        $bukus = $this->bukuModel->getAvailable();
        
        // Menampilkan halaman form peminjaman buku
        $this->view('user/peminjaman/pinjam', [
            'user' => $this->getCurrentUser(),
            'bukus' => $bukus,
            'flash' => $this->getFlash()
        ]);
    }
    
    // User: Proses menyimpan peminjaman buku
    public function storePinjam() {
        
        // Validasi role user
        $this->requireRole('user');
        
        // Mengambil ID user dari session
        $userId = $_SESSION['user']['id_user'] ?? 0;
        
        // Mengambil data dari form
        $idBuku = $_POST['id_buku'] ?? '';
        $tanggalKembali = $_POST['tanggal_kembali'] ?? '';
        
        // Validasi input
        if (empty($idBuku) || empty($tanggalKembali)) {
            $this->setFlash('danger', 'Pilih buku dan tanggal kembali');
            $this->redirect('/user/peminjaman/pinjam');
        }
        
        // Mengecek stok buku
        $buku = $this->bukuModel->getById($idBuku);
        if (!$buku || $buku['stok'] < 1) {
            $this->setFlash('danger', 'Stok buku habis');
            $this->redirect('/user/peminjaman/pinjam');
        }
        
        // Menyimpan data peminjaman
        $this->peminjamanModel->pinjam($userId, $idBuku, $tanggalKembali);
        
        // Mengurangi stok buku
        $this->bukuModel->updateStok($idBuku, -1);
        
        // Notifikasi sukses
        $this->setFlash('success', 'Peminjaman berhasil');
        
        // Redirect ke riwayat peminjaman
        $this->redirect('/user/peminjaman');
    }
    
    // User: Mengembalikan buku
    public function kembalikan($id) {
        
        // Validasi role user
        $this->requireRole('user');
        
        // Mengambil ID user login
        $userId = $_SESSION['user']['id_user'] ?? 0;
        
        // Mengambil data peminjaman berdasarkan ID
        $peminjaman = $this->peminjamanModel->getById($id);
        
        // Memastikan peminjaman milik user dan status masih dipinjam
        if ($peminjaman && $peminjaman['id_user'] == $userId && $peminjaman['status'] === 'dipinjam') {
            
            // Mengupdate status menjadi dikembalikan
            $this->peminjamanModel->kembalikan($id);
            
            // Menambah stok buku
            $this->bukuModel->updateStok($peminjaman['id_buku'], 1);
            
            // Mengambil ulang data peminjaman untuk cek denda
            $updatedPeminjaman = $this->peminjamanModel->getById($id);
            
            // Jika ada denda keterlambatan
            if ($updatedPeminjaman['denda'] > 0) {
                $this->setFlash('warning', 'Buku dikembalikan. Denda: Rp ' . number_format($updatedPeminjaman['denda'], 0, ',', '.'));
            } else {
                $this->setFlash('success', 'Buku berhasil dikembalikan');
            }
        }
        
        // Redirect ke riwayat peminjaman
        $this->redirect('/user/peminjaman');
    }
    
    // User: Mencari buku
    public function cariBuku() {
        
        // Validasi role user
        $this->requireRole('user');
        
        // Mengambil keyword pencarian
        $keyword = trim($_GET['q'] ?? '');
        
        // Jika ada keyword maka lakukan pencarian
        // Jika tidak maka tampilkan buku tersedia
        $bukus = $keyword ? $this->bukuModel->search($keyword) : $this->bukuModel->getAvailable();
        
        // Menampilkan halaman daftar buku
        $this->view('user/buku/index', [
            'user' => $this->getCurrentUser(),
            'bukus' => $bukus,
            'keyword' => $keyword,
            'flash' => $this->getFlash()
        ]);
    }
}