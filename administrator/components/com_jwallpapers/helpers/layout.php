<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: layout.php 328 2010-05-26 08:34:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JWallpapersHelperLayout {
	
	function getAllowedResolutionsLayout(&$allowedResolutions) {
		
		global $option;
		
		$count = 0;
		echo '<table class="resolutions_layout"><tr><td><b>' . JText::_ ( 'WIDTH' ) . ' (px)</td><td><b>x</b></td><td><b>' . JText::_ ( 'HEIGHT' ) . ' (px)</b></td><td></td></tr>';
		foreach ( $allowedResolutions as $allowedResolution ) {
			$count ++;
			echo '<tr>';
			echo '<input type="hidden" name="allowed_res_id_' . $count . '" value="' . $allowedResolution->id . '" />';
			echo '<td><input width="200px" readonly type="text" name="allowed_res_width_' . $count . '" value="' . $allowedResolution->width . '" /></td>';
			echo '<td>x</td>';
			echo '<td><input width="200px" readonly type="text" name="allowed_res_height_' . $count . '" value="' . $allowedResolution->height . '" /></td>';
			echo '<td><a class="ajax_allowed_res_link button_link" id="allowed_resolution" href="index.php?option=' . $option . '&controller=settings&task=delAllowedRes&id=' . $allowedResolution->id . '&' . JUtility::getToken () . '=1" >' . JText::_ ( 'DELETE_ALLOWED_RESOLUTION' ) . '</a></td>';
			echo '</tr>';
		
		}
		echo '<tr><td><b>' . JText::_ ( 'ADD_ALLOWED_RESOLUTION' ) . '</b></td></tr>';
		echo '<tr>';
		echo '<td><input type="text" name="allowed_res_width_new" id="allowed_res_width_new" value="" /></td>';
		echo '<td>x</td>';
		echo '<td><input type="text" name="allowed_res_height_new" id="allowed_res_height_new" value="" /></td>';
		echo '<td><a class="ajax_allowed_res_link button_link" id="new_allowed_resolution" href="index.php?option=' . $option . '&controller=settings&task=addAllowedRes&' . JUtility::getToken () . '=1" >' . JText::_ ( 'ADD_ALLOWED_RESOLUTION' ) . '</a></td>';
		echo '</tr>';
		echo '</table>';
	}
	
	function getResizeListLayout(&$resizeList) {
		
		global $option;
		
		$controller = JRequest::getVar ( 'controller' );
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = ( int ) $cid [0];
		
		if ($id) {
			$url_id = '&cid[]=' . $id;
		}
		
		
		$show_size_formats = false;
		if ($controller != 'pictures') {
			$show_size_formats = true;
		}
		
		$count = 0;
		
		if ($show_size_formats) {
			echo '<table class="resizes_layout"><tr><td><b>' . JText::_ ( 'WIDTH' ) . ' (px)</b></td><td><b>x</b></td><td><b>' . JText::_ ( 'HEIGHT' ) . ' (px)</b></td><td><b>4:3</b></td><td><b>16:10</b></td><td><b>16:9</b></td><td><b>5:4</b></td><td><b>' . JText::_ ( 'OTHER' ) . '</b></td></tr>';
		} else {
			echo '<table class="resizes_layout"><tr><td><b>' . JText::_ ( 'WIDTH' ) . ' (px)</b></td><td><b>x</b></td><td><b>' . JText::_ ( 'HEIGHT' ) . ' (px)</b></td></tr>';
		}
		
		foreach ( $resizeList as $resize ) {
			$count ++;
			if ($show_size_formats) {
				
				
				$resize->size_format_0 = '';
				$resize->size_format_1 = '';
				$resize->size_format_2 = '';
				$resize->size_format_3 = '';
				$resize->size_format_4 = '';
				
				
				$size_formats = explode ( ',', $resize->size_formats );
				foreach ( $size_formats as $size_format ) {
					switch ($size_format) {
						case '0' :
							$resize->size_format_0 = 'checked';
							break;
						case '1' :
							$resize->size_format_1 = 'checked';
							break;
						case '2' :
							$resize->size_format_2 = 'checked';
							break;
						case '3' :
							$resize->size_format_3 = 'checked';
							break;
						case '4' :
							$resize->size_format_4 = 'checked';
							break;
						default :
							
							break;
					}
				}
			}
			echo '<tr>';
			echo '<input type="hidden" name="resize_id_' . $count . '" value="' . $resize->id . '" />';
			echo '<td><input readonly type="text" name="resize_width_' . $count . '" value="' . $resize->width . '" /></td>';
			echo '<td>x</td>';
			echo '<td><input readonly type="text" name="resize_height_' . $count . '" value="' . $resize->height . '" /></td>';
			
			if ($show_size_formats) {
				echo '<td><input type="checkbox" name="resize_format_0_' . $count . '" ' . $resize->size_format_0 . ' /></td>';
				echo '<td><input type="checkbox" name="resize_format_1_' . $count . '" ' . $resize->size_format_1 . ' /></td>';
				echo '<td><input type="checkbox" name="resize_format_4_' . $count . '" ' . $resize->size_format_4 . ' /></td>';
				echo '<td><input type="checkbox" name="resize_format_2_' . $count . '" ' . $resize->size_format_2 . ' /></td>';
				echo '<td><input type="checkbox" name="resize_format_3_' . $count . '" ' . $resize->size_format_3 . ' /></td>';
			}
			echo '<td><a class="ajax_available_resize_link button_link" id="available_resize" href="index.php?option=' . $option . '&controller=' . $controller . '&task=delResize&id=' . $resize->id . '&' . JUtility::getToken () . '=1' . $url_id . '" >' . JText::_ ( 'DELETE_AVAILABLE_RESIZE' ) . '</a></td>';
			echo '</tr>';
		
		}
		
		

		echo '<input type="hidden" name="resizesCount" value="' . $count . '" />';
		echo '<tr><td><b>' . JText::_ ( 'ADD_AVAILABLE_RESIZE' ) . '</b></td></tr>';
		echo '<tr>';
		echo '<td><input type="text" name="resize_width_new" id="resize_width_new" value="" /></td>';
		echo '<td>x</td>';
		echo '<td><input type="text" name="resize_height_new" id="resize_height_new" value="" /></td>';
		
		if ($show_size_formats) {
			echo '<td><input type="checkbox" name="resize_format_0_new" id="resize_format_0_new" checked /></td>';
			echo '<td><input type="checkbox" name="resize_format_1_new" id="resize_format_1_new" checked /></td>';
			echo '<td><input type="checkbox" name="resize_format_4_new" id="resize_format_4_new" checked /></td>';
			echo '<td><input type="checkbox" name="resize_format_2_new" id="resize_format_2_new" checked /></td>';
			echo '<td><input type="checkbox" name="resize_format_3_new" id="resize_format_3_new" checked /></td>';
		}
		echo '<td><a class="ajax_available_resize_link button_link" id="new_resize" href="index.php?option=' . $option . '&controller=' . $controller . '&task=addResize&' . JUtility::getToken () . '=1' . $url_id . '" >' . JText::_ ( 'ADD_AVAILABLE_RESIZE' ) . '</a></td>';
		echo '</tr>';
		echo '</table>';
	}
	
	
	function getCatSelectLayout(&$catList, &$catPath) {
		
		global $option, $mainframe;
		
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$basicRoute = 'index.php?option=' . $option . '&controller=pictures&task=ajaxGetCat';
		
		
		$i = 0;
		$selectedCatTitle = '/';
		$selectedCatId = 0;
		$goUpId = - 1;
		$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
		$pathString = '/';
		foreach ( $catPath as $pathElement ) {
			$i ++;
			if ($i == 1) { 
				$selectedCatTitle = $pathElement->title;
				$selectedCatId = $pathElement->id;
				
				$pathString .= $selectedCatTitle;
				
				
				
				
				$goUpId = 0;
				continue;
			}
			if ($mainframe->isAdmin () || ($pathElement->frontend_uploads_en && ! in_array ( $user_aro_gid, explode ( ',', $pathElement->uploads_deny_acl ) ))) {
				
				
				$pathString = '/<a id="ajax_cat_pathString" class="ajax_cat_link" href="' . $basicRoute . '&id=' . $pathElement->id . '">' . $pathElement->title . '</a>' . $pathString;
				
				if ($i == 2) {
					$goUpId = $pathElement->id; 
				}
			} else {
				
				
				$pathString = '/<a class="ajax_cat_no_link">' . $pathElement->title . '</a>' . $pathString;
				
				if ($i == 2) {
					$goUpId = - 1;
				}
			}
		
		}
		
		
		echo '<div id="existing_cat_div">';
		echo '<ul id="ajax_category_list" style="list-style: none">';
		
		echo $pathString;
		echo '<br/>';
		
		
		if ($goUpId > 0) {
			echo '<a id="up_link" class="ajax_cat_link" href="' . $basicRoute . '&id=' . $goUpId . '">' . JText::_ ( 'UP' ) . '</a>';
			
		} elseif ($goUpId == 0) {
			
			echo '<a id="up_link" class="ajax_cat_link" href="' . $basicRoute . '&id=0">' . JText::_ ( 'UP' ) . '</a>';
		}
		
		
		if ($mainframe->isAdmin () || $params->get ( 'frontend_category_proposal' )) {
			echo '<li><a id="new_cat_link" href="#" onClick="fromNewCat(); return false;">' . JTEXT::_ ( 'NEW_CAT_HERE' ) . '</a></li>'; 
		}
		
		foreach ( $catList as $cat ) {
			echo '<li name="' . $cat->id . '"><a class="ajax_cat_link" href="' . $basicRoute . '&id=' . $cat->id . '">' . $cat->title . '</a></li>';
		}
		echo '</ul>';
		echo JTEXT::_ ( 'CURRENT_SELECTED_CAT' ) . ': <span class="red_msg">' . $selectedCatTitle . '</span><br/>';
		echo '<input type="hidden" name="cat_id" value="' . $selectedCatId . '" />';
		
		echo '</div>';
		
		

		
		echo '<div id="new_cat_div" style="display: none;">';
		echo JTEXT::_ ( 'CREATE_NEW_CAT_UNDER' ) . ': <span class="red_msg">' . $selectedCatTitle . '</span><br/>';
		echo '<input type="text" name="new_cat" id="new_cat" value="" onkeyup="categoryLimiter(this);" /><br/>';
		echo JTEXT::_ ( 'OR' ) . ' <a href="#" onClick="fromExistingCat(); return false;">' . JTEXT::_ ( 'SELECT_A_CAT' ) . '</a>';
		echo '</div>';
		
	}
	
	function getParentSelectLayout(&$catList, &$catPath, $thisCatId) {
		
		global $option;
		
		$basicRoute = 'index.php?option=' . $option . '&controller=categories&task=ajaxGetCat';
		
		
		$i = 0;
		$selectedCatTitle = '/';
		$selectedCatId = 0;
		$goUpId = null;
		$pathString = '/';
		foreach ( $catPath as $pathElement ) {
			$i ++;
			if ($i == 1) { 
				$selectedCatTitle = $pathElement->title;
				$selectedCatId = $pathElement->id;
				
				$pathString .= $selectedCatTitle;
				
				continue;
			} elseif ($i == 2) {
				$goUpId = $pathElement->id; 
			}
			$pathString = '/<a id="ajax_cat_pathString" class="ajax_cat_link" href="' . $basicRoute . '&id=' . $pathElement->id . '&cid[]=' . $thisCatId . '">' . $pathElement->title . '</a>' . $pathString;
		}
		
		
		echo '<div id="existing_cat_div">';
		echo '<ul id="ajax_category_list" style="list-style: none">';
		
		echo $pathString;
		echo '<br/>';
		
		
		if ($goUpId != null) {
			echo '<a id="up_link" class="ajax_cat_link" href="' . $basicRoute . '&id=' . $goUpId . '&cid[]=' . $thisCatId . '">' . JText::_ ( 'UP' ) . '</a>';
			
		} elseif ($catPath != null) { 
			echo '<a id="up_link" class="ajax_cat_link" href="' . $basicRoute . '&id=0&cid[]=' . $thisCatId . '">' . JText::_ ( 'UP' ) . '</a>';
		}
		
		foreach ( $catList as $cat ) {
			if ($cat->id != $thisCatId) { 
				echo '<li name="' . $cat->id . '"><a class="ajax_cat_link" href="' . $basicRoute . '&id=' . $cat->id . '&cid[]=' . $thisCatId . '">' . $cat->title . '</a></li>';
			}
		}
		echo '</ul>';
		
		echo JTEXT::_ ( 'CURRENT_SELECTED_CAT' ) . ': <span class="red_msg">' . $selectedCatTitle . '</span><br/>';
		echo '<input type="hidden" name="parent_id" value="' . $selectedCatId . '" />';
		echo '</div>';
		
	

	}
	
	
	function getThumbLayout(&$item, &$layout_params) {
		
		
		$option = 'com_jwallpapers';
		
		$thumbDir = 'jwallpapers_files/' . $item->year . '/' . $item->month;
		$thumb = $thumbDir . '/thumb_' . $item->name . '.jpg';
		
		
		if ($layout_params->show_thumb_title) {
			
			if (strlen ( $item->title ) > $layout_params->thumbs_title_max_length) {
				
				$title = '<p>' . substr ( $item->title, 0, $layout_params->thumbs_title_max_length ) . ' ...</p>';
			} else {
				$title = '<p>' . $item->title . '</p>';
			}
		} else {
			$title = '';
		}
		
		
		if ($item->rating == null) {
			$item->rating = 0;
		}
		
		
		
		
		if ($layout_params->show_thumb_info) {
			$info = JText::_ ( 'RATING' ) . ': ' . $item->rating . '<br/>' . JText::_ ( 'HITS' ) . ': ' . $item->hits;
		} else {
			$info = '';
		}
		
		
		require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'image.php');
		require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'system.php');
		
		
		JWallpapersHelperImage::imageGenChk ( $item, 'thumb' );
		
		
		
		$thumb_li_height = $layout_params->thumb_li_height + 2;
		$thumb_div_width = $layout_params->thumb_div_width + 2;
		
		
		$thumb_li_min_width = $thumb_div_width + 2;
		
		
		switch ($layout_params->target_window) {
			case 'new' :
				$target_html = 'target="_blank"';
				break;
			default :
			case 'current' :
				$target_html = '';
				break;
		}
		
		
		
		if (! (empty ( $layout_params->thumbs_width ) && empty ( $layout_params->thumbs_height ))) {
			$width = ( int ) abs ( $layout_params->thumbs_width );
			$height = ( int ) abs ( $layout_params->thumbs_height );
			$width_html = 'width="' . $width . '"';
			$height_html = 'height="' . $height . '"';
		} else {
			$width_html = '';
			$height_html = '';
		}
		
		
		if (@$item->tag_ep) {
			$anchor_class = 'class="editors_pick"';
		}
		
		$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
		
		
		if (in_array ( $user_aro_gid, explode ( ',', $item->item_deny_acl ) )) {
			$opacity_style = ' opacity:0.4; filter:alpha(opacity=40);';
		} else {
			$opacity_style = '';
		}
		return '<li style="width: ' . $layout_params->thumb_li_width . '%; height: ' . $thumb_li_height . 'px; min-width: ' . $thumb_li_min_width . 'px;' . $opacity_style . '"><div style="width: ' . $thumb_div_width . 'px;"><a ' . @$anchor_class . 'href="' . $item->link . '" ' . $target_html . '><img title="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" alt="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" src="' . $thumb . '" ' . $width_html . ' ' . $height_html . '/>' . $info . '</a>' . $title . '</div></li>';
	}
	
	
	function getCatThumbLayout(&$item, &$layout_params) {
		
		
		$option = 'com_jwallpapers';
		
		$params = & JComponentHelper::getParams ( $option );
		
		
		if ($layout_params->show_thumb_title) {
			
			if (strlen ( $item->title ) > $layout_params->thumbs_title_max_length) {
				
				$title = '<p>' . substr ( $item->title, 0, $layout_params->thumbs_title_max_length ) . ' ...</p>';
			} else {
				$title = '<p>' . $item->title . '</p>';
			}
		} else {
			$title = '';
		}
		
		
		
		$showDefaultPic = false;
		if (empty ( $item->name )) {
			
			if ($params->get ( 'search_cat_thumb' )) {
				
				$db = & JFactory::getDBO ();
				$query = 'SELECT id, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_files WHERE cat_id = ' . $item->id . ' AND published = 1 ORDER BY id LIMIT 0,1';
				$db->setQuery ( $query );
				$picThumb = $db->loadObject ();
				if ($picThumb === null) {
					
					$showDefaultPic = true;
				} else {
					
					$item->name = $picThumb->name;
					$item->year = $picThumb->year;
					$item->month = $picThumb->month;
					$item->ext = $picThumb->ext;
					
					
					$query = 'UPDATE #__jwallpapers_categories SET file_id = ' . $picThumb->id . ' WHERE id = ' . $item->id;
					$db->Execute ( $query );
				}
			} else {
				
				$showDefaultPic = true;
			}
		}
		
		
		if (! $showDefaultPic) {
			$thumbDir = 'jwallpapers_files/' . $item->year . '/' . $item->month;
			$thumb = $thumbDir . '/thumb_' . $item->name . '.jpg';
			
			
			require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'image.php');
			
			
			JWallpapersHelperImage::imageGenChk ( $item, 'thumb' );
		} else {
			$thumb = 'components/' . $option . '/images/default/folder_image.png';
		}
		
		
		
		$thumb_li_height = $layout_params->thumb_li_height + 2;
		$thumb_div_width = $layout_params->thumb_div_width + 2;
		
		
		$thumb_li_min_width = $thumb_div_width + 2;
		
		
		switch ($layout_params->target_window) {
			case 'new' :
				$target_html = 'target="_blank"';
				break;
			default :
			case 'current' :
				$target_html = '';
				break;
		}
		
		$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
		
		
		if (in_array ( $user_aro_gid, explode ( ',', $item->item_deny_acl ) )) {
			$opacity_style = ' opacity:0.4; filter:alpha(opacity=40);';
		} else {
			$opacity_style = '';
		}
		
		switch ($showDefaultPic) {
			case false :
				return '<li style="width: ' . $layout_params->thumb_li_width . '%; height: ' . $thumb_li_height . 'px; min-width: ' . $thumb_li_min_width . 'px;' . $opacity_style . '"><div style="width: ' . $thumb_div_width . 'px;"><a class="album" href="' . $item->link . '" ' . $target_html . '><img title="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" alt="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" src="' . $thumb . '"/></a>' . $title . '</div></li>';
				break;
			case true :
				$width = $params->get ( 'small_thumbs_width' );
				$height = $params->get ( 'small_thumbs_height' );
				return '<li style="width: ' . $layout_params->thumb_li_width . '%; height: ' . $thumb_li_height . 'px; min-width: ' . $thumb_li_min_width . 'px;' . $opacity_style . '"><div style="width: ' . $thumb_div_width . 'px;"><a class="album" href="' . $item->link . '" ' . $target_html . '><img title="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" alt="' . htmlspecialchars ( $item->title, ENT_QUOTES ) . '" src="' . $thumb . '" width=' . $width . ' height=' . $height . ' /></a>' . $title . '</div></li>';
				break;
		}
	}
	
	function getFormInputType($type) {
		
		global $option;
		
		if ($type == 'optional') {
			return '<img src="components/' . $option . '/images/default/icons/yellowled.png" alt="' . JTEXT::_ ( 'OPTIONAL' ) . '" title="' . JTEXT::_ ( 'OPTIONAL' ) . '" />';
		} elseif ($type == 'mandatory') {
			return '<img src="components/' . $option . '/images/default/icons/redled.png" alt="' . JTEXT::_ ( 'MANDATORY' ) . '" title="' . JTEXT::_ ( 'MANDATORY' ) . '" />';
		}
	}
	
	function prepareBreadcrumb($id, $title, &$cat_model = null) {
		global $mainframe, $Itemid, $option;
		
		if (is_null ( $cat_model )) {
			require_once (JPATH_ROOT . DS . 'components' . DS . $option . DS . 'models' . DS . 'category.php');
			$cat_model = new JWallpapersModelCategory ( );
		}
		
		
		$menu = &JSite::getMenu ();
		
		$menu_item_params = & $menu->getParams ( $Itemid );
		$view = JRequest::getVar ( 'view' );
		
		
		$show_title = 1;
		
		
		
		$show_last_path_item = 0;
		
		
		switch ($menu_item_params->get ( 'menu_item_type' )) {
			case 'jw_category' :
				
				$menu_item = & $menu->getItem ( $Itemid );
				if (preg_match ( '/id=(\d+)/m', $menu_item->link, $result )) {
					
					$menu_item_cat_id = $result [1];
					
					
					
					
					
					if ($menu_item_cat_id != $id) {
						$cat_path = $cat_model->getPath ( $id, $menu_item_cat_id );
					}
					
					switch ($view) {
						case 'picture' :
							
							
							$show_last_path_item = 1;
							break;
						case 'category' :
							if ($menu_item_cat_id == $id) {
								
								
								$show_title = 0;
							}
							break;
					}
				}
				break;
			case 'jw_main_gallery' :
				
				$cat_path = $cat_model->getPath ( $id );
				
				switch ($view) {
					case 'picture' :
						
						$show_last_path_item = 1;
						break;
				}
				break;
			case 'jw_picture' :
				break;
			case 'jw_special' :
				break;
			case 'jw_taggedpics' :
				break;
		}
		
		
		$pathway = & $mainframe->getPathway ();
		
		if (! empty ( $cat_path )) {
			$path_elements = count ( $cat_path );
			
			for($i = 0; $i < $path_elements; $i ++) {
				
				if ($i == $path_elements - 1 && ! $show_last_path_item) {
					break;
				}
				$pathLink = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $cat_path [$i]->slug . '&view=category' );
				$pathTitle = $cat_path [$i]->title;
				$pathway->addItem ( $pathTitle, $pathLink );
			}
		}
		
		if ($show_title) {
			$pathway->addItem ( $title );
		}
	
	}
	
	
	function &getSearchTagLayout($callbacks, &$params = null) {
		
		global $option, $mainframe;
		
		$document = & JFactory::getDocument ();
		
		if (empty ( $params )) {
			$component = JComponentHelper::getComponent ( $option );
			$params = new JParameter ( $component->params );
		}
		
		$ajax_tag_search_min_chars = ( int ) $params->get ( 'ajax_tag_search_min_chars' );
		$ajax_tag_search_min_time = ( int ) $params->get ( 'ajax_tag_search_min_time' );
		$ajax_tag_search_max_results = ( int ) $params->get ( 'ajax_tag_search_max_results' );
		
		
		if ($mainframe->isAdmin ()) {
			
			$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
			$id = $cid [0];
			$document->addScript ( 'components/' . $option . '/js/ajaxSearch.js' );
			$js .= 'var jw_ajax_tag_search = new ajaxSearch();
					jw_ajax_tag_search.url = "index.php?option=' . $option . '&controller=tags&task=ajaxSearchTag&id=' . $id . '&str=";
					jw_ajax_tag_search.anim = "<img src=\"../components/' . $option . '/images/ajax_loader/ajax-loader-cat-select.gif\" style=\"margin: 20px; padding-left: 10px;\"/>";';
		
		} else {
			$id = JRequest::getInt ( 'id', 0 );
			$document->addScript ( 'administrator/components/' . $option . '/js/ajaxSearch.js' );
			$js .= 'var jw_ajax_tag_search = new ajaxSearch();
					jw_ajax_tag_search.url = "index.php?option=' . $option . '&id=' . $id . '&task=ajaxSearchTag&str=";
					jw_ajax_tag_search.anim = "<img src=\"components/' . $option . '/images/ajax_loader/ajax-loader-cat-select.gif\" style=\"margin: 20px; padding-left: 10px;\"/>";';
		}
		
		$js .= 'jw_ajax_tag_search.min_chars = ' . $ajax_tag_search_min_chars . ';
		jw_ajax_tag_search.min_time = ' . $ajax_tag_search_min_time . ';
		jw_ajax_tag_search.search_result_xml_tag_name = "ajax_tag_search_result";
		jw_ajax_tag_search.search_result_container_id = "ajax_tag_search_result";
		jw_ajax_tag_search.callbacks = new Array(' . implode ( ',', $callbacks ) . ');
		
		window.addEvent(\'domready\',function() {
					$(\'ajax_tag_search\').addEvent(\'keyup\',function(event) {
					jw_ajax_tag_search.prepareSearchQuery(this.value);
					})});';
		
		$document->addScriptDeclaration ( $js );
		
		
		
		$layout = '<input autocomplete="off" type="text" id="ajax_tag_search" name="ajax_tag_search" value="" />';
		
		$layout .= '<br /><span class="ajax_search_note">' . JText::sprintf ( 'AJAX_TAG_SEARCH_NOTE', $ajax_tag_search_min_chars, $ajax_tag_search_max_results ) . '</span>';
		$layout .= '<div id="ajax_tag_search_result"></div>';
		
		return $layout;
	
	}
	
	
	
	function getUntagPicLayout(&$pic_tags, $pic_id) {
		
		global $option;
		
		$tag_list = array ();
		foreach ( $pic_tags as $pic_tag ) {
			$tag_list [] = '<a href="index.php?option=' . $option . '&controller=taggedpics&task=ajaxRemovePicTag&id=' . $pic_tag->id . '&' . JUtility::getToken () . '=1&pic_id=' . $pic_id . '" title="' . JText::_ ( 'CLICK_UNTAG_PIC' ) . '">' . $pic_tag->title . '</a>';
		}
		
		return implode ( ', ', $tag_list );
	
	}
	
	
	function getTagCloud(&$tags, $links) {
		
		$option = 'com_jwallpapers';
		
		
		
		
		
		
		
		
		
		
		

		
		
		

		$layout = array ();
		foreach ( $tags as $tag ) {
			
			
			
			
			
			
			
			
			

			
			
			$target_size = rand ( 0, 5 );
			
			if ($links) {
				
				
				
				$anchor_props = 'class="size' . $target_size . ' link" href="' . JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $tag->slug . '&Itemid=0' ) . '"';
			} else {
				$anchor_props = 'class="size' . $target_size . '"';
			}
			$layout [] = '<a ' . $anchor_props . '>' . $tag->title . '</a>';
		}
		
		$layout = implode ( ' ', $layout );
		
		return '<div class="jw_tag_cloud">' . $layout . '</div>';
	
	}
	
	
	function prepareDownloadOptions(&$picInfo, &$resizes, $include_original) {
		
		
		$resizeOptions4_3 = array ('<option disabled style="font-weight:bold;">4:3</option> ' );
		$resizeOptions16_10 = array ('<option disabled style="font-weight:bold;">16:10</option> ' );
		$resizeOptions16_9 = array ('<option disabled style="font-weight:bold;">16:9</option> ' );
		$resizeOptions5_4 = array ('<option disabled style="font-weight:bold;">5:4</option> ' );
		$resizeOptionsOther = array ('<option disabled style="font-weight:bold;">' . JText::_ ( 'SIZE_FORMAT_OTHER' ) . '</option> ' );
		
		if ($include_original) {
			
			switch ($picInfo->size_format) {
				case 0 :
					
					array_push ( $resizeOptions4_3, '<option value="id=' . $picInfo->id . '" selected="selected">&nbsp;' . $picInfo->width . 'x' . $picInfo->height . '</option>' );
					break;
				case 1 :
					
					array_push ( $resizeOptions16_10, '<option value="id=' . $picInfo->id . '" selected="selected">&nbsp;' . $picInfo->width . 'x' . $picInfo->height . '</option>' );
					break;
				case 2 :
					
					array_push ( $resizeOptions5_4, '<option value="id=' . $picInfo->id . '" selected="selected">&nbsp;' . $picInfo->width . 'x' . $picInfo->height . '</option>' );
					break;
				case 3 :
					
					array_push ( $resizeOptionsOther, '<option value="id=' . $picInfo->id . '" selected="selected">&nbsp;' . $picInfo->width . 'x' . $picInfo->height . '</option>' );
					break;
				case 4 :
					
					array_push ( $resizeOptions16_9, '<option value="id=' . $picInfo->id . '" selected="selected">&nbsp;' . $picInfo->width . 'x' . $picInfo->height . '</option>' );
					break;
			}
		}
		
		foreach ( $resizes as $resize ) {
			
			$width = $resize->width;
			$height = $resize->height;
			
			

			
			JWallpapersHelperImage::imageGenChk ( $picInfo, 'resize', $resize );
			
			$size_format = JWallpapersHelperImage::getSizeFormat ( $width, $height );
			switch ($size_format) {
				case 0 :
					
					array_push ( $resizeOptions4_3, '<option value="id=' . $picInfo->id . '&w=' . $width . '&h=' . $height . '">&nbsp;' . $width . 'x' . $height . '</option>' );
					break;
				case 1 :
					
					array_push ( $resizeOptions16_10, '<option value="id=' . $picInfo->id . '&w=' . $width . '&h=' . $height . '">&nbsp;' . $width . 'x' . $height . '</option>' );
					break;
				case 2 :
					
					array_push ( $resizeOptions5_4, '<option value="id=' . $picInfo->id . '&w=' . $width . '&h=' . $height . '">&nbsp;' . $width . 'x' . $height . '</option>' );
					break;
				case 3 :
					
					array_push ( $resizeOptionsOther, '<option value="id=' . $picInfo->id . '&w=' . $width . '&h=' . $height . '">&nbsp;' . $width . 'x' . $height . '</option>' );
					break;
				case 4 :
					
					array_push ( $resizeOptions16_9, '<option value="id=' . $picInfo->id . '&w=' . $width . '&h=' . $height . '">&nbsp;' . $width . 'x' . $height . '</option>' );
					break;
			
			}
		}
		
		return array_merge ( (count ( $resizeOptions4_3 ) == 1) ? array () : $resizeOptions4_3, (count ( $resizeOptions5_4 ) == 1) ? array () : $resizeOptions5_4, (count ( $resizeOptions16_10 ) == 1) ? array () : $resizeOptions16_10, (count ( $resizeOptions16_9 ) == 1) ? array () : $resizeOptions16_9, (count ( $resizeOptionsOther ) == 1) ? array () : $resizeOptionsOther );
	
	}
	
	
	function getGroupList($name, $selected_values) {
		
		if (! is_array ( $selected_values )) {
			$selected_values = explode ( ',', $selected_values );
		}
		
		
		$option_18 = '';
		$option_19 = '';
		$option_20 = '';
		$option_21 = '';
		$option_23 = '';
		$option_24 = '';
		$option_25 = '';
		$option_29 = '';
		$option_30 = '';
		
		foreach ( $selected_values as $selected_value ) {
			switch ($selected_value) {
				case 29 :
					$option_29 = 'selected="selected" ';
					break;
				case 18 :
					$option_18 = 'selected="selected" ';
					break;
				case 19 :
					$option_19 = 'selected="selected" ';
					break;
				case 20 :
					$option_20 = 'selected="selected" ';
					break;
				case 21 :
					$option_21 = 'selected="selected" ';
					break;
				case 30 :
					$option_30 = 'selected="selected" ';
					break;
				case 23 :
					$option_23 = 'selected="selected" ';
					break;
				case 24 :
					$option_24 = 'selected="selected" ';
					break;
				case 25 :
					$option_25 = 'selected="selected" ';
					break;
			}
		}
		
		$data = '<select multiple="multiple" class="inputbox" size="10" id="' . $name . '" name="' . $name . '[]">';
		$data .= '<option ' . $option_29 . 'value="29">  Public Front-end</option>';
		$data .= '<option ' . $option_18 . 'value="18">. - Registered</option>';
		$data .= '<option ' . $option_19 . 'value="19">.       - Author</option>';
		$data .= '<option ' . $option_20 . 'value="20">.             - Editor</option>';
		$data .= '<option ' . $option_21 . 'value="21">.                   - Publisher</option>';
		$data .= '<option ' . $option_30 . 'value="30">-  Public Back-end</option>';
		$data .= '<option ' . $option_23 . 'value="23">      - Manager</option>';
		$data .= '<option ' . $option_24 . 'value="24">            - Administrator</option>';
		$data .= '<option ' . $option_25 . 'value="25">                  - Super Administrator</option>';
		$data .= '</select>';
		
		return $data;
	
	}

}

?>