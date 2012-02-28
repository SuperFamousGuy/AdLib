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
//Get settings
global $vparams;

$context = JRequest::getCmd('c');
$media = $this->media;

//Load Stylesheet
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/views/videoflow/tmpl/css/lightbox_play.css';
if ($vparams->lightboxsys == 'multibox' && $context != 'fb') {
    $css2 = 'body {background-color: #000000 !important; color:#FFFFFF !important;}';
    $doc->addStyleDeclaration($css2);
}
$doc->addStyleSheet( $css, 'text/css', null, array() );
$xp = JRequest::getInt('xp');
$xparams = $this->getXparams();
if ($context == 'fb') {
$showshare = $vparams->fbshare;
} else {
$showshare = (bool) $xparams->get('showshare', $vparams->jshare);
}
$likecolour = (string) $xparams->get('likecolour', 'light');
if ($vparams->lightboxsys == 'multibox' && $context != 'fb') $likecolour = 'dark';
    
if (!empty($showshare)) {
$sharelink = JRoute::_(JURI::root().'index.php?option=com_videoflow&task=play&id='.$media->id);
$share = '<fb:like href="'.$sharelink.'" layout="standard" show_faces="false" colorscheme="'.$likecolour.'" width="300"></fb:like>';
} else {
$share = null;    
}

    if (stripos ($media->embedcode, 'swfobject.embedSWF') !== FALSE){
    $swfobject = JURI::root().'components/com_videoflow/jscript/swfobject.js';
    $doc->addScript($swfobject);
    $doc->addScriptDeclaration ("window.addEvent('domready', function(){ $media->embedcode })");
    $altcontent = '';
    } elseif (stripos ($media->embedcode, "jwplayer('vfmediaspace').setup") !== FALSE){
    $jwjs = JURI::root().'components/com_videoflow/jscript/jwplayer.js';
    $doc->addScript($jwjs);
    $doc->addScriptDeclaration ("window.addEvent('domready', function(){ $media->embedcode })");
    $altcontent = '';
    } else {
     $altcontent = $media->embedcode;
    }

// Load VOTItaly Rating System

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
    
if ($vparams->playall && $vparams->prostatus) {
$vfbox = "
  var vf_player;
  var vfState = 'fideri';
  
  function computeEnd(){
			myVfbox(0);
			}
			
  function playerReady(obj) {
	vf_player = document.getElementById('vf_fidsPlayer');
  vf_player.addModelListener('STATE', 'myVfbox');
  };
  
  function onYouTubePlayerReady(obj) {
  vf_player = document.getElementById ('vf_fidsPlayer');
  vf_player.addEventListener('onStateChange', 'myVfbox');
  }
  
  function yReady(obj) {
  alert('Yready!');
  vf_player = document.getElementById ('vf_fidsPlayer');
  vf_player.addEventListener('StateChange', 'myVfbox');
  }
  
  function onDailymotionPlayerReady(obj){
  vf_player = document.getElementById ('vf_fidsPlayer');
  vf_player.addEventListener('onStateChange', 'myVfbox');
  }
  
  function myVfbox(obj){
  var	currentState = obj.newstate; 
  var vfState = obj;
    if (currentState === 'COMPLETED' || vfState === 0){
    parent.document.getElementById('MultiBoxNext').fireEvent('dblclick');
    }
  }
"; 

  if (empty($xp)) {
  $doc->addScriptDeclaration ($vfbox);		   
  }
}   
}         



?>
<div id="vf_multibox" style="z-index:10; overflow:hidden;">
<table class="vftable">
<tbody>
<tr><td align="center">
<div id="vfmediaspace" style="min-height:<?php echo $vparams->playerheight.'px'; ?>; z-index:100;"><?php echo $altcontent; ?></div>
</td></tr>
<tr><td>
<div class="mod_vfshare"><?php echo $share; ?></div>
<?php if ($vparams->ratings) echo '<div class="vf_rating">'.$this->rating.'</div>'; ?>
</td></tr>
<tr><td align="center">
<div id="mod_vflow5" style="max-width:<?php echo $vparams->playerwidth.'px'; ?>;"><?php echo $this->vflow5; ?></div>
</td></tr>
</tbody>
</table>
</div>