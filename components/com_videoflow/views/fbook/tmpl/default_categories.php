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

/*
* Customisation Tip: You may edit the HTML and css stylesheet. 
* Not recommended to edit PHP code unless you are sure of what you are doing.
*/                                                                                                                                    

?>

<div id="vfwrapper">
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

<!-- 1.3 Start status message area-->
<?php
if (!empty($this->notice)) {
?> 
<tr><td>
<?php echo $this->notice; ?>  
</td></tr> 
<?php
}
?>
<!-- 1.3 End status message -->
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
<!-- 2. END MULTI-PURPOSE OUTPUT -->
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



<!-- 4. START CATEGORY LIST SECTION --> 
<?php
if (!empty($this->media) && is_array ($this->media)){
  foreach ($this->media as $media){
      $thumblink = '<a href="'.$vparams->canvasurl.'&task=cats&cat='.$media->id.'&vf=1">
                    <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" border="0" src="'.$media->pixlink.'"/></a>';      
      $titlelink = '<a href="'.$vparams->canvasurl.'&task=cats&cat='.$media->id.'&vf=1">'.html_entity_decode($media->name).'</a>';
?>
<!-- START ITEM BOX -->
<table align="center" cellspacing="0" cellpadding="0" border="0" valign="middle"><tr><td>
<div style="overflow: hidden; border:none; padding:10px 10px 5px 10px;" id="<?php echo 'vf'.$media->id; ?>"> 
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top">
<div style = "margin-left:10px;">
<div style="overflow: hidden; border: none; float:left; margin-right:10px;"> 
<?php echo $thumblink; ?>
</div>
<div style="float:left; width:400px; display:block;">
<div style="margin-bottom:4px;"><b><?php echo $titlelink; ?></b></div>
<div><?php echo nl2br(html_entity_decode($media->desc)); ?></div>
</div>
<div style="overflow: hidden; border: none; padding:0px; float:left; width:100%;"> 
<div style="border: none; padding-top:4px; padding-left:0px; float:right; width:120px; text-align:center;"> 
<img class="vf_tools_icons" src="<?php echo JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/close.gif'; ?>" />
<a href="#" onclick="Animation(document.getElementById('<?php echo 'vf'.$media->id; ?>')).to('height', '0px').to('opacity', 0).hide().go(); return false;"><?php echo JText::_('CLOSE'); ?></a>
</div>
</div>
</div>
</td>
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