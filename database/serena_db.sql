-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 08:51 AM
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
-- Database: `serena_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_rpjpd`
--

CREATE TABLE `tb_rpjpd` (
  `id_rpjpd` int(11) NOT NULL,
  `th_awal_rpjpd` year(4) NOT NULL,
  `th_akhir_rpjpd` year(4) NOT NULL,
  `status_periode` enum('Aktif','Tidak Aktif') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rpjpd`
--

INSERT INTO `tb_rpjpd` (`id_rpjpd`, `th_awal_rpjpd`, `th_akhir_rpjpd`, `status_periode`, `created_at`, `updated_at`) VALUES
(17, '2010', '2030', 'Aktif', '2024-09-07 21:54:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_rpjpd`
--
ALTER TABLE `tb_rpjpd`
  ADD PRIMARY KEY (`id_rpjpd`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_rpjpd`
--
ALTER TABLE `tb_rpjpd`
  MODIFY `id_rpjpd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
