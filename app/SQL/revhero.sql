-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2013 at 01:56 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `revhero`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_clicks`
--

CREATE TABLE IF NOT EXISTS `ad_clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_detail_id` int(11) NOT NULL,
  `placement_id` int(11) NOT NULL,
  `user_ip_address` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_details`
--

CREATE TABLE IF NOT EXISTS `ad_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advertiser_id` int(11) NOT NULL,
  `headline` varchar(200) NOT NULL,
  `body` varchar(255) NOT NULL,
  `dest_url` varchar(255) NOT NULL,
  `CPC` float NOT NULL,
  `CPA` float NOT NULL,
  `ad_image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `approved_date` datetime NOT NULL,
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '0 - Pending, 1 - approved, 2 - Rejected',
  `is_active` int(4) NOT NULL DEFAULT '1' COMMENT '0 - Disabled, 1 - Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_tags`
--

CREATE TABLE IF NOT EXISTS `ad_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE IF NOT EXISTS `placements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publisher_id` int(11) NOT NULL,
  `ad_detail_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `type` varchar(45) NOT NULL,
  `format` varchar(45) NOT NULL,
  `short_url` varchar(255) DEFAULT NULL,
  `creator_ip_address` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE IF NOT EXISTS `promo_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promocode` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `validFrom` date NOT NULL,
  `validTo` date NOT NULL,
  `status` int(3) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `promo_users`
--

CREATE TABLE IF NOT EXISTS `promo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `prof_image` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
