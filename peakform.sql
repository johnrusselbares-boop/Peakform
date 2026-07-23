-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 21, 2026 at 04:27 PM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peakform`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(1, 1, 4, 9, '2026-07-07 03:27:35'),
(2, 1, 2, 4, '2026-07-07 03:27:49'),
(3, 1, 6, 3, '2026-07-07 03:30:01'),
(4, 1, 1, 3, '2026-07-07 03:39:16'),
(5, 1, 5, 3, '2026-07-07 03:40:31'),
(6, 1, 3, 3, '2026-07-07 03:55:06'),
(14, 2, 3, 3, '2026-07-08 03:41:51'),
(13, 2, 2, 5, '2026-07-08 03:40:25'),
(12, 4, 2, 1, '2026-07-08 03:26:12'),
(15, 2, 4, 1, '2026-07-08 03:41:52'),
(16, 6, 2, 8, '2026-07-21 02:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `fullname` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `payment` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `fullname`, `address`, `contact`, `payment`) VALUES
(1, 2, 3800.00, 'Pending', '2026-07-08 02:19:15', '', '', '', ''),
(2, 4, 15400.00, 'Pending', '2026-07-08 03:16:59', '', '', '', ''),
(3, 5, 0.00, 'Pending', '2026-07-21 02:25:32', 'Shaira', 'Barobo', '09129700060', 'Credit Card'),
(4, 5, 0.00, 'Pending', '2026-07-21 02:47:37', 'Shaira', 'Manila', '09129700060', 'Cash on Delivery'),
(5, 5, 1600.00, 'Pending', '2026-07-21 02:49:17', 'Shaira', 'manila', '09129700060', 'Cash on Delivery'),
(6, 5, 0.00, 'Pending', '2026-07-21 02:53:47', 'Shaira', 'cavite', '09129700060', 'Cash on Delivery'),
(7, 5, 400.00, 'Pending', '2026-07-21 02:57:39', 'Shaira', 'cavite', '09129700060', 'Cash on Delivery'),
(8, 5, 400.00, 'Pending', '2026-07-21 02:57:50', 'Shaira', 'cavite', '09129700060', 'Cash on Delivery'),
(9, 5, 400.00, 'Pending', '2026-07-21 02:59:58', 'Shaira', 'cavite', '09129700060', 'Cash on Delivery'),
(10, 5, 400.00, 'Pending', '2026-07-21 03:00:15', 'Shaira', 'cavite', '09129700060', 'Debit Card'),
(11, 5, 2600.00, 'Pending', '2026-07-21 03:01:03', 'Shaira', 'Malabon', '09129700060', 'Maya'),
(12, 5, 2200.00, 'Pending', '2026-07-21 03:07:03', 'Shaira', 'Notre', '09129700060', 'GCash'),
(13, 5, 4150.00, 'Processing', '2026-07-21 15:49:17', 'JOHN RUSSEL', 'DE', '09129700060', 'GCash'),
(14, 5, 4150.00, 'Shipped', '2026-07-21 16:26:35', 'JOHN RUSSEL', 'Sa malapit', '09129700060', 'Debit Card');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 700.00),
(2, 1, 2, 4, 400.00),
(3, 1, 3, 1, 1500.00),
(4, 2, 3, 10, 1500.00),
(5, 2, 2, 1, 400.00),
(6, 5, 2, 4, 400.00),
(7, 9, 2, 1, 400.00),
(8, 10, 2, 1, 400.00),
(9, 11, 2, 1, 400.00),
(10, 11, 1, 1, 700.00),
(11, 11, 3, 1, 1500.00),
(12, 12, 4, 1, 300.00),
(13, 12, 3, 1, 1500.00),
(14, 12, 2, 1, 400.00),
(15, 13, 7, 2, 650.00),
(16, 13, 6, 1, 850.00),
(17, 13, 9, 2, 1000.00),
(18, 14, 7, 2, 650.00),
(19, 14, 5, 1, 900.00),
(20, 14, 6, 1, 850.00),
(21, 14, 8, 1, 1100.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 100,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `stock`) VALUES
(1, 'Angel Ark Compression Shirt', 700.00, 'prod1.jpg', 'Compression Shirt', 50),
(2, 'Captain America Compression Shirt', 400.00, 'prod2.jpg', 'Compression Shirt', 50),
(3, 'Youngla Compression', 1500.00, 'prod3.jpg', 'Premium Compression', 50),
(4, 'Muscle Up Compression Shirt', 300.00, 'prod4.jpg', 'Training Shirt', 50),
(5, 'Youngla Demon V1', 900.00, 'prod5.jpg', 'Oversized Shirt', 50),
(6, 'Gymshark Onyx', 850.00, 'prod6.jpg', 'Gym Wear', 50),
(7, 'Amper Sweat Absorbant Shirt', 650.00, 'prod7.jpg', 'Sweat Absorbant', 50),
(8, 'Nike Pro Compression Shirt', 1100.00, 'prod8.jpg', 'Nike Compression', 50);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `review`, `created_at`) VALUES
(1, 5, 2, 12, 5, 'Maganda', '2026-07-21 03:29:47'),
(2, 5, 4, 12, 3, 'mainit', '2026-07-21 03:35:03'),
(3, 5, 2, 12, 4, 'pawisin', '2026-07-21 03:35:15'),
(4, 5, 3, 12, 5, 'sarap', '2026-07-21 03:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`) VALUES
(2, 'Shaira', 'Marie', 'russel@gmail.com', '$2y$10$7s31bx10HCV2.e5nDXe/8eradCznCVVM5e5P5Azsje72eb6dymUcu', '2026-07-08 02:11:22'),
(3, 'Russel', 'Bares', 'shai@gmail.com', '$2y$10$8FKgOS.nW7Ej1nv2jZveiOEdXBbsuuD3ZfpuQN7Grg8ZB7dXf8eWS', '2026-07-08 02:55:26'),
(4, 'Janssen', 'Torres', 'Janssen@gmail.com', '$2y$10$rllMPbdv3KARwuBSNMbCoOfFckrG05O5YvUy4FkfYgUjfmnRPB4ya', '2026-07-08 02:56:34'),
(5, 'Shaira', 'Marie', 'ha@gmail.com', '$2y$10$8oy63D7oLgM5ZEhubjYDReh0OOJRJCJ5Xu.Skq585HEbFB7ejuJse', '2026-07-21 02:24:56');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
