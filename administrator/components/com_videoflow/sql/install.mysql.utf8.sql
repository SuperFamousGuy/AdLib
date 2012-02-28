--
-- VideoFlow 1.1.x Database Tables
--

-- --------------------------------------------------------

--
-- VideoFlow 1.1.0 
--


CREATE TABLE IF NOT EXISTS `#__vflow_conf` (
  `fid` tinyint(4) NOT NULL auto_increment,
  `facebook` tinyint(1) NOT NULL default '1',
  `fbkey` tinytext,
  `fbsecret` tinytext,
  `fkey` mediumint(9) default NULL,
  `mode` varchar(50) default '',
  `vmode` tinyint(1) NOT NULL default '0',
  `appname` text,
  `canvasurl` text,
  `jtemplate` varchar(50) NOT NULL default 'default',
  `ftemplate` varchar(50) NOT NULL default 'default',
  `dashboard` tinyint(1) NOT NULL default '1',
  `appid` tinytext,
  `fbcomments` tinyint(1) NOT NULL default '1',
  `flowid` tinytext,
  `limit` smallint(6) NOT NULL default '10',
  `sidebarlimit` smallint(6) NOT NULL default '10',
  `titlelimit` mediumint(9) NOT NULL default '50',
  `commentlimit` mediumint(9) NOT NULL default '300',
  `shorttitle` int(11) NOT NULL default '15',
  `thumbwidth` smallint(6) NOT NULL default '120',
  `thumbheight` smallint(6) NOT NULL default '90',
  `mediadir` varchar(50) NOT NULL default 'videoflow',
  `commentsys` varchar(50) default NULL,
  `mootools12` tinyint(1) NOT NULL default '0',
  `lightbox` tinyint(1) NOT NULL default '1',
  `lightboxsys` varchar(50) default NULL,
  `lightboxfull` tinyint(1) NOT NULL default '0',
  `findvmods` tinyint(1) NOT NULL default '0',
  `ratings` tinyint(1) NOT NULL default '1',
  `showadd` tinyint(1) NOT NULL default '1',
  `showshare` tinyint(1) NOT NULL default '1',
  `showemail` tinyint(1) NOT NULL default '1',
  `showreport` tinyint(1) NOT NULL default '1',
  `downloads` tinyint(1) NOT NULL default '0',
  `showtabs` tinyint(1) NOT NULL default '1',
  `toolcolour` varchar(50) NOT NULL default 'grey',
  `player` varchar(50) NOT NULL default 'nonverblaster',
  `playerwidth` smallint(6) NOT NULL default '470',
  `playerheight` smallint(6) NOT NULL default '290',
  `lplayerwidth` smallint(6) NOT NULL default '640',
  `lplayerheight` smallint(6) NOT NULL default '360',
  `menu` text,
  `skin` text,
  `playall` tinyint(1) NOT NULL,
  `audio` tinyint(1) NOT NULL default '1',
  `photo` tinyint(1) NOT NULL default '1',
  `video` tinyint(1) NOT NULL default '1',
  `jwforyoutube` tinyint(1) NOT NULL default '1',
  `prostatus` tinyint(1) NOT NULL default '0',
  `showpro` tinyint(1) NOT NULL default '1',
  `version` text,
  `showcredit` tinyint(1) NOT NULL default '1',
  `message` tinyint(1) NOT NULL default '1',
  `displayname` tinyint(1) NOT NULL default '1',
  `shortname` tinyint(4) NOT NULL default '8',
  `candelete` tinyint(1) NOT NULL default '1',
  `useradd` tinyint(1) NOT NULL default '1',
  `userupload` tinyint(1) NOT NULL default '1',
  `columns` tinyint(4) NOT NULL default '4',
  `maxmedsize` smallint(6) NOT NULL default '50',
  `maxthumbsize` smallint(6) NOT NULL default '100',
  `adminemail` text,
  `uploadlog` tinyint(1) NOT NULL default '1',
  `useredit` tinyint(1) NOT NULL default '1',
  `profile_id` tinytext,
  `fbmenu` text,
  `fbvideo` tinyint(1) NOT NULL default '1',
  `fbaudio` tinyint(1) NOT NULL default '1',
  `fbphoto` tinyint(1) NOT NULL default '1',
  `help` tinyint(1) NOT NULL default '0',
  `helpid` tinytext,
  `fbhelpid` tinytext,
  `showfull` tinyint(1) NOT NULL default '1',
  `ncatid` text,
  `autopubups` tinyint(1) NOT NULL,
  `autopubadds` tinyint(1) NOT NULL,
  `vdate` date NOT NULL,
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


INSERT IGNORE INTO `#__vflow_conf` (`fid`, `facebook`, `fbkey`, `fbsecret`, `fkey`, `mode`, `vmode`, `appname`, `canvasurl`, `jtemplate`, `ftemplate`, `dashboard`, `appid`, `fbcomments`, `flowid`, `limit`, `sidebarlimit`, `titlelimit`, `commentlimit`, `shorttitle`, `thumbwidth`, `thumbheight`, `mediadir`, `commentsys`, `mootools12`, `lightbox`, `lightboxsys`, `lightboxfull`, `findvmods`, `ratings`, `showadd`, `showshare`, `showemail`, `showreport`, `downloads`, `showtabs`, `toolcolour`, `player`, `playerwidth`, `playerheight`, `lplayerwidth`, `lplayerheight`, `menu`, `skin`, `playall`, `audio`, `photo`, `video`, `jwforyoutube`, `prostatus`, `showpro`, `version`, `showcredit`, `message`, `displayname`, `shortname`, `candelete`, `useradd`, `userupload`, `columns`, `maxmedsize`, `maxthumbsize`, `adminemail`, `uploadlog`, `useredit`, `profile_id`, `fbmenu`, `fbvideo`, `fbaudio`, `fbphoto`, `help`, `helpid`, `fbhelpid`, `showfull`, `ncatid`, `autopubups`, `autopubadds`, `vdate`) VALUES
(1, 1, NULL, NULL, 0, 'videoflow', 0, '', 'http://apps.facebook.com/your_app/', 'listview', 'simple', 1, NULL, 1, '', 10, 10, 50, 300, 15, 120, 90, 'videoflow', 'jcomments', 0, 1, 'multibox', 0, 0, 1, 1, 1, 1, 1, 0, 1, 'grey', 'nonverblaster', 470, 290, 640, 360, 'latest|featured|popular|hirated|myvids|categories|search|upload|help', '', 1, 1, 1, 1, 0, 0, 1, '1.1.0', 1, 1, 1, 8, 1, 1, 1, 4, 50, 100, '', 1, 1, NULL, 'fblatest|fbfeatured|fbpopular|fbmyvids|fbcategories|fbsearch|fbnews|fbdiscuss|fbinvite|fbaddmedia|fbhelp', 1, 1, 1, 0, '', NULL, 1, '', 0, 1, '0000-00-00');


CREATE TABLE IF NOT EXISTS `#__vflow_data` (
  `id` int(11) NOT NULL auto_increment,
  `cat` int(11) default '0',
  `title` text,
  `details` text,
  `file` text,
  `medialink` text,
  `type` tinytext,
  `pixlink` text,
  `server` text,
  `views` int(11) NOT NULL default '0',
  `dateadded` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) default '1',
  `download` tinyint(1) NOT NULL default '1',
  `recommended` tinyint(1) default '0',
  `tags` text,
  `lastclick` datetime NOT NULL default '0000-00-00 00:00:00',
  `favoured` int(11) NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT (`title`,`details`, `tags`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__vflow_mymedia` (
  `id` int(11) NOT NULL auto_increment,
  `jid` int(11) default '0',
  `faceid` bigint(11) default '0',
  `mid` smallint(6) default NULL,
  `type` varchar(50) default NULL,
  `component` varchar(150) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__vflow_users` (
  `id` int(11) NOT NULL auto_increment,
  `joomla_id` int(11) default NULL,
  `fb_id` int(11) default NULL,
  `join_date` datetime NOT NULL,
  `visitors` int(11) NOT NULL default '0',
  `subscribers` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;



CREATE TABLE IF NOT EXISTS `#__vflow_plugins` (
  `pid` tinyint(4) NOT NULL auto_increment,
  `name` tinytext,
  `jname` text,
  `propername` varchar(50) default NULL,
  `type` text,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT IGNORE INTO `#__vflow_plugins` (`pid`, `name`, `jname`, `propername`, `type`) VALUES
(1, 'videoflow', 'com_videoflow', 'VideoFlow', 'CMS'),
(2, 'seyret', 'com_seyret', 'Seyret', 'CMS'),
(3, 'hwdvideoshare', 'com_hwdvideoshare', 'hwdVideoShare', 'CMS'),
(4, 'jcomments', 'com_jcomments', 'JComments', 'comments'),
(5, 'facebook', NULL, 'Facebook', 'comments'),
(6, 'JW', NULL, 'JW', 'player'),
(7, 'neolao', NULL, 'Neolao', 'player'),
(8, 'nonverblaster', NULL, 'NonverBlaster', 'player'),
(9, 'listview', NULL, 'ListView', 'jtemplate'),
(10, 'grid', NULL, 'GridView', 'jtemplate'),
(11, 'default', NULL, 'Default', 'ftemplate'),
(12, 'grey', NULL, 'Grey', 'toolcolour'),
(13, 'black', NULL, 'Black', 'toolcolour'),
(14, 'white', NULL, 'White', 'toolcolour'),
(15, 'multibox', NULL, 'MultiBox', 'lightbox'),
(16, 'joomlabox', NULL, 'Joomla', 'lightbox'),
(17, 'latest', NULL, 'Latest', 'jmenu'),
(18, 'featured', NULL, 'Featured', 'jmenu'),
(19, 'popular', NULL, 'Popular', 'jmenu'),
(20, 'hirated', NULL, 'Highly Rated', 'jmenu'),
(21, 'myvids', NULL, 'My Channel', 'jmenu'),
(22, 'categories', NULL, 'Categories', 'jmenu'),
(23, 'search', NULL, 'Search', 'jmenu'),
(24, 'help', NULL, 'Help', 'jmenu'),
(25, 'upload', NULL, 'Add Media', 'jmenu'),
(26, 'fblatest', NULL, 'Latest', 'fbmenu'),
(27, 'fbfeatured', NULL, 'Featured', 'fbmenu'),
(28, 'fbpopular', NULL, 'Popular', 'fbmenu'),
(29, 'fbmyvids', NULL, 'My Channel', 'fbmenu'),
(30, 'fbcategories', NULL, 'Categories', 'fbmenu'),
(31, 'fbsearch', NULL, 'Search', 'fbmenu'),
(32, 'fbnews', NULL, 'News', 'fbmenu'),
(33, 'fbdiscuss', NULL, 'Discuss', 'fbmenu'),
(34, 'fbinvite', NULL, 'Invite', 'fbmenu'),
(35, 'fbhelp', NULL, 'Help', 'fbmenu'),
(36, 'fbaddmedia', NULL, 'Add Media', 'fbmenu');

CREATE TABLE IF NOT EXISTS `#__vflow_mychannels` (
  `id` int(11) NOT NULL auto_increment,
  `jid` int(11) default '0',
  `faceid` bigint(11) default '0',
  `cid` smallint(6) NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;


CREATE TABLE IF NOT EXISTS `#__vflow_rating` (
  `media_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) NOT NULL default '0',
  `rating_count` int(11) NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `#__vflow_categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `desc` text,
  `pixlink` text,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `from` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- VideoFlow 1.1.2 
--

CREATE TABLE IF NOT EXISTS `#__vflow_addons` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `propername` varchar(50) default NULL,
  `type` varchar(50) default NULL,
  `desc` text,
  `platform` varchar(50) default NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `#__vflow_addons` (`id`, `name`, `propername`, `type`, `desc`, `platform`, `status`) VALUES
(1, 'grid', 'GridView', 'template', 'Displays media files in grid format', 'Joomla', 0),
(2, 'playerview', 'PlayerView', 'template', 'Displays media player layout', 'Joomla', 0);