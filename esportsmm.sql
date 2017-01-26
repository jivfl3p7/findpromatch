-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2017 at 12:58 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `esportsmm`
--

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentid` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `tournamentid`, `userid`) VALUES
(2, '5', 2),
(3, '5', 6),
(4, '5', 8),
(5, '5', 3),
(6, '6', 8),
(7, '6', 7),
(8, '6', 3),
(9, '6', 5),
(10, '7', 4),
(11, '7', 24),
(12, '7', 10),
(13, '7', 9),
(14, '7', 2),
(15, '7', 8),
(16, '7', 3),
(17, '7', 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `thread_id`, `user_id`, `content`, `post_date`) VALUES
(1, 2, 3, 'testing aj', '2016-12-27 17:32:58'),
(2, 2, 2, 'test test test', '2016-12-03 15:37:37'),
(3, 6, 2, 'test testt test', '2016-12-03 15:43:20'),
(4, 6, 8, 'test test test', '2016-12-03 15:49:30'),
(6, 1, 6, 'Test Test Test Rules', '2016-12-03 16:03:38'),
(7, 7, 6, 'test test test test', '2016-12-04 15:34:47'),
(8, 7, 10, 'test test test', '2016-12-04 15:35:11'),
(9, 16, 6, 'GGWP', '2016-12-27 17:53:13'),
(10, 6, 1, 'GGWP noob\r\n', '2016-12-28 05:48:27'),
(11, 8, 2, 'GLHF', '2016-12-28 05:52:23'),
(12, 17, 8, 'hfhfhfhfhfhf', '2016-12-28 14:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `game` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sent_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `screenshot` varchar(255) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `room_id`, `user_id`, `team_id`, `game`, `category`, `sent_time`, `screenshot`, `accepted`) VALUES
(7, 7, 6, 3, 'csgo', 'mm', '2016-12-27 17:00:00', 'csgo.jpg', 1),
(8, 16, 6, 3, 'dota2', 'mm', '2016-12-27 17:00:00', 'dota.jpg', -1),
(10, 10, 2, 2, 'csgo', 'mm', '2016-12-30 13:53:09', 'space.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `server_name`
--

CREATE TABLE IF NOT EXISTS `server_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `server_name`
--

INSERT INTO `server_name` (`id`, `name`, `ip`) VALUES
(1, 'Server 1', '211.10.5.10:27015'),
(2, 'Server 2', '211.10.5.221:27015'),
(3, 'Server 3', '211.10.5.221:27017');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_team` varchar(50) NOT NULL,
  `exp` int(11) NOT NULL DEFAULT '0',
  `wincsgo` int(11) NOT NULL DEFAULT '0',
  `drawcsgo` int(11) NOT NULL DEFAULT '0',
  `losecsgo` int(11) NOT NULL DEFAULT '0',
  `windota` int(11) NOT NULL DEFAULT '0',
  `losedota` int(11) NOT NULL DEFAULT '0',
  `nickname_1` varchar(50) NOT NULL,
  `nickname_2` varchar(50) NOT NULL,
  `nickname_3` varchar(50) NOT NULL,
  `nickname_4` varchar(50) NOT NULL,
  `nickname_5` varchar(50) NOT NULL,
  `nickname_6` varchar(50) NOT NULL,
  `teamlogo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `nama_team`, `exp`, `wincsgo`, `drawcsgo`, `losecsgo`, `windota`, `losedota`, `nickname_1`, `nickname_2`, `nickname_3`, `nickname_4`, `nickname_5`, `nickname_6`, `teamlogo`) VALUES
(0, 1, 'TBD', 0, 0, 0, 0, 0, 0, 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', 'TBD', ''),
(1, 3, 'Fnatic', 1150, 3, 0, 1, 0, 0, 'twist', 'KRIMZ', 'dennis', 'olofmeister', 'disco doplan', 'N/A', ''),
(2, 2, 'Na''Vi', 4250, 6, 1, 2, 2, 1, 'GuardiaN', 'flamie', 'seized', 's1mple', 'Edward', 'test', ''),
(3, 6, 'NiP', 2100, 4, 0, 6, 0, 0, 'GeT_RiGhT', 'f0rest', 'pyth', 'friberg', 'Xizt', 'maikelele', ''),
(4, 4, 'SK.Gaming', 650, 1, 0, 1, 0, 0, 'FalleN', 'coldzera', 'TACO', 'fnx', 'fer', 'N/A', ''),
(5, 5, 'Virtus.Pro', 1600, 2, 1, 2, 0, 1, 'Snax', 'NEO', 'byali', 'pashabiceps', 'TaZ', 'N/A', ''),
(6, 7, 'Cloud9', 950, 1, 1, 1, 0, 0, 'shroud', 'n0thing', 'autimatic', 'Stewie2K', 'skadoodle', 'N/A', ''),
(12, 8, 'Recca', 1650, 3, 0, 1, 1, 0, 'BnTeT', 'xccurate', 'roseau', 'Sys', 'FrostMisty', 'N/A', ''),
(13, 9, 'TeamABC', 450, 0, 1, 1, 0, 0, 'abc1', 'def1', 'ghi1', 'jkl1', 'mno1', 'pqr1', ''),
(14, 10, 'testXYZ', 1250, 2, 0, 5, 0, 1, 'XYZ', 'ABC', 'DEF', 'GHI', 'JKL', 'N/A', ''),
(15, 24, 'Ninjas in Pyjam', 0, 0, 0, 0, 0, 0, 'fnxxxx', 'frxxxx', 'faxxxx', 'fixxxx', 'foxxxx', 'N/A', '');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL,
  `team_1_id` int(11) NOT NULL,
  `team_2_id` int(11) DEFAULT '0',
  `score_1` int(11) DEFAULT NULL,
  `score_2` int(11) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `finish_time` datetime NOT NULL,
  `map` varchar(50) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `category` varchar(10) NOT NULL,
  `open` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `server_id`, `team_1_id`, `team_2_id`, `score_1`, `score_2`, `screenshot`, `start_time`, `finish_time`, `map`, `status`, `category`, `open`) VALUES
(1, 1, 3, 12, 16, 10, NULL, '2016-10-07 09:58:00', '0000-00-00 00:00:00', 'mirage', 'finished', 'csgo', 1),
(2, 2, 2, 1, 6, 16, 'de_cache0000.jpg', '2016-10-12 06:30:00', '0000-00-00 00:00:00', 'dust2', 'finished', 'csgo', 1),
(3, 3, 4, 1, 16, 6, 'de_cache0000.jpg', '2016-10-05 18:50:00', '0000-00-00 00:00:00', 'nuke', 'finished', 'csgo', 1),
(4, 1, 5, 13, 0, 0, NULL, '2017-01-03 15:31:00', '0000-00-00 00:00:00', 'cobblestone', 'playing', 'csgo', 1),
(6, 1, 12, 2, 16, 14, 'de_cache0000.jpg', '2016-12-04 15:00:00', '0000-00-00 00:00:00', 'dust2', 'finished', 'csgo', 1),
(7, 2, 14, 3, 16, 10, 'csgo.jpg', '2016-12-04 12:30:00', '0000-00-00 00:00:00', 'cobblestone', 'finished', 'csgo', 1),
(8, 1, 3, 2, 0, 0, NULL, '2016-12-30 16:00:00', '0000-00-00 00:00:00', 'overpass', 'playing', 'csgo', 1),
(9, 2, 14, 2, 1, 0, 'de_overpass0000.jpg', '2016-12-02 12:00:00', '0000-00-00 00:00:00', '', 'finished', 'dota2', 1),
(10, 1, 2, 3, 16, 9, 'space.jpg', '2016-12-28 10:17:00', '0000-00-00 00:00:00', 'mirage', 'finished', 'csgo', 1),
(16, 2, 2, 3, 0, 0, 'dota.jpg', '2016-12-27 10:18:00', '0000-00-00 00:00:00', '', 'finished', 'dota2', 1),
(17, 3, 6, 12, 0, 0, NULL, '2017-01-17 15:00:00', '0000-00-00 00:00:00', 'train', 'playing', 'csgo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniqueid` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(20) NOT NULL,
  `participant` int(11) NOT NULL,
  `starttime` datetime NOT NULL,
  `finishtime` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `uniqueid`, `name`, `category`, `participant`, `starttime`, `finishtime`, `description`, `status`, `active`) VALUES
(5, 'hahaha96', 'CS:GO Tournament #10', 'csgo', 4, '2016-12-14 12:00:00', '2016-12-28 12:35:28', '', 'complete', 1),
(6, 'dotamajorpro', 'Dota 2 ProFindMatch #1', 'dota2', 4, '2016-12-31 22:00:00', '2016-12-28 12:28:30', 'Ini Description singkat tentang Dota 2 ProFindMatch #1', 'complete', 1),
(7, 'pfminor1', 'ProFindMatch Minor Tournament #1', 'csgo', 8, '2017-01-02 17:00:00', '2016-12-29 20:18:40', 'ProFindMatch Minor Tournament #1\r\n\r\nRules :\r\n- Bo3 Game\r\n- Map Pool Ban before game\r\n- Send final result screenshot via this page \r\n- Admin will clarify the request', 'complete', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_history`
--

CREATE TABLE IF NOT EXISTS `tournament_history` (
  `historyid` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`historyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tournament_history`
--

INSERT INTO `tournament_history` (`historyid`, `tournamentid`, `userid`, `position`) VALUES
(5, 6, 5, 1),
(6, 6, 3, 3),
(7, 6, 7, 2),
(8, 6, 8, 3),
(9, 5, 2, 2),
(10, 5, 6, 3),
(11, 5, 3, 1),
(12, 5, 8, 3),
(13, 7, 8, 1),
(14, 7, 5, 5),
(15, 7, 4, 3),
(16, 7, 24, 5),
(17, 7, 3, 4),
(18, 7, 9, 5),
(19, 7, 2, 2),
(20, 7, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `team_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phonenumber`, `team_id`, `role`) VALUES
(1, 'winfr', 'winfr', 'admin@gmail.com', '08123456789', 0, 'admin'),
(2, 'navi', 'navi123', 'wnfrx@gmail.com', '01239832742', 2, 'member'),
(3, 'fnatic', 'fnc123', 'indomiegoreng22@gmail.com', '01239832742', 1, 'member'),
(4, 'skgaming', 'sk123', 'sksksksk', '0211313131', 4, 'member'),
(5, 'virtuspro', 'vpvpvp123', 'vpvpvpvp@gmail.com', '0211313131', 5, 'member'),
(6, 'nipgaming', 'nip123', 'nipnipnip', '942834234', 3, 'member'),
(7, 'cloud9', 'cloud9c9', 'cloud9@c9.com', '0124723462', 6, 'member'),
(8, 'reccaindoo', 'recca123', 'win.fr8@gmail.com', '085966724444', 12, 'member'),
(9, 'abcabc', 'password', 'abc.nsx@gmail.com', '0821931931313', 13, 'member'),
(10, 'test1234', 'test1234', 'win.fr@gmail.com', '85912341234', 14, 'member'),
(16, 'hahahaha', 'hahahahahahaha', 'hahaha@g.co', '85912341234', 0, 'member'),
(17, 'hahahahah', 'hahahaha', 'hahaha@g.coc', '0123456789021', 0, 'member'),
(18, 'hehehehe', 'hehehehe', 'hehehe@h.oy', '093435353534', 0, 'member'),
(19, 'hehehehea', 'hehehehe', 'hehehe@h.oya', '093435353534', 0, 'member'),
(20, 'hahahaaa', 'hahahaha', 'aaaaa@h.c', '085966724472', 0, 'member'),
(21, 'aaaaaaaaa', 'aaaaaaaaa', 'aa@dada.gd', '023748332424', 0, 'member'),
(22, 'hahahaaaaa', 'hahahahaha', 'ha@s.cs', '03284242142', 0, 'member'),
(23, 'hahahaas', 'hahahaha', 'haw@f.g', '01234567890213', 0, 'member'),
(24, 'indomiegrg', 'asdasd123', 'indomiegrg22@gmail.com', '081234568203', 15, 'member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
