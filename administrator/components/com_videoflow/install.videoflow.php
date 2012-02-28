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


defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.file' );

function com_install() {
  $success = "VideoFlow installed successfully. Go to the Configuration Panel for set up.";
  $failure = "Failed to complete VideoFlow installation or upgrade process. Visit the forums at www.fidsoft.com for help.";
  $vf = versionCheck();
  if (empty($vf)) {
  echo '<font color="red">'.$failure.'</font>';
  return;
  }
  $status = versionUpdate($vf);
  if ($status) echo '<font color="green">'.$success.'</font>'; else echo '<font color="red">'.$failure.'</font>';
  return;
}
  
function flowDir() {
  global $mainframe;
   $vdir = JPATH_ROOT.DS.'videoflow'; 
   $file = $vdir.DS.'index.html'; 
   $success = createMediadir ($vdir, $file);
   if ($success){
   $dest = JPATH_ROOT.DS.'videoflow'.DS.'_thumbs';
   $file = $dest.DS.'index.html'; 
   createMediadir ($dest, $file);
   chmod ($dest, 0775);
   $dest  = JPATH_ROOT.DS.'videoflow'.DS.'videos'; 
   $file = $dest.DS.'index.html'; 
   createMediadir ($dest, $file);
   chmod ($dest, 0775);
   $dest  = JPATH_ROOT.DS.'videoflow'.DS.'audio'; 
   $file = $dest.DS.'index.html'; 
   createMediadir ($dest, $file);
   chmod ($dest, 0775);
   $dest = JPATH_ROOT.DS.'videoflow'.DS.'photos'; 
   $file = $dest.DS.'index.html'; 
   createMediadir ($dest, $file);
   chmod ($dest, 0775);
   chmod ($vdir, 0775);
   return true;
   } else {
   return false;
   }   
}

function createMediadir($destdir, $file, $source=null){
if (empty($source)) $source = JPATH_ROOT.DS.'components'.DS.'com_videoflow'.DS.'index.html';     
   if (!is_dir($destdir)){
   mkdir ($destdir, 0777);
   }
   if (is_dir($destdir)){
   $success = JFile::copy ($source, $file);
   chmod ($destdir, 0775);
   return $success; 
   } 
   return false;
  }

function versionCheck(){
  $db = & JFactory::getDBO();
  $query = "SELECT * FROM #__vflow_conf";
  $db->setQuery($query);
  $vf = $db->loadObject();
  if(!empty($vf->version)){
  return $vf; 
  } else {
  return false;
  }
}


function versionUpdate($vf) {
  $status = false;
  // v. 1.1.0 to 1.1.4
  if ($vf->version == '1.1.0') {
  
  // Create media directory if necessary
  $mdir = JPATH_ROOT.DS.'videoflow';  
  if ($vf->mediadir == 'videoflow' && !is_dir($mdir)){
  $status = flowDir();
  if (!$status) echo '<font color="blue">Failed to create "videoflow" directory and subdirectories in joomla root. You must create them manually.</font>';
  }
  // Upgrage to v. 1.1.3
  $status = toV111($vf);
  if ($status){
  $status = toV112($vf);
  }
  if ($status) {
  $status = toV113 ();
  }
  // Upgrade to v. 1.1.4
  if ($status) {
  $status = toV114 ();  
  }
  
  //v. 1.1.1 to 1.1.4
  } elseif($vf->version == '1.1.1'){
  $status = toV112($vf);
  if ($status) {
  $status = toV113();
  }
  if ($status) {
  $status = toV114 ();  
  }
  
  // v. 1.1.2 to 1.1.4
  } elseif ($vf->version == '1.1.2'){
  $status = toV113();
  if ($status) {
  $status = toV114 ();  
  }
  
  //v. 1.1.3 to 1.1.4
  } elseif ($vf->version == '1.1.3'){
  $status = toV114 ();  
  
  // v. 1.1.4 to 1.1.4
  } elseif ($vf->version == '1.1.4') {
  $status = toV114();  
  }
  return $status;
  }

function toV111($vf) {
  
  // Update configuration table - v. 1.1.1
  
  $db = & JFactory::getDBO();
  $vf = $db->getTableFields('#__vflow_conf');  
  if (!array_key_exists ('lboxh', $vf['#__vflow_conf'])) {
  $query = "ALTER TABLE #__vflow_conf ADD (
            lboxh smallint(6) default NULL,
            lboxw smallint(6) default NULL)";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
			}
  $query = "UPDATE #__vflow_conf SET lboxh = '20', lboxw = '8', version = '1.1.1' WHERE fid = '1'";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 }
  
  // Update categories table - v. 1.1.1
  $vf = $db->getTableFields('#__vflow_categories');
  if (!array_key_exists('date', $vf['#__vflow_categories'])) {
    $query = "ALTER TABLE #__vflow_categories ADD (
             date datetime NOT NULL default '0000-00-00 00:00:00'";
     if (!array_key_exists('pixlink', $vf['#__vflow_categories'])) {       
         $query .= ", pixlink text";
      }
  $query .= ")";
  }
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
			}
  }
  return true;
} 

function toV112($vf){
  //Update media directory
   $dest  = JPATH_ROOT.DS.$vf->mediadir.DS.'flash'; 
   $file = $dest.DS.'index.html'; 
   if (!createMediadir ($dest, $file)){
   echo '<font color="blue">Failed to create the subdirectory '.$dest.'. You should create it manually.</font>';
   }   
  $db = & JFactory::getDBO();
  
   // Update configuration table
  $vft = $db->getTableFields('#__vflow_conf');  
  if (!array_key_exists ('upsys', $vft['#__vflow_conf'])) {
  $query = "ALTER TABLE #__vflow_conf ADD (
            upsys varchar(150) default NULL,
            fbcommentint varchar(150) default NULL,
            repunderscore tinyint(1) default '1',
            catplay tinyint(1) default '1',
            jshare tinyint(1) default '1',
            fbshare tinyint(1) default '1',
            fbshowuser tinyint(1) default '1',
            fbshowviews tinyint(1) default '1',
            fbshowplaylists tinyint(1) default '1',
            fbshowcategory tinyint(1) default '1',
            fbshowrating tinyint(1) default '1',
            fbshowdate tinyint(1) default '1',
            fbshowmylist tinyint(1) default '1')";
  $db->setQuery($query);
  if (!$db->query()) {
      JError::raiseError( 500, $db->stderr());
			return false;
			}
  $query = "UPDATE #__vflow_conf SET upsys = 'plupload', fbcommentint = 'auto', version = '1.1.2' WHERE fid = '1'";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 }
  }
  // Update categories table - v. 1.1.1
  $vft = $db->getTableFields('#__vflow_data');
  if (!array_key_exists('downloads', $vft['#__vflow_data'])) {
    $query = "ALTER TABLE #__vflow_data ADD (
             downloads int(11) default '0')";
   
    $db->setQuery($query);
    if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
			}
   }
   
  $query = "INSERT IGNORE INTO #__vflow_plugins (pid, name, jname, propername, type) VALUES
  (NULL, 'playerview', NULL, 'PlayerView', 'jtemplate'),
  (NULL, 'alphabetic', NULL, 'Alphabetic', 'jmenu'),
  (NULL, 'jomcomment', 'com_jomcomment', 'Jom Comment', 'comments')";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 } 
   return true;
}

function toV113(){
  $db = &JFactory::getDBO();
  $query = 'SELECT joomla_id FROM #__vflow_users';
  $db -> setQuery ($query);    
  $res = $db->loadResultArray();
  if (is_array($res)) {
    foreach ($res as $c) {
      $query = 'SELECT COUNT(*) FROM #__vflow_mychannels WHERE cid='.(int) $c;
      $db->setQuery($query);
      $count = $db->loadResult();
      $query = 'UPDATE #__vflow_users SET subscribers = '.(int) $count.' WHERE joomla_id='.(int) $c;
      $db->setQuery($query);
      $db->query();
    }
  }  
  $query = 'SHOW INDEX FROM #__vflow_data WHERE Column_name = "title"';
  $db->setQuery($query);
  $ind = $db->loadAssoc();
  if ($ind['Index_type'] != 'FULLTEXT') {
  $query = 'ALTER TABLE #__vflow_data ADD FULLTEXT (title, details, tags)';
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 } 
  }  
  $query = "SELECT * FROM #__vflow_plugins WHERE name = 'default' AND type = 'jtemplate'";       
  $db->setQuery($query);      
  $res = $db->loadObject();  
  if (!empty($res)) {
  $query = "UPDATE #__vflow_plugins SET name = 'listview', propername = 'ListView' WHERE name = 'default' AND type = 'jtemplate'";
  $db->setQuery($query);
  $db->query();
  }
  $query = "SELECT * FROM #__vflow_plugins WHERE name = 'grid' AND type = 'jtemplate'";       
  $db->setQuery($query);      
  $res = $db->loadObject();  
  if (!empty($res)) {
  $query = "UPDATE #__vflow_plugins SET propername = 'GridView' WHERE name = 'grid' AND type = 'jtemplate'";
  $db->setQuery($query);
  $db->query();
  }
  $query = "SELECT jtemplate FROM #__vflow_conf WHERE fid = '1'";
  $db->setQuery($query);
  $jtemp = $db->loadResult();
  if ($jtemp == 'default') {
  $query = "UPDATE #__vflow_conf SET version = '1.1.3', jtemplate = 'listview' WHERE fid = '1'";
  } else {
  $query = "UPDATE #__vflow_conf SET version = '1.1.3' WHERE fid = '1'";
  }
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 } 
 return true;
}

function toV114(){
  $db = & JFactory::getDBO();
   // Update configuration table
  $vft = $db->getTableFields('#__vflow_conf');  
  if (!array_key_exists ('ffmpegpath', $vft['#__vflow_conf'])) { 
  $query = "ALTER TABLE #__vflow_conf ADD (
            showuser tinyint(1) default '1',
            showcat tinyint(1) default '1',
            showviews tinyint(1) default '1',
            showrating tinyint(1) default '1',
            showdate tinyint(1) default '1',
            likebutton tinyint(1) default '1',
            showplaylistcount tinyint(1) default '1',
            ffmpegpath varchar(150) default NULL,
            autothumb tinyint(1) default '1',
            ffmpegthumbwidth smallint(6) default '320',
            ffmpegthumbheight smallint(6) default '240',
            ffmpegsec smallint(6) default '10',
            wallposts tinyint(1) default '1',
            bwallposts tinyint(1) default '1',
            slist tinyint(1) default '1',
            showdownloads tinyint(1) default '1',
            showvotes tinyint(1) default '1',
            slistlimit smallint(6) default '5',
            fshowdownloads tinyint(1) default '1',
            fshowvotes tinyint(1) default '1',
            canvasheight smallint(6) default NULL)";
  $db->setQuery($query);
  if (!$db->query()) {
      JError::raiseError( 500, $db->stderr());
			return false;
			}
  
  $query = "UPDATE #__vflow_conf SET ftemplate = 'simple', version = '1.1.4' WHERE fid = '1'";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 }
   
  $query = "INSERT IGNORE INTO #__vflow_plugins (pid, name, jname, propername, type) VALUES
  (NULL, 'simple', NULL, 'SimpleView', 'jtemplate'),
  (NULL, 'simple', NULL, 'SimpleView', 'ftemplate')";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
		 }
  
  $query = "DELETE FROM #__vflow_plugins WHERE name='dialog'";
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
			return false;
  }
  } 
  if (version_compare(JVERSION, '1.6.0', 'ge')) {               
  //swap language files 
  $file = JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.com_videoflow.ini'; 
  $source = JPATH_ROOT.DS.'components'.DS.'com_videoflow'.DS.'language_j16'.DS.'en-GB.com_videoflow.ini'; 
  $success1 = JFile::copy($source, $file);
  $file = JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.com_videoflow.ini'; 
  $source = JPATH_ROOT.DS.'components'.DS.'com_videoflow'.DS.'language_j16'.DS.'admin'.DS.'en-GB.com_videoflow.ini'; 
  $success2 = JFile::copy($source, $file);
  if (!$success1 || !$success2) JError::raiseError( 500, 'Unable to copy J!1.6 language files. Please copy them manually from com_videoflow/language_j16');
  } else {
  
  // Fix menus
  $menu = array('COM_VIDEOFLOW_CONFIGURE_MENU'=>'Configure', 'COM_VIDEOFLOW_MEDIA_MENU'=>'Media', 'COM_VIDEOFLOW_UPGRADE_MENU'=>'Upgrade');
  foreach ($menu as $key=>$val) {
  $query = "UPDATE #__components SET name = '".$val."', admin_menu_alt = '".$val."' WHERE name = '".$key."' AND `option` = 'com_videoflow'"; 
  $db->setQuery($query);
  if (!$db->query()) {
			JError::raiseError( 500, $db->stderr());
                        return false;
		 }
  }
  } 
   return true;
}