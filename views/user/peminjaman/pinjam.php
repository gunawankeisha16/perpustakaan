<?php
// Menentukan judul halaman
$pageTitle = 'Pinjam Buku';

// Memanggil layout header (biasanya berisi navbar, sidebar, dll)
require_once __DIR__ . '/../../layouts/header.php';

// Mengambil id buku yang dikirim melalui parameter GET (jika user memilih buku dari halaman lain)
$selectedBuku = $_GET['id_buku'] ?? '';
?>

<!-- Container utama form dengan batas lebar maksimum -->
<div class="max-w-2xl animate-slide">

    <!-- Card utama form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <!-- Header form -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

                <!-- Icon buku -->
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-indigo-600"></i>
                </div>

                Form Peminjaman Buku
            </h3>
        </div>

        <!-- Form peminjaman buku -->
        <form action="<?= BASE_URL ?>/user/peminjaman/pinjam" method="POST" class="p-6 space-y-6">

            <!-- ===================== PILIH BUKU ===================== -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pilih Buku
                </label>

                <!-- Dropdown daftar buku -->
                <select name="id_buku" required 
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                    <option value="">-- Pilih Buku yang Tersedia --</option>

                    <?php foreach ($bukus as $b): ?>
                        <!-- Perulangan daftar buku dari database -->
                        <option value="<?= $b['id_buku'] ?>" 
                            <?= $selectedBuku == $b['id_buku'] ? 'selected' : '' ?>>

                            <!-- Menampilkan judul, pengarang, dan stok buku -->
                            <?= htmlspecialchars($b['judul']) ?> — 
                            <?= htmlspecialchars($b['pengarang']) ?> 
                            (Stok: <?= $b['stok'] ?>)

                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- ===================== TANGGAL KEMBALI ===================== -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Pengembalian
                </label>

                <!-- Input tanggal pengembalian -->
                <input type="date" 
                       name="tanggal_kembali" 
                       required 
                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>" 
                       max="<?= date('Y-m-d', strtotime('+14 days')) ?>"
                       class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                <!-- Informasi aturan tanggal -->
                <p class="text-sm text-slate-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Maksimal 14 hari dari hari ini
                </p>
            </div>
            
            <!-- ===================== INFO PERATURAN ===================== -->
            <!-- Box informasi aturan peminjaman -->
            <div class="p-5 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">

                <div class="flex items-start gap-4">

                    <!-- Icon peringatan -->
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-600"></i>
                    </div>

                    <!-- Isi informasi -->
                    <div>
                        <h4 class="font-semibold text-amber-800 mb-1">
                            Perhatian
                        </h4>

                        <ul class="text-sm text-amber-700 space-y-1">
                            <li>• Durasi peminjaman maksimal 14 hari</li>
                            <li>• Denda keterlambatan: <strong>Rp 1.000/hari</strong></li>
                            <li>• Pastikan buku dikembalikan tepat waktu</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- ===================== TOMBOL AKSI ===================== -->
            <div class="flex gap-3 pt-2">

                <!-- Tombol submit form -->
                <button type="submit" 
                        class="btn flex-1 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">

                    <i class="fas fa-check"></i> Pinjam Sekarang
                </button>

                <!-- Tombol batal kembali ke halaman peminjaman -->
                <a href="<?= BASE_URL ?>/user/peminjaman" 
                   class="btn px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold flex items-center gap-2">

                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

<?php
// Memanggil layout footer (biasanya berisi script JS dan penutup HTML)
require_once __DIR__ . '/../../layouts/footer.php';
?>