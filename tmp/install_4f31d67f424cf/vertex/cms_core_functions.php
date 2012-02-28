<?php

//Checks for RTL languages
$lang =& JFactory::getLanguage();
$s5_language_direction = $lang->isRTL();

//Checks if user is logged in
$user =& JFactory::getUser(); 
$s5_user_id = $user->get('id');

//Defines the template core path and sets restricted access
function s5_restricted_access_call() {
defined( '_JEXEC' ) or die( 'Restricted index access' );
}

//Calls Joomla <head> calls
function s5_head_call() { ?>
<jdoc:include type="head" />
<?php }

//Calls the default lanaguage
function s5_language_call() { 
$lang =& JFactory::getLanguage();
?>
xml:lang="<?php echo $lang->getTag(); ?>" lang="<?php echo $lang->getTag(); ?>"
<?php }

//Calls mootools javascript
function s5_mootools_call() {
JHTML::_('behavior.mootools');
}

//Calls the component and article call
function s5_component_call() { ?>
<jdoc:include type="message" />
<jdoc:include type="component" />
<?php }

//Calls modules by name and style
function s5_module_call($name,$style) { ?>
<jdoc:include type="modules" name="<?php echo $name ?>" style="<?php echo $style ?>" />
<?php }

?>