<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 351 2010-06-01 09:32:08Z amazeika $
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
		
		global $option, $mainframe;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		JHTML::_ ( 'stylesheet', 'ajax_cat_select.css', 'components/' . $option . '/css/' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = ( int ) $cid [0];
		
		$row->load ( $id );
		
		$user = & JFactory::getUser ();
		
		$task = JRequest::getVar ( 'task', 'add' );
		
		if ($task == 'edit') {
			
			if (JTable::isCheckedOut ( $user->id, $row->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $row->title );
				$mainframe->redirect ( 'index.php?option=com_jwallpapers&controller=categories', $msg, 'notice' );
				return;
			}
			
			
			$row->checkout ( $user->id );
			
			
			
			JRequest::setVar ( 'hidemainmenu', 1 );
		}
		
		
		
		if ($row->id == 0) {
			
			$row->parent_id = 0;
		}
		$catModel = &  $this->getModel ();
		$catList = $catModel->getCategoryChilds ( $row->parent_id );
		$category_resizes = & $catModel->getCategoryResizes ();
		$catPath = $catModel->getPath ( $row->parent_id );
		
		$this->assignRef ( 'catList', $catList );
		$this->assignRef ( 'catPath', $catPath );
		$this->assignRef ( 'row', $row );
		$this->assignRef ( 'category_resizes', $category_resizes );
		$this->assignRef ( 'published', JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published ) );
		$this->assignRef ( 'def_downloadable_front_pics_stat', JHTML::_ ( 'select.booleanlist', 'def_downloadable_front_pics_stat', 'class="inputbox"', $row->def_downloadable_front_pics_stat ) );
		$this->assignRef ( 'frontend_uploads_en', JHTML::_ ( 'select.booleanlist', 'frontend_uploads_en', 'class="inputbox"', $row->frontend_uploads_en ) );
		
		parent::display ( $tpl );
	}
}
