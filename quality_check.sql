-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2025 at 04:05 PM
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('quality-check-cache-settings.all', 'a:3:{s:8:\"app_name\";s:13:\"Quality Check\";s:8:\"app_logo\";s:53:\"settings/atgscYHUBWJfozCP5qomszcoBWejWSBK0qJbwgaD.png\";s:8:\"app_icon\";s:53:\"settings/TvBx6ZBAAqsNRRqa4yUqYcSCyWJGJoY9kaEKX6v8.png\";}', 2075370089);

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
(4, '{\"ar\": \"فئة تجريبية 2\", \"en\": \"Test Category 2\"}', 'test-category-3', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'categories/iBsRRcpeu6icKtYXFDblZXnRkG2xDoKGVPeLEQrd.jpg', 1, 0, 100.00, 850.00, '2025-10-02 11:53:51', '2025-10-04 05:38:31', '2025-10-04 05:38:31'),
(5, '{\"ar\": \"asdsad\", \"en\": \"asdasd\"}', 'asdasd', '{\"en\": null}', 'categories/iNlXLv18qg8z8FkzQqsjxDLlJELffVJkJbEEH0Fi.jpg', 1, 1, 10.00, 1.00, '2025-10-08 11:24:32', '2025-10-08 12:25:51', NULL);

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
(17, 2, 'adasd', '[\"asd\", \"asdsa\", \"asdsa\", \"asdsad\"]', 0, 0, 1, 1, 0, '2025-10-04 05:43:11', '2025-10-08 11:27:41'),
(18, 2, 'ttt', '[\"q\", \"a\", \"c\", \"b\"]', 1, 0, 1, 1, 3, '2025-10-08 10:38:33', '2025-10-08 10:38:33'),
(21, 5, 'هل لديك سجل تجاري', '[\"نعم\", \"لا\"]', 1, 1, 10, 1, 1, '2025-10-08 12:25:51', '2025-10-08 12:25:51'),
(22, 5, 'هل لديك فروع اخري', '[\"نعم\", \"لا\"]', 0, 0, 10, 1, 2, '2025-10-08 12:25:51', '2025-10-08 12:25:51');

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
(14, '2025_10_04_115112_create_phone_verification_codes_table', 8),
(17, '2025_10_04_141711_create_providers_table', 9),
(18, '2025_10_05_144937_create_provider_answers_table', 10),
(19, '2025_10_06_123643_create_provider_services_table', 11),
(20, '2025_10_06_134500_create_provider_subscriptions_table', 11),
(21, '2025_10_07_140351_create_settings_table', 12),
(22, '2025_10_08_101808_add_amount_to_provider_subscriptions_table', 13),
(23, '2025_10_09_113831_create_permission_tables', 14),
(24, '2025_10_09_131304_create_tickets_table', 15),
(25, '2025_10_09_131522_create_ticket_messages_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 10);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Categories', 'web', '2025-10-09 08:43:17', '2025-10-09 08:43:17'),
(2, 'Questions', 'web', '2025-10-09 08:43:26', '2025-10-09 08:43:26'),
(3, 'Badges', 'web', '2025-10-09 08:43:38', '2025-10-09 08:43:38'),
(4, 'Services', 'web', '2025-10-09 08:43:46', '2025-10-09 08:43:46'),
(5, 'Users', 'web', '2025-10-09 08:43:56', '2025-10-09 08:44:05'),
(6, 'Providers', 'web', '2025-10-09 08:44:20', '2025-10-09 08:44:20'),
(7, 'Admins', 'web', '2025-10-09 08:44:27', '2025-10-09 08:44:27'),
(8, 'Provider Services', 'web', '2025-10-09 08:44:53', '2025-10-09 08:44:53'),
(9, 'Provider Subscriptions', 'web', '2025-10-09 08:45:11', '2025-10-09 08:45:11'),
(10, 'Settings', 'web', '2025-10-09 08:45:19', '2025-10-09 08:45:19');

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
(2, 'App\\Models\\User', 3, 'auth-token', '463a081a584546278b98103ca3bb6d769a3ba561623a9d5be81e2b27f95d97c0', '[\"*\"]', '2025-10-08 12:24:37', NULL, '2025-10-04 09:03:55', '2025-10-08 12:24:37'),
(3, 'App\\Models\\User', 3, 'auth-token', '136fe966c4ce22dcd2f0e4f4d64b10d67f4dce3374e9cd52327018de16bca89c', '[\"*\"]', NULL, NULL, '2025-10-04 09:09:33', '2025-10-04 09:09:33'),
(4, 'App\\Models\\User', 3, 'auth-token', 'f8cb3a7c2c913b5a7f5c1c04173cdd5f5cd57a522ca9917e5d8a0c59609390d4', '[\"*\"]', NULL, NULL, '2025-10-04 09:12:34', '2025-10-04 09:12:34'),
(5, 'App\\Models\\User', 3, 'auth-token', '67b8e84c9c524e60924bc9099c1b1c75bbdd375d3f8e6d3c7f54440babd7e710', '[\"*\"]', NULL, NULL, '2025-10-04 09:42:54', '2025-10-04 09:42:54'),
(6, 'App\\Models\\User', 3, 'auth-token', 'b5d6966fd5f0d3a7599a1ceb423b35bf2ce92dcc9955772b26de9a639097cebd', '[\"*\"]', '2025-10-07 06:52:52', NULL, '2025-10-05 11:44:27', '2025-10-07 06:52:52'),
(7, 'App\\Models\\User', 3, 'auth-token', '9754be99548ecac9dcd1863bfd24016f6ec1178485a09c0156fe7542603a2cf9', '[\"*\"]', '2025-10-06 06:49:05', NULL, '2025-10-06 06:48:42', '2025-10-06 06:49:05'),
(8, 'App\\Models\\User', 7, 'auth-token', '7fb123ac02171e9fcdfcf7dff1d13478c9ebcd16a7a0ab238ecdc74849e8b7f9', '[\"*\"]', '2025-10-06 06:56:35', NULL, '2025-10-06 06:51:59', '2025-10-06 06:56:35'),
(9, 'App\\Models\\User', 7, 'auth-token', 'ba535e49d01fabb35e550ea8a443227498fca0c84659e46dc3146bd78d1f09c2', '[\"*\"]', '2025-10-08 10:38:43', NULL, '2025-10-07 06:53:12', '2025-10-08 10:38:43'),
(10, 'App\\Models\\User', 8, 'auth-token', 'dfec7a1a33f2b83df6317362238597cb6ce94679b1549fcc01617c5101b555ae', '[\"*\"]', '2025-10-08 10:38:54', NULL, '2025-10-08 07:24:25', '2025-10-08 10:38:54'),
(11, 'App\\Models\\User', 9, 'auth-token', '5c1d15167388c1c08f42c5bbf971bed34bb13864b3a1a67ffe9e18d329b4f26d', '[\"*\"]', '2025-10-08 10:51:34', NULL, '2025-10-08 10:37:55', '2025-10-08 10:51:34'),
(12, 'App\\Models\\User', 3, 'auth-token', 'b7a8516b45540f36dc862c0a14658d677739593744acac4f75308a3ec10baa58', '[\"*\"]', '2025-10-09 11:30:51', NULL, '2025-10-09 10:37:30', '2025-10-09 11:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `phone_verification_codes`
--

CREATE TABLE `phone_verification_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` json NOT NULL,
  `description` json DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `badge_id` bigint UNSIGNED DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `name`, `description`, `slug`, `user_id`, `category_id`, `badge_id`, `latitude`, `longitude`, `address`, `website_link`, `established_date`, `start_time`, `end_time`, `is_active`, `is_verified`, `image`, `pdf`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"ar\": \"مقدم خدمة تجريبي\", \"en\": \"Test Provider\"}', '{\"ar\": \"<p>وصف تجريبي للمقدم من اجل توضيح خدماته</p>\", \"en\": \"<p>just test description for provider</p>\"}', 'test-provider', 7, 1, 3, 33.00000000, 35.00000000, 'Cairo', 'https://google.com', '1990-01-01', '10:00:00', '18:00:00', 1, 1, 'providers/images/provider_1_1759750112.jpg', NULL, '2025-10-06 06:50:35', '2025-10-06 09:05:14', NULL),
(2, '{\"en\": \"Test Provider 2\"}', NULL, 'test-provider-2', 8, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-10-08 07:24:03', '2025-10-08 07:33:49', NULL),
(3, '{\"en\": \"Test Provider 3\"}', '{\"ar\": \"وصف تجريبي\", \"en\": \"test description\"}', 'test-provider-3', 9, 2, 1, 30.00000000, 35.00000000, '3 makram st', 'https://www.google.com', '2025-02-15', '08:00:00', '22:00:00', 1, 1, 'providers/images/provider_3_1759931494.jpg', 'providers/pdfs/provider_3_1759931494.pdf', '2025-10-08 10:37:43', '2025-10-08 11:36:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provider_answers`
--

CREATE TABLE `provider_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `provider_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `is_evaluated` tinyint(1) NOT NULL DEFAULT '0',
  `submitted_at` timestamp NULL DEFAULT NULL,
  `evaluated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_answers`
--

INSERT INTO `provider_answers` (`id`, `provider_id`, `question_id`, `answer`, `attachment`, `score`, `is_correct`, `is_evaluated`, `submitted_at`, `evaluated_at`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 'لا', NULL, 0, 0, 1, '2025-10-06 06:53:50', '2025-10-06 08:16:46', '2025-10-06 06:53:50', '2025-10-06 08:16:46'),
(3, 1, 14, 'نعم', 'provider_answers/provider_1_question_14_1759744538.png', 3, 1, 1, '2025-10-06 06:55:38', '2025-10-06 07:27:20', '2025-10-06 06:55:38', '2025-10-06 07:27:20'),
(6, 2, 17, 'asdsad', NULL, 1, 1, 1, '2025-10-08 07:30:11', '2025-10-08 07:30:49', '2025-10-08 07:30:11', '2025-10-08 07:30:49'),
(7, 2, 16, 'نعم', 'provider_answers/provider_2_question_16_1759919429.jpg', 10, 1, 1, '2025-10-08 07:30:29', '2025-10-08 07:30:45', '2025-10-08 07:30:29', '2025-10-08 07:30:45'),
(8, 3, 16, 'نعم', 'provider_answers/provider_3_question_16_1759930745.jpg', 0, 0, 1, '2025-10-08 10:39:05', '2025-10-08 11:35:44', '2025-10-08 10:39:05', '2025-10-08 11:35:44'),
(9, 3, 18, 'a', 'provider_answers/provider_3_question_18_1759930757.jpg', 1, 1, 1, '2025-10-08 10:39:17', '2025-10-08 11:35:24', '2025-10-08 10:39:17', '2025-10-08 11:35:24'),
(10, 3, 17, 'asdasd', NULL, 1, 1, 1, '2025-10-08 10:39:26', '2025-10-08 11:35:07', '2025-10-08 10:39:26', '2025-10-08 11:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `provider_services`
--

CREATE TABLE `provider_services` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_services`
--

INSERT INTO `provider_services` (`id`, `uuid`, `provider_id`, `service_id`, `price`, `description`, `image`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '4e27e9bb-806d-4631-9c58-af49742c2428', 1, 1, '50', '{\"ar\": \"<p>تيست</p>\", \"en\": \"<p>test</p>\"}', 'providers/images/provider_4e27e9bb-806d-4631-9c58-af49742c2428_1759836915.jpg', '1', '2025-10-07 07:11:08', '2025-10-07 08:36:43', NULL),
(2, '6343af6e-b859-4797-9892-bedb3ef953c9', 1, 5, '40', '{\"ar\": \"<p>شسيسشي</p>\", \"en\": \"<p>شسيشسي</p>\"}', 'providers/images/provider_1_1759838190.jpg', '1', '2025-10-07 08:56:30', '2025-10-07 10:55:20', '2025-10-07 10:55:20'),
(3, 'ad8c7cb6-e9ce-4b0c-a791-60f0896e0735', 1, 5, '35', '{\"ar\": \"<p>تيست</p>\", \"en\": \"<p>test</p>\"}', 'providers/images/provider_1_1759839024.jpg', '1', '2025-10-07 09:10:24', '2025-10-07 10:53:29', NULL),
(4, '50734585-b6f3-4096-86e4-ba68d2820283', 2, 2, NULL, '{\"ar\": \"تيست\", \"en\": \"test\"}', 'providers/images/provider_2_1759919999.jpg', '1', '2025-10-08 07:39:59', '2025-10-08 07:39:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provider_subscriptions`
--

CREATE TABLE `provider_subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_subscriptions`
--

INSERT INTO `provider_subscriptions` (`id`, `uuid`, `provider_id`, `category_id`, `start_date`, `end_date`, `amount`, `status`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, '71a7af6d-96df-4147-b029-d7768844033b', 2, 2, '2025-10-08', '2025-11-08', 100.00, 'active', 'cash', 'paid', '2025-10-08 07:33:19', '2025-10-08 07:39:24');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-10-09 08:41:45', '2025-10-09 08:41:45'),
(2, 'User', 'web', '2025-10-09 08:41:54', '2025-10-09 08:41:54'),
(3, 'Admin', 'web', '2025-10-09 08:50:26', '2025-10-09 08:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` json NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` json DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(5, '{\"ar\": \"خدمة تجريبية\", \"en\": \"test service 5\"}', 1, 'test-service-5', '{\"ar\": \"<p>وصف تجريبي</p>\", \"en\": \"<p>test description</p>\"}', 'services/yT8qrYRRgj07v1dXBF7NE29C2BqznRWo0rHJy773.jpg', 1, 1, '2025-10-04 06:17:07', '2025-10-04 07:52:01', NULL),
(7, '{\"ar\": \"شسيسشيش\", \"en\": \"شيشس\"}', 5, 'shyshs', '{\"ar\": \"<p>شسيشسي</p>\", \"en\": \"<p>شسيشي</p>\"}', 'services/7kXxp8HQxsK3Smhjl9G8FyexTaYJGxa6yqkw7bps.png', 1, 1, '2025-10-08 11:29:51', '2025-10-08 11:29:51', NULL);

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
('Zt44dn5ChFT9Ef9sXhg4QT72VQDWIoq9WCXLzYKn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNFNSc3haQ3JUTWc0dzYyb1dnUExMVzJxQ1Z0WndBSTAzVlpGQ1c2dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjY6ImxvY2FsZSI7czoyOiJlbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9xdWFsaXR5LWNoZWNrLnRlc3QvYWRtaW4vc2VydmljZXMiO319', 1760024005);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'Quality Check', 'text', '2025-10-07 11:06:11', '2025-10-07 11:06:11'),
(2, 'app_logo', 'settings/atgscYHUBWJfozCP5qomszcoBWejWSBK0qJbwgaD.png', 'image', '2025-10-07 11:06:38', '2025-10-07 11:21:43'),
(3, 'app_icon', 'settings/TvBx6ZBAAqsNRRqa4yUqYcSCyWJGJoY9kaEKX6v8.png', 'image', '2025-10-07 11:06:52', '2025-10-07 11:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','solved','closed','hold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ticket_from` enum('user','provider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `uuid`, `user_id`, `subject`, `description`, `status`, `ticket_from`, `created_at`, `updated_at`) VALUES
(2, 'ea30f1b8-c8c4-48bf-8c07-d8dd061faea4', 3, 'Test Subject 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni earum aliquam, quisquam blanditiis iusto nam fuga deserunt quo. Quam nobis excepturi ipsa repellat doloremque illum laboriosam reprehenderit iure quod soluta.', 'open', 'user', '2025-10-09 10:54:24', '2025-10-09 11:05:46'),
(3, 'bb6e08de-8d71-413b-a188-e657aa89c9ae', 3, 'Test Subject', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni earum aliquam, quisquam blanditiis iusto nam fuga deserunt quo. Quam nobis excepturi ipsa repellat doloremque illum laboriosam reprehenderit iure quod soluta.', 'open', 'user', '2025-10-09 10:54:48', '2025-10-09 11:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `sender_type` enum('user','provider','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_messages`
--

INSERT INTO `ticket_messages` (`id`, `ticket_id`, `sender_type`, `sender_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 3, 'admin', 1, 'test reply', '2025-10-09 11:24:13', '2025-10-09 11:24:13'),
(2, 3, 'admin', 1, 'test reply', '2025-10-09 11:25:17', '2025-10-09 11:25:17'),
(3, 3, 'admin', 1, 'asdas', '2025-10-09 11:26:51', '2025-10-09 11:26:51'),
(4, 3, 'user', 3, 'tset user reply', '2025-10-09 11:28:50', '2025-10-09 11:28:50');

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
  `role` enum('admin','user','provider') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
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
(1, '1dc707b7-d478-4ce5-aab7-34ef91ca27ec', 'admin', 'admin@admin.com', '+20123456789', 'admin', 'profile-images/VzWZ4Tuzgq5VUUEw1FoPYNjRQAxKK7UDA3JztJfm.png', NULL, NULL, 1, 1, '2025-10-02 11:00:41', '$2y$12$XrSnX9BOml/V1MptoFebYeIxv15ci0TVitgVCCqWwaLJ28Uc27sQq', 'oCQKhLsUr8qvz7NsfN56fQb8fOKV0bLNeWLyKnRsR75aEcasN2ptfnR4v3nA', '2025-10-02 08:00:30', '2025-10-04 10:41:27'),
(3, 'b31a4131-4a2b-4ca8-b0a8-27573685fa57', 'Test Api User', 'tset@test.com', '+01111111111', 'user', NULL, NULL, NULL, 1, 1, '2025-10-04 09:12:02', '$2y$12$vQ7RE3bMmlmLt5fBUIBy7e93Xn2hks43CVN260LfdYZdw8dsPf0qW', NULL, '2025-10-04 08:58:45', '2025-10-04 10:50:13'),
(7, 'c3348b82-e9df-455f-b4e3-349b276d0cf3', 'Test Provider', 'tset@provider.com', '+01111111110', 'provider', NULL, NULL, NULL, 1, 1, '2025-10-06 06:51:13', '$2y$12$7PmYDffCmHkAH5DMhGN05.F74DRUS6bhEKaVzqwKxvYvVmO0NaBB2', NULL, '2025-10-06 06:50:35', '2025-10-06 06:51:13'),
(8, 'b6679c98-9b06-47cf-9889-9a58d0df7040', 'Test Provider 2', 'tset@provide2r.com', '+01111111112', 'provider', NULL, NULL, NULL, 1, 1, '2025-10-08 07:24:15', '$2y$12$3WLOL5j2KD2sERFuWDkzpOAWAQ5z/ahQAtOa3kVjd6lhc4DxXXMtm', NULL, '2025-10-08 07:24:03', '2025-10-08 07:24:15'),
(9, '1400210d-dc60-42aa-9d05-bcb82c5c0128', 'Test Provider 3', 'tset@provider3.com', '+01111111113', 'provider', NULL, NULL, NULL, 1, 1, '2025-10-08 10:37:48', '$2y$12$fjmoq5ba6nvozLRqQiMYD.WF0Eb8Can27fiDjqbeYowOElXWnmcFW', NULL, '2025-10-08 10:37:43', '2025-10-08 10:37:48'),
(10, 'beb0b096-6376-4267-b764-2b88f9baed11', 'Test Sub Admin', 'subadmin@admin.com', '+01200110101', 'admin', 'uploads/users/XBIrQx4RdoWd8tPRHVeqTYc6PWrWHlHWL12stybC.jpg', NULL, NULL, 0, 1, NULL, '$2y$12$R3SH6L34y/JHJXfKMyB45u0/buH1a87JTJiwGCJhN.AK2lgfqw7PK', NULL, '2025-10-09 09:24:12', '2025-10-09 10:10:38');

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

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
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `providers_slug_unique` (`slug`),
  ADD KEY `providers_user_id_foreign` (`user_id`),
  ADD KEY `providers_category_id_foreign` (`category_id`),
  ADD KEY `providers_badge_id_foreign` (`badge_id`);

--
-- Indexes for table `provider_answers`
--
ALTER TABLE `provider_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_answers_provider_id_question_id_unique` (`provider_id`,`question_id`),
  ADD KEY `provider_answers_provider_id_is_evaluated_index` (`provider_id`,`is_evaluated`),
  ADD KEY `provider_answers_question_id_is_evaluated_index` (`question_id`,`is_evaluated`);

--
-- Indexes for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_services_uuid_unique` (`uuid`),
  ADD KEY `provider_services_provider_id_foreign` (`provider_id`),
  ADD KEY `provider_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `provider_subscriptions`
--
ALTER TABLE `provider_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_subscriptions_uuid_unique` (`uuid`),
  ADD KEY `provider_subscriptions_provider_id_foreign` (`provider_id`),
  ADD KEY `provider_subscriptions_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_uuid_unique` (`uuid`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_messages_sender_id_foreign` (`sender_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `phone_verification_codes`
--
ALTER TABLE `phone_verification_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provider_answers`
--
ALTER TABLE `provider_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provider_services`
--
ALTER TABLE `provider_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provider_subscriptions`
--
ALTER TABLE `provider_subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  ADD CONSTRAINT `mcq_questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `providers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_answers`
--
ALTER TABLE `provider_answers`
  ADD CONSTRAINT `provider_answers_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `mcq_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD CONSTRAINT `provider_services_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_subscriptions`
--
ALTER TABLE `provider_subscriptions`
  ADD CONSTRAINT `provider_subscriptions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_subscriptions_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
