-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2012 at 08:16 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vertex`
--

-- --------------------------------------------------------

--
-- Table structure for table `#__assets`
--

DROP TABLE IF EXISTS `#__assets`;
CREATE TABLE IF NOT EXISTS `#__assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `#__assets`
--

INSERT INTO `#__assets` (`id`, `parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES
(1, 0, 1, 414, 0, 'root.1', 'Root Asset', '{"core.login.site":{"6":1,"2":1},"core.login.admin":{"6":1},"core.login.offline":[],"core.admin":{"8":1},"core.manage":{"7":1},"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1},"core.edit.own":{"6":1,"3":1}}'),
(2, 1, 1, 2, 1, 'com_admin', 'com_admin', '{}'),
(3, 1, 3, 6, 1, 'com_banners', 'com_banners', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(4, 1, 7, 8, 1, 'com_cache', 'com_cache', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(5, 1, 9, 10, 1, 'com_checkin', 'com_checkin', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(6, 1, 11, 12, 1, 'com_config', 'com_config', '{}'),
(7, 1, 13, 16, 1, 'com_contact', 'com_contact', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(8, 1, 17, 20, 1, 'com_content', 'com_content', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}'),
(9, 1, 21, 22, 1, 'com_cpanel', 'com_cpanel', '{}'),
(10, 1, 23, 24, 1, 'com_installer', 'com_installer', '{"core.admin":{"7":1},"core.manage":{"7":1},"core.delete":[],"core.edit.state":[]}'),
(11, 1, 25, 26, 1, 'com_languages', 'com_languages', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(12, 1, 27, 28, 1, 'com_login', 'com_login', '{}'),
(13, 1, 29, 30, 1, 'com_mailto', 'com_mailto', '{}'),
(14, 1, 31, 32, 1, 'com_massmail', 'com_massmail', '{}'),
(15, 1, 33, 34, 1, 'com_media', 'com_media', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":{"5":1}}'),
(16, 1, 35, 36, 1, 'com_menus', 'com_menus', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(17, 1, 37, 38, 1, 'com_messages', 'com_messages', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(18, 1, 39, 40, 1, 'com_modules', 'com_modules', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(19, 1, 41, 44, 1, 'com_newsfeeds', 'com_newsfeeds', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(20, 1, 45, 46, 1, 'com_plugins', 'com_plugins', '{"core.admin":{"7":1},"core.manage":[],"core.edit":[],"core.edit.state":[]}'),
(21, 1, 47, 48, 1, 'com_redirect', 'com_redirect', '{"core.admin":{"7":1},"core.manage":[]}'),
(22, 1, 49, 50, 1, 'com_search', 'com_search', '{"core.admin":{"7":1},"core.manage":{"6":1}}'),
(23, 1, 51, 52, 1, 'com_templates', 'com_templates', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(24, 1, 53, 54, 1, 'com_users', 'com_users', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.own":{"6":1},"core.edit.state":[]}'),
(25, 1, 55, 58, 1, 'com_weblinks', 'com_weblinks', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}'),
(26, 1, 59, 60, 1, 'com_wrapper', 'com_wrapper', '{}'),
(27, 8, 18, 19, 2, 'com_content.category.2', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(28, 3, 4, 5, 2, 'com_banners.category.3', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(29, 7, 14, 15, 2, 'com_contact.category.4', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(30, 19, 42, 43, 2, 'com_newsfeeds.category.5', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(31, 25, 56, 57, 2, 'com_weblinks.category.6', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(32, 0, 415, 416, 0, 'com_content.category.7', 'News', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(33, 0, 417, 434, 0, 'com_content.category.8', 'Latest', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(34, 0, 435, 436, 0, 'com_content.category.9', 'Newsflash', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(35, 0, 437, 444, 0, 'com_content.category.10', 'Frontpage newsflash', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(36, 0, 445, 446, 0, 'com_content.category.11', 'FAQs', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(37, 0, 447, 448, 0, 'com_content.category.12', 'New to Joomla!', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(38, 0, 449, 450, 0, 'com_content.category.13', 'Current Users', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(39, 0, 451, 452, 0, 'com_content.category.14', 'General', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(40, 0, 453, 454, 0, 'com_content.category.15', 'Languages', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(41, 0, 455, 456, 0, 'com_content.category.16', 'About Joomla!', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(42, 0, 457, 458, 0, 'com_content.category.17', 'The Project', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(43, 0, 459, 460, 0, 'com_content.category.18', 'The CMS', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(44, 0, 461, 462, 0, 'com_content.category.19', 'The Community', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(45, 0, 463, 472, 0, 'com_content.category.20', 'Frontpage', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(46, 0, 473, 480, 0, 'com_content.category.21', 'Frontpage', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(47, 0, 481, 482, 0, 'com_content.category.22', 'Featured News', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(48, 0, 483, 484, 0, 'com_content.category.23', 'Featured News', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(49, 33, 424, 425, 1, 'com_content.article.12', 'Typography Options', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(50, 33, 418, 419, 1, 'com_content.article.13', 'S5 Flex Menu - Menu System', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(51, 33, 430, 431, 1, 'com_content.article.14', 'Module Positions and Styles', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(52, 0, 485, 486, 0, 'com_content.article.17', 'Installing The Template', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(53, 0, 487, 488, 0, 'com_content.article.18', 'The Templates Settings', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(54, 0, 489, 490, 0, 'com_content.article.24', 'Page, Column and Row Widths', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(55, 33, 426, 427, 1, 'com_content.article.36', 'How To Setup the Search Box and Menus', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(56, 0, 491, 492, 0, 'com_content.article.37', 'Tool Tips Setup', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(57, 33, 432, 433, 1, 'com_content.article.39', 'Site Shapers', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(58, 0, 493, 494, 0, 'com_content.article.97', 'Shape 5 Tab Show', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(59, 0, 495, 496, 0, 'com_content.article.110', 'Shape 5 CSS and JS Compressor Plugin', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(60, 0, 497, 498, 0, 'com_content.article.143', 'S5 Accordion Menu', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(61, 33, 428, 429, 1, 'com_content.article.146', 'Login and Register Setup', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(62, 0, 499, 500, 0, 'com_content.article.173', 'Search Engine Optimized ', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(63, 0, 501, 502, 0, 'com_content.article.195', 'Multibox Setup Tutorial', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(64, 33, 422, 423, 1, 'com_content.article.197', 'Template Specific Options', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(65, 0, 503, 504, 0, 'com_content.article.204', 'Google Fonts Enabled', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(66, 0, 505, 506, 0, 'com_content.article.208', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(67, 0, 507, 508, 0, 'com_content.article.211', 'Mobile Device Ready!', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(68, 0, 509, 510, 0, 'com_content.article.212', 'CSS Tableless Overrides', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(69, 0, 511, 512, 0, 'com_content.article.214', 'Fixed Side Tabs', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(70, 0, 513, 514, 0, 'com_content.article.227', 'Menu Scroll To Section', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(71, 0, 515, 516, 0, 'com_content.article.228', 'IE7 and 8 CSS3 Support', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(72, 0, 517, 518, 0, 'com_content.article.230', 'Lazy Load Images', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(73, 0, 519, 520, 0, 'com_content.article.231', 'Hide Article Component Area', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(74, 0, 521, 522, 0, 'com_content.article.233', 'S5 Drop Down Panel', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(75, 0, 523, 524, 0, 'com_content.article.234', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(76, 0, 525, 526, 0, 'com_content.article.235', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(77, 0, 527, 528, 0, 'com_content.article.236', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(78, 0, 529, 530, 0, 'com_content.article.237', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(79, 0, 531, 532, 0, 'com_content.article.242', 'Sample Article', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(80, 35, 442, 443, 1, 'com_content.article.243', 'Newsflash Article 3', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(81, 35, 440, 441, 1, 'com_content.article.244', 'Newsflash Article 2', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(82, 35, 438, 439, 1, 'com_content.article.245', 'Newsflash Article 1', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(83, 46, 474, 475, 1, 'com_content.article.246', 'Muse Takes To The Stage in London', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(84, 46, 476, 477, 1, 'com_content.article.247', 'David Guetta''s Tour Starts Soon', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(85, 46, 478, 479, 1, 'com_content.article.248', 'Maroon 5 Nominated For a Grammy', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(86, 0, 533, 534, 0, 'com_content.article.249', 'A Review of Kings of Leon', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(87, 0, 535, 536, 0, 'com_content.article.250', 'All New Music For 2012', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(88, 0, 537, 538, 0, 'com_content.article.251', 'Linkin Park Live and In Concert', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(89, 0, 539, 540, 0, 'com_content.article.252', 'Shape 5 Image Slide V2', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(90, 0, 541, 542, 0, 'com_banners.category.24', 'Joomla', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(91, 0, 543, 544, 0, 'com_banners.category.25', 'Text Ads', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(92, 0, 545, 546, 0, 'com_banners.category.26', 'Joomla! Promo', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(93, 0, 547, 548, 0, 'com_banners.category.27', 'Demo Banner', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(94, 0, 549, 550, 0, 'com_contact.category.28', 'Contacts', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(95, 0, 551, 552, 0, 'com_newsfeeds.category.29', 'Joomla!', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(96, 0, 553, 554, 0, 'com_newsfeeds.category.30', 'Free and Open Source Software', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(97, 0, 555, 556, 0, 'com_newsfeeds.category.31', 'Related Projects', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(98, 0, 557, 558, 0, 'com_weblinks.category.32', 'Joomla! Specific Links', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(99, 0, 559, 560, 0, 'com_weblinks.category.33', 'Other Resources', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(100, 45, 464, 465, 1, 'com_content.article.253', 'One of the Most Powerful Menu Systems', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(101, 45, 466, 467, 1, 'com_content.article.254', 'Lazy Load Images Save on Bandwidth', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(102, 45, 468, 469, 1, 'com_content.article.255', 'Hide The Main Article Area on Any page', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(103, 45, 470, 471, 1, 'com_content.article.256', 'Custom Page and Column Widths', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(104, 33, 420, 421, 1, 'com_content.article.257', '3rd Party Component Compatibility', '{"core.delete":[],"core.edit":[],"core.edit.state":[]}');

-- --------------------------------------------------------

--
-- Table structure for table `#__associations`
--

DROP TABLE IF EXISTS `#__associations`;
CREATE TABLE IF NOT EXISTS `#__associations` (
  `id` varchar(50) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__associations`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__banners`
--

DROP TABLE IF EXISTS `#__banners`;
CREATE TABLE IF NOT EXISTS `#__banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `#__banners`
--

INSERT INTO `#__banners` (`id`, `cid`, `type`, `name`, `alias`, `imptotal`, `impmade`, `clicks`, `clickurl`, `state`, `catid`, `description`, `custombannercode`, `sticky`, `ordering`, `metakey`, `params`, `own_prefix`, `metakey_prefix`, `purchase_type`, `track_clicks`, `track_impressions`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `reset`, `created`, `language`) VALUES
(1, 1, 0, 'OSM 1', 'osm-1', 0, 1919, 0, 'http://www.opensourcematters.org', 1, 24, '', '', 0, 1, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(2, 1, 0, 'OSM 2', 'osm-2', 0, 2021, 1, 'http://www.opensourcematters.org', 1, 24, '', '', 0, 2, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(3, 1, 0, 'Joomla!', 'joomla', 0, 504, 0, 'http://www.joomla.org', 1, 25, '', '<a href="{CLICKURL}" target="_blank">{NAME}</a>\r\n<br/>\r\nJoomla! The most popular and widely used Open Source CMS Project in the world.', 0, 1, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(4, 1, 0, 'JoomlaCode', 'joomlacode', 0, 504, 0, 'http://joomlacode.org', 1, 25, '', '<a href="{CLICKURL}" target="_blank">{NAME}</a>\r\n<br/>\r\nJoomlaCode, development and distribution made easy.', 0, 2, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(5, 1, 0, 'Joomla! Extensions', 'joomla-extensions', 0, 499, 0, 'http://extensions.joomla.org', 1, 25, '', '<a href="{CLICKURL}" target="_blank">{NAME}</a>\r\n<br/>\r\nJoomla! Components, Modules, Plugins and Languages by the bucket load.', 0, 3, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(6, 1, 0, 'Joomla! Shop', 'joomla-shop', 0, 499, 0, 'http://shop.joomla.org', 1, 25, '', '<a href="{CLICKURL}" target="_blank">{NAME}</a>\r\n<br/>\r\nFor all your Joomla! merchandise.', 0, 4, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(7, 1, 0, 'Joomla! Promo Shop', 'joomla-promo-shop', 0, 8, 1, 'http://shop.joomla.org', 1, 26, '', '', 0, 3, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(8, 1, 0, 'Joomla! Promo Books', 'joomla-promo-books', 0, 10, 0, 'http://shop.joomla.org/amazoncom-bookstores.html', 1, 26, '', '', 0, 4, '', '{}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*'),
(9, 0, 0, 'Demo Banner', 'demo-banner', 0, 3316, 0, 'http://www.shape5.com/join-now.html', 1, 27, '', '', 0, 1, '', '{"imageurl":"images\\/banners\\/osmbanner1.png","width":468,"height":60,"alt":""}', 0, '', -1, -1, -1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '*');

-- --------------------------------------------------------

--
-- Table structure for table `#__banner_clients`
--

DROP TABLE IF EXISTS `#__banner_clients`;
CREATE TABLE IF NOT EXISTS `#__banner_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__banner_clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__banner_tracks`
--

DROP TABLE IF EXISTS `#__banner_tracks`;
CREATE TABLE IF NOT EXISTS `#__banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__banner_tracks`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__categories`
--

DROP TABLE IF EXISTS `#__categories`;
CREATE TABLE IF NOT EXISTS `#__categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned DEFAULT NULL,
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `#__categories`
--

INSERT INTO `#__categories` (`id`, `asset_id`, `parent_id`, `lft`, `rgt`, `level`, `path`, `extension`, `title`, `alias`, `note`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `params`, `metadesc`, `metakey`, `metadata`, `created_user_id`, `created_time`, `modified_user_id`, `modified_time`, `hits`, `language`) VALUES
(1, 0, 0, 0, 65, 0, '', 'system', 'ROOT', 'root', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '2009-10-18 16:07:09', 0, '0000-00-00 00:00:00', 0, '*'),
(2, 27, 1, 55, 56, 1, 'uncategorised', 'com_content', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:26:37', 0, '0000-00-00 00:00:00', 0, '*'),
(3, 28, 1, 57, 58, 1, 'uncategorised', 'com_banners', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":"","foobar":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:27:35', 0, '0000-00-00 00:00:00', 0, '*'),
(4, 29, 1, 59, 60, 1, 'uncategorised', 'com_contact', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:27:57', 0, '0000-00-00 00:00:00', 0, '*'),
(5, 30, 1, 61, 62, 1, 'uncategorised', 'com_newsfeeds', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:28:15', 0, '0000-00-00 00:00:00', 0, '*'),
(6, 31, 1, 63, 64, 1, 'uncategorised', 'com_weblinks', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 42, '2010-06-28 13:28:33', 0, '0000-00-00 00:00:00', 0, '*'),
(7, 32, 1, 47, 54, 1, 'news', 'com_content', 'News', 'news', '', 'Select a news topic from the list below, then select a news article to read.', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(8, 33, 7, 48, 49, 2, 'news/latest-news', 'com_content', 'Latest', 'latest-news', '', 'The latest news from the Joomla! Team', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(9, 34, 7, 50, 51, 2, 'news/newsflash', 'com_content', 'Newsflash', 'newsflash', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(10, 35, 7, 52, 53, 2, 'news/frontpage-newsflash', 'com_content', 'Frontpage newsflash', 'frontpage-newsflash', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(11, 36, 1, 37, 46, 1, 'faqs', 'com_content', 'FAQs', 'faqs', '', 'From the list below choose one of our FAQs topics, then select an FAQ to read. If you have a question which is not in this section, please contact us.', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(12, 37, 11, 38, 39, 2, 'faqs/new-to-joomla', 'com_content', 'New to Joomla!', 'new-to-joomla', '', 'Questions for new users of Joomla!', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(13, 38, 11, 40, 41, 2, 'faqs/current-users', 'com_content', 'Current Users', 'current-users', '', 'Questions that users migrating to Joomla! 1.5 are likely to raise<br />', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(14, 39, 11, 42, 43, 2, 'faqs/general', 'com_content', 'General', 'general', '', 'General questions about the Joomla! CMS', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(15, 40, 11, 44, 45, 2, 'faqs/languages', 'com_content', 'Languages', 'languages', '', 'Questions related to localisation and languages', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(16, 41, 1, 29, 36, 1, 'about-joomla', 'com_content', 'About Joomla!', 'about-joomla', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(17, 42, 16, 30, 31, 2, 'about-joomla/the-project', 'com_content', 'The Project', 'the-project', '', 'General facts about Joomla!<br />', 1, 65, '2007-06-28 14:50:15', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(18, 43, 16, 32, 33, 2, 'about-joomla/the-cms', 'com_content', 'The CMS', 'the-cms', '', 'Information about the software behind Joomla!<br />', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(19, 44, 16, 34, 35, 2, 'about-joomla/the-community', 'com_content', 'The Community', 'the-community', '', 'About the millions of Joomla! users and Web sites<br />', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(20, 45, 1, 25, 28, 1, 'frontpage', 'com_content', 'Frontpage', 'frontpage', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(21, 46, 20, 26, 27, 2, 'frontpage/frontpage', 'com_content', 'Frontpage', 'frontpage', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(22, 47, 1, 21, 24, 1, 'featured-news', 'com_content', 'Featured News', 'featured-news', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(23, 48, 22, 22, 23, 2, 'featured-news/featured-news', 'com_content', 'Featured News', 'featured-news', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(24, 90, 1, 19, 20, 1, 'joomla', 'com_banners', 'Joomla', 'joomla', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(25, 91, 1, 17, 18, 1, 'text-ads', 'com_banners', 'Text Ads', 'text-ads', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(26, 92, 1, 15, 16, 1, 'joomla-promo', 'com_banners', 'Joomla! Promo', 'joomla-promo', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(27, 93, 1, 13, 14, 1, 'demo-banner', 'com_banners', 'Demo Banner', 'demo-banner', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(28, 94, 1, 11, 12, 1, 'contacts', 'com_contact_details', 'Contacts', 'contacts', '', 'Contact Details for this Web site', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(29, 95, 1, 9, 10, 1, 'joomla', 'com_newsfeeds', 'Joomla!', 'joomla', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(30, 96, 1, 7, 8, 1, 'free-and-open-source-software', 'com_newsfeeds', 'Free and Open Source Software', 'free-and-open-source-software', '', 'Read the latest news about free and open source software from some of its leading advocates.', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(31, 97, 1, 5, 6, 1, 'related-projects', 'com_newsfeeds', 'Related Projects', 'related-projects', '', 'Joomla builds on and collaborates with many other free and open source projects. Keep up with the latest news from some of them.', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(32, 98, 1, 3, 4, 1, 'joomla-specific-links', 'com_weblinks', 'Joomla! Specific Links', 'joomla-specific-links', '', 'A selection of links that are all related to the Joomla! Project.', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*'),
(33, 99, 1, 1, 2, 1, 'other-resources', 'com_weblinks', 'Other Resources', 'other-resources', '', '', 1, 62, '2009-04-07 19:56:18', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*');

-- --------------------------------------------------------

--
-- Table structure for table `#__contact_details`
--

DROP TABLE IF EXISTS `#__contact_details`;
CREATE TABLE IF NOT EXISTS `#__contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned DEFAULT NULL,
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `#__contact_details`
--

INSERT INTO `#__contact_details` (`id`, `name`, `alias`, `con_position`, `address`, `suburb`, `state`, `country`, `postcode`, `telephone`, `fax`, `misc`, `image`, `imagepos`, `email_to`, `default_con`, `published`, `checked_out`, `checked_out_time`, `ordering`, `params`, `user_id`, `catid`, `access`, `mobile`, `webpage`, `sortname1`, `sortname2`, `sortname3`, `language`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `metakey`, `metadesc`, `metadata`, `featured`, `xreference`, `publish_up`, `publish_down`) VALUES
(1, 'Name', 'name', 'Position', 'Street', 'Suburb', 'State', 'Country', 'Zip Code', 'Telephone', 'Fax', 'Miscellanous info', 'powered_by.png', 'top', 'email@email.com', 1, 1, 0, '0000-00-00 00:00:00', 1, '{"show_name":1,"show_position":1,"show_email":0,"show_street_address":1,"show_suburb":1,"show_state":1,"show_postcode":1,"show_country":1,"show_telephone":1,"show_mobile":1,"show_fax":1,"show_webpage":1,"show_misc":1,"show_image":1,"allow_vcard":0,"contact_icons":0,"icon_address":"","icon_email":"","icon_telephone":"","icon_fax":"","icon_misc":"","show_email_form":1,"email_description":1,"show_email_copy":1,"banned_email":"","banned_subject":"","banned_text":""}', 0, 12, 1, '', '', '', '', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `#__content`
--

DROP TABLE IF EXISTS `#__content`;
CREATE TABLE IF NOT EXISTS `#__content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `title_alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'Deprecated in Joomla! 3.0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(10) unsigned NOT NULL DEFAULT '0',
  `mask` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=258 ;

--
-- Dumping data for table `#__content`
--

INSERT INTO `#__content` (`id`, `asset_id`, `title`, `alias`, `title_alias`, `introtext`, `fulltext`, `state`, `sectionid`, `mask`, `catid`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `version`, `parentid`, `ordering`, `metakey`, `metadesc`, `access`, `hits`, `metadata`, `featured`, `language`, `xreference`) VALUES
(12, 49, 'Typography Options', 'typography-options', 'Typography Options', '<blockquote><p>This is a sample blockquote. Use <strong>&lt;blockquote&gt;&lt;p&gt;Your content goes \r\nhere!&lt;/p&gt;&lt;/blockquote&gt;</strong> to create a blockquote.</p></blockquote>\r\n\r\n\r\n\r\n\r\n<div class="s5_greenbox">\r\n<div class="point">\r\n\r\n\r\n&lt;div class="s5_greenbox"&gt;\r\n&lt;div class="point"&gt;\r\nYour text here\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n\r\n\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n<div class="s5_redbox">\r\n<div class="point">\r\n\r\n\r\n&lt;div class="s5_redbox"&gt;\r\n&lt;div class="point"&gt;\r\nYour text here\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n\r\n\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n\r\n<div class="s5_bluebox">\r\n<div class="point">\r\n\r\n\r\n&lt;div class="s5_bluebox"&gt;\r\n&lt;div class="point"&gt;\r\nYour text here\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n\r\n\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n\r\n<div class="s5_graybox">\r\n<div class="point">\r\n\r\n\r\n&lt;div class="s5_graybox"&gt;\r\n&lt;div class="point"&gt;\r\nYour text here\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n\r\n\r\n</div>\r\n</div>\r\n\r\n\r\n\r\n\r\n<br />\r\n\r\n<div class="black_box">This is a styled box. Use <strong>&lt;div class=&quot;black_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="gray_box">This is a styled box. Use <strong>&lt;div class=&quot;gray_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="red_box">This is a styled box. Use <strong>&lt;div class=&quot;red_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="blue_box">This is a styled box. Use <strong>&lt;div class=&quot;blue_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="green_box">This is a styled box. Use <strong>&lt;div class=&quot;green_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="yellow_box">This is a styled box. Use <strong>&lt;div class=&quot;yellow_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n<div class="orange_box">This is a styled box. Use <strong>&lt;div class=&quot;orange_box&quot;&gt;Your content \r\ngoes here!&lt;/div&gt;</strong></div>\r\n\r\n<br />\r\n\r\n\r\n\r\nThis is an image with the "boxed" class applied:<br /><br />\r\n\r\n<img class="boxed" src="http://www.shape5.com/demo/images/small1.jpg" alt=""></img>\r\n<br /><br /><br /><br />\r\n<br />\r\n\r\n\r\n\r\n\r\nThis is an image with the "boxed_black" class applied:<br /><br />\r\n\r\n<img class="boxed_black" src="http://www.shape5.com/demo/images/small1.jpg" alt=""></img>\r\n<br /><br />\r\n\r\n\r\n\r\n\r\nThis is an image with the "padded" class applied:<br /><br />\r\n\r\n<img class="padded" src="http://www.shape5.com/demo/images/small1.jpg" alt=""></img>\r\n<br /><br />\r\n\r\n\r\n\r\n\r\n<h1>Heading 1</h1>\r\n<h2>Heading 2</h2>\r\n<h3>Heading 3</h3>\r\n<h4>Heading 4</h4>\r\n<h5>Heading 5</h5>\r\n\r\n<br />\r\n\r\n<div class="code">This is a sample code div. Use <strong>&lt;div \r\n  class=&quot;code&quot;&gt;Your content goes here!&lt;/div&gt;</strong> to create a code div.<br /><br />#s5_code { width: 30px; color: #fff; line-height: 45px; } </div>\r\n\r\n<br />\r\n\r\n<ol>\r\n<li>This is an <strong>Ordered List</strong></li>\r\n<li>Congue Quisque augue elit dolor nibh.</li>\r\n<li>Condimentum elte quis.</li>\r\n<li>Opsum dolor sit amet consectetuer.</li>\r\n</ol>\r\n\r\n<br />\r\n\r\n<ul>\r\n<li>This is an <strong>Unordered List</strong></li>\r\n<li>Congue Quisque augue elit dolor nibh.</li>\r\n<li>Condimentum elte quis.</li>\r\n<li>Opsum dolor sit amet consectetuer.</li>\r\n</ul>\r\n\r\n<br />\r\n\r\n<ul class="ul_arrow">\r\n<li>This is an <strong>Unordered List with class ul_arrow</strong></li>\r\n<li>Congue Quisque augue elit dolor nibh.</li>\r\n<li>Condimentum elte quis.</li>\r\n<li>Opsum dolor sit amet consectetuer.</li>\r\n</ul>\r\n\r\n\r\n<br />\r\n\r\n<ul class="ul_star">\r\n<li>This is an <strong>Unordered List with class ul_star</strong></li>\r\n<li>Congue Quisque augue elit dolor nibh.</li>\r\n<li>Condimentum elte quis.</li>\r\n<li>Opsum dolor sit amet consectetuer.</li>\r\n</ul>\r\n\r\n<br />\r\n\r\n<ul class="ul_bullet">\r\n<li>This is an <strong>Unordered List with class ul_bullet</strong></li>\r\n<li>Congue Quisque augue elit dolor nibh.</li>\r\n<li>Condimentum elte quis.</li>\r\n<li>Opsum dolor sit amet consectetuer.</li>\r\n</ul>\r\n\r\n\r\n<br />\r\n\r\n\r\nThe following list will support lists up to number 9, add the following class to the UL wrapping the below LI elements, class="ul_numbers":\r\n<br /><br />\r\n\r\n<ul class="ul_numbers">\r\n\r\n<li class="li_number1">This is a sample styled number list <strong>&lt;li class=&quot;li_number1&quot;&gt;Your content \r\ngoes here!&lt;/li&gt;</strong></li>\r\n\r\n<li class="li_number2">This is a sample styled number list <strong>&lt;li class=&quot;li_number2&quot;&gt;Your content \r\ngoes here!&lt;/li&gt;</strong></li>\r\n\r\n<li class="li_number3">This is a sample styled number list <strong>&lt;li class=&quot;li_number3&quot;&gt;Your content \r\ngoes here!&lt;/li&gt;</strong></li>\r\n\r\n<li class="li_number4">This is a sample styled number list <strong>&lt;li class=&quot;li_number4&quot;&gt;Your content \r\ngoes here!&lt;/li&gt;</strong></li>\r\n\r\n</ul>\r\n\r\n<br />', '', 1, 0, 0, 8, '2007-12-05 11:25:14', 62, '', '2012-01-31 02:55:14', 42, 0, '0000-00-00 00:00:00', '2007-12-05 11:24:52', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"1","link_author":"","show_create_date":"0","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 47, 0, 17, '', '', 1, 25405, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(13, 50, 'S5 Flex Menu - Menu System', 's5-flex-menu-menu-system', 'S5 No-MooMenu With Multiple Effects', 'The S5 Flex Menu system is a very powerful plugin that provides functionality \r\nfar beyond what the standard Joomla menu system can provide. This plugin \r\nis intended to be as an extension of the existing menu system in Joomla to add many new features! Please see the full list of features below. \r\n\r\n<br /><br />\r\n\r\nThis menu system works off of the core Joomla mootools script so no extra javascript library is needed and keep download sizes to a minimum. Also, if you do not want to use this menu you can simply turn it it off from the template configuration page.\r\n<br /><br />\r\n\r\nTake your website to  the next design level by using the robust and feature\r\nrich S5 Flex Menu System. Organize your links with ease and show content \r\nin places you never could before!\r\n<br /><br />\r\n\r\n\r\n<h3>Menu Features:</h3>\r\n\r\n\r\n\r\n<ul class="ul_star">\r\n<li>Multiple javascript effects with core mootools</li>\r\n<li>Multiple columns for menu items or modules</li>\r\n<li>Modules load directly into the menu</li>\r\n<li>Group sub menu items into the same column or fly out</li>\r\n<li>Optional sub texts for each menu item</li>\r\n<li>Optional menu icon images for each menu item</li>\r\n<li>And much more!</li>\r\n</ul>\r\n\r\n\r\n<br /><br />\r\n<h3>Menu Screenshot:</h3>\r\n<br />\r\n<img class="padded" src="images/flexmenu.jpg" alt=""></img>\r\n<br /><br />\r\n\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div><br /></ul>', '', 1, 0, 0, 8, '2007-12-05 11:32:41', 62, '', '2012-01-31 14:08:33', 42, 0, '0000-00-00 00:00:00', '2007-12-05 11:32:07', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"0","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 90, 0, 18, '', '', 1, 30814, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(14, 51, 'Module Positions and Styles', 'module-positions-and-styles', '17 Positions and 6 Styles', '<br />\r\n<h3>All modules are fully collapsible</h3>\r\n<br />\r\nWhat exactly is a collapsing module? It&#39;s quite simple, whenever a module is not published to a postion that position does not appear on the frontend of the template. Consider the example below:\r\n<br /><br />\r\n<img src="http://www.shape5.com/demo/images/general/modules_6.png"></img>\r\n<br /><br />\r\nThis particular row has 6 module positions available to publish to. Let&#39;s say you only want to publish to 4 of these positions. The template will automatically collapse the modules you do not want to use and adjust the size of the modules accordingly:\r\n<br /><br />\r\n<img src="http://www.shape5.com/demo/images/general/modules_4.png"></img>\r\n<br /><br />\r\nIf no modules are published to the row the entire row itself will not show. The best feature of this is every module can be published to its own unique pages so the layout of your site can change on every page!\r\n<br /><br /><br />\r\n<h3>Infinite Layouts</h3>\r\n<br />\r\nBecause there are so many module positions available in so many different areas, the number of layouts you can create are limitless! For example, if you would like to show your main content area on the right side of your site but still have a column of modules, simply published your modules to the right or right_inset positions or both. The same would be true for the opposite, if you want a column on the left simply publish modules to left or left_inset. Of course you can always choose to not have a column at all. Remember, any module not published to will automatically collapse and the remaining area will automatically adjust. There is no need to choose a pre-defined layout for your entire site, simply use the power of collpasing module positions and take advantage of the numerous amount of module positions to create any layout you can dream of! Be sure to checkout the layout of modules below.\r\n<br /><br /><br />\r\n<h3>Dozens of Modules</h3>\r\n<br />\r\nBelow is a complete list of all the module positions available for this template.\r\n<br /><br />\r\n<img src="http://www.shape5.com/images/products/2012/vertex/vertex_layout.png"></img>\r\n<br /><br /><br />\r\n\r\n<h3>How to install and setup module styles:</h3></p> <ol> <li>   Download any module you wish to publish to your site.</li> <li>In the backend of Joomla    navigate to the menu item Extensions/Install Uninstall</li> <br />   <img style="margin-bottom:14px" src="http://www.shape5.com/demo/images/general/install_menu.png" border="0" width="199" height="172" /><br /> <li>Browse for the module&#39;s install file and click Upload File & Install.</li>  <li>   Once the module has be installed navigate to the menu item Extensions/Module    Manager (same menu as above)</li>  <li>Find the Module just installed and click on it&#39;s title.</li>  <li>   Change any parameters that you wish and be sure to set it to published and    publish it to your desired module position.</li><li>To apply a module style simply fill in the module class suffix field with any of this template&#39;s included module styles. This parameter setting is found under Module Parameters on the right side of the screen. </li> <br />   <img style="margin-bottom:14px" src="http://www.shape5.com/demo/images/general/module_suffix.png" border="0" width="200" height="72" /><br /> <li>Assign what pages you would like the module to appear on and finally click Save.</li><br />   <img src="http://www.shape5.com/demo/images/general/page_assignment.png" border="0" width="200" height="144" /><br />   </ol>            <p>&nbsp;</p>', '', 1, 0, 0, 8, '2007-12-05 13:16:18', 62, '', '2012-01-31 14:23:29', 42, 0, '0000-00-00 00:00:00', '2007-12-05 13:16:05', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 65, 0, 19, '', '', 1, 26909, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(17, 52, 'Installing The Template', 'installing-the-template', 'Installing Forever ACE 2', '<br /><ul class="bullet_list"><ul class="ul_numbers"><li class="li_number1">Download the installation package from our download section.</li><li class="li_number2">Once the download is complete go to the backend of Joomla.</li><li class="li_number3">     Navigate through your menu system to Extensions/Install Uninstall.</li>   </ul>   \r\n</ul>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n<img border="0" src="http://www.shape5.com/demo/images/general/install_menu.png" width="199" height="172"></p>\r\n<ul class="bullet_list"><ul class="ul_numbers">          <li class="li_number4">Once at the installation screen click the browse button and navigate to where you downloaded the template file.</li>     <li class="li_number5">Once you have the file selected click &#39;Upload File and Install&#39;</li>     \r\n  <p>\r\n  <img border="0" src="http://www.shape5.com/demo/images/general/browse.png" width="400" height="56"></p>\r\n  <p><b>The template is now installed, now let&#39;s set it as the default template:</b><br />     </p>     <li class="li_number6">Navigate through your menu system to Extensions/Template Manager.</li><li class="li_number7">Find the radio button next to the newly installed template.</li><li class="li_number8">Click on the Default button at the top right of the screen and you&#39;re done!</li><p>\r\n  <img border="0" src="http://www.shape5.com/demo/images/general/default.png" width="200" height="92"></ol>   </ul>   <p>&nbsp;</p>', '', 1, 0, 0, 8, '2007-12-11 19:38:14', 62, '', '2010-12-14 23:14:53', 62, 0, '0000-00-00 00:00:00', '2007-12-11 19:37:21', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 24, 0, 13, '', '', 1, 11203, '', 0, '*', ''),
(18, 53, 'The Template''s Settings', 'the-templates-settings', 'Configuring The Template''s Settings', '<p>This template comes loaded with options that you can use to customize your site exactly how you want it. Here&#39;s how to get to these custom settings:</p>\r\n<ol>\r\n<li>In the backend of Joomla go menu item Extensions/Template Manager.</li>\r\n<li>Click on the title of the template.</li>\r\n<li>This will bring you to the template manager screen where you can edit the template&#39;s parameters.</li>\r\n<li>Click save when you are done</li>\r\n</ol>\r\n<p><img src="http://www.shape5.com/demo/images/general/template_edit15.jpg" border="0" alt=" " width="500" height="156" /> <br /><br /><br /></p>\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top" style="color:#1B6FC2; text-decoration:underline">JOIN TODAY</a>.</strong></div>\r\n<p> </p>', '', 1, 0, 0, 8, '2007-12-11 19:46:04', 62, '', '2011-02-15 01:00:39', 62, 0, '0000-00-00 00:00:00', '2007-12-11 19:45:45', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 9, 0, 14, '', '', 1, 11395, '', 0, '*', ''),
(24, 54, 'Page, Column and Row Widths', 'page-column-and-row-widths', 'Custom Page and Column Widths', '<h3>Fixed or Fluid Width</h3><br />\r\nThis template has the ability to set the entire width of your set to either a \r\nfixed pixel width or a fluid percentage width. You can set the width to any size \r\nyou want.\r\n<br /><br /><h3>Column Widths</h3><br />\r\nYou may also set the widths of the following positions to any width that you \r\nneed to: left, left_inset, right, and right_inset. You may set them to any width \r\nyou need to.\r\n<br /><br /><h3>Row Widths</h3><br />\r\nThis template comes loaded with module positions, many of which appear in rows \r\nof 6 module positions. Any row that contains 6 module positions can have it&#39;s \r\nrow columns set to automatic widths or manual. For example, in the picture below \r\nthe first row shows 4 modules published and since it&#39;s set to automatic each is \r\nset to 25% width. The second row shows a manual calculation for each module in \r\nthe row. Again, you may do this for any row that contains 6 modules. If you \r\nsetup a manual calculation they must total to 100%. Not all 6 modules need to be \r\nused, as shown below.<p>\r\n</p>\r\n<p>All of this is done very easily in the template configuration.</p>\r\n<p align="center">\r\n<img style="border:solid 1px #333333" src="http://www.shape5.com/demo/images/general/custom_widths.png" width="600" height="432" /></p>\r\n<br />', '', 1, 0, 0, 8, '2007-12-11 21:25:09', 62, '', '2011-12-13 19:44:25', 62, 0, '0000-00-00 00:00:00', '2007-12-11 21:24:39', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 45, 0, 15, '', '', 1, 10818, '', 0, '*', ''),
(36, 55, 'How To Setup the Search Box and Menus', 'how-to-setup-the-search-box-and-menus', 'How To Setup the Search Box and Menus', '<p> <h3>1. Search Setup</h3></p>\r\n<p><span style="font-size: medium;"><strong> <img src="images/search.png" class="padded" /></strong></span></p>\r\n<ul class="ul_arrow">\r\n<li>Publish the default Joomla search module to the &#39;search&#39; position.</li>\r\n<li>Change any of the module&#39;s parameters you wish, and that&#39;s it.</li>\r\n</ul>\r\n\r\n<br />\r\n\r\n<p><h3>2. Column Menu Setup</h3></p>\r\n<p><span style="font-size: medium;"><strong> <img src="images/column_menu.png" class="padded" /></strong></span></p>\r\n<ul class="ul_arrow">\r\n<li>Publish any menu module to the main body module positions on your site. </li>\r\n<li>There should be no menu style suffixes applied under advanced parameters.</li>\r\n<li>You may apply any module class suffix. Shown above is the -line suffix.</li>\r\n<li> The menu style should be set to list.</li>\r\n<li>You may assign any of this template&#39;s module class suffixes.</li>\r\n</ul>\r\n\r\n\r\n\r\n<br />\r\n<p><h3>3. Bottom Menu Setup</h3></p>\r\n<p><img src="images/bottom_menu.png" class="padded" /></p>\r\n<ul class="ul_arrow">\r\n<li>Publish any menu to the &#39;bottom_menu&#39; position.</li>\r\n<li> There are no menu style suffixes applied under advanced parameters.</li>\r\n<li> The menu style should be set to list</li>\r\n</ul>\r\n<p> </p>', '', 1, 0, 0, 8, '2008-02-14 15:10:56', 62, '', '2012-01-31 03:08:28', 42, 0, '0000-00-00 00:00:00', '2008-02-14 15:10:36', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"0","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 62, 0, 20, '', '', 1, 8176, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(37, 56, 'Tool Tips Setup', 'tool-tips-setup', 'Tool Tips Setup', '<br /><div class="blue_box"><strong>Note - The tool tips script is by default disabled. If you wish to use it you must enable this script in the template&#39;s configuration area. This also includes site shaper installations.</strong></div>\r\n\r\n\r\n<br/>\r\n<strong>\r\nDemo 1:\r\n</strong>\r\n<br />\r\n<div class="code">\r\n&lt;a onmouseover="Tip(&#39;This is a sample tooltip.&#39;, WIDTH, 140, OPACITY, 80, ABOVE, true, OFFSETX, 1, FADEIN, 200, FADEOUT, 300,SHADOW, true, SHADOWCOLOR, &#39;#000000&#39;,SHADOWWIDTH, 2, BGCOLOR, &#39;#000000&#39;,BORDERCOLOR, &#39;#000000&#39;,FONTCOLOR, &#39;#FFFFFF&#39;, PADDING, 9)" href="http://www.shape5.com/demo/etensity/"><br/><br/>\r\n&lt;img class="boxed2" alt="" src="http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg"/><br/><br/>\r\n&lt;/a>\r\n</div>\r\n\r\n<br/>\r\n\r\n\r\n\r\n\r\n<a onmouseover="Tip(&#39;This is a sample tooltip.&#39;, WIDTH, 140, OPACITY, 80, ABOVE, true, OFFSETX, 1, FADEIN, 200, FADEOUT, 300,SHADOW, true, SHADOWCOLOR, &#39;#000000&#39;,SHADOWWIDTH, 2, BGCOLOR, &#39;#000000&#39;,BORDERCOLOR, &#39;#000000&#39;,FONTCOLOR, &#39;#FFFFFF&#39;, PADDING, 9)" href="http://www.shape5.com/demo/etensity/">\r\n\r\n<img class="boxed2" alt="" src="http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg"/>\r\n\r\n</a>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<br/>\r\n\r\n\r\n<br/><br />\r\n<strong>\r\nDemo 2:\r\n</strong>\r\n<br />\r\n\r\n\r\n\r\n<div class="code">\r\n&lt;a href="index.htm" onmouseover="Tip(&#39;Image Demo<br /> <br />&lt;img src=http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg width=220 height=147>&#39;)">Demo 2 Image Tool Tip &lt;/a> \r\n</div>\r\n<br/>\r\n<a href="index.htm" onmouseover="Tip(&#39;Image Demo<br /> <br /><img src=http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg width=220 height=147>&#39;)"><strong>Demo 2 Image Tool Tip</strong></a><br/><br/> \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n<br/>\r\n<strong>\r\nDemo 3:\r\n</strong>\r\n<br />\r\n\r\n\r\n<div class="code">\r\n&lt;a href="#" onmouseover="Tip(&#39;Image Demo&lt;br /> &lt;br />&lt;img src=http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg width=220 height=147>&#39;,SHADOW, true,  BGCOLOR, &#39;#000000&#39;, FADEIN, 400, FADEOUT, 400, SHADOWCOLOR, &#39;#000000&#39;, BORDERCOLOR, &#39;#000000&#39;,OPACITY, 90,FONTCOLOR, &#39;#FFFFFF&#39;)">&lt;strong>Demo 3 Image Tool Tip&lt;/strong>&lt;/a>\r\n</div>\r\n\r\n\r\n<a href="#" onmouseover="Tip(&#39;Image Demo<br /> <br /><img src=http://www.shape5.com/demo/smart_blogger/images/tooltip.jpg width=220 height=147>&#39;,SHADOW, true,  BGCOLOR, &#39;#000000&#39;, FADEIN, 400, FADEOUT, 400, SHADOWCOLOR, &#39;#000000&#39;, BORDERCOLOR, &#39;#000000&#39;, OPACITY, 90,FONTCOLOR, &#39;#FFFFFF&#39;)"><strong>Demo 3 Image Tool Tip</strong></a>\r\n<br/><br/>', '', 1, 0, 0, 8, '2008-08-13 18:09:50', 62, '', '2011-06-13 14:57:45', 62, 0, '0000-00-00 00:00:00', '2008-08-13 18:09:37', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 3, 0, 21, '', '', 1, 4830, '', 0, '*', ''),
(39, 57, 'Site Shapers', 'site-shapers', 'SQL Dumps/Site Shapers', '<p><br />So what are Site Shapers? They are quick installs of Joomla combined with all the modules, images, etc used on our demo. Within a few minutes you can have your site up, running and looking just like our demo. No more importing SQL dumps and installing modules.  Just head on over to the download section of this template and grab a Site Shaper.  Simply install the Site Shaper like any other Joomla installation, it&#39;s that easy!<br /><br /></p>\r\n<h3>How to setup a Site Shaper</h3>\r\n<br />\r\n<ul class="ul_bullet">\r\n<li>Login to your cpanel or your server admin panel.</li>\r\n<li>Locate the area where your databases are    (usually labeled Mysql Databases)</li>\r\n<li>Create a new database</li>\r\n<li>Next create a new database user and assign    it to this newly created database in the previous step</li>\r\n<li>You will then    need to extract the site shaper to either a folder on your server or the root    directory such as WWW. NOTE: if you already have a website in the root of your    WWW folder, we suggest creating a new folder and extract the site shaper    there. If your cpanel does not have an extract option or you cannot find it,    you may also extract the contents of your site shaper in to a folder on your    desktop and upload all the files via an ftp client to your server.</li>\r\n<li>Next, navigate to the url where you extracted the site shaper via your web browser.</li>\r\n<li>Continue through each screen until you reach the below screenshot:</li>\r\n<br /> <img src="http://www.shape5.com/demo/images/general/siteshaper.png" border="0" /> <br /><br />\r\n<li>At the above screen be sure to enter localhost as shown, continue to fill in the following text fields with your newly created database and username information</li>\r\n<li>Follow through the rest of the site shaper setup and click the install sample data at the last screen and the installation is complete! (be sure to rename/remove the installation directory after finishing the install)</li>\r\n</ul>\r\n<p><br /><br /></p>', '', 1, 0, 0, 8, '2008-08-13 18:43:32', 62, '', '2012-01-31 14:26:41', 42, 0, '0000-00-00 00:00:00', '2008-08-13 18:42:56', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 39, 0, 16, '', '', 1, 8978, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(97, 58, 'Shape 5 Tab Show', 'shape-5-tab-show', '', 'The S5 Tab Show module can be demo&#39;d at the right of this page. This version of the module is customized specifically for this template and cannot be used with any other templates. We do have another version that can be used on any Joomla template.\r\n<br /><br />\r\nThe module holds up to 10 actual module positions so you can publish any of your favorite modules to one of the slides and keep your site clean and consolidated while giving it some eye candy. So simply publish the s5 tab show module to your desired module position and pages. Then start publishing modules to the positions in the tab show (s5_tab1, s5_tab2, etc); these modules will become the slides.', '', -2, 0, 0, 8, '2009-06-15 23:25:04', 62, '', '2011-12-13 18:54:42', 62, 0, '0000-00-00 00:00:00', '2009-06-15 23:25:04', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 16, 0, 24, '', '', 1, 64, '', 0, '*', ''),
(110, 59, 'Shape 5 CSS and JS Compressor Plugin', 'shape-5-css-and-js-compressor-plugin', '', '<p><strong>The Shape 5 CSS and JS Compressor plugin is the most revolutionary and flexible compressor plugin available for Joomla! This plugin can be used on any Joomla template. Read the full description below to see why. </strong></p>\r\n<p>The CSS and JS Compressor increases speed and performance by compressing your site&#39;s CSS and Javascript files to much smaller sizes than the original and places them in a cache folder on your server. No data is lost during this process, just simply made smaller.   So what makes our&#39;s better than the rest? One word, FLEXIBILITY! Read below for  a full description:</p>\r\n<ul class="ul_star">\r\n<br />\r\n<li>All other plugins force all CSS and JS to be combined into one file of JS and file of CSS. Our compressor plugin gives you the option to: 	 \r\n<ul class="ul_star">\r\n<li>Only compress module files</li>\r\n<li>Only compress component files</li>\r\n<li>Only compress non-module and non-component files</li>\r\n<li>Or combine any of the above</li>\r\n</ul>\r\nThe point is you can control what gets compressed independent of each other. </li>\r\n<li>All other compressor plugins combine javascript files into one large file, called at the top of the page. The problem is javascript almost always needs to be called in a certain order or it will cause page errors. Calling a file at the top of the page that was originally intended to be called in a certain order will cause unwanted results. So we&#39;ve fixed this and given you three options: 	 \r\n<ul class="ul_star">\r\n<li>Call the compressed javascript at the top of the page in a combined file</li>\r\n<li>Call the compressed javascript at the bottom of the page in a combined file</li>\r\n<li>Call the compressed javascript in their original locations as individual files</li>\r\n</ul>\r\nThe first two ways will generate three files (module js, component js, and other js files) and will create less calls to your server. However, we HIGHLY recommend the use of the third option. This option will generate the same amount of calls to your server as without the plugin but will still compress your javascript to a much smaller size all while still being called in the original location to avoid  script errors, in other words less download time for your viewers and no script  errors! </li>\r\n<li>Need to exclude certain files? Not a problem! This plugin will allow you to specify certain file names to be excluded from compression despite any previous settings.</li>\r\n<li>Specify in the backend how long you want your cache to stay on your server. After the time has completed a new cached version of your files will be created.</li>\r\n<li>Eliminate unwanted white space in your files be enabling CSS Optimization. This feature will remove any un-used white space to reduce the size of each CSS file.</li>\r\n</ul>\r\n<p> </p><br />\r\n<div class="red_box"><span class="alert">Note: Because this plugin uses cached versions of your javascript and css this plugin should not be used while developing your site and should only be enabled after you have completed your site. <br /><br /> Gzip must be installed on your server and enabled in PHP in order to function.</span></div><br />\r\n<p><strong><span style="font-size: large;">See This Plugin in Action!</span></strong></p>\r\n<p>Without the Shape 5 CSS and JS Compressor Enabled:</p>\r\n<p><img src="http://www.shape5.com/demo/images/general/gzip_without.jpg" border="0" width="600" height="224" /></p>\r\n<p>With the Shape 5 CSS and JS Compressor Enabled a <strong>72% DECREASE IN DOWNLOAD  SIZE!</strong></p>\r\n<p><img src="http://www.shape5.com/demo/images/general/gzip_with.jpg" border="0" width="600" height="224" /></p>\r\n<p><br /><br /></p>\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', 1, 0, 0, 8, '2009-08-13 18:44:06', 62, '', '2011-12-13 20:06:45', 62, 0, '0000-00-00 00:00:00', '2009-08-13 18:44:06', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 14, 0, 22, '', '', 1, 63, '', 0, '*', ''),
(143, 60, 'S5 Accordion Menu', 's5-accordion-menu', '', '<br />The S5 Accordion menu is demo&#39;d on the right of this page. This version was built specifically for this template and cannot be transferred to another template. We do have another version that can be used on any Joomla template.<br /><br />   \r\n\r\nThis module is based off the Joomla main menu system module so you can still specify which Joomla menu you want to use with the S5 Accordion menu. The menu is powered off of the Mootools Javascript library but detects to see if the library is already initialized, if so then it doesn&#39;t load its own library to stop any conflicts from arising.\r\n\r\n<br /><br />   <div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', -2, 0, 0, 8, '2009-10-12 22:29:01', 62, '', '2011-02-14 20:19:24', 62, 0, '0000-00-00 00:00:00', '2009-10-12 22:29:01', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 10, 0, 25, '', '', 1, 173, '', 0, '*', ''),
(146, 61, 'Login and Register Setup', 'login-and-register-setup', '', 'Setting up the login and register links is very simple. Just enter the login, logout, and register text in the template configuration like shown below. As long as text is present the links will show. To disable them simply empty the fields and save the configuration.\r\n\r\n<br /><br />\r\n\r\n<img class="padded" src="images/login.png"></img>', '', 1, 0, 0, 8, '2009-10-12 22:44:23', 62, '', '2012-01-31 03:14:19', 42, 0, '0000-00-00 00:00:00', '2009-10-12 22:44:23', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 34, 0, 23, '', '', 1, 98, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(173, 62, 'Search Engine Optimized ', 'search-engine-optimized', '', '<br/>\r\n<h3>SEO - Get your site noticed!</h3>\r\n<p><br /> Not only is this template beautifully designed but it is great for search engine optimization as well! What is SEO? It is simple the act of altering a web site so that it does well in the organic, crawler-based listings of search engines such as google.com. How does this template accomplish this? It&#39;s simple, the majority of your most valuable content is found in the main body of your site, through css we are able to alter the layout of the site and call the main content before the left and right columns are called. This allows for your content to be found first by search engines before it reaches your other content, which is vital in search engine optimization. This is a common feature this can be done with almost all of Shape 5 templates as well.</p>\r\n<p> </p>\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', 1, 0, 0, 8, '2010-02-11 17:28:55', 62, '', '2010-08-13 18:55:05', 62, 0, '0000-00-00 00:00:00', '2010-02-11 17:28:55', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 12, 0, 12, '', '', 1, 87, '', 0, '*', ''),
(195, 63, 'Multibox Setup Tutorial', 'multibox-setup-tutorial', '', '<br/><h3>Features:</h3><br/>\r\n\r\n<ul class="ul_bullet_small">\r\n<li>Supports a range of multimedia formats: images, flash, video, mp3s, html!</li>\r\n<li>Auto detects formats or you can specify the format</li>\r\n<li>Html descriptions</li>\r\n<li>Enable/Disable page overlay when multibox pops up (via template parameters)</li>\r\n<li>Enable/Disable controls (via template parameters)</li>\r\n\r\n\r\n\r\n\r\n<br/>\r\n\r\n\r\n\r\n<p><strong><font size="2">Images Example</font></strong></p>          \r\n\r\n<a href="http://www.shape5.com/demo/images/multibox1_lrg.jpg" id="mb1" class="s5mb" title="Image #1:">\r\n<img src="http://www.shape5.com/demo/images/multibox1.jpg" style="margin-right:20px" class="boxed" alt="" />\r\n</a>\r\n<div class="s5_multibox mb1">Image #1. It can support <strong>html</strong>.</div>\r\n&nbsp;&nbsp;\r\n<a href="http://www.shape5.com/demo/images/multibox2_lrg.jpg" id="mb2" class="s5mb" title="Image #2:">\r\n<img src="http://www.shape5.com/demo/images/multibox2.jpg" style="margin-right:20px" class="boxed" alt="" />\r\n</a>\r\n<div class="s5_multibox mb2">Image #2. It can support <strong>html</strong>.</div>\r\n&nbsp;&nbsp;\r\n<a href="http://www.shape5.com/demo/images/multibox3_lrg.jpg" id="mb3" class="s5mb" title="Image #3:">\r\n<img src="http://www.shape5.com/demo/images/multibox3.jpg" class="boxed" alt="" />\r\n</a>\r\n<div class="s5_multibox mb3">Image #3. It can support <strong>html</strong>.</div>\r\n\r\n\r\n\r\n<br /><br /><br /><br /><br /><br /><br />\r\n\r\n <p>To enable use the following around any group of images:</p>\r\n<div style="clear:both"></div><div class="code">\r\n\r\n&lt;a href="http://www.shape5.com/demo/images/multibox1_lrg.jpg" id="mb2" class="s5mb" title="Grouped Image Example #1:"&gt;\r\n&lt;img src="http://www.shape5.com/demo/images/multibox1.jpg" class="boxed" alt="" /&gt;\r\n&lt;/a&gt;\r\n&lt;div class="s5_multibox mb2"&gt;Multiple Image #1. It can support &lt;strong&gt;html&lt;/strong&gt;.&lt;/div&gt;\r\n<br/>\r\n<br/>\r\n&lt;a href="http://www.shape5.com/demo/images/multibox2_lrg.jpg" id="mb3" class="s5mb" title="Grouped Image Example #2:"&gt;\r\n&lt;img src="http://www.shape5.com/demo/images/multibox2.jpg" class="boxed" alt="" /&gt;\r\n&lt;/a&gt;\r\n&lt;div class="s5_multibox mb3"&gt;Multiple Image #2. It can support &lt;strong&gt;html&lt;/strong&gt;.&lt;/div&gt;\r\n<br/>\r\n<br/>\r\n&lt;a href="http://www.shape5.com/demo/images/multibox3_lrg.jpg" id="mb4" class="s5mb" title="Grouped Image Example #3:"&gt;\r\n&lt;img src="http://www.shape5.com/demo/images/multibox3.jpg" class="boxed" alt="" /&gt;\r\n&lt;/a&gt;\r\n&lt;div class="s5_multibox mb4"&gt;Multiple Image #3. It can support &lt;strong&gt;html&lt;/strong&gt;.&lt;/div&gt;\r\n\r\n\r\n</div>\r\n\r\n\r\n\r\n<br/>\r\n\r\n\r\n<p><strong><font size="2">Video Example:</font></strong></p>   \r\n\r\n<a href="http://www.youtube.com/v/VGiGHQeOqII" id="youtube" class="s5mb" title="Youtube.com Video">\r\nYoutube.com Video - CLICK ME\r\n</a>\r\n<div class="s5_multibox youtube">UP: Carl and Ellie </div>\r\n\r\n<br/>\r\n<br/>\r\nYou can use the following video formats: flv, mov, wmv, real and swf.  Just insert the URL to the videos in the href of the hyperlink, here is an example of how we did this for a Youtube video:<br/>\r\n\r\n<div class="code">\r\n&lt;a href="http://www.youtube.com/v/VGiGHQeOqII" id="youtube" class="s5mb" title="Youtube.com Video"&gt;\r\nYoutube.com Video  - CLICK ME\r\n&lt;/a&gt;\r\n&lt;div class="s5_multibox youtube"&gt;UP: Carl and Ellie &lt;/div&gt;\r\n</div>\r\n\r\n\r\n<br/>\r\nYouTube Tutorial:  Simply right click on a youtube video and copy the embed code, then paste into a text editor and look for the embed src and use that URL in your hyperlink.\r\n\r\n<div class="code">\r\n&lt;embed src= http://www.youtube.com/v/VGiGHQeOqII\r\n</div>\r\n\r\n\r\n\r\n<br/>\r\n\r\n\r\n<p><strong><font size="2">MP3 Example:</font></strong></p>   \r\n\r\n<a href="http://www.shape5.com/demo/images/music.mp3"  id="mb8" class="s5mb" title="Music">MP3 example - CLICK ME</a>\r\n<div class="s5_multibox mb8">mp3 example</div><br />\r\n\r\n<div class="code">\r\n&lt;a href="http://www.shape5.com/demo/images/music.mp3"  id="mb8" class="s5mb" title="Music">MP3 example&lt;/a&gt;\r\n&lt;div class="s5_multibox mb8">mp3 example - CLICK ME&lt;/div&gt;\r\n</div>\r\n\r\n\r\n<br/>\r\n\r\n\r\n<p><strong><font size="2">iFrame:</font></strong></p>   \r\n\r\n<a href="http://www.google.com" rel="width:790,height:600" id="mb28" class="s5mb" title="Google.com">iFrame/HTML Example - CLICK ME</a>\r\n<div class="s5_multibox mb28">Google.com</div><br />\r\n\r\n<div class="code">\r\n&lt;a href="http://www.google.com" rel="width:790,height:600" id="mb28" class="s5mb" title="Google.com"&gt;iFrame/HTML Example - CLICK ME&lt;/a&gt;\r\n&lt;div class="s5_multibox mb28"&gt;Google.com&lt;/div&gt;\r\n\r\n</div>\r\n\r\n\r\n<br/><br/>\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n<div class="blue_box">\r\nI like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top"><strong>JOIN TODAY</strong></a>. </div>\r\n <br />', '', 1, 0, 0, 8, '2010-08-13 18:18:32', 62, '', '2011-12-13 19:38:59', 62, 0, '0000-00-00 00:00:00', '2010-08-13 18:18:32', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 18, 0, 11, '', '', 1, 81, '', 0, '*', ''),
(197, 64, 'Template Specific Options', 'template-specific-options', '', 'This template is built on the very powerful S5 Vertex Framework, which comes packed with amazing features! <a href="http://www.shape5.com/joomla/framework/vertex_framework.html" target="blank">Learn More About Vertex...</a> \r\n<br /><br />\r\nEvery template built on Vertex also comes with it&#39;s own unique template specific options applicable to that particular template such as highlight colors, social icons, and much more. These features are in addition to the standard functions of Vertex, and are still controlled through the very user friendly interface of Vertex. This page will document the features specific to this template.\r\n\r\n<br /><br /><br />\r\n<h2>Template Specific Configuration Interface of Vertex</h2><br />\r\nBelow is a screenshot that shows all the template specific features available in the user friendly Vertex admin:<br /><br />\r\n<img class="padded" src="images/template_specific.png"></img>\r\n\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Custom Highlight Colors</h2><br />\r\nNeed your own custom color scheme? Not a problem, this template Sienna comes with ultimate color control! With four highlight colors of your choice you can set titles, hyperlinks, buttons, backgrounds, and much more to any color you wish! This color can easily be set in the template configuration area. Below are some examples of custom color schemes created through the highlight color options.  \r\n<br /><br />\r\n<img class="padded" src="images/example1.jpg"></img><br />\r\n<img class="padded" src="images/example2.jpg"></img><br />\r\n\r\n\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Custom Highlight Font</h2><br />\r\nUse Google Fonts to set your own custom highlight font. There are dozens of fonts to choose from.  \r\n<br /><br />\r\n<img class="padded" src="images/font_example.jpg"></img><br />\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Social Icons</h2><br />\r\nEasily link to a social media site with the built in social icons found in the header of this template. Simply enter the url of your social site in the configuration and the icon will automatically appear. To disable an icon simply leave the url blank for that particular icon. \r\n<br /><br />\r\n<img class="padded" src="images/social.jpg"></img><br />\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Uppercase Letters</h2><br />\r\nAs you can see from this demo there are a lot of uppercase letters used in articles, modules, titles, etc. If you don&#39;t want to use uppercase letters simply turn them off in the configuration. \r\n<br /><br />\r\n<img class="padded" src="images/uppercase1.jpg"></img><br />\r\n<img class="padded" src="images/uppercase2.jpg"></img><br />\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Small Menu</h2><br />\r\nOn this template you can have subtext on the first level parent items. If you choose not to use subtext on these links simply choose a small menu option and the menu will automatically down size.\r\n<br /><br />\r\n<img class="padded" src="images/small_menu1.jpg"></img><br />\r\n<img class="padded" src="images/small_menu2.jpg"></img><br />\r\n\r\n\r\n\r\n\r\n<br /><br /><br />\r\n<h2>Custom Logo Size</h2><br />\r\nNeed a little bit more room for your logo? That&#39;s simple, just enter in the dimensions you need to fit your log and the header will automatically adjust. Keep in mind that if you are using the banner position, that you will want to leave enough room for that module position.\r\n<br /><br /><br /><br />', '', 1, 0, 0, 8, '2010-08-13 18:57:50', 62, '', '2012-01-31 14:10:40', 42, 0, '0000-00-00 00:00:00', '2010-08-13 18:57:50', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"0","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 46, 0, 10, '', '', 1, 123, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(204, 65, 'Google Fonts Enabled', 'google-fonts-enabled', '', 'Do you want your own custom font? Not a problem, this template comes with Google Fonts enabled, allowing you to pick from over a dozen font families for your website. In the template parameters area of the template you can choose your own custom font, and preview it from the Vertex interface. Below are some examples of the fonts available.<br/><br/>\r\n\r\n<img alt="" src="http://www.shape5.com/demo/images/general/google_fonts.png"></img>\r\n\r\n<br />\r\n<br /><br />\r\n\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div><br /></ul>', '', 1, 0, 0, 8, '2010-10-08 19:08:51', 62, '', '2011-12-13 19:44:03', 62, 0, '0000-00-00 00:00:00', '2010-10-08 19:08:51', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 7, 0, 9, '', '', 1, 22, '', 0, '*', ''),
(208, 66, 'Sample Article', 'sample-article', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.</p>', 'erwerwere', 1, 0, 0, 8, '2010-02-06 23:35:25', 62, '', '2011-10-05 19:29:03', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 6, 0, 8, '', '', 1, 42, '', 0, '*', '');
INSERT INTO `#__content` (`id`, `asset_id`, `title`, `alias`, `title_alias`, `introtext`, `fulltext`, `state`, `sectionid`, `mask`, `catid`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `version`, `parentid`, `ordering`, `metakey`, `metadesc`, `access`, `hits`, `metadata`, `featured`, `language`, `xreference`) VALUES
(211, 67, 'Mobile Device Ready!', 'mobile-device-ready', '', '<br /><img src="images/mobile_device.png" style="float:left; margin-right:20px"><h3>Need Mobile Device Support?</h3>\r\n<br />\r\nNo problem! This template comes with built in functionality to support popular mobile devices such as iPhone, Android, Blackberry, Windows Mobile and more. The mobile layout contains a mobile menu system, login and register functionality, and the following module positions: search, breadcrumb, mobile_top_1, mobile_top_2, mobile_bottom_1, and mobile_bottom_3. The mobile module positions are unique to the mobile device layout and will only show in this layout. Along with these functions users will also be presented an option to switch to the main PC version of the site. This feature can easily be enabled or disabled from the template configuration.\r\n\r\n<div style="clear:both; height:0px"></div>\r\n\r\n  <div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', 1, 0, 0, 8, '2010-12-13 23:28:26', 62, '', '2011-12-13 20:02:53', 62, 0, '0000-00-00 00:00:00', '2010-12-13 23:28:26', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":0,"show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 14, 0, 7, '', '', 1, 31, '', 0, '*', ''),
(212, 68, 'CSS Tableless Overrides', 'css-tableless-overrides', '', 'This template comes with CSS tabless overrides for the main Joomla content, overriding the default table layout. This makes your content much more accessible to search engines.\r\n<br /><br />\r\n<div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', 1, 0, 0, 8, '2010-12-13 23:29:23', 62, '', '2010-12-14 21:17:58', 62, 0, '0000-00-00 00:00:00', '2010-12-13 23:29:23', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 4, 0, 24, '', '', 1, 12, '', 0, '*', ''),
(214, 69, 'Fixed Side Tabs', 'fixed-side-tabs', '', 'This template includes a "Fixed Tab" option that you can enable and publish on your site and will show in a fixed position on either the left or right side of the screen. The great feature about the fixed tabs is that you can enter any text you desire and the text is automatically flipped vertically! This is great for search engines to read your text and also saves the hassle of creating an image with vertical text and placing it on the side of your site. The tabs are published site wide and can have the following options that can be changed via the template parameters area and can link to any URL that you desire.\r\n\r\n\r\n<br /><br /><h3>The following is a quick list of features: </h3></p>\r\n<ul class="ul_star">\r\n<li>Change background to any hex color </li>\r\n<li>Change the border to any hex color</li>\r\n<li>Change the font to any hex color</li>\r\n<li>Set vertical position of each tab</li>\r\n<li>Set the height of each tab</li>\r\n<li>Set each tab to either the left or right of the screen</li>\r\n<li>Add a class to each fixed tab to enable s5 box or perhaps a lightbox or other 3rd party extension</li>\r\n<li>Add a URL to each fixed tab so onclick the URL loads</li>\r\n<li>Enter any text you desire</li>\r\n</ul>\r\n\r\n<br /><br />   <div class="blue_box"><strong>I like what I see! I want to <a href="http://www.shape5.com/join-now.html" target="_top">JOIN TODAY</a>.</strong></div>', '', 1, 0, 0, 8, '2010-12-13 23:40:43', 62, '', '2011-10-11 18:24:30', 62, 0, '0000-00-00 00:00:00', '2010-12-13 23:40:43', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 5, 0, 6, '', '', 1, 9, '', 0, '*', ''),
(227, 70, 'Menu Scroll To Section', 'menu-scroll-to-section', '', 'This template includes a scroll to feature that will scroll your page to a specified section of your site. All you have to do is create an external link in your menu manager and then in the URL area enter in any ID on your page. You can reference any of the following IDs in order:<br /><br />\r\n\r\n<ul class="ul_bullet_small">\r\n<li>#s5_header_area1</li>\r\n<li>#s5_top_row1_area1</li>\r\n<li>#s5_top_row2_area1</li>\r\n<li>#s5_top_row3_area1</li>\r\n<li>#s5_center_area1</li>\r\n<li>#s5_bottom_row1_area1</li>\r\n<li>#s5_bottom_row2_area1</li>\r\n<li>#s5_bottom_row3_area1</li>\r\n<li>#s5_footer_area1</li>\r\n\r\n</ul>\r\n<br />\r\nScreenshot of admin area of an external menu item with DIV reference entered:<br /><br />\r\n\r\n<img border="0" src="http://www.shape5.com/demo/images/general/scrollto.jpg" style="">', '', 1, 0, 0, 8, '2011-06-10 21:35:45', 62, '', '2011-10-11 18:11:00', 62, 0, '0000-00-00 00:00:00', '2011-06-10 21:35:45', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 4, 0, 5, '', '', 1, 15, '', 0, '*', ''),
(228, 71, 'IE7 and 8 CSS3 Support', 'ie7-and-8-css3-support', '', 'This template includes limited support of CSS3 for IE7 and IE8. With the power of css3, websites can now be built much faster and with far \r\nless code. Design features such as gradients or shadows that used to be \r\ncreated and then called as images on the page are now simply called \r\nby css code. Transition effects that used to require full javascript libraries can \r\nnow be called with less than 1kb of text. Rounded corners that used to \r\nrequire upwards of eight wrapping div elements can now be done with a \r\nsingle element. What does this mean for you? Simple, a lightning fast website, \r\nthat becomes even more search engine friendly. \r\n\r\n<br /><br />Many modern browsers such as Firefox4 of IE9 already support CSS3 natively, but where does that leave IE7 and IE8? Thankfully a great solution called CSS PIE (Progressive Internet Explorer) has been introduced and is integrated into this template. Simply put, CSS PIE a script that upgrades IE7 and 8 to support most CSS3 formatting.  There are slight variations and some CSS3 formatting isn&#39;t supported, but overall it does a great job and allows us to extend CSS3 support to IE7 and 8.', '', 1, 0, 0, 8, '2011-06-10 21:37:19', 62, '', '2011-06-12 20:47:26', 62, 0, '0000-00-00 00:00:00', '2011-06-10 21:37:19', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 2, 0, 4, '', '', 1, 10, '', 0, '*', ''),
(230, 72, 'Lazy Load Images', 'lazy-load-images', '', 'The lazy load script is a great way to save bandwidth and load your pages much faster. Images that are not visible on the initial page load are not loaded or downloaded until they come into the main viewing area. Once an image comes into view it is then downloaded and faded into visibility. Scroll down this page to see the script in action.\r\n\r\n<br /><br />\r\n\r\nSetup is very easy! By default this script is disabled, in order to enable it simply choose All Images or Individual Images from the drop down, as shown below from inside the template configuration page.\r\n\r\n<br /><br />\r\n\r\n<img class="padded" src="http://www.shape5.com/demo/images/general/lazy_load.png" alt=""></img>\r\n\r\n<br /><br />\r\n\r\nAll images will load every standard image on the page with lazy load. There is no extra configuration or extra code to add with this configuration, it will just happen automatically. Individual images would be used if you want only certain images to load with this script and not all of them. To do this simply add class="s5_lazyload" to the image like so:\r\n\r\n<br />\r\n\r\n<div class="code">\r\n\r\n&lt;img class=&quot;s5_lazyload&quot; src=&quot;http://www.yoursite.com/image.jpg&quot;&gt;&lt;/img&gt;\r\n\r\n</div>\r\n\r\n<br /><br />\r\nThis script is compatible with Firefox3+, IE8+, Chrome14+, Safari5.05+, Opera 11.11+\r\n<br /><br />\r\n<h3>See the script in action:</h3>\r\n<br />\r\n\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load1.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load2.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load3.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load4.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load5.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load6.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load7.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load8.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load9.jpg" alt="" class="s5_lazyload padded"></img>\r\n<img src="http://www.shape5.com/demo/images/general/lazyload/lazy_load10.jpg" alt="" class="s5_lazyload padded"></img>', '', 1, 0, 0, 8, '2011-08-12 18:35:45', 62, '', '2011-12-13 19:39:24', 62, 0, '0000-00-00 00:00:00', '2011-08-12 18:35:45', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 15, 0, 3, '', '', 1, 30, '', 0, '*', ''),
(231, 73, 'Hide Article Component Area', 'hide-article-component-area', '', 'Did you ever need to create a page where this is no article present or no component to be shown, and only load modules? This template makes it all possible! From the template configuration page you can hide the main content area on any page on the site. \r\n\r\n<br /><br />\r\n\r\nBelow is a screenshot of this function from the configuration page, found under the General tab:\r\n\r\n<br /><br />\r\n\r\n<img class="padded" src="http://www.shape5.com/demo/images/general/hide_articles.png" alt=""></img>', '', 1, 0, 0, 8, '2011-08-12 18:37:35', 62, '', '2011-12-13 19:40:25', 62, 0, '0000-00-00 00:00:00', '2011-08-12 18:37:35', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 6, 0, 2, '', '', 1, 14, '', 0, '*', ''),
(233, 74, 'S5 Drop Down Panel', 's5-drop-down-panel', '', 'The S5 Drop Down Panel is a slide down panel that can be demo&#39;d at the top of this page. The panel itself contains six module positions. You may publish any module that you wish into these positions. It comes packed with features so be sure to check out the list and screenshot below.\r\n<br />\r\n<br />\r\n<img alt="" style="border:1px solid #CCCCCC" class="padded" src="http://www.shape5.com/demo/images/general/dropdown_tab.png">\r\n<br />\r\n<br />\r\n<ul class="ul_star"> \r\n<li>Customize almost everything! Shadows, borders, gradient, opacity</li> \r\n<li>Contains 6 module positions drop_down_1, drop_down_2, drop_down_3, drop_down_4, drop_down_5 and drop_down_6</li>\r\n<li>Auto adjust to the height of your content</li> \r\n<li>Set your own open and close text</li> \r\n<li>Auto collapse if no modules are published to it</li>\r\n<li>And many more features!</li>\r\n</ul>\r\n<br />\r\n<br />\r\n<h3>Screenshot of Drop Down admin in template configuration area:</h3><br />\r\n<img alt="" style="border:1px solid #CCCCCC" class="padded" src="http://www.shape5.com/demo/images/general/dropdown.png">', '', 1, 0, 0, 8, '2011-08-13 14:54:51', 62, '', '2011-12-13 19:41:31', 62, 0, '0000-00-00 00:00:00', '2011-08-13 14:54:51', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 10, 0, 1, '', '', 1, 20, '', 0, '*', ''),
(234, 75, 'Sample Article', 'sample-article', '', 'Lorem domec sit amet nibh. Viva lacer elitem mus lorem etnon arcu. Lorem amet via\r\nipsum dolor sit amet, lacer sit emru consectetur adipiscing elit.', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.', 1, 0, 0, 9, '2010-02-06 23:35:25', 62, '', '2011-10-10 20:50:46', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 3, 0, 6, '', '', 1, 0, '', 0, '*', ''),
(235, 76, 'Sample Article', 'sample-article', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur.', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.', 1, 0, 0, 9, '2010-02-06 23:35:25', 62, '', '2011-10-10 20:50:33', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 5, 0, 5, '', '', 1, 0, '', 0, '*', ''),
(236, 77, 'Sample Article', 'sample-article', '', 'Donec sit amet nibh. Viva lacer elitem mus lorem etnon arcu. Lorem amet via\r\nipsum dolor sit amet, lacer sit emru consectetur adipiscing elit.', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.', 1, 0, 0, 9, '2010-02-06 23:35:25', 62, '', '2011-10-10 20:49:45', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 3, 0, 4, '', '', 1, 0, '', 0, '*', ''),
(237, 78, 'Sample Article', 'sample-article', '', 'Viva lacer elitem mus non arcu em mus non arcu. Lorem ipsum dolor sit amet, lacer non consectetur adipiscing elit. Viva lacer elitem mus lor em et non. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.', 1, 0, 0, 9, '2010-02-06 23:35:25', 62, '', '2011-12-07 20:39:51', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 10, 0, 3, '', '', 1, 0, '', 0, '*', ''),
(242, 79, 'Sample Article', 'sample-article', '', 'Donec sit amet nibh. Viva lacer elitem mus lorem etnon arcu. Lorem amet via ipsum dolor sit amet, lacer sit emru consectetur adipiscing elit. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, consectetur adipiscing elit. id faEtiam dapibus, sit ame tellus a ucibus. tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. id faEtiam dapibus, tellus a ucibus. Donec sit amet nibh. Viva mus non arcu. Lorem ipsum dolor sit amet, consectetur. Donec sit am et nibh. Viva mus arcu. Lorem ipsu.', 1, 0, 0, 9, '2010-02-06 23:35:25', 62, '', '2011-10-10 23:10:49', 62, 0, '0000-00-00 00:00:00', '2010-02-06 23:35:25', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":1,"show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 1, 0, 2, '', '', 1, 0, '', 0, '*', ''),
(243, 80, 'Newsflash Article 3', 'newsflash-article-3', '', '<img src="images/nf_3.jpg" style="float:left;margin-bottom:1px" class="padded" alt=""></img>\r\n\r\nIpsum lorem dolor sit amet, consectetur\r\nscing elit. Fusce a sollicitudin ligula vesti\r\nhoncus sollicitudin elementum. ipsum do \r\nsit amet Nulla a erat et lectus venenatis\r\nlectus ut telus.\r\n\r\n\r\n\r\n', '\r\n<br />\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n<br />\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.', 1, 0, 0, 10, '2011-12-09 23:53:51', 62, '', '2011-12-14 18:55:26', 62, 0, '0000-00-00 00:00:00', '2011-12-09 23:53:51', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 7, 0, 3, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(244, 81, 'Newsflash Article 2', 'newsflash-article-2', '', '<img class="padded" src="images/nf_2.jpg" border="0" alt="" style="float: left;" /> Nibh aliquam parturient proin convallis nunc dui suspendisse maecenas nascetur. In Pellentesque tempor auctor semper eu sit Aenean ut odio gravida. Auctor urna convallis curabitur ipsum.\r\n', '\r\n<p><br /> Lorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin convallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper eu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare Vivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. Libero ac justo lorem Vivamus purus lacus lobortis leo nec. <br /> Libero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris mi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.</p>', -2, 0, 0, 10, '2011-12-10 23:53:00', 62, '', '2011-12-14 18:54:40', 62, 0, '0000-00-00 00:00:00', '2011-12-09 23:53:51', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 6, 0, 2, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(245, 82, 'Newsflash Article 1', 'newsflash-article-1', '', '<p><img class="padded" src="images/nf_1.jpg" border="0" alt="" style="float: left;" /> Lorem ipsum dolor sit amet, consectetur scing elit. Fusce a sollicitudin ligula vesti honcus sollicitudin elementum. ipsum do sit amet Nulla a erat et lectus venenatis lectus ut odio.</p>\r\n', '\r\n<p><br /> Lorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin convallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper eu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare Vivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. Libero ac justo lorem Vivamus purus lacus lobortis leo nec. <br /> Libero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris mi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.</p>', -2, 0, 0, 10, '2011-12-11 23:53:00', 62, '', '2011-12-14 18:52:45', 62, 0, '0000-00-00 00:00:00', '2011-12-09 23:53:51', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 2, 0, 1, '', '', 1, 1, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', ''),
(246, 83, 'Muse Takes To The Stage in London', 'muse-takes-to-the-stage-in-london', '', '<img alt="" class="boxed" src="images/article1.jpg"></img>\r\n\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n<br /><br />\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-12-14 00:46:00', 62, '', '2011-12-14 20:24:54', 62, 0, '0000-00-00 00:00:00', '2011-12-14 00:46:00', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 9, 0, 6, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(247, 84, 'David Guetta''s Tour Starts Soon', 'david-guettas-tour-starts-soon', '', '<img alt="" class="boxed" src="images/article2.jpg"></img>\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n<br /><br />\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-12-13 00:00:00', 62, '', '2011-12-14 20:25:08', 62, 0, '0000-00-00 00:00:00', '2011-12-13 00:56:00', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 7, 0, 5, '', '', 1, 132, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(248, 85, 'Maroon 5 Nominated For a Grammy', 'maroon-5-nominated-for-a-grammy', '', '<img alt="" class="boxed" src="images/article3.jpg"></img>\r\n\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n<br /><br />\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-12-12 00:00:00', 62, '', '2011-12-14 20:25:16', 62, 0, '0000-00-00 00:00:00', '2011-12-12 01:00:00', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","alternative_readmore":"","article_layout":""}', 7, 0, 4, '', '', 1, 6, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(249, 86, 'A Review of King''s of Leon', 'a-review-of-kings-of-leon', '', '<img alt="" class="boxed" src="images/article4.jpg"></img>\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n<br /><br />\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-11-30 00:00:00', 62, '', '2011-12-10 01:12:48', 62, 0, '0000-00-00 00:00:00', '2011-12-10 00:56:17', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 3, 0, 3, '', '', 1, 0, '', 1, '*', ''),
(250, 87, 'All New Music For 2012', 'all-new-music-for-2012', '', '<img alt="" class="boxed" src="images/article5.jpg"></img>\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n<br /><br />\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-11-22 00:00:00', 62, '', '2011-12-10 01:13:25', 62, 0, '0000-00-00 00:00:00', '2011-12-10 01:12:49', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 2, 0, 2, '', '', 1, 0, '', 1, '*', ''),
(251, 88, 'Linkin Park Live and In Concert', 'linkin-park-live-and-in-concert', '', '<img alt="" class="boxed" src="images/article6.jpg"></img>\r\nLibero tellus sit ipsum ante eu Curabitur nibh Sed Pellentesque nisl. Nibh quis laoreet mauris \r\nmi est quis nibh porttitor ac pulvinar. Condimentum facilisi Phasellus tempus wisi facilisi ut.\r\n<br /><br />\r\nLorem ipsum dolor sit amet consectetuer lacus vel dui leo enim. Nibh aliquam parturient Proin \r\nconvallis Nunc a dui Suspendisse Maecenas nascetur. In Pellentesque tempor auctor semper \r\neu sit Aenean ut odio gravida. Auctor urna convallis Curabitur interdum ipsum tellus ornare \r\nVivamus augue tellus. Metus enim iaculis et interdum quis habitasse lacinia habitant metus id. \r\nLibero ac justo lorem Vivamus purus lacus lobortis leo nec.\r\n\r\n', '\r\n<br /><br />\r\nNunc rutrum scelerisque ipsum ut aliquet. Duis et augue nunc, gravida fermentum mi. Quisque sed dui enim. Mauris ultricies, tellus ac semper consequat, enim tellus convallis lacus, sit amet tempus mauris nibh non turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', -2, 0, 0, 21, '2011-11-29 00:00:00', 62, '', '2011-12-12 19:32:58', 62, 0, '0000-00-00 00:00:00', '2011-12-10 00:56:17', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":"","show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 1, 0, 1, '', '', 1, 0, '', 1, '*', ''),
(252, 89, 'Shape 5 Image Slide V2', 'shape-5-image-slide-v2', '', 'The S5 Image Slide module can be viewed at the top of this page. This module allows for up to 10 images or modules and includes navigation arrows, play/pause buttons and preview images of each slide. Each image or module is treated a slide.\r\n\r\n\r\n\r\n\r\n\r\n<br/><br/>\r\n<strong>Features:</strong><br/>\r\n<ul class="ul_bullet_small"> \r\n<li>Choose from several effects</li> \r\n<li>Up to 10 images</li>\r\n<li>Up to 10 module positions if using module mode</li>\r\n<li>Choose auto rotate or manual rotate</li>\r\n<li>Show/Hide: thumbnails, navigation arrows and pause/play buttons</li>\r\n<li>Set links to each image and define if they show in a new window or in the same</li>\r\n<li>Set the width and height of the module</li>\r\n</ul>\r\n\r\n', '\r\n<br/><br/>\r\n<h3>Module tutorial:</h3><br/>\r\nSimply install and publish the s5 tab show module to your desired module position and pages. Then start publishing modules to the positions in the image slide module (imageslide_1, imageslide_2, etc); these modules will become the slides. Be sure to do them in order, not imageslide_1 and then imageslide_4.  Be sure they are in sequential order.\r\n\r\n<br /><br />\r\nBelow is the code used for the first slide on this demo:\r\n<br /><br />\r\n\r\n<div class="code">\r\n<p>&lt;div onclick=&quot;window.document.location.href=&#39;http://www.yourlink.com&#39;&quot; \r\nstyle=&quot;cursor:pointer; background:url(images/is_1.jpg); width:583px; height:305px&quot;&gt;</p>\r\n<p><br />\r\n&lt;div class=&quot;s5_image_slide_text_large&quot;&gt;<br />\r\nThirty Seconds to Mars - This is War<br />\r\n&lt;/div&gt;</p>\r\n<p><br />\r\n&lt;div style=&quot;clear:both;height:0px&quot;&gt;&lt;/div&gt;</p>\r\n<p><br />\r\n&lt;div class=&quot;s5_image_slide_text_small&quot;&gt;<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit sed gravida amite ait.<br />\r\n&lt;/div&gt;</p>\r\n<p><br />\r\n&lt;/div&gt;</p>\r\n</div>\r\n\r\n\r\n<br/><br/>\r\n<h3>Image Tutorial:</h3><br/>\r\nAfter installing the module simply publish it to your site and add URLs to images located on your server.  As you can see from the below screenshot you need to enter the URLs to the images, once this is done the fader will start cycling through the images, be sure to add them in order from 1 - 10.\r\n\r\n\r\n\r\n<br/><br/>\r\nScreenshot of S5 Image Slide Admin:<br/><br/>\r\n<center><img style="width:508px" src="images/imageslideadmin.jpg" alt="s5 image slide" /></center>', -2, 0, 0, 8, '2009-06-15 23:25:04', 62, '', '2011-12-13 21:29:23', 62, 0, '0000-00-00 00:00:00', '2009-06-15 23:25:04', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_vote":"","show_author":"","show_create_date":0,"show_modify_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","language":"","keyref":"","readmore":""}', 14, 0, 1, '', '', 1, 21, '', 0, '*', ''),
(253, 100, 'One of the Most Powerful Menu Systems', 'one-of-the-most-powerful-menu-systems', '', '<p>The S5 Flex Menu system is a powerful plugin that provides functionas beyond what the Joomla menu system provides. This plugin is an extension to add many new features!</p>', '', -2, 0, 0, 20, '2012-01-30 23:30:05', 42, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2012-01-30 23:30:05', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 1, 0, 3, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(254, 101, 'Lazy Load Images Save on Bandwidth', 'lazy-load-images-save-on-bandwidth', '', '<p>The lazy load script delays the loading of images until they are present in the viewing area of the browser, which dramatically decreases page load time and saves bandwidth. <a href="index.php/features-mainmenu-47/template-features/lazy-load-enabled">Read More...</a></p>', '', 1, 0, 0, 20, '2012-01-30 23:32:44', 42, '', '2012-01-30 23:39:53', 42, 0, '0000-00-00 00:00:00', '2012-01-30 23:32:44', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 2, 0, 2, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(255, 102, 'Hide The Main Article Area on Any page', 'hide-the-main-article-area-on-any-page', '', '<p>The Shape 5 Vertex framework allows you to hide the main Joomla component and article output on any page of your site so that you are not forced to have an article shown. <a class="readmore" href="index.php/features-mainmenu-47/template-features/hide-article-component-area">Read More...</a></p>', '', 1, 0, 0, 20, '2012-01-30 23:33:34', 42, '', '2012-01-30 23:38:23', 42, 0, '0000-00-00 00:00:00', '2012-01-30 23:33:34', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 3, 0, 1, '', '', 1, 1, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(256, 103, 'Custom Page and Column Widths', 'custom-page-and-column-widths', '', '<p>Set the entire width of your site to either a fixed pixel width or a fluid percentage width. Additionally, you can set the width of the columns, body and rows to any size you need. <a href="index.php/features-mainmenu-47/style-and-layout-options/page-row-and-column-widths">Read More...</a></p>', '', 1, 0, 0, 20, '2012-01-30 23:35:38', 42, '', '2012-01-30 23:39:06', 42, 0, '0000-00-00 00:00:00', '2012-01-30 23:35:38', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 2, 0, 0, '', '', 1, 0, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', ''),
(257, 104, '3rd Party Component Compatibility', '3rd-party-component-compatibility', '', 'This template is compatible with all the major 3rd party components available for Joomla. The following are just some of the ones available that work great with any Shape 5 template. A template itself should in no way hinder the functionality of a component. Although we haven''t tested every single Joomla component available we can say quite confidently that this template will be compatible with any Joomla extension you use with it.</p>\r\n<p /><img src="http://www.shape5.com/demo/images/general/3rdparty.png" border="0" /><br />and many more!', '', 1, 0, 0, 8, '2012-01-31 00:12:09', 42, '', '2012-01-31 03:02:15', 42, 0, '0000-00-00 00:00:00', '2012-01-31 00:12:09', '0000-00-00 00:00:00', '', '', '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}', 2, 0, 0, '', '', 1, 6, '{"robots":"","author":"","rights":"","xreference":""}', 0, '*', '');

-- --------------------------------------------------------

--
-- Table structure for table `#__content_frontpage`
--

DROP TABLE IF EXISTS `#__content_frontpage`;
CREATE TABLE IF NOT EXISTS `#__content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__content_frontpage`
--

INSERT INTO `#__content_frontpage` (`content_id`, `ordering`) VALUES
(45, 11),
(6, 12),
(44, 13),
(9, 14),
(30, 15),
(250, 6),
(249, 7),
(251, 5),
(248, 8),
(247, 9),
(246, 10),
(253, 4),
(254, 3),
(255, 2),
(256, 1);

-- --------------------------------------------------------

--
-- Table structure for table `#__content_rating`
--

DROP TABLE IF EXISTS `#__content_rating`;
CREATE TABLE IF NOT EXISTS `#__content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__content_rating`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__core_log_searches`
--

DROP TABLE IF EXISTS `#__core_log_searches`;
CREATE TABLE IF NOT EXISTS `#__core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__core_log_searches`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__extensions`
--

DROP TABLE IF EXISTS `#__extensions`;
CREATE TABLE IF NOT EXISTS `#__extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `access` int(10) unsigned DEFAULT NULL,
  `protected` tinyint(3) NOT NULL DEFAULT '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0',
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10035 ;

--
-- Dumping data for table `#__extensions`
--

INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES
(1, 'com_mailto', 'component', 'com_mailto', '', 0, 1, 1, 1, '{"legacy":false,"name":"com_mailto","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MAILTO_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(2, 'com_wrapper', 'component', 'com_wrapper', '', 0, 1, 1, 1, '{"legacy":false,"name":"com_wrapper","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_WRAPPER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(3, 'com_admin', 'component', 'com_admin', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_admin","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_ADMIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(4, 'com_banners', 'component', 'com_banners', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_banners","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_BANNERS_XML_DESCRIPTION","group":""}', '{"purchase_type":"3","track_impressions":"0","track_clicks":"0","metakey_prefix":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(5, 'com_cache', 'component', 'com_cache', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_cache","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CACHE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(6, 'com_categories', 'component', 'com_categories', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_categories","type":"component","creationDate":"December 2007","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CATEGORIES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(7, 'com_checkin', 'component', 'com_checkin', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_checkin","type":"component","creationDate":"Unknown","author":"Joomla! Project","copyright":"(C) 2005 - 2008 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CHECKIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(8, 'com_contact', 'component', 'com_contact', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_contact","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONTACT_XML_DESCRIPTION","group":""}', '{"contact_layout":"_:default","show_contact_category":"hide","show_contact_list":"0","presentation_style":"plain","show_name":"1","show_position":"1","show_email":"0","show_street_address":"1","show_suburb":"1","show_state":"1","show_postcode":"1","show_country":"1","show_telephone":"1","show_mobile":"1","show_fax":"1","show_webpage":"1","show_misc":"1","show_image":"1","image":"","allow_vcard":"0","show_articles":"0","show_profile":"0","show_links":"0","linka_name":"","linkb_name":"","linkc_name":"","linkd_name":"","linke_name":"","contact_icons":"0","icon_address":"","icon_email":"","icon_telephone":"","icon_mobile":"","icon_fax":"","icon_misc":"","category_layout":"_:default","show_category_title":"1","show_description":"1","show_description_image":"0","maxLevel":"-1","show_empty_categories":"0","show_subcat_desc":"1","show_cat_items":"1","show_base_description":"1","maxLevelcat":"-1","show_empty_categories_cat":"0","show_subcat_desc_cat":"1","show_cat_items_cat":"1","show_pagination_limit":"1","show_headings":"1","show_position_headings":"1","show_email_headings":"0","show_telephone_headings":"1","show_mobile_headings":"0","show_fax_headings":"0","show_suburb_headings":"1","show_state_headings":"1","show_country_headings":"1","show_pagination":"2","show_pagination_results":"1","initial_sort":"ordering","show_email_form":"1","show_email_copy":"1","banned_email":"","banned_subject":"","banned_text":"","validate_session":"1","custom_reply":"0","redirect":"","show_feed_link":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(9, 'com_cpanel', 'component', 'com_cpanel', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_cpanel","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CPANEL_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10, 'com_installer', 'component', 'com_installer', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_installer","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_INSTALLER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(11, 'com_languages', 'component', 'com_languages', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_languages","type":"component","creationDate":"2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_LANGUAGES_XML_DESCRIPTION","group":""}', '{"administrator":"en-GB","site":"en-GB"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(12, 'com_login', 'component', 'com_login', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_login","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(13, 'com_media', 'component', 'com_media', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_media","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MEDIA_XML_DESCRIPTION","group":""}', '{"upload_extensions":"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS","upload_maxsize":"10","file_path":"images","image_path":"images","restrict_uploads":"1","allowed_media_usergroup":"3","check_mime":"1","image_extensions":"bmp,gif,jpg,png","ignore_extensions":"","upload_mime":"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip","upload_mime_illegal":"text\\/html","enable_flash":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(14, 'com_menus', 'component', 'com_menus', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_menus","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MENUS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(15, 'com_messages', 'component', 'com_messages', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_messages","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MESSAGES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(16, 'com_modules', 'component', 'com_modules', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_modules","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_MODULES_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(17, 'com_newsfeeds', 'component', 'com_newsfeeds', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_newsfeeds","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_NEWSFEEDS_XML_DESCRIPTION","group":""}', '{"show_feed_image":"1","show_feed_description":"1","show_item_description":"1","feed_word_count":"0","show_headings":"1","show_name":"1","show_articles":"0","show_link":"1","show_description":"1","show_description_image":"1","display_num":"","show_pagination_limit":"1","show_pagination":"1","show_pagination_results":"1","show_cat_items":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(18, 'com_plugins', 'component', 'com_plugins', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_plugins","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_PLUGINS_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(19, 'com_search', 'component', 'com_search', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_search","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_SEARCH_XML_DESCRIPTION","group":""}', '{"enabled":"0","show_date":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(20, 'com_templates', 'component', 'com_templates', '', 1, 1, 1, 1, '{"legacy":false,"name":"com_templates","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_TEMPLATES_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(21, 'com_weblinks', 'component', 'com_weblinks', '', 1, 1, 1, 0, '{"legacy":false,"name":"com_weblinks","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_WEBLINKS_XML_DESCRIPTION","group":""}', '{"show_comp_description":"1","comp_description":"","show_link_hits":"1","show_link_description":"1","show_other_cats":"0","show_headings":"0","show_numbers":"0","show_report":"1","count_clicks":"1","target":"0","link_icons":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(22, 'com_content', 'component', 'com_content', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_content","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONTENT_XML_DESCRIPTION","group":""}', '{"article_layout":"_:default","show_title":"1","link_titles":"1","show_intro":"1","show_category":"1","link_category":"1","show_parent_category":"0","link_parent_category":"0","show_author":"1","link_author":"0","show_create_date":"0","show_modify_date":"0","show_publish_date":"1","show_item_navigation":"1","show_vote":"0","show_readmore":"1","show_readmore_title":"1","readmore_limit":"100","show_icons":"1","show_print_icon":"1","show_email_icon":"1","show_hits":"0","show_noauth":"0","urls_position":"0","show_publishing_options":"1","show_article_options":"1","show_urls_images_frontend":"0","show_urls_images_backend":"0","targeta":0,"targetb":0,"targetc":0,"float_intro":"right","float_fulltext":"right","category_layout":"_:blog","show_category_title":"0","show_description":"0","show_description_image":"0","maxLevel":"1","show_empty_categories":"0","show_no_articles":"1","show_subcat_desc":"1","show_cat_num_articles":"0","show_base_description":"1","maxLevelcat":"-1","show_empty_categories_cat":"0","show_subcat_desc_cat":"1","show_cat_num_articles_cat":"1","num_leading_articles":"1","num_intro_articles":"4","num_columns":"2","num_links":"4","multi_column_order":"0","show_subcategory_content":"0","show_pagination_limit":"1","filter_field":"hide","show_headings":"1","list_show_date":"0","date_format":"","list_show_hits":"1","list_show_author":"1","orderby_pri":"order","orderby_sec":"rdate","order_date":"published","show_pagination":"2","show_pagination_results":"1","show_feed_link":"1","feed_summary":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(23, 'com_config', 'component', 'com_config', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_config","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_CONFIG_XML_DESCRIPTION","group":""}', '{"filters":{"1":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"6":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"7":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"2":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"3":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"4":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"5":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"8":{"filter_type":"BL","filter_tags":"","filter_attributes":""}}}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(24, 'com_redirect', 'component', 'com_redirect', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_redirect","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_REDIRECT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(25, 'com_users', 'component', 'com_users', '', 1, 1, 0, 1, '{"legacy":false,"name":"com_users","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"COM_USERS_XML_DESCRIPTION","group":""}', '{"allowUserRegistration":"1","new_usertype":"2","useractivation":"1","frontend_userparams":"1","mailSubjectPrefix":"","mailBodySuffix":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(100, 'PHPMailer', 'library', 'phpmailer', '', 0, 1, 1, 1, '{"legacy":false,"name":"PHPMailer","type":"library","creationDate":"2008","author":"PHPMailer","copyright":"Copyright (C) PHPMailer.","authorEmail":"","authorUrl":"http:\\/\\/phpmailer.codeworxtech.com\\/","version":"2.5.0","description":"LIB_PHPMAILER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(101, 'SimplePie', 'library', 'simplepie', '', 0, 1, 1, 1, '{"legacy":false,"name":"SimplePie","type":"library","creationDate":"2008","author":"SimplePie","copyright":"Copyright (C) 2008 SimplePie","authorEmail":"","authorUrl":"http:\\/\\/simplepie.org\\/","version":"1.0.1","description":"LIB_SIMPLEPIE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(102, 'phputf8', 'library', 'phputf8', '', 0, 1, 1, 1, '{"legacy":false,"name":"phputf8","type":"library","creationDate":"2008","author":"Harry Fuecks","copyright":"Copyright various authors","authorEmail":"","authorUrl":"http:\\/\\/sourceforge.net\\/projects\\/phputf8","version":"2.5.0","description":"LIB_PHPUTF8_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(103, 'Joomla! Web Application Framework', 'library', 'joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"Joomla! Web Application Framework","type":"library","creationDate":"2008","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"http:\\/\\/www.joomla.org","version":"2.5.0","description":"LIB_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(200, 'mod_articles_archive', 'module', 'mod_articles_archive', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_archive","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters.\\n\\t\\tAll rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(201, 'mod_articles_latest', 'module', 'mod_articles_latest', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LATEST_NEWS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(202, 'mod_articles_popular', 'module', 'mod_articles_popular', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_articles_popular","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(203, 'mod_banners', 'module', 'mod_banners', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_banners","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_BANNERS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(204, 'mod_breadcrumbs', 'module', 'mod_breadcrumbs', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_breadcrumbs","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_BREADCRUMBS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(205, 'mod_custom', 'module', 'mod_custom', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(206, 'mod_feed', 'module', 'mod_feed', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FEED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(207, 'mod_footer', 'module', 'mod_footer', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_footer","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FOOTER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(208, 'mod_login', 'module', 'mod_login', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_login","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(209, 'mod_menu', 'module', 'mod_menu', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_menu","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_MENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(210, 'mod_articles_news', 'module', 'mod_articles_news', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_articles_news","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_NEWS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(211, 'mod_random_image', 'module', 'mod_random_image', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_random_image","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_RANDOM_IMAGE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(212, 'mod_related_items', 'module', 'mod_related_items', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_related_items","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_RELATED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(213, 'mod_search', 'module', 'mod_search', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_search","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SEARCH_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(214, 'mod_stats', 'module', 'mod_stats', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_stats","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_STATS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(215, 'mod_syndicate', 'module', 'mod_syndicate', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_syndicate","type":"module","creationDate":"May 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SYNDICATE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(216, 'mod_users_latest', 'module', 'mod_users_latest', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_users_latest","type":"module","creationDate":"December 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_USERS_LATEST_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(217, 'mod_weblinks', 'module', 'mod_weblinks', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_weblinks","type":"module","creationDate":"July 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WEBLINKS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(218, 'mod_whosonline', 'module', 'mod_whosonline', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_whosonline","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WHOSONLINE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(219, 'mod_wrapper', 'module', 'mod_wrapper', '', 0, 1, 1, 0, '{"legacy":false,"name":"mod_wrapper","type":"module","creationDate":"October 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_WRAPPER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(220, 'mod_articles_category', 'module', 'mod_articles_category', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_category","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(221, 'mod_articles_categories', 'module', 'mod_articles_categories', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_articles_categories","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(222, 'mod_languages', 'module', 'mod_languages', '', 0, 1, 1, 1, '{"legacy":false,"name":"mod_languages","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LANGUAGES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(300, 'mod_custom', 'module', 'mod_custom', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(301, 'mod_feed', 'module', 'mod_feed', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_FEED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(302, 'mod_latest', 'module', 'mod_latest', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LATEST_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(303, 'mod_logged', 'module', 'mod_logged', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_logged","type":"module","creationDate":"January 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGGED_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(304, 'mod_login', 'module', 'mod_login', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_login","type":"module","creationDate":"March 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(305, 'mod_menu', 'module', 'mod_menu', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_menu","type":"module","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_MENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(306, 'mod_online', 'module', 'mod_online', '', 1, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(307, 'mod_popular', 'module', 'mod_popular', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_popular","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(308, 'mod_quickicon', 'module', 'mod_quickicon', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_quickicon","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_QUICKICON_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(309, 'mod_status', 'module', 'mod_status', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_status","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_STATUS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(310, 'mod_submenu', 'module', 'mod_submenu', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_submenu","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_SUBMENU_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(311, 'mod_title', 'module', 'mod_title', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_title","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_TITLE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(312, 'mod_toolbar', 'module', 'mod_toolbar', '', 1, 1, 1, 1, '{"legacy":false,"name":"mod_toolbar","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"MOD_TOOLBAR_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(313, 'mod_multilangstatus', 'module', 'mod_multilangstatus', '', 1, 1, 1, 0, '{"legacy":false,"name":"mod_multilangstatus","type":"module","creationDate":"September 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"1.7.1","description":"MOD_MULTILANGSTATUS_XML_DESCRIPTION","group":""}', '{"cache":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(400, 'plg_authentication_gmail', 'plugin', 'gmail', 'authentication', 0, 0, 1, 0, '{"legacy":false,"name":"plg_authentication_gmail","type":"plugin","creationDate":"February 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_GMAIL_XML_DESCRIPTION","group":""}', '{"applysuffix":"0","suffix":"","verifypeer":"1","user_blacklist":""}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(401, 'plg_authentication_joomla', 'plugin', 'joomla', 'authentication', 0, 1, 1, 1, '{"legacy":false,"name":"plg_authentication_joomla","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_AUTH_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(402, 'plg_authentication_ldap', 'plugin', 'ldap', 'authentication', 0, 0, 1, 0, '{"legacy":false,"name":"plg_authentication_ldap","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LDAP_XML_DESCRIPTION","group":""}', '{"host":"","port":"389","use_ldapV3":"0","negotiate_tls":"0","no_referrals":"0","auth_method":"bind","base_dn":"","search_string":"","users_dn":"","username":"admin","password":"bobby7","ldap_fullname":"fullName","ldap_email":"mail","ldap_uid":"uid"}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(404, 'plg_content_emailcloak', 'plugin', 'emailcloak', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_emailcloak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION","group":""}', '{"mode":"1"}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(405, 'plg_content_geshi', 'plugin', 'geshi', 'content', 0, 0, 1, 0, '{"legacy":false,"name":"plg_content_geshi","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"","authorUrl":"qbnz.com\\/highlighter","version":"2.5.0","description":"PLG_CONTENT_GESHI_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(406, 'plg_content_loadmodule', 'plugin', 'loadmodule', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_loadmodule","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LOADMODULE_XML_DESCRIPTION","group":""}', '{"style":"none"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(407, 'plg_content_pagebreak', 'plugin', 'pagebreak', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_pagebreak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION","group":""}', '{"title":"1","multipage_toc":"1","showall":"1"}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(408, 'plg_content_pagenavigation', 'plugin', 'pagenavigation', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_pagenavigation","type":"plugin","creationDate":"January 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_PAGENAVIGATION_XML_DESCRIPTION","group":""}', '{"position":"1"}', '', '', 0, '0000-00-00 00:00:00', 5, 0),
(409, 'plg_content_vote', 'plugin', 'vote', 'content', 0, 1, 1, 1, '{"legacy":false,"name":"plg_content_vote","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_VOTE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 6, 0),
(410, 'plg_editors_codemirror', 'plugin', 'codemirror', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_codemirror","type":"plugin","creationDate":"28 March 2011","author":"Marijn Haverbeke","copyright":"","authorEmail":"N\\/A","authorUrl":"","version":"1.0","description":"PLG_CODEMIRROR_XML_DESCRIPTION","group":""}', '{"linenumbers":"0","tabmode":"indent"}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(411, 'plg_editors_none', 'plugin', 'none', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_none","type":"plugin","creationDate":"August 2004","author":"Unknown","copyright":"","authorEmail":"N\\/A","authorUrl":"","version":"2.5.0","description":"PLG_NONE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(412, 'plg_editors_tinymce', 'plugin', 'tinymce', 'editors', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors_tinymce","type":"plugin","creationDate":"2005-2011","author":"Moxiecode Systems AB","copyright":"Moxiecode Systems AB","authorEmail":"N\\/A","authorUrl":"tinymce.moxiecode.com\\/","version":"3.4.7","description":"PLG_TINY_XML_DESCRIPTION","group":""}', '{"mode":"1","skin":"0","compressed":"0","cleanup_startup":"0","cleanup_save":"2","entity_encoding":"raw","lang_mode":"0","lang_code":"en","text_direction":"ltr","content_css":"1","content_css_custom":"","relative_urls":"1","newlines":"0","invalid_elements":"script,applet,iframe","extended_elements":"","toolbar":"top","toolbar_align":"left","html_height":"550","html_width":"750","element_path":"1","fonts":"1","paste":"1","searchreplace":"1","insertdate":"1","format_date":"%Y-%m-%d","inserttime":"1","format_time":"%H:%M:%S","colors":"1","table":"1","smilies":"1","media":"1","hr":"1","directionality":"1","fullscreen":"1","style":"1","layer":"1","xhtmlxtras":"1","visualchars":"1","nonbreaking":"1","template":"1","blockquote":"1","wordcount":"1","advimage":"1","advlink":"1","autosave":"1","contextmenu":"1","inlinepopups":"1","safari":"0","custom_plugin":"","custom_button":""}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(413, 'plg_editors-xtd_article', 'plugin', 'article', 'editors-xtd', 0, 1, 1, 1, '{"legacy":false,"name":"plg_editors-xtd_article","type":"plugin","creationDate":"October 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_ARTICLE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(414, 'plg_editors-xtd_image', 'plugin', 'image', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_image","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_IMAGE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(415, 'plg_editors-xtd_pagebreak', 'plugin', 'pagebreak', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_pagebreak","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(416, 'plg_editors-xtd_readmore', 'plugin', 'readmore', 'editors-xtd', 0, 1, 1, 0, '{"legacy":false,"name":"plg_editors-xtd_readmore","type":"plugin","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_READMORE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(417, 'plg_search_categories', 'plugin', 'categories', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_categories","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(418, 'plg_search_contacts', 'plugin', 'contacts', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_contacts","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CONTACTS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(419, 'plg_search_content', 'plugin', 'content', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_content","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_CONTENT_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(420, 'plg_search_newsfeeds', 'plugin', 'newsfeeds', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_newsfeeds","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(421, 'plg_search_weblinks', 'plugin', 'weblinks', 'search', 0, 1, 1, 0, '{"legacy":false,"name":"plg_search_weblinks","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEARCH_WEBLINKS_XML_DESCRIPTION","group":""}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(422, 'plg_system_languagefilter', 'plugin', 'languagefilter', 'system', 0, 0, 1, 1, '{"legacy":false,"name":"plg_system_languagefilter","type":"plugin","creationDate":"July 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(423, 'plg_system_p3p', 'plugin', 'p3p', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_p3p","type":"plugin","creationDate":"September 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_P3P_XML_DESCRIPTION","group":""}', '{"headers":"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(424, 'plg_system_cache', 'plugin', 'cache', 'system', 0, 0, 1, 1, '{"legacy":false,"name":"plg_system_cache","type":"plugin","creationDate":"February 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CACHE_XML_DESCRIPTION","group":""}', '{"browsercache":"0","cachetime":"15"}', '', '', 0, '0000-00-00 00:00:00', 9, 0),
(425, 'plg_system_debug', 'plugin', 'debug', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"plg_system_debug","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_DEBUG_XML_DESCRIPTION","group":""}', '{"profile":"1","queries":"1","memory":"1","language_files":"1","language_strings":"1","strip-first":"1","strip-prefix":"","strip-suffix":""}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(426, 'plg_system_log', 'plugin', 'log', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_log","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_LOG_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 5, 0),
(427, 'plg_system_redirect', 'plugin', 'redirect', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_redirect","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_REDIRECT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 6, 0),
(428, 'plg_system_remember', 'plugin', 'remember', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_remember","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_REMEMBER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 7, 0),
(429, 'plg_system_sef', 'plugin', 'sef', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"plg_system_sef","type":"plugin","creationDate":"December 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SEF_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 8, 0),
(430, 'plg_system_logout', 'plugin', 'logout', 'system', 0, 1, 1, 1, '{"legacy":false,"name":"plg_system_logout","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(431, 'plg_user_contactcreator', 'plugin', 'contactcreator', 'user', 0, 0, 1, 1, '{"legacy":false,"name":"plg_user_contactcreator","type":"plugin","creationDate":"August 2009","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTACTCREATOR_XML_DESCRIPTION","group":""}', '{"autowebpage":"","category":"34","autopublish":"0"}', '', '', 0, '0000-00-00 00:00:00', 1, 0);
INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES
(432, 'plg_user_joomla', 'plugin', 'joomla', 'user', 0, 1, 1, 0, '{"legacy":false,"name":"plg_user_joomla","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2009 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_USER_JOOMLA_XML_DESCRIPTION","group":""}', '{"autoregister":"1"}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(433, 'plg_user_profile', 'plugin', 'profile', 'user', 0, 0, 1, 1, '{"legacy":false,"name":"plg_user_profile","type":"plugin","creationDate":"January 2008","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_USER_PROFILE_XML_DESCRIPTION","group":""}', '{"register-require_address1":"1","register-require_address2":"1","register-require_city":"1","register-require_region":"1","register-require_country":"1","register-require_postal_code":"1","register-require_phone":"1","register-require_website":"1","register-require_favoritebook":"1","register-require_aboutme":"1","register-require_tos":"1","register-require_dob":"1","profile-require_address1":"1","profile-require_address2":"1","profile-require_city":"1","profile-require_region":"1","profile-require_country":"1","profile-require_postal_code":"1","profile-require_phone":"1","profile-require_website":"1","profile-require_favoritebook":"1","profile-require_aboutme":"1","profile-require_tos":"1","profile-require_dob":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(434, 'plg_extension_joomla', 'plugin', 'joomla', 'extension', 0, 1, 1, 1, '{"legacy":false,"name":"plg_extension_joomla","type":"plugin","creationDate":"May 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(435, 'plg_content_joomla', 'plugin', 'joomla', 'content', 0, 1, 1, 0, '{"legacy":false,"name":"plg_content_joomla","type":"plugin","creationDate":"November 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CONTENT_JOOMLA_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(500, 'atomic', 'template', 'atomic', '', 0, 1, 1, 0, '{"legacy":false,"name":"atomic","type":"template","creationDate":"10\\/10\\/09","author":"Ron Severdia","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"contact@kontentdesign.com","authorUrl":"http:\\/\\/www.kontentdesign.com","version":"2.5.0","description":"TPL_ATOMIC_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(502, 'bluestork', 'template', 'bluestork', '', 1, 1, 1, 0, '{"legacy":false,"name":"bluestork","type":"template","creationDate":"07\\/02\\/09","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"TPL_BLUESTORK_XML_DESCRIPTION","group":""}', '{"useRoundedCorners":"1","showSiteName":"0","textBig":"0","highContrast":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(503, 'beez_20', 'template', 'beez_20', '', 0, 1, 1, 0, '{"legacy":false,"name":"beez_20","type":"template","creationDate":"25 November 2009","author":"Angie Radtke","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"a.radtke@derauftritt.de","authorUrl":"http:\\/\\/www.der-auftritt.de","version":"2.5.0","description":"TPL_BEEZ2_XML_DESCRIPTION","group":""}', '{"wrapperSmall":"53","wrapperLarge":"72","sitetitle":"","sitedescription":"","navposition":"center","templatecolor":"nature"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(436, 'plg_system_languagecode', 'plugin', 'languagecode', 'system', 0, 0, 1, 0, '{"legacy":false,"name":"plg_system_languagecode","type":"plugin","creationDate":"November 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 10, 0),
(505, 'beez5', 'template', 'beez5', '', 0, 1, 1, 0, '{"legacy":false,"name":"beez5","type":"template","creationDate":"21 May 2010","author":"Angie Radtke","copyright":"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.","authorEmail":"a.radtke@derauftritt.de","authorUrl":"http:\\/\\/www.der-auftritt.de","version":"2.5.0","description":"TPL_BEEZ5_XML_DESCRIPTION","group":""}', '{"wrapperSmall":"53","wrapperLarge":"72","sitetitle":"","sitedescription":"","navposition":"center","html5":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(600, 'English (United Kingdom)', 'language', 'en-GB', '', 0, 1, 1, 1, '{"legacy":false,"name":"English (United Kingdom)","type":"language","creationDate":"2008-03-15","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"en-GB site language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(601, 'English (United Kingdom)', 'language', 'en-GB', '', 1, 1, 1, 1, '{"legacy":false,"name":"English (United Kingdom)","type":"language","creationDate":"2008-03-15","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"en-GB administrator language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(700, 'files_joomla', 'file', 'joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"files_joomla","type":"file","creationDate":"January 2012","author":"Joomla! Project","copyright":"(C) 2005 - 2012 Open Source Matters. All rights reserved","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"FILES_JOOMLA_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10000, 'Our Poll', 'module', 'mod_poll', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10002, 'Popular Articles', 'module', 'mod_mostread', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10003, 'Archive', 'module', 'mod_archive', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10004, 'Sections', 'module', 'mod_sections', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10031, 'System - S5 Flex Menu', 'plugin', 'S5FlexMenu', 'system', 0, 1, 1, 0, '{"legacy":false,"name":"System - S5 Flex Menu","type":"plugin","creationDate":"June 2011","author":"Shape5.com","copyright":"This Plugin is released under the GNU\\/GPL License","authorEmail":"contact@shape5.com","authorUrl":"www.shape5.com","version":"1.0","description":"The S5 Flex Menu system is a very powerful plugin that provides functionality far beyond what the standard Joomla menu system.","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(437, 'plg_quickicon_joomlaupdate', 'plugin', 'joomlaupdate', 'quickicon', 0, 1, 1, 1, '{"legacy":false,"name":"plg_quickicon_joomlaupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"1.7.1","description":"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(438, 'plg_quickicon_extensionupdate', 'plugin', 'extensionupdate', 'quickicon', 0, 1, 1, 1, '{"legacy":false,"name":"plg_quickicon_extensionupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"1.7.1","description":"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(27, 'com_finder', 'component', 'com_finder', '', 1, 1, 0, 0, '', '{"show_description":"1","description_length":255,"allow_empty_query":"0","show_url":"1","show_advanced":"1","expand_advanced":"0","show_date_filters":"0","highlight_terms":"1","opensearch_name":"","opensearch_description":"","batch_size":"50","memory_table_limit":30000,"title_multiplier":"1.7","text_multiplier":"0.7","meta_multiplier":"1.2","path_multiplier":"2.0","misc_multiplier":"0.3","stemmer":"porter_en"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10013, 'Our Latest News', 'module', 'mod_latestnews', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10033, 'shape5_vertex', 'template', 'shape5_vertex', '', 0, 1, 1, 0, '{"legacy":false,"name":"shape5_vertex","type":"template","creationDate":"July 2011","author":"Shape5.com","copyright":"Shape5","authorEmail":"contact@shape5.com","authorUrl":"http:\\/\\/www.shape5.com","version":"1.0","description":"\\n\\t\\n\\t<h1>Shape 5 - shape5_vertex<\\/h1>\\n\\n\\t<br\\/>\\n\\t<img src=\\"..\\/templates\\/shape5_vertex\\/template_thumbnail.png\\" align=\\"left\\" hspace=\\"10\\" style=\\"padding-right:10px;\\"\\/>\\n\\tThis template is for members of the Shape 5 Joomla Template Club only, it is not free or open to the public domain.  <br \\/><br \\/>\\n\\tFor tutorials pertaining to this template and additional information check out:<br \\/> <a href=\\"http:\\/\\/www.shape5.com\\/demo\\/shape5_vertex\\">blank Demo<\\/a>.\\n\\t<br \\/>\\n\\t<br \\/><a target=\\"_blank\\" href=\\"http:\\/\\/www.shape5.com\\">Click here<\\/a> to visit Shape5.com\\n\\t<br \\/><br \\/>\\n\\t<div class=\\"vertex-admin-logoback\\"><div class=\\"vertex-admin-logo\\"><\\/div><\\/div>\\n\\t<br \\/><br \\/>\\n\\tPowered by a comprehensive template blue print<br\\/><br\\/>\\n\\t<a target=\\"_blank\\" href=\\"http:\\/\\/www.shape5.com\\/joomla\\/framework\\/vertex_framework.html\\">Read more about Vertex here<\\/a> \\n\\t\\n\\t\\n\\t\\n\\t","group":""}', '{"settings":"","s5_menu_type":"mainmenu","s5_hide_component_items":"-1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10019, 'This Month''s New Albums', 'module', 'mod_newsflash', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10021, 'VirtueMart Product Snapshot', 'plugin', 'vmproductsnapshots', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10022, 'Virtuemart Extended Search Plugin', 'plugin', 'vmxsearch.plugin', '', 0, 1, 1, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(439, 'plg_captcha_recaptcha', 'plugin', 'recaptcha', 'captcha', 0, 1, 1, 0, '{"legacy":false,"name":"plg_captcha_recaptcha","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"2.5.0","description":"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION","group":""}', '{"public_key":"","private_key":"","theme":"clean"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(440, 'plg_system_highlight', 'plugin', 'highlight', 'system', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 7, 0),
(441, 'plg_content_finder', 'plugin', 'finder', 'content', 0, 0, 1, 0, '{"legacy":false,"name":"plg_content_finder","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"1.7.0","description":"PLG_CONTENT_FINDER_XML_DESCRIPTION","group":""}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(442, 'plg_finder_categories', 'plugin', 'categories', 'finder', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(443, 'plg_finder_contacts', 'plugin', 'contacts', 'finder', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(444, 'plg_finder_content', 'plugin', 'content', 'finder', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(445, 'plg_finder_newsfeeds', 'plugin', 'newsfeeds', 'finder', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(446, 'plg_finder_weblinks', 'plugin', 'weblinks', 'finder', 0, 1, 1, 0, '', '{}', '', '', 0, '0000-00-00 00:00:00', 5, 0),
(223, 'mod_finder', 'module', 'mod_finder', '', 0, 1, 0, 0, '', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10034, 'PKG_JOOMLA', 'package', 'pkg_joomla', '', 0, 1, 1, 1, '{"legacy":false,"name":"PKG_JOOMLA","type":"package","creationDate":"2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"http:\\/\\/www.joomla.org","version":"2.5.0","description":"PKG_JOOMLA_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__finder_filters`
--

DROP TABLE IF EXISTS `#__finder_filters`;
CREATE TABLE IF NOT EXISTS `#__finder_filters` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY (`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__finder_filters`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links`
--

DROP TABLE IF EXISTS `#__finder_links`;
CREATE TABLE IF NOT EXISTS `#__finder_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `state` int(5) DEFAULT '1',
  `access` int(5) DEFAULT '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL DEFAULT '0',
  `sale_price` double unsigned NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__finder_links`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms0`
--

DROP TABLE IF EXISTS `#__finder_links_terms0`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms0`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms1`
--

DROP TABLE IF EXISTS `#__finder_links_terms1`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms1`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms2`
--

DROP TABLE IF EXISTS `#__finder_links_terms2`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms2`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms3`
--

DROP TABLE IF EXISTS `#__finder_links_terms3`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms3`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms4`
--

DROP TABLE IF EXISTS `#__finder_links_terms4`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms4`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms5`
--

DROP TABLE IF EXISTS `#__finder_links_terms5`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms5`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms6`
--

DROP TABLE IF EXISTS `#__finder_links_terms6`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms6`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms7`
--

DROP TABLE IF EXISTS `#__finder_links_terms7`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms7`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms8`
--

DROP TABLE IF EXISTS `#__finder_links_terms8`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms8`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_terms9`
--

DROP TABLE IF EXISTS `#__finder_links_terms9`;
CREATE TABLE IF NOT EXISTS `#__finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_terms9`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termsa`
--

DROP TABLE IF EXISTS `#__finder_links_termsa`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termsa`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termsb`
--

DROP TABLE IF EXISTS `#__finder_links_termsb`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termsb`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termsc`
--

DROP TABLE IF EXISTS `#__finder_links_termsc`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termsc`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termsd`
--

DROP TABLE IF EXISTS `#__finder_links_termsd`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termsd`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termse`
--

DROP TABLE IF EXISTS `#__finder_links_termse`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termse`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_links_termsf`
--

DROP TABLE IF EXISTS `#__finder_links_termsf`;
CREATE TABLE IF NOT EXISTS `#__finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_links_termsf`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_taxonomy`
--

DROP TABLE IF EXISTS `#__finder_taxonomy`;
CREATE TABLE IF NOT EXISTS `#__finder_taxonomy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `#__finder_taxonomy`
--

INSERT INTO `#__finder_taxonomy` (`id`, `parent_id`, `title`, `state`, `access`, `ordering`) VALUES
(1, 0, 'ROOT', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__finder_taxonomy_map`
--

DROP TABLE IF EXISTS `#__finder_taxonomy_map`;
CREATE TABLE IF NOT EXISTS `#__finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_taxonomy_map`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_terms`
--

DROP TABLE IF EXISTS `#__finder_terms`;
CREATE TABLE IF NOT EXISTS `#__finder_terms` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__finder_terms`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_terms_common`
--

DROP TABLE IF EXISTS `#__finder_terms_common`;
CREATE TABLE IF NOT EXISTS `#__finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_terms_common`
--

INSERT INTO `#__finder_terms_common` (`term`, `language`) VALUES
('a', 'en'),
('about', 'en'),
('after', 'en'),
('ago', 'en'),
('all', 'en'),
('am', 'en'),
('an', 'en'),
('and', 'en'),
('ani', 'en'),
('any', 'en'),
('are', 'en'),
('aren''t', 'en'),
('as', 'en'),
('at', 'en'),
('be', 'en'),
('but', 'en'),
('by', 'en'),
('for', 'en'),
('from', 'en'),
('get', 'en'),
('go', 'en'),
('how', 'en'),
('if', 'en'),
('in', 'en'),
('into', 'en'),
('is', 'en'),
('isn''t', 'en'),
('it', 'en'),
('its', 'en'),
('me', 'en'),
('more', 'en'),
('most', 'en'),
('must', 'en'),
('my', 'en'),
('new', 'en'),
('no', 'en'),
('none', 'en'),
('not', 'en'),
('noth', 'en'),
('nothing', 'en'),
('of', 'en'),
('off', 'en'),
('often', 'en'),
('old', 'en'),
('on', 'en'),
('onc', 'en'),
('once', 'en'),
('onli', 'en'),
('only', 'en'),
('or', 'en'),
('other', 'en'),
('our', 'en'),
('ours', 'en'),
('out', 'en'),
('over', 'en'),
('page', 'en'),
('she', 'en'),
('should', 'en'),
('small', 'en'),
('so', 'en'),
('some', 'en'),
('than', 'en'),
('thank', 'en'),
('that', 'en'),
('the', 'en'),
('their', 'en'),
('theirs', 'en'),
('them', 'en'),
('then', 'en'),
('there', 'en'),
('these', 'en'),
('they', 'en'),
('this', 'en'),
('those', 'en'),
('thus', 'en'),
('time', 'en'),
('times', 'en'),
('to', 'en'),
('too', 'en'),
('true', 'en'),
('under', 'en'),
('until', 'en'),
('up', 'en'),
('upon', 'en'),
('use', 'en'),
('user', 'en'),
('users', 'en'),
('veri', 'en'),
('version', 'en'),
('very', 'en'),
('via', 'en'),
('want', 'en'),
('was', 'en'),
('way', 'en'),
('were', 'en'),
('what', 'en'),
('when', 'en'),
('where', 'en'),
('whi', 'en'),
('which', 'en'),
('who', 'en'),
('whom', 'en'),
('whose', 'en'),
('why', 'en'),
('wide', 'en'),
('will', 'en'),
('with', 'en'),
('within', 'en'),
('without', 'en'),
('would', 'en'),
('yes', 'en'),
('yet', 'en'),
('you', 'en'),
('your', 'en'),
('yours', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `#__finder_tokens`
--

DROP TABLE IF EXISTS `#__finder_tokens`;
CREATE TABLE IF NOT EXISTS `#__finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '1',
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_tokens`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_tokens_aggregate`
--

DROP TABLE IF EXISTS `#__finder_tokens_aggregate`;
CREATE TABLE IF NOT EXISTS `#__finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__finder_tokens_aggregate`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__finder_types`
--

DROP TABLE IF EXISTS `#__finder_types`;
CREATE TABLE IF NOT EXISTS `#__finder_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__finder_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__jupgrade_categories`
--

DROP TABLE IF EXISTS `#__jupgrade_categories`;
CREATE TABLE IF NOT EXISTS `#__jupgrade_categories` (
  `old` int(11) NOT NULL,
  `new` int(11) NOT NULL,
  `section` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__jupgrade_categories`
--

INSERT INTO `#__jupgrade_categories` (`old`, `new`, `section`) VALUES
(0, 2, '0'),
(1, 7, 'com_section'),
(1, 8, '1'),
(3, 9, '1'),
(62, 10, '1'),
(3, 11, 'com_section'),
(27, 12, '3'),
(28, 13, '3'),
(31, 14, '3'),
(32, 15, '3'),
(4, 16, 'com_section'),
(25, 17, '4'),
(29, 18, '4'),
(30, 19, '4'),
(21, 20, 'com_section'),
(57, 21, '21'),
(22, 22, 'com_section'),
(60, 23, '22'),
(13, 24, 'com_banner'),
(14, 25, 'com_banner'),
(33, 26, 'com_banner'),
(34, 27, 'com_banner'),
(12, 28, 'com_contact_details'),
(4, 29, 'com_newsfeeds'),
(5, 30, 'com_newsfeeds'),
(6, 31, 'com_newsfeeds'),
(2, 32, 'com_weblinks'),
(19, 33, 'com_weblinks');

-- --------------------------------------------------------

--
-- Table structure for table `#__jupgrade_menus`
--

DROP TABLE IF EXISTS `#__jupgrade_menus`;
CREATE TABLE IF NOT EXISTS `#__jupgrade_menus` (
  `old` int(11) NOT NULL,
  `new` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__jupgrade_menus`
--

INSERT INTO `#__jupgrade_menus` (`old`, `new`) VALUES
(1, 102),
(2, 103),
(5, 104),
(7, 105),
(8, 106),
(9, 107),
(23, 108),
(26, 109),
(27, 110),
(28, 111),
(32, 112),
(33, 113),
(34, 114),
(35, 115),
(36, 116),
(37, 117),
(38, 118),
(47, 119),
(48, 120),
(49, 121),
(81, 122),
(88, 123),
(89, 124),
(90, 125),
(93, 126),
(96, 127),
(97, 128),
(99, 129),
(100, 130),
(113, 131),
(120, 132),
(129, 133),
(141, 134),
(142, 135),
(201, 136),
(202, 137),
(207, 138),
(210, 139),
(211, 140),
(213, 141),
(214, 142),
(225, 143),
(226, 144),
(228, 145),
(230, 146),
(233, 147),
(234, 148),
(250, 149),
(252, 150),
(259, 151),
(264, 152),
(266, 153),
(268, 154),
(269, 155),
(270, 156),
(275, 157),
(276, 158),
(277, 159),
(278, 160),
(279, 161),
(280, 162),
(281, 163),
(282, 164),
(283, 165),
(284, 166),
(285, 167),
(286, 168),
(287, 169),
(288, 170),
(289, 171),
(290, 172),
(291, 173),
(292, 174),
(293, 175),
(294, 176),
(295, 177),
(309, 178),
(310, 179),
(311, 180),
(312, 181),
(313, 182),
(314, 183),
(315, 184),
(316, 185),
(317, 186),
(318, 187),
(319, 188),
(320, 189),
(321, 190),
(322, 191),
(324, 192),
(325, 193),
(327, 194),
(328, 195),
(330, 196),
(331, 197),
(332, 198),
(334, 199),
(336, 200),
(338, 201),
(339, 202),
(340, 203),
(341, 204);

-- --------------------------------------------------------

--
-- Table structure for table `#__jupgrade_modules`
--

DROP TABLE IF EXISTS `#__jupgrade_modules`;
CREATE TABLE IF NOT EXISTS `#__jupgrade_modules` (
  `old` int(11) NOT NULL,
  `new` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__jupgrade_modules`
--

INSERT INTO `#__jupgrade_modules` (`old`, `new`) VALUES
(1, 26),
(16, 27),
(18, 28),
(20, 29),
(21, 30),
(22, 31),
(23, 32),
(24, 33),
(26, 34),
(27, 35),
(28, 36),
(30, 37),
(32, 38),
(34, 39),
(35, 40),
(36, 41),
(38, 42),
(120, 43),
(252, 44),
(435, 45),
(476, 46),
(477, 47),
(478, 48),
(479, 49),
(480, 50),
(481, 51),
(482, 52),
(483, 53),
(484, 54),
(485, 55),
(486, 56),
(487, 57),
(488, 58),
(489, 59),
(504, 60),
(505, 61),
(543, 62),
(548, 63),
(549, 64),
(561, 65),
(585, 66),
(587, 67),
(597, 68),
(608, 69),
(609, 70),
(610, 71),
(611, 72),
(612, 73),
(701, 74),
(702, 75),
(710, 76),
(711, 77),
(712, 78),
(714, 79),
(715, 80),
(716, 81),
(717, 82),
(718, 83),
(719, 84),
(720, 85),
(721, 86),
(722, 87),
(723, 88),
(724, 89),
(729, 90),
(730, 91),
(740, 92),
(741, 93),
(742, 94),
(743, 95),
(744, 96),
(745, 97),
(1, 19),
(16, 20),
(18, 21),
(20, 22),
(21, 23),
(22, 24),
(23, 25),
(24, 26),
(26, 27),
(27, 28),
(28, 29),
(30, 30),
(32, 31),
(34, 32),
(35, 33),
(36, 34),
(38, 35),
(120, 36),
(252, 37),
(435, 38),
(476, 39),
(477, 40),
(478, 41),
(479, 42),
(480, 43),
(481, 44),
(482, 45),
(483, 46),
(484, 47),
(485, 48),
(486, 49),
(487, 50),
(488, 51),
(489, 52),
(504, 53),
(505, 54),
(543, 55),
(548, 56),
(549, 57),
(561, 58),
(585, 59),
(587, 60),
(597, 61),
(608, 62),
(609, 63),
(610, 64),
(611, 65),
(612, 66),
(701, 67),
(702, 68),
(710, 69),
(711, 70),
(712, 71),
(714, 72),
(715, 73),
(716, 74),
(717, 75),
(718, 76),
(719, 77),
(720, 78),
(721, 79),
(722, 80),
(723, 81),
(724, 82),
(729, 83),
(730, 84),
(740, 85),
(741, 86),
(742, 87),
(743, 88),
(744, 89),
(745, 90);

-- --------------------------------------------------------

--
-- Table structure for table `#__jupgrade_steps`
--

DROP TABLE IF EXISTS `#__jupgrade_steps`;
CREATE TABLE IF NOT EXISTS `#__jupgrade_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `extension` int(1) NOT NULL DEFAULT '0',
  `state` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `#__jupgrade_steps`
--

INSERT INTO `#__jupgrade_steps` (`id`, `name`, `status`, `extension`, `state`) VALUES
(1, 'users', 1, 0, ''),
(2, 'menus', 1, 0, ''),
(3, 'modules', 1, 0, ''),
(4, 'categories', 1, 0, ''),
(5, 'content', 1, 0, ''),
(6, 'banners', 1, 0, ''),
(7, 'contacts', 1, 0, ''),
(8, 'newsfeeds', 1, 0, ''),
(9, 'weblinks', 1, 0, ''),
(10, 'extensions', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `#__languages`
--

DROP TABLE IF EXISTS `#__languages`;
CREATE TABLE IF NOT EXISTS `#__languages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `#__languages`
--

INSERT INTO `#__languages` (`lang_id`, `lang_code`, `title`, `title_native`, `sef`, `image`, `description`, `metakey`, `metadesc`, `sitename`, `published`, `ordering`) VALUES
(1, 'en-GB', 'English (UK)', 'English (UK)', 'en', 'en', '', '', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__menu`
--

DROP TABLE IF EXISTS `#__menu`;
CREATE TABLE IF NOT EXISTS `#__menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned DEFAULT NULL,
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`,`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(333)),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=211 ;

--
-- Dumping data for table `#__menu`
--

INSERT INTO `#__menu` (`id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `ordering`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES
(1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, 257, 0, '*', 0),
(2, 'menu', 'com_banners', 'Banners', '', 'Banners', 'index.php?option=com_banners', 'component', 0, 1, 1, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 1, 10, 0, '*', 1),
(3, 'menu', 'com_banners', 'Banners', '', 'Banners/Banners', 'index.php?option=com_banners', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 2, 3, 0, '*', 1),
(4, 'menu', 'com_banners_categories', 'Categories', '', 'Banners/Categories', 'index.php?option=com_categories&extension=com_banners', 'component', 0, 2, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-cat', 0, '', 4, 5, 0, '*', 1),
(5, 'menu', 'com_banners_clients', 'Clients', '', 'Banners/Clients', 'index.php?option=com_banners&view=clients', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-clients', 0, '', 6, 7, 0, '*', 1),
(6, 'menu', 'com_banners_tracks', 'Tracks', '', 'Banners/Tracks', 'index.php?option=com_banners&view=tracks', 'component', 0, 2, 2, 4, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-tracks', 0, '', 8, 9, 0, '*', 1),
(7, 'menu', 'com_contact', 'Contacts', '', 'Contacts', 'index.php?option=com_contact', 'component', 0, 1, 1, 8, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 11, 16, 0, '*', 1),
(8, 'menu', 'com_contact', 'Contacts', '', 'Contacts/Contacts', 'index.php?option=com_contact', 'component', 0, 7, 2, 8, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 12, 13, 0, '*', 1),
(9, 'menu', 'com_contact_categories', 'Categories', '', 'Contacts/Categories', 'index.php?option=com_categories&extension=com_contact', 'component', 0, 7, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact-cat', 0, '', 14, 15, 0, '*', 1),
(10, 'menu', 'com_messages', 'Messaging', '', 'Messaging', 'index.php?option=com_messages', 'component', 0, 1, 1, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages', 0, '', 17, 22, 0, '*', 1),
(11, 'menu', 'com_messages_add', 'New Private Message', '', 'Messaging/New Private Message', 'index.php?option=com_messages&task=message.add', 'component', 0, 10, 2, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages-add', 0, '', 18, 19, 0, '*', 1),
(12, 'menu', 'com_messages_read', 'Read Private Message', '', 'Messaging/Read Private Message', 'index.php?option=com_messages', 'component', 0, 10, 2, 15, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages-read', 0, '', 20, 21, 0, '*', 1),
(13, 'menu', 'com_newsfeeds', 'News Feeds', '', 'News Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 1, 1, 17, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 23, 28, 0, '*', 1),
(14, 'menu', 'com_newsfeeds_feeds', 'Feeds', '', 'News Feeds/Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 13, 2, 17, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 24, 25, 0, '*', 1),
(15, 'menu', 'com_newsfeeds_categories', 'Categories', '', 'News Feeds/Categories', 'index.php?option=com_categories&extension=com_newsfeeds', 'component', 0, 13, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds-cat', 0, '', 26, 27, 0, '*', 1),
(16, 'menu', 'com_redirect', 'Redirect', '', 'Redirect', 'index.php?option=com_redirect', 'component', 0, 1, 1, 24, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:redirect', 0, '', 37, 38, 0, '*', 1),
(17, 'menu', 'com_search', 'Search', '', 'Search', 'index.php?option=com_search', 'component', 0, 1, 1, 19, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:search', 0, '', 29, 30, 0, '*', 1),
(18, 'menu', 'com_weblinks', 'Weblinks', '', 'Weblinks', 'index.php?option=com_weblinks', 'component', 0, 1, 1, 21, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks', 0, '', 31, 36, 0, '*', 1),
(19, 'menu', 'com_weblinks_links', 'Links', '', 'Weblinks/Links', 'index.php?option=com_weblinks', 'component', 0, 18, 2, 21, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks', 0, '', 32, 33, 0, '*', 1),
(20, 'menu', 'com_weblinks_categories', 'Categories', '', 'Weblinks/Categories', 'index.php?option=com_categories&extension=com_weblinks', 'component', 0, 18, 2, 6, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:weblinks-cat', 0, '', 34, 35, 0, '*', 1),
(102, 'mainmenu', 'Home', 'home-mainmenu-1', '', 'home-mainmenu-1', 'index.php?option=com_content&view=featured', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"featured_categories":[""],"layout_type":"blog","num_leading_articles":"0","num_intro_articles":"6","num_columns":"1","num_links":"0","multi_column_order":"1","orderby_pri":"","orderby_sec":"rdate","order_date":"","show_pagination":"2","show_pagination_results":"1","show_title":"1","link_titles":"0","show_intro":"","show_category":"0","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"0","link_author":"0","show_create_date":"0","show_modify_date":"0","show_publish_date":"0","show_item_navigation":"","show_vote":"","show_readmore":"","show_readmore_title":"","show_icons":"","show_print_icon":"1","show_email_icon":"1","show_hits":"","show_noauth":"","show_feed_link":"1","feed_summary":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"Welcome to the Frontpage!","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Return Home","s5_group_child":"0"}', 41, 42, 1, '*', 0),
(103, 'mainmenu', 'News', 'news-mainmenu-2', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/news-mainmenu-2', 'index.php?option=com_content&view=category&layout=blog&id=7', 'component', 1, 109, 3, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_page_title":1,"pageclass_sfx":"","back_button":"","description_sec":1,"description_sec_image":1,"orderby":"","other_cat_show_section":1,"empty_cat_show_section":0,"show_category_description":1,"description_cat_image":1,"show_categories":1,"show_empty_categories":0,"show_cat_num_articles":1,"cat_show_description":1,"date_format":"","show_date":"","show_author":"","show_hits":"","show_headings":1,"show_item_navigation":1,"order_select":1,"show_pagination_limit":1,"display_num":50,"filter":1,"filter_type":"title","unpublished":1,"show_title":1,"show_page_heading":"0"}', 161, 162, 0, '*', 0),
(104, 'mainmenu', 'Search', 'search-mainmenu-5', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/search-mainmenu-5', 'index.php?option=com_search', 'component', 1, 109, 3, 19, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","pageclass_sfx":"","back_button":"","show_page_title":1,"page_title":"","show_title":1,"show_page_heading":"0"}', 159, 160, 0, '*', 0),
(105, 'mainmenu', 'News Feeds', 'news-feeds-mainmenu-7', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/news-feeds-mainmenu-7', 'index.php?option=com_newsfeeds&view=categories', 'component', 1, 109, 3, 17, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","pageclass_sfx":"","back_button":"","show_page_title":1,"page_title":"","other_cat_show_section":1,"show_categories":1,"cat_show_description":1,"show_cat_num_articles":1,"show_description":1,"description_text":"","image":-1,"image_align":"right","show_headings":1,"name":1,"articles":1,"num_links":0,"feed_image":1,"feed_descr":1,"item_descr":1,"word_count":0,"show_title":1,"show_page_heading":"0"}', 163, 164, 0, '*', 0),
(106, 'mainmenu', 'Wrapper', 'wrapper-mainmenu-8', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/wrapper-mainmenu-8', 'index.php?option=com_wrapper&view=wrapper', 'component', 1, 109, 3, 2, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","pageclass_sfx":"","back_button":"","show_page_title":1,"page_title":"","scrolling":"auto","width":"100%","height":600,"height_auto":0,"add":1,"url":"http:\\/\\/www.mozilla.com\\/en-US\\/firefox\\/","show_title":1,"show_page_heading":"0"}', 171, 172, 0, '*', 0),
(107, 'mainmenu', 'Blog', 'blog-mainmenu-9', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/links-mainmenu-23/blog-mainmenu-9', 'index.php?option=com_content&view=category&layout=blog&id=2', 'component', 0, 108, 4, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","pageclass_sfx":"","back_button":"","page_title":"A blog of all sections with no images","show_page_title":1,"num_leading_articles":0,"num_intro_articles":6,"num_columns":2,"num_links":4,"orderby_pri":"","orderby_sec":"","show_pagination":2,"show_pagination_results":1,"image":0,"show_description":0,"show_description_image":0,"show_category":0,"category_num_links":0,"show_title":1,"link_titles":"","show_readmore":"","show_vote":"","show_author":"","show_create_show_date":"","show_modify_show_date":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","unpublished":0,"sectionid":0,"show_page_heading":"0"}', 166, 167, 0, '*', 0),
(108, 'mainmenu', 'Links', 'links-mainmenu-23', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/links-mainmenu-23', 'index.php?option=com_weblinks&view=categories', 'component', 1, 109, 3, 21, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","pageclass_sfx":"","back_button":"","show_page_title":1,"page_title":"","show_headings":1,"show_hits":"","item_show_description":1,"other_cat_show_section":1,"show_categories":1,"show_description":1,"description_text":"","image":-1,"image_align":"right","weblink_icons":"","show_title":1,"show_page_heading":"0"}', 165, 168, 0, '*', 0),
(109, 'mainmenu', 'J! Stuff', 'joomla-stuff-mainmenu-26', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26', 'javascript:;', 'url', 1, 119, 2, 0, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/joomla.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Default Joomla Items","s5_group_child":"0"}', 158, 173, 0, '*', 0),
(110, 'mainmenu', 'Typography', 'typography-mainmenu-27', '', 'features-mainmenu-47/style-and-layout-options/typography-mainmenu-27', 'index.php?option=com_content&view=article&id=12', 'component', 1, 178, 3, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":1,"link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 183, 184, 0, '*', 0),
(111, 'mainmenu', 'S5 Flex Menu', 's5-flex-menu-1121', '', 's5-flex-menu-1121', 'index.php?option=com_content&view=article&id=13', 'component', 1, 1, 1, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":2,"s5_subtext":"Advanced Menu System","s5_group_child":0,"show_noauth":"","show_title":1,"link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 85, 118, 0, '*', 0),
(112, 'mainmenu', 'Drop Down Menu', 'sample-menu', '', 's5-flex-menu-1121/sample-menu', 'javascript:;', 'url', 1, 111, 2, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/application_put.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Unlimited Level Options","s5_group_child":"0"}', 86, 99, 0, '*', 0),
(113, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-33', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-33', 'javascript:;', 'url', 1, 112, 3, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 87, 88, 0, '*', 0),
(114, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-34', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-34', 'javascript:;', 'url', 1, 112, 3, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 89, 90, 0, '*', 0),
(115, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-35', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-35', 'javascript:;', 'url', 1, 112, 3, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 91, 98, 0, '*', 0),
(116, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-36', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-35/dummy-item-mainmenu-36', 'javascript:;', 'url', 1, 115, 4, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 92, 93, 0, '*', 0),
(117, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-37', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-35/dummy-item-mainmenu-37', 'javascript:;', 'url', 1, 115, 4, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 94, 95, 0, '*', 0),
(118, 'mainmenu', 'Dummy Item', 'dummy-item-mainmenu-38', '', 's5-flex-menu-1121/sample-menu/dummy-item-mainmenu-35/dummy-item-mainmenu-38', 'javascript:;', 'url', 1, 115, 4, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","show_title":1,"show_page_title":1,"show_page_heading":"0"}', 96, 97, 0, '*', 0),
(119, 'mainmenu', 'Features', 'features-mainmenu-47', '', 'features-mainmenu-47', 'javascript:;', 'url', 1, 1, 1, 0, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":2,"s5_subtext":"What''s Included","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 129, 202, 0, '*', 0),
(120, 'mainmenu', 'Tutorials', 'tutorials-mainmenu-48', '', 'tutorials-mainmenu-48', 'javascript:;', 'url', 1, 1, 1, 0, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Find Help Here","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 213, 234, 0, '*', 0),
(121, 'mainmenu', '94 Module Positions', '94-module-positions', '', 'features-mainmenu-47/template-features/94-module-positions', 'index.php?option=com_content&view=article&id=14', 'component', 1, 135, 3, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"1","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Thousands of Layout Options","s5_group_child":"0"}', 135, 136, 0, '*', 0),
(122, 'mainmenu', 'Contact Us', 'contact-us', '', 'features-mainmenu-47/joomla-stuff-mainmenu-26/contact-us', 'index.php?option=com_contact&view=contact&id=1', 'component', 1, 109, 3, 8, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_contact_list":0,"show_category_crumb":0,"contact_icons":"","icon_address":"","icon_email":"","icon_telephone":"","icon_mobile":"","icon_fax":"","icon_misc":"","show_headings":"","show_position":"","show_email":"","show_telephone":"","show_mobile":"","show_fax":"","allow_vcard":"","banned_email":"","banned_subject":"","banned_text":"","validate_session":"","custom_reply":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 169, 170, 0, '*', 0),
(123, 'mainmenu', 'Site Shaper Available', 'site-shaper-available', '', 'features-mainmenu-47/style-and-layout-options/site-shaper-available', 'index.php?option=com_content&view=article&id=39', 'component', 1, 178, 3, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 177, 178, 0, '*', 0),
(124, 'mainmenu', 'Site Shaper Setup', 'site-shaper-setup', '', 'tutorials-mainmenu-48/site-shaper-setup', 'index.php?option=com_content&view=article&id=39', 'component', 1, 120, 2, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Site Shapers Are Highly Recommended","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 216, 217, 0, '*', 0),
(125, 'mainmenu', 'Setting Up Module Styles', 'setting-up-module-styles', '', 'tutorials-mainmenu-48/setting-up-module-styles', 'index.php?option=com_content&view=article&id=14', 'component', 1, 120, 2, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 220, 221, 0, '*', 0),
(126, 'mainmenu', 'Fluid and Fixed Layouts', 'fluid-and-fixed-layouts', '', 'features-mainmenu-47/style-and-layout-options/fluid-and-fixed-layouts', 'index.php?option=com_content&view=article&id=24', 'component', 1, 178, 3, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 187, 188, 0, '*', 0),
(127, 'mainmenu', 'Tool Tips Enabled', 'tool-tips-enabled', '', 'features-mainmenu-47/template-features/tool-tips-enabled', 'index.php?option=com_content&view=article&id=37', 'component', 1, 135, 3, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 141, 142, 0, '*', 0),
(128, 'mainmenu', 'Tool Tips Setup', 'tool-tips-setup', '', 'tutorials-mainmenu-48/tool-tips-setup', 'index.php?option=com_content&view=article&id=37', 'component', 1, 120, 2, 22, 9, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 230, 231, 0, '*', 0),
(129, 'mainmenu', 'Installing The Template', 'installing-the-template', '', 'tutorials-mainmenu-48/installing-the-template', 'index.php?option=com_content&view=article&id=17', 'component', 1, 120, 2, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 218, 219, 0, '*', 0),
(130, 'mainmenu', 'Configuring The Template', 'configuring-the-template', '', 'tutorials-mainmenu-48/configuring-the-template', 'index.php?option=com_content&view=article&id=18', 'component', 1, 120, 2, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 222, 223, 0, '*', 0),
(131, 'mainmenu', 'Search and Menus Setup', 'search-and-menus-setup', '', 'tutorials-mainmenu-48/search-and-menus-setup', 'index.php?option=com_content&view=article&id=36', 'component', 1, 120, 2, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 224, 225, 0, '*', 0),
(132, 'mainmenu', 'S5 Tab Show', 's5-tab-show', '', 'extensions/s5-tab-show', 'index.php?option=com_content&view=article&id=97', 'component', -2, 134, 2, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Sliding Tab Module","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 72, 73, 0, '*', 0),
(133, 'mainmenu', 'S5 CSS / JS Compressor', 's5-css-a-js-compressor', '', 'extensions/s5-css-a-js-compressor', 'index.php?option=com_content&view=article&id=110', 'component', 0, 134, 2, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Optimize Your Site''s Performance","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 70, 71, 0, '*', 0),
(134, 'mainmenu', 'Extensions', 'extensions', '', 'extensions', 'javascript:;', 'url', 1, 1, 1, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Tools and Modules","s5_group_child":"0"}', 63, 78, 0, '*', 0),
(135, 'mainmenu', 'S5 Vertex Template Features', 'template-features', '', 'features-mainmenu-47/template-features', 'javascript:;', 'url', 1, 119, 2, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/application_split.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Powerful Template Settings","s5_group_child":"1"}', 134, 157, 0, '*', 0),
(136, 'mainmenu', 'LTR Language', 'ltr-language', '', 'features-mainmenu-47/template-features/ltr-language', '?lang=ltr', 'url', 1, 135, 3, 0, 10, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 153, 154, 0, '*', 0),
(137, 'mainmenu', 'RTL Language', 'rtl-language', '', 'features-mainmenu-47/template-features/rtl-language', '?lang=rtl', 'url', 1, 135, 3, 0, 11, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 155, 156, 0, '*', 0),
(138, 'mainmenu', 'SEO Optimized', 'seo-optimized', '', 'features-mainmenu-47/template-features/seo-optimized', 'index.php?option=com_content&view=article&id=173', 'component', 1, 135, 3, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 137, 138, 0, '*', 0),
(139, 'second-menu', 'About us', 'about-us', '', 'about-us', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 61, 62, 0, '*', 0),
(140, 'second-menu', 'FAQs', 'faqs', '', 'faqs', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 81, 82, 0, '*', 0),
(141, 'second-menu', 'News', 'news', '', 'news', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 127, 128, 0, '*', 0),
(142, 'second-menu', 'Blog', 'blog', '', 'blog', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 205, 206, 0, '*', 0),
(143, 'mainmenu', 'Multibox Enabled', 'multibox-enabled', '', 'features-mainmenu-47/template-features/multibox-enabled', 'index.php?option=com_content&view=article&id=195', 'component', 1, 135, 3, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 143, 144, 0, '*', 0),
(144, 'mainmenu', 'Multibox Setup', 'multibox-setup', '', 'tutorials-mainmenu-48/multibox-setup', 'index.php?option=com_content&view=article&id=195', 'component', 1, 120, 2, 22, 8, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 228, 229, 0, '*', 0),
(145, 'mainmenu', 'Template Specific Features', 'template-specific-features', '', 'features-mainmenu-47/template-specific-features', 'index.php?option=com_content&view=article&id=197', 'component', 1, 119, 2, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/color_wheel.png","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Options Specific To This Template","s5_group_child":"0"}', 132, 133, 0, '*', 0),
(146, 'mainmenu', 'Google Fonts Enabled', 'google-fonts-enabled', '', 'features-mainmenu-47/style-and-layout-options/google-fonts-enabled', 'index.php?option=com_content&view=article&id=204', 'component', 1, 178, 3, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 179, 180, 0, '*', 0),
(147, 'mainmenu', 'K2 Item Styling', 'k2-item', '', 'features-mainmenu-47/style-and-layout-options/k2-item', 'index.php?option=com_k2&view=item&layout=item&id=2', 'component', -2, 178, 3, 0, 10, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 193, 194, 0, '*', 0),
(148, 'mainmenu', 'K2 Category Styling', 'k2-category', '', 'features-mainmenu-47/style-and-layout-options/k2-category', 'index.php?option=com_k2&view=itemlist&layout=category&task=category&id=1', 'component', -2, 178, 3, 0, 11, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 195, 196, 0, '*', 0),
(149, 'mainmenu', 'Page, Row and Column Widths', 'page-row-and-column-widths', '', 'features-mainmenu-47/style-and-layout-options/page-row-and-column-widths', 'index.php?option=com_content&view=article&id=24', 'component', 1, 178, 3, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 181, 182, 0, '*', 0),
(150, 'mainmenu', 'Mobile Device Ready', 'mobile-device-ready', '', 'features-mainmenu-47/template-features/mobile-device-ready', 'index.php?option=com_content&view=article&id=211', 'component', 1, 135, 3, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 139, 140, 0, '*', 0),
(151, 'second-menu', 'Home', 'home', '', '', 'index.php?Itemid=', 'alias', 1, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_item":1,"aliasoptions":1,"show_page_heading":"0"}', 0, 0, 0, '*', 0),
(152, 'mainmenu', 'CSS Tableless Overrides', 'css-tableless-overrides', '', 'features-mainmenu-47/style-and-layout-options/css-tableless-overrides', 'index.php?option=com_content&view=article&id=212', 'component', 1, 178, 3, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 185, 186, 0, '*', 0),
(153, 'mainmenu', 'S5 Box', 's5-box', '', 'extensions/s5-box', 'index.php?option=com_content&view=article&id=146', 'component', -2, 134, 2, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Popup Box for Login","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 68, 69, 0, '*', 0),
(154, 'mainmenu', 'Login and Register Setup', 'login-and-register-setup', '', 'tutorials-mainmenu-48/login-and-register-setup', 'index.php?option=com_content&view=article&id=146', 'component', 1, 120, 2, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"","s5_group_child":"0"}', 226, 227, 0, '*', 0),
(155, 'mainmenu', 'S5 Accordion Menu', 's5-accordion-menu', '', 'extensions/s5-accordion-menu', 'index.php?option=com_content&view=article&id=143', 'component', -2, 134, 2, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Accordion Column Menu","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 66, 67, 0, '*', 0),
(156, 'second-menu', 'Site Map', 'site-map', '', 'site-map', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 237, 238, 0, '*', 0),
(157, 'second-menu', 'Site Terms', 'site-terms', '', 'site-terms', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 243, 244, 0, '*', 0),
(158, 'Bottom-Menu-1', 'Updates', 'updates-7046', '', 'updates-7046', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 43, 44, 0, '*', 0),
(159, 'Bottom-Menu-1', 'Addons', 'addons-15431', '', 'addons-15431', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 119, 120, 0, '*', 0),
(160, 'Bottom-Menu-1', 'Knowledge Base', 'knowledge-base', '', 'knowledge-base', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 207, 208, 0, '*', 0),
(161, 'Bottom-Menu-1', 'Designs', 'designs-31860', '', 'designs-31860', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 247, 248, 0, '*', 0),
(162, 'Bottom-Menu-2', 'Careers', 'careers-1437', '', 'careers-1437', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 99999, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 255, 256, 0, '*', 0),
(163, 'Bottom-Menu-2', 'Our Forum', 'our-forum-27154', '', 'our-forum-27154', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 121, 122, 0, '*', 0),
(164, 'Bottom-Menu-2', 'Listings', 'listings-21987', '', 'listings-21987', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 125, 126, 0, '*', 0),
(165, 'Bottom-Menu-2', 'Community', 'community', '', 'community', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 239, 240, 0, '*', 0),
(166, 'Bottom-Menu-1', 'Learn More', 'learn-more-27616', '', 'learn-more-27616', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 99999, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 253, 254, 0, '*', 0),
(167, 'Bottom-Menu-2', 'Learn How', 'learn-how-24217', '', 'learn-how-24217', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 245, 246, 0, '*', 0),
(168, 'Bottom-Menu-1', 'Mobile', 'mobile', '', 'mobile', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 57, 58, 0, '*', 0),
(169, 'Bottom-Menu-4', 'Affiliates', 'affiliates', '', 'affiliates', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 45, 46, 0, '*', 0),
(170, 'Bottom-Menu-1', 'Specials', 'specials', '', 'specials', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 203, 204, 0, '*', 0);
INSERT INTO `#__menu` (`id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `ordering`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES
(171, 'Bottom-Menu-4', 'Supplies', 'supplies', '', 'supplies', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 123, 124, 0, '*', 0),
(172, 'Bottom-Menu-2', 'Where To', 'where-to', '', 'where-to', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 79, 80, 0, '*', 0),
(173, 'Bottom-Menu-4', 'Careers', 'careers', '', 'careers', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 83, 84, 0, '*', 0),
(174, 'Bottom-Menu-4', 'Our Forum', 'our-forum', '', 'our-forum', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 235, 236, 0, '*', 0),
(175, 'Bottom-Menu-4', 'Listings', 'listings', '', 'listings', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 59, 60, 0, '*', 0),
(176, 'Bottom-Menu-4', 'Designs', 'designs', '', 'designs', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 209, 210, 0, '*', 0),
(177, 'Bottom-Menu-2', 'Learn How', 'learn-how', '', 'learn-how', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 211, 212, 0, '*', 0),
(178, 'mainmenu', 'Continued Vertex Features', 'style-and-layout-options', '', 'features-mainmenu-47/style-and-layout-options', '', 'separator', 1, 119, 2, 0, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"images\\/stories\\/application_view_tile.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"More Great S5 Vertex Options","s5_group_child":"1"}', 176, 201, 0, '*', 0),
(179, 'mainmenu', 'Fixed Side Tabs', 'fixed-side-tabs', '', 'features-mainmenu-47/style-and-layout-options/fixed-side-tabs', 'index.php?option=com_content&view=article&id=214', 'component', 1, 178, 3, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 189, 190, 0, '*', 0),
(180, 'second-menu', 'Learn More', 'learn-more', '', 'learn-more', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 8, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 249, 250, 0, '*', 0),
(181, 'second-menu', 'Updates', 'updates', '', 'updates', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 9, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 251, 252, 0, '*', 0),
(182, 'mainmenu', 'S5 Flex Menu', 's5-flex-menu', '', 'extensions/s5-flex-menu', 'index.php?option=com_content&view=article&id=13', 'component', 1, 134, 2, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Advanced Menu System","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 64, 65, 0, '*', 0),
(183, 'mainmenu', 'Grouped Child Menu', 'sample-grouped-child-menu', '', 's5-flex-menu-1121/sample-grouped-child-menu', '', 'separator', 1, 111, 2, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"images\\/stories\\/application_side_boxes.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Group Children Together","s5_group_child":"1"}', 102, 115, 0, '*', 0),
(184, 'mainmenu', 'Dummy Sample Link 1', 'dummy-link-1', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-1', '', 'separator', 1, 183, 3, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 105, 106, 0, '*', 0),
(185, 'mainmenu', 'Dummy Sample Link 2', 'dummy-link-2', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-2', '', 'separator', 1, 183, 3, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 103, 104, 0, '*', 0),
(186, 'mainmenu', 'Dummy Sample Link 3', 'dummy-link-3', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-3', '', 'separator', 1, 183, 3, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 107, 108, 0, '*', 0),
(187, 'mainmenu', 'Dummy Sample Link 4', 'dummy-link-4', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-4', '', 'separator', 1, 183, 3, 0, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 109, 110, 0, '*', 0),
(188, 'mainmenu', 'Dummy Sample Link 5', 'dummy-link-5', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-5', '', 'separator', 1, 183, 3, 0, 5, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 111, 112, 0, '*', 0),
(189, 'mainmenu', 'Dummy Sample Link 6', 'dummy-link-6', '', 's5-flex-menu-1121/sample-grouped-child-menu/dummy-link-6', '', 'separator', 1, 183, 3, 0, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 113, 114, 0, '*', 0),
(190, 'mainmenu', 'Menu Module Example', 'menu-module-example', '', 's5-flex-menu-1121/menu-module-example', '', 'separator', 1, 111, 2, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"images\\/stories\\/cog_edit.png","menu_text":1,"s5_load_mod":"1","s5_position":"s5_menu1","s5_columns":"1","s5_subtext":"","s5_group_child":"1"}', 100, 101, 0, '*', 0),
(191, 'mainmenu', 'Menu With No Menu Icon', 'item-with-menu-icon', '', 's5-flex-menu-1121/item-with-menu-icon', '', 'separator', 1, 111, 2, 0, 4, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu_image":"","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Standard Sub Menu Link","s5_group_child":"0"}', 116, 117, 0, '*', 0),
(192, 'mainmenu', 'Menu Scroll To', 'menu-scroll-to', '', 'features-mainmenu-47/template-features/menu-scroll-to', 'index.php?option=com_content&view=article&id=227', 'component', 1, 135, 3, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 147, 148, 0, '*', 0),
(193, 'mainmenu', 'IE7 and 8 CSS3 Support', 'ie7-and-8-css3-support', '', 'features-mainmenu-47/style-and-layout-options/ie7-and-8-css3-support', 'index.php?option=com_content&view=article&id=228', 'component', 1, 178, 3, 22, 8, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 191, 192, 0, '*', 0),
(194, 'mainmenu', 'Virtuemart Styling', 'virtuemart-styling', '', 'features-mainmenu-47/style-and-layout-options/virtuemart-styling', 'index.php?option=com_virtuemart', 'component', -2, 178, 3, 0, 12, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","product_id":"","category_id":"","flypage":"","page":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 197, 198, 0, '*', 0),
(195, 'mainmenu', 'S5 Vertex Framework', 'shape-5-vertex-framework', '', 'features-mainmenu-47/shape-5-vertex-framework', 'http://www.shape5.com/joomla/framework/vertex_framework.html', 'url', 1, 119, 2, 0, 1, 0, '0000-00-00 00:00:00', 1, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/application_link.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Learn More About Vertex","s5_group_child":"0"}', 130, 131, 0, '*', 0),
(196, 'Bottom-Menu-4', 'Addons', 'addons', '', 'addons', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 241, 242, 0, '*', 0),
(197, 'mainmenu', 'Hide Article Component Area', 'hide-article-component-area', '', 'features-mainmenu-47/template-features/hide-article-component-area', 'index.php?option=com_content&view=article&id=231', 'component', 1, 135, 3, 22, 8, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 149, 150, 0, '*', 0),
(198, 'mainmenu', 'Lazy Load Enabled', 'lazy-load-enabled', '', 'features-mainmenu-47/template-features/lazy-load-enabled', 'index.php?option=com_content&view=article&id=230', 'component', 1, 135, 3, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 145, 146, 0, '*', 0),
(199, 'mainmenu', 'Lazy Load Setup', 'lazy-load-setup', '', 'tutorials-mainmenu-48/lazy-load-setup', 'index.php?option=com_content&view=article&id=230', 'component', 1, 120, 2, 22, 10, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 232, 233, 0, '*', 0),
(200, 'mainmenu', 'Drop Down Panel', 'drop-down-panel', '', 'features-mainmenu-47/template-features/drop-down-panel', 'index.php?option=com_content&view=article&id=233', 'component', 1, 135, 3, 22, 9, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"","show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 151, 152, 0, '*', 0),
(201, 'mainmenu', 'S5 Image Slide V2', 's5-image-slide-v2', '', 'extensions/s5-image-slide-v2', 'index.php?option=com_content&view=article&id=252', 'component', -2, 134, 2, 22, 6, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Image Rotating Extension","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 74, 75, 0, '*', 0),
(202, 'mainmenu', 'S5 CSS/JS Compressor', 's5-cssjs-compressor', '', 'extensions/s5-cssjs-compressor', 'index.php?option=com_content&view=article&id=110', 'component', 1, 134, 2, 22, 7, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Optimize Your Site''s Performance","s5_group_child":0,"show_noauth":"","show_title":"","link_titles":"","show_intro":"","show_section":"","link_section":"","show_category":"","link_category":"","show_author":"","show_create_date":"","show_modify_date":"","show_item_navigation":"","show_readmore":"","show_vote":"","show_icons":"","show_pdf_icon":"","show_print_icon":"","show_email_icon":"","show_hits":"","feed_summary":"","page_title":"","show_page_title":1,"pageclass_sfx":"","menu_image":"","secure":0,"show_page_heading":"0"}', 76, 77, 0, '*', 0),
(203, 'mainmenu', 'Download Joomla Tutorials', 'joomla-tutorials-5470', '', 'features-mainmenu-47/joomla-tutorials-5470', 'http://www.shape5.com/joomla_tutorials.html', 'url', 1, 119, 2, 0, 5, 0, '0000-00-00 00:00:00', 1, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"images\\/stories\\/help.png","menu_text":1,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Practical Help For Joomla","s5_group_child":"0"}', 174, 175, 0, '*', 0),
(204, 'mainmenu', 'Download Joomla Tutorials', 'joomla-tutorials', '', 'tutorials-mainmenu-48/joomla-tutorials', 'http://www.shape5.com/joomla_tutorials.html', 'url', 1, 120, 2, 0, 1, 0, '0000-00-00 00:00:00', 1, 1, '', 0, '{"s5_load_mod":0,"s5_columns":1,"s5_subtext":"Practical Help For Joomla","s5_group_child":0,"menu_image":"","show_page_heading":"0"}', 214, 215, 0, '*', 0),
(21, 'menu', 'com_finder', 'Smart Search', '', 'Smart Search', 'index.php?option=com_finder', 'component', 0, 1, 1, 27, 0, 0, '0000-00-00 00:00:00', 0, 0, 'class:finder', 0, '', 39, 40, 0, '*', 1),
(205, 'bottom-menu', 'About Us', 'about', '', 'about', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Advanced Menu System","s5_group_child":"0"}', 47, 48, 0, '*', 0),
(206, 'bottom-menu', 'FAQs', 'faq', '', 'faq', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Advanced Menu System","s5_group_child":"0"}', 49, 50, 0, '*', 0),
(207, 'bottom-menu', 'Site Map', 'map', '', 'map', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Advanced Menu System","s5_group_child":"0"}', 51, 52, 0, '*', 0),
(208, 'bottom-menu', 'Terms', 'term', '', 'term', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Advanced Menu System","s5_group_child":"0"}', 53, 54, 0, '*', 0),
(209, 'bottom-menu', 'Updates', 'update', '', 'update', 'index.php?option=com_content&view=article&id=208', 'component', 1, 1, 1, 22, 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"Advanced Menu System","s5_group_child":"0"}', 55, 56, 0, '*', 0),
(210, 'mainmenu', '3rd Party Component Compatible', '3rd-party-component-compatible', '', 'features-mainmenu-47/style-and-layout-options/3rd-party-component-compatible', 'index.php?option=com_content&view=article&id=257', 'component', 1, 178, 3, 22, 0, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"s5_load_mod":"0","s5_columns":"1","s5_subtext":"","s5_group_child":"0"}', 199, 200, 0, '*', 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__menu_types`
--

DROP TABLE IF EXISTS `#__menu_types`;
CREATE TABLE IF NOT EXISTS `#__menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `#__menu_types`
--

INSERT INTO `#__menu_types` (`id`, `menutype`, `title`, `description`) VALUES
(1, 'mainmenu', 'Main Menu', 'The main menu for the site'),
(2, 'bottom-menu', 'Bottom Menu', '');

-- --------------------------------------------------------

--
-- Table structure for table `#__messages`
--

DROP TABLE IF EXISTS `#__messages`;
CREATE TABLE IF NOT EXISTS `#__messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__messages_cfg`
--

DROP TABLE IF EXISTS `#__messages_cfg`;
CREATE TABLE IF NOT EXISTS `#__messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__messages_cfg`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__modules`
--

DROP TABLE IF EXISTS `#__modules`;
CREATE TABLE IF NOT EXISTS `#__modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) NOT NULL DEFAULT '',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` int(10) unsigned DEFAULT NULL,
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `#__modules`
--

INSERT INTO `#__modules` (`id`, `title`, `note`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `published`, `module`, `access`, `showtitle`, `params`, `client_id`, `language`) VALUES
(20, 'Our Poll', '', '', 0, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_poll', 1, 1, '{"id":"14","moduleclass_sfx":"","cache":"1","cache_time":"900"}', 0, '*'),
(21, 'Login', '', '', 3, 'right_inset', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_login', 1, 1, '{"pretext":"","posttext":"","login":"","logout":"","greeting":"1","name":"0","usesecure":"0","layout":"_:default","moduleclass_sfx":"","cache":"0"}', 0, '*'),
(2, 'Login', '', '', 1, 'login', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_login', 1, 1, '', 1, '*'),
(3, 'Popular Articles', '', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_popular', 3, 1, '{"count":"5","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*'),
(4, 'Recently Added Articles', '', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_latest', 3, 1, '{"count":"5","ordering":"c_dsc","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*'),
(6, 'Unread Messages', '', '', 1, 'header', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_unread', 3, 1, '', 1, '*'),
(7, 'Online Users', '', '', 2, 'header', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_online', 3, 1, '', 1, '*'),
(8, 'Toolbar', '', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_toolbar', 3, 1, '', 1, '*'),
(9, 'Quick Icons', '', '', 1, 'icon', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_quickicon', 3, 1, '', 1, '*'),
(10, 'Logged-in Users', '', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_logged', 3, 1, '{"count":"5","name":"1","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}', 1, '*'),
(12, 'Admin Menu', '', '', 1, 'menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 3, 1, '{"layout":"","moduleclass_sfx":"","shownew":"1","showhelp":"1","cache":"0"}', 1, '*'),
(13, 'Admin Submenu', '', '', 1, 'submenu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_submenu', 3, 1, '', 1, '*'),
(14, 'User Status', '', '', 2, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_status', 3, 1, '', 1, '*'),
(15, 'Title', '', '', 1, 'title', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_title', 3, 1, '', 1, '*'),
(19, 'Main Menu', '', '', 1, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 1, '{"menutype":"mainmenu","startLevel":"1","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*'),
(22, 'Statistics', '', '', 13, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_stats', 1, 1, '{"serverinfo":"1","siteinfo":"1","counter":"1","increase":"0","moduleclass_sfx":"","cache":"0","cache_time":"900"}', 0, '*'),
(23, 'Guests Online', '', '', 1, 'right_inset', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_whosonline', 1, 1, '{"showmode":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","filter_groups":"0"}', 0, '*'),
(24, 'Popular Articles', '', '', 1, 'bottom_row1_2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_articles_popular', 1, 1, '{"catid":[""],"count":"4","show_front":"1","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(25, 'Archive', '', '', 2, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_articles_archive', 1, 1, '{"count":10,"moduleclass_sfx":"-blue tester","cache":1}', 0, '*'),
(26, 'Sections', '', '', 4, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_sections', 1, 1, '{"count":"5","moduleclass_sfx":"","cache":"1","cache_time":"900"}', 0, '*'),
(27, 'Related Items', '', '', 7, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_related_items', 1, 1, '{}', 0, '*'),
(28, 'Search', '', '', 4, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_search', 1, 0, '{"moduleclass_sfx":"","width":"34","text":"","button":"1","button_pos":"right","imagebutton":"","button_text":"find","set_itemid":"","cache":"1","cache_time":"900"}', 0, '*'),
(29, 'Random Image', '', '', 5, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_random_image', 1, 1, '{"type":"jpg","folder":"","link":"","width":"","height":"","moduleclass_sfx":"","cache":"0","cache_time":"900"}', 0, '*'),
(30, 'Banners', '', '', 1, 'banner', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_banners', 1, 0, '{"target":"1","count":"1","cid":"0","catid":["27"],"tag_search":"0","ordering":"random","header_text":"","footer_text":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"15"}', 0, '*'),
(31, 'Wrapper', '', '', 4, 'bottom_row_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_wrapper', 1, 1, '{"moduleclass_sfx":"","url":"","scrolling":"auto","width":"100%","height":"200","height_auto":"1","add":"1","target":"","cache":"0","cache_time":"900"}', 0, '*'),
(32, 'Feed Display', '', '', 4, 'above_body_2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_feed', 1, 1, '{"moduleclass_sfx":"","rssurl":"","rssrtl":"0","rsstitle":"1","rssdesc":"1","rssimage":"1","rssitems":"3","rssitemdesc":"1","word_count":"0","cache":"0","cache_time":"15"}', 0, '*'),
(33, 'Breadcrumbs', '', '', 1, 'breadcrumb', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 1, 1, '{"showHome":"1","homeText":"Home","showLast":"1","separator":"","moduleclass_sfx":"","cache":"0","layout":"_:default","cache_time":"900","cachemode":"itemid"}', 0, '*'),
(34, 'Syndication', '', '', 3, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_syndicate', 1, 1, '{"cache":"0","text":"Feed Entries","format":"rss","moduleclass_sfx":""}', 0, '*'),
(35, 'Advertisement', '', '', 6, 'left', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_banners', 1, 1, '{"target":"1","count":"4","cid":"0","catid":"14","tag_search":"0","ordering":"0","header_text":"Featured Links:","footer_text":"<a href=\\"http:\\/\\/www.joomla.org\\">Ads by Joomla!<\\/a>","moduleclass_sfx":"_text","cache":"0","cache_time":"900"}', 0, '*'),
(36, 'debug', '', '<p>This is the default debug module style.</p>', 1, 'debug', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(37, 'Our Latest News', '', '', 1, 'bottom_row1_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_articles_latest', 1, 1, '{"catid":[""],"count":"4","show_featured":"","ordering":"c_dsc","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"_:static"}', 0, '*'),
(40, 'Top Menu', '', '', 0, 'top_menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 1, '{"menutype":"second-menu","menu_style":"list","startLevel":1,"endLevel":0,"showAllChildren":0,"window_open":"","show_whitespace":0,"cache":1,"tag_id":"","class_sfx":"","moduleclass_sfx":"","maxdepth":10,"menu_images":0,"menu_images_align":0,"menu_images_link":0,"expand_menu":0,"activate_parent":0,"full_active_id":0,"indent_image":0,"indent_image1":"","indent_image2":"","indent_image3":"","indent_image4":"","indent_image5":"","indent_image6":"","spacer":"","end_spacer":""}', 0, '*'),
(41, 'Top Row1 Modules', '', 'This is an example of a module published to the top_row_1 row. This row contains 6 modules, read below for a full description.', 4, 'top_row1_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(42, 'Top Row2 Modules', '', 'This is an example of a module published to the top_row_2 row. This row contains 6 modules, read below for a full description.', 0, 'top_row2_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(43, 'Top Row3 Modules', '', '<p>This is an example of a module published to the top_row_3 row. This row contains 6 modules, read below for a full description.</p>', 3, 'top_row3_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(44, 'Bottom Row1 Modules', '', 'This is an example of a module published to the bottom_row_1 row. This row contains 6 modules, read above for a full description.', 4, 'bottom_row1_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(45, 'Bottom Row2 Modules', '', 'This is an example of a module published to the bottom_row_2 row. This row contains 6 modules, read above for a full description.', 0, 'bottom_row2_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(46, 'Bottom Row3 Modules', '', 'This is an example of a module published to the bottom_row_3 row. This row contains 6 modules, read above for a full description.', 1, 'bottom_row3_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(47, 'Mobile Top 1', '', 'This is the default mobile_top_1 position and is shown only on mobile devices.', 2, 'mobile_top_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(48, 'Mobile Top 2', '', 'This is the default mobile_top_2 position and is shown only on mobile devices.', 2, 'mobile_top_2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(49, 'Mobile Bottom 2', '', 'This is the default mobile_bottom_2 position and is shown only on mobile devices.', 1, 'mobile_bottom_2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(50, 'Mobile Bottom 1', '', 'This is the default mobile_bottom_1 position and is shown only on mobile devices.', 2, 'mobile_bottom_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(51, 'Right', '', 'This is an example of a module published to the right position. There is also a left position and many others, be sure to read the full description. This is the default style that will appear for most modules.', 3, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(52, 'Right Inset', '', 'This is an example of a module published to the right_inset position. There is also a left_inset position and many others, be sure to read the full description.', 1, 'right_inset', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(54, 'Demo Information', '', '<div style="font-size: 1em; line-height: 148%;">All content and images shown on this site is for demo, presentation purposes only. This site is intended to exemplify a live and published website and does not make any claim of any kind to the validity of non-Shape5 content, articles, images or posts published to this site.</div>', 1, 'bottom_row1_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(55, 'Site Shaper Available', '', '<p>Do you need a website up and running quickly? Then a site shaper is just what you are looking for. A Site Shaper is a quick and easy way to get your site looking just like our demo in just minutes! It includes Joomla itself, this template and any extensions that you see on this demo. It also installs the same module and article content, making an exact copy of this demo with very little effort. <a href="index.php/tutorials-mainmenu-48/site-shaper-setup">Learn More...</a></p>', 1, 'bottom_row2_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"-dark","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(93, 'Bottom Menu', '', '', 0, 'bottom_menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 1, '{"menutype":"bottom-menu","startLevel":"1","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*'),
(94, 'Unlimited Layout Options', '', '<p><span style="line-height: 158%;">Because there are so many module positions available in so many different areas, the number of layouts you can create with this template are limitless! <a href="index.php/features-mainmenu-47/template-features/94-module-positions">Learn More...</a></span></p>', 4, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(95, 'Multibox', '', '<a href="images/vertex_large1.jpg" id="mb1" class="s5mb" title="Image #1:">\r\n<img style="float: left; cursor: pointer; margin-right: 24px; margin-left:0px; margin-bottom:0px; margin-top:8px;" class="padded" src="images/vertex1.jpg" alt=""></img>\r\n</a>\r\n\r\n<a href="images/vertex_large2.jpg" id="mb2" class="s5mb" title="Image #2:">\r\n<img style="float: left; cursor: pointer; margin-right: 24px; margin-left:0px; margin-bottom:0px; margin-top:8px;" class="padded" src="images/vertex2.jpg" alt=""></img>\r\n</a>\r\n\r\n<a href="images/vertex_large3.jpg" id="mb3" class="s5mb" title="Image #3:">\r\n<img style="float: left; cursor: pointer; margin-right: 0px; margin-left:0px; margin-bottom:0px; margin-top:8px;" class="padded" src="images/vertex3.jpg" alt=""></img>\r\n</a>\r\n\r\n<div style="clear:both;height:0px; margin-bottom:22px"></div>\r\n\r\nThe S5 Vertex Framework is a set of functionality that creates the core logic and structure of a template. The purpose of the S5 Vertex framework is to unify the layouts, designs, and functions that Shape5 has built over the years to create one of the most flexible, robust and powerful template blue prints available! \r\n<br /><br />\r\nSome of the great features of S5 Vertext include: Fixed or Fluid layouts, custom page, row and column widths, an average of 80 module positions giving you an almost unlimited amount of layouts including up to 5 columns, S5 Flex Menu, mobile device support, integrated multibox and tooltips, third party component styling, google font integration, SEF optimized layout, RTL language support, and so much more! The functionality of the S5 Vertex Framework is endless. Sieze the power of this great framework today for your site! <a target="blank" href="http://www.shape5.com/joomla/framework/vertex_framework.html">Read more...</a>\r\n\r\n<div style="clear:both;height:8px"></div>', 1, 'top_row1_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(58, 'Featured News', '', '', 0, 'right_inset', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_articles_news', 1, 0, '{"layout":"vertical","image":"0","link_titles":"1","showLastSeparator":"0","item_title":"1","moduleclass_sfx":"","cache":"0","cache_time":"900","catid":["22"],"item_heading":"h4","count":"5","ordering":"a.publish_up","cachemode":"itemid"}', 0, '*'),
(96, '-dark', '', 'This is an example of the -dark module class suffix.', 3, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"-dark","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(62, 'S5 Flex Menu Sample Module', '', '<div style="width:182px;font-size:0.85em"><div style="float:left;overflow:hidden;width:86px"><img style="height:58px" src="http://www.shape5.com/demo/images/multibox3.jpg" alt=""></img></div>This is a sample module to showcase the functionality of the S5 Flex Menu system. This menu system contains up to 40 module positions and you can publish any module to any of these positions under any menu item.</div>', 0, 's5_menu1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 0, '{"moduleclass_sfx":""}', 0, '*'),
(97, '-none', '', 'This is an example of the -none module class suffix.', 3, 'right', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"-none","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(67, 'Sample Drop Down Module', '', 'This is an example of a module published to the drop_down row. This row contains 6 modules. To enable the drop down simple publish any module to any of the drop_down_x positions.', 0, 'drop_down_1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 1, '{"moduleclass_sfx":""}', 0, '*'),
(86, 'Banner Position', '', '<p>This is a custom html module published to the ''banner'' position with the suffix -style1 applied.</p>', 2, 'banner', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_custom', 1, 1, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"-style1","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(92, 'Search', '', '', 1, 'search', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_finder', 1, 0, '{"searchfilter":"","show_autosuggest":"1","show_advanced":"0","layout":"_:default","moduleclass_sfx":"","field_size":25,"alt_label":"","show_label":"1","label_pos":"top","show_button":"1","button_pos":"right","opensearch":"1","opensearch_title":""}', 0, '*'),
(91, 'Multilanguage status', '', '', 1, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_multilangstatus', 3, 1, '{"layout":"_:default","moduleclass_sfx":"","cache":"0"}', 1, '*');

-- --------------------------------------------------------

--
-- Table structure for table `#__modules_menu`
--

DROP TABLE IF EXISTS `#__modules_menu`;
CREATE TABLE IF NOT EXISTS `#__modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__modules_menu`
--

INSERT INTO `#__modules_menu` (`moduleid`, `menuid`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(12, 0),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(18, 0),
(19, 102),
(19, 103),
(19, 104),
(19, 105),
(19, 106),
(19, 107),
(19, 108),
(19, 109),
(19, 110),
(19, 111),
(19, 112),
(19, 113),
(19, 114),
(19, 115),
(19, 116),
(19, 117),
(19, 118),
(19, 119),
(19, 120),
(19, 122),
(19, 123),
(19, 124),
(19, 126),
(19, 127),
(19, 128),
(19, 129),
(19, 130),
(19, 131),
(19, 133),
(19, 134),
(19, 135),
(19, 136),
(19, 137),
(19, 138),
(19, 143),
(19, 144),
(19, 145),
(19, 146),
(19, 149),
(19, 150),
(19, 152),
(19, 154),
(19, 178),
(19, 179),
(19, 182),
(19, 183),
(19, 184),
(19, 185),
(19, 186),
(19, 187),
(19, 188),
(19, 189),
(19, 190),
(19, 191),
(19, 192),
(19, 193),
(19, 195),
(19, 197),
(19, 198),
(19, 199),
(19, 200),
(19, 202),
(19, 203),
(19, 204),
(19, 205),
(19, 206),
(19, 207),
(19, 208),
(19, 209),
(19, 210),
(20, 0),
(21, 102),
(22, 0),
(23, 102),
(24, 102),
(24, 103),
(24, 104),
(24, 105),
(24, 106),
(24, 108),
(24, 109),
(24, 110),
(24, 111),
(24, 112),
(24, 113),
(24, 114),
(24, 115),
(24, 116),
(24, 117),
(24, 118),
(24, 119),
(24, 120),
(24, 122),
(24, 123),
(24, 124),
(24, 126),
(24, 127),
(24, 128),
(24, 129),
(24, 130),
(24, 131),
(24, 132),
(24, 134),
(24, 135),
(24, 136),
(24, 137),
(24, 138),
(24, 143),
(24, 144),
(24, 145),
(24, 146),
(24, 147),
(24, 148),
(24, 149),
(24, 150),
(24, 152),
(24, 153),
(24, 154),
(24, 155),
(24, 178),
(24, 179),
(24, 182),
(24, 183),
(24, 184),
(24, 185),
(24, 186),
(24, 187),
(24, 188),
(24, 189),
(24, 190),
(24, 191),
(24, 192),
(24, 193),
(24, 194),
(24, 195),
(24, 197),
(24, 198),
(24, 199),
(24, 200),
(25, 0),
(26, 0),
(28, 102),
(28, 103),
(28, 104),
(28, 105),
(28, 106),
(28, 108),
(28, 109),
(28, 110),
(28, 111),
(28, 112),
(28, 113),
(28, 114),
(28, 115),
(28, 116),
(28, 117),
(28, 118),
(28, 119),
(28, 120),
(28, 122),
(28, 123),
(28, 124),
(28, 126),
(28, 127),
(28, 128),
(28, 129),
(28, 130),
(28, 131),
(28, 132),
(28, 134),
(28, 135),
(28, 136),
(28, 137),
(28, 138),
(28, 139),
(28, 140),
(28, 141),
(28, 142),
(28, 143),
(28, 144),
(28, 145),
(28, 146),
(28, 147),
(28, 148),
(28, 149),
(28, 150),
(28, 151),
(28, 152),
(28, 153),
(28, 154),
(28, 155),
(28, 156),
(28, 157),
(28, 158),
(28, 159),
(28, 160),
(28, 161),
(28, 162),
(28, 163),
(28, 164),
(28, 165),
(28, 166),
(28, 167),
(28, 168),
(28, 169),
(28, 170),
(28, 171),
(28, 172),
(28, 173),
(28, 174),
(28, 175),
(28, 176),
(28, 177),
(28, 178),
(28, 179),
(28, 180),
(28, 181),
(28, 182),
(28, 183),
(28, 184),
(28, 185),
(28, 186),
(28, 187),
(28, 188),
(28, 189),
(28, 190),
(28, 191),
(28, 192),
(28, 193),
(28, 194),
(28, 195),
(28, 196),
(28, 197),
(28, 198),
(28, 199),
(28, 200),
(28, 201),
(28, 202),
(28, 203),
(28, 204),
(30, 0),
(31, 0),
(31, 1),
(32, 0),
(33, 0),
(34, 0),
(35, 102),
(36, 121),
(36, 125),
(37, 102),
(37, 103),
(37, 104),
(37, 105),
(37, 106),
(37, 108),
(37, 109),
(37, 110),
(37, 111),
(37, 112),
(37, 113),
(37, 114),
(37, 115),
(37, 116),
(37, 117),
(37, 118),
(37, 119),
(37, 120),
(37, 122),
(37, 123),
(37, 124),
(37, 126),
(37, 127),
(37, 128),
(37, 129),
(37, 130),
(37, 131),
(37, 132),
(37, 134),
(37, 135),
(37, 136),
(37, 137),
(37, 138),
(37, 143),
(37, 144),
(37, 145),
(37, 146),
(37, 147),
(37, 148),
(37, 149),
(37, 150),
(37, 152),
(37, 153),
(37, 154),
(37, 155),
(37, 178),
(37, 179),
(37, 182),
(37, 183),
(37, 184),
(37, 185),
(37, 186),
(37, 187),
(37, 188),
(37, 189),
(37, 190),
(37, 191),
(37, 192),
(37, 193),
(37, 194),
(37, 195),
(37, 197),
(37, 198),
(37, 199),
(37, 200),
(39, 0),
(39, 47),
(40, 0),
(41, 121),
(41, 125),
(42, 121),
(42, 125),
(43, 121),
(43, 125),
(44, 121),
(44, 125),
(45, 121),
(45, 125),
(46, 121),
(46, 125),
(47, 102),
(48, 102),
(49, 102),
(50, 102),
(51, 121),
(51, 125),
(52, 121),
(52, 125),
(54, 102),
(54, 103),
(54, 104),
(54, 105),
(54, 106),
(54, 108),
(54, 109),
(54, 110),
(54, 111),
(54, 112),
(54, 113),
(54, 114),
(54, 115),
(54, 116),
(54, 117),
(54, 118),
(54, 119),
(54, 120),
(54, 122),
(54, 123),
(54, 124),
(54, 126),
(54, 127),
(54, 128),
(54, 129),
(54, 130),
(54, 131),
(54, 132),
(54, 134),
(54, 135),
(54, 136),
(54, 137),
(54, 138),
(54, 143),
(54, 144),
(54, 145),
(54, 146),
(54, 147),
(54, 148),
(54, 149),
(54, 150),
(54, 152),
(54, 153),
(54, 154),
(54, 155),
(54, 178),
(54, 179),
(54, 182),
(54, 183),
(54, 184),
(54, 185),
(54, 186),
(54, 187),
(54, 188),
(54, 189),
(54, 190),
(54, 191),
(54, 192),
(54, 193),
(54, 194),
(54, 195),
(54, 197),
(54, 198),
(54, 199),
(54, 200),
(55, 102),
(56, 0),
(57, 102),
(57, 103),
(57, 104),
(57, 105),
(57, 106),
(57, 108),
(57, 109),
(57, 110),
(57, 111),
(57, 112),
(57, 113),
(57, 114),
(57, 115),
(57, 116),
(57, 117),
(57, 118),
(57, 119),
(57, 120),
(57, 122),
(57, 123),
(57, 124),
(57, 126),
(57, 127),
(57, 128),
(57, 129),
(57, 130),
(57, 131),
(57, 132),
(57, 134),
(57, 135),
(57, 136),
(57, 137),
(57, 138),
(57, 139),
(57, 140),
(57, 141),
(57, 142),
(57, 143),
(57, 144),
(57, 145),
(57, 146),
(57, 147),
(57, 148),
(57, 149),
(57, 150),
(57, 151),
(57, 152),
(57, 153),
(57, 154),
(57, 155),
(57, 156),
(57, 157),
(57, 158),
(57, 159),
(57, 160),
(57, 161),
(57, 162),
(57, 163),
(57, 164),
(57, 165),
(57, 166),
(57, 167),
(57, 168),
(57, 169),
(57, 170),
(57, 171),
(57, 172),
(57, 173),
(57, 174),
(57, 175),
(57, 176),
(57, 177),
(57, 178),
(57, 179),
(57, 180),
(57, 181),
(57, 182),
(57, 183),
(57, 184),
(57, 185),
(57, 186),
(57, 187),
(57, 188),
(57, 189),
(57, 190),
(57, 191),
(57, 192),
(57, 193),
(57, 194),
(57, 195),
(57, 196),
(57, 197),
(57, 198),
(57, 199),
(57, 200),
(58, 102),
(59, 102),
(59, 103),
(59, 104),
(59, 105),
(59, 106),
(59, 108),
(59, 109),
(59, 110),
(59, 111),
(59, 112),
(59, 113),
(59, 114),
(59, 115),
(59, 116),
(59, 117),
(59, 118),
(59, 119),
(59, 120),
(59, 122),
(59, 123),
(59, 124),
(59, 126),
(59, 127),
(59, 128),
(59, 129),
(59, 130),
(59, 131),
(59, 132),
(59, 134),
(59, 135),
(59, 136),
(59, 137),
(59, 138),
(59, 139),
(59, 140),
(59, 141),
(59, 142),
(59, 143),
(59, 144),
(59, 145),
(59, 146),
(59, 147),
(59, 148),
(59, 149),
(59, 150),
(59, 151),
(59, 152),
(59, 153),
(59, 154),
(59, 155),
(59, 156),
(59, 157),
(59, 158),
(59, 159),
(59, 160),
(59, 161),
(59, 162),
(59, 163),
(59, 164),
(59, 165),
(59, 166),
(59, 167),
(59, 168),
(59, 169),
(59, 170),
(59, 171),
(59, 172),
(59, 173),
(59, 174),
(59, 175),
(59, 176),
(59, 177),
(59, 178),
(59, 179),
(59, 180),
(59, 181),
(59, 182),
(59, 183),
(59, 184),
(59, 185),
(59, 186),
(59, 187),
(59, 188),
(59, 189),
(59, 190),
(59, 191),
(59, 192),
(59, 193),
(59, 194),
(59, 195),
(59, 196),
(59, 197),
(59, 198),
(59, 199),
(59, 200),
(60, 102),
(60, 103),
(60, 104),
(60, 105),
(60, 106),
(60, 108),
(60, 109),
(60, 110),
(60, 111),
(60, 112),
(60, 113),
(60, 114),
(60, 115),
(60, 116),
(60, 117),
(60, 118),
(60, 119),
(60, 120),
(60, 122),
(60, 123),
(60, 124),
(60, 126),
(60, 127),
(60, 128),
(60, 129),
(60, 130),
(60, 131),
(60, 132),
(60, 133),
(60, 134),
(60, 135),
(60, 136),
(60, 137),
(60, 138),
(60, 139),
(60, 140),
(60, 141),
(60, 142),
(60, 143),
(60, 144),
(60, 145),
(60, 146),
(60, 147),
(60, 148),
(60, 149),
(60, 150),
(60, 151),
(60, 152),
(60, 153),
(60, 154),
(60, 155),
(60, 156),
(60, 157),
(60, 158),
(60, 159),
(60, 160),
(60, 161),
(60, 162),
(60, 163),
(60, 164),
(60, 165),
(60, 166),
(60, 167),
(60, 168),
(60, 169),
(60, 170),
(60, 171),
(60, 172),
(60, 173),
(60, 174),
(60, 175),
(60, 176),
(60, 177),
(60, 179),
(60, 182),
(60, 192),
(60, 193),
(60, 194),
(62, 0),
(63, 121),
(63, 125),
(64, 121),
(64, 125),
(65, 121),
(65, 125),
(66, 121),
(66, 125),
(67, 121),
(67, 125),
(67, 200),
(68, 102),
(68, 103),
(68, 104),
(68, 105),
(68, 106),
(68, 108),
(68, 109),
(68, 110),
(68, 111),
(68, 112),
(68, 113),
(68, 114),
(68, 115),
(68, 116),
(68, 117),
(68, 118),
(68, 119),
(68, 120),
(68, 122),
(68, 123),
(68, 124),
(68, 126),
(68, 127),
(68, 128),
(68, 129),
(68, 130),
(68, 131),
(68, 132),
(68, 134),
(68, 135),
(68, 136),
(68, 137),
(68, 138),
(68, 139),
(68, 140),
(68, 141),
(68, 142),
(68, 143),
(68, 144),
(68, 145),
(68, 146),
(68, 147),
(68, 148),
(68, 149),
(68, 150),
(68, 151),
(68, 152),
(68, 153),
(68, 154),
(68, 155),
(68, 156),
(68, 157),
(68, 158),
(68, 159),
(68, 160),
(68, 161),
(68, 162),
(68, 163),
(68, 164),
(68, 165),
(68, 166),
(68, 167),
(68, 168),
(68, 169),
(68, 170),
(68, 171),
(68, 172),
(68, 173),
(68, 174),
(68, 175),
(68, 176),
(68, 177),
(68, 178),
(68, 179),
(68, 180),
(68, 181),
(68, 182),
(68, 183),
(68, 184),
(68, 185),
(68, 186),
(68, 187),
(68, 188),
(68, 189),
(68, 190),
(68, 191),
(68, 192),
(68, 193),
(68, 194),
(68, 195),
(68, 196),
(68, 197),
(68, 198),
(68, 199),
(68, 200),
(68, 201),
(68, 202),
(68, 203),
(68, 204),
(70, 0),
(71, 0),
(72, 102),
(72, 201),
(73, 102),
(74, 102),
(75, 102),
(76, 102),
(77, 102),
(78, 102),
(79, 102),
(79, 145),
(79, 198),
(79, 199),
(80, 102),
(80, 103),
(80, 104),
(80, 105),
(80, 106),
(80, 108),
(80, 109),
(80, 110),
(80, 111),
(80, 112),
(80, 113),
(80, 114),
(80, 115),
(80, 116),
(80, 117),
(80, 118),
(80, 119),
(80, 120),
(80, 122),
(80, 123),
(80, 124),
(80, 126),
(80, 127),
(80, 128),
(80, 129),
(80, 130),
(80, 131),
(80, 132),
(80, 134),
(80, 135),
(80, 136),
(80, 137),
(80, 138),
(80, 139),
(80, 140),
(80, 141),
(80, 142),
(80, 143),
(80, 144),
(80, 145),
(80, 146),
(80, 147),
(80, 148),
(80, 149),
(80, 150),
(80, 151),
(80, 152),
(80, 153),
(80, 154),
(80, 155),
(80, 156),
(80, 157),
(80, 158),
(80, 159),
(80, 160),
(80, 161),
(80, 162),
(80, 163),
(80, 164),
(80, 165),
(80, 166),
(80, 167),
(80, 168),
(80, 169),
(80, 170),
(80, 171),
(80, 172),
(80, 173),
(80, 174),
(80, 175),
(80, 176),
(80, 177),
(80, 178),
(80, 179),
(80, 180),
(80, 181),
(80, 182),
(80, 183),
(80, 184),
(80, 185),
(80, 186),
(80, 187),
(80, 188),
(80, 189),
(80, 190),
(80, 191),
(80, 192),
(80, 193),
(80, 194),
(80, 195),
(80, 196),
(80, 197),
(80, 198),
(80, 199),
(80, 200),
(81, 102),
(81, 103),
(81, 104),
(81, 105),
(81, 106),
(81, 108),
(81, 109),
(81, 110),
(81, 111),
(81, 112),
(81, 113),
(81, 114),
(81, 115),
(81, 116),
(81, 117),
(81, 118),
(81, 119),
(81, 120),
(81, 122),
(81, 123),
(81, 124),
(81, 126),
(81, 127),
(81, 128),
(81, 129),
(81, 130),
(81, 131),
(81, 132),
(81, 134),
(81, 135),
(81, 136),
(81, 137),
(81, 138),
(81, 139),
(81, 140),
(81, 141),
(81, 142),
(81, 143),
(81, 144),
(81, 145),
(81, 146),
(81, 147),
(81, 148),
(81, 149),
(81, 150),
(81, 151),
(81, 152),
(81, 153),
(81, 154),
(81, 155),
(81, 156),
(81, 157),
(81, 158),
(81, 159),
(81, 160),
(81, 161),
(81, 162),
(81, 163),
(81, 164),
(81, 165),
(81, 166),
(81, 167),
(81, 168),
(81, 169),
(81, 170),
(81, 171),
(81, 172),
(81, 173),
(81, 174),
(81, 175),
(81, 176),
(81, 177),
(81, 178),
(81, 179),
(81, 180),
(81, 181),
(81, 182),
(81, 183),
(81, 184),
(81, 185),
(81, 186),
(81, 187),
(81, 188),
(81, 189),
(81, 190),
(81, 191),
(81, 192),
(81, 193),
(81, 194),
(81, 195),
(81, 196),
(81, 197),
(81, 198),
(81, 199),
(81, 200),
(83, 0),
(84, 0),
(85, 0),
(86, 0),
(87, 121),
(87, 125),
(88, 121),
(88, 125),
(89, 121),
(89, 125),
(90, 121),
(90, 125),
(91, 0),
(92, 0),
(93, 0),
(94, 102),
(95, 102),
(96, 121),
(96, 125),
(97, 121),
(97, 125),
(248, 1),
(249, 1),
(258, 1),
(259, 1),
(590, 1),
(590, 2),
(590, 5),
(590, 7),
(590, 8),
(590, 23),
(590, 26),
(590, 27),
(590, 28),
(590, 32),
(590, 33),
(590, 34),
(590, 35),
(590, 36),
(590, 37),
(590, 38),
(590, 47),
(590, 48),
(590, 81),
(590, 88),
(590, 89),
(590, 93),
(590, 96),
(590, 97),
(590, 99),
(590, 100),
(590, 113),
(590, 120),
(590, 129),
(590, 141),
(590, 142),
(590, 201),
(590, 202),
(590, 207),
(590, 210),
(590, 211),
(590, 213),
(590, 214),
(590, 225),
(590, 226),
(590, 228),
(590, 230),
(590, 233),
(590, 234),
(590, 250),
(590, 252),
(590, 259),
(590, 264),
(590, 266),
(590, 268),
(590, 269),
(590, 270),
(590, 275),
(590, 276),
(590, 277),
(590, 278),
(590, 279),
(590, 280),
(590, 281),
(590, 282),
(590, 283),
(590, 284),
(590, 285),
(590, 286),
(590, 287),
(590, 288),
(590, 289),
(590, 290),
(590, 291),
(590, 292),
(590, 293),
(590, 294),
(590, 295);

-- --------------------------------------------------------

--
-- Table structure for table `#__molajotools_customperms`
--

DROP TABLE IF EXISTS `#__molajotools_customperms`;
CREATE TABLE IF NOT EXISTS `#__molajotools_customperms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `perms` varchar(4) DEFAULT '0644',
  UNIQUE KEY `id` (`id`),
  KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__molajotools_customperms`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__newsfeeds`
--

DROP TABLE IF EXISTS `#__newsfeeds`;
CREATE TABLE IF NOT EXISTS `#__newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `link` varchar(200) NOT NULL DEFAULT '',
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(10) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(10) unsigned NOT NULL DEFAULT '3600',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  `access` int(10) unsigned DEFAULT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `#__newsfeeds`
--

INSERT INTO `#__newsfeeds` (`catid`, `id`, `name`, `alias`, `link`, `filename`, `published`, `numarticles`, `cache_time`, `checked_out`, `checked_out_time`, `ordering`, `rtl`, `access`, `language`, `params`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `metakey`, `metadesc`, `metadata`, `xreference`, `publish_up`, `publish_down`) VALUES
(29, 1, 'Joomla! Announcements', 'joomla-official-news', 'http://feeds.joomla.org/JoomlaAnnouncements', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 1, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 2, 'Joomla! Core Team Blog', 'joomla-core-team-blog', 'http://feeds.joomla.org/JoomlaCommunityCoreTeamBlog', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 2, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 3, 'Joomla! Community Magazine', 'joomla-community-magazine', 'http://feeds.joomla.org/JoomlaMagazine', '', 1, 20, 3600, 0, '0000-00-00 00:00:00', 3, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 4, 'Joomla! Developer News', 'joomla-developer-news', 'http://feeds.joomla.org/JoomlaDeveloper', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 4, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 5, 'Joomla! Security News', 'joomla-security-news', 'http://feeds.joomla.org/JoomlaSecurityNews', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 5, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 6, 'Free Software Foundation Blogs', 'free-software-foundation-blogs', 'http://www.fsf.org/blogs/RSS', NULL, 1, 5, 3600, 0, '0000-00-00 00:00:00', 4, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 7, 'Free Software Foundation', 'free-software-foundation', 'http://www.fsf.org/news/RSS', NULL, 1, 5, 3600, 62, '2008-09-14 00:24:25', 3, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 8, 'Software Freedom Law Center Blog', 'software-freedom-law-center-blog', 'http://www.softwarefreedom.org/feeds/blog/', NULL, 1, 5, 3600, 0, '0000-00-00 00:00:00', 2, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 9, 'Software Freedom Law Center News', 'software-freedom-law-center', 'http://www.softwarefreedom.org/feeds/news/', NULL, 1, 5, 3600, 0, '0000-00-00 00:00:00', 1, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 10, 'Open Source Initiative Blog', 'open-source-initiative-blog', 'http://www.opensource.org/blog/feed', NULL, 1, 5, 3600, 0, '0000-00-00 00:00:00', 5, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 11, 'PHP News and Announcements', 'php-news-and-announcements', 'http://www.php.net/feed.atom', NULL, 1, 5, 3600, 62, '2008-09-14 00:25:37', 1, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 12, 'Planet MySQL', 'planet-mysql', 'http://www.planetmysql.org/rss20.xml', NULL, 1, 5, 3600, 62, '2008-09-14 00:25:51', 2, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 13, 'Linux Foundation Announcements', 'linux-foundation-announcements', 'http://www.linuxfoundation.org/press/rss20.xml', NULL, 1, 5, 3600, 62, '2008-09-14 00:26:11', 3, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 14, 'Mootools Blog', 'mootools-blog', 'http://feeds.feedburner.com/mootools-blog', NULL, 1, 5, 3600, 62, '2008-09-14 00:26:51', 4, 0, 1, '*', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `#__overrider`
--

DROP TABLE IF EXISTS `#__overrider`;
CREATE TABLE IF NOT EXISTS `#__overrider` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `constant` varchar(255) NOT NULL,
  `string` text NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__overrider`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__redirect_links`
--

DROP TABLE IF EXISTS `#__redirect_links`;
CREATE TABLE IF NOT EXISTS `#__redirect_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(255) DEFAULT NULL,
  `new_url` varchar(255) DEFAULT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `#__redirect_links`
--

INSERT INTO `#__redirect_links` (`id`, `old_url`, `new_url`, `referer`, `comment`, `published`, `created_date`, `modified_date`) VALUES
(1, 'http://localhost/sienna/jupgrade/index.php/images/flexmenu.jpg', NULL, 'http://localhost/sienna/jupgrade/index.php/s5-flex-menu-1121', '', 0, '2011-12-14 20:06:00', '0000-00-00 00:00:00'),
(2, 'http://localhost/vertex/index.php/extensions/index.php', '', 'http://localhost/vertex/index.php/extensions/s5-accordion-menu', '', 0, '2012-01-30 22:51:17', '0000-00-00 00:00:00'),
(3, 'http://localhost/vertex/index.php/features-mainmenu-47/template-features/93-module-positions', '', 'http://localhost/vertex/index.php/features-mainmenu-47/template-specific-features', '', 0, '2012-01-31 02:27:08', '0000-00-00 00:00:00'),
(4, 'http://localhost/vertex/index.php/component/content/?id=39&Itemid=89', '', 'http://localhost/vertex/', '', 0, '2012-01-31 20:08:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `#__responses`
--

DROP TABLE IF EXISTS `#__responses`;
CREATE TABLE IF NOT EXISTS `#__responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(11) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `extension` varchar(50) NOT NULL DEFAULT '' COMMENT 'Joomla! Extension that this response',
  `content_id` int(10) unsigned NOT NULL COMMENT 'Response to Primary Key for Content',
  `content_title` varchar(255) NOT NULL DEFAULT 'Resposne to Primary Key Content Title',
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Response to Content Category ID',
  `response_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1: Comment 2: Content Rating 3: Social Bookmark 4: Poll Response 5: Email Subscription Response 6: Statistical Log 7: Trackback',
  `title` varchar(255) NOT NULL DEFAULT 'Response Title',
  `alias` varchar(255) NOT NULL DEFAULT 'Response Alias',
  `textual_response` mediumtext NOT NULL COMMENT 'Textual Response to Content',
  `numeric_response` int(11) NOT NULL DEFAULT '0' COMMENT 'Numeric Resposne to Content',
  `linked_response` varchar(255) NOT NULL DEFAULT '' COMMENT 'Linked Response to Content',
  `subscription_response` varchar(255) NOT NULL DEFAULT '' COMMENT 'Email Subscription to Content',
  `state` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'State',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Created Date and Time',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Created By User ID, if Member',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Created By Alias',
  `created_by_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Created By Email Address',
  `created_by_website` varchar(255) NOT NULL DEFAULT '' COMMENT 'Created By Website',
  `created_by_ip_address` varchar(10) NOT NULL DEFAULT '' COMMENT 'Created By IP Address',
  `created_by_referer` varchar(10) NOT NULL DEFAULT '' COMMENT 'Created By Referer',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified Date and Time',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Modified By User ID',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Checked Out User ID',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Checked Out Date and Time',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Publish Up Date and Time',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Publish Down Date and Time',
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if response item is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the response.',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Ordering within the Content Item.',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_extension` (`extension`,`content_id`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__responses`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__schemas`
--

DROP TABLE IF EXISTS `#__schemas`;
CREATE TABLE IF NOT EXISTS `#__schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__schemas`
--

INSERT INTO `#__schemas` (`extension_id`, `version_id`) VALUES
(700, '2.5.0-2012-01-14');

-- --------------------------------------------------------

--
-- Table structure for table `#__session`
--

DROP TABLE IF EXISTS `#__session`;
CREATE TABLE IF NOT EXISTS `#__session` (
  `session_id` varchar(200) NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) DEFAULT '',
  `data` mediumtext,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) DEFAULT '',
  `usertype` varchar(50) DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__session`
--

INSERT INTO `#__session` (`session_id`, `client_id`, `guest`, `time`, `data`, `userid`, `username`, `usertype`) VALUES
('db7ee8663a6aa3bd89b53ad3a63bef97', 0, 1, '1328040755', '__default|a:9:{s:22:"session.client.browser";s:70:"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)";s:15:"session.counter";i:5;s:8:"registry";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:4:"user";O:5:"JUser":23:{s:9:"\0*\0isRoot";b:0;s:2:"id";i:0;s:4:"name";N;s:8:"username";N;s:5:"email";N;s:8:"password";N;s:14:"password_clear";s:0:"";s:8:"usertype";N;s:5:"block";N;s:9:"sendEmail";i:0;s:12:"registerDate";N;s:13:"lastvisitDate";N;s:10:"activation";N;s:6:"params";N;s:6:"groups";a:0:{}s:5:"guest";i:1;s:10:"\0*\0_params";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:14:"\0*\0_authGroups";a:1:{i:0;i:1;}s:14:"\0*\0_authLevels";a:2:{i:0;i:1;i:1;i:1;}s:15:"\0*\0_authActions";N;s:12:"\0*\0_errorMsg";N;s:10:"\0*\0_errors";a:0:{}s:3:"aid";i:0;}s:16:"com_mailto.links";a:3:{s:40:"6782dba09d958c5ce8b4f09d95497065fc8f549f";O:8:"stdClass":2:{s:4:"link";s:80:"http://localhost/vertex/index.php/20-frontpage/256-custom-page-and-column-widths";s:6:"expiry";i:1328040755;}s:40:"28d39fb15eea63687a1d589e567464f32f315f2f";O:8:"stdClass":2:{s:4:"link";s:89:"http://localhost/vertex/index.php/20-frontpage/255-hide-the-main-article-area-on-any-page";s:6:"expiry";i:1328040755;}s:40:"0a19460bf800eb0b29887612abce5b4615d92a30";O:8:"stdClass":2:{s:4:"link";s:85:"http://localhost/vertex/index.php/20-frontpage/254-lazy-load-images-save-on-bandwidth";s:6:"expiry";i:1328040755;}}s:13:"session.token";s:32:"7d5d15975c32665c57cddd5a9e36d698";s:19:"session.timer.start";i:1328038240;s:18:"session.timer.last";i:1328039915;s:17:"session.timer.now";i:1328040755;}', 0, '', ''),
('5rrk14oe4qnf66d7p2cqj3bvd1', 0, 1, '1328040664', '__default|a:9:{s:15:"session.counter";i:12;s:19:"session.timer.start";i:1328039077;s:18:"session.timer.last";i:1328040651;s:17:"session.timer.now";i:1328040663;s:22:"session.client.browser";s:74:"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0.2) Gecko/20100101 Firefox/6.0.2";s:8:"registry";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:4:"user";O:5:"JUser":23:{s:9:"\0*\0isRoot";b:0;s:2:"id";i:0;s:4:"name";N;s:8:"username";N;s:5:"email";N;s:8:"password";N;s:14:"password_clear";s:0:"";s:8:"usertype";N;s:5:"block";N;s:9:"sendEmail";i:0;s:12:"registerDate";N;s:13:"lastvisitDate";N;s:10:"activation";N;s:6:"params";N;s:6:"groups";a:0:{}s:5:"guest";i:1;s:10:"\0*\0_params";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:14:"\0*\0_authGroups";a:1:{i:0;i:1;}s:14:"\0*\0_authLevels";a:2:{i:0;i:1;i:1;i:1;}s:15:"\0*\0_authActions";N;s:12:"\0*\0_errorMsg";N;s:10:"\0*\0_errors";a:0:{}s:3:"aid";i:0;}s:16:"com_mailto.links";a:11:{s:40:"6782dba09d958c5ce8b4f09d95497065fc8f549f";O:8:"stdClass":2:{s:4:"link";s:80:"http://localhost/vertex/index.php/20-frontpage/256-custom-page-and-column-widths";s:6:"expiry";i:1328040549;}s:40:"28d39fb15eea63687a1d589e567464f32f315f2f";O:8:"stdClass":2:{s:4:"link";s:89:"http://localhost/vertex/index.php/20-frontpage/255-hide-the-main-article-area-on-any-page";s:6:"expiry";i:1328040549;}s:40:"0a19460bf800eb0b29887612abce5b4615d92a30";O:8:"stdClass":2:{s:4:"link";s:85:"http://localhost/vertex/index.php/20-frontpage/254-lazy-load-images-save-on-bandwidth";s:6:"expiry";i:1328040549;}s:40:"722f9d16e6cc2d3ba83c347bafba25e8a42bd948";O:8:"stdClass":2:{s:4:"link";s:73:"http://localhost/vertex/index.php/tutorials-mainmenu-48/site-shaper-setup";s:6:"expiry";i:1328040514;}s:40:"612ed8e8d7cac84d8f2030ac731900fb1fff16c4";O:8:"stdClass":2:{s:4:"link";s:103:"http://localhost/vertex/index.php/features-mainmenu-47/style-and-layout-options/fluid-and-fixed-layouts";s:6:"expiry";i:1328040626;}s:40:"8b31ff04a51fc450e7125aa4ce08f28a8f56c6b4";O:8:"stdClass":2:{s:4:"link";s:110:"http://localhost/vertex/index.php/features-mainmenu-47/style-and-layout-options/3rd-party-component-compatible";s:6:"expiry";i:1328040651;}s:40:"f548f41d91f03d4e41bab7a875fed55720f354c3";O:8:"stdClass":2:{s:4:"link";s:88:"http://localhost/vertex/index.php/features-mainmenu-47/template-features/drop-down-panel";s:6:"expiry";i:1328040651;}s:40:"12f3a8ce7e3caabc88adaa97586375949737bb62";O:8:"stdClass":2:{s:4:"link";s:71:"http://localhost/vertex/index.php/tutorials-mainmenu-48/lazy-load-setup";s:6:"expiry";i:1328040651;}s:40:"16bf2e4b33bde500880ffce37adbc64c6e544a65";O:8:"stdClass":2:{s:4:"link";s:100:"http://localhost/vertex/index.php/features-mainmenu-47/template-features/hide-article-component-area";s:6:"expiry";i:1328040651;}s:40:"81545f5e3470321d9d113f86b4dcbfca5ba43bfc";O:8:"stdClass":2:{s:4:"link";s:102:"http://localhost/vertex/index.php/features-mainmenu-47/style-and-layout-options/ie7-and-8-css3-support";s:6:"expiry";i:1328040651;}s:40:"8db41841e145bcaa4682b5135eeaf4d53494e034";O:8:"stdClass":2:{s:4:"link";s:51:"http://localhost/vertex/index.php/s5-flex-menu-1121";s:6:"expiry";i:1328040663;}}s:13:"session.token";s:32:"ba83339a7285581bec143df2a4352ac1";}', 0, '', ''),
('2e924dbvh7m11dg2d1v33unab4', 1, 0, '1328040599', '__default|a:8:{s:15:"session.counter";i:14;s:19:"session.timer.start";i:1328040518;s:18:"session.timer.last";i:1328040599;s:17:"session.timer.now";i:1328040599;s:22:"session.client.browser";s:74:"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0.2) Gecko/20100101 Firefox/6.0.2";s:8:"registry";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":5:{s:11:"application";O:8:"stdClass":1:{s:4:"lang";s:0:"";}s:13:"com_installer";O:8:"stdClass":2:{s:7:"message";s:0:"";s:17:"extension_message";s:0:"";}s:11:"com_modules";O:8:"stdClass":3:{s:7:"modules";O:8:"stdClass":4:{s:6:"filter";O:8:"stdClass":8:{s:18:"client_id_previous";i:0;s:6:"search";s:6:"shaper";s:6:"access";i:0;s:5:"state";s:0:"";s:8:"position";s:0:"";s:6:"module";s:0:"";s:9:"client_id";i:0;s:8:"language";s:0:"";}s:10:"limitstart";i:0;s:8:"ordercol";s:8:"position";s:9:"orderdirn";s:3:"asc";}s:4:"edit";O:8:"stdClass":1:{s:6:"module";O:8:"stdClass":2:{s:2:"id";a:0:{}s:4:"data";N;}}s:3:"add";O:8:"stdClass":1:{s:6:"module";O:8:"stdClass":2:{s:12:"extension_id";N;s:6:"params";N;}}}s:6:"global";O:8:"stdClass":1:{s:4:"list";O:8:"stdClass":1:{s:5:"limit";s:2:"20";}}s:13:"com_templates";O:8:"stdClass":2:{s:6:"styles";O:8:"stdClass":1:{s:10:"limitstart";i:0;}s:4:"edit";O:8:"stdClass":1:{s:5:"style";O:8:"stdClass":2:{s:2:"id";a:0:{}s:4:"data";N;}}}}}s:4:"user";O:5:"JUser":23:{s:9:"\0*\0isRoot";b:1;s:2:"id";s:2:"42";s:4:"name";s:10:"Super User";s:8:"username";s:5:"admin";s:5:"email";s:7:"a@a.com";s:8:"password";s:65:"d1978f35e7c7773be5367b46f5511fea:ng9efSz8kJTRtjFsgVJdcPQw3fsFi4KZ";s:14:"password_clear";s:0:"";s:8:"usertype";s:10:"deprecated";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"1";s:12:"registerDate";s:19:"2012-01-28 14:49:29";s:13:"lastvisitDate";s:19:"2012-01-31 14:49:32";s:10:"activation";s:0:"";s:6:"params";s:0:"";s:6:"groups";a:1:{i:8;s:1:"8";}s:5:"guest";i:0;s:10:"\0*\0_params";O:9:"JRegistry":1:{s:7:"\0*\0data";O:8:"stdClass":0:{}}s:14:"\0*\0_authGroups";a:2:{i:0;i:1;i:1;i:8;}s:14:"\0*\0_authLevels";a:4:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:3;}s:15:"\0*\0_authActions";N;s:12:"\0*\0_errorMsg";N;s:10:"\0*\0_errors";a:0:{}s:3:"aid";i:0;}s:13:"session.token";s:32:"e20d885cbf817dd53110a16de8799573";}', 42, 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `#__tags`
--

DROP TABLE IF EXISTS `#__tags`;
CREATE TABLE IF NOT EXISTS `#__tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(11) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `tag_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1: Tag 2: Section',
  `title` varchar(255) NOT NULL DEFAULT 'Tag Title',
  `alias` varchar(255) NOT NULL DEFAULT 'Tag Alias',
  `description` mediumtext NOT NULL COMMENT 'Tag Description',
  `state` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'State',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Created Date and Time',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Created By User ID, if Member',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Created By Alias',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified Date and Time',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Modified By User ID',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Checked Out User ID',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Checked Out Date and Time',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Publish Up Date and Time',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Publish Down Date and Time',
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if response item is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the response.',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Ordering within the Content Item.',
  PRIMARY KEY (`id`),
  KEY `idx_type_title` (`tag_type`,`title`),
  KEY `idx_type_alias` (`tag_type`,`alias`),
  KEY `idx_state` (`state`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `#__tags`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__tag_content`
--

DROP TABLE IF EXISTS `#__tag_content`;
CREATE TABLE IF NOT EXISTS `#__tag_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `tag_id` int(10) unsigned NOT NULL COMMENT 'Tag to Primary Key for Content',
  `extension` varchar(50) NOT NULL DEFAULT '' COMMENT 'Joomla! Extension associated with this Tag',
  `content_id` int(10) unsigned NOT NULL COMMENT 'Tag to Primary Key for Content',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`tag_id`),
  KEY `idx_extension` (`extension`,`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `#__tag_content`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__template_styles`
--

DROP TABLE IF EXISTS `#__template_styles`;
CREATE TABLE IF NOT EXISTS `#__template_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) NOT NULL DEFAULT '',
  `client_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `home` char(7) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `#__template_styles`
--

INSERT INTO `#__template_styles` (`id`, `template`, `client_id`, `home`, `title`, `params`) VALUES
(2, 'bluestork', 1, '1', 'Bluestork - Default', '{"useRoundedCorners":"1","showSiteName":"0"}'),
(3, 'atomic', 0, '0', 'Atomic - Default', '{}'),
(4, 'beez_20', 0, '0', 'Beez2 - Default', '{"wrapperSmall":"53","wrapperLarge":"72","logo":"images\\/joomla_black.gif","sitetitle":"Joomla!","sitedescription":"Open Source Content Management","navposition":"left","templatecolor":"personal","html5":"0"}'),
(6, 'beez5', 0, '0', 'Beez5 - Default-Fruit Shop', '{"wrapperSmall":"53","wrapperLarge":"72","logo":"images\\/sampledata\\/fruitshop\\/fruits.gif","sitetitle":"Matuna Market ","sitedescription":"Fruit Shop Sample Site","navposition":"left","html5":"0"}'),
(12, 'shape5_vertex', 0, '1', 'shape5_vertex - Default', '{"settings":"","s5_menu_type":"mainmenu","s5_hide_component_items":"-1"}');

-- --------------------------------------------------------

--
-- Table structure for table `#__updates`
--

DROP TABLE IF EXISTS `#__updates`;
CREATE TABLE IF NOT EXISTS `#__updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_site_id` int(11) DEFAULT '0',
  `extension_id` int(11) DEFAULT '0',
  `categoryid` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT '',
  `description` text NOT NULL,
  `element` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `folder` varchar(20) DEFAULT '',
  `client_id` tinyint(3) DEFAULT '0',
  `version` varchar(10) DEFAULT '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  `infourl` text NOT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Available Updates' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__updates`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__update_categories`
--

DROP TABLE IF EXISTS `#__update_categories`;
CREATE TABLE IF NOT EXISTS `#__update_categories` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '',
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `updatesite` int(11) DEFAULT '0',
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Update Categories' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__update_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__update_sites`
--

DROP TABLE IF EXISTS `#__update_sites`;
CREATE TABLE IF NOT EXISTS `#__update_sites` (
  `update_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `location` text NOT NULL,
  `enabled` int(11) DEFAULT '0',
  `last_check_timestamp` bigint(20) DEFAULT '0',
  PRIMARY KEY (`update_site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Update Sites' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `#__update_sites`
--

INSERT INTO `#__update_sites` (`update_site_id`, `name`, `type`, `location`, `enabled`, `last_check_timestamp`) VALUES
(1, 'Joomla Core', 'collection', 'http://update.joomla.org/core/list.xml', 1, 1328018842),
(2, 'Joomla Extension Directory', 'collection', 'http://update.joomla.org/jed/list.xml', 1, 1328018842);

-- --------------------------------------------------------

--
-- Table structure for table `#__update_sites_extensions`
--

DROP TABLE IF EXISTS `#__update_sites_extensions`;
CREATE TABLE IF NOT EXISTS `#__update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT '0',
  `extension_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';

--
-- Dumping data for table `#__update_sites_extensions`
--

INSERT INTO `#__update_sites_extensions` (`update_site_id`, `extension_id`) VALUES
(1, 700),
(2, 700);

-- --------------------------------------------------------

--
-- Table structure for table `#__usergroups`
--

DROP TABLE IF EXISTS `#__usergroups`;
CREATE TABLE IF NOT EXISTS `#__usergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `#__usergroups`
--

INSERT INTO `#__usergroups` (`id`, `parent_id`, `lft`, `rgt`, `title`) VALUES
(1, 0, 1, 16, 'Public'),
(2, 1, 6, 13, 'Registered'),
(3, 2, 7, 12, 'Author'),
(4, 3, 8, 11, 'Editor'),
(5, 4, 9, 10, 'Publisher'),
(6, 1, 2, 5, 'Manager'),
(7, 6, 3, 4, 'Administrator'),
(8, 1, 14, 15, 'Super Users');

-- --------------------------------------------------------

--
-- Table structure for table `#__users`
--

DROP TABLE IF EXISTS `#__users`;
CREATE TABLE IF NOT EXISTS `#__users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `#__users`

--
-- Table structure for table `#__user_notes`
--

DROP TABLE IF EXISTS `#__user_notes`;
CREATE TABLE IF NOT EXISTS `#__user_notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__user_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__user_profiles`
--

DROP TABLE IF EXISTS `#__user_profiles`;
CREATE TABLE IF NOT EXISTS `#__user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';

--
-- Dumping data for table `#__user_profiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__user_usergroup_map`
--

DROP TABLE IF EXISTS `#__user_usergroup_map`;
CREATE TABLE IF NOT EXISTS `#__user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__user_usergroup_map`

--
-- Table structure for table `#__viewlevels`
--

DROP TABLE IF EXISTS `#__viewlevels`;
CREATE TABLE IF NOT EXISTS `#__viewlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `#__viewlevels`
--

INSERT INTO `#__viewlevels` (`id`, `title`, `ordering`, `rules`) VALUES
(1, 'Public', 0, '[1]'),
(2, 'Registered', 1, '[6,2,8]'),
(3, 'Special', 2, '[6,3,8]');

-- --------------------------------------------------------

--
-- Table structure for table `#__weblinks`
--

DROP TABLE IF EXISTS `#__weblinks`;
CREATE TABLE IF NOT EXISTS `#__weblinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `#__weblinks`
--

INSERT INTO `#__weblinks` (`id`, `catid`, `sid`, `title`, `alias`, `url`, `description`, `date`, `hits`, `state`, `checked_out`, `checked_out_time`, `ordering`, `archived`, `approved`, `access`, `params`, `language`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `metakey`, `metadesc`, `metadata`, `featured`, `xreference`, `publish_up`, `publish_down`) VALUES
(1, 32, 0, 'Joomla!', 'joomla', 'http://www.joomla.org', 'Home of Joomla!', '2005-02-14 15:19:02', 3, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 1, '{"target":0}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 32, 0, 'php.net', 'php', 'http://www.php.net', 'The language that Joomla! is developed in', '2004-07-07 11:33:24', 8, 1, 0, '0000-00-00 00:00:00', 3, 0, 1, 1, '{}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 32, 0, 'MySQL', 'mysql', 'http://www.mysql.com', 'The database that Joomla! uses', '2004-07-07 10:18:31', 1, 1, 0, '0000-00-00 00:00:00', 5, 0, 1, 1, '{}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 32, 0, 'OpenSourceMatters', 'opensourcematters', 'http://www.opensourcematters.org', 'Home of OSM', '2005-02-14 15:19:02', 11, 1, 0, '0000-00-00 00:00:00', 2, 0, 1, 1, '{"target":0}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 32, 0, 'Joomla! - Forums', 'joomla-forums', 'http://forum.joomla.org', 'Joomla! Forums', '2005-02-14 15:19:02', 4, 1, 0, '0000-00-00 00:00:00', 4, 0, 1, 1, '{"target":0}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 32, 0, 'Ohloh Tracking of Joomla!', 'ohloh-tracking-of-joomla', 'http://www.ohloh.net/projects/20', 'Objective reports from Ohloh about Joomla''s development activity. Joomla! has some star developers with serious kudos.', '2007-07-19 09:28:31', 1, 1, 0, '0000-00-00 00:00:00', 6, 0, 1, 1, '{"target":0}', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, '', '', '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
