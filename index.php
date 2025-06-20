<?php
require "admin/function.php";

$sql_featured = "SELECT a.id, a.Hari_Tanggal, a.Judul, a.Isi_Artikel, a.Gambar, ka.kategori_id AS Kategori_ID
                 FROM artikel a LEFT JOIN kategori_artikel ka ON a.kategori_id = ka.kategori_id
                 ORDER BY a.id DESC LIMIT 1";
$result_featured = mysqli_query($conn, $sql_featured);

$sql_previous = "SELECT a.id, a.Hari_Tanggal, a.Judul, a.Isi_Artikel, a.Gambar, ka.kategori_id AS Kategori_ID
                 FROM artikel a LEFT JOIN kategori_artikel ka ON a.kategori_id = ka.kategori_id
                 ORDER BY a.id DESC LIMIT 6 OFFSET 1";
$result_previous = mysqli_query($conn, $sql_previous);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beranda - Jalan Santai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .navbar { background: #343a40; }
    .header { background: linear-gradient(to right, #007bff, #00c6ff); color: white; }
    .card img { height: 250px; object-fit: cover; }
    .swiper-slide { padding: 10px; }
    .btn-primary { background: #007bff; border: none; }
    .card-body p { text-align: justify; }
    .swiper-pagination-bullet { background: white; }
    .footer { background: #343a40; color: #fff; padding: 50px 0; }
    .footer-bottom { text-align: center; padding: 20px 0; background: #222; }
    .footer-section { padding: 20px; }
    .logo-text span { color: #00c6ff; }
    .contact i, .socials i { color: #00c6ff; }
    .socials a { margin-right: 10px; font-size: 1.5em; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Blog Gies</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>

<header class="header py-5 mb-4 text-center">
  <div class="container">
    <h1 class="fw-bolder mb-3">Selamat Datang di Blog Gies</h1>
    <p>Catatan Artikel-Artikel Terbaru</p>
  </div>
</header>

<div class="container">
  <div class="row">
    <div class="col-lg-8">
      <div class="swiper mySwiper mb-4">
        <div class="swiper-wrapper">

          <?php if (mysqli_num_rows($result_featured) > 0) {
            $featured = mysqli_fetch_assoc($result_featured);
            $potongan = potong_artikel($featured['Isi_Artikel'], 250);
          ?>
          <div class="swiper-slide">
            <div class="card shadow rounded">
              <a href="detail.php?id_artikel=<?php echo $featured['id']; ?>&id_kategori=<?php echo $featured['Kategori_ID']; ?>">
                <img src="admin/gambar/<?php echo $featured['Gambar']; ?>" class="card-img-top rounded-top">
              </a>
              <div class="card-body">
                <h5 class="card-title"><?php echo $featured['Judul']; ?></h5>
                <p class="card-text"><?php echo $potongan; ?></p>
                <a href="detail.php?id_artikel=<?php echo $featured['id']; ?>&id_kategori=<?php echo $featured['Kategori_ID']; ?>" class="btn btn-primary">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
          <?php } ?>

          <?php while ($row = mysqli_fetch_assoc($result_previous)) {
            $potongan = potong_artikel($row['Isi_Artikel'], 125);
          ?>
          <div class="swiper-slide">
            <div class="card shadow rounded">
              <a href="detail.php?id_artikel=<?php echo $row['id']; ?>&id_kategori=<?php echo $row['Kategori_ID']; ?>">
                <img src="admin/gambar/<?php echo $row['Gambar']; ?>" class="card-img-top rounded-top">
              </a>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['Judul']; ?></h5>
                <p class="card-text"><?php echo $potongan; ?></p>
                <a href="detail.php?id_artikel=<?php echo $row['id']; ?>&id_kategori=<?php echo $row['Kategori_ID']; ?>" class="btn btn-primary">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>

        <div class="swiper-button-next text-primary"></div>
        <div class="swiper-button-prev text-primary"></div>
        <div class="swiper-pagination"></div>
      </div>
       <div class="col-md-8">
            <h3 class="mb-4">Artikel Terbaru</h3>
            <?php
            include 'koneksi.php';
          $sql = "SELECT a.id, a.Judul, a.Hari_Tanggal, LEFT(a.Isi_Artikel, 200) AS Cuplikan, k.kategori_id AS Kategori_ID, k.Nama_Kategori 
        FROM artikel a 
        JOIN kategori_artikel k ON a.kategori_id = k.kategori_id 
        ORDER BY a.id DESC LIMIT 3";
 $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="article-card">
                <h5><a href="detail.php?id=<?= $row['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($row['Judul']) ?></a></h5>
                <p class="small text-muted mb-1">Kategori: <?= $row['Nama_Kategori'] ?> | <?= $row['Hari_Tanggal'] ?></p>
                <p><?= htmlspecialchars($row['Cuplikan']) ?>...</p>
                <a href="detail.php?id_artikel=<?= $row['id'] ?>&id_kategori=<?= $row['Kategori_ID'] ?>" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
            </div>
            <?php } ?>
        </div>
    </div>
<div class="col-lg-4">
      <div class="card mb-4">
    <div class="card-header">Pencarian</div>
    <div class="card-body">
        <form method="GET" action="search.php">
            <div class="input-group">
                <input class="form-control" type="text" name="keyword" placeholder="Masukkan kata kunci..." required />
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>
    </div>
</div>


      <div class="card mb-4 shadow">
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

      <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">Tentang</div>
        <div class="card-body text-justify">  
          Blog Gies hadir sebagai wadah berbagi pengalaman menarik seputar wisata, kuliner, dan budaya. Kami menghadirkan artikel informatif dan inspiratif untuk menemani perjalanan eksplorasi Anda, baik di Malang maupun di berbagai daerah lainnya. Selamat membaca dan semoga bermanfaat!
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- About Section -->
            <div class="col-md-6 footer-section about">
                <h1 class="logo-text"><span>Blog</span>Gies</h1>
                <p>Blog pribadi catatan wisata dan jalan-jalan.</p>
                <div class="contact">
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <i class="fas fa-phone"></i>
                        <span style="margin-left: 10px;">123-456-789</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <i class="fas fa-envelope"></i>
                        <span style="margin-left: 10px;">jihannajib.com</span>
                    </div>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="col-md-6 footer-section contact-form">
                <h2>Contact Us</h2>
                <form action="index.html" method="post">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Your Email Address...">
                    </div>
                    <div class="mb-3">
                        <textarea rows="4" name="message" class="form-control" placeholder="Your Message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-envelope"></i> Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer-bottom text-center mt-3">
        &copy; jihannajib.com | Designed by Jihan Najib
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  pagination: { el: ".swiper-pagination", clickable: true },
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  autoplay: { delay: 4000, disableOnInteraction: false }
});
</script>

</body>
</html>
