<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 327 2010-05-25 22:44:43Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.view' );

class JWallpapersViewHome extends JView {
	
	function display($tpl = null) {
		
		
		global $option, $mainframe;
		
		$user = & JFactory::getUser ();
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'components/' . $option . '/css/' );
		
		
		$model = & $this->getModel ();
		$picList = $model->getAllPics ();
		$pageNav = $model->getPagination ();
		
		
		
		
		
		
		$params = & JComponentHelper::getParams ( $option );
		$thumbs_area_width = ( int ) $params->get ( 'thumbs_area_width' );
		
		
		$this->prepareLayoutParams ( $params );
		
		
		
		if ($params->get ( 'show_category_list' )) {
			$right_area_width = 100 - $thumbs_area_width;
			
			$mainCategoryList = $model->getMainCategories ();
			
			
			for($i = 0; $i < count ( $mainCategoryList ); $i ++) {
				$row = & $mainCategoryList [$i];
				$row->link = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $row->slug . '&view=category' );
			}
			
			$this->assignRef ( 'mainCategories', $mainCategoryList );
		
		} else {
			$right_area_width = 0;
			$thumbs_area_width = 100;
		}
		
		
		$display_mode = $params->get ( 'display_mode' );
		
		
		$show_credits = $params->get ( 'show_credits', 1 );
		
		
		switch ($display_mode) {
			default :
				$display_mode = 0;
			case 0 :
				
				
				$this->addLinks ( $picList, 'cats' );
				break;
			case 1 :
				
				
				$this->addLinks ( $picList );
				break;
		}
		
		
		
		
		

		
		

		
		
		
		
		
		$document = & JFactory::getDocument ();
		
		
		
		
		
		

		
		$this->prepareOrderByLinks ( $params );
		
		
		$this->prepareSubmitLink ( $params, $model );
		
		$this->preparePageClassSuffixes ( $params );
		
		
		
		
		$this->assign ( 'show_credits', $show_credits );
		$this->assignRef ( 'pageNav', $pageNav );
		$this->assignRef ( 'pics', $picList );
		$this->assign ( 'right_area_width', $right_area_width );
		$this->assign ( 'thumbs_area_width', $thumbs_area_width );
		$this->assign ( 'user_id', $user->id );
		$this->assignRef ( 'params', $params );
		
		
		parent::display ( $tpl );
	}
	
	
	function preparePageClassSuffixes(&$params) {
		
		
		$page_class_suffix = $this->escape ( $params->get ( 'pageclass_sfx' ) );
		If (! empty ( $page_class_suffix )) {
			$class_suffix = $page_class_suffix;
			
			$id_class = 'class="' . $page_class_suffix . '"';
		} else {
			$class_suffix = '';
			$id_class = '';
		}
		
		$this->assign ( 'class_suffix', $class_suffix );
		$this->assign ( 'id_class', $id_class );
	
	}
	
	
	function prepareSubmitLink(&$params, &$model) {
		
		$cats = $model->getMainCategories ();
		$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();
		$uploadable_cats_exist = 0;
		
		$frontend_category_proposal = $params->get ( 'frontend_category_proposal' );
		
		
		
		if (! $frontend_category_proposal) {
			
			
			foreach ( $cats as $cat ) {
				
				if ($cat->frontend_uploads_en) {
					
					if (! in_array ( $user_aro_gid, explode ( ',', $cat->uploads_deny_acl ) )) {
						$uploadable_cats_exist = 1;
						break;
					}
				}
			}
		}
		
		
		if ($params->get ( 'enable_uploads' ) && ($uploadable_cats_exist || $frontend_category_proposal)) {
			$submit_picture_layout = '<div class="submit_picture_link"><a href="' . JRoute::_ ( 'index.php?option=' . $option . '&view=submit' ) . '">' . JTEXT::_ ( 'SUBMIT_PICTURE' ) . '</a></div>';
			$this->assign ( 'submit_picture_layout', $submit_picture_layout );
		}
	
	}
	
	
	function prepareLayoutParams(&$params) {
		
		$pic_layout_params = new stdClass ( );
		
		$thumbs_wrapper_height_mod = ( int ) abs ( $params->get ( 'thumbs_wrapper_height_mod', 90 ) );
		$thumbs_wrapper_width_mod = ( int ) abs ( $params->get ( 'thumbs_wrapper_width_mod', 14 ) );
		$thumbs_columns = ( int ) $params->get ( 'thumbs_columns' );
		
		
		$pic_layout_params->thumb_li_width = floor ( 100 / $thumbs_columns );
		
		
		$pic_layout_params->thumb_li_height = ( int ) $params->get ( 'small_thumbs_height' ) + $thumbs_wrapper_height_mod;
		
		
		$pic_layout_params->thumb_div_width = ( int ) $params->get ( 'small_thumbs_width' ) + $thumbs_wrapper_width_mod;
		
		
		$pic_layout_params->thumbs_title_max_length = ( int ) abs ( $params->get ( 'thumbs_title_max_length', 45 ) );
		
		
		$pic_layout_params->show_thumb_info = ( int ) $params->get ( 'show_thumb_info' );
		
		
		$pic_layout_params->show_thumb_title = ( int ) $params->get ( 'show_pic_thumb_title' );
		
		
		$pic_layout_params->target_window = 'current';
		
		
		$this->assignRef ( 'pic_layout_params', $pic_layout_params );
		
		
		$cat_layout_params = clone ($pic_layout_params);
		
		
		$cat_layout_params->show_thumb_title = ( int ) $params->get ( 'show_cat_thumb_title' );
		
		
		$this->assignRef ( 'cat_layout_params', $cat_layout_params );
	
	}
	
	
	function prepareOrderByLinks(&$params) {
		
		global $option;
		
		
		$show_order_thumbs_by_bar = $params->get ( 'show_order_thumbs_by_bar', 1 );
		if (! $show_order_thumbs_by_bar) {
			
			return;
		}
		
		
		
		$default_order_thumbs_by = $params->get ( 'default_order_thumbs_by', 'id' );
		$order = JRequest::getVar ( 'order', $default_order_thumbs_by );
		
		$title_link = JRoute::_ ( 'index.php?option=' . $option . '&view=home&order=title' );
		$newest_first_link = JRoute::_ ( 'index.php?option=' . $option . '&view=home&order=date_desc' );
		$newest_last_link = JRoute::_ ( 'index.php?option=' . $option . '&view=home&order=date_asc' );
		$best_rated_link = JRoute::_ ( 'index.php?option=' . $option . '&view=home&order=rating_desc' );
		$most_viewed_link = JRoute::_ ( 'index.php?option=' . $option . '&view=home&order=hits_desc' );
		
		$this->assign ( 'title_link', '<a href="' . $title_link . '" title="' . JText::_ ( 'ORDER_BY' ) . ' ...">' . JText::_ ( 'TITLE' ) . '</a> | ' );
		$this->assign ( 'newest_first_link', '<a href="' . $newest_first_link . '" title="' . JText::_ ( 'ORDER_BY' ) . ' ...">' . JText::_ ( 'NEWEST' ) . ' ' . JText::_ ( 'FIRST' ) . '</a> | ' );
		$this->assign ( 'newest_last_link', '<a href="' . $newest_last_link . '" title="' . JText::_ ( 'ORDER_BY' ) . ' ...">' . JText::_ ( 'NEWEST' ) . ' ' . JText::_ ( 'LAST' ) . '</a> | ' );
		$this->assign ( 'best_rated_link', '<a href="' . $best_rated_link . '" title="' . JText::_ ( 'ORDER_BY' ) . ' ...">' . JText::_ ( 'BEST_RATED' ) . '</a> | ' );
		$this->assign ( 'most_viewed_link', '<a href="' . $most_viewed_link . '" title="' . JText::_ ( 'ORDER_BY' ) . ' ...">' . JText::_ ( 'MOST_VIEWED' ) . '</a>' );
		
		
		switch ($order) {
			case 'title' :
				$this->title_link = '<b>' . $this->title_link . '</b>';
				break;
			case 'date_asc' :
				$this->newest_last_link = '<b>' . $this->newest_last_link . '</b>';
				break;
			case 'date_desc' :
				$this->newest_first_link = '<b>' . $this->newest_first_link . '</b>';
				break;
			case 'rating_desc' :
				$this->best_rated_link = '<b>' . $this->best_rated_link . '</b>';
				break;
			case 'hits_desc' :
				$this->most_viewed_link = '<b>' . $this->most_viewed_link . '</b>';
				break;
		}
	
	}
	
	
	function addLinks(&$items, $type = 'pics') {
		
		global $option;
		
		for($i = 0; $i < count ( $items ); $i ++) {
			$row = & $items [$i];
			switch ($type) {
				case 'pics' :
					$row->link = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $row->slug . '&view=picture' );
					if ($row->rating == null) {
						$row->rating = 0;
					}
					break;
				case 'cats' :
					$row->link = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $row->slug . '&view=category' );
					break;
			}
		
		}
	
	}

}
?>