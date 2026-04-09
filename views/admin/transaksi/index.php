<?php
// Variabel judul halaman
$pageTitle = 'Transaksi Peminjaman';

// Memanggil layout header (biasanya berisi navbar, css, dan pembuka HTML)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- ================= HEADER SECTION ================= -->
<!-- Bagian ini menampilkan judul halaman dan tombol tambah transaksi -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6 animate-slide">
    
    <!-- Flexbox untuk mengatur posisi judul dan tombol -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        
        <!-- Bagian kiri berisi icon dan judul -->
        <div class="flex items-center gap-3">
            
            <!-- Icon transaksi -->
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-exchange-alt text-xl text-indigo-600"></i>
            </div>

            <!-- Judul dan jumlah transaksi -->
            <div>
                <h3 class="text-lg font-bold text-slate-800">Transaksi Peminjaman</h3>
                
                <!-- Menampilkan jumlah transaksi -->
                <!-- Operator ?? digunakan untuk menghindari error jika variabel kosong -->
                <p class="text-sm text-slate-500">
                    <?= count($transaksis ?? []) ?> transaksi tercatat
                </p>
            </div>
        </div>

        <!-- Tombol untuk menuju halaman tambah transaksi -->
        <a href="<?= BASE_URL ?>/admin/transaksi/create" 
           class="btn px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
</div>

<!-- ================= DATA TABLE ================= -->
<!-- Bagian tabel untuk menampilkan data transaksi -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.1s;">
    
    <!-- Agar tabel bisa discroll secara horizontal di layar kecil -->
    <div class="overflow-x-auto">
        <table class="w-full">

            <!-- ================= HEADER TABEL ================= -->
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Anggota</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Buku</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Tgl Pinjam</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Tenggat</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Denda</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <!-- ================= ISI DATA ================= -->
            <tbody class="divide-y divide-slate-100">

                <!-- Mengecek apakah ada data transaksi -->
                <?php if (!empty($transaksis)): ?>

                    <!-- Nomor urut -->
                    <?php $no = 1; foreach ($transaksis as $t): ?>

                        <tr class="table-row transition-colors">
                            
                            <!-- Nomor urut -->
                            <td class="px-4 py-4 text-slate-500 font-medium"><?= $no++ ?></td>

                            <!-- Nama anggota -->
                            <td class="px-4 py-4">
                                <!-- htmlspecialchars digunakan untuk mencegah XSS -->
                                <p class="font-semibold text-slate-800">
                                    <?= htmlspecialchars($t['nama_lengkap']) ?>
                                </p>
                            </td>

                            <!-- Judul buku -->
                            <td class="px-4 py-4 text-slate-600 max-w-[180px] truncate">
                                <?= htmlspecialchars($t['judul']) ?>
                            </td>

                            <!-- Tanggal pinjam -->
                            <!-- Hanya tampil pada layar medium ke atas -->
                            <td class="px-4 py-4 text-slate-600 hidden md:table-cell">
                                <?= date('d M Y', strtotime($t['tanggal_pinjam'])) ?>
                            </td>

                            <!-- Tanggal tenggat pengembalian -->
                            <td class="px-4 py-4 text-slate-600 hidden md:table-cell">
                                <?= date('d M Y', strtotime($t['tanggal_kembali'])) ?>
                            </td>

                            <!-- Menampilkan denda -->
                            <td class="px-4 py-4">
                                <?= $t['denda'] > 0 
                                    ? '<span class="text-red-600 font-bold">Rp ' . number_format($t['denda'], 0, ',', '.') . '</span>' 
                                    : '<span class="text-slate-400">-</span>' ?>
                            </td>

                            <!-- Status transaksi -->
                            <td class="px-4 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                <?= $t['status'] === 'dipinjam' 
                                    ? 'bg-amber-100 text-amber-700' 
                                    : 'bg-emerald-100 text-emerald-700' ?>">
                                    
                                    <!-- ucfirst untuk membuat huruf pertama kapital -->
                                    <?= ucfirst($t['status']) ?>
                                </span>
                            </td>

                            <!-- Tombol aksi -->
                            <td class="px-4 py-4">
                                <div class="flex gap-2">

                                    <!-- Tombol kembalikan buku -->
                                    <!-- Hanya muncul jika status masih dipinjam -->
                                    <?php if ($t['status'] === 'dipinjam'): ?>
                                        <a href="<?= BASE_URL ?>/admin/transaksi/kembalikan/<?= $t['id_peminjaman'] ?>" 
                                           onclick="return confirm('Kembalikan buku ini?')" 
                                           class="btn p-2.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol hapus transaksi -->
                                    <a href="<?= BASE_URL ?>/admin/transaksi/delete/<?= $t['id_peminjaman'] ?>" 
                                       onclick="return confirm('Hapus transaksi ini?')" 
                                       class="btn p-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </div>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <!-- Jika data kosong -->
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            
                            <!-- Icon kosong -->
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exchange-alt text-2xl text-slate-400"></i>
                            </div>

                            <!-- Pesan tidak ada data -->
                            <p class="text-slate-500 font-medium">Tidak ada transaksi</p>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php
// Memanggil layout footer (biasanya berisi script JS dan penutup HTML)
require_once __DIR__ . '/../../layouts/footer.php';
?>