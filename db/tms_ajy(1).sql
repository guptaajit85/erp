-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 02:41 PM
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
-- Table structure for table `packaging_orders`
--

CREATE TABLE `packaging_orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cus_bill_add_id` int(11) NOT NULL,
  `cus_ship_add_id` int(11) NOT NULL,
  `shiping_address` varchar(5555) DEFAULT NULL,
  `billing_address` varchar(5555) DEFAULT NULL,
  `is_invoice_generated` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sale_entry_id` int(11) DEFAULT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packaging_orders`
--

INSERT INTO `packaging_orders` (`id`, `customer_id`, `cus_bill_add_id`, `cus_ship_add_id`, `shiping_address`, `billing_address`, `is_invoice_generated`, `sale_entry_id`, `created`, `modified`, `status`) VALUES
(7, 4, 11, 10, '178/20 Erly Qtr Gulmohar scscdsc Kolkata 245524', '37A G T Road its test scscdsc hooghly 223434', 'Yes', 2, '2023-12-21', '0000-00-00', 1),
(8, 1, 2, 3, 'howrah kolkata scscdsc bhuvneswar 71110112', '37A G T Road its test scscdsc hooghly 223434', 'No', NULL, '2023-12-26', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packaging_order_items`
--

CREATE TABLE `packaging_order_items` (
  `id` int(11) NOT NULL,
  `packaging_ord_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `sale_order_item_id` int(11) DEFAULT NULL,
  `pack_type` int(11) DEFAULT NULL,
  `pack_meter` decimal(10,2) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `pcs` int(11) DEFAULT NULL,
  `cut` int(11) DEFAULT NULL,
  `meter` decimal(10,2) DEFAULT NULL,
  `rate` double(18,2) DEFAULT NULL,
  `amount` double(18,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL,
  `dyeing_color` varchar(255) DEFAULT NULL,
  `coated_pvc` varchar(255) DEFAULT NULL,
  `extra_job` varchar(255) DEFAULT NULL,
  `print_job` varchar(255) DEFAULT NULL,
  `created` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packaging_order_items`
--

INSERT INTO `packaging_order_items` (`id`, `packaging_ord_id`, `sale_order_id`, `sale_order_item_id`, `pack_type`, `pack_meter`, `item_id`, `pcs`, `cut`, `meter`, `rate`, `amount`, `discount`, `discount_amount`, `net_amount`, `dyeing_color`, `coated_pvc`, `extra_job`, `print_job`, `created`, `status`) VALUES
(1, 7, 1, 2, 1, '16.00', 27, 4, 4, '16.00', 6000.00, 96000.00, '20.00', '19200.00', '76800.00', NULL, 'PU Coated', 'Finish Flower', 'Rose Print', '2023-12-21', 1),
(2, 7, 2, 4, 1, '1.00', 27, 1, 1, '1.00', 6000.00, 6000.00, '20.00', '1200.00', '4800.00', NULL, 'PVC Coated', 'setup packaging', 'Animal', '2023-12-21', 1),
(3, 8, 3, 7, 2, '6.00', 32, 2, 3, '6.00', 700.00, 4200.00, '10.00', '420.00', '3780.00', NULL, 'PVC', '', NULL, '2023-12-26', 1),
(4, 8, 4, 9, 1, '1000.00', 32, 10, 50, '1000.00', 700.00, 350000.00, '0.00', '0.00', '350000.00', NULL, 'pu', 'extra', NULL, '2023-12-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packaging_types`
--

CREATE TABLE `packaging_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packaging_types`
--

INSERT INTO `packaging_types` (`id`, `name`, `created`, `modified`, `status`) VALUES
(1, 'Square Box', '2023-12-20', '2023-12-20', 1),
(2, 'Rectangle box', '2023-12-20', '2023-12-20', 1),
(3, 'Roll', '2023-12-20', '2023-12-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_entries`
--

CREATE TABLE `sale_entries` (
  `sale_entry_id` int(11) NOT NULL,
  `packaging_ord_id` int(11) DEFAULT NULL,
  `sale_entry_type_id` int(11) NOT NULL,
  `sale_order_number` varchar(255) NOT NULL,
  `billing_address` text NOT NULL,
  `shipping_address` text NOT NULL,
  `agent_id` varchar(60) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `individual_id` int(11) NOT NULL,
  `sale_entry_on` date NOT NULL,
  `bill_based` varchar(11) NOT NULL,
  `subtotal` float(10,2) NOT NULL,
  `frieght` decimal(10,2) NOT NULL,
  `coupon_discount` decimal(10,2) NOT NULL,
  `total` float(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `executed_by` int(11) NOT NULL,
  `cancel_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_entries`
--

INSERT INTO `sale_entries` (`sale_entry_id`, `packaging_ord_id`, `sale_entry_type_id`, `sale_order_number`, `billing_address`, `shipping_address`, `agent_id`, `customer_name`, `individual_id`, `sale_entry_on`, `bill_based`, `subtotal`, `frieght`, `coupon_discount`, `total`, `status`, `is_deleted`, `created_by`, `modified_by`, `executed_by`, `cancel_by`, `deleted_by`, `created`, `modified`) VALUES
(1, 7, 0, '1001', '37A G T Road its test scscdsc hooghly 223434', '178/20 Erly Qtr Gulmohar scscdsc Kolkata 245524', '', 'Sanjay Customer', 4, '2023-12-26', '', 85680.00, '1212.00', '21124.00', 65768.00, 1, 0, 18, 18, 18, 0, 0, '2023-12-26 10:36:36', '2023-12-26 10:36:36'),
(2, 8, 0, '1002', '37A G T Road its test scscdsc hooghly 223434', 'howrah kolkata scscdsc bhuvneswar 71110112', '', 'Ajy Tech Pvt Ltd', 1, '2023-12-26', '', 371469.00, '0.00', '0.00', 371469.00, 1, 0, 18, 18, 18, 0, 0, '2023-12-26 13:11:33', '2023-12-26 13:11:33'),
(3, 8, 0, '1002', '37A G T Road its test scscdsc hooghly 223434', 'howrah kolkata scscdsc bhuvneswar 71110112', '', 'Ajy Tech Pvt Ltd', 1, '2023-12-26', '', 371469.00, '0.00', '0.00', 371469.00, 1, 0, 18, 18, 18, 0, 0, '2023-12-26 13:12:30', '2023-12-26 13:12:30'),
(4, 8, 0, '1002', '37A G T Road its test scscdsc hooghly 223434', 'howrah kolkata scscdsc bhuvneswar 71110112', '', 'Ajy Tech Pvt Ltd', 1, '2023-12-26', '', 371469.00, '0.00', '0.00', 371469.00, 1, 0, 18, 18, 18, 0, 0, '2023-12-26 13:12:55', '2023-12-26 13:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `sale_entry_items`
--

CREATE TABLE `sale_entry_items` (
  `sale_entry_item_id` int(11) NOT NULL,
  `sale_entry_id` int(11) NOT NULL,
  `packaging_ord_id` int(11) DEFAULT NULL,
  `packaging_ord_item_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `sale_order_item_id` int(11) DEFAULT NULL,
  `pack_type` int(11) DEFAULT NULL,
  `bill_based` varchar(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_return` tinyint(1) NOT NULL DEFAULT 0,
  `unit` varchar(25) DEFAULT NULL,
  `pcs` decimal(10,2) NOT NULL,
  `cut` decimal(10,2) NOT NULL,
  `meter` int(10) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `taxable_amount` double(10,2) DEFAULT NULL,
  `cgstrs` double(10,2) DEFAULT NULL,
  `sgstrs` double(10,2) DEFAULT NULL,
  `igstrs` double(10,2) DEFAULT NULL,
  `cgst` double(10,2) DEFAULT NULL,
  `sgst` double(10,2) DEFAULT NULL,
  `igst` double(10,2) DEFAULT NULL,
  `tax_amount` double(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `dyeing_color` varchar(255) DEFAULT NULL,
  `coated_pvc` varchar(255) DEFAULT NULL,
  `extra_job` varchar(255) DEFAULT NULL,
  `print_job` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_entry_items`
--

INSERT INTO `sale_entry_items` (`sale_entry_item_id`, `sale_entry_id`, `packaging_ord_id`, `packaging_ord_item_id`, `sale_order_id`, `sale_order_item_id`, `pack_type`, `bill_based`, `item_id`, `name`, `total_price`, `is_deleted`, `is_return`, `unit`, `pcs`, `cut`, `meter`, `rate`, `amount`, `discount`, `discount_amount`, `taxable_amount`, `cgstrs`, `sgstrs`, `igstrs`, `cgst`, `sgst`, `igst`, `tax_amount`, `net_amount`, `dyeing_color`, `coated_pvc`, `extra_job`, `print_job`, `remarks`, `status`, `created_by`, `modified_by`, `created`, `modified`) VALUES
(1, 1, 7, 1, 1, 2, 1, '', 27, 'Gene Twill  PU Coated', '80640.00', 0, 0, 'Meter', '4.00', '4.00', 16, '6000.00', '96000.00', '20.00', '19200.00', 76800.00, 1920.00, 1920.00, 3840.00, 2.50, 2.50, 5.00, 3840.00, '80640.00', NULL, NULL, NULL, NULL, '', 1, 1, 1, '2023-12-26', '2023-12-26'),
(2, 1, 7, 2, 2, 4, 1, '', 27, 'Gene Twill  PVC Coated', '5040.00', 0, 0, 'Meter', '1.00', '1.00', 1, '6000.00', '6000.00', '20.00', '1200.00', 4800.00, 120.00, 120.00, 240.00, 2.50, 2.50, 5.00, 240.00, '5040.00', NULL, NULL, NULL, NULL, '', 1, 1, 1, '2023-12-26', '2023-12-26'),
(3, 4, 8, 3, 3, 7, 2, '', 32, 'Silver Checks  PVC', '3969.00', 0, 0, 'Meter', '2.00', '3.00', 6, '700.00', '4200.00', '10.00', '420.00', 3780.00, 94.50, 94.50, 189.00, 3.00, 3.00, 5.00, 189.00, '3969.00', NULL, NULL, NULL, NULL, '', 1, 1, 1, '2023-12-26', '2023-12-26'),
(4, 4, 8, 4, 4, 9, 1, '', 32, 'Silver Checks  pu', '367500.00', 0, 0, 'Meter', '10.00', '50.00', 1000, '700.00', '350000.00', '0.00', '0.00', 350000.00, 8750.00, 8750.00, 17500.00, 3.00, 3.00, 5.00, 17500.00, '367500.00', NULL, NULL, NULL, NULL, '', 1, 1, 1, '2023-12-26', '2023-12-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packaging_orders`
--
ALTER TABLE `packaging_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packaging_order_items`
--
ALTER TABLE `packaging_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packaging_types`
--
ALTER TABLE `packaging_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_entries`
--
ALTER TABLE `sale_entries`
  ADD PRIMARY KEY (`sale_entry_id`);

--
-- Indexes for table `sale_entry_items`
--
ALTER TABLE `sale_entry_items`
  ADD PRIMARY KEY (`sale_entry_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packaging_orders`
--
ALTER TABLE `packaging_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `packaging_order_items`
--
ALTER TABLE `packaging_order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packaging_types`
--
ALTER TABLE `packaging_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_entries`
--
ALTER TABLE `sale_entries`
  MODIFY `sale_entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_entry_items`
--
ALTER TABLE `sale_entry_items`
  MODIFY `sale_entry_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
