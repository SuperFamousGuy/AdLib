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

global $vparams;

if (!empty($vparams->profile_id)) {
$fb_notify = 'send_notification_uid="'.$vparams->profile_id.'"';
} else {
$fb_notify = '';
}

if (!empty ($this->xdata)) {
foreach ($this->xdata as $media) {
        
    if (empty($media->fulltext)) $media->fulltext = $media->introtext;
        
    $vxid = $vparams->mode.'_news_'.$media->id;
    
?>

<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle"><tr><td>
<div style="overflow: hidden; border:none; padding:10px 10px 5px 0px;" id="<?php echo 'vf'.$media->id; ?>"> 
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>

<td valign="top">
<div style = "margin-left:0px;">
<div style="float:left; width:490px; padding: 0px 5px 5px;">
<div style="margin-bottom:4px;"><b><?php echo $media->title; ?></b></div>
<div><?php echo $media->fulltext; ?>
<?php
if ($vparams->fbcomments){
?>
<fb:comments xid="<?php echo $vxid; ?>" canpost="true" numposts="5" publish_feed="true" candelete="false" simple="true" <?php echo $fb_notify; ?> returnurl="<?php echo $vparams->canvasurl.'&task=posted&id='.$media->id.'&vf=1'; ?>"><fb:title><?php echo $media->title; ?></fb:title></fb:comments>
<?php
}
?>
</div>

</div>
</div>
</td>
<?php
if ($vparams->fbshowuser || $vparams->fbshowviews || $vparams->fbshowdate || $vparams->fbshowcategory || $vparams->fbshare){
?>

<td width="2" valign="top" style="padding-top: 4px;">
<div class="vf_vdotted_line">
</div>
</td>
<td class="vflist10" width="" valign="top">
<table cellspacing="0" cellpadding="0">
<tbody>
<?php
if ($params->fbshowuser){
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
<?php
if (!empty($vparams->fbshare)) {
?>
<tr>
<td>
<div style="border: none; padding:8px 0px; float:left;"> 
<fb:share-button class="url" href="<?php echo $media->sharelink; ?>" />
</div>
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