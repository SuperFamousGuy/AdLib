<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: picture.php 352 2010-06-01 09:47:46Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelPicture extends JModel {
	
	var $_id = null;
	var $_pic_tags = null;
	var $_file_resizes = null;
	
	function __construct($id = null) {
		
		parent::__construct ();
		
		
		if (! $id) {
			$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
			$id = $cid [0];
		}
		$this->_id = $id;
	}
	
	function &getFileResizes() {
		
		if (! $this->_file_resizes) {
			
			$query = 'SELECT * FROM #__jwallpapers_files_resizes WHERE file_id = ' . $this->_id;
			$this->_file_resizes = $this->_getList ( $query );
		
		}
		
		return $this->_file_resizes;
	
	}
	
	function dropVotes($id = null) {
		
		if ($id == null) {
			$id = $this->_id;
		}
		
		$query = 'DELETE FROM #__jwallpapers_votes WHERE file_id = ' . ( int ) $id;
		
		$this->_db->Execute ( $query );
		
		$query = 'DELETE FROM #__jwallpapers_votes_cache WHERE file_id = ' . ( int ) $id;
		
		$this->_db->Execute ( $query );
	
	}
	
	function dropComments($id = null) {
		
		global $option;
		
		if ($id == null) {
			$id = $this->_id;
		}
		
		$query = 'DELETE FROM #__jcomments WHERE object_group = ' . $this->_db->Quote ( $option ) . ' AND object_id = ' . ( int ) $id;
		
		$this->_db->Execute ( $query );
	
	}
	
	
	function &getPicTags() {
		
		if (! $this->_pic_tags) {
			
			$query = 'SELECT t1.id AS id, title FROM #__jwallpapers_tagged_files AS t1 INNER JOIN #__jwallpapers_tags AS t2 ON t1.tag_id = t2.id WHERE file_id = ' . ( int ) $this->_id . ' ORDER BY title';
			$this->_pic_tags = $this->_getList ( $query );
		
		}
		
		return $this->_pic_tags;
	
	}
}

?>