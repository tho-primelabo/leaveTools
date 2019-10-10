-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2019 at 08:26 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

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
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_basic` varchar(10) NOT NULL,
  `social_insurance` varchar(10) NOT NULL,
  `salary_net` varchar(10) NOT NULL,
  `health_insurance` varchar(10) NOT NULL,
  `peson_tax_payer` varchar(10) NOT NULL,
  `unEmployment_insurance` varchar(10) NOT NULL,
  `taxable_incom` varchar(10) NOT NULL,
  `salary_overtime` varchar(10) NOT NULL,
  `personal_income_tax` varchar(10) NOT NULL,
  `income_before_tax` varchar(10) NOT NULL,
  `salary_other` varchar(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `employee_id`, `salary_basic`, `social_insurance`, `salary_net`, `health_insurance`, `peson_tax_payer`, `unEmployment_insurance`, `taxable_incom`, `salary_overtime`, `personal_income_tax`, `income_before_tax`, `salary_other`, `date`) VALUES
(4, 1, '12000000', '960000', '10653000', '180000', '0', '120000', '1740000', '0', '87000', '10740000', '0', '2019-10-08'),
(5, 2, '20000000', '1600000', '17620000', '300000', '3600000', '200000', '5300000', '0', '280000', '17900000', '0', '2019-10-08'),
(6, 9, '28500000', '2280000', '23781375', '427500', '0', '285000', '16507500', '0', '1726125', '25507500', '0', '2019-10-09'),
(7, 7, '17000000', '1360000', '15084250', '255000', '3600000', '170000', '2615000', '0', '130750', '15215000', '0', '2019-10-08'),
(8, 10, '17000000', '1360000', '15084250', '255000', '3600000', '170000', '2615000', '0', '130750', '15215000', '0', '2019-10-08'),
(9, 8, '20000000', '1600000', '17260000', '300000', '0', '200000', '8900000', '0', '640000', '17900000', '0', '2019-10-08'),
(10, 6, '11500000', '920000', '10227875', '172500', '0', '115000', '1292500', '0', '64625', '10292500', '0', '2019-10-09'),
(16, 4, '20000000', '1600000', '17260000', '300000', '0', '200000', '8900000', '0', '640000', '17900000', '0', '2019-10-09'),
(17, 4, '15000000', '1200000', '13383750', '225000', '3600000', '150000', '825000', '0', '41250', '13425000', '0', '2019-12-09'),
(18, 3, '19000000', '1520000', '16964750', '285000', '7200000', '190000', '805000', '0', '40250', '17005000', '0', '2019-10-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`,`employee_id`,`date`),
  ADD KEY `salary_ibfk_1` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
