<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: tags.php 292 2010-04-22 17:06:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerTags extends JController {
	function __construct($config = array()) {
		parent::__construct ( $config );
		
		$this->registerTask ( 'unpublish', 'publish' );
		
		$this->registerTask ( 'apply', 'save' );
	}
	
	function edit() {
		JRequest::setVar ( 'view', 'tag' );
		
		$this->display ();
	}
	
	function cancel() {
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		$row->bind ( JRequest::get ( 'post' ) );
		$row->checkin ();
		
		$this->setRedirect ( 'index.php?option=com_jwallpapers&controller=tags' );
	}
	
	function add() {
		JRequest::setVar ( 'view', 'tag' );
		
		$this->display ();
	}
	
	function manageTaggedPics() {
		
		global $option;
		
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		$row->bind ( JRequest::get ( 'post' ) );
		$row->checkin ();
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=taggedpics' );
	}
	
	function publish() {
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		
		$publish = 1;
		$msg = JText::_ ( 'TAGS_PUBLISHED' );
		
		if ($this->getTask () == 'unpublish') {
			$publish = 0;
			$msg = JText::_ ( 'TAGS_UNPUBLISHED' );
		}
		
		if (! $row->publish ( $cid, $publish )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=tags', $msg );
	
	}
	
	function delete() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option, $mainframe;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		$user = & JFactory::getUser ();
		
		$model = & $this->getModel ( 'tags' );
		
		
		$ids = array ();
		foreach ( $cid as $id ) {
			
			$id = ( int ) $id;
			
			$row->load ( $id );
			
			
			if (JTable::isCheckedOut ( $user->id, $row->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $row->title );
				$mainframe->enqueueMessage ( $msg, 'error' );
			} else {
				
				$row->checkout ( $user->id );
				
				$ids [] = $id;
			}
		}
		
		$model->deleteTags ( $ids );
		
		if (count ( $ids ) > 1) {
			$msg = JText::_ ( 'TAGS_DELETED' );
		} elseif (count ( $ids ) == 1) {
			$msg = JText::_ ( 'TAG_DELETED' );
		} else {
			$msg = '';
		}
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=tags', $msg );
	
	}
	
	function save() {
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$row = & JTable::getInstance ( 'JWallpapers_Tag', 'Table' );
		
		$data_from_form = JRequest::get ( 'post' );
		
		
		if (! isset ( $data_from_form ['title'] ) || $data_from_form ['title'] == '') {
			$msg = JText::_ ( 'MISSING_TAG_NAME' );
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=tags', $msg, 'error' );
			return;
		}
		
		
		$data_from_form ['title'] = strtolower ( $data_from_form ['title'] );
		
		
		if (! $row->bind ( $data_from_form )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		
		$row->check ();
		
		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		
		$row->validate();
		
		
		$row->checkin ();
		
		$task = JRequest::getVar ( 'task', 'save' );
		
		if ($task == 'save') {
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=tags', JText::_ ( 'TAG_SAVED' ) );
		} elseif ($task == 'apply') {
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=tags&task=edit&cid[]=' . $row->id, JText::_ ( 'CHANGES_APPLIED' ) );
		}
	
	}
	
	
	function ajaxSearchTag() {
		
		global $option;
		
		$search_string = urlencode ( JRequest::getString ( 'str', '' ) );
		$id = JRequest::getInt ( 'id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&id=' . $id . '&referer=ajaxSearchTag&str=' . $search_string );
	
	}
	
	function display() {
		
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'tags' );
		}
		
		parent::display ();
	}

}
?>