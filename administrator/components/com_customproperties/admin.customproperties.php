<?php
/**
* Custom Properties for Joomla! 1.5.x
* @package Custom Properties
* @subpackage Component
* version 1.98.3.4
* @revision $Revision: 1.5 $
* @author Andrea Forghieri
* @copyright (C) 2007-2011 Andrea Forghieri, Solidsystem - http://www.solidsystem.it
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL version 2
*/

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

// delete leftover of installation
if(is_dir( $cp_inst_dir = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS .'com_custompropertiesinstaller')){
	JFolder::delete($cp_inst_dir);
}
if(is_dir( $cp_inst_dir = JPATH_ROOT . DS . 'components' . DS . 'com_custompropertiesinstaller')){
	JFolder::delete($cp_inst_dir);
}

$document	=& JFactory::getDocument();
$document->addStyleSheet(JUri::root().'/administrator/components/com_customproperties/css/cp_admin.css');

// Set the table directory
JTable::addIncludePath( JPATH_COMPONENT.DS.'tables' );

// Load component helper
require_once( JPATH_COMPONENT.DS.'helper.php' );
// Load CP Contentelement
require_once( JPATH_COMPONENT.DS.'contentelement.class.php' );

$controllerName = JRequest::getWord('controller','cpanel'); // default controller
$path = JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php';
if(file_exists($path)){
  require_once($path);
  $classname    = 'CustompropertiesController'.$controllerName;
  $controller   = new $classname( );
}
else{
  JError::raiseError( 500, JText::_( 'Missing controller' ) );
}

// Perform the Request task
$task = JRequest::getCmd( 'task' );
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();

