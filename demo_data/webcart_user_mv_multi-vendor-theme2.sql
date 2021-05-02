-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2020 at 10:15 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rm_checking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `position_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `description`, `link`, `photo_id`, `location_id`, `is_active`, `position`, `created_at`, `updated_at`, `category_id`, `brand_id`, `position_brand`, `position_category`, `priority`) VALUES
(1, NULL, NULL, NULL, 175, 1, 1, 'Main Slider', '2019-03-11 06:19:21', '2020-03-04 05:20:15', NULL, NULL, NULL, NULL, 1),
(3, NULL, NULL, NULL, 176, 1, 1, 'Main Slider', '2019-03-11 06:19:41', '2020-03-04 05:20:26', NULL, NULL, NULL, NULL, 1),
(4, NULL, NULL, NULL, 178, 1, 1, 'Main Slider', '2019-03-25 13:07:34', '2020-03-04 05:26:54', NULL, NULL, 'Main Slider', NULL, 1),
(5, NULL, NULL, NULL, 180, 1, 0, 'Main Slider', '2019-03-25 13:07:52', '2020-03-04 05:43:00', 2, NULL, 'Main Slider', 'Main Slider', 1),
(6, NULL, NULL, NULL, 181, 1, 1, 'Below Main Slider', '2019-03-25 13:14:03', '2020-03-04 05:44:38', NULL, NULL, NULL, NULL, 2),
(7, NULL, NULL, NULL, 250, 1, 0, 'Below Main Slider', '2019-03-25 13:14:20', '2020-03-04 07:29:00', NULL, NULL, NULL, NULL, 2),
(8, NULL, NULL, NULL, 15, 1, 0, 'Below Main Slider', '2019-03-25 13:14:29', '2020-03-04 05:43:58', NULL, NULL, NULL, NULL, 2),
(9, NULL, NULL, NULL, 251, 1, 1, 'Below Main Slider - Two Images per row', '2019-03-25 13:14:49', '2020-03-04 07:29:51', NULL, NULL, NULL, NULL, 1),
(10, NULL, NULL, NULL, 252, 1, 1, 'Below Main Slider - Two Images per row', '2019-03-25 13:15:02', '2020-03-04 07:30:20', NULL, NULL, NULL, NULL, 2),
(11, NULL, NULL, NULL, 18, 1, 1, 'Below Main Slider - Three Images Layout', '2019-03-25 13:15:18', '2019-03-25 13:15:18', NULL, NULL, NULL, NULL, 4),
(12, NULL, NULL, NULL, 34, 1, 1, 'Right Side', '2019-03-25 13:35:19', '2019-03-25 13:35:19', NULL, NULL, NULL, NULL, 1),
(13, NULL, NULL, NULL, 35, 1, 1, 'Right Side', '2019-03-25 13:35:41', '2019-03-25 13:35:41', NULL, NULL, NULL, NULL, 2),
(14, NULL, NULL, NULL, 36, 1, 1, 'Right Side', '2019-03-25 13:36:00', '2019-03-25 13:36:00', NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `voucher_id` int(10) UNSIGNED DEFAULT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_slider` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `photo_id`, `slug`, `location_id`, `voucher_id`, `meta_desc`, `meta_keywords`, `meta_title`, `priority`, `show_in_menu`, `show_in_footer`, `show_in_slider`) VALUES
(5, 'Sony', 1, '2019-03-26 08:29:58', '2020-03-04 06:29:43', 244, 'sony', 1, NULL, '', '', '', 1, 1, 1, 1),
(6, 'Samsung', 1, '2019-03-26 08:30:57', '2020-03-04 06:30:00', 245, 'samsung', 1, NULL, '', '', '', 1, 1, 1, 1),
(7, 'Apple', 0, '2019-03-26 08:32:08', '2020-03-04 06:31:07', 42, 'apple', 1, NULL, '', '', '', 1, 1, 1, 1),
(8, 'HP', 1, '2019-03-26 08:34:27', '2020-03-04 06:30:15', 246, 'hp', 1, NULL, '', '', '', 1, 1, 1, 1),
(9, 'Lenovo', 1, '2019-03-26 08:41:52', '2020-03-04 06:30:27', 247, 'lenovo', 1, NULL, '', '', '', 1, 1, 1, 1),
(10, 'Dell', 1, '2019-03-26 08:52:21', '2020-03-04 06:30:33', 248, 'dell', 1, NULL, '', '', '', 1, 1, 0, 1),
(11, 'Oneplus', 1, '2019-03-26 08:58:08', '2020-03-04 06:30:40', 249, 'oneplus', 1, NULL, '', '', '', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `voucher_id` int(10) UNSIGNED DEFAULT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_slider` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `category_id`, `slug`, `location_id`, `voucher_id`, `photo_id`, `meta_desc`, `meta_keywords`, `meta_title`, `priority`, `show_in_menu`, `show_in_footer`, `show_in_slider`) VALUES
(5, 'Laptops', 1, '2019-03-26 06:21:56', '2020-03-04 05:50:57', 0, 'laptops', 1, NULL, 182, '', '', '', 1, 1, 1, 1),
(6, 'Dell', 1, '2019-03-26 06:35:27', '2019-03-26 06:37:50', 5, 'dell', 1, NULL, NULL, '', '', '', 1, 1, 1, 0),
(7, 'HP', 1, '2019-03-26 06:39:02', '2019-03-26 06:43:52', 5, 'hp', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(8, 'Lenovo', 1, '2019-03-26 06:40:12', '2019-03-26 06:42:55', 5, 'lenovo', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(9, 'Apple Macbook', 1, '2019-03-26 06:42:33', '2019-03-26 06:42:33', 5, 'apple-macbook', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(10, 'Inspiron Laptops', 1, '2019-03-26 06:47:11', '2019-03-26 07:47:13', 6, 'inspiron-laptops', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(11, 'Gaming Laptops - G Series', 1, '2019-03-26 06:47:55', '2019-03-26 07:47:21', 6, 'gaming-laptops-g-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(12, 'XPS Laptops', 1, '2019-03-26 06:48:22', '2019-03-26 07:47:26', 6, 'xps-laptops', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(13, 'Alienware Laptops', 1, '2019-03-26 06:48:57', '2019-03-26 07:47:32', 6, 'alienware-laptops', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(14, 'Inspiron 2-in-1 Laptops', 1, '2019-03-26 06:49:25', '2019-03-26 07:47:38', 6, 'inspiron-2-in-1-laptops', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(15, 'Spectre', 1, '2019-03-26 06:53:35', '2019-03-26 07:47:44', 7, 'spectre', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(16, 'HP Omen', 1, '2019-03-26 06:54:44', '2019-03-26 07:47:49', 7, 'hp-omen', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(17, 'Envy', 1, '2019-03-26 06:56:22', '2019-03-26 07:47:54', 7, 'envy-laptops', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(18, 'Pavilion', 1, '2019-03-26 06:57:08', '2019-03-26 07:47:59', 7, 'pavilion', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(19, 'ELITE', 1, '2019-03-26 06:59:31', '2019-03-26 07:48:03', 7, 'elite', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(21, 'ProBook', 1, '2019-03-26 07:01:01', '2019-03-26 07:48:12', 7, 'probook', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(24, 'IDEAPAD', 1, '2019-03-26 07:05:19', '2019-03-26 07:48:29', 8, 'ideapad', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(25, 'YOGA', 1, '2019-03-26 07:05:50', '2019-03-26 07:48:40', 8, 'yoga', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(26, 'Lenovo V Series', 1, '2019-03-26 07:06:26', '2019-03-26 07:48:46', 8, 'lenovo-v-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(27, 'Lenovo Legion Y Series', 1, '2019-03-26 07:08:06', '2019-03-26 07:48:53', 8, 'lenovo-legion-y-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(28, 'MacBook Air', 1, '2019-03-26 07:12:18', '2019-03-26 07:48:59', 9, 'macbook-air', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(29, 'Mac mini', 1, '2019-03-26 07:12:36', '2019-03-26 07:49:04', 9, 'mac-mini', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(30, 'MacBook Pro', 1, '2019-03-26 07:12:56', '2019-03-26 07:49:29', 9, 'macbook-pro', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(34, 'Mobiles', 1, '2019-03-26 07:50:48', '2020-03-04 05:51:30', 0, 'mobiles', 1, NULL, 183, '', '', '', 1, 1, 1, 1),
(35, 'Samsung', 1, '2019-03-26 07:55:03', '2019-03-26 08:02:28', 34, 'samsung', 1, NULL, NULL, '', '', '', 1, 1, 1, 0),
(36, 'Lenovo', 1, '2019-03-26 07:56:03', '2019-03-26 08:02:23', 34, 'lenovo-1', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(37, 'Sony', 1, '2019-03-26 07:58:51', '2019-03-26 08:02:19', 34, 'sony', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(38, 'iphone', 1, '2019-03-26 07:59:30', '2019-03-26 08:02:14', 34, 'iphone', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(39, 'Oneplus', 1, '2019-03-26 08:01:12', '2019-03-26 08:03:02', 34, 'oneplus', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(40, 'Galaxy S', 1, '2019-03-26 08:06:04', '2019-03-26 08:06:04', 35, 'galaxy-s', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(41, 'Galaxy Note', 1, '2019-03-26 08:06:45', '2019-03-26 08:06:45', 35, 'galaxy-note', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(42, 'Galaxy A', 1, '2019-03-26 08:07:14', '2019-03-26 08:07:14', 35, 'galaxy-a', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(43, 'Galaxy M', 1, '2019-03-26 08:07:39', '2019-03-26 08:07:39', 35, 'galaxy-m', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(44, 'Galaxy J', 1, '2019-03-26 08:08:05', '2019-03-26 08:08:05', 35, 'galaxy-j', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(45, 'Galaxy On', 1, '2019-03-26 08:08:46', '2019-03-26 08:08:46', 35, 'galaxy-on', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(46, 'P Series', 1, '2019-03-26 08:10:26', '2019-03-26 08:10:26', 36, 'p-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(47, 'K Series', 1, '2019-03-26 08:10:42', '2019-03-26 08:10:42', 36, 'k-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(48, 'Zuk Series', 1, '2019-03-26 08:10:58', '2019-03-26 08:10:58', 36, 'zuk-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(49, 'A Series', 1, '2019-03-26 08:11:17', '2019-03-26 08:11:17', 36, 'a-series', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(51, 'Xperia XZ2', 1, '2019-03-26 08:15:20', '2019-05-08 12:49:06', 37, 'xperia-x', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(52, 'Xperia L2', 1, '2019-03-26 08:15:54', '2019-05-08 12:49:58', 37, 'xperia-xa', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(53, 'Xperia XA Ultra', 1, '2019-03-26 08:16:28', '2019-03-26 08:16:28', 37, 'xperia-xa-ultra', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(54, 'Xperia XZ', 1, '2019-03-26 08:17:02', '2019-03-26 08:17:02', 37, 'xperia-xz', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(59, 'iPhone XR', 1, '2019-03-26 08:21:49', '2019-05-08 12:51:53', 38, 'iphone-xr', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(60, 'iPhone 8', 1, '2019-03-26 08:22:04', '2019-03-26 08:22:04', 38, 'iphone-8', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(61, 'iPhone 7', 1, '2019-03-26 08:22:26', '2019-03-26 08:22:26', 38, 'iphone-7', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(63, 'OnePlus 5', 1, '2019-03-26 08:25:40', '2019-03-26 08:25:40', 39, 'oneplus-5', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(64, 'OnePlus 5T', 1, '2019-03-26 08:25:56', '2019-03-26 08:25:56', 39, 'oneplus-5t', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(65, 'OnePlus 6', 1, '2019-03-26 08:26:16', '2019-03-26 08:26:16', 39, 'oneplus-6', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(66, 'OnePlus 6T', 1, '2019-03-26 08:26:35', '2019-03-26 08:26:35', 39, 'oneplus-6t', 1, NULL, NULL, '', '', '', 1, 1, 0, 0),
(67, 'Watches', 1, '2019-03-26 10:38:43', '2019-03-26 10:38:43', 0, 'watches', 1, NULL, 71, '', '', '', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_specification_type`
--

CREATE TABLE `category_specification_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `specification_type_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_specification_type`
--

INSERT INTO `category_specification_type` (`id`, `category_id`, `specification_type_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, NULL, NULL),
(2, 6, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comparision_groups`
--

CREATE TABLE `comparision_groups` (
  `cg_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comparision_groups` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comparision_groups`
--

INSERT INTO `comparision_groups` (`cg_id`, `title`, `comparision_groups`, `created_at`, `updated_at`) VALUES
(1, 'Mobile Compares', 'a:4:{i:0;a:2:{s:9:\"comp_type\";s:1:\"1\";s:8:\"photo_id\";i:169;}i:1;a:2:{s:9:\"comp_type\";s:1:\"2\";s:8:\"photo_id\";i:170;}i:2;a:2:{s:9:\"comp_type\";s:1:\"3\";s:8:\"photo_id\";i:174;}i:3;a:2:{s:9:\"comp_type\";s:1:\"4\";s:8:\"photo_id\";i:173;}}', '2020-02-06 18:55:31', '2020-02-06 18:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `name`, `description`, `priority`, `slug`, `is_active`, `created_at`, `updated_at`, `location_id`, `meta_desc`, `meta_keywords`, `meta_title`, `show_in_menu`, `show_in_footer`) VALUES
(1, 'Today\'s Deals', NULL, 1, 'today-s-deal', 1, '2019-03-25 13:11:47', '2019-11-13 01:45:47', 1, '', '', '', 1, 1),
(2, 'Lightening Deals', NULL, 2, 'lightening-deal', 1, '2019-11-13 01:44:58', '2019-11-13 01:49:20', 1, '', '', '', 0, 1),
(3, 'Deals on Laptops', NULL, 1, 'deals-on-laptops', 1, '2019-11-13 01:48:05', '2019-11-13 01:48:05', 1, '', '', '', 0, 1),
(4, 'Deals on Mobiles', NULL, 1, 'deals-on-mobiles', 1, '2019-11-13 01:48:59', '2019-11-13 01:48:59', 1, '', '', '', 0, 1),
(5, 'Fashion Sale', 'Fashion Sale is Here', 1, 'fashion-sale', 1, '2020-03-04 06:41:02', '2020-03-04 06:41:02', 1, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deal_product`
--

CREATE TABLE `deal_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `deal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deal_product`
--

INSERT INTO `deal_product` (`id`, `deal_id`, `product_id`, `created_at`, `updated_at`) VALUES
(6, 1, 14, NULL, NULL),
(7, 1, 15, NULL, NULL),
(8, 1, 16, NULL, NULL),
(9, 1, 17, NULL, NULL),
(10, 1, 18, NULL, NULL),
(11, 2, 8, NULL, NULL),
(12, 2, 9, NULL, NULL),
(13, 2, 10, NULL, NULL),
(14, 2, 11, NULL, NULL),
(15, 2, 12, NULL, NULL),
(16, 2, 13, NULL, NULL),
(17, 2, 14, NULL, NULL),
(18, 3, 15, NULL, NULL),
(19, 3, 16, NULL, NULL),
(20, 3, 20, NULL, NULL),
(21, 3, 29, NULL, NULL),
(22, 3, 30, NULL, NULL),
(23, 3, 31, NULL, NULL),
(24, 4, 32, NULL, NULL),
(25, 4, 33, NULL, NULL),
(26, 4, 34, NULL, NULL),
(27, 4, 35, NULL, NULL),
(28, 4, 36, NULL, NULL),
(29, 4, 37, NULL, NULL),
(30, 4, 38, NULL, NULL),
(31, 4, 39, NULL, NULL),
(32, 4, 40, NULL, NULL),
(33, 4, 41, NULL, NULL),
(34, 5, 56, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `is_active`, `slug`, `created_at`, `updated_at`, `meta_desc`, `meta_keywords`, `meta_title`, `priority`, `show_in_menu`, `show_in_footer`) VALUES
(1, 'About Us', '<!-- Container (About Section) -->\r\n<div id=\"about\" class=\"container-fluid\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-8\">\r\n<h2><strong>About Company Page</strong></h2>\r\n<br />\r\n<p>Being in this domain since 2000, GemsAuctions, is the principal exporter, manufacturer and wholesaler of Gemstone and Jewelry Products. We have received supreme accolade in our business for our array of products which includes Silver Jewelry, Precious Gemstones and Semi Precious Gemstones. We employ leading-edge processing technologies and tried-and-tested methods in order to offer fine quality, design and choices to our customers. Also we offer customization option for those clients who need something special according to their requirements. We shape their thoughts into our exclusive products. We assure timely delivery of bulk orders, easy payment mode without compromising with their quality. Leveraging on all these strengths, we have a huge clientele base and strong market capitalization.</p>\r\n<button class=\"btn btn-default btn-lg\" style=\"border: 1px solid;\">Get in Touch</button></div>\r\n<div class=\"col-sm-4\" style=\"margin-top: 0;\"><img src=\"https://image.freepik.com/free-vector/store-with-credit-card-gift-boxes-buyers-illustration_1262-18980.jpg\" alt=\"company\" width=\"450\" height=\"300\" /></div>\r\n</div>\r\n</div>\r\n<div class=\"container-fluid bg-grey\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4\" style=\"margin-top: 5%;\"><img src=\"https://image.freepik.com/free-vector/credit-card-concept-illustration_114360-170.jpg\" alt=\"values\" width=\"350\" height=\"350\" /></div>\r\n<div class=\"col-sm-8\">\r\n<h2><strong>Our Values</strong></h2>\r\n<br />\r\n<p><strong>VISION:</strong> Step into a world of chic designs and unique treasures hand-selected for your closet; a world where the hottest trends and timeless styles collide to create an unmatched selection of apparel and accessories. Step into very&rsquo;s global Boutique! At very&rsquo;s, our &ldquo;Style Hunters&rdquo; have a passion for fashion and are constantly searching to fill our collection with a limited selection of unique pieces so that when you buy from very&rsquo;s Fashion Boutique, you know your individual style will always stand out from the crowd and shine. We strive to inspire you with ideas to create your own look with signature items from very&rsquo;s global Boutique. very\'s is an online fashion store for taste-makers and trend-breakers all over the country. When it comes to online shopping for women looking for the latest fashion trends, very\'s is the one-stop destination. Started in 2018, this online fashion store comprises of the designer saree, trendiest tops, hottest dresses, skirts, jackets, shoes, bags, accessories and fashion jewellery for women online shopping. Every new season brings fresh and latest fashion for women. And it becomes important for you to keep up with the current trend. However, very\'s has all your styling stress sussed!</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p><br /><br /></p>', 1, 'about', '2020-02-04 20:47:10', '2020-03-04 06:40:13', '', '', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `name`, `created_at`, `updated_at`, `product_id`) VALUES
(11, '15535195532.jpg', '2019-03-25 13:12:33', '2019-03-25 13:12:33', NULL),
(14, '1553519660b2.jpg', '2019-03-25 13:14:20', '2019-03-25 13:14:20', NULL),
(15, '1553519669b3.jpg', '2019-03-25 13:14:29', '2019-03-25 13:14:29', NULL),
(16, '1553519689a1.jpg', '2019-03-25 13:14:49', '2019-03-25 13:14:49', NULL),
(18, '1553519718a3.jpg', '2019-03-25 13:15:18', '2019-03-25 13:15:18', NULL),
(34, '1553520919sb1.jpg', '2019-03-25 13:35:19', '2019-03-25 13:35:19', NULL),
(35, '1553520941sb2.jpg', '2019-03-25 13:35:41', '2019-03-25 13:35:41', NULL),
(36, '1553520960sb3.jpg', '2019-03-25 13:36:00', '2019-03-25 13:36:00', NULL),
(38, '1553581316laptop_category.jpg', '2019-03-26 06:21:56', '2019-03-26 06:21:56', NULL),
(40, '1553588998sony.jpg', '2019-03-26 08:29:58', '2019-03-26 08:29:58', NULL),
(41, '1553589057samsung.jpg', '2019-03-26 08:30:57', '2019-03-26 08:30:57', NULL),
(42, '1553589127apple.jpg', '2019-03-26 08:32:07', '2019-03-26 08:32:07', NULL),
(46, '1553590341dell1.jpg', '2019-03-26 08:52:21', '2019-03-26 08:52:21', NULL),
(49, '1553592693dell_ins1.jpg', '2019-03-26 09:31:33', '2019-03-26 09:31:33', NULL),
(50, 'alt_img_1553592693dell_ins2.jpg', '2019-03-26 09:31:33', '2019-03-26 09:31:33', 9),
(51, 'alt_img_1553593237dellins4.jpg', '2019-03-26 09:40:37', '2019-03-26 09:40:37', 8),
(52, '1553593271dellins3.jpg', '2019-03-26 09:41:11', '2019-03-26 09:41:11', NULL),
(53, '1553593759dellins5.png', '2019-03-26 09:49:19', '2019-03-26 09:49:19', NULL),
(54, 'alt_img_1553593759dellins6.png', '2019-03-26 09:49:19', '2019-03-26 09:49:19', 10),
(55, '1553594388dell-ins7.jpeg', '2019-03-26 09:59:48', '2019-03-26 09:59:48', NULL),
(56, 'alt_img_1553594388dell-ins8.jpeg', '2019-03-26 09:59:48', '2019-03-26 09:59:48', 11),
(57, '1553594612dell-na-gaming-laptop1.jpeg', '2019-03-26 10:03:32', '2019-03-26 10:03:32', NULL),
(58, 'alt_img_1553594612dell-na-gaming-laptop2.jpeg', '2019-03-26 10:03:32', '2019-03-26 10:03:32', 12),
(59, '1553594869dell-na-thin1.jpeg', '2019-03-26 10:07:49', '2019-03-26 10:07:49', NULL),
(60, 'alt_img_1553594869dell-na-thin2.jpeg', '2019-03-26 10:07:49', '2019-03-26 10:07:49', 13),
(61, '1553595098dell-na-thin-3.jpeg', '2019-03-26 10:11:38', '2019-03-26 10:11:38', NULL),
(62, 'alt_img_1553595098dell-na-thin-4.jpeg', '2019-03-26 10:11:38', '2019-03-26 10:11:38', 14),
(63, '1553595369alienware-na-gaming5.jpeg', '2019-03-26 10:16:09', '2019-03-26 10:16:09', NULL),
(64, 'alt_img_1553595369alienware-na-gaming6.jpeg', '2019-03-26 10:16:09', '2019-03-26 10:16:09', 15),
(65, '1553595747alienware-na-gaming4.jpeg', '2019-03-26 10:22:27', '2019-03-26 10:22:27', NULL),
(66, 'alt_img_1553595747alienware-na-gaming7.jpeg', '2019-03-26 10:22:27', '2019-03-26 10:22:27', 16),
(67, '1553596085dell-new-inspiron-15.jpeg', '2019-03-26 10:28:05', '2019-03-26 10:28:05', NULL),
(68, 'alt_img_1553596085dell-new-inspiron-15-1.jpeg', '2019-03-26 10:28:05', '2019-03-26 10:28:05', 17),
(69, '1553596318dell-inspiron-15-2.jpeg', '2019-03-26 10:31:58', '2019-03-26 10:31:58', NULL),
(70, 'alt_img_1553596319dell-inspiron-15-3.jpeg', '2019-03-26 10:31:59', '2019-03-26 10:31:59', 18),
(71, '1553596723watches.jpg', '2019-03-26 10:38:43', '2019-03-26 10:38:43', NULL),
(72, '1553598225hp-na-gaming-8.jpeg', '2019-03-26 11:03:45', '2019-03-26 11:03:45', NULL),
(73, 'alt_img_1553598225hp-na-gaming-9.jpeg', '2019-03-26 11:03:45', '2019-03-26 11:03:45', 19),
(74, '1553598553hp-na1.jpeg', '2019-03-26 11:09:13', '2019-03-26 11:09:13', NULL),
(75, 'alt_img_1553598553hp-na2.jpeg', '2019-03-26 11:09:13', '2019-03-26 11:09:13', 20),
(76, '1553598901hp-envy1.jpeg', '2019-03-26 11:15:01', '2019-03-26 11:15:01', NULL),
(77, 'alt_img_1553598901hp-envy2.jpeg', '2019-03-26 11:15:01', '2019-03-26 11:15:01', 21),
(78, '1553599116hp-pav1.jpeg', '2019-03-26 11:18:36', '2019-03-26 11:18:36', NULL),
(79, 'alt_img_1553599116hp-pav2.jpeg', '2019-03-26 11:18:36', '2019-03-26 11:18:36', 22),
(81, 'alt_img_1553599389hp-elite-2-1.jpeg', '2019-03-26 11:23:09', '2019-03-26 11:23:09', 23),
(82, '1553599809hp-probook-1.jpeg', '2019-03-26 11:30:09', '2019-03-26 11:30:09', NULL),
(83, 'alt_img_1553599810hp-probook-3.jpeg', '2019-03-26 11:30:10', '2019-03-26 11:30:10', 24),
(84, '1553600045lenovo-1.jpeg', '2019-03-26 11:34:05', '2019-03-26 11:34:05', NULL),
(85, 'alt_img_1553600045lenovo-2.jpeg', '2019-03-26 11:34:05', '2019-03-26 11:34:05', 25),
(86, '1553600380lenovo-na1.jpeg', '2019-03-26 11:39:40', '2019-03-26 11:39:40', NULL),
(87, 'alt_img_1553600380lenovo-na2.jpeg', '2019-03-26 11:39:40', '2019-03-26 11:39:40', 26),
(88, '1553600804testi1.jpg', '2019-03-26 11:46:44', '2019-03-26 11:46:44', NULL),
(89, '1553600888test2.jpg', '2019-03-26 11:48:08', '2019-03-26 11:48:08', NULL),
(90, 'alt_img_1557309047hp-probook-3.jpeg', '2019-05-08 09:50:47', '2019-05-08 09:50:47', 24),
(91, '1557309054hp-probook-1.jpeg', '2019-05-08 09:50:54', '2019-05-08 09:50:54', NULL),
(92, '1557309122hp-pav1.jpeg', '2019-05-08 09:52:02', '2019-05-08 09:52:02', NULL),
(93, 'alt_img_1557309191hp-envy2.jpeg', '2019-05-08 09:53:11', '2019-05-08 09:53:11', 21),
(94, '1557309194hp-envy1.jpeg', '2019-05-08 09:53:14', '2019-05-08 09:53:14', NULL),
(95, 'alt_img_1557309294dell-inspiron-15-3.jpeg', '2019-05-08 09:54:54', '2019-05-08 09:54:54', 18),
(96, '1557309295dell-inspiron-15-2.jpeg', '2019-05-08 09:54:55', '2019-05-08 09:54:55', NULL),
(97, '1557309328dell-new-inspiron-15.jpeg', '2019-05-08 09:55:29', '2019-05-08 09:55:29', NULL),
(98, 'alt_img_1557309380dell-na-thin2.jpeg', '2019-05-08 09:56:20', '2019-05-08 09:56:20', 13),
(99, '1557309383dell-na-thin1.jpeg', '2019-05-08 09:56:23', '2019-05-08 09:56:23', NULL),
(100, 'alt_img_1557309434dell_ins2.jpg', '2019-05-08 09:57:14', '2019-05-08 09:57:14', 9),
(101, '1557309436dell_ins1.jpg', '2019-05-08 09:57:16', '2019-05-08 09:57:16', NULL),
(102, '1557310581lenovo-v110.jpeg', '2019-05-08 10:16:21', '2019-05-08 10:16:21', NULL),
(103, 'alt_img_1557310581lenovo-v110-1.jpeg', '2019-05-08 10:16:21', '2019-05-08 10:16:21', 27),
(104, '1557310911lenovo-y.jpeg', '2019-05-08 10:21:51', '2019-05-08 10:21:51', NULL),
(105, 'alt_img_1557310911lenovo-y1.jpeg', '2019-05-08 10:21:51', '2019-05-08 10:21:51', 28),
(106, '1557311303apple-air1.jpeg', '2019-05-08 10:28:23', '2019-05-08 10:28:23', NULL),
(107, 'alt_img_1557311303apple-air2.jpeg', '2019-05-08 10:28:23', '2019-05-08 10:28:23', 29),
(109, '1557312382apple-air-pro.jpeg', '2019-05-08 10:46:22', '2019-05-08 10:46:22', NULL),
(110, 'alt_img_1557312382apple-air-pro1.jpeg', '2019-05-08 10:46:22', '2019-05-08 10:46:22', 31),
(169, '1581333611weight_407329.png', '2020-02-10 05:50:11', '2020-02-10 05:50:11', NULL),
(170, '1581333612839730-200.png', '2020-02-10 05:50:12', '2020-02-10 05:50:12', NULL),
(171, '1581408976hardware_ram-memory-hardware-512.png', '2020-02-11 02:46:16', '2020-02-11 02:46:16', NULL),
(172, '1581409176hardware_ram-memory-hardware-512.png', '2020-02-11 02:49:36', '2020-02-11 02:49:36', NULL),
(173, '1581409190396-01-512.png', '2020-02-11 02:49:50', '2020-02-11 02:49:50', NULL),
(174, '1581409257Ram-512.png', '2020-02-11 02:50:57', '2020-02-11 02:50:57', NULL),
(175, '158329921501.jpg', '2020-03-04 05:20:15', '2020-03-04 05:20:15', NULL),
(176, '158329922602.jpg', '2020-03-04 05:20:26', '2020-03-04 05:20:26', NULL),
(178, '158329961402.jpg', '2020-03-04 05:26:54', '2020-03-04 05:26:54', NULL),
(180, '158330058002.jpg', '2020-03-04 05:43:00', '2020-03-04 05:43:00', NULL),
(181, '1583300678home-banner.jpg', '2020-03-04 05:44:38', '2020-03-04 05:44:38', NULL),
(182, '1583301057banner-side.png', '2020-03-04 05:50:57', '2020-03-04 05:50:57', NULL),
(183, '1583301090top-menu-banner.jpg', '2020-03-04 05:51:30', '2020-03-04 05:51:30', NULL),
(184, 'alt_img_1583301533p7.jpg', '2020-03-04 05:58:53', '2020-03-04 05:58:53', 56),
(185, 'alt_img_1583301553p13.jpg', '2020-03-04 05:59:13', '2020-03-04 05:59:13', 56),
(186, '1583301558p7.jpg', '2020-03-04 05:59:18', '2020-03-04 05:59:18', NULL),
(187, 'alt_img_1583301614p6.jpg', '2020-03-04 06:00:15', '2020-03-04 06:00:15', 55),
(188, 'alt_img_1583301615p5.jpg', '2020-03-04 06:00:15', '2020-03-04 06:00:15', 55),
(189, '1583301616p6.jpg', '2020-03-04 06:00:17', '2020-03-04 06:00:17', NULL),
(190, 'alt_img_1583301663p8.jpg', '2020-03-04 06:01:03', '2020-03-04 06:01:03', 54),
(191, 'alt_img_1583301673p9.jpg', '2020-03-04 06:01:13', '2020-03-04 06:01:13', 54),
(192, '1583301675p8.jpg', '2020-03-04 06:01:15', '2020-03-04 06:01:15', NULL),
(193, 'alt_img_1583301697p12.jpg', '2020-03-04 06:01:37', '2020-03-04 06:01:37', 53),
(194, 'alt_img_1583301714p27.jpg', '2020-03-04 06:01:54', '2020-03-04 06:01:54', 53),
(195, '1583301715p12.jpg', '2020-03-04 06:01:55', '2020-03-04 06:01:55', NULL),
(196, 'alt_img_1583301738p24.jpg', '2020-03-04 06:02:18', '2020-03-04 06:02:18', 52),
(197, 'alt_img_1583301738p18.jpg', '2020-03-04 06:02:18', '2020-03-04 06:02:18', 52),
(198, '1583301742p18.jpg', '2020-03-04 06:02:22', '2020-03-04 06:02:22', NULL),
(199, 'alt_img_1583301808p15.jpg', '2020-03-04 06:03:28', '2020-03-04 06:03:28', 51),
(200, 'alt_img_1583301808p16.jpg', '2020-03-04 06:03:28', '2020-03-04 06:03:28', 51),
(201, '1583301809p16.jpg', '2020-03-04 06:03:29', '2020-03-04 06:03:29', NULL),
(202, 'alt_img_1583301840p29.jpg', '2020-03-04 06:04:00', '2020-03-04 06:04:00', 50),
(203, 'alt_img_1583301840p30.jpg', '2020-03-04 06:04:00', '2020-03-04 06:04:00', 50),
(204, '1583301842p29.jpg', '2020-03-04 06:04:02', '2020-03-04 06:04:02', NULL),
(205, 'alt_img_1583301873p4.jpg', '2020-03-04 06:04:33', '2020-03-04 06:04:33', 49),
(206, 'alt_img_1583301873p14.jpg', '2020-03-04 06:04:33', '2020-03-04 06:04:33', 49),
(207, '1583301875p14.jpg', '2020-03-04 06:04:35', '2020-03-04 06:04:35', NULL),
(208, 'alt_img_1583301960p4.jpg', '2020-03-04 06:06:00', '2020-03-04 06:06:00', 48),
(209, 'alt_img_1583301960p21.jpg', '2020-03-04 06:06:00', '2020-03-04 06:06:00', 48),
(210, '1583301961p4.jpg', '2020-03-04 06:06:01', '2020-03-04 06:06:01', NULL),
(211, 'alt_img_1583301989p28.jpg', '2020-03-04 06:06:29', '2020-03-04 06:06:29', 47),
(212, 'alt_img_1583301989p23.jpg', '2020-03-04 06:06:29', '2020-03-04 06:06:29', 47),
(213, '1583301992p28.jpg', '2020-03-04 06:06:32', '2020-03-04 06:06:32', NULL),
(214, 'alt_img_1583302042p10.jpg', '2020-03-04 06:07:22', '2020-03-04 06:07:22', 46),
(215, 'alt_img_1583302042p11.jpg', '2020-03-04 06:07:22', '2020-03-04 06:07:22', 46),
(216, '1583302044p10.jpg', '2020-03-04 06:07:24', '2020-03-04 06:07:24', NULL),
(217, 'alt_img_1583302080p9.jpg', '2020-03-04 06:08:00', '2020-03-04 06:08:00', 45),
(218, 'alt_img_1583302081p22.jpg', '2020-03-04 06:08:01', '2020-03-04 06:08:01', 45),
(219, '1583302083p9.jpg', '2020-03-04 06:08:03', '2020-03-04 06:08:03', NULL),
(220, 'alt_img_1583302157p20.jpg', '2020-03-04 06:09:17', '2020-03-04 06:09:17', 44),
(221, 'alt_img_1583302157p3.jpg', '2020-03-04 06:09:17', '2020-03-04 06:09:17', 44),
(222, '1583302161p20.jpg', '2020-03-04 06:09:21', '2020-03-04 06:09:21', NULL),
(223, 'alt_img_1583302186p26.jpg', '2020-03-04 06:09:46', '2020-03-04 06:09:46', 43),
(224, 'alt_img_1583302187p2.jpg', '2020-03-04 06:09:47', '2020-03-04 06:09:47', 43),
(225, '1583302187p2.jpg', '2020-03-04 06:09:47', '2020-03-04 06:09:47', NULL),
(226, 'alt_img_1583302244p1.jpg', '2020-03-04 06:10:44', '2020-03-04 06:10:44', 42),
(227, 'alt_img_1583302244p22.jpg', '2020-03-04 06:10:44', '2020-03-04 06:10:44', 42),
(228, '1583302246p22.jpg', '2020-03-04 06:10:46', '2020-03-04 06:10:46', NULL),
(229, 'alt_img_1583302343p24.jpg', '2020-03-04 06:12:23', '2020-03-04 06:12:23', 41),
(230, 'alt_img_1583302343p25.jpg', '2020-03-04 06:12:23', '2020-03-04 06:12:23', 41),
(231, '1583302344p24.jpg', '2020-03-04 06:12:24', '2020-03-04 06:12:24', NULL),
(232, 'alt_img_1583302368p17.jpg', '2020-03-04 06:12:48', '2020-03-04 06:12:48', 39),
(233, 'alt_img_1583302368p30.jpg', '2020-03-04 06:12:48', '2020-03-04 06:12:48', 39),
(234, '1583302369p17.jpg', '2020-03-04 06:12:49', '2020-03-04 06:12:49', NULL),
(235, 'alt_img_1583302387p9.jpg', '2020-03-04 06:13:07', '2020-03-04 06:13:07', 40),
(236, 'alt_img_1583302387p19.jpg', '2020-03-04 06:13:07', '2020-03-04 06:13:07', 40),
(237, '1583302390p19.jpg', '2020-03-04 06:13:10', '2020-03-04 06:13:10', NULL),
(238, 'alt_img_1583302457p15.jpg', '2020-03-04 06:14:17', '2020-03-04 06:14:17', 38),
(239, 'alt_img_1583302458p20.jpg', '2020-03-04 06:14:18', '2020-03-04 06:14:18', 38),
(240, '1583302459p15.jpg', '2020-03-04 06:14:19', '2020-03-04 06:14:19', NULL),
(241, 'alt_img_1583302483p11.jpg', '2020-03-04 06:14:43', '2020-03-04 06:14:43', 37),
(242, 'alt_img_1583302484p21.jpg', '2020-03-04 06:14:44', '2020-03-04 06:14:44', 37),
(243, '1583302485p11.jpg', '2020-03-04 06:14:45', '2020-03-04 06:14:45', NULL),
(244, '1583303383brand1.png', '2020-03-04 06:29:43', '2020-03-04 06:29:43', NULL),
(245, '1583303400brand2.png', '2020-03-04 06:30:00', '2020-03-04 06:30:00', NULL),
(246, '1583303415brand3.png', '2020-03-04 06:30:15', '2020-03-04 06:30:15', NULL),
(247, '1583303427brand4.png', '2020-03-04 06:30:27', '2020-03-04 06:30:27', NULL),
(248, '1583303433brand5.png', '2020-03-04 06:30:33', '2020-03-04 06:30:33', NULL),
(249, '1583303440brand6.png', '2020-03-04 06:30:40', '2020-03-04 06:30:40', NULL),
(250, '1583306940cat-banner-1.jpg', '2020-03-04 07:29:00', '2020-03-04 07:29:00', NULL),
(251, '1583306991home-banner1.jpg', '2020-03-04 07:29:51', '2020-03-04 07:29:51', NULL),
(252, '1583307020home-banner2.jpg', '2020-03-04 07:30:20', '2020-03-04 07:30:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` int(11) NOT NULL,
  `price` decimal(12,2) UNSIGNED NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_rate` decimal(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `sales` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `qty_per_order` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_id` int(10) UNSIGNED DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `virtual` tinyint(1) NOT NULL DEFAULT 0,
  `downloadable` tinyint(1) NOT NULL DEFAULT 0,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_price` decimal(12,2) UNSIGNED DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hsn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` int(10) UNSIGNED DEFAULT NULL,
  `variants` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comp_group_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `category_id`, `brand_id`, `name`, `description`, `in_stock`, `price`, `model`, `tax_rate`, `barcode`, `is_active`, `created_at`, `updated_at`, `photo_id`, `sales`, `qty_per_order`, `location_id`, `slug`, `voucher_id`, `file_id`, `virtual`, `downloadable`, `meta_desc`, `meta_keywords`, `meta_title`, `old_price`, `sku`, `hsn`, `custom_fields`, `vendor_id`, `variants`, `comp_group_id`) VALUES
(8, 3, 10, 10, 'Dell Inspiron 15 Core i3 7th gen', '<ul class=\"a-unordered-list a-vertical a-spacing-none\">\r\n<li><span class=\"a-list-item\">Intel Core i3 processor</span></li>\r\n<li><span class=\"a-list-item\">Windows 10 Operating System</span></li>\r\n<li><span class=\"a-list-item\">4GB RAM</span></li>\r\n<li><span class=\"a-list-item\">1TB HDD</span></li>\r\n</ul>', 298, '678.00', 'Inspiron 3567', '0.00', '1553581739', 1, '2019-03-26 06:28:59', '2020-05-25 02:22:58', 52, 3, 2, 1, 'test-product-1', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000002', '1-002', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(9, 3, 10, 10, 'Dell Inspiron 5370 Intel', '<ul class=\"a-unordered-list a-vertical a-spacing-none\">\r\n<li><span class=\"a-list-item\">Processor: Intel Core i5-8250U processor, 3.4 GHz base processor speed, 6MB cache</span></li>\r\n<li><span class=\"a-list-item\">Operating system: Pre-loaded Windows 10 with lifetime validity</span></li>\r\n<li><span class=\"a-list-item\">Display: 13.3-inch FHD (1920 x 1080) LED display | Anti-glare LED-backlit display</span></li>\r\n<li><span class=\"a-list-item\">Memory &amp; Storage: 8GB DDR RAM with Intel UHD 620 Graphics | Storage: 256GB SSD</span></li>\r\n<li><span class=\"a-list-item\">Design &amp; battery: Thin and light design | Laptop weight: 1.50kg | Lithium battery</span></li>\r\n<li><span class=\"a-list-item\">Warranty: This genuine Dell laptop comes with 1 year onsite domestic warranty from Dell covering Hardware Issues and not covering physical damage. For more details, see Warranty section below.</span></li>\r\n<li><span class=\"a-list-item\">Pre-installed Software: MS Office Home &amp; Student 2016 |In the Box: Laptop with included battery and charger</span></li>\r\n</ul>', 3000, '687.00', 'Inspiron 5370', '0.00', '1553592693', 1, '2019-03-26 09:31:33', '2019-05-08 09:57:16', 101, 0, 5, 1, 'dell-inspiron-5370-intel', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000001', '1-001', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(10, 3, 10, 10, 'Dell Inspiron 7570 15.6-inch', '<ul class=\"a-unordered-list a-vertical a-spacing-none\">\r\n<li><span class=\"a-list-item\">GHz Intel Core i5 - 8250 U processor</span></li>\r\n<li><span class=\"a-list-item\">8GB DDR4 RAM</span></li>\r\n<li><span class=\"a-list-item\">1TB hard drive</span></li>\r\n<li><span class=\"a-list-item\">15.6-inch screen, NVidia Geforce 940MX 4GB Graphics</span></li>\r\n<li><span class=\"a-list-item\">Windows 10 Home operating system</span></li>\r\n<li><span class=\"a-list-item\">2.1kg laptop</span></li>\r\n</ul>', 299, '654.00', 'Inspiron 7570', '0.00', '1553593759', 1, '2019-03-26 09:49:19', '2019-03-26 11:49:36', 53, 1, 2, 1, 'dell-inspiron-7570-15-6-inch', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000003', '1-003', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(11, 3, 11, 10, 'Dell G3 Series Core i5 8th Gen', '<ul class=\"a-unordered-list a-vertical a-spacing-none\">\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1050 for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit Anti-glare IPS Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n</ul>', 300, '567.00', 'G3 3579', '0.00', '1553594388', 1, '2019-03-26 09:59:48', '2019-03-26 09:59:48', 55, 0, 2, 1, 'dell-g3-series-core-i5-8th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000004', '1-004', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(12, 3, 11, 10, 'Dell G7 15 7000 Series Core i9 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1060 for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit Anti-glare IPS Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n</ul>', 200, '678.00', 'G7-7588', '0.00', '1553594612', 1, '2019-03-26 10:03:32', '2019-03-26 10:03:32', 57, 0, 2, 1, 'dell-g7-15-7000-series-core-i9-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000005', '1-005', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(13, 3, 12, 10, 'Dell XPS 13 Core i5 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Stylish &amp; Portable Thin and Light Laptop</li>\r\n<li class=\"_2-riNZ\">13 inch Full HD LED Backlit Infinity Edge Anti-glare Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 300, '567.00', '9370', '0.00', '1553594869', 1, '2019-03-26 10:07:49', '2020-02-11 02:38:38', 99, 0, 2, 1, 'dell-xps-13-core-i5-8th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000006', '1-006', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', 1),
(14, 3, 12, 10, 'Dell XPS 13 Core i7 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Stylish &amp; Portable Thin and Light Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch Full HD LED Backlit InfinityEdge Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 277, '654.00', '9370', '0.00', '1553595098', 1, '2019-03-26 10:11:38', '2020-01-20 06:43:20', 61, 23, 2, 1, 'dell-xps-13-core-i7-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000007', '1-007', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(15, 3, 13, 10, 'Alienware Core i7 7th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1070 for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">17.3 inch Full HD LED Backlit IPS Anti-glare 300-nits Display (Enabled with Tobii Eye-tracking)</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n</ul>', 294, '567.00', '17', '0.00', '1553595369', 1, '2019-03-26 10:16:09', '2020-05-25 02:22:58', 63, 6, 2, 1, 'alienware-core-i7-7th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000008', '1-008', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(16, 3, 13, 10, 'Alienware 15 Core i9 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1080 for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit IPS Anti-glare Display with NVIDIA G-sync Enabled</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n</ul>', 193, '687.00', 'AW159321TB8S', '0.00', '1553595747', 1, '2019-03-26 10:22:27', '2020-02-11 02:38:03', 65, 7, 4, 1, 'alienware-15-core-i9-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000009', '1-009', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', 1),
(17, 3, 14, 10, 'Dell Inspiron 15 3000 Core i3 7th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n<li class=\"_2-riNZ\">15.6 inch</li>\r\n</ul>', 288, '678.00', '15 3576', '0.00', '1553596085', 1, '2019-03-26 10:28:05', '2020-02-10 22:43:02', 97, 12, 2, 1, 'dell-inspiron-15-3000-core-i3-7th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000010', '1-010', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', 1),
(18, 3, 14, 10, 'Dell Inspiron Core i5 7th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n<li class=\"_2-riNZ\">Preloaded MS Office Home and Student 2016</li>\r\n<li class=\"_2-riNZ\">15.6 inch HD LED Backlit Truelife Display</li>\r\n</ul>', 176, '564.00', '5567', '0.00', '1553596318', 1, '2019-03-26 10:31:59', '2020-01-21 02:48:03', 96, 24, 2, 1, 'dell-inspiron-core-i5-7th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000011', '1-011', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(19, 3, 16, 8, 'HP Omen Core i7 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit Anti-glare Display (with 144 Hz Refresh Rate)</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n</ul>', 200, '678.00', '15-dc1006TX', '0.00', '1553598225', 1, '2019-03-26 11:03:45', '2019-03-26 11:03:45', 72, 0, 2, 1, 'hp-omen-core-i7-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000013', '1-013', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(20, 3, 15, NULL, 'HP Spectre x360 Core i7 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Carry It Along 2 in 1 Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch Full HD LED Backlit Widescreen Multitouch-enabled Flush Glass Anti-glare Display (Direct Bonding Touch with Corning Gorilla Glass NBT, HP SureView Integrated Privacy Screen, 72% Colour Gamut, Active Stylus Writing Support)</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 197, '786.00', '13-ae503TU', '0.00', '1553598553', 1, '2019-03-26 11:09:13', '2019-03-26 11:53:29', 74, 3, 2, 1, 'hp-spectre-x360-core-i7-8th-gen', NULL, NULL, 0, 0, '', '', '', '800.00', '1-000012', '1-012', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(21, 3, 17, 8, 'HP Envy 13 Core i3 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">tylish &amp; Portable Thin and Light Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch Full HD LED Backlit IPS Scratch Resistant Anti-glare Display</li>\r\n<li class=\"_2-riNZ\">Finger Print Sensor for Faster System Access</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 200, '786.00', '13-ah0042tu', '0.00', '1553598901', 1, '2019-03-26 11:15:01', '2019-05-08 09:53:14', 94, 0, 2, 1, 'hp-envy-13-core-i3-8th-gen', NULL, NULL, 0, 0, '', '', '', '800.00', '1-000014', '1-014', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(22, 3, 18, 8, 'HP Pavilion Core i7 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1050Ti for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit Widescreen Anti-glare IPS Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n</ul>', 199, '567.00', '15-cx0144TX', '0.00', '1553599116', 1, '2019-03-26 11:18:36', '2019-05-08 09:52:02', 92, 1, 2, 1, 'hp-pavilion-core-i7-8th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000015', '1-015', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(24, 3, 21, 8, 'HP Probook Core i5 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">14 inch</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 200, '786.00', 'Probook 440G5', '0.00', '1553599809', 1, '2019-03-26 11:30:09', '2019-05-08 09:50:54', 91, 0, 2, 1, 'hp-probook-core-i5-8th-gen', NULL, NULL, 0, 0, '', '', '', '800.00', '1-0000017', '1-017', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(25, 3, 24, 9, 'Lenovo Ideapad 330 Core i5 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce MX150 for High Graphics Performance</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">15.6 inch HD LED Backlit Anti-glare TN Display</li>\r\n</ul>', 199, '675.00', '330-15IKB', '0.00', '1553600045', 1, '2019-03-26 11:34:05', '2019-03-26 11:54:32', 84, 1, 2, 1, 'lenovo-ideapad-330-core-i5-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000018', '1-018', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(26, 3, 25, 9, 'Lenovo Yoga 730 Core i7 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Carry It Along 2 in 1 Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch Full HD LED Backlit IPS Touch Display</li>\r\n<li class=\"_2-riNZ\">Finger Print Sensor for Faster System Access</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 200, '756.00', '730-13IKB', '0.00', '1553600380', 1, '2019-03-26 11:39:40', '2019-03-26 11:43:52', 86, 0, 2, 1, 'lenovo-yoga-730-core-i7-8th-gen', NULL, NULL, 0, 0, '', '', '', '800.00', '1-000019', '1-019', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(27, 3, 26, 9, 'Lenovo V series Core i3 6th Gen', '<ul>\r\n<li class=\"_3YhLQA\">Laptop, Charger Cable</li>\r\n<li class=\"_3YhLQA\">15.6\"HD AntiGlare 1366x768</li>\r\n<li class=\"_3YhLQA\">Intel Integrated HD</li>\r\n<li class=\"_3YhLQA\">Windows 8, Windows 10 and Above</li>\r\n<li class=\"_3YhLQA\">1XUSB 2.0/ 1XUSB 3.0</li>\r\n<li class=\"_3YhLQA\">15.6\"HD AntiGlare 1366x768</li>\r\n</ul>', 200, '450.00', 'v110', '0.00', '1557310581', 1, '2019-05-08 10:16:21', '2019-05-08 10:22:16', 102, 0, 2, 1, 'lenovo-v-series-core-i3-6th-gen', NULL, NULL, 0, 0, '', '', '', '500.00', '1-000020', '1-020', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(28, 3, 27, 9, 'Lenovo Legion Core i7 7th Gen', '<ul>\r\n<li class=\"_2-riNZ\">NVIDIA Geforce GTX 1050Ti for Desktop Level Performance</li>\r\n<li class=\"_2-riNZ\">15.6 inch Full HD LED Backlit Anti-glare IPS Slim Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n<li class=\"_2-riNZ\">Pre-installed Genuine Windows 10 OS</li>\r\n</ul>', 200, '568.00', 'Y520', '0.00', '1557310911', 1, '2019-05-08 10:21:51', '2019-05-08 10:21:51', 104, 0, 2, 1, 'lenovo-legion-core-i7-7th-gen', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000021', '1-021', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(29, 3, 28, 7, 'Apple MacBook Air Core i5 8th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Stylish &amp; Portable Thin and Light Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch Quad HD LED Backlit IPS Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 98, '698.00', 'MREF2HN/A', '0.00', '1557311303', 1, '2019-05-08 10:28:23', '2020-01-21 02:50:14', 106, 2, 2, 1, 'apple-macbook-air-core-i5-8th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000022', '1-022', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(31, 3, 30, 7, 'Apple MacBook Pro Core i5 7th Gen', '<ul>\r\n<li class=\"_2-riNZ\">Stylish &amp; Portable Thin and Light Laptop</li>\r\n<li class=\"_2-riNZ\">13.3 inch WQHD LED Backlit IPS Display</li>\r\n<li class=\"_2-riNZ\">Light Laptop without Optical Disk Drive</li>\r\n</ul>', 140, '678.00', 'MPXQ2HN/A', '0.00', '1557312382', 1, '2019-05-08 10:46:22', '2019-05-08 10:46:22', 109, 0, 1, 1, 'apple-macbook-pro-core-i5-7th-gen', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000024', '1-024', 'a:1:{s:0:\"\";N;}', 1, NULL, NULL),
(37, 3, 42, 6, 'Samsung Galaxy A30', '<ul>\r\n<li class=\"_2-riNZ\">4 GB RAM | 64 GB ROM | Expandable Upto 512 GB</li>\r\n<li class=\"_2-riNZ\">16.26 cm (6.4 inch) FHD+ Display</li>\r\n<li class=\"_2-riNZ\">16MP + 5MP | 16MP Front Camera</li>\r\n<li class=\"_2-riNZ\">4000 mAh Lithium-ion Battery</li>\r\n<li class=\"_2-riNZ\">Exynos 7904 Processor</li>\r\n<li class=\"_2-riNZ\">Super AMOLED Display</li>\r\n</ul>', 120, '580.00', 'SM-A305FZBFINS', '0.00', '1557315381', 1, '2019-05-08 11:36:21', '2020-03-04 06:14:45', 243, 0, 1, 1, 'samsung-galaxy-a30', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000030', '1-030', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(38, 3, 43, 6, 'Samsung Galaxy M30', '<ul>\r\n<li class=\"_2-riNZ\">6 GB RAM | 128 GB ROM |</li>\r\n<li class=\"_2-riNZ\">16.26 cm (6.4 inches) Display</li>\r\n<li class=\"_2-riNZ\">16MP Rear Camera</li>\r\n<li class=\"_2-riNZ\">5000 mAh Battery</li>\r\n</ul>', 100, '690.00', 'SM-M305FZKGINS', '0.00', '1557315647', 1, '2019-05-08 11:40:47', '2020-03-04 06:14:19', 240, 0, 1, 1, 'samsung-galaxy-m30', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000031', '1-031', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(39, 3, 43, 6, 'Samsung Galaxy M20', '<ul>\r\n<li class=\"_2-riNZ\">4 GB RAM | 64 GB ROM |</li>\r\n<li class=\"_2-riNZ\">16.0 cm (6.3 inch) Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera</li>\r\n<li class=\"_2-riNZ\">5000 mAh Battery</li>\r\n</ul>', 120, '490.00', 'M20', '0.00', '1557315979', 1, '2019-05-08 11:46:19', '2020-03-04 06:12:49', 234, 0, 1, 1, 'samsung-galaxy-m20', NULL, NULL, 0, 0, '', '', '', '500.00', '1-000032', '1-032', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(40, 3, 44, 6, 'Samsung Galaxy J8', '<ul>\r\n<li class=\"_2-riNZ\">4 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">15.24 cm (6 inch) HD+ Display</li>\r\n<li class=\"_2-riNZ\">16MP + 5MP | 16MP Front Camera</li>\r\n<li class=\"_2-riNZ\">3500 mAh Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon SDM450 Processor</li>\r\n</ul>', 200, '470.00', 'SM-J810GZKGINS', '0.00', '1557316236', 1, '2019-05-08 11:50:36', '2020-03-04 06:13:10', 237, 0, 2, 1, 'samsung-galaxy-j8', NULL, NULL, 0, 0, '', '', '', '500.00', '1-000033', '1-033', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(41, 3, 44, 6, 'Samsung Galaxy J7 Prime', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 16 GB ROM | Expandable Up to 256 GB</li>\r\n<li class=\"_2-riNZ\">13.97 cm (5.5 inches) Full HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 8MP Front Camera</li>\r\n<li class=\"_2-riNZ\">3300 mAh Battery</li>\r\n<li class=\"_2-riNZ\">Exynos 7870 Octa Core 1.6GHz Processor</li>\r\n</ul>', 120, '580.00', 'SM-G610FZKDINS', '0.00', '1557316487', 1, '2019-05-08 11:54:47', '2020-03-04 06:12:24', 231, 0, 2, 1, 'samsung-galaxy-j7-prime', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000034', '1-034', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(42, 3, 45, 6, 'Samsung Galaxy On8', '<ul>\r\n<li class=\"_2-riNZ\">4 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">15.24 cm (6 inch) HD+ Display</li>\r\n<li class=\"_2-riNZ\">16MP + 5MP | 16MP Front Camera</li>\r\n<li class=\"_2-riNZ\">3500 mAh Lithium-ion Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 450 Processor</li>\r\n</ul>', 120, '590.00', 'SM-J810GZKFINS', '0.00', '1557317078', 1, '2019-05-08 12:04:38', '2020-03-04 06:10:46', 228, 0, 2, 1, 'samsung-galaxy-on8', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000035', '1-035', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(43, 3, 45, 6, 'Samsung Galaxy On Max', '<ul>\r\n<li class=\"_2-riNZ\">4 GB RAM | 32 GB ROM | Expandable Up to 256 GB</li>\r\n<li class=\"_2-riNZ\">14.48 cm (5.7 inches) Full HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 13MP Front Camera</li>\r\n<li class=\"_2-riNZ\">3300 mAh Battery</li>\r\n<li class=\"_2-riNZ\">MediaTek MTK6757V/WL 2.39GHz, 1.69GHz, Octa-Core Processor</li>\r\n</ul>', 198, '470.00', 'SM-G615FZDUINS', '0.00', '1557317332', 1, '2019-05-08 12:08:52', '2020-03-04 06:09:47', 225, 0, 2, 1, 'samsung-galaxy-on-max', NULL, NULL, 0, 0, '', '', '', '480.00', '1-000036', '1-036', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(44, 3, 46, 9, 'Lenovo P2', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 32 GB ROM | Expandable Up to 128 GB</li>\r\n<li class=\"_2-riNZ\">13.97 cm (5.5 inches) Full HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 5MP Front Camera</li>\r\n<li class=\"_2-riNZ\">5100 mAh Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 625 Octa Core 2.0GHz Processor</li>\r\n</ul>', 200, '490.00', 'P2a42', '0.00', '1557317714', 1, '2019-05-08 12:15:14', '2020-03-04 06:09:21', 222, 0, 2, 1, 'lenovo-p2', NULL, NULL, 0, 0, '', '', '', '500.00', '1-000037', '1-037', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(45, 3, 46, 9, 'Lenovo VIBE P1', '<ul>\r\n<li class=\"_2-riNZ\">2 GB RAM | 32 GB ROM | Expandable Up to 128 GB</li>\r\n<li class=\"_2-riNZ\">13.97 cm (5.5 inches) Full HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 5MP Front Camera</li>\r\n<li class=\"_2-riNZ\">4900 mAh Li-Polymer Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 615 64-bit Processor</li>\r\n</ul>', 200, '390.00', 'VIBE P1', '0.00', '1557318030', 1, '2019-05-08 12:20:30', '2020-03-04 06:08:03', 219, 0, 2, 1, 'lenovo-vibe-p1', NULL, NULL, 0, 0, '', '', '', '400.00', '1-000038', '1-038', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(46, 3, 47, 9, 'Lenovo K8 Plus', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 32 GB ROM | Expandable Upto 128 GB</li>\r\n<li class=\"_2-riNZ\">13.21 cm (5.2 inch) Full HD Display</li>\r\n<li class=\"_2-riNZ\">13MP + 5MP | 8MP Front Camera</li>\r\n<li class=\"_2-riNZ\">4000 mAh Battery</li>\r\n<li class=\"_2-riNZ\">MediaTek MTK Helio P25 Octa Core 2.5 GHz Processor</li>\r\n</ul>', 200, '280.00', 'K8 Plus', '0.00', '1557318247', 1, '2019-05-08 12:24:07', '2020-03-04 06:07:24', 216, 0, 2, 1, 'lenovo-k8-plus', NULL, NULL, 0, 0, '', '', '', '300.00', '1-000039', '1-039', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(47, 3, 47, 9, 'Lenovo K9', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 32 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">14.48 cm (5.7 inch) HD+ Display</li>\r\n<li class=\"_2-riNZ\">13MP + 5MP | 13MP + 5MP Dual Front Camera</li>\r\n<li class=\"_2-riNZ\">3000 mAh Battery</li>\r\n<li class=\"_2-riNZ\">MediaTek P22 Processor</li>\r\n</ul>', 200, '290.00', 'K9', '0.00', '1557318423', 1, '2019-05-08 12:27:03', '2020-03-04 06:06:32', 213, 0, 2, 1, 'lenovo-k9', NULL, NULL, 0, 0, '', '', '', '300.00', '1-000040', '1-040', 'a:1:{s:0:\"\";N;}', 1, 'a:2:{i:0;a:3:{s:1:\"n\";s:5:\"Color\";s:1:\"c\";s:1:\"1\";s:1:\"v\";a:2:{i:0;a:2:{s:1:\"n\";s:4:\"PINK\";s:1:\"p\";s:3:\"100\";}i:1;a:2:{s:1:\"n\";s:6:\"ORANGE\";s:1:\"p\";s:2:\"50\";}}}i:1;a:3:{s:1:\"n\";s:5:\"Sizes\";s:1:\"c\";s:1:\"0\";s:1:\"v\";a:1:{i:0;a:2:{s:1:\"n\";s:2:\"XL\";s:1:\"p\";s:3:\"100\";}}}}', NULL),
(48, 3, 48, 9, 'Lenovo ZUK Z1', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 64 GB ROM |</li>\r\n<li class=\"_2-riNZ\">13.97 cm (5.5 inch) Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera</li>\r\n<li class=\"_2-riNZ\">4100 mAh Battery</li>\r\n</ul>', 196, '10.00', 'Z1221', '0.00', '1557318651', 1, '2019-05-08 12:30:51', '2020-03-04 06:06:01', 210, 4, 2, 1, 'lenovo-zuk-z1', NULL, NULL, 0, 0, '', '', '', '5.00', '1-000041', '1-041', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(49, 3, 49, 9, 'Lenovo A6000 Shot', '<ul>\r\n<li class=\"_2-riNZ\">2 GB RAM | 16 GB ROM | Expandable Upto 32 GB</li>\r\n<li class=\"_2-riNZ\">12.7 cm (5 inch) HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 5MP Front Camera</li>\r\n<li class=\"_2-riNZ\">2300 mAh Li-Polymer Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 410 MSM8916 64-bit Processor</li>\r\n</ul>', 200, '280.00', 'A6000 Shot', '0.00', '1557319029', 1, '2019-05-08 12:37:09', '2020-03-04 06:04:35', 207, 0, 2, 1, 'lenovo-a6000-shot', NULL, NULL, 0, 0, '', '', '', '300.00', '1-000042', '1-042', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(50, 3, 49, 9, 'Lenovo A5', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 32 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">13.84 cm (5.45 inch) HD+ Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 8MP Front Camera</li>\r\n<li class=\"_2-riNZ\">4000 mAh Battery</li>\r\n<li class=\"_2-riNZ\">MediaTek MT6739 Processor</li>\r\n</ul>', 200, '260.00', 'A5', '0.00', '1557319267', 1, '2019-05-08 12:41:08', '2020-03-04 06:04:02', 204, 0, 2, 1, 'lenovo-a5', NULL, NULL, 0, 0, '', '', '', '280.00', '1-000043', '1-043', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(51, 3, 51, 5, 'Sony Xperia XZ2', '<ul>\r\n<li class=\"_2-riNZ\">6 GB RAM | 64 GB ROM | Expandable Upto 400 GB</li>\r\n<li class=\"_2-riNZ\">14.48 cm (5.7 inch) Display</li>\r\n<li class=\"_2-riNZ\">19MP Rear Camera</li>\r\n<li class=\"_2-riNZ\">3180 mAh Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 845 Processor</li>\r\n</ul>', 200, '679.00', 'Xperia XZ2', '0.00', '1557320124', 1, '2019-05-08 12:55:24', '2020-03-04 06:03:29', 201, 0, 2, 1, 'sony-xperia-xz2', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000044', '1-044', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(52, 3, 52, 5, 'Sony Xperia L2', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 32 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">13.97 cm (5.5 inch) HD Display</li>\r\n<li class=\"_2-riNZ\">13MP Rear Camera | 8MP Front Camera</li>\r\n<li class=\"_2-riNZ\">3300 mAh Battery</li>\r\n<li class=\"_2-riNZ\">MT6737T Processor</li>\r\n</ul>', 200, '580.00', 'Xperia L2', '0.00', '1557320329', 1, '2019-05-08 12:58:49', '2020-03-04 06:02:22', 198, 0, 2, 1, 'sony-xperia-l2', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000045', '1-045', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(53, 3, 53, 5, 'Sony Xperia XA Ultra', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 16 GB ROM | Expandable Upto 200 GB</li>\r\n<li class=\"_2-riNZ\">15.24 cm (6 inch) Full HD Display</li>\r\n<li class=\"_2-riNZ\">21.5MP Rear Camera | 16MP Front Camera</li>\r\n<li class=\"_2-riNZ\">2700 mAh Li-Ion Battery</li>\r\n<li class=\"_2-riNZ\">Mediatek MT6755 64-bit Octa Core 2GHz Processor</li>\r\n</ul>', 200, '590.00', 'Xperia XA Ultra', '0.00', '1557320482', 1, '2019-05-08 13:01:22', '2020-03-04 06:01:55', 195, 0, 2, 1, 'sony-xperia-xa-ultra', NULL, NULL, 0, 0, '', '', '', '600.00', '1-000046', '1-046', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(54, 3, 54, 5, 'Sony Xperia XZ', '<ul>\r\n<li class=\"_2-riNZ\">3 GB RAM | 64 GB ROM | Expandable Upto 256 GB</li>\r\n<li class=\"_2-riNZ\">13.21 cm (5.2 inch) Full HD Display</li>\r\n<li class=\"_2-riNZ\">23MP Rear Camera | 13MP Front Camera</li>\r\n<li class=\"_2-riNZ\">2900 mAh Battery</li>\r\n<li class=\"_2-riNZ\">Qualcomm Snapdragon 820 64-bit Processor</li>\r\n</ul>', 200, '480.00', 'Xperia XZ', '0.00', '1557320679', 1, '2019-05-08 13:04:39', '2020-05-25 02:29:40', 192, 0, 2, 1, 'sony-xperia-xz', NULL, NULL, 0, 0, '', '', '', '500.00', '1-000047', '1-047', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(55, 3, 59, 7, 'Apple iPhone XR', '<ul>\r\n<li class=\"_2-riNZ\">64 GB ROM |</li>\r\n<li class=\"_2-riNZ\">15.49 cm (6.1 inch) Display</li>\r\n<li class=\"_2-riNZ\">12MP Rear Camera | 7MP Front Camera</li>\r\n<li class=\"_2-riNZ\">A12 Bionic Chip Processor</li>\r\n</ul>', 193, '680.00', 'MRY42HN/A', '0.00', '1557320853', 1, '2019-05-08 13:07:33', '2020-03-04 06:00:17', 189, 6, 2, 1, 'apple-iphone-xr', NULL, NULL, 0, 0, '', '', '', '700.00', '1-000048', '1-048', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL),
(56, 3, 60, 7, 'Apple iPhone 8', '<ul>\r\n<li class=\"_2-riNZ\">256 GB ROM |</li>\r\n<li class=\"_2-riNZ\">11.94 cm (4.7 inch) Retina HD Display</li>\r\n<li class=\"_2-riNZ\">12MP Rear Camera | 7MP Front Camera</li>\r\n<li class=\"_2-riNZ\">A11 Bionic Chip with 64-bit Architecture, Neural Engine, Embedded M11 Motion Coprocessor Processor</li>\r\n</ul>', 999, '689.00', 'MQ7F2HN/A', '0.00', '1557321106', 1, '2019-05-08 13:11:46', '2020-05-25 02:29:40', 186, 4, 1, 1, 'apple-iphone-8', 1, 1, 1, 1, '', '', '', '700.00', '1-000049', '1-049', 'a:1:{s:0:\"\";N;}', 1, 'a:0:{}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_specification_type`
--

CREATE TABLE `product_specification_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `specification_type_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specification_type`
--

INSERT INTO `product_specification_type` (`id`, `product_id`, `specification_type_id`, `value`, `unit`, `created_at`, `updated_at`) VALUES
(8, 8, 1, '3.26', 'kg', NULL, NULL),
(9, 8, 2, 'black', NULL, NULL, NULL),
(10, 9, 1, '1.5', 'Kg', NULL, NULL),
(11, 9, 2, 'Silver', NULL, NULL, NULL),
(12, 10, 1, '2.1', 'kg', NULL, NULL),
(13, 10, 2, 'silver', NULL, NULL, NULL),
(14, 11, 1, '2.5', 'kg', NULL, NULL),
(15, 11, 2, 'Black', NULL, NULL, NULL),
(16, 12, 1, '2.63', 'kg', NULL, NULL),
(17, 12, 2, 'Licorice Black', NULL, NULL, NULL),
(18, 13, 2, 'Silver', NULL, NULL, NULL),
(19, 13, 1, '1.21', 'kg', NULL, NULL),
(20, 14, 2, 'Gold', NULL, NULL, NULL),
(21, 14, 1, '1.21', 'kg', NULL, NULL),
(22, 15, 2, 'Anodized Aluminum', NULL, NULL, NULL),
(23, 15, 1, '4.42', 'kg', NULL, NULL),
(24, 16, 2, 'Epic Silver', NULL, NULL, NULL),
(25, 16, 1, '3.49', 'kg', NULL, NULL),
(26, 17, 2, 'Black', NULL, NULL, NULL),
(27, 18, 2, 'Black', NULL, NULL, NULL),
(28, 19, 2, 'Shadow Black', NULL, NULL, NULL),
(29, 19, 1, '2.38', 'kg', NULL, NULL),
(30, 20, 2, 'Dark Ash SIlver', NULL, NULL, NULL),
(31, 20, 1, '1.26', 'kg', NULL, NULL),
(32, 21, 2, 'Natural Silver', NULL, NULL, NULL),
(33, 21, 1, '1.21', 'kg', NULL, NULL),
(34, 22, 1, 'Shadow Black', NULL, NULL, NULL),
(37, 24, 2, 'Silver', NULL, NULL, NULL),
(38, 25, 2, 'Onyx Black', NULL, NULL, NULL),
(39, 26, 2, 'Platinum', NULL, NULL, NULL),
(40, 27, 1, '1.9', 'kg', NULL, NULL),
(41, 27, 2, 'black', NULL, NULL, NULL),
(42, 28, 2, 'black', NULL, NULL, NULL),
(43, 28, 1, '2.4', 'kg', NULL, NULL),
(44, 29, 2, 'Gold', NULL, NULL, NULL),
(45, 29, 1, '1.25', 'kg', NULL, NULL),
(48, 31, 1, '1.37', 'kg', NULL, NULL),
(49, 31, 2, 'Space Grey', NULL, NULL, NULL),
(60, 37, 2, 'Blue', NULL, NULL, NULL),
(61, 37, 1, '165', 'g', NULL, NULL),
(62, 38, 2, 'Gradation Black', NULL, NULL, NULL),
(63, 39, 2, 'Ocean Blue', NULL, NULL, NULL),
(64, 39, 1, '186', 'g', NULL, NULL),
(65, 40, 2, 'black', NULL, NULL, NULL),
(66, 40, 1, '191', 'g', NULL, NULL),
(67, 41, 2, 'black', NULL, NULL, NULL),
(68, 42, 2, 'Black', NULL, NULL, NULL),
(69, 43, 2, 'Gold', NULL, NULL, NULL),
(70, 44, 2, 'Gold', NULL, NULL, NULL),
(71, 45, 2, 'Grey', NULL, NULL, NULL),
(72, 46, 2, 'Fine Gold', NULL, NULL, NULL),
(73, 47, 2, 'black', NULL, NULL, NULL),
(74, 48, 2, 'Space Grey', NULL, NULL, NULL),
(75, 49, 1, NULL, NULL, NULL, NULL),
(76, 50, 2, 'black', NULL, NULL, NULL),
(77, 51, 2, 'Liquid Black', NULL, NULL, NULL),
(78, 52, 2, 'Gold', NULL, NULL, NULL),
(79, 53, 2, 'Graphite Black', NULL, NULL, NULL),
(80, 54, 2, 'Platinum', NULL, NULL, NULL),
(81, 55, 2, 'black', NULL, NULL, NULL),
(82, 56, 2, 'Space Grey', NULL, NULL, NULL),
(83, 47, 1, '100', 'gm', NULL, NULL),
(87, 17, 1, '500', 'gm', NULL, NULL),
(88, 13, 3, '512', 'GB', NULL, NULL),
(89, 13, 4, '500', 'MAH', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `related_products`
--

CREATE TABLE `related_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `related_product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `related_products`
--

INSERT INTO `related_products` (`id`, `product_id`, `related_product_id`, `created_at`, `updated_at`) VALUES
(1, 58, 44, NULL, NULL),
(2, 59, 9, NULL, NULL),
(3, 59, 10, NULL, NULL),
(4, 59, 11, NULL, NULL),
(5, 59, 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `approved`, `created_at`, `updated_at`) VALUES
(2, 1, 41, 5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-11-26 04:33:25', '2019-11-26 04:35:53'),
(3, 1, 56, 4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2019-11-26 06:57:39', '2019-11-26 07:01:56'),
(4, 1, 16, 4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, '2019-11-26 07:01:31', '2020-02-06 01:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `sales` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `date`, `sales`, `order_id`) VALUES
(17, 8, '2019-03-26 06:30:17', 1, 8),
(18, 10, '2019-03-26 11:49:36', 1, 9),
(19, 20, '2019-03-26 11:49:36', 1, 9),
(22, 16, '2019-03-26 11:51:27', 1, 11),
(24, 22, '2019-03-26 11:52:30', 1, 13),
(25, 20, '2019-03-26 11:52:59', 1, 14),
(26, 20, '2019-03-26 11:53:29', 1, 15),
(27, 25, '2019-03-26 11:54:32', 1, 16),
(28, 15, '2019-03-26 12:00:52', 1, 17),
(30, 56, '2019-11-27 04:28:52', 1, 19),
(31, 55, '2019-11-27 04:28:52', 1, 19),
(32, 18, '2019-11-29 11:38:14', 1, 30),
(33, 18, '2019-11-29 11:39:37', 1, 31),
(35, 18, '2019-12-02 04:23:17', 1, 43),
(36, 18, '2019-12-02 07:14:16', 1, 50),
(37, 18, '2019-12-02 09:36:58', 1, 64),
(38, 18, '2019-12-02 09:38:46', 1, 65),
(39, 18, '2019-12-02 09:45:31', 1, 66),
(40, 18, '2019-12-02 10:54:30', 1, 72),
(41, 18, '2019-12-02 10:58:01', 1, 73),
(42, 18, '2019-12-02 11:11:15', 1, 77),
(43, 18, '2019-12-02 11:13:09', 1, 79),
(44, 18, '2019-12-02 11:15:34', 1, 80),
(45, 18, '2019-12-02 11:16:08', 1, 81),
(46, 18, '2019-12-02 11:32:57', 1, 82),
(47, 18, '2019-12-02 11:46:43', 1, 85),
(48, 18, '2019-12-02 11:47:52', 1, 86),
(49, 18, '2019-12-02 12:01:19', 1, 89),
(50, 56, '2019-12-04 10:27:16', 1, 99),
(51, 56, '2019-12-04 10:28:29', 1, 99),
(52, 18, '2019-12-04 11:30:06', 1, 103),
(53, 18, '2019-12-05 05:33:50', 1, 104),
(54, 18, '2019-12-05 05:46:19', 1, 108),
(56, 55, '2019-12-11 10:26:14', 1, 114),
(57, 56, '2019-12-11 10:54:01', 1, 118),
(59, 55, '2019-12-12 09:13:19', 1, 121),
(60, 55, '2019-12-12 09:16:24', 1, 122),
(61, 55, '2019-12-12 09:34:36', 1, 123),
(62, 55, '2019-12-13 07:15:55', 1, 124),
(63, 17, '2019-12-14 08:30:01', 1, 125),
(64, 8, '2019-12-19 07:50:57', 1, 8),
(65, 8, '2019-12-19 07:51:49', 1, 8),
(66, 48, '2019-12-19 07:54:51', 1, 153),
(67, 48, '2019-12-19 07:55:44', 1, 153),
(68, 48, '2019-12-19 07:56:54', 1, 153),
(69, 48, '2019-12-19 07:57:23', 1, 153),
(70, 15, '2019-12-27 06:42:02', 1, 154),
(71, 29, '2019-12-28 05:59:37', 1, 157),
(72, 15, '2020-01-20 04:46:35', 1, 158),
(73, 15, '2020-01-20 09:06:51', 1, 159),
(74, 15, '2020-01-20 09:32:39', 1, 160),
(75, 15, '2020-01-20 09:34:15', 1, 161),
(76, 14, '2020-01-20 09:34:58', 1, 162),
(77, 14, '2020-01-20 09:35:39', 1, 163),
(78, 14, '2020-01-20 11:18:30', 1, 176),
(79, 14, '2020-01-20 11:50:27', 1, 177),
(80, 14, '2020-01-20 11:52:43', 1, 178),
(81, 14, '2020-01-20 11:55:04', 1, 179),
(82, 14, '2020-01-20 11:55:56', 1, 180),
(83, 14, '2020-01-20 11:59:36', 1, 181),
(84, 14, '2020-01-20 12:02:39', 2, 182),
(85, 14, '2020-01-20 12:04:00', 1, 183),
(86, 14, '2020-01-20 12:04:39', 1, 184),
(87, 14, '2020-01-20 12:05:29', 2, 185),
(88, 14, '2020-01-20 12:06:09', 1, 186),
(89, 14, '2020-01-20 12:08:12', 1, 187),
(90, 14, '2020-01-20 12:09:27', 1, 188),
(91, 14, '2020-01-20 12:09:56', 1, 189),
(92, 14, '2020-01-20 12:11:01', 2, 190),
(93, 14, '2020-01-20 12:11:28', 1, 191),
(94, 14, '2020-01-20 12:13:20', 1, 192),
(95, 16, '2020-01-20 12:15:00', 1, 193),
(96, 16, '2020-01-20 12:15:32', 1, 194),
(97, 16, '2020-01-20 12:16:05', 1, 195),
(98, 16, '2020-01-20 12:16:28', 1, 196),
(99, 16, '2020-01-20 12:17:09', 2, 197),
(100, 17, '2020-01-21 05:31:37', 1, 198),
(101, 17, '2020-01-21 05:39:11', 1, 199),
(102, 17, '2020-01-21 05:47:05', 1, 200),
(103, 17, '2020-01-21 05:48:06', 1, 201),
(104, 17, '2020-01-21 05:52:37', 2, 202),
(105, 17, '2020-01-21 05:53:08', 2, 203),
(106, 17, '2020-01-21 05:53:52', 1, 204),
(107, 17, '2020-01-21 05:56:35', 2, 205),
(108, 18, '2020-01-21 06:34:06', 1, 206),
(109, 18, '2020-01-21 06:36:54', 1, 207),
(110, 18, '2020-01-21 07:25:45', 1, 208),
(111, 18, '2020-01-21 08:18:03', 1, 209),
(112, 29, '2020-01-21 08:20:14', 1, 210);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `full_width` tinyint(1) NOT NULL DEFAULT 1,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `position_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `content`, `is_active`, `position`, `priority`, `full_width`, `category_id`, `brand_id`, `position_category`, `position_brand`, `location_id`, `created_at`, `updated_at`) VALUES
(1, '<!-- ============================================== INFO BOXES ============================================== -->\r\n<div class=\"info-boxes wow fadeInUp\">\r\n<div class=\"info-boxes-inner\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6 col-sm-4 col-lg-4\">\r\n<div class=\"info-box\">\r\n<div class=\"row\">\r\n<div class=\"col-xs-12\">\r\n<h4 class=\"info-box-heading green\">money back</h4>\r\n</div>\r\n</div>\r\n<h6 class=\"text\">30 Days Money Back Guarantee</h6>\r\n</div>\r\n</div>\r\n<!-- .col -->\r\n<div class=\"hidden-md col-sm-4 col-lg-4\">\r\n<div class=\"info-box\">\r\n<div class=\"row\">\r\n<div class=\"col-xs-12\">\r\n<h4 class=\"info-box-heading green\">free shipping</h4>\r\n</div>\r\n</div>\r\n<h6 class=\"text\">Shipping on orders over $99</h6>\r\n</div>\r\n</div>\r\n<!-- .col -->\r\n<div class=\"col-md-6 col-sm-4 col-lg-4\">\r\n<div class=\"info-box\">\r\n<div class=\"row\">\r\n<div class=\"col-xs-12\">\r\n<h4 class=\"info-box-heading green\">Special Sale</h4>\r\n</div>\r\n</div>\r\n<h6 class=\"text\">Extra $5 off on all items</h6>\r\n</div>\r\n</div>\r\n<!-- .col --></div>\r\n<!-- /.row --></div>\r\n<!-- /.info-boxes-inner --></div>\r\n<!-- /.info-boxes -->', 1, 'Below Main Slider', 1, 1, NULL, NULL, NULL, NULL, 1, '2020-05-25 02:14:20', '2020-05-25 02:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `specification_types`
--

CREATE TABLE `specification_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specification_types`
--

INSERT INTO `specification_types` (`id`, `location_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Weight', '2019-03-11 08:37:17', '2019-03-11 08:37:17'),
(2, 1, 'Color', '2019-03-11 08:37:21', '2019-03-11 08:37:21'),
(3, 1, 'RAM', '2020-02-11 02:41:58', '2020-02-11 02:41:58'),
(4, 1, 'Battery', '2020-02-11 02:42:06', '2020-02-11 02:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `photo_id`, `author`, `review`, `designation`, `is_active`, `priority`, `created_at`, `updated_at`) VALUES
(1, 88, 'Jones Smith', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '', 1, 1, '2019-03-26 11:46:44', '2019-03-26 11:46:44'),
(2, 89, 'Daniel Craig', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', '', 1, 1, '2019-03-26 11:48:08', '2019-03-26 11:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_amounts`
--

CREATE TABLE `vendor_amounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `vendor_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) UNSIGNED DEFAULT NULL,
  `total_price` decimal(12,2) UNSIGNED DEFAULT NULL,
  `vendor_amount` decimal(12,2) UNSIGNED DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'outstanding',
  `outstanding_date` datetime DEFAULT NULL,
  `earned_date` datetime DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `processed` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `vendor_payment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_amounts`
--

INSERT INTO `vendor_amounts` (`id`, `order_id`, `product_id`, `vendor_id`, `product_name`, `product_quantity`, `unit_price`, `total_price`, `vendor_amount`, `currency`, `status`, `outstanding_date`, `earned_date`, `payment_date`, `cancel_date`, `processed`, `vendor_payment_id`) VALUES
(17, 8, 8, 1, 'test product 1', 1, '10.00', '10.00', '6.00', 'USD', 'paid', '2019-03-26 06:30:17', '2019-03-26 11:55:46', '2019-03-26 12:00:16', NULL, 1, 1),
(18, 9, 10, 1, 'Dell Inspiron 7570 15.6-inch', 1, '654.00', '654.00', '392.40', 'USD', 'paid', '2019-03-26 11:49:36', '2019-03-26 11:55:50', '2019-03-26 12:00:16', NULL, 1, 1),
(19, 9, 20, 1, 'HP Spectre x360 Core i7 8th Gen', 1, '786.00', '786.00', '471.60', 'USD', 'paid', '2019-03-26 11:49:36', '2019-03-26 11:55:50', '2019-03-26 12:00:16', NULL, 1, 1),
(20, 10, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'USD', 'cancelled', '2019-03-26 11:50:52', NULL, NULL, '2019-03-26 11:55:58', 0, NULL),
(21, 10, 21, 1, 'HP Envy 13 Core i3 8th Gen', 1, '786.00', '786.00', '471.60', 'USD', 'cancelled', '2019-03-26 11:50:52', NULL, NULL, '2019-03-26 11:55:58', 0, NULL),
(22, 11, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'USD', 'paid', '2019-03-26 11:51:27', '2019-03-26 11:56:09', '2019-03-26 12:00:16', NULL, 1, 1),
(23, 12, 23, 1, 'HP Core M 6th Gen', 1, '765.00', '765.00', '459.00', 'USD', 'outstanding', '2019-03-26 11:51:53', NULL, NULL, NULL, 0, NULL),
(24, 13, 22, 1, 'HP Pavilion Core i7 8th Gen', 1, '567.00', '567.00', '340.20', 'USD', 'paid', '2019-03-26 11:52:30', '2019-03-26 11:56:13', '2019-03-26 12:00:16', NULL, 1, 1),
(25, 14, 20, 1, 'HP Spectre x360 Core i7 8th Gen', 1, '786.00', '786.00', '471.60', 'USD', 'outstanding', '2019-03-26 11:52:59', NULL, NULL, NULL, 0, NULL),
(26, 15, 20, 1, 'HP Spectre x360 Core i7 8th Gen', 1, '786.00', '786.00', '471.60', 'USD', 'outstanding', '2019-03-26 11:53:29', NULL, NULL, NULL, 0, NULL),
(27, 16, 25, 1, 'Lenovo Ideapad 330 Core i5 8th Gen', 1, '675.00', '675.00', '405.00', 'USD', 'paid', '2019-03-26 11:54:32', '2019-03-26 11:56:19', '2019-03-26 12:00:16', NULL, 1, 1),
(28, 17, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'USD', 'paid', '2019-03-26 12:00:52', '2019-11-22 12:19:34', '2019-11-27 11:02:53', NULL, 1, 2),
(30, 19, 56, 1, 'Apple iPhone 8', 1, '689.00', '689.00', '413.40', 'USD', 'outstanding', '2019-11-27 04:28:52', NULL, NULL, NULL, 0, NULL),
(31, 19, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'USD', 'outstanding', '2019-11-27 04:28:52', NULL, NULL, NULL, 0, NULL),
(32, 30, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'USD', 'earned', NULL, '2019-11-29 11:38:14', NULL, NULL, 0, NULL),
(33, 31, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'USD', 'earned', NULL, '2019-11-29 11:39:37', NULL, NULL, 0, NULL),
(34, 42, 34, 1, 'Samsung Galaxy Note 8', 1, '480.00', '480.00', '288.00', 'NGN', 'earned', NULL, '2019-11-30 07:08:43', NULL, NULL, 0, NULL),
(35, 43, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'NGN', 'earned', NULL, '2019-12-02 04:23:17', NULL, NULL, 0, NULL),
(36, 50, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'USD', 'earned', NULL, '2019-12-02 07:14:16', NULL, NULL, 0, NULL),
(37, 64, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 09:36:58', NULL, NULL, 0, NULL),
(38, 65, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 09:38:46', NULL, NULL, 0, NULL),
(39, 66, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 09:45:31', NULL, NULL, 0, NULL),
(40, 72, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 10:54:30', NULL, NULL, 0, NULL),
(41, 73, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 10:58:01', NULL, NULL, 0, NULL),
(42, 77, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 11:11:15', NULL, NULL, 0, NULL),
(43, 79, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 11:13:09', NULL, NULL, 0, NULL),
(44, 80, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 11:15:34', NULL, NULL, 0, NULL),
(45, 81, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 11:16:08', NULL, NULL, 0, NULL),
(46, 82, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 11:32:57', NULL, NULL, 0, NULL),
(47, 85, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'USD', 'earned', NULL, '2019-12-02 11:46:43', NULL, NULL, 0, NULL),
(48, 86, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'USD', 'earned', NULL, '2019-12-02 11:47:52', NULL, NULL, 0, NULL),
(49, 89, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-02 12:01:19', NULL, NULL, 0, NULL),
(50, 99, 56, 1, 'Apple iPhone 8', 1, '689.00', '689.00', '413.40', 'RSD', 'earned', NULL, '2019-12-04 10:27:17', NULL, NULL, 0, NULL),
(51, 99, 56, 1, 'Apple iPhone 8', 1, '689.00', '689.00', '413.40', 'RSD', 'earned', NULL, '2019-12-04 10:28:29', NULL, NULL, 0, NULL),
(52, 103, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'earned', NULL, '2019-12-04 11:30:06', NULL, NULL, 0, NULL),
(53, 104, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'NGN', 'earned', NULL, '2019-12-05 05:33:50', NULL, NULL, 0, NULL),
(54, 108, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'NGN', 'earned', NULL, '2019-12-05 05:46:19', NULL, NULL, 0, NULL),
(55, NULL, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'USD', 'outstanding', '2019-12-11 07:57:20', NULL, NULL, NULL, 0, NULL),
(56, 114, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'INR', 'earned', NULL, '2019-12-11 10:26:14', NULL, NULL, 0, NULL),
(57, 118, 56, 1, 'Apple iPhone 8', 1, '689.00', '689.00', '413.40', 'INR', 'earned', NULL, '2019-12-11 10:54:01', NULL, NULL, 0, NULL),
(58, 119, 34, 1, 'Samsung Galaxy Note 8', 1, '480.00', '480.00', '288.00', 'INR', 'outstanding', '2019-12-11 11:12:02', NULL, NULL, NULL, 0, NULL),
(59, 121, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'INR', 'outstanding', '2019-12-12 09:13:18', NULL, NULL, NULL, 0, NULL),
(60, 122, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'INR', 'earned', '2019-12-12 09:16:24', '2019-12-13 06:39:31', NULL, NULL, 0, NULL),
(61, 123, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'INR', 'earned', '2019-12-12 09:34:36', '2019-12-12 09:38:40', NULL, NULL, 0, NULL),
(62, 124, 55, 1, 'Apple iPhone XR', 1, '680.00', '680.00', '408.00', 'INR', 'outstanding', '2019-12-13 07:15:55', NULL, NULL, NULL, 0, NULL),
(63, 125, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2019-12-14 08:30:01', NULL, NULL, NULL, 0, NULL),
(64, 8, 8, 1, 'Dell Inspiron 15 Core i3 7th gen', 1, '10.00', '10.00', '6.00', 'USD', 'earned', NULL, '2019-12-19 07:50:58', NULL, NULL, 0, NULL),
(65, 8, 8, 1, 'Dell Inspiron 15 Core i3 7th gen', 1, '10.00', '10.00', '6.00', 'USD', 'earned', NULL, '2019-12-19 07:51:49', NULL, NULL, 0, NULL),
(66, 153, 48, 1, 'Lenovo ZUK Z1', 1, '10.00', '10.00', '6.00', 'KES', 'earned', NULL, '2019-12-19 07:54:51', NULL, NULL, 0, NULL),
(67, 153, 48, 1, 'Lenovo ZUK Z1', 1, '10.00', '10.00', '6.00', 'KES', 'earned', NULL, '2019-12-19 07:55:44', NULL, NULL, 0, NULL),
(68, 153, 48, 1, 'Lenovo ZUK Z1', 1, '10.00', '10.00', '6.00', 'KES', 'earned', NULL, '2019-12-19 07:56:54', NULL, NULL, 0, NULL),
(69, 153, 48, 1, 'Lenovo ZUK Z1', 1, '10.00', '10.00', '6.00', 'KES', 'earned', NULL, '2019-12-19 07:57:23', NULL, NULL, 0, NULL),
(70, 154, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'KES', 'outstanding', '2019-12-27 06:42:02', NULL, NULL, NULL, 0, NULL),
(71, 157, 29, 1, 'Apple MacBook Air Core i5 8th Gen', 1, '698.00', '698.00', '418.80', 'KES', 'earned', '2019-12-28 05:59:37', '2019-12-28 06:03:15', NULL, NULL, 0, NULL),
(72, 158, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'USD', 'outstanding', '2020-01-20 04:46:35', NULL, NULL, NULL, 0, NULL),
(73, 159, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'INR', 'outstanding', '2020-01-20 09:06:51', NULL, NULL, NULL, 0, NULL),
(74, 160, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'INR', 'outstanding', '2020-01-20 09:32:39', NULL, NULL, NULL, 0, NULL),
(75, 161, 15, 1, 'Alienware Core i7 7th Gen', 1, '567.00', '567.00', '340.20', 'INR', 'outstanding', '2020-01-20 09:34:15', NULL, NULL, NULL, 0, NULL),
(76, 162, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:34:58', NULL, NULL, NULL, 0, NULL),
(77, 163, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:35:39', NULL, NULL, NULL, 0, NULL),
(78, 164, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:37:20', NULL, NULL, NULL, 0, NULL),
(79, 165, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:37:51', NULL, NULL, NULL, 0, NULL),
(80, 166, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:41:14', NULL, NULL, NULL, 0, NULL),
(81, 167, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:45:23', NULL, NULL, NULL, 0, NULL),
(82, 168, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:48:00', NULL, NULL, NULL, 0, NULL),
(83, 169, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 09:49:00', NULL, NULL, NULL, 0, NULL),
(84, 170, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 2, '654.00', '1308.00', '784.80', 'INR', 'outstanding', '2020-01-20 09:55:05', NULL, NULL, NULL, 0, NULL),
(85, 171, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 2, '654.00', '1308.00', '784.80', 'INR', 'outstanding', '2020-01-20 10:00:38', NULL, NULL, NULL, 0, NULL),
(86, 172, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 10:13:55', NULL, NULL, NULL, 0, NULL),
(87, 173, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 10:14:50', NULL, NULL, NULL, 0, NULL),
(88, 174, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 10:25:30', NULL, NULL, NULL, 0, NULL),
(89, 175, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 10:27:53', NULL, NULL, NULL, 0, NULL),
(90, 176, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:18:30', NULL, NULL, NULL, 0, NULL),
(91, 177, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:50:27', NULL, NULL, NULL, 0, NULL),
(92, 178, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:52:43', NULL, NULL, NULL, 0, NULL),
(93, 179, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:55:04', NULL, NULL, NULL, 0, NULL),
(94, 180, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:55:56', NULL, NULL, NULL, 0, NULL),
(95, 181, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 11:59:36', NULL, NULL, NULL, 0, NULL),
(96, 182, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 2, '654.00', '1308.00', '784.80', 'INR', 'outstanding', '2020-01-20 12:02:39', NULL, NULL, NULL, 0, NULL),
(97, 183, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:04:00', NULL, NULL, NULL, 0, NULL),
(98, 184, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:04:39', NULL, NULL, NULL, 0, NULL),
(99, 185, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 2, '654.00', '1308.00', '784.80', 'INR', 'outstanding', '2020-01-20 12:05:29', NULL, NULL, NULL, 0, NULL),
(100, 186, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:06:09', NULL, NULL, NULL, 0, NULL),
(101, 187, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:08:12', NULL, NULL, NULL, 0, NULL),
(102, 188, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:09:27', NULL, NULL, NULL, 0, NULL),
(103, 189, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:09:56', NULL, NULL, NULL, 0, NULL),
(104, 190, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 2, '654.00', '1308.00', '784.80', 'INR', 'outstanding', '2020-01-20 12:11:01', NULL, NULL, NULL, 0, NULL),
(105, 191, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:11:28', NULL, NULL, NULL, 0, NULL),
(106, 192, 14, 1, 'Dell XPS 13 Core i7 8th Gen', 1, '654.00', '654.00', '392.40', 'INR', 'outstanding', '2020-01-20 12:13:20', NULL, NULL, NULL, 0, NULL),
(107, 193, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'INR', 'outstanding', '2020-01-20 12:15:00', NULL, NULL, NULL, 0, NULL),
(108, 194, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'INR', 'outstanding', '2020-01-20 12:15:32', NULL, NULL, NULL, 0, NULL),
(109, 195, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'INR', 'outstanding', '2020-01-20 12:16:05', NULL, NULL, NULL, 0, NULL),
(110, 196, 16, 1, 'Alienware 15 Core i9 8th Gen', 1, '687.00', '687.00', '412.20', 'INR', 'outstanding', '2020-01-20 12:16:28', NULL, NULL, NULL, 0, NULL),
(111, 197, 16, 1, 'Alienware 15 Core i9 8th Gen', 2, '687.00', '1374.00', '824.40', 'INR', 'outstanding', '2020-01-20 12:17:09', NULL, NULL, NULL, 0, NULL),
(112, 198, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2020-01-21 05:31:37', NULL, NULL, NULL, 0, NULL),
(113, 199, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2020-01-21 05:39:11', NULL, NULL, NULL, 0, NULL),
(114, 200, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2020-01-21 05:47:05', NULL, NULL, NULL, 0, NULL),
(115, 201, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2020-01-21 05:48:06', NULL, NULL, NULL, 0, NULL),
(116, 202, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 2, '678.00', '1356.00', '813.60', 'INR', 'outstanding', '2020-01-21 05:52:37', NULL, NULL, NULL, 0, NULL),
(117, 203, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 2, '678.00', '1356.00', '813.60', 'INR', 'outstanding', '2020-01-21 05:53:08', NULL, NULL, NULL, 0, NULL),
(118, 204, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 1, '678.00', '678.00', '406.80', 'INR', 'outstanding', '2020-01-21 05:53:52', NULL, NULL, NULL, 0, NULL),
(119, 205, 17, 1, 'Dell Inspiron 15 3000 Core i3 7th Gen', 2, '678.00', '1356.00', '813.60', 'INR', 'outstanding', '2020-01-21 05:56:35', NULL, NULL, NULL, 0, NULL),
(120, 206, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'outstanding', '2020-01-21 06:34:06', NULL, NULL, NULL, 0, NULL),
(121, 207, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'outstanding', '2020-01-21 06:36:54', NULL, NULL, NULL, 0, NULL),
(122, 208, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'outstanding', '2020-01-21 07:25:45', NULL, NULL, NULL, 0, NULL),
(123, 209, 18, 1, 'Dell Inspiron Core i5 7th Gen', 1, '564.00', '564.00', '338.40', 'INR', 'outstanding', '2020-01-21 08:18:03', NULL, NULL, NULL, 0, NULL),
(124, 210, 29, 1, 'Apple MacBook Air Core i5 8th Gen', 1, '698.00', '698.00', '418.80', 'INR', 'outstanding', '2020-01-21 08:20:14', NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uses` int(10) UNSIGNED DEFAULT NULL,
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `max_uses_user` int(10) UNSIGNED DEFAULT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `discount_amount` decimal(12,2) UNSIGNED NOT NULL,
  `is_fixed` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `valid_above_amount` decimal(12,2) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `name`, `description`, `uses`, `max_uses`, `max_uses_user`, `type`, `discount_amount`, `is_fixed`, `starts_at`, `expires_at`, `created_at`, `updated_at`, `location_id`, `valid_above_amount`) VALUES
(1, NULL, 'Flash Sale', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, NULL, NULL, 2, '5.00', 0, '2020-02-12 13:21:00', '2022-06-03 13:21:00', '2020-05-25 02:22:03', '2020-05-25 02:22:03', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_photo_id_index` (`photo_id`),
  ADD KEY `banners_location_id_index` (`location_id`),
  ADD KEY `banners_category_id_index` (`category_id`),
  ADD KEY `banners_brand_id_index` (`brand_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_photo_id_index` (`photo_id`),
  ADD KEY `brands_location_id_index` (`location_id`),
  ADD KEY `brands_voucher_id_index` (`voucher_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_category_id_index` (`category_id`),
  ADD KEY `categories_location_id_index` (`location_id`),
  ADD KEY `categories_voucher_id_index` (`voucher_id`),
  ADD KEY `categories_photo_id_index` (`photo_id`);

--
-- Indexes for table `category_specification_type`
--
ALTER TABLE `category_specification_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comparision_groups`
--
ALTER TABLE `comparision_groups`
  ADD PRIMARY KEY (`cg_id`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deals_location_id_index` (`location_id`);

--
-- Indexes for table `deal_product`
--
ALTER TABLE `deal_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_product_id_index` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_user_id_index` (`user_id`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_brand_id_index` (`brand_id`),
  ADD KEY `products_photo_id_index` (`photo_id`),
  ADD KEY `products_location_id_index` (`location_id`),
  ADD KEY `products_voucher_id_index` (`voucher_id`),
  ADD KEY `products_vendor_id_index` (`vendor_id`),
  ADD KEY `products_comp_group_id_index` (`comp_group_id`);

--
-- Indexes for table `product_specification_type`
--
ALTER TABLE `product_specification_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `related_products`
--
ALTER TABLE `related_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_index` (`user_id`),
  ADD KEY `reviews_product_id_index` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_product_id_index` (`product_id`),
  ADD KEY `sales_order_id_index` (`order_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_category_id_index` (`category_id`),
  ADD KEY `sections_brand_id_index` (`brand_id`),
  ADD KEY `sections_location_id_index` (`location_id`);

--
-- Indexes for table `specification_types`
--
ALTER TABLE `specification_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specification_types_location_id_index` (`location_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_photo_id_index` (`photo_id`);

--
-- Indexes for table `vendor_amounts`
--
ALTER TABLE `vendor_amounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_amounts_order_id_index` (`order_id`),
  ADD KEY `vendor_amounts_product_id_index` (`product_id`),
  ADD KEY `vendor_amounts_vendor_id_index` (`vendor_id`),
  ADD KEY `vendor_amounts_vendor_payment_id_index` (`vendor_payment_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vouchers_location_id_index` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `category_specification_type`
--
ALTER TABLE `category_specification_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comparision_groups`
--
ALTER TABLE `comparision_groups`
  MODIFY `cg_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deal_product`
--
ALTER TABLE `deal_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `product_specification_type`
--
ALTER TABLE `product_specification_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `related_products`
--
ALTER TABLE `related_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `specification_types`
--
ALTER TABLE `specification_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_amounts`
--
ALTER TABLE `vendor_amounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
