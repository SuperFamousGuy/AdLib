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

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelCategory extends JModel {
	
	var $_id = null;
	var $_subCategories = null;
	var $_pics = null;
	var $_catName = null;
	var $_path = null;
	var $_pagination = null;
	var $_totalPics = null;
	var $_maxCatDepth = null;
	var $_catChildList = null;
	var $_descendants = null;
	var $_display_mode = null;
	var $_descendants_ids = null;
	var $_order = null;
	var $_user_aro_gid = null;
	var $_total_subcats;
	
	function __construct($id = null) {
		
		
		global $option;
		
		parent::__construct ();
		
		
		if (! $id) {
			
			$id = JRequest::getInt ( 'id', 0 );
			
		}
		
		$this->_id = $id;
		
		
		

		
		
		
		
		
		
		$params = & JComponentHelper::getParams ( $option );
		$thumb_columns = $params->get ( 'thumbs_columns' );
		$thumb_lines = $params->get ( 'thumbs_lines' );
		$limit = $thumb_columns * $thumb_lines; 
		

		
		$limitstart = JRequest::getVar ( 'limitstart', 0 );
		
		$this->setState ( 'limit', $limit );
		$this->setState ( 'limitstart', $limitstart );
		
		
		$this->_display_mode = $params->get ( 'display_mode' );
		
		if ($this->_display_mode == 1) {
			
			

			
			$this->_maxCatDepth = $params->get ( 'maxCatDepth' );
			
			
			$this->_db->Execute ( 'SET @@SESSION.max_sp_recursion_depth=' . ( int ) $this->_maxCatDepth );
		}
		
		
		
		$default_order_thumbs_by = $params->get ( 'default_order_thumbs_by', 'id' );
		
		$this->_order = JRequest::getVar ( 'order', $default_order_thumbs_by );
		
		
		$this->_user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
	
	}
	
	function getTotalPics() {
		
		global $option;
		
		if (! $this->_totalPics) {
			
			
			
			$params = & JComponentHelper::getParams ( $option );
			
			if (! $params->get ( 'acl_show_restricted_category' )) {
				
				$filter_restricted_cats_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl)';
			} else {
				
				$filter_restricted_cats_cond = '';
			}
			
			if (! $params->get ( 'acl_show_restricted_picture' )) {
				
				
				$filter_restricted_pics_cond_0 = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl)';
				
				$filter_restricted_pics_cond_1 = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			} else {
				
				$filter_restricted_pics_cond_0 = '';
				$filter_restricted_pics_cond_1 = '';
			}
			
			switch ($this->_display_mode) {
				default :
					$this->_display_mode = 0;
				case 0 :
					
					
					$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $this->_id . ' AND published = 1' . $filter_restricted_cats_cond;
					$this->_db->setQuery ( $query );
					$subCatCount = $this->_db->loadResult ();
					
					
					$query = 'SELECT COUNT(*) FROM #__jwallpapers_files WHERE cat_id = ' . ( int ) $this->_id . ' AND published = 1' . $filter_restricted_pics_cond_0;
					$this->_db->setQuery ( $query );
					$picsCount = $this->_db->loadResult ();
					
					
					$count = $subCatCount + $picsCount;
					
					break;
				case 1 :
					
					$this->genDescendantsTable ();
					
					
					$descendants_ids = $this->getDescendantsIds ();
					
					if ($descendants_ids) {
						$ids = ( int ) $this->_id . ',' . $descendants_ids;
					} else {
						$ids = ( int ) $this->_id;
					}
					
					$query = 'SELECT COUNT(*) AS count FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t2.id = t1.cat_id WHERE cat_id IN (' . $ids . ') AND t1.published = 1' . $filter_restricted_pics_cond_1;
					
					$this->_db->setQuery ( $query );
					$count = $this->_db->loadResult ();
					
					break;
			}
			
			$this->_totalPics = $count;
		
		}
		return $this->_totalPics;
	}
	
	function getPics() {
		
		global $option;
		
		if (! $this->_pics) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			
			switch ($this->_order) {
				default :
					$this->_order = 'id';
				case 'id' :
					$order_pics_by = 'ORDER BY t1.id';
					$order_cats_by = 'ORDER BY id';
					break;
				case 'title' :
					$order_pics_by = 'ORDER BY t1.title';
					$order_cats_by = 'ORDER BY title';
					break;
				case 'date_asc' :
					$order_pics_by = 'ORDER BY upload_date ASC';
					
					
					$order_cats_by = 'ORDER BY id ASC';
					break;
				case 'date_desc' :
					$order_pics_by = 'ORDER BY upload_date DESC';
					$order_cats_by = 'ORDER BY id DESC';
					break;
				case 'rating_asc' :
					$order_pics_by = 'ORDER BY rating ASC';
					
					
					$order_cats_by = 'ORDER BY title';
					break;
				case 'rating_desc' :
					$order_pics_by = 'ORDER BY rating DESC';
					$order_cats_by = 'ORDER BY title';
					break;
				case 'hits_asc' :
					$order_pics_by = 'ORDER BY t1.hits ASC';
					$order_cats_by = 'ORDER BY title';
					break;
				case 'hits_desc' :
					$order_pics_by = 'ORDER BY t1.hits DESC';
					$order_cats_by = 'ORDER BY title';
					break;
			}
			
			
			
			$params = & JComponentHelper::getParams ( $option );
			
			if (! $params->get ( 'acl_show_restricted_category' )) {
				
				$filter_restricted_cats_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',t1.item_deny_acl) ';
			} else {
				
				$filter_restricted_cats_cond = '';
			}
			
			if (! $params->get ( 'acl_show_restricted_picture' )) {
				
				
				$filter_restricted_pics_cond_0 = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl) ';
				
				$filter_restricted_pics_cond_1 = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END)';
			
			} else {
				
				$filter_restricted_pics_cond_0 = '';
				$filter_restricted_pics_cond_1 = '';
			}
			
			switch ($this->_display_mode) {
				default :
					$this->_display_mode = 0;
				case 0 :
					
					
					$query = 'SELECT t1.id AS id, t1.item_deny_acl, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, t1.title AS title, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_categories AS t1 LEFT JOIN #__jwallpapers_files AS t2 ON t1.file_id = t2.id WHERE parent_id = ' . ( int ) $this->_id . ' AND t1.published = 1 ' . $filter_restricted_cats_cond . $order_cats_by;
					
					$subCats = $this->_getList ( $query, $limitstart, $limit );
					
					$query = 'SELECT tag_ep, item_deny_acl, t1.id, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id WHERE cat_id = ' . ( int ) $this->_id . ' AND t1.published = 1 ' . $filter_restricted_pics_cond_0 . $order_pics_by;
					
					
					$total_subCats = $this->getTotalSubCats ();
					
					
					$picStart = ($total_subCats > $limitstart) ? 0 : $limitstart - $total_subCats;
					
					
					$picLimit = $limit - count ( $subCats );
					if ($picLimit) {
						$pics = $this->_getList ( $query, $picStart, $picLimit );
					} else {
						$pics = array ();
					}
					
					
					$this->_pics = array ('cats' => $subCats, 'pics' => $pics );
					
					break;
				case 1 :
					
					$this->genDescendantsTable ();
					
					
					$descendants_ids = $this->getDescendantsIds ();
					
					if ($descendants_ids) {
						$ids = ( int ) $this->_id . ',' . $descendants_ids;
					} else {
						$ids = ( int ) $this->_id;
					}
					
					$query = 'SELECT t1.id, tag_ep, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t3.id = t1.cat_id WHERE cat_id IN (' . $ids . ') AND t1.published = 1 ' . $filter_restricted_pics_cond_1 . $order_pics_by;
					
					$this->_pics = $this->_getList ( $query, $limitstart, $limit );
					
					break;
			}
		
		}
		return $this->_pics;
	}
	
	
	
	function genDescendantsTable() {
		
		
		if (! $this->_descendants) {
			
			$this->_db->Execute ( 'CALL recursivesubtree(' . $this->_id . ',0)' );
			
			$this->_descendants = 1;
		
		}
	
	}
	
	
	function getDescendantsIds() {
		
		
		
		
		

		if (! $this->_descendants_ids) {
			
			$query = 'SELECT GROUP_CONCAT(id) FROM descendants';
			$this->_db->setQuery ( $query );
			$this->_descendants_ids = $this->_db->loadResult ();
		
		}
		
		return $this->_descendants_ids;
	
	}
	
	function getSubCategories() {
		
		global $option;
		
		if (! $this->_subCategories) {
			
			
			
			$params = & JComponentHelper::getParams ( $option );
			
			if (! $params->get ( 'acl_show_restricted_category' )) {
				
				$filter_restricted_cats_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl) ';
			} else {
				
				$filter_restricted_cats_cond = '';
			}
			
			$query = 'SELECT *, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END AS slug FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $this->_id . ' AND published = 1 ' . $filter_restricted_cats_cond . 'ORDER BY title';
			$this->_subCategories = $this->_getList ( $query );
		}
		return $this->_subCategories;
	}
	
	function getTotalSubCats() {
		
		global $option;
		
		if (! $this->_total_subcats) {
			
			$params = & JComponentHelper::getParams ( $option );
			
			if (! $params->get ( 'acl_show_restricted_category' )) {
				
				$filter_restricted_cats_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl) ';
			} else {
				
				$filter_restricted_cats_cond = '';
			}
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE parent_id = ' . $this->_id . $filter_restricted_cats_cond;
			$this->_db->setQuery ( $query );
			$this->_total_subcats = $this->_db->loadResult ();
		}
		
		return $this->_total_subcats;
	
	}
	
	function getCategoryChilds($mode = 'show', $id = null) {
		
		
		if ($mode == 'hide') {
			$filter_uploads_deny_cats_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',uploads_deny_acl) AND frontend_uploads_en = 1';
		} else {
			$filter_uploads_deny_cats_cond = '';
		}
		
		if ($id == null) { 
			

			if (! $this->_catChildList) {
				$query = 'SELECT title, id FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $this->_id . ' AND published = 1' . $filter_uploads_deny_cats_cond;
				
				$this->_catChildList = $this->_getList ( $query );
			}
			
			return $this->_catChildList;
		
		} else {
			
			$query = 'SELECT title, id, frontend_uploads_en FROM #__jwallpapers_categories WHERE parent_id = ' . ( int ) $id . ' AND published = 1' . $filter_uploads_deny_cats_cond;
			
			return $this->_getList ( $query );
		
		}
	
	}
	
	
	
	function getPath($id = null, $stop_id = 0) {
		if ($id == null) { 
			if (! $this->_path) {
				
				$this->_db->Execute ( 'CALL getCatDownPath(' . ( int ) $this->_id . ',0)' );
				
				$query = 'SELECT *, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug FROM  #__jwallpapers_categories AS t1 INNER JOIN catDownPath AS t2 USING (id) ORDER BY pos DESC';
				
				$this->_path = $this->_getList ( $query );
				
			}
			return $this->_path;
		} else { 
			

			$this->_db->Execute ( 'CALL getCatDownPath(' . ( int ) $id . ',' . ( int ) $stop_id . ')' );
			
			$query = 'SELECT *, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug FROM  #__jwallpapers_categories AS t1 INNER JOIN catDownPath AS t2 USING (id) ORDER BY pos DESC';
			
			return $this->_getList ( $query );
			
		

		}
	}
	
	function getPagination() {
		if (! $this->_pagination) {
			
			jimport ( 'joomla.html.pagination' );
			
			
			$total = $this->getTotalPics ();
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			
			$this->_pagination = new JPagination ( $total, $limitstart, $limit );
		}
		return $this->_pagination;
	}
	
	function hit() {
		
		if ($this->_id) {
			$query = 'UPDATE #__jwallpapers_categories SET hits = hits + 1 WHERE id = ' . $this->_id;
			$this->_db->Execute ( $query );
			return true;
		}
		return false;
	}

}

?>