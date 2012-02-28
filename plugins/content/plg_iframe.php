<?php
/**
 * @version $Id: mosiframe.php  2009-10-28 20:27 
 * @ Viet Nguyen Hoang - viet4777 - www.xahoihoctap.net & www.luyenkim.net $
 * @package     Joomla
 * @subpackage Content
 * @copyright  Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license    GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die();
jimport( 'joomla.event.plugin' );

$enabled = JPluginHelper :: isEnabled  ('content','plg_iframe');  
/**
 * Content Plugin
 *
 * @package    Joomla
 * @subpackage Content
 * @since      1.5
 */

class plgContentplg_iframe extends JPlugin
{
   /**
    * Constructor
    *
    * For php4 compatability we must not use the __constructor as a constructor for plugins
    * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
    * This causes problems with cross-referencing necessary for the observer design pattern.
    *
    * @param object $subject The object to observe
    * @param object $params  The object that holds the plugin parameters
    * @since 1.5
    */
   function plgContentplg_iframe( &$subject, $params )
   {  
        parent::__construct( $subject, $params );
        //$this->_plugin =& JPluginHelper::getPlugin('content','plg_iframe');
        //$this->params = new JParameter( $this->_plugin->params );
   }

   /**
    * prepare content method
    *
    * Method is called by the view
    *
    * @param   object      The article object.  Note $article->text is also available
    * @param   object      The article params
    * @param   int         The 'page' number
    */
   function onPrepareContent( &$article, &$params, $limitstart )
   {
   // require_once( JURI::root(true).'/includes/domit/xml_saxy_lite_parser.php' );//xml_domit_lite_parser.php
   //$live_site = JURI::base();

      // Start IFRAME Replacement
        // define the regular expression for the bot
        $plugin =& JPluginHelper::getPlugin('content', 'plg_iframe');
        $pluginParams = new JParameter( $plugin->params );
        
   $regex = "#{iframe*(.*?)}(.*?){/iframe}#s";
  $plugin_enabled = $pluginParams->get('enabled','1');
   if($plugin_enabled=="0"){
   $article->text = preg_replace($regex, '', $article->text);
   }
   else {
   if (preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER) > 0) {
      $db      =& JFactory::getDBO(); //Ket noi CSDL
      $url    = JRequest::getCmd('src'); //JRequest::getCmd
      
   foreach ($matches as $match) {

   $params0 = & JUtility::parseAttributes($match[1]);

   $params0['src'] = (@$params0['src'])? $params0['src']:$pluginParams->get( 'src', 'http://www.luyenkim.net' );
   if($url !='') {
      if(strpos($url,'http://') == false)$params0['src'] = 'http://'.$url;
      }
   //$params0['src'] = filter_var($params0['src'], FILTER_SANITIZE_URL);
   $params0['height'] = (@$params0['height'])? $params0['height']: $pluginParams->get( 'height', '400' );
   $params0['width'] = (@$params0['width'])?$params0['width'] : $pluginParams->get( 'width', '100%' );
   $params0['marginheight'] = (@$params0['marginheight'])? $params0['marginheight']: $pluginParams->get( 'marginheight', '0' );
   $params0['marginwidth'] = (@$params0['marginwidth'])?$params0['marginwidth'] : $pluginParams->get( 'marginwidth', '0' );
   $params0['scrolling'] = (@$params0['scrolling'])?$params0['scrolling']:$pluginParams->get( 'scrolling', '0' );
   $params0['frameborder'] = (@$params0['frameborder'])?$params0['frameborder'] : $pluginParams->get( 'frameborder', '0' );
   $params0['align'] = (@$params0['align']) ? $params0['align'] : $pluginParams->get( 'align', 'bottom' );
   $params0['name'] = (@$params0['name']) ? $params0['name'] : $pluginParams->get( 'name', '' );
   $params0['noframes'] = (@$params0['noframes']) ? $params0['noframes'] : $pluginParams->get( 'noframes', '' );
   
   if(@$match[2]) $url = $match[2]; else $url = $params0['src'];
   $url = strip_tags(rtrim(ltrim($url)));
   $name = $params0['name'];
   $noframes =  $params0['noframes'];
   unset($params0['src']);
   unset($params0['name']);
   unset($params0['noframes']);
   
        $article->text = preg_replace($regex, JHTML::iframe($url,$name,$params0,$noframes), $article->text, 1);
   unset($params0);
        }
   }     
        // End IFRAME Replacement         
}//end of else enable
   } // End Function
} // End Class