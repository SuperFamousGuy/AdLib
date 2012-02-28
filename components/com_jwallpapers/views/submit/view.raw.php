<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.raw.php 302 2010-04-26 18:23:00Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewSubmit extends JView {
	function display($tpl = null) {
		
		global $option;
		
		$task = JRequest::getVar ( 'referer' );
		
		if ($task == 'ajaxGetCat') {
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'category.php');
			
			$id = JRequest::getInt ( 'id', 0 );
			
			$catModel = & new JWallpapersModelCategory ( $id );
			$catList = $catModel->getCategoryChilds ( 'hide' );
			
			$catPath = array_reverse ( $catModel->getPath () );
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'catSelectLayout' );
			
			$xmlCategoryLayoutUpdate = & $xml->addChild ( 'category_layout_update' );
			
			ob_start ();
			JWallpapersHelperLayout::getCatSelectLayout ( $catList, $catPath );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlCategoryLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($task == 'refreshCaptcha') {
			
			$kcaptchaPath = 'administrator' . DS . 'components' . DS . $option . DS . 'kcaptcha';
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'newCaptcha' );
			
			$xmlCategoryLayoutUpdate = & $xml->addChild ( 'captcha_info' );
			
			$data = '<img src="' . $kcaptchaPath . DS . 'index.php?rn=' . mt_rand ( 0, 9999 ) . '">';
			
			$xmlCategoryLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($task == 'checkCaptcha') {
			
			global $option;
			
			$session = & JFactory::getSession ();
			$captcha_keystring = $session->get ( 'captcha_keystring' );
			$keystring = JRequest::getVar ( 'keystring', '' );
			if (isset ( $captcha_keystring ) && $captcha_keystring == $keystring) {
				$result = 'true';
			} else {
				$result = 'false';
			}
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'checkCaptcha' );
			
			$xmlCategoryLayoutUpdate = & $xml->addChild ( 'check_result' );
			
			$xmlCategoryLayoutUpdate->setData ( $result );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		}
	
	}
}
?>