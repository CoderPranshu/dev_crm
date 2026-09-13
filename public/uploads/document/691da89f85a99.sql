-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 13, 2025 at 07:22 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u538333613_indiorigin`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@gmail.com|2401:4900:4460:c8c6:0:67:982e:801', 'i:1;', 1762435647),
('laravel-cache-admin@gmail.com|2401:4900:4460:c8c6:0:67:982e:801:timer', 'i:1762435647;', 1762435647);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `des`, `image`, `created_at`, `updated_at`) VALUES
(4, 'Handcrafted Home Decor', 'Handcrafted Home Decor', 'uploads/category/1760335757.png', '2025-10-09 00:32:24', '2025-11-09 06:31:05'),
(5, 'Block Printed textiles', 'Textiles & Fabrics', 'uploads/category/1760336124.png', '2025-10-09 00:34:44', '2025-11-09 06:29:26'),
(6, 'Handcrafted Leather Products', 'Leather & Footwear', 'uploads/category/1760336149.png', '2025-10-09 00:35:50', '2025-11-09 06:32:18'),
(7, 'Blue Pottery', 'Pottery & Ceramics', 'uploads/category/1762670161.jpg', '2025-10-09 00:36:40', '2025-11-09 06:36:01'),
(8, 'Handicrafted Gifts & Souvenirs', 'Handicraft Gifts & Souvenirs', 'uploads/category/1760336183.png', '2025-10-09 00:37:25', '2025-11-09 06:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `working_hour` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `whastapp` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `tweeter` varchar(255) DEFAULT NULL,
  `linkdin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `contact`, `email`, `address`, `working_hour`, `created_at`, `updated_at`, `whastapp`, `instagram`, `facebook`, `tweeter`, `linkdin`) VALUES
(1, '+91 99999 99999', 'info@Handicraft', '25/B Palam, New Delh', 'Mon to Sat -10:00 AM - 05:00 PM  Sunday - Closed', NULL, '2025-10-15 03:08:37', NULL, 'https://www.instagram.com/', 'https://www.facebook.com/', 'https://x.com/', 'https://in.linkedin.com/');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_30_102910_create_sliders_table', 1),
(5, '2025_10_01_070301_create_categories_table', 1),
(6, '2025_10_01_071638_create_products_table', 1),
(7, '2025_10_04_103237_create_testimonials_table', 1),
(8, '2025_10_04_103645_create_contacts_table', 1),
(9, '2025_10_08_115055_add_new_to_sliders', 2),
(10, '2025_10_08_171806_create_subcategories_table', 3),
(11, '2025_10_08_173015_rename_category_id_to_subcategory_id', 4),
(12, '2025_10_09_095300_add_new_to_products', 5),
(13, '2025_10_09_124108_add_new_to_subcategories', 6),
(14, '2025_10_13_063405_create_spotlight__artisans_table', 7),
(15, '2025_10_13_103834_add_new_to_contacts', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subcategory_id` varchar(255) NOT NULL,
  `price` varchar(255) DEFAULT NULL,
  `treding_product` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `created_at`, `updated_at`, `subcategory_id`, `price`, `treding_product`) VALUES
(5, 'Special Gift Box', 'uploads/product/1760010624.png', '2025-10-09 06:20:24', '2025-10-13 04:16:06', '9', '100', 'yes'),
(6, 'Special Gift Box', 'uploads/product/1760011757.png', '2025-10-09 06:39:17', '2025-10-09 06:40:51', '4', '50', 'yes'),
(7, 'Special Gift Box', 'uploads/product/1760011785.png', '2025-10-09 06:39:45', '2025-10-09 07:00:11', '4', '250', 'yes'),
(8, 'Special Gift Box', 'uploads/product/1760011810.png', '2025-10-09 06:40:10', '2025-10-09 06:41:01', '9', '50', 'yes'),
(9, 'Special Gift Box', 'uploads/product/1760011842.png', '2025-10-09 06:40:42', '2025-10-09 06:41:06', '8', '250', 'yes'),
(10, 'Special Gift Box', 'uploads/product/1760012011.png', '2025-10-09 06:43:31', '2025-10-09 06:43:57', '10', '250', 'yes'),
(11, 'Rohit Mehta1', 'uploads/product/1760081680.jpg', '2025-10-10 02:04:40', '2025-10-10 02:04:40', '7', '100', 'no'),
(12, 'Rahim Simon', 'uploads/product/1760100273.jpeg', '2025-10-10 07:14:33', '2025-10-10 07:14:33', '13', '868', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5BnHVyNaOgCmFAKTptRICyucBCIjmWnWYCOgAwro', NULL, '2401:4900:1c75:c54c:f4ec:ecef:2c9f:f54a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDMwWlFHdkdDSWJRSlNtNVlnT1B1VzU0VFY5N05rMHdVbXBiakIzZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763015883),
('637X8zWsxtGiiYb8jruAenOWNMMtOPeKzgA8ZaTL', NULL, '2401:4900:1c89:c77c:f158:190:736e:3437', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXpjd3JPOUNlM0hnQlhVTzQ3MmRNbE9mWEtrMkpQbUhBUUZrSzNHVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njg6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9zdWJjYXRlZ29yeS1wcm9kdWN0LzEzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762866708),
('86ZDu5apLIEupJwLWWbLLZwOmtju3UFSBu9i1g4s', NULL, '103.115.187.106', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWh5WkR2cmhVZHZZOHNvTGl2c3ROQ2tWT1BmMDhHVVJQUEJoZE5IQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763000499),
('93ExMCk3ZaTsmkFCYlpnUwuHwwfzFU0hdx4FPhzJ', NULL, '122.161.75.174', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDBkeEVFdXpldUQxSTBZY3JuVVN5MUJSTFl0OHc4WWZMSjFHVjFaTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9hYm91dC11cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762672510),
('bC1spN6HOXJRRz52VScG24JWucO3GsGEaWxOV4r0', NULL, '35.87.50.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFp1VEtONkdvSFY5U0pzV3JPUjJiVnBjeWpnTURCZmprMDcxMUtUOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763006513),
('BXrqElG0cbEtH7a6sUrSg4RuhGN3EpGTSZJkyEsH', NULL, '34.116.39.37', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 AppEngine-Google; (+http://code.google.com/appengine; appid: s~virustotalcloud)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicEw1NkV0eENTdXYwQndPVFBCVGU0c0tjcjlYV2thYXpRU1VxUnU0cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762996490),
('CWWAhAuAlhNn9Aca6416LUrYRcSIMAqnvTuFq4MF', NULL, '34.116.39.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 AppEngine-Google; (+http://code.google.com/appengine; appid: s~virustotalcloud)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXNvZ0JKY0Z3UUtkOG5hQXo4bTBUbzBkbkhWY0dsaW5kSUZGekh1MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996491),
('DNeO4OMZytJzLgiiF79k8a4KWUpNKxJvrkPfsI7D', NULL, '34.116.39.38', 'Mozilla/5.0 (Linux; Android 13; Pixel 4a (5G) Build/TQ2A.230505.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 GoogleApp/14.16.27.29.arm64 AppEngine-Google; (+http://code.google.com/appengine; appid: s~virustotalcloud)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZzNKbE5RQjNReW1iVlRKNWFnalNZNE1zclhBNHdBZ2NLU1o5Q2ZteSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762996481),
('dRxPQ2PE95CoYcqcQA7bMvhB9YUVXZcfiosIfdNV', NULL, '18.217.125.151', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Edg/114.0.1823.51', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTZEY2NhRmJoY3JoVm96VGszZGxyQzViUnExclJQRGlEYjZwbVFpMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996482),
('EdWV8SLcLaGFoylgiBZ9pxmli2viNCtWO4Dymitp', NULL, '95.181.235.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUJuajdlVkJmNlpVS2o0OVlhWlNXSW1NanEzMkFXSWFuSW1iU3dRTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763004010),
('ehxq4Y3S9GfSIiv1iOqyFUIy8eaDLCDu9MS073YF', NULL, '42.106.160.166', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjdwZk5BYmxHbWd0OWRIZng1azZ4QWdnNTFMc2lkRGhOZE16MVRFTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762669644),
('gKwkqcSaL4KiJrTSusi5JQRkWzYRUNl2wu4ZSAtS', NULL, '188.212.140.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/138.0.7204.156 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickl2OWVGR2VabkNRYVV1WlprakRSR3lFN3kwa1dHRnB0aDlBcUdFaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763003934),
('GQu4XiGXvB4Vq5kBsUmcYsKfNdZ0C2TCmwHsWfjg', NULL, '50.118.175.169', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGRMS1ZDYjF4aVNpZ3ZzSmNPREJuTFV1dWJoZGZYRDJqQTVDNDNoaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763000502),
('hXjEFKIt36e1nmYyIOAGZ57f8bO0Xyu7NLMLzwvm', NULL, '34.118.38.189', 'Mozilla/5.0 (iPhone13,2; U; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVFvV3Q4QlR4ODZvRWhmaEtxSnpYQk02c3dURENrWUc4enNkM0RaeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763000101),
('KkWMw3qdupq6tlq539INBE6GaTZL4hpVcDGoRvk3', 1, '2401:4900:1c89:c77c:f158:190:736e:3437', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicnd1aGZCamlTVUxHYzRIZE5sZ21lRmZmQmZXUFAybkd4d1VRc1BucSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9nZXQtc3ViY2F0ZWdvcmllcy80Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762856146),
('mB6cU1eBsCEdPlxaabhDGHPpOJyz834eLt6EGyda', NULL, '98.81.227.237', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Edg/114.0.1823.51', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3dtdUx2aDRnaGNnSVM2d2RleWdOeXJWOXNDQmhqSVFMSVZpa2RTTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996481),
('o1hvEfYFAptXF6FOx0zUFjpcYYnkpbnAGLv0hryF', NULL, '2401:4900:1c74:305f:499b:f6a4:9026:3fc2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVndhTEhmd29jQksyRlNONTRVRmhCTEdmUGplcnNmQlhMNEV4NXBETiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9hYm91dC11cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762949620),
('qvrMKIqPa00a60k4mz8hvL0niFMxQvOwaEldLrjg', NULL, '18.191.210.47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Edg/114.0.1823.51', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFVFdUZVV3VFenVCSmFsaUt1VFU0Q2xrUHBWTXNQYXRYdmUzcVo2UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996482),
('r5Iga2dWpab9fS6rG0Ijxa87NPuJ87RLYndou0vN', 1, '122.161.75.174', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUtteGlGMDZpRFFpclRFall6WEJsYjlyODRncjFhanVyb1BoNHJ1dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762676197),
('rbBTWK3l0BGbTkN70rBxxz5vyCXbEbRJrnXun3NG', NULL, '54.70.53.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEdiTEFjdWRBUk5VaVlyNjdFZEhmb2M1VHJSazAxWWJ5cFRHd1ZSVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996484),
('t06OATxzajSiMaccl9HrBZxHWum0n3uMYbof9UMF', NULL, '122.161.75.174', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3BPeVdFVElhdEVnNlpQa3lpZXFEajBuNXFrWjREM1d3dFB1SGRsbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762670690),
('UAvkYjp8OZa0BmAu1bgn7OZDozs4VgcbZkl4xTtA', NULL, '34.116.39.36', 'Mozilla/5.0 (Linux; Android 13; Pixel 4a (5G) Build/TQ2A.230505.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 GoogleApp/14.16.27.29.arm64 AppEngine-Google; (+http://code.google.com/appengine; appid: s~virustotalcloud)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGpxQWM5VHJaWGdIQjFBR2JEM0Q2bXBOVVZKUklIRkxSTDdnVEJ1NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996482),
('XgZWJFY4PRWUdq6RcR8px2JqsmNcD1Q2a7utB4hS', NULL, '188.213.34.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUYzcDNoeTNFT0xpU29LMW04VFA5T01lS2wwVm8yZDJmUTF3QVFabyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763000410),
('xzylk5R7Arj1tdKZ8HJn6fjWE9Fq4WqHVDJwz7Ge', NULL, '34.125.230.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnFMdDBod3BNZG0wbnREU0tWa2pIUW80eVVOSzhSTEg0Y1JJcUVhMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762996486),
('ZxM29tJo2eA8IUIuHcNFEfY5tFK4I5olRQjVXuSf', NULL, '122.161.75.174', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWl3R2M1blZtS1dEWUFTa0lTa2NEaFRrYmRpbDMzeW16Z1hkSGgweiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NDoiaHR0cHM6Ly9pbmRpLW9yaWdpbi53ZWJzaXRlaW5kZWxoaS5jb20vcHVibGljL2NhdGVnb3J5Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vaW5kaS1vcmlnaW4ud2Vic2l0ZWluZGVsaGkuY29tL3B1YmxpYy9jYXRlZ29yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762670690);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `text_editor` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `created_at`, `updated_at`, `text_editor`) VALUES
(10, 'uploads/sliders/1759939516.jpg', '2025-10-08 10:35:16', '2025-10-08 10:35:16', '<h6><span style=\"font-family: \'arial black\', sans-serif;\"><span style=\"font-family: arial black, sans-serif;\">Our Product Range</span></span></h6>\n<h1><span style=\"font-family: \'arial black\', sans-serif;\">Timeless Crafts from India</span></h1>\n<p>&nbsp;</p>\n<p><span style=\"font-family: arial black, sans-serif;\">From <strong>home</strong> d&eacute;cor and textiles to leather, pottery, and festive collections &mdash; every piece tells a story of India&rsquo;s rich craft heritage.</span></p>'),
(11, 'uploads/sliders/1759940540.jpg', '2025-10-08 10:52:20', '2025-10-08 11:28:36', '<p><span style=\"font-size: 14pt;\">Why Choose Us</span></p>\r\n<h1><span style=\"font-size: 24pt;\">Crafted with Love &amp; Care</span></h1>\r\n<p>Every purchase supports artisans, preserves traditions, and delivers uncompromising quality with sustainable and ethical practices.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `spotlight__artisans`
--

CREATE TABLE `spotlight__artisans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spotlight__artisans`
--

INSERT INTO `spotlight__artisans` (`id`, `name`, `designation`, `image`, `location`, `des`, `created_at`, `updated_at`) VALUES
(6, 'Prasoon', 'Artisan : Block Print Textiles', 'uploads/spotlight/1762671178_Artisan3.jpg', 'Jaipur, India', '\"Every block I press leaves an imprint of my tradition and pride.\"', '2025-10-13 03:40:03', '2025-11-09 07:12:23'),
(7, 'Sita Devi', 'Artisan : Textile', 'uploads/spotlight/1762671843_Artsan1.jpg', 'Jaipur, India', '\"For decades, I have carried this tradition with care and responsibility.\"', '2025-10-13 03:41:30', '2025-11-09 07:04:03'),
(8, 'Govind', 'Artisan: Leather products', 'uploads/spotlight/1762672461_WhatsApp Image 2025-11-09 at 12.35.06 (2).jpeg', 'Ajmer, India', '\"I craft the leather products that tell the story of my family legacy.\"', '2025-10-13 03:42:31', '2025-11-09 07:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`, `created_at`, `updated_at`, `image`) VALUES
(7, 'Wooden Art & Sculptures', '4', '2025-10-09 03:13:41', '2025-10-09 07:37:01', 'uploads/subcategory/1760015221.webp'),
(8, 'Metal & Brass Art', '4', '2025-10-09 03:14:27', '2025-10-09 07:37:12', 'uploads/subcategory/1760015232.jpg'),
(9, 'Wall Hangings', '4', '2025-10-09 03:15:17', '2025-10-09 07:37:32', 'uploads/subcategory/1760015252.jpeg'),
(10, 'Traditional Artifacts', '4', '2025-10-09 03:16:14', '2025-10-09 07:37:43', 'uploads/subcategory/1760015263.jpg'),
(11, 'Table & Accent Décor', '4', '2025-10-09 03:16:22', '2025-10-09 07:38:26', 'uploads/subcategory/1760015306.jpg'),
(13, 'subcategory2', '5', '2025-10-10 06:33:14', '2025-10-10 06:33:14', 'uploads/subcategory/1760097794jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Amit', 'Wholesale Buyer, Germany', '“We’ve been sourcing from IndiOrigins for months, and every shipment reflects impeccable craftsmanship and professionalism.”', '69103887d46a8.jpg', '2025-10-09 01:45:57', '2025-11-09 07:17:19'),
(2, 'Gordo Novak', 'Gordo Novak', 'There are many variations of long passages available but the content majority have suffered to the editor page when looking at its layout alteration in some injected.', '1759994215.jpg', '2025-10-09 01:46:55', '2025-10-09 01:46:55'),
(3, 'Parker Jimenez', 'Customer', 'There are many variations of long passages available but the content majority have suffered to the editor page when looking at its layout alteration in some injected.', '1759994277.jpg', '2025-10-09 01:47:57', '2025-10-09 01:47:57'),
(4, 'Heruli Nez', 'customer', 'There are many variations of long passages available but the content majority have suffered to the editor page when looking at its layout alteration in some injected.', '1759994329.jpg', '2025-10-09 01:48:49', '2025-10-09 01:48:49');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mail.com', NULL, '$2y$12$WXQcwBRl/9zzyiktGCnZne/FLlnA8dosJ2KKXxBEeRaNEj29QFO4C', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spotlight__artisans`
--
ALTER TABLE `spotlight__artisans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `spotlight__artisans`
--
ALTER TABLE `spotlight__artisans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
