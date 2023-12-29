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
-- Table structure for table `transports`
--

DROP TABLE IF EXISTS `transports`;
CREATE TABLE `transports` (
  `id` int(11) NOT NULL,
  `individual_id` int(11) NOT NULL DEFAULT 0,
  `station` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `transports`
--

TRUNCATE TABLE `transports`;
--
-- Dumping data for table `transports`
--

INSERT INTO `transports` (`id`, `individual_id`, `station`, `created_by`, `modified_by`, `created`, `modified`, `status`) VALUES
(1, 14, 'kolkata', 1, 1, '2023-08-16 14:15:02', '2023-08-16 14:15:02', 1),
(2, 14, 'Kolkata', 1, 1, '2023-08-16 14:38:43', '2023-08-16 14:38:43', 1),
(3, 14, 'Surat', 1, 1, '2023-08-16 14:37:42', '2023-08-16 14:37:42', 1),
(4, 14, 'mumbai', 1, 1, '2023-08-17 10:22:11', '2023-08-17 10:22:11', 1),
(5, 14, 'kolkata', 1, 1, '2023-08-25 09:55:02', '2023-08-25 09:55:02', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transports`
--
ALTER TABLE `transports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
