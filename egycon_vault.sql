-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2021 at 11:50 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `egycon_vault`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `image`, `created_at`, `updated_at`) VALUES
(1, '1.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(2, '2.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(3, '3.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(4, '4.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(5, '5.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(6, '6.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(7, '7.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(8, '8.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(9, '9.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(10, '10.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(11, '11.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(12, '12.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(13, '13.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(14, '14.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49'),
(15, '15.jpg', '2021-09-12 09:45:49', '2021-09-12 09:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `belongings`
--

CREATE TABLE `belongings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `belonging_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `belonging_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `belongings`
--

INSERT INTO `belongings` (`id`, `name`, `email`, `phone`, `color`, `status`, `created_at`, `updated_at`, `belonging_type_id`, `belonging_size_id`, `color_name`, `notes`, `slot_id`, `code`) VALUES
(1, 'Mohamed Ashraf', 'Mohamed1812470@miuegypt.edu.eg', '+201156052920', '#c93636', '1', '2021-09-11 20:59:40', '2021-09-11 20:59:40', 1, 2, 'Flush Mahogany', 'cfffff', NULL, ''),
(2, 'Mohamed Ashraf', 'Mohamed1812470@miuegypt.edu.eg', '+201156052920', '#c93636', '1', '2021-09-11 20:59:40', '2021-09-11 20:59:40', 1, 2, 'Flush Mahogany', 'cfffff', NULL, ''),
(3, 'Ahmed Ashraf', 'xxTrimy@gmail.com', '+2011560252920', '#a51d1d', '1', '2021-09-12 00:29:09', '2021-09-12 00:29:09', 1, 2, 'Roof Terracotta', NULL, NULL, ''),
(4, 'ddddddddd', 'dddddddddddddd@fffff.com', 'dddddddddddddd', '#c05959', '1', '2021-09-12 00:36:10', '2021-09-12 00:36:10', 1, 2, 'Chestnut', NULL, NULL, ''),
(5, 'Mohamed Ashraffff', 'Mohamed1812470@miufffegypt.edu.eg', '+201156052920', '#9d3f3f', '1', '2021-09-12 00:36:41', '2021-09-12 00:36:41', 1, 2, 'Sanguine Brown', NULL, 4, ''),
(6, 'xTrimy', 'Mohamed1812470@miuegypt.edu.eg', '+201156052920', '#36dd60', '1', '2021-09-12 10:00:29', '2021-09-12 10:00:29', 1, 2, 'Shamrock', NULL, 2, ''),
(7, 'Mohamed Ashraf', 'Mohamed1812470@miuegypt.edu.eg', '+201156052920', '#a33838', '1', '2021-09-19 11:02:41', '2021-09-19 11:02:41', 1, 3, 'Stiletto', 'Test', 2, 'B-2'),
(8, 'gggggdddddddd', 'gggggggggggggggggggg@fff.com', 'ggggggggdddddd', '#be7474', '1', '2021-09-19 11:03:17', '2021-09-19 11:03:17', 1, 3, 'Old Rose', NULL, 2, 'B-3');

-- --------------------------------------------------------

--
-- Table structure for table `belonging_sizes`
--

CREATE TABLE `belonging_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `belonging_sizes`
--

INSERT INTO `belonging_sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Light', NULL, NULL),
(2, 'Normal', NULL, NULL),
(3, 'Heavy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `belonging_types`
--

CREATE TABLE `belonging_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `belonging_types`
--

INSERT INTO `belonging_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Bag', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_11_215558_create_belongings_table', 1),
(6, '2021_09_11_215717_create_belonging_types_table', 1),
(7, '2021_09_11_215738_create_belonging_sizes_table', 1),
(8, '2021_09_11_215847_add_columns_to_belongings_table', 1),
(9, '2021_09_11_223926_add_more_columns_to_belongings_table', 2),
(10, '2021_09_11_232328_create_slots_table', 3),
(11, '2021_09_12_021213_add_slot_id_table_to_belongings_table', 4),
(12, '2021_09_12_111747_create_avatars_table', 5),
(13, '2021_09_12_111835_add_avatar_column_to_users_table', 6),
(14, '2021_09_19_125543_add_code_column_to_belongings_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `name`, `max`, `created_at`, `updated_at`) VALUES
(1, 'A', 50, NULL, NULL),
(2, 'B', 50, NULL, NULL),
(3, 'C', 50, NULL, NULL),
(4, 'D', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `avatar_id`) VALUES
(1, 'xTrimy', 'Mohamed1812470@miuegypt.edu.eg', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2021-09-12 09:48:13', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `belongings`
--
ALTER TABLE `belongings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belongings_belonging_type_id_foreign` (`belonging_type_id`),
  ADD KEY `belongings_belonging_size_id_foreign` (`belonging_size_id`),
  ADD KEY `belongings_slot_id_foreign` (`slot_id`);

--
-- Indexes for table `belonging_sizes`
--
ALTER TABLE `belonging_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `belonging_types`
--
ALTER TABLE `belonging_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_avatar_id_foreign` (`avatar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `belongings`
--
ALTER TABLE `belongings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `belonging_sizes`
--
ALTER TABLE `belonging_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `belonging_types`
--
ALTER TABLE `belonging_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `belongings`
--
ALTER TABLE `belongings`
  ADD CONSTRAINT `belongings_belonging_size_id_foreign` FOREIGN KEY (`belonging_size_id`) REFERENCES `belonging_sizes` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `belongings_belonging_type_id_foreign` FOREIGN KEY (`belonging_type_id`) REFERENCES `belonging_types` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `belongings_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `slots` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_avatar_id_foreign` FOREIGN KEY (`avatar_id`) REFERENCES `avatars` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
