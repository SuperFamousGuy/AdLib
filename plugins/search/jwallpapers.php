<?php
/**
 * JWallpapers Search Plugin - A plugin for searching JWallpapers pictures
 * 
 * @version 1.1 $Id: jwallpapers.php 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.plugin.plugin' );

class plgSearchJWallpapers extends JPlugin {
	
	function onSearchAreas($value = '') {
		
		$language = & JFactory::getLanguage ();
		$language->load ( 'com_jwallpapers' );
		$areas = array ('pictures' => JText::_ ( 'PICTURES' ) );
		return $areas;
	
	}
	
	function onSearch($text, $phrase = '', $ordering = '', $areas = null) {
		
		if (! $text) {
			return array ();
		} elseif (is_array ( $areas )) {
			if (! array_intersect ( $areas, array_keys ( $this->onSearchAreas () ) )) {
				return array ();
			}
		}
		
		$db = & JFactory::getDBO ();
		
		if ($phrase == 'exact') {
			$where = "(t1.title LIKE '%{$text}%') OR (t1.keywords LIKE '%{$text}%') OR (t3.title LIKE '{$text}%')";
		} else {
			$words = explode ( ' ', $text );
			$wheres = array ();
			foreach ( $words as $word ) {
				$wheres [] = "(t1.title LIKE '%{$word}%') OR (t1.keywords LIKE '%{$word}%') OR (t3.title LIKE '{$text}%')";
			}
			if ($phrase == 'all') {
				$separator = 'AND';
			} else {
				$separator = 'OR';
			}
			$where = '(' . implode ( ') ' . $separator . ' (', $wheres ) . ')';
			$where .= ' AND t1.published = 1';
		}
		
		switch ($ordering) {
			case 'oldest' :
				$order = 't1.upload_date ASC';
				break;
			case 'alpha' :
				$order = 't1.title ASC';
				break;
			case 'newest' :
			default :
				$order = 't1.title DESC';
				break;
		}
		
		$plugin = & JPluginHelper::getPlugin ( 'search', 'jwallpapers' );
		$pluginParams = new JParameter ( $plugin->params );
		
		$query = 'SELECT DISTINCT t1.title, t1.description AS text, t1.upload_date AS created, CONCAT(\'index.php?option=com_jwallpapers&view=picture&id=\',t1.id) AS href, \'2\' AS browsernav FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_tagged_files AS t2 ON t1.id = t2.file_id LEFT JOIN #__jwallpapers_tags AS t3 ON t3.id = t2.tag_id WHERE ' . $where . ' ORDER BY ' . $order;
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	
	}

}

