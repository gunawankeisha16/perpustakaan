<?php
// Menentukan judul halaman
$pageTitle = 'Tambah Anggota';

// Memanggil file header layout (biasanya berisi navbar, CSS, meta, dll)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Container utama dengan lebar maksimal 2xl dan animasi slide -->
<div class="max-w-2xl animate-slide">

    <!-- Card tampilan form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <!-- Bagian header card -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-slate-50">

            <!-- Judul form -->
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

                <!-- Icon user tambah -->
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-emerald-600"></i>
                </div>

                Tambah Anggota Baru
            </h3>
        </div>

        <!-- Form input data anggota -->
        <form action="<?= BASE_URL ?>/admin/anggota/store" method="POST" class="p-6 space-y-5">
            <!-- 
                action = alamat tujuan saat form dikirim
                BASE_URL = konstanta alamat dasar website
                Method POST digunakan untuk mengirim data ke server
            -->

            <!-- Input Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>

                <!-- required artinya wajib diisi -->
                <input type="text" name="nama_lengkap" required 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Grid untuk Username dan Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Input Username -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="username" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>

                    <input type="password" name="password" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>
            </div>

            <!-- Input Alamat -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Alamat
                </label>

                <!-- Tidak wajib diisi -->
                <input type="text" name="alamat" 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Input Nomor Telepon -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    No. Telepon
                </label>

                <!-- Tidak wajib diisi -->
                <input type="text" name="no_telp" 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 pt-4">

                <!-- Tombol Submit -->
                <button type="submit" 
                class="btn flex-1 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">

                    <i class="fas fa-save"></i> Simpan
                </button>

                <!-- Tombol Batal (kembali ke halaman anggota) -->
                <a href="<?= BASE_URL ?>/admin/anggota" 
                class="btn px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold flex items-center gap-2">

                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php
// Memanggil file footer layout
require_once __DIR__ . '/../../layouts/footer.php';
?>