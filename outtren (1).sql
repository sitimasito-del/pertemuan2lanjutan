-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 08:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `outtren`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '12345678#'),
(2, 'admin', 'bcbc93a39ba88bd1e21b10005f659eb5');

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `nama_alat`) VALUES
(1, 'Tenda'),
(2, 'Carrier'),
(3, 'Sleeping Bag');

-- --------------------------------------------------------

--
-- Table structure for table `alat_varian`
--

CREATE TABLE `alat_varian` (
  `id` int(11) NOT NULL,
  `alat_id` int(11) NOT NULL,
  `varian` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `alat_varian`
--

INSERT INTO `alat_varian` (`id`, `alat_id`, `varian`, `harga`, `stok`) VALUES
(1, 1, '2 Orang', 30000, 5),
(2, 1, '3 Orang', 35000, 5),
(3, 1, '4 Orang', 40000, 5),
(4, 2, '35 L', 20000, 5),
(5, 2, '45 L', 40000, 5),
(6, 3, 'Ukuran 35', 20000, 5),
(7, 3, 'Ukuran 40', 45000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `jaminan` varchar(50) DEFAULT NULL,
  `status` enum('baru','dipinjam','selesai') DEFAULT 'baru',
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `nama`, `whatsapp`, `tgl_pinjam`, `tgl_kembali`, `jaminan`, `status`, `total`) VALUES
(8, 'nella', '08223345', '2025-12-02', '2025-01-13', 'KTP', 'selesai', 0),
(9, 'amel', '7654321', '2025-12-12', '2026-01-12', 'KTP', 'selesai', 0),
(11, 'tata', '0987654321', '2025-12-30', '2025-12-31', 'KTM', 'selesai', 0);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_detail`
--

CREATE TABLE `peminjaman_detail` (
  `id` int(11) NOT NULL,
  `peminjaman_id` int(11) NOT NULL,
  `alat_varian_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `peminjaman_detail`
--

INSERT INTO `peminjaman_detail` (`id`, `peminjaman_id`, `alat_varian_id`, `harga`) VALUES
(4, 8, 3, 40000),
(5, 9, 1, 30000),
(7, 11, 2, 35000),
(8, 11, 4, 20000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alat_varian`
--
ALTER TABLE `alat_varian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alat_id` (`alat_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_id` (`peminjaman_id`),
  ADD KEY `alat_varian_id` (`alat_varian_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alat_varian`
--
ALTER TABLE `alat_varian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat_varian`
--
ALTER TABLE `alat_varian`
  ADD CONSTRAINT `alat_varian_ibfk_1` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`);

--
-- Constraints for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `peminjaman_detail_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`),
  ADD CONSTRAINT `peminjaman_detail_ibfk_2` FOREIGN KEY (`alat_varian_id`) REFERENCES `alat_varian` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
