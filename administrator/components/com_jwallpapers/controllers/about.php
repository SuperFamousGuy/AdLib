<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: about.php 126 2009-11-27 15:54:01Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerAbout extends JController {
	
	function display() {
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'about' );
		}
		
		parent::display ();
	}

}
?>