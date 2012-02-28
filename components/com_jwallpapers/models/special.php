<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: special.php 350 2010-05-31 14:28:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelSpecial extends JModel {
	
	var $_bestRated = null;
	var $_newest = null;
	var $_mostViewed = null;
	var $_totalPics = null;
	var $_pagination = null;
	var $_ids = null;
	var $_order = null;
	var $_orderedCatsPics = null;
	var $_params = null;
	var $_editorPicks = null;
	var $_special_view_id = null;
	var $_user_aro_gid = null;
	
	function __construct() {
		
		
		global $option;
		
		parent::__construct ();
		
		
		

		
		
		
		
		
		
		$this->_params = & JComponentHelper::getParams ( $option );
		$thumb_columns = $this->_params->get ( 'thumbs_columns' );
		$thumb_lines = $this->_params->get ( 'thumbs_lines' );
		$limit = $thumb_columns * $thumb_lines; 
		

		
		$this->_special_view_id = JRequest::getInt ( 'id' );
		
		
		$this->_getIds ();
		
		
		
		$limitstart = JRequest::getInt ( 'limitstart', 0 );
		
		$this->setState ( 'limit', $limit );
		$this->setState ( 'limitstart', $limitstart );
		
		
		
		$default_order_thumbs_by = $this->_params->get ( 'default_order_thumbs_by', 'id' );
		
		$this->_order = JRequest::getVar ( 'order', $default_order_thumbs_by );
		
		
		$this->_user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
	
	}
	
	
	function _getIds() {
		
		global $mainframe;
		
		
		if ($this->_special_view_id == 3) {
			$contest_id = $this->_params->get ( 'contest_id' );
			if (! empty ( $contest_id )) {
				
				
				

				$mod_row = & JTable::getInstance ( 'Module', 'JTable' );
				
				if (! $mod_row->load ( ( int ) $contest_id )) {
					
					$msg = JText::_ ( 'CONTEST_NOT_LONGER_EXISTS' );
					$mainframe->redirect ( JRoute::_ ( 'index.php?option=com_content&view=frontpage', false ), $msg, 'error' );
					return;
				}
				
				$mod_params = JWallpapersHelperSystem::getParamsFromRow ( $mod_row );
				
				$ids = $mod_params->get ( 'cat_ids' );
			}
		}
		
		
		$special_cat_ids = $this->_params->get ( 'special_cat_ids', 0 );
		
		
		if (! isset ( $ids )) {
			
			$ids = $special_cat_ids;
		}
		
		$this->_ids = JWallpapersHelperSystem::filterIdList ( $ids );
	
	}
	
	function getBestRated() {
		
		if (! $this->_bestRated) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END) ';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			if ($this->_ids) {
				
				$where_cond = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$where_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE ' . $where_cond . 't3.published = 1 AND t1.published = 1 ' . $filter_restricted_pics_cond . 'ORDER BY average DESC';
			$this->_bestRated = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_bestRated;
	
	}
	
	function getMostViewed() {
		
		if (! $this->_mostViewed) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END) ';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			if ($this->_ids) {
				
				$where_cond = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$where_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE ' . $where_cond . 't3.published = 1 AND t1.published = 1 ' . $filter_restricted_pics_cond . 'ORDER BY t1.hits DESC';
			$this->_mostViewed = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_mostViewed;
	
	}
	
	function getNewest() {
		if (! $this->_newest) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = 'AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END) ';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			if ($this->_ids) {
				
				$where_cond = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$where_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE ' . $where_cond . 't3.published = 1 AND t1.published = 1 ' . $filter_restricted_pics_cond . 'ORDER BY upload_date DESC';
			$this->_newest = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_newest;
	
	}
	
	function getTotalPics() {
		if (! $this->_totalPics) {
			
			
			if ($this->_ids) {
				
				$sub_query = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$sub_query = '';
			}
			
			if ($this->_special_view_id == 5) {
				
				$editors_picks_cond = 'AND tag_ep = 1 ';
			} else {
				$editors_picks_cond = '';
			}
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			
			$query = 'SELECT COUNT(*) AS count FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE ' . $sub_query . 't2.published = 1 ' . $editors_picks_cond . 'AND t1.published = 1' . $filter_restricted_pics_cond;
			$this->_totalPics = $this->_getList ( $query );
			$this->_totalPics = $this->_totalPics [0]->count;
		}
		return $this->_totalPics;
	}
	
	
	
	function getOrderedCatsPics() {
		
		global $mainframe;
		
		if (! $this->_orderedCatsPics) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			
			switch ($this->_order) {
				default :
					$this->_order = 'id';
				case 'id' :
					$order_by = 'ORDER BY t1.id';
					break;
				case 'title' :
					$order_by = 'ORDER BY t1.title';
					break;
				case 'date_asc' :
					$order_by = 'ORDER BY upload_date ASC';
					break;
				case 'date_desc' :
					$order_by = 'ORDER BY upload_date DESC';
					break;
				case 'rating_asc' :
					$order_by = 'ORDER BY rating ASC';
					break;
				case 'rating_desc' :
					$order_by = 'ORDER BY rating DESC';
					break;
				case 'hits_asc' :
					$order_by = 'ORDER BY t1.hits ASC';
					break;
				case 'hits_desc' :
					$order_by = 'ORDER BY t1.hits DESC';
					break;
			}
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END) ';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			if ($this->_ids) {
				
				$where_cond = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$where_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE ' . $where_cond . 't3.published = 1 AND t1.published = 1 ' . $filter_restricted_pics_cond . $order_by;
			$this->_orderedCatsPics = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_orderedCatsPics;
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
	
	
	function getEditorsPicks() {
		
		global $mainframe;
		
		if (! $this->_editorPicks) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			
			switch ($this->_order) {
				default :
					$this->_order = 'id';
				case 'id' :
					$order_by = 'ORDER BY id';
					break;
				case 'title' :
					$order_by = 'ORDER BY title';
					break;
				case 'date_asc' :
					$order_by = 'ORDER BY upload_date ASC';
					break;
				case 'date_desc' :
					$order_by = 'ORDER BY upload_date DESC';
					break;
				case 'rating_asc' :
					$order_by = 'ORDER BY rating ASC';
					break;
				case 'rating_desc' :
					$order_by = 'ORDER BY rating DESC';
					break;
				case 'hits_asc' :
					$order_by = 'ORDER BY t1.hits ASC';
					break;
				case 'hits_desc' :
					$order_by = 'ORDER BY t1.hits DESC';
					break;
			}
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END) ';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			if ($this->_ids) {
				
				$where_cond = 'cat_id IN (' . $this->_ids . ') AND ';
			} else {
				
				$where_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE ' . $where_cond . 't3.published = 1 AND t1.published = 1 AND t1.tag_ep = 1 ' . $filter_restricted_pics_cond . $order_by;
			$this->_editorPicks = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_editorPicks;
	}

}

?>