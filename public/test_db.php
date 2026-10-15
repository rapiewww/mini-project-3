<?php
require_once __DIR__ . '/../config/database.php';

if (isset($pdo)) {
    echo "Koneksi database BERHASIL dengan PDO!";
} else {
    echo "Koneksi database GAGAL.";
}
