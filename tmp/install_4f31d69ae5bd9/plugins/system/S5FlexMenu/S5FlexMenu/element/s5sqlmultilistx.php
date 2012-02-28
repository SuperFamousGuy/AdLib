<?php

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldS5SQLMultiListX extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'S5SQLMultiListX';

	function getInput(){
		//$level = $this->form->getValue('level');

		$key = "value";//($node->attributes('key_field') ? $node->attributes('key_field') : 'value');
		$val = "text";//($node->attributes('value_field') ? $node->attributes('value_field') : $name);			
		
		$options = array();
		for($i = 1; $i <= 40; $i++){
			$options[] = JHTML::_( 'select.option',  's5_menu'.$i, 's5_menu'.$i);
		}
		return JHTML::_('select.genericlist', $options, 'jform[params][s5_position]', "multiple='multiple' size='10'", $key, $val, $this->value);	
	}
} 
?>