<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/functions.php';

init_session();
check_auth();

// Ambil data produk beserta nama kategorinya dari database
$stmt = $pdo->query("
    SELECT p.*, c.name AS category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC
");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-['Plus_Jakarta_Sans'] text-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-6">
            <h1 class="text-xl font-bold text-indigo-400">InventorySystem</h1>
            <div class="flex gap-4 text-sm">
                <a href="index.php" class="text-slate-300 hover:text-white">Dashboard</a>
                <a href="products.php" class="text-indigo-400 font-semibold">Produk</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">Halo, <b><?= e($_SESSION['user']['username']) ?></b></span>
            <a href="logout.php" class="bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-sm transition">Logout</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-6xl mx-auto p-6 mt-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold">Manajemen Produk</h2>
                <p class="text-slate-400 text-sm">Daftar seluruh barang inventaris gudang</p>
            </div>
            <a href="add_product.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition">+ Tambah Produk</a>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="p-4">SKU</th>
                            <th class="p-4">Nama Produk</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4">Stok</th>
                            <th class="p-4">Status</th>
                            <th class="p4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700 text-sm">
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-400">Belum ada data produk di dalam database.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <tr class="hover:bg-slate-700/30 transition">
                                    <td class="p-4 font-mono text-indigo-300"><?= e($p['sku']) ?></td>
                                    <td class="p-4 font-medium text-white"><?= e($p['name']) ?></td>
                                    <td class="p-4 text-slate-300"><?= e($p['category_name']) ?></td>
                                    <td class="p-4">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                                    <td class="p-4 font-bold <?= $p['stock'] <= $p['minimum_stock'] ? 'text-red-400' : 'text-green-400' ?>">
                                        <?= e($p['stock']) ?>
                                    </td>
                                    <td class="p-4">
                                        <?php if ($p['stock'] <= $p['minimum_stock']): ?>
                                            <span class="bg-red-500/10 text-red-400 border border-red-500/30 px-2.5 py-1 rounded-full text-xs font-semibold">Stok Menipis</span>
                                        <?php else: ?>
                                            <span class="bg-green-500/10 text-green-400 border border-green-500/30 px-2.5 py-1 rounded-full text-xs font-semibold">Aman</span>
                                                    <?php endif; ?>
        </td> <!-- Ini adalah penutup kolom Status -->

        <!-- PASTE KODE TOMBOL AKSI DI BAWAH SINI -->
        <td class="p-4 text-right space-x-2">
            <a href="edit_product.php?id=<?= $p['id'] ?>" class="bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-white px-3 py-1 rounded text-xs transition font-semibold">Edit</a>
            <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white px-3 py-1 rounded text-xs transition font-semibold">Hapus</a>
        </td>
        <!-- BATAS PASTE -->

    </tr> <!-- Ini adalah penutup baris (sudah ada di kodemu) -->
<?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
