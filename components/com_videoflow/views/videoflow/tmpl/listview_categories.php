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

global $vparams, $fxparams;
$context = JRequest::getCmd('c');
$xparams = $this->getXparams();
$ajaxmode = (int) $xparams->get('ajaxmode', 1);
$tmplname = JRequest::getCmd('layout');
if (empty($tmplname)) $tmplname = (string) $xparams->get('tmplname', $vparams->jtemplate);
if (empty($tmplname)) $tmplname = 'listview';
$Itemid = JRequest::getInt('Itemid', $vparams->flowid);
if (empty($Itemid)) $Itemid = ''; else $Itemid = '&Itemid='.$Itemid;
$activeborderc = strtolower((string) $xparams->get('activeborderc', '#E3EBFF'));
$inactiveborderc = strtolower((string) $xparams->get('inactiveborderc', '#000000'));
$fontcolor = (string) $xparams->get('fontcolor');
$vfbgcolor = (string) $xparams->get('vfbgcolor');
$jeffectsclass = (string) $xparams->get('jeffectsclass', '');
$jeffects = (string) $xparams->get('jeffects', '');
$iborders = (int) $xparams->get('iborders', 4);
$borders = (int) $xparams->get('borders', 1);
if (!empty($jeffects)) $iborders = 0;
$showviews = (bool) $xparams->get('showviews', 1);
$showdate = (bool) $xparams->get('showdate', 1);


$vtask = JRequest::getCmd('task');
if ($vtask == 'mysubs') {
$this->data = $this->tabone;
}

//Load template stylesheet
if ($context == 'fb') $cssfile = $tmplname.'_fb'; else $cssfile = $tmplname;
$doc = &JFactory::getDocument();

if (file_exists(JPATH_COMPONENT.'/views/videoflow/tmpl/css/'.$cssfile.'.css')) {
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/'.$cssfile.'.css';
} else {
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/listview.css';
}
$doc->addStyleSheet( $css, 'text/css', null, array() );

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
if ($context == 'fb') $target = 'target="_parent"'; else $target = null;

/**************************************************************************/

/* 
* You may edit some parts below
*/ 


?>
<table class="vftable">
<tbody>
<tr><td valign="top">
<div id="vfwrapper" style="background-color:<?php echo $vfbgcolor; ?>; color:<?php echo $fontcolor; ?>;">
<div class="vf_defpadding">
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody>
<tr><td valign="top">

<!-- START TOP SECTION --> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" valign="top">
<tbody><tr> <td>
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
</td></tr>
<?php
     $fbuser = JRequest::getVar ('fbuser');
     if ($fbuser || $this->vflow1) {
      echo '<tr><td>';
     echo '<div style="position:relative; height:62px; padding-bottom:10px;">'; // Start top banner division
                      ?>        
                      <div class="vf_fbtheme" style="position:absolute; left:0px; top: 24px; height:20px; width:100%; background-color:<?php echo $bgactive;?>; border-color: <?php echo $iborderc; ?>"></div>
                      <?php echo '<table style="margin:auto; width:100%; height:62px;"><tr>'; ?>
                      <td>
                        <table style="margin:auto;">
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
 ?>

</tbody>
</table>

<!-- END TOP SECTION -->

<?php

/*************** IT IS NOT NECESSARY TO CHANGE THIS PART ****************
**************** BE CAREFUL IF YOU CHOOSE TO MODIFY IT ******************/

if (!empty($this->data) && is_array ($this->data)){
  foreach ($this->data as $data){
      if (empty($data->pixlink)) $data->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/playerview/default_thumbnail.gif';
      if ($vtask == 'mysubs'){
      $data->desc = '';
      if ($showviews) {
      $data->desc .= '<div class="vf_sstats">'.JText::_('COM_VIDEOFLOW_TVISITORS').' '.$data->visitors.'</div>';
      $data->desc .= '<div class="vf_sstats">'.JText::_('COM_VIDEOFLOW_TSUBSCRIBERS').' '.$data->subscribers.'</div>';
      }
      if ($showdate) $data->desc .= '<div class="vf_sstats">'.JText::_('COM_VIDEOFLOW_TJOIN_DATE').' '.$data->join_date.'</div>';
      $thumblink = '<a href="'.$this->doRoute ('&task=visit&cid='.$data->joomla_id.'&layout='.$tmplname.$Itemid).'" '.$target.'>
                    <img class="vf_img '.$jeffectsclass.'" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$data->pixlink.'"/></a>';      
      $titlelink = '<a href="'.$this->doRoute ('&task=visit&cid='.$data->joomla_id.'&layout='.$tmplname.$Itemid).'" '.$target.'>'.$this->escape($data->title).'</a>';
      } else {
      $thumblink = '<a href="'.$this->doRoute ('&task=cats&cat='.$data->id.'&sl=categories&layout='.$tmplname.$Itemid).'" '.$target.'>
                    <img class="vf_img '.$jeffectsclass.'" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$data->pixlink.'"/></a>';      
      $titlelink = '<a href="'.$this->doRoute ('&task=cats&cat='.$data->id.'&sl=categories&layout='.$tmplname.$Itemid).'" '.$target.'>'.$this->escape($data->name).'</a>';
      }

       //End default thumbnail and title links

/*****************************************************************************/

// You may edit the parts below to suit your needs. The corresponding css file is css/listview.css
      
?>
<div class="vfbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td width="12"/></td>
<td width="<?php echo $vparams->thumbwidth + 18; ?>" valign="top">
<div style="position: relative;">
<?php echo $thumblink; ?>
</div>
</td>
<td valign="top">
<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px; padding-left:10px; padding-right:10px;">
<tbody>
<tr>
<td valign="top" height="20" style="padding-top: 3px; text-align:left;">
<span class="vftitle" style="padding-left:0px;">
<?php echo $titlelink; ?>
</span>
</td>
</tr>
<tr>
<td height="4">
</td>
</tr>
<tr>
<td valign="top" style="text-align:left;">
<div class="vflist3">
<?php echo nl2br($data->desc); ?>
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="vflist8">
<div class="vf_hsolid_line vf_borderc">
</div>
</div>
</div>
<?php
}
}

?>
</td>
<td class="vfaligntop"><div id="mod_vflow2"><?php echo $this->vflow2; ?></div></td>
</tr></tbody></table>
<div id="vffooter" style="text-align:center;">
<?php
if (!empty($this->pagination)){
echo $this->pagination->getPagesLinks();
echo '&nbsp;&nbsp;';
echo $this->pagination->getPagesCounter();
}
?>
</div>
</div>
</div>
</td></tr></tbody></table>

<?php
if ($context == 'fb') {
  $canvasheight = (int) $fxparams->get('canvasheight');
  if(!empty($canvasheight)) $canvasfix = '{height: "'.$canvasheight.'px"}'; else $canvasfix = 250;
  jimport('joomla.environment.browser');
  $jbrowser = & JBrowser::getInstance();
  $browser = $jbrowser->getBrowser();
  $canvas = '<script>
            window.fbAsyncInit = function() {';
            if ($browser == 'msie' && empty ($canvasheight)) {
            $canvas .= ' FB.Canvas.setAutoResize();';
            }
            $canvas .= ' FB.XFBML.parse();
            FB.Canvas.setSize('.$canvasfix.'); 
            }
            </script>';
  echo $canvas;
}