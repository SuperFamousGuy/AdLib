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

class VideoflowFbookHelper
{ 
  function getComcount ($id)
   {
   global $vparams;
   $xid = $vparams->mode.'_'.$id;
   $fb = new Facebook($vparams->fbkey, $vparams->fbsecret);
   $fq = 'SELECT id FROM comment WHERE xid = "'.$xid.'"';
   $res = $fb->api_client->fql_query($fq);
   if (empty($res)) return JText::_('COM_VIDEOFLOW_NONE'); else return count($res);
   }
   
  function checkPerms ($uid)
   {
   global $vparams;
   $fb = new Facebook($vparams->fbkey, $vparams->fbsecret);
   $fq = 'SELECT status_update,photo_upload,sms,offline_access,email,create_event,rsvp_event,publish_stream,read_stream,share_item,create_note,bookmarked,tab_added FROM permissions WHERE uid = "'.$uid.'"';
   return $fb->api_client->fql_query($fq);
   }

   
   
   function getUserData ($id)
   {
   global $vparams;
   $db = & JFactory::getDBO();
   $query = 'SELECT fb_id FROM #__vflow_users where joomla_id='.(int) $id; 
   $db->setQuery($query);
   $res = $db->loadResult();
   if (empty($res)) return false;
   $fb = new Facebook($vparams->fbkey, $vparams->fbsecret);
   $fq = 'SELECT name, profile_url FROM user WHERE uid = "'.$res.'"';
   $res = $fb->api_client->fql_query($fq);
   if (empty($res)) return false; else return $res;
   }
   
   function invite(){
    global $vparams;
    echo "invite"; exit();
    $fb = new Facebook($vparams->fbkey, $vparams->fbsecret);
    $fbuser = JRequest::getVar('fbuser');
    $fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuser.') AND has_added_app = 1';  
    $_friends = $fb->api_client->fql_query($fql);  
    $friends = array();   
    if (is_array($_friends) && count($_friends)) {   
    foreach ($_friends as $friend) {   
        $friends[] = $friend['uid'];   
    }   
  }   
  $addtext = JText::_('COM_VIDEOFLOW_ADD');
  $invitetext = sprintf(JText::_('COM_VIDEOFLOW_JOIN_APP'), $vparams->appname);
  $friends = implode(',', $friends);   
   
$content =<<<FBML
<fb:pronoun uid = "{$fbuser}" capitalize="true" /> $invitetext   
<fb:req-choice url="{$fb->get_add_url()}" label="$addtext"/>
FBML;
$fbml = '<fb:request-form action="'.$vparams->canvasurl.'" method="POST" invite="true" type="'.$vparams->appname.'" content="'. htmlentities($content).'">   
        <fb:multi-friend-selector max="24" actiontext="'.sprintf(JText::_('COM_VIDEOFLOW_INVITE_FB_FRIENDS'), $vparams->appname).'" showborder="true" cols="3" exclude_ids="'.$friends.'"></fb:request-form>';
return $fbml;
}

function channelInvite(){
    global $vparams;
    echo "channel invite"; exit();
    $cid = JRequest::getInt ('cid');
    $cname = JRequest::getVar('cname');
    $fb = new Facebook($vparams->fbkey, $vparams->fbsecret);
    if (!$vparams->vmode) return false;
    $fbuser = JRequest::getVar('fbuser');
    $fql = 'SELECT uid2 FROM friend WHERE uid1='.$fbuser;  
    $_friends = $fb->api_client->fql_query($fql);  
    $friends = array();   
    if (is_array($_friends) && count($_friends)) {   
    foreach ($_friends as $friend) { 
        foreach($friend as $friend){
        $friends[] = $friend['uid2'];
        }   
    }   
  }   
  $addtext = JText::_('COM_VIDEOFLOW_GO');
  $clink = $vparams->canvasurl.'&task=visit&cid='.$cid.'&cname='.$cname.'&vf=1';
  $owner_poss = '<fb:name uid="'.$cid.'" possessive="true" useyou="true" capitalize="false" linked="false" />';
  $invitetext = sprintf(JText::_('COM_VIDEOFLOW_CHECK_OUT'), $owner_poss, $vparams->appname);
  $friends = implode(',', $friends);   
  if ($cid == $fbuser) $cname = JText::_('COM_VIDEOFLOW_YOUR');
  
$content =<<<FBML
<fb:pronoun uid = "{$fbuser}" capitalize="true" /> $invitetext   
<fb:req-choice url="{$clink}" label="$addtext"/>
FBML;
$fbml = '<fb:request-form action="'.$vparams->canvasurl.'" method="POST" invite="true" type="'.$vparams->appname.'" content="'. htmlentities($content).'">   
        <fb:multi-friend-selector max="24" actiontext="'.sprintf(JText::_('COM_VIDEOFLOW_INVITE_FB_FRIENDS_TO_CHANNEL'), $cname).'" showborder="true" cols="3"></fb:request-form>';
return $fbml;
}

}