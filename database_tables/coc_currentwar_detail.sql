-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2017 at 10:23 AM
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
-- Table structure for table `coc_currentwar_detail`
--

CREATE TABLE IF NOT EXISTS `coc_currentwar_detail` (
`ID` int(11) NOT NULL,
  `warid` int(11) DEFAULT NULL,
  `MapRank` int(11) DEFAULT NULL,
  `Player_ID` varchar(11) DEFAULT NULL,
  `Player_TH` int(11) NOT NULL DEFAULT '0',
  `Attack_1_Rank` int(11) DEFAULT NULL,
  `Attack_1_Percentage` int(11) DEFAULT NULL,
  `Attack_1_Star` int(11) DEFAULT NULL,
  `Attack_2_Rank` int(11) DEFAULT NULL,
  `Attack_2_Percentage` int(11) DEFAULT NULL,
  `Attack_2_Star` int(11) DEFAULT NULL,
  `Attacked` int(11) DEFAULT NULL,
  `EBA_AttackerRank` int(11) NOT NULL DEFAULT '0',
  `EBA_Destruction` int(11) NOT NULL DEFAULT '0',
  `EBA_Star` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc_currentwar_detail`
--
ALTER TABLE `coc_currentwar_detail`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coc_currentwar_detail`
--
ALTER TABLE `coc_currentwar_detail`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=351;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
