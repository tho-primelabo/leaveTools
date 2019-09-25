-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2019 at 04:57 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jorani`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the user',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'First name',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Last name',
  `login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Identfier used to login (can be an email address)',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email address',
  `password` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Password encrypted with BCRYPT or a similar method',
  `role` int(11) DEFAULT NULL COMMENT 'Role of the employee (binary mask). See table roles.',
  `manager` int(11) DEFAULT NULL COMMENT 'Employee validating the requests of the employee',
  `country` int(11) DEFAULT NULL COMMENT 'Country code (for later use)',
  `organization` int(11) DEFAULT 0 COMMENT 'Entity where the employee has a position',
  `contract` int(11) DEFAULT NULL COMMENT 'Contract of the employee',
  `position` int(11) DEFAULT NULL COMMENT 'Position of the employee',
  `datehired` date DEFAULT NULL COMMENT 'Date hired / Started',
  `identifier` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Internal/company identifier',
  `language` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'Language ISO code',
  `ldap_path` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LDAP Path for complex authentication schemes',
  `active` tinyint(1) DEFAULT 1 COMMENT 'Is user active',
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Timezone of user',
  `calendar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'External Calendar address',
  `random_hash` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Obfuscate public URLs',
  `user_properties` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Entity ID (eg. user id) to which the parameter is applied',
  `picture` blob DEFAULT NULL COMMENT 'Profile picture of user for tabular calendar',
  `annualleave` decimal(11,2) DEFAULT 0.00,
  `telephone` varchar(20) DEFAULT  NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of employees / users having access to Jorani' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `login`, `email`, `password`, `role`, `manager`, `country`, `organization`, `contract`, `position`, `datehired`, `identifier`, `language`, `ldap_path`, `active`, `timezone`, `calendar`, `random_hash`, `user_properties`, `picture`) VALUES
(0, 'Hr Manager', 'Manager', 'hrmanager', 'hrmanager@admin.com', '$2a$08$7eOLRXMAKeBmC6JC9S8.feQrqSUwN5ughbsCPg8plzPbJvt1.cI8W', 25, 1, NULL, 1, 1, 1, '2019-08-28', '', 'en', NULL, 0, 'Europe/Paris', NULL, 'Wp-JjGY8fadzwhxpldudxOo3', NULL, NULL),
(1, 'Admin', 'System', 'admin', 'admin@admin.com', '$2a$08$.RK0wUFvJQZeGK1TRkB7UuuZiuegyJPQvKpToQwokcNvx9Jn0P/j.', 25, 1, NULL, 1, 1, 1, '2019-06-27', 'TOOL0001', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, NULL, NULL, NULL),
(2, 'User', 'System', 'user', 'user@admin.com', '$2a$08$kNQ7R9i5hH1i2avQ9OyAn.saAPRt1SwpCz5qp5c6DDuajovQUVUGi', 2, 5, NULL, 1, 1, 1, '2019-08-28', 'TOOL0002', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'tlqMA6FU2BfrjSvCmc-0J6MN', NULL, NULL),
(3, 'HR', 'System', 'hr', 'hr@admin.com', '$2a$08$i5KC.pAg3JCqsN3.UxqG2uYoCfb26Vnpr7kklMUB3p6h6jhIErnGu', 25, 4, NULL, 1, 1, 1, '2019-08-28', 'TOOL0003', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 't1SAzeWiAS4bUEML_8HHppty', NULL, NULL),
(5, 'General', 'Manager', 'general', 'general@admin.com', '$2a$08$gWgtfbi33TVmm52vrv3koOufFAosx3queIAVO7MdTjIt1T3SeGobq', 32, 5, NULL, 1, 1, 2, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'mMjCOyFIz9UP_hIykxLaZORv', NULL, NULL),
(6, 'Global', 'Manager', 'global', 'global@admin.com', '$2a$08$X1ZAt3dufkmGWqgZokt4geMRkDJPEGuIt7HdmUPv5/pggl1CkbswG', 64, 6, NULL, 0, 1, NULL, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'K_i_sEjoU2HUisaeHA5C3chJ', NULL, NULL),
(7, 'Thanh', 'Bình', 'ltbinh', 'songviytuong@gmail.com', '$2a$08$MZmzVSRAYdM6Gis63qJ9H.954iH74bj7CrgSALsbrwry1F4OAyhS6', 2, 5, NULL, 1, 1, 1, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'NuCcv7-0vPw9d7uriKVctuUM', NULL, NULL),
(8, 'tho', 'LE', 'thole', 'duy.tho@primelabo.com.vn', '$2a$08$/mqpeCdb.wmC3ViUDVE3BOosp4Ur4xQQSZ1E41TPxwMXE/TpteS7.', 25, 5, NULL, 1, 1, NULL, '2019-08-28', '027', 'en', NULL, 1, 'Europe/Paris', NULL, 'D0Me4MvFdJhB9HsTfXHNQS6f', NULL, NULL),
(9, 'Phan', 'DINH', 'pdinh', 'abc@gmail.com', '$2a$08$DdlNbHnyPExSTPd/O.wh8OBVie/YblNh7gmlaK1utPhbIYHQZRF4e', 2, 8, NULL, 1, 1, 1, '2018-11-30', '52', 'en', NULL, 1, 'Europe/Paris', NULL, 'a9pTRcWO_c_fOaVtFwGNUtTy', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `manager` (`manager`) USING BTREE,
  ADD KEY `organization` (`organization`) USING BTREE,
  ADD KEY `contract` (`contract`) USING BTREE,
  ADD KEY `position` (`position`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the user', AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
