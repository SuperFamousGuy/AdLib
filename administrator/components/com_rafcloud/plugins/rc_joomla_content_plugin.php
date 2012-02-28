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
$descr= "Joomla Content Plugin v 3.0"; //short information about plugin
$database = &JFactory::getDBO(); 

if (($runMe)&&($loadWord))
{
	//content
	$database->setQuery("SELECT * FROM #__content WHERE state=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->title;
			$stag.= " ".$row->title_alias;
			$stag.= " ".$row->fulltext;
			$stag.= " ".$row->introtext;
			if ($this->cacheTag($stag,$metaKey)) 
			{$stag=null; $metaKey=null;}
		}
	}

	//sections
	$database->setQuery("SELECT title,name,description FROM #__sections WHERE published=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->title;
			$stag.= " ".$row->name;
			$stag.= " ".$row->description;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}

	//categories
	$database->setQuery("SELECT title,name,description FROM #__categories WHERE published=1");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->title;
			$stag.= " ".$row->name;
			$stag.= " ".$row->description;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}
}
?>