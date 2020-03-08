-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 10:30 AM
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
(1, 2, 'Lunch 001', 250.00, '2020-01-20 03:23:22', '2020-01-20 03:23:22'),
(2, 1, 'Brakfast 001', 600.00, '2020-01-20 03:23:50', '2020-01-20 03:23:50');

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
(1, 1, 1, 1, '2020-01-20 03:23:22', '2020-01-20 03:23:22'),
(2, 1, 3, 1, '2020-01-20 03:23:22', '2020-01-20 03:23:22'),
(3, 1, 4, 1, '2020-01-20 03:23:22', '2020-01-20 03:23:22'),
(4, 2, 3, 1, '2020-01-20 03:23:50', '2020-01-20 03:23:50');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `r9_food_menu`
--
ALTER TABLE `r9_food_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `r10_food_menu_items`
--
ALTER TABLE `r10_food_menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
