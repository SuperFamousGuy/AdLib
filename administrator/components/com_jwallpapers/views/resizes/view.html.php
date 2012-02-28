<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

class JWallpapersViewResizes extends JView {
	function display($tpl = null) {
		
		global $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
				
		parent::display ( $tpl );
	
	}
}
?>