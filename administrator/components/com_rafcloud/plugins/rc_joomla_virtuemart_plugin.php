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
	$descr= "Joomla VirtueMart Plugin v 3.0"; //short information about plugin
$database = &JFactory::getDBO(); 

if (($runMe)&&($loadWord))
{
	$database->setQuery("SELECT product_s_desc,product_desc FROM #__vm_product WHERE product_publish='Y'");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->product_s_desc;
			$stag.= " ".$row->product_desc;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}

	$database->setQuery("SELECT category_description,category_name FROM #__vm_category WHERE  category_publish='Y'");
	if ($cur = $database->query()) 
	{
		while ($row = mysql_fetch_object( $cur )) 
		{
			$stag.= " ".$row->category_name;
			$stag.= " ".$row->category_description;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}


}
?>