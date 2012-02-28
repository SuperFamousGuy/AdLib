<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: com_jwallpapers.plugin.php 126 2009-11-27 15:54:01Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Direct Access to this location is not allowed.' );

class jc_com_jwallpapers extends JCommentsPlugin {
	
	function getObjectTitle($id) {
		$db = & JCommentsFactory::getDBO ();
		$db->setQuery ( 'SELECT title FROM #__jwallpapers_files WHERE id=' . ( int ) $id );
		return $db->loadResult ();
	}
	
	function getObjectLink($id) {
		$_Itemid = JCommentsPlugin::getItemid ( 'com_jwallpapers' );
		$link = 'index.php?option=com_jwallpapers&view=picture&id=' . ( int ) $id . '&Itemid=' . ( int ) $_Itemid;
		return $link;
	}
}
?>