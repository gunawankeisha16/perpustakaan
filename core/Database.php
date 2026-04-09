<?php
// Class Database - Singleton pattern dengan PDO
class Database {
    
    // Menyimpan instance Database agar hanya dibuat satu kali (Singleton)
    private static $instance = null;
    
    // Variabel untuk menyimpan objek koneksi PDO
    private $pdo;
    
    // Constructor dibuat private agar tidak bisa dipanggil dari luar class
    // Ini adalah konsep Singleton Pattern
    private function __construct() {
        
        // Memanggil file konfigurasi database
        require_once __DIR__ . '/../config/database.php';
        
        // Membuat DSN (Data Source Name) untuk koneksi ke database MySQL
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        
        // Opsi konfigurasi PDO
        $options = [
            
            // Menampilkan error dalam bentuk exception
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            
            // Mengambil data dalam bentuk array asosiatif
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            
            // Menonaktifkan emulasi prepared statement agar lebih aman
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        try {
            // Membuat koneksi PDO menggunakan konfigurasi database
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            
            // Jika koneksi gagal, tampilkan pesan error
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
    
    // Method untuk mengambil instance Database (Singleton)
    public static function getInstance() {
        
        // Jika instance belum dibuat
        if (self::$instance === null) {
            
            // Buat instance baru
            self::$instance = new self();
        }
        
        // Mengembalikan instance Database yang sama
        return self::$instance;
    }
    
    // Mengambil objek koneksi PDO
    public function getConnection() { 
        return $this->pdo; 
    }
    
    // Method untuk menjalankan query SQL dengan parameter
    public function query($sql, $params = []) {
        
        // Menyiapkan query (prepared statement)
        $stmt = $this->pdo->prepare($sql);
        
        // Menjalankan query dengan parameter
        $stmt->execute($params);
        
        // Mengembalikan objek statement
        return $stmt;
    }
    
    // Mengambil satu data dari hasil query
    public function fetch($sql, $params = []) {
        
        // Menjalankan query lalu mengambil satu baris data
        return $this->query($sql, $params)->fetch();
    }
    
    // Mengambil semua data dari hasil query
    public function fetchAll($sql, $params = []) {
        
        // Menjalankan query lalu mengambil semua baris data
        return $this->query($sql, $params)->fetchAll();
    }
    
    // Mengambil ID terakhir dari data yang baru ditambahkan
    public function lastInsertId() { 
        return $this->pdo->lastInsertId(); 
    }
}