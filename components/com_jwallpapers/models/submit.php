<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: submit.php 199 2010-02-26 11:00:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.model' );

class JWallpapersModelSubmit extends JModel {
	
	var $_allowedResolutions;
	
	
	function &getAllowedResolutions() {
		
		if (! $this->_allowedResolutions) {
			
			$query = 'SELECT * FROM #__jwallpapers_allowed_resolutions';
			$results = $this->_getList ( $query );
			
			$this->_allowedResolutions = array ();
			
			foreach ( $results as $result ) {
				
				array_push ( $this->_allowedResolutions, $result->width . 'x' . $result->height );
			}		
		}
		
		return $this->_allowedResolutions;
	
	}

}

?>