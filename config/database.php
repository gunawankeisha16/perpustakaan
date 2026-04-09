<?php
// Konfigurasi koneksi database

// Menentukan alamat server database. "localhost" berarti database berjalan di komputer/server yang sama dengan aplikasi.
define('DB_HOST', 'localhost');
// Menentukan nama database yang akan digunakan, yaitu "db_perpus".  
define('DB_NAME', 'db_perpus');
// Username untuk mengakses database. Default XAMPP biasanya menggunakan "root".
define('DB_USER', 'root');
//  Password database. Kosong karena default XAMPP biasanya tidak memakai password.
define('DB_PASS', '');
// Menentukan karakter encoding database agar mendukung berbagai karakter termasuk emoji dan simbol internasional.
define('DB_CHARSET', 'utf8mb4');  