<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

class JWallpapersViewSettings extends JView {
	function display($tpl = null) {
		
		global $option, $mainframe;
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'administrator/components/' . $option . '/css/' );
		
		$model = & $this->getModel ( 'settings' );
		
		$allowedResolutions =& $model->getAllowedResolutions ();
		$global_resizes =& $model->getGlobalResizes ();
		
		
		$component = JComponentHelper::getComponent ( $option );
		$paramsdata = $component->params;
		
		
		$paramsdefs = JPATH_COMPONENT . DS . 'config.xml';
		
		$params = new JParameter ( $paramsdata, $paramsdefs );
		
		
		$gd_ver = (function_exists ( 'gd_info' )) ? gd_info () : array ();
		$imagick_exists = (class_exists ( 'Imagick' )) ? 1 : 0;
		If ($imagick_exists) {
			$imagick = new Imagick ( );
			$imagick_ver = $imagick->getVersion ();
		} else {
			$imagick_ver = array ();
		}
		
		
		$image_library_select_opts = array ();
		$image_libraries_info = array ();
		
		if (! empty ( $gd_ver )) {
			$image_library_select_opts [] = ($params->get ( 'image_library' ) == 'GD') ? '<option selected="selected">GD</option>' : '<option>GD</option>';
			
			$image_libraries_info [] = '<li>GD: <span class="green_msg">' . $gd_ver ['GD Version'] . '</span>';
		} else {
			
			$image_libraries_info [] = '<li>GD: <span class="red_msg">' . JText::_ ( 'NOT_INSTALLED' ) . '</span>';
		}
		if (! empty ( $imagick_ver )) {
			$image_library_select_opts [] = ($params->get ( 'image_library' ) == 'Imagick') ? '<option selected="selected">Imagick</option>' : '<option>Imagick</option>';
			
			$image_libraries_info [] = '<li>Imagick: <span class="green_msg">' . $imagick_ver ['versionString'] . '</span>';
		} else {
			
			$image_libraries_info [] = '<li>Imagick: <span class="red_msg">' . JText::_ ( 'NOT_INSTALLED' ) . '</span>';
		}
		
		
		
		
		$apache_conf_chk_file_path = JPATH_ROOT . DS . 'jwallpapers_files' . DS . 'apache_conf_chk_file.txt';
		
		if (! file_exists ( $apache_conf_chk_file_path )) {
			
			touch ( $apache_conf_chk_file_path );
		}
		$apache_conf_chk_file_url = JURI::root () . 'jwallpapers_files/apache_conf_chk_file.txt';
		$apache_conf_chk_link = '<a class="ajax_chk_apache_link button_link" href="' . $apache_conf_chk_file_url . '">' . JText::_ ( 'APACHE_CONF_CHECK_TEST' ) . '</a>';
		
		
		$ajax_regenerate_thumbs_link = '<a class="ajax_regenerate_thumbs_link button_link" href="index.php?option=' . $option . '&controller=settings&task=ajaxRegenerateThumbs&' . JUtility::getToken () . '=1">' . JText::_ ( 'REGENERATE_THUMBS' ) . '</a>';
		$ajax_regenerate_resizes_link = '<a class="ajax_regenerate_resizes_link button_link" href="index.php?option=' . $option . '&controller=settings&task=ajaxRegenerateResizes&' . JUtility::getToken () . '=1">' . JText::_ ( 'REGENERATE_RESIZES' ) . '</a>';
		$ajax_delete_water_orgs_link = '<a class="ajax_delete_water_orgs_link button_link" href="index.php?option=' . $option . '&controller=settings&task=ajaxDeleteWaterOrgs&' . JUtility::getToken () . '=1">' . JText::_ ( 'DELETE_WATER_ORGS' ) . '</a>';
		
		$this->assign ( 'apache_conf_chk_link', $apache_conf_chk_link );
		$this->assignRef ( 'jwresizes_sec_chk', JHTML::_ ( 'select.booleanlist', 'jwresizes_sec_chk', 'class="inputbox"', $params->get ( 'jwresizes_sec_chk' ) ) );
		$this->assignRef ( 'safe_exec_mode', JHTML::_ ( 'select.booleanlist', 'safe_exec_mode', 'class="inputbox"', $params->get ( 'safe_exec_mode' ) ) );
		$this->assignRef ( 'image_library_select_opts', $image_library_select_opts );
		$this->assignRef ( 'image_libraries_info', $image_libraries_info );
		$this->assignRef ( 'allowedResolutions', $allowedResolutions );
		$this->assignRef ( 'global_resizes', $global_resizes );
		$this->assignRef ( 'params', $params );
		$this->assign ( 'ajax_regenerate_thumbs_link', $ajax_regenerate_thumbs_link );
		$this->assign ( 'ajax_regenerate_resizes_link', $ajax_regenerate_resizes_link );
		$this->assign ( 'ajax_delete_water_orgs_link', $ajax_delete_water_orgs_link );
		
		parent::display ( $tpl );
	
	}
}
?>