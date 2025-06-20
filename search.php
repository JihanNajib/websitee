<?php
require "admin/function.php";

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Hasil Pencarian untuk: <em><?= htmlspecialchars($keyword) ?></em></h3>

    <div class="row">
        <?php
        if (!empty($keyword)) {
            $sql_search = "SELECT a.id, a.Judul, a.Isi_Artikel, a.Gambar 
                           FROM artikel a 
                           WHERE a.Judul LIKE '%$keyword%' OR a.Isi_Artikel LIKE '%$keyword%' 
                           ORDER BY a.id DESC";
            $result = mysqli_query($conn, $sql_search);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $potongan = substr($row['Isi_Artikel'], 0, 150) . "...";
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="admin/gambar/<?= $row['Gambar'] ?>" class="card-img-top">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($row['Judul']) ?></h5>
                                <p><?= htmlspecialchars($potongan) ?></p>
                                <a href="detail.php?id_artikel=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Tidak ditemukan artikel dengan kata kunci tersebut.</p>";
            }
        } else {
            echo "<p>Silakan masukkan kata kunci.</p>";
        }
        ?>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
</div>

</body>
</html>
