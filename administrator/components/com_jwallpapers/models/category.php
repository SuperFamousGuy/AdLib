<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: category.php 352 2010-06-01 09:47:46Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelCategory extends JModel {
	
	var $_id = null;
	var $_catChildsList = null;
	var $_category_resizes = null;
	var $_path = null;
	
	function __construct($id = null) {
		
		parent::__construct ();
		
		
		if (! $id) {
			$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
			$id = ( int ) $cid [0];
		}
		$this->_id = ( int ) $id;
	
	}
	
	function getCategoryChilds($id = null) {
		
		if ($id === null) { 
			

			if (! $this->_catChildsList) {
				$query = 'SELECT title, id FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $this->_id;
				
				$this->_catChildsList = $this->_getList ( $query );
			}
			
			return $this->_catChildsList;
		
		} else {
			
			$query = 'SELECT title, id FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $id;
			
			return $this->_getList ( $query );
		
		}
	
	}
	
	function getPath($id = null) {
		
		if ($id === null) { 
			

			if (! $this->_path) {
				
				$this->_db->Execute ( 'CALL getCatDownPath(' . ( int ) $this->_id . ',0)' );
				
				$query = 'SELECT * FROM catDownPath';
				
				$this->_path = $this->_getList ( $query );
			}
			
			return $this->_path;
		
		} else {
			
			$this->_db->Execute ( 'CALL getCatDownPath(' . ( int ) $id . ',0)' );
			
			$query = 'SELECT * FROM catDownPath';
			
			return $this->_getList ( $query );
		
		}
	
	}
	
	function takeCareOfOrphans($id = null) {
		
		if ($id === null) {
			$id = $this->_id;
		}
		
		
		$query = 'UPDATE #__jwallpapers_files AS files SET files.cat_id = 0  WHERE files.cat_id = ' . ( int ) $id;
		
		$this->_db->Execute ( $query );
		
		
		$query = 'UPDATE #__jwallpapers_categories AS categories SET categories.parent_id = 0  WHERE categories.parent_id = ' . ( int ) $id;
		
		$this->_db->Execute ( $query );
	
	}
	
	function &getCategoryResizes() {
		
		if (! $this->_category_resizes) {
			
			$query = 'SELECT * FROM #__jwallpapers_categories_resizes WHERE cat_id = ' . $this->_id;
			$this->_category_resizes = $this->_getList ( $query );
		
		}
		
		return $this->_category_resizes;
	
	}
	
	
	function deleteResizeList($cid) {
		
		$ids = implode ( ',', $cid );
		$ids_filtered = JWallpapersHelperSystem::filterIdList ( $ids );
		
		$query = 'DELETE FROM #__jwallpapers_categories_resizes WHERE cat_id IN (' . $ids_filtered . ')';
		$this->_db->Execute ( $query );
	
	}

}
?>