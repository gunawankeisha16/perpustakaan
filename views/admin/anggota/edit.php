<?php
// Menentukan judul halaman
$pageTitle = 'Edit Anggota';

// Memanggil file header layout (biasanya berisi navbar, CSS, dan konfigurasi awal)
require_once __DIR__ . '/../../layouts/header.php';
?>

<!-- Container utama halaman -->
<div class="max-w-2xl animate-slide">

    <!-- Card utama form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <!-- Header card -->
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50">

            <!-- Judul halaman -->
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-3">

                <!-- Icon edit anggota -->
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-edit text-amber-600"></i>
                </div>

                Edit Anggota
            </h3>
        </div>

        <!-- Form edit data anggota -->
        <form action="<?= BASE_URL ?>/admin/anggota/update/<?= $anggota['id_user'] ?>" 
              method="POST" 
              class="p-6 space-y-5">
            <!--
                action mengarah ke controller update anggota
                id_user dikirim melalui URL
                method POST digunakan untuk mengirim data secara aman
            -->

            <!-- Input Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>

                <!-- 
                    value diisi data lama dari database
                    htmlspecialchars() digunakan untuk mencegah XSS
                -->
                <input type="text" 
                       name="nama_lengkap" 
                       value="<?= htmlspecialchars($anggota['nama_lengkap']) ?>" 
                       required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Input Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Password 
                    <span class="text-slate-400 font-normal">(kosongkan jika tidak diubah)</span>
                </label>

                <!-- 
                    Password tidak diisi otomatis demi keamanan
                    Jika kosong, controller biasanya tidak mengubah password
                -->
                <input type="password" 
                       name="password" 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Input Alamat -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Alamat
                </label>

                <!-- 
                    Operator ?? digunakan jika alamat bernilai null
                -->
                <input type="text" 
                       name="alamat" 
                       value="<?= htmlspecialchars($anggota['alamat'] ?? '') ?>" 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <!-- Grid No Telepon dan Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Input No Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        No. Telepon
                    </label>

                    <input type="text" 
                           name="no_telp" 
                           value="<?= htmlspecialchars($anggota['no_telp'] ?? '') ?>" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                </div>

                <!-- Select Status Aktif -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status
                    </label>

                    <select name="status_aktif" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">

                        <!-- Opsi Aktif -->
                        <option value="aktif" 
                            <?= $anggota['status_aktif'] === 'aktif' ? 'selected' : '' ?>>
                            Aktif
                        </option>

                        <!-- Opsi Nonaktif -->
                        <option value="nonaktif" 
                            <?= $anggota['status_aktif'] === 'nonaktif' ? 'selected' : '' ?>>
                            Non-Aktif
                        </option>
                    </select>
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-3 pt-4">

                <!-- Tombol Update -->
                <button type="submit" 
                        class="btn flex-1 py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-semibold shadow-lg shadow-amber-200 flex items-center justify-center gap-2">

                    <i class="fas fa-save"></i> Update
                </button>

                <!-- Tombol Batal -->
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