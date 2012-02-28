<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.raw.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewSettings extends JView {
	function display($tpl = null) {
		
		global $option;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$referer = JRequest::getVar ( 'referer', '' );
		
		if ($referer == 'addAllowedRes' || $referer == 'delAllowedRes') {
			$model = & $this->getModel ( 'settings' );
			
			$allowedResolutions = $model->getAllowedResolutions ();
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlAllowedResolutionsLayoutUpdate = & $xml->addChild ( 'allowed_resolutions_layout_update' );
			
			ob_start ();
			JWallpapersHelperLayout::getAllowedResolutionsLayout ( $allowedResolutions );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlAllowedResolutionsLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		} elseif ($referer == 'addResize' || $referer == 'delResize') {
			
			$model = & $this->getModel ( 'settings' );
			
			$global_resizes = $model->getGlobalResizes ();
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlAvailableResizesLayoutUpdate = & $xml->addChild ( 'available_resizes_layout_update' );
			ob_start ();
			JWallpapersHelperLayout::getResizeListLayout ( $global_resizes );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlAvailableResizesLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		}
	}
}
?>