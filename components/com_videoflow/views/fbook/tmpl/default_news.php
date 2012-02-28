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

$task = JRequest::getCmd ('task');

/*
* Customisation Tip: You may edit the HTML and css stylesheet. 
* Not recommended to edit PHP code unless you are sure of what you are doing.
*/                                                                                                                                    

?>

<div id="vfwrapper" style="max-width:760px; overflow:hidden;">
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody>
<tr><td valign="top">
<!-- 1. START TOP SECTION --> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody>
<!-- 1.1 Start Dashboard --> 
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
<!-- 1.1 End Dashboard--> 

<!-- 1.1 Start Menu Area 1 --> 
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
<!-- 1.1 End Menu Area 1--> 


<!-- 1.2 Start Menu Area 2 --> 

<?php 
if (!empty ($this->menu2)) {
?>
<tr><td style="border:0px; border-bottom: 1px dotted #CCCCCC; text-align:center;">
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle">
<tr><td>
<?php echo $this->menu2; ?>
</td></tr>
</table>
</td></tr>
<?php
}
?>
<!-- 1.2 End Menu Area 2--> 
<!-- 1.3 Start status box area-->
<?php
if (!empty($this->notice)) {
?> 
<tr><td>
<?php echo $this->notice; ?>  
</td></tr> 
<?php
}
?>
<!-- 1.3 End status box area -->
<!-- 1.4 Start Top Banner Area --> 
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
<!-- 1.4 End top banner Area --> 
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



<!-- 4. START ARTICLE LIST SECTION --> 
<?php
if (!empty ($this->media)) {
foreach ($this->media as $media) {
        
    if (empty($media->sintro)) $media->sintro = $media->sarticle;
        
    $vxid = 'vf_news_'.$media->id;
    
?>
<!-- START ITEM BOX -->
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle"><tr><td>
<div style="overflow: hidden; border:none; padding:10px 10px 5px 10px;" id="<?php echo 'vf'.$media->id; ?>"> 
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<?php
if ($task == 'news') {
?>
<td width="" valign="top">
<div style="min-width:100px">
<?php
if (!empty($media->pixlink)) {
echo '<img src="'.$media->pixlink.'" style="width: 100px; float:left; margin-right:5px;" />';
}
?>
</div>
</td>
<?php
}
?>
<td valign="top">
<div style = "margin-left:0px;">
<div style="float:left; width:380px; display:block; padding: 0px 5px 5px;">
<div style="margin-bottom:4px;"><a href="<?php echo $media->link; ?>"><b><?php echo $media->title; ?></b></a></div>
<div><?php echo $media->sintro; ?></a>
<?php
if ($vparams->fbcomments) {
?>
<fb:comments xid="<?php echo $vxid; ?>" canpost="true" numposts="5" publish_feed="true" candelete="false" simple="true" <?php echo $fb_notify; ?> returnurl="<?php echo $vparams->canvasurl.'&task=read&id='.$media->id.'&vf=1'; ?>"><fb:title><?php echo $media->title; ?></fb:title></fb:comments>
<?php
}
?>
</div>
<div style="overflow: hidden; border: none; margin-top:5px; float:left; width:100%;"> 
<div style="border: none; padding-top:4px; padding-left:0px; float:left; width:120px; text-align:center;"> 
<img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/close.gif'; ?>" />
<a href="#" onclick="Animation(document.getElementById('<?php echo 'vf'.$media->id; ?>')).to('height', '0px').to('opacity', 0).hide().go(); return false;"><?php echo JText::_('CLOSE'); ?></a>
</div>
<div style="border: none; padding-top:4px; float:left; width:120px; text-align:left;"> 
</div>

<?php
if (!empty($vparams->fbshare)){
?>
<div style="border: none; padding-top:4px; float:left; width:120px; text-align:left;"> 
<fb:share-button class="url" href="<?php echo $media->sharelink; ?>" />
</div>
<?php
}
?>

</div>
</div>
</div>
</td>

<?php
if ($vparams->fbshowuser || $vparams->fbshowviews || $vparams->fbshowdate || $vparams->fbshowcategory){
?>
<td width="2" valign="top" style="padding-top: 4px;">
<div class="vf_vdotted_line">
</div>
</td>
<td class="vflist10" width="20%" valign="top">
<table cellspacing="0" cellpadding="0">
<tbody>
<?php
if ($vparams->fbshowuser) {
?>
<tr>
<td>
<font class="vflist6"><?php echo JText::_('Author: ').$media->name; ?></font>
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
<font class="vflist5"><?php echo $media->hits; ?></font>
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
<font class="vflist6"><?php echo date_format(date_create($media->modified), 'Y - m - d'); ?>
</font>
</td>
</tr>
<?php
}
?>
<?php
if ($vparams->fbshowcategory){
?>
<tr>
<td>
<font class="vflist5"><?php echo $media->ctitle; ?></font>
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
<div class="vflist8" style="margin-left:0px">
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
<div style="position:relative; margin:auto; text-align:center;overflow:hidden;">
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