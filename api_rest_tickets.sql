-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 30-10-2025 a las 13:47:13
-- Versión del servidor: 5.7.34
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_rest_tickets`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `favorite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `avatar`, `slug`, `is_active`, `is_featured`, `favorite_id`, `user_id`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Welcome to Our Blog', 'This is the first post on our blog, created by the admin.', NULL, 'welcome-to-our-blog', 1, 1, NULL, 2, 1, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(2, 'Teaching Tips for Success', 'Helpful tips for teachers to succeed in the classroom.', NULL, 'teaching-tips-for-success', 1, 0, NULL, NULL, 2, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(3, 'Latest Technology Trends', 'An overview of the latest trends in technology.', NULL, 'latest-technology-trends', 1, 0, NULL, 2, 1, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(4, 'Classroom Management Strategies', 'Effective strategies for managing a classroom.', NULL, 'classroom-management-strategies', 1, 0, NULL, NULL, 2, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(5, 'Health and Wellness Tips', 'Tips for maintaining health and wellness.', NULL, 'health-and-wellness-tips', 1, 0, NULL, 2, 3, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Technology', '2025-10-30 13:46:50', '2025-10-30 13:46:50'),
(2, 'Education', '2025-10-30 13:46:50', '2025-10-30 13:46:50'),
(3, 'Health', '2025-10-30 13:46:50', '2025-10-30 13:46:50'),
(4, 'Sports', '2025-10-30 13:46:50', '2025-10-30 13:46:50'),
(5, 'Entertainment', '2025-10-30 13:46:50', '2025-10-30 13:46:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` timestamp NULL DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `company` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `n_doc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User email for login',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hashed password',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'For "remember me" functionality',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `role` enum('GUEST','CLIENT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CLIENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `name`, `surname`, `mobile`, `birth_date`, `gender`, `company`, `address`, `avatar`, `n_doc`, `status`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `role`) VALUES
(1, 'Josefina', 'Bashirian', '1-878-712-1656', '1977-01-07 04:00:00', 2, NULL, '53964 Reva Dale Suite 665\nEstellaburgh, SC 22465', NULL, '0629723542', 'ACTIVE', 'hill.agustin@example.org', NULL, '$2y$10$ifEwIVXGa4IuxTmEUjqWCOlW9MeZnXoKXwSQt6..k8yPGNmT0rlaK', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL, 'CLIENT'),
(2, 'Vincenza', 'Schneider', '(931) 609-2067', '1994-10-10 04:00:00', 2, NULL, '20504 Darby Way\nPort Jeremie, UT 14787', NULL, '4310789793', 'ACTIVE', 'vhagenes@example.com', NULL, '$2y$10$DKBKqPe3titARBH4SaO8LuDLv/U/.czLy5IZHI/oPdZAX.XZ1SEtS', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL, 'CLIENT'),
(3, 'Isac', 'Welch', '(930) 303-2792', '1973-12-07 04:00:00', 1, NULL, '10649 Schulist Ridges\nCarlottamouth, GA 68542', NULL, '3143043467', 'ACTIVE', 'yaufderhar@example.net', NULL, '$2y$10$DPS8JnJ5kssnmT.gg/0uy.W6Jy.gz1j0qFwm4z5jiDKt9jlq8FtLm', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL, 'CLIENT'),
(4, 'Paris', 'Lesch', '+1 (564) 944-2593', '2018-12-19 04:00:00', 2, NULL, '746 Edyth Field\nPort Kylerhaven, OR 78888', NULL, '8470975654', 'ACTIVE', 'kulas.ana@example.org', NULL, '$2y$10$BLC/HDUhJ5IiNs.2vzZj/.8W2xtTvfzn9mCqgQ0c.WNa6yJCY88Ui', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(5, 'Eva', 'Feeney', '+18609041457', '2003-05-14 04:00:00', 1, NULL, '90328 Karen View\nEast Brad, AL 00800', NULL, '0373972685', 'INACTIVE', 'chance.kautzer@example.net', NULL, '$2y$10$IWFYZ5QhxInEAwODgfpu4ucdqHIiaVZzpLSeBcu4MxbJW.0woziEa', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(6, 'Roma', 'Bins', '1-608-907-5736', '1985-03-10 04:00:00', 2, NULL, '1900 Cremin Mews Apt. 932\nSouth Adelbert, DE 43477-7027', NULL, '0431111269', 'INACTIVE', 'liza.swift@example.com', NULL, '$2y$10$WHvlKd8KyYX1eUkfDUAgg.sSafeO3AkRFVZHhXrp2fkHBBzLLXR9.', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(7, 'Jamir', 'Hauck', '(878) 699-8123', '1974-12-13 04:00:00', 2, NULL, '87628 McCullough Expressway\nKingmouth, KY 49864-0975', NULL, '9065461388', 'INACTIVE', 'marjorie.ritchie@example.org', NULL, '$2y$10$x6O38.3K1w8GJ2KRbkcd1e9PNVibzHarSUTVvCCMn3SivXY5dKCem', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(8, 'Cleora', 'Cremin', '551-423-8764', '1976-08-09 04:00:00', 1, NULL, '50675 Rebeka Villages\nDeliaberg, KY 04008-3915', NULL, '9060262411', 'INACTIVE', 'simonis.dortha@example.net', NULL, '$2y$10$uUtePdg.mNRVIJFymf2kNe0GbGYLkxv/5SEfBGuspjRTUGtLv8A1m', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(9, 'Anthony', 'Terry', '1-215-577-3444', '1991-08-06 04:00:00', 2, NULL, '441 Tessie Stream Apt. 277\nNorth Aliya, ND 46914', NULL, '8613428055', 'ACTIVE', 'marian99@example.net', NULL, '$2y$10$vc0nEdBemA9deVil2o.s1uC9.pGkYEJliwHrQxh6870bhuazvdxFy', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT'),
(10, 'Joy', 'Braun', '1-385-604-1607', '1982-01-03 04:00:00', 1, NULL, '3159 Denesik Forks Apt. 200\nLake Napoleonville, NH 93749', NULL, '6516017408', 'INACTIVE', 'colt81@example.com', NULL, '$2y$10$m6L8hNcVajVzi43TOllQjOacTSiI.8B8RKqAcWKFERBEnN2YI74Hu', NULL, '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL, 'CLIENT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `company` text COLLATE utf8mb4_unicode_ci,
  `fecha_inicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `precio_general` double(15,2) NOT NULL,
  `precio_estudiantes` double(15,2) DEFAULT NULL,
  `precio_especialistas` double(15,2) DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','RETIRED','FINISHED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `name`, `description`, `company`, `fecha_inicio`, `fecha_fin`, `precio_general`, `precio_estudiantes`, `precio_especialistas`, `avatar`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Wilfrid', NULL, NULL, '1980-01-15 04:00:00', '2020-01-16 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(2, 'Sofia', NULL, NULL, '1984-11-13 04:00:00', '1995-11-28 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(3, 'Josiane', NULL, NULL, '2015-06-15 04:30:00', '1991-02-22 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'ACTIVE', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(4, 'Henriette', NULL, NULL, '2005-02-14 04:00:00', '1973-12-10 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(5, 'Lindsey', NULL, NULL, '1984-02-13 04:00:00', '2025-06-18 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(6, 'Ressie', NULL, NULL, '2024-04-12 04:00:00', '1979-04-10 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(7, 'Misael', NULL, NULL, '2017-11-20 04:00:00', '1986-08-04 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'ACTIVE', '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(8, 'Kaley', NULL, NULL, '1970-02-06 04:00:00', '1974-05-08 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(9, 'Oceane', NULL, NULL, '1970-06-13 04:00:00', '1979-10-19 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(10, 'Eladio', NULL, NULL, '2000-11-24 04:00:00', '2002-10-18 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(11, 'Leonardo', NULL, NULL, '2024-01-29 04:00:00', '2014-02-04 04:30:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(12, 'Alan', NULL, NULL, '2007-09-14 04:00:00', '1981-11-09 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(13, 'Kailee', NULL, NULL, '1996-09-08 04:00:00', '2009-04-17 04:30:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(14, 'Maida', NULL, NULL, '2010-12-19 04:30:00', '1998-03-25 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(15, 'Judah', NULL, NULL, '2022-02-15 04:00:00', '1992-09-04 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(16, 'Cameron', NULL, NULL, '1994-04-07 04:00:00', '1990-04-05 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'ACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(17, 'Yadira', NULL, NULL, '1980-06-22 04:00:00', '1984-05-16 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(18, 'Chasity', NULL, NULL, '2006-12-20 04:00:00', '1997-12-07 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(19, 'Arno', NULL, NULL, '1980-05-24 04:00:00', '2002-11-18 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(20, 'Izabella', NULL, NULL, '2013-08-16 04:30:00', '2010-06-19 04:30:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'ACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(21, 'Lavina', NULL, NULL, '1997-11-19 04:00:00', '1970-03-20 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(22, 'Sydnie', NULL, NULL, '2014-05-26 04:30:00', '1994-09-02 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(23, 'Krystina', NULL, NULL, '2019-05-23 04:00:00', '2020-04-19 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'ACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(24, 'Katherine', NULL, NULL, '1974-08-21 04:00:00', '1972-11-03 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(25, 'Sandy', NULL, NULL, '2007-02-17 04:00:00', '2013-01-28 04:30:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(26, 'Arden', NULL, NULL, '1970-12-11 04:00:00', '2003-03-22 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'FINISHED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(27, 'Katelyn', NULL, NULL, '2011-03-23 04:30:00', '2024-10-11 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(28, 'Eliezer', NULL, NULL, '1978-02-28 04:00:00', '2015-03-13 04:30:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'RETIRED', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL),
(29, 'Leatha', NULL, NULL, '1984-03-10 04:00:00', '1990-03-23 04:00:00', 1000.00, 1000.00, 1000.00, NULL, NULL, 'INACTIVE', '2025-10-30 13:46:50', '2025-10-30 13:46:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_clientes`
--

CREATE TABLE `eventos_clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `eventos_clientes`
--

INSERT INTO `eventos_clientes` (`id`, `event_id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 3, NULL, NULL),
(8, 8, 3, NULL, NULL),
(9, 9, 4, NULL, NULL),
(10, 10, 4, NULL, NULL),
(11, 11, 4, NULL, NULL),
(12, 12, 4, NULL, NULL),
(13, 13, 4, NULL, NULL),
(14, 14, 5, NULL, NULL),
(15, 15, 6, NULL, NULL),
(16, 16, 6, NULL, NULL),
(17, 17, 6, NULL, NULL),
(18, 18, 6, NULL, NULL),
(19, 19, 7, NULL, NULL),
(20, 20, 7, NULL, NULL),
(21, 21, 8, NULL, NULL),
(22, 22, 8, NULL, NULL),
(23, 23, 8, NULL, NULL),
(24, 24, 8, NULL, NULL),
(25, 25, 8, NULL, NULL),
(26, 26, 9, NULL, NULL),
(27, 27, 9, NULL, NULL),
(28, 28, 10, NULL, NULL),
(29, 29, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_users`
--

CREATE TABLE `eventos_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(56, '2014_10_12_000000_create_users_table', 1),
(57, '2014_10_12_100000_create_password_resets_table', 1),
(58, '2019_08_19_000000_create_failed_jobs_table', 1),
(59, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(60, '2022_11_30_175428_create_jobs_table', 1),
(61, '2022_12_18_035041_create_contacts_table', 1),
(62, '2023_11_29_231903_create_permission_tables', 1),
(63, '2025_05_28_131403_create_parents_table', 1),
(64, '2025_05_28_131430_create_eventos_table', 1),
(65, '2025_05_28_131433_create_payments_table', 1),
(66, '2025_05_28_131458_create_tiposdepagos_table', 1),
(67, '2025_05_30_003122_create_tasabcvs_table', 1),
(68, '2025_05_30_120000_create_morosos_table', 1),
(69, '2025_06_05_145052_create_categories_table', 1),
(70, '2025_06_05_145111_create_blogs_table', 1),
(71, '2025_10_28_183753_add_role_to_clientes_table', 1),
(72, '2025_10_30_000253_create_eventos_clientes_table', 1),
(73, '2025_10_30_031120_create_eventos_users_table', 1),
(74, '2025_10_30_032518_add_user_id_to_eventos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(12, 'App\\Models\\Cliente', 1),
(1, 'App\\Models\\User', 1),
(12, 'App\\Models\\Cliente', 2),
(1, 'App\\Models\\User', 2),
(12, 'App\\Models\\Cliente', 3),
(9, 'App\\Models\\User', 3),
(12, 'App\\Models\\Cliente', 4),
(9, 'App\\Models\\User', 4),
(12, 'App\\Models\\Cliente', 5),
(12, 'App\\Models\\Cliente', 6),
(12, 'App\\Models\\Cliente', 7),
(12, 'App\\Models\\Cliente', 8),
(12, 'App\\Models\\Cliente', 9),
(12, 'App\\Models\\Cliente', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `morosos`
--

CREATE TABLE `morosos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `amount_due` double NOT NULL DEFAULT '400',
  `amount_paid` double NOT NULL DEFAULT '0',
  `status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referencia` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_destino` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` double(15,2) NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('APPROVED','PENDING','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `deuda` double NOT NULL DEFAULT '0',
  `monto_pendiente` double NOT NULL DEFAULT '0',
  `status_deuda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'patient_dashboard', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(2, 'admin_dashboard', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(3, 'doctor_dashboard', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(4, 'register_rol', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(5, 'list_rol', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(6, 'edit_rol', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(7, 'delete_rol', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(8, 'settings', 'api', '2025-10-30 13:46:49', '2025-10-30 13:46:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', 'api', '2025-10-30 17:46:49', '2025-10-30 17:46:49'),
(2, 'ADMIN', 'api', '2025-10-30 17:46:49', '2025-10-30 17:46:49'),
(9, 'GUEST', 'api', '2025-10-30 17:46:49', '2025-10-30 17:46:49'),
(10, 'PARTNER', 'api', '2025-10-30 17:46:49', '2025-10-30 17:46:49'),
(11, 'GUEST', 'parent-api', '2025-10-30 13:46:49', '2025-10-30 13:46:49'),
(12, 'CLIENT', 'parent-api', '2025-10-30 13:46:49', '2025-10-30 13:46:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasabcvs`
--

CREATE TABLE `tasabcvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `precio_dia` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposdepagos`
--

CREATE TABLE `tiposdepagos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciorif` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankAccount` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankName` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankAccountType` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tiposdepagos`
--

INSERT INTO `tiposdepagos` (`id`, `tipo`, `ciorif`, `telefono`, `bankAccount`, `bankName`, `bankAccountType`, `email`, `user`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Transferencia Bolívares', NULL, NULL, '01051223345678904', 'mercantil', 'Corriente', NULL, 'das', 'ACTIVE', '2023-10-10 09:32:48', '2023-10-10 10:04:50', NULL),
(2, 'Transferencia Dólares', NULL, NULL, 'ZEL0101010143543', 'BOFA', NULL, 'ddsa', NULL, 'ACTIVE', '2024-01-10 06:07:20', '2024-01-10 06:07:43', NULL),
(3, 'Pago Móvil', '123456', '234567', '253453', 'Mercantil Pago M', NULL, NULL, NULL, 'ACTIVE', '2024-01-16 07:17:12', '2024-01-16 07:17:16', NULL),
(4, 'Pago Móvil', '1223338', '234566777', NULL, 'Provincial', NULL, NULL, NULL, 'ACTIVE', '2024-05-17 09:16:25', '2024-05-17 09:16:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_doc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` timestamp NULL DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User email for login',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hashed password',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'For "remember me" functionality',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `n_doc`, `birth_date`, `gender`, `status`, `mobile`, `telefono`, `address`, `avatar`, `empresa`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super', 'Johnson', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'superadmin@superadmin.com', '2025-10-30 17:46:49', '$2y$10$LPfZ8g9/mI79sqsEQDYXoOkMyOGado/VmeyX35PId65f8FoMpwVdy', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(2, 'admin', 'Johnson', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'admin@admin.com', '2025-10-30 17:46:49', '$2y$10$KXVQpQus68hhWSV21bz8T.fQXJK02kCKg.o.sbuPERWd3G/Bzp4bC', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(3, 'invitado', 'Johnson', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'invitado@invitado.com', '2025-10-30 17:46:49', '$2y$10$OKnMBSlDtVabWEynPJtqmu64MyfawdmgN.xE285wEstbWbtWFdSx2', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL),
(4, 'partner', 'Johnson', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'partner@partner.com', '2025-10-30 17:46:49', '$2y$10$n2CWiCh6rB9BLjVdaU5zx.rQGiUIdrEF2X3OPHwqC1PAT8WkBkaMi', NULL, '2025-10-30 13:46:49', '2025-10-30 13:46:49', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_user_id_foreign` (`user_id`),
  ADD KEY `blogs_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_email_unique` (`email`),
  ADD UNIQUE KEY `clientes_n_doc_unique` (`n_doc`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eventos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `eventos_clientes`
--
ALTER TABLE `eventos_clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eventos_clientes_event_id_client_id_unique` (`event_id`,`client_id`),
  ADD KEY `eventos_clientes_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `eventos_users`
--
ALTER TABLE `eventos_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eventos_users_event_id_user_id_unique` (`event_id`,`user_id`),
  ADD KEY `eventos_users_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `morosos`
--
ALTER TABLE `morosos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `morosos_client_id_event_id_index` (`client_id`,`event_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_event_id_foreign` (`event_id`),
  ADD KEY `payments_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `tasabcvs`
--
ALTER TABLE `tasabcvs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposdepagos`
--
ALTER TABLE `tiposdepagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_n_doc_unique` (`n_doc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `eventos_clientes`
--
ALTER TABLE `eventos_clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `eventos_users`
--
ALTER TABLE `eventos_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `morosos`
--
ALTER TABLE `morosos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tasabcvs`
--
ALTER TABLE `tasabcvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiposdepagos`
--
ALTER TABLE `tiposdepagos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `eventos_clientes`
--
ALTER TABLE `eventos_clientes`
  ADD CONSTRAINT `eventos_clientes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventos_clientes_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `eventos_users`
--
ALTER TABLE `eventos_users`
  ADD CONSTRAINT `eventos_users_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventos_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `eventos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
