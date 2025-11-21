-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 21, 2025 at 06:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fish_inventory`
--

CREATE DATABASE IF NOT EXISTS `fish_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `fish_inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `category`, `description`, `amount`, `expense_date`, `notes`, `receipt_image`, `created_at`, `updated_at`) VALUES
(1, 3, 'ice', 'to preserve the remaining fishes', 100.00, '2025-10-28', NULL, NULL, '2025-10-28 06:49:58', '2025-10-28 06:49:58'),
(2, 3, 'ice', 'to preserve the remaining fishes', 50.00, '2025-10-28', NULL, NULL, '2025-10-28 07:35:48', '2025-10-28 07:35:48'),
(3, 2, 'ice', 'to preserve the remaining fishes', 50.00, '2025-11-06', 'kdmvfsdk;gfm', NULL, '2025-11-06 13:58:47', '2025-11-06 13:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `fish`
--

CREATE TABLE `fish` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity_available` decimal(8,2) NOT NULL DEFAULT 0.00,
  `price_per_kilo` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fish`
--

INSERT INTO `fish` (`id`, `user_id`, `name`, `type`, `quantity_available`, `price_per_kilo`, `description`, `image`, `created_at`, `updated_at`) VALUES
(2, 2, 'Bangus', 'FreshWater', 60.00, 240.00, 'blahblah', 'fish-images/D6nxKXyb9NYBJpqfLn7wwGsjqo3wVXnUcFKVgnvr.jpg', '2025-10-28 04:02:56', '2025-11-06 13:56:39'),
(3, 3, 'Tilapia', 'FreshWater', 3.00, 260.00, NULL, NULL, '2025-10-28 05:55:23', '2025-10-28 05:55:23'),
(4, 3, 'Bangus', 'Salt Water', 2.00, 280.00, NULL, NULL, '2025-10-28 05:56:24', '2025-10-28 06:20:02'),
(5, 3, 'Tuna', 'Salt Water', 5.00, 180.00, NULL, NULL, '2025-10-28 05:57:53', '2025-10-28 07:32:45'),
(6, 2, 'MALATINDOK', 'Salt Water', 60.00, 240.00, 'fresh malatindok buy now', 'fish-images/B0xVIb3XSePbVP1aw2YtZZh5LQPFnM4aSuHYbwuk.jpg', '2025-11-06 13:42:36', '2025-11-06 13:45:07'),
(7, 2, 'TULINGAN', 'Salt Water', 10.00, 200.00, 'Fresh Tulingan buy now', 'fish-images/hlmFZx7mLEU1glNlyH8BzBHomRaIgjFRPwyvZdlp.jpg', '2025-11-06 13:49:18', '2025-11-06 13:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_01_01_000000_create_fish_table', 1),
(4, '2024_01_02_000000_create_sales_table', 1),
(5, '2024_01_03_000000_create_expenses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fish_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_sold` decimal(8,2) NOT NULL,
  `price_per_kilo` decimal(8,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `fish_id`, `quantity_sold`, `price_per_kilo`, `total_price`, `customer_name`, `notes`, `sale_date`, `created_at`, `updated_at`) VALUES
(2, 3, 4, 4.00, 280.00, 1120.00, NULL, NULL, '2025-10-28 06:18:00', '2025-10-28 06:20:02', '2025-10-28 06:20:02'),
(3, 3, 5, 3.00, 180.00, 540.00, NULL, NULL, '2025-10-28 07:32:00', '2025-10-28 07:32:45', '2025-10-28 07:32:45'),
(5, 2, 7, 20.00, 200.00, 4000.00, 'Dia Khea Mae Villareal', NULL, '2025-11-06 13:56:00', '2025-11-06 13:57:11', '2025-11-06 13:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `business_name`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Mark Kenneth A. Nacua', 'markynacua41@gmail.com', NULL, '$2y$10$EBKIgCLfjUutl.DczmzQau7ukGd7QjUdSETJiX.LdAfznnIyKj3ly', 'Mark Fish Dealer', '+639602223595', NULL, '2025-10-28 04:00:46', '2025-10-28 04:00:46'),
(3, 'ell', 'ella@gmail.com', NULL, '$2y$10$g1iVkLqZc.MwWlfgipl8dO0yfeOgMAOGRTXowrhciqL8qwuH2ZED2', 'EN Fish Broker', NULL, NULL, '2025-10-28 05:54:01', '2025-10-28 05:54:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `fish`
--
ALTER TABLE `fish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fish_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_fish_id_foreign` (`fish_id`);

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
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fish`
--
ALTER TABLE `fish`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fish`
--
ALTER TABLE `fish`
  ADD CONSTRAINT `fish_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_fish_id_foreign` FOREIGN KEY (`fish_id`) REFERENCES `fish` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
