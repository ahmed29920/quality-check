-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 04, 2025 at 07:09 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quality_check`
--

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` bigint UNSIGNED NOT NULL,
  `name` json NOT NULL,
  `min_score` int NOT NULL,
  `max_score` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `min_score`, `max_score`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"ar\": \"إشارة برونزية\", \"en\": \"Bronze Badge\"}', 0, 20, 1, '2025-10-04 04:58:44', '2025-10-04 05:08:18', NULL),
(2, '{\"ar\": \"إشارة فضية\", \"en\": \"Sliver Badge\"}', 21, 40, 1, '2025-10-04 04:58:44', '2025-10-04 05:08:32', NULL),
(3, '{\"ar\": \"إشارة بلاتينيوم\", \"en\": \"Platinum Badge\"}', 41, 60, 1, '2025-10-04 04:58:44', '2025-10-04 05:09:12', NULL),
(4, '{\"ar\": \"إشارة ذهبية\", \"en\": \"Gold Badge\"}', 61, 80, 1, '2025-10-04 04:58:44', '2025-10-04 05:09:34', NULL),
(5, '{\"ar\": \"إشارة ماسية\", \"en\": \"Diamond Badge\"}', 81, 100, 1, '2025-10-04 04:58:44', '2025-10-04 05:10:09', NULL),
(6, '{\"ar\": \"إشارة فضية\", \"en\": \"Sliver Badge\"}', 0, 25, 1, '2025-10-04 04:58:44', '2025-10-04 05:10:13', '2025-10-04 05:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` json NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` json NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `has_pricable_services` tinyint(1) NOT NULL DEFAULT '1',
  `monthly_subscription_price` decimal(10,2) DEFAULT NULL,
  `yearly_subscription_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `has_pricable_services`, `monthly_subscription_price`, `yearly_subscription_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"ar\": \"فئة تجريبية\", \"en\": \"Test Category\"}', 'test-category', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>Test Description&nbsp;</p>\"}', 'categories/pE4pv9T7J530cwYEckRV4MBsCoFicWlNJouMbj7x.jpg', 1, 1, NULL, NULL, '2025-10-02 11:27:53', '2025-10-04 03:25:00', NULL),
(2, '{\"ar\": \"فئة تجريبية 2\", \"en\": \"Test Category 2\"}', 'test-category-2', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'categories/KcKNWoHApHj2Xzi5yrDMM0ejZh1VaAtZX5zKVfg8.jpg', 1, 0, 100.00, 850.00, '2025-10-02 11:53:51', '2025-10-04 03:25:38', NULL),
(4, '{\"ar\": \"فئة تجريبية 2\", \"en\": \"Test Category 2\"}', 'test-category-3', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'categories/iBsRRcpeu6icKtYXFDblZXnRkG2xDoKGVPeLEQrd.jpg', 1, 0, 100.00, 850.00, '2025-10-02 11:53:51', '2025-10-04 05:38:31', '2025-10-04 05:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mcq_questions`
--

CREATE TABLE `mcq_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json NOT NULL,
  `allows_attachments` tinyint(1) NOT NULL DEFAULT '0',
  `requires_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `score` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcq_questions`
--

INSERT INTO `mcq_questions` (`id`, `category_id`, `title`, `options`, `allows_attachments`, `requires_attachment`, `score`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(13, 1, 'هل لديك فروع أخرى', '[\"نعم\", \"لا\"]', 0, 0, 3, 1, 1, '2025-10-04 03:25:00', '2025-10-04 03:25:00'),
(14, 1, 'هل لديك سجل تجاري', '[\"نعم\", \"لا\"]', 1, 0, 3, 1, 2, '2025-10-04 03:25:00', '2025-10-04 03:25:00'),
(15, 1, 'اختر اي اجابة', '[\"لا\", \"لا لا\", \"لا لا لا\", \"لا لا لا لا\"]', 0, 0, 4, 1, 3, '2025-10-04 03:25:00', '2025-10-04 03:25:00'),
(16, 2, 'هل لديك اي شيء؟', '[\"نعم\", \"لا\"]', 1, 1, 10, 1, 1, '2025-10-04 03:25:38', '2025-10-04 03:25:38'),
(17, 2, 'adasd', '[\"asd\", \"asdsa\", \"asdsa\", \"asdsad\"]', 0, 0, 1, 1, 0, '2025-10-04 05:43:11', '2025-10-04 05:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(7, '2025_10_02_101031_create_categories_table', 2),
(8, '2025_10_02_104829_create_personal_access_tokens_table', 2),
(9, '2025_10_02_110117_add_is_active_to_usrs_table', 3),
(10, '2025_10_02_123650_create_mcq_questions_table', 4),
(11, '2025_10_04_074139_create_badges_table', 5),
(12, '2025_10_04_081828_create_services_table', 6),
(13, '2025_10_04_115049_create_password_reset_tokens_table', 7),
(14, '2025_10_04_115112_create_phone_verification_codes_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('tset@test.com', '$2y$12$ISZZ1MGvcgPsiB47zN3rIuxFVmtfnMicuVqul01PGvbEhK2aYJCom', '2025-10-04 09:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 3, 'auth-token', '463a081a584546278b98103ca3bb6d769a3ba561623a9d5be81e2b27f95d97c0', '[\"*\"]', '2025-10-04 09:43:34', NULL, '2025-10-04 09:03:55', '2025-10-04 09:43:34'),
(3, 'App\\Models\\User', 3, 'auth-token', '136fe966c4ce22dcd2f0e4f4d64b10d67f4dce3374e9cd52327018de16bca89c', '[\"*\"]', NULL, NULL, '2025-10-04 09:09:33', '2025-10-04 09:09:33'),
(4, 'App\\Models\\User', 3, 'auth-token', 'f8cb3a7c2c913b5a7f5c1c04173cdd5f5cd57a522ca9917e5d8a0c59609390d4', '[\"*\"]', NULL, NULL, '2025-10-04 09:12:34', '2025-10-04 09:12:34'),
(5, 'App\\Models\\User', 3, 'auth-token', '67b8e84c9c524e60924bc9099c1b1c75bbdd375d3f8e6d3c7f54440babd7e710', '[\"*\"]', NULL, NULL, '2025-10-04 09:42:54', '2025-10-04 09:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `phone_verification_codes`
--

CREATE TABLE `phone_verification_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` json NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_pricable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `category_id`, `slug`, `description`, `image`, `is_active`, `is_pricable`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"ar\": \"خدمة تجريبية\", \"en\": \"test service\"}', 1, 'test-service', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'services/O680KynNiUwD4fDkWwa08QTi5TWXK0qcsOusY7XM.jpg', 1, 1, '2025-10-04 06:17:07', '2025-10-04 07:19:09', NULL),
(2, '{\"ar\": \"خدمة تجريبية 1\", \"en\": \"test service 1\"}', 2, 'test-service-1', '{\"ar\": \"<p>dasd</p>\", \"en\": \"<p>sadsad</p>\"}', 'services/JsFXpLbfzo39Zs4qcDeD0LkBOpOJcum6R244u2lX.jpg', 1, 0, '2025-10-04 06:55:15', '2025-10-04 06:55:15', NULL),
(5, '{\"ar\": \"خدمة تجريبية\", \"en\": \"test service 5\"}', 1, 'test-service-5', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'services/yT8qrYRRgj07v1dXBF7NE29C2BqznRWo0rHJy773.jpg', 1, 1, '2025-10-04 06:17:07', '2025-10-04 07:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jsRyZZdH7e5RNoCTEKTU2jKAkBc8vQv7FxpbmAes', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUFFIRXNyd0t1eXR0elJLNTB0SWNWeGtNakFJWVloVGtjTG5weVRGaiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjY6ImxvY2FsZSI7czoyOiJlbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9xdWFsaXR5LWNoZWNrLnRlc3QvYWRtaW4vY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759587390);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code_expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `phone`, `role`, `image`, `verification_code`, `verification_code_expires_at`, `is_verified`, `is_active`, `phone_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1dc707b7-d478-4ce5-aab7-34ef91ca27ec', 'admin', 'admin@admin.com', '+20123456789', 'admin', 'profile-images/VzWZ4Tuzgq5VUUEw1FoPYNjRQAxKK7UDA3JztJfm.png', NULL, NULL, 1, 1, '2025-10-02 11:00:41', '$2y$12$XrSnX9BOml/V1MptoFebYeIxv15ci0TVitgVCCqWwaLJ28Uc27sQq', 'FgY87RwHsAXJwmrGf8bFqEyATsaGQ9iLUDNqYHET2z2mm15ZX7SMpxJJUiVQ', '2025-10-02 08:00:30', '2025-10-04 10:41:27'),
(3, 'b31a4131-4a2b-4ca8-b0a8-27573685fa57', 'Test Api User', 'tset@test.com', '+01111111111', 'user', NULL, NULL, NULL, 1, 1, '2025-10-04 09:12:02', '$2y$12$vQ7RE3bMmlmLt5fBUIBy7e93Xn2hks43CVN260LfdYZdw8dsPf0qW', NULL, '2025-10-04 08:58:45', '2025-10-04 10:50:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mcq_questions_category_id_sort_order_index` (`category_id`,`sort_order`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `phone_verification_codes`
--
ALTER TABLE `phone_verification_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_verification_codes_phone_code_index` (`phone`,`code`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phone_verification_codes`
--
ALTER TABLE `phone_verification_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  ADD CONSTRAINT `mcq_questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
