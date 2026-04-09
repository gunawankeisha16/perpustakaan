<?php
// Variabel untuk menyimpan judul halaman
$pageTitle = 'Tambah Buku';

// Memanggil file header layout (biasanya berisi navbar, css, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Container utama dengan lebar maksimal dan animasi slide -->
<div class="max-w-2xl animate-slide">
    
    <!-- Card tampilan form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Bagian header card -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-slate-50">
            
            <!-- Judul form -->
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                
                <!-- Icon tambah -->
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus text-emerald-600"></i>
                </div>
                
                Tambah Buku Baru
            </h3>
        </div>

        <!-- Form untuk mengirim data buku baru -->
        <!-- Data dikirim ke route /admin/buku/store menggunakan method POST -->
        <form action="<?= BASE_URL ?>/admin/buku/store" method="POST" class="p-6 space-y-5">
            
            <!-- Input Judul Buku -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Judul Buku <span class="text-red-500">*</span>
                </label>
                
                <!-- Input wajib diisi -->
                <input type="text" name="judul" required 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Input Pengarang -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pengarang <span class="text-red-500">*</span>
                </label>

                <!-- Input wajib diisi -->
                <input type="text" name="pengarang" required 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Grid untuk Penerbit dan Tahun Terbit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Input Penerbit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit</label>
                    
                    <!-- Input opsional -->
                    <input type="text" name="penerbit" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <!-- Input Tahun Terbit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit</label>
                    
                    <!-- Input angka dengan batas minimum 1900 dan maksimum tahun sekarang -->
                    <input type="number" name="tahun_terbit" min="1900" max="<?= date('Y') ?>" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <!-- Grid untuk Kategori dan Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Dropdown Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    
                    <select name="id_kategori" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                        
                        <!-- Default pilihan kosong -->
                        <option value="">-- Pilih Kategori --</option>
                        
                        <!-- Looping data kategori dari controller -->
                        <?php foreach ($kategoris as $k): ?>
                            
                            <!-- Menampilkan id kategori sebagai value -->
                            <!-- htmlspecialchars digunakan untuk mencegah XSS -->
                            <option value="<?= $k['id_kategori'] ?>">
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Input Stok Buku -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>
                    
                    <!-- Default stok = 1 dan tidak boleh kurang dari 0 -->
                    <input type="number" name="stok" value="1" min="0" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-3 pt-4">
                
                <!-- Tombol simpan data -->
                <button type="submit" 
                class="btn flex-1 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <!-- Tombol batal kembali ke halaman daftar buku -->
                <a href="<?= BASE_URL ?>/admin/buku" 
                class="btn px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

<?php 
// Memanggil file footer layout (biasanya berisi penutup HTML, script JS, dll)
require_once __DIR__ . '/../../layouts/footer.php'; 
?>