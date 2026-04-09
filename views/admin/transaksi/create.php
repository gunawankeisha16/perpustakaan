<?php
// Menentukan judul halaman
$pageTitle = 'Tambah Transaksi';

// Memanggil file layout header (biasanya berisi navbar, css, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Container utama form -->
<div class="max-w-2xl animate-slide">

    <!-- Card form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <!-- Header Card -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

                <!-- Icon transaksi -->
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus text-indigo-600"></i>
                </div>

                Tambah Transaksi Peminjaman
            </h3>
        </div>

        <!-- Form tambah transaksi -->
        <!-- Action menuju controller transaksi dengan method POST -->
        <form action="<?= BASE_URL ?>/admin/transaksi/store" method="POST" class="p-6 space-y-5">

            <!-- Pilih Anggota -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pilih Anggota <span class="text-red-500">*</span>
                </label>

                <!-- Dropdown daftar anggota -->
                <select name="id_user" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                    <!-- Option default -->
                    <option value="">-- Pilih Anggota --</option>

                    <!-- Loop data anggota dari controller -->
                    <?php foreach ($anggota as $a): ?>

                        <!-- Value berisi id_user, tampilan berisi nama dan username -->
                        <option value="<?= $a['id_user'] ?>">
                            <?= htmlspecialchars($a['nama_lengkap']) ?> (<?= $a['username'] ?>)
                        </option>

                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pilih Buku -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pilih Buku <span class="text-red-500">*</span>
                </label>

                <!-- Dropdown daftar buku -->
                <select name="id_buku" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                    <option value="">-- Pilih Buku --</option>

                    <!-- Loop data buku -->
                    <?php foreach ($bukus as $b): ?>

                        <!-- Menampilkan judul buku dan stok -->
                        <option value="<?= $b['id_buku'] ?>">
                            <?= htmlspecialchars($b['judul']) ?> (Stok: <?= $b['stok'] ?>)
                        </option>

                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Input tanggal kembali -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Kembali <span class="text-red-500">*</span>
                </label>
                
            </div>

            <!-- Informasi denda -->
            <div class="p-4 bg-gradient-to-r from-indigo-50 to-slate-50 rounded-xl border border-indigo-100 flex items-center gap-3">

                <!-- Icon informasi -->
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                    <i class="fas fa-info-circle text-indigo-600"></i>
                </div>

                <!-- Keterangan aturan denda -->
                <span class="text-sm text-indigo-700">
                    Denda keterlambatan: <strong>Rp 1.000/hari</strong>
                </span>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-3 pt-4">

                <!-- Tombol submit -->
                <button type="submit"
                        class="btn flex-1 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">

                    <i class="fas fa-save"></i> Simpan
                </button>

                <!-- Tombol batal kembali ke halaman transaksi -->
                <a href="<?= BASE_URL ?>/admin/transaksi"
                   class="btn px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold flex items-center gap-2">

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