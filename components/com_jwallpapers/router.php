<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: router.php 310 2010-05-17 14:56:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

function JWallpapersBuildRoute(&$query) {
	
	global $mainframe;
	
	
	
	$option = 'com_jwallpapers';
	
	$segments = array ();
	$id = null;
	$view = null;
	
	if (isset ( $query ['view'] )) {
		
		
		
		
		
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$sef_picture = $params->get ( 'sef_picture' );
		$sef_category = $params->get ( 'sef_category' );
		$sef_special = $params->get ( 'sef_special' );
		$sef_submit = $params->get ( 'sef_submit' );
		
		switch ($query ['view']) {
			case 'picture' :
				$viewURL = $sef_picture;
				break;
			case 'category' :
				$viewURL = $sef_category;
				break;
			case 'special' :
				$viewURL = $sef_special;
				break;
			case 'submit' :
				$viewURL = $sef_submit;
				break;
			case 'taggedpics' :
				$viewURL = 'tagged-pictures';
				break;
			default :
				$viewURL = null;
				break;
		}
		
		if (! empty ( $viewURL )) {
			$segments [] = $viewURL;
		}
		
		if ($viewURL == $sef_picture) {
			
			$db = & JFactory::getDBO ();
			
			$picID = explode ( ':', $query ['id'] );
			$picID = ( int ) $picID [0];
			
			$dbQuery = 'SELECT #__jwallpapers_categories.alias FROM #__jwallpapers_categories INNER JOIN #__jwallpapers_files ON #__jwallpapers_categories.id = #__jwallpapers_files.cat_id WHERE #__jwallpapers_files.id = ' . $picID;
			
			$db->setQuery ( $dbQuery );
			
			
			$catName = $db->loadResult ();
			
			
			
			

			
			$segments [] = $catName;
		
		}
		
		$view = $query ['view'];
		unset ( $query ['view'] );
	
	} else {
		
		
		return $segments;
	}
	
	if (isset ( $query ['id'] )) {
		$segments [] = $query ['id'];
		
		$id = $query ['id'];
		unset ( $query ['id'] );
	}
	
	return $segments;
}

function JWallpapersParseRoute($segments) {
	
	
	

	
	$option = JRequest::getVar ( 'option', 'com_jwallpapers' );
	
	
	$component = JComponentHelper::getComponent ( $option );
	$params = new JParameter ( $component->params );
	$sef_picture = $params->get ( 'sef_picture' );
	$sef_category = $params->get ( 'sef_category' );
	$sef_special = $params->get ( 'sef_special' );
	$sef_submit = $params->get ( 'sef_submit' );
	
	$vars = array ();
	
	
	
	
	$segments [0] = str_replace ( '-', ':', $segments [0] );
	
	switch ($segments [0]) {
		case $sef_special :
			$vars ['view'] = 'special';
			$id = explode ( ':', $segments [1] );
			$vars ['id'] = ( int ) $id [0];
			break;
		case $sef_submit :
			$vars ['view'] = 'submit';
			break;
		case $sef_category :
			$vars ['view'] = 'category';
			$id = explode ( ':', $segments [1] );
			$vars ['id'] = ( int ) $id [0];
			break;
		case $sef_picture :
			$vars ['view'] = 'picture';
			$id = explode ( ':', $segments [2] );
			$vars ['id'] = ( int ) $id [0];
			break;
		case 'tagged:pictures':
			$vars['view'] = 'taggedpics';
			$vars['id'] = (int) $segments[1];
			break;
	}
	
	return $vars;
}

?>