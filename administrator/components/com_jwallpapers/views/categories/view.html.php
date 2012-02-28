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

class JWallpapersViewCategories extends JView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$rows = & $this->get ( 'data' );
		$pagination = & $this->get ( 'pagination' );
		$rowInstance = JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		
		foreach ( $rows as $row ) {
			if ($row->parent_id) { 
				$rowInstance->load ( $row->parent_id );
				$row->parentTitle = $rowInstance->title;
			} else { 
				$row->parentTitle = '/';
			}
		}
		
		$lists = array ();
		
		
		
		$filter_state = $mainframe->getUserStateFromRequest ( $option . 'filter_state', 'filter_state' );
		
		$lists ['state'] = JHTML::_ ( 'grid.state', $filter_state );
		
		
		$filter_by_state_cats = $mainframe->getUserStateFromRequest ( $option . 'filter_by_state_cats', 'filter_by_state_cats' );
		
		$StateFilterByOpts = array ();
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'FILTER_BY' ) . ' -', 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'FRONT_UPLOADS_EN', JText::_ ( 'FRONTEND_UPLOADS_ENABLED' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'FRONT_UPLOADS_DIS', JText::_ ( 'FRONTEND_UPLOADS_DISABLED' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'DEF_DOWNLOADABLE_FRONT_PICS_YES', JText::_ ( 'DEFAULT_DOWNLOADABLE_FRONT_PICS_YES' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'DEF_DOWNLOADABLE_FRONT_PICS_NO', JText::_ ( 'DEFAULT_DOWNLOADABLE_FRONT_PICS_NO' ), 'state', 'title' );
		$lists ['filter_by_state_cats'] = JHTML::_ ( 'select.genericlist', $StateFilterByOpts, 'filter_by_state_cats', 'class="inputbox" onchange="document.adminForm.submit();"', 'state', 'title', $filter_by_state_cats );
		
		
		$filter_deny_access_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_access_to', 'filter_deny_access_to' );
		$acl_aro_groups = JWallpapersHelperSystem::getCoreACLAroGroups ();
		array_unshift ( $acl_aro_groups, JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'CATEGORY_DENY_ACL' ) . ' -', 'id', 'title' ) );
		$lists ['filter_deny_access_to'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_access_to', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_access_to );
		
		$filter_deny_votes_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_votes_from', 'filter_deny_votes_from' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'CATEGORY_VOTES_DENY_ACL' ) . ' -';
		$lists ['filter_deny_votes_from'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_votes_from', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_votes_from );
		
		$filter_deny_downloads_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_downloads_to', 'filter_deny_downloads_to' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'CATEGORY_DOWNLOADS_DENY_ACL' ) . ' -';
		$lists ['filter_deny_downloads_to'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_downloads_to', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_downloads_to );
		
		$filter_deny_tagging_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_tagging_from', 'filter_deny_tagging_from' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'CATEGORY_TAGGING_DENY_ACL' ) . ' -';
		$lists ['filter_deny_tagging_from'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_tagging_from', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_tagging_from );
		
		$filter_deny_uploads_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_uploads_to', 'filter_deny_uploads_to' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'CATEGORY_UPLOADS_DENY_ACL' ) . ' -';
		$lists ['filter_deny_uploads_to'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_uploads_to', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_uploads_to );
		
		
		$filter_search = $mainframe->getUserStateFromRequest ( $option . 'filter_search', 'filter_search' );
		$lists ['filter_search'] = htmlspecialchars ( $filter_search, ENT_QUOTES );
		
		
		
		$filter_order = $mainframe->getUserStateFromRequest ( $option . 'filter_order', 'filter_order', 'upload_date' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest ( $option . 'filter_order_Dir', 'filter_order_Dir', 'DESC' );
		
		$lists ['order_Dir'] = $filter_order_Dir;
		$lists ['order'] = $filter_order;
		
		
		$this->assignRef ( 'lists', $lists );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagination );
		
		parent::display ( $tpl );
	}
}
?>