<?php
// Memanggil file Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil Model User untuk mengolah data user/anggota
require_once __DIR__ . '/../models/User.php';

// Membuat class AnggotaController yang mewarisi Controller
class AnggotaController extends Controller {
    
    // Variabel untuk menyimpan object User Model
    private $userModel;
    
    // Constructor dijalankan saat controller dipanggil
    public function __construct() {
        // Membuat instance dari model User
        $this->userModel = new User();
    }
    
    // Method untuk menampilkan daftar anggota
    public function index() {
        
        // Memastikan hanya admin yang bisa mengakses
        $this->requireRole('admin');
        
        // Mengambil semua data anggota dari model
        $anggota = $this->userModel->getAllAnggota();
        
        // Menampilkan view halaman daftar anggota
        $this->view('admin/anggota/index', [
            'user' => $this->getCurrentUser(), // Data user yang sedang login
            'anggota' => $anggota,             // Data anggota dari database
            'flash' => $this->getFlash()       // Pesan notifikasi sementara
        ]);
    }
    
    // Method untuk menampilkan halaman tambah anggota
    public function create() {
        
        // Hanya admin yang boleh mengakses
        $this->requireRole('admin');
        
        // Menampilkan form tambah anggota
        $this->view('admin/anggota/create', [
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash()
        ]);
    }
    
    // Method untuk menyimpan data anggota baru
    public function store() {
        
        // Validasi role admin
        $this->requireRole('admin');
        
        // Mengambil data dari form POST
        $data = [
            'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'no_telp' => trim($_POST['no_telp'] ?? '')
        ];
        
        // Validasi jika field wajib kosong
        if (empty($data['nama_lengkap']) || empty($data['username']) || empty($data['password'])) {
            
            // Set pesan error
            $this->setFlash('danger', 'Nama, username, dan password harus diisi');
            
            // Redirect kembali ke form tambah anggota
            $this->redirect('/admin/anggota/create');
        }
        
        // Mengecek apakah username sudah dipakai
        if ($this->userModel->findByUsername($data['username'])) {
            $this->setFlash('danger', 'Username sudah digunakan');
            $this->redirect('/admin/anggota/create');
        }
        
        // Menyimpan data anggota ke database
        $this->userModel->register($data);
        
        // Set pesan sukses
        $this->setFlash('success', 'Anggota berhasil ditambahkan');
        
        // Redirect ke halaman daftar anggota
        $this->redirect('/admin/anggota');
    }
    
    // Method untuk menampilkan form edit anggota
    public function edit($id) {
        
        // Validasi role admin
        $this->requireRole('admin');
        
        // Mengambil data anggota berdasarkan ID
        $anggota = $this->userModel->getById($id);
        
        // Jika data tidak ada atau bukan role user maka redirect
        if (!$anggota || $anggota['role'] !== 'user') 
            $this->redirect('/admin/anggota');
        
        // Menampilkan halaman edit anggota
        $this->view('admin/anggota/edit', [
            'user' => $this->getCurrentUser(),
            'anggota' => $anggota,
            'flash' => $this->getFlash()
        ]);
    }
    
    // Method untuk mengupdate data anggota
    public function update($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data dari form
        $data = [
            'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'no_telp' => trim($_POST['no_telp'] ?? ''),
            'status_aktif' => $_POST['status_aktif'] ?? 'aktif'
        ];
        
        // Jika password diisi maka update password
        if (!empty($_POST['password'])) {
            $data['password'] = trim($_POST['password']);
        }
        
        // Mengupdate data ke database
        $this->userModel->update($id, $data);
        
        // Pesan sukses
        $this->setFlash('success', 'Data anggota berhasil diupdate');
        
        // Redirect ke daftar anggota
        $this->redirect('/admin/anggota');
    }
    
    // Method untuk menghapus anggota
    public function delete($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Menghapus data anggota berdasarkan ID
        $this->userModel->delete($id);
        
        // Pesan sukses
        $this->setFlash('success', 'Anggota berhasil dihapus');
        
        // Redirect ke daftar anggota
        $this->redirect('/admin/anggota');
    }
}