<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 366 2010-06-04 14:11:33Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.view' );

class JWallpapersViewSubmit extends JView {
	
	function display($tpl = null) {
		
		global $mainframe, $option, $Itemid;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'components/' . $option . '/css/' );
		JHTML::_ ( 'stylesheet', 'ajax_cat_select.css', 'components/' . $option . '/css/' );
		
		require_once (JPATH_COMPONENT . DS . 'models' . DS . 'category.php');
		
		
		$def_cat = JRequest::getInt ( 'def_cat', 0 );
		
		
		
		
		$params = & JComponentHelper::getParams ( $option );
		$max_upload_size = $params->get ( 'max_upload_size' );
		$max_upload_resolution = $params->get ( 'max_upload_resolution' );
		$selective_resolution = $params->get ( 'selective_resolution' );
		$uploads_enabled = $params->get ( 'enable_uploads' );
		$security_key = $params->get ( 'security_key' );
		
		
		
		
		$menu = & JSite::getMenu ();
		$menu_params = & $menu->getParams ( $Itemid );
		if ($menu_params->get ( 'menu_item_type' ) == 'jw_submit') {
			
			$target_itemid = $menu_params->get ( 'target_menu_item_id', 1 );
			
			$target_menu_item_id = & $menu->getItem ( $target_itemid );
			$redirect_link = $target_menu_item_id->link;
			if (empty ( $target_menu_item_id->link )) {
				
				$target_itemid = 0;
				
				$redirect_link = 'index.php?option=com_content&view=frontpage';
			}
			
			
			$redirect_link .= '&Itemid=' . $target_itemid;
		} else {
			
			
			$redirect_link = 'index.php';
		}
		
		if (! JWallpapersHelperSystem::authorize ( 'uploads' )) {
			$msg = JText::_ ( 'NO_UPLOAD_PRIVILEGES' );
			$mainframe->redirect ( JRoute::_ ( $redirect_link, false ), $msg, 'notice' );
			return;
		}
		
		
		
		if ($def_cat) {
			
			$cat_row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
			if (! $cat_row->load ( $def_cat )) {
				die ( 'Submit: invalid category ID' );
			}
			if (! $cat_row->frontend_uploads_en) {
				
				$msg = JText::_ ( 'CAT_NOT_UPLOADABLE' );
				$mainframe->redirect ( JRoute::_ ( $redirect_link, false ), $msg, 'notice' );
				return;
			}
		}
		
		
		$show_credits = $params->get ( 'show_credits', 1 );
		
		
		if (! $uploads_enabled) {
			
			$msg = JText::_ ( 'UPLOADS_DISABLED' );
			$mainframe->redirect ( JRoute::_ ( $redirect_link, false ), $msg, 'error' );
			return;
		}
		
		$user = & JFactory::getUser ();
		$userId = $user->id;
		
		
		$model = & $this->getModel ();
		
		$catModel = & new JWallpapersModelCategory ( $def_cat ); 
		$catList = $catModel->getCategoryChilds ( 'hide' );
		
		$catPath = array_reverse ( $catModel->getPath () );
		
		
		
		
		
		
		
		
		
		
		

		
		$kcaptchaURL = 'administrator/components/' . $option . '/kcaptcha';
		
		
		$upload_boxes = $params->get ( 'upload_boxes' );
		
		
		$pathway = & $mainframe->getPathway ();
		$pathway->addItem ( Jtext::_ ( 'SUBMIT_PICTURE' ) );
		
		
		

		
		
		
		
		
		$document = & JFactory::getDocument ();
		
		
		
		$document->setTitle ( JText::_ ( 'SUBMIT_PICTURE' ) );
		
		$allowedResolutionsString = '';
		
		if ($selective_resolution) {
			
			$allowedResolutions = $model->getAllowedResolutions ();
			foreach ( $allowedResolutions as $allowedResolution ) {
				$allowedResolutionsString .= $allowedResolution . " ";
			}
		
		}
		
		
		$hashString = $option . 'addPictures' . $Itemid . $userId . $security_key . $upload_boxes;
		$signature = md5 ( $hashString );
		
		
		$show_captcha = JWallpapersHelperSystem::showCaptcha ();
		
		$this->preparePageClassSuffixes ( $params );
		
		
		
		
		$this->assign ( 'upload_boxes', $upload_boxes );
		$this->assign ( 'show_credits', $show_credits );
		$this->assign ( 'show_captcha', $show_captcha );
		$this->assign ( 'user_id', $userId );
		$this->assignRef ( 'catList', $catList );
		$this->assignRef ( 'catPath', $catPath );
		$this->assignRef ( 'is_owner', JHTML::_ ( 'select.booleanlist', 'is_owner', 'class="inputbox"', 1 ) );
		$this->assign ( 'kcaptchaURL', $kcaptchaURL );
		$this->assign ( 'max_upload_size', $max_upload_size );
		$this->assign ( 'max_upload_resolution', $max_upload_resolution );
		$this->assign ( 'Itemid', $Itemid );
		$this->assign ( 'selective_resolution', $selective_resolution );
		$this->assign ( 'allowedResolutionsString', $allowedResolutionsString );
		$this->assign ( 'signature', $signature );
		
		
		parent::display ( $tpl );
	}
	
	
	function preparePageClassSuffixes(&$params) {
		
		
		$page_class_suffix = $this->escape ( $params->get ( 'pageclass_sfx' ) );
		If (! empty ( $page_class_suffix )) {
			$class_suffix = $page_class_suffix;
			
			$id_class = 'class="' . $page_class_suffix . '"';
		} else {
			$class_suffix = '';
			$id_class = '';
		}
		
		$this->assign ( 'class_suffix', $class_suffix );
		$this->assign ( 'id_class', $id_class );
	
	}

}
?>