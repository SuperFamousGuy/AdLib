<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 244 2010-03-26 17:22:21Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.view' );

class JWallpapersViewTaggedPics extends JView {
	
	function display($tpl = null) {
		
		global $mainframe, $option, $Itemid;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'components/' . $option . '/css/' );
		
		
		$model = & $this->getModel ();
		$document = & JFactory::getDocument ();
		
		$id = JRequest::getInt ( 'id', 0 );
		
		if (! $id) {
			die ( 'Tag pictures: the provided tag id is invalid' );
		}
		
		
		
		$show_nav_url = '';
		
		
		
		
		
		
		$params = & JComponentHelper::getParams ( $option );
		
		$picList = $model->getPicsInfo ();
		
		
		$tag_row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		$tag_row->load ( $id );
		
		
		
		if (! $Itemid) {
			$headString = JText::_ ( 'TAG_MATCHING_PICS' ) . ' ' . $tag_row->title;
			$document->setTitle ( JText::_ ( 'TAGGED_PICS' ) );
		} else {
			$headString = $document->title;
		}
		
		
		
		if ($Itemid && $params->get ( 'menu_item_type' ) != 'jw_taggedpics') {
			
			
			
			
			
			$show_nav_url = '&show_nav=0';
		}
		$this->prepareOrderByLinks ( $params, $id, $show_nav_url );
		
		$pageNav = $model->getPagination ();
		
		
		$this->prepareLayoutParams ( $params );
		
		
		$show_credits = $params->get ( 'show_credits', 1 );
		
		
		for($i = 0; $i < count ( $picList ); $i ++) {
			$row = & $picList [$i]; 
			$row->link = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $row->slug . '&view=picture' . $show_nav_url ); 
			if ($row->rating == null) {
				$row->rating = 0;
			}
		}
		
		
		

		
		
		
		
		
		
		
		
		
		
		

		$this->preparePageClassSuffixes ( $params );
		
		
		
		
		$this->assign ( 'show_credits', $show_credits );
		$this->assignRef ( 'pageNav', $pageNav );
		$this->assignRef ( 'pics', $picList );
		$this->assign ( 'headString', $headString );
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
	
	
	function prepareOrderByLinks(&$params, $id, $show_nav_url) {
		
		global $option;
		
		
		$show_order_thumbs_by_bar = $params->get ( 'show_order_thumbs_by_bar', 1 );
		if (! $show_order_thumbs_by_bar) {
			
			return;
		}
		
		
		
		$default_order_thumbs_by = $params->get ( 'default_order_thumbs_by', 'id' );
		$order = JRequest::getVar ( 'order', $default_order_thumbs_by );
		
		$title_link = JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $id . '&order=title' . $show_nav_url );
		$newest_first_link = JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $id . '&order=date_desc' . $show_nav_url );
		$newest_last_link = JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $id . '&order=date_asc' . $show_nav_url );
		$best_rated_link = JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $id . '&order=rating_desc' . $show_nav_url );
		$most_viewed_link = JRoute::_ ( 'index.php?option=' . $option . '&view=taggedpics&id=' . $id . '&order=hits_desc' . $show_nav_url );
		
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
	
	
	function prepareLayoutParams(&$params) {
		
		$layout_params = new stdClass ( );
		
		$thumbs_wrapper_height_mod = ( int ) abs ( $params->get ( 'thumbs_wrapper_height_mod', 90 ) );
		$thumbs_wrapper_width_mod = ( int ) abs ( $params->get ( 'thumbs_wrapper_width_mod', 14 ) );
		$thumbs_columns = ( int ) $params->get ( 'thumbs_columns' );
		
		
		$layout_params->thumb_li_width = floor ( 100 / $thumbs_columns );
		
		
		$layout_params->thumb_li_height = ( int ) $params->get ( 'small_thumbs_height' ) + $thumbs_wrapper_height_mod;
		
		
		$layout_params->thumb_div_width = ( int ) $params->get ( 'small_thumbs_width' ) + $thumbs_wrapper_width_mod;
		
		
		$layout_params->thumbs_title_max_length = ( int ) abs ( $params->get ( 'thumbs_title_max_length', 45 ) );
		
		
		$layout_params->show_thumb_info = ( int ) $params->get ( 'show_thumb_info' );
		
		
		$layout_params->show_thumb_title = ( int ) $params->get ( 'show_thumb_title' );
		
		
		$layout_params->target_window = 'current';
		
		
		$this->assignRef ( 'layout_params', $layout_params );
	
	}

}
?>