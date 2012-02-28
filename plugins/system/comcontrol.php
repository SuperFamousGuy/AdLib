<?php
/**
* @Copyright Copyright (C) 2010- Roger Noar, www.rayonics.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Distributed under the terms of the GPL
**/

/**
 * Joomla! Component Content Control
 * Version 1.52a  , March 29, 2010
 * @author		Roger Noar
 * @package		Joomla 1.50
 * @subpackage	System
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgSystemComcontrol extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemComcontrol(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRoute()  
	{
		global $mainframe;
		$option	= JRequest::getCmd('option');
		$ccc_version = 'Comcontrol V1.52a';
//		$task	= JRequest::getCmd('task');
//		$view	= JRequest::getCmd('view');
		
//  Get current URL
		$uri =& JFactory::getURI();
		$url = $uri->toString();
		$u_host = $uri->getHost();
		$u_path = $uri->getPath();		

//  Get parameters	
		$com_name1 = $this->params->get('com_name1', '');
		$com_substring1 = $this->params->get('com_substring1', '');
		$com_name2 = $this->params->get('com_name2', '');
		$com_substring2 = $this->params->get('com_substring2', '');		
		$com_redirect_url = $this->params->get('com_redirect_url', '');
		$com_debug = $this->params->get('com_debug', '');
		$com_message = $this->params->get('com_message', '');

//	Get usertype to see if logged-in
		$user =& JFactory::getUser();
		$user_type = $user->get('usertype');		

//  Main 
		if ($user_type != "" && $user_type != "Public Frontend") { return ;}  //if user logged-in, then return from function
		if (empty ($option) && $com_debug !='1' ) {return;}		
		if (strpos(($com_name1 . ' ' . $com_name2), $option)===false && $com_debug !='1' ) {return;}  //low overhead - return from function if this is not a com we're interested in

		
		$substring1 = explode(" ",$com_substring1); // get mostly public substring tags, space delimited		
		$substring2 = explode(" ",$com_substring2); // get mostly private substring tags, space delimited				
		// Initialize
		$tag1 = '';
		$tag2 = '';
		$tag_match1 = true; // for mostly public components		
		$tag_match2 = false; // for mostly private components
		$private_match = false;
		$public_match = false;
		
		if (strpos( $com_name1, $option) !== false)  // Check mostly public components
		{ 
			$public_match = true;
			foreach($substring1 as $tag1) {
			if ( empty($tag1) ) {break;} // stop if tag empty
			$tag_match1 = strpos($url, $tag1);  //See if the substring tag is present in the path
			if ($tag_match1 !== false) {break;} // stop if there is a match		
			}		
		}		
		
		elseif (strpos( $com_name2, $option) !== false) // Check mostly private components 
		{
			$private_match = true;
			foreach($substring2 as $tag2) {
			if ( empty($tag2) ) {break;} // stop if tag empty
			$tag_match2 = strpos($url, $tag2);  //See if the substring tag is present in the path
			if ($tag_match2 !== false) {break;} // stop if there is a match
			}	
		}		
		
		if ($com_debug=='1') 
		{
		$mainframe->enqueueMessage( $ccc_version) ;	
		$mainframe->enqueueMessage( 'JFactory::getURI =' . $url ) ;		
		$mainframe->enqueueMessage( 'getHost =' . $u_host ) ;			
		$mainframe->enqueueMessage( 'getPath =' . $u_path ) ;			
		$mainframe->enqueueMessage( '$option =' . $option ) ;			
		$mainframe->enqueueMessage( '$com_name1 =' . $com_name1) ;				
		$mainframe->enqueueMessage( '$com_name2 =' . $com_name2) ;			
		$mainframe->enqueueMessage( '$user_type =' . $user_type ) ;	
		$mainframe->enqueueMessage( '$public_match = ' . $public_match ) ;
		$mainframe->enqueueMessage( '$private_match = ' . $private_match ) ;		
		$mainframe->enqueueMessage( '$tag_match1 = ' . $tag_match1 ) ;
		$mainframe->enqueueMessage( '$tag1 = ' . $tag1 ) ;		
		$mainframe->enqueueMessage( '$tag_match2 = ' . $tag_match2 ) ;
		$mainframe->enqueueMessage( '$tag2 = ' . $tag2 ) ;	
		}
		
		if ($tag_match1 === false && $com_debug !='1') {return;} // Mostly Public match not found, so this page is allowed
		if ($tag_match2 !== false && $com_debug !='1') {return;} // Match Private match found, so this page is allowed

//  Redirect to login page, since the component page is private
		if ( empty($com_redirect_url) ) { $com_redirect_url = 'index.php?option=com_user&view=login';} //standard joomla login page
		if ($com_debug != '1') {$mainframe->redirect( $com_redirect_url, $com_message );}

	Return ;// return from function
	}
		

}
?>