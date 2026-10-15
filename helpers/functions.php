<?php
// helpers/functions.php - Kumpulan fungsi helper keamanan dan escape

// 1. Fungsi untuk mencegah XSS (Output Encoding)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// 2. Fungsi untuk memulai session dengan aman
function init_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// 3. Fungsi untuk mengecek apakah user sudah login
function check_auth() {
    init_session();
    if (!isset($_SESSION['user'])) {
        header('Location: /inventory-app/public/login.php');
        exit;
    }
}

// 4. Fungsi untuk membatasi hak akses berdasarkan role (Admin / Staff)
function check_role($required_role) {
    check_auth();
    if ($_SESSION['user']['role'] !== $required_role) {
        http_response_code(403);
        exit('Access Denied: Anda tidak memiliki hak akses ke halaman ini.');
    }
}
