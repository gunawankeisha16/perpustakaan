<?php
// Base Model - Class induk dengan CRUD operations
class Model {
    
    // Menyimpan objek koneksi database
    protected $db;
    
    // Menyimpan nama tabel (akan diisi oleh class turunan)
    protected $table;
    
    // Menyimpan primary key tabel (default = id)
    protected $primaryKey = 'id';
    
    // Constructor untuk menghubungkan model dengan database
    public function __construct() {
        
        // Mengambil instance database menggunakan Singleton
        $this->db = Database::getInstance();
    }
    
    // Mengambil semua data dari tabel
    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM {$this->table}");
    }
    
    // Mengambil satu data berdasarkan primary key
    public function getById($id) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
    }
    
    // Mengambil semua data berdasarkan kondisi tertentu
    public function getWhere($column, $value) {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE {$column} = ?", [$value]);
    }
    
    // Mengambil satu data berdasarkan kondisi tertentu
    public function getOneWhere($column, $value) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE {$column} = ?", [$value]);
    }
    
    // Menambahkan data baru ke tabel
    public function insert($data) {
        
        // Mengambil nama kolom dari array data
        $columns = implode(', ', array_keys($data));
        
        // Membuat placeholder ? sesuai jumlah data
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        // Menjalankan query INSERT
        $this->db->query(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})",
            array_values($data)
        );
        
        // Mengembalikan ID data yang baru ditambahkan
        return $this->db->lastInsertId();
    }
    
    // Mengupdate data berdasarkan primary key
    public function update($id, $data) {
        
        // Membuat bagian SET pada query UPDATE
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';
        
        // Menggabungkan nilai data dengan id
        $params = array_merge(array_values($data), [$id]);
        
        // Menjalankan query UPDATE
        return $this->db->query(
            "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?",
            $params
        );
    }
    
    // Menghapus data berdasarkan primary key
    public function delete($id) {
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }
    
    // Menghitung jumlah data dalam tabel
    public function count($where = null, $params = []) {
        
        // Query dasar untuk menghitung jumlah data
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        
        // Jika ada kondisi WHERE, tambahkan ke query
        if ($where) $sql .= " WHERE {$where}";
        
        // Mengambil hasil total data
        return $this->db->fetch($sql, $params)['total'];
    }
}