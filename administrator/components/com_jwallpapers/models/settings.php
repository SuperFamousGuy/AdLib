<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: settings.php 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.model' );

class JWallpapersModelSettings extends JModel {
	
	var $_allowedResolutions = null;
	var $_global_resizes = null;
	
	function &getAllowedResolutions() {
		if (! $this->_allowedResolutions) {
			$query = 'SELECT * FROM #__jwallpapers_allowed_resolutions';
			$this->_allowedResolutions = $this->_getList ( $query );
		}
		return $this->_allowedResolutions;
	}
	
	function &getGlobalResizes() {
		
		if (! $this->_global_resizes) {
			$query = 'SELECT * FROM #__jwallpapers_global_resizes';
			$this->_global_resizes = $this->_getList ( $query );
		}
		return $this->_global_resizes;
	}
}
?>