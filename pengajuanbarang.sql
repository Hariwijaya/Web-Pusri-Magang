-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 12:05 PM
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
-- Database: `pengajuanbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nm_divisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nm_divisi`) VALUES
(1, 'Pemeliharaan'),
(2, 'Teknologi Informasi'),
(3, 'Pengajuan'),
(4, 'Keamanan'),
(5, 'Logistik'),
(6, 'Research and Development');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama`) VALUES
(1, 'SSD'),
(2, 'RAM'),
(3, 'Kabel LAN'),
(5, 'PSU'),
(6, 'Processor'),
(8, 'Tools');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pengajuan` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `nm_pengaju` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `id_divisi`, `nm_barang`, `jumlah`, `tgl_pengajuan`, `status`, `nm_pengaju`, `keterangan`) VALUES
(118, 1, '5', 1, '2024-08-16 19:26:56', 'Disetujui', 'Hari Wijaya', 'upgrade ke SSD NVMe untuk mendukung peningkatan lalu lintas data dan beban kerja yang semakin besar.'),
(119, 2, '3', 1, '2024-12-23 15:58:20', 'Ditolak', 'Hari Wijaya', 'pemakaian pribadi '),
(120, 1, '6', 4, '2024-12-16 20:02:29', 'Disetujui', 'Hari Wijaya', 'untuk penggantian berkala supaya menjaga performa\r\n'),
(122, 2, '4', 1, '2024-12-11 02:09:00', 'Ditolak', 'M ghibran adean', 'butuh penyimpanan baru dikarenakan yang lama sudah rusak'),
(125, 6, '3', 12, '2024-12-11 14:08:36', 'Pending', 'Yusuf Amirudin', 'peningkatan server database di departemen R&D untuk mendukung peningkatan beban kerja aplikasi internal.'),
(129, 2, '2', 50, '2024-12-17 16:17:07', 'Disetujui', 'Hari Wijaya', 'penyimpanan server hampir penuh, perlu diganti sebelum berpengaruh ke performa'),
(130, 2, '3', 1, '2024-12-30 21:27:46', 'Disetujui', 'Hari Wijaya', 'untuk penggantian berkala supaya performa tetap stabil'),
(131, 2, '2', 11, '2025-01-23 21:44:27', 'Pending', 'Hari Wijaya', 'cadangan untuk mengantisipasi kerusakan mendadak atau kebutuhan mendesak lainnya.'),
(132, 2, '3', 12, '2024-12-18 11:16:31', 'Disetujui', 'Hari Wijaya', 'memperbarui'),
(135, 5, '3', 1, '2025-01-07 22:33:10', 'Pending', 'M Ghibran Adean', 'performa melambat dikarenakan ssd yang dipakai adalah ssd versi lama'),
(136, 5, '10', 3, '2025-01-08 00:33:32', 'Disetujui', 'M Ghibran Adean', 'kabel sebelumnya rusak karena digigit tikus'),
(137, 3, '5', 8, '2025-01-08 00:37:15', 'Pending', 'Logan Nord', ' dikarenakan yang sebelumnya sudah usang akibat pemakaian jangka panjang'),
(138, 2, '16', 1, '2025-01-08 00:39:25', 'Disetujui', 'Fahmi Andini', 'beberapa obeng hilang dan butuh obeng baru untuk saat ini'),
(139, 6, '8', 6, '2025-01-08 00:44:38', 'Disetujui', 'Yusuf Akmal', 'Rusak akibat overheat pada CPU'),
(140, 6, '3', 4, '2025-01-08 00:45:26', 'Disetujui', 'Yusuf Akmal', 'beberapa ssd rusak akibat overheat pada cpu'),
(141, 3, '18', 2, '2025-01-08 00:48:35', 'Pending', 'Logan Nord', 'Performa sudah menurun'),
(145, 4, '23', 2, '2025-01-08 20:31:13', 'Pending', 'Lutfi Saputra', 'upgrade processor'),
(146, 4, '5', 4, '2025-01-08 20:31:41', 'Ditolak', 'Lutfi Saputra', 'untuk memenuhi kebutuhan melakukan perakitan pc baru'),
(147, 4, '2', 3, '2025-01-08 20:32:32', 'Ditolak', 'Lutfi Saputra', 'untuk memenuhi kebutuhan melakukan perakitan pc baru'),
(148, 1, '15', 2, '2025-01-08 20:38:01', 'Pending', 'Muhammad Hariqq', ' terdapat beberapa kerusakan pada alat lampu tester'),
(149, 1, '16', 1, '2025-01-08 20:42:43', 'Pending', 'Muhammad Hariqq', 'menambah stok cadangan'),
(150, 1, '3', 8, '2025-01-08 22:36:26', 'Pending', 'Muhammad Hariqq', 'mengganti hard drive di server lama yang mengalami penurunan performa.'),
(151, 3, '13', 3, '2025-01-08 22:37:34', 'Pending', 'muhammad arif', 'kabel terputus '),
(152, 3, '18', 2, '2025-01-09 07:54:06', 'Pending', 'Muzaki Farid', 'sebagai cadangan untuk menjaga performa '),
(153, 5, '13', 2, '2025-01-09 09:32:17', 'Disetujui', 'M Ghibran Adean', 'beberapa kabel rusak, membutuhkan sekitar 9 meter');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nm_pengguna` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `tgl_buat` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin_divisi','approval') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `nm_pengguna`, `email`, `id_divisi`, `tgl_buat`, `password`, `role`, `foto_profil`) VALUES
(8, 'hariwijaya11', 'Hari Wijaya', 'hari@gmail.com', 2, '2024-08-16', '$2y$10$L2D39aUCFycG8X5VOuZaNO8MIxAcarzxtfKEyVp2ndPLiOHKgoSuS', 'super_admin', '../assets/uploads/haripotter.jpg'),
(9, 'gibran11', 'M Ghibran Adean', 'ghibran@gmail.com', 5, '2024-08-28', '$2y$10$CMR27DLTRc.RuKP1n2OEEOFYpjmG/GngbfzOWqCyvJ6.VTwtKTPeW', 'admin_divisi', NULL),
(10, 'nurung93', 'Muhammad Nurung', 'nurunk@gmail.com', 2, '2024-08-29', '$2y$10$2GvOfA8wNZKFFpquLmtsDunUvaR.lWWXMNU14Pb6rikaacDy9fEM.', 'approval', NULL),
(14, 'Zaki', 'Muzaki Farid', 'muzaki@gmail.com', 3, '2024-09-23', '$2y$10$MjprvdP5PjlKxzK3uIcnuewilPewKeqPCc/P7Zb7MQqtoCSO.436W', 'admin_divisi', '../assets/uploads/profile.jpg'),
(15, 'Manager', 'Manager Pembelian', 'manager@gmail.com', 2, '2024-09-23', '$2y$10$YfvUFpIvjAaVQxrhqiuCq.0pKb7NqLBu2mlvyXWP76BswmZCuTuG2', 'approval', NULL),
(16, 'Fahmi', 'Fahmi Andini', 'Mimi@gmail.com', 2, '2024-12-08', '$2y$10$tsD0tszs46XPphUerSjhS.ApXxVyfcUEytG8uvStwiJy9eEwlipU.', 'admin_divisi', ''),
(17, 'arif33', 'muhammad arif', 'arif@gmail.com', 3, '2024-12-09', '$2y$10$PAJTNBrveurthQB1/sv8Bucdg7DEJIfkrRcrq3vdAcAziyY5ojzha', 'admin_divisi', NULL),
(18, 'Lutfi', 'Lutfi Saputra', 'Luffy@gmail.com', 4, '2024-12-11', '$2y$10$ZXzCalKWRnyvXPg7sU2FGeGbKmx36irQpX9qRgaHpXLgfK0eyKi0G', 'admin_divisi', NULL),
(19, 'Akmal', 'Yusuf Akmal', 'yusuf123@gmail.com', 6, '2024-12-11', '$2y$10$xgmwjVKG3kX6DZpzAM41BOEg/eVm5jQG5p/xrVXGYH1MtLZjULki.', 'admin_divisi', NULL),
(30, 'Hariq', 'Muhammad Hariqq', 'hariqq@gmail.com', 1, '2024-12-11', '$2y$10$D.dZm/DxktX6VUzQEX0v.OO23VRIiOg0zzls75jd7dHkumWZn7/AC', 'admin_divisi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sparepart`
--

CREATE TABLE `sparepart` (
  `id_sparepart` int(11) NOT NULL,
  `nm_sparepart` varchar(255) NOT NULL,
  `spesifikasi` text NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` int(11) NOT NULL,
  `tgl_diperbarui` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sparepart`
--

INSERT INTO `sparepart` (`id_sparepart`, `nm_sparepart`, `spesifikasi`, `stok`, `kategori`, `tgl_diperbarui`) VALUES
(2, 'Samsung 970 EVO Plus', 'Kapasitas: 1TB\r\nKecepatan Baca: 3500 MB/s\r\nKecepatan Tulis: 3300 MB/s\r\nInterface: NVMe PCIe M.2', 19, 1, '2025-01-07 14:12:44'),
(3, 'Intel SSD D3-S4510 Series', 'Kapasitas: 960GB\r\nKecepatan Baca: 560 MB/s\r\nKecepatan Tulis: 510 MB/s\r\nInterface: SATA III', 7, 1, '2025-01-07 14:04:38'),
(4, 'Western Digital Ultrastar DC SN640', 'Kapasitas: 3.84TB\r\nKecepatan Baca: 3400 MB/s\r\nKecepatan Tulis: 3000 MB/s\r\nInterface: NVMe PCIe 3.0', 32, 1, '2025-01-07 14:05:16'),
(5, 'Kingston Server Premier DDR4 ECC', 'Kapasitas: 32GB\r\nKecepatan: 3200MHz\r\nTipe: DDR4 ECC', 15, 2, '2025-01-07 14:19:03'),
(6, 'Crucial Ballistix DDR4', 'Kapasitas: 16GB\r\nKecepatan: 3200MHz\r\nTipe: DDR4 Non-ECC', 11, 2, '2025-01-07 14:09:05'),
(8, 'Corsair Vengeance LPX DDR4', 'Kapasitas: 64GB (2x32GB)\r\nKecepatan: 3600MHz\r\nTipe: DDR4 Non-ECC', 5, 2, '2025-01-07 14:09:55'),
(10, 'Cat6a Ethernet Cable (Shielded)', 'Panjang: 10 Meter\r\nKecepatan Transfer: Hingga 10Gbps\r\nShielding: S/FTP (Shielded/Foiled Twisted Pair)\r\n', 18, 3, '2025-01-07 15:17:39'),
(13, 'Cat7 Ethernet Cable', 'Panjang: 15 Meter\r\nKecepatan Transfer: Hingga 40Gbps\r\nShielding: S/FTP', 14, 3, '2025-01-07 15:19:52'),
(14, 'Fiber Optic Cable (Single-Mode)', 'Panjang: 100 Meter\r\nKecepatan Transfer: Hingga 100Gbps', 16, 3, '2025-01-07 15:21:47'),
(15, 'Fluke Networks Cable Tester DSX-5000', 'Penggunaan: Tester jaringan yang digunakan untuk menguji kecepatan kabel Ethernet dan infrastruktur jaringan. Memastikan performa jaringan sesuai standar enterprise.', 50, 8, '2025-01-07 15:23:39'),
(16, 'Obeng Set Professional iFixit Pro Tech Toolkit', 'Jumlah Kepala: 64 Kepala Presisi\r\nMaterial: Baja Stainless\r\nPenggunaan: untuk perbaikan perangkat keras seperti server, laptop, dan perangkat jaringan.', 32, 8, '2025-01-07 15:24:24'),
(17, 'Soldering Iron Hakko FX-888D', 'Penggunaan: Alat solder presisi tinggi untuk pekerjaan elektronik dan perbaikan untuk perawatan perangkat elektronik internal.', 22, 8, '2025-01-07 15:25:44'),
(18, 'Seasonic PRIME TX-850', 'Daya: 850W\r\nSertifikasi: 80 PLUS Titanium\r\nModular: Fully Modular', 23, 5, '2025-01-07 15:27:09'),
(19, 'Corsair HX1200', 'Daya: 1200W\r\nSertifikasi: 80 PLUS Platinum\r\nModular: Fully Modular', 14, 5, '2025-01-07 15:28:05'),
(20, 'Delta Electronics DPS-1600AB', 'Daya: 1600W\r\n', 13, 5, '2025-01-07 15:31:24'),
(21, 'Intel Xeon Gold 6258R', 'Kecepatan Dasar: 2.7 GHz\r\nTurbo Boost: Hingga 4.0 GHz\r\nCore/Thread: 28 Core, 56 Thread\r\nCache: 38.5MB L3 Cache', 16, 6, '2025-01-07 15:37:30'),
(22, 'AMD EPYC 7742', 'Kecepatan Dasar: 2.25 GHz\r\nTurbo Boost: Hingga 3.4 GHz\r\nCore/Thread: 64 Core, 128 Thread\r\nCache: 256MB L3 Cache', 39, 6, '2025-01-07 15:38:06'),
(23, 'Intel Core i9-11900K', 'Kecepatan Dasar: 3.5 GHz\r\nTurbo Boost: Hingga 5.3 GHz\r\nCore/Thread: 8 Core, 16 Thread\r\nCache: 16MB Intel Smart Cache', 54, 6, '2025-01-07 15:40:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `id_divisi` (`id_divisi`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_divisi` (`id_divisi`);

--
-- Indexes for table `sparepart`
--
ALTER TABLE `sparepart`
  ADD PRIMARY KEY (`id_sparepart`),
  ADD KEY `fk_kategori` (`kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sparepart`
--
ALTER TABLE `sparepart`
  MODIFY `id_sparepart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE CASCADE;

--
-- Constraints for table `sparepart`
--
ALTER TABLE `sparepart`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
