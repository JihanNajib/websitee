<?php
require "function.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard - Kelola Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f8f9fa;
        }
        .sb-sidenav {
            background: linear-gradient(45deg, #343a40, #212529);
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .dashboard-icon {
            font-size: 40px;
            opacity: 0.3;
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Menu Utama</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                    <a class="nav-link" href="artikel.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div> Artikel
                    </a>
                    <a class="nav-link" href="kategori.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div> Kategori
                    </a>
                    <a class="nav-link" href="penulis.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-pen-nib"></i></div> Penulis
                    </a>
                    <a class="nav-link" href="logout.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div> Logout
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <h1 class="mb-4">Dashboard</h1>
                <div class="row">

                    <!-- Artikel -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card bg-primary text-white position-relative">
                            <div class="card-body">
                                Artikel
                                <div class="dashboard-icon"><i class="fa-solid fa-newspaper"></i></div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php
                                $sql_artikel = "SELECT * from artikel";
                                $query_artikel = mysqli_query($conn, $sql_artikel);
                                $count_artikel = mysqli_num_rows($query_artikel);
                                ?>
                                <a class="small text-white stretched-link" href="artikel.php">
                                    <?php echo $count_artikel . " Artikel"; ?>
                                </a>
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card bg-warning text-white position-relative">
                            <div class="card-body">
                                Kategori
                                <div class="dashboard-icon"><i class="fa-solid fa-list"></i></div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php
                                $sql_kategori = "SELECT * from kategori_artikel";
                                $query_kategori = mysqli_query($conn, $sql_kategori);
                                $count_kategori = mysqli_num_rows($query_kategori);
                                ?>
                                <a class="small text-white stretched-link" href="kategori.php">
                                    <?php echo $count_kategori . " Kategori"; ?>
                                </a>
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Penulis -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card bg-success text-white position-relative">
                            <div class="card-body">
                                Penulis
                                <div class="dashboard-icon"><i class="fa-solid fa-pen-nib"></i></div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php
                                $sql_penulis = "SELECT * from penulis";
                                $query_penulis = mysqli_query($conn, $sql_penulis);
                                $count_penulis = mysqli_num_rows($query_penulis);
                                ?>
                                <a class="small text-white stretched-link" href="penulis.php">
                                    <?php echo $count_penulis . " Penulis"; ?>
                                </a>
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">&copy; Kelola Konten 2025</div>
                    <div>
                        <a href="#">Privacy Policy</a> &middot; <a href="#">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
