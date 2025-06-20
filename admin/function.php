<?php
session_start();

// Aktifkan pelaporan error MySQLi agar kesalahan SQL lebih mudah didiagnosis
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Konfigurasi database
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dbblog";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set zona waktu ke WIB (Indonesia Barat)
date_default_timezone_set('Asia/Jakarta');

// --- FUNGSI BARU: potong_artikel ---
function potong_artikel($isi_artikel, $jml_karakter) {
    // Memastikan jumlah karakter tidak melebihi panjang artikel
    if (strlen($isi_artikel) <= $jml_karakter) {
        return $isi_artikel;
    }

    // Mencari spasi terdekat sebelum atau pada jml_karakter
    $potongan_isi = substr($isi_artikel, 0, $jml_karakter);
    $last_space = strrpos($potongan_isi, ' ');

    if ($last_space !== false) {
        $potongan_isi = substr($potongan_isi, 0, $last_space);
    }

    return $potongan_isi . " ...";
}


// --- FUNGSI BARU: terjemah_hari ---
function terjemah_hari($nama_hari_inggris) {
    switch ($nama_hari_inggris) {
        case 'Sunday':
            return 'Minggu';
        case 'Monday':
            return 'Senin';
        case 'Tuesday':
            return 'Selasa';
        case 'Wednesday':
            return 'Rabu';
        case 'Thursday':
            return 'Kamis';
        case 'Friday':
            return 'Jumat';
        case 'Saturday':
            return 'Sabtu';
        default:
            return $nama_hari_inggris;
    }
}

// --- FUNGSI BARU: terjemah_bulan ---
function terjemah_bulan($bulan_angka) {
    switch ($bulan_angka) {
        case '01': return 'Januari';
        case '02': return 'Februari';
        case '03': return 'Maret';
        case '04': return 'April';
        case '05': return 'Mei';
        case '06': return 'Juni';
        case '07': return 'Juli';
        case '08': return 'Agustus';
        case '09': return 'September';
        case '10': return 'Oktober';
        case '11': return 'November';
        case '12': return 'Desember';
        default: return $bulan_angka;
    }
}


// Cek jika tombol login ditekan
if (isset($_POST['btn_login'])) {
    $data_email    = $_POST['email'];
    $data_password = $_POST['password'];

    $data_email    = mysqli_real_escape_string($conn, $data_email);
    $data_password = md5(mysqli_real_escape_string($conn, $data_password));

    // UBAH DARI 'Username' MENJADI 'Email' DI SINI
    $sql = "SELECT IP, Email, Nama_Lengkap, Pswd FROM penulis WHERE Email='$data_email' AND Pswd='$data_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['Email']; // Menggunakan 'Email' sebagai username sesi
        $_SESSION['id_penulis'] = $row['IP'];     // Menyimpan IP penulis ke sesi
        $_SESSION['last_activity'] = time();      // Menyimpan waktu aktivitas terakhir untuk timeout sesi
        header("Location: index.php"); // Arahkan ke index.php setelah login berhasil
        exit();
    } else {
        // Jika login gagal, Anda bisa arahkan kembali ke login.php dengan pesan error
        header("Location: login.php?error=1");
        exit();
    }
}

// --- LOGIKA UNTUK MENAMBAH PENULIS ---
if (isset($_POST['btn_simpan_penulis'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username_email = mysqli_real_escape_string($conn, $_POST['username']); // Ini masih 'username' dari form
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Enkripsi password menggunakan MD5 sebelum disimpan
    $password_md5 = md5($password);

    $ip_penulis = $_SERVER['REMOTE_ADDR'];

    // UBAH DARI 'Username' MENJADI 'Email' DI SINI
    $sql = "INSERT INTO penulis (IP, Email, Nama_Lengkap, Pswd) VALUES ('$ip_penulis', '$username_email', '$nama_lengkap', '$password_md5')";

    if (mysqli_query($conn, $sql)) {
        header("Location: penulis.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGUBAH PENULIS ---
if (isset($_POST['btn_ubah_penulis'])) {
    $id_penulis = mysqli_real_escape_string($conn, $_POST['id_penulis_update']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username_email = mysqli_real_escape_string($conn, $_POST['username']); // Ini masih 'username' dari form
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql_update = "UPDATE penulis SET Nama_Lengkap='$nama_lengkap', Email='$username_email'"; // UBAH DI SINI

    // Jika password diisi, enkripsi dan tambahkan ke query update
    if (!empty($password)) {
        $password_md5 = md5($password);
        $sql_update .= ", Pswd='$password_md5'";
    }

    $sql_update .= " WHERE IP='$id_penulis'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: penulis.php");
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGHAPUS PENULIS ---
if (isset($_POST['btn_hapus_penulis'])) {
    $id_penulis = mysqli_real_escape_string($conn, $_POST['id_hapus_penulis']);

    $sql = "DELETE FROM penulis WHERE IP='$id_penulis'";

    if (mysqli_query($conn, $sql)) {
        header("Location: penulis.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENAMBAH KATEGORI ---
if (isset($_POST['btn_simpan_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "INSERT INTO kategori_artikel (Nama_Kategori, Keterangan) VALUES ('$nama_kategori', '$keterangan')";

    if (mysqli_query($conn, $sql)) {
        header("Location: kategori.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGUBAH KATEGORI ---
if (isset($_POST['btn_ubah_kategori'])) {
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori_update']);
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "UPDATE kategori_artikel SET Nama_Kategori='$nama_kategori', Keterangan='$keterangan' WHERE kategori_id=$id_kategori";

    if (mysqli_query($conn, $sql)) {
        header("Location: kategori.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGHAPUS KATEGORI ---
if (isset($_POST['btn_hapus_kategori'])) {
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_hapus_kategori']);

    $sql = "DELETE FROM kategori_artikel WHERE kategori_id=$id_kategori";

    if (mysqli_query($conn, $sql)) {
        header("Location: kategori.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENYIMPAN ARTIKEL BARU ---
if (isset($_POST['btn_simpan_artikel'])) {
    // --- Bagian Upload Gambar ---
    $target_dir = "gambar/"; // Folder tempat menyimpan gambar
    // Pastikan folder 'gambar' ada di direktori yang sama dengan 'artikel.php' dan 'function.php'
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Mengecek apakah file gambar asli atau palsu
    if (isset($_POST["btn_simpan_artikel"])) {
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Mengecek apakah file sudah ada
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Membatasi ukuran file (misal: 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) { // 5MB = 5.000.000 bytes
        $uploadOk = 0;
    }

    // Membatasi format file yang diizinkan
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    // Jika $uploadOk masih 0, berarti ada kesalahan
    if ($uploadOk == 0) {
        // Jika ada kesalahan upload, Anda bisa menambahkan notifikasi atau redirect ke halaman error
        // Misalnya: header("Location: artikel.php?upload_error=1");
        // exit();
        // Set data_gambar menjadi kosong jika upload gagal
        $data_gambar = '';
    } else {
        // Jika semuanya OK, coba upload file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // File berhasil diupload
            $data_gambar = mysqli_real_escape_string($conn, $target_file);
        } else {
            // Jika ada kesalahan upload, Anda bisa menambahkan notifikasi atau redirect ke halaman error
            // Misalnya: header("Location: artikel.php?upload_error=2");
            // exit();
            // Set data_gambar menjadi kosong jika upload gagal
            $data_gambar = '';
        }
    }
    // --- Akhir Bagian Upload Gambar ---


    // --- Mengambil Data dari Form ---
    $data_tanggal  = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $data_judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $data_isi      = mysqli_real_escape_string($conn, $_POST['isi']);
    $data_kategori_id = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Mendapatkan ID Penulis dari session
    $data_penulis_ip = $_SESSION['id_penulis'];


    // --- Insert Data Artikel ke Tabel 'artikel' ---
    $sql_insert_artikel = "INSERT INTO artikel (Hari_Tanggal, Judul, Isi_Artikel, Gambar, kategori_id, Penulis_IP)
                           VALUES ('$data_tanggal', '$data_judul', '$data_isi', '$data_gambar', $data_kategori_id, '$data_penulis_ip')";
    $query_insert_artikel = mysqli_query($conn, $sql_insert_artikel);

    if ($query_insert_artikel) {
        header("Location: artikel.php"); // Redirect ke halaman artikel setelah berhasil menyimpan
        exit();
    } else {
        echo "Error: " . $sql_insert_artikel . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGHAPUS DATA ARTIKEL ---
if (isset($_POST['btn_hapus_artikel'])) {
    $id_hapus_artikel = mysqli_real_escape_string($conn, $_POST['id_hapus_artikel']);

    // Dapatkan nama file gambar dari database sebelum menghapus record artikel
    $sql_get_gambar = "SELECT Gambar FROM artikel WHERE id = '$id_hapus_artikel'";
    $result_get_gambar = mysqli_query($conn, $sql_get_gambar);

    $gambar_path = '';
    if ($result_get_gambar && mysqli_num_rows($result_get_gambar) > 0) {
        $row_gambar = mysqli_fetch_assoc($result_get_gambar);
        $gambar_path = $row_gambar['Gambar'];
    }

    // SQL untuk menghapus artikel
    $sql_hapus_artikel = "DELETE FROM artikel WHERE id = '$id_hapus_artikel'";
    $query_hapus_artikel = mysqli_query($conn, $sql_hapus_artikel);

    if ($query_hapus_artikel) {
        // Hapus file gambar dari server jika file tersebut ada dan query berhasil
        if (!empty($gambar_path) && file_exists($gambar_path)) {
            unlink($gambar_path); // Hapus file dari server
        }

        header("Location: artikel.php"); // Redirect ke halaman artikel setelah berhasil menyimpan
        exit();
    } else {
        echo "Error menghapus artikel: " . $sql_hapus_artikel . "<br>" . mysqli_error($conn);
    }
}

// --- LOGIKA UNTUK MENGUBAH DATA ARTIKEL ---
if (isset($_POST['btn_ubah_artikel'])) {
    // --- Bagian Upload Gambar (sama seperti simpan) ---
    $target_dir = "gambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $data_gambar = ''; // Inisialisasi variabel gambar

    // Cek apakah ada file baru yang diupload
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == UPLOAD_ERR_OK) { // Pastikan file terupload tanpa error
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Jika ada file baru diupload, lakukan validasi dan proses upload
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) { $uploadOk = 0; error_log("Gambar: File bukan gambar."); }
        if (file_exists($target_file)) { $uploadOk = 0; error_log("Gambar: File sudah ada."); }
        if ($_FILES["gambar"]["size"] > 5000000) { $uploadOk = 0; error_log("Gambar: Ukuran file terlalu besar."); } // 5MB
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) { $uploadOk = 0; error_log("Gambar: Format file tidak diizinkan."); }

        if ($uploadOk == 0) {
            // Jika upload file baru gagal, tetap ambil gambar lama
            $id_artikel_ubah = mysqli_real_escape_string($conn, $_POST['id_ubah_artikel']);
            $sql_get_old_gambar = "SELECT Gambar FROM artikel WHERE id = '$id_artikel_ubah'";
            $result_get_old_gambar = mysqli_query($conn, $sql_get_old_gambar);
            if ($result_get_old_gambar && mysqli_num_rows($result_get_old_gambar) > 0) {
                $row_old_gambar = mysqli_fetch_assoc($result_get_old_gambar);
                $data_gambar = mysqli_real_escape_string($conn, $row_old_gambar['Gambar']);
            }
            error_log("Gambar: Upload file baru gagal. Menggunakan gambar lama atau kosong.");
        } else {
            // Jika upload file baru berhasil
            $id_artikel_ubah = mysqli_real_escape_string($conn, $_POST['id_ubah_artikel']);
            $sql_get_old_gambar = "SELECT Gambar FROM artikel WHERE id = '$id_artikel_ubah'";
            $result_get_old_gambar = mysqli_query($conn, $sql_get_old_gambar);
            $row_old_gambar = mysqli_fetch_assoc($result_get_old_gambar);
            $old_gambar_path = $row_old_gambar['Gambar'];

            if (!empty($old_gambar_path) && file_exists($old_gambar_path)) {
                unlink($old_gambar_path); // Hapus gambar lama
                error_log("Gambar: Menghapus gambar lama: " . $old_gambar_path);
            }

            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $data_gambar = mysqli_real_escape_string($conn, $target_file);
                error_log("Gambar: File baru berhasil diupload: " . $data_gambar);
            } else {
                // Jika move_uploaded_file gagal (meskipun uploadOk=1), gunakan gambar lama sebagai fallback
                $data_gambar = mysqli_real_escape_string($conn, $old_gambar_path);
                error_log("Gambar: move_uploaded_file gagal. Menggunakan gambar lama: " . $data_gambar);
            }
        }
    } else {
        // Jika tidak ada file baru diupload (error code 4 atau tidak ada input file)
        $id_artikel_ubah = mysqli_real_escape_string($conn, $_POST['id_ubah_artikel']);
        $sql_get_old_gambar = "SELECT Gambar FROM artikel WHERE id = '$id_artikel_ubah'";
        $result_get_old_gambar = mysqli_query($conn, $sql_get_old_gambar);
        $row_old_gambar = mysqli_fetch_assoc($result_get_old_gambar);
        $data_gambar = mysqli_real_escape_string($conn, $row_old_gambar['Gambar']);
        error_log("Gambar: Tidak ada file baru diupload. Menggunakan gambar lama: " . $data_gambar);
    }
    // --- Akhir Bagian Upload Gambar ---

    // --- Mengambil Data dari Form ---
    $id_artikel_ubah = mysqli_real_escape_string($conn, $_POST['id_ubah_artikel']); // ID artikel dari input hidden
    $data_tanggal    = mysqli_real_escape_string($conn, $_POST['tanggal']); // Ini readonly, tetap diambil
    $data_judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $data_isi        = mysqli_real_escape_string($conn, $_POST['isi']); // Ini adalah isi artikel yang sudah kita pastikan tidak kosong
    $data_kategori_id = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Membangun query UPDATE artikel
    $sql_update_artikel = "UPDATE artikel
                           SET
                               Judul = '$data_judul',
                               Isi_Artikel = '$data_isi',
                               Gambar = '$data_gambar',
                               kategori_id = '$data_kategori_id'
                           WHERE id = '$id_artikel_ubah'";

    error_log("SQL Query: " . $sql_update_artikel); // Log SQL query untuk debugging

    $query_update_artikel = mysqli_query($conn, $sql_update_artikel);

    if ($query_update_artikel) {
        error_log("Artikel ID " . $id_artikel_ubah . " berhasil diupdate.");
        header("Location: artikel.php"); // Redirect ke halaman artikel setelah berhasil menyimpan
        exit();
    } else {
        // Tampilkan error jika query gagal
        echo "Error: " . $sql_update_artikel . "<br>" . mysqli_error($conn);
        error_log("Error mengupdate artikel ID " . $id_artikel_ubah . ": " . mysqli_error($conn) . " - Query: " . $sql_update_artikel);
        exit(); // Hentikan eksekusi setelah menampilkan error
    }
}