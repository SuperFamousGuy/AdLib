<?php
/**
 * @package     Vertex Framework
 * @version		1.0
 * @author		Shape 5 http://www.shape5.com
 * @copyright 	Copyright (C) 2007 - 2010 Shape 5, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');//import the necessary class definition for formfield

$dir = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($dir . '/templateDetails.xml')) {
    $template_xml = simplexml_load_file($dir . '/templateDetails.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
    $template_name = $template_xml->name;
} else {
    $template_name = 'blank';
}

define('VERTEX_TEMPLATE_NAME', $template_name);

print "<script type='text/javascript'>console.log('$template_name');</script>";

class JFormFieldVertex extends JFormField
{
	protected $type = 'Vertex'; //the form field type
    
    protected function getInput() {
        
        if(!defined('VERTEX_LOADED')) {
            $vertex_admin_path = JURI::root(true) . '/templates/' . VERTEX_TEMPLATE_NAME . '/vertex/admin';
            $template_path = JURI::root(true) . '/templates/' . VERTEX_TEMPLATE_NAME;
            $document = JFactory::getDocument();
            
            //replace mootools with our own moo1.3 version
            //$moo11 = JURI::root(true) .'/media/system/js/mootools.js';
            //$moo12 = JURI::root(true) .'/plugins/system/mtupgrade/mootools.js';
            //$moo13 = '/js/mootools.js';
            $moo14 = JURI::root(true) .'/media/system/js/mootools-more.js';
            
            $a = array();
            //foreach ($document->_scripts as $k => $v) {if ($k == $moo11 || $k == $moo12) { $a[$moo13] = $v; } else { $a[$k] = $v; }}
            foreach ($document->_scripts as $k => $v) {if ($k == $moo14) { unset($a[$moo14]); } else { $a[$k] = $v; }}
            $document->_scripts = $a;
            
            $document->_script = str_replace("window.addEvent('domready', function() {
			$$('.hasTip').each(function(el) {
				var title = el.get('title');
				if (title) {
					var parts = title.split('::', 2);
					el.store('tip:title', parts[0]);
					el.store('tip:text', parts[1]);
				}
			});
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
		});", '', $document->_script);
            
            $document->_script = preg_replace('/window.addEvent(\'domready\', function(){ new Fx.Accordion(*}); });/', '', $document->_script);
            $document->addStyleSheet(JURI::root(true) . '/templates/' . VERTEX_TEMPLATE_NAME . '/vertex/admin/vertex.css');
            $document->addScript($vertex_admin_path . '/js/jquery.min.js');
            $document->addScript($vertex_admin_path . '/js/jquery.ui.core.js');
            $document->addScript($vertex_admin_path . '/js/jquery.ui.widget.js');
            $document->addScript($vertex_admin_path . '/js/jquery.ui.mouse.js');
            $document->addScript($vertex_admin_path . '/js/jquery.ui.position.js');
            $document->addScript($vertex_admin_path . '/js/jquery.ui.autocomplete.js');
            
            $document->addScript("$vertex_admin_path/vertexScript.php?path=$vertex_admin_path&template_path=$template_path");
            // Initialize variables.
            $session = JFactory::getSession();
            
            define('VERTEX_LOADED', true);
            // Output
            return '';
        }
	}
}
