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
 
jimport( 'joomla.application.component.model' );
 
class VideoflowModelVideoflow extends JModel
{
   
    var $_total = null;
    
    var $_pagination = null;
    
    var $_limit = null;
    
    var $_userid = null;
    
    var $_vtask = null;
        
    function __construct()
    {
        parent::__construct();
     
        global $vparams;  
        $xparams = $this->getXparams();
        $tlimit = (int) $xparams->get('limit', $vparams->limit);
        $dlimit = $this->getState('limit', null);
        if (!is_null($dlimit)) $this->setState('limit', $dlimit); else $this->setState('limit', $tlimit);
        $limitstart = JRequest::getInt('limitstart', 0);
        $this->setState('limitstart', $limitstart);
    }


    function getData() 
    {
        global $vparams;
        $task = JRequest::getCmd ('task');
        $id = JRequest::getInt('id');
        $c = JRequest::getCmd ('c');
        $lo = JRequest::getCmd ('layout', $vparams->jtemplate);
        $limit = $this->getState ('limit');
        if (!empty($vparams->catplay) && $task == 'cats') {
            if ($c != 'fb' && $lo != 'playerview' && $lo != 'ajaxlist' && $lo != 'simple') {
            $limit = 0;
            } 
        }        
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $limit); 
        }
        return $this->_data;
    }

   
   function updateData(&$vlist) {
   global $vparams;
   $xparams = $this->getXparams();
   $shortcat = (int) $xparams->get('shortcat', 8);
   $shortname = (int) $xparams->get('shortname');
   $shorttitle = (int) $xparams->get('shorttitle');
   $shortdetails = (int) $xparams->get('shortdetails');

   if (empty($shorttitle)) $shorttitle = $vparams->shorttitle; 
   if (empty($shortname)) $shortname = $vparams->shortname; 
   if (empty($shortdetails)) $shortdetails = $vparams->commentlimit; 

   foreach ($vlist as &$data) {
                if (!is_array($data)) { 
                        $data->comcount = $this->getCommentCount($data->id); 
                        if (empty($data->medialink) && $data->type == 'jpg' || $data->type == 'png' || $data->type == 'gif') $data->medialink = $this->genMediaLink($data, 'photos');
                        $data->usrname = $this->getUsername($data->userid); 
                        $data->sdetails = stripslashes($this->runTool('xterWrap', $data->details, $shortdetails));
                        $data->stitle = stripslashes($this->runTool('xterWrap', $data->title, $shorttitle));
                        $data->sname = stripslashes($this->runTool('xterWrap', $data->usrname, $shortname));
                        $data->scat = stripslashes($this->runTool('xterWrap', $data->catname, $shortcat));
                } else { 
                        $this->updateData($data);
                }
        }
        return $vlist;
  }
  
  function updateDataFB(&$vlist, $layout = null)
  {
   global $vparams;
   include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php');   
   $task = JRequest::getCmd ('task');
   foreach ($vlist as &$data) {
                if (!is_array($data)) { 
                        if ($vparams->repunderscore) {
                        $data->title = str_replace('_', ' ', $data->title);
                        }
                        $username = VideoflowFbookHelper::getUserData($data->userid);
                        if (!empty($username[0]['name'])) {
                        $data->usrlink = '<a href="'.$username[0]['profile_url'].'">'.$username['0']['name'].'</a>';
                        } else {
                        $data->usrlink = $data->name;
                        }
                        if (empty($data->usrlink)) $data->usrlink = JText::_('COM_VIDEOFLOW_FB_USER');
                        if ($layout == 'default' || $layout == 'tabview') $data->embedcode = $this->_buildCode($data);
                        if (empty($data->catname)) $data->catname = JText::_('COM_VIDEOFLOW_CAT_NONE');
                        $data->sdetails = stripslashes($this->runTool('xterWrap', $data->details, $vparams->commentlimit));
                        $data->stitle = stripslashes($this->runTool('xterWrap', $data->title, 32));
                        $data->rating = $this->calRating($data->rating, $data->votes);
                        if ($vparams->showpro) {
                        if ($task == 'myfavs') $action = 'remove'; else $action = 'add';
                        $do = JURI::root().'index.php?option=com_videoflow&task='.$action.'&id='.$data->id.'&c=fb&format=raw&vf=1';
                        $data->mylist = '<img class="vf_tools_icons" src="'.JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/'.$action.'.gif" />
                        <a href="#" onClick="showChoice(\''.$do.'\', \''.JText::_('COM_VIDEOFLOW_STATUS_MES').'\', \''.JText::_('COM_VIDEOFLOW_OKAY').'\'); return false">'.JText::_('COM_VIDEOFLOW_MYLIST').'</a>';              
                        if ($task == "myvids") $data->mylist = '';
                        } else {
                        $data->mylist = '';
                        }
                        $data->sharelink = JURI::root().'index.php?option=com_videoflow&task=play&id='.$data->id;
                        $data->link = $vparams->canvasurl.'&task=play&id='.$data->id.'&vf=1';
                } else { 
                        $this->updateDataFB($data);
                }
        }
        return $vlist;
  
  }
  
   function xterWrap(&$vlist, $element) {
   if (!is_array($vlist)) $vlist = array($vlist);
   foreach ($vlist as &$data) {
                if (!is_array($data)) { 
                        foreach($element as $key=>$val){
                        $selement = 's'.$key;
                        $data->$selement = stripslashes($this->runTool('xterWrap', $data->$key, $val));
                        }
                } else { 
                        $this->xterWrap($data);
                }
        }
        return $vlist;
  }

  
  function getMyvidsFB ($userid)
  {
    $id = JRequest::getInt('id');          
    $db = & JFactory::getDBO();
    $query = 'SELECT DISTINCT mid FROM #__vflow_mymedia WHERE mid != '.(int) $id .' AND jid='. (int) $userid.' AND component="videoflow"';
    $db -> setQuery ($query);    
    $res = $db->loadResultArray();
    $query = 'SELECT SQL_CALC_FOUND_ROWS'.$this->_getSubquery(). 
             ' WHERE published = 1 AND media.id !='.(int) $id.' AND (media.userid = '.(int) $userid; 
    if (!empty($res)) {    
    $query .=  ' OR media.id = ' . implode( ' OR media.id = ', $res );
    }
    $query .= ') ORDER BY dateadded DESC';       
    $db -> setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
    $vlist = $db -> loadObjectList();
    $db->setQuery('SELECT FOUND_ROWS();');
    $this->_total = $db->loadResult();
    return $vlist;
  }
  
  

   function calRating($total, $votes)
   {
      if ($total > 0 && $votes > 0) {
      $rating = round($total / $votes, 2).JText::_('COM_VIDEOFLOW_PER_FIVE'); 
      } else {
      $rating = JText::_('COM_VIDEOFLOW_NONE');
      }
    return $rating;   
   }
      
   function getTools($media, $add_remove = 'add')
   {
   global $vparams;
   $user = & JFactory::getUser();
   $fbuser = JRequest::getInt('fbuser');
   if ($user->guest && $fbuser) {
          $db =& JFactory::getDBO();
          $query = 'SELECT joomla_id FROM #__vflow_users WHERE fb_id ='.(int) $fbuser;
          $db->setQuery( $query );
          $vfuser = $db->loadResult();
          if ($vfuser) $user = & JFactory::getUser($vfuser);
   }
   
   $tools = array();
   $c = JRequest::getCmd('c');
  // if ($c == 'fb') $showshare = $vparams->fbshare; else $showshare = $vparams->jshare;
   $itemid = JRequest::getInt('Itemid');
   if ($itemid) {
   $itemid = '&Itemid='.$itemid;
   } else {
   $itemid = '';
   }
   $task = JRequest::getCmd('task');
   $elink = base64_encode (JURI::root().'index.php?option=com_videoflow&task=play&id='.$media->id.$itemid);
   $mylist = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$add_remove.'&id='.$media->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}">'.JText::_('COM_VIDEOFLOW_MYLIST').'</a>';
   $email = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=email&id='.$media->id.'&tmpl=component&link='.$elink).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}">'.JText::_('COM_VIDEOFLOW_EMAIL').'</a>';
   $share = '<a href="#" onClick="vfshare_display(\'vfshare\'); return false;">'.JText::_('COM_VIDEOFLOW_SHARE').'</a>';
   $download = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=download&id='.$media->id).'">'.JText::_('COM_VIDEOFLOW_GRAB').'</a>';
   $report = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=report&id='.$media->id.'&tmpl=component').'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}">'.JText::_('COM_VIDEOFLOW_REPORT').'</a>';
   $edit = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=edit&cid='.$media->id.'&tmpl=component&fr=1').'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}">'.JText::_('COM_VIDEOFLOW_EDIT').'</a>';
   $delete = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=delete&id='.$media->id.'&tmpl=component&fr=1').'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}">'.JText::_('COM_VIDEOFLOW_DELETE').'</a>';
   if ($vparams->showpro) {
      if ($vparams->showadd) $tools[$add_remove] = $mylist;
   }
   if ($vparams->showemail) $tools['email'] = $email;
  // if ($showshare) $tools['share'] = $share;
   if ($vparams->showshare) $tools['share'] = $share;
   if ($vparams->downloads && $media->download && ($media->server == 'local')) $tools ['download'] = $download;
   if ($vparams->showreport) $tools['alert'] = $report;
   if (version_compare(JVERSION, '1.6.0', 'ge')) {
   $auth = $user->getAuthorisedGroups();
   if (in_array(8, $auth)  || in_array(7, $auth) || ($vparams->useredit && ($user->id == $media->userid))) $tools['edit'] = $edit;
   if (in_array(8, $auth)  || in_array(7, $auth) || ($vparams->useredit && ($user->id == $media->userid))) $tools['unsubscribe'] = $delete;

   } else {
   if ($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator' || ($vparams->useredit && $user->id == $media->userid)) $tools['edit'] = $edit;
   if ($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator' || ($vparams->candelete && $user->id == $media->userid)) $tools['unsubscribe'] = $delete;
   }
   return $tools;
   }
    
    function getMedia($id = null, $pcode = null)
    {
       global $vparams;
       $task = JRequest::getCmd ('task');
       $db =& JFactory::getDBO();
       $query = 'SELECT'.$this->_getSubquery(). 
                ' WHERE published="1"';
       if (!empty($id) || $task == 'edit') {
       $query .= 'AND media.id = '.(int) $id;
       } else {
       $query .= 'ORDER BY RAND()';
       }       
       $db->setQuery($query);
       $media = $db->loadObject(); 
       if ($vparams->repunderscore) {
       $media->title = str_replace('_', ' ', $media->title);
       }
       $media->shorttitle = stripslashes($this->runTool('xterWrap', $media->title, $vparams->shorttitle));
       $media->title = stripslashes($this->runTool('xterWrap', $media->title, $vparams->titlelimit));
       $media->title = str_replace("'", "", $media->title);
       $media->details = stripslashes($this->runTool('xterWrap', $media->details, $vparams->commentlimit));
       $media->views = $media->views + 1;
       if (empty($media->catname)) {
          $media->catname = JText::_('COM_VIDEOFLOW_CAT_NONE'); 
       }       
       if (!empty($media->pixlink)) {
         if ($media->server == 'local' && stristr($media->pixlink, 'http') === FALSE) {  
         $media->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->pixlink;
         }
       }
      if ($media->server == 'local' && stristr($media->file, 'http') === FALSE) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 
        $subdir = VideoflowFileManager::getFileInfo ($media->type);
        $media->file = JURI::root().$vparams->mediadir.'/'.$subdir['dir'].'/'.$media->file;
      }
       if ($task == 'play' || $task == 'myvids' || $task == 'visit' || $task == 'cats' || $task == 'myfavs' || $task == 'mysubs' || $task == 'searchplay' || !empty($pcode)) {
       if (!empty($media->tags)) $media->autotags = $this->processTags($media->tags); else $media->autotags='';
       $media->embedcode = $this-> _buildCode($media);
       $media->metaplay = $this->_buildCode($media, 'fb');
       $media->shortname = stripslashes($this->runTool('xterWrap', $media->name, $vparams->shortname));
       }
       $query = 'UPDATE #__vflow_data' .
							  ' SET views = views + 1' .
							  ' WHERE id = '.(int) $id;
			 $db->setQuery($query);
       if (!$db->query()) {
					JError::raiseError( 500, $db->stderr());
				}
			 return $media;
    }
    
    function getFile($id)
    {
       $db =& JFactory::getDBO();
       $query = 'SELECT * FROM #__vflow_data WHERE id=' .(int) $id . ' AND published="1"';
       $db->setQuery($query);
       $file = $db->loadObject(); 
       return $file;
    }
  
  function getCategories()
  {
    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');
    return VideoFlowCategoryManager::getCategories();
  }
  
  function getCatName($id)
  {
   include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');
   return VideoFlowCategoryManager::getCatName($id);
  }    
  
  function getCatList($limit = null)
  {
    global $vparams;
    if (!$limit) $limit = $this->getState('limit');
    $db =& JFactory::getDBO();
    $query = 'SELECT COUNT(*) FROM #__vflow_categories AS c';
    $db->setQuery ($query);
    $count = $db->loadResult() + 1;
    $this->_total = $count;
    JRequest::setVar('count', $count);
    $query = 'SELECT c.* FROM #__vflow_categories AS c ORDER BY name ASC';
    $db->setQuery ($query, $this->getState('limitstart'), $limit);
    $rows = $db->loadObjectList();
    $count = count ($rows);
    if ($count < $limit) {
    $query = 'SELECT * FROM #__vflow_data WHERE cat = "0" AND published = "1"';
    $db->setQuery($query);
    $uncat = $db->loadObject();
      if (!empty($uncat)) {
      $none = new stdClass();
      $none->id = 0;
      $none->name = JText::_('COM_VIDEOFLOW_CAT_NONE');
      $none->desc = JText::_('COM_VIDEOFLOW_CAT_NONE_DESC');
      array_push ($rows, $none); 
      }
    }
    if (is_array($rows)){
        foreach ($rows as $row){
        if (empty($row->pixlink)) {
        $query = 'SELECT pixlink FROM #__vflow_data WHERE cat='.(int) $row->id;
        $db->setQuery( $query );
        $pix = $db->loadResult ();
        } else {
        $pix = $row->pixlink;
        }
        if (!empty($pix)) {
          if (stristr($pix, 'http') === FALSE) {  
          $pix = JURI::root().$vparams->mediadir.'/_thumbs/'.$pix;
          } else {   
          $pix = $pix;
          }
        } else {
        $pix = JURI::root().'components/com_videoflow/players/vflow.jpg';
        }
        $row->pixlink = $pix;
        }
      }
	 return $rows;
  }  
  
  function getChannel($id){
    global $vparams;
    $app = &JFactory::getApplication();
    $cname = & JFactory::getUser($id);
    $cname = $cname->name;
    if (!$vparams->displayname) $cname = $cname->username;
    $media = new stdClass();
    $media->title = $cname.JText::_("'s media channel at").' '.$app->getCfg('sitename'); 
    $media->pixlink = JURI::root().'components/com_videoflow/players/vflow.jpg';
    $media->elink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task=channel&id='.$id.'&name='.$cname);
    return $media;
  }  

  function findMedia ($source, $key, $type){
    if (!is_array($source)) $source = array ($source);
    switch ($type){
        case 'uploads':
        default:
        $func = 'getByuser';
        break;
        
        case 'favourites':
        $func = 'getFavourites';
        break;
    }

    foreach ($source as $source) {
     $media = $this->$func ($source->$key);
     if (!empty($media)) {
     JRequest::setVar ('pid', $source->$key);
     return $media;
     }
    }
    return false;
  }
  
  function getCname($ids){
    if (!is_array($ids)) $ids = array($ids);
    foreach ($ids as $ids){
    $cname = $this->getUsername($ids->joomla_id);
    $ids->title = $cname;
    $array[] = $ids;
    }
    return $array;
  }
  
  function processTags ($tags){
    $lo = JRequest::getCmd('layout','');
    if ($lo == 'ajax') $lo = 'playerview';
    $Itemid = JRequest::getInt('Itemid');
    if (!empty($Itemid)) $Itemid = '&Itemid='.$Itemid; else $Itemid = '';
    if (!empty($lo)) $lo = '&layout='.$lo;
    $tags = str_replace(array(",","\r","\n","\t", " +"), " ", $tags);
    $tags = explode (" ", $tags);
    foreach ($tags as $tag){
    $autotag [] = '<a href="'.JRoute::_(JURI::root().'index.php?option=com_videoflow&task=search&vs=1&searchword='.$tag.$lo.$Itemid).'">'.$tag.'</a>';
    }
    return implode (" ", $autotag);
}

  function fbInvite(){
    global $vparams;
    $cid = JRequest::getInt('cid');
    $cname = JRequest::getString ('cname');
    $c = JRequest::getCmd ('c');
    $fbuser = JRequest::getInt('fbuser');
    $user = & JFactory::getUser();
    $lo = JRequest::getCmd('layout');
    if (empty($cname)) {
        $cname = & JFactory::getUser($cid);
        $cname = $cname->name;
        if (!$vparams->displayname) $cname = $cname->username;
    }
    if ($c == 'fb'){
    $root = $vparams->canvasurl;
    $site = $vparams->appname;
    $lo = '';
    } else {
    $root = JURI::root().'index.php?option=com_videoflow';
    $site = $app->getCfg('sitename');
    if (!empty($lo)) $lo = '&layout='.$lo;
    }
    $owner = $this->getFBuserObj($cid);
    $owner_poss = $my = $cname;
    if (!empty ($owner->fb_id) && !empty($fbuser)){
        if ($owner->fb_id == $fbuser) {
            $owner_poss = JText::_('COM_VIDEOFLOW_YOUR');
            $my = JText::_('COM_VIDEOFLOW_MY');
        }    
    } else if (!empty($user->id) && $user->id == $cid) {
    $owner_poss = JText::_('COM_VIDEOFLOW_YOUR');
    $my = JText::_('COM_VIDEOFLOW_MY');
    }
    $jlink = $root.'&task=fbinvites&tmpl=component&cid='.$cid;
    $clink = $root.'&task=visit&cid='.$cid.'&name='.$cname.$lo;
    $visit = JText::_('Visit');
    $text = sprintf( JText::_('COM_VIDEOFLOW_INVITE_TEXT'), $owner_poss, $site);
    $ctext = sprintf( JText::_('COM_VIDEOFLOW_INVITE_TEXT2'), $my, $site);
    $type = JText::_('Channel');
    return '<fb:serverFbml width="760px" style="width: 760px; height: 400px; overflow:visible">  <script type="text/fbml">  <fb:fbml>  <fb:request-form action="'.$jlink.'" method="POST" invite="true" type="'.$type.'" content="<a href=\''.$clink.'\'>'.$ctext.'</a> <fb:req-choice url='.$clink.' label='.$visit.' /> " >  <fb:multi-friend-selector showborder="false" actiontext="'.$text.'">  </fb:request-form>  </fb:fbml>  </script>  </fb:serverFbml>';
  } 

  function emailSend() {
    $app = &JFactory::getApplication();
    JRequest::checkToken() or jexit( 'Invalid Request' );
    jimport( 'joomla.mail.helper' );
    $status = new stdClass();
    $status->type = 'error';
    $status->message = JText::_('COM_VIDEOFLOW_ERROR_SEND');
    $email = JRequest::get('post');
    if (empty( $email['subject'])) $subject = sprintf( JText::_('COM_VIDEOFLOW_EMAIL_SUBJ'), $email['yourname']);
                $elink = base64_decode( JRequest::getVar( 'elink', '', 'post', 'base64' ) );
		if(!JURI::isInternal($elink)) return $status;
    if (!$email['email'] || !$email['youremail'] || !JMailHelper::isEmailAddress($email['email']) || !JMailHelper::isEmailAddress($email['youremail']) ) {
		  $status->message = JText::_('COM_VIDEOFLOW_WARN_ADDRESS');
			return $status;
		}
    $headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');
    $fields = array ('mailto',
						 'sender',
						 'from',
						 'subject',
						 );
    foreach ($fields as $field)
		{
			foreach ($headers as $header)
			{
				if (strpos($_POST[$field], $header) !== false)
				{
					return $status;
				}
			}
		}
		unset ($headers, $fields);
		$url = JURI::root();
	  $msg = sprintf( JText::_('COM_VIDEOFLOW_EMAIL_MESSAGE'), $email['friendname'], $email['yourname'], $email['youremail'], $email['title'], $email['yourname'], $email['personalmessage'], $elink, $app->getCfg('sitename'), $url);
	  $email['yourname'] .= ' (via '.$app->getCfg('sitename').')';
		$success = JUtility::sendMail ($email['youremail'], $email['yourname'], $email['email'], $email['subject'], $msg, null, null, null, null, $email['youremail'], $email['yourname']);
		if (!$success || JError::isError($success)) return $status;
		$status->type = 'message';
		$status->message = sprintf(JText::_('COM_VIDEOFLOW_NOTICE_SENT'), $email['email']); 
		return $status;
	} 

    function doSearch()
    { 
      $searchword = JRequest::getString('searchword');
      $c = JRequest::getCmd ('c');
      $id = JRequest::getVar('id', null);
      if (empty ($searchword)) {
      $this->_total = 1;
      $err = JText::_('COM_VIDEOFLOW_WARN_SEARCH');
      if ($c == 'fb') echo $err; else JError::raiseWarning(400, $err);
      return;
      }
      $media = new stdClass();
      $media->id = $id;
      $media->tags = $searchword;
      return $this ->  getRelated ($media);
    }

        
    
  function getRelated ($media, $xlimit = null)
    {
     global $vparams;     
     $vtask = JRequest::getCmd('task');
     $related = $catfilter = null;
     if ($vtask == 'cats' ) {
     $cat = JRequest::getInt('cat');
     $catfilter = ' AND media.cat = \''.$cat.'\'';
     }
     if (empty($media->tags)) $mtags = $media->title; else $mtags = $media->tags;
     $db =& JFactory::getDBO();         
     $query = 'SELECT SQL_CALC_FOUND_ROWS media.*, u.name, u.username, c.name AS catname'.
     ' FROM #__vflow_data AS media'.
     ' LEFT JOIN #__users AS u on u.id = media.userid'. 
     ' LEFT JOIN #__vflow_categories AS c ON c.id = media.cat'.
     ' WHERE published="1"'. $catfilter .
     ' AND MATCH (media.tags, media.title, media.details) AGAINST (\''.$mtags.'\')';
     if (!empty($media)) {
     $query .= ' AND media.id !='. (int) $media->id;
     }
     $limit = $vparams->sidebarlimit;
     $limitstart = 0;
     if ($vtask == 'dosearch' || $vtask == 'search' || $vtask == 'searchplay') {
     $xparams = $this->getXparams();
     $limit = (int) $xparams->get('limit', $vparams->limit);
     $limitstart = $this->getState ('limitstart');
     }
     if (!empty($xlimit)) $limit = $xlimit;
     $db->setQuery($query, $limitstart, $limit);
     $related = $db->loadObjectList();
     $db->setQuery('SELECT FOUND_ROWS();');
     $vcount = $db->loadResult();
     JRequest::setVar ('vcount', $vcount);
     return $related;
    }

     
   function getByuser ($userid, $mid=null)
    {
      global $vparams;
      $task = JRequest::getCmd ('task');
      $lo = JRequest::getCmd('layout');
      $c = JRequest::getCmd ('c');
      if ($c == 'fb' && empty($lo)) $lo = $vparams->ftemplate; 
      $fil = $this->genMediaFilter('media.type');
      if (!empty($fil)) $fil = 'AND '.$fil;
      if ($c == 'fb') $limit = $vparams->limit; else $limit = $vparams->sidebarlimit;
      $limitstart = 0;
      if ($lo == 'playerview' || $lo == 'ajaxlist' ||$lo == 'simple') {
      $xparams = $this->getXparams();
      $limit = (int) $xparams->get('limit', $vparams->limit);
      $limitstart = $this->getState ('limitstart');
      } 
      $db =& JFactory::getDBO();
      $query = 'SELECT SQL_CALC_FOUND_ROWS'.$this->_getSubquery().
               ' WHERE (published = 1 AND media.userid='.(int) $userid . $fil .')' .           
               ' AND media.id !=' . (int) $mid .' ORDER BY media.dateadded DESC';
      $db->setQuery( $query, $limitstart, $limit );
      $data = $db->loadObjectList();
      $db->setQuery('SELECT FOUND_ROWS();');
      $ucount = $db->loadResult();
      $this->_total = $ucount;
      JRequest::setVar ('ucount', $ucount);
      if ($mid) {
      $u_count = $ucount + 1;
      } else {
      $u_count = $ucount;
      }
      JRequest::setVar('u_count', $u_count);
      return $data;
      }


    
    function getMysubs ($userid, $mid=null)
    {
      global $vparams;
      $db = & JFactory::getDBO();
      $fbuser = JRequest::getInt ('fbuser', null);
      $task = JRequest::getCmd('task'); 
      $query = 'SELECT cid FROM #__vflow_mychannels WHERE jid ='. (int) $userid;
      if ($fbuser) $query .= ' OR faceid='. (int) $fbuser;    
      $query .= ' ORDER BY RAND()';
      $db->setQuery($query);
      $ids = $db->loadResultArray();
      if (!$ids) {
      return false;
      } else {
      $fcount = count($ids);
      JRequest::setVar('fcount', $fcount);
      $limit = $vparams-> sidebarlimit;
      $limitstart = 0;
      if ($task == 'cvids'){
              $xparams = $this->getXparams();
              $this->_total = $fcount;
              $limit = (int) $xparams->get('limit', $vparams->limit);
              $limitstart = $this->getState ('limitstart');                
      }
      if ($mid) {
      $f_count = $fcount + 1; 
      } else {
      $f_count = $fcount;
      }      
      JRequest::setVar('f_count', $f_count);
      $query = 'SELECT * FROM #__vflow_users WHERE joomla_id =' . implode( ' OR joomla_id = ', $ids );
      $db->setQuery($query, $limitstart, $limit);
      return $db->loadObjectList();
      }
    }
    
    
    function checkSubs($myid)
    {
      $cid = JRequest::getInt('pid', JRequest::getInt('cid'));
      if (empty($cid) || empty($myid)) return false;
      $db = & JFactory::getDBO();
      $query = 'SELECT * FROM #__vflow_mychannels WHERE jid ='. (int) $myid.' AND cid ='. (int) $cid;
      $db->setQuery($query);
      return $db->loadObject();
    }
    
    function setSubAction($myid)
    {
      global $vparams;
      $task = JRequest::getCmd ('task');
      $cid = JRequest::getInt('pid', JRequest::getInt('cid'));
      if ($task == 'myvids') $cid = $myid;
      if (empty($cid)) return false;
      if ($task == 'myvids') {
      $subaction = '<div class="vf_tools" style="float:right;"><img class="vf_tools_icons" src="'.
                      JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.
                      $vparams->toolcolour.'/invite.gif'.'" /><a href="'.
                      JRoute::_('index.php?option=com_videoflow&task=cshare&cid='.
                      $cid.'&tmpl=component').'" class="modal-vflow" rel="{handler:\'iframe\', size: {x:780, y:480}}">'.
                      JText::_('COM_VIDEOFLOW_INVITE').'</a></div>';
      return $subaction;
      }
            
      $sub = $this->checkSubs($myid);
      if ($sub){
      $subaction = '<div class="vf_tools" style="float:right;"><img class="vf_tools_icons" src="'.
                      JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.
                      $vparams->toolcolour.'/unsubscribe.gif'.'" /><a href="'.
                      JRoute::_('index.php?option=com_videoflow&task=unsubscribe&cid='.
                      $cid.'&tmpl=component').'" class="modal-vflow" rel="{handler:\'iframe\', size: {x:600, y:480}}">'.
                      JText::_('COM_VIDEOFLOW_UNSUBSCRIBE').'</a></div>';
       } else {
       $subaction = '<div class="vf_tools" style="float:right;"><img class="vf_tools_icons" src="'.
                      JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.
                      $vparams->toolcolour.'/subscribe.gif'.'" /><a href="'.
                      JRoute::_('index.php?option=com_videoflow&task=subscribe&cid='.
                      $cid.'&tmpl=component').'" class="modal-vflow" rel="{handler:\'iframe\', size: {x:600, y:480}}">'.
                      JText::_('COM_VIDEOFLOW_SUBSCRIBE').'</a></div>';
        }
    return $subaction;
    }
    
    
    function getRand($limit){
    global $vparams;
    $id = JRequest::getInt('id');
    if (!$limit) {
    $xparams = $this->getXparams();
    $limit = (int) $xparams->get('limit', $vparams->limit);
    }
    $db = & JFactory::getDBO();
    $query = 'SELECT'.$this->_getSubquery().
			           ' WHERE published = 1 AND media.id != ' . (int) $id . ' ORDER BY RAND() LIMIT 0, '.$limit;
    $db->setQuery($query);
    return $db->loadObjectList();             
    }
    
    function getFavourites ($userid, $mid=null)
    {
      global $vparams;
      $lo = JRequest::getCmd('layout');
      $db = & JFactory::getDBO();
      $fbuser = JRequest::getInt ('fbuser', null);
      $c = JRequest::getCmd ('c');
      $task = JRequest::getCmd('task'); 
      $query = 'SELECT DISTINCT mid FROM #__vflow_mymedia WHERE mid !='. (int) $mid.' AND (jid='. (int) $userid;
      if ($fbuser) $query .= ' OR faceid='. (int) $fbuser;    
      $query .= ') ORDER BY date DESC';
      $db->setQuery($query);
      $ids = $db->loadResultArray();
      if (!$ids) {
      return false;
      } else {
      $fcount = count($ids);
      JRequest::setVar('fcount', $fcount);
      $limit = $vparams-> sidebarlimit;
      $limitstart = 0;
      if ($task == 'userfavs' || $c == 'fb' || $lo == 'playerview' || $lo == 'ajaxlist' || $lo == 'simple'){
              $this->_total = $fcount;
              $xparams = $this->getXparams();
              $limit = (int) $xparams->get('limit', $vparams->limit);
              $limitstart = $this->getState ('limitstart');                
      }
      if ($mid) {
      $f_count = $fcount + 1; 
      } else {
      $f_count = $fcount;
      }           
      JRequest::setVar('f_count', $f_count);
      $query = 'SELECT'.$this->_getSubquery().
               ' WHERE published = "1" AND media.id =' . implode( ' OR media.id = ', $ids );
      $db->setQuery($query, $limitstart, $limit);
      return $db->loadObjectList();
      }
    }
    
    function countFavs($userid)
    {
     $db = & JFactory::getDBO();
     $fbuser = JRequest::getInt ('fbuser');
     $query = 'SELECT DISTINCT mid FROM #__vflow_mymedia WHERE jid='. (int) $userid;     
     if (!empty($fbuser)) $query .= ' OR faceid='. (int) $fbuser;
     $db->setQuery($query);
     return count($db->loadResultArray());
    }
    
    function countUploads($userid)
    {
     $db = & JFactory::getDBO();
     $query = 'SELECT COUNT(*) FROM #__vflow_data WHERE published = 1 AND userid = '. (int) $userid;
     $db->setQuery($query);
     return $db->loadResult();
    }

    function getUsername ($usid)
    {
        global $vparams;
        $usr = &JFactory::getUser($usid);
 			  $usrname = $usr->username;
 			  if ($vparams->displayname) $usrname = $usr->name;
 			  if (empty($usrname)) $usrname = JText::_("COM_VIDEOFLOW_GUEST");
        return $usrname; 
		} 

    function getComments($media) 
    {
    global $vparams;
    $fbuser = JRequest::getInt('fbuser');
    $c = JRequest::getCmd('c');
    $xparams = $this->getXparams();
    $colorscheme = (string) $xparams->get('fbcolorscheme', $vparams->fbcolorscheme);
    $comments = JText::_('COM_VIDEOFLOW_WARN_COMMENT');
    if ($vparams->commentsys == 'facebook' || ($vparams->fbcommentint == 'auto' && $vparams->vmode == 1 && $fbuser) || $c == 'fb' && $vparams->fbcomments){
    $vxid = 'vf_'.$vparams->mode.'_'.$media->id;
    $clink = JURI::root().'index.php?option=com_videoflow&task=play&id='.$media->id;
  //  $clink = "http://apps.facebook.com/ugandabooks/&task=play&id=".$media->id;
    if ($vparams->playerwidth > 500) $cwidth = $vparams->playerwidth; else $cwidth = "500";
    $locale = JRequest::getWord('locale', 'en_US');
    $comments = '<div class="vf_fbcomments"><script src="http://connect.facebook.net/'.$locale.'/all.js#appId='.$vparams->appid.'&amp;xfbml=1"></script><fb:comments href="'.$clink.'" xid="'.$vxid.'" width="'.$cwidth.'" migrate="1" data-colorscheme="'.$colorscheme.'" num_posts="10"></fb:comments></div>';    
   // $comments = '<div class="vf_fbcomments"><fb:comments href="'.$clink.'" xid="'.$vxid.'" width="'.$cwidth.'" migrate="1" num_posts="10"></fb:comments></div>';    
    } elseif ($vparams->commentsys == 'jcomments') {
        if (file_exists($commentfile = JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php')){
        require_once ($commentfile);
        $jcomments = JComments::showComments ($media->id, 'com_videoflow', $media->title);
        if (!empty($jcomments)) {
        $comments = $jcomments;
        } else {
        $comments = JText::_('COM_VIDEOFLOW_WARN_JCOMMENTS');
        }
        } else {
        $comments = JText::_('COM_VIDEOFLOW_WARN_JCOMMENTS_PLUGIN');
        }
    } elseif ($vparams->commentsys == 'jomcomment') { 
        if (file_exists($commentfile = JPATH_PLUGINS . DS . 'content' . DS . 'jom_comment_bot.php')){
        require_once($commentfile);
        $jcomments = jomcomment( $media->id , 'com_videoflow' );
        if (!empty($jcomments)) {
        $comments = $jcomments;
        } else {
        $comments = JText::_('COM_VIDEOFLOW_WARN_JOM_COMMENT');
        }
        } else {
        $comments = JText::_('COM_VIDEOFLOW_WARN_JOM_COMMENT_INSTALL');
        }
    }
    return $comments;
    }

    
    function getCommentCount($mid)
    {
    global $vparams;
    $comcount = 0;
    if ($vparams->commentsys == 'jcomments'){
        if (file_exists($commentfile = JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php')){
        require_once ($commentfile);
        $jcomcount = JComments::getCommentsCount ($mid, 'com_videoflow');
        if (!empty($jcomcount)) $comcount = $jcomcount;
    } elseif ($vparams->commentsys == 'facebook'){
    $comcount = null;
    }
    return $comcount; 
    }
    }
    
    function _buildQuery()
	  {
	global $vparams;
	$task = JRequest::getCmd('task');
        $cat = JRequest::getVar('cat', "");
        if ($task == 'cats' && empty ($cat)) $cat = 0; 
        $where = ' WHERE published = "1"';
        if ($task == "featured") $where .= ' AND media.recommended="1"';
        if ($task == "uservids") {
        $usrid = JRequest::getInt('usrid');
        $where .= ' AND media.userid = '.(int) $usrid; 
        }
        if ($task == 'search' || $task == 'dosearch') {     
        $c = JRequest::getCmd ('c');
        $searchword = JRequest::getString ('searchword');
        if (empty($searchword)) {   
        $err = JText::_('COM_VIDEOFLOW_WARN_SEARCH');
        if ($c == 'fb') echo $err; else JError::raiseWarning(400, $err);
        return;
        } else {
        preg_replace("/[^a-z \d]/i", "", $searchword);
        $where .= ' AND MATCH (media.tags, media.title, media.details) AGAINST (\''.$searchword.'\')';
        }
        }
        if ($cat !== "") $where .= ' AND media.cat='.(int) $cat;
        $fil = $this->genMediaFilter('media.type');                  
        if (!empty($fil)) $fil = 'AND '.$fil;
        $where .= $fil;
        $id = JRequest::getInt('id');
        if ($id) $where .= ' AND media.id !='.(int) $id;
        $orderby = ' ORDER BY';
        if ($task == "popular") {
        $orderby .= ' media.views DESC';
        } elseif ($task == 'hirated'){
        $orderby .= ' media.rating / media.votes DESC, media.votes DESC';
        } elseif ($task == 'random') {
        $orderby .= ' RAND()';
        } elseif ($task == 'alphabetic'){
        $orderby .= ' media.title ASC';
        } else {
        $orderby .= ' media.dateadded DESC'; 
        }
        $query = 'SELECT'.$this->_getSubquery().
			           $where.
			           $orderby;
        return $query;
	   }
	   
	   function _getSubquery(){
        $query = ' media.*, u.name, u.username, c.name AS catname'. 
                 ' FROM #__vflow_data AS media' .
                 ' LEFT JOIN #__users AS u ON u.id = media.userid'.
                 ' LEFT JOIN #__vflow_categories AS c ON c.id = media.cat';
        return $query; 
     }
	   
 
    function _buildCode($media, $env = null)
    {
    $server = $media->server;
    if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') {
    return $this->photoCode($media);
    }
      if (empty($server)){
      $server = 'local';
      }
      if ($server != 'local') {
      $xserver = substr($server,0,strpos($server,'.'));
      if (!empty($xserver)) $server = $xserver;
      }
    if (file_exists($codebuilder = JPATH_COMPONENT_SITE.DS.'servers'.DS.'output'.DS.$server.'.php')) {
    require_once ($codebuilder);
    }
    $sclass = 'Videoflow'.ucfirst($server).'Play';
    $pclass = new $sclass;
    return $pclass->buildEmbedcode($media, $env);
    }
    
    function photoCode($media)
    {
    global $vparams;
    $c = JRequest::getCmd ('c');
    if ($c == 'fb') $pwidth = $vparams->fbpwidth; else $pwidth = $vparams->playerwidth;
    $file = $this->genMediaLink ($media, 'photos');
    return '<img src="'.$file.'" width="'.$pwidth.'" / >';
    }
    
    function genMediaFilter ($field)
    {
       $type = JRequest::getVar('type');   
       if ($type == 'audio') {
        $fil = $field.' = "mp3" OR '.$field.' = "wma"';
        } else if ($type == 'photos') {
        $fil = $field.' = "jpg" OR '.$field.' = "png" OR '.$field.' = "gif"';
        } else if ($type == 'video') {
        $fil = $field.' != "mp3" AND '.$field.' != "wma" AND '.$field.' != "jpg" AND '.$field.' != "png" AND '.$field.' != "gif"';        
        } else {        
        $fil = '';        
        }
    return $fil;
    }

    
    
    function genMediaLink($media, $dir)
    {
      global $vparams;
      if (stripos($media->file, 'http://') !== FALSE ) {
      $file = $media->file;
      } else if (stripos($media->medialink, 'http://') !== FALSE ) {
      $file = $media->medialink;
      } else {
      if (!empty($media->file)) $file = JURI::root().$vparams->mediadir.'/'.$dir.'/'.$media->file; else $file = '';
      }
      return $file;
    }
    
    function getMenu()
    {
    global $vparams;
    $task = JRequest::getCmd ('task', 'latest');
    $type = JRequest::getVar('type');
    $c = JRequest::getCmd ('c');
    $layout = JRequest::getWord('layout');
    $tabview = JRequest::getBool('tabview');
   // if ($layout == 'tabview') return $this->tabMenu();
    $htmlmenu = null;
    if (!empty ($type)) $type = '&type='.$type; else $type = '';
    $flowid = JRequest::getInt('Itemid');
    if (!empty ($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
    if ($tabview) {
    $menu = array ('home', 'fanpage', 'search', 'more');    
    } else {
    $menu = explode ("|", $vparams->menu);
    }
    if (!$vparams->showpro) {
    $menu = $this->runTool ('arrayValueDel', $menu, array('myvids'));
    }
    if (empty($vparams->helpid) && in_array('help', $menu)) {
    $menu = $this->runTool ('arrayValueDel', $menu, array('help'));
    }
    
    $newarr = array('myvids', 'categories', 'upload', 'search');
    $intarr = array_intersect($menu, $newarr);
    if (!empty($intarr)) {
    $vmenu = $this->runTool('arrayValueDel', $menu, $intarr);
    if(!empty($vmenu)) $menu = array_merge($vmenu, $intarr);
    }
    
    $menu = array_filter ($menu);
    $width = count($menu);
    if ($width) $width = round (90 / $width).'%';
    $selected = JRequest::getString('sl');
    if (empty($selected)) {
    if ($task == 'cats') $selected = 'categories'; else $selected = $task;
    }
    if ($selected == 'cats' || $task == 'cats') $selected = 'categories';
    if ($task == 'mysubs') $selected = 'myvids';    
    if(!empty($layout)) $layout = '&layout='.$layout; else $layout = '';
    if ($c == 'fb') {
     $root = $vparams->canvasurl;
     $layout = $flowid = '';
    } else {
     $root = JURI::root().'index.php?option=com_videoflow';
    }
    $popup = null;

    foreach ($menu as $menu){       
        $vlink = $root.'&task='.strtolower($menu).$layout.$flowid;
        if ($c == 'fb') $popup = 'target="_parent"';
        if ($menu == 'latest' || $menu == 'hirated' || $menu == 'random' || $menu == 'featured' || $menu == 'popular' || $menu == 'alphabetic') $vlink .= $type;
        if ($menu == 'hirated') {
            $dispname = 'COM_VIDEOFLOW_HIGHLY_RATED';
        } elseif ($menu == 'myvids') {
            $dispname = 'COM_VIDEOFLOW_MY_CHANNEL';
        } elseif ($menu == 'fanpage'){
            $dispname = 'COM_VIDEOFLOW_FAN_PAGE';
            $vlink = 'http://www.facebook.com/board.php?uid='.$vparams->appid;
        } elseif ($menu == 'more') {
            $vlink = $root.'&task=random';
            $dispname = 'COM_VIDEOFLOW_MORE';
        } elseif ($menu == 'upload'){
            $dispname = 'COM_VIDEOFLOW_ADD_MEDIA';
            $vlink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task='.strtolower($menu).'&tmpl=component');
            $popup = 'class="modal-vflow" rel="{handler: \'iframe\', size: {x: \'600\', y: \'480\'}}"';    
        } elseif ($menu == 'help') {
            $vlink = JRoute::_('index.php?option=com_content&view=article&id='.$vparams->helpid);
            $popup = 'target="_blank"';
            $dispname = 'COM_VIDEOFLOW_HELP';
        } else {
            $dispname = 'COM_VIDEOFLOW_'.strtoupper($menu);
        }
        if (strtolower($menu) == $selected) {
        $htmlmenu[]= '<div class="vfmenu_selected" style="min-width:'.$width.';"><a href="'.$vlink.'" "'.$popup.'">'.JText::_($dispname).'</a></div>';
        } else {
        $htmlmenu[] = '<div class="vfmenu" style="min-width:'.$width.';"><a href="'.$vlink.'" '.$popup.'>'.JText::_($dispname).'</a></div>';
        }
    $popup = null;
    }
    return $htmlmenu;
    }
    
    function tabMenu() {
        
        
    }
    

    
    function getTotal()
    {
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
    }
    
    
    function getPagination()
    {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        
        return $this->_pagination;
    }
    
    function storeVote()
    {
     global $vparams;
     require_once (JPATH_COMPONENT_SITE.DS.'extra'.DS.'votitaly'.DS.'vf_votitaly_ajax.php');
	   new VideoflowExtraVotitaly ($vparams);
     $res = JRequest::getInt('regvote');
     if (!$res){
     $fbuser = JRequest::getInt('fbuser');
	   $id = JRequest::getInt('cid');
	   $media = $this->getMedia($id);
	   $rating = JRequest::getInt('rating');
	   if (!empty($fbuser)) $this->createNews($media, array('action'=>'rating', 'result'=>$rating));
	   }
    }
    
    function runVprocess ($task = null, $pro = null)
    {
      $c = JRequest::getCmd('c');
      if ($c == 'fb') {
      return $this->runTool('runFprocess', $task, $this->runTool('createResp'));
      } else {
          if ($pro == 'sp'){
          return $this->runTool('runSprocess', $task, $this->runTool('createResp'));
          } else {
          return $this->runTool('runVprocess', $task, $this->runTool('createResp'));
          }
      }
    }
    
    
    function getVFuserObj ($fbuser)
    {
          include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
          return VideoflowUserManager::getVFuserObj($fbuser);
    }
    
    function getFBuserObj ($juser)
    {
          include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
          return VideoflowUserManager::getFBuserObj($juser);
    }

    
      
   function createRating ($id)
   {
    global $vparams;
   		$star_description = $vparams->stardesc;
      $db =& JFactory::getDBO();
      $query = 'SELECT *' .
					' FROM #__vflow_rating' .
					' WHERE media_id = '.(int) $id;
			$db ->setQuery($query);
			$rating = $db ->loadObject();
			if (!$rating)	{
				$rating_count = 0;
				$rating_sum   = 0;
				$average      = 0;
				$width        = 0;
			} else {
				$rating_count = $rating->rating_count;
				$rating_sum = $rating->rating_sum;		
				$average = number_format(intval($rating_sum) / intval( $rating_count ),2);
				$width   = $average * 20;
			}
	  $trans_star_description = $this->createRatingDesc($star_description, $rating_count, $average);
	  $html = '
    <!-- Votitaly v1.2 for VideoFlow starts here -->
    <div class="vf_votitaly-inline-rating" id="vf_votitaly-inline-rating-'. $id .'">
	  <div class="vf_votitaly-get-id" style="display:none;">'. $id .'</div> 
    ';
    if ($vparams->showstars) {
	  $html .= '
	 <div class="vf_votitaly-inline-rating-stars">
	  <ul class="vf_votitaly-star-rating">
	    <li class="vf_current-rating" style="width:'. $width .'%;">&nbsp;</li>
	    <li><a title="'.JText::_( 'COM_VIDEOFLOW_TERRIBLE' ) .'" class="vf_votitaly-toggler one-star">1</a></li>
	    <li><a title="'. JText::_( 'COM_VIDEOFLOW_ORDINARY' ) .'" class="vf_votitaly-toggler two-stars">2</a></li>
	    <li><a title="'. JText::_( 'COM_VIDEOFLOW_OKAY' ) .'" class="vf_votitaly-toggler three-stars">3</a></li>
	    <li><a title="'. JText::_( 'COM_VIDEOFLOW_QUITE_GOOD' ) .'" class="vf_votitaly-toggler four-stars">4</a></li>
	    <li><a title="'. JText::_( 'COM_VIDEOFLOW_BRILLIANT' ) .'" class="vf_votitaly-toggler five-stars">5</a></li>
	  </ul>
	</div>
	';
}
$html .= '
	<div class="vf_votitaly-box">
';
$html .= $trans_star_description;
$html .= '
	</div>
</div>
<!-- Votitaly v1.2 for VideoFlow ends here -->
';
  return $html;
  }

function createRatingDesc ( $string, $num_votes, $num_average ) 
{
  $patterns = array(
		'/{num_votes}/',
		'/{num_average}/',
		'/#VF_VOTES/',
		'/#VF_AVERAGE/',
		'/#VF_OUTOF/',
	);
	$replacements = array( 
		$num_votes, 
		$num_average, 
		($num_votes==1 ? JText::_( 'COM_VIDEOFLOW_VOTE') : JText::_( 'COM_VIDEOFLOW_VOTES')),
		JText::_( 'COM_VIDEOFLOW_AVERAGE'),
		JText::_( 'COM_VIDEOFLOW_TOTAL_SCORE')
	);
	return preg_replace($patterns, $replacements, $string);
}

function setField ($id, $field, $value)
{
    $db = & JFactory::getDBO();
    $query = 'UPDATE #__vflow_data SET ' . $field . ' = ' . $value . ' WHERE id='.(int) $id;
    $db->setQuery($query);
    $db->query();
}


function subscribe($myid)
{
  $id = JRequest::getInt('cid');
  $mes = $this->runTool('createResp');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
  $this->runTool('vfileInc', $vfile, 'vlm');
  if (!class_exists('VideoflowListManager')) return $mes; 
  $mes = VideoflowListManager::addCToList($id, $myid);
  if ($mes->status) {
  $db = &JFactory::getDBO();
  $query = 'UPDATE #__vflow_users SET subscribers = subscribers + 1 WHERE joomla_id='.(int) $id;
  $db->setQuery($query);
  if (!$db->query()) {
    JError::raiseError(500, JText::_($db->stderr()));
    return false;
    }
  }
  return $mes;
}

function countSubscribers ($cid)
{
  $db = & JFactory::getDBO();
  $query = 'SELECT COUNT(*) FROM #__vflow_mychannels WHERE cid='.(int) $cid;
  $db -> setQuery ($query);
  return $db->loadResult();
}

function unsubscribe ()
{
  $cid = JRequest::getInt('cid');
  $mes = $this->runTool('createResp');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
  $this->runTool('vfileInc', $vfile, 'vlm');
  if (!class_exists('VideoflowListManager')) return $mes; 
  $mes = VideoflowListManager::removeCfromList($cid);
  if ($mes->status) {
  $db = &JFactory::getDBO();
  $query = 'UPDATE #__vflow_users SET subscribers = subscribers - 1 WHERE joomla_id='.(int) $cid;
  $db->setQuery($query);
  if (!$db->query()) {
    JError::raiseError(500, JText::_($db->stderr()));
    return false;
    }
  }
  return $mes;
}


	function addmedia($myid)
  {
    $resp = $this->runTool('createResp');
    $embedlink = JRequest::getVar('embedlink');	
    $c = JRequest::getCmd ('c');
 		if (empty($embedlink)) {
		  $resp -> message = JText::_('COM_VIDEOFLOW_WARN_LINK');
		  return $resp;
    }
		$parselink = parse_url(trim($embedlink));
		$url = trim($parselink['host'] ? $parselink['host'] : array_shift(explode('/', $parselink['path'], 2)));
		preg_match('/(?P<server>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url, $data);
                if ($data['server'] == 'youtu.be') {
                    $data['server'] = 'youtube.com';
                    $embedlink = str_replace ('youtu.be/', 'youtube.com/watch?v=', $embedlink);
                }
		if (file_exists($vfile = JPATH_COMPONENT_SITE.DS.'servers'.DS.'input'.DS.$data['server'].'.php')) {
			 require_once ($vfile);
			 include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');
			 $videoinfo = VideoflowRemoteProcessor::processLink($embedlink);
			 if (!empty($videoinfo)){
       $videoinfo->userid = $myid;
       $faceid = JRequest::getInt('fbuser', '');
       $videoinfo-> faceid = $faceid;       
       $videoinfo->dateadded = & JFactory::getDate()->toFormat();
       $videoinfo->catlist = VideoflowCategoryManager::getCategories();
       if (!empty($videoinfo->cat)) $videoinfo->selcat = VideoflowCategoryManager::getCatId($videoinfo->cat);
       $videoinfo->status = 1;
       return $videoinfo;
       } else {
       return $resp;
       } 
    } else {
      $resp->message = sprintf(JText::_('COM_VIDEOFLOW_WARN_SERVER'), $data['server']);
      return $resp;
    }
  }
  
  function uploadmedia($user)
  {
    $db = & JFactory::getDBO();
    $title = JRequest::getString('title');
    $date = & JFactory::getDate();
    $query = "INSERT INTO #__vflow_data (id, title, dateadded, published, userid) VALUES ('', " . $db->quote( $db->getEscaped( $title ), false ). ",'" . $date->toMySQL() ."', '-1', '".(int) $user . "')";
    $db->setQuery($query);
    if (!$db->query()) {
    JError::raiseError(500, JText::_($db->stderr()));
    return false;
    }
    if ($id = $db->insertid()) {
    $data = new stdClass();
    $data->id = $id;
    $data->title = $title;
    $data->dateadded = $date;
    $data->userid = $user;
    return $data;
    } else {
    JError::raiseError(500, JText::_('COM_VIDEOFLOW_ERROR_REQUEST'));
    return false;
    }
  }


 function saveThumb()
 {
  global $vparams;
  jimport('joomla.filesystem.file');
  $newfile = JRequest::get( 'files' );
  $logfile = JPATH_COMPONENT.DS.'logs'.DS.'error.txt';
  	if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	
        $contents = fwrite($fp, "===================================================\r\n");
		    $contents = fwrite($fp, JText::_("File Manager: File details:")." \r\n");
		    $contents = fwrite($fp, print_r($newfile,true));
		    $contents = fwrite($fp, "\r\n");
		    fclose($fp);
	    }
  $id = JRequest::getInt ('id');
  if( !empty($newfile['myfile']['name']) ){  
    $fext = strtolower(JFile::getExt($newfile['myfile']['name']));
      if ($fext != 'jpg' && $fext != 'gif' && $fext != 'png') return false;
      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');
			$status = VideoflowFileManager::fileUpload( $newfile['myfile'], $vparams->mediadir.DS."_thumbs", $vparams->maxthumbsize*1024);	
			if(!$status || JError::isError($status)){
				$treport = JText::_('COM_VIDEOFLOW_ERROR_THUMB_UPLOAD');
			} else {
        $data = array ('id'=>$id, 'pixlink'=>$status['fname']);
        if (!JError::isError($this->writedata($data))){
        $treport = JText::_('COM_VIDEOFLOW_NOTICE_THUMB_UPLOAD');
        } 
      }
    echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload ("'.$treport.'");</script>';      
    }	 
 }

 function saveRemote()
    {
    if(!JRequest::checkToken() && !JRequest::checkToken('get')) JExit( 'Invalid Token' );
    global $vparams;
    $task = JRequest::getCmd('task');
    $status = $this->runTool('createResp');
    if ($task == 'saveRemote' || $task == 'saveFlash') $status->task = 'upload';
    $post = JRequest::get('post');
    $user = &JFactory::getUser($post['userid']);
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $auth = $user->getAuthorisedGroups();
    if (in_array(8, $auth) || in_array(7, $auth)) $usertype = 'Administrator';
    } else {
    $usertype = $user->usertype;    
    }
    if (!$vparams->useradd && ($usertype != 'Super Administrator' && $usertype != 'Administrator')) {
    $status->message = JText::_('COM_VIDEOFLOW_ERROR_PERM_ADD');
    $status->type = 'error';
    $status->task = 'status';
    return $status;
    }
    if ($task == 'saveFlash') {
    $pubset = $vparams->autopubups;
    } else {
    $pubset = $vparams->autopubadds;
    }
    
    if (!$pubset && ($usertype != 'Super Administrator' && $usertype != 'Administrator')) {
    $post['published'] = 0;
    }
    $file = JRequest::getVar ('file');
    $title = JRequest::getString ('title');
    if (empty ($title)) {
    $status->message = JText::_('COM_VIDEOFLOW_ERROR_TITLE');
    return $status;
    }
    if ($task == 'saveRemote') {
    $db = & JFactory::getDBO();
    $query = 'SELECT * FROM #__vflow_data WHERE file ='.$db->quote($file).
             ' OR title LIKE '.$db->quote ('%'.$db->getEscaped ($title, true).'%',false );
    $db-> setQuery($query);
    $media = $db->loadObject();
    if (!empty($media)) {
    $status->message = "\"$title\" ".JText::_('COM_VIDEOFLOW_EXISTS')."<a href='".
                       JRoute::_(JURI::root().'index.php?option=com_videoflow&task=add&id='.$media->id)."'> ".
                       JText::_('COM_VIDEOFLOW_NOTICE_ADD_TO_LIST')."</a>";                              
     return $status;
     } 
    }
    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');
    if ($ret = VideoflowFileManager::saveRemoteFile($post)) {
        $status->status = true;
        $status->id = $ret;
        $status->message = "\"$title\" ".JText::_('COM_VIDEOFLOW_SAVED'); 
        if (!$pubset && ($usertype != 'Super Administrator' && $usertype != 'Administrator')) {
        $status->message = "\"$title\" ".JText::_("COM_VIDEOFLOW_ADMIN_APPROVAL"); 
        }
        $status->type = 'message';     
        }
		return $status;   
    }  	

function saveXpload()
{
 global $vparams; 
    JRequest::checkToken('get') or JExit( 'Invalid Token' );
    require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');
    $res = VideoflowFileManager::saveXpload();
    if (!empty($res)) {
    $this->saveUpload($res);
    } 
}


function saveUpload($newfile = null)
{
  global $vparams; 
    if (empty($newfile)){
    JRequest::checkToken('get') or JExit( 'Invalid Token' );
    $newfile = JRequest::get( 'files' );
    } 
    if (empty($newfile)) return false;
	  $logfile = JPATH_COMPONENT_SITE.DS.'logs'.DS.'uploadlog.txt';
	  $id = JRequest::getInt('media_id');
    $fbuser = JRequest::getInt ( 'fb_user');
    $userid = JRequest::getInt ( 'user_id');
		$juser = & JFactory::getUser ();
	  $logfile = JPATH_COMPONENT_SITE.DS.'logs'.DS.'uploadlog.txt';
	  $db =& JFactory::getDBO();
		if (!$juser->guest && ($juser->id != $userid)) return false;
		if (empty($juser->id) && !empty($userid)) $juser = & JFactory::getUser ($userid);
    if ($juser->guest && (!empty($fbuser))) {
          $query = 'SELECT joomla_id FROM #__vflow_users WHERE fb_id ='.(int) $fbuser;
          $db->setQuery( $query );
          $ju = $db->loadResult();
          if (!$ju) return false; else $juser = &JFactory::getUser ($ju);
    }  
    if (empty ($juser)) return false;
    $date = &JFactory::getDate();
	  $folder = JPATH_ROOT.DS.$vparams->mediadir; 
    if( !empty($newfile['Filedata']['name']) ){
      jimport('joomla.filesystem.file');
      $uptype = strtolower(JFile::getExt($newfile['Filedata']['name']));
      $newfile['Filedata']['user'] = $juser->username;
      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');
    	if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	
        $contents = fwrite($fp, "===================================================\r\n");
		    $contents = fwrite($fp, JText::_("Frontend Upload: File details:")." \r\n");
		    $contents = fwrite($fp, print_r($newfile['Filedata'],true));
		    $contents = fwrite($fp, "\r\n");
		    fclose($fp);
	    }
    
      if (!$subdir = $this->dirselect($uptype)){
          $status =  JText::_('COM_VIDEOFLOW_ERROR_UPLOAD_DIR');
          $data ['1']['success'] = JText::_("NO");
	        $data ['1']['error'] = $status;
	        $data ['1']['user'] = $juser->username;
	        $data ['1']['date'] = $date->toFormat();
	        if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	
                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 
                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 
                  fclose($fp);
          }
          return false;
       }
      $filepath = JPATH_ROOT.DS.$vparams->mediadir.DS.$subdir.DS; 
			    if(!file_exists($filepath)) mkdir($filepath,0777);
			    chmod($filepath,0777);
   			  $status = VideoflowFileManager::fileUpload( $newfile['Filedata'], $folder.DS.$subdir, $vparams->maxmedsize*1024*1024);	
   			  chmod($filepath,0755);
           if (JError::isError($status)){
               $data ['1']['success'] = JText::_("NO");
	             $data ['1']['error'] = $status->message;
	             $data ['1']['user'] = $juser->username;
	             $data ['1']['date'] = $date->toFormat();
	                if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	
                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 
                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 
                  fclose($fp);
                  }
              return false;
          }
          
          $query = "SELECT * FROM #__vflow_data WHERE id =". (int) $id;
          $db = & JFactory::getDBO();
	        $db->setQuery($query);
	        $data = $db -> loadAssocList();
	        $data['0']['file'] = $status['fname'];    
	        $data['0']['userid'] = $juser->id;
	        $data['0']['type'] = $uptype;
	        $data['0']['server'] = "local";
	        $data['0']['published'] = 1; 
	        $data['1']['success'] = JText::_("YES");
	        $data['1'] ['location'] = $status['fpath'];
	        $data['1']['user'] = $juser->username;
	        $data['1']['date'] = $date->toFormat();

    if (!empty ($data) && (file_exists($status['fpath']))){
        $post = $data['0'];
        if (empty($post['pixlink']) && $vparams->autothumb) {
            if ($uptype == 'mp4' || $uptype == 'flv') {
                $pixlink = $this->runTool('genThumb', $status['fpath'], JFile::stripExt ($status['fname']).'.jpg');
                if (!empty($pixlink)) {
                    $post['pixlink'] = $data['0']['pixlink'] = $pixlink;
                }
            }
        }
        if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	
            $contents = fwrite($fp, JText::_("Media File Details:")." \r\n"); 
            $contents = fwrite($fp, print_r($data['0'], true)." \r\n"); 
            $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 
            $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 
            $contents = fwrite($fp, print_r($status, true)." \r\n"); 
            fclose($fp);
        }
    } else {
        $data ['2']['success'] = JText::_("NO");
	      $data ['2']['error'] = JText::_("Unknown error");
	      $data ['2']['user'] = $juser->username;
	      $data ['2']['date'] = $date->toFormat();
	      if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	       	
              $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 
              $contents = fwrite($fp, print_r($data['2'], true)." \r\n"); 
              $contents = fwrite($fp, print_r($status, true)." \r\n"); 
              fclose($fp);
        }
        return false;
       }
    }  			  
    if (JError::isError($row = self::writedata($post))){
        $message = $row;
        } else {
        $message = JText::_( 'COM_VIDEOFLOW_ITEM_SAVED' );
        if (!empty($fbuser) && !empty($ju)) {
        $this->createNews (NULL, array('action'=>'upload', 'id'=>$id));
        }
        }
 return true;
}


 function writedata($data){
  
    $row =& JTable::getInstance('Media', 'Table');
 	  if (!$row->bind( $data)) {
    	return JError::raiseWarning( 500, $row->getError() );
		}
    if (!$row->store()) {
      return JError::raiseWarning(500, $row->getError());
    }
    return $row;
  }

function dirselect($uptype){
    switch ($uptype){
          case 'mp3':
          case 'aac':
          $dir = 'audio';
          break;
          
          case 'flv':
          case 'mp4':
          $dir = 'videos';
          break;
          
          case 'swf':
          $dir = 'flash';
          break;
          
          case 'jpg':
          case 'gif':
          case 'png':
          $dir = 'photos';
          break;
          
          default:
          $dir = false;
          break;
        }          
  return $dir;
  }

  function getDownload()

  {

    global $vparams;
    $status = $this->runTool ('createResp');
    $user = & JFactory::getUser();
    $fbuser = JRequest::getInt('fbuser');
    if (empty($user->id) && empty($fbuser)) {
    $status->message = JText::_('COM_VIDEOFLOW_WARN_DOWNLOAD');
    return $status;
    }

    if (!$vparams->downloads) return $status;
    
    if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');  

    $id = JRequest::getInt('id');

    $data = $this->getFile($id);

    if (empty($data) || empty($data->download) || $data->server != 'local' || empty($vparams->vmode)) return $status;

    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 

    $fileinfo = VideoflowFileManager::getFileInfo($data->type);

    if (stristr($data->file, 'http') !== FALSE) {
    
    $fileloc = VideoflowFileManager::genpath($data->file);
    
    $file = $data->file;

        } else {
        
        $file = $vparams->mediadir.'/'.$fileinfo['dir'].'/'.$data->file;
        
        $fileloc = JPATH_ROOT.DS.$vparams->mediadir.DS.$fileinfo['dir'].DS.$data->file;

        }
    
    if(!file_exists($fileloc) || !is_readable($file)){
    return $status;
    }
    
   $fname = substr(stristr ($file, "vf_"), 13);
   $fname = str_replace (" ", "_", $fname);
   if (empty($fname)) $fname = 'file.'.$data->type;
   $size=filesize($file);
   $content_type = $fileinfo['mime'];
   if (empty($content_type)) $content_type = "application/force-download";
    $this->setField($id, 'downloads', 'downloads + 1');
    header('Pragma: public'); 
    header('Expires: 0');  
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header("Content-type: $content_type");
    header("Content-Length: $size");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=\"$fname\"");
    header("Content-Transfer-Encoding: binary");
    header('Connection: close');
    readfile($file); 
    exit();
}


function getUploadStatus()
{
  $status = $this->runTool ('createResp');
  include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');
  $status = VideoflowFileManager::getStatus($status);
  return $status;
}


function remove ()
{
  $id = JRequest::getInt('id');
  $media = $this->getFile ($id);
  $mes = $this->runTool ('createResp');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
  $this->runTool('vfileInc', $vfile, 'vlm');
  if (!class_exists('VideoflowListManager')) return $mes; 
  $mes = VideoflowListManager::removeFromList($id, $media, $mes);
  if ($mes->status) $this->setField($id, 'favoured', 'favoured - 1');
  return $mes;
}

function delete($vu)
{
  global $vparams;
  $id = JRequest::getInt('id');
  $vid = $this->getFile($id);
  $mes = $this->runTool ('createResp');
  if ($vid->userid != $vu->myid && $vu->utype != 'Administrator' && $vu->utype != 'Super Administrator') {
  return $mes;
  }
  if (!$vparams->candelete && $vu->utype != 'Administrator' && $vu->utype != 'Super Administator') {
  return $mes;
  }
  $this->setField($id, 'published', '-1');
  $mes->status = true;
  $mes->message = '<b>'.$vid->title.'</b> '.JText::_('COM_VIDEOFLOW_DELETED');
  $mes->type = 'message';
  $mes->task = 'status';
  return $mes;
}

function transRating($val){
  switch ($val){
  case 1:
  $txt = JText::_('COM_VIDEOFLOW_SUCKS');
  break;
  
  case 2:
  $txt = JText::_('COM_VIDEOFLOW_IS_ORDINARY');
  break;
  
  case 3:
  $txt = JText::_('COM_VIDEOFLOW_IS_OK');
  break;
  
  case 4:
  $txt = JText::_('COM_VIDEOFLOW_IS_GOOD');
  break;
  
  case 5:
  $txt = JText::_('COM_VIDEOFLOW_IS_BRILLIANT');
  break;
  
  default:
  $txt = 0;
  break;
  }
  return $txt;
}


function add($myid)
{
  global $vparams;
  $id = JRequest::getInt('id');
  $c = JRequest::getCmd ('c');
  $fbuser = JRequest::getInt('fbuser');
  $media = $this->getMedia($id);
  $mes = $this->runTool('createResp');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
  $this->runTool('vfileInc', $vfile, 'vlm');
  if (!class_exists('VideoflowListManager')) return $mes;  
  $mes = VideoflowListManager::addToList($id, $myid, $media, $mes);
  if ($mes->status) {
  $this-> setField($id, 'favoured', 'favoured + 1');
  $this->createNews($media, array('action'=>'add'));
  } 
  return $mes;
}

// FKNOTE: Array must include 'action'. May include 'id', 'joomla_id'

function createNews($media, $array)
{
  global $vparams;
  $app = &JFactory::getApplication();
  $fbuser = JRequest::getInt('fbuser');
  $perms = JRequest::getVar('perms');
  if (empty($perms[0]['publish_stream'])) return;
  if (empty($media)) $media = $this->getMedia($array['id']);
  if (empty($media)) return;
  $c = JRequest::getCmd('c');
  if ($c == 'fb') {
  $link = $vparams->canvasurl.'&task=play&id='.$media->id.'&vf=1';
  $sname = $vparams->appname;
  } else {
  $link = JURI::root().'index.php?option=com_videoflow&task=play&id='.$media->id;
  $sname = $app->getCfg('sitename');
  }   
  if (empty($sname)) {
  $sname = JURI::root();
  if (stripos($sname, 'http://') === 0 ) {
  $sname = substr($sname, 7);
  } else if (stripos($sname, 'https://') === 0 ) {
  $sname = substr($sname, 8);
  }
  if (stripos($sname, 'www.') === 0 ) {
  $sname = substr($sname, 4);
  }
  }
  $fbuserdata = JRequest::getVar('fbuserdata');
  if (!empty($fbuserdata['gender'])) $gender = $fbuserdata['gender']; else $gender = 'undefined';
    
  switch ($array['action'])
  {
    case 'rating':
    $result = $this->transRating($array['result']);
    if (!$result) return;
    $action = JText::_('COM_VIDEOFLOW_SAYS').' "'.$media->title.'" '.$result.' '.JText::_('COM_VIDEOFLOW_JUDGE');
    break;
        
    case 'upload':
    case 'add':
    if ($array['action'] == 'upload') {
    $action = JText::_('COM_VIDEOFLOW_UPLOADED').' '.'"'.$media->title.'"';
    } else {
    $action = JText::_('COM_VIDEOFLOW_ADDED').' '.'"'.$media->title.'"';    
    }
    if ($gender == 'male') {
    $action .= ' '.JText::_('COM_VIDEOFLOW_HIS_CHANNEL');
    } else if ($gender == 'female') {
    $action .= ' '.JText::_('COM_VIDEOFLOW_HER_CHANNEL');
    } else {
    $action .= ' '.JText::_('COM_VIDEOFLOW_THEIR_CHANNEL');
    }
    $action .= ' '.$sname;    
    if ($c == 'fb' && (!empty($fbuser))) {
    $link = $vparams->canvasurl.'&task=visit&cid='.$fbuser.'&id='.$media->id.'&vf=1';
    } else {
    if (!empty($fbuser)) {
      if (!empty ($array['joomla_id'])) {
      $ju = $array['joomla_id'];
      } else {
      $juser = $this->getVFuserObj($fbuser);
      if (!empty($juser->joomla_id)) $ju = $juser->joomla_id;
      } 
      if (!empty($ju)) {
      $link = JURI::root().'index.php?option=com_videoflow&task=visit&cid='.$ju.'&id='.$media->id;
      }
    }
    }
    break;

    default:
    return;
    break;
  }
  $this->createFeed($media, $action, $link); 
}

function createFeed($media, $u_action, $mlink) 
{
  global $vparams;
  $c = JRequest::getCmd('c');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fb_tools.php';
  $this->runTool('vfileInc', $vfile, 'vft');
  if (!class_exists('VideoflowFbTools')) return false;

  if (empty($media->favoured)) $media->favoured = '';
  
  $fv = $this->_buildCode($media, 'fb');
  
  if (!empty($fv)) {
  $fvc = $fv['player'].'?'.$fv['flashvars'];
  } else {
  $fvc = '';
  }  
  
      if ($c == 'fb') {
      $tag_link = $vparams->canvasurl.'&task=dosearch&searchword='.$media->tags.'&vf=1';
      $source_link = $vparams->canvasurl;
      } else {
      $tag_link = JURI::root().'index.php?option=com_videoflow&task=search&vs=1&searchword='.$media->tags;
      $source_link = JURI::root().'index.php?option=com_videoflow';
      }
      
     $xid =  'vf_'.$vparams->mode.'_'.$media->id;
     $n = array(
          'message'=>$u_action,
          'picture'=>$media->pixlink,
          'link'=>$mlink,
          'description'=>$media->details,
          'source'=>$fvc,
          'comments_xid'=> $xid,
          'properties' => array(JText::_('COM_VIDEOFLOW_TAGS') => array(
                              'text' => $media->tags,
                              'href' => $tag_link),
                              JText::_('COM_VIDEOFLOW_FANS') => $media->favoured,
                              JText::_('COM_VIDEOFLOW_SOURCE') =>array (
                              'text' => $vparams->appname,
                              'href' => $source_link)
                              ),
          'action_links' => array(
                          array('text' => JText::_('COM_VIDEOFLOW_TUNE_IN'),
                            'href' => $mlink)    
                            )
          );
     VideoflowFbTools::fbnewsFeed ($n);
}

function createPost($id)
{
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fb_tools.php';
  $this->runTool('vfileInc', $vfile, 'vft');
  if (!class_exists('VideoflowFbTools')) return false;
  $media = $this->getMedia($id);
  if (empty($media->favoured)) $media->favoured = '';
  $fv = $this->_buildCode($media, 'fb');
  if (!empty($fv)) {
  $fvc = $fv['player'].'?'.$fv['flashvars'];
  } else {
  $fvc = '';
  }
  $media->fvc = $fvc;
    VideoflowFbTools::fbwallPost($media);
}



function runTool($func=null, $param1=null, $param2=null, $param3=null, $param4=null)
{
  include_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php';
  $tools = new VideoflowTools();
  $tools->func   = $func;
  $tools->param1 = $param1;
  $tools->param2 = $param2;
  $tools->param3 = $param3;
  $tools->param4 = $param4;
 return $tools->runTool();
}

function setVisitors($id)
{
  $db = & JFactory::getDBO();
  $query = 'SELECT * FROM #__vflow_users WHERE joomla_id='.(int) $id;
	$db->setQuery($query);
  $res = $db->loadObject();
  if (!$res){
  include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
  $vdata['joomla_id'] = $id;
  $vdata['visitors'] = 1;
  VideoflowUserManager::vfusersNew($vdata);
  return 1;
  }
  $user = JRequest::getVar('juser');
  if ($user && ($user->id == $id)) return $res->visitors;
  $query = 'UPDATE #__vflow_users' .
					 ' SET visitors = visitors + 1' .
					 ' WHERE joomla_id = '.(int) $id;
	$db->setQuery($query);
	$db->query();
	return $res->visitors + 1;
}

function getXparams()
  {
    global $fxparams;
    $context = JRequest::getCmd('c');
    if ($context == 'fb') {
    $xparams = $fxparams;    
    } else {
    $app = &JFactory::getApplication();
    $xparams = &$app->getParams('com_videoflow');    
    }   
    return $xparams;
  }
}