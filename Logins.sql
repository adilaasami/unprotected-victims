-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2021 at 04:18 AM
-- Server version: 5.7.34
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `irkutacl_4321`
--

-- --------------------------------------------------------

--
-- Table structure for table `Logins`
--

CREATE TABLE `Logins` (
  `AID` tinyint(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Logins`
--

INSERT INTO `Logins` (`AID`, `email`, `password`) VALUES
(14, 'testing@testing.com', '$2y$10$G3vts3o6XBNcjlh3snWh2uK9L6WA1/zzoPJ0BzmsYTRz.DP9SwJZ2'),
(6, 'test@gmail.com', '$2y$10$UJSN2xEB1NH0sMZdpQw3Xu3sw/IOvczg5ZJMHAdUQEGkoDua8M8xy'),
(13, 'ikolodny@Yahoo.com', '$2y$10$R1Syx0Pr6ORRDV5jYIMu6uZZmSmmbolTgfT8KLa8TClVDTsFKmpQq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Logins`
--
ALTER TABLE `Logins`
  ADD PRIMARY KEY (`AID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Logins`
--
ALTER TABLE `Logins`
  MODIFY `AID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
