-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2026 at 06:22 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lumea_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int NOT NULL,
  `id_pesanan` varchar(20) NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`) VALUES
(1, 'LUM-59876', 4, 1),
(2, 'LUM-44448', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_toko`
--

CREATE TABLE `konfigurasi_toko` (
  `id` int NOT NULL,
  `link_banner` varchar(255) NOT NULL,
  `deskripsi_footer` text NOT NULL,
  `email_toko` varchar(100) NOT NULL,
  `telepon_toko` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `konfigurasi_toko`
--

INSERT INTO `konfigurasi_toko` (`id`, `link_banner`, `deskripsi_footer`, `email_toko`, `telepon_toko`) VALUES
(1, 'bg-mawar.jpg', 'Luméa Perfume adalah merek wewangian independen yang berdedikasi untuk menciptakan aroma elegan dengan sentuhan personal. Kami percaya bahwa setiap aroma menyimpan kenangan.', 'hello@lumeaperfume.com', '+62 812 3456 7890');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(20) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `alamat_penerima` text NOT NULL,
  `total_bayar` int NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_pesanan` varchar(50) DEFAULT 'Sedang Dikemas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `username`, `nama_penerima`, `alamat_penerima`, `total_bayar`, `metode_pembayaran`, `tanggal_pesan`, `status_pesanan`) VALUES
('LUM-44448', 'Rahma', 'Rahma Fitria', 'Jalan Soekarno Hatta, Pekanbaru, Riau (HP: 081234567812)', 44000, 'Gopay', '2026-07-14 17:10:47', 'Sedang Dikemas');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `harga` int NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `kategori`, `tag`, `harga`, `deskripsi`, `gambar`, `status`) VALUES
(2, 'Meadow', 'FEMININE', 'Strongly Floral', 35000, 'Perpaduan bunga liar dan jasmine yang menghadirkan aroma floral yang lembut, elegan, dan cocok menemani aktivitas sehari-hari.', 'uploads/botol.jpg', 'BEST SELLER'),
(3, 'Lavanda', 'ANY GENDER', 'Calming', 35000, 'Aroma lavender yang dipadukan dengan vanilla menciptakan sensasi menenangkan, nyaman, dan cocok digunakan kapan saja.', 'uploads/botol.jpg', 'NORMAL'),
(4, 'Neroli', 'FEMININE', 'Deep & Sweet', 35000, 'Wangi neroli berpadu citrus manis menghasilkan aroma hangat, feminin, dan memberikan kesan anggun sepanjang hari.', 'uploads/botol.jpg', 'NORMAL'),
(5, 'Ocean Musk', 'MASCULINE', 'Fresh & Clean', 35000, 'Perpaduan aroma laut dan white musk yang memberikan kesan segar, bersih, dan maskulin tanpa terasa berlebihan.', 'uploads/botol.jpg', 'NORMAL'),
(6, 'Peony Blush', 'FEMININE', 'Soft & Romantic', 39000, 'Kombinasi peony, rose, dan pear menghadirkan aroma manis yang lembut dengan sentuhan romantis dan elegan.', 'uploads/botol.jpg', 'NORMAL'),
(7, 'Cedar Noir', 'MASCULINE', 'Woody & Bold', 35000, 'Perpaduan cedarwood, black pepper, dan amber yang menghadirkan karakter maskulin, tegas, dan berkelas.', 'uploads/botol.jpg', 'NORMAL'),
(8, 'Midnight Ember', 'MASCULINE', 'Warm & Smooky', 39000, 'Kombinasi sandalwood, leather, dan vanilla menghasilkan aroma hangat dengan sentuhan smoky yang elegan.', 'uploads/botol.jpg', 'NEW RELEASE'),
(9, 'Vanilla Bloom', 'ANY GENDER', 'Warm & Cozy', 35000, 'Vanilla creamy dipadukan orchid dan sandalwood menciptakan aroma hangat, lembut, dan nyaman sepanjang hari.', 'uploads/botol.jpg', 'BEST SELLER'),
(10, 'Moon Petal', 'ANY GENDER', 'Powdery & Soft', 35000, 'White lily, musk, dan cotton blossom menghadirkan aroma bersih, lembut, dan tahan lama untuk segala suasana.', 'uploads/botol.jpg', 'NORMAL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'Rahma', '$2y$10$dhhws83jCEnWZ4OZQS6b2eqmzoOC5HkA9DGQrsMrCrv1/oIziMrA2', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `konfigurasi_toko`
--
ALTER TABLE `konfigurasi_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konfigurasi_toko`
--
ALTER TABLE `konfigurasi_toko`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
