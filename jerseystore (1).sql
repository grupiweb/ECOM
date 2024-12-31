-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 01:24 PM
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
-- Database: `jerseystore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_item_id` int(255) NOT NULL,
  `produkt_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekip`
--

CREATE TABLE `ekip` (
  `ekip_id` int(11) NOT NULL,
  `ekip_name` varchar(20) NOT NULL,
  `liga_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekip`
--

INSERT INTO `ekip` (`ekip_id`, `ekip_name`, `liga_id`) VALUES
(1, 'Juventus', 1),
(2, 'Milan', 1),
(4, 'Barcelona', 2),
(5, 'PSG', 3),
(6, 'Real Madrid', 2),
(7, 'Inter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `liga`
--

CREATE TABLE `liga` (
  `liga_id` int(11) NOT NULL,
  `liga_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liga`
--

INSERT INTO `liga` (`liga_id`, `liga_name`) VALUES
(1, 'Seria A'),
(2, 'La Liga'),
(3, 'Ligue 1');

-- --------------------------------------------------------

--
-- Table structure for table `produkt`
--

CREATE TABLE `produkt` (
  `produkt_id` int(255) NOT NULL,
  `produkt_name` varchar(100) NOT NULL,
  `produkt_description` varchar(250) NOT NULL,
  `produkt_keywords` varchar(250) NOT NULL,
  `liga_id` int(11) NOT NULL,
  `ekip_id` int(11) NOT NULL,
  `produkt_image1` varchar(250) NOT NULL,
  `produkt_image2` varchar(250) NOT NULL,
  `produkt_image3` varchar(250) NOT NULL,
  `produkt_price` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `produkt_name`, `produkt_description`, `produkt_keywords`, `liga_id`, `ekip_id`, `produkt_image1`, `produkt_image2`, `produkt_image3`, `produkt_price`, `date`, `status`) VALUES
(3, 'Juventus Home Kit', 'Sezoni 24/25', 'juve,juventus,seria a', 1, 1, 'juventus.png', 'juventus2.png', 'juventus3.png', 20.00, '2024-12-21 13:14:27', 'true'),
(7, 'Barcelona Home Kit', 'Sezoni 24/25', 'barca,barcelona', 2, 4, 'barcelona1.png', 'barcelona2.png', 'barcelona3.png', 23.00, '2024-12-31 11:38:52', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(2) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(0, 'admin'),
(1, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(255) NOT NULL,
  `produkt_id` int(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `stock` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `produkt_id`, `size`, `stock`) VALUES
(1, 7, 'S', 3),
(2, 7, 'M', 2),
(3, 7, 'L', 0),
(4, 7, 'XL', 6),
(5, 7, 'XXL', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(2) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `code_expiration` datetime DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `surname`, `foto`, `email`, `password`, `role_id`, `role_name`, `verification_code`, `code_expiration`, `verified`) VALUES
(1, 'usertest', 'Heidi', 'Jemin', '', 'usertest@gmail.com', '$2y$10$f92O6nW8oFCLBvCKNq6uq.IZqqvUZiyI/27gxlzKR7q5jtue1YJsG', 1, 'user', NULL, NULL, 0),
(2, 'userhj', '', '', '', 'userhj@gmail.com', '$2y$10$X7TK1iuV97O.CUlShqDPcu7Nb/KZ6baQeQ/5R0.YVeKyMfXnG74SO', 1, 'user', NULL, NULL, 0),
(3, 'userhjj', '', '', '', 'user44@gmail.com', '$2y$10$4K0Zn66.xEYChaQF6o6jpuFtaO.l5/XPgb4EhlwwzOhE0yiA6b6PW', 1, 'user', NULL, NULL, 0),
(4, 'boli', 'Boli', 'Boli', '', 'boli@gmail.com', '$2y$10$WIPDhBjZ3m43jl2yXAVPrusEq/L36Fo9PSbsass9qlaqfrH6MeE06', 1, 'user', NULL, NULL, 0),
(11, 'testtttttt', 'Aesttttttt', 'Aest', '', 'ddietanley@gmail.com', '$2y$10$ddKjF7wCnW/VZqMhSjj/SOqEVk/gOmEFJpPj8.1M2hx3TZeRgCi.C', 1, 'user', '193504', '2024-12-26 14:40:50', 1),
(12, 'heidijemin', 'Heidi', 'Jemin', '', 'heidijemini1@gmail.com', '$2y$10$3de5R7m3FNrrYkcQy4Frl.U/C7Q/kFSG/9mk2DcvlG.uUYRaXrCPC', 1, 'user', '423289', '2024-12-31 22:44:39', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `SizeToProdukt` (`size_id`),
  ADD KEY `UserInCart` (`user_id`),
  ADD KEY `ProduktInCart` (`produkt_id`);

--
-- Indexes for table `ekip`
--
ALTER TABLE `ekip`
  ADD PRIMARY KEY (`ekip_id`);

--
-- Indexes for table `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`liga_id`);

--
-- Indexes for table `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`produkt_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `SizeToProdukt` (`produkt_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_item_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ekip`
--
ALTER TABLE `ekip`
  MODIFY `ekip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `liga`
--
ALTER TABLE `liga`
  MODIFY `liga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `ProduktInCart` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`),
  ADD CONSTRAINT `UserInCart` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `SizeToProdukt` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
