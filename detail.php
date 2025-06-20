<?php
require "admin/function.php"; // Memanggil file function.php dari folder admin

// Ambil ID Artikel dari URL
$id_artikel_url = isset($_GET['id_artikel']) ? mysqli_real_escape_string($conn, $_GET['id_artikel']) : '';

if (empty($id_artikel_url)) {
    // Redirect atau tampilkan pesan error jika ID artikel tidak ditemukan
    header("Location: index.php");
    exit();
}

// Query untuk mengambil detail artikel
// Join dengan tabel kategori_artikel dan penulis untuk mendapatkan Nama_Kategori dan Nama_Lengkap
$sql_detail = "SELECT a.id, a.Hari_Tanggal, a.Judul, a.Isi_Artikel, a.Gambar, ka.Nama_Kategori, p.Nama_Lengkap, ka.kategori_id AS Kategori_ID
               FROM artikel a
               LEFT JOIN kategori_artikel ka ON a.kategori_id = ka.kategori_id
               LEFT JOIN penulis p ON a.Penulis_IP = p.IP
               WHERE a.id = '$id_artikel_url'"; // Filter berdasarkan ID artikel unik
$result_detail = mysqli_query($conn, $sql_detail);

$data_found = false;
if (mysqli_num_rows($result_detail) > 0) {
    $detail_artikel = mysqli_fetch_assoc($result_detail);
    $data_found = true;

    $data_id_artikel = $detail_artikel['id'];
    $data_tanggal = date('F d, Y', strtotime($detail_artikel['Hari_Tanggal']));
    $data_judul = $detail_artikel['Judul'];
    $data_isi = $detail_artikel['Isi_Artikel'];
    $data_gambar = $detail_artikel['Gambar'];
    $data_kategori_nama = $detail_artikel['Nama_Kategori'];
    $data_penulis_nama = $detail_artikel['Nama_Lengkap'];
    $data_kategori_id_artikel = $detail_artikel['Kategori_ID']; // Kategori ID dari artikel ini
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Artikel - Jalan Santai</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="css/styles.css" rel="stylesheet" />
         <style>
            .text-justify {
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Jalan Santai</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        <?php if ($data_found) { ?>
                        <header class="mb-4">
                            <h1 class="fw-bolder mb-1"><?php echo $data_judul; ?></h1>
                            <div class="text-muted fst-italic mb-2">Ditulis pada <?php echo $data_tanggal; ?> oleh <?php echo $data_penulis_nama; ?></div>
                            <a class="badge bg-secondary text-decoration-none link-light" href="kategori_artikel.php?id_kategori=<?php echo $data_kategori_id_artikel; ?>"><?php echo $data_kategori_nama; ?></a>
                        </header>
                        <figure class="mb-4"><img class="img-fluid rounded" src="admin/gambar/<?php echo $data_gambar; ?>" alt="..." /></figure>
                        <section class="mb-5 text-justify">
                            <?php echo $data_isi; ?>
                        </section>
                        <?php } else { ?>
                            <p>Artikel tidak ditemukan.</p>
                        <?php } ?>
                    </article>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" onclick="history.back()">Kembali</button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">Pencarian</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Masukkan kata kunci..." aria-label="Masukkan kata kunci..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Artikel Terkait</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                    <?php
                                    if ($data_found) {
                                        // Query untuk artikel terkait (kategori sama, ID artikel lebih kecil/lebih lama)
                                        $sql_related = "SELECT a.id, a.Judul, ka.kategori_id
                                                        FROM artikel a
                                                        LEFT JOIN kategori_artikel ka ON a.kategori_id = ka.kategori_id
                                                        WHERE a.kategori_id = '$data_kategori_id_artikel' AND a.id < '$data_id_artikel'
                                                        ORDER BY a.id DESC LIMIT 5"; // Batasi 5 artikel terkait
                                        $result_related = mysqli_query($conn, $sql_related);

                                        if (mysqli_num_rows($result_related) > 0) {
                                            while($related_article = mysqli_fetch_assoc($result_related)) {
                                                $related_article_id = $related_article['id'];
                                                $related_kategori_id = $related_article['kategori_id'];
                                        ?>
                                        <a class="list-group-item list-group-item-action" href="detail.php?id_artikel=<?php echo $related_article_id; ?>&id_kategori=<?php echo $related_kategori_id; ?>">
                                            <?php echo $related_article['Judul']; ?>
                                        </a>
                                        <?php
                                            }
                                        } else {
                                            echo "<p class='list-group-item'>Tidak ada artikel terkait.</p>";
                                        }
                                    } else {
                                        echo "<p class='list-group-item'>Tidak ada artikel terkait.</p>";
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Jalan Santai 2024</p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>