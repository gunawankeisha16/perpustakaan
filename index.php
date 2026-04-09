<?php
// =====================================================
// INDEX.PHP - Entry Point & Router
// Sistem Perpustakaan
// =====================================================

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

// Define BASE_URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $protocol . '://' . $host . ($scriptName === '\\' || $scriptName === '/' ? '' : $scriptName);
define('BASE_URL', $baseUrl);

// Load core files
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Router.php';

// Load controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/BukuController.php';
require_once __DIR__ . '/controllers/AnggotaController.php';
require_once __DIR__ . '/controllers/TransaksiController.php';
require_once __DIR__ . '/controllers/PeminjamanController.php';

// Initialize router
$router = new Router();

// --- Auth Routes ---
$router->get('/', [AuthController::class, 'loginForm']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'index']);

// --- Admin: Buku ---
$router->get('/admin/buku', [BukuController::class, 'index']);
$router->get('/admin/buku/create', [BukuController::class, 'create']);
$router->post('/admin/buku/store', [BukuController::class, 'store']);
$router->get('/admin/buku/edit/{id}', [BukuController::class, 'edit']);
$router->post('/admin/buku/update/{id}', [BukuController::class, 'update']);
$router->get('/admin/buku/delete/{id}', [BukuController::class, 'delete']);
$router->get('/admin/buku/search', [BukuController::class, 'search']);

// --- Admin: Anggota ---
$router->get('/admin/anggota', [AnggotaController::class, 'index']);
$router->get('/admin/anggota/create', [AnggotaController::class, 'create']);
$router->post('/admin/anggota/store', [AnggotaController::class, 'store']);
$router->get('/admin/anggota/edit/{id}', [AnggotaController::class, 'edit']);
$router->post('/admin/anggota/update/{id}', [AnggotaController::class, 'update']);
$router->get('/admin/anggota/delete/{id}', [AnggotaController::class, 'delete']);

// --- Admin: Transaksi ---
$router->get('/admin/transaksi', [TransaksiController::class, 'index']);
$router->get('/admin/transaksi/create', [TransaksiController::class, 'create']);
$router->post('/admin/transaksi/store', [TransaksiController::class, 'store']);
$router->get('/admin/transaksi/kembalikan/{id}', [TransaksiController::class, 'kembalikan']);
$router->get('/admin/transaksi/delete/{id}', [TransaksiController::class, 'delete']);

// --- User: Peminjaman ---
$router->get('/user/peminjaman', [PeminjamanController::class, 'index']);
$router->get('/user/peminjaman/pinjam', [PeminjamanController::class, 'pinjam']);
$router->post('/user/peminjaman/pinjam', [PeminjamanController::class, 'storePinjam']);
$router->get('/user/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan']);
$router->get('/user/buku', [PeminjamanController::class, 'cariBuku']);

// Run router
$router->run();