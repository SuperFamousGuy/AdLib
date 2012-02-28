<?php

// VideoFlow List Module //
/**
* @ Version 1.1.0 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow List Module is free software
* @ Requires VideoFlow Multimedia Component available at http://www.videoflow.tv
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/	

// Prevent direct access

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// Include module helper file
require_once(dirname(__FILE__).DS.'helper.php');

// Get parameters
$modloc = (string) $params->get ('modloc', 'joomla');
$vcats = (string) $params->get ('cats', null);
$lightboxsys = (string) $params->get ('lightboxsys', 'multibox');
$lightboxmode = (int) $params->get ('lightboxmode', 0);
$lboxh = (int) $params->get('lboxh', 60);
$lboxw = (int) $params->get('lboxw', 8);
$moo = (int) $params->get ('loadmoo12', 1);
$internaltitle = (int) $params->get ('autotitle', 1);
$listtype = (string) $params->get('listtype', 'latest');
$daycount = (int) $params->get('daycount', 7);
$listlimit = (int) $params->get('listlimit', 10);
$vfcolumns = (int) $params->get('vfcolumns', 1);
$titlepos = (string) $params->get('titlepos', 'bottom');
$thumbwidth = (int) $params->get('thumbwidth', 120);
$thumbheight = (int) $params->get('thumbheight', 90);
$jeffectsclass = (string) $params->get('jeffectsclass', '');
$jeffects = (string) $params->get('jeffects', '');
$titlelength = (int) $params->get('titlelength', 15);
$bgroundc = (string) $params->get('bgroundc', '');
$textc = (string) $params->get('textc', '');
$texts = (string) $params->get('texts', '');
$borderc = (string) $params->get('borderc', '');
$ltexta = (string) $params->get('ltexta', 'center');
$lbgroundc = (string) $params->get('lbgroundc', '');
$iborders = $params->get('iborders', 0);
if ($iborders === 0 && empty($jeffects)) $iborders = 4;
$iborderc = (string) $params->get('iborderc', '');
if (empty($iborderc) && empty ($jeffects)) $iborderc = '#EDEDED';
$ltextc = (string) $params->get('ltextc', '');
$lborderc = (string) $params->get('lborderc', '');
$lborders = (int) $params->get('lborders', 0);
$borders = $params->get('borders', "");
$ltexts = (string) $params->get('ltexts', '120%');
$seemore = (int) $params->get('seemore', 1);
$stexta = (string) $params->get('stexta', 'right');
$vparams = ModVideoflowList::getVparams();	
$vboxheight = $vparams->lplayerheight + $lboxh;
$vboxwidth = $vparams->lplayerwidth + $lboxw;
$flowid = $vparams->flowid;
if (empty($flowid)) {
$flowid = ModVideoflowList::getFlowid();
}
	
// Retrieve video data
$mv = new ModVideoflowList;
$mv->task = $listtype;
$mv->limit = $listlimit;
$mv->cats = $vcats;
$mv->daycount = $daycount;
$mv->vparams = $vparams;
$data = $mv->getData();
if ($internaltitle) $label = $mv->getLabel();

//Include display file
require(JModuleHelper::getLayoutPath('mod_listmodule_for_videoflow'));