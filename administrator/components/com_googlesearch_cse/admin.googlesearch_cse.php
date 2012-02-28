<?php
/**
* admin.googlesearch_cse.php
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* Jan 3, 2009
*/

defined('_JEXEC') or die();

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
require_once(JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'admin.googlesearch.lib.php');

$controller = new googleSearch_cse_Controller(1);
$controller->registerDefaultTask('listConfiguration');
$task = JRequest::getCmd('task');
$controller->execute($task);
$controller->redirect();

?>