-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 01:59 PM
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
-- Database: `farmasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `expired` date NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(3) NOT NULL,
  `harga` int(7) NOT NULL,
  `nama_obat` varchar(36) NOT NULL,
  `foto_obat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `expired`, `deskripsi`, `stok`, `harga`, `nama_obat`, `foto_obat`) VALUES
(3, '0000-00-00', 'Menurunkan tekanan darah pada penderita hipertensi. Obat ini juga bisa dimanfaatkan dalam pengobatan nyeri dada kronis (angina pektoris) akibat penyakit jantung koroner. Amlodipine dapat digunakan sebagai obat tunggal atau dikombinasikan dengan obat lain.', 91, 10000, 'Amlodipine', '78x6fdfsyp8fr13132hqb5xbr2gkkmaq.webp'),
(7, '0000-00-00', 'da', 30, 25000, 'Aprazolam', '14902368693070184.png'),
(9, '0000-00-00', 'Fentanyl adalah obat penghilang rasa sakit yang sangat kuat, termasuk dalam kelas opioid sintetis.Harus digunakan dengan hati-hati karena potensinya tinggi, dapat menyebabkan efek samping dan ketergantungan. Hanya digunakan di bawah pengawasan medis untuk menghindari risiko overdosis dan dampak negatif lainnya. ', 4, 320000, 'Fentanyl', '5174219481367964.jpeg'),
(11, '0000-00-00', 'Morfium adalah obat penghilang rasa sakit yang termasuk dalam kelas opioid. Ini digunakan untuk mengelola nyeri berat, seperti setelah operasi atau kondisi medis serius. Morfium bekerja dengan merubah cara otak merespons rasa sakit. Penting untuk digunakan sesuai petunjuk dokter karena dapat menyebabkan efek samping dan memiliki potensi ketergantungan. ', 68, 190000, 'Morphine', 'morphine_addiction-scaled-2.jpeg'),
(13, '0000-00-00', 'Furosemide adalah diuretik yang digunakan untuk mengatasi retensi cairan yang terkait dengan berbagai kondisi medis, seperti gagal jantung, edema, atau tekanan darah tinggi. Obat ini bekerja dengan meningkatkan pengeluaran air dan garam melalui urine, membantu mengurangi volume cairan di dalam tubuh.', 55, 3000, 'Furosemide', 'apotek_online_k24klik_201804171137074677_furosemid-kf.jpg'),
(14, '2028-01-11', 'Bronkodilator yang digunakan untuk merelaksasi otot di saluran udara dan meningkatkan aliran udara ke dalam paru-paru. Ini termasuk dalam kelas obat yang disebut beta-agonis. Albuterol digunakan untuk mengatasi gejala penyakit paru obstruktif kronis (COPD) dan asma. ', 30, 280000, 'Albuterol', 'ventolin-hfa-albuterol-sulfate-90mcg-200-metered-inhalations-42.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `tanggal_pembelian`, `total_pembelian`) VALUES
(2, '2023-12-06', 250000),
(28, '2024-01-10', 320000),
(29, '2024-01-10', 0),
(30, '2024-01-10', 0),
(31, '2024-01-10', 0),
(32, '2024-01-10', 828000),
(33, '2024-01-10', 828000),
(34, '2024-01-10', 828000),
(35, '2024-01-10', 828000),
(79, '2024-06-18', 0),
(80, '2024-06-18', 0),
(81, '2024-06-18', 0),
(82, '2024-06-18', 0),
(83, '2024-06-18', 0),
(84, '2024-06-18', 0),
(85, '2024-06-18', 0),
(86, '2024-06-18', 0),
(87, '2024-06-18', 0),
(88, '2024-06-18', 0),
(89, '2024-06-18', 0),
(90, '2024-06-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_penjualan` int(11) NOT NULL,
  `jumlah_obat` int(3) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `id_pembelian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_penjualan`, `jumlah_obat`, `tanggal`, `id_obat`, `id_pembelian`) VALUES
(2, 1, '2023-12-06', 3, 2),
(4, 1, '2024-01-10', 3, 28),
(5, 1, '2024-01-10', 3, 29),
(6, 1, '2024-01-10', 3, 30),
(7, 1, '2024-01-10', 3, 31);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(10) NOT NULL,
  `username` text DEFAULT NULL,
  `nama` text NOT NULL,
  `telepon` varchar(12) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `nama`, `telepon`, `password`, `admin`) VALUES
(1, 'SoF4rAway', 'Farid', '0', '$2y$10$QKSZNosx6V3YgwttKxU2yuYesPkr4O25wcf1nZxKCReSHlekXUFCa', 1),
(2, 'admin', 'Admin', NULL, '$2y$10$SF30wq2tCUf9HCecea9wB.d49hI1mm5pD3FaNmtIg3I.HB/EWpMS2', 1),
(5, 'f4r', 'Muhammad Farid Rahman', '082129295903', '$2y$10$yu.WlvNj53dt0oN0hFd6Vu54nW/yYPbLkNVGVh3jALQswY.gsW5DC', 0);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_penjualan`),
  ADD KEY `fk_penjualan_obat` (`id_obat`),
  ADD KEY `fk_pembelian_produk_pembelian` (`id_pembelian`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `no_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `fk_pembelian_produk_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`),
  ADD CONSTRAINT `fk_penjualan_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
