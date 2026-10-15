<?php
require_once __DIR__ . '/../config/database.php';

// Generate hash asli dari server PHP kamu sendiri
$password_asli = 'password123';
$hash_baru = password_hash($password_asli, PASSWORD_DEFAULT);

// Update ke database
$stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE username = 'admin_ganteng'");
$stmt->execute(['hash' => $hash_baru]);

echo "Password untuk admin_ganteng BERHASIL diperbarui menggunakan hash asli server!<br>";
echo "Silakan hapus file ini, lalu coba login kembali.";
