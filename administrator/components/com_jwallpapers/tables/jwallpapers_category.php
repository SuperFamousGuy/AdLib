<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_category.php 351 2010-06-01 09:32:08Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_Category extends JTable {
	
	var $id = null;
	var $parent_id = null;
	var $title = null;
	var $alias = null;
	var $keywords = null;
	var $description = null;
	var $file_id = null;
	var $frontend_uploads_en = null;
	var $published = null;
	var $hits = null;
	var $def_downloadable_front_pics_stat = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $item_deny_acl = null;
	var $votes_deny_acl = null;
	var $downloads_deny_acl = null;
	var $tagging_deny_acl = null;
	var $uploads_deny_acl = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_categories', 'id', $db );
	}
	
	function check() {
		jimport ( 'joomla.filter.output' );
		if (empty ( $this->alias )) {
			$this->alias = $this->title;
		}
		$this->alias = JFilterOutput::stringURLSafe ( $this->alias );
		
		
		return true;
	}
	
	
	function exists($id) {
		
		if ($id == 0) {
			return 1;
		}
		$db = & JFactory::getDBO ();
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE id = ' . ( int ) $id;
		$db->setQuery ( $query );
		$result = $db->loadResult ( $query );
		
		if ($result == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
	function validate() {
		
		
		

		$db = & JFactory::getDBO ();
		
		$changed = 0;
		if ($this->parent_id) {
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE id = ' . ( int ) $this->parent_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->parent_id = 0;
				$changed = 1;
			}
		}
		
		if ($changed) {
			$this->store ();
		}
	
	}

}
?>