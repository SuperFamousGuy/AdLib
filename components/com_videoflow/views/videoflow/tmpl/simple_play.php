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
 
defined( '_JEXEC' ) or die( 'Restricted access' );
global $vparams, $fxparams;
$doc = &JFactory::getDocument();
$vfslide = "
     var vfshare_display = function(vf){
        if ($(vf).style.display == 'none'){
        $(vf).style.display = 'block';
        } else {
        $(vf).style.display = 'none';
        }      
     }
";
$doc->addScriptDeclaration($vfslide);
$context = JRequest::getCmd('c');
$varext = '';

if ($context == 'fb') {
$xparams = $fxparams;
$target = 'target="_parent"';
} else {
$xparams = $this->getXparams();
$target = '';
}
if ($context == 'fb') {
$showuser = $vparams->fbshowuser;
$showcat = $vparams->fbshowcategory;
$showdate = $vparams->fbshowdate;
$showviews = $vparams->fbshowviews;
$showrating = $vparams->fbshowrating;
$showplaylistcount = $vparams->fbshowplaylists;
$showlike = $vparams->likebutton;
$showadd = $vparams->fbshowmylist;
//$showshare = $vparams->fbshare;
} else {
$showadd = (bool) $xparams->get('showadd', $vparams->showadd);
$showuser = (bool) $xparams->get('showuser', $vparams->showuser);
$showcat = (bool) $xparams->get('showcat', $vparams->showcat);
$showviews = (bool) $xparams->get('showviews', $vparams->showviews);
$showrating = (bool) $xparams->get('showrating', $vparams->showrating);
$showdate = (bool) $xparams->get('showdate', $vparams->showdate);
$showplaylistcount = (bool) $xparams->get('showplaylistcount', $vparams->showplaylistcount);
$showlike = (bool) $xparams->get('likebutton', $vparams->likebutton);
//$showshare = $vparams->jshare;
}
$showvotes = (bool) $xparams->get('showvotes', $vparams->showvotes);
$showdownloads = (bool) $xparams->get ('showdownloads', $vparams->showdownloads);
$likelayout = (string) $xparams->get('likelayout', 'standard');
$likecolour = (string) $xparams->get('likecolour', 'light');
$likefaces = (bool) $xparams->get('likefaces', true);
$iborderc = (string) $xparams->get('iborderc');
$bgactive = (string) $xparams->get('bgactive');
$bginactive = (string) $xparams->get('bginactive');
$iborders = (int) $xparams->get('iborders', 4);
$borders = (int) $xparams->get('borders', 1);
$playerwidth = (int) $xparams->get('playerwidth', $vparams->playerwidth);
$playerheight = (int) $xparams->get('playerwidth', $vparams->playerheight);
if (!empty($showlike)) {
$sharelink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task=play&id='.$this->media->id);
$share = '<fb:like href="'.$sharelink.'" layout="button_count" show_faces="false" colorscheme="'.$likecolour.'"></fb:like>';
} else {
$share = null;    
}
$slist = (bool) $xparams->get('slist', 1);
$flowid = JRequest::getInt('Itemid');
if (!empty($flowid)) $flowid = '&Itemid='.$flowid; else $flowid = '';
$type = JRequest::getVar('type');
if (!empty($type)) $type = '&type='.$type; else $type = '';
$tmpl = JRequest::getCmd('tmpl');
if (!empty($tmpl)) $tmpl = '&tmpl='.$tmpl; else $tmpl = '';
$fb = JRequest::getCmd('c');
if ($fb == 'fb') $fb = '&c=fb'; else $fb = ''; 
$frm = JRequest::getBool('fb_sig_in_iframe');
if ($frm) $frm = '&fb_sig_in_iframe=1'; else $frm = '';
$lo = JRequest::getCmd('layout');
//if (empty($lo) && !empty($fb)) $lo = $vparams->ftemplate;
if (!empty($lo) && $context != 'fb') $lo = '&layout='.$lo; else $lo = '';
$ls = JRequest::getInt ('limitstart', null);
    if ($ls > 0) $ls = '&limitstart='.$ls;
$cid = JRequest::getInt('cid');
  if (!empty($cid)) $cid = '&cid='.$cid; else $cid = '';
$vtask = JRequest::getCmd('task', 'play');
if ($vparams->lightboxfull) $xp = '&xp=1'; else $xp = '';
$list = JRequest::getWord('list');
if (!empty($list)) $list = '&list='.$list; else $list = '';
$catid = null;
if ($vtask == 'cats'){
$catid = JRequest::getInt('cat');
$catid = '&cat='.$catid;
}
if ($vtask == 'search') {
    $searchword = JRequest::getString('searchword');
    if (!empty($searchword)) $varext .= '&searchword='.$searchword;
}
if ($context == 'fb') {
    
} else {
    
}

if (!empty ($this->media)) {
    $media = $this->media;
    //Load the layout stylesheet
    $doc = &JFactory::getDocument();

    //Check is we are using swfobject to load the player. This is the preferred method.

    if (stripos ($media->embedcode, 'swfobject.embedSWF') !== FALSE){
    
    //Load swfobject javascript file
    $swfobject = JURI::root().'components/com_videoflow/jscript/swfobject.js';
    $doc->addScript($swfobject);
    
    //Load the player using swfobject
    $doc->addScriptDeclaration ("window.addEvent('domready', function(){ $media->embedcode })");
    $altcontent = '';
    } elseif (stripos ($media->embedcode, "jwplayer('vfmediaspace').setup") !== FALSE){
    //If using JW custom JS
    $jwjs = JURI::root().'components/com_videoflow/jscript/jwplayer.js';
    $doc->addScript($jwjs);

    $doc->addScriptDeclaration ("window.addEvent('domready', function(){ $media->embedcode })");
    $altcontent = '';
    } else {
    //If using the standard embed method, replace alternative content with the player
     $altcontent = $media->embedcode;
    }


    //Load VOTItaly rating system
    if ($vparams -> ratings) {
          
    // Load rating CSS
    $ratingcss = JURI::root().'components/com_videoflow/extra/votitaly/css/votitaly.css';
    $doc->addStyleSheet( $ratingcss, 'text/css', null, array() );
    
    //Initialise VOTItaly script
    $vratings ='
    '."
	   window.addEvent('domready', function(){
	     var vf_rate = new VotitalyPlugin({
	  	    submiturl: '".JURI::base()."index.php?option=com_videoflow&task=vote&format=raw',
		      loadingimg: '".JURI::base()."components/com_videoflow/extra/votitaly/images/loading.gif',
			    show_stars: ".($vparams->showstars ? 'true' : 'false').",
			    star_description: '".addslashes($vparams->stardesc)."',		
			    language: {
				  updating: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_UPDATING'))."',
				  thanks: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_THANKS'))."',
				  already_vote: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_ALREADY_VOTED'))."',
				  votes: '".addslashes(JText::_( 'COM_VIDEOFLOW_VOTES'))."',
				  vote: '".addslashes(JText::_( 'COM_VIDEOFLOW_VOTE'))."',
				  average: '".addslashes(JText::_( 'COM_VIDEOFLOW_AVERAGE'))."',
				  outof: '".addslashes(JText::_( 'COM_VIDEOFLOW_TOTAL_SCORE'))."',
				  error1: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_ERR'))."',
				  error2: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_ALREADY_VOTED'))."',
				  error3: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_RANGE'))."',
				  error4: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_LOGIN'))."',
				  error5: '".addslashes(JText::_( 'COM_VIDEOFLOW_RATE_ALREADY_SUBMITTED'))."'
			    }
	       });
	     });
      ".'
    ';
    $doc->addScriptDeclaration ($vratings);		          

// Load rating js file
    if (!empty($vparams->ratinglegacy)) {
    $ratingjs = JURI::root().'components/com_videoflow/extra/votitaly/js/votitaly_legacy.js';
    } else {
    $ratingjs = JURI::root().'components/com_videoflow/extra/votitaly/js/votitaly.js';
    }
    $doc->addScript ($ratingjs);
  }          

  //Default thumbnail
  if (empty($media->pixlink)) $media->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';

    
?>
<!-- START ITEM BOX -->
<table class="vftable" cellspacing="0" cellpadding="0" border="0" style="margin: 0px auto; vertical-align: top;"><tr><td>
<div class="vfsimpleplay"> 
<table style="margin-right:auto; margin-left:auto;" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top">
<div style = "margin-left:0px;">
<div>
<table name="player_AND_comments_and_mods_2_4_6" cellspacing="0" cellpadding="0" style="margin-right:10px; width:<?php echo $vparams->playerwidth.'px';?>">
<tbody>
<?php
if (!empty($this->vflow3)) { 
echo '<tr><td name="vmodule2" valign="top"><div style="margin-bottom:8px;">'.$this->vflow3.'</div></td></tr>';
}
?>
<tr><td name="player_title" valign="top"><div id="vfmediatitle" class="vf_fbtheme" style="background-color:<?php echo $bgactive; ?>; border-color:<?php echo $iborderc; ?>"><?php echo stripslashes ($media->title); ?></div></td></tr>
<tr><td name="player" valign="top" align="center" style="text-align: center;"><div id="vfmediaspace" style="min-height:<?php echo $vparams->playerheight.'px'; ?>;"><?php echo $altcontent; ?></div></td></tr>
<tr><td name="vf_share" valign="top">
<div style="width:<?php echo $vparams->playerwidth;?>px; margin:auto;">
<?php
if ($showlike){
echo '<div class="mod_vfshare">'.$share.'</div>';
}
if (!empty($this->rating)) echo '<div class="vf_rating">'.$this->rating.'</div>'; 
?>
</div>
</td></tr>
<?php
if (is_array($this->tools) && (!empty($this->tools))){ 
echo '<tr><td class="vf_fbtheme" style="text-align:center; background-color:'.$bgactive.'; border-color:'.$iborderc.'">';
echo '<table style="width: auto; margin:auto"><tr><td style="padding-top:4px;"><font class="vflist6">';
  foreach ($this->tools as $key=>$value){
  echo '<div class="vf_tools"><img class="vf_tools_icons" src="'.
  JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.
  $vparams->toolcolour.'/'.$key.'.gif" />'.$value.'</div>';
  }
echo '</font></td></tr></table>';
if (!empty($vparams->showshare)) { 
echo '<table style="margin:auto;"><tr><td>';
echo '<div class="vfinfofx" style="border: none;">';
echo '<div id="vfshare" style="display:none; text-align:center;">'.$this->vfshare.'</div>';
echo '</div>';
echo '</td></tr></table>';
}
echo '</td></tr>';
}
?>

<tr><td><div style="margin: 12px 0px; text-align:left;"><?php echo $media->details; ?></div></td></tr>
<tr><td>
<table align="center" style="margin-bottom:0px;"cellspacing="0" cellpadding="0" border="0" valign="middle" width="100%">
<tr>
<td valign="top">

<div style="width:100%; clear:both; margin-bottom:8px;">
<table class="vfmedinfo">
<tr>
<?php
echo '<td>';
if ($showuser){
echo '<div class="vfinfolist">'.JText::_('COM_VIDEOFLOW_TUSER').' <a href="'.$this->doRoute('&task=visit&cid='.$media->userid.$lo).'" $target>'.$media->shortname.'</a></div>';
}
echo '</td><td>';
if ($showdate){
echo '<div class="vfinfolist">'.JText::_('COM_VIDEOFLOW_TDATE').' '.date_format(date_create($media->dateadded), 'Y - m - d').'</div>';
}
echo '</td><td>';
if ($showcat){
echo '<div class="vfinfolist">'.JText::_('COM_VIDEOFLOW_TCAT').'<a href="'.$vparams->canvasurl.'&task=cats&cat='.$media->cat.'&vf=1"> '.JText::_($media->catname).'</a></div>';
}
echo '</td>';
?>
</tr><tr>
<?php
echo '<td>';
if ($showviews){
echo '<div class="vfinfolist">'.JText::_('COM_VIDEOFLOW_TVIEWS').' '.$media->views.'</div>';
}
echo '</td><td>';
if ($vparams->showpro && $showplaylistcount){
echo '<div class="vfinfolist">'. JText::_('COM_VIDEOFLOW_TPLAYLISTS').' '. $media->favoured.'</div>';
}
echo '</td><td>';
if ($showdownloads){
echo '<div class="vfinfolist">'.JText::_('COM_VIDEOFLOW_TDOWNLOADS').' '.$media->downloads.'</div>';
}
echo '</td>';
?>
</tr>
</table>
</div>
<?php
echo '<div style="clear:both;">';
if (!empty($this->comments)) echo $this->comments;
echo '</div>';
?>
</td>
</tr>
</table>

</td></tr>



<tr><td name="vmodule4" valign="top"><?php echo $this->vflow5; ?></td></tr>
<tr><td name="vmodule6" valign="top"><?php echo $this->vflow6; ?></td></tr>
</tbody>
</table>
</div>
</div>
</td>
<?php
if ($slist) {
echo '<td style="vertical-align:top;">';
  $mboxs = 1;
  $mbox = 1;
  $mboxxs = 1000;
  if (!empty($this->tabone)) $tabone = $this->tabone; else $tabone = array();
  if (!empty($this->vlist)) $dcount = count($this->vlist); else $dcount = 0;
  if (!empty($this->tabone)) {
    //Determine lightbox popup height. Additionally controlled through css
    $vboxheight = $vparams->lplayerheight + $vparams->lboxh;
    $vboxwidth = $vparams->lplayerwidth + $vparams->lboxw;
    if ($vparams->ratings || (!empty($this->vfshare))) $vboxheight = $vboxheight + 30;
    if (!empty($this->vflow8)) $vboxheight = $vboxheight + 78;
    $swidth = $vparams->thumbwidth + 14;
    echo '<div class="vf_sidelist" style="width:'.$swidth.'px; border-color:'.$iborderc.'; background-color:'.$bgactive.'"><table style="margin:auto;">';
    echo '<tr><td align="center"><div class="vf_rlabel">'.JText::_('COM_VIDEOFLOW_RELATED_MEDIA').'<div></td></tr>';
    foreach ($this->tabone as $rmedia) {    
     
      if ($rmedia->type == 'jpg' || $rmedia->type == 'png' || $rmedia->type == 'gif') {
        if (empty($rmedia->pixlink) && !file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$rmedia->title.'.jpg')) {
            $rmedia->pixlink = $this->imgResize($rmedia, 'thumb');
        }
      }
     
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

  
        // Set thumbnail and title link format for "MultiBox" lightbox system
      if ($vparams->lightbox && ($vparams->lightboxsys=='multibox')){
      $rthumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$rmedia->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mbox'.$mbox.'" class="vf_mbox" title="'.stripslashes($rmedia->title).'">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" class="vf_img" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$rpixlink.'"/>
                   <div class="vflowBoxDesc vf_mbox'.$mbox.'"></div> </a>';
      $rtitlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$rmedia->id.$xp).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_mboxx'.$mbox.'" class="vf_mboxx" title="'.stripslashes($rmedia->title).'">'.stripslashes($rmedia->stitle).'
                   <div class="vflowTboxDesc vf_mboxx'.$mbox.'"></div> </a>';
           if ($rmedia->type == 'jpg' || $rmedia->type == 'png' || $rmedia->type == 'gif') {
           $rmedia->medialink = $this->imgResize($rmedia, 'pix');
	   if (empty($rmedia->medialink)) $rmedia->medialink = JURI::root().$vparams->mediadir.'/photos/'.$rmedia->file;
           
	   $rthumblink = '<a href="'.$rmedia->medialink.'" id="vf_mboxs'.$mboxs.'" class="vf_mboxs" title="'.stripslashes($rmedia->title).'">
                   <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$rpixlink.'"/>
                   <div class="vflowBoxDesc vf_mboxs'.$mboxs.'"></div> </a>'; 
           $rtitlelink = '<a href="'.$rmedia->medialink.'" id="vf_mboxxs'.$mboxxs.'" class="vf_mboxxs" title="'.stripslashes($rmedia->title).'">'.stripslashes($rmedia->stitle).'
                   <div class="vflowTboxDesc vf_mboxxs'.$mboxxs.'"></div></a>'; 
          }
          if (!$vparams->lightboxfull){
          $rtitlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$rmedia->id.$cid.$catid.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($rmedia->stitle).'</a>';
	  }          
      } //End MultiBox link settings
      
      //Set thumbnail and title link formats for Joomla lightbox system
      elseif ($vparams->lightbox && ($vparams->lightboxsys == 'joomlabox')){
      $rthumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$rmedia->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$rpixlink.'"/></a>';
      $rtitlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$rmedia->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($rmedia->stitle).'</a>';
           if ($rmedia->type == 'jpg' || $rmedia->type == 'png' || $rmedia->type == 'gif') {
           $rmedia->medialink = $this->imgResize($rmedia, 'pix');
           if (empty($rmedia->medialink)) $rmedia->medialink = JURI::root().$vparams->mediadir.'/photos/'.$rmedia->file;
           $rthumblink = '<a href="'.$rmedia->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">
                   <img width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$rmedia->pixlink.'"/></a>'; 
          
           $rtitlelink = '<a href="'.$rmedia->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">'.stripslashes($rmedia->title).'</a>';
          }
          if (!$vparams->lightboxfull){
            $rtitlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$rmedia->id.$cid.$catid.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($rmedia->stitle).'</a>';

       //   $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task='.$stask.'&id='.$vid->id.$sl.$ls.$flowid.$tmpl.'&layout=simple').'">'.stripslashes($vid->title).'</a>';
	  }    
      } // End Joomla lightbox thumbnail links
      
      // Set default thumbnail and title link formats - no lightbox effect
      
      else {
      
       $rthumblink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$rmedia->id.$cid.$catid.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>
                    <img class="vf_img" width="'.$vparams->thumbwidth.'" height="'.$vparams->thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$rpixlink.'"/></a>';      
      
      $rtitlelink = '<a href="'.$this->doRoute('&task='.$vtask.'&id='.$rmedia->id.$cid.$catid.$ls.$type.$flowid.$list.$lo.$varext).'" '.$target.'>'.stripslashes($rmedia->stitle).'</a>';
    
    } //End default thumbnail and title links
/*****************************************************************************/
// You may edit the parts below to suit your needs. The corresponding css file is css/simple.css
 
  
  
    echo '<tr><td>';
    echo '<div style="width:100%">'.$rthumblink.'</div>';
    echo '<div style="width:100%; padding: 2px 2px 4px 2px;">'.$rtitlelink.'</div>';
    echo '</td></tr>';
    $mboxs++;
    $mboxxs++;
    }
  echo '</table></div>';
  }
  echo '</td>';
// Initialise MultiBox
if ($vparams->lightbox && ($vparams->lightboxsys == 'multibox') ) {
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
			
			
			var vfmboxs = {};
			window.addEvent('domready', function(){
				vfmboxs = new MultiBox('vf_mboxs', {descClassName: 'vflowBoxDesc', useOverlay: <?php echo $this->vlay; ?>, multiCount: true, offset: {x:0, y:<?php echo $offsety; ?>}, MbOffset: <?php echo $this->mboffset; ?> });
			});
				
			var vfmboxxs = {};
			window.addEvent('domready', function(){
				vfmboxxs = new MultiBox('vf_mboxxs', {descClassName: 'vflowTboxDesc', useOverlay: <?php echo $this->vlay; ?>, offset: {x:0, y:<?php echo $offsety; ?>}, MbOffset: <?php echo $this->mboffset; ?>});
			});
	
</script> <?php
}

?>
</tr>
</tbody>
</table>
</div>
</td></tr></table>
<div class="vf_hsolid_line"></div>
<?php
}
}