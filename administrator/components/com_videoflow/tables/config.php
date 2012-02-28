<?php

//VideoFlow - Joomla Multimedia System for Facebook//

/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2011 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableConfig extends JTable

{
  var $fid          = null;
  var $facebook     = null; 
  var $fbkey        = null;
  var $fbsecret     = null; 
  var $fkey         = null;
  var $mode         = null; 
  var $appname      = null; 
  var $canvasurl    = null; 
  var $ftemplate    = null; 
  var $jtemplate    = null; 
  var $dashboard    = null;
  var $appid        = null;
  var $fbcomments   = null;
  var $flowid       = null; 
  var $limit        = null; 
  var $menu         = null;
  var $jwforyoutube = null;
  var $skin         = null;
  var $titlelimit   = null; 
  var $commentlimit = null; 
  var $shorttitle   = null; 
  var $thumbwidth   = null;
  var $thumbheight  = null;
  var $mediadir     = null;
  var $downloads    = null;
  var $player       = null;
  var $playerwidth  = null;
  var $playerheight = null;
  var $lplayerwidth = null;
  var $lplayerheight = null;
  var $playall      = null;
  var $audio        = null;
  var $video        = null;
  var $photo        = null;
  var $vmode        = null; 
  var $prostatus    = null;
  var $showpro      = null;
  var $showadd      = null;
  var $showshare    = null; // For social bookmarking
  var $showemail    = null;
  var $showreport   = null; 
  var $version      = null;
  var $showcredit   = null; 
  var $message      = null;
  var $displayname  = null; 
  var $repunderscore = null;
  var $shortname    = null; 
  var $sidebarlimit = null;
  var $commentsys   = null;
  var $mootools12   = null;
  var $lightbox     = null;
  var $lightboxsys  = null;
  var $lightboxfull = null;
  var $findvmods    = null;
  var $ratings      = null;
  var $toolcolour   = null;
  var $showtabs     = null;
  var $candelete    = null; 
  var $useradd      = null; 
  var $userupload   = null; 
  var $columns      = null; 
  var $maxmedsize   = null; 
  var $maxthumbsize = null; 
  var $adminemail    = null; 
  var $uploadlog    = null; 
  var $useredit     = null; 
  var $profile_id   = null;   
  var $fbmenu       = null;
  var $fbvideo      = null; 
  var $fbaudio      = null; 
  var $fbphoto      = null; 
  var $fbhelpid     = null; 
  var $fbshare      = null; //depreciated
  var $showfull     = null; 
  var $help = null;
  var $helpid = null;
  var $ncatid = null; 
  var $autopubups = null;
  var $autopubadds = null;
  var $lboxh = null;
  var $lboxw = null;
  var $vdate = null;
  var $catplay = null;
  var $jshare = null; //depreciated
  var $upsys = null;
  var $fbcommentint = null;
  var $fbshowuser  = null;
  var $fbshowviews = null;
  var $fbshowplaylists = null;
  var $fbshowcategory = null;
  var $fbshowrating = null;
  var $fbshowdate = null;
  var $fbshowmylist = null;
  var $showuser = null;
  var $showcat = null;
  var $showviews = null;
  var $showrating = null;
  var $showdate = null;
  var $showplaylistcount = null;   
  var $ffmpegpath = null;
  var $autothumb = null;
  var $ffmpegthumbwidth = null;
  var $ffmpegthumbheight = null;
  var $ffmpegsec = null;
  var $wallposts = null;
  var $bwallposts = null;
  var $slist = null;
  var $slistlimit = null;
  var $showdownloads = null; 
  var $showvotes = null; 
  var $fshowdownloads = null;
  var $fshowvotes = null;
  var $likebutton = null;
  var $canvasheight = null; 

	function __construct( &$_db )
	{
		parent::__construct( '#__vflow_conf', 'fid', $_db );		
	}
}