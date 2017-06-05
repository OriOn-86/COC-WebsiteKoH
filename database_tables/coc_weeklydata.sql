-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2017 at 10:19 AM
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
-- Table structure for table `coc_weeklydata`
--

CREATE TABLE IF NOT EXISTS `coc_weeklydata` (
`id` int(50) NOT NULL,
  `daterecord` date NOT NULL,
  `player_tag` varchar(12) NOT NULL,
  `name` varchar(50) NOT NULL,
  `townHallLevel` int(11) NOT NULL,
  `bestTrophies` int(11) NOT NULL DEFAULT '0',
  `warStars` int(11) NOT NULL,
  `attackWins` int(11) NOT NULL,
  `defenseWins` int(11) NOT NULL,
  `builderHallLevel` int(11) NOT NULL DEFAULT '0',
  `bestVersusTrophies` int(11) NOT NULL DEFAULT '0',
  `versusBattleWins` int(11) NOT NULL DEFAULT '0',
  `versusBattleWinCount` int(11) NOT NULL DEFAULT '0',
  `Barbarian` int(11) NOT NULL DEFAULT '0',
  `Archer` int(11) NOT NULL DEFAULT '0',
  `Goblin` int(11) NOT NULL DEFAULT '0',
  `Giant` int(11) NOT NULL DEFAULT '0',
  `Wall_Breaker` int(11) NOT NULL DEFAULT '0',
  `Balloon` int(11) NOT NULL DEFAULT '0',
  `Wizard` int(11) NOT NULL DEFAULT '0',
  `Healer` int(11) NOT NULL DEFAULT '0',
  `Dragon` int(11) NOT NULL DEFAULT '0',
  `PEKKA` int(11) NOT NULL DEFAULT '0',
  `Baby_Dragon` int(11) NOT NULL DEFAULT '0',
  `Miner` int(11) NOT NULL DEFAULT '0',
  `Minion` int(11) NOT NULL DEFAULT '0',
  `Hog_Rider` int(11) NOT NULL DEFAULT '0',
  `Valkyrie` int(11) NOT NULL DEFAULT '0',
  `Golem` int(11) NOT NULL DEFAULT '0',
  `Witch` int(11) NOT NULL DEFAULT '0',
  `Lava_Hound` int(11) NOT NULL DEFAULT '0',
  `Bowler` int(11) NOT NULL DEFAULT '0',
  `Raged_Barbarian` int(11) NOT NULL DEFAULT '0',
  `Sneaky_Archer` int(11) NOT NULL DEFAULT '0',
  `Boxer_Giant` int(11) NOT NULL DEFAULT '0',
  `Beta_Minion` int(11) NOT NULL DEFAULT '0',
  `Bomber` int(11) NOT NULL DEFAULT '0',
  `Baby_Dragon2` int(11) NOT NULL DEFAULT '0',
  `Cannon_Cart` int(11) NOT NULL DEFAULT '0',
  `Night_Witch` int(11) NOT NULL DEFAULT '0',
  `Drop_Ship` int(11) NOT NULL DEFAULT '0',
  `Super_PEKKA` int(11) NOT NULL DEFAULT '0',
  `Barbarian_King` int(11) NOT NULL DEFAULT '0',
  `Archer_Queen` int(11) NOT NULL DEFAULT '0',
  `Grand_Warden` int(11) NOT NULL DEFAULT '0',
  `Battle_Machine` int(11) NOT NULL DEFAULT '0',
  `Lightning_Spell` int(11) NOT NULL DEFAULT '0',
  `Healing_Spell` int(11) NOT NULL DEFAULT '0',
  `Rage_Spell` int(11) NOT NULL DEFAULT '0',
  `Jump_Spell` int(11) DEFAULT '0',
  `Freeze_Spell` int(11) NOT NULL DEFAULT '0',
  `Clone_Spell` int(11) NOT NULL DEFAULT '0',
  `Poison_Spell` int(11) NOT NULL DEFAULT '0',
  `Earthquake_Spell` int(11) NOT NULL DEFAULT '0',
  `Haste_Spell` int(11) NOT NULL DEFAULT '0',
  `Skeleton_Spell` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1058 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc_weeklydata`
--
ALTER TABLE `coc_weeklydata`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coc_weeklydata`
--
ALTER TABLE `coc_weeklydata`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1058;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
