-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2017 at 10:22 AM
-- Server version: 5.5.50-0+deb8u1
-- PHP Version: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clashofclans`
--

-- --------------------------------------------------------

--
-- Table structure for table `coc_dailydata`
--

CREATE TABLE IF NOT EXISTS `coc_dailydata` (
`ID` int(50) NOT NULL,
  `date` date NOT NULL,
  `player_tag` varchar(12) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expLevel` int(11) NOT NULL,
  `league` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `trophies` int(11) NOT NULL,
  `versusTrophies` int(11) NOT NULL,
  `clanRank` int(11) NOT NULL,
  `previousClanRank` int(11) NOT NULL,
  `donations` int(11) NOT NULL,
  `donationsReceived` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17300 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc_dailydata`
--
ALTER TABLE `coc_dailydata`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coc_dailydata`
--
ALTER TABLE `coc_dailydata`
MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17300;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
