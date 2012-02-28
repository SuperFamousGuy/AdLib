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

jimport( 'joomla.application.component.controller' );

class VideoflowControllerUpgrade extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.admin', 'com_videoflow')) {
				return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
	}

	function display()
	{
		global $vparams;
		require_once(JPATH_COMPONENT.DS.'views'.DS.'config.php');
		if (!empty($vparams->prostatus)) {
     JError::raiseWarning(500, JText::_( 'VideoFlow is already running in pro mode. If you are experiencing errors, visit <a href="http://www.fidsoft.com" target="_blank">fidsoft.com</a> for support.' ));
    }
		VideoflowViewConfig::donate();
	}
	
function processpro(){  
  $vcode = JRequest::getInt('vcode');
  $version = JRequest::getString('version');
  $error = "ERROR! Upgrade process failed. Please contact fideri@fidsoft.com for help. Quote error code: $vcode";
  $mestype = 'error';
  if ($vcode > 0){
  JExit ("<script> alert('$error VFPRO1'); window.history.go(-1); </script>");
  }
  $email = JRequest::getString('email');
  if (!empty($email)) $email = base64_encode($email);
  $h = & JURI::getInstance();
  $vsite = base64_encode($h->getHost());
  $udir = JPATH_COMPONENT.'/utilities';
  $ufile = $udir.'/utility.php'; 
  $vcode = rand(100000,999999);
  $version = JRequest::getString('version');
  $reg_url = "http://www.fidsoft.com/index.php?option=com_fidsoft&task=regpro&vcode=$vcode&vsite=$vsite&email=$email&version=$version&format=raw";
  $reg = $this->runTool('readRemote', $reg_url); 
  jimport( 'joomla.filesystem.file' );
  if (!empty($reg)) JFile::write($ufile, $reg); else JExit("<script> alert ('$error VFPRO03'); window.history.go(-1); </script>"); 
  if (file_exists ($ufile) ){
  $status = include_once $ufile;
  if (!$status){
  JExit("<script> alert ('$error VFPRO08'); window.history.go(-1); </script>"); 
  } else {
  $error = JText::_("Success! Your status has been temporarily set to Pro pending confirmation of your subscription. No further action is required on your side. Thank you for upgrading.");
  $mestype = 'message';
  }  
  JFile::delete($ufile);
  }
  $link = JRoute::_('index.php?option=com_videoflow'); 
  $this->setRedirect( $link, $error, $mestype);
  }

function autoupdate(){
  global $vparams;
  jimport( 'joomla.filesystem.file' );
  $mes = JText::_('Auto update failed. Please visit www.videoflow.tv for manual update instructions.');
  $mestype = 'error';
  $link = html_entity_decode(JRoute::_('index.php?option=com_videoflow&c=config&vtab=3')); 
  if (empty ($vparams->vmode)) {
  $this->setRedirect( $link, $mes, $mestype);
  return;
	}
  $type = JRequest::getWord('aname');
  $aid = JRequest::getInt('aid');
  $action = JRequest::getWord('action');
  $h = & JURI::getInstance();
  $site = base64_encode($h->getHost());
  if (!$vparams->prostatus){
  $mes = JText::_('Auto update available only with Pro version. Visit www.videoflow.tv for manual update instructions.');
  $this->setRedirect( $link, $mes, $mestype);
  return;
  } 
  $upd_url = "http://www.fidsoft.com/index.php?option=com_fidsoft&task=autofix&type=$type&aid=$aid&action=$action&vcode=$vparams->fkey&vsite=$site&vmode=$vparams->vmode&version=$vparams->version&format=raw";
  $upd = $this->runTool('readRemote', $upd_url); 
  $udir = JPATH_COMPONENT.'/utilities';
  $ufile = $udir.'/vupdate.php'; 
  if (!empty($upd)) JFile::write($ufile, $upd);
  if (file_exists ($ufile) ){
  $status = include_once $ufile;
  if ($status){
  $mes = JText::_("Your system has been updated.");
  $mestype = 'message'; 
  } 
  JFile::delete($ufile);
  }
  $this->setRedirect( $link, $mes, $mestype);
}


function runTool($func=null, $param1=null, $param2=null, $param3=null, $param4=null)
    {
    include_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php';
    $tools = new VideoflowTools();
    $tools->func   = $func;
    $tools->param1 = $param1;
    $tools->param2 = $param2;
    $tools->param3 = $param3;
    $tools->param4 = $param4;
    return $tools->runTool();
    }
}