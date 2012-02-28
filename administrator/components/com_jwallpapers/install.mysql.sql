-- v1.0 stable

CREATE TABLE IF NOT EXISTS `#__jwallpapers_allowed_resolutions` (
  `id` int(11) NOT NULL auto_increment,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx-published-parent_id` (`published`,`parent_id`),
  KEY `idx-parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_files` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text,
  `upload_date` datetime NOT NULL,
  `is_owner` tinyint(1) NOT NULL,
  `published` tinyint(4) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  `file_name` varchar(32) NOT NULL,
  `file_ext` varchar(3) NOT NULL,
  `size_format` tinyint(1) NOT NULL,
  `owner` varchar(32) default NULL,
  `is_locked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx-published-cat_id` (`published`,`cat_id`),
  KEY `idx-cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_resizes` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx-parent_id-width-height` (`parent_id`,`width`,`height`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_resizes_params` (
  `id` int(11) NOT NULL auto_increment,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `size_formats` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_resizes_queue` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL,
  `file_name` varchar(32) NOT NULL,
  `file_ext` varchar(3) NOT NULL,
  `upload_date` datetime NOT NULL,
  `size_format` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_votes` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx-file_id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_votes_cache` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL,
  `average` decimal(3,2) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx-file_id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- v1.1RC1

CREATE TABLE IF NOT EXISTS `#__jwallpapers_settings_backup` (
  `param` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- v1.3

CREATE TABLE IF NOT EXISTS `#__jwallpapers_votes_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `vote_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-user_id-file_id` (`user_id`,`file_id`),
  KEY `idx-ip-file_id` (`ip`,`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- v2.0

CREATE TABLE IF NOT EXISTS `#__jwallpapers_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx-published` (`published`),
  KEY `idx-title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_tagged_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `idx-tag_id` (`tag_id`),
  KEY `idx-file_id` (`file_id`),
  KEY `idx-published` (`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_categories_resizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `size_formats` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__jwallpapers_files_resizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-file_id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
