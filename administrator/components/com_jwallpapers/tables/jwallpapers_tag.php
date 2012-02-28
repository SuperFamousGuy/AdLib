<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers_tag.php 292 2010-04-22 17:06:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class TableJWallpapers_Tag extends JTable {
	
	var $id = null;
	var $title = null;
	var $alias = null;
	var $user_id = null;
	var $date = null;
	var $hits = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;
	
	function __construct(&$db) {
		parent::__construct ( '#__jwallpapers_tags', 'id', $db );
	}
	
	
	function exists($id) {
		
		$db = & JFactory::getDBO ();
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_tags WHERE id = ' . ( int ) $id;
		$db->setQuery ( $query );
		$result = $db->loadResult ( $query );
		
		if ($result == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
	function getIdFromTitle(&$id, $title) {
		
		$db = & JFactory::getDBO ();
		
		$title = strtolower ( $title );
		
		$query = 'SELECT id FROM #__jwallpapers_tags WHERE title = \'' . $db->getEscaped ( $title ) . '\'';
		$db->setQuery ( $query );
		$id = $db->loadResult ();
		
		if (! empty ( $id )) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function check() {
		jimport ( 'joomla.filter.output' );
		if (empty ( $this->alias )) {
			$this->alias = $this->title;
		}
		$this->alias = JFilterOutput::stringURLSafe ( $this->alias );
		
		
		return true;
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
		
		if ($changed) {
			$this->store ();
		}
	
	}

}
?>