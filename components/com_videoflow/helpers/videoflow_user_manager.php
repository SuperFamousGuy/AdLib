<?php

//VideoFlow - Joomla Multimedia System for Facebook//

/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2011 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class VideoflowUserManager {
	 
	function registerNew($fbuser)
	{		
    global $vparams;
    $rname = mt_rand(0000, 9999);
    $fbuser_details = self::getFBuserInfo($fbuser);
    if (empty($fbuser_details)) {
    JError::raiseError(500, JText::_('COM_VIDEOFLOW_NO_FB_INFO'));
    return false;
    }
    if (!$fbuser_details['name']) {
    $fullname = 'FB_User_'.$rname;
    } else {
    $fullname = $fbuser_details['name'];
    }
    if (!$fbuser_details['first_name']) {
    $name = 'FB_User_'.$rname;
    } else {
    $name = $fbuser_details['first_name'];
    }
    if (!$fbuser_details['last_name']) {
    $last_name = $rname;
    } else {
    $last_name = $fbuser_details['last_name'];
    }    
    $db = & JFactory::getDBO();
    $query = 'SELECT * FROM #__users WHERE name LIKE '.$db->quote ('%'.$db->getEscaped ($fullname, true).'%',false );
    $db->setQuery($query);
    $jname = $db->loadObject();
    if ($jname) {
      $xname = $name.$last_name;
      $query = 'SELECT * FROM #__users WHERE name LIKE '.$db->quote ('%'.$db->getEscaped ($xname, true).'%',false );
      $db->setQuery($query);
      $nname = $db->loadObject();
      if ($nname) $fullname = $name.'_'.$rname; else $fullname = $xname; 
    }
    if (!$fbuser_details['username']) {
    $username = $name;
    } else {
    $username = $fbuser_details['username'];
    }
    $query = 'SELECT * FROM #__users WHERE username LIKE '.$db->quote ('%'.$db->getEscaped ($username, true).'%',false );
    $db->setQuery($query);
    $jusername = $db->loadObject();
    if (!empty($jusername)) $username = $rname;
    if (!$fbuser_details['email']){
        $url = JURI::root(); 
        $parselink = parse_url(trim($url));      
        $url = trim($parselink['host'] ? $parselink['host'] : array_shift(explode('/', $parselink['path'], 2)));
		    preg_match('/(?P<server>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url, $data);
        $email = $fbuser.'@'.$data['server'];
    } else {
    $email = $fbuser_details['email'];
    }
    $pwd = preg_replace("/([0-9])/e","chr((\\1+112))", mt_rand(100000,999999));   
    $pwd .= $pwd.mt_rand (100000,999999);     
    jimport( 'joomla.user.user' );
		$user 		= clone(JFactory::getUser());
		$authorize	=& JFactory::getACL();
		jimport('joomla.application.component.helper');
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_( 'COM_VIDEOFLOW_NO_ACCESS' ));
			return false;
		}
		
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
		$usertype = $usersConfig->get('new_usertype', 2);
		} else {
		$usertype = $usersConfig->get( 'new_usertype' );
		if (!$usertype) {
			$usertype = 'Registered';
		}
		$data['gid'] = $authorize->get_group_id( '', $usertype, 'ARO' );  
		}
		
		
    $data['name'] = $fullname; 
    $data['username'] = $username; 
    $data['email'] = $email;
    $data['password'] = $pwd;
    $data['password2'] = $pwd; 
    $data['sendEmail'] = 1; 
    $data['block'] = 0;
		if (!$user->bind( $data )) {
			JError::raiseError( 500, JText::_($user->getError()));
			return false;
		}
		if ( !$user->save() )
		{
			JError::raiseWarning(500, JText::_( $user->getError()));
    	return false;
		}
		
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$db = &JFactory::getDBO();
			$query = "INSERT INTO #__user_usergroup_map (user_id, group_id) VALUES ('". (int) $user->id."', '". (int) $usertype. "')";
			$db->setQuery($query);
			if (!$db->query()) {
			JError::raiseError(500, JText::_($db->stderr()));
			return false;
			}
		}
    $vdata['joomla_id'] = $user->id;
    $vdata['fb_id'] = $fbuser;
    self::vfusersNew($vdata);      
    return $user;
    }
    
    function vfusersNew($vdata)
    {
    $vfusers = & JTable::getInstance('users', 'Table');
    if (!$vfusers -> bind($vdata)) {
        JError::raiseWarning(500, JText::_($vfusers->getError()));
        return false;
    }
    if (!$vfusers -> store()) {
        JError::raiseWarning(500, JText::_($vfusers->getError()));
        return false;
      }
    return true;
    }
    
    
    function getVFuserObj ($fbuser)
    {
          $db =& JFactory::getDBO();
          $query = 'SELECT * FROM #__vflow_users WHERE fb_id ='.(int) $fbuser;
          $db->setQuery( $query );
          return $db->loadObject();
    }   
    
    function getFBuserObj($user)
    {
          $db =& JFactory::getDBO();
          $query = 'SELECT * FROM #__vflow_users WHERE joomla_id ='.(int) $user;
          $db->setQuery( $query );
          return $db->loadObject();  
    }
    
    function getFBuserInfo($fbuser)
    {
    global $vparams;
    include_once (JPATH_COMPONENT_SITE.DS.'fbook'.DS.'facebook.php');
       $fb = new Facebook(array(
        'appId' => $vparams->appid,
        'secret' => $vparams->fbsecret,
        'cookie' => true
        ));
    return $fb->api("/$fbuser");  
    }
}