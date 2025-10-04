-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 02:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
(1, 'Keuangan'),
(2, 'Teknologi Informasi'),
(3, 'Sumber Daya Manusia'),
(4, 'Operasional'),
(5, 'Pemasaran');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `nm_pengaju` varchar(100) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `id_divisi`, `nm_barang`, `jumlah`, `tgl_pengajuan`, `status`, `nm_pengaju`, `keterangan`) VALUES
(76, 1, 'Keuangan', 1, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'uang'),
(77, 2, 'TI', 1, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'TI'),
(78, 3, 'Sumberdaya', 2, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'sumber'),
(79, 1, 'uang', 100, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'seratus lembar'),
(80, 2, 'TI', 1, '2024-09-12', 'Disetujui', 'Hari Wijaya', '1'),
(81, 5, 'Pasar', 11, '2024-09-12', 'Pending', 'Hari Wijaya', '11'),
(82, 4, 'operasi', 1, '2024-09-12', 'Ditolak', 'Hari Wijaya', '1'),
(83, 3, 'SDM', 1, '2024-09-12', 'Disetujui', 'Hari Wijaya', '1'),
(84, 3, 'IQ 190', 10, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'butuh IQ yang besar'),
(85, 4, 'Helm Proyek', 15, '2024-09-12', 'Disetujui', 'Hari Wijaya', 'bbrp helm hilang'),
(86, 2, 'Laptop', 12, '2024-09-12', 'Pending', 'Hari Wijaya', 'untuk acara SRINOVA'),
(87, 5, 'Laptop', 1, '2024-09-12', 'Pending', 'Hari Wijaya', 'untuk membuat desain brand'),
(88, 1, 'duit', 1000000, '2024-09-15', 'Disetujui', 'semut angkrang', 'lagi butuhhi'),
(89, 2, 'apa aja', 1, '2024-09-16', 'Disetujui', 'yanto subroto', '1'),
(90, 2, 'Laptop', 100, '2024-09-16', 'Disetujui', 'yanto subroto', 'buka warnett'),
(91, 1, 'Pena', 1, '2024-09-23', 'Ditolak', 'Hari Wijaya', 'kekurangan pena'),
(92, 1, 'Pena', 1, '2024-09-23', 'Disetujui', 'Hari Wijaya', 'ngetes'),
(93, 3, 'Meja', 10, '2024-09-23', 'Ditolak', 'Hari Wijaya', 'Butuh Meja '),
(94, 1, 'Nota', 10, '2024-09-23', 'Pending', 'Hari Wijaya', 'Restock '),
(95, 4, 'Laptop', 10, '2024-09-23', 'Pending', 'Hari Wijaya', 'untuk karyawan');

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
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) NOT NULL,
  `role` enum('admin_pengelola','admin_divisi','manager_pembelian') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `nm_pengguna`, `email`, `id_divisi`, `tgl_buat`, `aktif`, `password`, `role`) VALUES
(8, 'hari', 'Hari Wijaya', 'hari@gmail.com', 1, '2024-08-16', 1, '$2y$10$DahkYvUqNBctI.aUP6kcu.8aK1MrQhozU.NSFN4ykioGodIfkxAva', 'admin_pengelola'),
(9, 'yanto', 'yanto subroto', 'yanto@gmail.com', 2, '2024-08-28', 1, '$2y$10$CMR27DLTRc.RuKP1n2OEEOFYpjmG/GngbfzOWqCyvJ6.VTwtKTPeW', 'admin_divisi'),
(10, 'Nurung', 'Muhammad Nurung', 'nurunk8j02@gmail.com', 1, '2024-08-29', 1, '$2y$10$2GvOfA8wNZKFFpquLmtsDunUvaR.lWWXMNU14Pb6rikaacDy9fEM.', 'admin_pengelola'),
(11, 'tes', 'tesaja', 'tes@gmail.com', 1, '2024-09-12', 1, '$2y$10$HM8IjfQOiEXxAiIst419tOS8K1vPvH1dmtGAjUDOX0iCqLMUdKd3a', 'manager_pembelian'),
(13, 'pembeli', 'Manager Pembelian', 'apaja@gmail.com', 1, '2024-09-16', 1, '$2y$10$gn6MjU9Pe9c3L1eLRUo1W.lzyvfyZRoes.gfIqt8xLO62e/oH/D1.', 'manager_pembelian'),
(14, 'admindivisi', 'Hari Wijaya', 'admin@gmail.com', 3, '2024-09-23', 1, '$2y$10$MjprvdP5PjlKxzK3uIcnuewilPewKeqPCc/P7Zb7MQqtoCSO.436W', 'admin_divisi'),
(15, 'Manager', 'Manager Pembelian', 'manager@gmail.com', 4, '2024-09-23', 1, '$2y$10$YfvUFpIvjAaVQxrhqiuCq.0pKb7NqLBu2mlvyXWP76BswmZCuTuG2', 'manager_pembelian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
