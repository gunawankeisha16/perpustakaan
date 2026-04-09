<?php
// Menentukan judul halaman
$pageTitle = 'Kelola Anggota';

// Memanggil file header layout (biasanya berisi navbar, CSS, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Header Section -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6 animate-slide">

    <!-- Bagian header berisi judul dan tombol tambah anggota -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

        <!-- Informasi Judul -->
        <div class="flex items-center gap-3">

            <!-- Icon anggota -->
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-xl text-emerald-600"></i>
            </div>

            <!-- Judul dan jumlah anggota -->
            <div>
                <h3 class="text-lg font-bold text-slate-800">Kelola Anggota</h3>

                <!-- Menghitung jumlah data anggota -->
                <p class="text-sm text-slate-500">
                    <?= count($anggota ?? []) ?> anggota terdaftar
                </p>
            </div>
        </div>

        <!-- Tombol tambah anggota -->
        <a href="<?= BASE_URL ?>/admin/anggota/create" 
        class="btn px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center gap-2">

            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.1s;">

    <!-- Membuat tabel bisa discroll secara horizontal -->
    <div class="overflow-x-auto">
        <table class="w-full">

            <!-- Header tabel -->
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Anggota</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Username</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">No. Telp</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <!-- Isi tabel -->
            <tbody class="divide-y divide-slate-100">

                <!-- Mengecek apakah data anggota ada -->
                <?php if (!empty($anggota)): ?>

                    <!-- Looping data anggota -->
                    <?php foreach ($anggota as $a): ?>

                        <tr class="table-row transition-colors">

                            <!-- Kolom informasi anggota -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <!-- Avatar huruf pertama nama -->
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                        <?= strtoupper(substr($a['nama_lengkap'], 0, 1)) ?>
                                    </div>

                                    <div>
                                        <!-- Menampilkan nama anggota -->
                                        <p class="font-semibold text-slate-800">
                                            <?= htmlspecialchars($a['nama_lengkap']) ?>
                                        </p>

                                        <!-- Username ditampilkan di layar kecil -->
                                        <p class="text-sm text-slate-500 md:hidden">
                                            <?= htmlspecialchars($a['username']) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom username (disembunyikan di layar kecil) -->
                            <td class="px-6 py-4 text-slate-600 hidden md:table-cell">
                                <?= htmlspecialchars($a['username']) ?>
                            </td>

                            <!-- Kolom nomor telepon -->
                            <td class="px-6 py-4 text-slate-600 hidden lg:table-cell">
                                <?= htmlspecialchars($a['no_telp'] ?? '-') ?>
                            </td>

                            <!-- Kolom status anggota -->
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                    <?= $a['status_aktif'] === 'aktif' 
                                        ? 'bg-emerald-100 text-emerald-700' 
                                        : 'bg-red-100 text-red-700' ?>">

                                    <?= ucfirst($a['status_aktif']) ?>
                                </span>
                            </td>

                            <!-- Kolom aksi -->
                            <td class="px-6 py-4">
                                <div class="flex gap-2">

                                    <!-- Tombol edit -->
                                    <a href="<?= BASE_URL ?>/admin/anggota/edit/<?= $a['id_user'] ?>" 
                                    class="btn p-2.5 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol hapus -->
                                    <a href="<?= BASE_URL ?>/admin/anggota/delete/<?= $a['id_user'] ?>" 
                                    onclick="return confirm('Hapus anggota ini?')" 
                                    class="btn p-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <!-- Jika tidak ada data -->
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">

                            <!-- Icon tidak ada data -->
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-2xl text-slate-400"></i>
                            </div>

                            <p class="text-slate-500 font-medium">Tidak ada data anggota</p>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php
// Memanggil footer layout
require_once __DIR__ . '/../../layouts/footer.php';
?>