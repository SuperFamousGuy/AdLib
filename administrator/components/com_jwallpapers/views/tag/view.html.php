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

class JWallpapersViewTag extends JView {
	function display($tpl = null) {
		
		global $mainframe, $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = $cid [0];
		$task = JRequest::getVar ( 'task', 'add' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		
		
		
		$row->load ( $id );
		
		$user = & JFactory::getUser ();
		
		if ($task == 'add') {
			
			$row->user_id = $user->id;
			
			$date = date ( 'Y-m-d H:i:s', time () );
			$row->date = $date;
		} else {
			
			
			if (JTable::isCheckedOut ( $user->id, $row->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $row->title );
				$mainframe->redirect ( 'index.php?option=com_jwallpapers&controller=tags', $msg, 'notice' );
				return;
			}
			
			
			$row->checkout ( $user->id );
		
			
			
			JRequest::setVar ( 'hidemainmenu', 1 );
		
		}
		
		$this->assignRef ( 'published', JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published ) );
		$this->assignRef ( 'row', $row );
		$this->assign ( 'task', $task );
		
		parent::display ( $tpl );
	
	}
}