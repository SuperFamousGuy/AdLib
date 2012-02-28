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

class JWallpapersViewTaggedPics extends JView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$rows = & $this->get ( 'data' );
		$pagination = & $this->get ( 'pagination' );
		
		$lists = array ();
		
		
		
		$filter_status_state = $mainframe->getUserStateFromRequest ( $option . 'filter_status_state', 'filter_status_state' );
		
		$status_state_filter_opts = array ();
		$status_state_filter_opts [] = JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'SELECT STATE' ) . ' -', 'state', 'title' );
		$status_state_filter_opts [] = JHTML::_ ( 'select.option', 'E', JText::_ ( 'ENABLED' ), 'state', 'title' );
		$status_state_filter_opts [] = JHTML::_ ( 'select.option', 'D', JText::_ ( 'DISABLED' ), 'state', 'title' );
		$lists ['status_state'] = JHTML::_ ( 'select.genericlist', $status_state_filter_opts, 'filter_status_state', 'class="inputbox" onchange="document.adminForm.submit();"', 'state', 'title', $filter_status_state );
		
		
		$filter_search = $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' );
		$lists ['filter_search'] = htmlspecialchars($filter_search, ENT_QUOTES);
		
		
		
		$filter_order_hits = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'date' );
		$filter_order_hits_Dir = $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' );
		
		$lists ['order_Dir'] = $filter_order_hits_Dir;
		$lists ['order'] = $filter_order_hits;
		
		$pic_row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		$user = & JTable::getInstance ('user');
		foreach ( $rows as &$row ) {
			
			if ($row->user_id) {
				$user->load ( $row->user_id );
				$username = $user->username;
				$user_id = $user->id;
			} else {
				$username = JText::_ ( 'GUEST' );
				$user_id = 0;
			}
			$row->user = '<b>' . $username . '</b> (ID: ' . $user_id . ')';
			
			$row->pic_link = 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->file_id;
			$pic_row->load ( $row->file_id );
			$row->pic_link_title = $pic_row->title;
			
			$row->tag_link = 'index.php?option=' . $option . '&controller=tags&task=edit&cid[]=' . $row->tag_id;
		}
		
		
		$this->assignRef ( 'lists', $lists );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagination );
		
		parent::display ( $tpl );
	}
}
?>