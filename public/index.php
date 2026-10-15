<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/functions.php';

init_session();
check_auth(); // Pastikan user sudah login

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-['Plus_Jakarta_Sans'] text-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-400">InventorySystem</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">Halo, <b><?= e($user['username']) ?></b> (<?= e($user['role']) ?>)</span>
            <a href="logout.php" class="bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-sm transition">Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto p-6 mt-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard</h2>
            <p class="text-slate-400 text-sm mb-6">Sistem Manajemen Inventaris Barang Gudang</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl">
                    <p class="text-slate-400 text-sm">Total Produk</p>
                    <h3 class="text-3xl font-bold text-indigo-400 mt-1">0</h3>
                </div>
                <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl">
                    <p class="text-slate-400 text-sm">Kategori Barang</p>
                    <h3 class="text-3xl font-bold text-emerald-400 mt-1">4</h3>
                </div>
                <div class="bg-slate-900 border border-slate-700 p-5 rounded-xl">
                    <p class="text-slate-400 text-sm">Status Sistem</p>
                    <h3 class="text-lg font-bold text-green-400 mt-2">Aktif / Berjalan</h3>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
