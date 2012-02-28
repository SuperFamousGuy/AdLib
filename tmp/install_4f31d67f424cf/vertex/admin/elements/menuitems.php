<?php

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldmenuitems extends JFormField {
    protected $type = 'menuitems';
    
    function createMenuList(){
        // build the html select list
        $options = JHTML::_('menu.linkoptions');
        $result  = JHTML::_('select.genericlist', $options, 'xml_s5_hide_component_items', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $this->value);
        return $result;
	}
    function getInput() {
        return JFormFieldmenuitems::createMenuList();
    }
}