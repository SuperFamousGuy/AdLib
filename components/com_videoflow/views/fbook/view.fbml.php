<?php

//VideoFlow - Joomla Multimedia System for Facebook//

/**
* @ Version 1.1.2 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/ 

// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 
class VideoflowViewFbook extends JView
{

  function __construct()
    {
     parent::__construct();               
     global $vparams;
     $this->genCredit(); 
     $this->loadLibrary();
     $this->assignRef ('menu', $this->createTabs());
     $this->assignRef ('dashboard', $this->createDashboard());
     $this->loadVflowModules();
     }    
    
  function loadVflowModules()    
   {
     jimport('joomla.application.module.helper');

     global $vparams;
      $vmods = array('fb_vflow1', 'fb_vflow2', 'fb_vflow3', 'fb_vflow4');
      $pos = 1;
      foreach ($vmods as $vmods){
        $vmodule = &JModuleHelper::getModules($vmods);
        if (!empty($vmodule)){
        $vmodule = JModuleHelper::renderModule ($vmodule[0], array('style'=>'table'));
        } else {
        $vmodule = '';
        }
        $vfpos = 'fb_vflow'.$pos; 
        if ($vparams->findvmods) $vmodule = '<h2>'.$vfpos.'</h2>';
        $this->assignRef ($vfpos, $vmodule);
        $pos++;
      }
   } 
   
  
    
    function display()
    {
        $model =& $this->getModel();
        $id = JRequest::getInt('id');
        $vlist = $model->getData ();
        if(!empty ($vlist)) { 
          $layout = $this->getLayout();
          $vlist = $model->updateDataFB($vlist, $layout);
          $pagination = $this->doPagination($model-> getPagination ());
          $this->assignRef ('media', $vlist);
          $this->assignRef ( 'pagination', $pagination);   
          }         
        if(!empty($id)) {
          $media = $model->getMedia($id);
          $this->createDlist($media, 4);
          $arr = array($media);
          $media = $model->updateDataFB($arr, 'default');
          $this->assignRef ('xdata', $media[0]);
          $this->xtemp = 'play';
          }
        if(empty($vlist) && empty($id)) {
          $notice = new stdClass();
          $notice->type = 'error';
          $notice->message = JText::_('No media found. Please try another option.');
          $this->assignRef('notice', $this->createNotice($notice));
          }
        parent::display();
    }
   
   function displayMedia($id)
   {
        global $vparams;
        $model = $this->getModel();
        $media = $model->getMedia($id);
        $this->createDlist($media, 4);
        $arr = array($media);
        $media = $model->updateDataFB($arr, 'default');
        $vlist = $model->getData();
        if (!empty($vlist)) {
        $lo = JRequest::getCmd('layout', null);
        $vlist = $model->updateDataFB($vlist, $vparams->ftemplate);
        $pagination = $this->doPagination($model-> getPagination ());
        $this->assignRef ('pagination', $pagination);
        $this->assignRef('media', $vlist);
        } 
        $this->assignRef ('xdata', $media[0]);
        $this->xtemp = 'play';
      parent::display(); 
   }
   
   
   function displayMyvids($myid = null, $faceid = null)
   {
        global $vparams;
        $fbuser = JRequest::getInt('fbuser');
        if (empty($faceid)) $faceid = $fbuser; 
        $cname = JRequest::getVar('cname');
        $task = JRequest::getCmd ('task');
        $id = JRequest::getInt('id');
        if (!empty($id)) $mid = $id; else $mid = null;
        $model = $this->getModel();
        $notice = new stdClass();
        $notice->type = 'error';
        if ($task == 'myups' || $task == 'ups') {
        $vlist = $model->getByuser($myid, $mid);
        $notice->message = JText::_('You have not yet added any media to your list. Click on "Add Media" to add media from other websites (e.g youtube.com).').'<br />';
        $notice->message .= JText::_('To upload files from your desktop, ').'<a href="'.JURI::root().'index.php?option=com_videoflow" target="_blank">'.JText::_('go to our main site').'</a>';
          if ($task == 'ups') {
          $notice->message = JText::_('This user has not yet uploaded media to his or her channel.');
          if (!empty($cname)) $notice->message = $cname.' '.JText::_('has not yet uploaded media to his or her channel.');
          }
        } else if ($task == 'myfavs' || $task == 'favs') {
        $vlist = $model->getFavourites ($myid, $mid);
        $notice->message = JText::_('You have not yet added any media to your media list. Click on "+MyList" to create your media list.');
          if ($task == 'favs') {
          $notice->message = JText::_('This user has not yet picked his or her favourites.');
          if (!empty($cname)) $notice->message = $cname.' '.JText::_('has not yet picked his or her favourites.');
          }
        } else {
        $vlist = $model -> getMyvidsFB($myid, $faceid);
        if ($vparams->mode == 'videoflow'){ 
        $notice->message = JText::_('You have not yet uploaded or added any media to your media list. Click on "Add Media" or "+MyList" to create your media list.');
        } else {
        $notice->message = JText::_('You have not yet added any media to your personal list. Click on "+MyList" to add media to your list.');
        }
         if ($task == 'visit') $notice->message = JText::_('This channel has no media currently.');
        }
        if (!empty($vlist)) {
        $layout = $this->getLayout();
        $media = $model -> updateDataFB($vlist, $layout);
        $pagination = $this->doPagination($model-> getPagination ());
        $this->assignRef('media', $media);
        $this->assignRef ('pagination', $pagination);
        } 
        if(!empty($id)) {
          $xmedia = $model->getMedia($id);
          $this->createDlist($xmedia, 4);
          $arr = array($xmedia);
          $xmedia = $model->updateDataFB($arr, 'default');
          $this->assignRef ('xdata', $xmedia[0]);
          $this->xtemp = 'play';
          } 
        if ($task == 'myvids' || $task == 'myups' || $task == 'myfavs') { 
            if (!empty($fbuser) && file_exists ($vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php')){
            include_once ($vfile);
            $perms = VideoFlowFbookHelper::checkPerms($fbuser);
                if (!$perms[0]['publish_stream']) {   
                $promptperm = '<div><fb:prompt-permission perms="email,read_stream,publish_stream"><div style="width:100%; padding: 4px 8px; margin: 4px 0px; background-color:#ffebe8; border: 1px solid #dd3c10;">'.JText::_('Click here to allow us to create updates for your Facebook News Feed (e.g. when you add a video)').'</div></fb:prompt-permission></div>';
                $this->assignRef ('notice', $promptperm);
                }
            }
        }
        if (empty($vlist) && empty ($id)) {
        $this->assignRef ('notice', $this->createNotice($notice));
        }
        if (empty($cname) && (!empty($faceid))) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
        $fuinfo = VideoflowUserManager::getFBuserInfo($faceid);  
        if (isset($fuinfo[0]['first_name'])) $cname = $fuinfo[0]['first_name']; else $cname = '';
        }
        if (!empty($faceid)) {
        $this->cpix = '<fb:profile-pic uid="'.$faceid.'" height="40" linked="true" />';
        $this->cname = '<div style="float:left; margin: 2px; padding: 0px 5px; border-left: 1px dotted #CCCCCC; border-right: 1px dotted #CCCCCC;">'.JText::_('This is ').'<fb:name uid="'.$faceid.'" possessive="true" useyou="true" capitalize="true" linked="true" /> '.JText::_('Channel').'</div>';
        }
        if ($vparams->mode == 'videoflow') {
        $menu2 = array('myvids'=>JText::_('All Media'), 'myups'=>JText::_('Uploads'), 'myfavs'=>JText::_('Favourites'));
          if ($task == 'visit' || $task == 'ups' || $task == 'favs') {
           $menu2 = array('visit'=>JText::_('All Media'), 'ups'=>JText::_('Uploads'), 'favs'=>JText::_('Favourites'));
          }
        } else {
        $menu2 = array();
        }
        $this->assignRef ('menu2', $this->createMenu2($menu2, $faceid, $cname));
        parent::display(); 
   }
    
    function displayNotice($notice)
    {
      if (!empty($notice) && !is_string($notice)) $notice = $this->createNotice($notice);
      $this->assignRef('notice', $notice);
      parent::display();
    }
        
   function displayCategories()
   {
      $model = $this->getModel();
      $cats = $model ->getCatList(); 
      $pagination = $this->doPagination($model-> getPagination ());
      $this->assignRef ('media', $cats);
      $this->assignRef ('pagination', $pagination);
      parent::display();
   }
   
   function displayCats()
   {
      $model = $this->getModel();
      $cat = JRequest::getInt ('cat');
      $id = JRequest::getInt('id');
      $notice = new stdClass();
      if (empty ($cat)) $catname = JText::_('VF_CAT_NONE'); else $catname = $model->getCatName($cat);
      $vlist = $model->getData();
      if (empty($vlist) && empty($id)) {
      $notice->type = 'error';
      $notice->message = JText::_('No media found in the category').' <b>'.$catname.'</b>';
      } else {
      $layout = $this->getLayout();
      $vlist = $model->updateDataFB($vlist, $layout);       
      $pagination = $this->doPagination($model-> getPagination ());
      $this->assignRef('media', $vlist);
      $this->assignRef ('pagination', $pagination);
      $notice->type = 'message';
      $notice->message = JText::_('Media in category').' <b>'.$catname.'</b>';
      if(!empty($id)) {
          $xmedia = $model->getMedia($id);
          $this->createDlist($xmedia, 4);
          $arr = array($xmedia);
          $xmedia = $model->updateDataFB($arr, 'default');
          $this->assignRef ('xdata', $xmedia[0]);
          $this->xtemp = 'play';
          }  
      }
      $this->assignRef ('notice', $this->createNotice($notice));
      parent::display();
   }
   
   function genCredit()
    { 
      global $vparams, $mainframe;
      $credit = JText::_('Powered by').'<a href="'.JURI::root().'"> '.$mainframe->getCfg('sitename').'</a>';
      if ($vparams->showcredit) $credit .= ' '.JText::_('and').' '.'<a href="http://www.videoflow.tv">VideoFlow</a>';
      $this->assignRef ('credit', $credit);
    }
    
    function showStatus($status)
    { 
     echo $this->createNotice ($status);
    }
    
    function createNotice($status)
    { 
     if ($status->type == 'error') {
     $notice = '<div style="width:96%; padding: 4px 8px; margin: 4px 0px; background-color:#ffebe8; border: 1px solid #dd3c10;">'.$status->message.'</div>';
     } else {
     $notice = '<div style="width:96%; padding: 4px 8px; margin: 4px 0px; background-color:#eceff6; border: 1px solid #d4dae8;">'.$status->message.'</div>';
     }
     return $notice;
    }

    
    function loadLibrary()
    {
      if (file_exists (JPATH_COMPONENT_SITE.DS.'utilities'.DS.'js'.DS.'vflibrary.js')){
      $vfile = JURI::root().'components/com_videoflow/utilities/js/vflibrary.js';
      } else {
      $vfile = JURI::root().'components/com_videoflow/utilities/js/xlibrary.js';
      }
      echo '<script src="'.$vfile.'?v=12.0"></script>';
    }
    
    function createTabs()
    {
      global $vparams;
      $vmedia = JRequest::getWord('media');
      $vtask = JRequest::getCmd('task');
      $tab = JRequest::getBool('tab');
      switch ($vtask) {
        case 'myfavs':
        case 'myups':
        $vtask = 'myvids';
        break;
        
        case 'dosearch':
        $vtask = 'search';
        break;
        
        case 'fetch':
        case 'saveRemote':
        $vtask = 'addmedia';
        break;
        
        case 'cats':
        $vtask = 'categories';
        break;
      }     
      
      if (!empty($vmedia)){
      $task = $vparams->canvasurl.'&media='.$vmedia.'&task';
      } else{
      $task = $vparams->canvasurl.'&task'; 
      }
      
      if (!empty($vparams->fbmenu)) {
      $fbmenu = explode ('|', $vparams->fbmenu);
      foreach ($fbmenu as $fbmenu) {
      $vparams->$fbmenu = 1;
      }
      }
      $fbtabs = '<fb:tabs>';
      if (!empty($vparams->fblatest)) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=latest&vf=1" title="'.JText::_('Latest').'" />';
      }
      if (!empty($vparams->fbfeatured) && $tab !=1) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=featured&vf=1" title="'.JText::_('Featured').'" />';
      }
      if (!empty($vparams->fbpopular)) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=popular&vf=1" title="'.JText::_('Popular').'" />';
      }
      if ($vparams->showpro && (!empty($vparams->fbmyvids))){
      $fbtabs .= '<fb:tab-item href="'.$task.'=myvids&vf=1" title="'.JText::_('My Channel').'" />';      
      }
      if (!empty($vparams->fbcategories) && $vparams->mode != 'seyret'){
      $fbtabs .= '<fb:tab-item href="'.$task.'=categories&vf=1" title="'.JText::_('Categories').'" />';      
      }
      if (!empty($vparams->fbsearch)) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=search&vf=1" align="right" title="'.JText::_('Search').'" />';      
      }
      if (!empty($vparams->fbnews)) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=news&vf=1" align="right" title="'.JText::_('News').'" />';      
      } 
      if (!empty($vparams->fbdiscuss) && !empty($vparams->appid) && $tab != 1){
      $fbtabs .= '<fb:tab-item href="http://www.facebook.com/ugandavideos" align="right" title="'.JText::_('Discuss').'" />';      
      }
      if ($vparams->showpro && (!empty($vparams->fbinvite)) && $tab != 1) {
      $fbtabs .= '<fb:tab-item href="'.$task.'=invite&vf=1" align="right" title="'.JText::_('Invite').'" />';      
      } 
      $fbtabs .= "</fb:tabs>";
      
      $fbtabs = str_replace($vtask.'&vf=1', $vtask.'&vf=1" selected="true"', $fbtabs);
      
      return $fbtabs;
  }

function createMenu2($arr_task, $cid = null, $cname = null)
{
  global $vparams, $mainframe;
  $vmedia = JRequest::getWord('media');
  $ftask = JRequest::getCmd ('task');
  $tab = JRequest::getBool('tab');
  if (!empty($vmedia)){
      $task = $vparams->canvasurl.'&media='.$vmedia.'&task';
      } else{
      $task = $vparams->canvasurl.'&task'; 
      }
  if (!empty($cid)) {
  $c_id = '&cid='.$cid;
  include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
  $jid = VideoflowUserManager::getVFuserObj($cid);
  if (!empty($jid->joomla_id)) $j_id = '&cid='.$jid->joomla_id; else $j_id = '';
  } else {
  $c_id = $j_id = ''; 
  }
  if (!empty($cname)) $c_name = '&cname='.$cname; else $c_name = ''; 
      $fbtabs = '<div>';
      $fbtabs .= '<div style="float:left; margin: 2px; padding: 0px 5px; border-right: 1px dotted #CCCCCC;">&nbsp;</div>';
      foreach ($arr_task as $vtask=>$name) {
        $fbtabs .= '<div style="float:left; margin: 2px; padding: 0px 5px; border-right: 1px dotted #CCCCCC;"><a href="'.$task.'='.$vtask.$c_id.$c_name.'&vf=1">'.JText::_($name).'</a></div>';
      }
      if ($ftask == 'myvids' || $ftask == 'myups' || $ftask == 'myfavs' || $ftask == 'visit' || $ftask == 'ups' || $ftask == 'favs' ) {
      if ($tab != 1) {
      $fbtabs .= '<div style="float:left; margin: 2px; padding: 0px 5px; border-right: 1px dotted #CCCCCC;"><a href="'.JURI::root().'index.php?option=com_videoflow&task=visit'.$j_id.'" target="_blank">'.JText::_('Channel Home').'</a></div>';   
       }
       if (!empty($cid) && $vparams->showpro){
        $fbtabs .= '<div style="float:left; margin: 2px; padding: 0px 5px; border-right: 1px dotted #CCCCCC;"><a href="'.$task.'=cshare&cid='.$cid.'&cname='.$cname.'&vf=1">'.JText::_('Share It').'</a></div>';     
        }
      }      
      $fbtabs .= '</div>';
  return $fbtabs;
}

function createDashboard () {
        
            global $vparams;
            $vtask = $vparams->canvasurl.'&task';
            if (!empty($vparams->fbmenu)) {
            $fbmenu = explode ('|', $vparams->fbmenu);
            foreach ($fbmenu as $fbmenu) {
            $vparams->$fbmenu = 1;
            }
            }
            $dashboard = "<fb:dashboard>
            <fb:action href='$vparams->canvasurl'>".JText::_('Home')."</fb:action>";
            if ($vparams->showpro && (!empty($vparams->fbaddmedia)) && ($vparams->mode == 'videoflow')) {
              $dashboard .= "<fb:create-button href='$vtask=addmedia&vf=1'>".JText::_('Add Media')."</fb:create-button>";
            }
            if (!empty($vparams->fbhelp) && !empty($vparams->fbhelpid)) { 
            $dashboard .= "<fb:help href='$vtask=read&id=$vparams->fbhelpid&vf=1'>".JText::_('Help')."</fb:help>"; 
            }
            $dashboard .= "</fb:dashboard>";
            return $dashboard;
    }
    
    function createDlist($media, $limit) {
            $model = $this->getModel();
            $rmedia = $model->getRelated($media, $limit);
            $rlabel = '<div style="width:100%; text-align:center; background-color:#6D84B4; color:#FFFFFF; font-weight:bold; padding:4px 0px;">'.JText::_('RELATED MEDIA').'</div>';
            if (empty($rmedia)) {
            $rmedia = $model->getRand($limit);
            $rlabel = '<div style="width:100%; text-align:center; color:#000000; font-weight:bold; padding:4px 0px;">'.JText::_('RANDOM MEDIA').'</div>';
            }
            if (!empty($rmedia)) {
            $rmedia = $model->updateDataFB($rmedia);
            $this->assignRef('rmedia', $rmedia);
            $this->assignRef ('rlabel', $rlabel);
            }
      }      

function displayNews()
{  
  $model = $this->getModel();
  $news = $model->getData();
  if (!empty($news)) {
  $news = $model->updateData($news);
  $pagination = $this->doPagination($model-> getPagination ());
  $this->assignRef ('media', $news);
  $this->assignRef ('pagination', $pagination);
  }
  parent::display();
}

function displayArticle()
{
  $model = $this->getModel();
  $model->_id = JRequest::getInt('id');
  $article = $model->getData();
  if (!empty($article)) {
  $article = $model->updateData($article);
  $this->assignRef ('xdata', $article);
  $this->xtemp = 'article';
  }
  parent::display();

}

function displayInviteForm()
{
 include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php');
 $invite = VideoflowFbookHelper::invite();
 $this->assignRef ('data', $invite);
 parent::display();
}

function displayCInviteForm()
{
 include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php');
 $invite = VideoflowFbookHelper::channelInvite();
 $this->assignRef ('data', $invite);
 parent::display();
}


function displayForm()
{
$task = JRequest::getCmd('task');
$main_label = JText::_('URL (link) to add');
$field_name = 'embedlink';
$go_label = JText::_('Add');
$vtask = '&task=fetch';
$task_legend = JText::_('Add Media');
if ($task == 'search') {
$main_label = JText::_('Enter Keywords');
$field_name = 'searchword';
$go_label = JText::_('Search');
$vtask = '&task=dosearch';
$task_legend = JText::_('Search Media');
}
echo '<link rel="stylesheet" type="text/css" media="screen" href="'.JURI::root().'components/com_videoflow/utilities/css/vf_forms.css?v=3.0" />';
$data = <<<DATA
<fieldset class="vf_forms">
<legend>$task_legend</legend>
<div>
 <form id="addForm" name="addForm" action="$vtask" method="post">
 <table class="admintable">
            <tr>	
            <td class="key">
						<label for="$field_name">
						$main_label		
						</label>
						</td>
            <td>
						<input type="text" size="80" maxsize="100" name="$field_name" value="" />	
						</td>
            <td>
            <button onclick="document.addForm.submit(); return false;" name="upsubmit">$go_label</button>
            </td>
            </tr>
  </table> 
 </form>
</div>
DATA;
$this->assignRef('data', $data);
parent::display();
}

function displayDoSearch()
{
  $searchword = JRequest::getString('searchword');
  $id = JRequest::getInt('id');
  $res = new stdClass();
  $res->type = 'error';
  if (empty($searchword)) {
  $res->message = JText::_('You must provide a search phrase');
  } else {
  $model = $this-> getModel();
  $vlist = $model->doSearch();
  if(!empty ($vlist)) {
  $layout = $this->getLayout();
  $vlist = $model->updateDataFB($vlist, $layout);
  $pagination = $this->doPagination($model-> getPagination ());
  $res->type = 'message';
  $res->message = JText::_('Search results for').' <b>'.$searchword.'</b>';
  $this->assignRef ('media', $vlist);
  $this->assignRef ( 'pagination', $pagination);   
  } else {
  $res->message = JText::_('No results found for').' <b>'.$searchword.'</b>';
  } 
  } 
  if(!empty($id)) {
          $xmedia = $model->getMedia($id);
          $this->createDlist($xmedia, 4);
          $arr = array($xmedia);
          $xmedia = $model->updateDataFB($arr, 'default');
          $this->assignRef ('xdata', $xmedia[0]);
          $this->xtemp = 'play';
          }         
  $this->assignRef ('notice', $this->createNotice($res));
  parent::display(); 
}


function displayEditForm($data)
{
echo '<link rel="stylesheet" type="text/css" media="screen" href="'.JURI::root().'components/com_videoflow/utilities/css/vf_forms.css?v=3.0" />';
    $bselect = array(
    JHTML::_('select.option', '0', JText::_('No') ),
    JHTML::_('select.option', '1', JText::_('Yes') )
    );
    $data->bselect = $bselect;
    $data->selcat = $data->cat;
    $this->assignRef ('xdata', $data);
    $this-> xtemp = 'embedform';
  parent::display();
}


function tabselect($tab, $mytabs){
return str_replace($tab, $tab.' '. 'selected="true"', $mytabs);
}

function doPagination ($pagination){
 global $vparams;
 $searchword = JRequest::getString('searchword');
 $pagination->pagelinks = str_replace('index.php?option=com_videoflow', substr($vparams->canvasurl, 25).'index.php?option=com_videoflow', $pagination->getPagesLinks());
 if (!empty($searchword)) $pagination->pagelinks = str_replace('dosearch', 'dosearch&searchword='.$searchword, $pagination->pagelinks);
 return $pagination;
}    
}