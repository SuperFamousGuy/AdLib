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
 
defined( '_JEXEC' ) or die( 'Restricted access' );

global $vparams;

if (!empty($vparams->profile_id)) {
$fb_notify = 'send_notification_uid="'.$vparams->profile_id.'"';
} else {
$fb_notify = '';
}

if (!empty ($this->xdata)) {
    $xmedia = $this->xdata;
    $vxid = 'vf_'.$vparams->mode.'_'.$xmedia->id;
       if (!empty($xmedia->pixlink)) {
       if (stripos($xmedia->pixlink, 'http://') === FALSE) {  
         $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$xmedia->pixlink;
         } else {
         $pixlink = $xmedia->pixlink;
         }
       } else if (empty($xmedia->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$xmedia->title.'.jpg')){       
       $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$xmedia->title.'.jpg';
       } else {
       $pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      }
      
    //Set media URL to full URL, excepting earlier versions where filename was saved as full URL 
 
    if ($vparams->mode == 'videoflow') {
        if (stripos ($xmedia->file, 'http://') === FALSE) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 
        $subdir = VideoflowFileManager::getFileInfo ($xmedia->type);
        $xmedia->file = JURI::root().$vparams->mediadir.'/'.$subdir['dir'].'/'.$xmedia->file;
        }
    }
            
    if ($xmedia->server == 'youtube.com') $vheight = '290px'; else $vheight = '265px';

?>
<!-- START ITEM BOX -->
<div id="<?php echo 'vf'.$xmedia->id; ?>">
<table cellspacing="0" cellpadding="0" border="0" valign="middle"><tr><td>
<div style="overflow: hidden; border:none; padding:10px 10px 5px 0px;"> 
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>

<td valign="top">
<div style = "margin-left:0px;">
<div style="float:left; max-width:490px; padding: 0px 5px 5px;">
<div>
<center>
<?php if (!empty($xmedia->xplayer)) {
echo $xmedia->xplayer;
} elseif (is_string($xmedia->embedcode)) {
echo $xmedia->embedcode;
} else {
echo '<fb:swf swfsrc="'.$xmedia->embedcode['player'].'" flashvars="'.$xmedia->embedcode['flashvars'].'" width="470px" height="'.$vheight.'" imgstyle="width: 120px; height: 90px; float:left;" waitforclick="false" imgsrc="'.$pixlink.'"/>';
}
?>
</center>
</div>
<div style="margin:20px 0px;">
<table align="left" cellspacing="0" cellpadding="0" border="0" valign="middle"><tr>
<?php
if(!empty($vparams->fbshowuser) || !empty($vparams->fbshowviews) || !empty($vparams->fbshowrating) || !empty($vparams->fbshowdate) || !empty($vparams->fbshowcategory) || !empty($vparams->fbshowplaylists)) {
?>
<td class="vflist10" valign="top" style="width: 100px; margin-right:5px;">
<table cellspacing="0" cellpadding="0">
<tbody>
<?php
if ($vparams->fbshowuser){
?>
<tr>
<td>
<font class="vflist6"><?php echo JText::_('User: ').$xmedia->usrlink; ?></font>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->fbshowviews){
?>
<tr>
<td>
<font class="vflist6"><?php echo JText::_('Views:'); ?></font>
<font class="vflist5"><?php echo $xmedia->views; ?></font>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->showpro && $vparams->fbshowplaylists){
?>
<tr>
<td>
<?php 
echo '<font class="vflist6">'. JText::_('Playlists:').'</font>
     <font class="vflist5">'. $xmedia->favoured . '</font>';
?>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->fbshowrating){
?>
<tr>
<td valign="middle" height="15">
<font class="vflist6"><?php echo JText::_('Rating:'); ?></font>
<font class="vflist5"><?php echo $xmedia->rating; ?></font>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->fbshowcategory){
?>
<tr>
<td valign="middle" height="15">
<font class="vflist6"><?php echo JText::_('Category: '); ?>
<a href="<?php echo $vparams->canvasurl.'&task=cats&cat='.$xmedia->cat.'&vf=1'; ?>"><?php echo $xmedia->catname; ?></a>
</font>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->fbshowdate){
?>
<tr>
<td valign="middle" height="15">
<font class="vflist6"><?php echo date_format(date_create($xmedia->dateadded), 'Y - m - d'); ?>
</font>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</td>
<td width="2" valign="top" style="padding-top: 4px;">
<div class="vf_vdotted_line">
</div>
</td>
<?php
}
?>

<td valign="top">
<div style="padding: 0px 10px;">
<div style="margin-bottom:4px;"><b><?php echo $xmedia->title; ?></b></div>
<div style="margin-bottom:12px;"><?php echo $xmedia->sdetails; ?></div>
<?php
if ($vparams->fbcomments){
?>
<div>
<fb:comments xid="<?php echo $vxid; ?>" canpost="true" numposts="5" publish_feed="true" candelete="false" simple="true" <?php echo $fb_notify; ?> returnurl="<?php echo $vparams->canvasurl.'&task=posted&id='.$xmedia->id.'&vf=1'; ?>"><fb:title><?php echo $xmedia->title; ?></fb:title></fb:comments>
</div>
<?php
}
?>
</div>
<div style="overflow: hidden; border: none; margin-top:5px; float:left; width:100%;"> 
<div style="border: none; padding-top:4px; padding-left:0px; float:left; width:120px; text-align:center;"> 
<img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/close.gif'; ?>" />
<a href="#" onclick="Animation(document.getElementById('<?php echo 'vf'.$xmedia->id; ?>')).to('height', '0px').to('opacity', 0).hide().go(); return false;"><?php echo JText::_('CLOSE'); ?></a>
</div>
<div style="border: none; padding-top:4px; float:left; width:120px; text-align:left;"> 
<?php echo $xmedia->mylist; ?>
</div>

<?php
if (!empty($vparams->fbshare)){
?>
<div style="border: none; padding-top:4px; float:left; width:120px; text-align:left;"> 
<fb:share-button class="url" href="<?php echo $xmedia->sharelink; ?>" />
</div>
<?php
}
?>

</div>
</td>
</tr></table>

</div>
</div>
</div>
</td>


<td valign="top">
<?php
  if (!empty($this->rmedia)) {
  echo '<div style="background-color:#eceff6; border: 1px solid #d4dae8; padding: 2px 4px; width: 110px; text-align:center;"><table>';
  echo '<tr><td>'.$this->rlabel.'</td></tr>';
    foreach ($this->rmedia as $rmedia) {    
     
     if (!empty($rmedia->pixlink)) {
       if (stripos($rmedia->pixlink, 'http://') === FALSE) {  
         $rpixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$rmedia->pixlink;
         } else {
         $rpixlink = $rmedia->pixlink;
         }
       } else if (empty($rmedia->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$rmedia->title.'.jpg')){       
       $rpixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$rmedia->title.'.jpg';
       } else {
       $rpixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      }

  
    echo '<tr><td>';
    echo '<div style="width:100%"><a href="'.$rmedia->link.'"><img src="'.$rpixlink.'" style="width:100px; display:block; margin-left:auto; margin-right:auto;" /></a></div>';
    echo '<div style="width:100%; padding: 2px 2px 4px 2px;"><a href="'.$rmedia->link.'">'.$rmedia->stitle.'</a></div>';
    echo '</td></tr>';
    }
  echo '</table></div>';
  } 
?>
</td>
</tr>
</tbody>
</table>
<div class="vflist8" style="margin-left:0px">
</div>
</div>
</div>
</td></tr></table>
<div class="vf_hsolid_line"></div>
</div>
<?php
}