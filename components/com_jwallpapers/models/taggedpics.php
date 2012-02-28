<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: taggedpics.php 350 2010-05-31 14:28:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelTaggedPics extends JModel {
	
	var $_id = null;
	var $_picsInfo = null;
	var $_totalPics = null;
	var $_pagination = null;
	var $_order = null;
	var $_params = null;
	var $_user_aro_gid = null;
	
	function __construct() {
		
		
		global $option;
		
		parent::__construct ();
		
		
		

		
		
		
		
		
		
		$this->_params = & JComponentHelper::getParams ( $option );
		$thumb_columns = $this->_params->get ( 'thumbs_columns' );
		$thumb_lines = $this->_params->get ( 'thumbs_lines' );
		$limit = $thumb_columns * $thumb_lines; 
		

		
		$this->_id = JRequest::getInt ( 'id', 0 );
		
		
		
		$limitstart = JRequest::getInt ( 'limitstart', 0 );
		
		$this->setState ( 'limit', $limit );
		$this->setState ( 'limitstart', $limitstart );
		
		
		
		$default_order_thumbs_by = $this->_params->get ( 'default_order_thumbs_by', 'id' );
		
		$this->_order = JRequest::getVar ( 'order', $default_order_thumbs_by );
		
		
		$this->_user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
	
	}
	
	function getTotalPics() {
		if (! $this->_totalPics) {
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id INNER JOIN #__jwallpapers_tagged_files AS t3 ON t1.id = t3.file_id WHERE t3.published = 1 AND t1.published = 1 AND t2.published = 1 AND t3.tag_id = ' . $this->_id . $filter_restricted_pics_cond;
			
			$this->_db->setQuery ( $query );
			$this->_totalPics = $this->_db->loadResult ();
		
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
	
	
	function hit() {
		
		$query = 'UPDATE #__jwallpapers_tags SET hits = hits + 1 WHERE id = ' . $this->_id;
		$this->_db->Execute ( $query );
	
	}
	
	
	function getPicsInfo() {
		
		if (! $this->_picsInfo) {
			
			$limitstart = $this->getState ( 'limitstart' );
			$limit = $this->getState ( 'limit' );
			
			
			switch ($this->_order) {
				default :
					$this->_order = 'id';
				case 'id' :
					$order_by = ' ORDER BY t1.id';
					break;
				case 'title' :
					$order_by = ' ORDER BY t1.title';
					break;
				case 'date_asc' :
					$order_by = ' ORDER BY upload_date ASC';
					break;
				case 'date_desc' :
					$order_by = ' ORDER BY upload_date DESC';
					break;
				case 'rating_asc' :
					$order_by = ' ORDER BY rating ASC';
					break;
				case 'rating_desc' :
					$order_by = ' ORDER BY rating DESC';
					break;
				case 'hits_asc' :
					$order_by = ' ORDER BY t1.hits ASC';
					break;
				case 'hits_desc' :
					$order_by = ' ORDER BY t1.hits DESC';
					break;
			}
			
			if (! $this->_params->get ( 'acl_show_restricted_picture' )) {
				$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END)';
			} else {
				$filter_restricted_pics_cond = '';
			}
			
			$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id INNER JOIN #__jwallpapers_tagged_files AS t4 ON t1.id = t4.file_id WHERE t3.published = 1 AND t1.published = 1 AND t4.published = 1 AND t4.tag_id = ' . $this->_id . $filter_restricted_pics_cond . $order_by;
			$this->_picsInfo = $this->_getList ( $query, $limitstart, $limit );
		}
		return $this->_picsInfo;
	
	}

}

?>