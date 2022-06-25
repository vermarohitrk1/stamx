-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2020 at 01:08 PM
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
-- Table structure for table `public_donation_orders`
--

CREATE TABLE `public_donation_orders` (
  `id` int(11) NOT NULL,
  `subscriber` int(11) NOT NULL,
  `stripe_customer` varchar(225) NOT NULL,
  `pdonation_users_id` int(11) NOT NULL,
  `tranaction_id` varchar(150) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `monthlygift` varchar(225) DEFAULT NULL,
  `donation_date` varchar(224) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `public_donation_orders`
--

INSERT INTO `public_donation_orders` (`id`, `subscriber`, `stripe_customer`, `pdonation_users_id`, `tranaction_id`, `amount`, `status`, `monthlygift`, `donation_date`, `created`) VALUES
(5, 1, 'cus_HUL9jUDtRIWcMX', 6, 'ch_1GvMTW2tryTVhHnceWAwfSoO', '120', 'Paid', 'canceled', '2020-06-18', '2020-06-18 12:04:11'),
(6, 1, 'cus_HXISExA2jVomSp', 7, 'ch_1GyDrE2tryTVhHnchohatDkj', '10', 'Paid', 'monthlygift', '2020-06-26', '2020-06-26 09:28:29'),
(7, 1, 'cus_HXIeF1EUGNPYbq', 8, 'ch_1GyE3d2tryTVhHncSSnyxyY4', '10', 'Paid', ' ', '2020-06-26', '2020-06-26 09:41:17'),
(8, 1, 'cus_HXJMAJstJgRTAq', 9, 'ch_1GyEjy2tryTVhHncfqERpwou', '10', 'Paid', ' ', '2020-06-26', '2020-06-26 10:25:02'),
(9, 242, 'cus_HXJNN6pksuGQcu', 10, 'ch_1GyElALzuboJY1BXzx40slWe', '10', 'Paid', ' ', '2020-06-26', '2020-06-26 10:26:16'),
(10, 242, 'cus_HXJP3toJt1vD73', 11, 'ch_1GyEn7LzuboJY1BX7aUsptf1', '10', 'Paid', ' ', '2020-06-26', '2020-06-26 10:28:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `public_donation_orders`
--
ALTER TABLE `public_donation_orders`
  ADD PRIMARY KEY (`id`,`subscriber`,`pdonation_users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `public_donation_orders`
--
ALTER TABLE `public_donation_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
