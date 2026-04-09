<?php
// Memanggil Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil model User
require_once __DIR__ . '/../models/User.php';

// Memanggil model Buku
require_once __DIR__ . '/../models/Buku.php';

// Memanggil model Peminjaman
require_once __DIR__ . '/../models/Peminjaman.php';

// Controller untuk mengatur dashboard
class DashboardController extends Controller {
    
    // Method utama dashboard
    public function index() {
        
        // Memastikan user sudah login
        $this->requireLogin();
        
        // Mengambil role user dari session
        $role = $_SESSION['user']['role'];
        
        // Jika role admin maka tampilkan dashboard admin
        if ($role === 'admin') {
            $this->adminDashboard();
        } else {
            // Jika bukan admin maka tampilkan dashboard user
            $this->userDashboard();
        }
    }
    
    // Dashboard khusus admin
    private function adminDashboard() {
        
        // Membuat instance model
        $userModel = new User();
        $bukuModel = new Buku();
        $peminjamanModel = new Peminjaman();
        
        // Mengambil data statistik untuk dashboard admin
        $stats = [
            
            // Menghitung total buku
            'total_buku' => $bukuModel->count(),
            
            // Menghitung jumlah anggota (role user)
            'total_anggota' => $userModel->countByRole('user'),
            
            // Menghitung jumlah buku yang sedang dipinjam
            'sedang_dipinjam' => $peminjamanModel->countByStatus('dipinjam'),
            
            // Menghitung jumlah buku yang sudah dikembalikan
            'sudah_dikembalikan' => $peminjamanModel->countByStatus('dikembalikan')
        ];
        
        // Mengambil semua transaksi peminjaman lengkap
        $transaksiTerbaru = $peminjamanModel->getAllWithDetail();
        
        // Mengambil hanya 5 transaksi terbaru
        $transaksiTerbaru = array_slice($transaksiTerbaru, 0, 5);
        
        // Menampilkan halaman dashboard admin
        $this->view('admin/dashboard', [
            'user' => $this->getCurrentUser(),   // Data user login
            'stats' => $stats,                   // Data statistik
            'transaksiTerbaru' => $transaksiTerbaru, // Data transaksi terbaru
            'flash' => $this->getFlash()         // Notifikasi
        ]);
    }
    
    // Dashboard khusus user/anggota
    private function userDashboard() {
        
        // Membuat instance model
        $bukuModel = new Buku();
        $peminjamanModel = new Peminjaman();
        
        // Mengambil ID user dari session
        $userId = $_SESSION['user']['id_user'] ?? 0;
        
        // Mengambil statistik peminjaman user
        $stats = [
            
            // Jumlah buku yang sedang dipinjam user
            'sedang_dipinjam' => $peminjamanModel->countByUserAndStatus($userId, 'dipinjam'),
            
            // Total seluruh riwayat peminjaman user
            'total_peminjaman' => count($peminjamanModel->getByUser($userId))
        ];
        
        // Mengambil daftar peminjaman yang masih aktif
        $peminjamanAktif = $peminjamanModel->getActivePinjaman($userId);
        
        // Mengambil 6 buku terbaru yang tersedia
        $bukuTerbaru = array_slice($bukuModel->getAvailable(), 0, 6);
        
        // Menampilkan dashboard user
        $this->view('user/dashboard', [
            'user' => $this->getCurrentUser(),
            'stats' => $stats,
            'peminjamanAktif' => $peminjamanAktif,
            'bukuTerbaru' => $bukuTerbaru,
            'flash' => $this->getFlash()
        ]);
    }
}