-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 03:39 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms_ajy`
--

-- --------------------------------------------------------

--
-- Table structure for table `transport_allotments`
--

DROP TABLE IF EXISTS `transport_allotments`;
CREATE TABLE `transport_allotments` (
  `id` int(11) NOT NULL,
  `packaging_ord_id` int(11) DEFAULT NULL,
  `transport_id` int(11) DEFAULT NULL,
  `transport_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `gstin` varchar(55) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `lr_number` varchar(255) DEFAULT NULL,
  `from_station` int(11) DEFAULT NULL,
  `to_station` int(11) DEFAULT NULL,
  `remark` varchar(555) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `transport_allotments`
--

TRUNCATE TABLE `transport_allotments`;
--
-- Dumping data for table `transport_allotments`
--

INSERT INTO `transport_allotments` (`id`, `packaging_ord_id`, `transport_id`, `transport_name`, `mobile`, `phone`, `email`, `gstin`, `booking_date`, `lr_number`, `from_station`, `to_station`, `remark`, `created`, `status`) VALUES
(1, 1, 19, 'Sanjay Express', NULL, '9804994398', 'sanjay2666@gmail.com', '08AKCPB9383K2ZT', '2023-12-28', 'TRGG587152', 2, 3, 'wqdw', '2023-12-28', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transport_allotments`
--
ALTER TABLE `transport_allotments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transport_allotments`
--
ALTER TABLE `transport_allotments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
