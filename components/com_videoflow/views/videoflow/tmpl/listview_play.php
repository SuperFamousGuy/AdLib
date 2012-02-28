<?php

//VideoFlow - Joomla Multimedia System for Facebook//
/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); 

global $vparams;

//Load the layout stylesheet
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/listview.css';
$doc->addStyleSheet( $css, 'text/css', null, array() );
$xparams = $this->getXparams();
$iborderc = (string) $xparams->get('iborderc', '#EDEDED');
$bgactive = (string) $xparams->get('bgactive', '#F6F6F6');
$bginactive = (string) $xparams->get('bginactive', '#EDEDED');
 
$css2 = 'dl.tabs dt, div.current, .vftextbox, .vfround, .mod_vflow, .vf_borderc {border-color:'.$iborderc.';}
        #vfmediatitle, .vfmenu_selected, .vf_bgactive, .vf_seemore, dl.tabs dt.open {background-color:'.$bgactive.';}
        .vf_bginactive, dl.tabs dt {background-color:'.$bginactive.'}';

$doc->addStyleDeclaration($css2);
$flowid = JRequest::getInt('Itemid', $vparams->flowid);
if (!empty($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
?>
<table class="vftable">
<tbody>
<tr><td valign="top">
<div id="vfwrapper">
<table width="100%" border="0" valign="top"><tr>
<td valign="top"><!-- start main player area -->
<div id="vfnavig" class="vfround" style="padding-top:0px; margin-top:0px;">
<?php

// Write menu
if (is_array ($this->menu)){
foreach ($this->menu as $menu){
  echo $menu;
}
}
?>
</div>
 
<?php 
if (!empty($this->promptperm)) echo $this->promptperm;
if (isset($this->media)) echo $this->loadTemplate('media'); 
?>

<div class="mod_vflow"><?php echo $this->vflow8; ?></div>
<div id="vffooter">
</div>
</td> <!-- end main player area -->
<td valign="top"> <!-- start module position 2 -->
<?php echo $this->vflow2; ?>
</td> <!-- end module position 2 -->
</tr></table>
</div>
</td></tr></tbody></table>
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