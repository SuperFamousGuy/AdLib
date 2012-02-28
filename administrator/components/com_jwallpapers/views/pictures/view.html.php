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

class JWallpapersViewPictures extends JView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$rows = & $this->get ( 'data' );
		$pagination = & $this->get ( 'pagination' );
		
		
		$show_backend_category_filter = $params->get ( 'show_backend_category_filter' );
		
		if ($show_backend_category_filter) {
			
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'categories.php');
			$catModel = & new JWallpapersModelCategories ( );
			$catList = $catModel->getCatList ();
		} else {
			$catList = array ();
		}
		
		$cat_list_orphan = new stdClass ( );
		
		
		$cat_list_orphan->id = - 1;
		$cat_list_orphan->title = '* ' . JText::_ ( 'FILTER_ORPHANS' ) . ' *';
		array_unshift ( $catList, $cat_list_orphan );
		
		foreach ( $rows as &$row ) {
			
			
			$user = & JTable::getInstance ( 'user' );
			$user->load ( $row->user_id );
			
			if ($row->user_id != 0) {
				$username = $user->username;
				$row->uploadedBy = $username;
			} else {
				$row->uploadedBy = JText::_ ( 'GUEST' );
			}
			
			
			

			$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
			
			if ($catRow->load ( $row->cat_id )) {
				$row->isCatPublished = ($catRow->published) ? JText::_ ( 'YES' ) : '<span class="red_msg">' . JText::_ ( 'NO' ) . '<span class="red_msg">';
			} else {
				
				$row->isCatPublished = JText::_ ( 'YES' );
			}
			
			if ($row->cat_id) { 
				$catLink = '<a href="index.php?option=' . $option . '&controller=categories&task=edit&cid[]=' . $row->cat_id . '">' . $catRow->title . '</a>';
			} else {
				$catLink = '<span class="red_msg">' . JText::_ ( 'ORPHAN' ) . '</span>';
			}
			
			$row->catLink = $catLink;
			
			
			if ($row->count == null) {
				$row->count = 0;
			}
			if ($row->average == null) {
				$row->average = 0.00;
			}
		
		}
		
		$lists = array ();
		
		
		
		$filter_state = $mainframe->getUserStateFromRequest ( $option . 'filter_state', 'filter_state' );
		
		$lists ['state'] = JHTML::_ ( 'grid.state', $filter_state );
		
		$filter_catid = $mainframe->getUserStateFromRequest ( $option . 'filter_catid', 'filter_catid' );
		
		array_unshift ( $catList, JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'SELECT CATEGORY' ) . ' -', 'id', 'title' ) );
		$lists ['catid'] = JHTML::_ ( 'select.genericlist', $catList, 'filter_catid', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', ( int ) $filter_catid );
		
		
		$filter_by_state_pics = $mainframe->getUserStateFromRequest ( $option . 'filter_by_state_pics', 'filter_by_state_pics' );
		
		$StateFilterByOpts = array ();
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'FILTER_BY' ) . ' -', 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'VOTES_EN', JText::_ ( 'VOTES_ENABLED' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'VOTES_DIS', JText::_ ( 'VOTES_DISABLED' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'DOWNLOADS_EN', JText::_ ( 'DOWNLOADS_ENABLED' ), 'state', 'title' );
		$StateFilterByOpts [] = JHTML::_ ( 'select.option', 'DOWNLOADS_DIS', JText::_ ( 'DOWNLOADS_DISABLED' ), 'state', 'title' );
		$lists ['filter_by_state_pics'] = JHTML::_ ( 'select.genericlist', $StateFilterByOpts, 'filter_by_state_pics', 'class="inputbox" onchange="document.adminForm.submit();"', 'state', 'title', $filter_by_state_pics );
		
		
		$filter_tag = $mainframe->getUserStateFromRequest ( $option . 'filter_tag', 'filter_tag' );
		$filter_tag_opts = array ();
		$filter_tag_opts [] = JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'SELECT_TAG' ) . ' -', 'tag', 'title' );
		$filter_tag_opts [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'EDITORS_PICKS' ), 'tag', 'title' );
		$lists ['filter_tag'] = JHTML::_ ( 'select.genericlist', $filter_tag_opts, 'filter_tag', 'class="inputbox" onchange="document.adminForm.submit();"', 'tag', 'title', $filter_tag );
		
		
		$filter_deny_access_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_access_to', 'filter_deny_access_to' );
		$acl_aro_groups = JWallpapersHelperSystem::getCoreACLAroGroups ();
		array_unshift ( $acl_aro_groups, JHTML::_ ( 'select.option', '0', '- ' . JText::_ ( 'PICTURE_DENY_ACL' ) . ' -', 'id', 'title' ) );
		$lists ['filter_deny_access_to'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_access_to', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_access_to );
		
		$filter_deny_votes_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_votes_from', 'filter_deny_votes_from' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'PICTURE_VOTES_DENY_ACL' ) . ' -';
		$lists ['filter_deny_votes_from'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_votes_from', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_votes_from );
		
		$filter_deny_downloads_to = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_downloads_to', 'filter_deny_downloads_to' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'PICTURE_DOWNLOADS_DENY_ACL' ) . ' -';
		$lists ['filter_deny_downloads_to'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_downloads_to', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_downloads_to );
		
		$filter_deny_tagging_from = $mainframe->getUserStateFromRequest ( $option . 'filter_deny_tagging_from', 'filter_deny_tagging_from' );
		$acl_aro_groups [0]->title = '- ' . JText::_ ( 'PICTURE_TAGGING_DENY_ACL' ) . ' -';
		$lists ['filter_deny_tagging_from'] = JHTML::_ ( 'select.genericlist', $acl_aro_groups, 'filter_deny_tagging_from', 'class="inputbox" onchange="document.adminForm.submit();"', 'id', 'title', $filter_deny_tagging_from );
		
		
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