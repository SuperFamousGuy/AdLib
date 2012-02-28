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



defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class VideoflowYoutubePlay {

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
    } else if (file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$media->title.'jpg')) {   
    $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->title.'jpg';
    } else {
    $pixlink = JURI::root().'components/com_videoflow/players/preview.jpg';
    }

    

    

    //Facebook embedcode - Embeds video on Facebook. Not required if you are not using the Facebook application



    $c = JRequest::getCmd('c');
    $frm = JRequest::getBool('iframe');

    if ((!$frm && $c == 'fb') || $env == 'fb') {

      if ($vparams->player == 'JW' && $vparams->jwforyoutube) {

      $vfplayer = JURI::root().'components/com_videoflow/players/player.swf';

      $embedcode = "file=$media->medialink&autostart=true&logo=$vparams->logo&image=$pixlink";

      } else {

      $vfplayer = 'http://www.youtube.com/v/'.$media->file.'&autoplay=1&fs=1';

      $embedcode = '';

      }

    return array('player'=>$vfplayer, 'flashvars'=>$embedcode);

    }

     

    

    

    /*

    * We use javascript to embed the YouTube player 

    */    



    $embedcode = "

      var flashvars =

      {

      };



      var params =

      {

        'allowscriptaccess':                     'always',
        
        'allowfullscreen':                        'true',

        'bgcolor':                               '#FFFFFF',

        'wmode':                                 'opaque'

      };



      var attributes =

      {

        'id':                                    'vf_fidsPlayer',

        'name':                                  'vf_fidsPlayer'

      };



      swfobject.embedSWF('http://www.youtube.com/v/$media->file?enablejsapi=1&playerapiid=vf_fidsPlayer&autoplay=1&modestbranding=1&fs=1', 'vfmediaspace', '$vparams->playerwidth', '$vparams->playerheight', '9', false, flashvars, params, attributes);

      ";



    

    // If you prefer, you could use the standard embed code commented out below

    

    /*

    $embedcode = "

    <object width='$vparams->playerwidth' height='$vparams->playerheight'>

    <param name='movie' value='http://www.youtube.com/v/$media->file&hl=en_US&fs=1&rel=1&autoplay=1'></param>

    <param name='allowFullScreen' value='true'></param>

    <param name='allowscriptaccess' value='always'></param>

    <embed src='http://www.youtube.com/v/$media->file&hl=en_US&fs=1&rel=1&autoplay=1' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='$vparams->playerwidth' height='$vparams->playerheight'></embed>

    </object>";

    */

    //End standard embed code;

    

    

    /*

    * The JW player is capable of playing youtube videos. 

    * If we have it installed and set as the Videoflow player, we may use it to play youtube

    * Note that we give the player the medialink, i.e the URL, as the filename    

    */    

    

    if ($vparams->player == "JW" && $vparams->jwforyoutube) {

    $vfplayer = JURI::root().'components/com_videoflow/players/player.swf';
    
    if (!empty ($vparams->flashhtml5)) {
    
    $embedcode = "
    
    jwplayer('vfmediaspace').setup({
	
        'flashplayer': 				 '$vfplayer',
        
        'file':                                  '$media->medialink',

        'title':                                 '$media->title',

        'image':                                 '$pixlink',

        'displayclick':                          'play',

        'controlbar':                            'bottom',

        'smoothing':                             'true',

        'repeat':                                'none',

        'stretching':                            'uniform',

        'id':                                    'vf_fidsPlayer',

        'autostart':                             'true',

        'skin':                                  '$vparams->skin',
        
        'width':                                 '$vparams->playerwidth',
        
        'height':                                '$vparams->playerheight',

        'logo':                                  '$vparams->logo',

        'dock':                                  'true'
    
    });";
    
    } else {

    $embedcode = "

      var flashvars =

      {

        'file':                                   encodeURIComponent('$media->medialink'),

        'title':                                 '$media->title',

        'image':                                 '$pixlink',

        'displayclick':                          'play',

        'controlbar':                            'bottom',

        'smoothing':                             'true',

        'repeat':                                'none',

        'stretching':                            'uniform',

        'id':                                    'vf_fidsPlayer',

        'autostart':                             'true',

        'skin':                                  '$vparams->skin',

        'logo':                                  '$vparams->logo',

        'dock':                                  'true'
        

      };



      var params =

      {

        'allowfullscreen':                       'true',

        'allowscriptaccess':                     'always',

        'bgcolor':                               '#FFFFFF',

        'wmode':                                 'opaque'

      };



      var attributes =

      {

        'id':                                    'vf_fidsPlayer',

        'name':                                  'vf_fidsPlayer'

      };



      swfobject.embedSWF('$vfplayer', 'vfmediaspace', '$vparams->playerwidth', '$vparams->playerheight', '9', false, flashvars, params, attributes);

      ";

      }
    }

    return $embedcode;

  }

}