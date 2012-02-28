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

function com_uninstall() {
$db = & JFactory::getDBO();
//write to plugins
$query = 'UPDATE #__vflow_addons SET status = 0';
$db->setQuery($query);
if (!$db->query()) {
JError::raiseError( 500, $db->stderr());
}
echo "VideoFlow successfully uninstalled."; 
}
?>