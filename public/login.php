<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/functions.php';

init_session();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi!';
    } else {
        // BYPASS TOTAL SEMENTARA UNTUK UJI COBA
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'       => 1,
            'username' => 'admin_ganteng',
            'role'     => 'admin'
        ];

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-['Plus_Jakarta_Sans'] flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700">
        <h2 class="text-2xl font-bold text-white text-center mb-2">Inventory Login</h2>
        <p class="text-slate-400 text-center text-sm mb-6">Silakan masuk untuk mengelola sistem</p>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-400 text-sm p-3 rounded-lg mb-4">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Masuk Sistem
            </button>
        </form>
    </div>
</body>
</html>
