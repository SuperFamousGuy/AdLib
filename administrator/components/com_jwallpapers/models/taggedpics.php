<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: taggedpics.php 311 2010-05-18 15:11:33Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelTaggedPics extends JModel {
	
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
		return 'SELECT t1.*, t2.title AS tag_title FROM #__jwallpapers_tagged_files AS t1 INNER JOIN #__jwallpapers_tags AS t2 ON t1.tag_id = t2.id' . $this->_buildQueryWhere () . $this->_buildQueryOrderBy ();
	}
	
	function _buildQueryWhere() {
		global $option, $mainframe;
		
		
		$where = array ();
		
		
		$filter_status_state = $mainframe->getUserStateFromRequest ( $option . 'filter_status_state', 'filter_status_state' );
		
		if ($filter_status_state == 'E') {
			$where [] = 't1.published = 1';
		} elseif ($filter_status_state == 'D') {
			$where [] = 't1.published = 0';
		}
		
		$filter_search = trim ( $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' ) );
		
		if ($filter_search) {
			$filter_search = JString::strtolower ( $filter_search );
			$escaped_filter_search = $this->_db->getEscaped ( $filter_search );
			$where [] = "(t2.title LIKE '{$escaped_filter_search}%')";
		}
		
		
		return (count ( $where )) ? ' WHERE ' . implode ( ' AND ', $where ) : '';
	
	}
	
	function _buildQueryOrderBy() {
		global $mainframe, $option;
		
		
		$orders = array ('t1.date', 'tag_title' );
		
		$filter_order = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'date' );
		
		$filter_order_Dir = strtoupper ( $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' ) );
		
		
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC') {
			$filter_order_Dir = 'DESC';
		}
		
		
		if (! in_array ( $filter_order, $orders )) {
			$filter_order = 't1.date';
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
	
	
	
	function tag_picture($pic_id, &$tag_obj, $enable) {
		
		global $mainframe;
		
		$user = & JFactory::getUser ();
		
		
		if ($tag_obj->new) {
			
			$tag_row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
			
			
			if ($tag_row->getIdFromTitle ( $id, $tag_obj->title )) {
				
				$tag_row->load ( $id );
				$tag_id = $tag_row->id;
			} else {
				
				$tag_date = date ( 'Y-m-d H:i:s', time () );
				$data = array ('title' => $tag_obj->title, 'user_id' => $user->id, 'date' => $tag_date, 'published' => $enable );
				
				if (! $tag_row->bind ( $data )) {
					return - 1;
				}
				
				
				$tag_row->check ();
				
				if (! $tag_row->store ()) {
					return - 1;
				}
				
				
				$tag_row->validate ();
				
				
				$tag_id = $tag_row->id;
			}
		
		} else {
			$tag_id = $tag_obj->id;
		}
		
		
		$pic_id = ( int ) $pic_id;
		$tag_id = ( int ) $tag_id;
		
		
		$tag_row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		if (! $tag_row->exists ( $tag_id )) {
			return - 1;
		}
		$pic_row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		if (! $pic_row->exists ( $pic_id )) {
			return - 1;
		}
		
		
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_tagged_files WHERE tag_id=' . $tag_id . ' AND file_id=' . $pic_id;
		$this->_db->setQuery ( $query );
		$exists = $this->_db->loadResult ();
		
		if ($exists) {
			
			return 0;
		}
		
		
		$tagged_file_row = & JTable::getInstance ( 'JWallpapers_Tagged_File', 'Table' );
		
		$tagged_file_data = array ('file_id' => $pic_id, 'tag_id' => $tag_id, 'user_id' => ( int ) $user->id, 'date' => date ( 'Y-m-d H:i:s', time () ), 'published' => $enable );
		
		if (! $tagged_file_row->bind ( $tagged_file_data )) {
			return - 1;
		}
		
		if (! $tagged_file_row->store ()) {
			return - 1;
		}
		
		
		if ($tagged_file_row->validate ()) {
			
			return 1;
		} else {
			
			return - 1;
		}
	}

}
?>