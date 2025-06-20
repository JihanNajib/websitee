<?php
// Mulai sesi (penting untuk mengakses variabel sesi)
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan pengguna ke halaman login
header("Location: login.php");
exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
?>