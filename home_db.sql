-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 05:18 PM
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
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(3, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(4, 'Vandika', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `number`, `message`) VALUES
(1, 'olan', 'asd@gmail.com', '12345', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `order_date`) VALUES
(4, 1, 4, '2025-01-05 09:42:37'),
(5, 1, 5, '2025-01-05 09:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `price` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  `sub_category` varchar(50) NOT NULL,
  `specific_category` varchar(50) NOT NULL,
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `click_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `user_id`, `product_name`, `address`, `price`, `type`, `category`, `sub_category`, `specific_category`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `description`, `date`, `click_count`) VALUES
(4, 1, 'Rumah posisi hook', 'Bandung', '2000000', 'tempat', 'tempat tinggal', 'rumah', '', 'p66Za7df9DQAglC60Yq0.webp', 'M63hyp1fhBB7ijvqe9kN.webp', '6r4KGJrwxrXfiWebAV8l.webp', '', '', 'rumah dengan perabotan lengkap', '2024-12-31', 8),
(5, 1, 'Mobil sport', 'Bojongsoang', '1500000', 'kendaraan', 'kendaraan roda empat', 'mobil', 'lainnya', 'On2Xjgy96ncnFIgBUwwk.jpg', '0d8ydTKhQoZFJJvC0zlm.jpg', 'tmwshLn8Rnp77gZMeRyJ.png', '', '', 'Ferrari F80 adalah supercar edisi terbatas yang menggabungkan teknologi mutakhir dengan performa tinggi.', '2024-12-31', 6),
(6, 1, 'iRobot Braava Jet 240', 'Bandung', '500000', 'barang', 'alat rumah tangga', 'peralatan pembersih', 'alat pel', '4Vu1e8pH3AszzvmDsCXG.webp', 'cBlQXujfhEG2JZwgLuDH.webp', '4dkCVVCU2LKbESbT5AmR.jpg', '', '', 'alat pel otomatis praktis', '2024-12-31', 4),
(7, 1, 'Lahan parkir kendaraan kecil', 'Karawang', '1000000', 'tempat', 'tempat lainnya', 'lahan parkir', 'parkir kendaraan kecil', 'UnmB3t6Ggh249JXOaNIT.jpeg', 'BBhGecrwPPpkBPSqCC15.jpeg', 'zEjN5qSHqzmFr3BIsVUt.jpeg', '', '', 'lahan parkir luas', '2024-12-31', 2),
(8, 1, 'Ballroom Hotel X', 'Tangerang', '2000000', 'tempat', 'tempat acara', 'tempat event dan pesta', 'gedung pernikahan', 'maNzqBZBOAcsaPxPP4pi.jpg', '', '', '', '', 'Masuki suasana mewah di ballroom Hotel X – tempat sempurna untuk acara tak terlupakan! Dengan desain luas tanpa pilar, lampu gantung yang memukau, dan sistem audiovisual modern, ballroom ini ideal untuk pernikahan, pertemuan bisnis, atau perayaan megah. Mampu menampung hingga 200 tamu, ruang elegan ini menawarkan tata letak yang fleksibel serta layanan terbaik untuk memastikan acara Anda menjadi luar biasa.', '2025-01-07', 2),
(9, 1, 'Drone', 'Jakarta', '1000000', 'barang', 'elektronik', 'drone', '', 'MOYcdBc9UTU4OUXa2rdR.jpg', '', '', '', '', 'Ingin mengambil gambar udara yang memukau atau melihat dunia dari sudut berbeda? Drone berkualitas tinggi kami siap untuk fotografi, videografi, dan petualangan seru! 🎥 Dilengkapi dengan kamera HD, kontrol penerbangan yang stabil, dan baterai tahan lama, cocok digunakan baik untuk pemula maupun profesional. Sewa sekarang dan wujudkan kreativitasmu di langit!', '2025-01-07', 0),
(10, 1, 'Karpet 10 x 15m', 'Bukittinggi', '250000', 'barang', 'alat tidur dan furnitur', 'karpet', '', 'qH8f7LbdPtE2BImCETl6.png', '', '', '', '', 'Butuh karpet luas untuk acara spesialmu? Kami menyediakan karpet ukuran 10 x 15 meter yang cocok untuk berbagai keperluan, seperti pesta, pernikahan, atau acara formal lainnya. Karpet berkualitas tinggi, nyaman, dan siap membuat acara kamu lebih berkesan. Hubungi kami sekarang untuk informasi lebih lanjut!', '2025-01-07', 1),
(11, 1, 'Kamera Profesional', 'Bali', '200000', 'barang', 'elektronik', 'kamera', '', 'X1rkE9MqWntQzxeWnNVw.jpg', 'H5J6xTj1IgnVR3aBhSEZ.jpg', '', '', '', 'Abadikan momen terbaikmu dengan kamera profesional berkualitas tinggi! Cocok untuk fotografi, videografi, pre-wedding, atau proyek kreatif lainnya. Dilengkapi dengan fitur canggih dan lensa premium untuk hasil yang memukau. Sewa sekarang dan wujudkan hasil foto impianmu!', '2025-01-07', 1),
(12, 1, 'Kasur Lipat Portable', 'Karawang', '100000', 'barang', 'alat tidur dan furnitur', 'tempat tidur lipat', '', 'piBzdlnrPQaNOn56slhA.jpg', '', '', '', '', 'Butuh tempat tidur praktis dan nyaman? Kami menyediakan kasur lipat portable yang mudah digunakan, cocok untuk tamu, perjalanan, atau camping. Nyaman, ringan, dan hemat ruang, siap menemani kebutuhanmu kapan saja. Sewa sekarang untuk solusi tidur yang praktis!', '2025-01-07', 0),
(13, 1, 'Blender Serbaguna', 'Tangerang', '49999', 'barang', 'alat rumah tangga', 'peralatan dapur', 'blender', 'jfLxXaMy15ZexDHMHkZL.png', '', '', '', '', 'Butuh blender untuk membuat jus, smoothie, atau keperluan dapur lainnya? Kami menyediakan blender berkualitas tinggi yang mudah digunakan dan siap membantu aktivitas memasakmu. Praktis untuk acara keluarga, pesta, atau kebutuhan harian. Sewa sekarang dan nikmati kemudahan di dapur!', '2025-01-07', 0),
(14, 1, 'Sepeda Motor Matic', 'Bandung', '75000', 'kendaraan', 'kendaraan roda dua', 'motor', 'motor matic', 'NuhgKa5ZS2DwDNN5VpPQ.png', '', '', '', '', 'Cari kendaraan praktis untuk mobilitas harian atau liburan? Kami menyediakan sepeda motor matic yang nyaman, irit bahan bakar, dan siap menemani perjalananmu. Cocok untuk berkendara di kota atau jalanan santai. Sewa sekarang untuk perjalanan yang lebih mudah dan menyenangkan!', '2025-01-07', 1),
(15, 1, 'Excavator', 'Tangerang', '8000000', 'kendaraan', 'kendaraan konstruksi', 'alat berat', 'excavator', 'IKStpXubErYyVd8gqUY2.jpeg', '', '', '', '', 'Dukung proyek konstruksi Anda dengan excavator berkualitas! Cocok untuk penggalian, perataan tanah, dan pekerjaan berat lainnya. Mesin handal, operator berpengalaman (opsional), dan siap membantu menyelesaikan pekerjaan dengan efisien.', '2025-01-07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `sender` int(20) NOT NULL,
  `receiver` int(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `product_id`, `sender`, `receiver`, `date`) VALUES
(2, 4, 1, 1, '2025-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`id`, `product_id`, `user_id`) VALUES
(8, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
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
(1, 'olan', '081394234964', 'olan@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '677d23326ef49_absolute cinema.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved`
--
ALTER TABLE `saved`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saved`
--
ALTER TABLE `saved`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
