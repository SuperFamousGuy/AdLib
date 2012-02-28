<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
	$descr= "Joomla Content Keywords Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if (($runMe)&&($loadKey))
{
	//content
	$database->setQuery("SELECT metakey FROM #__content WHERE state=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$metaKey.= ",".$row->metakey;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}
}
/*
//under construction

if (($runSearch)&&(!empty($search)))
{
	$nullDate 	= $database->getNullDate();
	$now 		= _CURRENT_SERVER_TIME;
	$order = 'a.created ASC';
	echo($row->metakey."<br>");
	$where= "LOWER(a.metakey) LIKE LOWER('%".$row->metakey."%')";
	$query = "SELECT a.title AS title,"
	. "\n a.created AS created,"
	. "\n CONCAT(a.introtext, a.fulltext) AS text,"
	. "\n CONCAT_WS( '/', u.title, b.title ) AS section,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.id ) AS href,"
	. "\n '2' AS browsernav,"
	. "\n 'content' AS type"
 	. "\n, u.id AS sec_id, b.id as cat_id"
 	. "\n FROM #__content AS a"
	. "\n INNER JOIN #__categories AS b ON b.id=a.catid"
	. "\n INNER JOIN #__sections AS u ON u.id = a.sectionid"
	. "\n WHERE ( $where )"
	. "\n AND a.state = 1"
	. "\n AND u.published = 1"
	. "\n AND b.published = 1"
	. "\n AND a.access <= " . (int) $my->gid
	. "\n AND b.access <= " . (int) $my->gid
	. "\n AND u.access <= " . (int) $my->gid
	. "\n AND ( a.publish_up = " . $database->Quote( $nullDate ) . " OR a.publish_up <= " . $database->Quote( $now ) . " )"
	. "\n AND ( a.publish_down = " . $database->Quote( $nullDate ) . " OR a.publish_down >= " . $database->Quote( $now ) . " )"
	. "\n GROUP BY a.id"
	. "\n ORDER BY $order";

	//$database->setQuery("SELECT metakey FROM #__content WHERE metakey LIKE '%".$search."%'");
	//if ($cur = $database->query()) 
	//{
		//while ($row = mysql_fetch_object( $cur )) 
		//{
	$limit=10;
	$database->setQuery( $query, 0, $limit );
	$results = $database->loadObjectList();

	//	}
	//}

} */

?>