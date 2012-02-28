<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: pictures.php 349 2010-05-31 12:58:41Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerPictures extends JController {
	function __construct($config = array()) {
		parent::__construct ( $config );
		
		$this->registerTask ( 'unpublish', 'publish' );
		
		$this->registerTask ( 'apply', 'save' );
	}
	
	function edit() {
		JRequest::setVar ( 'view', 'picture' );
		
		JRequest::setVar ( 'controller', 'pictures' );
		
		$this->display ();
	}
	
	function cancel() {
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		$row->bind ( JRequest::get ( 'post' ) );
		$row->checkin ();
		
		$this->setRedirect ( 'index.php?option=com_jwallpapers' );
	}
	
	function add() {
		JRequest::setVar ( 'view', 'picture' );
		
		$this->display ();
	}
	
	
	function manageTaggedPics() {
		
		global $option;
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		$row->bind ( JRequest::get ( 'post' ) );
		$row->checkin ();
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=taggedpics' );
	}
	
	function addPictures(&$dataFromForm) {
		global $option, $mainframe;
		
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$selective_resolution = $params->get ( 'selective_resolution' );
		
		
		$fields = array ('picturefile_server', 'id', 'new_cat', 'cat_id', 'published', 'title' );
		if (! JWallpapersHelperSystem::isFormDataComplete ( $dataFromForm, $fields )) {
			$msg = JText::_ ( 'FORM_VAR_CHECK_PROBLEM' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
			return;
		}
		
		
		$file = JRequest::getVar ( 'picturefile', array (), 'files', 'array' );
		
		
		$fields = array ('error', 'name', 'type', 'tmp_name', 'size' );
		if (! JWallpapersHelperSystem::isFormDataComplete ( $file, $fields )) {
			$msg = JText::_ ( 'FORM_FILE_VAR_CHECK_ERROR' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
			return;
		}
		
		
		if ($file ['error'] != 4) {
			
			$file ['is_in_server'] = 0;
		} else {
			
			
			if (JWallpapersHelperSystem::isWin ()) {
				$regexp = '/([^\\\\]*)$/m';
			} else {
				$regexp = '/([^\/]*)$/m';
			}
			
			if (! preg_match ( $regexp, $dataFromForm ['picturefile_server'], $result )) {
				$msg = JText::_ ( 'REG_EXP_FILE_NAME_EXT' );
				$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
				return;
			}
			
			$file ['name'] = rtrim ( $result [1] );
			$file ['tmp_name'] = $dataFromForm ['picturefile_server'];
			$file ['is_in_server'] = 1;
		}
		
		
		
		if ($file ['name'] == '') {
			
			
			$msg = JText::_ ( 'MISSING_UPLOAD_PICTURE' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
			return;
		}
		
		
		$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		if (! $catRow->exists ( $dataFromForm ['cat_id'] )) {
			$this->setRedirect ( 'index.php?option=' . $option, JText::_ ( 'CAT_NOT_EXIST' ), 'error' );
			return;
		}
		
		
		if ($dataFromForm ['new_cat'] != '') {
			$newCatData = array ('parent_id' => $dataFromForm ['cat_id'], 'title' => $dataFromForm ['new_cat'] );
			
			if (! $catRow->bind ( $newCatData )) {
				JError::raiseError ( 500, $catRow->getError () );
			}
			
			
			$catRow->check ();
			
			if (! $catRow->store ()) {
				JError::raiseError ( 500, $catRow->getError () );
			}
			
			
			$catRow->validate ();
			
			
			$dataFromForm ['cat_id'] = $catRow->id;
			
			
			
			if ($dataFromForm ['published']) {
				$catRow->publish ();
			}
		
		}
		
		
		$user = & JFactory::getUser ();
		$dataFromForm ['user_id'] = $user->id;
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		if (! $row->bind ( $dataFromForm )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		
		
		

		jimport ( 'joomla.filesystem.file' );
		
		$ext = JFile::getExt ( $file ['name'] );
		
		if ($ext == 'zip') {
			
			if (! JWallpapersHelperImage::processZipFile ( $file, $dataFromForm, $file ['is_in_server'], $params )) {
				
				$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
				return;
			}
			$msg = JText::_ ( 'PICTURES_ADDED' );
		} else {
			if (! JWallpapersHelperImage::processImageFile ( $file, $dataFromForm, $params, $admin_msgs, $msg, $submit_model, $file ['is_in_server'] )) {
				
				$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
				return;
			}
			$msg = JText::_ ( 'PICTURE_ADDED' );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option, $msg );
	
	}
	
	function editPicture(&$dataFromForm) {
		global $option;
		
		
		$issetArray = array ('id', 'new_cat', 'cat_id', 'published', 'title' );
		foreach ( $issetArray as $issetElement ) {
			switch (isset ( $dataFromForm [$issetElement] )) {
				case true :
					break;
				case false :
					$msg = JText::_ ( 'FORM_VAR_CHECK_PROBLEM' );
					$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
					return;
					break;
			}
		}
		
		
		$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		if (! $catRow->exists ( $dataFromForm ['cat_id'] )) {
			$msg = JText::_ ( 'CAT_NOT_EXIST' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
			return;
		}
		
		
		if ($dataFromForm ['new_cat'] != '') {
			
			$newCatData = array ('parent_id' => $dataFromForm ['cat_id'], 'title' => $dataFromForm ['new_cat'] );
			
			if (! $catRow->bind ( $newCatData )) {
				JError::raiseError ( 500, $catRow->getError () );
			}
			
			$catRow->check (); 
			

			if (! $catRow->store ()) {
				JError::raiseError ( 500, $catRow->getError () );
			}
			
			$dataFromForm ['cat_id'] = $catRow->id; 
			

			
			
			if ($dataFromForm ['published']) {
				$catRow->publish ();
			}
		
		}
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		
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
			$msg = JText::_ ( 'PICTURE_SAVED' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg );
		} elseif ($task == 'apply') {
			$msg = JText::_ ( 'CHANGES_APPLIED' );
			$this->setRedirect ( 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id, $msg );
		}
	
	}
	
	function save() {
		global $option;
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		
		$dataFromForm = JRequest::get ( 'post', 4 );
		
		jimport ( 'joomla.filter.filteroutput' );
		
		
		
		
		
		
		

		
		
		
		$noHtmlFilter = & JFilterInput::getInstance ();
		$dataFromForm ['title'] = $noHtmlFilter->clean ( $dataFromForm ['title'] );
		$dataFromForm ['keywords'] = $noHtmlFilter->clean ( $dataFromForm ['keywords'] );
		$dataFromForm ['owner'] = $noHtmlFilter->clean ( $dataFromForm ['owner'] );
		$dataFromForm ['alias'] = $noHtmlFilter->clean ( $dataFromForm ['alias'] );
		
		
		if ($dataFromForm ['tag_ep'] != $dataFromForm ['tag_ep_current']) {
			
			
			$dataFromForm ['tag_ep_date'] = date ( 'Y-m-d H:i:s', time () );
		}
		
		
		$deny_acls = array ('item_deny_acl', 'votes_deny_acl', 'downloads_deny_acl', 'tagging_deny_acl' );
		foreach ( $deny_acls as $deny_acl ) {
			if (isset ( $dataFromForm [$deny_acl] )) {
				$dataFromForm [$deny_acl] = implode ( ',', $dataFromForm [$deny_acl] );
			} else {
				$dataFromForm [$deny_acl] = '';
			}
		}
		
		
		if (isset ( $dataFromForm ['id'] )) {
			if ($dataFromForm ['id'] == 0) {
				
				$this->addPictures ( $dataFromForm );
			} else {
				
				$this->editPicture ( $dataFromForm );
			}
		} else {
			
			$msg = JText::_ ( 'FORM_PICTURE_PROBLEM' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
		}
	}
	
	function publish() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		$publish = 1;
		
		if ($this->getTask () == 'unpublish') {
			$publish = 0;
		}
		
		if (! $row->publish ( $cid, $publish )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if ($this->getTask () == 'unpublish') {
			$msg = JText::_ ( 'PICTURES_UNPUBLISHED' );
		} else {
			$msg = JText::_ ( 'PICTURES_PUBLISHED' );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option, $msg );
	}
	
	function remove() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option, $mainframe;
		
		
		
		$lockedFilesMsgSent = 0;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		$picRow = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		$picture_model = & $this->getModel ( 'picture' );
		
		$db = & JFactory::getDBO ();
		
		$user = & JFactory::getUser ();
		
		
		$cid_removed_count = 0;
		
		
		foreach ( $cid as $id ) {
			
			$id = ( int ) $id;
			
			$picRow->load ( $id );
			
			
			if (JTable::isCheckedOut ( $user->id, $picRow->checked_out )) {
				$msg = JText::sprintf ( 'ITEM_CHECKED_OUT', $picRow->title );
				$mainframe->enqueueMessage ( $msg, 'error' );
				continue;
			}
			
			
			$picRow->checkout ( $user->id );
			
			$uploadDate = strtotime ( $picRow->upload_date );
			
			
			$filesToDelete = JPATH_SITE . DS . 'jwallpapers_files' . DS . date ( 'Y', $uploadDate ) . DS . date ( 'n', $uploadDate ) . DS . '*' . $picRow->file_name . '.*';
			
			foreach ( glob ( $filesToDelete ) as $filename ) {
				unlink ( $filename );
			}
			
			
			$picture_model->dropVotes ( $id );
			$picture_model->dropComments ( $id );
			
			if (! $picRow->delete ( $id )) {
				JError::raiseError ( 500, $picRow->getError () );
			}
			
			$cid_removed_count ++;
		
		}
		
		$pictures_model = & $this->getModel ( 'pictures' );
		
		
		$pictures_model->deleteResizeList ( $cid );
		
		
		$pictures_model->deleteTaggedPics ( $cid );
		
		if ($cid_removed_count > 1) {
			$msg = JText::_ ( 'PICTURES_DELETED' );
		} elseif ($cid_removed_count == 1) {
			$msg = JText::_ ( 'PICTURE_DELETED' );
		} else {
			$msg = '';
		}
		$this->setRedirect ( 'index.php?option=' . $option, $msg );
	}
	
	function ajaxGetCat() {
		
		global $option;
		
		$catId = JRequest::getInt ( 'id', 0 );
		
		
		$this->setRedirect ( 'index.php?option=' . $option . '&referer=ajaxGetCat&task=display&view=picture&format=raw&id=' . $catId );
	}
	
	function display() {
		
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'pictures' );
		}
		
		parent::display ();
	}
	
	function ratingsReset() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->ratingsReset ();
		
		$msg = JText::_ ( 'RATINGS_RESET_SUCCESSFUL' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
	
	function allRatingsReset() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->allRatingsReset ();
		
		$msg = JText::_ ( 'RATINGS_RESET_SUCCESSFUL' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
	
	
	function ajaxRefreshUntagPicLayout() {
		
		global $option;
		
		$pic_id = JRequest::getInt ( 'pic_id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=ajaxRefreshUntagPicLayout&pic_id=' . $pic_id );
	
	}
	
	
	function addResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$h = JRequest::getInt ( 'h' );
		$w = JRequest::getInt ( 'w' );
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$id = ( int ) $cid [0];
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File_Resize', 'Table' );
		
		$newResizeData = array ('width' => $w, 'height' => $h, 'file_id' => $id );
		
		if (! $row->bind ( $newResizeData )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures&view=picture&format=raw&referer=addResize&cid[]=' . $id );
	
	}
	
	
	function delResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'DEFAULT', 'array' );
		$pic_id = ( int ) $cid [0];
		
		$id = JRequest::getInt ( 'id' );
		
		$row = & JTable::getInstance ( 'JWallpapers_File_Resize', 'Table' );
		
		$row->load ( $id );
		
		if (! $row->delete ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures&view=picture&format=raw&referer=delResize&cid[]=' . $pic_id );
	
	}
	
	
	function enableVotes() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->setVotesStatus ( 'en' );
		
		$msg = JText::_ ( 'VOTES_SUCCESSFULLY_ENABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
	
	
	function disableVotes() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->setVotesStatus ( 'dis' );
		
		$msg = JText::_ ( 'VOTES_SUCCESSFULLY_DISABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
	
	
	function enableDownloads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->setDownloadableStatus ( 'en' );
		
		$msg = JText::_ ( 'DOWNLOADS_SUCCESSFULLY_ENABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
	
	
	function disableDownloads() {
		
		
		
		JRequest::checkToken () or JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		global $option;
		
		$model = & $this->getModel ( 'pictures' );
		
		$model->setDownloadableStatus ( 'dis' );
		
		$msg = JText::_ ( 'DOWNLOADS_SUCCESSFULLY_DISABLED' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=pictures', $msg );
		
		return;
	
	}
}
?>