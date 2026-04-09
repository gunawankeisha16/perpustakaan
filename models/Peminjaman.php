<?php
// Memanggil file Database.php untuk koneksi database
require_once __DIR__ . '/../core/Database.php';

// Memanggil file Model.php sebagai parent class
require_once __DIR__ . '/../core/Model.php';

// Class Peminjaman merupakan turunan dari class Model
class Peminjaman extends Model {

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'tb_peminjaman';

    // Menentukan primary key tabel
    protected $primaryKey = 'id_peminjaman';
    

    // Method untuk mengambil semua data peminjaman lengkap dengan nama user dan judul buku
    public function getAllWithDetail() {

        return $this->db->fetchAll("
            SELECT p.*, u.nama_lengkap, b.judul 
            FROM {$this->table} p 
            JOIN tb_user u ON p.id_user = u.id_user 
            JOIN tb_buku b ON p.id_buku = b.id_buku 
            ORDER BY p.created_at DESC
        ");
        // JOIN digunakan untuk menggabungkan data dari tabel user dan buku
        // ORDER BY digunakan untuk menampilkan data terbaru terlebih dahulu
    }
    

    // Method untuk mengambil data peminjaman berdasarkan user tertentu
    public function getByUser($userId) {

        return $this->db->fetchAll("
            SELECT p.*, b.judul, b.pengarang 
            FROM {$this->table} p 
            JOIN tb_buku b ON p.id_buku = b.id_buku 
            WHERE p.id_user = ? 
            ORDER BY p.created_at DESC
        ", [$userId]);
        // Parameter binding (?) digunakan untuk keamanan dari SQL Injection
    }
    

    // Method untuk mengambil data peminjaman yang masih aktif (belum dikembalikan)
    public function getActivePinjaman($userId) {

        return $this->db->fetchAll("
            SELECT p.*, b.judul, b.pengarang 
            FROM {$this->table} p 
            JOIN tb_buku b ON p.id_buku = b.id_buku 
            WHERE p.id_user = ? AND p.status = 'dipinjam'
            ORDER BY p.tanggal_kembali ASC
        ", [$userId]);
        // Hanya menampilkan peminjaman dengan status "dipinjam"
        // Diurutkan berdasarkan tanggal pengembalian terdekat
    }
    

    // Method untuk melakukan proses peminjaman buku
    public function pinjam($userId, $bukuId, $tanggalKembali) {

        return $this->insert([
            'id_user' => $userId, // ID user yang meminjam
            'id_buku' => $bukuId, // ID buku yang dipinjam
            'tanggal_pinjam' => date('Y-m-d'), // Tanggal pinjam otomatis hari ini
            'tanggal_kembali' => $tanggalKembali, // Tanggal batas pengembalian
            'status' => 'dipinjam' // Status peminjaman
        ]);
        // Method insert() berasal dari class Model
    }
    

    // Method untuk proses pengembalian buku
    public function kembalikan($id) {

        // Mengambil data peminjaman berdasarkan ID
        $peminjaman = $this->getById($id);

        // Inisialisasi denda
        $denda = 0;

        // Mendapatkan tanggal hari ini
        $today = new DateTime();

        // Mengambil tanggal batas pengembalian dari data peminjaman
        $tanggalKembali = new DateTime($peminjaman['tanggal_kembali']);
        
        // Mengecek apakah pengembalian terlambat
        if ($today > $tanggalKembali) {

            // Menghitung selisih hari keterlambatan
            $selisih = $today->diff($tanggalKembali)->days;

            // Menghitung denda (Rp 1.000 per hari)
            $denda = $selisih * 1000;
        }
        
        // Update data peminjaman menjadi dikembalikan
        return $this->update($id, [
            'tanggal_dikembalikan' => date('Y-m-d'), // Tanggal buku dikembalikan
            'status' => 'dikembalikan', // Mengubah status
            'denda' => $denda // Menyimpan nilai denda jika ada
        ]);
    }
    

    // Method untuk menghitung jumlah peminjaman berdasarkan status tertentu
    public function countByStatus($status) {

        return $this->count("status = ?", [$status]);
        // Method count() kemungkinan berasal dari Model.php
    }
    

    // Method untuk menghitung jumlah peminjaman berdasarkan user dan status
    public function countByUserAndStatus($userId, $status) {

        return $this->count("id_user = ? AND status = ?", [$userId, $status]);
    }
}