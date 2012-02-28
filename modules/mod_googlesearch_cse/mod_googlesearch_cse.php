<?php
/**
* googleSearch_cse module
* This module complements the googleSearch_cse component.
* It allows you to add a Google search form as a module.
* The search result will be displayed in the googleSearch component
* right inside your Joomla page!
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* v1.5 Jan 3, 2009
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modGoogleSearch_cse_Helper::getList($params);
$Itemid = modGoogleSearch_cse_Helper::getItemid($params);
require(JModuleHelper::getLayoutPath('mod_googlesearch_cse'));