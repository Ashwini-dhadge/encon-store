-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 29, 2023 at 01:36 PM
-- Server version: 8.0.34
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efsindia_uat`
--

-- --------------------------------------------------------

--
-- Table structure for table `view_calculate_vendor_bill`
--

CREATE TABLE `view_calculate_vendor_bill` (
  `total_to_pay_cash` double(19,2) DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `billing_type` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view_customer_wallet_balance`
--

CREATE TABLE `view_customer_wallet_balance` (
  `customer_id` bigint DEFAULT NULL,
  `balance` decimal(33,0) DEFAULT NULL,
  `totalAdded` decimal(32,0) DEFAULT NULL,
  `totalSubtract` decimal(32,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view_get_customer_used_credit_limit`
--

CREATE TABLE `view_get_customer_used_credit_limit` (
  `final_amount` double(19,2) DEFAULT NULL,
  `shipper_cust_id` int DEFAULT NULL,
  `id` int DEFAULT NULL,
  `credit_min_limit_amount` float(10,2) DEFAULT NULL,
  `credit_max_limit_amount` float(10,2) DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
