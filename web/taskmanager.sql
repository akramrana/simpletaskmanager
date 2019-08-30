-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 30, 2019 at 01:28 PM
-- Server version: 5.7.27-log
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(50) CHARACTER SET cp1251 COLLATE cp1251_general_cs NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `phone`, `created_at`, `updated_at`, `is_active`, `is_deleted`) VALUES
(1, 'Akram', 'akram.hossain@lezasolutions.net', '$2y$13$NLUyTU3ao1Oeuw5A1P21Mes1uyLqNIr2eubD3iCgIQLn418fxttIO', '12341234', '2019-08-25 09:59:15', '2019-08-25 09:59:15', 1, 0),
(2, 'Rana', 'rana@gmail.com', '$2y$13$K1yDsq5vT.6D656f.f5bVeKm4m3HIp2t24aouZFwcR7tTFJpv82/C', '14782563', '2019-08-25 10:01:58', '2019-08-25 10:02:03', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `points` int(11) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `parent_id`, `user_id`, `title`, `points`, `is_done`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Task 1', 10, 1, '2019-08-26 17:57:09', '2019-08-26 17:57:09'),
(2, NULL, 2, 'Task 2', 15, 1, '2019-08-26 17:57:53', '2019-08-26 17:57:53'),
(3, 2, 2, 'Task 2.1', 3, 1, '2019-08-26 18:14:24', '2019-08-26 18:14:24'),
(4, 2, 2, 'Task 2.2', 3, 1, '2019-08-26 18:17:21', '2019-08-26 18:17:21'),
(5, 2, 2, 'Task 2.3', 3, 1, '2019-08-26 18:23:17', '2019-08-26 18:23:17'),
(6, 2, 2, 'Task 2.4', 3, 1, '2019-08-26 18:23:21', '2019-08-26 18:23:21'),
(9, 2, 2, 'Task 2.5', 2, 1, '2019-08-26 18:28:57', '2019-08-26 18:28:57'),
(10, NULL, 4, 'Task 1', 9, 1, '2019-08-28 17:51:16', '2019-08-28 17:54:53'),
(11, 10, 4, 'Task 3.1', 7, 1, '2019-08-28 17:51:57', '2019-08-28 17:56:02'),
(12, 10, 4, 'Task 3.2', 2, 1, '2019-08-28 17:52:12', '2019-08-28 17:52:12'),
(13, 12, 4, 'Task 3.2.1', 2, 1, '2019-08-30 05:13:39', '2019-08-30 05:13:39'),
(14, 13, 4, 'Task 3.2.1.1', 2, 1, '2019-08-30 05:20:57', '2019-08-30 05:20:57'),
(15, 9, 2, 'Task 2.1.1', 2, 1, '2019-08-30 05:37:47', '2019-08-30 05:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'John', 'Boe', 'john.boe@email.com', '2020-01-01 00:00:00', '2020-01-01 00:00:00', 0),
(2, 'John', 'Toe', 'john.toe@email.com', '2020-02-01 00:00:00', '2020-02-01 00:00:00', 0),
(3, 'John', 'Koe', 'john.koe@email.com', '2020-03-01 00:00:00', '2020-03-01 00:00:00', 0),
(4, 'John', 'Soe', 'john.soe@email.com', '2020-04-01 00:00:00', '2020-04-01 00:00:00', 0),
(5, 'John', 'Loe', 'john.loe@email.com', '2020-05-01 00:00:00', '2020-05-01 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tasks_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
