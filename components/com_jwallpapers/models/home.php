<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: home.php 350 2010-05-31 14:28:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelHome extends JModel {
	
	var $_bestRated = null;
	var $_newest = null;
	var $_categories = null;
	var $_pics = null;
	var $_totalPics = null;
	var $_pagination = null;
	var $_maxCatDepth = null;
	var $_descendants = null;
	var $_display_mode = null;
	var $_descendants_ids = null;
	var $_order = null;
	var $_user_aro_gid = null;
	
	function __construct() {
		
		
		global $option;
		
		parent::__construct ();
		
		
		

		
		
		
		
		
		
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
	
	function getMainCategories() {
		
		global $option;
		
		if (! $this->_categories) {
			
			
			
			$params = & JComponentHelper::getParams ( $option );
			
			if (! $params->get ( 'acl_show_restricted_category' )) {
				
				$filter_restricted_cats_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',item_deny_acl) ';
			} else {
				
				$filter_restricted_cats_cond = '';
			}
			
			$query = 'SELECT *, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END AS slug FROM #__jwallpapers_categories WHERE parent_id = 0 AND published = 1 ' . $filter_restricted_cats_cond . 'ORDER BY title';
			$this->_categories = $this->_getList ( $query );
		}
		return $this->_categories;
	}
	
	function getAllPics() {
		
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
				
				
				$filter_restricted_pics_cond_1 = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END)';
			
			} else {
				
				$filter_restricted_pics_cond_1 = '';
			}
			
			switch ($this->_display_mode) {
				default :
					$this->_display_mode = 0;
				case 0 :
					
					
					$query = 'SELECT t1.id AS id, tag_ep, t1.item_deny_acl, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, t1.title, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_categories AS t1 LEFT JOIN #__jwallpapers_files AS t2 ON t1.file_id = t2.id WHERE parent_id = 0 AND t1.published = 1 ' . $filter_restricted_cats_cond . $order_cats_by;
					break;
				case 1 :
					
					$this->genDescendantsTable ();
					
					
					$descendants_ids = $this->getDescendantsIds ();
					
					if ($descendants_ids) {
						$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE cat_id IN (' . $descendants_ids . ') AND t1.published = 1 ' . $filter_restricted_pics_cond_1 . $order_pics_by;
					} else {
						
						$this->_pics = array ();
						return $this->_pics;
					}
					
					break;
			}
			
			$this->_pics = $this->_getList ( $query, $limitstart, $limit );
		
		}
		return $this->_pics;
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
				
				
				$filter_restricted_pics_cond_1 = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			
			} else {
				
				$filter_restricted_pics_cond_1 = '';
			}
			
			switch ($this->_display_mode) {
				default :
					$this->_display_mode = 0;
				case 0 :
					
					
					$query = 'SELECT COUNT(*) FROM #__jwallpapers_categories WHERE parent_id = 0 AND published = 1' . $filter_restricted_cats_cond;
					$this->_db->setQuery ( $query );
					$count = $this->_db->loadResult ();
					
					
					
					
					
					
					

					
					
					

					break;
				case 1 :
					
					$this->genDescendantsTable ();
					
					
					$descendants_ids = $this->getDescendantsIds ();
					
					if ($descendants_ids) {
						$query = 'SELECT COUNT(*) AS count FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id IN (' . $descendants_ids . ') AND t1.published = 1' . $filter_restricted_pics_cond_1;
					} else {
						
						$this->_totalPics = 0;
						return $this->_totalPics;
					}
					
					$this->_db->setQuery ( $query );
					$count = $this->_db->loadResult ();
					
					break;
			}
			
			$this->_totalPics = $count;
		
		}
		return $this->_totalPics;
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
	
	
	
	function genDescendantsTable() {
		
		
		if (! $this->_descendants) {
			
			$this->_db->Execute ( 'CALL recursivesubtree(0,0)' );
			
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

}

?>