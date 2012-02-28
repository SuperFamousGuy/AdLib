<?php


// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFields5group extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 's5group';

	function getInput(){
		$level = $this->form->getValue('level');
		
		if($level > 1){
			$arr = array(
				JHtml::_('select.option', '1', JText::_('JYES')),
				JHtml::_('select.option', '0', JText::_('JNO'))
			);
			$html = JHtml::_('select.radiolist', $arr, 'jform[params][s5_group_child]', '', 'value', 'text', (int) $this->value);
		}else{
			$arr = array(
				JHtml::_('select.option', '1', JText::_('JYES')),
				JHtml::_('select.option', '0', JText::_('JNO'))
			);
			$html = JHtml::_('select.radiolist', $arr, 'jform[params][s5_group_child]', 'disabled="disabled""', 'value', 'text', 0);
			$html .= '<label for="jform_params_s5_group_child" style="margin-left:150px;">Grouping disabled for first level items!</label>';
			$html .= '<input type="hidden" name="jform[params][s5_group_child]" id="jform_params_s5_group_child" value="0" />';
		}		
		return $html;
	}
} 