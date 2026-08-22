-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 03:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `encon_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_configs`
--

CREATE TABLE `tbl_configs` (
  `id` int(11) NOT NULL,
  `group_field` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `access_by` tinyint(4) NOT NULL COMMENT '3= Developer, 1 = Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_configs`
--

INSERT INTO `tbl_configs` (`id`, `group_field`, `name`, `key`, `value`, `access_by`) VALUES
(1, 'Website Basic', 'Project Name', 'project_name', 'EFS', 1),
(2, 'Rate', 'volumetric_weight_constant', 'volumetric_weight_constant', '5000', 1),
(3, 'Rate', 'air_freight_minimum_kg', 'air_freight_minimum_kg', '10', 1),
(13, 'Rate', 'air_freight_minimum_value', 'air_freight_minimum_value', '500', 1),
(14, 'Rate', 'surface_freight_minimum_kg', 'surface_freight_minimum_kg', '20', 1),
(15, 'Rate', 'surface_freight_minimum_value', 'surface_freight_minimum_value', '300', 1),
(16, 'Rate', 'train_freight_minimum_kg', 'train_freight_minimum_kg', '25', 1),
(17, 'Rate', 'train_freight_minimum_value', 'train_freight_minimum_value', '500', 1),
(18, 'City Display', 'is_display_all_city', 'is_display_all_city', 'No', 1),
(19, 'Rate', 'default_gst_number', 'default_gst_number', '27AABCE7441F1ZS', 1),
(20, 'Rate', 'eway_bill_maximum_limit', 'eway_bill_maximum_limit', '50000', 1),
(21, 'Website Basic', 'PATEL INTEGRATED LOGISTICS LTD', 'invoice_header_name', 'Express Freight System (I) PVT.LTD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module`
--

CREATE TABLE `tbl_module` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_display_user_access` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_module`
--

INSERT INTO `tbl_module` (`id`, `name`, `is_active`, `is_display_user_access`) VALUES
(1, 'all', 1, 0),
(2, 'role', 1, 0),
(3, 'User', 1, 1),
(4, 'Branch', 1, 1),
(5, 'Franchise', 1, 1),
(6, 'Hub', 1, 1),
(7, 'Shipment', 1, 1),
(8, 'DRS Shipment', 1, 1),
(9, 'Customer', 1, 1),
(10, 'Pincode', 1, 1),
(11, 'Manifest', 1, 1),
(12, 'Received Manifest', 1, 1),
(13, 'Vendor', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_main_role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_name`, `created_at`, `is_main_role`) VALUES
(1, 'Super Admin', '2022-10-07 18:22:29', 1),
(2, 'Admin', '2022-10-07 18:22:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles_access`
--

CREATE TABLE `tbl_roles_access` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `create` tinyint(4) NOT NULL DEFAULT 0,
  `edit` tinyint(4) NOT NULL DEFAULT 0,
  `delete` tinyint(4) NOT NULL DEFAULT 0,
  `view_global` int(11) NOT NULL DEFAULT 1,
  `view_own` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_roles_access`
--

INSERT INTO `tbl_roles_access` (`id`, `role_id`, `module_id`, `create`, `edit`, `delete`, `view_global`, `view_own`) VALUES
(1, 1, 1, 1, 1, 0, 1, 1),
(2, 3, 3, 1, 1, 0, 1, 1),
(3, 3, 4, 0, 0, 0, 0, 0),
(4, 3, 5, 0, 0, 0, 0, 0),
(5, 3, 6, 0, 0, 0, 0, 0),
(6, 3, 7, 1, 1, 0, 1, 1),
(7, 3, 8, 1, 1, 0, 1, 1),
(8, 3, 9, 1, 1, 0, 1, 1),
(9, 3, 10, 1, 1, 0, 1, 1),
(10, 3, 11, 1, 1, 0, 1, 1),
(11, 3, 12, 1, 1, 0, 1, 1),
(12, 3, 13, 1, 1, 0, 1, 1),
(13, 3, 14, 0, 0, 0, 0, 0),
(14, 4, 3, 1, 1, 0, 1, 1),
(15, 4, 4, 0, 0, 0, 0, 0),
(16, 4, 5, 0, 0, 0, 0, 0),
(17, 4, 6, 0, 0, 0, 0, 0),
(18, 4, 7, 1, 1, 0, 1, 1),
(19, 4, 8, 0, 0, 0, 0, 0),
(20, 4, 9, 0, 0, 0, 0, 0),
(21, 4, 10, 1, 1, 0, 1, 1),
(22, 4, 11, 0, 0, 0, 0, 0),
(23, 4, 12, 0, 0, 0, 0, 0),
(24, 4, 13, 1, 1, 0, 0, 1),
(25, 4, 14, 0, 0, 0, 0, 0),
(26, 5, 3, 0, 0, 0, 0, 0),
(27, 5, 4, 0, 0, 0, 0, 0),
(28, 5, 5, 0, 0, 0, 0, 0),
(29, 5, 6, 0, 0, 0, 0, 0),
(30, 5, 7, 1, 1, 0, 1, 1),
(31, 5, 8, 0, 0, 0, 0, 0),
(32, 5, 9, 1, 1, 0, 1, 1),
(33, 5, 10, 0, 0, 0, 0, 0),
(34, 5, 11, 0, 0, 0, 0, 0),
(35, 5, 12, 0, 0, 0, 0, 0),
(36, 5, 13, 0, 0, 0, 0, 0),
(37, 5, 14, 0, 0, 0, 0, 0),
(38, 10, 3, 0, 0, 0, 0, 0),
(39, 10, 4, 0, 0, 0, 0, 0),
(40, 10, 5, 0, 0, 0, 0, 0),
(41, 10, 6, 0, 0, 0, 0, 0),
(42, 10, 7, 0, 0, 0, 0, 1),
(43, 10, 8, 0, 0, 0, 0, 0),
(44, 10, 9, 0, 0, 0, 0, 0),
(45, 10, 10, 0, 0, 0, 0, 0),
(46, 10, 11, 0, 0, 0, 0, 0),
(47, 10, 12, 0, 0, 0, 0, 0),
(48, 10, 13, 0, 0, 0, 0, 0),
(49, 10, 14, 0, 0, 0, 0, 0),
(50, 12, 3, 0, 0, 0, 0, 0),
(51, 12, 4, 0, 0, 0, 0, 0),
(52, 12, 5, 0, 0, 0, 0, 0),
(53, 12, 6, 0, 0, 0, 0, 0),
(54, 12, 7, 0, 0, 0, 0, 0),
(55, 12, 8, 1, 1, 0, 1, 1),
(56, 12, 9, 0, 0, 0, 0, 0),
(57, 12, 10, 0, 0, 0, 0, 0),
(58, 12, 11, 0, 0, 0, 0, 0),
(59, 12, 12, 0, 0, 0, 0, 0),
(60, 12, 13, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `contact` bigint(22) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `role_access_id` int(11) DEFAULT NULL,
  `parent_staffid` int(11) NOT NULL,
  `parent_staff_role` int(11) NOT NULL DEFAULT 0,
  `notification_token` text DEFAULT NULL,
  `otp_number` int(11) DEFAULT NULL,
  `is_otp_verified` tinyint(4) DEFAULT NULL COMMENT '1: verified  0:Not Verified',
  `api_token` varchar(500) DEFAULT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `deleted_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `contact`, `address`, `email`, `password`, `image`, `role_id`, `role_access_id`, `parent_staffid`, `parent_staff_role`, `notification_token`, `otp_number`, `is_otp_verified`, `api_token`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super', 'admin', 1234567890, 'nashik', 'superadmin@gmail.com', '123456', NULL, 1, 1, 0, 0, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZWdfdHlwZSI6IjEiLCJyZWdfaWQiOiIxIiwicmVnX2VtYWlsIjoic3VwZXJhZG1pbkBnbWFpbC5jb20iLCJyZWdfbmFtZSI6InN1cGVyIEFkbWluIiwia2V5Ijo1NzQyMTJ9.93fhliHGPYccLIDJwXiyJbsZNQ4cHO2bLglznyVON4Q', 1, NULL, NULL, '2022-11-14 14:36:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `country_id`, `state_id`, `city_id`, `created_at`) VALUES
(1, 2, 101, 4008, 133024, '2023-03-03 13:15:03'),
(2, 3, 101, 4008, 133504, '2023-03-03 14:04:36'),
(3, 4, 101, 4008, 133024, '2023-03-03 15:50:27'),
(4, 5, 101, 4008, 133504, '2023-03-03 16:03:04'),
(5, 6, 101, 4008, 133504, '2023-03-03 16:13:40'),
(6, 7, 101, 4008, 133024, '2023-03-03 16:19:21'),
(7, 8, 101, 4008, 133504, '2023-03-03 16:24:15'),
(8, 9, 101, 4008, 133504, '2023-03-03 16:25:51'),
(9, 10, 101, 4008, 133024, '2023-03-03 16:32:02'),
(10, 11, 101, 4008, 133024, '2023-03-03 16:33:33'),
(11, 12, 101, 4008, 131746, '2023-03-03 19:21:30'),
(12, 13, 101, 4008, 133024, '2023-03-08 17:27:06'),
(13, 14, 101, 4008, 133504, '2023-03-09 12:34:54'),
(14, 15, 101, 4008, 133504, '2023-03-09 14:58:28'),
(15, 16, 101, 4008, 133177, '2023-03-16 14:25:08'),
(16, 17, 101, 4008, 57689, '2023-03-16 14:31:53'),
(17, 18, 101, 4008, 133024, '2023-03-16 14:34:07'),
(18, 19, 101, 4008, 133177, '2023-03-16 14:47:44'),
(19, 20, 101, 4008, 133177, '2023-03-16 14:54:02'),
(20, 21, 101, 4008, 133178, '2023-03-16 14:55:42'),
(21, 22, 101, 4008, 133177, '2023-03-16 15:03:35'),
(22, 23, 101, 4008, 133177, '2023-03-17 19:22:56'),
(23, 24, 101, 4008, 133177, '2023-03-17 19:26:25'),
(24, 25, 101, 4008, 133177, '2023-03-20 12:53:12'),
(25, 26, 101, 4008, 133504, '2023-03-20 19:44:33'),
(26, 27, 101, 4008, 132214, '2023-03-23 14:59:14'),
(27, 28, 101, 4008, 132214, '2023-03-23 16:35:59'),
(28, 29, 101, 4008, 132214, '2023-03-23 16:45:36'),
(29, 30, 101, 4008, 132214, '2023-03-23 17:19:44'),
(30, 31, 101, 4021, 131679, '2023-03-24 15:29:23'),
(31, 32, 101, 4021, 131679, '2023-03-24 15:31:33'),
(32, 33, 101, 4021, 131679, '2023-03-24 15:35:47'),
(33, 34, 101, 4021, 131679, '2023-03-24 15:37:21'),
(34, 35, 101, 4021, 131679, '2023-03-24 15:39:16'),
(35, 36, 101, 4008, 147751, '2023-04-07 16:44:42'),
(36, 37, 101, 4010, 132162, '2023-04-13 17:59:45'),
(37, 38, 101, 4010, 132162, '2023-04-13 18:03:00'),
(38, 39, 101, 4008, 133505, '2023-05-09 17:22:54'),
(39, 40, 101, 4008, 133177, '2023-05-12 10:58:13'),
(40, 41, 101, 4008, 133177, '2023-05-12 10:58:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_configs`
--
ALTER TABLE `tbl_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_module`
--
ALTER TABLE `tbl_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles_access`
--
ALTER TABLE `tbl_roles_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_configs`
--
ALTER TABLE `tbl_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_module`
--
ALTER TABLE `tbl_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_roles_access`
--
ALTER TABLE `tbl_roles_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
