-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 01:48 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topup_diamond_ml`
--

-- --------------------------------------------------------

--
-- Table structure for table `ml_diamond`
--

CREATE TABLE `ml_diamond` (
  `id_diamond` int(11) NOT NULL,
  `jumlah_diamond` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ml_diamond`
--

INSERT INTO `ml_diamond` (`id_diamond`, `jumlah_diamond`, `harga`) VALUES
(1, 20, '20000.00'),
(2, 30, '30000.00'),
(4, 40, '40000.00'),
(5, 50, '50000.00'),
(7, 60, '60000.00'),
(8, 70, '70000.00'),
(9, 80, '80000.00'),
(10, 90, '90000.00'),
(13, 200, '100000.00'),
(14, 345, '123333.00');

-- --------------------------------------------------------

--
-- Table structure for table `ml_pembelian`
--

CREATE TABLE `ml_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_diamond` int(11) NOT NULL,
  `tanggal_pembelian` datetime DEFAULT current_timestamp(),
  `status` enum('pending','berhasil','gagal') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ml_pembelian`
--

INSERT INTO `ml_pembelian` (`id_pembelian`, `id_user`, `id_diamond`, `tanggal_pembelian`, `status`) VALUES
(92, 4, 1, '2025-01-19 18:03:27', 'berhasil'),
(93, 2, 4, '2025-01-19 18:26:52', 'gagal'),
(94, 4, 2, '2025-01-19 18:27:18', 'berhasil'),
(95, 4, 1, '2025-01-19 18:41:07', 'berhasil'),
(96, 4, 13, '2025-01-19 19:30:41', 'berhasil'),
(97, 6, 13, '2025-01-19 19:58:10', 'berhasil'),
(98, 7, 13, '2025-01-19 20:00:08', 'berhasil');

-- --------------------------------------------------------

--
-- Table structure for table `ml_transaksi`
--

CREATE TABLE `ml_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `status_pembayaran` enum('menunggu','dibayar','gagal') DEFAULT 'menunggu',
  `tanggal_transaksi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ml_transaksi`
--

INSERT INTO `ml_transaksi` (`id_transaksi`, `id_pembelian`, `jumlah_pembayaran`, `status_pembayaran`, `tanggal_transaksi`) VALUES
(89, 92, '20000.00', 'dibayar', '2025-01-19 18:03:27'),
(90, 93, '40000.00', 'gagal', '2025-01-19 18:26:52'),
(91, 94, '30000.00', 'dibayar', '2025-01-19 18:27:18'),
(92, 95, '20000.00', 'dibayar', '2025-01-19 18:41:07'),
(93, 96, '100000.00', 'dibayar', '2025-01-19 19:30:41'),
(94, 97, '100000.00', 'dibayar', '2025-01-19 19:58:10'),
(95, 98, '100000.00', 'dibayar', '2025-01-19 20:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `ml_user`
--

CREATE TABLE `ml_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','pengguna') DEFAULT 'pengguna',
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ml_user`
--

INSERT INTO `ml_user` (`id_user`, `username`, `password`, `email`, `role`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$SE1w1X4yZi2bv85z69Ow.OuaOuAyLJ4.Ye/8NGTTdU5iz8HEc.WMm', 'a@gmail.com', 'admin', 'admin satu'),
(2, 'user', '$2y$10$EBLo.7vzGP7L3.GgSobk.OD6Tv4X.rcIKh1zI8UwrsZ7M.9wrEmyC', 'user@gmail.com', 'pengguna', 'user1'),
(4, 'Arjun', '$2y$10$UGlIQKzAbtn6VqOMa39CXOblsF04vdXd7DF0px7N3p7dNwWmdl.x.', 'arjun@gmail.com', 'pengguna', 'user2'),
(5, 'kepin', '$2y$10$/FC0bFa27V1tfhL9JsQIxehz8bTZBm9LZT43Z8BRiuaMn39dPkFJy', 'k@gmail.com', 'pengguna', 'kepin kece'),
(6, 'agung', '$2y$10$KJ6i4aMwh6tWRm1ShzDbNu6Nb7frCROtBpc/STNy3lOo./mfAgh6S', 'ww@gmail.com', 'pengguna', 'agung ganteng'),
(7, 'anjay', '$2y$10$1WD83vLkMyolV.K92oy0Gu7.XTRc6c/0/Mg7.0IAEXRlLBHkNfwYy', 'ee@gmail.com', 'pengguna', 'anjay kece');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ml_diamond`
--
ALTER TABLE `ml_diamond`
  ADD PRIMARY KEY (`id_diamond`);

--
-- Indexes for table `ml_pembelian`
--
ALTER TABLE `ml_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_diamond` (`id_diamond`);

--
-- Indexes for table `ml_transaksi`
--
ALTER TABLE `ml_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pembelian` (`id_pembelian`);

--
-- Indexes for table `ml_user`
--
ALTER TABLE `ml_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ml_diamond`
--
ALTER TABLE `ml_diamond`
  MODIFY `id_diamond` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ml_pembelian`
--
ALTER TABLE `ml_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `ml_transaksi`
--
ALTER TABLE `ml_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `ml_user`
--
ALTER TABLE `ml_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ml_pembelian`
--
ALTER TABLE `ml_pembelian`
  ADD CONSTRAINT `ml_pembelian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `ml_user` (`id_user`),
  ADD CONSTRAINT `ml_pembelian_ibfk_2` FOREIGN KEY (`id_diamond`) REFERENCES `ml_diamond` (`id_diamond`);

--
-- Constraints for table `ml_transaksi`
--
ALTER TABLE `ml_transaksi`
  ADD CONSTRAINT `ml_transaksi_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `ml_pembelian` (`id_pembelian`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
