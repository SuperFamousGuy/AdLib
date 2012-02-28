<?php
/**
 * JWallpapers Content Pictures Plugin - A plugin for displaying JWallpapers pictures in articles
 * 
 * @version 1.3 $Id: jwpictures.php 362 2010-06-03 11:21:09Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.plugin.plugin' );

JHTML::_ ( 'behavior.mootools' );

class plgContentJWPictures extends JPlugin {
	
	function OnPrepareContent(&$row, &$params) {
		
		if (preg_match_all ( '/\{jwpics (.*?)\}/', $row->text, $results )) {
			
			
			JHTML::_ ( 'stylesheet', 'default.css', 'components/com_jwallpapers/css/' );
			
			JHTML::_ ( 'stylesheet', 'slimbox.css', 'plugins/content/jwpictures/css/' );
			
			
			$document = & JFactory::getDocument ();
			$document->addScript ( 'plugins/content/jwpictures/js/slimbox.js' );
			
			
			require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'layout.php');
			require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'image.php');
			
			$language = & JFactory::getLanguage ();
			$language->load ( 'com_jwallpapers' );
			
			$plugin = & JPluginHelper::getPlugin ( 'content', 'jwpictures' );
			$pluginParams = new JParameter ( $plugin->params );
			
			$componentParams = & JComponentHelper::getParams ( 'com_jwallpapers' );
			
			$thumbs_width = ( int ) $pluginParams->get ( 'thumbs_width', 0 );
			$thumbs_height = ( int ) $pluginParams->get ( 'thumbs_height', 0 );
			$thumbs_wrapper_height_mod = ( int ) $pluginParams->get ( 'thumbs_wrapper_height_mod', 90 );
			$thumbs_wrapper_width_mod = ( int ) $pluginParams->get ( 'thumbs_wrapper_width_mod', 14 );
			$show_thumb_info = $pluginParams->get ( 'show_thumb_info', 0 );
			$show_thumb_title = $pluginParams->get ( 'show_thumb_title', 1 );
			$target_new_window = $pluginParams->get ( 'target_new_window', 0 );
			
			
			$i = 0;
			
			foreach ( $results [1] as $result ) {
				
				$tag_params = explode ( ';', $result );
				
				
				if (empty ( $tag_params [0] )) {
					return false;
				}
				
				$tainted_ids = explode ( ',', $tag_params [0] );
				
				$filtered_ids = array ();
				foreach ( $tainted_ids as $tainted_id ) {
					if (empty ( $tainted_id )) {
						break;
					}
					$filtered_ids [] = ( int ) $tainted_id;
				}
				
				
				if (empty ( $filtered_ids )) {
					return false;
				}
				
				$pics = $this->getPics ( implode ( ',', $filtered_ids ) );
				
				
				$columns = (empty ( $tag_params [1] )) ? 3 : ( int ) $tag_params [1];
				
				
				$lightbox = (! isset ( $tag_params [2] )) ? 1 : ( int ) $tag_params [2];
				
				
				$layout_params = new stdClass ( );
				$layout_params->thumb_li_width = floor ( 100 / $columns );
				
				if (empty ( $thumbs_width ) && empty ( $thumbs_height )) {
					
					$thumbs_width = ( int ) $componentParams->get ( 'small_thumbs_width' );
					$thumbs_height = ( int ) $componentParams->get ( 'small_thumbs_height' );
				} else {
					
					
					$layout_params->thumbs_width = $thumbs_width;
					$layout_params->thumbs_height = $thumbs_height;
				}
				
				
				
				$layout_params->thumb_li_height = $thumbs_height + $thumbs_wrapper_height_mod;
				
				
				$layout_params->thumb_div_width = $thumbs_width + $thumbs_wrapper_width_mod;
				
				
				$layout_params->thumbs_title_max_length = ( int ) abs ( $componentParams->get ( 'thumbs_title_max_length', 45 ) );
				
				
				$layout_params->show_thumb_info = $show_thumb_info;
				
				
				$layout_params->show_thumb_title = $show_thumb_title;
				
				
				if ($target_new_window) {
					$layout_params->target_window = 'new';
				} else {
					$layout_params->target_window = 'current';
				}
				
				$tag_replacement = '<ul class="thumbnails">';
				
				foreach ( $pics as $pic ) {
					
					
					if ($lightbox) {
						
						if (count ( $pics ) <= 1) {
							$pic->link = 'jwallpapers_files/' . $pic->year . '/' . $pic->month . '/light_thumb_' . $pic->name . '.jpg" rel="lightbox" title="' . $pic->title;
						} else {
							
							$pic->link = 'jwallpapers_files/' . $pic->year . '/' . $pic->month . '/light_thumb_' . $pic->name . '.jpg" rel="lightbox[group_' . $i . ']" title="' . $pic->title;
						}
					} else {
						$pic->link = JRoute::_ ( 'index.php?option=com_jwallpapers&view=picture&id=' . $pic->slug );
					}
					
					$thumb_layout = JWallpapersHelperLayout::getThumbLayout ( $pic, $layout_params );
					
					
					JWallpapersHelperImage::imageGenChk ( $pic, 'light_thumb' );
					
					$tag_replacement .= $thumb_layout;
				
				}
				
				$tag_replacement .= '</ul>';
				
				$row->text = str_replace ( '{jwpics ' . $result . '}', $tag_replacement, $row->text );
				
				$i ++;
			}
			return true;
		}
	}
	
	function getPics($id_list) {
		
		
		$query = 'SELECT #__jwallpapers_files.id, CASE WHEN CHAR_LENGTH(#__jwallpapers_files.alias) THEN CONCAT_WS(\':\', #__jwallpapers_files.id, #__jwallpapers_files.alias) ELSE #__jwallpapers_files.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, title, hits, average AS rating FROM #__jwallpapers_files LEFT JOIN #__jwallpapers_votes_cache ON #__jwallpapers_files.id = #__jwallpapers_votes_cache.file_id WHERE #__jwallpapers_files.id IN (' . $id_list . ')';
		$db = & JFactory::getDBO ();
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	
	}
}

?>
