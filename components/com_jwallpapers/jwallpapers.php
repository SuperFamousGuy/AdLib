<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jwallpapers.php 349 2010-05-31 12:58:41Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

require_once (JPATH_COMPONENT . DS . 'controller.php');




require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'layout.php');
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'system.php');

JTable::addIncludePath ( JPATH_ADMINISTRATOR . DS . 'components' . DS . $option . DS . 'tables' ); 
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . $option . DS . 'helpers' . DS . 'image.php'); 





$format = JRequest::getVar ( 'format' );
if ($format != 'raw') {
	
	$core_acl_aro_groups = JWallpapersHelperSystem::getCoreACLAroGroupsIDS ();
	$id = JRequest::getInt ( 'id', 0 );
	$view = JRequest::getVar ( 'view', null );
	$task = JRequest::getVar ( 'task', null );
	$pic_row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
	$cat_row = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
	
	
	if (isset ( $task )) {
		switch ($task) {
			case 'ajaxTagPicture' :
				
				if (! $pic_row->load ( JRequest::getInt ( 'pic_id', 0 ) )) {
					die ( 'Access Control: invalid picture ID' );
				}
				
				if (! $cat_row->load ( $pic_row->cat_id )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'tagging', $core_acl_aro_groups, $pic_row, $cat_row );
				
				break;
			case 'vote' :
				
				if (! $pic_row->load ( $id )) {
					die ( 'Access Control: invalid picture ID' );
				}
				
				if (! $cat_row->load ( $pic_row->cat_id )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'vote', $core_acl_aro_groups, $pic_row, $cat_row );
				
				break;
			case 'download' :
				
				if (! $pic_row->load ( $id )) {
					die ( 'Access Control: invalid picture ID' );
				}
				
				if (! $cat_row->load ( $pic_row->cat_id )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'download', $core_acl_aro_groups, $pic_row, $cat_row );
				
				break;
			case 'addPictures' :
				$new_cat = JRequest::getVar ( 'new_cat', null, 'post' );
				if (isset ( $new_cat ) && $new_cat == '') {
					$cat_id = JRequest::getInt ( 'cat_id', 0, 'post' );
					
					if (! $cat_row->load ( $cat_id )) {
						die ( 'Access Control: invalid category ID' );
					}
					JWallpapersHelperSystem::prepareACL ( 'uploads', $core_acl_aro_groups, $pic_row, $cat_row );
				}
				break;
		}
	}
	
	
	if (isset ( $view )) {
		switch ($view) {
			case 'picture' :
				
				if (! $pic_row->load ( $id )) {
					die ( 'Access Control: invalid picture ID' );
				}
				
				if (! $cat_row->load ( $pic_row->cat_id )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'view_item', $core_acl_aro_groups, $pic_row, $cat_row );
				JWallpapersHelperSystem::prepareACL ( 'vote', $core_acl_aro_groups, $pic_row, $cat_row );
				JWallpapersHelperSystem::prepareACL ( 'download', $core_acl_aro_groups, $pic_row, $cat_row );
				JWallpapersHelperSystem::prepareACL ( 'tagging', $core_acl_aro_groups, $pic_row, $cat_row );
				break;
			case 'category' :
				
				if (! $cat_row->load ( $id )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'view_item', $core_acl_aro_groups, $pic_row, $cat_row );
				JWallpapersHelperSystem::prepareACL ( 'uploads', $core_acl_aro_groups, $pic_row, $cat_row );
				break;
			case 'submit' :
				
				$def_cat = JRequest::getInt ( 'def_cat', 0 );
				
				if ($def_cat && ! $cat_row->load ( $def_cat )) {
					die ( 'Access Control: invalid category ID' );
				}
				JWallpapersHelperSystem::prepareACL ( 'uploads', $core_acl_aro_groups, $pic_row, $cat_row );
				break;
		}
	}
}



$controller = new JWallpapersController ( );
$controller->execute ( JRequest::getVar ( 'task' ) ); 
$controller->redirect (); 


?>