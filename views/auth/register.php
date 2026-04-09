<!DOCTYPE html>
<!-- Mendefinisikan bahwa dokumen ini menggunakan standar HTML5 -->

<html lang="id">
<!-- Menentukan bahasa utama halaman adalah Bahasa Indonesia -->

<head>
    <!-- Bagian head berisi konfigurasi halaman -->

    <meta charset="UTF-8">
    <!-- Mengatur encoding karakter agar mendukung berbagai simbol dan huruf -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Membuat tampilan halaman menjadi responsif pada perangkat mobile dan desktop -->
    
    <title>Login - Perpustakaan</title>
    <!-- Judul halaman yang muncul pada tab browser -->
    
    <!-- Menghubungkan Tailwind CSS melalui CDN -->
    <!-- Tailwind digunakan untuk mempercepat styling UI menggunakan class utility -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Menghubungkan Font Awesome -->
    <!-- Digunakan untuk menampilkan icon seperti user, kunci, dan login -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Menghubungkan Google Fonts Inter -->
    <!-- Digunakan untuk memperindah tampilan teks -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Mengatur font default seluruh halaman */
        body { font-family: 'Inter', sans-serif; }

        /* Class untuk animasi elemen melayang */
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        /* Animasi melayang dengan jeda 3 detik */
        .animate-float-delayed { animation: float 6s ease-in-out infinite 3s; }
        
        /* Keyframe animasi naik turun */
        @keyframes float { 
            0%, 100% { transform: translateY(0); } /* Posisi awal */
            50% { transform: translateY(-20px); } /* Bergerak ke atas */
        }

        /* Efek glassmorphism untuk card login */
        .glass { 
            background: rgba(255, 255, 255, 0.15); /* Transparansi */
            backdrop-filter: blur(12px); /* Efek blur background */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Border transparan */
        }

        /* Animasi transisi tombol */
        .btn { transition: all 0.2s ease; }

        /* Efek tombol saat cursor diarahkan */
        .btn:hover { transform: translateY(-2px); }
    </style>
</head>

<!-- Bagian utama tampilan halaman -->
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 flex items-center justify-center p-4">
    <!-- min-h-screen = tinggi halaman minimal full layar -->
    <!-- bg-gradient = background gradasi warna -->
    <!-- flex items-center justify-center = memposisikan konten di tengah -->
    <!-- p-4 = padding halaman -->

    <!-- Elemen dekorasi background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- absolute inset-0 = memenuhi seluruh layar -->
        <!-- pointer-events-none = elemen tidak bisa diklik -->

        <!-- Lingkaran dekorasi pertama -->
        <div class="animate-float absolute top-20 left-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl"></div>
        
        <!-- Lingkaran dekorasi kedua -->
        <div class="animate-float-delayed absolute bottom-20 right-10 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
        
        <!-- Lingkaran dekorasi ketiga -->
        <div class="animate-float absolute top-1/2 left-1/4 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl"></div>
    </div>
    
    <!-- Container utama form login -->
    <div class="w-full max-w-md relative z-10">
        <!-- max-w-md = lebar maksimal container -->
        <!-- z-10 = memastikan tampil di atas background -->

        <!-- Bagian branding aplikasi -->
        <div class="text-center mb-8">

            <!-- Icon buku -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl shadow-2xl shadow-emerald-500/30 mb-6">
                <span class="text-4xl">📚</span>
            </div>

            <!-- Judul aplikasi -->
            <h1 class="text-3xl font-bold text-white mb-2">Perpustakaan</h1>

            <!-- Deskripsi aplikasi -->
            <p class="text-slate-400">Sistem Manajemen Perpustakaan Modern</p>
        </div>
        
        <!-- Card form login -->
        <div class="glass rounded-3xl p-8 shadow-2xl">
            <!-- glass = efek transparan -->
            <!-- rounded-3xl = sudut membulat -->
            <!-- p-8 = padding -->
            <!-- shadow-2xl = bayangan card -->

            <!-- Judul form login -->
            <h2 class="text-2xl font-bold text-white text-center mb-6">Masuk ke Akun</h2>
            
            <!-- Mengecek apakah ada pesan error -->
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 text-red-200 rounded-xl flex items-center gap-3">
                    
                    <!-- Icon error -->
                    <i class="fas fa-exclamation-circle"></i>
                    
                    <!-- Menampilkan pesan error dengan keamanan htmlspecialchars -->
                    <!-- htmlspecialchars mencegah serangan XSS -->
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Form login -->
            <form action="<?= BASE_URL ?>/login" method="POST" class="space-y-5">
                <!-- action = tujuan pengiriman data -->
                <!-- method POST = mengirim data secara aman -->

                <!-- Input Username -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Username</label>
                    
                    <div class="relative">

                        <!-- Icon username -->
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <!-- Input username -->
                        <input type="text" name="username" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/30 outline-none transition-all"
                               placeholder="Masukkan username">
                        <!-- required = wajib diisi -->
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    
                    <div class="relative">

                        <!-- Icon password -->
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <!-- Input password -->
                        <input type="password" name="password" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/30 outline-none transition-all"
                               placeholder="Masukkan password">
                    </div>
                </div>

                <!-- Tombol login -->
                <button type="submit" class="btn w-full py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-2 text-lg">
                    
                    <!-- Icon login -->
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>
            
            <!-- Link menuju halaman registrasi -->
            <p class="text-center text-slate-400 mt-6">
                Belum punya akun? 
                
                <!-- Link menuju halaman daftar akun -->
                <a href="<?= BASE_URL ?>/register" class="text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">Daftar</a>
            </p>
        </div>
        
        <!-- Footer halaman -->
        <p class="text-center text-slate-500 text-sm mt-8">
            &copy; <?= date('Y') ?> Perpustakaan. All rights reserved.
            <!-- date('Y') digunakan untuk menampilkan tahun secara otomatis -->
        </p>
    </div>
</body>
</html>