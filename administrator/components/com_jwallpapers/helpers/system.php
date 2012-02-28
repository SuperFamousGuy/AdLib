<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: system.php 349 2010-05-31 12:58:41Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JWallpapersHelperSystem {
	
	
	
	function deleteFilesFromPath($path, $reg_exp, $recursive) {
		
		if (is_dir ( $path )) {
			$dh = opendir ( $path );
			if ($dh) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ($file != '.' && $file != '..') {
						if (is_dir ( $path . $file ) && $recursive) {
							
							JWallpapersHelperSystem::deleteFilesFromPath ( $path . $file . DS, $reg_exp, $recursive );
						} else {
							
							if (preg_match ( $reg_exp, $file )) {
								unlink ( $path . $file );
							}
						}
					}
				}
			}
			closedir ( $dh );
		}
	
	}
	
	
	function deleteAllResizesFromPath($path) {
		
		if (is_dir ( $path )) {
			$dh = opendir ( $path );
			if ($dh) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ($file != '.' && $file != '..') {
						if (is_dir ( $path . $file )) {
							
							JWallpapersHelperSystem::deleteAllResizesFromPath ( $path . $file . DS );
						} else {
							
							if (preg_match ( '/^[0-9]+_[0-9]+/', $file )) {
								unlink ( $path . $file );
							}
						}
					}
				}
			}
			closedir ( $dh );
		}
	
	}
	
	
	
	function showCaptcha() {
		
		global $option;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$user = & JFactory::getUser ();
		$userId = $user->id;
		
		$show_frontend_captcha = $params->get ( 'show_frontend_captcha' );
		
		switch ($show_frontend_captcha) {
			default :
				$show_frontend_captcha = 0;
			case 0 :
				
				return false;
				break;
			case 1 :
				
				return true;
				break;
			case 2 :
				
				if ($userId) {
					
					return false;
				} else {
					
					return true;
				}
				break;
		}
	
	}
	
	
	function checkCaptcha($keystring) {
		
		$session = & JFactory::getSession ();
		$captcha_keystring = $session->get ( 'captcha_keystring' );
		
		if (! (isset ( $captcha_keystring ) && $captcha_keystring == $keystring)) {
			return 0;
		} else {
			return 1;
		}
	
	}
	
	
	function isWin() {
		
		$op_sys_name = php_uname ( 's' );
		
		if (stristr ( $op_sys_name, 'WIN' ) && ! stristr ( $op_sys_name, 'DARWIN' )) {
			
			return true;
		} else {
			
			return false;
		}
	
	}
	
	
	
	function isFormDataComplete($data_array, $fields) {
		
		foreach ( $fields as $field ) {
			switch (isset ( $data_array [$field] )) {
				case true :
					break;
				case false :
					
					return false;
					break;
			}
		}
		
		
		return true;
	
	}
	
	function sendPM($from_userid, $to_userid, $msgs) {
		
		$db = & JFactory::getDBO ();
		
		$from_userid_filtered = ( int ) $from_userid;
		$to_userid_filtered = ( int ) $to_userid;
		
		
		$query = 'SELECT COUNT(*) FROM #__users WHERE id IN (' . $from_userid_filtered . ',' . $to_userid_filtered . ')';
		$db->setQuery ( $query );
		$result = $db->loadResult ();
		
		switch ($result) {
			case 1 :
				
				if ($from_userid_filtered != $to_userid_filtered) {
					
					return;
				}
				
				break;
			case 2 :
				
				break;
			default :
				
				return;
				break;
		}
		
		
		require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_messages' . DS . 'tables' . DS . 'message.php');
		
		$adminMsg = new TableMessage ( $db );
		
		$msg = implode ( "\n", $msgs );
		
		$adminMsg->send ( $from_userid_filtered, $to_userid_filtered, JText::_ ( 'NEW_PICS' ), $msg );
	
	}
	
	function sendEmail($from_userid, $to_userid, $msgs) {
		
		$user = & JTable::getInstance ( 'user' );
		
		$from_userid_filtered = ( int ) $from_userid;
		$to_userid_filtered = ( int ) $to_userid;
		
		$msg = implode ( "\n", $msgs );
		
		$mailer = & JFactory::getMailer ();
		
		
		$user->load ( $from_userid_filtered );
		if (! $user->id) {
			
			return;
		}
		$mailer->setSender ( $user->email );
		
		
		$user->load ( $to_userid_filtered );
		if (! $user->id) {
			
			return;
		}
		$mailer->addRecipient ( $user->email );
		
		
		$mailer->setSubject ( JText::_ ( 'NEW_PICS' ) );
		$mailer->setBody ( $msg );
		
		
		$mailer->Send ();
	
	}
	
	
	function getParamsFromRow(&$row) {
		
		return new JParameter ( $row->params );
	
	}
	
	
	
	
	function filterIdList($ids) {
		$ids = explode ( ',', $ids );
		$id_array = array ();
		
		foreach ( $ids as $id ) {
			
			$id = ( int ) $id;
			
			if ($id == 0) {
				$ids_str = 0;
				break;
			}
			$id_array [] = $id;
		}
		
		if (! isset ( $ids_str )) {
			$ids_str = implode ( ',', $id_array );
		}
		
		return $ids_str;
	
	}
	
	
	
	
	
	
	function authorize($aco, $mode = 'grant') {
		
		global $option;
		
		$user = & JFactory::getUser ();
		
		
		
		
		if (empty ( $user->usertype )) {
			$user->usertype = 'Public Frontend';
		}
		
		switch ($mode) {
			case 'deny' :
				
				if ($user->authorize ( $option, $aco )) {
					return false;
				} else {
					return true;
				}
				break;
			default :
				$mode = 'grant';
			case 'grant' :
				
				if ($user->authorize ( $option, $aco )) {
					return true;
				} else {
					return false;
				}
				break;
		}
	
	}
	
	
	function getUserAroGroupID() {
		
		$user = & JFactory::getUser ();
		$acl = & JFactory::getACL ();
		
		
		return $acl->get_group_id ( (empty ( $user->usertype )) ? 'Public Frontend' : $user->usertype, 'ARO' );
	
	}
	
	
	function getCoreACLAroGroupsIDS() {
		
		
		$db = & JFactory::getDBO ();
		$query = 'SELECT id FROM #__core_acl_aro_groups';
		$db->setQuery ( $query );
		return $db->loadResultArray ();
	}
	
	
	function getCoreACLAroGroups() {
		
		
		$db = & JFactory::getDBO ();
		
		
		$query = 'SELECT id, name AS title FROM #__core_acl_aro_groups WHERE id NOT IN (17,28)';
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	
	function prepareACL($aco_value, &$core_acl_aro_groups, &$pic_row, &$cat_row) {
		
		global $option;
		
		$acl_obj = & JFactory::getACL ();
		
		$deny_acl = array ();
		
		switch ($aco_value) {
			case 'view_item' :
				if (! empty ( $pic_row->item_deny_acl )) {
					
					$deny_acl = explode ( ',', $pic_row->item_deny_acl );
				} elseif (! empty ( $cat_row->item_deny_acl )) {
					
					
					$deny_acl = explode ( ',', $cat_row->item_deny_acl );
				}
				break;
			case 'vote' :
				
				if (! empty ( $pic_row->votes_deny_acl )) {
					
					$deny_acl = explode ( ',', $pic_row->votes_deny_acl );
				} elseif (! empty ( $cat_row->votes_deny_acl )) {
					
					$deny_acl = explode ( ',', $cat_row->votes_deny_acl );
				}
				break;
			case 'download' :
				
				if (! empty ( $pic_row->downloads_deny_acl )) {
					
					$deny_acl = explode ( ',', $pic_row->downloads_deny_acl );
				} elseif (! empty ( $cat_row->downloads_deny_acl )) {
					
					$deny_acl = explode ( ',', $cat_row->downloads_deny_acl );
				}
				break;
			case 'tagging' :
				
				if (! empty ( $pic_row->tagging_deny_acl )) {
					
					$deny_acl = explode ( ',', $pic_row->tagging_deny_acl );
				} elseif (! empty ( $cat_row->tagging_deny_acl )) {
					
					$deny_acl = explode ( ',', $cat_row->tagging_deny_acl );
				}
				break;
			case 'uploads' :
				
				if (! empty ( $cat_row->uploads_deny_acl )) {
					
					$deny_acl = explode ( ',', $cat_row->uploads_deny_acl );
				}
				break;
		}
		
		
		$acl = array_diff ( $core_acl_aro_groups, $deny_acl );
		
		foreach ( $acl as $acl_item ) {
			$acl_obj->addACL ( $option, $aco_value, 'users', $acl_obj->get_group_name ( $acl_item ) );
		}
	
	}

}

?>