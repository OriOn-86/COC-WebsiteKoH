-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2017 at 08:08 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

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
-- Table structure for table `coc_wars_detail`
--

CREATE TABLE IF NOT EXISTS `coc_wars_detail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `warid` int(11) NOT NULL DEFAULT '0',
  `MapRank` int(11) NOT NULL DEFAULT '0',
  `Player_ID` varchar(11) NOT NULL,
  `Player_TH` int(11) NOT NULL DEFAULT '0',
  `Attack_1_Rank` int(11) NOT NULL DEFAULT '0',
  `Attack_1_Percentage` float NOT NULL DEFAULT '0',
  `Attack_1_Star` int(11) NOT NULL DEFAULT '0',
  `Attack_1_Order` int(11) NOT NULL,
  `Attack_2_Rank` int(11) NOT NULL DEFAULT '0',
  `Attack_2_Percentage` float NOT NULL DEFAULT '0',
  `Attack_2_Star` int(11) NOT NULL DEFAULT '0',
  `Attack_2_Order` int(11) NOT NULL,
  `Effective_Star` int(11) NOT NULL,
  `Attacked` int(11) NOT NULL DEFAULT '0',
  `EBA_AttackerRank` int(11) NOT NULL DEFAULT '0',
  `EBA_Destruction` float NOT NULL DEFAULT '0',
  `EBA_Star` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
