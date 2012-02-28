<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: picture.php 350 2010-05-31 14:28:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelPicture extends JModel {
	
	var $_id = null;
	var $_picInfo = null;
	var $_previousPic = null;
	var $_nextPic = null;
	var $_resizes = null;
	var $_position = null;
	var $_picsInCat = null;
	var $_picCat = null;
	var $_voteCache = null;
	var $_path = null;
	var $_user_aro_gid = null;
	
	function __construct($id = null) {
		parent::__construct ();
		
		if ($id) {
			$this->_id = ( int ) $id;
		} else {
			$this->_id = JRequest::getInt ( 'id', 0 );
		}
		
		
		$this->_user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
	
	}
	
	function getPicInfo() {
		if (! $this->_picInfo) {
			
			$query = 'SELECT *, #__jwallpapers_files.id AS id, CASE WHEN CHAR_LENGTH(#__jwallpapers_files.alias) THEN CONCAT_WS(\':\', #__jwallpapers_files.id, #__jwallpapers_files.alias) ELSE #__jwallpapers_files.id END AS slug, average AS rating, count AS vote_count, #__jwallpapers_files.user_id AS upload_user_id FROM #__jwallpapers_files LEFT JOIN #__jwallpapers_votes_cache ON #__jwallpapers_files.id = #__jwallpapers_votes_cache.file_id WHERE #__jwallpapers_files.id = ' . ( int ) $this->_id . ' AND #__jwallpapers_files.published = 1';
			$this->_db->setQuery ( $query );
			$this->_picInfo = $this->_db->loadObject ();
		}
		return $this->_picInfo;
	}
	
	function getPrevPic() {
		if (! $this->_previousPic) {
			
			
			$query = 'SELECT *, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . ( int ) $this->_picInfo->cat_id . ' AND t1.id < ' . ( int ) $this->_picInfo->id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END) ORDER BY t1.id DESC LIMIT 1';
			$this->_previousPic = $this->_getList ( $query );
			$this->_previousPic = ($this->_previousPic) ? $this->_previousPic [0] : null;
		}
		return $this->_previousPic;
	}
	
	function getNextPic() {
		
		if (! $this->_nextPic) {
			
			
			$query = 'SELECT *, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . ( int ) $this->_picInfo->cat_id . ' AND t1.id > ' . ( int ) $this->_picInfo->id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END) ORDER BY t1.id ASC LIMIT 1';
			$this->_nextPic = $this->_getList ( $query );
			$this->_nextPic = ($this->_nextPic) ? $this->_nextPic [0] : null;
		}
		return $this->_nextPic;
	}
	
	function getPosition() {
		if (! $this->_position) {
			
			
			$query = 'SELECT COUNT(*) AS pos FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . ( int ) $this->_picInfo->cat_id . ' AND t1.id < ' . ( int ) $this->_picInfo->id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			$this->_position = $this->_getList ( $query );
			$this->_position = $this->_position [0];
		}
		return $this->_position;
	}
	
	function getTotalPicsInCat() {
		if (! $this->_picsInCat) {
			$query = 'SELECT COUNT(*) FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . ( int ) $this->_picInfo->cat_id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $this->_user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
			$this->_db->setQuery ( $query );
			$this->_picsInCat = $this->_db->loadResult ();
		}
		return $this->_picsInCat;
	}
	
	function getResizes() {
		
		global $option;
		
		if (! $this->_resizes) {
			
			if (! $this->_picInfo) {
				$this->getPicInfo ();
			}
			
			$params = & JComponentHelper::getParams ( $option );
			
			
			if (! $params->get ( 'resizes_extrapolate' )) {
				
				$query_cond = ' AND t1.width < ' . $this->_picInfo->width . ' AND t1.height < ' . $this->_picInfo->height;
			}
			
			$queries = array ();
			
			$queries [] = 'SELECT t1.width AS width, t1.height AS height FROM #__jwallpapers_files_resizes AS t1 WHERE file_id = ' . $this->_id . $query_cond;
			
			$queries [] = 'SELECT t1.width AS width, t1.height AS height FROM #__jwallpapers_categories_resizes AS t1 INNER JOIN #__jwallpapers_files AS t2 ON t1.cat_id = t2.cat_id WHERE t2.id = ' . $this->_id . ' AND FIND_IN_SET(t2.size_format,t1.size_formats)' . $query_cond;
			
			
			$queries [] = 'SELECT t1.width AS width, t1.height AS height FROM #__jwallpapers_global_resizes AS t1 WHERE FIND_IN_SET(' . $this->_picInfo->size_format . ',t1.size_formats)' . $query_cond;
			
			for($i = 0; $i < 3; $i ++) {
				$resizes = $this->_getList ( $queries [$i] );
				if (! empty ( $resizes )) {
					break;
				}
			}
			
			$this->_resizes = $resizes;
		}
		return $this->_resizes;
	}
	
	function getCategory() {
		if (! $this->_picCat) {
			$query = 'SELECT title FROM #__jwallpapers_categories WHERE id = ' . ( int ) $this->_picInfo->cat_id;
			
			$this->_picCat = $this->_getList ( $query );
			$this->_picCat = $this->_picCat [0]->title;
		}
		return $this->_picCat;
	}
	
	function hit() {
		
		if ($this->_id) {
			$query = 'UPDATE #__jwallpapers_files SET hits = hits + 1 WHERE id = ' . $this->_id;
			$this->_db->Execute ( $query );
			return true;
		}
		return false;
	}
	
	function getVoteCache() {
		if (! $this->_voteCache) {
			$query = 'SELECT #__jwallpapers_votes_cache.id AS id, ROUND( SUM( value ) / COUNT( value ) , 2) AS average, COUNT( value ) AS count, #__jwallpapers_votes.file_id AS file_id FROM #__jwallpapers_votes LEFT JOIN #__jwallpapers_votes_cache ON #__jwallpapers_votes.file_id = #__jwallpapers_votes_cache.file_id WHERE #__jwallpapers_votes.file_id =' . ( int ) $this->_id . ' GROUP BY #__jwallpapers_votes.file_id';
			$this->_voteCache = $this->_getList ( $query );
			$this->_voteCache = $this->_voteCache [0];
		}
		return $this->_voteCache;
	
	}
	
	
	function getCBfield($field, $user_id) {
		
		
		if (! ($field && $user_id)) {
			return null;
		}
		
		$field_clean = $this->_db->getEscaped ( $field );
		
		$query = 'SELECT * FROM #__comprofiler_fields WHERE name = \'' . $field_clean . '\'';
		$this->_db->setQuery ( $query );
		$fieldObj = $this->_db->loadObject ();
		
		
		$type = $fieldObj->type;
		$validFields = array ('webaddress', 'text' );
		
		if (in_array ( $type, $validFields )) {
			$query = 'SELECT ' . $field_clean . ' FROM #__comprofiler WHERE user_id = ' . ( int ) $user_id;
			$this->_db->setQuery ( $query );
			$field_val = $this->_db->loadResult ();
			switch ($type) {
				case 'webaddress' :
					$field_val = '<a href="http://' . $field_val . '" target="_blank">' . $field_val . '</a>';
					break;
			}
			
			return $field_val;
		
		} else {
			return null;
		}
	
	}
	
	
	
	function uploadUserExists($id = null) {
		
		
		if ($id == 0 || $this->_picInfo->id == 0) {
			return true;
		}
		
		if (! $id) {
			$query = 'SELECT COUNT(*) FROM #__users WHERE id = ' . $this->_picInfo->user_id;
		} else {
			$query = 'SELECT COUNT(*) FROM #__users WHERE id = ' . $id;
		}
		
		$this->_db->setQuery ( $query );
		$result = $this->_db->loadResult ();
		
		switch ($result) {
			case 0 :
				return false;
				break;
			default :
				return true;
				break;
		}
	
	}
	
	
	
	
	function &getPicTags($id = null) {
		
		if (! $id) {
			$id = $this->_id;
		}
		
		
		$query = 'SELECT t2.id, CASE WHEN CHAR_LENGTH(t2.alias) THEN CONCAT_WS(\':\', t2.id, t2.alias) ELSE t2.id END AS slug, title FROM #__jwallpapers_tagged_files AS t1 INNER JOIN #__jwallpapers_tags AS t2 ON t1.tag_id = t2.id WHERE file_id = ' . ( int ) $id . ' AND t1.published = 1 ORDER BY RAND()';
		return $this->_getList ( $query );
	}

}

?>