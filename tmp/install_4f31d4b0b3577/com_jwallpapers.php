<?php
/**
 * @author Arunas Mazeika http://www.wextend.com
 * @copyright Copyright (C) 2009 Arunas Mazeika - All rights reserved
 * @email jwallpapers@wextend.com
 * @version com_jwallpapers.php v1.1.0 $Id: com_jwallpapers.php 363 2010-06-03 12:30:08Z amazeika $
 * @package Xmap
 * @license GNU/GPL
 * @description Xmap plugin for JWallpapers component
 */

defined ( '_JEXEC' ) or die ( 'Restricted access.' );

class xmap_com_jwallpapers {
	
	function getTree(&$xmap, &$parent, &$params) {
		if (strpos ( $parent->link, 'func=fileinfo' )) {
			return $list;
		}
		
		$link_query = parse_url ( $parent->link );
		parse_str ( html_entity_decode ( $link_query ['query'] ), $link_vars );
		$catid = JArrayHelper::getValue ( $link_vars, 'id', 0 );
		
		$include_files = JArrayHelper::getValue ( $params, 'include_files', 1, '' );
		$include_files = ($include_files == 1 || ($include_files == 2 && $xmap->view == 'xml') || ($include_files == 3 && $xmap->view == 'html'));
		$params ['include_files'] = $include_files;
		
		$priority = JArrayHelper::getValue ( $params, 'cat_priority', $parent->priority, '' );
		$changefreq = JArrayHelper::getValue ( $params, 'cat_changefreq', $parent->changefreq, '' );
		if ($priority == '-1')
			$priority = $parent->priority;
		if ($changefreq == '-1')
			$changefreq = $parent->changefreq;
		
		$params ['cat_priority'] = $priority;
		$params ['cat_changefreq'] = $changefreq;
		
		$priority = JArrayHelper::getValue ( $params, 'file_priority', $parent->priority, '' );
		$changefreq = JArrayHelper::getValue ( $params, 'file_changefreq', $parent->changefreq, '' );
		if ($priority == '-1')
			$priority = $parent->priority;
		
		if ($changefreq == '-1')
			$changefreq = $parent->changefreq;
		
		$params ['file_priority'] = $priority;
		$params ['file_changefreq'] = $changefreq;
		
		if ($include_files) {
			$params ['limit'] = '';
			$params ['days'] = '';
			$limit = JArrayHelper::getValue ( $params, 'max_files', '', '' );
			
			if (intval ( $limit ))
				$params ['limit'] = ' LIMIT ' . $limit;
			
			$days = JArrayHelper::getValue ( $params, 'max_age', '', '' );
			if (intval ( $days ))
				$params ['days'] = ' AND upload_date >= \'' . date ( 'Y-m-d H:m:s', ($xmap->now - ($days * 86400)) ) . "' ";
		}
		
		
		$menu = & JSite::getMenu ();
		$menu_item_params = & $menu->getParams ( ( int ) $parent->id );
		$menu_item_type = $menu_item_params->get ( 'menu_item_type' );
		
		switch ($menu_item_type) {
			case 'jw_category' :
				$menu_item = & $menu->getItem ( ( int ) $parent->id );
				if (preg_match ( '/id=(\d+)/', $menu_item->link, $result )) {
					xmap_com_jwallpapers::getJWallpapersTree ( $xmap, $parent, $params, ( int ) $result [1] );
				}
				break;
			case 'jw_main_gallery' :
				xmap_com_jwallpapers::getJWallpapersTree ( $xmap, $parent, $params, 0 );
				break;
		}
	}
	
	function getJWallpapersTree(&$xmap, &$parent, &$params, $catid) {
		$db = JFactory::getDBO ();
		
		$db->setQuery ( "select id, title, alias, parent_id from #__jwallpapers_categories where parent_id=$catid and published = '1' order by title" );
		$cats = $db->loadObjectList ();
		$xmap->changeLevel ( 1 );
		foreach ( $cats as $cat ) {
			$node = new stdclass ( );
			$node->id = $parent->id;
			$node->uid = $parent->uid . 'c' . $cat->id;
			$node->pid = $cat->parent_id;
			$node->name = $cat->title;
			$node->priority = $params ['cat_priority'];
			$node->changefreq = $params ['cat_changefreq'];
			$node->link = 'index.php?option=com_jwallpapers&amp;view=category&amp;id=' . $cat->id . "-" . $cat->alias;
			$node->tree = array ();
			
			if ($xmap->printNode ( $node ) !== FALSE) {
				xmap_com_jwallpapers::getJWallpapersTree ( $xmap, $parent, $params, $cat->id );
			}
		}
		
		if ($params ['include_files']) {
			
			$db->setQuery ( "select id, title, alias from #__jwallpapers_files where cat_id=$catid and published = '1' " . $params ['days'] . " order by title " . $params ['limit'] );
			$pics = $db->loadObjectList ();
			foreach ( $pics as $pic ) {
				$node = new stdclass ( );
				$node->id = $parent->id;
				$node->uid = $parent->uid . 'd' . $pic->id;
				$node->name = $pic->title;
				$node->link = 'index.php?option=com_jwallpapers&amp;view=picture&amp;id=' . $pic->id . "-" . $pic->alias;
				$node->priority = $params ['file_priority'];
				$node->changefreq = $params ['file_changefreq'];
				$node->tree = array ();
				$xmap->printNode ( $node );
			}
		}
		$xmap->changeLevel ( - 1 );
	}

}
