<?php
// Menentukan judul halaman
$pageTitle = 'Edit Buku';

// Memanggil layout header (biasanya berisi navbar, css, meta, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Container utama form -->
<div class="max-w-2xl animate-slide">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header tampilan form -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                
                <!-- Icon edit -->
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-edit text-amber-600"></i>
                </div>

                <!-- Judul halaman -->
                Edit Buku
            </h3>
        </div>

        <!-- Form untuk mengupdate data buku -->
        <!-- Action mengarah ke controller update dengan membawa id buku -->
        <form action="<?= BASE_URL ?>/admin/buku/update/<?= $buku['id_buku'] ?>" 
              method="POST" 
              class="p-6 space-y-5">

            <!-- Input Judul Buku -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Judul Buku <span class="text-red-500">*</span>
                </label>

                <!-- value diisi data buku lama -->
                <!-- htmlspecialchars digunakan untuk mencegah XSS -->
                <input type="text" 
                       name="judul" 
                       value="<?= htmlspecialchars($buku['judul']) ?>" 
                       required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Input Pengarang -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pengarang <span class="text-red-500">*</span>
                </label>

                <input type="text" 
                       name="pengarang" 
                       value="<?= htmlspecialchars($buku['pengarang']) ?>" 
                       required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Grid untuk Penerbit dan Tahun Terbit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Input Penerbit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit</label>

                    <!-- Operator ?? digunakan jika nilai kosong -->
                    <input type="text" 
                           name="penerbit" 
                           value="<?= htmlspecialchars($buku['penerbit'] ?? '') ?>"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <!-- Input Tahun Terbit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit</label>

                    <input type="number" 
                           name="tahun_terbit" 
                           value="<?= $buku['tahun_terbit'] ?? '' ?>"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <!-- Grid untuk Kategori dan Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Dropdown Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>

                    <select name="id_kategori" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                        focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                        <option value="">-- Pilih Kategori --</option>

                        <!-- Loop data kategori -->
                        <?php foreach ($kategoris as $k): ?>

                            <!-- selected digunakan untuk menandai kategori buku saat ini -->
                            <option value="<?= $k['id_kategori'] ?>" 
                                <?= $buku['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>

                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Input Stok Buku -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>

                    <!-- Menampilkan stok lama -->
                    <input type="number" 
                           name="stok" 
                           value="<?= $buku['stok'] ?>" 
                           min="0"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-3 pt-4">

                <!-- Tombol update data -->
                <button type="submit" 
                    class="btn flex-1 py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl 
                    font-semibold shadow-lg shadow-amber-200 flex items-center justify-center gap-2">

                    <i class="fas fa-save"></i> Update
                </button>

                <!-- Tombol batal kembali ke halaman daftar buku -->
                <a href="<?= BASE_URL ?>/admin/buku" 
                   class="btn px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 
                   rounded-xl font-semibold flex items-center gap-2">

                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php
// Memanggil layout footer
require_once __DIR__ . '/../../layouts/footer.php';
?>