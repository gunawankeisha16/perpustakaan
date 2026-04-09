-- =====================================================
-- Database: db_perpustakaan
-- Sistem Perpustakaan dengan 2 Role (Admin, User)
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_perpus;
USE db_perpus;

-- Tabel User (Admin & Anggota)
CREATE TABLE tb_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    alamat TEXT,
    no_telp VARCHAR(20),
    status_aktif ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Kategori Buku
CREATE TABLE tb_kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

-- Tabel Buku
CREATE TABLE tb_buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100),
    tahun_terbit YEAR,
    id_kategori INT,
    stok INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES tb_kategori(id_kategori) ON DELETE SET NULL
);

-- Tabel Peminjaman
CREATE TABLE tb_peminjaman (
    id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_buku INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    tanggal_dikembalikan DATE NULL,
    status ENUM('dipinjam', 'dikembalikan') DEFAULT 'dipinjam',
    denda INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES tb_buku(id_buku) ON DELETE CASCADE
);

-- =====================================================
-- Sample Data
-- =====================================================

-- User (password: 123456)
INSERT INTO tb_user (nama_lengkap, username, password, role) VALUES
('Administrator', 'admin', '123456', 'admin'),
('Budi Santoso', 'budi', '123456', 'user'),
('Siti Rahayu', 'siti', '123456', 'user');

-- Kategori
INSERT INTO tb_kategori (nama_kategori) VALUES
('Fiksi'),
('Non-Fiksi'),
('Sains'),
('Teknologi'),
('Sejarah');

-- Buku
INSERT INTO tb_buku (judul, pengarang, penerbit, tahun_terbit, id_kategori, stok) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 1, 5),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 1, 3),
('Sapiens', 'Yuval Noah Harari', 'Harper', 2011, 2, 4),
('Cosmos', 'Carl Sagan', 'Random House', 1980, 3, 2),
('Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 4, 3),
('Sejarah Indonesia Modern', 'M.C. Ricklefs', 'Serambi', 2008, 5, 2);
