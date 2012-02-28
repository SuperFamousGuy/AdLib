<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: jwallpapers.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

global $mainframe;

JTable::addIncludePath ( JPATH_COMPONENT . DS . 'tables' );

require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'layout.php');
require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'image.php');
require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'system.php');

$controller = JRequest::getCmd ( 'controller', 'pictures' );

JSubMenuHelper::addEntry ( JText::_ ( 'PICTURES' ), 'index.php?option=' . $option . '&controller=pictures' );
JSubMenuHelper::addEntry ( JText::_ ( 'CATEGORIES' ), 'index.php?option=' . $option . '&controller=categories' );
JSubMenuHelper::addEntry ( JText::_ ( 'SETTINGS' ), 'index.php?option=' . $option . '&controller=settings' );
JSubMenuHelper::addEntry ( JText::_ ( 'TAGS' ), 'index.php?option=' . $option . '&controller=tags' );
JSubMenuHelper::addEntry ( JText::_ ( 'ABOUT' ), 'index.php?option=' . $option . '&controller=about' );








require_once (JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php');

switch ($controller) {
	case 'pictures' :
		$controllerName = 'JWallpapersControllerPictures';
		break;
	case 'categories' :
		$controllerName = 'JWallpapersControllerCategories';
		break;
	case 'settings' :
		$controllerName = 'JWallpapersControllerSettings';
		break;
	case 'tags' :
		$controllerName = 'JWallpapersControllerTags';
		break;
	case 'taggedpics' :
		$controllerName = 'JWallpapersControllerTaggedPics';
		break;
	case 'about' :
		$controllerName = 'JWallpapersControllerAbout';
		break;
}

$controller = new $controllerName ( );
$controller->execute ( JRequest::getCmd ( 'task' ) );
$controller->redirect ();

?>