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
   $descr= "Joomla Remository Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if ($runMe)
{

	if (($loadWord)||($loadKey))
	{
		//files
		$database->setQuery("SELECT keywords,filetitle,description,smalldesc FROM #__downloads_files WHERE published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->filetitle;
					$stag.= " ".$row->description;
					$stag.= " ".$row->smalldesc;
				}
				if ($loadKey) $metaKey.= ",".$row->keywords;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
		//containers
		$database->setQuery("SELECT windowtitle,name,description,keywords FROM #__downloads_containers WHERE published=1");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->windowtitle;
					$stag.= " ".$row->name;
					$stag.= " ".$row->description;
				}
				if ($loadKey) $metaKey.= ",".$row->keywords;
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}
	if ($loadWord)	
	{
		//reviews
		$database->setQuery("SELECT comment,title FROM #__downloads_reviews");
		if ($cur = $database->query()) {
			while ($row = mysql_fetch_object( $cur )) {
				if ($loadWord)
				{
					$stag.= " ".$row->title;
					$stag.= " ".$row->comment;
				}
				if ($this->cacheTag($stag,$metaKey)) 		{$stag=null; $metaKey=null;}
			}
		}
	}
}


?>
