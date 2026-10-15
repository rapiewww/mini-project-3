<?php
// config/database.php - Konfigurasi Koneksi Database menggunakan PDO

$host = 'localhost';
$port = '8889'; // Sesuaikan port MySQL MAMP kamu (biasanya 8889 di Mac, atau 3306)
$db   = 'inventory_db';
$user = 'root';
$pass = 'root'; // Default password MAMP biasanya 'root'

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Tangani error koneksi secara aman
    http_response_code(500);
    exit("Koneksi database gagal: " . $e->getMessage());
}
