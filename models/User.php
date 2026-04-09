<?php
// Memanggil file Database.php untuk menangani koneksi database
require_once __DIR__ . '/../core/Database.php';

// Memanggil file Model.php sebagai class induk
require_once __DIR__ . '/../core/Model.php';

// Class User merupakan turunan dari class Model
class User extends Model {

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'tb_user';

    // Menentukan primary key tabel
    protected $primaryKey = 'id_user';
    

    // Method untuk mencari data user berdasarkan username
    public function findByUsername($username) {

        // Menggunakan parameter binding untuk keamanan dari SQL Injection
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE username = ?", [$username]);
    }
    

    // Method untuk memverifikasi proses login user
    public function verifyLogin($username, $password) {

        // Mengambil data user berdasarkan username
        $user = $this->findByUsername($username);

        // Mengecek apakah:
        // 1. User ditemukan
        // 2. Password sesuai
        // 3. Status user aktif
        if ($user && $user['password'] === $password && $user['status_aktif'] === 'aktif') {
            return $user; // Jika valid, kembalikan data user
        }

        return false; // Jika tidak valid, login gagal
    }
    

    // Method untuk mengambil semua data anggota (role user biasa, bukan admin)
    public function getAllAnggota() {

        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE role = 'user' 
            ORDER BY created_at DESC
        ");
        // Menampilkan data anggota terbaru terlebih dahulu
    }
    

    // Method untuk proses registrasi user baru
    public function register($data) {

        return $this->insert([
            'nama_lengkap' => $data['nama_lengkap'], // Nama lengkap user
            'username' => $data['username'], // Username untuk login
            'password' => $data['password'], // Password user
            'role' => 'user', // Default role anggota biasa
            'alamat' => $data['alamat'] ?? '', // Jika alamat tidak diisi, diset kosong
            'no_telp' => $data['no_telp'] ?? '' // Jika nomor telepon tidak diisi, diset kosong
        ]);
        // Method insert() berasal dari class Model
    }
    

    // Method untuk menghitung jumlah user berdasarkan role tertentu
    public function countByRole($role) {

        return $this->count("role = ?", [$role]);
        // Method count() kemungkinan berasal dari Model.php
    }
}