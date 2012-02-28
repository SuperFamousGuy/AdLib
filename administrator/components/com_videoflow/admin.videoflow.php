<?php

//VideoFlow - Joomla Multimedia System for Facebook//
/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2011 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_videoflow'.DS.'tables');
global $vparams;
$lang = JFactory::getLanguage();
$lang->load('com_videoflow', NULL, 'en-GB', false);
$vparams = JTable::getInstance('config', 'Table');
$vparams ->load(1);
if (empty($vparams->mediadir)) $vparams->mediadir = 'videoflow';
$vparams->xmode = 1;

$vparams-> logo = JURI::root().'components/com_videoflow/players/logo.png';
$vparams->fbpwidth = 600;
$vparams->fbpheight = 338;
$vparams->metapwidth = 352;
$vparams->metapheight = 264;

// Load stylesheets required by VideoFlow
$doc = &JFactory::getDocument();
$css = JURI::root().'administrator/components/com_videoflow/css/videoflow.css';
$doc->addStyleSheet( $css, 'text/css', null, array() );
$css2 = JURI::root().'templates/system/css/system.css';
$doc->addStyleSheet( $css2, 'text/css', null, array() );

// Set user permissions for J15: Only administrators and super administrators may manage VideoFlow from backend
if (version_compare(JVERSION, '1.6.0') < 0) {
$auth =& JFactory::getACL();       
$auth->addACL('com_videoflow', 'manage', 'users', 'super administrator');
$auth->addACL('com_videoflow', 'manage', 'users', 'administrator');               

// User must be authorised to view this page
$app = &JFactory::getApplication();
$user = & JFactory::getUser();
if (!$user->authorize( 'com_videoflow', 'manage' )) {
$app->redirect( 'index.php', JText::_('You are not authorised to view this page') );
}
} 

include_once( JPATH_COMPONENT.DS.'utilities'.DS.'videoflow.php' );

$controllerName = JRequest::getCmd( 'c', 'media' );

if($controllerName == 'config') {
	JSubMenuHelper::addEntry(JText::_('Configure'), 'index.php?option=com_videoflow&c=config', true);
	JSubMenuHelper::addEntry(JText::_('Media'), 'index.php?option=com_videoflow');
	JSubMenuHelper::addEntry(JText::_('Upgrade'), 'index.php?option=com_videoflow&c=upgrade');
} elseif ($controllerName == 'upgrade') {
	JSubMenuHelper::addEntry(JText::_('Configure'), 'index.php?option=com_videoflow&c=config');
	JSubMenuHelper::addEntry(JText::_('Media'), 'index.php?option=com_videoflow');
	JSubMenuHelper::addEntry(JText::_('Upgrade'), 'index.php?option=com_videoflow&c=upgrade', true);
} else {
	JSubMenuHelper::addEntry(JText::_('Configure'), 'index.php?option=com_videoflow&c=config');
	JSubMenuHelper::addEntry(JText::_('Media'), 'index.php?option=com_videoflow', true);
	JSubMenuHelper::addEntry(JText::_('Upgrade'), 'index.php?option=com_videoflow&c=upgrade');
}

switch ($controllerName)
{
	default:
		$controllerName = 'media';
	
    case 'media' :
	  case 'config':
	  case 'upgrade':

		require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );
		$controllerName = 'VideoflowController'.$controllerName;

		// Create the controller
		$controller = new $controllerName();

		// Perform the Request task
		$controller->execute( JRequest::getCmd('task') );

		// Redirect if set by the controller
		$controller->redirect();
		break;
}