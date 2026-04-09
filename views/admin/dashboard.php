<?php
// Menentukan judul halaman dashboard
$pageTitle = 'Dashboard Admin';

// Memanggil file layout header (biasanya berisi navbar, CSS, dan pembuka HTML)
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- ================= STATISTIK DASHBOARD ================= -->
<!-- Bagian ini menampilkan ringkasan data perpustakaan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- ===== CARD TOTAL BUKU ===== -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide">
        <div class="flex items-center justify-between">
            <div>
                <!-- Judul statistik -->
                <p class="text-sm font-medium text-slate-500 mb-1">Total Buku</p>

                <!-- Menampilkan jumlah buku -->
                <!-- Operator ?? digunakan untuk menghindari error jika data kosong -->
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['total_buku'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon buku -->
            <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-book text-2xl text-indigo-600"></i>
            </div>
        </div>
    </div>

    <!-- ===== CARD TOTAL ANGGOTA ===== -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide" style="animation-delay: 0.1s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Anggota</p>
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['total_anggota'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon anggota -->
            <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-2xl text-emerald-600"></i>
            </div>
        </div>
    </div>

    <!-- ===== CARD BUKU YANG SEDANG DIPINJAM ===== -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide" style="animation-delay: 0.2s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['sedang_dipinjam'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon membaca -->
            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-book-reader text-2xl text-amber-600"></i>
            </div>
        </div>
    </div>

    <!-- ===== CARD BUKU YANG SUDAH DIKEMBALIKAN ===== -->
    <div class="card bg-white rounded-2xl p-6 shadow-sm border border-slate-200 animate-slide" style="animation-delay: 0.3s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Dikembalikan</p>
                <h3 class="text-3xl font-bold text-slate-800">
                    <?= $stats['sudah_dikembalikan'] ?? 0 ?>
                </h3>
            </div>

            <!-- Icon centang -->
            <div class="w-14 h-14 bg-violet-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl text-violet-600"></i>
            </div>
        </div>
    </div>

</div>

<!-- ================= TRANSAKSI TERBARU ================= -->
<!-- Bagian ini menampilkan daftar transaksi terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.4s;">
    
    <!-- Header tabel -->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

        <!-- Judul section -->
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-history text-indigo-600"></i>
            </div>
            Transaksi Terbaru
        </h3>

        <!-- Tombol menuju halaman semua transaksi -->
        <a href="<?= BASE_URL ?>/admin/transaksi" 
           class="btn px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium text-sm shadow-lg shadow-indigo-200 flex items-center gap-2">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tabel transaksi -->
    <div class="overflow-x-auto">
        <table class="w-full">

            <!-- HEADER TABEL -->
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th class="hidden md:table-cell">Tgl Pinjam</th>
                    <th class="hidden md:table-cell">Tenggat</th>
                    <th>Status</th>
                </tr>
            </thead>

            <!-- ISI DATA -->
            <tbody class="divide-y divide-slate-100">

                <!-- Mengecek apakah ada transaksi -->
                <?php if (!empty($transaksiTerbaru)): ?>

                    <?php foreach ($transaksiTerbaru as $t): ?>

                        <tr class="table-row transition-colors">

                            <!-- Nama anggota -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <!-- Avatar huruf pertama nama -->
                                    <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-semibold text-sm">
                                        <?= strtoupper(substr($t['nama_lengkap'], 0, 1)) ?>
                                    </div>

                                    <!-- Nama lengkap anggota -->
                                    <span class="font-medium text-slate-800">
                                        <?= htmlspecialchars($t['nama_lengkap']) ?>
                                    </span>
                                </div>
                            </td>

                            <!-- Judul buku -->
                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate">
                                <?= htmlspecialchars($t['judul']) ?>
                            </td>

                            <!-- Tanggal pinjam -->
                            <td class="px-6 py-4 text-slate-600 hidden md:table-cell">
                                <?= date('d M Y', strtotime($t['tanggal_pinjam'])) ?>
                            </td>

                            <!-- Tanggal tenggat -->
                            <td class="px-6 py-4 text-slate-600 hidden md:table-cell">
                                <?= date('d M Y', strtotime($t['tanggal_kembali'])) ?>
                            </td>

                            <!-- Status transaksi -->
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                <?= $t['status'] === 'dipinjam' 
                                    ? 'bg-amber-100 text-amber-700' 
                                    : 'bg-emerald-100 text-emerald-700' ?>">

                                    <?= ucfirst($t['status']) ?>
                                </span>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <!-- Jika belum ada transaksi -->
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">

                            <!-- Icon kosong -->
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-400"></i>
                            </div>

                            <!-- Pesan tidak ada transaksi -->
                            <p class="text-slate-500 font-medium">Belum ada transaksi</p>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php
// Memanggil layout footer (biasanya berisi script JS dan penutup HTML)
require_once __DIR__ . '/../layouts/footer.php';
?>