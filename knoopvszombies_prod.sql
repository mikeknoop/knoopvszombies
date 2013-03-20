-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2013 at 07:45 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `muzombies_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `gid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `current` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `countdown` tinyint(4) NOT NULL DEFAULT '0',
  `countdown_paused` tinyint(1) NOT NULL DEFAULT '0',
  `registration_open` tinyint(1) NOT NULL DEFAULT '1',
  `oz_hidden` tinyint(1) NOT NULL DEFAULT '1',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `start_time` bigint(20) DEFAULT NULL,
  `end_time` bigint(20) DEFAULT NULL,
  `created` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_xref`
--

CREATE TABLE IF NOT EXISTS `game_xref` (
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `gid` bigint(20) NOT NULL DEFAULT '0',
  `secret` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'human',
  `oz` tinyint(1) NOT NULL DEFAULT '0',
  `oz_pool` tinyint(1) NOT NULL DEFAULT '1',
  `zombie_kills` int(11) NOT NULL DEFAULT '0',
  `zombied_time` bigint(20) NOT NULL DEFAULT '0',
  `zombie_feed_timer` bigint(20) NOT NULL DEFAULT '0',
  `zombie_killed_by` int(11) DEFAULT NULL,
  `old_secret` varchar(500) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `zombied_where_x` varchar(20) DEFAULT NULL,
  `zombied_where_y` varchar(20) DEFAULT NULL,
  `attended_orientation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`gid`),
  KEY `player_id` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hidden_fb_events`
--

CREATE TABLE IF NOT EXISTS `hidden_fb_events` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fb_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hidden_fb_posts`
--

CREATE TABLE IF NOT EXISTS `hidden_fb_posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fb_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `historical`
--

CREATE TABLE IF NOT EXISTS `historical` (
  `uid` bigint(20) NOT NULL,
  `zombie_kills` int(11) NOT NULL DEFAULT '0',
  `time_alive` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orientations`
--

CREATE TABLE IF NOT EXISTS `orientations` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `time` bigint(20) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `lost_pw_hash` varchar(150) DEFAULT NULL,
  `fb_id` bigint(20) DEFAULT NULL,
  `using_fb` tinyint(1) DEFAULT '1',
  `admin` tinyint(1) DEFAULT '0',
  `privileges` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `code_of_conduct` tinyint(1) DEFAULT '0',
  `liability_waiver` varchar(100) DEFAULT NULL,
  `active_game` tinyint(1) DEFAULT '0',
  `active_squad` tinyint(1) DEFAULT '0',
  `squad_name` varchar(30) DEFAULT NULL,
  `created` bigint(20) DEFAULT NULL,
  `email_confirmed` tinyint(1) DEFAULT '0',
  `email_confirm_hash` varchar(100) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `forum_privileges` varchar(50) DEFAULT 'member',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2240 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_approval`
--

CREATE TABLE IF NOT EXISTS `user_approval` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;
