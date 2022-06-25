-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2020 at 01:09 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roundtab_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `public_donation_users`
--

CREATE TABLE `public_donation_users` (
  `id` int(11) NOT NULL,
  `subscriber` int(11) NOT NULL,
  `stripe_customer` varchar(100) DEFAULT NULL,
  `fname` varchar(150) DEFAULT NULL,
  `lname` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text,
  `state` int(11) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `monthlygift` varchar(225) DEFAULT NULL,
  `donation_date` varchar(224) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `public_donation_users`
--

INSERT INTO `public_donation_users` (`id`, `subscriber`, `stripe_customer`, `fname`, `lname`, `email`, `address`, `state`, `city`, `zip`, `country`, `monthlygift`, `donation_date`, `created`) VALUES
(6, 1, 'cus_HUL9jUDtRIWcMX', 'karanveer', '1', 'karanmehra.km11@gmail.com', 'Plot No C 139 C-139 Phase 8, Industrial Area , Moh', 2, 'Mohali', '160055', 'India', 'canceled', '2020-06-18', '2020-06-18 12:04:11'),
(7, 1, 'cus_HXISExA2jVomSp', 'sahil', '1', 'sahil9256@gmail.com', 'dssd', 18, 'Mohali', '1234567890', 'India', 'monthlygift', '2020-06-26', '2020-06-26 09:28:29'),
(8, 1, 'cus_HXIeF1EUGNPYbq', 'sahil', '1', 'sahil9256@gmail.com', 'dssd', 20, 'Mohali', '1234567890', 'India', ' ', '2020-06-26', '2020-06-26 09:41:17'),
(9, 1, 'cus_HXJMAJstJgRTAq', 'sahil', '1', 'sahil9256@gmail.com', 'dssd', 3, 'Mohali', '1234567890', 'India', ' ', '2020-06-26', '2020-06-26 10:25:02'),
(10, 242, 'cus_HXJNN6pksuGQcu', 'sahil', '1', 'sahil9256@gmail.com', 'dssd', 2, 'Mohali', '1234567890', 'India', ' ', '2020-06-26', '2020-06-26 10:26:16'),
(11, 242, 'cus_HXJP3toJt1vD73', 'sahil', '1', 'sahil9256@gmail.com', 'dssd', 2, 'Mohali', '1234567890', 'India', ' ', '2020-06-26', '2020-06-26 10:28:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `public_donation_users`
--
ALTER TABLE `public_donation_users`
  ADD PRIMARY KEY (`id`,`subscriber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `public_donation_users`
--
ALTER TABLE `public_donation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
