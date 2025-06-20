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
        <title>Artikel - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .ck-editor__editable_inline {
                min-height: 350px; /* Menyesuaikan tinggi editor CKEditor seperti di video */
            }
        </style>
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
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></i></div>
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
                        <h1 class="mt-4">Artikel</h1>
                        <p class="text-muted">Silahkan kelola artikel</p>

                        <div class="mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormArtikel">
                                <i class="fas fa-plus me-2"></i>Artikel Baru
                            </button>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Judul</th>
                                            <th>Isi Artikel</th>
                                            <th>Kategori</th>
                                            <th>Penulis</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data artikel dengan JOIN ke kategori_artikel dan penulis
                                        $sql_artikel_display = "SELECT
                                                            a.id,
                                                            a.Hari_Tanggal,
                                                            a.Judul,
                                                            a.Isi_Artikel,
                                                            a.Gambar,
                                                            ka.Nama_Kategori,
                                                            ka.kategori_id AS kategori_id_artikel,
                                                            p.Nama_Lengkap
                                                        FROM
                                                            artikel AS a
                                                        JOIN
                                                            kategori_artikel AS ka ON a.kategori_id = ka.kategori_id
                                                        JOIN
                                                            penulis AS p ON a.Penulis_IP = p.IP
                                                        ORDER BY a.id DESC";

                                        $result_artikel_display = mysqli_query($conn, $sql_artikel_display);

                                        if (mysqli_num_rows($result_artikel_display) > 0) {
                                            $nomor_urut = 1;
                                            while($row_artikel = mysqli_fetch_assoc($result_artikel_display)) {
                                                // Ambil ID artikel dan kategori ID untuk digunakan di modal ubah dan hapus
                                                $data_id_artikel = $row_artikel['id'];
                                                $data_kategori_id_artikel = $row_artikel['kategori_id_artikel']; // Untuk pre-select kategori di modal ubah
                                                $data_gambar_artikel = $row_artikel['Gambar']; // Untuk pre-fill gambar di modal ubah
                                                $data_isi_artikel = $row_artikel['Isi_Artikel']; // Untuk pre-fill isi di modal ubah

                                                // Format tanggal seperti di video: "Senin, 27 Mei 2024 | 11:41"
                                                $timestamp = strtotime($row_artikel['Hari_Tanggal']);
                                                $hari = date('l', $timestamp);
                                                $nama_hari_indo = terjemah_hari($hari);
                                                $tanggal_format = $nama_hari_indo . ", " . date('d F Y | H:i', $timestamp);

                                                // Potong isi artikel agar tidak terlalu panjang di tabel
                                                $isi_potongan = potong_artikel($row_artikel['Isi_Artikel'], 100);
                                        ?>
                                        <tr>
                                            <td><?php echo $nomor_urut++; ?></td>
                                            <td><?php echo $tanggal_format; ?></td>
                                            <td><?php echo $row_artikel['Judul']; ?></td>
                                            <td><?php echo $isi_potongan; ?></td>
                                            <td><?php echo $row_artikel['Nama_Kategori']; ?></td>
                                            <td><?php echo $row_artikel['Nama_Lengkap']; ?></td>
                                            <td>
                                                <?php if (!empty($row_artikel['Gambar'])): ?>
                                                    <img src="<?php echo $row_artikel['Gambar']; ?>" alt="Gambar Artikel" style="max-width: 100px; height: auto;">
                                                <?php else: ?>
                                                    Tidak ada gambar
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalFormUbahArtikel<?php echo $data_id_artikel; ?>"> Ubah
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusArtikel<?php echo $data_id_artikel; ?>"> Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalHapusArtikel<?php echo $data_id_artikel; ?>" tabindex="-1" aria-labelledby="modalHapusArtikelLabel<?php echo $data_id_artikel; ?>" aria-hidden="true" data-bs-backdrop="static">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="function.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusArtikelLabel<?php echo $data_id_artikel; ?>">Hapus Data Artikel</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                Apakah artikel dengan judul <strong><?php echo $row_artikel['Judul']; ?></strong> akan dihapus?
                                                            </div>
                                                            <input type="hidden" name="id_hapus_artikel" value="<?php echo $data_id_artikel; ?>">
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-end gap-2">
                                                            <button type="submit" class="btn btn-danger" name="btn_hapus_artikel">Hapus</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalFormUbahArtikel<?php echo $data_id_artikel; ?>" tabindex="-1" aria-labelledby="modalFormUbahArtikelLabel<?php echo $data_id_artikel; ?>" aria-hidden="true" data-bs-backdrop="static">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <form method="post" action="function.php" enctype="multipart/form-data" class="form-ubah-artikel">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalFormUbahArtikelLabel<?php echo $data_id_artikel; ?>">Ubah Artikel</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="tanggal_ubah<?php echo $data_id_artikel; ?>" class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" id="tanggal_ubah<?php echo $data_id_artikel; ?>" name="tanggal" value="<?php echo $tanggal_format; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="judul_ubah<?php echo $data_id_artikel; ?>" class="form-label">Judul</label>
                                                                <input type="text" class="form-control" id="judul_ubah<?php echo $data_id_artikel; ?>" name="judul" value="<?php echo $row_artikel['Judul']; ?>" placeholder="Masukkan judul artikel" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kategori_ubah<?php echo $data_id_artikel; ?>" class="form-label">Kategori</label>
                                                                <select class="form-select" id="kategori_ubah<?php echo $data_id_artikel; ?>" name="kategori" required>
                                                                    <option value="">Pilih Kategori</option>
                                                                    <?php
                                                                    // Mengambil data kategori untuk dropdown dan pre-select kategori yang sudah ada
                                                                    $sql_kategori_dropdown_ubah = "SELECT kategori_id, Nama_Kategori FROM kategori_artikel ORDER BY Nama_Kategori ASC";
                                                                    $result_kategori_dropdown_ubah = mysqli_query($conn, $sql_kategori_dropdown_ubah);
                                                                    if (mysqli_num_rows($result_kategori_dropdown_ubah) > 0) {
                                                                        while($row_kategori_dropdown_ubah = mysqli_fetch_assoc($result_kategori_dropdown_ubah)) {
                                                                            $selected = ($row_kategori_dropdown_ubah['kategori_id'] == $data_kategori_id_artikel) ? 'selected' : '';
                                                                            echo "<option value='" . $row_kategori_dropdown_ubah['kategori_id'] . "' " . $selected . ">" . $row_kategori_dropdown_ubah['Nama_Kategori'] . "</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="isi_ubah<?php echo $data_id_artikel; ?>" class="form-label">Isi Artikel</label>
                                                                <textarea class="form-control" id="isi_ubah<?php echo $data_id_artikel; ?>" name="isi" rows="10" placeholder="Tulis artikel di sini"><?php echo htmlspecialchars($data_isi_artikel); ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="gambar_ubah<?php echo $data_id_artikel; ?>" class="form-label">Gambar</label>
                                                                <input type="file" class="form-control" id="gambar_ubah<?php echo $data_id_artikel; ?>" name="gambar">
                                                                <?php if (!empty($data_gambar_artikel)): ?>
                                                                    <small class="text-muted">Gambar saat ini: <a href="<?php echo $data_gambar_artikel; ?>" target="_blank"><?php echo basename($data_gambar_artikel); ?></a></small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="hidden" name="id_ubah_artikel" value="<?php echo $data_id_artikel; ?>">
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-primary btn_ubah_artikel_submit" name="btn_ubah_artikel" data-article-id="<?php echo $data_id_artikel; ?>">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='8'>Tidak ada data artikel.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-muted">
                            Showing 1 to <?php echo mysqli_num_rows($result_artikel_display); ?> of <?php echo mysqli_num_rows($result_artikel_display); ?> entries
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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

        <div class="modal fade" id="modalFormArtikel" tabindex="-1" aria-labelledby="modalFormArtikelLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl"> <div class="modal-content">
                    <form method="post" action="function.php" enctype="multipart/form-data"> <div class="modal-header">
                            <h5 class="modal-title" id="modalFormArtikelLabel">Tambah Artikel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <?php
                                // Mengambil dan memformat tanggal dan waktu otomatis seperti di video
                                date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
                                $hari_inggris = date('l'); // 'l' untuk nama hari lengkap dalam bahasa Inggris
                                $nama_hari_indo = terjemah_hari($hari_inggris); // Fungsi dari function.php
                                $tanggal_angka = date('d'); // Hari dalam angka
                                $bulan_angka = date('m'); // Bulan dalam angka (01-12)
                                $nama_bulan_indo = terjemah_bulan($bulan_angka); // Fungsi terjemah_bulan dari function.php
                                $tahun = date('Y'); // Tahun lengkap
                                $waktu = date('H:i'); // Jam dan menit (24-jam format)

                                $tanggal_lengkap = $tanggal_angka . " " . $nama_bulan_indo . " " . $tahun;
                                $hari_tanggal_waktu = $nama_hari_indo . ", " . $tanggal_lengkap . " | " . $waktu;
                                ?>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $hari_tanggal_waktu; ?>" readonly> </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul artikel" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    // Mengambil data kategori untuk dropdown seperti di video
                                    $sql_kategori_dropdown = "SELECT kategori_id, Nama_Kategori FROM kategori_artikel ORDER BY Nama_Kategori ASC";
                                    $result_kategori_dropdown = mysqli_query($conn, $sql_kategori_dropdown);
                                    if (mysqli_num_rows($result_kategori_dropdown) > 0) {
                                        while($row_kategori_dropdown = mysqli_fetch_assoc($result_kategori_dropdown)) {
                                            echo "<option value='" . $row_kategori_dropdown['kategori_id'] . "'>" . $row_kategori_dropdown['Nama_Kategori'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel</label>
                                <textarea class="form-control" id="isi" name="isi" rows="10" placeholder="Tulis artikel di sini"></textarea> </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary" name="btn_simpan_artikel">Simpan</button>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
        <script>
            // Map untuk menyimpan instance CKEditor agar mudah diakses
            const editorInstances = {};

            // Konfigurasi CKEditor untuk form Tambah Artikel (ID: isi)
            CKEDITOR.ClassicEditor.create(document.getElementById("isi"), {
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|', 'findAndReplace', 'selectAll', '|', 'heading', '|', 'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|', 'undo', 'redo', '|', 'blockQuote', 'insertTable', 'undo', 'redo', '|', 'link', 'bulletedList', 'numberedList', 'uploadImage', 'indent', 'outdent', '|', 'highlight', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|', 'specialCharacters', 'horizontalLine', 'pageBreak', '|', 'textPartLanguage', '|', 'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: { styles: true, startIndex: true, reversed: true }
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' }, { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' }, { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }, { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }, { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }, { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }, { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                placeholder: 'Tulis artikel di sini',
                fontFamily: {
                    options: [ 'default', 'Arial, Helvetica, sans-serif', 'Courier New', 'Courier, monospace', 'Georgia, serif', 'Lucida Sans Unicode', 'Lucida Grande', 'sans-serif', 'Tahoma', 'Geneva, sans-serif', 'Times New Roman', 'Times, serif', 'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif' ], supportAllValues: true
                },
                fontSize: { options: [ 10, 12, 14, 'default', 18, 20, 22 ], supportAllValues: true },
                htmlSupport: { allowOrphanedDOMNodess: true },
                htmlEmbed: { showPreivewInViewport: true },
                link: {
                    decorators: { addTargetToExternalLinks: true, rel: { attributes: { rel: 'noopener noreferrer nofollow' } } }
                },
                mention: {
                    feeds: [ { marker: '@', feed: [ '@Chris', '@Robert', '@Victoria', '@Tiffani', '@Keaton', '@Laura', '@Jaden', '@Kyler', '@Pan', '@Alvin', '@Ryan' ], minimumCharacters: 1 } ]
                },
                removePlugins: [ 'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaboraation', 'TrackChanges', 'WProofreader', 'WordCount', 'CusomTextTransofrmation', 'SourceEditing' ]
            }).then(editor => {
                editorInstances['isi'] = editor; // Simpan instance editor "Tambah Artikel"
            });

            // ====================================================================
            // BAGIAN PENTING: Penanganan CKEditor untuk Modal Ubah Artikel
            // ====================================================================
            document.addEventListener('DOMContentLoaded', function() {
                var ubahArtikelModals = document.querySelectorAll('[id^="modalFormUbahArtikel"]');

                ubahArtikelModals.forEach(function(modalElement) {
                    // Event listener saat modal ditampilkan
                    modalElement.addEventListener('shown.bs.modal', function () {
                        const articleId = this.id.replace('modalFormUbahArtikel', '');
                        const textareaId = 'isi_ubah' + articleId;
                        const editorElement = document.getElementById(textareaId);

                        // Fungsi untuk membuat CKEditor dengan konfigurasi standar
                        const createCkEditorInstance = (element, id) => {
                            return CKEDITOR.ClassicEditor.create(element, {
                                toolbar: { items: [ 'exportPDF','exportWord', '|', 'findAndReplace', 'selectAll', '|', 'heading', '|', 'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|', 'undo', 'redo', '|', 'blockQuote', 'insertTable', 'undo', 'redo', '|', 'link', 'bulletedList', 'numberedList', 'uploadImage', 'indent', 'outdent', '|', 'highlight', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|', 'specialCharacters', 'horizontalLine', 'pageBreak', '|', 'textPartLanguage', '|', 'sourceEditing' ], shouldNotGroupWhenFull: true }, list: { properties: { styles: true, startIndex: true, reversed: true } }, heading: { options: [ { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' }, { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' }, { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }, { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }, { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }, { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }, { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' } ] }, placeholder: 'Tulis artikel di sini', fontFamily: { options: [ 'default', 'Arial, Helvetica, sans-serif', 'Courier New', 'Courier, monospace', 'Georgia, serif', 'Lucida Sans Unicode', 'Lucida Grande', 'sans-serif', 'Tahoma', 'Geneva, sans-serif', 'Times New Roman', 'Times', 'serif', 'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif' ], supportAllValues: true }, fontSize: { options: [ 10, 12, 14, 'default', 18, 20, 22 ], supportAllValues: true }, htmlSupport: { allowOrphanedDOMNodess: true }, htmlEmbed: { showPreivewInViewport: true }, link: { decorators: { addTargetToExternalLinks: true, rel: { attributes: { rel: 'noopener noreferrer nofollow' } } } }, mention: { feeds: [ { marker: '@', feed: [ '@Chris', '@Robert', '@Victoria', '@Tiffani', '@Keaton', '@Laura', '@Jaden', '@Kyler', '@Pan', '@Alvin', '@Ryan' ] , minimumCharacters: 1 } ] }, removePlugins: [ 'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaboraation', 'TrackChanges', 'WProofreader', 'WordCount', 'CusomTextTransofrmation', 'SourceEditing' ]
                            });
                        };

                        // Hancurkan instance yang mungkin sudah ada, lalu buat yang baru
                        // Ini penting untuk memastikan editor bersih setiap kali modal dibuka
                        if (editorElement && editorInstances[textareaId]) {
                            editorInstances[textareaId].destroy()
                                .then(() => {
                                    delete editorInstances[textareaId];
                                    createCkEditorInstance(editorElement, textareaId).then(editor => {
                                        editorInstances[textareaId] = editor;
                                        editor.setData(editorElement.value); // Set data dari textarea ke editor
                                    });
                                })
                                .catch(error => console.error('Error destroying old CKEditor instance:', error));
                        } else if (editorElement) {
                            // Jika belum ada instance, buat yang baru
                            createCkEditorInstance(editorElement, textareaId).then(editor => {
                                editorInstances[textareaId] = editor;
                                editor.setData(editorElement.value); // Set data dari textarea ke editor
                            });
                        }
                    });

                    // Event listener saat modal disembunyikan
                    modalElement.addEventListener('hidden.bs.modal', function () {
                        const articleId = this.id.replace('modalFormUbahArtikel', '');
                        const textareaId = 'isi_ubah' + articleId;
                        if (editorInstances[textareaId]) {
                            // Update source sebelum menghancurkan (safety first)
                            editorInstances[textareaId].updateSourceElement();
                            editorInstances[textareaId].destroy()
                                .then(() => {
                                    delete editorInstances[textareaId];
                                })
                                .catch(error => console.error('Error destroying CKEditor instance:', error));
                        }
                    });

                    // Tambahkan event listener untuk tombol submit 'Ubah' di dalam modal
                    // Ini adalah BARIS KRUSIAL untuk memastikan data CKEditor terkirim
                    // Karena kita mengubah type tombol menjadi "button", kita harus secara manual submit form
                    const ubahButton = modalElement.querySelector('button[name="btn_ubah_artikel"]');
                    if (ubahButton) {
                        ubahButton.addEventListener('click', function(event) {
                            event.preventDefault(); // Mencegah submit default tombol
                            const articleId = modalElement.id.replace('modalFormUbahArtikel', '');
                            const textareaId = 'isi_ubah' + articleId;
                            if (editorInstances[textareaId]) {
                                // Memaksa CKEditor untuk menyalin konten ke textarea sebelum form disubmit
                                editorInstances[textareaId].updateSourceElement();
                            }
                            // Setelah memastikan textarea terisi, submit form secara manual
                            this.closest('form').submit();
                        });
                    }
                });
            });
        </script>
    </body>
</html>