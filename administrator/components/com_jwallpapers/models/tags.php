<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: tags.php 311 2010-05-18 15:11:33Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelTags extends JModel {
	
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	var $_search = null;
	var $_query = null;
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
		return 'SELECT * FROM #__jwallpapers_tags' . $this->_buildQueryWhere () . $this->_buildQueryOrderBy ();
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
		
		$filter_search = trim ( $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' ) );
		
		if ($filter_search) {
			$filter_search = JString::strtolower ( $filter_search );
			$escaped_filter_search = $this->_db->getEscaped ( $filter_search );
			$where [] = "(title LIKE '%{$escaped_filter_search}%')";
		}
		
		
		return (count ( $where )) ? ' WHERE ' . implode ( ' AND ', $where ) : '';
	
	}
	
	function _buildQueryOrderBy() {
		global $mainframe, $option;
		
		
		$orders = array ('date', 'hits', 'title' );
		
		$filter_order = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'date' );
		
		$filter_order_Dir = strtoupper ( $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' ) );
		
		
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC') {
			$filter_order_Dir = 'DESC';
		}
		
		
		if (! in_array ( $filter_order, $orders )) {
			$filter_order = 'date';
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
	
	
	
	function deleteTags($ids) {
		
		$ids = implode ( ',', $ids );
		
		
		$query = 'DELETE FROM #__jwallpapers_tagged_files WHERE tag_id IN (' . $ids . ')';
		$this->_db->Execute ( $query );
		
		
		$query = 'DELETE FROM #__jwallpapers_tags WHERE id IN (' . $ids . ')';
		$this->_db->Execute ( $query );
	
	}
	
	
	function &matching_tags($search_string) {
		
		
		
		
		$search_string = trim ( $search_string );
		
		$search_string = strtolower ( $search_string );
		
		
		$max_results = $this->_params->get ( 'ajax_tag_search_max_results', 32 );
		
		$query = 'SELECT id, title FROM #__jwallpapers_tags WHERE title LIKE \'' . $this->_db->getEscaped ( $search_string ) . '%\' ORDER BY title LIMIT ' . ( int ) $max_results;
		return $this->_getList ( $query );
	
	}

}
?>