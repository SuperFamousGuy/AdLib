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
   $descr= "Joomla Mosets Tree Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if ($runMe)
{

	if (($loadWord)||($loadKey))
	{
		$database->setQuery("SELECT cat_desc,metakey,metadesc FROM #__mt_cats WHERE cat_published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->cat_desc;
					$stag.= " ".$row->metadesc;
				}
				if ($loadKey) $metaKey.= ",".$row->metakey;
				if ($this->cacheTag($stag,$metaKey)) unset($stag,$metaKey);
			}
		}
		$database->setQuery("SELECT link_name,link_desc,metakey,metadesc FROM #__mt_links WHERE link_published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->link_name;
					$stag.= " ".$row->link_desc;
					$stag.= " ".$row->metadesc;
				}
				if ($loadKey) $metaKey.= ",".$row->metakey;
				if ($this->cacheTag($stag,$metaKey)) unset($stag,$metaKey);
			}
		}
	}
}


?>
