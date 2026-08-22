-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2022 at 01:14 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_efs1`
--
CREATE DATABASE IF NOT EXISTS `db_efs1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_efs1`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_document`
--

CREATE TABLE IF NOT EXISTS `tbl_branch_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `document_image` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_branch_document`
--

INSERT INTO `tbl_branch_document` (`id`, `user_id`, `document_image`, `is_active`) VALUES
(1, 3, 'doc_img_1668520884.jpg', 1),
(2, 3, 'doc_img_16685208841.jpg', 1),
(3, 3, 'doc_img_16685208842.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_pincode`
--

CREATE TABLE IF NOT EXISTS `tbl_branch_pincode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `pincode_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_branch_pincode`
--

INSERT INTO `tbl_branch_pincode` (`id`, `branch_id`, `pincode_id`, `created_at`) VALUES
(1, 3, 1, '2022-11-21 16:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_profile`
--

CREATE TABLE IF NOT EXISTS `tbl_branch_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:branch 2:hub 3:Franchise',
  `area` text,
  `gst_number` varchar(100) DEFAULT NULL,
  `adhar_number` varchar(100) DEFAULT NULL,
  `pan_number` varchar(100) DEFAULT NULL,
  `tan_number` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `ifsc_code` varchar(100) DEFAULT NULL,
  `detail_address` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_branch_profile`
--

INSERT INTO `tbl_branch_profile` (`id`, `user_id`, `country_id`, `state_id`, `city_id`, `type`, `area`, `gst_number`, `adhar_number`, `pan_number`, `tan_number`, `account_number`, `bank_name`, `ifsc_code`, `detail_address`, `created_at`) VALUES
(1, 3, 101, 4008, 133177, 1, 'Panchavati', '12345', '1234567', '1233455', '123444', 'account', 'bank name', 'sadds', ' sdsfdsf                                                                                                                                                             ', '2022-11-15 19:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_configs`
--

CREATE TABLE IF NOT EXISTS `tbl_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_field` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `access_by` tinyint(4) NOT NULL COMMENT '3= Developer, 1 = Admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_configs`
--

INSERT INTO `tbl_configs` (`id`, `group_field`, `name`, `key`, `value`, `access_by`) VALUES
(1, 'Website Basic', 'Project Name', 'project_name', 'EFS', 1),
(2, 'Shipment', 'Volumetric Weight Constant', 'volumetric_weight_constant', '5000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_unique_id` varchar(100) NOT NULL,
  `name` varchar(500) NOT NULL,
  `customer_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1:Company  2:Individule',
  `contact` bigint(22) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `parent_staffid` int(11) NOT NULL,
  `parent_staff_role` int(11) NOT NULL DEFAULT '0',
  `notification_token` text,
  `otp_number` int(11) DEFAULT NULL,
  `is_otp_verified` tinyint(4) DEFAULT NULL COMMENT '1: verified  0:Not Verified',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `api_token` text,
  `created_by` int(11) unsigned NOT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `deleted_by` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `customer_unique_id`, `name`, `customer_type`, `contact`, `address`, `email`, `password`, `image`, `role_id`, `parent_staffid`, `parent_staff_role`, `notification_token`, `otp_number`, `is_otp_verified`, `is_active`, `api_token`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', 'HDFC Bank', 2, 9527380090, 'HDFC Bank Nashik Branch', 'hdfc@nashik.com', '123456', NULL, 10, 1, 1, '1', NULL, NULL, 0, NULL, 1, NULL, NULL, '2022-11-23 04:59:44', NULL, NULL),
(2, '', 'COSMOS Bank', 2, 9527380090, 'Cosmos Bank Nashik Branch', 'cosmos@nashik.com', '123456', NULL, 10, 1, 1, '1', NULL, NULL, 0, NULL, 1, NULL, NULL, '2022-11-23 04:59:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_profile`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) DEFAULT NULL,
  `contact_person_name` varchar(500) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `customer_category` varchar(3) NOT NULL DEFAULT 'A',
  `pan_number` varchar(20) DEFAULT NULL,
  `tan_number` varchar(20) DEFAULT NULL,
  `gst_number` varchar(20) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `description` text,
  `payment_type_id` int(11) NOT NULL,
  `billing_schedule` tinyint(4) NOT NULL,
  `credit_min_limit_amount` float(10,2) DEFAULT NULL,
  `credit_max_limit_amount` float(10,2) DEFAULT NULL,
  `credit_period` int(11) DEFAULT NULL,
  `credit_period1` int(11) DEFAULT NULL,
  `billing_format` tinyint(4) DEFAULT '2',
  `billing_address` varchar(500) DEFAULT NULL,
  `tax_exempted` tinyint(4) DEFAULT NULL,
  `sales_user_id` int(11) DEFAULT NULL,
  `account_user_id` int(11) DEFAULT NULL,
  `operational_user_id` int(11) DEFAULT NULL,
  `customer_support_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_customer_profile`
--

INSERT INTO `tbl_customer_profile` (`id`, `cust_id`, `contact_person_name`, `telephone`, `customer_category`, `pan_number`, `tan_number`, `gst_number`, `address`, `country_id`, `state_id`, `city_id`, `description`, `payment_type_id`, `billing_schedule`, `credit_min_limit_amount`, `credit_max_limit_amount`, `credit_period`, `credit_period1`, `billing_format`, `billing_address`, `tax_exempted`, `sales_user_id`, `account_user_id`, `operational_user_id`, `customer_support_user_id`, `created_at`) VALUES
(1, 1, 'ABC ASD', '89456', 'A', 'qwe', 'qwe', 'qwqw', 'asas', 101, 4008, 133177, 'HDFC BANK', 1, 1, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 0, '2022-11-23 05:01:46'),
(2, 2, 'qwe ert', '89456', 'A', 'qwe1', 'qwe1', 'qwqw1', 'Nashik Cosmos', 101, 4008, 133177, 'HDFC BANK', 1, 1, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 0, '2022-11-23 05:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_customer_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` mediumint(9) NOT NULL COMMENT 'From tbl_Customer id',
  `key` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `access_by` tinyint(4) NOT NULL COMMENT '3= Developer, 1 = Admin',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_customer_setting`
--

INSERT INTO `tbl_customer_setting` (`id`, `cust_id`, `key`, `value`, `access_by`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 'volumetric_weight_constant', '4000', 1, 1, '2022-11-24 10:02:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_booking_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_booking_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_chargeable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_master_booking_type`
--

INSERT INTO `tbl_master_booking_type` (`id`, `name`, `is_active`, `is_chargeable`) VALUES
(1, 'Account', 1, 0),
(2, 'Cash', 1, 0),
(3, 'To pay', 1, 0),
(4, 'COD', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_city_category`
--

CREATE TABLE IF NOT EXISTS `tbl_master_city_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_chargeable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_master_city_category`
--

INSERT INTO `tbl_master_city_category` (`id`, `name`, `is_active`, `is_chargeable`) VALUES
(1, 'Metro city', 1, 0),
(2, 'Megacity', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_delivery_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_delivery_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `service_type_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id tbl_master_service_type',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_chargeable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_master_delivery_type`
--

INSERT INTO `tbl_master_delivery_type` (`id`, `name`, `service_type_id`, `is_active`, `is_chargeable`) VALUES
(1, 'EFS Door delivery', 0, 1, 0),
(2, 'Appointment delivery', 0, 1, 1),
(3, 'Special Delivery(malls/restaurant/Sunday/gov)', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_insurance_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_insurance_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_master_insurance_type`
--

INSERT INTO `tbl_master_insurance_type` (`id`, `name`, `is_active`) VALUES
(1, 'Owner Risk', 1),
(2, 'Carrier Risk', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_material_description`
--

CREATE TABLE IF NOT EXISTS `tbl_master_material_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `short_code` varchar(100) NOT NULL,
  `handling_type_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_master_material_description`
--

INSERT INTO `tbl_master_material_description` (`id`, `name`, `short_code`, `handling_type_id`, `is_active`) VALUES
(1, 'Fruits', 'Fl', 1, 1),
(2, 'Electronics', 'EL', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_material_handling_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_material_handling_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `chargeable_percentage` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_master_material_handling_type`
--

INSERT INTO `tbl_master_material_handling_type` (`id`, `name`, `chargeable_percentage`, `is_active`) VALUES
(1, 'Handle With Care', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_payment_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_chargeable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_master_payment_type`
--

INSERT INTO `tbl_master_payment_type` (`id`, `name`, `is_active`, `is_chargeable`) VALUES
(1, 'Cash', 1, 0),
(2, 'Credit', 1, 0),
(3, 'Cheque', 1, 0),
(4, 'To Pay', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_pincode`
--

CREATE TABLE IF NOT EXISTS `tbl_master_pincode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_chargeable` tinyint(4) NOT NULL DEFAULT '0',
  `place_code` varchar(500) DEFAULT NULL,
  `pincode` int(11) NOT NULL,
  `city_id` mediumint(9) NOT NULL,
  `state_id` mediumint(9) NOT NULL,
  `country_id` mediumint(9) NOT NULL,
  `zone_id` mediumint(9) NOT NULL,
  `sub_zone_id` mediumint(9) NOT NULL,
  `city_category_id` int(11) NOT NULL,
  `is_prepaid` tinyint(4) NOT NULL DEFAULT '0',
  `is_serviceable` tinyint(4) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_cash` tinyint(4) NOT NULL DEFAULT '0',
  `is_reverse_pickup` tinyint(4) NOT NULL DEFAULT '0',
  `is_cod` tinyint(4) NOT NULL DEFAULT '0',
  `is_oda1` tinyint(4) NOT NULL DEFAULT '0',
  `is_oda2` tinyint(4) NOT NULL DEFAULT '0',
  `nearest_km` double(10,2) DEFAULT NULL,
  `nearest_branch_id` int(11) DEFAULT NULL COMMENT 'tbl_user from role_id 3',
  `latitude` double(10,2) DEFAULT NULL,
  `longitude` double(10,2) DEFAULT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `deleted_by` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_master_pincode`
--

INSERT INTO `tbl_master_pincode` (`id`, `is_chargeable`, `place_code`, `pincode`, `city_id`, `state_id`, `country_id`, `zone_id`, `sub_zone_id`, `city_category_id`, `is_prepaid`, `is_serviceable`, `is_active`, `is_cash`, `is_reverse_pickup`, `is_cod`, `is_oda1`, `is_oda2`, `nearest_km`, `nearest_branch_id`, `latitude`, `longitude`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'Panchavati', 422003, 133177, 4008, 101, 1, 3, 1, 0, 1, 1, 0, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, '2022-11-18 11:12:48', NULL, NULL),
(2, 0, 'CIDEO', 422009, 133177, 4008, 101, 1, 3, 1, 0, 1, 1, 0, 0, 0, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, '2022-11-18 11:12:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_service_type`
--

CREATE TABLE IF NOT EXISTS `tbl_master_service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_master_service_type`
--

INSERT INTO `tbl_master_service_type` (`id`, `name`, `is_active`) VALUES
(1, 'AIR-EXPRESS', 1),
(2, 'SFC-EXPRESS', 1),
(3, 'TRAIN-EXPRESS', 1),
(4, 'AIR-NFO', 1),
(5, 'SFC-FTL', 1),
(6, 'INTL Express', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_time_slots`
--

CREATE TABLE IF NOT EXISTS `tbl_master_time_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_time` varchar(50) NOT NULL,
  `to_time` varchar(50) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `from_time_format` time DEFAULT NULL,
  `to_time_format` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_master_time_slots`
--

INSERT INTO `tbl_master_time_slots` (`id`, `from_time`, `to_time`, `is_active`, `from_time_format`, `to_time_format`) VALUES
(1, '10:00AM', '11:00PM', 1, '09:00:00', '11:00:00'),
(3, '09:00AM', '12:00PM', 1, '09:00:00', '12:00:00'),
(4, '12:00PM', '03:00PM', 1, '12:00:00', '15:00:00'),
(6, '03:00PM', '06:00PM', 1, '15:00:00', '18:00:00'),
(13, '06:00PM', '09:00PM', 1, '18:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_zone_subzone`
--

CREATE TABLE IF NOT EXISTS `tbl_master_zone_subzone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `zone_name` varchar(64) NOT NULL,
  `zone_level` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 = deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_master_zone_subzone`
--

INSERT INTO `tbl_master_zone_subzone` (`id`, `parent_id`, `zone_name`, `zone_level`, `is_deleted`) VALUES
(1, 0, 'Nashik', 1, 0),
(2, 0, 'pune', 1, 0),
(3, 1, 'Nashik ', 2, 0),
(4, 1, 'Nashik Road', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module`
--

CREATE TABLE IF NOT EXISTS `tbl_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_display_user_access` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

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
(12, 'Received Manifest ', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_main_role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_name`, `created_at`, `is_main_role`) VALUES
(1, 'Super Admin', '2022-10-07 18:22:29', 1),
(2, 'Admin', '2022-10-07 18:22:41', 0),
(3, 'Branch', '2022-10-12 14:53:16', 1),
(4, 'Franchise', '2022-10-12 14:54:19', 1),
(5, 'Hub', '2022-10-12 14:54:31', 1),
(6, 'Sales Employee', '2022-10-12 14:55:05', 0),
(7, 'Account Employee', '2022-10-12 14:55:05', 0),
(8, 'Customer Support', '2022-10-12 14:55:26', 0),
(9, 'Operational Employee', '2022-10-12 14:55:26', 0),
(10, 'Customer', '2022-10-12 14:55:48', 1),
(11, 'Delivery boy', '2022-11-14 16:46:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles_access`
--

CREATE TABLE IF NOT EXISTS `tbl_roles_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `create` tinyint(4) NOT NULL DEFAULT '0',
  `edit` tinyint(4) NOT NULL DEFAULT '0',
  `delete` tinyint(4) NOT NULL DEFAULT '0',
  `view_global` int(11) NOT NULL DEFAULT '1',
  `view_own` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

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
(7, 3, 8, 0, 0, 0, 0, 0),
(8, 3, 9, 1, 0, 0, 1, 0),
(9, 3, 10, 0, 0, 0, 0, 0),
(10, 3, 11, 0, 0, 0, 0, 0),
(11, 3, 12, 0, 0, 0, 0, 0),
(12, 3, 13, 0, 0, 0, 0, 0),
(13, 3, 14, 0, 0, 0, 0, 0),
(14, 4, 3, 0, 0, 0, 0, 0),
(15, 4, 4, 0, 0, 0, 0, 0),
(16, 4, 5, 0, 0, 0, 0, 0),
(17, 4, 6, 0, 0, 0, 0, 0),
(18, 4, 7, 0, 0, 0, 0, 0),
(19, 4, 8, 0, 0, 0, 0, 0),
(20, 4, 9, 0, 0, 0, 0, 0),
(21, 4, 10, 0, 0, 0, 0, 0),
(22, 4, 11, 0, 0, 0, 0, 0),
(23, 4, 12, 0, 0, 0, 0, 0),
(24, 4, 13, 0, 0, 0, 0, 0),
(25, 4, 14, 0, 0, 0, 0, 0),
(26, 5, 3, 0, 0, 0, 0, 0),
(27, 5, 4, 0, 0, 0, 0, 0),
(28, 5, 5, 0, 0, 0, 0, 0),
(29, 5, 6, 0, 0, 0, 0, 0),
(30, 5, 7, 0, 0, 0, 0, 0),
(31, 5, 8, 0, 0, 0, 0, 0),
(32, 5, 9, 0, 0, 0, 1, 1),
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
(49, 10, 14, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

CREATE TABLE IF NOT EXISTS `tbl_user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `create` tinyint(4) NOT NULL DEFAULT '0',
  `edit` tinyint(4) NOT NULL DEFAULT '0',
  `delete` tinyint(4) NOT NULL DEFAULT '0',
  `view_global` int(11) NOT NULL DEFAULT '1',
  `view_own` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `tbl_user_access`
--

INSERT INTO `tbl_user_access` (`id`, `user_id`, `module_id`, `create`, `edit`, `delete`, `view_global`, `view_own`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 3, 1, 1, 1, 1, 1),
(3, 2, 4, 1, 1, 0, 1, 1),
(4, 2, 5, 0, 0, 0, 0, 0),
(5, 2, 6, 1, 1, 0, 1, 1),
(6, 2, 7, 1, 1, 0, 1, 1),
(7, 2, 8, 1, 1, 0, 1, 1),
(8, 2, 9, 1, 0, 0, 1, 1),
(9, 2, 10, 0, 0, 0, 0, 0),
(10, 2, 11, 0, 0, 0, 0, 0),
(11, 2, 12, 0, 0, 0, 0, 0),
(12, 3, 3, 1, 1, 0, 1, 1),
(13, 3, 4, 0, 0, 0, 0, 0),
(14, 3, 5, 0, 0, 0, 0, 0),
(15, 3, 6, 0, 0, 0, 0, 0),
(16, 3, 7, 1, 1, 0, 1, 1),
(17, 3, 8, 1, 1, 0, 1, 1),
(18, 3, 9, 0, 1, 0, 1, 1),
(19, 3, 10, 0, 0, 0, 0, 0),
(20, 3, 11, 0, 0, 0, 0, 0),
(21, 3, 12, 0, 0, 0, 0, 0),
(22, 4, 3, 1, 1, 0, 1, 1),
(23, 4, 4, 0, 0, 0, 0, 0),
(24, 4, 5, 0, 0, 0, 0, 0),
(25, 4, 6, 0, 0, 0, 0, 0),
(26, 4, 7, 1, 1, 0, 1, 1),
(27, 4, 8, 0, 1, 0, 1, 1),
(28, 4, 9, 0, 0, 0, 0, 0),
(29, 4, 10, 0, 0, 0, 0, 0),
(30, 4, 11, 0, 0, 0, 0, 0),
(31, 4, 12, 0, 0, 0, 0, 0),
(32, 5, 3, 1, 1, 0, 0, 1),
(33, 5, 4, 0, 0, 0, 0, 0),
(34, 5, 5, 0, 0, 0, 0, 0),
(35, 5, 6, 0, 0, 0, 0, 0),
(36, 5, 7, 1, 1, 0, 1, 1),
(37, 5, 8, 0, 0, 0, 0, 0),
(38, 5, 9, 0, 0, 0, 1, 1),
(39, 5, 10, 0, 0, 0, 0, 0),
(40, 5, 11, 0, 0, 0, 0, 0),
(41, 5, 12, 0, 0, 0, 0, 0),
(42, 6, 3, 0, 0, 0, 1, 1),
(43, 6, 4, 0, 0, 0, 0, 0),
(44, 6, 5, 0, 0, 0, 0, 0),
(45, 6, 6, 0, 0, 0, 0, 0),
(46, 6, 7, 0, 0, 0, 1, 1),
(47, 6, 8, 0, 0, 0, 1, 1),
(48, 6, 9, 0, 0, 0, 1, 1),
(49, 6, 10, 0, 0, 0, 0, 0),
(50, 6, 11, 0, 0, 0, 0, 0),
(51, 6, 12, 0, 0, 0, 0, 0),
(52, 7, 3, 0, 0, 0, 1, 1),
(53, 7, 4, 0, 0, 0, 0, 0),
(54, 7, 5, 0, 0, 0, 0, 0),
(55, 7, 6, 0, 0, 0, 0, 0),
(56, 7, 7, 0, 0, 0, 1, 1),
(57, 7, 8, 0, 0, 0, 1, 1),
(58, 7, 9, 0, 0, 0, 1, 1),
(59, 7, 10, 0, 0, 0, 0, 0),
(60, 7, 11, 0, 0, 0, 0, 0),
(61, 7, 12, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `parent_staff_role` int(11) NOT NULL DEFAULT '0',
  `notification_token` text,
  `otp_number` int(11) DEFAULT NULL,
  `is_otp_verified` tinyint(4) DEFAULT NULL COMMENT '1: verified  0:Not Verified',
  `created_by` int(11) unsigned NOT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `deleted_by` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `contact`, `address`, `email`, `password`, `image`, `role_id`, `role_access_id`, `parent_staffid`, `parent_staff_role`, `notification_token`, `otp_number`, `is_otp_verified`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super', 'admin', 1234567, 'nashik', 'superadmin@gmail.com', '123456', NULL, 1, 1, 0, 0, NULL, NULL, NULL, 1, NULL, NULL, '2022-11-14 14:36:58', NULL, NULL),
(2, 'admin', '1', 12333, '123', 'admin@gmail.com', '123456', NULL, 2, NULL, 1, 1, NULL, NULL, NULL, 1, 1, NULL, '2022-11-14 09:08:18', '2022-11-16 01:59:05', NULL),
(3, 'Nashik Branch1', '', 9527380097, '', 'nashik@nashikbranch.com', '123456', 'Chrysanthemum.jpg', 3, NULL, 1, 1, NULL, NULL, NULL, 1, 1, NULL, '2022-11-15 08:31:24', '2022-11-21 05:48:10', NULL),
(4, 'Nashik ', 'admin', 9527380090, 'nashik', 'nashikadmin@nashikbranch.com', '123456', NULL, 2, NULL, 3, 3, NULL, NULL, NULL, 2, 2, NULL, '2022-11-15 09:14:42', '2022-11-16 00:32:46', NULL),
(5, 'admin2', 'nashik Branch', 7894563210, 'nashik', 'admin2@nashikbranch.com', '123456', NULL, 2, NULL, 3, 3, NULL, NULL, NULL, 3, 2, NULL, '2022-11-16 03:49:07', '2022-11-16 04:08:10', NULL),
(6, 'sales', 'admin nashik', 9527380095, 'nashik', 'sales@nashikbranch.com', '123456', NULL, 6, NULL, 3, 3, NULL, NULL, NULL, 5, NULL, NULL, '2022-11-16 04:11:06', NULL, NULL),
(7, 'Cust support', 'nashik', 1234567890, 'nashik', 'custsupport@nashikbranch.com', '123456', NULL, 8, NULL, 3, 3, NULL, NULL, NULL, 3, NULL, NULL, '2022-11-18 02:39:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `country_id`, `state_id`, `city_id`, `created_at`) VALUES
(1, 2, 101, 4008, 133177, '2022-11-14 20:08:18'),
(2, 3, 101, 4008, 133177, '2022-11-15 19:31:24'),
(3, 4, 101, 4008, 133177, '2022-11-15 20:14:42'),
(4, 5, 101, 4008, 133177, '2022-11-16 14:49:07'),
(5, 6, 101, 4008, 133177, '2022-11-16 15:11:06'),
(6, 7, 101, 4008, 133177, '2022-11-18 13:39:25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
