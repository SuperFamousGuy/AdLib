<?php
/**
* googleSearch module - default.php
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* v1.5 Jan 3, 2009
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$lib = JPATH_BASE.DS.'components'.DS.'com_googlesearch_cse'.DS.'googlesearch.lib.php';

if (!file_exists($lib)) {
	print "ERROR >>> You need to install the latest version of <a href=\"http://www.kksou.com/php-gtk2/Joomla/googleSearch-component.php\">googleSearch component</a> to run this module!";
	return;
}
require_once($lib);

#$r = &$list;

$moduleclass_sfx = $params->get('moduleclass_sfx');
$app = new googleSearch_DisplayForm($list, 'mod_', '1.5', $Itemid, $moduleclass_sfx, 1);
?>
