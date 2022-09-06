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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `market` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `normal_price` double NOT NULL,
  `discounted_price` double NOT NULL,
  `ex_date` date NOT NULL,
  `ex_img` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`PID`),
  KEY `market` (`market`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PID`, `market`, `title`, `stock`, `normal_price`, `discounted_price`, `ex_date`, `ex_img`) VALUES
(85, 'gecitmarket@gmail.com', 'Canned Tuna', 20, 45, 30, '2022-10-01', '88c37c9fd4eaa4ce1d22b3753516c327a03e42c1.jpg'),
(84, 'gecitmarket@gmail.com', 'Egg', 200, 3, 2, '2022-05-30', 'be9a5b2815225741db74805f29ddcf1e27861c2b.jpg'),
(35, 'gecitmarket@gmail.com', 'Chestnut', 45, 49.99, 44.99, '2022-05-28', 'best-before-date.jpg'),
(71, 'isiklarsupermini@gmail.com', 'Canned Tuna', 25, 45, 32, '2022-07-01', '1d76f5b6e85dcf5a8c9e62b6f641aa5c86a44e4a.jpg'),
(37, 'isiklarsupermini@gmail.com', 'Sütaş Milk', 95, 9.99, 7.99, '2022-05-16', 'download.jpg'),
(38, 'isiklarsupermini@gmail.com', 'S&uuml;taş Cheese', 95, 9.99, 7.99, '2022-05-18', '7fb623c5b55938bf28a659d7592c7bf4946bf225.jpg'),
(88, 'parkmarket@gmail.com', 'Mayonnaise', 75, 20, 15, '2018-03-27', 'ac70a2222f8bcac65f0946717f9ed01a8d2f60f4.jpg'),
(41, 'uyum@gmail.com', 'Sütaş Yoghurt', 100, 49.99, 47.99, '2022-07-23', 'istockphoto-464753338-612x612.jpg'),
(42, 'uyum@gmail.com', 'İçim Kefir', 100, 19.99, 15.99, '2022-07-22', 'download.jpg'),
(43, 'uyum@gmail.com', 'Untad Bread', 100, 9.99, 5.99, '2022-08-02', 'images.jpg'),
(80, 'yeniyurtseven@gmail.com', 'Pasta', 60, 50, 40, '2022-07-02', '7e496ae679db901921fbeb964534909356adb36d.jpg'),
(45, 'yeniyurtseven@gmail.com', 'Lentil', 150, 12.99, 9.99, '2022-05-15', 'istockphoto-464753338-612x612.jpg'),
(46, 'yigitler@gmail.com', 'Meatballs', 45, 44.99, 34.99, '2022-05-22', 'best-before-date.jpg'),
(72, 'cankaya@gmail.com', 'Mainland Butter', 11, 50, 30, '2022-09-14', 'feb3bb5b20aa63f030ff228f29ced5e6eb92aefd.jpg'),
(49, 'cankaya@gmail.com', 'Milk', 98, 13.99, 10.99, '2022-05-25', 'download.jpg'),
(86, 'gecitmarket@gmail.com', 'Kefir', 20, 20, 10, '2017-07-13', 'b575682005de62ddddc65d23578fcc03646afb0f.jpg'),
(87, 'gecitmarket@gmail.com', 'Peache Juice', 50, 35, 20, '2020-06-12', 'ff0a5e286884e627d7e1c44813e3fbb5942c62a6.jpg'),
(83, 'yeniyurtseven@gmail.com', 'Canned Pea', 150, 45, 35, '2017-09-04', '9671c783b36e680ebd9ac310b71751486c64ac81.jpg'),
(73, 'cankaya@gmail.com', 'Ada Sugar_sugar', 55, 35, 25, '2020-06-01', '8a9592ce0e3870389d7de3b26f65c74e1dae3a99.jpg'),
(74, 'cankaya@gmail.com', 'Algida Icecream', 150, 70, 65, '2022-06-15', '4a78e632a402052baf87269ec59da3e4a07a14b1.jpg'),
(77, 'yigitler@gmail.com', 'Nestle  Cornflakes', 65, 25, 10, '2020-01-15', '300a466ef4150fe4ad905a954e0f1c1e238d4cee.jpg'),
(103, 'isiklarsupermini@gmail.com', 'Biscuit', 15, 10, 5, '2022-05-31', '90aca9a64b02c99198cd0eddd1179c2c3ba42508.jpg'),
(79, 'yigitler@gmail.com', 'Canned Tuna', 80, 45, 5, '2022-01-05', '046955d1e85613db98fa4d0d417ef74609cbf969.jpg'),
(81, 'yeniyurtseven@gmail.com', 'Cream Cheese', 25, 80, 70, '2022-02-10', '808c4009986fe71474b4b098180ebecaa788de8c.jpg'),
(68, 'isiklarsupermini@gmail.com', '&Ccedil;eliktepe Butter', 12, 50, 35, '2020-12-18', 'edf33257682c8d3570219b8cfb4f190280b948ad.jpg'),
(69, 'isiklarsupermini@gmail.com', 'Uzman Kasap Veal Cubes', 20, 250, 150, '2021-01-14', '0729355c7c91cbac4e66dc1c2de4c65b9f036264.jpg'),
(70, 'isiklarsupermini@gmail.com', 'A Yogurt', 11, 20, 15, '2022-06-20', 'bd477a72b5468a374546fe60b8d9fa6558e5e5f7.jpg'),
(82, 'yeniyurtseven@gmail.com', 'Dried Fruit', 60, 40, 30, '2009-02-09', '7311d163d258fbd012c4585689e7392cc29475a8.jpg'),
(89, 'parkmarket@gmail.com', 'Mustard', 150, 30, 10, '2020-09-24', 'dff3906b6e3ef1a304619f04ce2213e40e6aff30.jpg'),
(90, 'parkmarket@gmail.com', 'Cream Cheese', 70, 55, 40, '2021-06-05', 'c81b55416640665999223f3fdfddef786fed740f.jpg'),
(91, 'parkmarket@gmail.com', 'Egg', 300, 3, 1, '2020-05-03', '43c4f12541f2ff33fe0917acfedab298bfde9dd5.jpg'),
(92, 'parkmarket@gmail.com', 'Peach Juice', 50, 40, 30, '2022-01-30', 'd26840123f2ce93b4e0f5997ae346041db328c28.jpg'),
(93, 'parkmarket@gmail.com', 'Yogurt', 30, 20, 10, '2022-06-10', '8e214db7b98da85efec63ef4ecd5fd48142b0c31.jpg'),
(94, 'uyum@gmail.com', 'Organic Milks', 25, 18, 10, '2021-05-20', '4b2f30bc257f9212122bdfde2c4f9b8fdbc3be3f.jpg'),
(96, 'uyum@gmail.com', 'Mayonnaise', 30, 20, 10, '2022-06-30', 'bbf2d0d8c694baee3f37aa2b3515184bc91bbd54.jpg'),
(100, 'uyum@gmail.com', 'Milk', 70, 15, 10, '2022-04-30', '728edf224148a84af867cb0af5b05038a0d7f413.jpg'),
(101, 'uyum@gmail.com', 'S&uuml;taş Kefir', 20, 20, 10, '2022-03-25', 'f2a49bd0a00bd32172c6743a03076f5421a579f4.jpg'),
(102, 'cankaya@gmail.com', 'Pınar Milk', 13, 15, 10, '2022-05-08', '1e49257bd42417bd582020cad4edd4eaa5650c81.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
