<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 288 2010-04-21 19:11:29Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewPicture extends JView {
	function display($tpl = null) {
		
		global $option, $mainframe;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		JHTML::_ ( 'stylesheet', 'ajax_cat_select.css', 'components/' . $option . '/css/' );
		
		require_once (JPATH_COMPONENT . DS . 'models' . DS . 'category.php');
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = $cid [0];
		
		$row->load ( $id );
		$this->assignRef ( 'row', $row );
		
		$user = & JFactory::getUser ();
		
		
		$task = JRequest::getVar ( 'task', 'add' );
		
		if ($task == 'edit') {
			
			
			if (JTable::isCheckedOut ( $user->id, $row->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $row->title );
				$mainframe->redirect ( 'index.php?option=com_jwallpapers', $msg, 'notice' );
				return;
			}
			
			
			$row->checkout ( $user->id );
			
			
			
			JRequest::setVar ( 'hidemainmenu', 1 );
			
			$timestamp = strtotime ( $row->upload_date );
			
			
			
			$picObject = new stdClass ( );
			$picObject->name = $row->file_name;
			$picObject->ext = $row->file_ext;
			$picObject->year = date ( 'Y', $timestamp );
			$picObject->month = date ( 'n', $timestamp );
			JWallpapersHelperImage::imageGenChk ( $picObject, 'big_thumb' );
			
			
			
			$picFile = "../jwallpapers_files/" . $picObject->year . "/" . $picObject->month . "/big_thumb_" . $row->file_name . ".jpg";
		
		}
		
		
		
		if ($row->id == 0) {
			
			$row->cat_id = 0;
		}
		$catModel = & new JWallpapersModelCategory ( $row->cat_id );
		$catList = $catModel->getCategoryChilds (); 
		$catPath = $catModel->getPath ();
		
		if ($row->id) {
			
			$model = & $this->getModel ();
			$pic_tags = & $model->getPicTags ();
			$file_resizes = & $model->getFileResizes ();
			$this->assignRef ( 'pic_tags', $pic_tags );
			$this->assignRef ( 'file_resizes', $file_resizes );
		}
		
		$editor = & JFactory::getEditor ();
		$this->assignRef ( 'editor', $editor );
		$this->assign ( 'picFile', $picFile );
		$this->assignRef ( 'catList', $catList );
		$this->assignRef ( 'catPath', $catPath );
		$this->assign ( 'task', $task );
		
		
		$this->assignRef ( 'is_owner', JHTML::_ ( 'select.booleanlist', 'is_owner', 'class="inputbox"', $row->is_owner ) );
		$this->assignRef ( 'published', JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published ) );
		$this->assignRef ( 'votes_en', JHTML::_ ( 'select.booleanlist', 'votes_en', 'class="inputbox"', $row->votes_en ) );
		$this->assignRef ( 'downloadable', JHTML::_ ( 'select.booleanlist', 'downloadable', 'class="inputbox"', $row->downloadable ) );
		$this->assignRef ( 'tag_ep', JHTML::_ ( 'select.booleanlist', 'tag_ep', 'class="inputbox"', $row->tag_ep ) );
		if (isset ( $row->tag_ep )) {
			$this->assign ( 'tag_ep_current', $row->tag_ep );
		} else {
			$this->assign ( 'tag_ep_current', 0 );
		}
		
		

		parent::display ( $tpl );
	}
}
?>