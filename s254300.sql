-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 10:55 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s254300`
--

CREATE DATABASE IF NOT EXISTS `s254300` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `s254300`;

-- ---------------------------------------------------------- --------------------------------------------------------
--
-- Removing Tables
--
DROP TABLE IF EXISTS `reservations`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `stops`;

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `email` varchar(36) NOT NULL,
  `dep` varchar(36) NOT NULL,
  `dest` varchar(36) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`email`, `dep`, `dest`, `number`) VALUES
('u1@p.it', 'FF', 'KK', 4),
('u2@p.it', 'BB', 'EE', 1),
('u3@p.it', 'DD', 'EE', 1),
('u4@p.it', 'AL', 'DD', 1);


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(36) NOT NULL,
  `password` char(128) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`) VALUES
('u1@p.it', '2439a64be91a99151f6cf065c422d3a4253dd9d3684a5baf1552d35ab93ed348b5093df547202117310369867474a7b8aa4452b6fd278ec342204eaddfe01888'),
('u2@p.it', '6352f1fcc8610fde1d8eb5a3f46dd9daea28c5d46b268b11d2725ff965dfdb70a1d737d21bd61d1f93c4c811a4fdb57d6208e4a1a6c79e986ca54b85f56087a0'),
('u3@p.it', 'e00c24b1de4888901cb2b131d2173f93f90a37ec5dfc910e2322c18921979bbcca1b7df2644c92e5181885504d70402db7395fa158811df74632e33055769bd6'),
('u4@p.it', '035b9208bf3867d5acd74fc15dcb249ee1e7bfcd4d0a2a0e3a3de58bd5f4bb763da483626e31f60d81a55528e2990dd05fd004db284bc7be17d0cdb4769e3434');
-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE `stops` (
  `name` varchar(36) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` (`name`) VALUES
('AL'),
('BB'),
('DD'),
('EE'),
('FF'),
('KK');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
