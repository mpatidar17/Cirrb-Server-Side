-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2017 at 06:47 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.1.6-1~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bl_lat` double DEFAULT NULL,
  `bl_long` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `restaurant_id`, `name`, `bl_lat`, `bl_long`, `created_at`, `updated_at`) VALUES
(1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', '2017-06-21 05:39:31'),
(2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', '2017-06-20 08:16:09'),
(3, 2, 'Khajrana Ring Road', 22.73720537194017, 75.91258407060548, '2017-06-20 08:19:42', '2017-06-20 08:19:42'),
(4, 2, 'CAT Road', 22.668635158805845, 75.8179986519043, '2017-06-20 08:20:56', '2017-06-20 08:20:56'),
(5, 3, 'sultana', 24.48919466944508, 39.58498555908204, '2017-06-20 23:05:35', '2017-06-20 23:05:35'),
(6, 1, 'test', 23.15829070054286, 76.78984243164064, '2017-06-21 05:00:10', '2017-06-21 05:39:30'),
(7, 1, 'Harda', 22.380809584540376, 77.11462575683595, '2017-06-21 05:07:06', '2017-06-21 05:07:24'),
(8, 3, 'Testing', 24.490686, 39.56773720000001, '2017-06-22 17:47:29', '2017-06-22 17:47:29'),
(9, 1, 'Satwas', 22.538147780317132, 76.70032332734377, '2017-06-23 13:06:44', '2017-06-23 13:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `restaurant_id`, `branch_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Chapati', 'Good for lunch', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55', '2017-06-20 08:16:55'),
(2, 1, 0, 'Vegitables', 'good', 85.95, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:19', '2017-06-20 08:17:19'),
(3, 1, 0, 'Rice', 'lightt food', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46', '2017-06-20 08:17:46'),
(4, 2, 0, 'Noodles', 'Good for snackes', 120.15, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:21:28', '2017-06-20 08:21:28'),
(5, 2, 0, 'Manchurian', 'snacks', 90.20, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:21:49', '2017-06-20 08:21:49'),
(6, 2, 0, 'Mixed', 'food', 167.25, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:22:17', '2017-06-20 08:22:17'),
(7, 3, 0, 'test 1', NULL, 10.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:02', '2017-06-20 23:06:02'),
(8, 3, 0, 'test 2', NULL, 9.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:16', '2017-06-20 23:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `restaurant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_phone` bigint(20) DEFAULT NULL,
  `restaurant_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restaurant_approved` text COLLATE utf8mb4_unicode_ci,
  `restaurant_approved_on` timestamp NULL DEFAULT NULL,
  `restaurant_created_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `branch_restaurant_id` int(11) DEFAULT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_lat` double DEFAULT NULL,
  `branch_long` double DEFAULT NULL,
  `branch_created_at` timestamp NULL DEFAULT NULL,
  `partner_id` int(11) DEFAULT '0',
  `cl_lat` double DEFAULT NULL,
  `cl_long` double DEFAULT NULL,
  `sub_total` double(10,2) DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fees` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL,
  `remain_balance` float DEFAULT NULL,
  `commission` double(10,2) DEFAULT '0.00',
  `order_payable` float DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `transaction_id`, `user_id`, `email`, `restaurant_id`, `restaurant_name`, `restaurant_description`, `restaurant_phone`, `restaurant_email`, `restaurant_image`, `restaurant_approved`, `restaurant_approved_on`, `restaurant_created_at`, `branch_id`, `branch_restaurant_id`, `branch_name`, `branch_lat`, `branch_long`, `branch_created_at`, `partner_id`, `cl_lat`, `cl_long`, `sub_total`, `status`, `delivery_fees`, `total`, `remain_balance`, `commission`, `order_payable`, `created_at`, `updated_at`) VALUES
(2, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 0, NULL, NULL, 5.16, 'incomplete', 155.80, 160.96, 0, 0.00, 0, '2017-06-23 04:31:30', '2017-06-23 04:31:30'),
(3, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 04:31:51', '2017-06-23 04:31:51'),
(4, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 04:33:33', '2017-06-23 04:33:33'),
(5, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 04:38:33', '2017-06-23 04:38:33'),
(6, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 18, NULL, NULL, 200.00, 'closed', 9.50, 404.00, -162.91, 0.00, 387.91, '2017-06-23 04:50:22', '2017-06-23 04:50:22'),
(7, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 04:57:39', '2017-06-23 04:57:39'),
(8, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:19:34', '2017-06-23 05:19:34'),
(9, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:19:55', '2017-06-23 05:19:55'),
(10, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:20:23', '2017-06-23 05:20:23'),
(11, 0, 18, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:20:52', '2017-06-23 05:20:52'),
(12, 0, 18, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:21:00', '2017-06-23 05:21:00'),
(13, 0, 18, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:21:33', '2017-06-23 05:21:33'),
(14, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:22:18', '2017-06-23 05:22:18'),
(15, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 05:24:29', '2017-06-23 05:24:29'),
(16, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 05:33:19', '2017-06-23 05:33:19'),
(17, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 0, NULL, NULL, 5.16, 'incomplete', 155.80, 160.96, 0, 0.00, 0, '2017-06-23 05:41:00', '2017-06-23 05:41:00'),
(18, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 08:03:54', '2017-06-23 08:03:54'),
(19, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 08:05:35', '2017-06-23 08:05:35'),
(20, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 08:12:49', '2017-06-23 08:12:49'),
(21, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 08:15:43', '2017-06-23 08:15:43'),
(22, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 08:30:09', '2017-06-23 08:30:09'),
(23, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 45.17, 'cancel', 63.65, 108.82, 0, 0.00, 0, '2017-06-23 08:38:56', '2017-06-23 08:38:56'),
(24, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 45.17, 'cancel', 63.65, 108.82, 0, 0.00, 0, '2017-06-23 08:41:07', '2017-06-23 08:41:07'),
(25, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 08:45:56', '2017-06-23 08:45:56'),
(26, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 08:47:49', '2017-06-23 08:47:49'),
(27, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 08:48:41', '2017-06-23 08:48:41'),
(28, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 85.95, 'cancel', 63.65, 149.60, 0, 0.00, 0, '2017-06-23 08:55:54', '2017-06-23 08:55:54'),
(29, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 90.34, 'cancel', 63.65, 153.99, 0, 0.00, 0, '2017-06-23 09:01:57', '2017-06-23 09:01:57'),
(30, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 09:07:53', '2017-06-23 09:07:53'),
(31, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:12:04', '2017-06-23 09:12:04'),
(32, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 09:12:29', '2017-06-23 09:12:29'),
(33, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 09:12:46', '2017-06-23 09:12:46'),
(34, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:13:58', '2017-06-23 09:13:58'),
(35, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:36:15', '2017-06-23 09:36:15'),
(36, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:41:42', '2017-06-23 09:41:42'),
(37, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:49:25', '2017-06-23 09:49:25'),
(38, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:49:46', '2017-06-23 09:49:46'),
(39, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:51:14', '2017-06-23 09:51:14'),
(40, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:55:05', '2017-06-23 09:55:05'),
(41, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:58:03', '2017-06-23 09:58:03'),
(42, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:58:16', '2017-06-23 09:58:16'),
(43, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 09:58:27', '2017-06-23 09:58:27'),
(44, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 26, NULL, NULL, 200.00, 'process', 9.50, 404.00, 0, 0.00, 404, '2017-06-23 09:59:06', '2017-06-23 09:59:06'),
(45, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 10:13:06', '2017-06-23 10:13:06'),
(46, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 45.17, 'cancel', 81.70, 126.87, 0, 0.00, 0, '2017-06-23 10:16:45', '2017-06-23 10:16:45'),
(47, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 10:18:07', '2017-06-23 10:18:07'),
(48, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 81.70, 86.86, 0, 0.00, 0, '2017-06-23 10:26:02', '2017-06-23 10:26:02'),
(49, 0, 19, NULL, 2, 'Radission', 'This is good for lunch and dinner', 8787878787, 'rd@gmail.com', 'http://api.cirrb.com/images/restaurent-1.png', 'y', '2017-06-20 08:18:51', '2017-06-20 08:18:51', 3, 2, 'Khajrana Ring Road', 22.73720537194017, 75.91258407060548, '2017-06-20 08:19:42', 0, NULL, NULL, 167.25, 'incomplete', 5.70, 172.95, 0, 0.00, 0, '2017-06-23 10:27:23', '2017-06-23 10:27:23'),
(50, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 18, NULL, NULL, 90.34, 'closed', 10.45, 100.79, -163.7, 0.00, 263.7, '2017-06-23 10:28:21', '2017-06-23 10:28:21'),
(51, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'incomplete', 81.70, 86.86, 0, 0.00, 0, '2017-06-23 10:35:51', '2017-06-23 10:35:51'),
(52, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 45.17, 'incomplete', 63.65, 108.82, 0, 0.00, 0, '2017-06-23 11:32:32', '2017-06-23 11:32:32'),
(53, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 0, NULL, NULL, 85.95, 'cancel', 155.80, 241.75, 0, 0.00, 0, '2017-06-23 11:40:23', '2017-06-23 11:40:23'),
(54, 0, 19, NULL, 2, 'Radission', 'This is good for lunch and dinner', 8787878787, 'rd@gmail.com', 'http://api.cirrb.com/images/restaurent-1.png', 'y', '2017-06-20 08:18:51', '2017-06-20 08:18:51', 3, 2, 'Khajrana Ring Road', 22.73720537194017, 75.91258407060548, '2017-06-20 08:19:42', 0, NULL, NULL, 120.15, 'cancel', 140.60, 260.75, 0, 0.00, 0, '2017-06-23 11:50:07', '2017-06-23 11:50:07'),
(55, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 11:50:29', '2017-06-23 11:50:29'),
(56, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 11:55:20', '2017-06-23 11:55:20'),
(57, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 11:55:39', '2017-06-23 11:55:39'),
(58, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 5.16, 'cancel', 63.65, 68.81, 0, 0.00, 0, '2017-06-23 11:56:23', '2017-06-23 11:56:23'),
(59, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 0, NULL, NULL, 5.16, 'cancel', 155.80, 160.96, 0, 0.00, 0, '2017-06-23 11:56:50', '2017-06-23 11:56:50'),
(60, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-23 12:19:55', '2017-06-23 12:19:55'),
(61, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 18, NULL, NULL, 200.00, 'closed', 9.50, 404.00, 32.3, 0.00, 567.7, '2017-06-23 12:29:35', '2017-06-23 12:29:35'),
(62, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 2, 1, 'Rau Branch', 22.623483620857783, 75.80323577348634, '2017-06-20 08:15:55', 0, NULL, NULL, 5.16, 'cancel', 10.45, 15.61, 0, 0.00, 0, '2017-06-23 12:47:04', '2017-06-23 12:47:04'),
(63, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 18, NULL, NULL, 5.16, 'closed', 81.70, 86.86, 170.44, 0.00, 54.56, '2017-06-23 12:51:33', '2017-06-23 12:51:33'),
(64, 0, 61, NULL, 3, 'Albaik', NULL, 7143269328, 'albaik@albaik.com', 'http://api.cirrb.com/images/276636660bc6c96a4b92808222da9609_400x400.png', 'y', '2017-06-20 11:03:55', '2017-06-20 23:03:55', 5, 3, 'sultana', 24.48919466944508, 39.58498555908204, '2017-06-20 23:05:35', 60, NULL, NULL, 20.98, 'closed', 4.00, 24.98, 25.02, 0.00, 24.98, '2017-06-23 19:26:34', '2017-06-23 19:26:34'),
(65, 0, 61, NULL, 3, 'Albaik', NULL, 7143269328, 'albaik@albaik.com', 'http://api.cirrb.com/images/276636660bc6c96a4b92808222da9609_400x400.png', 'y', '2017-06-20 11:03:55', '2017-06-20 23:03:55', 5, 3, 'sultana', 24.48919466944508, 39.58498555908204, '2017-06-20 23:05:35', 60, NULL, NULL, 52.95, 'cancel', 4.00, 56.95, 0, 0.00, 31.93, '2017-06-23 19:34:34', '2017-06-23 19:34:34'),
(66, 0, 61, NULL, 3, 'Albaik', NULL, 7143269328, 'albaik@albaik.com', 'http://api.cirrb.com/images/276636660bc6c96a4b92808222da9609_400x400.png', 'y', '2017-06-20 11:03:55', '2017-06-20 23:03:55', 5, 3, 'sultana', 24.48919466944508, 39.58498555908204, '2017-06-20 23:05:35', 0, NULL, NULL, 20.98, 'incomplete', 4.00, 24.98, 0, 0.00, 0, '2017-06-23 21:02:26', '2017-06-23 21:02:26'),
(67, 0, 61, NULL, 3, 'Albaik', NULL, 7143269328, 'albaik@albaik.com', 'http://api.cirrb.com/images/276636660bc6c96a4b92808222da9609_400x400.png', 'y', '2017-06-20 11:03:55', '2017-06-20 23:03:55', 5, 3, 'sultana', 24.48919466944508, 39.58498555908204, '2017-06-20 23:05:35', 60, NULL, NULL, 20.98, 'closed', 4.00, 24.98, 5.04, 0.00, -0.04, '2017-06-23 21:16:53', '2017-06-23 21:16:53'),
(68, 0, 19, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 85.95, 'cancel', 63.65, 149.60, 0, 0.00, 0, '2017-06-26 04:25:25', '2017-06-26 04:25:25'),
(69, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:16:48', '2017-06-26 05:16:48'),
(70, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:22:32', '2017-06-26 05:22:32'),
(71, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:27:00', '2017-06-26 05:27:00'),
(72, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:37:00', '2017-06-26 05:37:00'),
(73, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:38:49', '2017-06-26 05:38:49'),
(74, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:43:12', '2017-06-26 05:43:12'),
(75, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 05:47:26', '2017-06-26 05:47:26'),
(76, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:03:50', '2017-06-26 06:03:50'),
(77, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:06:49', '2017-06-26 06:06:49'),
(78, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:09:37', '2017-06-26 06:09:37'),
(79, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:12:03', '2017-06-26 06:12:03'),
(80, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:14:00', '2017-06-26 06:14:00'),
(81, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:16:08', '2017-06-26 06:16:08'),
(82, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:19:17', '2017-06-26 06:19:17'),
(83, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:22:11', '2017-06-26 06:22:11'),
(84, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:25:35', '2017-06-26 06:25:35'),
(85, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:27:43', '2017-06-26 06:27:43'),
(86, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:33:22', '2017-06-26 06:33:22'),
(87, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:34:40', '2017-06-26 06:34:40'),
(88, 0, 35, NULL, 1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', 1, 1, 'Vijay Nagar Branch', 23.31164110251639, 76.39426589433594, '2017-06-20 08:14:35', 0, NULL, NULL, 200.00, 'incomplete', 9.50, 404.00, 0, 0.00, 0, '2017-06-26 06:38:10', '2017-06-26 06:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `cost` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menu_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_menu_cost` double DEFAULT NULL,
  `menu_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `name`, `description`, `notes`, `quantity`, `cost`, `created_at`, `updated_at`, `menu_id`, `per_menu_cost`, `menu_image`, `menu_created_at`) VALUES
(3, 2, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:31:30', '2017-06-23 04:31:30', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(4, 3, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:31:51', '2017-06-23 04:31:51', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(5, 4, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:33:33', '2017-06-23 04:33:33', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(6, 5, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:38:33', '2017-06-23 04:38:33', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(7, 6, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:50:22', '2017-06-23 04:50:22', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(8, 7, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 04:57:39', '2017-06-23 04:57:39', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(9, 8, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:19:34', '2017-06-23 05:19:34', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(10, 9, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:19:55', '2017-06-23 05:19:55', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(11, 10, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:20:23', '2017-06-23 05:20:23', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(12, 11, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:20:52', '2017-06-23 05:20:52', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(13, 12, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:21:00', '2017-06-23 05:21:00', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(14, 13, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:21:33', '2017-06-23 05:21:33', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(15, 14, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 05:22:18', '2017-06-23 05:22:18', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(16, 15, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 05:24:29', '2017-06-23 05:24:29', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(17, 16, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 05:33:19', '2017-06-23 05:33:19', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(18, 17, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 05:41:00', '2017-06-23 05:41:00', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(19, 18, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 08:03:54', '2017-06-23 08:03:54', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(20, 19, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 08:05:35', '2017-06-23 08:05:35', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(21, 20, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 08:12:49', '2017-06-23 08:12:49', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(22, 21, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 08:15:43', '2017-06-23 08:15:43', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(23, 22, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 08:30:09', '2017-06-23 08:30:09', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(24, 23, 'Rice', 'lightt food', NULL, 1, 45, '2017-06-23 08:38:56', '2017-06-23 08:38:56', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(25, 24, 'Rice', 'lightt food', NULL, 1, 45, '2017-06-23 08:41:07', '2017-06-23 08:41:07', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(26, 25, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 08:45:56', '2017-06-23 08:45:56', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(27, 26, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 08:47:49', '2017-06-23 08:47:49', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(28, 27, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 08:48:42', '2017-06-23 08:48:42', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(29, 28, 'Vegitables', 'good', NULL, 1, 86, '2017-06-23 08:55:54', '2017-06-23 08:55:54', '2', 85.95, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:19'),
(30, 29, 'Rice', 'lightt food', NULL, 2, 90, '2017-06-23 09:01:57', '2017-06-23 09:01:57', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(31, 30, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 09:07:53', '2017-06-23 09:07:53', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(32, 31, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:12:04', '2017-06-23 09:12:04', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(33, 32, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 09:12:29', '2017-06-23 09:12:29', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(34, 33, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 09:12:46', '2017-06-23 09:12:46', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(35, 34, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:13:58', '2017-06-23 09:13:58', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(36, 35, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:36:15', '2017-06-23 09:36:15', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(37, 36, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:41:42', '2017-06-23 09:41:42', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(38, 37, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:49:25', '2017-06-23 09:49:25', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(39, 38, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:49:46', '2017-06-23 09:49:46', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(40, 39, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:51:14', '2017-06-23 09:51:14', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(41, 40, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:55:05', '2017-06-23 09:55:05', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(42, 41, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:58:03', '2017-06-23 09:58:03', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(43, 42, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:58:16', '2017-06-23 09:58:16', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(44, 43, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:58:27', '2017-06-23 09:58:27', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(45, 44, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 09:59:06', '2017-06-23 09:59:06', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(46, 45, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 10:13:06', '2017-06-23 10:13:06', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(47, 46, 'Rice', 'lightt food', NULL, 1, 45, '2017-06-23 10:16:45', '2017-06-23 10:16:45', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(48, 47, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 10:18:07', '2017-06-23 10:18:07', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(49, 48, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 10:26:02', '2017-06-23 10:26:02', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(50, 49, 'Mixed', 'food', NULL, 1, 167, '2017-06-23 10:27:23', '2017-06-23 10:27:23', '6', 167.25, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:22:17'),
(51, 50, 'Rice', 'lightt food', NULL, 2, 90, '2017-06-23 10:28:21', '2017-06-23 10:28:21', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(52, 51, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 10:35:51', '2017-06-23 10:35:51', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(53, 52, 'Rice', 'lightt food', NULL, 1, 45, '2017-06-23 11:32:32', '2017-06-23 11:32:32', '3', 45.17, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:46'),
(54, 53, 'Vegitables', 'good', NULL, 1, 86, '2017-06-23 11:40:23', '2017-06-23 11:40:23', '2', 85.95, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:19'),
(55, 54, 'Noodles', 'Good for snackes', NULL, 1, 120, '2017-06-23 11:50:07', '2017-06-23 11:50:07', '4', 120.15, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:21:28'),
(56, 55, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 11:50:29', '2017-06-23 11:50:29', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(57, 56, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 11:55:20', '2017-06-23 11:55:20', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(58, 57, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 11:55:39', '2017-06-23 11:55:39', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(59, 58, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 11:56:23', '2017-06-23 11:56:23', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(60, 59, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 11:56:50', '2017-06-23 11:56:50', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(61, 60, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-23 12:19:55', '2017-06-23 12:19:55', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(62, 61, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 12:29:35', '2017-06-23 12:29:35', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(63, 62, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 12:47:04', '2017-06-23 12:47:04', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(64, 63, 'Chapati', 'Good for lunch', NULL, 1, 5, '2017-06-23 12:51:33', '2017-06-23 12:51:33', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(65, 64, 'test 1', NULL, NULL, 1, 11, '2017-06-23 19:26:34', '2017-06-23 19:26:34', '7', 10.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:02'),
(66, 64, 'test 2', NULL, NULL, 1, 10, '2017-06-23 19:26:34', '2017-06-23 19:26:34', '8', 9.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:16'),
(67, 65, 'test 1', NULL, NULL, 3, 33, '2017-06-23 19:34:34', '2017-06-23 19:34:34', '7', 10.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:02'),
(68, 65, 'test 2', NULL, NULL, 2, 20, '2017-06-23 19:34:34', '2017-06-23 19:34:34', '8', 9.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:16'),
(69, 66, 'test 1', NULL, NULL, 1, 11, '2017-06-23 21:02:26', '2017-06-23 21:02:26', '7', 10.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:02'),
(70, 66, 'test 2', NULL, NULL, 1, 10, '2017-06-23 21:02:26', '2017-06-23 21:02:26', '8', 9.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:16'),
(71, 67, 'test 1', NULL, NULL, 1, 11, '2017-06-23 21:16:53', '2017-06-23 21:16:53', '7', 10.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:02'),
(72, 67, 'test 2', NULL, NULL, 1, 10, '2017-06-23 21:16:53', '2017-06-23 21:16:53', '8', 9.99, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 23:06:16'),
(73, 68, 'Vegitables', 'good', NULL, 1, 86, '2017-06-26 04:25:25', '2017-06-26 04:25:25', '2', 85.95, 'http://api.cirrb.com/images/menu-1.png', '2017-06-20 08:17:19'),
(74, 69, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:16:48', '2017-06-26 05:16:48', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(75, 70, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:22:32', '2017-06-26 05:22:32', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(76, 71, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:27:00', '2017-06-26 05:27:00', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(77, 72, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:37:00', '2017-06-26 05:37:00', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(78, 73, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:38:49', '2017-06-26 05:38:49', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(79, 74, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:43:12', '2017-06-26 05:43:12', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(80, 75, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 05:47:26', '2017-06-26 05:47:26', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(81, 76, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:03:50', '2017-06-26 06:03:50', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(82, 77, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:06:49', '2017-06-26 06:06:49', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(83, 78, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:09:37', '2017-06-26 06:09:37', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(84, 79, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:12:03', '2017-06-26 06:12:03', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(85, 80, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:14:00', '2017-06-26 06:14:00', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(86, 81, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:16:08', '2017-06-26 06:16:08', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(87, 82, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:19:17', '2017-06-26 06:19:17', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(88, 83, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:22:11', '2017-06-26 06:22:11', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(89, 84, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:25:35', '2017-06-26 06:25:35', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(90, 85, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:27:43', '2017-06-26 06:27:43', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(91, 86, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:33:22', '2017-06-26 06:33:22', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(92, 87, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:34:40', '2017-06-26 06:34:40', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55'),
(93, 88, 'Chapati', 'Good for lunch', NULL, 3, 15, '2017-06-26 06:38:10', '2017-06-26 06:38:10', '1', 5.16, 'http://api.cirrb.com/images/default.png', '2017-06-20 08:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `partner_response`
--

CREATE TABLE `partner_response` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_response`
--

INSERT INTO `partner_response` (`id`, `order_id`, `partner_id`, `response`, `created_at`, `updated_at`) VALUES
(1, 2, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 04:31:30'),
(2, 3, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 04:31:52'),
(3, 4, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 04:33:33'),
(4, 5, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 04:38:33'),
(5, 6, 18, 'accept', '2017-06-23 04:52:02', '2017-06-23 04:52:02'),
(6, 7, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 04:57:39'),
(7, 16, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 05:33:19'),
(8, 17, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 05:41:00'),
(9, 18, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:03:54'),
(10, 19, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:05:35'),
(11, 20, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:12:49'),
(12, 21, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:15:43'),
(13, 22, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:30:09'),
(14, 23, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:38:56'),
(15, 24, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:41:07'),
(16, 25, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:45:56'),
(17, 26, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:47:49'),
(18, 27, 18, 'deny', '2017-06-23 08:50:44', '2017-06-23 08:48:42'),
(19, 28, 26, 'deny', '2017-06-23 08:56:59', '2017-06-23 08:55:54'),
(20, 29, 26, 'deny', '2017-06-23 09:02:16', '2017-06-23 09:01:57'),
(21, 30, 26, 'deny', '2017-06-23 09:31:49', '2017-06-23 09:31:49'),
(22, 31, 26, 'deny', '2017-06-23 09:34:38', '2017-06-23 09:34:38'),
(23, 32, 26, 'deny', '2017-06-23 09:34:38', '2017-06-23 09:34:38'),
(24, 33, 26, 'deny', '2017-06-23 09:34:38', '2017-06-23 09:34:38'),
(25, 34, 26, 'deny', '2017-06-23 09:34:38', '2017-06-23 09:34:38'),
(26, 35, 26, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(27, 36, 26, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(28, 37, 18, 'deny', '2017-06-23 09:53:34', '2017-06-23 09:53:34'),
(29, 38, 18, 'deny', '2017-06-23 09:54:54', '2017-06-23 09:54:54'),
(30, 39, 18, 'deny', '2017-06-23 09:54:58', '2017-06-23 09:54:58'),
(31, 40, 18, 'deny', '2017-06-23 10:00:24', '2017-06-23 09:55:05'),
(32, 41, 18, 'deny', '2017-06-23 10:00:28', '2017-06-23 09:58:03'),
(33, 44, 26, 'deny', '2017-06-23 10:04:32', '2017-06-23 10:04:32'),
(34, 44, 18, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(35, 45, 26, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(36, 46, 26, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(37, 47, 26, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(38, 48, 18, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(39, 49, 18, 'not respond', '2017-06-23 10:29:11', '2017-06-23 10:29:11'),
(40, 50, 18, 'accept', '2017-06-23 10:38:05', '2017-06-23 10:38:05'),
(41, 51, 18, 'not respond', '2017-06-23 10:36:56', '2017-06-23 10:36:56'),
(42, 52, 26, 'not respond', '2017-06-23 11:34:01', '2017-06-23 11:34:01'),
(43, 53, 26, 'not respond', '2017-06-23 11:42:02', '2017-06-23 11:42:02'),
(44, 54, 26, 'not respond', '2017-06-23 11:52:01', '2017-06-23 11:52:01'),
(45, 55, 26, 'not respond', '2017-06-23 11:52:01', '2017-06-23 11:52:01'),
(46, 56, 26, 'not respond', '2017-06-23 11:57:02', '2017-06-23 11:57:02'),
(47, 57, 26, 'not respond', '2017-06-23 11:57:02', '2017-06-23 11:57:02'),
(48, 58, 26, 'not respond', '2017-06-23 11:58:01', '2017-06-23 11:58:01'),
(49, 59, 26, 'not respond', '2017-06-23 11:58:01', '2017-06-23 11:58:01'),
(50, 60, 26, 'not respond', '2017-06-23 12:21:01', '2017-06-23 12:21:01'),
(51, 61, 18, 'accept', '2017-06-23 12:29:49', '2017-06-23 12:29:49'),
(52, 62, 26, 'not respond', '2017-06-23 12:49:01', '2017-06-23 12:49:01'),
(53, 63, 18, 'accept', '2017-06-23 12:51:50', '2017-06-23 12:51:50'),
(54, 64, 60, 'accept', '2017-06-23 19:26:42', '2017-06-23 19:26:42'),
(55, 65, 60, 'accept', '2017-06-23 19:35:57', '2017-06-23 19:35:57'),
(56, 66, 26, 'not respond', '2017-06-23 21:04:02', '2017-06-23 21:04:02'),
(57, 67, 60, 'accept', '2017-06-23 21:17:06', '2017-06-23 21:17:06'),
(58, 68, 26, 'not respond', '2017-06-26 04:27:01', '2017-06-26 04:27:01'),
(59, 69, 26, 'not respond', '2017-06-26 05:18:02', '2017-06-26 05:18:02'),
(60, 70, 26, 'not respond', '2017-06-26 05:24:01', '2017-06-26 05:24:01'),
(61, 71, 26, 'not respond', '2017-06-26 05:28:01', '2017-06-26 05:28:01'),
(62, 72, 26, 'not respond', '2017-06-26 05:38:01', '2017-06-26 05:38:01'),
(63, 73, 26, 'not respond', '2017-06-26 05:40:01', '2017-06-26 05:40:01'),
(64, 74, 26, 'not respond', '2017-06-26 05:45:01', '2017-06-26 05:45:01'),
(65, 75, 26, 'not respond', '2017-06-26 05:49:01', '2017-06-26 05:49:01'),
(66, 76, 26, 'not respond', '2017-06-26 06:05:02', '2017-06-26 06:05:02'),
(67, 77, 26, 'not respond', '2017-06-26 06:08:01', '2017-06-26 06:08:01'),
(68, 78, 26, 'not respond', '2017-06-26 06:11:01', '2017-06-26 06:11:01'),
(69, 79, 26, 'not respond', '2017-06-26 06:14:01', '2017-06-26 06:14:01'),
(70, 80, 26, 'not respond', '2017-06-26 06:15:01', '2017-06-26 06:15:01'),
(71, 81, 26, 'not respond', '2017-06-26 06:18:01', '2017-06-26 06:18:01'),
(72, 82, 26, 'not respond', '2017-06-26 06:21:01', '2017-06-26 06:21:01'),
(73, 83, 26, 'not respond', '2017-06-26 06:24:01', '2017-06-26 06:24:01'),
(74, 84, 26, 'not respond', '2017-06-26 06:27:01', '2017-06-26 06:27:01'),
(75, 85, 26, 'not respond', '2017-06-26 06:29:01', '2017-06-26 06:29:01'),
(76, 86, 26, 'not respond', '2017-06-26 06:35:02', '2017-06-26 06:35:02'),
(77, 87, 26, 'not respond', '2017-06-26 06:36:01', '2017-06-26 06:36:01'),
(78, 88, 26, 'not respond', '2017-06-26 06:40:01', '2017-06-26 06:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('shatakshiyuvasoft179@gmail.com', '2391', NULL),
('shatakshiyuvasoft179@gmail.com', '9369', NULL),
('shatakshiyuvasoft179@gmail.com', '7013', NULL),
('shatakshiyuvasoft179@gmail.com', '2378', NULL),
('shatakshiyuvasoft179@gmail.com', '3788', NULL),
('shatakshiyuvasoft179@gmail.com', '7819', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` text COLLATE utf8mb4_unicode_ci,
  `approved_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `phone`, `email`, `image`, `approved`, `approved_on`, `created_at`, `updated_at`) VALUES
(1, 'Guru Kripa', 'This is good for food.', 98989898, 'gk@gmail.com', 'http://api.cirrb.com/images/default.png', 'y', '2017-06-20 08:13:16', '2017-06-20 08:13:16', '2017-06-20 08:13:16'),
(2, 'Radission', 'This is good for lunch and dinner', 8787878787, 'rd@gmail.com', 'http://api.cirrb.com/images/restaurent-1.png', 'y', '2017-06-20 08:18:51', '2017-06-20 08:18:51', '2017-06-20 08:18:51'),
(3, 'Albaik', NULL, 7143269328, 'albaik@albaik.com', 'http://api.cirrb.com/images/276636660bc6c96a4b92808222da9609_400x400.png', 'y', '2017-06-20 11:03:55', '2017-06-20 23:03:55', '2017-06-20 23:03:55'),
(4, 'Raj Hotel', 'Testing item', 7563215, 'info@rajhotel.com', 'http://api.cirrb.com/images/restaurent-1.png', 'y', '2017-06-23 02:10:48', '2017-06-23 14:10:48', '2017-06-23 14:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `display_name`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Delivery Charges Per KM', 'delivery_charges_per_km', '.95', NULL, '2017-06-09 11:14:40'),
(2, 'Minimum Delivery Charges', 'minimum_delivery_charges', '4', NULL, '2017-06-09 11:14:40'),
(3, 'Maximum Radius', 'maximum_radius', '50', NULL, '2017-06-15 04:16:18'),
(4, 'Default commission for Partner', 'default_commission_partner', '10', NULL, '2017-06-21 10:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `display` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '   ',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '   ',
  `last_name` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` bigint(20) DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ' ',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `long` float DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci,
  `partner_status` text COLLATE utf8mb4_unicode_ci,
  `approve` text COLLATE utf8mb4_unicode_ci,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_limit` int(11) DEFAULT NULL,
  `balance` float DEFAULT '0',
  `cash_in_hand` float DEFAULT NULL,
  `commission` float DEFAULT '0',
  `commission_amount` float DEFAULT '0',
  `verified` tinyint(4) DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `display`, `name`, `last_name`, `email`, `phone`, `image`, `password`, `device_token`, `device_type`, `remember_token`, `auth_token`, `lat`, `long`, `status`, `partner_status`, `approve`, `roles`, `order_limit`, `balance`, `cash_in_hand`, `commission`, `commission_amount`, `verified`, `verification_token`, `notification`, `created_at`, `updated_at`) VALUES
(1, '   ', ' ', ' ', 'khallaf@3webbox.com', 0, 'http://13.56.74.245/images/new-user-image-default.png', '$2y$10$aigmA8wZKWaHKaOyujNZ4e.cP52WscYz9/b2.qYx6K0jGJ5pJ1ujq', 'sda', 'ios', 'xmvs9TVjMHyehGFZ0Y1tbBqTL0NCx5NkCgTFcbDW63PusLLoMWjgResZBRd1', '', 22.66, 75.66, '1', '-', NULL, 'admin', 500, 0, 0, NULL, NULL, 0, 'e64a499728785067449d3d80ce16a447', 0, '2017-06-20 08:12:03', '2017-06-20 08:12:03'),
(18, NULL, 'Agents', NULL, 'agent@gmail.co', 0, 'http://13.56.74.245/images/new-user-image-default.png', '$2y$10$1qzjS8QLY/qVO6E/HgbLUeFedMOCHn3MDWds65VuEV5StgXr2tZve', '8b9b1bcca3c5fef56736545dfe9f7c47770ace5017224a4cc0cb70383b241a3e', 'ios', 'YFuB4k2j9gevG96klUIcl74rmhS2aMgwcJIepb6nIzuYegI1ySOhbjPIvyoA', '04f6cdfe73abbe29f37b1a2b7656903e', 22.7005, 75.8765, '1', 'busy', '', 'partner', 1000, 0, 0, 10, 168.45, 1, '', 0, '2017-06-21 09:56:07', '2017-06-26 06:25:33'),
(19, '   ', 'customer', ' ', 'customer@gmail.co', 0, 'http://13.56.74.245/images/new-user-image-default.png', '$2y$10$XGg/eMxdOVaCosNoArgrue2CxQMUrLx3fRjHfyzcw4xKAwx0wMxCm', 'abcd', 'ios', 'G2r9FXf8uwB8vkRaIsMgAwgzjBoHEEV285qRG3HDjedXD8YCINWE9nc1O5E0', '6fcdc7697bd500aefaea40ec72254e5d', 23.7455, 76.8516, '1', '-', NULL, 'customer', 5, 170.44, 0, 0, 0, 1, '', 0, '2017-06-21 09:56:20', '2017-06-26 06:46:01'),
(22, 'P456', 'Kem', 'Che', 'kem@gmail.com', 1234657, 'http://13.56.74.245/images/new-user-image-default.png', '$2y$10$wNl96ex/OjPKn6eIseJOW.2crj0itTOmj/qnIJN0IOjR2ESYYes8a', '', '', NULL, NULL, 0, 0, '1', 'busy', '', 'partner', 275, 0, 0, 16, 0, 0, '418741598b7317ee52f0268c9da9cbb1', 0, '2017-06-21 11:20:40', '2017-06-23 21:17:06'),
(25, 'Mahadev', 'Mahadev', 'Patidar', 'notestagent@gmail.co', 9856548745, 'http://api.cirrb.com/images/Screen Shot 2017-06-22 at 2.38.58 PM.png', '$2y$10$87dyrtYDgW2MYlQMOoEBWu0AqHqJ5q7wZkoKQu1OIyfeoHVmZDlCO', 'pass_device_token_here', 'pass_device_type_here', 'uFK3UKnqjvQeD6DOjoHsapApwDw4mcjfIovggZF9w7A5U0w90167bbfDzVqE', '8340e35302a20039976d730fe5e889b5', 22.78, 75.62, '1', 'busy', '', 'partner', 500, 0, 0, 10, 0, 1, '', 0, '2017-06-21 11:31:07', '2017-06-23 21:17:06'),
(26, 'shatakshi', 'sakshi', 'shukla', 'shatakshiyuvasoft179@gmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$7Oyy3Cw0eehZ65zPUcEh4uM.K0t9405gwf9wYbvNrI/ABADtP6pPu', 'true', 'Android', 'jtn1EZ7FknuYug83TwZSjWuO1W3cbwZUTVYd8tfLARLfFLLe0HewEuDxEZe5', 'c6cb53015a62c69d469564372cc0b48e', NULL, NULL, '1', 'free', '', 'partner', 500, 0, 0, 10, 0, 1, ' ', 45, '2017-06-21 13:05:27', '2017-06-26 06:39:13'),
(35, '   ', ' ', ' ', 'amityuvasoft199@gmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$Cd3Hkd6sE8BO1K1UanFef.fGhxLCZiFE.hMRQx.35Cpm8ckebYP/6', 'true', 'Android', 'FuvvOy5O0wUSN6XCvpvLRt6ZVPJo1IeXPXKwdBeBpXVkPzc9P2RHC6nRmtzM', 'c86cd0177b40a5af01fe8081df17e418', 0, 0, '1', '-', NULL, 'customer', 5, 0, 0, 0, 0, 1, ' ', 1, '2017-06-23 08:44:40', '2017-06-26 05:16:13'),
(36, '   ', ' ', ' ', 'mahadev.yuvasoft109@gmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$5thNqr6jTfmLcDtMKTe0G.Nb9rcEaH228RHouJQnUMSsd/MMFgf6G', 'Android', 'Android', '8FUfFU9fyWufOd1ywk0kutyHvMm0QQWbAaU1VvLEmYqgCyWeSFGXdm3w7N5f', '0de6eddf9ff01a23829947748379c026', 23.7455, 76.8516, '1', '-', NULL, 'customer', 5, 0, 0, 0, 0, 1, ' ', 0, '2017-06-23 09:15:01', '2017-06-26 06:25:59'),
(56, '   ', 'dfdfd', 'ddfd', 'ubuntuyou@gmail.com', 0, ' ', '123456', '0', 'web', NULL, NULL, NULL, NULL, NULL, NULL, '', 'partner', NULL, 0, NULL, 0, 0, NULL, NULL, 0, NULL, '2017-06-23 21:17:06'),
(57, '   ', ' ', ' ', 'vaibhavyuvasoft187@gmail.com', 0, 'http://api.cirrb.com/public/images/new-user-image-default.png', '$2y$10$AE/widlglckHMFZbPGfSNuKHla.ph3fPbdBznW6eRXHNRodUHLfmm', 'true', 'ios', NULL, '', 0, 0, '1', '-', NULL, 'customer', 5, 0, 0, 0, 0, 1, ' ', 0, '2017-06-23 18:52:25', '2017-06-23 19:22:13'),
(58, '   ', ' ', ' ', 'vaibhaassdasdvyuvasoft187@gmail.com', 0, 'http://api.cirrb.com/public/images/new-user-image-default.png', '$2y$10$pw6HuGtus.0G1o4Qd4oAiOxlHxVNKWo1nd2UhYJb/dwVU.Q/2nie.', 'true', 'ios', NULL, '', 0, 0, '1', '-', NULL, 'customer', 5, 0, 0, 0, 0, 0, '39b570ab0c89af304056daaba5b9db9a', 0, '2017-06-23 18:52:35', '2017-06-23 18:52:35'),
(60, NULL, 'Eyad', 'Khallaf', 'eyad.n.khallaf@gmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$rAmvcIi0uL8FjC9zPUnryOUvyEvoQCbeaiQDZlQHhN/YrNAH.sXAm', 'ca7e794a5b0f3c536765b87273fba810ce27ccde017a2500e1dd67ac4262e871', 'ios', 'O8AlVFcW4ve6qJ6MzQ7Apj0oLtNGDyk9i5GHzth9LQH4NP7YxIcb5VO71MWn', 'e7ccc2c85f7e79ce43d7e829eaaec2d2', 24.4908, 39.5677, '1', 'busy', '', 'partner', 500, 0, 37.26, 10, 0.8, 1, ' ', 0, '2017-06-23 18:56:52', '2017-06-26 03:21:48'),
(61, '   ', 'jake', 'mulla', 'exe19801@hotmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$Mo0BrL.gOhdtChepMxwCQeMM9BscPFti56SieLrlBOrW7sa7yKEFG', 'b7bd960e1e3b32a368b4eff282a07f54a93aa7e969f075881a1d2a7ba0c20851', 'ios', 'EJ2B5zWYzvLIrPinkPyzOv6dH92wpv605WUhRJqlMJcX0FSkclJeRlpICaN8', '20ffbf088b7342a5e151fe83e1304683', 24.4907, 39.5677, '1', '-', NULL, 'customer', 5, 5.04, 0, 0, 0, 1, ' ', 0, '2017-06-23 19:20:47', '2017-06-24 21:04:02'),
(62, '   ', ' ', ' ', 'eyad545@hotmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$XBO.u8Szf/t06u/qU.8neODVQe25q7f.C6.98FPedDfiUupCLOuHy', 'd085a539f3596db1603cb9920ac5a17c5f64bf7e11f93aa4a58a82633316b09c', 'ios', NULL, '', 24.491, 39.5676, '1', '-', NULL, 'customer', 5, 0, 0, 0, 0, 0, '7710ec000a2a943ac23aeac4c2e25bdf', 0, '2017-06-23 19:24:09', '2017-06-23 19:24:09'),
(63, '   ', ' ', ' ', 'eyad.n.kallaf@gmail.com', 0, 'http://api.cirrb.com/images/new-user-image-default.png', '$2y$10$RX5LQxHN6NVtgw1O65Mmouebfohf5E5SnfxTO.Quq4thCEvzxooWy', '43ec0bb0f6a6a56b8ed4f321ec30a864a2935cb002f88dfe2b5a1c7986f549db', 'ios', NULL, '', 0, 0, '0', 'busy', '', 'partner', 500, 0, 0, 10, 0, 0, '5558c6bc35c12391c5762f7d18ec8dde', 0, '2017-06-23 20:59:37', '2017-06-23 21:17:06'),
(64, '   ', 'ritesh', 'ddfd', 'ubuntuyouu@gmail.com', 0, ' ', '12345678', '0', 'web', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'partner', NULL, 0, NULL, 0, 0, NULL, NULL, 0, NULL, NULL),
(65, '   ', 'bansanker', 'gupta', 'ubuntuyouas@gmail.com', 0, ' ', '12345678', '0', 'web', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'partner', NULL, 0, NULL, 0, 0, NULL, NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_response`
--
ALTER TABLE `partner_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `partner_response`
--
ALTER TABLE `partner_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
