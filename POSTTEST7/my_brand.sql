-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 06:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_brand`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `username`, `password`, `email`) VALUES
(3, 'davin', '$2y$10$B/sInZ.hVM14tfzGkmV.Juu9SqPMqSQD69zKJf8eoiuBO4Eh3uPo2', 'Davina@gmail.com'),
(4, 'Lala', '$2y$10$Wgzaa3Kj2q/rvoB6h7sUZOqvCglg2uLR6KMFLAiARjAtJNEpFoQAW', 'lala@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `deskripsi`, `harga`, `gambar`, `created_at`) VALUES
(3, 'LANEIGE Water Bank Blue Hyaluronic Moisturizer', 'A lush cream that visibly firms, strengthens skin\'s moisture barrier, and delivers replenishing, long lasting hydration.', 650.00, 'moist laneige.jpg', '2024-10-15 02:42:37'),
(4, 'White Truffle First Spray Serum', 'Descubre el lujo en cada gota con el D\'Alba White Truffle First Spray Serum, un tratamiento esencial que combina lo mejor de la naturaleza y la ciencia. Enriquecido con valiosa trufa blanca de Italia, este sérum hidratante y nutritivo está diseñado para revitalizar tu piel desde el primer uso, dejándola suave, radiante y saludable. ', 1200000.00, 'alba.jpg', '2024-10-15 02:45:19'),
(6, 'Essence de Soin Visage Sk-Ii 230Ml', 'L\'essence de traitement du visage SK-II contient plus de 90 pour cent de pitera, le composant de beauté efficace unique et bien connu de SK-II pour renouveler la peau, stimuler l\'hydratation et lutter contre le vieillissement cutané. Sans colorant, sans parfum et non testé sur les animaux', 1300000.00, '2024-10-15 10.33.27.jpg', '2024-10-15 08:33:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
