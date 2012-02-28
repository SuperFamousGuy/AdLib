<?php
/**
* @version		3.0
* @package		Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

function RafcloudBuildRoute(&$query)
{

	static $items;

	$segments	= array();
	$itemid		= null;

	// Get the menu items for this component.
	if (!$items) {
		$component	= &JComponentHelper::getComponent('com_rafcloud');
		$menu		= &JSite::getMenu();
		$items		= $menu->getItems('componentid', $component->id);
	}

       if(isset($query['sid']))
       {
 
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT word FROM #__rafcloud_stat WHERE id='".intval($query['sid'])."'");
		$result=$db->loadObject();
		if (!empty($result)) $word=rawurlencode(str_replace(" ","-",trim($result->word)));
                $segments[] = $query['sid'];
                $segments[] = $word;
                unset( $query['sid'] );
       }

	return $segments;
}

function RafcloudParseRoute($segments)
{
	$menu	= &JSite::getMenu();
	$item	= &$menu->getActive();

	$vars['sid'] = $segments[0];
	return $vars;
}