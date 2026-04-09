    </main>
    <!-- Penutup tag <main> yang biasanya berisi konten utama halaman -->

</div>
<!-- Penutup container utama layout halaman -->

<script>
/* Script JavaScript untuk mengatur interaksi UI */

// Auto hide alerts with fade animation
// Berfungsi untuk menyembunyikan notifikasi alert secara otomatis
document.addEventListener('DOMContentLoaded', function() {
    // Event ini memastikan script berjalan setelah seluruh halaman selesai dimuat
    
    setTimeout(function() {
        // setTimeout digunakan untuk memberikan jeda waktu sebelum alert disembunyikan
        // 4000 milidetik = 4 detik
        
        document.querySelectorAll('[class*="alert"]').forEach(function(alert) {
            // Mencari semua elemen yang memiliki class yang mengandung kata "alert"
            // Biasanya digunakan untuk notifikasi sukses, error, warning, dll
            
            alert.style.transition = 'all 0.5s ease';
            // Menambahkan animasi transisi selama 0.5 detik
            
            alert.style.opacity = '0';
            // Membuat elemen menjadi transparan
            
            alert.style.transform = 'translateY(-20px)';
            // Menggeser elemen sedikit ke atas saat menghilang
            
            setTimeout(() => alert.remove(), 500);
            // Menghapus elemen dari DOM setelah animasi selesai (0.5 detik)
        });
    }, 4000);
    
    // Add stagger animation to cards
    // Memberikan efek animasi berurutan pada elemen card
    document.querySelectorAll('.card-hover').forEach((card, index) => {
        // Mengambil semua elemen dengan class "card-hover"
        
        card.style.animationDelay = `${index * 0.1}s`;
        // Memberikan delay animasi berbeda untuk setiap card
        // Card pertama 0s, kedua 0.1s, ketiga 0.2s, dst
    });
});

// Close sidebar on mobile when clicking outside
// Berfungsi menutup sidebar secara otomatis jika pengguna klik di luar sidebar
document.addEventListener('click', function(e) {

    const sidebar = document.querySelector('.sidebar');
    // Mengambil elemen sidebar
    
    const menuBtn = document.querySelector('[onclick*="sidebar"]');
    // Mengambil tombol menu yang biasanya digunakan untuk membuka sidebar
    
    if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
        // Mengecek kondisi:
        // 1. Hanya berjalan pada tampilan mobile (lebar layar < 1024px)
        // 2. Klik tidak terjadi di dalam sidebar
        // 3. Klik tidak terjadi pada tombol menu
        
        sidebar.classList.remove('active');
        // Menghapus class "active" untuk menutup sidebar
    }
});
</script>

</body>
</html>
