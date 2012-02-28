<?php
/**
 * sh404SEF support for com_jwallpapers component.
 * @version 1.3 $Id: com_jwallpapers.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Direct Access to this location is not allowed.' );


global $sh_LANG, $sefConfig;
$shLangName = '';
$shLangIso = '';
$title = array ();
$shItemidString = '';
$dosef = shInitializePlugin ( $lang, $shLangName, $shLangIso, $option );
if ($dosef == false)
	return;
	



$no_sef_url_tasks = array ('ajaxGetCat', 'vote', 'refreshCaptcha', 'checkCaptcha', 'ajaxGetImageUrl', 'download', 'tag_untag_ep', 'ajaxSearchTag', 'ajaxTagPicture', 'ajaxRefreshPicTagsLayout' );
if (isset ( $task ) && in_array ( $task, $no_sef_url_tasks )) {
	$dosef = false;
	return;
}




if (isset ( $format ) && $format == 'raw') {
	$dosef = false;
	return;
}




$params = & JComponentHelper::getParams ( 'com_jwallpapers' );


if (! isset ( $limit )) {
	$thumb_columns = $params->get ( 'thumbs_columns' );
	$thumb_lines = $params->get ( 'thumbs_lines' );
	$limit = $thumb_columns * $thumb_lines;
	
	shAddToGETVarsList ( 'limit', $limit );
}


shRemoveFromGETVarsList ( 'option' );
shRemoveFromGETVarsList ( 'lang' );
shRemoveFromGETVarsList ( 'view' );
shRemoveFromGETVarsList ( 'id' );
if (! empty ( $limit )) {
	shRemoveFromGETVarsList ( 'limit' );
}
if (isset ( $limitstart )) {
	shRemoveFromGETVarsList ( 'limitstart' );
}


$id = isset ( $id ) ? $id : null;
$view = isset ( $view ) ? $view : null;
$Itemid = isset ( $Itemid ) ? $Itemid : null;


$db = & JFactory::getDBO ();


$item_id_set = 1;
if (! isset ( $Itemid )) {
	
	
	
	
	global $Itemid;
	
	$item_id_set = 0;

}









$query = 'SELECT t1.name, t1.parent FROM #__menu AS t1 INNER JOIN #__components AS t2 ON t1.componentid = t2.id WHERE t1.id = ' . ( int ) $Itemid . ' AND t2.option = \'com_jwallpapers\'';
$db->setQuery ( $query );
$result = $db->loadObject ();



if (! empty ( $result )) {
	
	
	
	
	shAddToGETVarsList ( 'Itemid', $Itemid );
	
	shRemoveFromGETVarsList ( 'Itemid' );
}

$names = array ($result->name );

while ( $result->parent ) {
	$query = 'SELECT name, parent FROM #__menu WHERE id = ' . $result->parent;
	$db->setQuery ( $query );
	$result = $db->loadObject ();
	$names [] = $result->name;
}


$names = array_reverse ( $names );

foreach ( $names as $name ) {
	
	$title [] = strtolower ( $name );
}

switch ($view) {
	case 'category' :
		
		
		$title [] = str_replace ( ':', '-', $params->get ( 'sef_category' ) );
		
		$query = 'SELECT CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\'-\', id, alias) ELSE id END AS slug FROM #__jwallpapers_categories WHERE id = ' . ( int ) $id;
		$db->setQuery ( $query );
		$slug = $db->loadResult ();
		$title [] = $slug;
		
		break;
	case 'picture' :
		
		
		
		$menu = & JSite::getMenu ();
		$menu_params = & $menu->getParams ( $Itemid );
		if ($menu_params->get ( 'menu_item_type' ) != 'jw_picture') {
			
			$title [] = str_replace ( ':', '-', $params->get ( 'sef_picture' ) );
			
			$picID = explode ( ':', $id );
			$picID = ( int ) $picID [0];
			$query = 'SELECT alias FROM #__jwallpapers_categories WHERE id = (SELECT cat_id FROM #__jwallpapers_files WHERE id = ' . $picID . ')';
			$db->setQuery ( $query );
			$catName = $db->loadResult ();
			$title [] = $catName;
			
			$query = 'SELECT CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\'-\', id, alias) ELSE id END AS slug FROM #__jwallpapers_files WHERE id = ' . ( int ) $id;
			$db->setQuery ( $query );
			$slug = $db->loadResult ();
			$title [] = $slug;
		}
		break;
	
	case 'special' :
		
		
		

		
		
		if (! $item_id_set) {
			
			$title [] = str_replace ( ':', '-', $params->get ( 'sef_special' ) );
			
			$language = & JFactory::getLanguage ();
			$language->load ( 'com_jwallpapers' );
			
			switch ($id) {
				default :
					$id = '1';
				case '1' :
					$slug = '1-' . strtolower ( JText::_ ( 'BEST_RATED' ) );
					break;
				case '2' :
					$slug = '2-' . strtolower ( JText::_ ( 'NEWEST' ) );
					break;
				case '3' :
					$slug = '3';
					break;
				case '4' :
					$slug = '4-' . strtolower ( JText::_ ( 'MOST_VIEWED' ) );
					break;
				case '5' :
					$slug = '5-' . strtolower ( JText::_ ( 'EDITORS_PICKS' ) );
			}
			
			
			$title [] = $slug;
		}
		break;
	case 'submit' :
		
		$title [] = str_replace ( ':', '-', $params->get ( 'sef_submit' ) );
		break;
	case 'taggedpics' :
		if ($Itemid == 0) {
			$title [] = 'tagged-pictures';
			$title [] = $id;
		}
		break;
	default :
		
		
		break;

}


if ($dosef) {
	$string = shFinalizePlugin ( $string, $title, $shAppendString, $shItemidString, (isset ( $limit ) ? @$limit : null), (isset ( $limitstart ) ? @$limitstart : null), (isset ( $shLangName ) ? @$shLangName : null) );
}



?>
