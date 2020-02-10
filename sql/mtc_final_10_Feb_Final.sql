-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2020 at 10:44 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtc_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`id`, `name`, `code`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'ASSET', '1000', 0, '2019-11-23 09:18:30', '2019-11-23 09:18:30'),
(2, 'LIABILITY', '3000', 0, '2019-11-23 09:18:30', '2019-11-23 09:18:30'),
(3, 'INCOME', '4000', 0, '2019-11-23 09:18:30', '2019-11-23 09:18:30'),
(4, 'EXPENSE', '5000', 0, '2019-11-23 09:18:30', '2019-11-23 09:18:30'),
(5, 'EQUITY', '6000', 0, '2019-11-23 09:18:30', '2019-11-23 09:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `account_head_child_i`
--

CREATE TABLE `account_head_child_i` (
  `id` int(10) UNSIGNED NOT NULL,
  `ac_head_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_head_child_i`
--

INSERT INTO `account_head_child_i` (`id`, `ac_head_id`, `name`, `code`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fixet Asset', '1100', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(2, 1, 'Current Asset', '1500', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(3, 2, 'Current Liability Member Savings', '3100', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(4, 2, 'Others Savings A/C', '3200', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(5, 2, 'Long Term Liability (PKSF)', '3300', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(6, 2, 'Current Account Principal (Branch & HO)', '3400', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(7, 3, 'General Income', '4100', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(8, 3, 'Others Income', '4200', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(9, 4, 'Financial Expense', '5100', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(10, 4, 'Current Account Service Charge (Branch & HO)', '5200', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(11, 4, 'Salary & Allowance', '5300', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(12, 4, 'Operating Cost', '5400', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(13, 2, 'Others Liability', '3500', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(14, 2, 'Capital Fund', '3600', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(15, 3, 'Reimbursement', '7700', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(16, 2, 'Loan A/C With Others', '3700', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(17, 4, 'Non Operating Cost', '5600', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(18, 3, 'Income from Training Operating', '4500', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(19, 4, 'Expenses for Training center', '5700', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(20, 4, 'Loss On Sale Of Land', '5001', 0, '2019-11-20 21:22:33', '2019-11-20 21:22:33'),
(21, 1, 'Black Rice', '010540', 0, '2020-01-18 01:06:44', '2020-01-18 01:06:44'),
(22, 1, 'Super Admin', '123', 0, '2020-01-18 01:07:38', '2020-01-18 01:07:38'),
(23, 1, 'ewr', '345', 0, '2020-01-18 01:12:01', '2020-01-18 01:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `account_head_child_ii`
--

CREATE TABLE `account_head_child_ii` (
  `id` int(10) UNSIGNED NOT NULL,
  `ac_head_child_i_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_head_child_ii`
--

INSERT INTO `account_head_child_ii` (`id`, `ac_head_child_i_id`, `name`, `code`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Land & Building', '1150', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(2, 1, 'Furniture & fixture', '1200', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(3, 1, 'Office Equipment', '1250', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(4, 1, 'Vehicles', '1300', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(5, 1, 'Electronic Equipment', '1350', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(6, 1, 'Other Fixet Assets', '1400', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(7, 2, 'Loan A/C with  Member\'s', '1900', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(8, 2, 'Others Loan', '2000', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(9, 2, 'Advance', '2100', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(10, 2, 'Others Investment', '2300', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(11, 5, 'Fund A/C With  PKSF', '3350', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(12, 8, 'Other Income', '4250', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(13, 8, 'Bank Interest', '4300', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(14, 10, 'Service Charge paid to HO', '5220', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(15, 11, 'Salary & Allowance', '5310', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(16, 12, 'Operating cost', '5450', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(17, 3, 'Genaral  Savings (GS)', '3120', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(18, 3, 'Specail Savings (SS)', '3140', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(19, 9, 'Service Charge Paid to PKSF', '5130', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(20, 9, 'Interest on Group Savings', '5120', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(21, 3, 'Monthly Savings(DPS)', '3150', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(22, 3, 'Emergemcy  Fund A/C', '3160', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(23, 7, 'Service charge A/C (member)', '4150', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(24, 12, 'Bank Charge', '5500', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(25, 2, 'Cash & Bank', '1700', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(26, 6, 'Current Account Principal InterTransaction (Branch & HO)', '3420', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(27, 13, 'Reserve & Provition', '3520', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(28, 14, 'Retained Surplus/Deficit', '3620', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(29, 2, 'Loan to project', '1510', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(30, 13, 'Others Fund', '3550', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(31, 2, 'Other Current Asset', '1550', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(32, 14, 'Capital fund', '3601', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(33, 2, 'Fund A/C With Branch', '1600', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(34, 7, 'Service charge from Branch', '4400', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(35, 16, 'Loan A/C With Others', '3710', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(36, 17, 'Non Operating Cost', '5650', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(37, 3, 'Health Savings', '3180', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(38, 4, 'Special Savings (staff)', '3201', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(39, 3, 'Fixed General savings', '3190', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(40, 4, 'Staff Welfare', '3206', 0, '2019-11-20 21:27:57', '2019-11-20 21:27:57'),
(41, 23, 'Basmati Rice', '235', 0, '2020-01-18 01:13:08', '2020-01-18 01:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `account_head_child_iii`
--

CREATE TABLE `account_head_child_iii` (
  `id` int(10) UNSIGNED NOT NULL,
  `ac_head_child_ii_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_head_child_iii`
--

INSERT INTO `account_head_child_iii` (`id`, `ac_head_child_ii_id`, `name`, `code`, `amount`, `created_at`, `updated_at`) VALUES
(1, 25, 'Cash in hand', '1750', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(2, 25, 'Cash at Bank', '1800', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(3, 17, 'JAGARON', '3120.1', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(4, 17, 'AGRASHOR', '3120.2', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(5, 17, 'BUNIAD', '3120.3', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(6, 17, 'MFMSF', '3120.4', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(7, 17, 'SUFALON', '3120.5', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(8, 17, 'EFRRAP', '3120.6', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(9, 17, 'FSP', '3120.7', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(10, 17, 'Enrich IGA', '3120.8', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(11, 17, 'Enrich LIL', '3120.9', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(12, 17, 'Enrich ACL', '3120.10', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08'),
(13, 17, 'EDUCATION', '3120.11', 0, '2019-11-20 21:29:08', '2019-11-20 21:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `account_head_child_iv`
--

CREATE TABLE `account_head_child_iv` (
  `id` int(10) UNSIGNED NOT NULL,
  `ac_head_child_iii_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
  `id` int(10) UNSIGNED NOT NULL,
  `guest_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `mis_voucher_id` int(10) UNSIGNED NOT NULL,
  `checkout_status` tinyint(1) NOT NULL DEFAULT 0,
  `reserved` tinyint(1) NOT NULL DEFAULT 0,
  `total_bill` double(14,2) NOT NULL DEFAULT 0.00,
  `advance_paid` double(14,2) NOT NULL DEFAULT 0.00,
  `total_paid` double(14,2) NOT NULL DEFAULT 0.00,
  `discount` double(14,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `guest_id` int(10) UNSIGNED NOT NULL,
  `billing_id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `booking_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 2,
  `no_of_visitors` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `bill` double(14,2) NOT NULL DEFAULT 0.00,
  `vat` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `service_charge` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount` double(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `h_start_date` date DEFAULT NULL,
  `h_end_date` date DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `room_no` int(11) DEFAULT NULL,
  `room_unit_price` int(11) DEFAULT NULL,
  `h_total_day` int(11) DEFAULT NULL,
  `h_total_bill` int(11) DEFAULT NULL,
  `v_start_date` date DEFAULT NULL,
  `v_end_date` date DEFAULT NULL,
  `venue_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v_unit_price` int(11) DEFAULT NULL,
  `v_total_day` int(11) DEFAULT NULL,
  `v_total_bill` int(11) DEFAULT NULL,
  `r_total_bill` int(11) DEFAULT NULL,
  `venue_booking_id` int(11) DEFAULT NULL,
  `room_booking_id` int(11) DEFAULT NULL,
  `all_total` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `grand_total` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `h_start_date`, `h_end_date`, `name`, `contact`, `room_no`, `room_unit_price`, `h_total_day`, `h_total_bill`, `v_start_date`, `v_end_date`, `venue_no`, `v_unit_price`, `v_total_day`, `v_total_bill`, `r_total_bill`, `venue_booking_id`, `room_booking_id`, `all_total`, `discount`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Asmot Molla', 1222244, NULL, NULL, NULL, NULL, '2019-12-22', '2019-12-23', 'Venue-100', 6000, NULL, NULL, 0, 1, NULL, 0, 0, 0, '2019-12-29 00:13:52', '2019-12-29 00:13:52'),
(2, '2019-12-22', '2019-12-23', 'Rahamot Ullah', 1222255, 204, 4000, 2, 8000, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, 8000, 0, 8000, '2019-12-30 01:48:42', '2019-12-30 01:48:42'),
(3, NULL, NULL, 'Asmot Molla', 1222244, NULL, NULL, NULL, NULL, '2019-12-22', '2019-12-23', 'Venue-100', 6000, NULL, NULL, 0, 1, NULL, 0, 0, 0, '2020-01-14 22:48:47', '2020-01-14 22:48:47'),
(4, '2019-12-22', '2019-12-23', 'Rahamot Ullah', 1222255, 204, 4000, 2, 8000, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, 8000, 0, 8000, '2020-01-14 23:55:42', '2020-01-14 23:55:42'),
(5, '2019-12-22', '2019-12-23', 'Rahamot Ullah', 1222255, 204, 4000, 2, 8000, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, 8000, 0, 8000, '2020-01-15 02:24:13', '2020-01-15 02:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `id` int(10) UNSIGNED NOT NULL,
  `billing_id` int(10) UNSIGNED NOT NULL,
  `mis_voucher_id` int(10) UNSIGNED NOT NULL,
  `checkout_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double(14,2) NOT NULL DEFAULT 0.00,
  `date` date DEFAULT NULL,
  `software_start_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `name`, `text`, `value`, `date`, `software_start_date`, `created_at`, `updated_at`) VALUES
(1, 'software_date', NULL, 0.00, '2019-12-30', '2019-12-30', NULL, '2020-02-09 23:19:20'),
(2, 'vat_food', NULL, 15.00, NULL, NULL, NULL, '2020-02-10 00:50:02'),
(3, 'vat_service', NULL, 10.00, NULL, NULL, NULL, '2020-02-10 00:50:02'),
(4, 'vat_others', NULL, 5.00, NULL, NULL, NULL, '2020-02-10 00:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `current_balance`
--

CREATE TABLE `current_balance` (
  `id` int(10) UNSIGNED NOT NULL,
  `thead_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `debit` double(14,2) NOT NULL DEFAULT 0.00,
  `credit` double(14,2) NOT NULL DEFAULT 0.00,
  `amount` double(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, '2019-12-30', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `current_stock_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `quantity` double(10,3) NOT NULL DEFAULT 0.000,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e1_departments`
--

CREATE TABLE `e1_departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e1_departments`
--

INSERT INTO `e1_departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Test', NULL, '2019-12-05 00:16:52', NULL),
(4, 'Department', NULL, '2019-12-06 23:15:30', NULL),
(5, 'Name', NULL, '2019-12-13 05:10:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `e2_employee_designations`
--

CREATE TABLE `e2_employee_designations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e2_employee_designations`
--

INSERT INTO `e2_employee_designations` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Deputy Director', '', '2019-09-09 13:36:14', NULL),
(2, 'Asst. Director', '', '2019-09-09 13:36:29', NULL),
(3, 'Manager', '', '2019-09-09 13:36:38', NULL),
(4, 'Accounts Officer', '', '2019-09-09 13:36:43', NULL),
(5, 'Service Manager', '', '2019-10-06 22:36:35', NULL),
(6, 'Receptionist', '', '2019-10-06 22:37:02', NULL),
(7, 'Electric Officer', '', '2019-10-06 22:37:29', NULL),
(8, 'Service Officer', '', '2019-10-06 22:37:49', NULL),
(9, 'Guard', '', '2019-10-06 22:38:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `e3_salary_grades`
--

CREATE TABLE `e3_salary_grades` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `provident_fund` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_salary` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transportation_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dinning_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_rent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_salary` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e3_salary_grades`
--

INSERT INTO `e3_salary_grades` (`id`, `name`, `type`, `provident_fund`, `basic_salary`, `transportation_allowance`, `dinning_allowance`, `other_allowance`, `home_rent`, `gross_salary`, `note`, `created_at`, `updated_at`) VALUES
(1, 'SALARY GRADE test', 1, '300', '2000', '1000', '100', '200', '500', '500', 'Note', '2019-12-05 07:53:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `e4_employees`
--

CREATE TABLE `e4_employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `type_id` enum('0','3','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `salary_grade_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `emergency_contact` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e4_employees`
--

INSERT INTO `e4_employees` (`id`, `department_id`, `type_id`, `name`, `date_of_birth`, `phone`, `address`, `blood_group`, `designation_id`, `salary_grade_id`, `emergency_contact`, `other`, `created_at`, `updated_at`) VALUES
(1, 5, '3', 'test', '2019-05-12', '243563', 'Dhaka', 'A+', 5, 1, '3245235235', NULL, '2019-12-13 07:34:37', '2019-12-13 07:50:27'),
(2, 4, '0', 'Rice', '2001-06-21', '345345', 'dgfdg', 'AB-', 8, 1, '345345', NULL, '2020-01-20 00:56:02', '2020-01-20 00:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `e5_leave_categories`
--

CREATE TABLE `e5_leave_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e5_leave_categories`
--

INSERT INTO `e5_leave_categories` (`id`, `name`, `details`, `created_at`, `updated_at`) VALUES
(1, 'Name2', NULL, '2019-12-13 05:16:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `e6_leaves`
--

CREATE TABLE `e6_leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_category_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e6_leaves`
--

INSERT INTO `e6_leaves` (`id`, `name`, `duration`, `leave_category_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Name2', '2019-12-03-2019-12-05', 1, NULL, '2019-12-13 05:17:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_infos`
--

CREATE TABLE `general_infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double(14,2) NOT NULL DEFAULT 0.00,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `org_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appearance` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `h1_building_types`
--

CREATE TABLE `h1_building_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h1_building_types`
--

INSERT INTO `h1_building_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Normal', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h2_buildings`
--

CREATE TABLE `h2_buildings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_type` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h2_buildings`
--

INSERT INTO `h2_buildings` (`id`, `name`, `building_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Aspada Training Academy', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h3_floor_types`
--

CREATE TABLE `h3_floor_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h3_floor_types`
--

INSERT INTO `h3_floor_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ground', 'This is Ground type floor.', '2019-11-15 13:05:39', NULL),
(2, 'Normal', 'This is normal type of floor.', '2019-11-15 13:06:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h4_floors`
--

CREATE TABLE `h4_floors` (
  `id` int(10) UNSIGNED NOT NULL,
  `building_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor_type` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h4_floors`
--

INSERT INTO `h4_floors` (`id`, `building_id`, `name`, `floor_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ground Floor', 1, 'This is Ground Floor.', '2019-11-15 14:42:56', NULL),
(2, 1, 'Floor-1', 2, 'This is Floor-1.', '2019-11-15 14:46:19', NULL),
(3, 1, 'Floor-2', 2, 'This is Floor-2', '2019-11-15 14:46:41', NULL),
(4, 1, 'Floor-3', 2, 'This is Floor-3.', '2019-11-15 14:47:08', NULL),
(5, 1, 'Floor-4', 2, 'This is Floor-4', '2019-11-15 14:48:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h5_room_categories`
--

CREATE TABLE `h5_room_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `vat` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h5_room_categories`
--

INSERT INTO `h5_room_categories` (`id`, `name`, `price`, `vat`, `description`, `image`, `created_at`, `updated_at`) VALUES
(5, 'A/C Single', 2000, 10, 'Enjoy our Presidential Suite', 'bjr_executive-suite.jpg', '2019-11-15 08:54:08', NULL),
(6, 'A/C Double', 4000, 10, 'Enjoy our Presidential Suite', 'XI6_room5.jpg', '2019-11-15 08:55:17', NULL),
(7, 'Single', 1500, 10, 'Enjoy our Presidential Suite', 'WoM_room3.jpg', '2019-11-15 08:55:58', NULL),
(8, 'Double', 3000, 10, 'Enjoy our Presidential Suite', 'tzl_executive-suite.jpg', '2019-11-15 08:56:19', NULL),
(10, 'A/C 3 Bed', 6000, 10, 'Enjoy our Presidential Suite', 'cwc_room5.jpg', '2019-11-15 09:00:05', NULL),
(11, 'A/C 4 Bed', 8000, 10, 'Enjoy our Presidential Suite', 'tGr_room3.jpg', '2019-11-15 09:00:29', NULL),
(12, '3 Bed', 4000, 10, 'Enjoy our Presidential Suite', 'sqB_executive-suite.jpg', '2019-11-15 09:01:49', NULL),
(13, '4 Bed', 6000, 10, 'Enjoy our Presidential Suite', 'Nb3_room5.jpg', '2019-11-15 09:02:16', NULL),
(14, 'A/C Semi Double', 3500, 10, 'Enjoy our Presidential Suite', 'vTw_room3.jpg', '2019-11-15 09:03:03', NULL),
(15, 'Semi Double', 2500, 10, 'Enjoy our Presidential Suite', 'VwL_executive-suite.jpg', '2019-11-15 09:03:20', NULL),
(16, 'VIP A/C Double', 5000, 10, 'Enjoy our Presidential Suite', 'i8n_room5.jpg', '2019-11-15 09:28:59', NULL),
(17, 'VIP A/C Semi Double', 4000, 10, 'Enjoy our Presidential Suite .', 'QNJ_room3.jpg', '2019-11-18 04:54:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h6_rooms`
--

CREATE TABLE `h6_rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `floor_id` int(10) UNSIGNED NOT NULL,
  `persons_capacity` int(11) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `h6_rooms`
--

INSERT INTO `h6_rooms` (`id`, `room_no`, `price`, `floor_id`, `persons_capacity`, `category_id`, `description`, `image`, `created_at`, `updated_at`) VALUES
(3, '201', 6000, 2, 4, 13, NULL, 'Vdm_room3.jpg', '2019-11-15 09:09:54', NULL),
(4, '202', 4000, 2, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:10:14', NULL),
(5, '203', 4000, 2, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:10:43', NULL),
(6, '204', 4000, 2, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:11:11', NULL),
(7, '205', 4000, 2, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:11:35', NULL),
(8, '301', 2000, 3, 1, 5, NULL, 'Vdm_room3.jpg', '2019-11-15 09:14:24', NULL),
(9, '302', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:15:43', NULL),
(10, '303', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:16:08', NULL),
(11, '304', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:16:44', NULL),
(12, '305', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:17:13', NULL),
(13, '306', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:17:50', NULL),
(14, '307', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:19:06', NULL),
(15, '308', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:19:24', NULL),
(16, '309', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:19:52', NULL),
(17, '310', 4000, 3, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-15 09:20:26', NULL),
(18, '311', 4000, 3, 4, 13, NULL, 'Vdm_room3.jpg', '2019-11-15 09:20:42', NULL),
(19, '312', 2000, 3, 1, 5, NULL, 'Vdm_room3.jpg', '2019-11-15 09:21:15', NULL),
(20, '313', 2000, 3, 1, 5, NULL, 'Vdm_room3.jpg', '2019-11-15 09:21:35', NULL),
(21, '314', 2000, 3, 1, 5, NULL, 'Vdm_room3.jpg', '2019-11-15 09:21:54', NULL),
(22, '315', 3500, 3, 1, 14, NULL, 'Vdm_room3.jpg', '2019-11-15 09:23:55', NULL),
(23, '316', 3500, 3, 1, 14, NULL, 'Vdm_room3.jpg', '2019-11-15 09:24:25', NULL),
(24, '317', 6000, 3, 4, 13, NULL, 'Vdm_room3.jpg', '2019-11-15 09:25:04', NULL),
(25, '401', 5000, 4, 2, 16, NULL, 'Vdm_room3.jpg', '2019-11-18 04:18:53', NULL),
(26, '402', 5000, 4, 2, 16, NULL, 'Vdm_room3.jpg', '2019-11-18 04:19:56', NULL),
(27, '403', 3500, 4, 1, 14, NULL, 'Vdm_room3.jpg', '2019-11-18 04:20:55', NULL),
(28, '404', 4000, 4, 2, 6, NULL, 'Vdm_room3.jpg', '2019-11-18 04:22:07', NULL),
(29, '405', 4000, 4, 3, 12, NULL, 'Vdm_room3.jpg', '2019-11-18 04:23:07', NULL),
(30, '406', 2000, 4, 1, 5, NULL, 'Vdm_room3.jpg', '2019-11-18 04:24:09', NULL),
(31, '407', 1500, 4, 1, 7, NULL, 'Vdm_room3.jpg', '2019-11-18 04:25:25', NULL),
(32, '408', 1500, 4, 1, 7, NULL, 'Vdm_room3.jpg', '2019-11-18 04:26:22', NULL),
(33, '409', 2000, 4, 1, 5, NULL, 'hHZ_room3.jpg', '2019-11-18 04:28:05', NULL),
(34, '411', 6000, 4, 2, 6, NULL, 'A8f_room5.jpg', '2019-11-18 04:30:15', NULL),
(35, '412', 3500, 4, 2, 14, NULL, 'efk_room5.jpg', '2019-11-18 04:31:24', NULL),
(36, '413', 3500, 4, 1, 14, NULL, 'zP3_room5.jpg', '2019-11-18 04:32:30', NULL),
(37, '414', 1500, 4, 1, 7, NULL, 'u4m_room3.jpg', '2019-11-18 04:33:10', NULL),
(38, '415', 1500, 4, 1, 7, NULL, 'Rqz_room5.jpg', '2019-11-18 04:34:18', NULL),
(39, '416', 3000, 4, 2, 8, NULL, 'N8F_room3.jpg', '2019-11-18 04:35:07', NULL),
(40, '501', 5000, 5, 2, 16, NULL, '3Y3_room3.jpg', '2019-11-18 04:46:56', NULL),
(41, '502', 5000, 5, 2, 16, NULL, 'XzK_room5.jpg', '2019-11-18 04:47:21', NULL),
(42, '503', 4000, 5, 2, 6, NULL, '16j_room5.jpg', '2019-11-18 04:48:07', NULL),
(43, '504', 4000, 5, 2, 6, NULL, 'Yhk_room5.jpg', '2019-11-18 04:48:46', NULL),
(44, '505', 4000, 5, 2, 17, NULL, 'qyo_room3.jpg', '2019-11-18 04:56:39', NULL),
(45, '506', 4500, 5, 2, 14, NULL, 'cyO_room3.jpg', '2019-11-18 04:57:25', NULL),
(101, '206 A', 300, 4, 2, 12, 'sadsad', 'kcZ_qyo_room3.jpg', '2020-01-27 05:51:44', NULL),
(500, '205 A', 300, 4, 1, 12, 'werwer', '9LT_N8F_room3.jpg', '2020-01-26 05:03:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m1_mis_heads`
--

CREATE TABLE `m1_mis_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `voucher_type_id` int(10) UNSIGNED NOT NULL,
  `credit_head_id` int(10) UNSIGNED DEFAULT NULL,
  `debit_head_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m1_mis_heads`
--

INSERT INTO `m1_mis_heads` (`id`, `voucher_type_id`, `credit_head_id`, `debit_head_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 10, 7, 353, 'Hotel Receipt', NULL, NULL, '2020-02-09 22:51:35'),
(2, 10, 5, 353, 'Venue Receipt', NULL, NULL, '2020-02-09 22:51:35'),
(3, 10, 8, 353, 'Restaurant Receipt', NULL, NULL, '2020-02-09 22:51:35'),
(4, 11, 12, 353, 'Restaurant Payment', NULL, NULL, NULL),
(5, 11, 12, 353, 'Inventory Payment', NULL, NULL, NULL),
(6, 10, 353, 96, 'Miscellaneous Expense', NULL, NULL, '2020-02-09 22:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `m2_mis_head_child_i`
--

CREATE TABLE `m2_mis_head_child_i` (
  `id` int(10) UNSIGNED NOT NULL,
  `mis_head_id` int(10) UNSIGNED NOT NULL,
  `credit_head_id` int(10) UNSIGNED NOT NULL,
  `debit_head_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m3_mis_ledger_heads`
--

CREATE TABLE `m3_mis_ledger_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `mis_head_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_head_id` int(10) UNSIGNED DEFAULT NULL,
  `debit_head_id` int(10) UNSIGNED DEFAULT NULL,
  `code` int(10) UNSIGNED NOT NULL,
  `amount` double(14,2) NOT NULL DEFAULT 0.00,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_type_id` int(10) UNSIGNED DEFAULT NULL,
  `ledgerable_id` int(11) NOT NULL,
  `ledgerable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m3_mis_ledger_heads`
--

INSERT INTO `m3_mis_ledger_heads` (`id`, `mis_head_id`, `name`, `credit_head_id`, `debit_head_id`, `code`, `amount`, `description`, `unit_type_id`, `ledgerable_id`, `ledgerable_type`, `checked`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 1, 'Room', 7, 353, 1000, 0.00, NULL, NULL, 1, 'App\\MISHead', 1, NULL, NULL, '2020-02-10 00:50:02'),
(6, 2, 'Venue', 5, 353, 1100, 0.00, NULL, NULL, 2, 'App\\MISHead', 1, NULL, NULL, '2020-02-10 00:50:02'),
(7, 3, 'Restaurant', 8, 353, 1200, 0.00, NULL, NULL, 3, 'App\\MISHead', 1, NULL, NULL, '2020-02-10 00:50:02'),
(8, 6, 'Discount', 353, 96, 1300, 0.00, NULL, NULL, 6, 'App\\MISHead', 1, NULL, NULL, '2020-02-10 00:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `m4_mis_vouchers_i`
--

CREATE TABLE `m4_mis_vouchers_i` (
  `id` int(10) UNSIGNED NOT NULL,
  `mis_head_id` int(10) UNSIGNED NOT NULL,
  `ledger_head_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `voucher_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_07_03_100000_create_a1_account_heads_table', 1),
(2, '2019_07_03_200000_create_a2_account_head_child_i', 1),
(3, '2019_07_03_300000_create_a3_account_head_child_ii', 1),
(4, '2019_07_03_400000_create_a4_account_head_child_iii', 1),
(5, '2019_07_03_500000_create_a5_account_head_child_iv', 1),
(6, '2019_07_03_600000_create_a6_transaction_heads_table', 1),
(7, '2019_08_13_100000_create_aa1_roles_table', 1),
(8, '2019_08_13_200000_create_aa2_users_table', 1),
(9, '2019_08_13_300000_create_aa3_password_resets_table', 1),
(14, '2019_09_01_000139_create_h1_building_types_table', 1),
(15, '2019_09_01_100139_create_h2_buildings_table', 1),
(16, '2019_09_01_200139_create_h3_floor_types_table', 1),
(17, '2019_09_01_300139_create_h4_floors_table', 1),
(23, '2019_09_04_033048_create_e1_departments_table', 1),
(24, '2019_09_04_133048_create_e2_employee_designations_table', 1),
(25, '2019_09_04_233048_create_e3_salary_grades_table', 1),
(26, '2019_09_04_333048_create_e4_employees_table', 1),
(27, '2019_09_04_433048_create_e5_leave_categories_table', 1),
(28, '2019_09_04_533048_create_e6_leaves_table', 1),
(33, '2019_09_08_500157_create_r5_meal_types_table', 1),
(34, '2019_09_08_600157_create_r6_meal_items_table', 1),
(35, '2019_09_08_700157_create_r7_menu_types_table', 1),
(41, '2019_09_14_400000_create_i4_inventories_table', 7),
(42, '2019_11_11_100000_create_vv1_voucher_types_table', 1),
(57, '2019_12_10_093004_create_staff_table', 7),
(59, '2019_12_03_105249_create_checkout_table', 7),
(60, '2019_08_16_160615_create_v1_venues_table', 3),
(64, '2019_09_01_400139_create_h5_room_categories_table', 3),
(65, '2019_09_01_500139_create_h6_rooms_table', 3),
(68, '2019_09_01_800139_create_h9_room_billings_table', 3),
(123, '2019_12_29_110523_create_checkouts_table', 9),
(720, '2019_12_12_113448_create_configurations_table', 3),
(773, '2020_01_20_063023_create_r9_food_menu_table', 3),
(774, '2020_01_20_080808_create_r10_food_menu_items_table', 3),
(1103, '2020_01_08_040625_create_suppliers_table', 6),
(1105, '2020_01_30_041614_create_general_infos_table', 4),
(1106, '2020_02_02_060733_create_m1_mis_heads_table', 4),
(1110, '2020_02_02_064130_create_s1_unit_types_table', 6),
(1111, '2020_02_02_064157_create_s2_units_table', 6),
(1115, '2019_11_11_200000_create_vv2_vouchers_table', 8),
(1116, '2019_11_11_300000_create_vv3_current_balance_table', 8),
(1117, '2019_11_11_500000_create_vv5_dates_table', 8),
(1118, '2019_11_11_600000_create_vv6_voucher_groups_table', 8),
(1119, '2019_11_11_700000_create_vv7_voucher_update_histories_table', 8),
(1120, '2019_11_24_400000_create_m4_mis_current_stocks_table', 8),
(1121, '2019_11_24_600000_create_m6_purchases_table', 8),
(1122, '2019_11_24_700000_create_m7_purchase_groups_table', 8),
(1123, '2019_12_23_041801_create_guests_table', 8),
(1124, '2019_12_23_041836_create_bookings_table', 8),
(1125, '2019_12_23_050024_create_billings_table', 8),
(1126, '2019_12_28_090517_create_visitors_table', 8),
(1127, '2019_12_30_040536_create_payments_table', 8),
(1128, '2020_01_07_055304_create_deliveries_table', 8),
(1129, '2020_01_20_102033_create_r11_food_sales_table', 8),
(1130, '2020_02_02_063939_create_m2_mis_head_child_i_table', 8),
(1131, '2020_02_02_064016_create_m3_mis_ledger_heads_table', 8),
(1132, '2020_02_02_064050_create_m4_mis_vouchers_i_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `mis_current_stocks`
--

CREATE TABLE `mis_current_stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `quantity_cr` double(10,3) NOT NULL DEFAULT 0.000,
  `quantity_dr` double(10,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `billing_id` int(10) UNSIGNED NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(14,2) NOT NULL DEFAULT 0.00,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mis_voucher_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `mis_voucher_id` int(10) UNSIGNED NOT NULL,
  `purchase_group_id` int(10) UNSIGNED NOT NULL,
  `current_stock_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `amount` double(14,2) NOT NULL DEFAULT 0.00,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_groups`
--

CREATE TABLE `purchase_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `mis_head_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r5_meal_types`
--

CREATE TABLE `r5_meal_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r5_meal_types`
--

INSERT INTO `r5_meal_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fish', 'fish', '2019-12-03 03:58:46', NULL),
(2, 'Rice', 'Rice', '2019-12-03 03:59:37', NULL),
(3, 'Meat', 'Meat', '2019-12-03 03:59:46', NULL),
(4, 'Drinks', 'Drinks', '2019-12-03 03:59:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `r6_meal_items`
--

CREATE TABLE `r6_meal_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `meal_type_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r6_meal_items`
--

INSERT INTO `r6_meal_items` (`id`, `name`, `price`, `meal_type_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Plain Rice', 20, 2, NULL, '2019-12-03 04:00:47', NULL),
(2, 'Polau Rice', 40, 2, NULL, '2019-12-03 04:01:05', NULL),
(3, 'Hilsa Fish (Ilish)', 100, 1, NULL, '2019-12-03 04:01:21', NULL),
(4, 'Prawn (Chingri)', 60, 1, NULL, '2019-12-03 04:01:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `r7_menu_types`
--

CREATE TABLE `r7_menu_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r7_menu_types`
--

INSERT INTO `r7_menu_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Lunch01', NULL, '2019-12-03 03:53:51', NULL),
(2, 'Lunch', NULL, '2019-12-03 03:54:02', NULL),
(4, 'Brekfast', NULL, '2020-02-09 23:57:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `r9_food_menu`
--

CREATE TABLE `r9_food_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_type_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r9_food_menu`
--

INSERT INTO `r9_food_menu` (`id`, `menu_type_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'sdfsdf', 80.00, '2020-01-30 00:25:53', '2020-01-30 00:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `r10_food_menu_items`
--

CREATE TABLE `r10_food_menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `food_menu_id` int(10) UNSIGNED NOT NULL,
  `meal_item_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r10_food_menu_items`
--

INSERT INTO `r10_food_menu_items` (`id`, `food_menu_id`, `meal_item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, '2020-01-30 00:25:53', '2020-01-30 00:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `r11_food_sales`
--

CREATE TABLE `r11_food_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `billing_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `bill` double(12,2) NOT NULL DEFAULT 0.00,
  `discount` double(14,2) NOT NULL DEFAULT 0.00,
  `vat` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `service_charge` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super admin', 0, NULL, NULL),
(2, 'Admin', 'admin', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s1_unit_types`
--

CREATE TABLE `s1_unit_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s1_unit_types`
--

INSERT INTO `s1_unit_types` (`id`, `name`, `short_name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'KG', 'kg', NULL, NULL, '2020-02-08 22:20:12', '2020-02-08 22:20:12'),
(2, 'Liter', 'liter', NULL, NULL, '2020-02-08 22:21:24', '2020-02-08 22:21:24'),
(3, 'Piece', 'piece', NULL, NULL, '2020-02-08 22:22:16', '2020-02-08 22:22:16'),
(4, 'Dozon', 'dozon', NULL, NULL, '2020-02-08 22:22:43', '2020-02-08 22:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `s2_units`
--

CREATE TABLE `s2_units` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_type_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multiply_by` double(14,6) NOT NULL DEFAULT 1.000000,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s2_units`
--

INSERT INTO `s2_units` (`id`, `unit_type_id`, `name`, `short_name`, `description`, `multiply_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'kg', 'kg', NULL, 1.000000, NULL, '2020-02-08 22:20:23', '2020-02-08 22:20:23'),
(2, 1, 'Gram', 'gm', NULL, 1000.000000, NULL, '2020-02-08 22:20:56', '2020-02-08 22:20:56'),
(3, 1, 'Miligram', 'mg', NULL, 1000000.000000, NULL, '2020-02-08 22:21:13', '2020-02-08 22:21:13'),
(4, 2, 'Liter', 'liter', NULL, 1.000000, NULL, '2020-02-08 22:21:37', '2020-02-08 22:21:37'),
(5, 2, 'Mililiter', 'ml', NULL, 1000.000000, NULL, '2020-02-08 22:21:59', '2020-02-08 22:21:59'),
(6, 3, 'piece', 'piece', NULL, 1.000000, NULL, '2020-02-08 22:22:29', '2020-02-08 22:22:29'),
(7, 4, 'dozon', 'dzn', NULL, 1.000000, NULL, '2020-02-08 22:23:16', '2020-02-08 22:23:16'),
(8, 4, 'Hali', 'hali', NULL, 3.000000, NULL, '2020-02-08 22:23:40', '2020-02-08 22:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_id` enum('3','5') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `type_id`, `name`, `phone_no`, `address`, `created_at`, `updated_at`) VALUES
(1, '5', 'Claudine L. Blue', '+44 1632 960379', 'Brownsville, Kentucky(KY), 42210', '2019-12-11 03:26:02', '2019-12-11 03:26:02'),
(2, '5', 'Irene J McClure', '337-255-9859', 'Lafayette, Louisiana(LA), 70501', '2019-12-11 03:27:33', '2019-12-11 03:27:33'),
(3, '3', 'Kelli I Zimmerman', '813-625-1485', 'Tampa, Florida(FL), 33610', '2019-12-11 03:28:40', '2019-12-11 03:28:40'),
(4, '3', 'Liam Hemsworth', ' 256-652-9521', '1883 Strother Street', '2019-12-11 03:31:09', '2019-12-11 03:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_heads`
--

CREATE TABLE `transaction_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `ac_head_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` bigint(20) NOT NULL DEFAULT 0,
  `credit` bigint(20) NOT NULL DEFAULT 0,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionable_id` int(11) NOT NULL,
  `transactionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_heads`
--

INSERT INTO `transaction_heads` (`id`, `ac_head_id`, `name`, `debit`, `credit`, `amount`, `code`, `transactionable_id`, `transactionable_type`, `created_at`, `updated_at`) VALUES
(1, 3, 'MFMSF', 0, 0, 0, '7701', 15, 'App\\AccountHeadChild_I', NULL, '2019-12-12 06:05:20'),
(2, 3, 'UPP', 0, 0, 0, '7702', 15, 'App\\AccountHeadChild_I', NULL, '2019-12-12 06:08:23'),
(3, 3, 'FSP', 0, 0, 0, '7703', 15, 'App\\AccountHeadChild_I', NULL, '2019-11-21 16:02:31'),
(4, 3, 'Enrich', 0, 0, 0, '7704', 15, 'App\\AccountHeadChild_I', NULL, NULL),
(5, 3, 'Training venue Charge', 0, 0, 0, '4501', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(6, 3, 'Conference Room Fare', 0, 0, 0, '4502', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(7, 3, 'Accommodation', 0, 0, 0, '4503', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(8, 3, 'Food Bill received', 0, 0, 0, '4504', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(9, 3, 'Training Service Charge Received', 0, 0, 0, '4505', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(10, 3, 'Training matirials Bill', 0, 0, 0, '4506', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(11, 3, 'Facilitators Honorarirum', 0, 0, 0, '4507', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(12, 3, 'Equipment Charge', 0, 0, 0, '4508', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(13, 3, 'Tranees convence received', 0, 0, 0, '4509', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(14, 3, 'Residence Personal', 0, 0, 0, '4510', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(15, 3, 'Food bill Received (Personal)', 0, 0, 0, '4511', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(16, 4, 'Food cost', 0, 0, 0, '5701', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(17, 4, 'Special Allawonces', 0, 0, 0, '5703', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(18, 4, 'Supporting Staff cost for cook', 0, 0, 0, '5705', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(19, 4, 'Training matirials cost', 0, 0, 0, '5706', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(20, 4, 'Trainees Convyence cost', 0, 0, 0, '5707', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(21, 4, 'RESO. Person H cost', 0, 0, 0, '5708', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(22, 4, 'Extra Service Sttaf Cost', 0, 0, 0, '5709', 19, 'App\\AccountHeadChild_I', NULL, NULL),
(23, 3, 'Dining Charge', 0, 0, 0, '4512', 18, 'App\\AccountHeadChild_I', NULL, NULL),
(26, 1, 'Furniture', 0, 0, 0, '1201', 2, 'App\\AccountHeadChild_II', NULL, NULL),
(27, 1, 'Telephone Set', 0, 0, 0, '1251', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(29, 1, 'Photo copier', 0, 0, 0, '1253', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(30, 1, 'Video Camera', 0, 0, 0, '1255', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(31, 1, 'Vehical A/C', 0, 0, 0, '1301', 4, 'App\\AccountHeadChild_II', NULL, NULL),
(32, 1, 'Motor Cycle', 0, 0, 0, '1302', 4, 'App\\AccountHeadChild_II', NULL, NULL),
(33, 1, 'Computer System', 0, 0, 0, '1351', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(34, 1, 'Television', 0, 0, 0, '1352', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(35, 1, 'Generator', 0, 0, 0, '1353', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(36, 1, 'Refrigerator', 0, 0, 0, '1354', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(37, 1, 'Electric Fan', 0, 0, 0, '1355', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(38, 1, 'Solar System', 0, 0, 0, '1356', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(39, 1, 'Air Conditioner', 0, 0, 0, '1357', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(40, 1, 'Server', 0, 0, 0, '1401', 6, 'App\\AccountHeadChild_II', NULL, NULL),
(41, 1, 'Microcredit Software', 0, 0, 0, '1402', 6, 'App\\AccountHeadChild_II', NULL, NULL),
(42, 1, 'Loan A/C With members -JAGARON', 0, 0, 0, '1901', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(43, 1, 'Loan A/C With members -AGRASHOR', 0, 0, 0, '1902', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(44, 1, 'Loan A/C With members -BUNIAD', 0, 0, 0, '1903', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(45, 1, 'Loan A/C With members -SUFALON', 0, 0, 0, '1904', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(46, 1, 'Loan A/C With members -MFMSF', 0, 0, 0, '1905', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(47, 1, 'Loan A/C With members -EFRRAP', 0, 0, 0, '1906', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(48, 1, 'By Cycle Loan (staff)', 0, 0, 0, '2002', 8, 'App\\AccountHeadChild_II', NULL, NULL),
(49, 1, 'Rain Coat', 0, 0, 0, '2005', 8, 'App\\AccountHeadChild_II', NULL, NULL),
(50, 1, 'LLPI', 0, 0, 0, '2301', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(51, 1, 'DMFI', 0, 0, 0, '2302', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(52, 2, 'JAGARON (SS)', 0, 0, 0, '3141', 18, 'App\\AccountHeadChild_II', NULL, NULL),
(53, 2, 'Monthly Savings(DPS)', 0, 0, 0, '3151', 21, 'App\\AccountHeadChild_II', NULL, NULL),
(54, 2, 'RMC (PKSF) Principal', 0, 0, 0, '3351', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(55, 2, 'UMC (PKSF) Principal', 0, 0, 0, '3352', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(56, 2, 'ME (PKSF) Principal', 0, 0, 0, '3353', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(57, 2, 'JAGARON (PKSF) Principal', 0, 0, 0, '3354', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(58, 2, 'AGRASHOR (PKSF) Principal', 0, 0, 0, '3355', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(59, 2, 'SUFALON (PKSF) Principal', 0, 0, 0, '3356', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(60, 3, 'Other Income', 0, 0, 0, '4256', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(61, 3, 'Income from Training Center', 0, 0, 0, '4259', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(62, 3, 'ENRICH Project Income', 0, 0, 0, '4260', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(63, 3, 'ENRICH Project Grant Income', 0, 0, 0, '4261', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(64, 3, 'Sale of pass book (DPS)', 0, 0, 0, '4262', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(65, 3, 'FK norway project', 0, 0, 0, '4263', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(66, 3, 'Bad Debts', 0, 0, 0, '4264', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(67, 3, 'Income for vahicle sale', 0, 0, 0, '4265', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(68, 3, 'Bank Interest', 0, 0, 0, '4301', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(69, 3, 'Bank Interest?FDR', 0, 0, 0, '4302', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(70, 3, 'Bank Interest?LLP', 0, 0, 0, '4303', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(71, 3, 'Bank Interest?DMF', 0, 0, 0, '4304', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(72, 3, 'Bank Interest?DF', 0, 0, 0, '4305', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(73, 4, 'RMC Service Charge paid to HO', 0, 0, 0, '5221', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(74, 4, 'UMC Service Charge paid to HO', 0, 0, 0, '5222', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(75, 4, 'ME Service Charge paid to HO', 0, 0, 0, '5223', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(76, 4, 'UPP Service Charge paid to HO', 0, 0, 0, '5224', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(77, 4, 'SL Service Charge paid to HO', 0, 0, 0, '5225', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(78, 4, 'ASMP  Service Charge paid to HO', 0, 0, 0, '5226', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(79, 4, 'Printing & Stationery', 0, 0, 0, '5451', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(80, 4, 'Fuel Cost', 0, 0, 0, '5452', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(81, 4, 'Office Rent', 0, 0, 0, '5453', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(82, 4, 'Postage & Telephone', 0, 0, 0, '5454', 16, 'App\\AccountHeadChild_II', NULL, '2020-01-19 05:10:51'),
(83, 4, 'Electricity Bill', 0, 0, 0, '5455', 16, 'App\\AccountHeadChild_II', NULL, '2020-01-19 05:10:51'),
(84, 4, 'Entertainment Cost', 0, 0, 0, '5456', 16, 'App\\AccountHeadChild_II', NULL, '2020-01-19 05:10:51'),
(85, 4, 'Repair & Maintenance Cost', 0, 0, 0, '5457', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(86, 4, 'Gas bill & installation', 0, 0, 0, '5458', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(87, 4, 'Advertisement', 0, 0, 0, '5459', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(88, 4, 'VAT/TAX', 0, 0, 0, '5460', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(89, 4, 'Audit & Professional Fee', 0, 0, 0, '5461', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(90, 4, 'Training Allowance', 0, 0, 0, '5462', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(91, 4, 'Software Cost', 0, 0, 0, '5463', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(92, 4, 'LLPE', 0, 0, 0, '5464', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(93, 4, 'DMFE', 0, 0, 0, '5465', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(94, 4, 'Depricaition', 0, 0, 0, '5466', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(95, 4, 'Legal Expense', 0, 0, 0, '5467', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(96, 4, 'Miscellaneous Expense', 0, 0, 0, '5468', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(97, 4, 'Honorarium fee', 0, 0, 0, '5469', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(98, 4, 'Service Charge Paid to PKSF (RMC)', 0, 0, 0, '5131', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(99, 4, 'Service Charge Paid to PKSF (UMC)', 0, 0, 0, '5132', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(100, 4, 'Service Charge Paid to PKSF (ME)', 0, 0, 0, '5133', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(101, 4, 'Service Charge Paid to PKSF (UPP)', 0, 0, 0, '5134', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(102, 4, 'Service Charge Paid to PKSF (ID loan)', 0, 0, 0, '5135', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(103, 4, 'Service Charge Paid to PKSF (JAGARON)', 0, 0, 0, '5136', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(104, 4, 'Service Charge Paid to PKSF (AGRASHOR)', 0, 0, 0, '5137', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(105, 4, 'Service Charge Paid to PKSF (BUNIAD)', 0, 0, 0, '5138', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(106, 4, 'Interest on Group Savings', 0, 0, 0, '5121', 20, 'App\\AccountHeadChild_II', NULL, NULL),
(107, 2, 'Emergency Fund JAGARON', 0, 0, 0, '3161', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(108, 3, 'Service Charge A/C JAGARON', 0, 0, 0, '4151', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(109, 3, 'Service Charge A/C AGRASHOR', 0, 0, 0, '4152', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(110, 3, 'Service Charge A/C BUNIAD', 0, 0, 0, '4153', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(111, 3, 'Service Charge A/C  SUFOLON', 0, 0, 0, '4154', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(112, 3, 'Service Charge A/C EFRRAP', 0, 0, 0, '4155', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(113, 3, 'Service Charge A/C  MFMSF', 0, 0, 0, '4156', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(114, 4, 'Staff Salary & Allowance', 0, 0, 0, '5311', 15, 'App\\AccountHeadChild_II', NULL, '2020-01-18 02:58:09'),
(115, 4, 'Traveling Cost/ Conveyance', 0, 0, 0, '5471', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(116, 4, 'Bank/D.D/T.T Charge & comm;.', 0, 0, 0, '5501', 24, 'App\\AccountHeadChild_II', NULL, NULL),
(117, 2, 'Current Account Principal (HO & Branch)RMC', 0, 0, 0, '3421', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(118, 2, 'Current Account Principal (HO & Branch)UMC', 0, 0, 0, '3422', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(119, 2, 'Current Account Principal (Branch & HO)ME', 0, 0, 0, '3423', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(120, 2, 'Current Account Principal (Branch & HO)UPP', 0, 0, 0, '3424', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(121, 2, 'Current Account Principal (Branch & HO)SL', 0, 0, 0, '3425', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(122, 2, 'Current Account Principal (Branch & HO)JAGARON', 0, 0, 0, '3426', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(123, 2, 'Current Account Principal (Branch & HO)AGRASHOR', 0, 0, 0, '3427', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(124, 2, 'Current Account Principal (Branch & HO)MFMSF', 0, 0, 0, '3428', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(125, 2, 'Loan Loss Provision Fund (LLP)', 0, 0, 0, '3521', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(126, 2, 'Disaster Management Fund (DMF)', 0, 0, 0, '3522', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(127, 2, 'Accumulated Depreciation', 0, 0, 0, '3523', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(128, 2, 'Provision for Expenses', 0, 0, 0, '3524', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(129, 2, 'Payable for Savings Interest', 0, 0, 0, '3525', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(130, 2, 'Retained Surplus/Deficit', 0, 0, 0, '3621', 28, 'App\\AccountHeadChild_II', NULL, NULL),
(131, 1, 'Building/Office Construction', 0, 0, 0, '1153', 1, 'App\\AccountHeadChild_II', NULL, NULL),
(132, 1, 'Veceom Cleaner', 0, 0, 0, '1358', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(133, 1, 'Sound System', 0, 0, 0, '1359', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(134, 1, 'AC/DC Motors & Feetings', 0, 0, 0, '1360', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(135, 1, 'Lift', 0, 0, 0, '1361', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(136, 1, 'IPS', 0, 0, 0, '1362', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(137, 1, 'Oven', 0, 0, 0, '1363', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(138, 1, 'Multimedia And Overhead Projector', 0, 0, 0, '1254', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(139, 1, 'Fire extinguisher', 0, 0, 0, '1256', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(140, 1, 'DFI', 0, 0, 0, '2303', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(141, 1, 'Savings FDR', 0, 0, 0, '2304', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(142, 1, 'Other Savings FDR', 0, 0, 0, '2305', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(143, 2, 'AGRASHOR (SS)', 0, 0, 0, '3142', 18, 'App\\AccountHeadChild_II', NULL, NULL),
(144, 2, 'BUNIAD (SS)', 0, 0, 0, '3143', 18, 'App\\AccountHeadChild_II', NULL, NULL),
(145, 2, 'MFMSF (SS)', 0, 0, 0, '3144', 18, 'App\\AccountHeadChild_II', NULL, NULL),
(146, 2, 'SUFALON (SS)', 0, 0, 0, '3145', 18, 'App\\AccountHeadChild_II', NULL, NULL),
(147, 2, 'Emergency Fund AGRASOR', 0, 0, 0, '3162', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(148, 2, 'Emergency Fund BUNIAD', 0, 0, 0, '3163', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(149, 2, 'Emergency fund SUFALON', 0, 0, 0, '3164', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(150, 2, 'Emergency Fund FSP', 0, 0, 0, '3165', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(151, 2, 'Emergency Fund EFRRAP', 0, 0, 0, '3166', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(152, 2, 'Health Insurance', 0, 0, 0, '3167', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(153, 4, 'Service Charge Paid to PKSF (SUFOLON)', 0, 0, 0, '5139', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(154, 4, 'Daily Allowance', 0, 0, 0, '5472', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(155, 4, 'Meeting Expenses', 0, 0, 0, '5473', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(156, 4, 'Festival Allowance', 0, 0, 0, '5474', 15, 'App\\AccountHeadChild_II', NULL, NULL),
(157, 4, 'News Paper Bill', 0, 0, 0, '5476', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(158, 4, 'Registration Fees', 0, 0, 0, '5477', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(159, 4, 'Insurance Fee', 0, 0, 0, '5478', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(160, 4, 'Scholarship Fee', 0, 0, 0, '5479', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(161, 4, 'Donation', 0, 0, 0, '5480', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(162, 4, 'Incentive DPS', 0, 0, 0, '5481', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(163, 4, 'Office Maintenance', 0, 0, 0, '5482', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(164, 4, 'Project Profile', 0, 0, 0, '5483', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(165, 4, 'FK norway project expenses', 0, 0, 0, '5484', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(166, 4, 'Expenses for Training Center', 0, 0, 0, '5485', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(167, 4, 'City Allowance', 0, 0, 0, '5486', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(168, 4, 'Cookarige', 0, 0, 0, '5487', 16, 'App\\AccountHeadChild_II', NULL, '2020-01-18 00:17:53'),
(169, 4, 'Security Guard Allowance', 0, 0, 0, '5488', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(170, 4, 'Annual/Special Program', 0, 0, 0, '5489', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(171, 4, 'Service Charge Rebate', 0, 0, 0, '5491', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(172, 4, 'Bank Charge of LLP', 0, 0, 0, '5502', 24, 'App\\AccountHeadChild_II', NULL, NULL),
(173, 4, 'Bank Charge of DMF', 0, 0, 0, '5503', 24, 'App\\AccountHeadChild_II', NULL, NULL),
(174, 3, 'Income From Sale of Land', 0, 0, 0, '4266', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(175, 4, 'Imterest Paid on Bank Loan', 0, 0, 0, '5492', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(176, 4, 'Interest on Savings(staff)', 0, 0, 0, '5493', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(177, 1, 'Advance', 0, 0, 0, '2101', 9, 'App\\AccountHeadChild_II', NULL, NULL),
(178, 1, 'Loan A/C with Climate Change Project', 0, 0, 0, '1511', 29, 'App\\AccountHeadChild_II', NULL, NULL),
(179, 1, 'Loan to MICR Project', 0, 0, 0, '1512', 29, 'App\\AccountHeadChild_II', NULL, NULL),
(180, 1, 'VGD Project Loan A/C', 0, 0, 0, '1513', 29, 'App\\AccountHeadChild_II', NULL, NULL),
(181, 1, 'Non Formal Education Project Loan A/C', 0, 0, 0, '1514', 29, 'App\\AccountHeadChild_II', NULL, NULL),
(182, 2, 'Special Saving (Staff)', 0, 0, 0, '3202', 38, 'App\\AccountHeadChild_II', NULL, NULL),
(183, 2, 'Current Account Principal (Branch & HO) EFRREP', 0, 0, 0, '3429', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(184, 2, 'Current Account Principal (Branch & HO) AGRICULTURE', 0, 0, 0, '3430', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(185, 2, 'Current Account Principal (Branch & HO) ID Loan(C&B)', 0, 0, 0, '3431', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(186, 2, 'Current Account Principal (Branch & HO) MFMSFP(Kachina-1)', 0, 0, 0, '3432', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(187, 2, 'Current Account Principal (Branch & HO) SUFOLON', 0, 0, 0, '3433', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(188, 2, 'payable for Organization cotribution', 0, 0, 0, '3551', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(189, 2, 'payable to Gratuity Fund', 0, 0, 0, '3552', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(190, 2, 'Advance against sale of Land', 0, 0, 0, '3553', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(191, 2, 'Motorcycle Installment Collection', 0, 0, 0, '3554', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(192, 2, 'Advance Grant for ENRICH pro.', 0, 0, 0, '3555', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(193, 2, 'payable to PF Contribution', 0, 0, 0, '3556', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(194, 2, 'payable to PF Loan A/C', 0, 0, 0, '3534', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(195, 2, 'payable to PF Service A/C', 0, 0, 0, '3557', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(196, 2, 'payable to Salary Tax', 0, 0, 0, '3558', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(197, 2, 'ED Loan', 0, 0, 0, '3559', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(198, 3, 'Admission fees A/C', 0, 0, 0, '4267', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(199, 3, 'Sale of Passbook ( Member)', 0, 0, 0, '4268', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(200, 3, 'Sale Of Form Fee', 0, 0, 0, '4269', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(201, 1, 'Office Security', 0, 0, 0, '1551', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(202, 1, 'Suspense A/C', 0, 0, 0, '1552', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(203, 2, 'Current Account Principal (Branch & HO) Training Academy Mymensingh Loan', 0, 0, 0, '3434', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(204, 2, 'Bank Loan (southeast)', 0, 0, 0, '3560', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(205, 2, 'Provident Fund (PF)', 0, 0, 0, '3526', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(206, 4, 'JAGORON Service Charge paid to HO', 0, 0, 0, '2526', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(207, 4, 'AGROSOR Service Charge paid to HO', 0, 0, 0, '2527', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(208, 3, 'Income from Training fee', 0, 0, 0, '4270', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(209, 3, 'Sale of Passbook ( security savings)', 0, 0, 0, '4271', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(210, 1, 'Mobile Set', 0, 0, 0, '1257', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(211, 4, 'EFRRAP Service Charge Paid to HO', 0, 0, 0, '2528', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(212, 2, 'Capital fund', 0, 0, 0, '3602', 32, 'App\\AccountHeadChild_II', NULL, NULL),
(213, 4, 'MFMSF Service charge paid to H/O', 0, 0, 0, '3537', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(214, 4, 'SUFOLON service charge paid to H/O', 0, 0, 0, '3539', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(215, 2, 'ENRICH Pro. (ACL)', 0, 0, 0, '3357', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(216, 2, 'ENRICH Pro. (IGA)', 0, 0, 0, '3358', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(217, 2, 'ENRICH Pro. (LIL)', 0, 0, 0, '3359', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(218, 1, 'Fund A/C With Branch- RMC', 0, 0, 0, '1601', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(219, 1, 'Fund A/C With Branch- UMC', 0, 0, 0, '1602', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(220, 1, 'Fund A/C With Branch- ME', 0, 0, 0, '1603', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(221, 1, 'Fund A/C With Branch- MFMSF', 0, 0, 0, '1604', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(222, 1, 'Fund A/C With Branch- UPP', 0, 0, 0, '1605', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(223, 1, 'Fund A/C With Branch- JAGORAN', 0, 0, 0, '1606', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(224, 1, 'Fund A/C With Branch- AGRASHOR', 0, 0, 0, '1607', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(225, 1, 'Fund A/C With Branch- SUFOLON', 0, 0, 0, '1608', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(226, 1, 'Fund A/C With Branch- AGRICULTURE', 0, 0, 0, '1609', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(227, 1, 'Fund A/C With Branch- SEASONAL', 0, 0, 0, '1610', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(228, 1, 'Fund A/C With Branch- EFRRAP', 0, 0, 0, '1611', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(229, 3, 'Service charge from Branch- MFMSF', 0, 0, 0, '4404', 34, 'App\\AccountHeadChild_II', NULL, NULL),
(230, 1, 'Fund A/C With Branch-FSP', 0, 0, 0, '1612', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(231, 1, 'Fund A/C With Branch ID Loan (C&B)', 0, 0, 0, '1613', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(232, 1, 'Fund A/C With Branch MFMSFP (Kachina-01)', 0, 0, 0, '1614', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(233, 1, 'Fund A/C With Branch ENRICH (IGA PRO.)', 0, 0, 0, '1615', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(234, 1, 'Fund A/C With Branch ENRICH (Livelihood impro.)', 0, 0, 0, '1616', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(235, 1, 'Fund A/C With Branch ENRICH (Asset creation.)', 0, 0, 0, '1617', 33, 'App\\AccountHeadChild_II', NULL, NULL),
(236, 2, 'Emergency Fund MFMSF', 0, 0, 0, '3168', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(237, 2, 'Other Branch Loan A/C', 0, 0, 0, '3565', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(238, 4, 'BUNIAD Service Charge Paid HO', 0, 0, 0, '3540', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(239, 4, 'Expenses for training to Beneficiaries', 0, 0, 0, '5494', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(240, 2, 'Current Account Principle ( Branch & h/O ) -FSP', 0, 0, 0, '3435', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(241, 2, 'Current Account Principle ( Branch & h/O ) ENRICH (LIL)', 0, 0, 0, '3436', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(242, 2, 'Current Account Principle ( Branch & h/O ) ENRICH ( ACL)', 0, 0, 0, '3437', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(243, 1, 'Loan A/C With members - FSP', 0, 0, 0, '1907', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(244, 1, 'Loan A/C With members - LRP', 0, 0, 0, '1908', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(245, 3, 'Service Charge A/C FSP', 0, 0, 0, '4157', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(246, 3, 'Service Charge A/C DMF   [4158]', 0, 0, 0, '4158', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(247, 4, 'FSP Service Charge Paid HO', 0, 0, 0, '3541', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(248, 4, 'Bank Charge DF', 0, 0, 0, '5504', 24, 'App\\AccountHeadChild_II', NULL, NULL),
(249, 4, 'Decoration Fee', 0, 0, 0, '5495', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(250, 4, 'Field Day', 0, 0, 0, '5496', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(251, 4, 'Project Contribution', 0, 0, 0, '5498', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(252, 1, 'Reserve Fund FDR', 0, 0, 0, '2306', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(253, 2, 'Bank Loan (Midland )', 0, 0, 0, '3561', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(254, 3, 'Service Charge A/C - LRP', 0, 0, 0, '4159', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(255, 2, 'ED', 0, 0, 0, '3711', 35, 'App\\AccountHeadChild_II', NULL, NULL),
(256, 2, 'PF', 0, 0, 0, '3712', 35, 'App\\AccountHeadChild_II', NULL, NULL),
(257, 2, 'DMF', 0, 0, 0, '3713', 35, 'App\\AccountHeadChild_II', NULL, NULL),
(258, 2, 'Current Account Principle ( Branch & h/O ) LRP', 0, 0, 0, '3439', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(259, 4, 'Work Shop', 0, 0, 0, '5497', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(260, 3, 'Bank Interest-FDR', 0, 0, 0, '4397', 13, 'App\\AccountHeadChild_II', NULL, NULL),
(261, 1, 'By Cycle', 0, 0, 0, '1303', 4, 'App\\AccountHeadChild_II', NULL, NULL),
(262, 4, 'Abnormal Loss', 0, 0, 0, '5470', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(263, 1, 'Loan A/C with Member-DMF', 0, 0, 0, '1909', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(264, 2, 'Current Account Principle(Branch & H/O)-DMF', 0, 0, 0, '3440', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(265, 1, 'Loan A/C With members -IGA', 0, 0, 0, '1910', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(266, 1, 'Loan A/C With members -LIL', 0, 0, 0, '1911', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(267, 1, 'Loan A/C With members -ACL', 0, 0, 0, '1912', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(268, 3, 'Service Charge A/C IGA', 0, 0, 0, '4160', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(269, 3, 'Service Charge A/C LIL', 0, 0, 0, '4161', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(270, 3, 'Service Charge A/C ACL', 0, 0, 0, '4162', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(271, 2, 'DD Admin', 0, 0, 0, '3715', 35, 'App\\AccountHeadChild_II', NULL, NULL),
(272, 3, 'Office Rent Receive', 0, 0, 0, '4272', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(273, 1, 'Mobile Loan', 0, 0, 0, '2006', 8, 'App\\AccountHeadChild_II', NULL, NULL),
(274, 4, 'DMF Service Charge Paid HO', 0, 0, 0, '3542', 14, 'App\\AccountHeadChild_II', NULL, NULL),
(275, 2, 'Emergency Fund Enrich (IGA)', 0, 0, 0, '3169', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(276, 2, 'Emergency Fund Enrich (LIL)', 0, 0, 0, '3170', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(277, 2, 'Emergency Fund Enrich (ACL)', 0, 0, 0, '3171', 22, 'App\\AccountHeadChild_II', NULL, NULL),
(278, 4, 'Enrich Project Expenses', 0, 0, 0, '5499', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(279, 4, 'Bad Debts Expenditure', 0, 0, 0, '5651', 36, 'App\\AccountHeadChild_II', NULL, NULL),
(280, 4, 'Training Center Service Charge Paid to HO', 0, 0, 0, '3543', 14, 'App\\AccountHeadChild_II', NULL, '2020-01-18 02:58:09'),
(281, 3, 'Income for Motorcycle sale', 0, 0, 0, '4273', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(282, 3, 'Income for Air Condition sale', 0, 0, 0, '4274', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(283, 3, 'FK Narway project Income', 0, 0, 0, '4275', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(284, 4, 'Provident Fund Expenses', 0, 0, 0, '5475', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(285, 4, 'Gratuity Fund Expenses', 0, 0, 0, '5490', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(286, 2, 'Seasonal  (PKSF) Principal', 0, 0, 0, '3361', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(287, 2, 'MFMSF  (PKSF) Principal', 0, 0, 0, '3362', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(288, 2, 'EFRRAP  (PKSF) Principal', 0, 0, 0, '3363', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(289, 2, 'MEP  (PKSF) Principal', 0, 0, 0, '3364', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(290, 2, 'FSP  (PKSF) Principal', 0, 0, 0, '3365', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(291, 2, 'LRP  (PKSF) Principal', 0, 0, 0, '3366', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(292, 2, 'Agriculture  (PKSF) Principal', 0, 0, 0, '3367', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(293, 2, 'UPP  (PKSF) Principal', 0, 0, 0, '3368', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(294, 2, 'ID  (PKSF) Principal', 0, 0, 0, '3369', 11, 'App\\AccountHeadChild_II', NULL, NULL),
(295, 4, 'Service Charge Paid to PKSF (Seasonal)', 0, 0, 0, '5140', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(296, 4, 'Service Charge Paid to PKSF (Agriculture)', 0, 0, 0, '5141', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(297, 4, 'Service Charge Paid to PKSF (MFMSF)', 0, 0, 0, '5142', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(298, 4, 'Service Charge Paid to PKSF (EFRRAP)', 0, 0, 0, '5143', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(299, 4, 'Service Charge Paid to PKSF (MEP)', 0, 0, 0, '5144', 19, 'App\\AccountHeadChild_II', NULL, '2020-01-19 05:10:51'),
(300, 4, 'Service Charge Paid to PKSF (FSP)', 0, 0, 0, '5145', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(301, 4, 'Service Charge Paid to PKSF (LRP)', 0, 0, 0, '5146', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(302, 2, 'Current Account Principal (Branch & HO) Training Center Trishal Loan', 0, 0, 0, '3441', 26, 'App\\AccountHeadChild_II', NULL, NULL),
(303, 3, 'House Rent', 0, 0, 0, '4255', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(304, 1, 'Project Security A/C', 0, 0, 0, '1553', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(305, 1, 'Washing Machine', 0, 0, 0, '1366', 5, 'App\\AccountHeadChild_II', NULL, NULL),
(306, 4, 'Service Charge Paid to PKSF ENRICH(IGA)', 0, 0, 0, '5147', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(307, 4, 'Service Charge Paid to PKSF ENRICH(LIL)', 0, 0, 0, '5148', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(308, 4, 'Service Charge Paid to PKSF ENRICH(ACL)', 0, 0, 0, '5149', 19, 'App\\AccountHeadChild_II', NULL, NULL),
(309, 3, 'Income for Generatar sale', 0, 0, 0, '4276', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(310, 1, 'Grihayan Project Loan', 0, 0, 0, '1554', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(311, 2, 'Mutual Trust Bank Loan A/C', 0, 0, 0, '3562', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(312, 2, 'NRB Bank Loan A/C', 0, 0, 0, '3563', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(313, 3, 'Vat Received', 0, 0, 0, '4277', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(314, 3, 'Tax Received', 0, 0, 0, '4278', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(315, 4, 'Vat Paid', 0, 0, 0, '5975', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(316, 4, 'Tax Paid', 0, 0, 0, '5976', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(317, 1, 'FDR Interest Receivable A/C', 0, 0, 0, '2307', 10, 'App\\AccountHeadChild_II', NULL, NULL),
(318, 1, 'FK Norway Project Loan', 0, 0, 0, '1516', 29, 'App\\AccountHeadChild_II', NULL, NULL),
(319, 3, 'Income from Computer Sale', 0, 0, 0, '4257', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(320, 4, 'Incentive Allowance', 0, 0, 0, '5977', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(321, 1, 'Security For Land', 0, 0, 0, '1556', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(322, 1, 'Motor Cycle Loan A/C (staff)', 0, 0, 0, '2007', 8, 'App\\AccountHeadChild_II', NULL, NULL),
(323, 4, 'HardShip Allowance(ED)', 0, 0, 0, '5978', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(324, 2, 'Capitat Gain From Motorcycle', 0, 0, 0, '3603', 32, 'App\\AccountHeadChild_II', NULL, NULL),
(325, 2, 'Project Security Received', 0, 0, 0, '3527', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(326, 1, 'Blood Pressur Machine', 0, 0, 0, '1258', 3, 'App\\AccountHeadChild_II', NULL, NULL),
(327, 4, 'Loss On Asset', 0, 0, 0, '5652', 36, 'App\\AccountHeadChild_II', NULL, NULL),
(328, 4, 'Pension Expenses', 0, 0, 0, '5979', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(329, 2, 'Health Savings (staff)', 0, 0, 0, '3203', 38, 'App\\AccountHeadChild_II', NULL, NULL),
(330, 4, 'Loss On Sale Of Land', 0, 0, 0, '5653', 36, 'App\\AccountHeadChild_II', NULL, NULL),
(331, 1, 'Vehical Loan A/C (ED)', 0, 0, 0, '2008', 8, 'App\\AccountHeadChild_II', NULL, NULL),
(332, 2, 'Health Project A/C', 0, 0, 0, '3528', 27, 'App\\AccountHeadChild_II', NULL, NULL),
(333, 2, 'Advance Grant for Probin Kormosuchi', 0, 0, 0, '3564', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(334, 3, 'Probin Kormosuchi Grant Income', 0, 0, 0, '4280', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(335, 4, 'Probin Kormosuchi Expenses', 0, 0, 0, '5980', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(336, 4, 'Interest on FGS Savings', 0, 0, 0, '5122', 20, 'App\\AccountHeadChild_II', NULL, NULL),
(337, 1, 'DI Project Loan', 0, 0, 0, '1555', 31, 'App\\AccountHeadChild_II', NULL, NULL),
(338, 4, 'Adolescent Confurance', 0, 0, 0, '5981', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(339, 1, 'Advance For Building', 0, 0, 0, '2102', 9, 'App\\AccountHeadChild_II', NULL, NULL),
(340, 1, 'Loan A/C With members - EDUCATION', 0, 0, 0, '1913', 7, 'App\\AccountHeadChild_II', NULL, NULL),
(341, 3, 'Service Charge A/C EDUCATION', 0, 0, 0, '4163', 23, 'App\\AccountHeadChild_II', NULL, NULL),
(342, 2, 'Staff Welfare', 0, 0, 0, '3208', 40, 'App\\AccountHeadChild_II', NULL, NULL),
(343, 1, 'Advance Income Tax', 0, 0, 0, '2103', 9, 'App\\AccountHeadChild_II', NULL, NULL),
(344, 2, 'Advance against Training', 0, 0, 0, '3566', 30, 'App\\AccountHeadChild_II', NULL, NULL),
(345, 4, 'Other Expenses', 0, 0, 0, '5982', 16, 'App\\AccountHeadChild_II', NULL, NULL),
(346, 3, 'Sale of Pass Book (FGS)', 0, 0, 0, '4279', 12, 'App\\AccountHeadChild_II', NULL, '2019-11-22 21:47:55'),
(347, 3, 'Income From Sale Of Furniture', 0, 0, 0, '4254', 12, 'App\\AccountHeadChild_II', NULL, NULL),
(348, 4, 'JAGARON (GS)', 0, 0, 0, '3121', 3, 'App\\AccountHeadChild_III', NULL, NULL),
(349, 4, 'AGRASHOR (GS)', 0, 0, 0, '3122', 4, 'App\\AccountHeadChild_III', NULL, NULL),
(350, 4, 'BUNIAD (GS)', 0, 0, 0, '3123', 5, 'App\\AccountHeadChild_III', NULL, NULL),
(351, 4, 'MFMSF (GS)', 0, 0, 0, '3124', 6, 'App\\AccountHeadChild_III', NULL, NULL),
(352, 4, 'SUFALON (GS)', 0, 0, 0, '3125', 7, 'App\\AccountHeadChild_III', NULL, NULL),
(353, 1, 'Cash in hand', 0, 0, 0, '1751', 1, 'App\\AccountHeadChild_III', NULL, '2019-12-12 06:08:24'),
(354, 1, 'Sonali Bank,H/O, C/A-33012835', 0, 0, 0, '1802', 2, 'App\\AccountHeadChild_III', NULL, '2019-12-12 06:08:24'),
(355, 1, 'Bangladesh Krishi Bank,H/O,C/A-527', 0, 0, 0, '1803', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(356, 1, 'Primier Bank,H/O,C/A-272', 0, 0, 0, '1804', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(357, 1, 'National Bank,H/O,C/A-33023223', 0, 0, 0, '1805', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(358, 1, 'Mutual Trast Bank,H/O,C/A-14', 0, 0, 0, '1806', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(359, 1, 'South East Bank,H/O,0011100005467', 0, 0, 0, '1807', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(360, 1, 'Midland  Bank,H/O,C/A-00111490000483', 0, 0, 0, '1808', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(361, 1, 'Pubali  Bank,Mymensingh-01,C/D-8821', 0, 0, 0, '1809', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(362, 1, 'Prime  Bank,Mymensingh-01,C/A-9730', 0, 0, 0, '1810', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(363, 1, 'National  Bank,Mymensingh-01,C/A-21491', 0, 0, 0, '1811', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(364, 1, 'National  Bank,Mymensingh-02,C/D-33022052', 0, 0, 0, '1812', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(365, 1, 'Prime  Bank,Mymensingh-02,C/A-9731', 0, 0, 0, '1813', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(366, 1, 'Bangladesh Krishi Bank,Gouripur-02,C/A-175', 0, 0, 0, '1814', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(367, 1, 'Rupali  Bank,Samgonj,C/A-836', 0, 0, 0, '1816', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(368, 1, 'Rupali  Bank,Dapunia-01,C/A-6241', 0, 0, 0, '1817', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(369, 1, 'Rupali  Bank,Dapunia-02,C/A-631', 0, 0, 0, '1818', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(370, 1, 'South East Bank Mymensingh-1, C/A-214', 0, 0, 0, '1821', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(371, 1, 'Rupali Bank, Dapunia-2, C/A-781', 0, 0, 0, '1819', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(372, 1, 'Krishi Bank Dapunia-3,C/A-129', 0, 0, 0, '1820', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(373, 4, 'EFRRAP (GS)', 0, 0, 0, '3126', 8, 'App\\AccountHeadChild_III', NULL, NULL),
(374, 1, 'Krishi Bank Fulbaria-my, C/A-8945', 0, 0, 0, '1822', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(375, 1, 'Sunali Bank fulbaria-my, C/A-411', 0, 0, 0, '1823', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(376, 4, 'FSP (GS)', 0, 0, 0, '3127', 9, 'App\\AccountHeadChild_III', NULL, NULL),
(377, 1, 'Krishi Bank Dhanikhula, C/A-225', 0, 0, 0, '1824', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(378, 1, 'Rupali Bank, Trishal, C/A-1138', 0, 0, 0, '1825', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(379, 1, 'Pubali Bank, Trishal, C/A-30287', 0, 0, 0, '1826', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(380, 1, 'Sonali Bank,Valuka, C/A-33012075', 0, 0, 0, '1827', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(381, 1, 'Sonali Bank, muktagasa, C/A- 001031283', 0, 0, 0, '1828', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(382, 1, 'Sonali Bank, muktagasa, C/A- 32342', 0, 0, 0, '1829', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(383, 1, 'Sonali Bank, Asim Bazer Branch, C/A-3332', 0, 0, 0, '1830', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(384, 1, 'Sunali Bank,muktagasa-1 Branch, C/A-31077', 0, 0, 0, '1831', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(385, 1, 'National Bank, muktagasa Branch,C/a-4872', 0, 0, 0, '1832', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(386, 1, 'Sunali Bank, kalibari Branch, C/A- 375', 0, 0, 0, '1833', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(387, 1, 'Sunali Bank, Kashorgonj Branch, C/A- 4153', 0, 0, 0, '1834', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(388, 1, 'UCB Bank Mawna Branch, C/A-3207', 0, 0, 0, '1835', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(389, 1, 'Mitual Trust Bank Masterbari Branch, C/A--0032', 0, 0, 0, '1836', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(390, 1, 'Mitual Trust Bank Masterbari Branch, C/A--3593', 0, 0, 0, '1837', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(391, 1, 'First security Islami Bank Masterbari Branch, C/A--0022', 0, 0, 0, '1838', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(392, 1, 'Krishi Bank Jaina Bazer Branch, C/A--193', 0, 0, 0, '1839', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(393, 1, 'Rupaly bank Balipara branch, C/A--749', 0, 0, 0, '1840', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(394, 1, 'Mitual Trust Bank, Goforgoan Branch, C/A--0403', 0, 0, 0, '1841', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(395, 1, 'Sunaly bank, Goforgoan Branch,C/A-2996', 0, 0, 0, '1842', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(396, 1, 'Mitual Trust Bank, Pirujali Branch, C/A-6962', 0, 0, 0, '1843', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(397, 1, 'Sunali Bank, Gouripur Branch, C/A-22774', 0, 0, 0, '1844', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(398, 1, 'Rupali Bank. mallikbari branch.C/A- 362', 0, 0, 0, '1845', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(399, 1, 'pubali Bank.Joydebpur Branch,C/A-3315', 0, 0, 0, '1846', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(400, 1, 'Krishi Bank, Fulbaria- Kaliakoir, C/A-206', 0, 0, 0, '1847', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(401, 1, 'Al Arafa Islami Bank,Fulbaria-Kaliakoir,C/A-3958', 0, 0, 0, '1848', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(402, 1, 'Krishi Bank,Mirjapur Branch,C/A-636/4', 0, 0, 0, '1849', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(403, 1, 'Shahjalal Islami Bank Limited,Bhaluka Branch, C/A-5738', 0, 0, 0, '1850', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(404, 1, 'National Bank Limited, Bhaluka Branch, C/A-116', 0, 0, 0, '1851', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(405, 1, 'Sonali Bank Limited, Bhaluka Branch, C/A-6226', 0, 0, 0, '1852', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(406, 1, 'Sonali Bank Limited, Bhaluka Branch, C/A-4989', 0, 0, 0, '1853', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(407, 1, 'Sonali Bank Limited, Bhaluka VBranch, C/A-2331', 0, 0, 0, '1854', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(408, 1, 'Sonali Bank Limited, Bhaluka VBranch, C/A-6218', 0, 0, 0, '1855', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(409, 1, 'First security Bank Limited Bhaluka, C/A-0065', 0, 0, 0, '1856', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(410, 1, 'Mitual Trust Bank limited, Masterbari Branch,C/A-3600', 0, 0, 0, '1857', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(411, 1, 'Mitual trust Bank limited, Masterbari Branch,C/A-0023', 0, 0, 0, '1858', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(412, 1, 'Midland Bank Limited,Masterbari Branch,C/A-0119', 0, 0, 0, '1859', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(413, 1, 'First Security Islami Bank Limited , Masterbari branch,C/A-0005', 0, 0, 0, '1860', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(414, 1, 'Krishi Bank, Nalua Branch, C/A- 188', 0, 0, 0, '1861', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(415, 1, 'Krishi Bank, Kachua Branch A/C No- 239', 0, 0, 0, '1862', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(416, 1, 'Natinal Bank, Sakhipur Branch A/C No-1573', 0, 0, 0, '1863', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(417, 1, 'Sonali bank, Sreepur Branch, L.T.D Acc No: 200000095', 0, 0, 0, '1864', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(418, 1, 'First Secutity Islami Bank, Srepur Branch,  L.T.D Acc No: 014311100004170', 0, 0, 0, '1865', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(419, 4, 'Enrich IGA (GS)', 0, 0, 0, '3128', 10, 'App\\AccountHeadChild_III', NULL, NULL),
(420, 4, 'Enrich LIL (GS)', 0, 0, 0, '3129', 11, 'App\\AccountHeadChild_III', NULL, NULL),
(421, 4, 'Enrich ACL (GS)', 0, 0, 0, '3130', 3, 'App\\AccountHeadChild_III', NULL, NULL),
(422, 1, 'Agroni bank limited.Nalua Branch, C/A-0343', 0, 0, 0, '1866', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(423, 1, 'Sonali Bank, Shibgonj Branch, C/A-195', 0, 0, 0, '1867', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(424, 1, 'Janota Bank. sagordighi branch. C/A-4366', 0, 0, 0, '1868', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(425, 1, 'Premier Bank, Bhaluka Branch, C/A-0125', 0, 0, 0, '1869', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(426, 1, 'Exim Bank Limited,Seed store Branch, C/A-22518', 0, 0, 0, '1870', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(427, 1, 'Krishi bank, Batajor Branch,C/A- 73', 0, 0, 0, '1871', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(428, 1, 'Mutual Trust Bank H/O A/C N-0054-0210003562', 0, 0, 0, '1872', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(429, 1, 'NRB Bank H/O A/C-1012010069609', 0, 0, 0, '1873', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(430, 1, 'Dutch Bangla Bank H/O A/C-2591101227', 0, 0, 0, '1874', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(431, 1, 'Prime Bank, T.A - Mymensingh Branch, C/A-17431030009729', 0, 0, 0, '1875', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(432, 1, 'Sunaly Bank, T.A - Matsha Gabeshana Institute Branch, C/A-3301200006064', 0, 0, 0, '1876', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(433, 1, 'Rupali Bank, Trishal Training Centre, C/A-1684', 0, 0, 0, '1877', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(434, 1, 'South East Bank Limited,Konabari Branch, C/A-004611100000801', 0, 0, 0, '1878', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(435, 1, 'National Bank Limited, Madhupur Branch,C/A-1080002331657', 0, 0, 0, '1879', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(436, 1, 'First Security Islami Bank, Uthura Branch,C/A-487', 0, 0, 0, '1890', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(437, 1, 'Sunali Bank,Nandina Branch,C/A-2618702000374', 0, 0, 0, '1891', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(438, 1, 'Rupali Bank, Netrokona Branch, C/A-0836020001568', 0, 0, 0, '1892', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(439, 1, 'UCB Bank, GHatail Branch, C/A-1571301000000143', 0, 0, 0, '1893', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(440, 4, 'Jagaron (H.S)', 0, 0, 0, '3181', 3, 'App\\AccountHeadChild_III', NULL, NULL),
(441, 4, 'Agroshor (H.S)', 0, 0, 0, '3182', 4, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(442, 4, 'Sufolon (H.S)', 0, 0, 0, '3183', 7, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(443, 1, 'MTB, MasterBari branch, C/A- 00760210005662', 0, 0, 0, '1894', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(444, 1, 'National bank, Trishal branch, C/A-1176002468821', 0, 0, 0, '1895', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(445, 1, 'Pubali Bank Limited. Kashimpur Branch, C/A-0748901029221', 0, 0, 0, '1896', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(446, 1, 'Midland Bank, Mirjapur Branch, C/A:00041490000044', 0, 0, 0, '1897', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(447, 1, 'Southeast bank Limited, Muktagasa Branch, C/A:00000131', 0, 0, 0, '1898', 2, 'App\\AccountHeadChild_III', NULL, NULL),
(448, 4, 'JAGARON (FGS)', 0, 0, 0, '3191', 3, 'App\\AccountHeadChild_III', NULL, NULL),
(449, 4, 'AGRASHOR (FGS)', 0, 0, 0, '3192', 4, 'App\\AccountHeadChild_III', NULL, NULL),
(450, 4, 'SUFALON (FGS)', 0, 0, 0, '3193', 7, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(451, 1, 'Sonali Bank, Banani Branch, C/A 0105702000461', 0, 0, 0, '1899', 2, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(452, 1, 'NCC Bank Ltd A/C-00720210010712', 0, 0, 0, '1880', 2, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(453, 4, 'EDUCATION (GS)', 0, 0, 0, '3131', 13, 'App\\AccountHeadChild_III', NULL, '2019-12-13 11:32:09'),
(455, 1, 'Account Head', 0, 0, 0, '000', 1, 'App\\AccountHeadChild_II', '2020-01-18 00:56:47', '2020-01-18 00:56:47'),
(459, 1, 'Rice', 0, 0, 0, '2000', 41, 'App\\AccountHeadChild_II', '2020-01-18 01:13:44', '2020-01-18 02:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mtcadmin01', 1, 'mtcadmin01@gmail.com', NULL, '$2y$10$JsIPV2aJAK8tDJ7TQphz.enBRWkqEH90COX5hFN9JzupbJOnjzl0O', 'PAQ1TsPhB0SJlwEDOiwOWdyzUyCdPg91qeOOeEQACo25chDe5zg6C9wrpJoL', '2019-08-14 20:30:21', '2019-08-14 20:30:21'),
(2, 'farhan', 1, 'faru@gmail.com', NULL, '$2y$10$.iwzTL10vX9zGNzjOEoV0uASk0.yGAwjR6TX1YB4wQyF.HphFhFJ.', NULL, '2019-09-15 18:04:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `v1_venues`
--

CREATE TABLE `v1_venues` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `v1_venues`
--

INSERT INTO `v1_venues` (`id`, `name`, `location`, `price`, `feature`, `created_at`, `updated_at`) VALUES
(50, 'VIP Venue-400', '4th floor (Extension)', '28000', 'Capacity of upto 800 persons.\r\nSurround Sound Systems.\r\nAir conditioned.', NULL, NULL),
(51, 'Venue-200', '2nd floor', '18000', 'Capacity of upto 350 persons.\r\nSurround Sound Systems.\r\nAir Conditioned.', NULL, NULL),
(52, 'Venue-401', '4th floor (Extension)', '16000', 'Capacity of upto 120 persons. Surround Sound Systems. Air Conditioned.', NULL, NULL),
(53, 'Executive Venue-500', '5th floor', '15000', 'Capacity of upto 100 persons. Surround Sound Systems. Air Conditioned.', NULL, NULL),
(54, 'Venue-201', '2nd floor', '10000', 'Hall Room Capacity-10-25', NULL, NULL),
(55, 'Venue-100', '1st floor', '6000', 'Dining. Capacity-90', NULL, NULL),
(56, 'Venue-101', '1st floor', '6000', 'Vip A/C Dining Capacity-25', NULL, NULL),
(57, 'Venue-102', '1st floor', '5000', 'Hall Room Capacity 30-55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(10) UNSIGNED NOT NULL,
  `guest_id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appearance` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `v_group_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `debit_head_id` int(10) UNSIGNED NOT NULL,
  `credit_head_id` int(10) UNSIGNED NOT NULL,
  `amount` double(14,2) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_groups`
--

CREATE TABLE `voucher_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

CREATE TABLE `voucher_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'Payment', 'pv', NULL, NULL),
(2, 'Receipt', 'rv', NULL, NULL),
(3, 'Journal', 'jr', NULL, NULL),
(4, 'Contra', 'cr', NULL, NULL),
(5, 'Hotel Receipt', 'rv', NULL, NULL),
(6, 'Venue Receipt', 'rv', NULL, NULL),
(7, 'Restaurant Receipt', 'rv', NULL, NULL),
(8, 'Restaurant Payment', 'pv', NULL, NULL),
(9, 'Inventory Payment', 'pv', NULL, NULL),
(10, 'Auto Receipt', 'rv', NULL, NULL),
(11, 'Auto Payment', 'pv', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_update_histories`
--

CREATE TABLE `voucher_update_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `voucher_id` int(10) UNSIGNED NOT NULL,
  `date_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` double(14,2) NOT NULL DEFAULT 0.00,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_heads_code_unique` (`code`);

--
-- Indexes for table `account_head_child_i`
--
ALTER TABLE `account_head_child_i`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_head_child_i_ac_head_id_index` (`ac_head_id`);

--
-- Indexes for table `account_head_child_ii`
--
ALTER TABLE `account_head_child_ii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_head_child_ii_ac_head_child_i_id_index` (`ac_head_child_i_id`);

--
-- Indexes for table `account_head_child_iii`
--
ALTER TABLE `account_head_child_iii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_head_child_iii_ac_head_child_ii_id_index` (`ac_head_child_ii_id`);

--
-- Indexes for table `account_head_child_iv`
--
ALTER TABLE `account_head_child_iv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_head_child_iv_ac_head_child_iii_id_index` (`ac_head_child_iii_id`);

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billings_guest_id_index` (`guest_id`),
  ADD KEY `billings_date_id_index` (`date_id`),
  ADD KEY `billings_mis_voucher_id_index` (`mis_voucher_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_guest_id_index` (`guest_id`),
  ADD KEY `bookings_billing_id_index` (`billing_id`),
  ADD KEY `bookings_room_id_index` (`room_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkouts_billing_id_index` (`billing_id`),
  ADD KEY `checkouts_mis_voucher_id_index` (`mis_voucher_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_balance`
--
ALTER TABLE `current_balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `current_balance_thead_id_index` (`thead_id`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveries_current_stock_id_index` (`current_stock_id`),
  ADD KEY `deliveries_stock_id_index` (`stock_id`),
  ADD KEY `deliveries_date_id_index` (`date_id`),
  ADD KEY `deliveries_unit_id_index` (`unit_id`);

--
-- Indexes for table `e1_departments`
--
ALTER TABLE `e1_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e2_employee_designations`
--
ALTER TABLE `e2_employee_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e3_salary_grades`
--
ALTER TABLE `e3_salary_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e4_employees`
--
ALTER TABLE `e4_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e4_employees_department_id_index` (`department_id`),
  ADD KEY `e4_employees_designation_id_index` (`designation_id`),
  ADD KEY `e4_employees_salary_grade_id_index` (`salary_grade_id`);

--
-- Indexes for table `e5_leave_categories`
--
ALTER TABLE `e5_leave_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e6_leaves`
--
ALTER TABLE `e6_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e6_leaves_leave_category_id_foreign` (`leave_category_id`);

--
-- Indexes for table `general_infos`
--
ALTER TABLE `general_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h1_building_types`
--
ALTER TABLE `h1_building_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h2_buildings`
--
ALTER TABLE `h2_buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `h2_buildings_building_type_foreign` (`building_type`);

--
-- Indexes for table `h3_floor_types`
--
ALTER TABLE `h3_floor_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h4_floors`
--
ALTER TABLE `h4_floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `h4_floors_building_id_foreign` (`building_id`),
  ADD KEY `h4_floors_floor_type_foreign` (`floor_type`);

--
-- Indexes for table `h5_room_categories`
--
ALTER TABLE `h5_room_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h6_rooms`
--
ALTER TABLE `h6_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `h6_rooms_floor_id_foreign` (`floor_id`),
  ADD KEY `h6_rooms_category_id_foreign` (`category_id`);

--
-- Indexes for table `m1_mis_heads`
--
ALTER TABLE `m1_mis_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m1_mis_heads_voucher_type_id_index` (`voucher_type_id`),
  ADD KEY `m1_mis_heads_credit_head_id_index` (`credit_head_id`),
  ADD KEY `m1_mis_heads_debit_head_id_index` (`debit_head_id`);

--
-- Indexes for table `m2_mis_head_child_i`
--
ALTER TABLE `m2_mis_head_child_i`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m2_mis_head_child_i_mis_head_id_index` (`mis_head_id`),
  ADD KEY `m2_mis_head_child_i_credit_head_id_index` (`credit_head_id`),
  ADD KEY `m2_mis_head_child_i_debit_head_id_index` (`debit_head_id`);

--
-- Indexes for table `m3_mis_ledger_heads`
--
ALTER TABLE `m3_mis_ledger_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `m3_mis_ledger_heads_code_unique` (`code`),
  ADD KEY `m3_mis_ledger_heads_mis_head_id_index` (`mis_head_id`),
  ADD KEY `m3_mis_ledger_heads_unit_type_id_index` (`unit_type_id`);

--
-- Indexes for table `m4_mis_vouchers_i`
--
ALTER TABLE `m4_mis_vouchers_i`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m4_mis_vouchers_i_mis_head_id_index` (`mis_head_id`),
  ADD KEY `m4_mis_vouchers_i_ledger_head_id_index` (`ledger_head_id`),
  ADD KEY `m4_mis_vouchers_i_date_id_index` (`date_id`),
  ADD KEY `m4_mis_vouchers_i_voucher_id_index` (`voucher_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mis_current_stocks`
--
ALTER TABLE `mis_current_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mis_current_stocks_stock_id_index` (`stock_id`),
  ADD KEY `mis_current_stocks_date_id_index` (`date_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_billing_id_index` (`billing_id`),
  ADD KEY `payments_mis_voucher_id_index` (`mis_voucher_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_mis_voucher_id_index` (`mis_voucher_id`),
  ADD KEY `purchases_purchase_group_id_index` (`purchase_group_id`),
  ADD KEY `purchases_current_stock_id_index` (`current_stock_id`),
  ADD KEY `purchases_stock_id_index` (`stock_id`),
  ADD KEY `purchases_unit_id_index` (`unit_id`),
  ADD KEY `purchases_supplier_id_index` (`supplier_id`),
  ADD KEY `purchases_receiver_id_index` (`receiver_id`);

--
-- Indexes for table `purchase_groups`
--
ALTER TABLE `purchase_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_groups_mis_head_id_index` (`mis_head_id`),
  ADD KEY `purchase_groups_date_id_index` (`date_id`),
  ADD KEY `purchase_groups_user_id_index` (`user_id`);

--
-- Indexes for table `r5_meal_types`
--
ALTER TABLE `r5_meal_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r6_meal_items`
--
ALTER TABLE `r6_meal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r6_meal_items_meal_type_id_foreign` (`meal_type_id`);

--
-- Indexes for table `r7_menu_types`
--
ALTER TABLE `r7_menu_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r9_food_menu`
--
ALTER TABLE `r9_food_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r9_food_menu_menu_type_id_index` (`menu_type_id`);

--
-- Indexes for table `r10_food_menu_items`
--
ALTER TABLE `r10_food_menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r10_food_menu_items_food_menu_id_index` (`food_menu_id`),
  ADD KEY `r10_food_menu_items_meal_item_id_index` (`meal_item_id`);

--
-- Indexes for table `r11_food_sales`
--
ALTER TABLE `r11_food_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r11_food_sales_billing_id_index` (`billing_id`),
  ADD KEY `r11_food_sales_date_id_index` (`date_id`),
  ADD KEY `r11_food_sales_menu_id_index` (`menu_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s1_unit_types`
--
ALTER TABLE `s1_unit_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s2_units`
--
ALTER TABLE `s2_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s2_units_unit_type_id_index` (`unit_type_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_heads`
--
ALTER TABLE `transaction_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_heads_code_unique` (`code`),
  ADD KEY `transaction_heads_ac_head_id_index` (`ac_head_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `v1_venues`
--
ALTER TABLE `v1_venues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitors_guest_id_index` (`guest_id`),
  ADD KEY `visitors_booking_id_index` (`booking_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vouchers_v_group_id_index` (`v_group_id`),
  ADD KEY `vouchers_date_id_index` (`date_id`),
  ADD KEY `vouchers_debit_head_id_index` (`debit_head_id`),
  ADD KEY `vouchers_credit_head_id_index` (`credit_head_id`);

--
-- Indexes for table `voucher_groups`
--
ALTER TABLE `voucher_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_groups_date_id_index` (`date_id`),
  ADD KEY `voucher_groups_type_id_index` (`type_id`),
  ADD KEY `voucher_groups_user_id_index` (`user_id`);

--
-- Indexes for table `voucher_types`
--
ALTER TABLE `voucher_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_update_histories`
--
ALTER TABLE `voucher_update_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_update_histories_voucher_id_index` (`voucher_id`),
  ADD KEY `voucher_update_histories_date_id_index` (`date_id`),
  ADD KEY `voucher_update_histories_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `account_head_child_i`
--
ALTER TABLE `account_head_child_i`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `account_head_child_ii`
--
ALTER TABLE `account_head_child_ii`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `account_head_child_iii`
--
ALTER TABLE `account_head_child_iii`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `account_head_child_iv`
--
ALTER TABLE `account_head_child_iv`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `current_balance`
--
ALTER TABLE `current_balance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `e1_departments`
--
ALTER TABLE `e1_departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `e2_employee_designations`
--
ALTER TABLE `e2_employee_designations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `e3_salary_grades`
--
ALTER TABLE `e3_salary_grades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `e4_employees`
--
ALTER TABLE `e4_employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `e5_leave_categories`
--
ALTER TABLE `e5_leave_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `e6_leaves`
--
ALTER TABLE `e6_leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_infos`
--
ALTER TABLE `general_infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `h1_building_types`
--
ALTER TABLE `h1_building_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `h2_buildings`
--
ALTER TABLE `h2_buildings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `h3_floor_types`
--
ALTER TABLE `h3_floor_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `h4_floors`
--
ALTER TABLE `h4_floors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `h5_room_categories`
--
ALTER TABLE `h5_room_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `h6_rooms`
--
ALTER TABLE `h6_rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT for table `m1_mis_heads`
--
ALTER TABLE `m1_mis_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m2_mis_head_child_i`
--
ALTER TABLE `m2_mis_head_child_i`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m3_mis_ledger_heads`
--
ALTER TABLE `m3_mis_ledger_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `m4_mis_vouchers_i`
--
ALTER TABLE `m4_mis_vouchers_i`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1133;

--
-- AUTO_INCREMENT for table `mis_current_stocks`
--
ALTER TABLE `mis_current_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_groups`
--
ALTER TABLE `purchase_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `r5_meal_types`
--
ALTER TABLE `r5_meal_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `r6_meal_items`
--
ALTER TABLE `r6_meal_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `r7_menu_types`
--
ALTER TABLE `r7_menu_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `r9_food_menu`
--
ALTER TABLE `r9_food_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `r10_food_menu_items`
--
ALTER TABLE `r10_food_menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `r11_food_sales`
--
ALTER TABLE `r11_food_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s1_unit_types`
--
ALTER TABLE `s1_unit_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `s2_units`
--
ALTER TABLE `s2_units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_heads`
--
ALTER TABLE `transaction_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `v1_venues`
--
ALTER TABLE `v1_venues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_groups`
--
ALTER TABLE `voucher_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_types`
--
ALTER TABLE `voucher_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `voucher_update_histories`
--
ALTER TABLE `voucher_update_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `e6_leaves`
--
ALTER TABLE `e6_leaves`
  ADD CONSTRAINT `e6_leaves_leave_category_id_foreign` FOREIGN KEY (`leave_category_id`) REFERENCES `e5_leave_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `h2_buildings`
--
ALTER TABLE `h2_buildings`
  ADD CONSTRAINT `h2_buildings_building_type_foreign` FOREIGN KEY (`building_type`) REFERENCES `h1_building_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `h4_floors`
--
ALTER TABLE `h4_floors`
  ADD CONSTRAINT `h4_floors_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `h2_buildings` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `h4_floors_floor_type_foreign` FOREIGN KEY (`floor_type`) REFERENCES `h3_floor_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `h6_rooms`
--
ALTER TABLE `h6_rooms`
  ADD CONSTRAINT `h6_rooms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `h5_room_categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `h6_rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `h4_floors` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `r6_meal_items`
--
ALTER TABLE `r6_meal_items`
  ADD CONSTRAINT `r6_meal_items_meal_type_id_foreign` FOREIGN KEY (`meal_type_id`) REFERENCES `r5_meal_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
