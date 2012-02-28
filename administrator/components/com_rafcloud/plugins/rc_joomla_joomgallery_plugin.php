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
$descr= "Joomla JoomGallery Plugin v 3.0"; //short information about plugin

$database = &JFactory::getDBO(); 

if (($runMe)&&($loadWord))
{
	//photo
	$database->setQuery("SELECT imgtitle,imgtext FROM #__joomgallery WHERE approved=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->imgtitle;
			$stag.= " ".$row->imgtext;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}

	//cat
	$database->setQuery("SELECT name,description FROM #__joomgallery_catg WHERE published=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->name;
			$stag.= " ".$row->description;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}
}
?>