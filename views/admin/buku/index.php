<?php
// Menentukan judul halaman
$pageTitle = 'Data Buku';

// Memanggil layout header (biasanya berisi navbar, css, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Header Section -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6 animate-slide">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        
        <!-- Bagian kiri header -->
        <div class="flex items-center gap-3">
            
            <!-- Icon buku -->
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-book text-xl text-indigo-600"></i>
            </div>

            <!-- Judul dan jumlah buku -->
            <div>
                <h3 class="text-lg font-bold text-slate-800">Kelola Data Buku</h3>

                <!-- Menampilkan jumlah buku -->
                <!-- Operator ?? digunakan untuk menghindari error jika variabel kosong -->
                <p class="text-sm text-slate-500"><?= count($bukus ?? []) ?> buku tersedia</p>
            </div>
        </div>

        <!-- Bagian kanan header -->
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

            <!-- Form pencarian buku -->
            <form action="<?= BASE_URL ?>/admin/buku/search" method="GET" class="flex gap-2">

                <!-- Input pencarian -->
                <div class="relative flex-1">
                    
                    <!-- Icon search -->
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <!-- Input keyword pencarian -->
                    <!-- htmlspecialchars digunakan untuk mencegah XSS -->
                    <input type="text" 
                           name="q" 
                           placeholder="Cari buku..." 
                           value="<?= htmlspecialchars($keyword ?? '') ?>"
                           class="w-full sm:w-48 pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 outline-none transition-all">
                </div>

                <!-- Tombol submit pencarian -->
                <button type="submit" class="btn px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Tombol menuju halaman tambah buku -->
            <a href="<?= BASE_URL ?>/admin/buku/create" 
               class="btn px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                
                <i class="fas fa-plus"></i> Tambah Buku
            </a>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide" style="animation-delay: 0.1s;">
    <div class="overflow-x-auto">

        <!-- Tabel daftar buku -->
        <table class="w-full">
            
            <!-- Header tabel -->
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Pengarang</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <!-- Isi tabel -->
            <tbody class="divide-y divide-slate-100">

                <!-- Jika data buku ada -->
                <?php if (!empty($bukus)): ?>

                    <!-- Variabel nomor urut -->
                    <?php $no = 1; foreach ($bukus as $b): ?>

                        <tr class="table-row transition-colors">

                            <!-- Nomor urut -->
                            <td class="px-6 py-4 text-slate-500 font-medium"><?= $no++ ?></td>

                            <!-- Judul buku -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    <?= htmlspecialchars($b['judul']) ?>
                                </p>

                                <!-- Pengarang tampil di mobile -->
                                <p class="text-sm text-slate-500 md:hidden">
                                    <?= htmlspecialchars($b['pengarang']) ?>
                                </p>
                            </td>

                            <!-- Pengarang tampil di desktop -->
                            <td class="px-6 py-4 text-slate-600 hidden md:table-cell">
                                <?= htmlspecialchars($b['pengarang']) ?>
                            </td>

                            <!-- Kategori buku -->
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-medium">
                                    
                                    <!-- Jika kategori tidak ada maka tampil '-' -->
                                    <?= htmlspecialchars($b['nama_kategori'] ?? '-') ?>
                                </span>
                            </td>

                            <!-- Stok buku -->
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold 
                                    
                                    <!-- Jika stok lebih dari 0 maka hijau, jika tidak merah -->
                                    <?= $b['stok'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
                                    
                                    <?= $b['stok'] ?>
                                </span>
                            </td>

                            <!-- Tombol aksi -->
                            <td class="px-6 py-4">
                                <div class="flex gap-2">

                                    <!-- Tombol edit -->
                                    <a href="<?= BASE_URL ?>/admin/buku/edit/<?= $b['id_buku'] ?>" 
                                       class="btn p-2.5 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol hapus -->
                                    <!-- confirm() untuk memastikan user yakin menghapus -->
                                    <a href="<?= BASE_URL ?>/admin/buku/delete/<?= $b['id_buku'] ?>" 
                                       onclick="return confirm('Hapus buku ini?')" 
                                       class="btn p-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <!-- Jika data buku kosong -->
                <?php else: ?>

                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            
                            <!-- Icon kondisi kosong -->
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book-open text-2xl text-slate-400"></i>
                            </div>

                            <!-- Pesan tidak ada data -->
                            <p class="text-slate-500 font-medium">Tidak ada data buku</p>
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Memanggil layout footer
require_once __DIR__ . '/../../layouts/footer.php';
?>