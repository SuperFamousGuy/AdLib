<?php
/**
* admin.googlesearch_cse.html.php
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* Jan 3, 2009
*/

defined('_JEXEC') or die();

class HTML_googleSearch_cse
{
	function listConfiguration($option, &$row)
	{
		HTML_googleSearch_cse::setMessageToolbar();
		$app = new googleSearch_config($option, $row, '1.5', 1);
	}

	function setMessageToolbar()
	{
		JToolBarHelper::title('googleSearch (CSE) Configuration', 'generic.png');
		JToolBarHelper::save();
	}

}

?>