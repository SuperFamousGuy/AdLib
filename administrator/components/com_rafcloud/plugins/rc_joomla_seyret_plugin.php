<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
$descr= "Joomla Seyret Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 
if ($runMe)
{
	if (($loadWord)||($loadKey))
	{
		$database->setQuery("SELECT title,itemcomment,videotags FROM #__seyret_items WHERE published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->title;
					$stag.= " ".$row->itemcomment;
				}
				if ($loadKey) $metaKey.= ",".$row->videotags;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}

	if ($loadWord)
	{
		$database->setQuery("SELECT categoryname,categoryinfo FROM #__seyret_categories");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				$stag.= " ".$row->categoryname;
				$stag.= " ".$row->categoryinfo;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}
}
?>