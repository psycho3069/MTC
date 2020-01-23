-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2020 at 05:05 AM
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
(29, '2019_09_08_100157_create_r1_restaurant_suppliers_table', 1),
(30, '2019_09_08_200157_create_r2_restaurant_receivers_table', 1),
(31, '2019_09_08_300157_create_r3_grocery_categories_table', 1),
(32, '2019_09_08_400157_create_r4_groceries_table', 1),
(33, '2019_09_08_500157_create_r5_meal_types_table', 1),
(34, '2019_09_08_600157_create_r6_meal_items_table', 1),
(35, '2019_09_08_700157_create_r7_menu_types_table', 1),
(36, '2019_09_08_800157_create_r8_menus_table', 1),
(37, '2019_09_08_900157_create_r9_sales_table', 1),
(38, '2019_09_14_100000_create_i1_inventory_suppliers_table', 1),
(39, '2019_09_14_200000_create_i2_inventory_receivers_table', 1),
(40, '2019_09_14_300000_create_i3_inventory_categories_table', 1),
(41, '2019_09_14_400000_create_i4_inventories_table', 1),
(42, '2019_11_11_100000_create_vv1_voucher_types_table', 1),
(45, '2019_11_11_400000_create_vv4_transaction_histories_table', 1),
(49, '2019_11_24_100000_create_m1_mis_account_heads_table', 1),
(57, '2019_12_10_093004_create_staff_table', 1),
(59, '2019_12_03_105249_create_checkout_table', 2),
(60, '2019_08_16_160615_create_v1_venues_table', 3),
(61, '2019_08_16_175341_create_v2_venue_reservations_table', 3),
(62, '2019_08_16_185341_create_v3_venue_bookings_table', 3),
(63, '2019_08_16_195341_create_v4_venue_billings_table', 3),
(64, '2019_09_01_400139_create_h5_room_categories_table', 3),
(65, '2019_09_01_500139_create_h6_rooms_table', 3),
(66, '2019_09_01_600139_create_h7_room_reservations_table', 3),
(67, '2019_09_01_700139_create_h8_room_bookings_table', 3),
(68, '2019_09_01_800139_create_h9_room_billings_table', 3),
(123, '2019_12_29_110523_create_checkouts_table', 4),
(555, '2019_12_28_090517_create_visitors_table', 5),
(558, '2020_01_07_055304_create_deliveries_table', 5),
(559, '2020_01_08_040625_create_suppliers_table', 5),
(568, '2020_01_20_063023_create_r9_food_menu_table', 6),
(569, '2020_01_20_080808_create_r10_food_menu_items_table', 6),
(572, '2019_12_12_113448_create_configurations_table', 8),
(613, '2019_11_11_200000_create_vv2_vouchers_table', 9),
(614, '2019_11_11_300000_create_vv3_current_balance_table', 9),
(615, '2019_11_11_500000_create_vv5_dates_table', 9),
(616, '2019_11_11_600000_create_vv6_voucher_groups_table', 9),
(617, '2019_11_11_700000_create_vv7_voucher_update_histories_table', 9),
(618, '2019_11_24_200000_create_m2_mis_vouchers_table', 9),
(619, '2019_11_24_300000_create_m3_stock_heads_table', 9),
(620, '2019_11_24_400000_create_m4_mis_current_stocks_table', 9),
(621, '2019_11_24_500000_create_m5_stocks_table', 9),
(622, '2019_11_24_600000_create_m6_purchases_table', 9),
(623, '2019_11_24_700000_create_m7_purchase_groups_table', 9),
(624, '2019_12_23_041801_create_guests_table', 9),
(625, '2019_12_23_041836_create_bookings_table', 9),
(626, '2019_12_23_050024_create_billings_table', 9),
(627, '2019_12_30_040536_create_payments_table', 9),
(628, '2019_12_31_070815_create_food_sales_table', 9),
(630, '2020_01_20_102033_create_r11_food_sales_table', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=631;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
