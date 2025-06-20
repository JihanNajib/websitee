<?php
require "function.php"; // Pastikan file function.php berisi koneksi database ($conn)
require "check_session.php"; // Memastikan sesi login
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Penulis - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Menu Utama</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="artikel.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                                Artikel
                            </a>
                            <a class="nav-link" href="kategori.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                                Kategori
                            </a>
                            <a class="nav-link" href="penulis.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-pen-nib"></i></div>
                                Penulis
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Menu Utama
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Penulis</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Silakan kelola penulis</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormPenulis">
                                    <i class="fa-solid fa-user-plus"></i> Penulis Baru
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penulis</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data penulis
                                        // UBAH 'Username' menjadi 'Email'
                                        $sql = "SELECT IP, Email, Nama_Lengkap, Pswd FROM penulis ORDER BY IP DESC"; // Baris 93
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $nomor_urut = 1;
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $data_ip = $row['IP'];
                                                $data_nama_lengkap = $row['Nama_Lengkap'];
                                                $data_email = $row['Email']; // UBAH INI JUGA DARI $row['Username']
                                        ?>
                                        <tr>
                                            <td><?php echo $nomor_urut++; ?></td>
                                            <td><?php echo $data_nama_lengkap; ?></td>
                                            <td><?php echo $data_email; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormUpdatePenulis<?php echo str_replace('.', '', $data_ip); ?>">
                                                    Ubah
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapusPenulis<?php echo str_replace('.', '', $data_ip); ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalFormUpdatePenulis<?php echo str_replace('.', '', $data_ip); ?>" tabindex="-1" aria-labelledby="modalFormUpdatePenulisLabel<?php echo str_replace('.', '', $data_ip); ?>" aria-hidden="true" data-bs-backdrop="static">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="function.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalFormUpdatePenulisLabel<?php echo str_replace('.', '', $data_ip); ?>">Ubah Penulis</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_lengkap_update_<?php echo str_replace('.', '', $data_ip); ?>" class="form-label">Nama Penulis</label>
                                                                <input type="text" class="form-control" id="nama_lengkap_update_<?php echo str_replace('.', '', $data_ip); ?>" name="nama_lengkap" value="<?php echo $data_nama_lengkap; ?>" required>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="username_update_<?php echo str_replace('.', '', $data_ip); ?>" class="form-label">Email</label>
                                                                <input type="email" class="form-control" id="username_update_<?php echo str_replace('.', '', $data_ip); ?>" name="username" value="<?php echo $data_email; ?>" required>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="password_update_<?php echo str_replace('.', '', $data_ip); ?>" class="form-label">Password</label>
                                                                <input type="password" class="form-control" id="password_update_<?php echo str_replace('.', '', $data_ip); ?>" name="password" placeholder="Isi dengan password lama atau ganti dengan yang baru">
                                                            </div>
                                                            <input type="hidden" name="id_penulis_update" value="<?php echo $data_ip; ?>">
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-end gap-2">
                                                            <button type="submit" class="btn btn-warning" name="btn_ubah_penulis">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalHapusPenulis<?php echo str_replace('.', '', $data_ip); ?>" tabindex="-1" aria-labelledby="modalHapusPenulisLabel<?php echo str_replace('.', '', $data_ip); ?>" aria-hidden="true" data-bs-backdrop="static">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="function.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusPenulisLabel<?php echo str_replace('.', '', $data_ip); ?>">Hapus Penulis</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah penulis dengan nama <strong><?php echo $data_nama_lengkap; ?></strong> akan dihapus?
                                                            <input type="hidden" name="id_hapus_penulis" value="<?php echo $data_ip; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="btn_hapus_penulis">Hapus</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>Tidak ada data penulis.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Blog Gies 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div class="modal fade" id="modalFormPenulis" tabindex="-1" aria-labelledby="modalFormPenulisLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="function.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFormPenulisLabel">Tambah Penulis</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Penulis</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama penulis" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="username" class="form-label">Email</label>
                                <input type="email" class="form-control" id="username" name="username" placeholder="Masukkan email penulis" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary" name="btn_simpan_penulis">Simpan</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>