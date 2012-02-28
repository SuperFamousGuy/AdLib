<?php
//VideoFlow - Joomla Multimedia System for Facebook//
/**
* @ Version 1.1.3 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/
// No direct access
 
defined('_JEXEC') or die('Restricted access'); 
/************************** SET TABS AND LINK FORMATS. DON'T EDIT UNLESS YOU ARE CONFIDENT ****************************/ 
global $vparams;
$media = $this->media;
$xparams = $this->getXparams();
$showlike = (bool) $xparams->get('likebutton', $vparams->likebutton);
$vtask = JRequest::getCmd('task');
$stask = 'play';
$pid = '';
$sl = '';
$flowid = JRequest::getInt('Itemid');
if (!empty ($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
$type = JRequest::getVar('type');
if (!empty ($type)) $type = '&type='.$type; else $type = '';
if (empty($media->name)) $media->name = JText::_('Guest');
if (empty($media->usrname)) $media->usrname = JText::_('Guest');
if ($vtask == 'myvids' || $vtask == 'visit' ){
$tabone = JText::_('Uploads');
$tabtwo = JText::_('Favourites');
$stask = $vtask;
} else if ($vtask == 'cats') {
$cat = JRequest::getInt ('cat');
$tabone = JText::_('In ').$this->escape($this->catname);
$tabtwo = JText::_('Categories');
$stask = $vtask;
$pid = '&cat='.$cat;
$sl = '&sl=categories';
} else if ($vtask == 'mysubs') {
$stask = $vtask;
$sid = JRequest::getInt ('pid');
if (!empty($sid)) $pid = '&pid='.$sid;
$tabone = JText::_('Channels');
$tabtwo = JText::_('CH: ').$this->escape($media->name);
} else {
$tabone = JText::_('Related');
$tabtwo = JText::_('By ').$this->escape($media->name);
}
if ($vtask == 'visit'){
 $pid = JRequest::getInt('pid', JRequest::getInt('cid'));
 if (!empty($pid) || ($pid === 0)) $pid = '&pid='.$pid;
}
$tabthumbwidth = (int) $xparams->get('tabthumbwidth', 90);
$tabthumbheight = (int) $xparams->get('tabthumbheight', 60);
$iborders = (int) $xparams->get('iborders', 4);
$borders = (int) $xparams->get('borders', 1);
if (!empty($jeffects)) $iborders = 0;
$iborderc = (string) $xparams->get('iborderc', '#EDEDED');

if ($vparams->lightboxfull) $xp = '&xp=1'; else $xp = '';
//Determine lightbox popup height. Additionally controlled through css
$vboxheight = $vparams->lplayerheight + $vparams->lboxh;
$vboxwidth = $vparams->lplayerwidth + $vparams->lboxw;
if ($vparams->ratings || (!empty($showlike))) $vboxheight = $vboxheight + 68;
if (!empty($this->vflow8)) $vboxheight = $vboxheight + 78;
jimport('joomla.html.pane');
$seltab = JRequest::getString('tab', 'one');
if ($seltab == "two") {
$starttab = 1;
} else {
$starttab = 0;
}  
$vfTabs = & JPane::getInstance('tabs', array('startOffset'=>$starttab));
echo $vfTabs->startPane( 'vftabs' );
echo $vfTabs->startPanel( $tabone, 'tabone' );
if (is_array($this->tabone)) {
echo '<div style="padding:0px; margin:0px; height:1px;"></div>';
$mbox = 1;
foreach ($this->tabone as $vid){
     //special for channels
     
   // Set thumbnail link
      if (!empty($vid->pixlink)) {
         if (stripos($vid->pixlink, 'http://') === FALSE) {  
         $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->pixlink;
         }
       } else if (empty($vid->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$vid->title.'.jpg')){
       
       $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->title.'.jpg';
       
       } else {
      
      if (empty($vid->pixlink)) $vid->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      
      }   
      if (!isset($vid->type)) $vid->type = '';      
   // Set thumbnail and title link format for "MultiBox" lightbox system
      if ($vparams->lightbox && ($vparams->lightboxsys=='multibox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" />
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id.$xp).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mboxx'.$mbox.'" class="vf_mboxx" title="'.stripslashes ($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mbox.'"></div> </a>';
           if (!empty($vid->type) && ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif')) {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /><div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>'; 
           $titlelink = '<a href="'.$vid->medialink.'" id="vf_mboxx'.$mbox.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$mbox.'"></div></a>'; 
          }
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=one&add=1'.$flowid.$type.$sl.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }
      } //End MultiBox link settings
      
      //Set thumbnail and title link formats for Joomla lightbox system
      elseif ($vparams->lightbox && ($vparams->lightboxsys == 'joomlabox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($vid->title).'</a>';
          
          if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">
                        <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';
          
           $titlelink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">'.stripslashes($vid->title).'</a>';
          }  
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=one&add=1'.$flowid.$type.$sl.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }
      } // End Joomla lightbox thumbnail links
      
      // Set default thumbnail and title link formats - no lightbox effect
      
      else {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=one&add=1'.$flowid.$type.'&layout=listview').'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=one&add=1'.$flowid.$type.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
      } //End default thumbnail and title links
      
      if ($vtask == 'cats' && !$vparams->lightbox) {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$cat.'&id='.$vid->id.$sl.$flowid.'&layout=listview').'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$cat.'&id='.$vid->id.$sl.$flowid.'&layout=listview').'">'.stripslashes($vid->title).'</a>';      
      }
      
      if ($vtask == 'mysubs') {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=visit&cid='.$vid->joomla_id.$flowid.'&layout=listview').'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=visit&cid='.$vid->joomla_id.$flowid.'&layout=listview').'">'.stripslashes($vid->title).'</a>';      
      }
?>
<div style="width:100%; padding:6px 0px; height:<?php echo $tabthumbheight + 4; ?>px; overflow:hidden;">
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td valign="middle">
        <div class="vf_sidelist">
          <?php echo $thumblink; ?>
        </div> </td>
      <td valign="middle">
        <div class="vf_sidetitle">
          <?php echo $titlelink; ?>
        </div></td>
    </tr>
  </table>
</div>
<?php
$mbox++;
}
if ($this->tab1count > $vparams->sidebarlimit) {
$morelink = JRoute::_('index.php?option=com_videoflow&task=search&vs=rel&searchword='.$media->tags.'&title='.$media->title.'&layout=listview'.$flowid);
if ($vtask == 'cats') $morelink = JRoute::_('index.php?option=com_videoflow&task=cmed&cat='.$cat.'&cname='.$this->catname.$sl.$flowid.'&layout=listview'); 
if ($vtask == 'myvids' || $vtask == 'visit') {
  if (isset($this->owner)) $uname = $this->owner->name; else $uname = $media->usrname;
  $morelink = JRoute::_('index.php?option=com_videoflow&task=uservids&usrid='.$media->userid.'&usrname='.$uname.$flowid.'&layout=listview');
}  
?>
<div class="vf_seemore">
  <a href = "<?php echo $morelink; ?>"> 
    <?php echo JText::_('See All'); ?></a>
</div>
<?php
}
}
echo $vfTabs->endPanel();
echo $vfTabs->startPanel( $tabtwo, 'tabtwo' );
if (is_array($this->tabtwo)){
echo '<div style="padding:0px; margin:0px; height:1px;"></div>';
$vmbox = 1000000;
if ($vtask == "myvids") {
$vadd = 0;
} else {
$vadd = 1;
}
foreach ($this->tabtwo as $vid){
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
   
      if ($vtask == 'cats'){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$vid->id.'&sl=categories&layout=listview'.$flowid).'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$vid->id.'&sl=categories&layout=listview'.$flowid).'">'.stripslashes($vid->name).'</a>';
      
      } else {
    
   // Set thumbnail and title link format for "MultiBox" lightbox system
      if ($vparams->lightbox && ($vparams->lightboxsys=='multibox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mbox'.$vmbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" />
                   <div class="vflowBoxDesc vf_mbox'.$vmbox.'"></div> </a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mboxx'.$vmbox.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$vmbox.'"></div> </a>';
           if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="vf_mbox'.$vmbox.'" class="vf_mbox" title="'.stripslashes($vid->title).'">
                   <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" />
                   <div class="vflowBoxDesc vf_mbox'.$vmbox.'"></div> </a>'; 
           $titlelink = '<a href="'.$vid->medialink.'" id="vf_mboxx'.$vmbox.'" class="vf_mboxx" title="'.stripslashes($vid->title).'">'.stripslashes($vid->title).'
                   <div class="vflowTboxDesc vf_mboxx'.$vmbox.'"></div></a>'; 
          }          
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=two&add='.$vadd.$flowid.$type.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }
      
      
      
      } //End MultiBox link settings
      
      //Set thumbnail and title link formats for Joomla lightbox system
      elseif ($vparams->lightbox && ($vparams->lightboxsys == 'joomlabox')){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$vid->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($vid->title).'</a>';
          if ($vid->type == 'jpg' || $vid->type == 'png' || $vid->type == 'gif') {
           if (empty($vid->medialink)) $vid->medialink = JURI::root().$vparams->mediadir.'/photos/'.$vid->file;
           $thumblink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$vmbox.'" class="modal-vflow">
                        <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';
          
           $titlelink = '<a href="'.$vid->medialink.'" id="modal-vflow'.$vmbox.'" class="modal-vflow">'.stripslashes($vid->title).'</a>';
          }          
          if (!$vparams->lightboxfull){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=two&add='.$vadd.$flowid.$type.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
          }
      } // End Joomla lightbox thumbnail links
      
      // Set default thumbnail and title link formats - no lightbox effect
      
      else {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=two&add='.$vadd.$flowid.$type.'&layout=listview').'">
                    <img width="'.$tabthumbwidth.'px" height="'.$tabthumbheight.'px" src="'.$vid->pixlink.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" /></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$pid.'&tab=two&add='.$vadd.$flowid.$type.'&layout=listview').'">'.stripslashes($vid->title).'</a>';
      } 
    }//End default thumbnail and title links
?>
<div style="width:100%; padding:6px 0px; height:<?php echo $tabthumbheight + 4; ?>px; overflow:hidden;">
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td valign="middle">
        <div class="vf_sidelist">
          <?php echo $thumblink; ?>
        </div> </td>
      <td valign="middle">
        <div class="vf_sidetitle">
          <?php echo $titlelink; ?>
        </div></td>
    </tr>
  </table>
</div>
<?php
$vmbox++;
}
if ($this->tab2count > $vparams->sidebarlimit) {
$morelink = JRoute::_('index.php?option=com_videoflow&task=uservids&usrid='.$media->userid.'&usrname='.$media->username.$flowid.'&layout=listview');
  if ($vtask == 'cats') $morelink = JRoute::_('index.php?option=com_videoflow&task=categories&layout=listview'.$flowid);
  if ($vtask == 'myvids' || $vtask == 'visit') {
  if (isset($this->owner)) {
    $uname = $this->owner->name;
    $uid = $this->owner->id;
    } else {
    $uname = $media->usrname;
    $uid = $media->userid;
    }
  $morelink = JRoute::_('index.php?option=com_videoflow&task=userfavs&usrid='.$uid.'&usrname='.$uname.$flowid.'&layout=listview');
}  
?>
<div class="vf_seemore">
  <a href = "<?php echo $morelink ?>"> 
    <?php echo JText::_('See All'); ?></a>
</div>
<?php
}
}
echo $vfTabs->endPanel();
echo $vfTabs->endPane();
// Initialise MultiBox
if ($vparams->lightbox && ($vparams->lightboxsys == 'multibox') ) {
?>
<script type="text/javascript">
						
			var vfmbox = {};
			window.addEvent('domready', function(){
				vfmbox = new MultiBox('vf_mbox', {descClassName: 'vflowBoxDesc', useOverlay: true, tabCount : <?php echo count($this->tabone); ?>, tabCountExtra : <?php echo count($this->tabtwo); ?>, MbOffset: <?php echo $this->mboffset; ?>, MbIndex: false});
			});
			
			
			var vfmboxx = {};
			window.addEvent('domready', function(){
				vfmboxx = new MultiBox('vf_mboxx', {descClassName: 'vflowTboxDesc', useOverlay: true, MbOffset: <?php echo $this->mboffset; ?>, MbIndex: false});
			});
	
		</script>
<?php
}