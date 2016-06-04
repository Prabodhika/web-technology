-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2016 at 09:51 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `copies` int(10) NOT NULL DEFAULT '0',
  `description` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `copies`, `description`) VALUES
(1, 'Twilight Saga', 'Stephenie Meyer', 5, 'The Twilight Saga is a series of five romance fantasy films from Summit Entertainment.'),
(2, 'Wuthering Heights', 'Emily Bronte', 3, 'Written between October 1845 and June 1846, Wuthering Heights was published in 1847 under the pseudonym "Ellis Bell"'),
(3, 'The Notebook', 'Nicholas Sparks', 1, 'Submit to the sentiment and this is a heart-wrenching romance'),
(4, 'Love Lies', 'Adel Parks', 0, 'Love story based on a true life story'),
(6, 'Eclipse', 'Stephenie Meyer', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `copy`
--

DROP TABLE IF EXISTS `copy`;
CREATE TABLE IF NOT EXISTS `copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(15) NOT NULL,
  `book_id` int(11) NOT NULL,
  `availability` tinyint(4) DEFAULT '1',
  `received_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_number` (`reference_number`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `copy`
--

INSERT INTO `copy` (`id`, `reference_number`, `book_id`, `availability`, `received_at`) VALUES
(1, 'AC4565', 1, 0, '2016-05-05 20:18:30'),
(2, 'AC4889', 2, 1, '2016-05-05 20:24:26'),
(5, 'AL4458', 1, 1, '2016-05-05 20:36:48'),
(6, 'AL4456', 1, 1, '2016-05-05 20:39:58'),
(7, 'AL8895', 1, 1, '2016-05-05 20:40:57'),
(8, 'EI1111', 2, 1, '2016-05-05 23:29:08'),
(9, 'TN0185', 3, 1, '2016-05-06 00:16:31'),
(10, 'WH1120', 2, 0, '2016-05-16 12:06:11'),
(11, 'EC4588', 6, 1, '2016-05-24 04:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

DROP TABLE IF EXISTS `fine`;
CREATE TABLE IF NOT EXISTS `fine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `total_amount` float NOT NULL DEFAULT '0',
  `paid_amount` float NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `paid_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
CREATE TABLE IF NOT EXISTS `loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copy_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `returned` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `copy_id` (`copy_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `copy_id`, `student_id`, `borrow_date`, `return_date`, `received_date`, `returned`) VALUES
(1, 1, 1, '2016-05-05', '2016-05-12', NULL, 0),
(2, 7, 1, '2016-05-20', '2016-05-26', NULL, 0),
(4, 1, 1, '2016-05-13', '2016-05-14', NULL, 0),
(5, 1, 1, '2016-05-13', '2016-05-13', NULL, 0),
(6, 10, 4, '2016-05-16', '2016-05-23', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

DROP TABLE IF EXISTS `reminder`;
CREATE TABLE IF NOT EXISTS `reminder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `reminder_no` int(11) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reminder`
--

INSERT INTO `reminder` (`id`, `loan_id`, `reminder_no`, `sent_at`) VALUES
(1, 1, 1, '2016-05-24 11:55:32'),
(2, 6, 1, '2016-05-24 11:56:16'),
(3, 1, 2, '2016-05-24 11:59:12'),
(4, 2, 1, '2016-05-24 12:03:42'),
(5, 4, 1, '2016-05-24 12:07:58'),
(6, 6, 2, '2016-05-24 12:08:07'),
(7, 1, 3, '2016-05-24 12:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reserved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dismissed` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `book_id`, `student_id`, `reserved_at`, `dismissed`) VALUES
(1, 3, 1, '2016-05-12 20:52:13', 0),
(3, 2, 2, '2016-05-16 11:34:22', 0),
(5, 2, 3, '2016-05-16 12:09:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `class` varchar(10) NOT NULL,
  `registration_number` varchar(15) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `registered_at` timestamp NULL DEFAULT NULL,
  `phone` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_number` (`registration_number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `class`, `registration_number`, `active`, `registered_at`, `phone`) VALUES
(1, 'Erandi', '8C', '2012/0015', 1, '2016-05-01 23:28:13', 717086160),
(2, 'Kasuni', '5A', '2012/0063', 1, '2016-05-02 01:29:44', 771548777),
(3, 'Nilumi', '8', '2012/0018', 1, '2016-05-06 00:11:44', 714545857),
(4, 'Roshan', '8A', '2012/0064', 1, '2016-05-16 12:02:31', 771255689),
(10, 'G.Amal', '4C', '2012/0014', 1, '2016-05-24 06:53:21', 717086164),
(11, 'S.Saman Perera', '6A', '2012/0047', 1, '2016-05-24 06:54:33', 332255785);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `copy`
--
ALTER TABLE `copy`
  ADD CONSTRAINT `copy_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`copy_id`) REFERENCES `copy` (`id`),
  ADD CONSTRAINT `loan_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
