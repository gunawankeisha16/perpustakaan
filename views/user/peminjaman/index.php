<?php
// Menentukan judul halaman yang akan ditampilkan pada layout header
$pageTitle = 'Peminjaman Saya';

// Memanggil file header layout (biasanya berisi navbar, sidebar, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- ===================== QUICK ACTION ===================== -->
<!-- Tombol cepat untuk menuju halaman peminjaman buku baru -->
<div class="mb-6 animate-slide">

    <!-- Tombol menuju halaman pinjam buku -->
    <a href="<?= BASE_URL ?>/user/peminjaman/pinjam" 
       class="btn inline-flex px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold items-center gap-2 shadow-lg shadow-emerald-200">
        
        <!-- Icon tambah -->
        <i class="fas fa-plus"></i> Pinjam Buku Baru
    </a>
</div>

<!-- ===================== BORROWING HISTORY TABLE ===================== -->
<!-- Card utama untuk menampilkan riwayat peminjaman -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.1s;">

    <!-- Header tabel -->
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

            <!-- Icon riwayat -->
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-history text-indigo-600"></i>
            </div>

            Riwayat Peminjaman
        </h3>
    </div>

    <!-- Wrapper agar tabel bisa discroll horizontal di layar kecil -->
    <div class="overflow-x-auto">
        <table class="w-full">

            <!-- ===================== HEADER TABEL ===================== -->
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Buku</th>

                    <!-- Kolom ini hanya tampil pada layar medium ke atas -->
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">
                        Tgl Pinjam
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tenggat</th>

                    <!-- Kolom hanya tampil pada layar besar -->
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">
                        Dikembalikan
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <!-- ===================== BODY TABEL ===================== -->
            <tbody class="divide-y divide-slate-100">

                <?php if (!empty($peminjamans)): ?>
                    <!-- Jika ada data peminjaman -->

                    <?php foreach ($peminjamans as $p): ?>
                        <!-- Perulangan setiap data peminjaman -->
                        <tr class="table-row transition-colors">

                            <!-- Judul buku -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    <?= htmlspecialchars($p['judul']) ?>
                                </p>
                            </td>

                            <!-- Tanggal pinjam -->
                            <td class="px-6 py-4 text-slate-600 hidden md:table-cell">
                                <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                            </td>

                            <!-- Tenggat pengembalian -->
                            <td class="px-6 py-4 text-slate-600">
                                <?= date('d M Y', strtotime($p['tanggal_kembali'])) ?>
                            </td>

                            <!-- Tanggal dikembalikan -->
                            <td class="px-6 py-4 text-slate-600 hidden lg:table-cell">
                                
                                <!-- Jika sudah dikembalikan tampilkan tanggal -->
                                <?= $p['tanggal_dikembalikan'] 
                                    ? date('d M Y', strtotime($p['tanggal_dikembalikan'])) 
                                    : '-' ?>
                            </td>

                            <!-- ===================== DENDA ===================== -->
                            <td class="px-6 py-4">
                                
                                <!-- Jika ada denda tampilkan nominal -->
                                <?= $p['denda'] > 0 
                                    ? '<span class="text-red-600 font-bold">Rp ' . number_format($p['denda'], 0, ',', '.') . '</span>' 
                                    : '<span class="text-slate-400">-</span>' ?>
                            </td>

                            <!-- ===================== STATUS ===================== -->
                            <td class="px-6 py-4">

                                <!-- Badge status peminjaman -->
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                    <?= $p['status'] === 'dipinjam' 
                                        ? 'bg-amber-100 text-amber-700' 
                                        : 'bg-emerald-100 text-emerald-700' ?>">

                                    <?= $p['status'] === 'dipinjam' 
                                        ? 'Dipinjam' 
                                        : 'Dikembalikan' ?>
                                </span>
                            </td>

                            <!-- ===================== AKSI ===================== -->
                            <td class="px-6 py-4">

                                <?php if ($p['status'] === 'dipinjam'): ?>
                                    
                                    <!-- Tombol pengembalian buku -->
                                    <a href="<?= BASE_URL ?>/user/peminjaman/kembalikan/<?= $p['id_peminjaman'] ?>" 
                                       onclick="return confirm('Kembalikan buku ini?')" 
                                       class="btn inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium">
                                        
                                        <i class="fas fa-undo"></i> Kembalikan
                                    </a>

                                <?php else: ?>

                                    <!-- Jika sudah dikembalikan -->
                                    <span class="inline-flex items-center gap-1.5 text-emerald-500">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>

                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <!-- ===================== DATA KOSONG ===================== -->
                    <!-- Jika belum ada riwayat peminjaman -->
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">

                            <!-- Icon kosong -->
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-400"></i>
                            </div>

                            <p class="text-slate-500 font-medium">
                                Belum ada riwayat peminjaman
                            </p>

                            <!-- Link menuju halaman pencarian buku -->
                            <a href="<?= BASE_URL ?>/user/buku" 
                               class="text-indigo-600 hover:text-indigo-700 text-sm mt-2 inline-block">
                                Cari buku untuk dipinjam
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php
// Memanggil file footer layout (biasanya berisi penutup HTML dan script JS)
require_once __DIR__ . '/../../layouts/footer.php';
?>