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
* @Author: Filu.pl , modified by Skorp
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
   $descr= "Bookmark Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if ($runMe)
{

	if (($loadWord)||($loadKey))
	{
		//bookmarks
		$database->setQuery("SELECT keywords,description FROM #__bookmarks WHERE published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->description;
				}
				if ($loadKey) $metaKey.= ",".$row->keywords;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
		
	
	}
}


?>
