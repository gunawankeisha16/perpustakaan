<?php
// Memanggil Controller utama (parent class)
require_once __DIR__ . '/../core/Controller.php';

// Memanggil model Buku untuk mengelola data buku
require_once __DIR__ . '/../models/Buku.php';

// Memanggil model Kategori untuk mengelola kategori buku
require_once __DIR__ . '/../models/Kategori.php';

// Controller untuk mengelola data buku
class BukuController extends Controller {
    
    // Menyimpan instance model Buku
    private $bukuModel;
    
    // Menyimpan instance model Kategori
    private $kategoriModel;
    
    // Constructor dijalankan saat controller dipanggil
    public function __construct() {
        // Membuat object model Buku
        $this->bukuModel = new Buku();
        
        // Membuat object model Kategori
        $this->kategoriModel = new Kategori();
    }
    
    // Menampilkan daftar buku
    public function index() {
        
        // Hanya admin yang boleh mengakses
        $this->requireRole('admin');
        
        // Mengambil semua data buku beserta kategorinya
        $bukus = $this->bukuModel->getAllWithKategori();
        
        // Menampilkan halaman daftar buku
        $this->view('admin/buku/index', [
            'user' => $this->getCurrentUser(), // Data user login
            'bukus' => $bukus,                 // Data buku
            'flash' => $this->getFlash()       // Notifikasi
        ]);
    }
    
    // Menampilkan form tambah buku
    public function create() {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil semua kategori buku
        $kategoris = $this->kategoriModel->getAll();
        
        // Menampilkan halaman tambah buku
        $this->view('admin/buku/create', [
            'user' => $this->getCurrentUser(),
            'kategoris' => $kategoris,
            'flash' => $this->getFlash()
        ]);
    }
    
    // Menyimpan data buku baru
    public function store() {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data dari form
        $data = [
            'judul' => trim($_POST['judul'] ?? ''),
            'pengarang' => trim($_POST['pengarang'] ?? ''),
            'penerbit' => trim($_POST['penerbit'] ?? ''),
            'tahun_terbit' => $_POST['tahun_terbit'] ?? null,
            'id_kategori' => $_POST['id_kategori'] ?: null,
            'stok' => (int)($_POST['stok'] ?? 1)
        ];
        
        // Validasi data wajib
        if (empty($data['judul']) || empty($data['pengarang'])) {
            $this->setFlash('danger', 'Judul dan pengarang harus diisi');
            $this->redirect('/admin/buku/create');
        }
        
        // Menyimpan data buku ke database
        $this->bukuModel->insert($data);
        
        // Menampilkan pesan sukses
        $this->setFlash('success', 'Buku berhasil ditambahkan');
        
        // Redirect ke daftar buku
        $this->redirect('/admin/buku');
    }
    
    // Menampilkan form edit buku
    public function edit($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data buku berdasarkan ID
        $buku = $this->bukuModel->getById($id);
        
        // Mengambil semua kategori buku
        $kategoris = $this->kategoriModel->getAll();
        
        // Jika buku tidak ditemukan maka redirect
        if (!$buku) $this->redirect('/admin/buku');
        
        // Menampilkan halaman edit buku
        $this->view('admin/buku/edit', [
            'user' => $this->getCurrentUser(),
            'buku' => $buku,
            'kategoris' => $kategoris,
            'flash' => $this->getFlash()
        ]);
    }
    
    // Mengupdate data buku
    public function update($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Mengambil data dari form
        $data = [
            'judul' => trim($_POST['judul'] ?? ''),
            'pengarang' => trim($_POST['pengarang'] ?? ''),
            'penerbit' => trim($_POST['penerbit'] ?? ''),
            'tahun_terbit' => $_POST['tahun_terbit'] ?? null,
            'id_kategori' => $_POST['id_kategori'] ?: null,
            'stok' => (int)($_POST['stok'] ?? 1)
        ];
        
        // Mengupdate data buku ke database
        $this->bukuModel->update($id, $data);
        
        // Pesan sukses
        $this->setFlash('success', 'Buku berhasil diupdate');
        
        // Redirect ke daftar buku
        $this->redirect('/admin/buku');
    }
    
    // Menghapus buku
    public function delete($id) {
        
        // Validasi admin
        $this->requireRole('admin');
        
        // Menghapus data buku
        $this->bukuModel->delete($id);
        
        // Pesan sukses
        $this->setFlash('success', 'Buku berhasil dihapus');
        
        // Redirect ke daftar buku
        $this->redirect('/admin/buku');
    }
    
    // Fitur pencarian buku
    public function search() {
        
        // Memastikan user sudah login
        $this->requireLogin();
        
        // Mengambil keyword pencarian dari URL
        $keyword = trim($_GET['q'] ?? '');
        
        // Jika ada keyword maka lakukan pencarian
        // Jika tidak maka tampilkan buku yang tersedia
        $bukus = $keyword ? $this->bukuModel->search($keyword) : $this->bukuModel->getAvailable();
        
        // Menentukan view berdasarkan role user
        $view = $_SESSION['user']['role'] === 'admin' ? 'admin/buku/index' : 'user/buku/index';
        
        // Menampilkan hasil pencarian
        $this->view($view, [
            'user' => $this->getCurrentUser(),
            'bukus' => $bukus,
            'keyword' => $keyword,
            'flash' => $this->getFlash()
        ]);
    }
}