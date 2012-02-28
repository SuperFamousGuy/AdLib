<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_tagged_file.php 292 2010-04-22 17:06:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_Tagged_File extends JTable {
	
	var $id = null;
	var $file_id = null;
	var $tag_id = null;
	var $user_id = null;
	var $date = null;
	var $published = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_tagged_files', 'id', $db );
	}
	
	
	function exists($id) {
		
		$db = & JFactory::getDBO ();
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_tagged_files WHERE id = ' . ( int ) $id;
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
		
		$deleted = 0;
		
		if ($this->user_id) {
			
			$query = 'SELECT COUNT(*) FROM #__users WHERE id = ' . ( int ) $this->user_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->user_id = 0;
				$changed = 1;
			}
		}
		
		if ($this->file_id) {
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_files WHERE id = ' . ( int ) $this->file_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->delete ();
				$deleted = 1;
			}
		} else {
			
			$this->delete ();
			$deleted = 1;
		}
		
		if ($this->tag_id) {
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_tags WHERE id = ' . ( int ) $this->tag_id;
			$db->setQuery ( $query );
			$result = $db->loadResult ();
			if (empty ( $result )) {
				
				$this->delete ();
				$deleted = 1;
			}
		} else {
			
			$this->delete ();
			$deleted = 1;
		}
		
		if ($changed && ! $deleted) {
			$this->store ();
		}
		
		if ($deleted) {
			return 0;
		} else {
			return 1;
		}
	
	}

}
?>