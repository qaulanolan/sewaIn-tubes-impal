-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 01:13 PM
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
-- Database: `home_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('BcjKNX58e4x7bIqIvxG7', 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `price` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `user_id`, `product_name`, `address`, `price`, `type`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `description`, `date`) VALUES
('CLHgmSORjF4FnMxRvuLc', '2kjuuLmAbCPEXx6NvUfY', 'W11', 'Bandung', '99999999', 'kendaraan', 'vOW8WUEdHbpSH1w2kQf9.jpg', 'hkpuf34R1hJDKCdqG1oA.jpg', 'v2B7onGlXfHSuo9DTioO.jpg', '', '', 'Mercedes-AMG F1 W11 EQ Performance adalah sebuah mobil balap Formula Satu yang didesain dan dibangun oleh tim Mercedes-AMG Petronas F1 untuk berkompetisi di musim balap Formula Satu 2020. Mobil ini dikenal sangat dominan di musim tersebut dan berhasil membawa tim Mercedes meraih gelar juara dunia konstruktor dan pembalap (diraih oleh Lewis Hamilton).', '2024-12-07'),
('rYGN7cF8yBCOHleHR2xo', '2kjuuLmAbCPEXx6NvUfY', 'Ferrari F80', 'bubat', '1000', 'kendaraan', '5XuTYwgPJjPKjTPy8S7h.jpg', 'gWJf8pc2vqeynmKrP5Ea.png', 'nlJb21kmOb1VcDU3JUFF.jpg', '', '', 'Ferrari F80 adalah sebuah hypercar yang dirilis oleh pabrikan Italia ternama, Ferrari. Mobil ini hadir sebagai puncak dari inovasi dan teknologi yang dimiliki Ferrari, memadukan performa ekstrem dengan desain yang sangat aerodinamis.', '2024-12-07'),
('Dwk1qMDmyfJk6Qy0E7vR', 'pvzRQ5VyBCi3IZ7zWoni', 'tes', 'bdg', '11', 'barang', '40nD44DYcXolxjdvw2dA.png', '', '', '', '', 'tes', '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `product_id`, `sender`, `receiver`, `date`) VALUES
('9NmbXfG6twkk9Id2IpJd', 'CLHgmSORjF4FnMxRvuLc', '2kjuuLmAbCPEXx6NvUfY', '2kjuuLmAbCPEXx6NvUfY', '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `password`, `profile_pic`) VALUES
('2kjuuLmAbCPEXx6NvUfY', 'a', '123', 'a@gmail.com', 'f10e2821bbbea527ea02200352313bc059445190', '6753f6737b571_me.png'),
('pvzRQ5VyBCi3IZ7zWoni', 'olan', '81394234964', 'olan2@gmail.com', 'f10e2821bbbea527ea02200352313bc059445190', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
