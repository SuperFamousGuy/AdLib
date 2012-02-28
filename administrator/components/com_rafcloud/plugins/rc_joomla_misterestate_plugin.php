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
   $descr= "Joomla MisterEstate Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if ($runMe)
{

	if (($loadWord)||($loadKey))
	{
		$database->setQuery("SELECT * FROM #__misterestate WHERE publish=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->title;
					$stag.= " ".$row->description;
					$stag.= " ".$row->location;
					$stag.= " ".$row->condition;
					$stag.= " ".$row->other;
					$stag.= " ".$row->town;
					$stag.= " ".$row->metadesc;
				}
				if ($loadKey) $metaKey.= ",".$row->metakey;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}
	if ($loadWord)	
	{
		//categories
		$database->setQuery("SELECT name,description FROM #__misterestate_categories");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				$stag.= " ".$row->name;
				$stag.= " ".$row->description;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}
}


?>
