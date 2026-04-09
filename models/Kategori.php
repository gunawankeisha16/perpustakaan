<?php
// Memanggil file Database.php yang berisi konfigurasi dan fungsi koneksi database
require_once __DIR__ . '/../core/Database.php';

// Memanggil file Model.php yang menjadi parent class (class induk)
require_once __DIR__ . '/../core/Model.php';

// Membuat class Kategori yang merupakan turunan (inheritance) dari class Model
class Kategori extends Model {

    // Menentukan nama tabel database yang digunakan oleh model ini
    protected $table = 'tb_kategori';

    // Menentukan primary key dari tabel tb_kategori
    protected $primaryKey = 'id_kategori';
}