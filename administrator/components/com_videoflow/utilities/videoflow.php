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

class VideoflowUtilities
{
  
 function setVideoFlowTitle($title, $icon = 'generic.png')
   {
      $app = &JFactory::getApplication();
      $icon   = preg_replace('#\.[^.]*$#', '', $icon);
      if (version_compare(JVERSION, '1.6.0') < 0) {
      $html  = "<div class=\"header icon-48-$icon\">\n";
      $html .= "$title\n";
      } else {
      $html  = "<div class=\"pagetitle icon-48-$icon\">\n";
      $html .= "<h2>$title</h2>";
      }
      $html .= "</div>\n";
      $app->set('JComponentTitle', $html);
   }
}