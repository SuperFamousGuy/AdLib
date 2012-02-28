<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: maingallery.php 126 2009-11-27 15:54:01Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


defined ( 'JPATH_BASE' ) or die ();

class JElementMainGallery extends JElement {
	
	var $_name = 'MainGallery';
	
	function fetchElement($name, $value, &$node, $control_name) {
		$db = &JFactory::getDBO ();
		
		$query = 'SELECT id, name, link FROM #__menu WHERE link LIKE \'%com_jwallpapers%\'';
		
		$db->setQuery ( $query );
		$options = $db->loadObjectList ();
		
		$myoptions = array ();
		foreach ( $options as $option ) {
			if (preg_match ( '/^index\.php\?option=com_jwallpapers\s*$/mi', $option->link )) {
				$myoptions [] = $option;
			}
		}
		
		array_unshift ( $options, JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'Select Category' ) . ' -', 'id', 'title' ) );
		
		return JHTML::_ ( 'select.genericlist', $myoptions, '' . $control_name . '[' . $name . ']', 'class="inputbox"', 'id', 'name', $value, $control_name . $name );
	}
}
?>