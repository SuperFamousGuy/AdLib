<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_global_resize.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_Global_Resize extends JTable {
	
	var $id = null;
	var $width = null;
	var $height = null;
	var $size_formats = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_global_resizes', 'id', $db );
	}

}
?>