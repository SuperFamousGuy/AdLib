<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_vote_cache.php 126 2009-11-27 15:54:01Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_Vote_Cache extends JTable {
	
	var $id = null;
	var $file_id = null;
	var $average = null;
	var $count = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_votes_cache', 'id', $db );
	}

}
?>