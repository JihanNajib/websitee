<?php
require "admin/function.php"; // Memanggil koneksi database

// Pastikan koneksi tersedia
if (!$conn) {
    die("Database connection failed.");
}

// Inisialisasi variabel default
$id_kategori_terpilih = '';
$nama_kategori_terpilih = 'Semua Kategori';
$result_category_articles = null;

if (isset($_GET['id_kategori'])) {
    $id_kategori_terpilih = mysqli_real_escape_string($conn, $_GET['id_kategori']);

    // Ambil nama kategori
    $sql_get_category_name = "SELECT Nama_Kategori FROM kategori_artikel WHERE kategori_id = '$id_kategori_terpilih'";
    $result_get_category_name = mysqli_query($conn, $sql_get_category_name);

    if ($result_get_category_name && mysqli_num_rows($result_get_category_name) > 0) {
        $row_category_name = mysqli_fetch_assoc($result_get_category_name);
        $nama_kategori_terpilih = $row_category_name['Nama_Kategori'];
    }

    // Ambil artikel per kategori
    $sql_category_articles = "SELECT a.id, a.Hari_Tanggal, a.Judul, a.Isi_Artikel, a.Gambar, ka.kategori_id AS Kategori_ID
                               FROM artikel a 
                               LEFT JOIN kategori_artikel ka ON a.kategori_id = ka.kategori_id
                               WHERE a.kategori_id = '$id_kategori_terpilih'
                               ORDER BY a.id DESC";
    $result_category_articles = mysqli_query($conn, $sql_category_articles);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori: <?= htmlspecialchars($nama_kategori_terpilih) ?> - Blog Gies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card img { height: 200px; object-fit: cover; }
        .navbar { background: #343a40; }
        .footer { background: #343a40; color: white; padding: 30px 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Blog Gies</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-primary text-white text-center py-5 mb-4">
    <div class="container">
        <h1>Artikel Kategori: <?= htmlspecialchars($nama_kategori_terpilih) ?></h1>
        <p>Temukan artikel menarik sesuai kategori pilihan Anda</p>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <?php if ($result_category_articles && mysqli_num_rows($result_category_articles) > 0) {
                    while($article = mysqli_fetch_assoc($result_category_articles)) {
                        $potongan = substr(strip_tags($article['Isi_Artikel']), 0, 150) . '...';
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="detail.php?id_artikel=<?= $article['id'] ?>&id_kategori=<?= $article['Kategori_ID'] ?>">
                            <img src="admin/gambar/<?= $article['Gambar'] ?>" class="card-img-top">
                        </a>
                        <div class="card-body">
                            <small class="text-muted"><?= date('d M Y', strtotime($article['Hari_Tanggal'])) ?></small>
                            <h5 class="card-title mt-2"><?= htmlspecialchars($article['Judul']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($potongan) ?></p>
                            <a href="detail.php?id_artikel=<?= $article['id'] ?>&id_kategori=<?= $article['Kategori_ID'] ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <?php } 
                } else {
                    echo "<div class='col-12'><div class='alert alert-info'>Belum ada artikel dalam kategori ini.</div></div>";
                }
                ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Kategori</div>
                <div class="list-group list-group-flush">
                <?php
                $kategori_query = "SELECT * FROM kategori_artikel ORDER BY Nama_Kategori ASC";
                $kategori_result = mysqli_query($conn, $kategori_query);
                if (mysqli_num_rows($kategori_result) > 0) {
                    while($kategori = mysqli_fetch_assoc($kategori_result)) {
                        echo '<a href="kategori_artikel.php?id_kategori='.$kategori['kategori_id'].'" class="list-group-item">'.$kategori['Nama_Kategori'].'</a>';
                    }
                } else {
                    echo '<p class="list-group-item">Tidak ada kategori.</p>';
                }
                ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Tentang</div>
                <div class="card-body">
                    Sekedar catatan artikel yang terdapat didalam Blog Gies
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer text-center">
    <div class="container">
        <p class="mb-0">&copy; Blog Gies 2025 - All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
