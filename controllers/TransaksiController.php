<?php
// Memanggil Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil model Peminjaman (mengelola transaksi peminjaman)
require_once __DIR__ . '/../models/Peminjaman.php';

// Memanggil model Buku (mengelola data buku)
require_once __DIR__ . '/../models/Buku.php';

// Memanggil model User (mengelola data anggota)
require_once __DIR__ . '/../models/User.php';

// Controller untuk mengelola transaksi peminjaman oleh admin
class TransaksiController extends Controller {
    
    // Menyimpan instance model Peminjaman
    private $peminjamanModel;
    
    // Menyimpan instance model Buku
    private $bukuModel;
    
    // Menyimpan instance model User
    private $userModel;
    
    // Constructor dijalankan saat controller dipanggil
    public function __construct() {
        
        // Membuat object model
        $this->peminjamanModel = new Peminjaman();
        $this->bukuModel = new Buku();
        $this->userModel = new User();
    }
    
    // Menampilkan daftar transaksi peminjaman
    public function index() {
        
        // Memastikan hanya admin yang bisa mengakses
        $this->requireRole('admin');
        
        // Mengambil semua data transaksi lengkap (biasanya join buku + user)
        $transaksis = $this->peminjamanModel->getAllWithDetail();
        
        // Menampilkan halaman daftar transaksi
        $this->view('admin/transaksi/index', [
            'user' => $this->getCurrentUser(),
            'transaksis' => $transaksis,
            'flash' => $this->getFlash()
        ]);
    }
    
    // Menampilkan form tambah transaksi peminjaman
    public function create() {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil daftar buku yang tersedia
        $bukus = $this->bukuModel->getAvailable();
        
        // Mengambil daftar anggota
        $anggota = $this->userModel->getAllAnggota();
        
        // Menampilkan halaman form transaksi
        $this->view('admin/transaksi/create', [
            'user' => $this->getCurrentUser(),
            'bukus' => $bukus,
            'anggota' => $anggota,
            'flash' => $this->getFlash()
        ]);
    }
    
    // Menyimpan transaksi peminjaman baru
    public function store() {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data dari form
        $idUser = $_POST['id_user'] ?? '';
        $idBuku = $_POST['id_buku'] ?? '';
        $tanggalKembali = $_POST['tanggal_kembali'] ?? '';
        
        // Validasi input
        if (empty($idUser) || empty($idBuku) || empty($tanggalKembali)) {
            $this->setFlash('danger', 'Semua field harus diisi');
            $this->redirect('/admin/transaksi/create');
        }
        
        // Menyimpan data peminjaman
        $this->peminjamanModel->pinjam($idUser, $idBuku, $tanggalKembali);
        
        // Mengurangi stok buku
        $this->bukuModel->updateStok($idBuku, -1);
        
        // Notifikasi sukses
        $this->setFlash('success', 'Transaksi peminjaman berhasil');
        
        // Redirect ke daftar transaksi
        $this->redirect('/admin/transaksi');
    }
    
    // Proses pengembalian buku oleh admin
    public function kembalikan($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data peminjaman berdasarkan ID
        $peminjaman = $this->peminjamanModel->getById($id);
        
        // Jika status masih dipinjam
        if ($peminjaman && $peminjaman['status'] === 'dipinjam') {
            
            // Mengubah status menjadi dikembalikan
            $this->peminjamanModel->kembalikan($id);
            
            // Menambah stok buku
            $this->bukuModel->updateStok($peminjaman['id_buku'], 1);
            
            // Notifikasi sukses
            $this->setFlash('success', 'Buku berhasil dikembalikan');
        }
        
        // Redirect ke daftar transaksi
        $this->redirect('/admin/transaksi');
    }
    
    // Menghapus transaksi peminjaman
    public function delete($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data peminjaman
        $peminjaman = $this->peminjamanModel->getById($id);
        
        // Jika transaksi masih dipinjam maka stok buku dikembalikan
        if ($peminjaman && $peminjaman['status'] === 'dipinjam') {
            $this->bukuModel->updateStok($peminjaman['id_buku'], 1);
        }
        
        // Menghapus data transaksi
        $this->peminjamanModel->delete($id);
        
        // Notifikasi sukses
        $this->setFlash('success', 'Transaksi berhasil dihapus');
        
        // Redirect ke daftar transaksi
        $this->redirect('/admin/transaksi');
    }
}