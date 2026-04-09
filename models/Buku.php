<?php
// Memanggil file Database.php untuk koneksi database
require_once __DIR__ . '/../core/Database.php';

// Memanggil file Model.php sebagai parent class (inheritance)
require_once __DIR__ . '/../core/Model.php';

// Class Buku merupakan turunan dari class Model
class Buku extends Model {

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'tb_buku';

    // Menentukan primary key dari tabel tb_buku
    protected $primaryKey = 'id_buku';
    

    // Method untuk mengambil semua data buku beserta nama kategorinya
    public function getAllWithKategori() {

        // Menjalankan query SELECT dengan JOIN ke tabel kategori
        return $this->db->fetchAll("
            SELECT b.*, k.nama_kategori 
            FROM {$this->table} b 
            LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori 
            ORDER BY b.created_at DESC
        ");
        // LEFT JOIN digunakan agar data buku tetap muncul walaupun tidak memiliki kategori
        // ORDER BY digunakan untuk mengurutkan data berdasarkan waktu pembuatan terbaru
    }
    

    // Method untuk mengambil satu data buku berdasarkan ID lengkap dengan kategorinya
    public function getByIdWithKategori($id) {

        // Menggunakan parameter binding (?) untuk keamanan dari SQL Injection
        return $this->db->fetch("
            SELECT b.*, k.nama_kategori 
            FROM {$this->table} b 
            LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori 
            WHERE b.id_buku = ?
        ", [$id]);
    }
    

    // Method untuk mencari buku berdasarkan keyword
    public function search($keyword) {

        // Menambahkan wildcard % agar pencarian bersifat fleksibel (LIKE)
        $keyword = "%{$keyword}%";

        return $this->db->fetchAll("
            SELECT b.*, k.nama_kategori 
            FROM {$this->table} b 
            LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori 
            WHERE b.judul LIKE ? OR b.pengarang LIKE ? OR b.penerbit LIKE ?
            ORDER BY b.judul ASC
        ", [$keyword, $keyword, $keyword]);
        // Pencarian dilakukan pada judul, pengarang, dan penerbit
        // ORDER BY judul ASC untuk mengurutkan hasil berdasarkan abjad
    }
    

    // Method untuk mengambil data buku yang stoknya masih tersedia
    public function getAvailable() {

        return $this->db->fetchAll("
            SELECT b.*, k.nama_kategori 
            FROM {$this->table} b 
            LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori 
            WHERE b.stok > 0
            ORDER BY b.judul ASC
        ");
        // Hanya menampilkan buku dengan stok lebih dari 0
    }
    

    // Method untuk mengupdate stok buku
    public function updateStok($id, $change) {

        return $this->db->query(
            "UPDATE {$this->table} SET stok = stok + ? WHERE id_buku = ?", 
            [$change, $id]
        );
        // stok = stok + ? memungkinkan stok bertambah atau berkurang
        // Jika $change bernilai negatif maka stok akan berkurang
        // Jika $change bernilai positif maka stok akan bertambah
    }
}