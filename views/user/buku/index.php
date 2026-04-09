<?php
// Menentukan judul halaman yang akan ditampilkan pada layout/header
$pageTitle = 'Cari Buku';

// Memanggil file header layout (biasanya berisi navbar, sidebar, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- ===================== SEARCH SECTION ===================== -->
<!-- Bagian ini berfungsi untuk menampilkan form pencarian buku -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6 animate-slide">

    <!-- Form pencarian menggunakan method GET agar keyword tampil di URL -->
    <form action="<?= BASE_URL ?>/user/buku" method="GET" class="flex flex-col sm:flex-row gap-4">

        <!-- Input pencarian -->
        <div class="flex-1 relative">

            <!-- Icon search dari FontAwesome -->
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <!-- 
                Input teks untuk memasukkan kata kunci pencarian 
                htmlspecialchars digunakan untuk mencegah XSS (serangan script berbahaya)
            -->
            <input type="text" name="q" placeholder="Cari judul buku, pengarang, atau penerbit..." 
                   value="<?= htmlspecialchars($keyword ?? '') ?>"
                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all text-slate-700">
        </div>

        <!-- Tombol submit pencarian -->
        <button type="submit" class="btn px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
            <i class="fas fa-search"></i>
            <span class="sm:inline hidden">Cari</span>
        </button>
    </form>
</div>

<?php if (!empty($keyword)): ?>
    <!-- 
        Bagian ini menampilkan keyword pencarian jika user memasukkan kata kunci 
        Berguna untuk memberi tahu hasil pencarian berdasarkan apa
    -->
    <div class="mb-6 flex items-center gap-2 text-slate-600">
        <span>Hasil untuk:</span>

        <!-- Menampilkan keyword -->
        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-medium">
            <?= htmlspecialchars($keyword) ?>
        </span>

        <!-- Tombol untuk menghapus filter pencarian -->
        <a href="<?= BASE_URL ?>/user/buku" class="ml-2 text-slate-400 hover:text-slate-600">
            <i class="fas fa-times"></i>
        </a>
    </div>
<?php endif; ?>

<!-- ===================== BOOKS GRID ===================== -->

<?php if (!empty($bukus)): ?>
    <!-- 
        Jika data buku tersedia, maka buku ditampilkan dalam bentuk grid
        Responsive layout menggunakan Tailwind CSS
    -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- Perulangan data buku -->
        <?php foreach ($bukus as $index => $b): ?>

            <!-- Card tampilan buku -->
            <div class="card bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-slide"
                 style="animation-delay: <?= $index * 0.05 ?>s;">

                <div class="p-6">

                    <!-- Judul buku + stok -->
                    <div class="flex justify-between items-start gap-3 mb-4">

                        <!-- Judul buku -->
                        <h3 class="text-lg font-bold text-slate-800 leading-tight line-clamp-2">
                            <?= htmlspecialchars($b['judul']) ?>
                        </h3>

                        <!-- Badge stok buku -->
                        <span class="shrink-0 px-2.5 py-1 rounded-lg text-xs font-bold 
                            <?= $b['stok'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">

                            <?= $b['stok'] ?> stok
                        </span>
                    </div>

                    <!-- Informasi detail buku -->
                    <div class="space-y-2.5 text-sm">

                        <!-- Informasi pengarang -->
                        <div class="flex items-center gap-3 text-slate-600">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 text-xs"></i>
                            </div>
                            <span class="truncate"><?= htmlspecialchars($b['pengarang']) ?></span>
                        </div>

                        <!-- Informasi penerbit -->
                        <div class="flex items-center gap-3 text-slate-600">
                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-slate-500 text-xs"></i>
                            </div>
                            <span class="truncate"><?= htmlspecialchars($b['penerbit'] ?? '-') ?></span>
                        </div>

                        <!-- Informasi kategori dan tahun terbit -->
                        <div class="flex items-center gap-3">

                            <!-- Icon kategori -->
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tag text-emerald-600 text-xs"></i>
                            </div>

                            <!-- Nama kategori -->
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded text-xs font-medium">
                                <?= htmlspecialchars($b['nama_kategori'] ?? 'Umum') ?>
                            </span>

                            <!-- Tahun terbit -->
                            <span class="text-slate-400 text-xs ml-auto">
                                <?= $b['tahun_terbit'] ?? '-' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ===================== ACTION BUTTON ===================== -->
                <div class="px-6 pb-6">

                    <?php if ($b['stok'] > 0): ?>
                        <!-- 
                            Jika stok buku tersedia
                            Tombol untuk meminjam buku akan muncul
                        -->
                        <a href="<?= BASE_URL ?>/user/peminjaman/pinjam?id_buku=<?= $b['id_buku'] ?>"
                           class="btn block text-center py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200">
                            <i class="fas fa-plus mr-2"></i>Pinjam Buku
                        </a>

                    <?php else: ?>
                        <!-- Jika stok habis -->
                        <div class="text-center py-3 bg-slate-100 text-slate-400 rounded-xl font-semibold cursor-not-allowed">
                            <i class="fas fa-times mr-2"></i>Stok Habis
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <!-- 
        Jika tidak ada buku ditemukan 
        Maka tampilkan pesan kosong
    -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">

        <!-- Icon buku -->
        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-book-open text-3xl text-slate-400"></i>
        </div>

        <!-- Pesan tidak ada data -->
        <h3 class="text-lg font-semibold text-slate-700 mb-2">
            Tidak Ada Buku Ditemukan
        </h3>

        <p class="text-slate-500">
            Coba gunakan kata kunci lain untuk pencarian
        </p>
    </div>

<?php endif; ?>

<?php
// Memanggil layout footer (biasanya berisi script js atau penutup HTML)
require_once __DIR__ . '/../../layouts/footer.php';
?>