<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.raw.php 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewCategory extends JView {
	function display($tpl = null) {
		
		global $option;
		
		$referer = JRequest::getVar ( 'referer', '' );
		
		if ($referer == 'ajaxGetCat') {
			
			$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
			$cat_id = (int) $cid[0];
			
			$id = JRequest::getInt('id',0);

			$catModel = & $this->getModel ();
			$catList = $catModel->getCategoryChilds ($id);
			$catPath = $catModel->getPath ($id);
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlCategoryLayoutUpdate = & $xml->addChild ( 'category_layout_update' );
			
			ob_start ();
			JWallpapersHelperLayout::getParentSelectLayout ( $catList, $catPath, $cat_id );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlCategoryLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'addResize' || $referer == 'delResize') {
			
			$model = & $this->getModel ( 'category' );
			
			$category_resizes =& $model->getCategoryResizes ();

			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlAvailableResizesLayoutUpdate = & $xml->addChild ( 'available_resizes_layout_update' );
			ob_start ();
			JWallpapersHelperLayout::getResizeListLayout ( $category_resizes );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlAvailableResizesLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		}
	
	}
}
?>