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
 
defined('_JEXEC') or die('Restricted access'); 

global $vparams;
$tmpl = JRequest::getCmd ('tmpl');
$c = JRequest::getCmd('c');
if ($c == 'fb') {
$rlink = $vparams->canvasurl;	
} else {
$rlink = JRoute::_('index.php?option=com_videoflow');	
}
echo '<div style="padding:4px 8px;">';
if (isset($this->data) && !empty($this->data)) echo $this->data;
echo '</div>';
echo '<div style="padding:4px 8px; margin: 4px auto; text-align:center;">';
if ($tmpl == 'component') {
if (version_compare(JVERSION, '1.6.0', 'ge')) {
echo '<button type="button" onclick="window.parent.SqueezeBox.close();">'.JText::_('COM_VIDEOFLOW_CLOSE').'</button>';
} else {
echo '<button type="button" onclick="window.parent.document.getElementById(\'sbox-window\').close();">'.JText::_('COM_VIDEOFLOW_CLOSE').'</button>';
}
} else {
echo "<button type='button' onclick='top.window.location.href=\"$rlink\">".JText::_('COM_VIDEOFLOW_CONTINUE')."</button>";
}
echo '</div>';