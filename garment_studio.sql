-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2024 at 06:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `FashionCart`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `user_id` int(11) NOT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`user_id`, `address_line_1`, `address_line_2`, `area`, `city`, `pincode`, `state`, `country`) VALUES
(1, 'Bagalkot', 'Navanagar', '@4 SE', 'bagalkot', '587103', 'KARNATKA', 'INDIA');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `Product_id` int(11) DEFAULT NULL,
  `Image_01` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Product_Name` varchar(255) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `size` varchar(5) NOT NULL,
  `Total_Price` decimal(10,2) DEFAULT NULL,
  `Address_line_1` varchar(255) DEFAULT NULL,
  `Address_line_2` varchar(255) DEFAULT NULL,
  `Area` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Pincode` varchar(20) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `order_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `Order_Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `Payment_Status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(5) NOT NULL,
  `size` varchar(50) NOT NULL,
  `fabric` varchar(20) NOT NULL,
  `stock` int(10) NOT NULL,
  `colors` varchar(50) NOT NULL,
  `original_price` int(10) NOT NULL,
  `offer_price` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `photo` varchar(20) NOT NULL,
  `photo_2` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `size`, `fabric`, `stock`, `colors`, `original_price`, `offer_price`, `description`, `photo`, `photo_2`) VALUES
(1, 'Mens Kurta Shirt', 'Men', 'XS,L', 'Cotton', 30, 'Green, Blue, Cream', 399, 299, 'Nice Fittings, Machin Wash, Hand Wash', 'download.jpeg', '');

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `just_id` int(3) NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `size` varchar(5) DEFAULT NULL,
  `fabric` varchar(20) DEFAULT NULL,
  `subcatebory` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`just_id`, `category`, `size`, `fabric`, `subcatebory`) VALUES
(1, 'Men', 'X', NULL, NULL),
(2, 'Helo', 'S', NULL, NULL),
(3, NULL, 'XS', 'Cotton', NULL),
(4, 'Men', 'L', NULL, NULL),
(5, 'women', 'XL', NULL, NULL),
(6, 'Kids', NULL, NULL, NULL),
(7, NULL, 'Xxl', NULL, NULL),
(8, 'electronics', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `unique_id` int(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`unique_id`, `name`, `email`, `phone`, `password`, `role`) VALUES
(1, 'Shravan HJ', 'Shravanhj@gmail.com', 7406492844, 'fd', 'User'),
(2, 'Shravan HJ', 'Shravanhj@gmail.com', 7406492855, '321', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`just_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `just_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `unique_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
