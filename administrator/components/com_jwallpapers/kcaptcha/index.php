<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: index.php 126 2009-11-27 15:54:01Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

define ( '_JEXEC', 1 );
define ( 'DS', DIRECTORY_SEPARATOR );

define ( 'JPATH_BASE', dirname ( __FILE__ ) . DS . '..' . DS . '..' . DS . '..' . DS . '..' . DS );


require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

$mainframe = & JFactory::getApplication ( 'site' );
$mainframe->initialise ();

$session = & JFactory::getSession ();



include ('kcaptcha.php');

$captcha = new KCAPTCHA ( );

$session->set ( 'captcha_keystring', $captcha->getKeyString () );

?>
