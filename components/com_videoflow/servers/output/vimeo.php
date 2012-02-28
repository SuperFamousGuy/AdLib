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

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class VideoflowVimeoPlay {

    /**
     * Generates embed codes needed to playback media    
     *      
     */

	
  //Build embed code; 
  
  function buildEmbedcode ($media, $env = null) {
    global $vparams;
    
    //Player size in lightbox popup. Normally bigger than default size.
    
    $layout = JRequest::getString('layout');
    if ($layout == 'lightbox'){
    $vparams->playerheight = $vparams->lplayerheight;
    $vparams->playerwidth = $vparams->lplayerwidth;
    }

    
    //Set set a default preview image, if there is none associated with current media file
    if (!empty($media->pixlink)) {
    $pixlink = $media->pixlink;
    } else {   
    $pixlink = JURI::root().'components/com_videoflow/players/preview.jpg';
    }
    
    
    //Facebook embedcode - Embeds video on Facebook. Not required if you are not using the Facebook application

    $c = JRequest::getCmd('c');
    $frm = JRequest::getBool('iframe');
    if ((!$frm && $c == 'fb') || $env == 'fb') {
      $vfplayer = 'http://vimeo.com/moogaloop.swf?clip_id='.$media->file.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=1&amp;loop=0;';
      $embedcode = '';
    return array('player'=>$vfplayer, 'flashvars'=>$embedcode);
    }
   // Standard embed code
    $embedcode = '<iframe src="http://player.vimeo.com/video/'.$media->file.'?portrait=0&amp;title=0&amp;byline=0&amp;color=97b8c7&amp;autoplay=1" width="'.$vparams->playerwidth.'" height="'.$vparams->playerheight.'" frameborder="0"></iframe>';
    return $embedcode;
  }
}