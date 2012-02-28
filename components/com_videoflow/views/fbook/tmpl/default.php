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

echo '<link rel="stylesheet" type="text/css" media="screen" href="'.JURI::root().'components/com_videoflow/views/fbook/tmpl/css/default.css?v=7.0" />';

global $vparams;

if (!empty($vparams->profile_id)) {
$fb_notify = 'send_notification_uid="'.$vparams->profile_id.'"';
} else {
$fb_notify = '';
}

/*
* Customisation Tip: You may edit the HTML and css stylesheet. 
* Not recommended to edit PHP code unless you are sure of what you are doing.
*/                                                                                                                                    

?>

<div id="vfwrapper">
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody>
<tr><td valign="top" style="width:630px;">
<!-- 1. START TOP SECTION --> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody>
<!-- 1.1 Start Top Banner Area --> 
<?php
    if(!empty($this->fb_vflow1)) {
    ?>
    <tr><td align="center">
    <div class="vfb_mod1">
    <?php echo $this->fb_vflow1; ?>
    </div>
    </td></tr>
<?php
    }
  ?>
<!-- 1.1 End top banner Area --> 
<!-- 1.2 Start Dashboard --> 
<tr><td>
<div style="margin:0px; width:98%; padding:0px 4px;">
<?php

//Load the menu
if (!empty ($this->dashboard)){
  echo $this->dashboard;
}
?>
</div>
</td></tr>
<!-- 1.2 End Dashboard--> 



<!-- 1.3 Start Menu Area 1 --> 
<tr><td>
<div id="vfnavig" style="margin:0px; padding-top:0px;">
<?php

//Load the menu
if (!empty ($this->menu)){
  echo $this->menu;
}
?>
</div>
</td></tr>
<!-- 1.3 End Menu Area 1 --> 


<!-- 1.4 Start Menu Area 2 --> 

<?php 
if (!empty ($this->menu2) || !empty($this->cname) || !empty($this->cpix)){
?>
<tr><td>

<table align="center" cellspacing="0" cellpadding="0" border="0" valign="top">
<tr>
<?php 
if (!empty($this->cname)) {
?>
<td valign="top">
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td valign="top" style="border:0px; border-bottom: 1px dotted #CCCCCC;">
<?php echo $this->cname; ?>
</td><td style="border:0px; border-bottom: 1px dotted #CCCCCC; width:10px;"></td></tr></table>
</td>
<?php
}
if (!empty($this->cpix)) {
echo '<td>'.$this->cpix.'</td>';
}
if (!empty($this->menu2)){
?>
<td valign="top">
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td style="border:0px; border-bottom: 1px dotted #CCCCCC; text-align:center;">
<?php echo $this->menu2; ?>
</td></tr></table>
</td>
<?php
}
?>

</tr></table>

</td></tr>
<?php
}
?>
<!-- 1.4 End Menu Area 2--> 
<!-- 1.5 Start status message area-->
<?php
if (!empty($this->notice)) {
?> 
<tr><td>
<?php echo $this->notice; ?>  
</td></tr> 
<?php
}
?>
<!-- 1.5 End status message area -->

</tbody>
</table>

<!-- 1. END TOP SECTION -->

<!-- 2. START MULTI-FUNCTION OUTPUT -->
<?php 
if (!empty($this->data)) {
?>
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td>
<div>
<?php echo $this->data; ?>
</div>
</td></tr>
</table>
<?php
}
?>
<!-- 2. END MULTI-FUNCTION OUTPUT -->
<!-- 3. START SECONDARY TEMPLATE -->
<?php 
if (!empty($this->xdata)) {
?>
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td>
<div>
<?php echo $this->loadTemplate($this->xtemp); ?>
</div>
</td></tr>
</table>
<?php
}
?>
<!-- 3. END SECONDARY TEMPLATE -->



<!-- 4. START VIDEOLIST SECTION --> 
<?php
if (!empty ($this->media)) {
foreach ($this->media as $media) {

  if (!isset($media->type)) $media->type = '';
   
//Set media URL to full URL, excepting earlier versions where filename was saved as full URL 
 
    if ($vparams->mode == 'videoflow') {
        if (stripos($media->file, 'http://') === FALSE) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 
        $subdir = VideoflowFileManager::getFileInfo ($media->type);
        $media->file = JURI::root().$vparams->mediadir.'/'.$subdir['dir'].'/'.$media->file;
        }
    }


//Set default preview image, correcting for earlier versions where files name was saved as full URL
 
    if (!empty($media->pixlink)) {       
       if (stripos($media->pixlink, 'http://') === FALSE) {  
         $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->pixlink;
         } else {
         $pixlink = $media->pixlink;
         }
       } else if (empty($media->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$media->title.'.jpg')){
       $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->title.'.jpg';       
       } else if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') {
       $pixlink = $media->file;
       } else {
       $pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      }
         
    $vxid = 'vf_'.$vparams->mode.'_'.$media->id;
    
    $sharelink = JURI::root().'index.php?option=com_videoflow&task=play&id='.$media->id;
    
    if ($media->server == 'youtube') $vheight = '362'; else $vheight = '338'; 

?>
<!-- START ITEM BOX -->
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td>
<div style="overflow: hidden; border:none; padding:10px 10px 5px 10px;" id="<?php echo 'vf'.$media->id; ?>"> 
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" align="center">
<table cellspacing="0" cellpadding="0" style="float:left; min-width:20%">
<tr><td>
<div style="overflow: visible; border: none; float:left; padding-right:4px; padding-bottom:20px;"> 
<?php if (is_string($media->embedcode)) {
?>
<fb:js-string var="vfimg<?php echo $media->id; ?>"><center><?php echo $media->embedcode; ?></center></fb:js-string>
<a href="#" onclick='this.setInnerFBML(vfimg<?php echo $media->id; ?>);return false;'><img id='vfimg<?php echo $media->id;?>' src='<?php echo $pixlink; ?>' width='<?php echo $vparams->thumbwidth.'px'; ?>' / ></a>
<?php
} else {
echo '<fb:swf swfsrc="'.$media->embedcode['player'].'" flashvars="'.$media->embedcode['flashvars'].'" width="600px" height="'.$vheight.'px" imgstyle="width: 120px; height: 90px;" waitforclick="true" imgsrc="'.$pixlink.'"/>';
}
?>
</center>
</div>
</td></tr>
</table>
<table cellspacing="0" cellpadding="0" style="float:right; width:75%">
<tr><td>
<table><tr>
<td style="width:380px;">
<div style="float:left; padding: 0px 5px 5px;">
<div style="margin-bottom:4px;"><b><?php echo $media->title; ?></b></div>
<div style="margin-bottom:12px;"><?php echo $media->sdetails; ?></div>
<?php
if (!empty($vparams->fbcomments)) {
?>
<fb:comments xid="<?php echo $vxid; ?>" canpost="true" numposts="5" publish_feed="true" candelete="false" simple="true" <?php echo $fb_notify; ?> returnurl="<?php echo $vparams->canvasurl.'&task=posted&id='.$media->id.'&vf=1'; ?>"><fb:title><?php echo $media->title; ?></fb:title></fb:comments>
<?php
}
?>
</div>
<div style="overflow: hidden; border: none; padding:0px; float:left; width:100%;"> 
<?php
if (!empty($vparams->showpro) && !empty($vparams->fbshowmylist)){
?>
<div style="border: none; padding-top:4px; float:left; width:30%; text-align:left;"> 
<?php echo $media->mylist; ?>
</div>
<?php
}
?>
<?php
if (!empty($vparams->fbshare)){
?>
<div style="border: none; padding-top:4px; float:left; width:30%; text-align:left;"> 
<fb:share-button class="url" href="<?php echo $media->sharelink; ?>" />
</div>
<?php
}
?>
<div style="border: none; padding-top:4px; padding-left:0px; float:left; width:30%; text-align:center;"> 
<img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/close.gif'; ?>" />
<a href="#" onclick="Animation(document.getElementById('<?php echo 'vf'.$media->id; ?>')).to('height', '0px').to('opacity', 0).hide().go(); return false;"><?php echo JText::_('CLOSE'); ?></a>
</div>
</div>
</td>
<?php
if(!empty($vparams->fbshowuser) || !empty($vparams->fbshowviews) || !empty($vparams->fbshowrating) || !empty($vparams->fbshowdate) || !empty($vparams->fbshowcategory) || !empty($vparams->fbshowplaylists)) {
?>
<td valign="top" style="width:2px; padding-top: 4px;">
<div class="vf_vdotted_line">
</div>
</td>
<td class="vflist10" style="width:120px;" valign="top">
<table cellspacing="0" cellpadding="0">
<tbody>
<?php
if ($vparams->fbshowuser){
?>
<tr>
<td>
<font class="vflist6"><?php echo JText::_('User: ').$media->usrlink; ?></font>
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
<font class="vflist5"><?php echo $media->views; ?></font>
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
     <font class="vflist5">'. $media->favoured . '</font>';
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
<font class="vflist5"><?php echo $media->rating; ?></font>
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
<a href="<?php echo $vparams->canvasurl.'&task=cats&cat='.$media->cat.'&vf=1'; ?>"><?php echo $media->catname; ?></a>
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
<font class="vflist6"><?php echo date_format(date_create($media->dateadded), 'Y - m - d'); ?>
</font>
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
</tr></table>
</td></tr>
</table>
</td>
</tr>
</tbody>
</table>
<div class="vflist8" style="margin-left:0px; height:10px;">
<div class="vf_hsolid_line">
</div>
</div>
</div>
</div>
</td></tr></table>
<?php
}
}
?>
<!--END ITEM BOX-->
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle" align="center">
<tr><td align="center">
<div class = "vfpagination">
<?php
if (!empty($this->pagination)){
echo $this->pagination->pagelinks; echo '&nbsp;&nbsp;';
echo $this->pagination->getPagesCounter();
}
if (!empty($this->credit)) echo '<div style="margin:8px;">'.$this->credit.'</div>';
?>
</div>
</td></tr>
<?php
  if (!empty($this->fb_vflow3)) {
  echo '<tr><td>';
  echo '<div style="margin:4px 0px;">'. $this->fb_vflow3 .'</div>';
  echo '</td></tr>';
  }
?>
</table>
</td>
<td class="vfaligntop""><div id="mod_vflow2" style="width:130px;"> <?php if (!empty($this->fb_vflow2)) echo $this->fb_vflow2; ?></div></td>
</tr></tbody></table>
<div id="vffooter"></div>
</div>