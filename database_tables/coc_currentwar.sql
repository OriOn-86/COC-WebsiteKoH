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
-- Table structure for table `coc_currentwar`
--

CREATE TABLE IF NOT EXISTS `coc_currentwar` (
`id` int(11) NOT NULL,
  `datewar` date NOT NULL,
  `state` varchar(15) NOT NULL,
  `team_size` int(11) NOT NULL DEFAULT '0',
  `koh_badgeUrl` varchar(55) DEFAULT NULL,
  `koh_clanLevel` int(11) NOT NULL DEFAULT '0',
  `koh_stars` int(11) NOT NULL DEFAULT '0',
  `koh_attacks` int(11) NOT NULL DEFAULT '0',
  `koh_destructionPercentage` float NOT NULL DEFAULT '0',
  `opponent_tag` varchar(15) DEFAULT NULL,
  `opponent_name` varchar(50) NOT NULL,
  `opponent_badgeUrl` varchar(55) DEFAULT NULL,
  `opponent_clanLevel` int(11) NOT NULL DEFAULT '0',
  `opponent_stars` int(11) NOT NULL DEFAULT '0',
  `opponent_attacks` int(11) DEFAULT '0',
  `opponent_destructionPercentage` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc_currentwar`
--
ALTER TABLE `coc_currentwar`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coc_currentwar`
--
ALTER TABLE `coc_currentwar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
