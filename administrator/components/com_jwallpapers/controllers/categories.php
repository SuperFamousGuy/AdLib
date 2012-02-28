<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: categories.php 361 2010-06-03 10:03:35Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerCategories extends JController {
	
	function __construct($config = array()) {
		parent::__construct ( $config );
		
		$this->registerTask ( 'unpublish', 'publish' );
		$this->registerTask ( 'apply', 'save' ); 
	}
	
	function save() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		
		
		$dataFromForm = JRequest::get ( 'post', 4 );
		
		
		
		
		
		

		
		
		
		$noHtmlFilter = & JFilterInput::getInstance ();
		$dataFromForm ['title'] = $noHtmlFilter->clean ( $dataFromForm ['title'] );
		$dataFromForm ['keywords'] = $noHtmlFilter->clean ( $dataFromForm ['keywords'] );
		$dataFromForm ['alias'] = $noHtmlFilter->clean ( $dataFromForm ['alias'] );
		
		
		$deny_acls = array ('item_deny_acl', 'votes_deny_acl', 'downloads_deny_acl', 'tagging_deny_acl', 'uploads_deny_acl' );
		foreach ( $deny_acls as $deny_acl ) {
			if (isset ( $dataFromForm [$deny_acl] )) {
				$dataFromForm [$deny_acl] = implode ( ',', $dataFromForm [$deny_acl] );
			} else {
				$dataFromForm [$deny_acl] = '';
			}
		}
		
		
		if (! isset ( $dataFromForm ['title'] ) || $dataFromForm ['title'] == '') {
			$msg = JText::_ ( 'MISSING_CAT_NAME' );
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg, 'error' );
			return;
		}
		
		
		

		
		JWallpapersHelperImage::updateResizeList ( $dataFromForm );
		
		if (! $row->bind ( $dataFromForm )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$row->check (); 
		

		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		
		$row->validate ();
		
		
		$row->checkin ();
		
		$task = JRequest::getVar ( 'task', 'save' );
		
		if ($task == 'save') {
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', JText::_ ( 'CATEGORY_SAVED' ) );
		} elseif ($task == 'apply') {
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories&task=edit&cid[]=' . $row->id, JText::_ ( 'CHANGES_APPLIED' ) );
		}
	}
	
	function add() {
		JRequest::setVar ( 'view', 'category' );
		
		$this->display ();
	}
	
	function edit() {
		JRequest::setVar ( 'view', 'category' );
		$this->display ();
	}
	
	function cancel() {
		
		
		$row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		$row->bind ( JRequest::get ( 'post' ) );
		$row->checkin ();
		
		$this->setRedirect ( 'index.php?option=com_jwallpapers&controller=categories' );
	}
	
	function remove() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option, $mainframe;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		
		$user = & JFactory::getUser ();
		
		$model = & $this->getModel ( 'category' );
		
		
		$cid_removed_count = 0;
		
		foreach ( $cid as $id ) {
			
			$id = ( int ) $id;
			
			$row->load ( $id );
			
			
			if (JTable::isCheckedOut ( $user->id, $row->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $row->title );
				$mainframe->enqueueMessage ( $msg, 'error' );
				continue;
			}
			
			
			$row->checkout ( $user->id );
			
			
			

			
			$model->takeCareOfOrphans ( $id );
			
			if (! $row->delete ( $id )) {
				JError::raiseError ( 500, $row->getError () );
			}
			
			$cid_removed_count ++;
		
		}
		
		
		$model->deleteResizeList ( $cid );
		
		if ($cid_removed_count > 1) {
			$msg = JText::_ ( 'CATS_DELETED' );
		} elseif ($cid_removed_count == 1) {
			$msg = JText::_ ( 'CAT_DELETED' );
		} else {
			$msg = '';
		}
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
	}
	
	function publish() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		
		$publish = 1;
		
		if ($this->getTask () == 'unpublish') {
			$publish = 0;
		}
		
		if (! $row->publish ( $cid, $publish )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if ($this->getTask () == 'unpublish') {
			$msg = JText::_ ( 'CATS_UNPUBLISHED' );
		} else {
			$msg = JText::_ ( 'CATS_PUBLISHED' );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
	}
	
	function ajaxGetCat() {
		
		global $option;
		
		$id = JRequest::getInt ( 'id', 0 );
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$cat_id = ( int ) $cid [0];
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories&referer=ajaxGetCat&view=category&format=raw&id=' . $id . '&cid[]=' . $cat_id );
	}
	
	function display() {
		$view = JRequest::getVar ( 'view' );
		
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'categories' );
		}
		
		parent::display ();
	}
	
	function ratingsReset() {
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->ratingsReset ();
		
		$msg = JText::_ ( 'RATINGS_RESET_SUCCESSFUL' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function enableVotes() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setVotesStatus ( 'en' );
		
		$msg = JText::_ ( 'VOTES_SUCCESSFULLY_ENABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function disableVotes() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setVotesStatus ( 'dis' );
		
		$msg = JText::_ ( 'VOTES_SUCCESSFULLY_DISABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function enableDownloads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setDownloadableStatus ( 'en' );
		
		$msg = JText::_ ( 'DOWNLOADS_SUCCESSFULLY_ENABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function disableDownloads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setDownloadableStatus ( 'dis' );
		
		$msg = JText::_ ( 'DOWNLOADS_SUCCESSFULLY_DISABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function addResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$h = JRequest::getInt ( 'h' );
		$w = JRequest::getInt ( 'w' );
		
		$size_formats = JRequest::getVar ( 'size_formats', '0,1,2,3,4' );
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = ( int ) $cid [0];
		
		
		$row = & JTable::getInstance ( 'JWallpapers_Category_Resize', 'Table' );
		
		$newResizeData = array ('width' => $w, 'height' => $h, 'size_formats' => $size_formats, 'cat_id' => $id );
		
		if (! $row->bind ( $newResizeData )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories&view=category&format=raw&referer=addResize&cid[]=' . $id );
	
	}
	
	
	function delResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$cat_id = ( int ) $cid [0];
		
		$id = JRequest::getInt ( 'id' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Category_Resize', 'Table' );
		
		$row->load ( $id );
		
		if (! $row->delete ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories&view=category&format=raw&referer=delResize&cid[]=' . $cat_id );
	
	}
	
	
	function enableFrontendUploads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setFrontendUploadStatus ( 'en' );
		
		$msg = JText::_ ( 'FRONTEND_UPLOADS_SUCCESSFULLY_ENABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}
	
	
	function disableFrontendUploads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'categories' );
		
		$model->setFrontendUploadStatus ( 'dis' );
		
		$msg = JText::_ ( 'FRONTEND_UPLOADS_SUCCESSFULLY_DISABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=categories', $msg );
		
		return;
	
	}

}
?>
