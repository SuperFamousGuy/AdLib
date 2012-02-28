<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: settings.php 310 2010-05-17 14:56:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerSettings extends JController {
	function __construct($config = array()) {
		parent::__construct ( $config );
		
		$this->registerTask ( 'apply', 'save' ); 
	}
	
	function display() {
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'settings' );
		}
		
		parent::display ();
	}
	
	
	function addAllowedRes() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$h = JRequest::getInt ( 'h' );
		$w = JRequest::getInt ( 'w' );
		
		
		$row = & JTable::getInstance ( 'JWallpapers_Allowed_Resolutions', 'Table' );
		
		$newAllowedResData = array ('width' => $w, 'height' => $h );
		
		if (! $row->bind ( $newAllowedResData )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=settings&format=raw&w=' . $w . '&h=' . $h . '&referer=addAllowedRes' );
	}
	
	
	function delAllowedRes() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$id = JRequest::getInt ( 'id' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Allowed_Resolutions', 'Table' );
		
		$row->load ( $id );
		
		if (! $row->delete ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=settings&format=raw&referer=delAllowedRes' );
	
	}
	
	
	function save() {
		global $option, $mainframe;
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		$dataFromForm = JRequest::get ( 'post' );
		
		
		
		
		

		
		
		$component = & JTable::getInstance ( 'Component', 'JTable' );
		
		
		$dataFromForm ['params'] ['image_library'] = $dataFromForm ['image_library'];
		
		
		
		if ($dataFromForm ['params'] ['comments'] == 1) {
			$jcomments_plugins_path = JPATH_ROOT . DS . 'components' . DS . 'com_jcomments' . DS . 'plugins';
			
			if (file_exists ( $jcomments_plugins_path )) {
				
				if (! file_exists ( $jcomments_plugins_path . DS . 'com_jwallpapers.plugin.php' )) {
					
					jimport ( 'joomla.filesystem.file' );
					$jwallpapers_plugin_path = JPATH_BASE . DS . 'components' . DS . $option . DS . 'extras';
					if (! JFile::copy ( $jwallpapers_plugin_path . DS . 'com_jwallpapers.plugin.php', $jcomments_plugins_path . DS . 'com_jwallpapers.plugin.php' )) {
						$msg = JText::_ ( 'FILE_COPY_FAILED' );
						$this->setRedirect ( 'index.php?option=' . $option . '&controller=settings', $msg, 'error' );
						return;
					}
				}
			} else {
				
				$dataFromForm ['params'] ['comments'] = 0;
				$mainframe->enqueueMessage ( JText::_ ( 'JCOMMENTS_NOT_INSTALLED' ), 'error' );
			}
		
		}
		
		
		if ($dataFromForm ['params'] ['comments'] == 2) {
			$jomcomment_path = JPATH_ROOT . DS . 'components' . DS . 'com_jomcomment';
			if (! file_exists ( $jomcomment_path )) {
				$dataFromForm ['params'] ['comments'] = 0;
				$mainframe->enqueueMessage ( JText::_ ( 'JOMCOMMENT_NOT_INSTALLED' ), 'error' );
			}
		}
		
		
		$dataFromForm ['params'] ['sef_picture'] = str_replace ( '-', ':', $dataFromForm ['params'] ['sef_picture'] );
		$dataFromForm ['params'] ['sef_category'] = str_replace ( '-', ':', $dataFromForm ['params'] ['sef_category'] );
		$dataFromForm ['params'] ['sef_special'] = str_replace ( '-', ':', $dataFromForm ['params'] ['sef_special'] );
		$dataFromForm ['params'] ['sef_submit'] = str_replace ( '-', ':', $dataFromForm ['params'] ['sef_submit'] );
		
		
		$dataFromForm ['params'] ['upload_boxes'] = abs ( ( int ) $dataFromForm ['params'] ['upload_boxes'] );
		if (! $dataFromForm ['params'] ['upload_boxes'] || $dataFromForm ['params'] ['upload_boxes'] > 5) {
			$dataFromForm ['params'] ['upload_boxes'] = 1;
		}
		
		
		if (! $component->loadByOption ( $option )) {
			JError::raiseError ( 500, $component->getError () );
		}
		
		
		
		if (! $component->bind ( $dataFromForm )) {
			JError::raiseError ( 500, $component->getError () );
		}
		
		if (! $component->store ()) {
			JError::raiseError ( 500, $component->getError () );
		}
		
		
		
		

		
		if (! JWallpapersHelperImage::updateResizeList ( $dataFromForm )) {
			$msg = JText::_ ( 'FORM_VAR_CHECK_PROBLEM' );
			$this->setRedirect ( 'index.php?option=' . $option, $msg, 'error' );
			return;
		}
		
		$task = JRequest::getVar ( 'task', 'save' );
		
		$msg = JText::_ ( 'SETTINGS_CHANGED' );
		if ($task == 'apply') {
			
			$this->setRedirect ( 'index.php?option=' . $option . '&controller=settings', $msg );
		} elseif ($task == 'save') {
			
			$this->setRedirect ( 'index.php?option=' . $option, $msg );
		}
	
	}
	
	
	function ajaxDeleteWaterOrgs() {
		
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$jwallpapers_files_path = JPATH_ROOT . DS . 'jwallpapers_files' . DS;
		JWallpapersHelperSystem::deleteFilesFromPath ( $jwallpapers_files_path, '/water/i', true );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=settings&referer=ajaxDeleteWaterOrgs' );
	
	}
	
	
	function ajaxRegenerateResizes() {
		
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		
		$jwallpapers_files_path = JPATH_ROOT . DS . 'jwallpapers_files' . DS;
		JWallpapersHelperSystem::deleteAllResizesFromPath ( $jwallpapers_files_path );
	
	}
	
	
	function ajaxRegenerateThumbs() {
		
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		
		$jwallpapers_files_path = JPATH_ROOT . DS . 'jwallpapers_files' . DS;
		JWallpapersHelperSystem::deleteFilesFromPath ( $jwallpapers_files_path, '/thumb/i', true );
	
	}
	
	
	function addResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$h = JRequest::getInt ( 'h' );
		$w = JRequest::getInt ( 'w' );
		
		$size_formats = JRequest::getVar ( 'size_formats', '0,1,2,3,4' );
		
		
		$row = & JTable::getInstance ( 'JWallpapers_Global_Resize', 'Table' );
		
		$newResizeData = array ('width' => $w, 'height' => $h, 'size_formats' => $size_formats );
		
		if (! $row->bind ( $newResizeData )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		if (! $row->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=settings&view=settings&format=raw&referer=addResize' );
	
	}
	
	
	function delResize() {
		global $option;
		
		JRequest::checkToken ( 'get' ) or jexit ( 'Invalid Token' );
		
		$id = JRequest::getInt ( 'id' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Global_Resize', 'Table' );
		
		$row->load ( $id );
		
		if (! $row->delete ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=settings&view=settings&format=raw&referer=delResize' );
	
	}
}
?>