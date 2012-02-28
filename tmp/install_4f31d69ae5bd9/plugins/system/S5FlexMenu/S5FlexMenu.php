<?php
/**
 * S5FlexMenu system plugin
 *
 * @package		S5FlexMenu
 * @subpackage	System 
 */ 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

/**
 * S5FlexMenu system plugin
 *
 * @package		Joomla
 * @subpackage	System 
 */ 
class  plgSystemS5FlexMenu extends JPlugin{

	function onContentPrepareForm($form, $data){
		$document =& JFactory::getDocument();	
		if ($form->getName()=='com_menus.item'){
            $document->addStyleSheet('../plugins/system/S5FlexMenu/S5FlexMenu/element/s5group.css');
			JForm::addFormPath(JPATH_PLUGINS.DS.'system'.DS.'S5FlexMenu'.DS.'S5FlexMenu'.DS.'params');
			$form->loadFile(JPATH_PLUGINS.DS.'system'.DS.'S5FlexMenu'.DS.'S5FlexMenu'.DS.'params'.DS.'S5FlexMenu_params.xml', false);
		}
		if ($form->getName()=='com_templates.style'){
            $document->addStyleSheet('../plugins/system/S5FlexMenu/S5FlexMenu/element/s5group.css');
			JForm::addFormPath(JPATH_PLUGINS.DS.'system'.DS.'S5FlexMenu'.DS.'S5FlexMenu'.DS.'templateparams');
			$form->loadFile(JPATH_PLUGINS.DS.'system'.DS.'S5FlexMenu'.DS.'S5FlexMenu'.DS.'templateparams'.DS.'S5FlexMenu_templateparams.xml', false);
		}
	}
	
}
?>