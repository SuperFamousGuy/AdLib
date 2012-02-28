<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 292 2010-04-22 17:06:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewTags extends JView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$rows = & $this->get ( 'data' );
		$pagination = & $this->get ( 'pagination' );
		
		$lists = array ();
		
		
		
		$filter_state = $mainframe->getUserStateFromRequest ( $option . 'filter_state', 'filter_state' );
		
		$lists ['state'] = JHTML::_ ( 'grid.state', $filter_state );
		
		
		$filter_search = $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' );
		$lists ['filter_search'] = htmlspecialchars ( $filter_search, ENT_QUOTES );
		
		
		
		$filter_order_hits = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'date' );
		$filter_order_hits_Dir = $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' );
		
		$lists ['order_Dir'] = $filter_order_hits_Dir;
		$lists ['order'] = $filter_order_hits;
		
		
		
		
		
		
		
		
		
		
		foreach ( $rows as &$row ) {
			$user = & JTable::getInstance ( 'user' );
			if ($row->user_id) {
				$user->load ( $row->user_id );
				$username = $user->username;
				$user_id = $user->id;
			} else {
				$username = JText::_ ( 'GUEST' );
				$user_id = 0;
			}
			$row->user = '<b>' . $username . '</b> (ID: ' . $user_id . ')';
		}
		
		
		$this->assignRef ( 'lists', $lists );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagination );
		
		parent::display ( $tpl );
	}
}
?>