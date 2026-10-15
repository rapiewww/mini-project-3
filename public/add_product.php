<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/functions.php';

init_session();
check_auth();

$error = '';

// Ambil daftar kategori untuk dropdown pilihan form
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id   = trim($_POST['category_id'] ?? '');
    $sku           = trim($_POST['sku'] ?? '');
    $name          = trim($_POST['name'] ?? ''); // Perbaikan di sini (tambah tanda =)
    $price         = trim($_POST['price'] ?? '');
    $stock         = trim($_POST['stock'] ?? '');
    $minimum_stock = trim($_POST['minimum_stock'] ?? '5');

    if (empty($category_id) || empty($sku) || empty($name) || empty($price) || empty($stock)) {
        $error = 'Semua kolom wajib diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO products (category_id, sku, name, price, stock, minimum_stock) 
                VALUES (:cat, :sku, :name, :price, :stock, :min)
            ");
            $stmt->execute([
                'cat'   => $category_id,
                'sku'   => $sku,
                'name'  => $name,
                'price' => $price,
                'stock' => $stock,
                'min'   => $minimum_stock
            ]);

            header('Location: products.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Gagal menyimpan produk (Kemungkinan SKU sudah terdaftar).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-['Plus_Jakarta_Sans'] text-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-400">InventorySystem</h1>
        <a href="products.php" class="text-sm text-slate-300 hover:text-white">&larr; Kembali ke Daftar Produk</a>
    </nav>

    <!-- Form Content -->
    <main class="max-w-xl mx-auto p-6 mt-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-1">Tambah Produk Baru</h2>
            <p class="text-slate-400 text-sm mb-6">Masukkan spesifikasi barang inventaris baru</p>

            <?php if (!empty($error)): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-400 text-sm p-3 rounded-lg mb-4">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Kategori Barang</label>
                    <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Kode SKU Barang</label>
                    <input type="text" name="sku" required placeholder="Contoh: SNK-001" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Nama Produk</label>
                    <input type="text" name="name" required placeholder="Contoh: Sepatu Lari" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="500000" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-1">Stok Awal</label>
                        <input type="number" name="stock" required placeholder="10" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Batas Minimum Stok (Peringatan)</label>
                    <input type="number" name="minimum_stock" value="5" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
                    Simpan Produk
                </button>
            </form>
        </div>
    </main>
</body>
</html>
