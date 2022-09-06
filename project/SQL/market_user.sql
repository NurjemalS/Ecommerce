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
-- Table structure for table `market_user`
--

DROP TABLE IF EXISTS `market_user`;
CREATE TABLE IF NOT EXISTS `market_user` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_email` varchar(100) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `m_city` varchar(100) NOT NULL,
  `m_district` varchar(100) NOT NULL,
  `m_address` varchar(100) NOT NULL,
  `m_password` varchar(100) NOT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `market_user`
--

INSERT INTO `market_user` (`m_id`, `m_email`, `m_name`, `m_city`, `m_district`, `m_address`, `m_password`) VALUES
(2, 'saryyevanurjemal@gmail.com', 'Nurjemal Saryyeva', 'Ankara', '&Ccedil;ankaya', 'Bilkent University, Main Campus', '$2y$10$6vQ7X1ZdongPyRHDlEJMIOqp4rfahpiYN4L5V5LaEeByYV/3NAyya'),
(4, 'cankaya@gmail.com', '&Ccedil;ankaya S&uuml;permarkett', 'Ankara', '&Ccedil;ankaya', '&Ccedil;ankaya Mahallesi Şehit Ersen Cad. &amp;, And Sk. 6/20', '$2y$10$sw2tKK/DsUXk2uQYwnUI5eN/me9Q9kicpFek081aMQP6Qo5GuGOG.'),
(5, 'gecitmarket@gmail.com', 'Geçit Market', 'İzmir', 'Konak', 'Mimar Sinan, Geçit Market, Yzb. Şerafettin Bey Sk. no: 43 D:1', '$2y$10$2n.1Vk.kVuA0GbL4.vH6eO/90M8GWUXZzbaPrlG4a7cV9n5WOIgRi'),
(6, 'isiklarsupermini@gmail.com', 'Işıklar S&uuml;per Market', 'Ankara', 'Etimesgut', 'Şeyh Şamil, 3. Etap İş Merkezi D:13, 06824', '$2y$10$175XXG2t0HlA/ozyN4Y6DuJ7X.0HgypDzPzD2gxVNAnOVzBb8lKXO'),
(7, 'parkmarket@gmail.com', 'Park Market', 'İzmir', 'Konak', 'Kılıç Reis, 320/1. Sk. No:4', '$2y$10$kN0QBn/4Qxlxj8l5TEtkHO2yyuvxQ4.XcxOOhNzSw3otuIgituPk2'),
(8, 'uyum@gmail.com', 'Uyum Market', 'Ankara', '&Ccedil;ankaya', 'Çankaya, Üsküp Cd. No:30', '$2y$10$Ueprwnfs.bC3FeubH1l4y.ZG64erhf1clxohqV/FQnKE7POjuFZlq'),
(9, 'yeniyurtseven@gmail.com', 'Yeni Yurtseven Market', 'Ankara', 'Etimesgut', 'Tunahan, 2130. Sk. No:6, 06790', '$2y$10$BfbSuN.3W2d4NAgul9jTr.vVTmAJ8MuuQqT0bYDAXThltbZcqzZ96'),
(10, 'yigitler@gmail.com', 'Yiğitler Market', 'Ankara', '&Ccedil;ankaya', 'Büyükesat, Çankaya/Ankara, Türkiye, Uğur Mumcu Cd. No:103 D:A', '$2y$10$agd07Hz49q8MdqBWSGvasOfh/JOijF.yXv.t6Jhxl2CTo9Mv8k/vS'),
(26, 'nurjemal.saryyeva@ug.bilkent.edu.tr', 'aaaaaaaaa', 'a', 'a', 'a', '$2y$10$ffhSe6wlcZJ8B8YQ6Dx/LeYt53kNsN3dtl42t/yrxUukr5MnvOFu2'),
(27, 'nurjemal.saryyeva@ug.bilkent.edu.tr', 'aaaaaaaaa', 'a', 'a', 'a', '$2y$10$ffhSe6wlcZJ8B8YQ6Dx/LeYt53kNsN3dtl42t/yrxUukr5MnvOFu2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
