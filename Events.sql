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
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
  `EID` smallint(6) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `URL` varchar(100) NOT NULL,
  `CalendarDate` datetime NOT NULL,
  `Keywords` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`EID`, `Title`, `Description`, `URL`, `CalendarDate`, `Keywords`) VALUES
(18, 'New Friends', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2021-06-23 15:30:00', 'event, fun, social, unprotected victims'),
(2, 'Finding Your Voice', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp3.png', '2021-06-16 00:00:00', 'unprotected'),
(19, 'Discover the World', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2022-02-25 19:00:00', 'friends, protection, understanding'),
(3, 'Road to Happiness', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp2.png', '2021-06-08 00:00:00', 'family, peace, happiness'),
(4, 'Looking to the Future', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2021-08-11 13:00:00', 'jail, police, mental health'),
(5, 'Living by A Prayer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2021-06-23 15:30:00', 'religion, family, hope'),
(11, 'Understanding Religion', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2022-02-25 19:00:00', 'religion, respect'),
(17, 'Future to You', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2021-08-11 13:00:00', 'church, freedom'),
(7, 'Find a Friend', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp1.png', '2021-05-31 00:00:00', 'friends, protection'),
(29, 'Exercise Time', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2022-02-25 19:00:00', 'safety, exercise'),
(31, 'Meet Your Mentor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum, augue eget suscipit bibendum, leo nunc auctor lorem, eu convallis felis nulla id eros. Suspendisse potenti. Integer quam est, bibendum eget vulputate pulvinar, consequat sit amet magna. Phasellus nec mauris est. Aliquam consectetur et est quis aliquet. Donec sit amet massa velit. Duis finibus lobortis libero ut bibendum. Integer vitae maximus urna, a varius eros.', 'images/temp.jpg', '2022-02-25 19:00:00', 'friends, protection, understanding');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `EID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
