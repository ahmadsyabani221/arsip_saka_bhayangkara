-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 06:21 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip_saka_bhayangkara`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `profile_picture`) VALUES
(1, 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id` int(11) NOT NULL,
  `nama_arsip` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `arsip`
--

INSERT INTO `arsip` (`id`, `nama_arsip`, `kategori`, `file_path`, `uploaded_by`, `created_at`, `title`) VALUES
(30, 'Surat Undangan Kapolsek Se-Jakut', 'Surat Undangan', '675a59ca1b57b_Undangan Ka Polsek Se Jakut.pdf', 1, '2024-12-11 17:50:25', ''),
(31, 'Surat Izin Orang Tua', 'Surat Izin', '6759c310c0e05_Surat Izin Orang Tua.pdf', 1, '2024-12-11 17:51:28', ''),
(33, 'Surat Undangan Kwarran Se-Jakut', 'Surat Undangan', '675a4d1e7b450_Undangan Ka Kwarran Se Jakut.pdf', 1, '2024-12-12 03:40:30', ''),
(34, 'Surat Undangan Kapolres Se-Jakut', 'Surat Undangan', '675a4e7e97b53_Surat Izin Orang Tua.pdf', 1, '2024-12-12 03:46:22', ''),
(40, 'hehehe', 'Surat Izin', '675dbfa51504c_836-Article Text-1522-1-10-20200330.pdf', 1, '2024-12-14 18:25:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `arsip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `download_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `keterangan`) VALUES
(1, 'Surat Undangan', NULL),
(2, 'Surat Pelantikan', NULL),
(3, 'Surat Undangan', 'contoh surat undangan');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(256) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `username`, `password`, `email`, `profile_picture`) VALUES
(1, 'Petugas1', '44d2401a78939038860244ab96c9aab1', 'Petugas@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin','petugas') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `profile_picture`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'admin', '675d6e3a8b343_6034ad9f8264f.jpg'),
(5, 'Dewan Saka Bhayangkara Polsek Kelapa Gading', 'd9615cfcf2357c0c66742b62b1b88338', 'DewanSakaBhayangkaraKelapaGading@gmail.com', 'user', NULL),
(6, 'Dewan Saka Bhayangkara Polsek Pademangan', 'a29611d74d728fdf69816313f2115679', 'DewanSakaBhayangkaraPademangan@gmail.com', 'user', NULL),
(7, 'Dewan Saka Bhayangkara Polsek Tanjung Priok', '$2y$10$1QXqT/EN/L3EiO6FVtw/RerghjZz6/nZpjLSTwDBA4O/HCeeHwyoe', 'DewanSakaBhayangkaraTanjungPriok@gmail.com', 'user', NULL),
(8, 'Dewan Saka Bhayangkara Polsek Penjaringan', '$2y$10$yGFnBz2feqATlIT7sU7BkO4YiYsM3YYK/DZG4nbY.v6/00vtgZLIS', 'DewanSakaBhayangkaraPenjaringan@gmail.com', 'user', NULL),
(15, 'bani', '497a333d611f80dfddb5407f81632a85', 'ahmadsya_bani221@yahoo.com', 'user', '675c058cac5ac__BICYCLE FOLDING 16 INCH PARROT 3 SPEED.jpg'),
(16, 'rizqi', 'a2ff141ca614b73fb00ce18d96bd56b3', 'coba@gmail.com', 'user', '675c5715bee3a__BICYCLE FOLDING 16 INCH PARROT 3 SPEED.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `uploaded_by_2` (`uploaded_by`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_id` (`arsip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
