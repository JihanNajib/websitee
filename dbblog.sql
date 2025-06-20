-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 02:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `Hari_Tanggal` datetime NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Isi_Artikel` text NOT NULL,
  `Gambar` varchar(255) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `Penulis_IP` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `Hari_Tanggal`, `Judul`, `Isi_Artikel`, `Gambar`, `kategori_id`, `Penulis_IP`) VALUES
(2, '2024-03-02 14:30:00', 'Tutorial Python Dasar', 'Python adalah bahasa pemrograman serbaguna yang mudah dipelajari oleh pemula. Dalam tutorial ini, kita akan mempelajari sintaks dasar, struktur kontrol, fungsi, dan pengenalan ke pustaka populer seperti NumPy dan Pandas untuk analisis data.', 'python.jpg', 2, '192.168.1.2'),
(3, '2024-03-03 09:45:00', 'Manfaat Berolahraga Pagi', 'Olahraga pagi tidak hanya menyegarkan tubuh tetapi juga membantu meningkatkan metabolisme, mengurangi stres, dan meningkatkan kualitas tidur. Rutin berolahraga di pagi hari dapat memperbaiki mood dan konsentrasi sepanjang hari.', 'sport.jpg', 4, '192.168.1.3'),
(4, '2024-03-04 17:20:00', '5 Destinasi Wisata Murah', 'Ingin liburan hemat? Berikut lima destinasi wisata murah yang bisa dikunjungi tanpa menguras dompet, mulai dari pantai tersembunyi di Indonesia hingga kota bersejarah di Asia Tenggara dengan biaya hidup rendah.', 'travel.jpg', 5, '192.168.1.4'),
(5, '2024-03-05 12:10:00', 'Resep Makanan Sehat', 'Coba resep makanan sehat berikut yang kaya nutrisi dan rendah kalori. Resep termasuk smoothie hijau, sup quinoa sayur, dan salad buah segar dengan dressing alami tanpa gula tambahan.', 'food.jpg', 6, '192.168.1.5'),
(6, '2024-03-06 15:00:00', 'Tips Investasi untuk Pemula', 'Mulai investasi sejak dini bisa membantu mencapai kebebasan finansial. Artikel ini memberikan panduan tentang jenis-jenis investasi, manajemen risiko, serta kesalahan umum yang perlu dihindari bagi investor pemula.', 'finance.jpg', 8, '192.168.1.6'),
(7, '2024-03-07 11:30:00', 'Film Terbaru 2024', 'Tahun 2024 dipenuhi dengan film menarik dari berbagai genre. Mulai dari blockbuster Hollywood, film animasi keluarga, hingga drama Korea yang emosional. Temukan daftar film yang layak masuk watchlist kamu.', 'movies.jpg', 9, '192.168.1.7'),
(8, '2024-03-08 08:00:00', 'Penemuan Baru dalam Sains', 'Ilmuwan di berbagai bidang telah menemukan metode baru dalam terapi gen, teknologi energi terbarukan, dan pengembangan vaksin mRNA. Penemuan ini membawa dampak signifikan bagi masa depan kesehatan dan lingkungan.', 'science.jpg', 10, '192.168.1.1'),
(9, '2024-03-09 16:45:00', 'Tren Teknologi di 2024', 'Tahun 2024 akan didominasi oleh tren teknologi seperti AI generatif, metaverse, keamanan siber, dan edge computing. Organisasi global mulai mengadopsi teknologi ini untuk meningkatkan efisiensi dan layanan.', 'tech_trend.jpg', 1, '192.168.1.2'),
(10, '2024-03-10 13:25:00', 'Belajar HTML dan CSS', 'HTML dan CSS adalah fondasi dari pengembangan web. Artikel ini menjelaskan struktur dasar halaman web, penggunaan tag-tag HTML penting, serta teknik CSS untuk tata letak dan styling modern.', 'html_css.jpg', 2, '192.168.1.3'),
(11, '2024-03-11 10:10:00', 'Tips Hidup Sehat', 'Hidup sehat dimulai dari kebiasaan kecil seperti menjaga pola makan, tidur cukup, aktif bergerak, dan mengelola stres. Artikel ini juga mencakup tips praktis untuk mengatur waktu dan menjaga kesehatan mental.', 'health.jpg', 3, '192.168.1.4'),
(12, '2024-03-12 18:30:00', 'Analisis Liga Champions', 'Laga Liga Champions musim ini mempertemukan tim-tim besar Eropa. Artikel ini membahas performa klub, analisis statistik pertandingan, dan prediksi peluang juara berdasarkan data dan form terkini.', 'ucl.jpg', 4, '192.168.1.5'),
(13, '2024-03-13 09:50:00', 'Wisata Alam Terbaik', 'Alam menyimpan keindahan luar biasa. Artikel ini menyajikan daftar wisata alam terbaik di dunia, termasuk pegunungan bersalju, danau berwarna, dan hutan hujan tropis yang cocok untuk pelancong pencinta alam.', 'nature.jpg', 5, '192.168.1.6'),
(14, '2024-03-14 14:40:00', 'Kuliner Khas Indonesia', 'Indonesia dikenal dengan keberagaman kulinernya. Dari rendang Padang hingga gudeg Yogyakarta, artikel ini mengeksplorasi cita rasa tradisional dan sejarah di balik makanan khas dari berbagai daerah.', 'indonesian_food.jpg', 6, '192.168.1.7'),
(15, '2024-03-15 16:15:00', 'Strategi Menabung Efektif', 'Mengelola keuangan pribadi bisa dimulai dengan strategi menabung yang efektif. Temukan teknik budgeting, pentingnya dana darurat, dan tips agar tidak boros dalam pengeluaran sehari-hari.', 'saving.jpg', 8, '192.168.1.1'),
(16, '2024-03-16 11:55:00', 'Drama Korea Populer', 'Drama Korea kini makin digemari berkat alur cerita yang kuat dan produksi berkualitas tinggi. Artikel ini mengulas judul-judul drama terpopuler 2024 beserta sinopsis dan keunggulannya.', 'kdrama.jpg', 9, '192.168.1.2'),
(17, '2024-03-17 07:45:00', 'Eksperimen Fisika Menarik', 'Pelajari eksperimen fisika sederhana yang bisa dilakukan di rumah. Dari hukum Newton hingga elektromagnetik, aktivitas ini cocok untuk pelajar dan pencinta sains yang ingin belajar dengan cara menyenangkan.', 'physics.jpg', 10, '192.168.1.3'),
(18, '2024-03-18 19:20:00', 'Blockchain dan Masa Depan', 'Blockchain tidak hanya digunakan untuk kripto, tapi juga memiliki potensi di sektor logistik, perbankan, dan kesehatan. Artikel ini membahas bagaimana blockchain dapat mengubah cara kita menyimpan dan memverifikasi data.', 'blockchain.jpg', 8, '192.168.1.4'),
(19, '2024-03-19 12:30:00', 'Belajar Java untuk Pemula Kita', 'Java adalah bahasa pemrograman yang banyak digunakan di industri. Artikel ini memberikan panduan langkah demi langkah untuk memulai coding dengan Java, mencakup konsep OOP, sintaks dasar, dan praktik terbaik.', 'java.jpg', 2, '192.168.1.5'),
(20, '2024-03-20 17:00:00', 'Fakta Unik tentang Alam Semesta Kita', 'Alam semesta menyimpan banyak misteri. Artikel ini membahas fakta-fakta menakjubkan seperti materi gelap, lubang hitam, dan asal mula Big Bang yang terus menjadi pusat penelitian astrofisika.', 'universe.jpg', 4, '192.168.1.6');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `kategori_id` int(11) NOT NULL,
  `Nama_Kategori` varchar(100) NOT NULL,
  `Keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`kategori_id`, `Nama_Kategori`, `Keterangan`) VALUES
(1, 'Teknologi', 'Artikel terkait perkembangan teknologi terbaru'),
(2, 'Pemrograman', 'Tutorial dan berita seputar pemrograman'),
(3, 'Kesehatan', 'Tips dan info seputar kesehatan'),
(4, 'Olahraga', 'Berita dan analisis dunia olahraga'),
(5, 'Travel', 'Destinasi wisata menarik di berbagai negara'),
(6, 'Kuliner', 'Rekomendasi makanan dan minuman enak'),
(7, 'Edukasi', 'Artikel pendidikan dan pembelajaran'),
(8, 'Keuangan', 'Tips investasi dan finansial'),
(9, 'Hiburan', 'Berita selebriti, film, dan musik'),
(10, 'Sains', 'Penelitian dan penemuan ilmiah terbaru kan');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `IP` varchar(45) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Nama_Lengkap` varchar(100) NOT NULL,
  `Pswd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`IP`, `Email`, `Nama_Lengkap`, `Pswd`) VALUES
('192.168.1.1', 'johndoe@gmail.com', 'John Doe', '482c811da5d5b4bc6d497ffa98491e38'),
('192.168.1.2', 'janedoe@gmail.com', 'Jane Doe', '2e248e7a3b4fbaf2081b3dff10ee402b'),
('192.168.1.3', 'alicew@gmail.com', 'Alice Williams', '6f4d64d8e668470ee4a70063a8f02bb3'),
('192.168.1.4', 'bobm@gmail.com', 'Bob Marley', '3dbc281dac46c23977e31cb42eb23ee2'),
('192.168.1.5', 'charliep@gmail.com', 'Charlie Parker', 'ad319dbc63d687f4f9623bd28157ae89'),
('192.168.1.6', 'davids@gmail.com', 'David Smith', '3e35d1025659d07ae28e0069ec51ab92'),
('192.168.1.7', 'emilyj@gmail.com', 'Emily Johnson ha', '2bef40281b29e91652f8d6a4e14d2cab');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `Penulis_IP` (`Penulis_IP`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`IP`),
  ADD UNIQUE KEY `Username` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_artikel` (`kategori_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `artikel_ibfk_2` FOREIGN KEY (`Penulis_IP`) REFERENCES `penulis` (`IP`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
