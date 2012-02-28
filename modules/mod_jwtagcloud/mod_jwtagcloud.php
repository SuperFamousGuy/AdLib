<?php
/**
 * JWallpapers next and previous module - A module to display the next and previous pictures based on the position and the category of the picture being displayed 
 * 
 * @version 1.0 $Id: mod_jwtagcloud.php 285 2010-04-21 08:03:35Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2010 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

global $option, $Itemid;

require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'layout.php');

JHTML::_ ( 'stylesheet', 'default.css', 'components/com_jwallpapers/css/' );

$language = & JFactory::getLanguage ();
$language->load ( 'com_jwallpapers' );

$db = & JFactory::getDBO ();


$target_new_window = ( int ) $params->get ( 'target_new_window', 0 );
$max_number_tags = ( int ) $params->get ( 'max_number_tags', 32 );
$tag_ordering = ( int ) $params->get ( 'tag_ordering', 0 );


switch ($tag_ordering) {
	default :
		$tag_ordering = 0;
	case 0 :
		
		$order_by = 'ORDER BY RAND()';
		break;
	case 1 :
		
		$order_by = 'ORDER BY date DESC';
		break;
	case 2 :
		
		$order_by = 'ORDER BY hits DESC';
		break;
	case 3 :
		
		$order_by = 'ORDER BY title ASC';
}


$query = 'SELECT id, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END AS slug, title FROM #__jwallpapers_tags WHERE published = 1 ' . $order_by . ' LIMIT ' . $max_number_tags;
$db->setQuery ( $query );
$tags = $db->loadObjectList ();

echo JWallpapersHelperLayout::getTagCloud ( $tags, true, false );