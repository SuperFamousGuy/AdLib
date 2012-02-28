<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_file_resize.php 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_File_Resize extends JTable {
	
	var $id = null;
	var $width = null;
	var $height = null;
	var $file_id = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_files_resizes', 'id', $db );
	}

}
?>