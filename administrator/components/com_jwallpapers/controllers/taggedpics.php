<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: taggedpics.php 248 2010-03-30 17:17:52Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class JWallpapersControllerTaggedPics extends JController {
	function __construct($config = array()) {
		parent::__construct ( $config );
		
		$this->registerTask ( 'unpublish', 'publish' );
	
	}
	
	function publish() {
		
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tagged_File', 'Table' );
		
		$publish = 1;
		$msg = JText::_ ( 'TAGS_ENABLED' );
		
		if ($this->getTask () == 'unpublish') {
			$publish = 0;
			$msg = JText::_ ( 'TAGS_DISABLED' );
		}
		
		if (! $row->publish ( $cid, $publish )) {
			JError::raiseError ( 500, $row->getError () );
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=taggedpics', $msg );
	
	}
	
	function remove() {
		JRequest::checkToken () or jexit ( 'Invalid Token' );
		
		global $option, $mainframe;
		
		$cid = JRequest::getVar ( 'cid', array (), 'DEFAULT', 'array' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tagged_File', 'Table' );
		
		foreach ( $cid as $id ) {
			
			
			if (! $row->delete ( $id )) {
				Error::raiseError ( 500, $row->getError () );
			}
		
		}
		
		if (count ( $cid ) > 1) {
			$msg = JText::_ ( 'TAGS_REMOVED' );
		} else {
			$msg = JText::_ ( 'TAG_REMOVED' );
		}
		$this->setRedirect ( 'index.php?option=' . $option . '&controller=taggedpics', $msg );
	
	}
	
	function ajaxTagPicture() {
		
		global $option;
		
		
		JRequest::checkToken ( 'get' ) or die ( 'Invalid Token' );
		
		$tag_obj = new stdClass ( );
		$new_tag = strtolower ( JRequest::getString ( 'new_tag', null ) );
		if (! empty ( $new_tag )) {
			$tag_obj->new = 1;
			$tag_obj->title = $new_tag;
		} else {
			$tag_id = JRequest::getInt ( 'tag_id', 0 );
			$tag_obj->new = 0;
			$tag_obj->id = $tag_id;
		}
		$pic_id = JRequest::getInt ( 'pic_id', 0 );
		
		$model = & $this->getModel ( 'taggedpics' );
		
		
		$status = $model->tag_picture ( $pic_id, $tag_obj, 1 );
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&status=' . $status . '&referer=ajaxTagPicture' );
	
	}
	
	function ajaxRemovePicTag() {
		
		global $option;
		
		
		JRequest::checkToken ( 'get' ) or die ( 'Invalid Token' );
		
		$row = & JTable::getInstance ( 'JWallpapers_Tagged_File', 'Table' );
		
		$id = JRequest::getInt ( 'id', 0 );
		$pic_id = JRequest::getInt ( 'pic_id', 0 );
		
		$status = 1;
		if (! $row->delete ( $id )) {
			$status = 0;
		}
		
		$this->setRedirect ( 'index.php?option=' . $option . '&view=picture&format=raw&referer=ajaxRemovePicTag&pic_id=' . $pic_id . '&status=' . $status );
	
	}
	
	function display() {
		
		$view = JRequest::getVar ( 'view' );
		
		if (! $view) {
			JRequest::setVar ( 'view', 'taggedpics' );
		}
		
		parent::display ();
	}

}
?>