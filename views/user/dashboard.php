<?php
// Menentukan judul halaman dashboard
$pageTitle = 'Dashboard';

// Memanggil layout header (navbar, sidebar, topbar, dll)
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- ===================== STATISTIK DASHBOARD ===================== -->
<!-- Card statistik jumlah buku dipinjam dan total peminjaman -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">

    <!-- Card jumlah buku yang sedang dipinjam -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide">
        <div class="flex items-center justify-between">
            <div>
                <!-- Judul statistik -->
                <p class="text-sm font-medium text-slate-500 mb-1">Buku Dipinjam</p>

                <!-- Menampilkan jumlah buku sedang dipinjam -->
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['sedang_dipinjam'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon statistik -->
            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-book-reader text-2xl text-amber-600"></i>
            </div>
        </div>
    </div>

    <!-- Card total riwayat peminjaman -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide" style="animation-delay: 0.1s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Peminjaman</p>

                <!-- Menampilkan jumlah total peminjaman -->
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['total_peminjaman'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon statistik -->
            <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-history text-2xl text-indigo-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- ===================== QUICK ACTION ===================== -->
<!-- Tombol aksi cepat untuk user -->
<div class="flex flex-wrap gap-3 mb-8 animate-slide" style="animation-delay: 0.2s;">

    <!-- Tombol menuju halaman pinjam buku -->
    <a href="<?= BASE_URL ?>/user/peminjaman/pinjam" 
       class="btn px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center gap-2">
        <i class="fas fa-plus"></i> Pinjam Buku
    </a>

    <!-- Tombol menuju halaman pencarian buku -->
    <a href="<?= BASE_URL ?>/user/buku" 
       class="btn px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 rounded-xl font-semibold border-2 border-slate-200 flex items-center gap-2">
        <i class="fas fa-search"></i> Cari Buku
    </a>
</div>

<!-- ===================== BUKU SEDANG DIPINJAM ===================== -->
<!-- Menampilkan daftar buku yang sedang dipinjam user -->
<?php if (!empty($peminjamanAktif)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 overflow-hidden animate-slide" style="animation-delay: 0.3s;">

    <!-- Header section -->
    <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

            <!-- Icon -->
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-amber-600"></i>
            </div>

            Buku Sedang Dipinjam
        </h3>
    </div>

    <div class="divide-y divide-slate-100">

        <!-- Perulangan data peminjaman aktif -->
        <?php foreach ($peminjamanAktif as $p): 

            // Membuat objek tanggal tenggat pengembalian
            $tenggat = new DateTime($p['tanggal_kembali']);

            // Tanggal hari ini
            $today = new DateTime();

            // Mengecek apakah terlambat
            $isLate = $today > $tenggat;

            // Menghitung selisih hari
            $diff = $today->diff($tenggat);
        ?>

            <!-- Card item peminjaman -->
            <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">

                <div class="flex-1">

                    <!-- Judul buku -->
                    <h4 class="font-semibold text-slate-800 mb-1">
                        <?= htmlspecialchars($p['judul']) ?>
                    </h4>

                    <!-- Informasi tanggal -->
                    <div class="flex flex-wrap gap-3 text-sm text-slate-500">

                        <!-- Tanggal pinjam -->
                        <span>
                            <i class="fas fa-calendar-alt mr-1.5"></i>
                            Pinjam: <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </span>

                        <!-- Status sisa waktu -->
                        <span class="<?= $isLate ? 'text-red-600 font-medium' : '' ?>">
                            <i class="fas fa-clock mr-1.5"></i>

                            <?php if ($isLate): ?>
                                Terlambat <?= $diff->days ?> hari!
                            <?php else: ?>
                                Sisa <?= $diff->days ?> hari
                            <?php endif; ?>
                        </span>

                    </div>
                </div>

                <!-- Tombol pengembalian buku -->
                <a href="<?= BASE_URL ?>/user/peminjaman/kembalikan/<?= $p['id_peminjaman'] ?>"
                   onclick="return confirm('Kembalikan buku ini?')"
                   class="btn px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium text-sm shadow-lg shadow-emerald-200">

                    <i class="fas fa-undo mr-2"></i>Kembalikan
                </a>

            </div>

        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===================== BUKU TERSEDIA ===================== -->
<!-- Menampilkan daftar buku terbaru / tersedia -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.4s;">

    <!-- Header -->
    <div class="p-6 border-b border-slate-100">
        <div class="flex items-center justify-between">

            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

                <!-- Icon -->
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-indigo-600"></i>
                </div>

                Buku Tersedia
            </h3>

            <!-- Link melihat semua buku -->
            <a href="<?= BASE_URL ?>/user/buku" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>

        </div>
    </div>

    <div class="p-6">

        <!-- Grid daftar buku -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php foreach ($bukuTerbaru as $index => $b): ?>

                <!-- Card buku -->
                <div class="card p-5 bg-slate-50 hover:bg-white rounded-xl border border-slate-100 hover:border-slate-200">

                    <!-- Judul buku -->
                    <h4 class="font-semibold text-slate-800 mb-3 line-clamp-1">
                        <?= htmlspecialchars($b['judul']) ?>
                    </h4>

                    <!-- Detail buku -->
                    <div class="space-y-1.5 text-sm text-slate-600">

                        <!-- Pengarang -->
                        <p class="flex items-center gap-2">
                            <i class="fas fa-user text-indigo-500 w-4"></i> 
                            <?= htmlspecialchars($b['pengarang']) ?>
                        </p>

                        <!-- Kategori -->
                        <p class="flex items-center gap-2">
                            <i class="fas fa-tag text-emerald-500 w-4"></i> 
                            <?= htmlspecialchars($b['nama_kategori'] ?? 'Umum') ?>
                        </p>

                        <!-- Stok buku -->
                        <p class="flex items-center gap-2">
                            <i class="fas fa-layer-group text-amber-500 w-4"></i> 
                            Stok: 
                            <span class="font-bold text-emerald-600">
                                <?= $b['stok'] ?>
                            </span>
                        </p>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
// Memanggil layout footer
require_once __DIR__ . '/../layouts/footer.php';
?>