<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/functions.php';

init_session();
check_auth();

$error = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: products.php');
    exit;
}

// Ambil data produk berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

// Ambil kategori
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id   = trim($_POST['category_id'] ?? '');
    $sku           = trim($_POST['sku'] ?? '');
    $name          = trim($_POST['name'] ?? '');
    $price         = trim($_POST['price'] ?? '');
    $stock         = trim($_POST['stock'] ?? '');
    $minimum_stock = trim($_POST['minimum_stock'] ?? '5');

    if (empty($category_id) || empty($sku) || empty($name) || empty($price) || empty($stock)) {
        $error = 'Semua kolom wajib diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE products 
                SET category_id = :cat, sku = :sku, name = :name, price = :price, stock = :stock, minimum_stock = :min 
                WHERE id = :id
            ");
            $stmt->execute([
                'cat'   => $category_id,
                'sku'   => $sku,
                'name'  => $name,
                'price' => $price,
                'stock' => $stock,
                'min'   => $minimum_stock,
                'id'    => $id
            ]);

            header('Location: products.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Gagal memperbarui produk (SKU mungkin sudah digunakan).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-['Plus_Jakarta_Sans'] text-slate-100 min-h-screen">
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-400">InventorySystem</h1>
        <a href="products.php" class="text-sm text-slate-300 hover:text-white">&larr; Kembali</a>
    </nav>

    <main class="max-w-xl mx-auto p-6 mt-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-1">Edit Produk</h2>
            <p class="text-slate-400 text-sm mb-6">Perbarui informasi barang inventaris</p>

            <?php if (!empty($error)): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-400 text-sm p-3 rounded-lg mb-4">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Kategori Barang</label>
                    <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Kode SKU Barang</label>
                    <input type="text" name="sku" value="<?= e($product['sku']) ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Nama Produk</label>
                    <input type="text" name="name" value="<?= e($product['name']) ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-1">Harga (Rp)</label>
                        <input type="number" name="price" value="<?= e($product['price']) ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-1">Stok</label>
                        <input type="number" name="stock" value="<?= e($product['stock']) ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">Batas Minimum Stok</label>
                    <input type="number" name="minimum_stock" value="<?= e($product['minimum_stock']) ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </main>
</body>
</html>
