<?php
// Layout Header - Modern UI with Indigo & Emerald Theme
// File ini berfungsi sebagai layout header utama yang digunakan pada halaman dashboard dan halaman lainnya

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Mengambil path URL yang sedang diakses user
// Digunakan untuk menentukan menu sidebar yang sedang aktif

$role = $user['role'] ?? 'user';
// Mengambil role user dari data login
// Jika role tidak tersedia maka otomatis dianggap sebagai "user"
?>

<!DOCTYPE html>
<html lang="id">
<!-- Menentukan dokumen HTML menggunakan Bahasa Indonesia -->

<head>
    <meta charset="UTF-8">
    <!-- Encoding karakter agar mendukung berbagai simbol -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Mengatur tampilan agar responsive -->

    <title><?= $pageTitle ?? 'Perpustakaan' ?></title>
    <!-- Menampilkan judul halaman secara dinamis -->
    <!-- Jika variabel $pageTitle tidak ada maka defaultnya "Perpustakaan" -->

    <!-- Import Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Import Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Import Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        // Konfigurasi tambahan Tailwind CSS
        tailwind.config = {
            theme: {
                extend: {

                    // Menambahkan font Inter sebagai font default
                    fontFamily: { sans: ['Inter', 'sans-serif'] },

                    // Menambahkan warna custom primary dan accent
                    colors: {
                        primary: { 
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 
                            400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 
                            800: '#3730a3', 900: '#312e81' 
                        },

                        accent: { 
                            50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 300: '#6ee7b7', 
                            400: '#34d399', 500: '#10b981', 600: '#059669', 700: '#047857', 
                            800: '#065f46', 900: '#064e3b' 
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Mengatur font default */
        body { font-family: 'Inter', sans-serif; }

        /* Styling link sidebar */
        .sidebar-link { transition: all 0.25s ease; position: relative; }

        /* Efek hover sidebar */
        .sidebar-link:hover { transform: translateX(6px); background: rgba(255,255,255,0.15); }

        /* Styling sidebar aktif */
        .sidebar-link.active { background: rgba(255,255,255,0.2); border-left: 3px solid #10b981; }

        /* Styling card */
        .card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Efek hover card */
        .card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); }

        /* Styling tombol */
        .btn { transition: all 0.2s ease; }

        /* Efek hover tombol */
        .btn:hover { transform: translateY(-2px); }

        /* Efek klik tombol */
        .btn:active { transform: translateY(0); }

        /* Efek hover tabel */
        .table-row:hover { background: rgba(99,102,241,0.04); }

        /* Animasi fade */
        .animate-fade { animation: fadeIn 0.5s ease-out; }

        /* Animasi slide */
        .animate-slide { animation: slideUp 0.4s ease-out; }

        /* Keyframe animasi fade */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Keyframe animasi slide */
        @keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive sidebar untuk mobile */
        @media (max-width: 1024px) { 
            .sidebar { transform: translateX(-100%); } 
            .sidebar.active { transform: translateX(0); } 
        }

        /* Efek glass pada topbar */
        .glass { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">
<!-- Background halaman berwarna abu terang -->

<div class="flex">
<!-- Layout menggunakan flexbox -->

    <!-- Sidebar Navigasi -->
    <nav class="sidebar fixed lg:sticky lg:top-0 w-72 h-screen bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white z-50 transition-transform duration-300 shadow-2xl">
        
        <!-- Branding Sidebar -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex items-center gap-3">

                <!-- Icon aplikasi -->
                <div class="w-11 h-11 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center text-xl shadow-lg">
                    📚
                </div>

                <!-- Nama aplikasi -->
                <div>
                    <h2 class="text-xl font-bold text-white">Perpustakaan</h2>
                    <p class="text-xs text-slate-400">Sistem Manajemen</p>
                </div>
            </div>
        </div>

        <!-- Menu Sidebar -->
        <div class="p-4 space-y-1">
            <p class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu Utama</p>

            <!-- Kondisi jika user adalah admin -->
            <?php if ($role === 'admin'): ?>

                <!-- Menu Dashboard Admin -->
                <a href="<?= BASE_URL ?>/dashboard" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, 'dashboard') !== false && strpos($currentPath, 'admin') === false ? 'active' : '' ?>">
                    <i class="fas fa-home w-5 text-center"></i><span>Dashboard</span>
                </a>

                <!-- Menu Data Buku -->
                <a href="<?= BASE_URL ?>/admin/buku" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, '/buku') !== false ? 'active' : '' ?>">
                    <i class="fas fa-book w-5 text-center"></i><span>Data Buku</span>
                </a>

                <!-- Menu Kelola Anggota -->
                <a href="<?= BASE_URL ?>/admin/anggota" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, '/anggota') !== false ? 'active' : '' ?>">
                    <i class="fas fa-users w-5 text-center"></i><span>Kelola Anggota</span>
                </a>

                <!-- Menu Transaksi -->
                <a href="<?= BASE_URL ?>/admin/transaksi" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, '/transaksi') !== false ? 'active' : '' ?>">
                    <i class="fas fa-exchange-alt w-5 text-center"></i><span>Transaksi</span>
                </a>

            <?php else: ?>
            <!-- Menu jika user biasa -->

                <a href="<?= BASE_URL ?>/dashboard" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, 'dashboard') !== false ? 'active' : '' ?>">
                    <i class="fas fa-home w-5 text-center"></i><span>Dashboard</span>
                </a>

                <a href="<?= BASE_URL ?>/user/buku" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, '/buku') !== false ? 'active' : '' ?>">
                    <i class="fas fa-search w-5 text-center"></i><span>Cari Buku</span>
                </a>

                <a href="<?= BASE_URL ?>/user/peminjaman" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white <?= strpos($currentPath, '/peminjaman') !== false ? 'active' : '' ?>">
                    <i class="fas fa-book-reader w-5 text-center"></i><span>Peminjaman Saya</span>
                </a>

            <?php endif; ?>

            <!-- Menu Logout -->
            <div class="pt-6 mt-6 border-t border-slate-700/50">
                <a href="<?= BASE_URL ?>/logout" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i><span>Logout</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Konten utama halaman -->
    <main class="flex-1 min-h-screen lg:ml-0">

        <!-- Tombol menu mobile -->
        <button onclick="document.querySelector('.sidebar').classList.toggle('active')" class="lg:hidden fixed top-4 left-4 z-50 p-3 bg-slate-800 text-white rounded-xl shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Topbar -->
        <header class="sticky top-0 z-40 glass border-b border-slate-200/80">
            <div class="px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

                <!-- Judul halaman -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-800"><?= $pageTitle ?? 'Dashboard' ?></h1>

                    <!-- Menampilkan tanggal saat ini -->
                    <p class="text-sm text-slate-500 mt-0.5"><?= date('l, d F Y') ?></p>
                </div>

                <!-- Informasi user -->
                <div class="flex items-center gap-4">

                    <!-- Nama user -->
                    <div class="text-right hidden sm:block">
                        <p class="font-semibold text-slate-800"><?= htmlspecialchars($user['nama_lengkap'] ?? 'User') ?></p>

                        <!-- Badge role -->
                        <span class="inline-block px-2.5 py-0.5 text-xs font-medium rounded-full <?= $role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' ?>">
                            <?= ucfirst($role) ?>
                        </span>
                    </div>

                    <!-- Avatar user -->
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white">
                        <?= strtoupper(substr($user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                        <!-- Mengambil huruf pertama nama user -->
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Konten halaman -->
        <div class="p-6 lg:p-8 animate-fade">

            <!-- Flash message notifikasi -->
            <?php if (!empty($flash)): ?>
                <div class="animate-slide mb-6 p-4 rounded-xl flex items-center gap-3 <?= $flash['type'] === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($flash['type'] === 'warning' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-red-50 text-red-800 border border-red-200') ?>">
                    
                    <!-- Icon notifikasi -->
                    <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : ($flash['type'] === 'warning' ? 'exclamation-triangle' : 'times-circle') ?> text-lg"></i>

                    <!-- Pesan notifikasi -->
                    <span class="font-medium"><?= $flash['message'] ?></span>
                </div>
            <?php endif; ?>