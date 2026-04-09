<?php
// Memanggil class Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil model User untuk mengolah data user dari database
require_once __DIR__ . '/../models/User.php';

// Membuat controller autentikasi user
class AuthController extends Controller {
    
    // Menyimpan instance model User
    private $userModel;
    
    // Constructor dijalankan saat controller dipanggil
    public function __construct() {
        // Membuat object dari model User
        $this->userModel = new User();
    }
    
    // Menampilkan halaman form login
    public function loginForm() {
        
        // Jika user sudah login maka diarahkan ke dashboard
        if ($this->isLoggedIn()) $this->redirect('/dashboard');
        
        // Mengambil pesan notifikasi (flash message)
        $flash = $this->getFlash();
        
        // Menampilkan halaman login
        $this->view('auth/login', ['flash' => $flash]);
    }
    
    // Proses login user
    public function login() {
        
        // Mengambil data dari form login
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        // Validasi jika input kosong
        if (empty($username) || empty($password)) {
            $this->setFlash('danger', 'Username dan password harus diisi');
            $this->redirect('/login');
        }
        
        // Memverifikasi login melalui model User
        $user = $this->userModel->verifyLogin($username, $password);
        
        // Jika login berhasil
        if ($user) {
            
            // Menyimpan data user ke session
            $_SESSION['user'] = $user;
            
            // Redirect ke dashboard
            $this->redirect('/dashboard');
        } else {
            
            // Jika login gagal
            $this->setFlash('danger', 'Username atau password salah');
            $this->redirect('/login');
        }
    }
    
    // Menampilkan form registrasi
    public function registerForm() {
        
        // Jika sudah login maka diarahkan ke dashboard
        if ($this->isLoggedIn()) $this->redirect('/dashboard');
        
        // Mengambil flash message
        $flash = $this->getFlash();
        
        // Menampilkan halaman register
        $this->view('auth/register', ['flash' => $flash]);
    }
    
    // Proses pendaftaran user baru
    public function register() {
        
        // Mengambil data dari form register
        $data = [
            'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'no_telp' => trim($_POST['no_telp'] ?? '')
        ];
        
        // Validasi input wajib
        if (empty($data['nama_lengkap']) || empty($data['username']) || empty($data['password'])) {
            $this->setFlash('danger', 'Nama, username, dan password harus diisi');
            $this->redirect('/register');
        }
        
        // Mengecek apakah username sudah digunakan
        if ($this->userModel->findByUsername($data['username'])) {
            $this->setFlash('danger', 'Username sudah digunakan');
            $this->redirect('/register');
        }
        
        // Menyimpan data user baru ke database
        $this->userModel->register($data);
        
        // Memberi notifikasi berhasil daftar
        $this->setFlash('success', 'Pendaftaran berhasil! Silakan login');
        
        // Redirect ke halaman login
        $this->redirect('/login');
    }
    
    // Proses logout user
    public function logout() {
        
        // Menghapus semua session
        session_destroy();
        
        // Redirect ke halaman login
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}