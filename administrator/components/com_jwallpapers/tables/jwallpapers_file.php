<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_file.php 303 2010-04-27 15:53:14Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_File extends JTable {
	
	var $id = null;
	var $user_id = null;
	var $title = null;
	var $alias = null;
	var $keywords = null;
	var $description = null;
	var $upload_date = null;
	var $is_owner = null;
	var $published = null;
	var $hits = null;
	var $cat_id = null;
	var $width = null;
	var $height = null;
	var $file_name = null;
	var $file_ext = null;
	var $size_format = null;
	var $owner = null;
	var $tag_ep = null;
	var $tag_ep_date = null;
	var $votes_en = null;
	var $downloadable = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $item_deny_acl = null;
	var $votes_deny_acl = null;
	var $downloads_deny_acl = null;
	var $tagging_deny_acl = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_files', 'id', $db );
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
		$db = & JFactory::getDBO ();
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_files WHERE id = ' . ( int ) $id;
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
		if ($this->user_id) {
			
			$query = 'SELECT COUNT(*) FROM #__users WHERE id = ' . ( int ) $this->user_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->user_id = 0;
				$changed = 1;
			}
		}
		
		if ($this->cat_id) {
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE id = ' . ( int ) $this->cat_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->cat_id = 0;
				$changed = 1;
			}
		}
		
		if ($changed) {
			$this->store ();
		}
	
	}

}
?>