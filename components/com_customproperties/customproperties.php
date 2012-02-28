<?php
/**
* Custom Properties for Joomla! 1.5.x
* @package Custom Properties
* @subpackage Component
* version 1.98.3.4
* @revision $Revision: 1.4 $
* @author Andrea Forghieri
* @copyright (C) 2007-2011 Andrea Forghieri, Solidsystem - http://www.solidsystem.it
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL version 2
*/


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


// Load component helper
require_once( JPATH_COMPONENT.DS.'helper.php' );
// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Create the controller
$classname    = 'CustompropertiesController';
$controller   = new $classname( );

// Perform the Request task
$task = JRequest::getVar( 'task' );
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();
