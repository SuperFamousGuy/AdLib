<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: categories.php 355 2010-06-01 12:35:00Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelCategories extends JModel {
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	var $_search = null;
	var $_query = null;
	var $_catList = null;
	
	function &getData() {
		$pagination = & $this->getPagination ();
		
		if (empty ( $this->_data )) {
			$query = $this->buildQuery ();
			
			
			$this->_data = $this->_getList ( $query, $pagination->limitstart, $pagination->limit );
		}
		
		return $this->_data;
	}
	
	function buildQuery() {
		return 'SELECT *, parent_id AS parent, title AS name FROM #__jwallpapers_categories' . $this->_buildQueryWhere () . $this->_buildQueryOrderBy ();
	}
	
	function _buildQueryWhere() {
		global $option, $mainframe;
		
		
		$filter_state = $mainframe->getUserStateFromRequest ( $option . 'filter_state', 'filter_state' );
		$filter_search = trim ( $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' ) );
		
		
		$where = array ();
		
		
		if ($filter_state == 'P') {
			$where [] = 'published = 1';
		} elseif ($filter_state == 'U') {
			$where [] = 'published = 0';
		}
		
		$filter_by_state_cats = $mainframe->getUserStateFromRequest ( $option . 'filter_by_state_cats', 'filter_by_state_cats' );
		switch ($filter_by_state_cats) {
			case 'FRONT_UPLOADS_EN' :
				$where [] = 'frontend_uploads_en = 1';
				break;
			case 'FRONT_UPLOADS_DIS' :
				$where [] = 'frontend_uploads_en = 0';
				break;
			case 'DEF_DOWNLOADABLE_FRONT_PICS_YES' :
				$where [] = 'def_downloadable_front_pics_stat = 1';
				break;
			case 'DEF_DOWNLOADABLE_FRONT_PICS_NO' :
				$where [] = 'def_downloadable_front_pics_stat = 0';
				break;
		}
		
		$filter_deny_access_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_access_to', 'filter_deny_access_to' );
		if ($filter_deny_access_to) {
			$where [] = 'FIND_IN_SET(' . ( int ) $filter_deny_access_to . ',item_deny_acl)';
		}
		
		$filter_deny_votes_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_votes_from', 'filter_deny_votes_from' );
		if ($filter_deny_votes_from) {
			$where [] = 'FIND_IN_SET(' . ( int ) $filter_deny_votes_from . ',votes_deny_acl)';
		}
		
		$filter_deny_downloads_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_downloads_to', 'filter_deny_downloads_to' );
		if ($filter_deny_downloads_to) {
			$where [] = 'FIND_IN_SET(' . ( int ) $filter_deny_downloads_to . ',downloads_deny_acl)';
		}
		
		$filter_deny_tagging_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_tagging_from', 'filter_deny_tagging_from' );
		if ($filter_deny_tagging_from) {
			$where [] = 'FIND_IN_SET(' . ( int ) $filter_deny_tagging_from . ',tagging_deny_acl)';
		}
		
		$filter_deny_uploads_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_uploads_to', 'filter_deny_uploads_to' );
		if ($filter_deny_uploads_to) {
			$where [] = 'FIND_IN_SET(' . ( int ) $filter_deny_uploads_to . ',uploads_deny_acl)';
		}
		
		
		if ($filter_search) {
			$filter_search = JString::strtolower ( $filter_search );
			$escaped_filter_search = $this->_db->getEscaped ( $filter_search );
			$where [] = "(title LIKE '%{$escaped_filter_search}%' OR description LIKE '%{$escaped_filter_search}%')";
		}
		
		
		return (count ( $where )) ? ' WHERE ' . implode ( ' AND ', $where ) : '';
	
	}
	
	function _buildQueryOrderBy() {
		global $mainframe, $option;
		
		
		$orders = array ('title', 'hits', 'id' );
		
		$filter_order = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'upload_date' );
		$filter_order_Dir = strtoupper ( $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' ) );
		
		
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC') {
			$filter_order_Dir = 'DESC';
		}
		
		
		if (! in_array ( $filter_order, $orders )) {
			$filter_order = 'id';
		}
		
		
		return ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
	}
	
	function &getPagination() {
		if (! $this->_pagination) {
			jimport ( 'joomla.html.pagination' );
			global $mainframe;
			$this->_pagination = new JPagination ( $this->getTotal (), JRequest::getInt ( 'limitstart', 0 ), JRequest::getInt ( 'limit', $mainframe->getCfg ( 'list_limit' ) ) );
		}
		
		return $this->_pagination;
	}
	
	function getTotal() {
		if (! $this->_total) {
			$query = $this->buildQuery ();
			$this->_total = $this->_getListCount ( $query );
		}
		
		return $this->_total;
	}
	
	function buildSearch() {
		if (! $this->_query) {
			$search = $this->getSearch ();
			
			$this->_query = 'SELECT * FROM #__jwallpapers_categories AS c';
			
			if ($search != '') {
				$search = $this->_db->getEscaped ( $search, true );
				$escaped_search = $this->_db->getEscaped ( $search );
				$this->_query .= " WHERE c.title LIKE '%{$escaped_search}%' OR c.description LIKE '%{$escaped_search}%'";
			}
			
			$this->_query .= $this->_buildQueryOrderBy (); 
		}
		
		return $this->_query;
	}
	
	function getCatList() {
		if (! $this->_catList) {
			$query = 'SELECT id, title FROM #__jwallpapers_categories ORDER by title ASC';
			$this->_catList = $this->_getList ( $query );
		}
		return $this->_catList;
	}
	
	
	function ratingsReset(&$ids = null) {
		
		if ($ids === null) {
			
			
			$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
			
			
			foreach ( $cid as &$id ) {
				$id = ( int ) $id;
			}
			
			$cid_str = implode ( ',', $cid );
		} else {
			
			
			$cid_str = $ids;
		
		}
		
		
		$query = 'DELETE FROM #__jwallpapers_votes WHERE file_id IN (SELECT id FROM #__jwallpapers_files WHERE cat_id IN (' . $cid_str . '))';
		$this->_db->Execute ( $query );
		
		
		$query = 'DELETE FROM #__jwallpapers_votes_cache WHERE file_id IN (SELECT id FROM #__jwallpapers_files WHERE cat_id IN (' . $cid_str . '))';
		$this->_db->Execute ( $query );
		
		return;
	
	}
	
	
	function setVotesStatus($action, &$ids = null) {
		
		if ($ids === null) {
			
			
			$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
			
			
			foreach ( $cid as &$id ) {
				$id = ( int ) $id;
			}
			
			$cid_str = implode ( ',', $cid );
		} else {
			
			
			$cid_str = $ids;
		
		}
		
		switch ($action) {
			case 'en' :
				
				$query = 'UPDATE #__jwallpapers_files SET votes_en = 1 WHERE cat_id IN (' . $cid_str . ')';
				break;
			case 'dis' :
				
				$query = 'UPDATE #__jwallpapers_files SET votes_en = 0 WHERE cat_id IN (' . $cid_str . ')';
				break;
		}
		$this->_db->Execute ( $query );
		
		return;
	
	}
	
	
	function setDownloadableStatus($action, &$ids = null) {
		
		if ($ids === null) {
			
			
			$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
			
			
			foreach ( $cid as &$id ) {
				$id = ( int ) $id;
			}
			
			$cid_str = implode ( ',', $cid );
		} else {
			
			
			$cid_str = $ids;
		
		}
		
		switch ($action) {
			case 'en' :
				
				$query = 'UPDATE #__jwallpapers_files SET downloadable = 1 WHERE cat_id IN (' . $cid_str . ')';
				break;
			case 'dis' :
				
				$query = 'UPDATE #__jwallpapers_files SET downloadable = 0 WHERE cat_id IN (' . $cid_str . ')';
				break;
		}
		$this->_db->Execute ( $query );
		
		return;
	
	}
	
	
	function setFrontendUploadStatus($action, &$ids = null) {
		
		if ($ids === null) {
			
			
			$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
			
			
			foreach ( $cid as &$id ) {
				$id = ( int ) $id;
			}
			
			$cid_str = implode ( ',', $cid );
		} else {
			
			
			$cid_str = $ids;
		
		}
		
		switch ($action) {
			case 'en' :
				
				$query = 'UPDATE #__jwallpapers_categories SET frontend_uploads_en = 1 WHERE id IN (' . $cid_str . ')';
				break;
			case 'dis' :
				
				$query = 'UPDATE #__jwallpapers_categories SET frontend_uploads_en = 0 WHERE id IN (' . $cid_str . ')';
				break;
		}
		$this->_db->Execute ( $query );
		
		return;
	
	}

}
?>