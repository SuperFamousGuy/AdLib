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
defined('_JEXEC') or die('Restricted access'); 
global $vparams;

//Load template stylesheet

$context = JRequest::getCmd('c');
$iframe = JRequest::getBool('iframe');
$varext = '';
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/simple.css';
if ($context == 'fb') {
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/simple_fb.css';  
}
$doc->addStyleSheet( $css, 'text/css', null, array() );
$xparams = $this->getXparams();
$iborderc = (string) $xparams->get('iborderc');
$bgactive = (string) $xparams->get('bgactive');
$bginactive = (string) $xparams->get('bginactive');
$vflabel = (string) $xparams->get('vflabel');
$vflabelfont = (string) $xparams->get('vflabelfont');
if ($context != 'fb') {
$css2 = '.vfround, .mod_vflow, .vf_borderc, .vf_hsolid_line, .vf_vdotted_line {border-color:'.$iborderc.';}
        .vf_bgactive, .vf_fbtheme  {background-color:'.$bgactive.';}
        .vfmenu_selected {background-color:'.$vflabel.'; color:'.$vflabelfont.';}
        .vfmenu_selected a {color:'.$vflabelfont.' !important; font-weight:bold !important;}
        .vf_bginactive {background-color:'.$bginactive.'}';
$doc->addStyleDeclaration($css2);
}
$flowid = JRequest::getInt('Itemid');
if (!empty($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
$type = JRequest::getVar('type');
if (!empty($type)) $type = '&type='.$type; else $type = '';
$tmpl = JRequest::getCmd('tmpl');
if (!empty($tmpl)) $tmpl = '&tmpl='.$tmpl; else $tmpl = '';
if ($context == 'fb') $fb = '&c=fb'; else $fb = '';
//$frm = JRequest::getBool('fb_sig_in_iframe');
//if ($frm) $frm = '&fb_sig_in_iframe=1'; else $frm = '';
$list = JRequest::getWord ('list');
if (!empty($list)) $list = '&list='.$list; else $list = '';
// Get parameters
$iborders = (string) $xparams->get('iborders');
$borders = (int) $xparams->get('borders', 1);
if ($context == 'fb') {
$showuser = $vparams->fbshowuser;
$showcat = $vparams->fbshowcategory;
$showdate = $vparams->fbshowdate;
$showviews = $vparams->fbshowviews;
$showrating = $vparams->fbshowrating;
$showplaylistcount = $vparams->fbshowplaylists;
$showlike = 0;
$showadd = $vparams->fbshowmylist;
} else {
$showadd = (bool) $xparams->get('showadd', $vparams->showadd);
$showuser = (bool) $xparams->get('showuser', $vparams->showuser);
$showcat = (bool) $xparams->get('showcat', $vparams->showcat);
$showviews = (bool) $xparams->get('showviews', $vparams->showviews);
$showrating = (bool) $xparams->get('showrating', $vparams->showrating);
$showdate = (bool) $xparams->get('showdate', $vparams->showdate);
$showplaylistcount = (bool) $xparams->get('showplaylistcount', $vparams->showplaylistcount);
$showlike = (bool) $xparams->get('listlikebutton', 0);
}
$showvotes = (bool) $xparams->get('showvotes', $vparams->showvotes);
$showdownloads = (bool) $xparams->get ('showdownloads', $vparams->showdownloads);
$likelayout = (string) $xparams->get('likelayout', 'standard');
$likecolour = (string) $xparams->get('likecolour', 'light');
$likefaces = (bool) $xparams->get('likefaces', true);

// Required for Joomla popups
JHTML::_('behavior.modal', 'a.modal-vflow');
/********* DON'T EDIT THIS PART UNLESS YOU KNOW WHAT YOUR DOING **********/
                    
          // Controls link parameters  
  
  $vtask = JRequest::getCmd('task', 'latest');
  $stask = 'play';
  $sl = '';
  if (!empty ($vtask) && $vtask != 'visit') $sl = '&sl='.$vtask;
  $ls = JRequest::getInt ('limitstart', null);
  if ($ls > 0) $ls = '&limitstart='.$ls;
  $cid = JRequest::getInt('cid');
  if (!empty($cid)) $cid = '&cid='.$cid; else $cid = '';
  if ($vparams->lightboxfull) $xp = '&xp=1'; else $xp = '';
  $lo = JRequest::getCmd('layout');
  if (!empty($lo)) $lo = '&layout='.$lo; else $lo = ''; 
  if ($context == 'fb') {
  $target = 'target="_parent"';
  $lo = '';
  } else {
  $target = '';  
  }

  // status messages
     
      
  if ($vtask == 'search') {
    $smessage = '';
    $vs = JRequest::getString('vs');
    $searchword = JRequest::getString('searchword');
    if (!empty($this->vlist)) {
      $varext .= '&searchword='.$searchword;
      if ($vs == 'rel' ) {
      $reltitle = JRequest::getString('title');
      $smessage = JText::_('COM_VIDEOFLOW_RELATED_TO').' <b>'.$reltitle.'</b>';
      } else {
      $smessage = JText::_('COM_VIDEOFLOW_RESULTS_FOR').' <b>'.$searchword.'</b>';  
      }
    } else if (empty($this->vlist) && !empty ($searchword)){
    $smessage = JText::_('No results found for').' <b>'.$searchword.'</b>.'.JText::_('COM_VIDEOFLOW_TRY_NEW_TERM');
    } else if (empty($this->vlist) && empty ($searchword)){
    $smessage = null;
    } else {
    $smessage = JText::_('COM_VIDEOFLOW_RESULTS_FOR').' <b>'.$searchword.'</b>';  
    }
  }


// Display "videos by user" message if necessary
if ($vtask == 'uservids'){
$pid = JRequest::getInt('usrid');
$stask = 'visit&pid='.$pid;
$vuser = JRequest::getString('usrname', 'Guest');
$smessage = JText::_('COM_VIDEOFLOW_MEDIA_FROM').' <b>'.$vuser.'</b>';
}
//Display "videos liked by user" message if necessary
if ($vtask == 'userfavs'){
$pid = JRequest::getInt('usrid');
$stask = 'visit&pid='.$pid.'&tab=two';
$vuser = JRequest::getString('usrname', 'Guest');
$smessage = JText::_('COM_VIDEOFLOW_LIKED_BY').' <b>'.$vuser.'</b>';
}
// Display "videos in category" if necessary
if ($vtask == 'cmed'){
$cname = JRequest::getString('cname');
$smessage = JText::_('COM_VIDEOFLOW_TCAT').' <b>'.JText::_($cname).'</b>';
}
// Flat category view
$catid = null;
if ($vtask == 'cats'){
$smessage = JText::_('COM_VIDEOFLOW_TCAT').' <b>'.JText::_($this->catname).'</b>';
$catid = JRequest::getInt('cat');
$catid = '&cat='.$catid;
}

/**************************************************************************/
/* 
* You may edit some parts below
*/ 
?>
<table class="vftable" style="margin:auto; vertical-align:top; text-align:center; border:none; width:100%">
  <tbody>
    <tr>
      <td valign="top">
        <div id="vfwrapper" style="padding: 2px 4px">
          <div>
          <table class="vftable" valign="top">
            <tbody>
              <tr>
                <td valign="top">
                  <!-- START TOP SECTION --> 
                  <table class="vftable" valign="top">
                    <tbody>
                    <?php
                    if ($context == 'fb') {
                      echo '<tr><td>';
                      echo '<div style="float:left; padding: 0px 4px 4px;">';
                      echo '<a href="'.$vparams->canvasurl.'" target="_parent">'.JText::_('COM_VIDEOFLOW_HOME').'</a>';
                      echo '</div>';
                      echo '<div style="float:right; padding: 0px 4px 4px;">';
                      echo '<a href="http://www.facebook.com/apps/application.php?id='.$vparams->appid.'" target="_parent">'.JText::_('COM_VIDEOFLOW_FAN_PAGE').'</a>';
                      echo '</div>';
                      echo '</td></tr>';
                    }
                      ?>
                      <tr>
                        <td>
                          <div id="vfnavig" class="vfround" style="margin-top:0px; padding-top:0px;">
                          <?php
                          //Load the menu
                          if (is_array ($this->menu)){
                              foreach ($this->menu as $menu){
                              echo $menu;
                              }
                          }
                          ?>
                          </div>
                        </td>
                      </tr>
                       <!-- 1.4 Start Menu Area 2 --> 

                      <?php 
                      if (!empty ($this->menu2) || !empty($this->cname) || !empty($this->cpix)){
                      ?>
                      <tr>
                        <td>
                          <table class="vftable" align="center" valign="top">
                            <tr>
                            <?php 
                            if (!empty($this->cname)) {
                            ?>
                              <td valign="top">
                                <table class="vftable" align="center" valign="middle">
                                  <tr>
                                    <td valign="top" style="border:0px; border-bottom: 1px dotted #CCCCCC;">
                                    <?php echo $this->cname; ?>
                                    </td>
                                    <td style="border:0px; border-bottom: 1px dotted #CCCCCC; width:10px;"></td>
                                  </tr>
                                </table>
                              </td>
                              <?php
                              }
                              if (!empty($this->cpix)) {
                              echo '<td>'.$this->cpix.'</td>';
                              if ($context == 'fb') {
                                echo '<script> window.fbAsyncInit = function() { FB.XFBML.parse(); } </script>';
                              } 
                              }
                              if (!empty($this->menu2)){
                              ?>
                              <td valign="top">
                                <table class="vftable" align="center" valign="middle">
                                  <tr>
                                    <td style="border:0px; border-bottom: 1px dotted #CCCCCC; text-align:center;">
                                    <?php
                                    echo $this->menu2;
                                    ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <?php
                              }
                              ?>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <?php
                      }
                      ?>
                      <!-- 1.4 End Menu Area 2-->                       
                      <?php
                      $fbuser = JRequest::getVar ('fbuser');
                      if (!empty($this->promptperm)) echo '<tr><td>'.$this->promptperm.'</td></tr>';
                      if (!empty($this->notice)) echo '<tr><td>'.$this->notice.'</td></tr>';
                      if ($fbuser || $this->vflow1) {
                      echo '<tr><td>';
                      echo '<div style="position:relative; height:62px; padding-bottom:10px;">'; // Start top banner division
                      ?>        
                      <div class="vf_fbtheme" style="position:absolute; left:0px; top: 24px; height:20px; width:100%; background-color:<?php echo $bgactive;?>; border-color: <?php echo $iborderc; ?>"></div>
                      <?php echo '<table style="margin:auto; width:100%; height:62px;"><tr>'; ?>
                      <td>
                        <table class="vftable" style="margin:auto;">
                          <tr>
                            <td>
                              <div style="position:relative; max-height:62px;">
                              <?php echo $this->vflow1; ?>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <?php
                      }
                      if ($fbuser) {
                      ?>
                      <td style="width: 60px;">
                        <div style="margin:5px; position:relative; float:right;">
                          <fb:profile-pic class="fb_profile_pic_rendered FB_ElementReady" facebook-logo="true" size="square" uid="<?php echo $fbuser; ?>"></fb:profile-pic>     
                        </div>
                      </td>
                      <td style="width:80px;">
                        <div style="position:relative; padding: 0px 10px;">
                        <?php
                        $logouturl = JRequest::getString('logouturl');
                        if (!empty($logouturl)) {  
                        echo '<a href="'.$logouturl.'" target="_parent">'.JText::_('COM_VIDEOFLOW_LOGOUT').'</a>';
                        }
                      ?>
                        </div>
                      </td>
                      <?php
                       }
                      if ($fbuser || $this->vflow1) {
                      echo '</tr></table>';
                      echo '</div>'; //End top banner division
                      echo '</td></tr>';
                      }
                      if (!empty($smessage)) {
                      echo '<tr><td><div class="vf_fbtheme" style="height:20px; margin: 4px 0px; width:100%; background-color:'.$bgactive.'; border-color:'.$iborderc.';">';
                      echo '<div class="vf_smessage">'. $smessage .' </div>';
                      echo '</div></td></tr>';
                      }
                      ?>
                    </tbody>
                  </table> 
                  <!-- END TOP SECTION -->
<?php
/*************** IT IS NOT NECESSARY TO CHANGE THIS PART ****************
**************** BE CAREFUL IF YOU CHOOSE TO MODIFY IT ******************/

// Load search form 
if ($vtask == 'search') {
  $vs = JRequest::getString('vs');
  $id = JRequest::getInt('id');
  if ($vs != 'rel' && empty($id)) {
    $stemp = new JView;
    $stemp->_layout = 'listview';
    $stemp->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'videoflow' . DS . 'tmpl' );
    echo $stemp->loadTemplate('search');
  }
}

//Display login form if necessary
if ($vtask == 'login'){
echo $this->loadTemplate('login');
}
// Or logout form
if ($vtask == 'logout'){
echo $this->loadTemplate ('login');
}

if (isset($this->media)) echo $this->loadTemplate('play');

$dcount = 0;
if (!empty($this->vlist) && is_array ($this->vlist)){
  
  $dcount = count($this->vlist);
  if (!empty($this->tabone)) $tabone = $this->tabone; else $tabone = array();
  $mbox = 1000000; 
  $mboxx = 1;
    
  foreach ($this->vlist as $vid){
      
      //Set sharelink
      $sharelink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task=play&id='.$vid->id);
  
      // Set thumbnail link
      
      if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
         if (empty($vid->pixlink) && !file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$vid->title.'.jpg')) {
         $vid->pixlink = $this->imgResize($vid, 'thumb');
         }
        }
      
      if (!empty($vid->pixlink)) {
         if (stripos($vid->pixlink, 'http://') === FALSE) {  
         $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->pixlink;
         }
       } else if (empty($vid->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$vid->title.'.jpg')){       
       $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->title.'.jpg';
       } else { 
      $vid->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      }
      
      $dispcat = stripslashes(JText::_($this->cats[$vid->cat]->name));
      
      if (empty ($dispcat)) $dispcat = JText::_('COM_VIDEOFLOW_CAT_NONE');
      
      // Determine rating
      if ($vid->rating > 0 && $vid->votes > 0) {
      $vid->rating = round($vid->rating / $vid->votes, 2).JText::_('COM_VIDEOFLOW_PER_FIVE'); 
      } else {
      $vid->rating = JText::_('COM_VIDEOFLOW_RATE_NONE');
      }
      
      //Determine lightbox popup height. Additionally controlled through css
      $vboxheight = $vparams->lplayerheight + $vparams->lboxh;
      $vboxwidth = $vparams->lplayerwidth + $vparams->lboxw;
      if ($vparams->ratings || (!empty($this->vfshare))) $vboxheight = $vboxheight + 30;
      if (!empty($this->vflow8)) $vboxheight = $vboxheight + 78;
      // Set thumbnail and title link format for "MultiBox" lightbox system
      if ($vparams->lightbox && ($vparams->lightboxsys=='multibox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/>
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id.$xp).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mboxx'.$mbox.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mbox.'"></div> </a>';
           if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           $vid->medialink = $this->imgResize($vid, 'pix');
           $thumblink = '<a href="'.$vid->medialink.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/>
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>'; 
           $titlelink = '<a href="'.$vid->medialink.'" id="vf_mboxx'.$mboxx.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mboxx.'"></div></a>'; 
          }
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$vid->id.$cid.$catid.$sl.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($vid->title).'</a>';
          }          
      } //End MultiBox link settings
      
      //Set thumbnail and title link formats for Joomla lightbox system
      elseif ($vparams->lightbox && ($vparams->lightboxsys == 'joomlabox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($vid->title).'</a>';
           
           if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
              $vid->medialink = $this->imgResize($vid, 'pix');
              $thumblink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">
                   <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>';           
           $titlelink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">'.stripslashes($vid->title).'</a>';
          }
          if (!$vparams->lightboxfull){
        //  $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$flowid.$tmpl.'&layout=simple').'">'.stripslashes($vid->title).'</a>';
          $titlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$vid->id.$cid.$catid.$sl.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($vid->title).'</a>';
          }    
      } // End Joomla lightbox thumbnail links
      
      // Set default thumbnail and title link formats - no lightbox effect
      
      else {
      $thumblink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$vid->id.$cid.$catid.$sl.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>
                    <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>';      
      
      $titlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$vid->id.$cid.$catid.$sl.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($vid->title).'</a>';
      
     // $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$type.$flowid.$tmpl.'&layout=simple').'">'.stripslashes($vid->title).'</a>';
      } //End default thumbnail and title links
/*****************************************************************************/
// You may edit the parts below to suit your needs. The corresponding css file is css/simple.css
      
      
                  ?>
                   <!-- START ITEM BOX -->
                  <div class="vfbox">
                    <div>
                    <table class="vftable">
                      <tbody>
                        <tr>
                          <td width="<?php echo $vparams->thumbwidth + 18; ?>" valign="top">
                            <div>
                            <?php echo $thumblink; ?>
                            </div>
                          </td>
                          <?php
                          if (!empty($vparams->jshare)) {
                          echo '<td>&nbsp;&nbsp;&nbsp;</td>';
                          }
                          ?>
                          <td valign="top">
                            <table style="font-size: 11px; padding-left:10px; padding-right:10px;">
                              <tbody>
                                <tr>
                                  <td valign="top" height="20" style="padding-top: 3px;">
                                      <span class="vftitle">
                                      <?php echo $titlelink; ?>
                                      </span>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="4"></td>
                                </tr>
                                <tr>
                                  <td valign="top" height="63">
                                    <div class="vflist3">
                                    <?php echo nl2br($this->escape($vid->sdetails)); ?>
                                    </div>
                                    <div style="padding-top:5px;">
                                    <?php
                                    if ($showdate){
                                    echo '<div style="font-family: arial;float:left; padding-right:20px; padding-top:10px;"><b>'.JText::_('COM_VIDEOFLOW_TDATE').' </b>'.$vid->dateadded.'</div>';
                                    }
                                    if ($showadd && !empty($vparams->showpro)) {
                                      $alist = JRequest::getWord('list');
                                      if ($alist == 'favs' && $vtask != 'visit') $add = 'remove'; else $add = 'add';
                                    ?>
                                      <div style="float:left; padding-right:20px; padding-top:10px;">
                                      <img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/'.$add.'.gif'; ?>" />
                                      <a href="<?php echo JRoute::_('index.php?option=com_videoflow&task='.$add.'&id='.$vid->id); ?>" class="modal-vflow" rel="{handler: 'iframe', size: {x: '600', y: '480'}}">
                                      <?php echo JText::_('COM_VIDEOFLOW_MYLIST'); ?>
                                      </a>
                                      </div>
                                    <?php
                                    }
                                    if (!empty($showlike)) {
                                    echo '<div style="float:left; margin: 5px 2px; padding-top:5px;">';
                                    echo '<fb:like href="'.$sharelink.'" layout="'.$likelayout.'" width="300" show_faces="'.$likefaces.'" colorscheme="'.$likecolour.'"></fb:like>';
                                    echo '</div>';
                                    }
                                    ?>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <?php 
                          if ($showuser || $showviews || $showplaylistcount || $showdownloads || $showcommentcount || $showrating || $showcat ){
                          ?>  
                          <td width="2" valign="top" style="padding-top: 4px;">
                            <div class="vf_vdotted_line">
                            </div>
                          </td>
                          <td class="vflist10" width="20%" valign="top">
                            <table class="vftable">
                              <tbody>
                              <?php
                              if ($showuser) {
                                if ($context == 'fb') {
                                 $href = 'href="'.$vparams->canvasurl.'&task=visit&cid='.$vid->userid.'" target="_parent"'; 
                                } else {
                                 $href = 'href="'.JRoute::_('index.php?option=com_videoflow&task=visit&cid='.$vid->userid.'&layout=simple'.$flowid).'"'; 
                                }
                              ?>
                                <tr>
                                  <td>
                                    <font class="vflist6">
                                      <?php echo JText::_('COM_VIDEOFLOW_TUSER'); ?>
                                    </font>
                                    <a style="font-size: 11px; font-family: arial;" <?php echo $href; ?>">
                                    <?php echo stripslashes($vid->usrname); ?>
                                    </a>
                                  </td>
                                </tr>
                              <?php
                              }
                              if ($showviews) {
                              ?>
                                <tr>
                                  <td>
                                    <font class="vflist6">
                                      <?php echo JText::_('COM_VIDEOFLOW_TVIEWS'); ?>
                                    </font>
                                    <font class="vflist5">
                                      <?php echo $vid->views; ?>
                                    </font>
                                  </td>
                                </tr>
                              <?php
                              }
                              if ($showvotes) {
                              ?>
                                <tr>
                                  <td>
                                    <font class="vflist6">
                                      <?php echo JText::_('COM_VIDEOFLOW_TVOTES'); ?>
                                    </font>
                                    <font class="vflist5">
                                      <?php echo $vid->votes; ?>
                                    </font>
                                  </td>
                                </tr>
                              <?php
                              }         
                              if ($showplaylistcount && $vparams->showpro){
                              ?>
                                <tr>
                                  <td>
                                    <font class="vflist6"><?php echo JText::_('COM_VIDEOFLOW_TPLAYLISTS'); ?></font>
                                    <font class="vflist5"><?php echo $vid->favoured; ?></font>
                                  </td>
                                </tr>
                              <?php
                              }
                              if ($showdownloads && $vparams->showpro){
                              ?>
                                <tr>
                                  <td>
                                    <font class="vflist6"><?php echo JText::_('COM_VIDEOFLOW_TDOWNLOADS'); ?></font>
                                    <font class="vflist5"><?php echo $vid->downloads; ?></font>
                                  </td>
                                </tr>
                              <?php
                              }
                              if ($showrating) {
                              ?>
                                <tr>
                                  <td valign="middle" height="15">
                                    <font class="vflist6">
                                      <?php echo JText::_('COM_VIDEOFLOW_TRATING'); ?>
                                    </font>
                                    <font class="vflist5">
                                      <?php echo $vid->rating; ?> 
                                    </font>
                                  </td>
                                </tr>
                              <?php
                              }
                              if ($showcat) {
                                if ($context == 'fb') {
                                  $catlink = '<a href="'.$vparams->canvasurl.'&task=cats&cat='.$vid->cat.'&sl=categories" target="_parent">'; 
                                } else {
                                  $catlink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$vid->cat.'&sl=categories&layout=simple'.$flowid).'">'; 
                                }
                              ?>
                                <tr>
                                  <td valign="bottom" height="20">
                                    <?php echo $catlink.$dispcat; ?>
                                    </a>
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>
                              </tbody>
                            </table>
                          </td>
                          <?php
                          }
                          ?>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                    <div class="vflist8">
                      <div class="vf_hsolid_line"></div>
                    </div>
                  </div>
         <!--END ITEM BOX-->
<?php
$mbox++;
$mboxx++;
}
}

// Initialise MultiBox
if ($vparams->lightbox && empty($tabone) &&  $vparams->lightboxsys == 'multibox') {
    if ($context == 'fb') $offsety = -700; else $offsety = 0;
        ?>
<script type="text/javascript">
						
                        var vfmbox = {};
			window.addEvent('domready', function(){
				vfmbox = new MultiBox('vf_mbox', {descClassName: 'vflowBoxDesc', useOverlay: <?php echo $this->vlay; ?>, tabCount : <?php echo count($tabone); ?>, tabCountExtra : <?php echo $dcount; ?>, MbOffset: <?php echo $this->mboffset; ?>, offset: {x:0, y:<?php echo $offsety; ?>}, MbIndex: false});
			});
                        
                        var vfmboxx = {};
			window.addEvent('domready', function(){
				vfmboxx = new MultiBox('vf_mboxx', {descClassName: 'vflowTboxDesc', useOverlay: <?php echo $this->vlay; ?>, tabCount : <?php echo count($tabone); ?>, tabCountExtra : <?php echo $dcount; ?>, MbOffset: <?php echo $this->mboffset; ?>, offset: {x:0, y:<?php echo $offsety; ?>}, MbIndex: false});
			});
			
</script>
<?php
}
        ?></td>
      <td class="vfaligntop">
        <div id="mod_vflow2">
          <?php echo $this->vflow2; ?>
        </div></td>
    </tr>
  </tbody>
</table>
        </div>
<div id="vffooter">
<?php
if (!empty($this->pagination)) {
  if (empty($this->pagination->pages)) $pages = $this->pagination->getPagesLinks(); else $pages = $this->pagination->pages;
  echo str_replace (array ('&amp;id=', 'task=play'), array ('&amp;v=', 'task=latest'), $pages);
  echo '&nbsp;&nbsp;';
  echo $this->pagination->getPagesCounter();
}
if (!empty($this->credit)) echo '<div style="margin:8px; text-align:center;">'.$this->credit.'</div>';
?>
</div><!-- vffooter-->
</div> <!-- wrapper -->
</td>
</tr>
</tbody>
</table> <!-- Table 1-->
<?php
if ($context == 'fb') $this->canvasFix();