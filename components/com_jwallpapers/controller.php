<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: controller.php 351 2010-06-01 09:32:08Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


defined ( '_JEXEC' ) or die ( 'Restricted Access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersController extends JController {
	
	function display() {
		
		global $option;
		
		
		$document = & JFactory::getDocument ();
		
		
		
		$document->setBase ( JURI::base () ); 
		$viewName = JRequest::getVar ( 'view', 'home' ); 
		$viewFormat = JRequest::getVar ( 'format', 'html' );
		$viewType = $document->getType ();
		$view = & $this->getView ( $viewName, $viewType ); 
		$model = & $this->getModel ( $viewName ); 
		if (! JError::isError ( $model )) {
			$view->setModel ( $model, true ); 
		}
		
		

		
		if (($viewName == 'picture' || $viewName == 'category') && $viewFormat == 'html') {
			$model->hit ();
		}
		
		if ($viewName == 'taggedpics' && $viewFormat == 'html') {
			
			$model->hit ();
		}
		
		$view->display ();
	}
	
	function vote() {
		
		global $option, $mainframe;
		
		$id = JRequest::getInt ( 'id', 0 );
		
		$user = & JFactory::getUser ();
		$user_id = $user->id;
		
		
		$this->voteSecCheck ( $id );
		
		$row = & JTable::getInstance ( 'JWallpapers_vote', 'Table' );
		
		
		switch (JRequest::getInt ( 'value', 0 )) {
			default :
				
				die ( 'Illegal Vote' );
				break;
			case 1 :
				$value = 1;
				break;
			case 2 :
				$value = 2;
				break;
			case 3 :
				$value = 3;
				break;
			case 4 :
				$value = 4;
				break;
			case 5 :
				$value = 5;
				break;
		}
		
		$data = array ('file_id' => $id, 'user_id' => $user_id, 'value' => $value );
		if (! $row->bind ( $data )) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		if (! $row->store ()) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		$model = & $this->getModel ( 'picture' );
		$cache = $model->getVoteCache ();
		$row = & JTable::getInstance ( 'JWallpapers_vote_cache', 'Table' );
		
		if (! $row->bind ( $cache )) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		if (! $row->store ()) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		
		JPluginHelper::importPlugin ( 'jwallpapers' );
		
		$mainframe->triggerEvent ( 'onAfterJWallpapersVote', array () );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&id=' . $id . '&view=picture&format=raw&referer=vote' );
	
	}
	
	
	
	function voteSecCheck($id) {
		
		global $option, $mainframe;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		
		
		
		
		JRequest::checkToken ( 'get' ) or die ( 'Invalid Token' );
		
		
		$pic_row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		if (! $pic_row->load ( $id )) {
			die ( 'JW Voting System security check: The picture does not exists' );
		}
		
		
		if (! ($params->get ( 'votes' ) && $pic_row->votes_en)) {
			die ( 'JW Voting System security check: Votes are disabled' );
		}
		
		
		$auth_vote_status = 1;
		
		
		
		JPluginHelper::importPlugin ( 'jwallpapers' );
		$mainframe->triggerEvent ( 'onInitJWallpapersVote' );
		$mainframe->triggerEvent ( 'onPrepareJWallpapersVote', array (&$auth_vote_status ) );
		
		
		if (! $auth_vote_status) {
			die ( 'Illegal Vote' );
		}
		
		
		$session = & JFactory::getSession (); 
		$cantVoteIds = $session->get ( 'vote', array (), $option );
		
		
		if (in_array ( $id, $cantVoteIds )) {
			die ( 'Illegal Vote' );
		}
		
		
		
		if (! JWallpapersHelperSystem::authorize ( 'vote' )) {
			die ( 'Illegal Vote' );
		}
		
		return;
	
	}
	
	function ajaxGetCat() {
		global $option;
		
		$catId = JRequest::getInt ( 'id', 0 );
		
		
		$this->setRedirect ( 'index.php?option=' . $option . '&referer=ajaxGetCat&task=display&view=submit&format=raw&id=' . $catId );
	
	}
	
	
	function ajaxGetPicsFromCat() {
		
		global $option;
		
		$id = JRequest::getInt ( 'id', 0 );
		$cat_id = JRequest::getInt ( 'cat_id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=ajaxGetPicsFromCat&cat_id=' . $cat_id . '&id=' . $id );
	
	}
	
	
	
	function ajaxGetImageUrl() {
		
		global $option;
		
		$pic_pos = JRequest::getInt ( 'pos', 0 );
		$cat_id = JRequest::getInt ( 'cat_id', 0 );
		$pics_count = JRequest::getInt ( 'pics_count', 0 );
		$item_id = JRequest::getInt ( 'item_id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&pos=' . $pic_pos . '&cat_id=' . $cat_id . '&pics_count=' . $pics_count . '&item_id=' . $item_id . '&referer=ajaxGetImageUrl' );
	
	}
	
	function addPictures() {
		
		
		global $option, $mainframe;
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		
		$admin_msgs = array ();
		
		$selective_resolution = $params->get ( 'selective_resolution' );
		$moderate_cats = $params->get ( 'moderate_cats' );
		$moderate = $params->get ( 'moderate' );
		
		
		$dataFromForm = JRequest::get ( 'post' );
		
		
		$Itemid = JRequest::getInt ( 'Itemid', 0 );
		
		
		$fields = array ('upload_boxes', 'keystring', 'option', 'task', 'Itemid', 'user_id', 'signature', 'title', 'description', 'owner', 'new_cat', 'cat_id' );
		if (! JWallpapersHelperSystem::isFormDataComplete ( $dataFromForm, $fields )) {
			$msg = JText::_ ( 'FORM_VAR_CHECK_ERROR' );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
			return;
		}
		
		
		
		
		if (JWallpapersHelperSystem::showCaptcha ()) {
			if (! JWallpapersHelperSystem::checkCaptcha ( $dataFromForm ['keystring'] )) {
				$msg = JText::_ ( 'FORM_VAL_INSERT_VALID_CODE' );
				$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
				return;
			}
		}
		
		
		if ($dataFromForm ['new_cat'] != '' && ! $params->get ( 'frontend_category_proposal' )) {
			$msg = JText::_ ( 'FORM_VAR_CHECK_ERROR' );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
			return;
			break;
		}
		
		
		$security_key = $params->get ( 'security_key' );
		$hashString = $dataFromForm ['option'] . $dataFromForm ['task'] . $dataFromForm ['Itemid'] . $dataFromForm ['user_id'] . $security_key . $dataFromForm ['upload_boxes'];
		$signature = md5 ( $hashString );
		
		if ($dataFromForm ['signature'] != $signature) {
			
			die ( 'Access Denied' );
		}
		
		
		$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
		if (! $catRow->exists ( $dataFromForm ['cat_id'] )) {
			$msg = JText::_ ( 'CAT_NOT_EXIST' );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
			return;
		}
		
		
		if ($dataFromForm ['new_cat'] != '') {
			
			$newCatData = array ('parent_id' => $dataFromForm ['cat_id'], 'title' => $dataFromForm ['new_cat'] );
			
			if (! $catRow->bind ( $newCatData )) {
				echo "<script> alert('" . $catRow->getError () . "');
	    window.history.go(-1); </script>\n";
				exit ();
			}
			
			
			$catRow->check ();
			
			
			if ($moderate_cats) {
				$catRow->published = 0;
			} else {
				$catRow->published = 1;
			}
			
			if (! $catRow->store ()) {
				echo "<script> alert('" . $catRow->getError () . "');
	    window.history.go(-1); </script>\n";
				exit ();
			}
			
			
			$catRow->validate ();
			
			
			$dataFromForm ['cat_id'] = $catRow->id;
		
		} else {
			
			$catRow->load ( $dataFromForm ['cat_id'] );
			
			
			if (! JWallpapersHelperSystem::authorize ( 'uploads' )) {
				
				$msg = JText::_ ( 'NO_UPLOAD_PRIVILEGES' );
				$this->setRedirect ( JRoute::_ ( 'index.php?option' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
				return;
			}
			
			
			if (! $catRow->frontend_uploads_en) {
				
				$msg = JText::_ ( 'CAT_NOT_UPLOADABLE' );
				$this->setRedirect ( JRoute::_ ( 'index.php?option' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
				return;
			}
		}
		
		
		$dataFromForm ['downloadable'] = $catRow->def_downloadable_front_pics_stat;
		
		
		
		if ($params->get ( 'moderate' )) {
			$dataFromForm ['published'] = 0;
		} else {
			$dataFromForm ['published'] = 1;
		}
		
		
		$dataFromForm ['tag_ep'] = 0;
		$dataFromForm ['tag_ep_date'] = null;
		
		
		$success_counter = 0;
		$failed_counter = 0;
		
		
		$submit_model = & $this->getModel ( 'submit' );
		
		for($i = 0; $i < ( int ) $dataFromForm ['upload_boxes']; $i ++) {
			
			$file = JRequest::getVar ( 'picturefile_' . $i, '', 'files', 'array' );
			
			if ($file ['error'] == 4) {
				
				continue;
			}
			
			if (! JWallpapersHelperImage::processImageFile ( $file, $dataFromForm, $params, $admin_msgs, $msg, $submit_model )) {
				
				if (! empty ( $file ['name'] )) {
					
					$msg = $file ['name'] . ': ' . $msg;
				} else {
					
					$msg = $i . ': ' . $msg;
				}
				$mainframe->enqueueMessage ( $msg, 'notice' );
				$failed_counter ++;
			} else {
				$success_counter ++;
			}
		
		}
		
		
		if (! $success_counter) {
			
			
			if ($dataFromForm ['new_cat'] != '') {
				$catRow->delete ();
			}
			
			$msg = JText::_ ( 'UPLOAD_FAILED' );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option . '&Itemid=' . $Itemid, false ), $msg, 'error' );
			return;
		}
		
		
		if ($failed_counter && $success_counter) {
			$mainframe->enqueueMessage ( JText::_ ( 'UPLOAD_PARTIAL_SUCCESS' ), 'notice' );
		}
		
		
		if (! empty ( $admin_msgs )) {
			
			$msg_to = $params->get ( 'msg_to' );
			$msg_from = $params->get ( 'msg_from' );
			
			switch ($params->get ( 'msg_method' )) {
				case 0 :
					break;
				case 1 :
					
					JWallpapersHelperSystem::sendPM ( $msg_from, $msg_to, $admin_msgs );
					break;
				case 2 :
					
					JWallpapersHelperSystem::sendEmail ( $msg_from, $msg_to, $admin_msgs );
					break;
				case 3 :
					
					JWallpapersHelperSystem::sendPM ( $msg_from, $msg_to, $admin_msgs );
					JWallpapersHelperSystem::sendEmail ( $msg_from, $msg_to, $admin_msgs );
					break;
			}
		
		}
		
		
		$menu = & JSite::getMenu ();
		$menu_item = & $menu->getItem ( $Itemid );
		if (empty ( $menu_item->link )) {
			$redirect_link = 'index.php?option=com_content&view=frontpage';
		} else {
			
			$redirect_link = $menu_item->link . '&Itemid=' . $Itemid;
		}
		
		
		if ($moderate) {
			$msg = JText::_ ( 'UPLOAD_SUCCESS_MOD' );
			$this->setRedirect ( JRoute::_ ( $redirect_link, false ), $msg );
		} else {
			$msg = JText::_ ( 'UPLOAD_SUCCESS' );
			$this->setRedirect ( JRoute::_ ( $redirect_link, false ), $msg );
		}
	
	}
	
	function checkCaptcha() {
		
		global $option;
		
		$keystring = JRequest::getVar ( 'keystring' );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&referer=checkCaptcha&view=submit&format=raw&keystring=' . $keystring );
	
	}
	
	function refreshCaptcha() {
		
		global $option;
		
		$this->setRedirect ( 'index.php?option=' . $option . '&referer=refreshCaptcha&view=submit&format=raw' );
	
	}
	
	
	function download() {
		
		global $option, $mainframe;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$id = JRequest::getInt ( 'id', 0 );
		$width = JRequest::getInt ( 'w', null );
		$height = JRequest::getInt ( 'h', null );
		
		$pic_row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		
		if (! $pic_row->load ( $id )) {
			die ( 'JW Download security check: the picture does not exists' );
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		
		$auth_dld_status = 1;
		
		
		
		JPluginHelper::importPlugin ( 'jwallpapers' );
		$mainframe->triggerEvent ( 'onInitJWallpapersVMDownload' );
		$mainframe->triggerEvent ( 'onPrepareJWallpapersVMDownload', array (&$auth_dld_status ) );
		
		
		if (! JWallpapersHelperSystem::authorize ( 'download' )) {
			$auth_dld_status = 0;
		}
		
		
		if ($params->get ( 'disable_downloads' ) || ! $pic_row->downloadable) {
			$auth_dld_status = 0;
		}
		
		if ($auth_dld_status) {
			if (isset ( $width ) && isset ( $height )) {
				
				JWallpapersHelperImage::sendDownload ( $id, array ('width' => $width, 'height' => $height ) );
			} else {
				
				JWallpapersHelperImage::sendDownload ( $id );
			}
		} else {
			
			
			$this->setRedirect ( JRoute::_ ( 'index.php?option=' . $option, false ), JText::_ ( 'NOT_AUTHORIZED' ), 'notice' );
		}
	
	}
	
	
	function tag_untag_ep() {
		
		global $option;
		
		
		$this_user = & JFactory::getUser ();
		if ($this_user->gid != 25) {
			die ( 'Tag / untag security check: Restricted Access' );
		}
		
		$id = JRequest::getInt ( 'id', 0 );
		$action = JRequest::getVar ( 'action', null );
		
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		
		if (! $row->load ( $id )) {
			die ( 'Tag / untag: Failed to load data' );
		}
		
		$tag_untag_date = date ( 'Y-m-d H:i:s', time () );
		
		switch ($action) {
			case 'tag' :
				$row->tag_ep = 1;
				break;
			case 'untag' :
				$row->tag_ep = 0;
				break;
			default :
				die ();
				break;
		}
		
		
		$row->tag_ep_date = $tag_untag_date;
		
		
		if (! $row->store ()) {
			die ( 'Tag / untag: Failed to store data' );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=tag_untag_ep&action=' . $action . '&id=' . $id );
	
	}
	
	
	function ajaxSearchTag() {
		
		global $option;
		
		$search_string = urlencode ( JRequest::getString ( 'str', '' ) );
		$id = JRequest::getInt ( 'id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=ajaxSearchTag&id=' . $id . '&str=' . $search_string );
	
	}
	
	
	function ajaxTagPicture() {
		
		global $option;
		
		if (! JWallpapersHelperSystem::authorize ( 'tagging' )) {
			die ( 'Ajax tag picture: restricted access' );
		}
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$frontend_tagging = $params->get ( 'frontend_tagging' );
		$moderate_frontend_tagging = $params->get ( 'moderate_frontend_tagging' );
		
		JRequest::checkToken ( 'get' ) or die ( 'Invalid Token' );
		
		
		
		$user = & JFactory::getUser ();
		if ($user->gid == 25) {
			$frontend_tagging = 1;
			$moderate_frontend_tagging = 0;
		}
		
		
		if (! $frontend_tagging) {
			die ( 'Ajax tag picture: this feature is disabled' );
		}
		
		
		if (JWallpapersHelperSystem::showCaptcha ()) {
			$keystring = JRequest::getString ( 'captcha_string', '' );
			if (! JWallpapersHelperSystem::checkCaptcha ( $keystring )) {
				$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&status=-2&referer=ajaxTagPicture' );
				return;
			}
		}
		
		
		
		if ($moderate_frontend_tagging) {
			$enable = 0;
		} else {
			$enable = 1;
		}
		
		$tag_obj = new stdClass ( );
		$new_tag = strtolower ( JRequest::getString ( 'new_tag', null ) );
		if (! empty ( $new_tag )) {
			
			
			if (! ($params->get ( 'frontend_tag_proposal' ) || $user->gid == 25)) {
				die ( 'Ajax tag picture: this feature is disableddd' );
			}
			$tag_obj->new = 1;
			$tag_obj->title = $new_tag;
		} else {
			$tag_id = JRequest::getInt ( 'tag_id', 0 );
			$tag_obj->new = 0;
			$tag_obj->id = $tag_id;
		}
		$pic_id = JRequest::getInt ( 'pic_id', 0 );
		
		
		require_once (JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'models' . DS . 'taggedpics.php');
		$tags_model = new JWallpapersModelTaggedPics ( );
		
		$status = $tags_model->tag_picture ( $pic_id, $tag_obj, $enable );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&status=' . $status . '&referer=ajaxTagPicture' );
	
	}
	
	
	
	function ajaxRefreshPicTagsLayout() {
		
		global $option;
		
		$pic_id = JRequest::getInt ( 'pic_id', 0 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=ajaxRefreshPicTagsLayout&pic_id=' . $pic_id );
	
	}

}

?>