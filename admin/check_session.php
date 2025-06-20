<?php
// session_start(); // <--- HAPUS BARIS INI ATAU JADIKAN KOMENTAR

// Cek apakah user sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) { // Memastikan $_SESSION['username'] ada dan tidak kosong
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Cek apakah sesi masih aktif (optional - untuk keamanan tambahan)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    // Sesi berakhir setelah 30 menit tidak aktif (1800 detik = 30 menit)
    session_unset(); // Hapus semua variabel sesi
    session_destroy(); // Hancurkan sesi
    header("Location: login.php?timeout=1"); // Redirect ke halaman login dengan pesan timeout
    exit();
}

// Update waktu aktivitas terakhir
$_SESSION['last_activity'] = time();

// Fungsi untuk logout (Jika ada di sini, biasanya dipicu oleh URL ?logout)
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>