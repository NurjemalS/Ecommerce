-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2022 at 08:45 PM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `consumer_user`
--

DROP TABLE IF EXISTS `consumer_user`;
CREATE TABLE IF NOT EXISTS `consumer_user` (
  `c_email` varchar(100) NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_city` varchar(100) NOT NULL,
  `c_district` varchar(100) NOT NULL,
  `c_address` varchar(100) NOT NULL,
  `c_password` varchar(100) NOT NULL,
  PRIMARY KEY (`c_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `consumer_user`
--

INSERT INTO `consumer_user` (`c_email`, `c_name`, `c_city`, `c_district`, `c_address`, `c_password`) VALUES
('a@gmail.com', 'a', 'a', 'a', 'a', '$2y$10$Ml8XbPRzolrAKFKv/6il5e.x7o9F9GAg5n67kuURVd3dDzl5nGBRK'),
('mal@gmail.com', 'a', 'a', 'a', 'a', '$2y$10$khuewSI1TrnPg0FgdHMevetg58f6.vDBFRXtpDHSeLyCcRoou5bJ2'),
('nurjemal.saryyeva@ug.bilkent.edu.tr', 'Nurjemal SaryyevaZzz', 'Ankara', '&Ccedil;ankaya', 'xxxx', '$2y$10$czu5bs2UWCWZJIzV72LgjO7r0c6t8jBeBBye84PuiOTPllRiOz.7u');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
