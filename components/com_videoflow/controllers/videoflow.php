<?php

//VideoFlow - Joomla Multimedia System for Facebook//
/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/


// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');

class VideoflowController extends JController
{
     
      function __construct()
    {
        global $vparams;
        parent::__construct();
        $this->registerTask ('report', 'email');   
        $this->registerTask ('eshare', 'email');  
        $this->registerTask ('saveEdit', 'saveRemote');  
        $this->registerTask ('saveFlash', 'saveRemote');
	$c = JRequest::getCmd ('c');
        if ($c || ($vparams->facebook && !empty ($vparams->appid) && !empty($vparams->fbsecret))) {
	$this->loadFbConn();
	include_once (JPATH_COMPONENT_SITE.DS.'fbook'.DS.'facebook.php');
        $fb = new Facebook(array(
        'appId' => $vparams->appid,
        'secret' => $vparams->fbsecret,
        'cookie' => true
        ));
        $fbuser = $fb->getUser();
	if (!empty($fbuser)) {
	    try{
	    $fbme = $fb->api('/me');
	    } catch (Exception $ex) {}
	    if (!empty($fbme['id'])) {
	    JRequest::setVar('fbuser', $fbme['id']);
	    JRequest::getVar('fbuserdata', $fbme);
	    try {
	        $q = array(
	        'method' => 'fql.query',
	        'query' => 'SELECT user_videos,friends_videos,offline_access,email,publish_stream FROM permissions WHERE uid = "'.$fbme['id'].'"'
	        );
	    JRequest::setVar('perms', $fb->api($q));
	    } catch (Exception $ex) {
	    }
          $lo = JRequest::getVar('layout', '');
	  if (!empty ($lo)) $lo = '&layout='.$lo;
	  $Itemid = JRequest::getInt('Itemid');
	  if (!empty($Itemid)) $Itemid = '&Itemid='.$Itemid; else $Itemid = '';
	  if ($c == 'fb') $redir = $vparams->canvasurl.'&task=vflogout'; else $redir = JURI::root().'index.php?option=com_videoflow&task=vflogout'.$lo.$Itemid; 
	  $logout = $fb->getLogoutUrl (array ('next' => $redir));
	  if (!empty($logout)) JRequest::setVar('logouturl', $logout);
	  }    
        } 
      }
    }
    
    function display()
    {   
       global $vparams;
       $layout = $this->vlayout();
       $v = JRequest::getCmd ('view');
       if ($v == 'xml') {
       $view = & $this->getView('xml', 'xml');
       $layout = 'default';
       } else {
       $view = & $this->getView('videoflow', 'html');
       }
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> display();
    }
    
    function tabview () {
      global $vparams;
      JRequest::setVar('tabview', 1);
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout('tabview');
       $view -> display();
    }
    
            
    function myvids()
    {
        global $vparams;
	$c = JRequest::getCmd('c');
	$task = JRequest::getCmd('task','myvids');
        $vprocess = $this->vprocess();
	$sess = JRequest::getBool('sess');
        if ($vprocess->status) {
        $layout = $this->vlayout('_play');  
        $view = & $this->getView('videoflow', 'html');
        $model = & $this->getModel('videoflow');
        $view->setModel($model, true);
        $view->setLayout($layout);	
	if (!empty($vprocess->fbuser)) $view->fbowner = $vprocess->fbuser;
        $view -> displayMyvids($vprocess->myid);
        } else {
	    if ($c == 'fb' || !empty($sess)) {
		$this->createSession($task);
	    } else {
	    $lo = JRequest::getCmd('layout');
	    if ($lo == 'playerview') $lo = 'listview_login'; else $lo = $this->vlayout('_login');  
	    if (!empty($lo)) $lo = '&layout='.$lo; else $lo = '';
	    $link = html_entity_decode(JRoute::_('index.php?option=com_videoflow&task='.$vprocess->task.'&direct=myvids'.$lo));
	    $this->setRedirect($link, $vprocess->message, $vprocess->type);
	    }
	}
    }
    
    function myfavs ()
    {
        global $vparams;
        $vprocess = $this->vprocess();        
        if ($vprocess->status) {
        $layout = $this->vlayout('_play');  
        $view = & $this->getView('videoflow', 'html');
        $model = & $this->getModel('videoflow');
        $view->setModel($model, true);
        $view->setLayout($layout);
        $view -> displayMyfavs($vprocess->myid);
        } else {
        $lo = JRequest::getCmd('layout');
        if (!empty($lo)) $lo = '&layout='.$lo; else $lo = '';
        $link = html_entity_decode(JRoute::_('index.php?option=com_videoflow&task='.$vprocess->task.'&direct=myfavs'.$lo));
        $this->setRedirect($link, $vprocess->message, $vprocess->type);
        }
    }

    
    function cats()
    {
        global $vparams;
        $lo = JRequest::getCmd('layout'); 
        $model = & $this->getModel('videoflow');
	$id = JRequest::getInt('id');
	$c = JRequest::getCmd('c');
        $vlist = $model->getData();
        if ($vlist || !empty($id)) {
          $view = & $this->getView('videoflow', 'html');
          $view->setModel($model, true);
          if (!empty($vparams->catplay) && $lo != 'playerview') {
	  $layout = $this->vlayout('_play');  
          $view->setLayout($layout);
          $view -> displayCats($vlist);
          } else {
          $layout = $this->vlayout();
          $view->setLayout($layout);
          $view->displayByCat($vlist);
          }
        } else {
        $lo = JRequest::getCmd('layout');
        if (!empty($lo)) $lo = '&layout='.$lo; else $lo = '';
        $link = html_entity_decode(JRoute::_('index.php?option=com_videoflow&task=categories'.$lo));
	if ($c == 'fb') {
	$link = html_entity_decode($vparams->canvasurl.'&task=categories');    
	}
        $err = JText::_('COM_VIDEOFLOW_NO_MEDIA_IN_CATEGORY');
        $this->setRedirect($link, $err, 'error');
        }    
    }
          
    
    function visit()
    {
        global $vparams;
	//Get channel id
	$cid = JRequest::getInt('cid', JRequest::getInt('pid'));
        $layout = $this->vlayout('_play');  
        $view = & $this->getView('videoflow', 'html');
        $model = & $this->getModel('videoflow');
        //Get logged in FB user
	$fbuser = JRequest::getInt('fbuser');
        //Get logged in Joomla user
	$user = &JFactory::getUser();
  	$view->setModel($model, true);
        $view->setLayout($layout);
	//Get and set FB credentials for selected channel
	$vfuser = $model->getFBuserObj($cid);
	if (!empty($vfuser)) $view->fbowner = $vfuser->fb_id;
	if (empty($user->name)) $user->name = JText::_('COM_VIDEOFLOW_GUEST');
	
	//Set Joomla credetials for selected channel
	if (!empty($cid) && $cid == $user->id) {
	$view->assignRef('owner', $user);
	//$view->owner = $user;
	} else {
	$owner = & JFactory::getUser($cid);
	$view->assignRef('owner', $owner);    
	}
	//If the channel owner is the same things as the logged in user, redirect to myvideos
	if ($vparams->prostatus && ($user->id && $user->id == $cid || $vfuser->fb_id && $vfuser->fb_id == $fbuser)) {
	    JRequest::setVar('task', 'myvids');	    
	}      
        $view -> displayMyvids($cid);
    }
    
    function userfavs()
    {
       $layout = $this->vlayout();
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayUserfavs();
    }
    
    
    function mysubs()
    {
      global $vparams;
        $vprocess = $this->vprocess();        
        $lo = JRequest::getCmd('layout');
        $id = JRequest::getInt('id');
	$c = JRequest::getCmd('c');
	if ($c == 'fb' && empty($lo)) $lo = $vparams->ftemplate;
        if ($vprocess->status) {
        if (($lo == 'playerview' || $lo == 'simple') && empty($id)) {
        $layout = 'listview_categories';  
        } else {
        $layout = $this->vlayout('_play');  
        }
        $view = & $this->getView('videoflow', 'html');
        $model = & $this->getModel('videoflow');
        $view->setModel($model, true);
        $view->setLayout($layout);
        $view -> displayMysubs($vprocess->myid);
        } else {
        if (!empty($lo)) $lo = '&layout='.$lo; else $lo = '';
        $link = html_entity_decode(JRoute::_('index.php?option=com_videoflow&task='.$vprocess->task.'&direct=mysubs'.$lo));
        $this->setRedirect($link, $vprocess->message, $vprocess->type);
        }
    }


    function login()
    {
      $layout = $this->vlayout ();
      $model = & $this->getModel('videoflow');
      $view = & $this->getView ('videoflow', 'html');
      $view->setModel ($model, true);
      $view->setLayout ($layout);
      $view->displayLogin();
    }
    
    function logout()
    {
      $layout = $this->vlayout ();
      $model = & $this->getModel('videoflow');
      $view = & $this->getView ('videoflow', 'html');
      $view->setModel ($model, true);
      $view->setLayout ($layout);
      $view->displayLogout();
    }

    
    
    function vote()
    {
        $model = & $this->getModel('videoflow' );
        $model->storeVote();
    }
    
    function saveRemote()
    {
      global $vparams;
      $fbuser = JRequest::getInt('fbuser');
      $perms = JRequest::getVar('perms');
      $model = & $this->getModel('videoflow');
      $status = $model->saveRemote(); 
      if (!empty($status->id) && !empty($fbuser) && !empty($perms[0]['publish_stream'])) {
      $model->createNews(null, array('action'=>'upload', 'id'=>$status->id));
      }
      if (!empty($vparams->appid) && !empty($status->id) && !empty($vparams->wallposts)) $model->createPost ($status->id);
      $link = JRoute::_('index.php?option=com_videoflow&task='.$status->task.'&tmpl=component');
      $this->setRedirect($link, $status->message, $status->type);
    }
    
    
    function saveUpload(){

     $model = & $this->getModel('videoflow');
     $model->saveUpload();
    }
    
    function saveXpload(){
     $model = & $this->getModel('videoflow');
     $status = $model->saveXpload();
    }
    
    function saveThumb(){
     $model = & $this->getModel ('videoflow');
     $model->saveThumb();
    }
    

    function getStatus()
    {
     $model = & $this->getModel('videoflow');
     $status = $model->getUploadStatus();
     if ($status->status){
     $link = JRoute::_('index.php?option=com_videoflow&task=edit&cid='.$status->cid.'&userid='.$status->userid.'&tmpl=component&auto=1');
     } else {
     $link = JRoute::_('index.php?option=com_videoflow&task=upload&tmpl=component');
     }
     $this->setRedirect ($link, $status->message, $status->type);
    }
    
    
    function edit()
    {
       global $vparams;
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel ($model, true); 
       $vprocess = $this->vprocess('sp');
       $id = JRequest::getInt('cid');
       $userid = JRequest::getInt('userid');
       $auto = JRequest::getBool('auto');
       $data = $model->getFile($id);
       $mes = JText::_('COM_VIDEOFLOW_ERROR_REQUEST');
       $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
       switch ($auto){
          case true:
          if (!empty ($data) && $vprocess->myid == $userid && $vprocess->myid == $data->userid) { 
          $view->displayEditForm($data);
          } else {
          $model->setField($id, 'published', '-1');
          $this->setRedirect ($link, $mes, 'error');
          }
          break;
          
          case false:
          if (!empty($data) && $vparams->useredit && $vprocess->myid == $data->userid){
          $view->displayEditForm($data);
          } else if (!empty($data) && ($vprocess->utype == 'Super Administrator' || $vprocess->utype == 'Administrator')) {
          $view->displayEditForm($data);
          } else {
          $this->setRedirect ($link, $mes, 'error');
          }
          break;
       }   
    }
    
            
    function categories()
    {
       $lo = JRequest::getCmd('layout');
       if ($lo == 'playerview') {
       $layout = 'listview_categories';
       } else {
       $layout = $this->vlayout('_categories');
       }
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayCategories();
    }
    
    function cshare()
    {
       $fb = JRequest::getInt('fbuser', '');
       if ($fb){
       $layout = $this->vlayout('_status');
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayCshare();
       } else {
       $id = JRequest::getInt('cid');
       $link = JRoute::_('index.php?option=com_videoflow&task=eshare&tmpl=component&id='.$id);
       $this->setRedirect($link);
       }
    }
    
     
    function play()
    {  
       $id = JRequest::getInt('id');
       $layout = $this->vlayout('_play');
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayMedia($id);
    }    
    
    
    function search()
    {
       $lo = JRequest::getCmd ('layout');
       if ($lo == 'playerview'){
       $layout = $this->vlayout('_search');
       } else {
       $layout = $this->vlayout();
       }
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displaySearch();
    }
    
   function searchplay()
    {  
       $layout = $this->vlayout('_play');
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displaySearchPlay();
    }    

    
    function email()
    {
       $id = JRequest::getInt('id');
       $view = & $this->getView('videoflow', 'html');
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $view -> displayEmail($id);
    }
    
    function emailsend()
    {
       $model = & $this->getModel('videoflow');
       $status = $model->emailsend();
       $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
       $this->setRedirect($link, $status->message, $status->type);
    }
    
    function status()
    {
        $layout = $this->vlayout('_status');
        $view = $this->getView('videoflow', 'html');
        $view->setLayout($layout);
        $view->displayStatus();
    }

    function add()
    {
    $status = $this-> vprocess();
    if ($status->status) {
    $model = & $this->getModel('videoflow');
    $status = $model->add($status->myid); 
    }
    $link = JRoute::_('index.php?option=com_videoflow&task='.$status->task.'&tmpl=component');
    if ($status->task == 'login') {
    $id = JRequest::getInt('id');
    $link .= '&layout=listview_login&direct=add&id='.$id;
    }
    $this->setRedirect($link, $status->message, $status->type);
    }
    
    function subscribe()
    {
    $status = $this-> vprocess();
    if ($status->status) {
    $model = & $this->getModel('videoflow');
    $status = $model->subscribe($status->myid); 
    }
    $cid = JRequest::getInt('cid');
    $link = JRoute::_('index.php?option=com_videoflow&task='.$status->task.'&tmpl=component');
    if ($status->task == 'login') $link .= '&layout=listview_login&direct=subscribe&cid='.$cid;
    $this->setRedirect($link, $status->message, $status->type);
    }
    
    function unsubscribe()
    {
      $model = & $this->getModel('videoflow');
      $status = $model->unsubscribe(); 
      $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
      $this->setRedirect($link, $status->message, $status->type);
    }


    
    function upload ()
    {
    $status = $this-> vprocess('sp');
    $sess = JRequest::getBool('sess');
    $task = JRequest::getCmd('task', 'upload');
    if ($status->status) {
    $view = & $this->getView('videoflow', 'html');
    $view->displayAdd();
    } else {
     if ($c == 'fb' || !empty($sess)) {
		$this->createSession($task);
	    } else { 
	    $link = JURI::root().'index.php?option=com_videoflow&task='.$status->task.'&tmpl=component';
	    if ($status->task == 'login') $link .= '&layout=listview_login&direct=upload';
	    $this->setRedirect($link, $status->message, $status->type);
	    }
    }
    }
    
    function addmedia()
    {
      $status = $this->vprocess('sp');
      $link = JRoute::_('index.php?option=com_videoflow&task='.$status->task.'&tmpl=component');
      if ($status->status){
      $model = & $this->getModel('videoflow');
      $data = $model->addmedia($status->myid);
        if ($data->status){
        $view = & $this->getView('videoflow', 'html');
        $view->setModel($model, true);
        $view->displayEditForm($data);
        } else{
        $status->message = $data->message;
        $status->type = 'error';
        $this->setRedirect($link, $status->message, $status->type);
        }
      } else {
      $this->setRedirect($link, $status->message, $status->type);
      }
    }
    
    function uploadmedia()
    {
      $status = $this->vprocess();
      if ($status->status){
      $model = & $this->getModel('videoflow');
      $data = $model->uploadmedia($status->myid);
        if ($data){
        $view = & $this->getView('videoflow', 'html');
        $view->displayUploadForm($data);
        } else {
        $link = JRoute::_('index.php?option=com_videoflow&task=upload&tmpl=component');
        $status->message = JText::_('COM_VIDEOFLOW_ERROR_UPLOAD');
        $this->setRedirect($link, $status->message, $status->type);
        }
      } else {
      $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
      $this->setRedirect($link, $status->message, $status->type);
      }
    }
    
    function remove()
    {
      $model = & $this->getModel('videoflow');
      $status = $model->remove(); 
      $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
      $this->setRedirect($link, $status->message, $status->type);
    }
    
    function delete()
    {
      $model = & $this->getModel('videoflow');
      $status = $model->runTool('runSprocess', 'delete', $model->runTool('createResp'));
      if ($status->status) {     
      $status = $model->delete($status);
      }   
      $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
      $this->setRedirect($link, $status->message, $status->type);
    }

        
    function download()
    {
      $model = & $this->getModel('videoflow');
      $status = $model->getDownload(); 
      if (!$status->status) {
      echo '<script language="javascript" type="text/javascript">alert("'.$status->message.'"); history.go(-1);</script>';
      }
    }  
        
    function vlayout($type = '')
    {
       global $vparams;
       $layout = JRequest::getVar('layout', $vparams->jtemplate);
       if (($layout == 'playerview' || $layout == 'ajaxlist' || $layout == 'simple' ) && $type == '_play') $type = '';
       if (!empty($layout) && file_exists (JPATH_COMPONENT_SITE.DS.'views'.DS.'videoflow'.DS.'tmpl'.DS.$layout.$type.'.php')) {
       $layout = $layout.$type;
       } else {
       $layout = 'listview'.$type;
       }
       return $layout;     
    }
    
    function logincheck()
    {
      $fbuser = JRequest::getInt ('fbuser');
      $juser = & JFactory::getUser();
      if (!$fbuser && $juser->guest){
      $link = JRoute::_('index.php?option=com_videoflow&task=login&tmpl=component&layout=listview_login');
      $message = JText::_('COM_VIDEOFLOW_WARN_LOGIN');
      $type = 'error';
      } else {
      $link = JRoute::_('index.php?option=com_videoflow&task=status&tmpl=component');
      $message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN');
      $type = 'message';
      }
      $this->setRedirect($link, $message, $type);
    }
    
    function vflogout()
    {
     global $vparams;
     include_once (JPATH_COMPONENT_SITE.DS.'fbook'.DS.'facebook.php');
        $fb = new Facebook(array(
        'appId' => $vparams->appid,
        'secret' => $vparams->fbsecret
        ));
     $c = JRequest::getCmd('c');
     $lo = JRequest::getCmd ('layout');
     $fbuser = JRequest::getInt('fbuser');
     if (!empty($lo)) $lo = '&layout='.$lo;
     if (!empty ($fbuser)) {
      $fb->vfClearData();
     }
	if ($c == 'fb'){
        echo '<script>top.location.href="'.$vparams->canvasurl.'"</script>';
	} else {
        $this->setRedirect(JURI::root().'index.php?option=com_videoflow'.$lo);
	}
    }
    
    function vprocess($process=null)
    {
    $task = JRequest::getCmd('task');
    $model = & $this->getModel('videoflow' );
    return $model->runVprocess($task, $process);
    }
    
    function fb(){
    echo "<body onLoad=\"alert('".JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_FB')."'); self.close();\" />";
    }
    
   function fbinvites()
   {
      global $vparams;
      $c = JRequest::getCmd('c');
      $cid = JRequest::getInt('cid');
      $confirm = JText::_("COM_VIDEOFLOW_NOTICE_INVITATION");
      if ($c == 'fb') {
      echo '<script>alert("'.$confirm.'"); top.location.href="'.$vparams->canvasurl.'&task=visit&cid='.$cid.'"</script>';    
      } else {
      echo "<script>alert ('$confirm'); self.close ()</script>";
      }
   }

   function loadFbconn()
   {
      global $vparams;
      $fmt = JRequest::getCmd('format');
      $view = JRequest::getCmd('view');
      if ($fmt == 'raw' || $view == 'xml') return;
      $c = JRequest::getCmd('c');
      $task = JRequest::getCmd('task');
      $fbuser = JRequest::getInt('fbuser');
      $lang = &JFactory::getLanguage();
      if ($vparams->facebook){
      $fbuserdata = JRequest::getVar('fbuserdata');
      if (!empty($fbuserdata['locale'])) {
      $locale = $fbuserdata['locale'];
      } else {
      $lang = &JFactory::getLanguage();
      if (!empty($lang->tag)) $locale = $lang->tag; else $locale = 'en_US';
      }
      JRequest::setVar('locale', $locale);
      $canvasheight = $vparams->canvasheight;
      if(!empty($canvasheight)) $canvasfix = '{height: "'.$canvasheight.'px"}'; else $canvasfix = 250;
      jimport('joomla.environment.browser');
      $jbrowser = & JBrowser::getInstance();
      $browser = $jbrowser->getBrowser();
      $canvas = '';
      if ($c == 'fb') {
      if (empty ($canvasheight)) {
      $canvas .= ' FB.Canvas.setAutoResize();';
      }
      $canvas .= ' FB.XFBML.parse(); FB.Canvas.setSize('.$canvasfix.');';
      }
      $fbinit = "<div id=\"fb-root\"></div>
      <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId  : '$vparams->appid',
          status : true, // check login status
          cookie : true, // enable cookies to allow the server to access the session
          xfbml  : true  // parse XFBML
        });";
      $fbinit .= "};
      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/".$locale."/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
      window.fbAsyncInit = function() {
      ".$canvas."
      }
      </script>"; 
      echo $fbinit;  
    }
  }
  
  function createSession($task)  {
      global $vparams;
      $attempt = JRequest::getBool('attempt');
      if (!empty($attempt)) {
	echo JText::_("COM_VIDEOFLOW_ERROR_LOGIN_FAILURE_FB");
	return false;
      }
      include_once (JPATH_COMPONENT_SITE.DS.'fbook'.DS.'facebook.php');
        $fb = new Facebook(array(
        'appId' => $vparams->appid,
        'secret' => $vparams->fbsecret,
        'cookie' => true
        ));
      $c = JRequest::getCmd('c');
      if ($c == 'fb') {
	    $next = $vparams->canvasurl;  
      } else {
	    $next =  JURI::root().'index.php?option=com_videoflow';    
      }
      $perms = 'offline_access,publish_stream';
 
      $login_url = $fb->getLoginUrl (array (
		'next' => $next.'&task='.$task.'&attempt=1&sess=0', 
		'cancel_url' => $next,
		'req_perms' => $perms)
		 );
      echo '<script>window.location="'.$login_url.'"</script>';    
  } 
}