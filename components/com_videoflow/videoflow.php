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

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$doc =& JFactory::getDocument();
$fupload = JURI::root().'components/com_videoflow/utilities/js/fupload.js';
$doc->addScript($fupload);
$lang = JFactory::getLanguage();
$lang->load('com_videoflow', NULL, 'en-GB', false);

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_videoflow'.DS.'tables');
jimport( 'joomla.html.parameter' );
global $vparams, $fxparams;

$app = &JFactory::getApplication();
$xparams = &$app->getParams('com_videoflow');
$vparams = JTable::getInstance('config', 'Table');    
$vparams ->load(1);
$fxparams = new JParameter ('com_videoflow');
$fxparams->set ('slist', $vparams->slist);
$fxparams->set ('slistlimit', $vparams->slistlimit);
$fxparams->set ('showdownloads', $vparams->fshowdownloads);
$fxparams->set ('showvotes', $vparams->fshowvotes);
$fxparams->set ('canvasheight', $vparams->canvasheight);
$vparams-> logo = JURI::root().'components/com_videoflow/players/logo.png';
$vparams->ratinglegacy = $vparams->mootools12;
$vparams->appid = $vparams->fbkey;
$vparams->showstars = 1;
$vparams->stardesc = '({num_votes} #VF_VOTES, #VF_AVERAGE {num_average} #VF_OUTOF)'; // Leave empty for no desc
$vparams->rating_access 		= 'all'; 
$vparams->rating_periodical	= '0'; 
$vparams->only_registered		= '0'; 
$vparams->nsecid = '';
$vparams->nfront = 1;
$vparams->contactuser = 1;
$vparams->fbpwidth = 600;
$vparams->fbpheight = 338;
$vparams->metapwidth = 352;
$vparams->metapheight = 264;
$vparams->playerwidth = $xparams->get('playerwidth', $vparams->playerwidth);
$vparams->playerheight = $xparams->get('playerheight', $vparams->playerheight);

//V.1.1.5 params
$vparams->flashhtml5 = true;
$vparams->fbcolorscheme = 'light';

$tv = JRequest::getBool('tv');
if ($tv) {
$vparams->lplayerwidth = 384;
$vparams->lplayerheight = 288;
}
if ($vparams->prostatus) {
    $db = & JFactory::getDBO();
    $query = 'SELECT name FROM #__vflow_plugins WHERE type = "jtools"';
    $db->setQuery($query);
    $vparams->xmode = $db->loadResult();
   } else {
    $vparams->xmode = 0;
   }        

        $c = JRequest::getCmd('c');
        if ($c == 'fb') {
           $vparams->playerwidth = 512;
           $vparams->playerheight =288;
           $fbml = JRequest::getBool('fbml');
           if (empty($fbml)) {
           JRequest::setVar ('iframe', 1);
           $vparams->jtemplate = $vparams->ftemplate;
           $ctrler = 'videoflow.php';
           $csuff = '';
           } else {
           $ctrler = 'facebook.php';
           $csuff = 'FB';
           }
           require_once(JPATH_COMPONENT.DS.'controllers'.DS.$ctrler);
           if ($vparams->fbcomments || $vparams->fbshare) $vparams->facebook = 1;
        } else {
          switch ($vparams->mode){
              case 'videoflow':
              require_once(JPATH_COMPONENT.DS.'controllers'.DS.'videoflow.php');
              $csuff = '';
              break; 
          
              default:
              $app = &JFactory::getApplication();
              if (empty($vparams->mode)) $link = 'index.php'; else $link = 'index.php?option=com_'.$vparams->mode;
              $app->redirect($link);
              break;
        }
      }  
$classname    = 'VideoflowController'.$csuff;
$controller   = new $classname( );
$controller->execute( JRequest::getVar( 'task' ) );
$controller->redirect();