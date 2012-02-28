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
$descr= "Joomla MojoBlog Plugin v 3.0"; //short information about plugin


$database = &JFactory::getDBO(); 

if (($runMe)&&($loadWord))
{
	$database->setQuery("SELECT post_content,post_title FROM #__wp_posts WHERE post_status='publish'");

		if ($cur = $database->query()) {
		while ($row = mysql_fetch_object( $cur )) {
			$stag.= " ".$row->post_content;
			$stag.= " ".$row->post_title;
			if ($this->cacheTag($stag,$metaKey)) 			{$stag=null; $metaKey=null;}
		}
	}
}
?>