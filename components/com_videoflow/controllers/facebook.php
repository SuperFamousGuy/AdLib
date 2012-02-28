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
jimport( 'joomla.application.component.controller' );  
require_once (JPATH_COMPONENT_SITE.DS.'fbook'.DS.'facebook.php');

class VideoflowControllerFB extends JController
{
	
	var $vpre = 'fbook';
	var $cmode = 'fbml';
	
  function __construct()
	{		
    global $vparams;   
    parent::__construct();
    $this->registerTask ('myfavs', 'myvids');   
    $this->registerTask ('myups', 'myvids');  
    $this->registerTask ('favs', 'visit');   
    $this->registerTask ('ups', 'visit');
    $frm = JRequest::getBool('fb_sig_in_iframe');
    if ($frm && $vparams->mode == 'videoflow') {
    $this->vpre = 'videoflow';
    $this->cmode = 'html';
    }
    $fb = new Facebook(array(
    'appId' => $vparams->appid,
    'secret' => $vparams->fbsecret,
    'cookie' => true
    ));
    $session = $fb->getSession();
      if(!empty($session)){
      $fbuser = $fb->getUser();
          if (!empty($fbuser)) {
          JRequest::setVar('fbuser', $fbuser);
          try {
	        $q = array(
	        'method' => 'fql.query',
	        'query' => 'SELECT user_birthday,friends_birthday,user_likes,friends_likes,user_status,friends_status,user_photos,friends_photos,user_videos,friends_videos,read_requests,sms,offline_access,email,read_stream,publish_stream FROM permissions WHERE uid = "'.$fbuser.'"'
	        );
          JRequest::setVar('perms', $fb->api($q));
          JRequest::setVar('fbuserdata', $fb->api("/me"));
          } catch (Exception $ex) {
          }
          } 
      }
  }
	
  
	function display()
	{
      global $vparams;
       $layout = $this->vlayout();
       $view = & $this->getView($this->vpre, $this->cmode);
       $model = & $this->getModel($vparams->mode);
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> display();
	}
	
	function tabview()
	{
     global $vparams;
     JRequest::setVar('tab', 1);
     $pid = JRequest::getInt('fb_sig_profile_id');
     $model = & $this->getModel($vparams->mode);
     $view = & $this->getView('fbook', 'fbml');
     $view->setModel($model, true);
     $view->setLayout('tabview');
     if (!empty($pid) && !empty($vparams->vmode)) {
     include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
     $myid = VideoflowUserManager::getVFuserObj($pid);
     if (!empty($myid->joomla_id) && !empty($vparams->vmode)) {   
        $vlist = $model->getByuser($myid->joomla_id, null);
        if (empty($vlist)) $vlist = $model->getFavourites ($myid->joomla_id, null);
        if (empty($vlist)) {
        JRequest::setVar('task', 'latest');
        $view->display(); 
        } else {
        JRequest::setVar('task', 'visit');
        JRequest::setVar('cid', $pid);
        $view -> displayMyvids($myid->joomla_id, $pid);
        }
     }
     } else { 
     $view->display();
     } 
  }
	
	function add()
	{
   global $vparams;
   $view = & $this->getView('fbook', 'fbml');
   $status = $this ->vprocess();
   if ($status->status) {
   $model = & $this->getModel($vparams->mode);
   $status = $model->add($status->myid); 
   }
   $view->showStatus($status);
  }
  
   
  function remove ()
	{
   global $vparams;
   $view = & $this->getView('fbook', 'fbml');
   $status = $this ->vprocess();
   if ($status->status) {
   $model = & $this->getModel($vparams->mode);
   $status = $model->remove($status->myid); 
   }
   $view->showStatus($status);
  }

  
  function addmedia(){
   $view = & $this->getView('fbook', 'fbml');
   $view ->setLayout ('default');
   $status = $this->vprocess();
   if ($status->status) {
   $view->displayForm();
   } else {
   $view->displayNotice($status);
   } 
  }
  
  function search(){
   $view = & $this->getView('fbook', 'fbml');
   $view ->setLayout ('default');
   $view->displayForm();
   } 
 
    function dosearch()
    {
       global $vparams;
       $layout = $this->vlayout();
       $view = & $this->getView('fbook', 'fbml');
       $model = & $this->getModel($vparams->mode);
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayDoSearch();
    }
    
        
    function play()
    {
      global $vparams;
       $id = JRequest::getInt('id');
       $layout = $this->vlayout();
       $view = & $this->getView($this->vpre, $this->cmode);
       $model = & $this->getModel($vparams->mode);
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayMedia($id);
    }

 
    function categories()
    {
       global $vparams;
       $layout = $this->vlayout('_categories');
       $view = & $this->getView('fbook', 'fbml');
       $model = & $this->getModel($vparams->mode);
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayCategories();
    }
    
    function cats()
    {
        global $vparams;
        $model = & $this->getModel($vparams->mode);
        $layout = $this->vlayout();  
        $view = & $this->getView('fbook', 'fbml');
        $view->setModel($model, true);
        $view->setLayout($layout);
        $view -> displayCats();
    } 
    
    
    function news()
    {
       $layout = $this->vlayout('_news');
       $view = & $this->getView('fbook', 'fbml');
       $model = & $this->getModel('newsfb');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayNews();
    }

 function read()
 {
       $layout = $this->vlayout('_news');
       $view = & $this->getView('fbook', 'fbml');
       $model = & $this->getModel('newsfb');
       $view->setModel($model, true);
       $view->setLayout($layout);
       $view -> displayArticle();
 }

function invite()
{
       $layout = $this->vlayout();
       $view = & $this->getView('fbook', 'fbml');
       $view->setLayout($layout);
       $view -> displayInviteForm();
}


function cshare()
{
       $layout = $this->vlayout();
       $view = & $this->getView('fbook', 'fbml');
       $view->setLayout($layout);
       $view -> displayCInviteForm();
}

 
  function fetch()
  {  
      global $vparams;
      $status = $this->vprocess();
      $view = & $this->getView('fbook', 'fbml');
      $layout = $this->vlayout();
      $view->setLayout($layout);
      if ($status->status){
      $model = & $this->getModel($vparams->mode);
      $data = $model->addmedia($status->myid);
        if ($data->status){
        $view->setModel($model, true);
        $view->displayEditForm($data);
        } else {
        $status->message = $data->message;
        $status->type = 'error';
        $view->displayNotice($status);
        }
      } else {
      $view->displayNotice($status);
      }
  }
  
  function saveRemote()
  {
      global $vparams;
      $fbuser = JRequest::getInt('fbuser');
      $model = & $this->getModel($vparams->mode);
      $view = & $this->getView('fbook', 'fbml');
      $layout = $this->vlayout();
      $view->setLayout($layout);
      $status = $model->saveRemote(); 
      if (!empty($status->id) && !empty($fbuser)) {
      $model->createUpfeed($status->id);
      }
      $view->displayNotice ($status); 
  }

  
  
  function myvids()
    {
        global $vparams;
        $status = $this->vprocess();
        $layout = $this->vlayout();
        $view = & $this->getView('fbook', 'fbml');
        $view->setLayout($layout);
        if ($status->status) {
        $model = & $this->getModel($vparams->mode);
        $view->setModel($model, true);
        $view -> displayMyvids($status->myid);
        } else {
        $view->displayNotice($status);
        }
    }
    
    function visit()
    {
      global $vparams;
      $cuser = JRequest::getInt ('fbuser');
      if (empty($cuser)) $cuser = JRequest::getInt('fb_sig_user');
      include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
      $cid = JRequest::getInt('cid');
      $myid = VideoflowUserManager::getVFuserObj($cid);
     // print_r($myid);
      $layout = $this->vlayout();
      $view = & $this->getView('fbook', 'fbml');
      $view->setLayout($layout);
      if (!empty($myid->joomla_id) && !empty($vparams->vmode)) {
        if ($cuser == $cid) JRequest::setVar('task', 'myvids');
        $model = & $this->getModel($vparams->mode);
        $view->setModel($model, true);
        $view -> displayMyvids($myid->joomla_id, $cid);
      } else {
       $model = & $this->getModel('videoflow');
       $view->setModel($model, true);
       $status = $model->runTool('createResp');
       $view->displayNotice($status);
      }  
    }
    
    
    function iplay()
    {
    global $vparams;
    $model = & $this->getModel($vparams->mode);
    $splay = $model->genIplay();  
    echo $splay;         
    }
  
  
    function vprocess()
    {
    global $vparams;
    $task = JRequest::getCmd('task');
    $model = & $this->getModel('videoflow');
    return $model->runVprocess($task);
    }

    function vlayout($type = '')
    {
       global $vparams;
       $layout = JRequest::getVar('layout');
       if (!empty($layout) && file_exists (JPATH_COMPONENT_SITE.DS.'views'.DS.'fbook'.DS.'tmpl'.DS.$layout.$type.'.php')) {
       $layout = $layout.$type;
       } elseif (file_exists (JPATH_COMPONENT_SITE.DS.'views'.DS.'fbook'.DS.'tmpl'.DS.$vparams->ftemplate.$type.'.php')) {
       $layout = $vparams->ftemplate.$type;
       } else{
       $layout = 'default'.$type;
       }
       if ($vparams->mode == 'seyret' && ($layout == 'default'.$type)) {
          if (file_exists (JPATH_COMPONENT_SITE.DS.'views'.DS.'fbook'.DS.'tmpl'.DS.'simple'.$type.'.php')) {
          $layout = 'simple'.$type;
          }
       }
       return $layout;     
    }  
} 