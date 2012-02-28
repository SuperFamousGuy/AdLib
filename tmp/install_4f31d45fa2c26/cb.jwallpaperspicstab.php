<?php
/**
 * Community Builder JWallpapers Pictures Tab
 * 
 * @version 1.6 $Id: cb.jwallpaperspicstab.php 353 2010-06-01 10:04:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

class getJWallpapersPicsTab extends cbTabHandler {
	
	function getJWallpapersPicsTab() {
		$this->cbTabHandler ();
	}
	
	function getDisplayTab($tab, $user, $ui) {
		
		global $mainframe, $my;
		$params = $this->params;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'components/com_jwallpapers/css/' );
		
		
		require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'layout.php');
		require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'system.php');
		
		
		$language = & JFactory::getLanguage ();
		switch ($language->getTag ()) {
			default :
			case 'en-GB' :
				require_once (JPATH_BASE . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_jwallpaperspicturestab' . DS . 'en-GB.jwallpaperspicturestab.php');
				break;
			case 'es-ES' :
				require_once (JPATH_BASE . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_jwallpaperspicturestab' . DS . 'es-ES.jwallpaperspicturestab.php');
				break;
			case 'fr-FR' :
				require_once (JPATH_BASE . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_jwallpaperspicturestab' . DS . 'fr-FR.jwallpaperspicturestab.php');
				break;
		}
		
		
		$language->load ( 'com_jwallpapers' );
		
		if (! file_exists ( JPATH_BASE . DS . 'components' . DS . 'com_jwallpapers' . DS . 'jwallpapers.php' )) {
			$return = _JW_PICSTAB_NOT_INSTALLED;
		}
		
		$columns = ( int ) $params->get ( 'thumbs_columns' );
		$lines = ( int ) $params->get ( 'thumbs_lines' );
		$target_new_window = $params->get ( 'target_new_window', 0 );
		$show_thumb_info = $params->get ( 'show_thumb_info', 0 );
		$show_thumb_title = $params->get ( 'show_thumb_title', 1 );
		$thumbs_width = ( int ) $params->get ( 'thumbs_width', 0 );
		$thumbs_height = ( int ) $params->get ( 'thumbs_height', 0 );
		$thumbs_wrapper_height_mod = ( int ) $params->get ( 'thumbs_wrapper_height_mod', 90 );
		$thumbs_wrapper_width_mod = ( int ) $params->get ( 'thumbs_wrapper_width_mod', 14 );
		
		$limit = $columns * $lines;
		
		if ($limit <= 0) {
			$columns = 3;
			$lines = 3;
			$limit = 9;
		}
		
		
		$com_params = & JComponentHelper::getParams ( 'com_jwallpapers' );
		
		$acl_show_restricted_picture = $com_params->get ( 'acl_show_restricted_picture', 1 );
		
		
		$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
		
		
		if ($acl_show_restricted_picture) {
			
			$filter_restricted_pics_cond = '';
		} else {
			
			$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END)';
		}
		
		$db = & JFactory::getDBO ();
		
		$query = 'SELECT COUNT(*) FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE t1.user_id = ' . $user->id . ' AND t2.published = 1 AND t1.published = 1' . $filter_restricted_pics_cond;
		$db->setQuery ( $query );
		$picsCount = $db->loadResult ();
		
		$pagination = $this->_getPaging ( array (), array ('_' ) );
		
		if (empty ( $pagination ['_limitstart'] )) {
			$pagination ['_limitstart'] = '0';
		}
		
		if (empty ( $pagination ['_limit'] )) {
			$pagination ['_limit'] = $limit;
		}
		
		if (empty ( $pagination ['_sortby'] )) {
			$pagination ['_sortby'] = 'date_desc';
		}
		
		switch ($pagination ['_sortby']) {
			default :
				$pagination ['_sortby'] = 'date_desc';
			case 'date_desc' :
				$order_by = ' ORDER BY t1.upload_date DESC';
				break;
			case 'date_asc' :
				$order_by = ' ORDER BY t1.upload_date ASC';
				break;
			case 'best_rated' :
				$order_by = ' ORDER BY rating DESC';
				break;
			case 'most_visited' :
				$order_by = ' ORDER BY t1.hits DESC';
				break;
		}
		
		$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END AS item_deny_acl, t1.tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(t1.upload_date) AS month, YEAR(t1.upload_date) AS year, t1.file_name AS name, t1.file_ext AS ext, t1.title, t1.hits, t3.average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t3 ON t1.id = t3.file_id INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE t1.user_id = ' . $user->id . ' AND t2.published = 1 AND t1.published = 1' . $filter_restricted_pics_cond . $order_by . ' LIMIT ' . $pagination ['_limitstart'] . ',' . $pagination ['_limit'];
		
		$db->setQuery ( $query );
		$pictures = $db->loadObjectList ();
		
		$return = '<h4>' . $tab->description . '</h4>';
		$return .= '<ul class="thumbnails">';
		
		
		$layout_params = new stdClass ( );
		$layout_params->thumb_li_width = floor ( 100 / $columns );
		
		if (empty ( $thumbs_width ) && empty ( $thumbs_height )) {
			
			$thumbs_width = ( int ) $com_params->get ( 'small_thumbs_width' );
			$thumbs_height = ( int ) $com_params->get ( 'small_thumbs_height' );
		} else {
			
			
			$layout_params->thumbs_width = $thumbs_width;
			$layout_params->thumbs_height = $thumbs_height;
		}
		
		
		
		$layout_params->thumb_li_height = $thumbs_height + $thumbs_wrapper_height_mod;
		
		
		$layout_params->thumb_div_width = $thumbs_width + $thumbs_wrapper_width_mod;
		
		
		$layout_params->thumbs_title_max_length = ( int ) abs ( $com_params->get ( 'thumbs_title_max_length', 45 ) );
		
		
		$layout_params->show_thumb_info = $show_thumb_info;
		
		
		$layout_params->show_thumb_title = $show_thumb_title;
		
		
		if ($target_new_window) {
			$layout_params->target_window = 'new';
		} else {
			$layout_params->target_window = 'current';
		}
		
		foreach ( $pictures as &$picture ) {
			
			$picture->link = JRoute::_ ( 'index.php?option=com_jwallpapers&id=' . $picture->slug . '&view=picture' );
			$return .= JWallpapersHelperLayout::getThumbLayout ( $picture, $layout_params );
		}
		
		$return .= '</ul><div class="clear_both"></div><center>';
		
		$return .= $this->_writeSortByLink ( $pagination, '_', 'date_desc', _JW_PICSTAB_NEWEST_FIRST, true ) . ' | ';
		$return .= $this->_writeSortByLink ( $pagination, '_', 'date_asc', _JW_PICSTAB_NEWEST_LAST, false ) . ' | ';
		$return .= $this->_writeSortByLink ( $pagination, '_', 'best_rated', _JW_PICSTAB_BEST_RATED, false ) . ' | ';
		;
		$return .= $this->_writeSortByLink ( $pagination, '_', 'most_visited', _JW_PICSTAB_MOST_VIEWED, false ) . '</center><br />';
		;
		
		if ($picsCount > $pagination ['_limit']) {
			$return .= '<div style="width: 95%; margin: auto; text-align: center;">' . $this->_writePaging ( $pagination, '_', $pagination ['_limit'], $picsCount ) . '</div>';
		}
		
		return $return;
	}
}
?>
