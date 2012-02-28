<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {

	case 'config':
		TOOLBAR_rafcloud::CONFIG_MENU();
		break;
	case 'plugins':
		TOOLBAR_rafcloud::PLUGIN_MENU();
		break;
	case 'removeWords':
		TOOLBAR_rafcloud::REMOVE_MENU();
		break;
	default:
		TOOLBAR_rafcloud::_DEFAULT();
		break;
}
?>