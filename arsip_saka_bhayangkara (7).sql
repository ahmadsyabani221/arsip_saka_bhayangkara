-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2025 pada 04.12
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

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
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `announcements`
--

INSERT INTO `announcements` (`id`, `text`, `created_at`) VALUES
(1, 'Tes', '2025-01-05 07:54:07'),
(4, 'tes2', '2025-01-05 07:59:33'),
(6, 'tes3', '2025-01-05 11:56:42'),
(7, 'tes4', '2025-01-05 12:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
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
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`id`, `nama_arsip`, `kategori`, `file_path`, `uploaded_by`, `created_at`, `title`) VALUES
(30, 'Surat Undangan Kapolsek Se-Jakut', 'Surat Undangan', '675a59ca1b57b_Undangan Ka Polsek Se Jakut.pdf', 1, '2024-12-11 17:50:25', ''),
(31, 'Surat Izin Orang Tua', 'Surat Izin', '6759c310c0e05_Surat Izin Orang Tua.pdf', 1, '2024-12-11 17:51:28', ''),
(33, 'Surat Undangan Kwarran Se-Jakut', 'Surat Undangan', '675a4d1e7b450_Undangan Ka Kwarran Se Jakut.pdf', 1, '2024-12-12 03:40:30', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip_user`
--

CREATE TABLE `arsip_user` (
  `id` int(11) NOT NULL,
  `arsip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `keterangan`) VALUES
(1, 'Surat Undangan', 'Digunakan untuk mengundang anggota, pembina, atau pihak terkait untuk menghadiri kegiatan, seperti rapat, pertemuan, pelatihan, atau kegiatan lapangan.'),
(5, 'Surat Permohonan', 'Digunakan untuk mengajukan permohonan resmi kepada pihak tertentu, seperti permohonan izin tempat kegiatan, permohonan bantuan fasilitas, atau permohonan dukungan lainnya.'),
(6, 'Surat Keputusan', 'Surat resmi yang dikeluarkan oleh pembina atau pimpinan Saka Bhayangkara untuk menetapkan keputusan terkait kegiatan, pengangkatan anggota, atau kebijakan internal.'),
(7, 'Surat Pemberitahuan', 'Digunakan untuk memberikan informasi resmi kepada anggota atau pihak terkait, seperti jadwal kegiatan, perubahan agenda, atau pengumuman penting lainnya'),
(8, 'Surat Tugas', 'Surat resmi yang diberikan kepada anggota untuk melaksanakan tugas tertentu, seperti menjadi panitia kegiatan, mengikuti pelatihan, atau melakukan pendampingan pada acara tertentu'),
(9, 'Surat Keterangan', 'Surat yang dikeluarkan untuk memberikan keterangan resmi terkait anggota, kegiatan, atau pernyataan tertentu, seperti keterangan telah mengikuti pelatihan atau sertifikasi.'),
(10, 'Surat Laporan', 'Surat yang digunakan untuk melaporkan hasil kegiatan, seperti laporan pelatihan, kegiatan bakti sosial, atau laporan keuangan suatu acara.'),
(11, 'Surat Pelantikan', 'Surat resmi untuk melantik anggota baru atau pengurus baru dalam struktur organisasi Saka Bhayangkara.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin','petugas') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `profile_picture`, `last_login`, `reset_token`, `token_expiry`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'admin', '6779bb9519b8e_logo.png', '2025-01-04 22:15:35', NULL, NULL),
(23, 'DS_BHAYANGKARA RANTING PENJARINGAN', 'db16bb3a71fecf2f9a5e13826eef0bcf', 'DS_BhayangkaraPenjaringan@gmail.com', 'user', NULL, '2025-01-05 10:49:04', NULL, NULL),
(24, 'DS_BHAYANGKARA RANTING PADEMANGAN', '463aec1f471e398a797e8cc3cc71e14d', 'DS_BhayangkaraPademangan@gmail.com', 'user', NULL, '2025-01-05 10:50:27', NULL, NULL),
(25, 'DS_BHAYANGKARA RANTING TANJUNG PRIOK', 'b933168d52eb65e60b27775121eb3539', 'DS_BhayangkaraTanjungPriok@gmail.com', 'user', NULL, '2025-01-05 10:51:21', NULL, NULL),
(26, 'DS_BHAYANGKARA RANTING KOJA', '307cd3496287345f5bc895789437530c', 'DS_BhayangkaraKoja@gmail.com', 'user', NULL, '2025-01-05 10:52:08', NULL, NULL),
(27, 'DS_BHAYANGKARA RANTING CILINCING', '2293ffe457a3f53d58b5e6265b784136', 'DS_BhayangkaraCilincing@gmail.com', 'user', NULL, '2025-01-05 10:53:00', NULL, NULL),
(28, 'DS_BHAYANGKARA RANTING KELAPA GADING', 'd9615cfcf2357c0c66742b62b1b88338', 'DS_BhayangkaraKelapaGading@gmail.com', 'user', NULL, '2025-01-05 10:54:11', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `uploaded_by_2` (`uploaded_by`);

--
-- Indeks untuk tabel `arsip_user`
--
ALTER TABLE `arsip_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_id` (`arsip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `arsip_user`
--
ALTER TABLE `arsip_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `arsip_user`
--
ALTER TABLE `arsip_user`
  ADD CONSTRAINT `arsip_user_ibfk_1` FOREIGN KEY (`arsip_id`) REFERENCES `arsip` (`id`),
  ADD CONSTRAINT `arsip_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
