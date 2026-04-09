<?php
// Base Controller - Helper methods untuk views dan auth
class Controller {

    // Fungsi untuk menampilkan file view
    protected function view($view, $data = []) {
        
        // Mengubah array $data menjadi variabel
        // Contoh: ['user' => $user] menjadi $user
        extract($data);
        
        // Menentukan lokasi file view
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        
        // Mengecek apakah file view ada
        if (file_exists($viewPath)) {
            
            // Menjalankan file view
            require_once $viewPath;
        } else {
            
            // Menampilkan error jika view tidak ditemukan
            die("View '{$view}' tidak ditemukan.");
        }
    }
    
    // Fungsi untuk mengalihkan halaman (redirect)
    protected function redirect($url) {
        
        // Mengarahkan user ke URL tertentu
        header("Location: " . BASE_URL . $url);
        
        // Menghentikan eksekusi program setelah redirect
        exit;
    }
    
    // Mengecek apakah user sudah login
    protected function isLoggedIn() {
        
        // Mengecek apakah session user tersedia
        return isset($_SESSION['user']);
    }
    
    // Mengecek apakah user memiliki role tertentu
    protected function hasRole($role) {
        
        // Mengecek login + mengecek role user
        return $this->isLoggedIn() && $_SESSION['user']['role'] === $role;
    }
    
    // Memastikan user wajib login
    protected function requireLogin() {
        
        // Jika belum login maka diarahkan ke halaman login
        if (!$this->isLoggedIn()) $this->redirect('/login');
    }
    
    // Memastikan user memiliki role tertentu
    protected function requireRole($roles) {
        
        // Pastikan user sudah login
        $this->requireLogin();
        
        // Jika role yang diberikan berupa string
        // maka diubah menjadi array
        if (is_string($roles)) $roles = [$roles];
        
        // Mengecek apakah role user termasuk dalam daftar role yang diizinkan
        if (!in_array($_SESSION['user']['role'], $roles)) 
            $this->redirect('/dashboard');
    }
    
    // Mengambil data user yang sedang login
    protected function getCurrentUser() {
        
        // Mengembalikan data session user
        return $_SESSION['user'] ?? null;
    }
    
    // Menyimpan pesan notifikasi sementara (flash message)
    protected function setFlash($type, $message) {
        
        // Menyimpan pesan ke session
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
    
    // Mengambil flash message
    protected function getFlash() {
        
        // Jika ada flash message
        if (isset($_SESSION['flash'])) {
            
            // Simpan pesan ke variabel sementara
            $flash = $_SESSION['flash'];
            
            // Hapus flash agar hanya muncul sekali
            unset($_SESSION['flash']);
            
            return $flash;
        }
        
        // Jika tidak ada flash message
        return null;
    }
}