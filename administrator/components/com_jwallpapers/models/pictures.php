<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: pictures.php 351 2010-06-01 09:32:08Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelPictures extends JModel {
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	var $_search = null;
	var $_query = null;
	var $_allowedResolutions = null;
	var $_params = null;
	
	function __construct() {
		
		global $option;
		
		parent::__construct ();
		
		$component = JComponentHelper::getComponent ( $option );
		$this->_params = new JParameter ( $component->params );
	
	}
	
	function &getData() {
		$pagination = & $this->getPagination ();
		
		if (empty ( $this->_data )) {
			$query = $this->buildQuery ();
			$this->_data = $this->_getList ( $query, $pagination->limitstart, $pagination->limit );
		}
		
		return $this->_data;
	}
	
	function buildQuery() {
		return 'SELECT #__jwallpapers_files.*, average, count FROM #__jwallpapers_files LEFT JOIN #__jwallpapers_votes_cache ON #__jwallpapers_files.id = file_id' . $this->_buildQueryWhere () . $this->_buildQueryOrderBy ();
	}
	
	function _buildQueryWhere() {
		global $option, $mainframe;
		
		
		$where = array ();
		
		
		$filter_state = $mainframe->getUserStateFromRequest ( $option . 'filter_state', 'filter_state' );
		
		if ($filter_state == 'P') {
			$where [] = 'published = 1';
		} elseif ($filter_state == 'U') {
			$where [] = 'published = 0';
		}
		
		$filter_catid = ( int ) $mainframe->getUserStateFromRequest ( $option . 'filter_catid', 'filter_catid' );
		
		if ($filter_catid == - 1) {
			$where [] = 'cat_id = 0';
		}
		
		if ($filter_catid > 0) {
			$where [] = 'cat_id = ' . $filter_catid;
		}
		
		$filter_by_state_pics = $mainframe->getUserStateFromRequest ( $option . 'filter_by_state_pics', 'filter_by_state_pics' );
		switch ($filter_by_state_pics) {
			case 'VOTES_EN' :
				$where [] = 'votes_en = 1';
				break;
			case 'VOTES_DIS' :
				$where [] = 'votes_en = 0';
				break;
			case 'DOWNLOADS_EN' :
				$where [] = 'downloadable = 1';
				break;
			case 'DOWNLOADS_DIS' :
				$where [] = 'downloadable = 0';
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
		
		$filter_tag = $mainframe->getUserStateFromRequest ( $option . 'filter_tag', 'filter_tag' );
		switch ($filter_tag) {
			default :
				break;
			case 1 :
				
				$where [] = 'tag_ep = 1';
				break;
		}
		
		$filter_search = trim ( $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' ) );
		
		if ($filter_search) {
			$filter_search = JString::strtolower ( $filter_search );
			$escaped_filter_search = $this->_db->getEscaped ( $filter_search );
			$where [] = "(title LIKE '%{$escaped_filter_search}%' OR description LIKE '%{$escaped_filter_search}%')";
		}
		
		
		return (count ( $where )) ? ' WHERE ' . implode ( ' AND ', $where ) : '';
	
	}
	
	function _buildQueryOrderBy() {
		global $mainframe, $option;
		
		
		$orders = array ('upload_date', 'title', 'id', 'count', 'average', 'hits', 'downloads' );
		
		$filter_order = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'upload_date' );
		$filter_order_Dir = strtoupper ( $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' ) );
		
		
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC') {
			$filter_order_Dir = 'DESC';
		}
		
		
		if (! in_array ( $filter_order, $orders )) {
			$filter_order = 'upload_date';
		}
		
		
		return ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
	}
	
	function getTotal() {
		if (! $this->_total) {
			$query = $this->buildQuery ();
			$this->_total = $this->_getListCount ( $query );
		}
		
		return $this->_total;
	}
	
	function &getPagination() {
		if (! $this->_pagination) {
			jimport ( 'joomla.html.pagination' );
			global $mainframe;
			$this->_pagination = new JPagination ( $this->getTotal (), JRequest::getInt ( 'limitstart', 0 ), JRequest::getInt ( 'limit', $mainframe->getCfg ( 'list_limit' ) ) );
		}
		
		return $this->_pagination;
	}
	
	function getAllowedResolutions() {
		
		if (! $this->_allowedResolutions) {
			
			$query = 'SELECT * FROM #__jwallpapers_allowed_resolutions';
			$this->_allowedResolutions = $this->_getList ( $query );
		
		}
		
		return $this->_allowedResolutions;
	
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
		
		
		$query = 'DELETE FROM #__jwallpapers_votes WHERE file_id IN (' . $cid_str . ')';
		$this->_db->Execute ( $query );
		
		
		$query = 'DELETE FROM #__jwallpapers_votes_cache WHERE file_id IN (' . $cid_str . ')';
		$this->_db->Execute ( $query );
		
		return;
	
	}
	
	function allRatingsReset() {
		
		$query = 'TRUNCATE TABLE #__jwallpapers_votes';
		$this->_db->Execute ( $query );
		
		$query = 'TRUNCATE TABLE #__jwallpapers_votes_cache';
		$this->_db->Execute ( $query );
		
		return;
	
	}
	
	
	function deleteResizeList($cid) {
		
		$ids = implode ( ',', $cid );
		$ids_filtered = JWallpapersHelperSystem::filterIdList ( $ids );
		
		$query = 'DELETE FROM #__jwallpapers_files_resizes WHERE file_id IN (' . $ids_filtered . ')';
		$this->_db->Execute ( $query );
	
	}
	
	function deleteTaggedPics($cid) {
		
		$ids = implode ( ',', $cid );
		$ids = JWallpapersHelperSystem::filterIdList ( $ids );
		
		$query = 'DELETE FROM #__jwallpapers_tagged_files WHERE file_id IN (' . $ids . ')';
		$this->_db->Execute ( $query );
	
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
				
				$query = 'UPDATE #__jwallpapers_files SET votes_en = 1 WHERE id IN (' . $cid_str . ')';
				break;
			case 'dis' :
				
				$query = 'UPDATE #__jwallpapers_files SET votes_en = 0 WHERE id IN (' . $cid_str . ')';
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
				
				$query = 'UPDATE #__jwallpapers_files SET downloadable = 1 WHERE id IN (' . $cid_str . ')';
				break;
			case 'dis' :
				
				$query = 'UPDATE #__jwallpapers_files SET downloadable = 0 WHERE id IN (' . $cid_str . ')';
				break;
		}
		$this->_db->Execute ( $query );
		
		return;
	
	}
}
?>