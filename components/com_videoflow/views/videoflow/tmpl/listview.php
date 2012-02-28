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
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/listview.css';
$doc->addStyleSheet( $css, 'text/css', null, array() );
$xparams = $this->getXparams();
$iborderc = (string) $xparams->get('iborderc', '#EDEDED');
$bgactive = (string) $xparams->get('bgactive', '#F6F6F6');
$bginactive = (string) $xparams->get('bginactive', '#EDEDED');
 
$css2 = '.vfround, .mod_vflow, .vf_borderc, .vf_hsolid_line, .vf_vdotted_line {border-color:'.$iborderc.';}
        .vfmenu_selected, .vf_bgactive {background-color:'.$bgactive.';}
        .vf_bginactive {background-color:'.$bginactive.'}';
$doc->addStyleDeclaration($css2);

$flowid = JRequest::getInt('Itemid');
if (!empty($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
$type = JRequest::getVar('type');
if (!empty($type)) $type = '&type='.$type; else $type = '';

// Get parameters

$iborders = (int) $xparams->get('iborders', 4);
$borders = (int) $xparams->get('borders', 1);
$showuser = (bool) $xparams->get('showuser', 1);
$showcat = (bool) $xparams->get('showcat', 1);
$showviews = (bool) $xparams->get('showviews', 1);
$showvotes = (bool) $xparams->get('showvotes', 1);
$showrating = (bool) $xparams->get('showrating', 1);
$showadd = (bool) $xparams->get('showadd', 1);
$showlike = (bool) $xparams->get('listlikebutton', 0);
$showdate = (bool) $xparams->get('showdate', 1);
$showdownloads = (bool) $xparams->get ('showdownloads', 1);
$showplaylistcount = (bool) $xparams->get('showplaylistcount', 1);
$showcommentcount = (bool) $xparams->get('showcommentcount', 1);
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
    if (!empty ($vtask)) $sl = '&sl='.$vtask;
  $ls = JRequest::getInt ('limitstart', null);
    if ($ls > 0) $ls = '&limitstart='.$ls; 
  $mbox = 1; 
  $mboxx = 1000000;
  if ($vparams->lightboxfull) $xp = '&xp=1'; else $xp = '';
/**************************************************************************/
/* 
* You may edit some parts below
*/ 
?>
<table class="vftable">
  <tbody>
    <tr>
      <td valign="top">
        <div id="vfwrapper">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
            <tbody>
              <tr>
                <td valign="top">
                  <!-- START TOP SECTION --> 
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
                    <tbody>
                      <tr><td>
                          <?php
                          //Load the menu
                          if (is_array ($this->menu)){
                              echo '<div id="vfnavig" class="vfround" style="margin-top:0px; padding-top:0px;">';
                              foreach ($this->menu as $menu){
                              echo $menu;
                              }
                              echo '</div>';
                          }
                          $fbuser = JRequest::getVar ('fbuser');
                          if (!empty($this->promptperm)) echo $this->promptperm;
                          if ($fbuser || $this->vflow1) {
                              echo '<div style="position:relative; height:62px;">'; // Start top banner division   
                              echo '<div style="position:absolute; left:0px; top: 20px; height:20px; background:'.$bgactive.'; width:100%;"></div>';
                              echo '<div style="position:relative; max-height:62px; padding-left:20px; float:left;">';
                              echo $this->vflow1;
                              echo '</div>';     
                          }
                          if ($fbuser) {
                          echo '<div style="position:relative; margin-top:20px; padding-right:20px; float:right;">';     
                          echo '<a href="#" onClick="quitFB()">';
                          echo JText::_('Logout');
                          echo '</a>';     
                          echo '</div>';     
                          echo '<div style="margin:5px; position:relative; float:right;">';          
                          echo '<fb:profile-pic class="fb_profile_pic_rendered FB_ElementReady" facebook-logo="true" size="square" uid="'.$fbuser.'"></fb:profile-pic>';     
                          echo '</div>';     
                          echo '<div style="position:relative; margin-top:20px; float:right;">';
                          echo '<fb:name uid="'.$fbuser.'" firstnameonly="true" useyou="false"></fb:name>';
                          echo '</div>';     
                          }
                          if ($fbuser || $this->vflow1) echo '</div>'; //End top banner division
                          ?>
                    </td></tr>
                  </tbody>
                </table>
               <!-- TOP SECTION -->
<?php
/*************** IT IS NOT NECESSARY TO CHANGE THIS PART ****************
**************** BE CAREFUL IF YOU CHOOSE TO MODIFY IT ******************/
// Load search form and display search status message if necessary
if ($vtask == 'search') {
    $search_message = '';
    $vs = JRequest::getString('vs');
    if ($vs != 'rel') echo $this->loadTemplate('search');
    $searchword = JRequest::getString('searchword');
    if (!empty ($this->vlist)) {
    $search_message = JText::_('Search results for').' <b>'.$searchword.'</b>:';
    } 
    if (empty($this->vlist) && (!empty ($searchword))){
    $search_message = JText::_('No results found for').' <b>'.$searchword.'</b>.'.JText::_('Try another search term.'); 
    }
    if ($vs == 'rel' ) {
    $reltitle = JRequest::getString('title');
    $search_message = JText::_('Media related to').' <b>'.$reltitle.'</b>:';
    }
echo '<div id="vfsearch_msg">'.$search_message.'</div>';
}
// Display "videos by user" message if necessary
if ($vtask == 'uservids'){
$pid = JRequest::getInt('usrid');
$stask = 'visit&pid='.$pid;
$vuser = JRequest::getString('usrname', 'Guest');
echo '<div id="vfsearch_msg">'.JText::_('Media from').' <b>'.$vuser.'</b>:</div>';
}
//Display "videos liked by user" message if necessary
if ($vtask == 'userfavs'){
$pid = JRequest::getInt('usrid');
$stask = 'visit&pid='.$pid.'&tab=two';
$vuser = JRequest::getString('usrname', 'Guest');
echo '<div id="vfsearch_msg">'.JText::_('Media liked by').' <b>'.$vuser.'</b>:</div>';
}
// Display "videos in category" if necessary
if ($vtask == 'cmed'){
$cname = JRequest::getString('cname');
echo '<div id="vfsearch_msg">'.JText::_('Media in category').' <b>'.$cname.'</b>:</div>';
}
// Flat category view
if ($vtask == 'cats'){
echo '<div id="vfsearch_msg">'.JText::_('Media in category').' <b>'.$this->catname.'</b>:</div>';
}
//Display login form if necessary
if ($vtask == 'login'){
echo $this->loadTemplate('login');
}
// Or logout form
if ($vtask == 'logout'){
echo $this->loadTemplate ('login');
}
$dcount = 0;
if (!empty($this->vlist) && is_array ($this->vlist)){
  
  $dcount = count($this->vlist);
    
  foreach ($this->vlist as $vid){
      
      //Set sharelink
      $sharelink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task=play&id='.$vid->id);
  
      // Set thumbnail link
      if (!empty($vid->pixlink)) {
         if (stripos($vid->pixlink, 'http://') === FALSE) {  
         $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->pixlink;
         }
       } else if (empty($vid->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$vid->title.'.jpg')){
       
       $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->title.'.jpg';
       
       } else {
      
      $vid->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      
      }
      
      $dispcat = stripslashes($this->cats[$vid->cat]->name);
      
      if (empty ($dispcat)) $dispcat = JText::_('None');
      
      // Determine rating
      if ($vid->rating > 0 && $vid->votes > 0) {
      $vid->rating = round($vid->rating / $vid->votes, 2).JText::_('/5'); 
      } else {
      $vid->rating = JText::_('None');
      }
      
      //Determine lightbox popup height. Additionally controlled through css
      $vboxheight = $vparams->lplayerheight + $vparams->lboxh;
      $vboxwidth = $vparams->lplayerwidth + $vparams->lboxw;
      if ($vparams->ratings || (!empty($showlike))) $vboxheight = $vboxheight + 68;
      if (!empty($this->vflow8)) $vboxheight = $vboxheight + 78;
      // Set thumbnail and title link format for "MultiBox" lightbox system
      if ($vparams->lightbox && ($vparams->lightboxsys=='multibox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/>
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id.$xp).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mboxx'.$mboxx.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mboxx.'"></div> </a>';
           if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/>
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>'; 
           $titlelink = '<a href="'.$vid->medialink.'" id="vf_mboxx'.$mboxx.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mboxx.'"></div></a>'; 
          }
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$type.$flowid.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }          
      } //End MultiBox link settings
      
      //Set thumbnail and title link formats for Joomla lightbox system
      elseif ($vparams->lightbox && ($vparams->lightboxsys == 'joomlabox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($vid->title).'</a>';
           if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>'; 
          
           $titlelink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">'.stripslashes($vid->title).'</a>';
          }
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$flowid.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }    
      } // End Joomla lightbox thumbnail links
      
      // Set default thumbnail and title link formats - no lightbox effect
      
      else {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$flowid.'&layout=listview').'">
                    <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vid->pixlink.'"/></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$type.$flowid.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
      } //End default thumbnail and title links
/*****************************************************************************/
// You may edit the parts below to suit your needs. The corresponding css file is css/listview.css
      
                  ?>
                   <!-- START ITEM BOX -->
                  <div class="vfbox">
                    <table width="100%" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                <td width="<?php echo $vparams->thumbwidth + 18; ?>" valign="top">
                    <div>
                      <?php echo $thumblink; ?>
                    </div>
                </td>
                <?php
                if ($showlike) {
                echo '<td>&nbsp;&nbsp;&nbsp;</td>';
                }
                ?>
                <td valign="top">
                  <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px; padding-left:10px; padding-right:10px;">
                    <tbody>
                      <tr>
                        <td valign="top" height="20" style="padding-top: 3px;">
                          <span class="vftitle">
                            <?php echo $titlelink; ?>
                          </span></td>
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
                            echo '<div style="font-family: arial;float:left; padding-right:20px; padding-top:10px;"><b>'.JText::_('Date:').' </b>'.$vid->dateadded.'</div>';
                            }
                            if ($showadd && !empty($vparams->showpro)) {
                            ?>
                            <div style="float:left; padding-right:20px; padding-top:10px;">
                              <img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/add.gif'; ?>" />
                              <a href="<?php echo JRoute::_('index.php?option=com_videoflow&task=add&id='.$vid->id); ?>" class="modal-vflow" rel="{handler: 'iframe', size: {x: '600', y: '480'}}">
                                <?php echo JText::_('MyList'); ?></a>
                            </div>
                            <?php
                            }
                            if ($showlike) {
                            echo '<div style="float:left; margin: 5px 2px; padding-top:5px;">';
                            echo '<fb:like href="'.$sharelink.'" layout="'.$likelayout.'" show_faces="'.$likefaces.'" colorscheme="'.$likecolour.'"></fb:like>';
                            echo '</div>';
                            }
                            ?>
                          </div></td>
                      </tr>
                    </tbody>
                  </table></td>
                <?php 
                if ($showuser || $showviews || $showplaylistcount || $showdownloads || $showcommentcount || $showrating || $showcat ){
                ?>  
                <td width="2" valign="top" style="padding-top: 4px;">
                  <div class="vf_vdotted_line">
                  </div></td>
                <td class="vflist10" width="20%" valign="top">
                  <table cellspacing="0" cellpadding="0">
                    <tbody>
                      <?php
                      if ($showuser) {
                      ?>
                      <tr><td>
                          <font class="vflist6">
                            <?php echo JText::_('User:'); ?>
                          </font>
                          <a style="color: rgb(101, 101, 101); font-size: 11px; font-family: arial;" href="<?php echo JRoute::_('index.php?option=com_videoflow&task=visit&cid='.$vid->userid.'&layout=listview'.$flowid); ?>">
                            <?php echo stripslashes($vid->usrname); ?></a></td>
                      </tr>
                      <?php
                      }
                      if ($showviews) {
                      ?>
                      <tr><td>
                          <font class="vflist6">
                            <?php echo JText::_('Views:'); ?>
                          </font>
                          <font class="vflist5">
                            <?php echo $vid->views; ?>
                          </font></td>
                      </tr>
                      <?php
                      }
                      if ($showvotes) {
                      ?>
                      <tr><td>
                          <font class="vflist6">
                            <?php echo JText::_('Votes:'); ?>
                          </font>
                          <font class="vflist5">
                            <?php echo $vid->votes; ?>
                          </font></td>
                      </tr>
                      <?php
                      }         
                      if ($showplaylistcount && $vparams->showpro){
                      ?>
                      <tr><td>
                      <font class="vflist6"><?php echo JText::_('Playlists:'); ?></font>
                      <font class="vflist5"><?php echo $vid->favoured; ?></font>
                      </td>
                      </tr>
                      <?php
                      }
                      if ($showdownloads && $vparams->showpro){
                      ?>
                      <tr><td>
                      <font class="vflist6"><?php echo JText::_('Downloads:'); ?></font>
                      <font class="vflist5"><?php echo $vid->downloads; ?></font>
                      </td>
                      </tr>
                      <?php
                      }
                      if ($showcommentcount){
                      ?>
                      <tr><td>
                          <font class="vflist6">
                            <?php echo JText::_('Comments:'); ?>
                          </font>
                          <font class="vflist5">
                            <?php echo $vid->comcount; ?>
                          </font></td>
                      </tr>
                      <?php
                      }
                      if ($showrating) {
                      ?>
                      <tr>
                        <td valign="middle" height="15">
                          <font class="vflist6">
                            <?php echo JText::_('Rating:'); ?>
                          </font>
                          <font class="vflist5">
                            <?php echo $vid->rating; ?> 
                          </font></td>
                      </tr>
                      <?php
                      }
                      if ($showcat) {
                      ?>
                      <tr>
                        <td valign="bottom" height="20">
                          <a href="<?php echo JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$vid->cat.'&sl=categories&layout=listview'.$flowid); ?>">
                            <?php echo $dispcat; ?></a></td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table></td>
                  <?php
                  }
                  ?>
              </tr>
            </tbody>
          </table>
          <div class="vflist8">
            <div class="vf_hsolid_line">
            </div>
          </div>
        </div>
         <!--END ITEM BOX-->
<?php
$mbox++;
$mboxx++;
}
}
// Initialise MultiBox
if ($vparams->lightbox && ($vparams->lightboxsys == 'multibox') ) {
        ?>
<script type="text/javascript">
						
			var vfmbox = {};
			window.addEvent('domready', function(){
				vfmbox = new MultiBox('vf_mbox', {descClassName: 'vflowBoxDesc', useOverlay: true, tabCount: <?php echo $dcount; ?>, multiCount: true, MbOffset: <?php echo $this->mboffset; ?> });
			});
				
			var vfmboxx = {};
			window.addEvent('domready', function(){
				vfmboxx = new MultiBox('vf_mboxx', {descClassName: 'vflowTboxDesc', useOverlay: true, MbOffset: <?php echo $this->mboffset; ?>});
			});
			
			var vfmboxphoto = {};
			window.addEvent('domready', function(){
				vfmboxphoto = new MultiBox('vfphoto_mbox', {descClassName: 'vflowTboxDesc', useOverlay: true, MbOffset: <?php echo $this->mboffset; ?>});
			});
	
		</script>             
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
<div id="vffooter" style="text-align:center;">
<?php
if (!empty($this->pagination)){
echo $this->pagination->getPagesLinks();
echo '&nbsp;&nbsp;';
echo $this->pagination->getPagesCounter();
}
  ?>
</div>
</div></td>
</tr>
</tbody>
</table>
<?php
if ($vparams->facebook) {
?>
<script type="text/javascript">
function quitFB(){
  FB.logout(function(response) {
  window.location = "<?php echo JRoute::_(JURI::root().'index.php?option=com_videoflow&layout=listview'.$flowid); ?>";
  });
} 
</script>	
<?php
}