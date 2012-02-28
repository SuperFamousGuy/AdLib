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


class VideoflowLocalPlay {

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
    
    //Set default preview image, correcting for earlier versions where files name was save as full URL
    //Correct for ealier versions that saved full image URL    
    if (!empty($media->pixlink)) {
       if (stripos($media->pixlink, 'http://') === FALSE) {  
         $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->pixlink;
         } else {
         $pixlink = $media->pixlink;
         }
      } else if (empty($media->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$media->title.'.jpg')){
       $pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->title.'.jpg';
      } else {     
      $pixlink = JURI::root().'components/com_videoflow/players/preview.jpg';
      }

    
    //Set media URL to full URL, excepting earlier versions where filename was saved as full URL 
    if ($media->server == 'local' && stripos($media->file, 'http://') === FALSE) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 
        $subdir = VideoflowFileManager::getFileInfo ($media->type);
        $media->file = JURI::root().$vparams->mediadir.'/'.$subdir['dir'].'/'.$media->file;
    }

        
    //Defile common flash variables
      $smoothing = 'smoothing';
      $plogo = $vparams->logo;
      $loading = '';
      $autoval = 1;
      $vfskin = 'vfskin';
    
    
    //Define NonverBlaster flash variables
  
      if ($vparams->player == 'nonverblaster'){
      $vfplayer = JURI::root().'components/com_videoflow/players/NonverBlaster.swf';
      $file = 'mediaURL';
      $image = 'teaserURL';
      $smoothing = 'allowSmoothing';
      $autostart = 'autoPlay';
      $vlogo = 'indentImageURL';
      $autoval = 'true';
      if ($media->type == 'mp3') $autoval = 'false';
      }
    
    //Define Neolao flash variables 
    
    if ($vparams->player == 'neolao') {
    $vfcon = mt_rand();
    $vfplayer = JURI::root().'components/com_videoflow/players/neolao.swf?v='.$vfcon;
    $file = 'flv';
    if ($media->type == 'mp3') {
    $vfplayer = JURI::root().'components/com_videoflow/players/neomp3.swf?v='.$vfcon;
    $file = 'mp3';
    }
    $image = 'startimage';
    $autostart = "autoplay";
    $loading = JText::_('Loading').'_n_';
    $vlogo = 'top1';
    $plogo = $vparams->logo.'|-15|15';  
    }
    
    //Define JW flash variables
    
    if ($vparams->player == 'JW') {
    $vfplayer = JURI::root().'components/com_videoflow/players/player.swf';
    $vfskin = 'skin';
    $file = 'file';
    $image = 'image';
    $autostart = 'autostart';
    $vlogo = 'logo';
    }
    
    //Facebook Embed Code    
    $c = JRequest::getCmd('c');
    $frm = JRequest::getBool('iframe');
    if ((!$frm && $c == 'fb') || $env == 'fb') {
    $embedcode = "$file=$media->file&width=$vparams->fbpwidth&height=$vparams->fbpheight&$autostart=$autoval&$image=$pixlink&$vlogo=$plogo&crop=false&controlColor=0x3fd2a3&controlBackColor=0x000000&id=$media->id";
    if ($media->type == 'swf') $vfplayer = $media->file;
    return array('player'=>$vfplayer, 'flashvars'=>$embedcode);
    }

        
    //Joomla Embed Code

    /*
    * Most flashvars are optional.
    * The only flashvar we must provide is "$file".  
    */
    
    if (!empty ($vparams->flashhtml5) && $vparams->player == 'JW') {
    $embedcode = "  
    jwplayer('vfmediaspace').setup({
	'flashplayer': 				 '$vfplayer',
	'$file':                                 '$media->file',
        'title':                                 '$media->title', 
        '$image':                                '$pixlink',
        'displayclick':                          'play',
        '$smoothing':                             'true',
        'repeat':                                'none',
        'stretching':                            'uniform',
        'controlbar':                            'bottom',
        'id':                                    'vf_fidsPlayer',
        '$autostart':                            '$autoval',
        'dock':                                  'true',
        '$vfskin':                               '$vparams->skin',
        'width':                                 '$vparams->playerwidth',
        'height':                                '$vparams->playerheight',
        'bgcolor':                               '000000',
        'bgcolor1':                              '000000',
        'bgcolor2':                              '000000',
        'margin':                                '5', 
        'showstop':                              '1',
        'showvolume':                            '1',
        'showtime':                              '2',
        'showfullscreen':                        '1', 
        'playertimeout':                         '3000',
        '$vlogo':                                '$plogo',
        'controlColor':                          '0x3fd2a3',
        'controlBackColor':                      '0x000000',
	'buffer':                                '4'
    });";
    } else {
    $embedcode = "
      var flashvars =
      {
        '$file':                                 encodeURIComponent('$media->file'),
        'title':                                 '$media->title', 
        '$image':                                '$pixlink',
        'displayclick':                          'play',
        '$smoothing':                             'true',
        'repeat':                                'none',
        'stretching':                            'uniform',
        'controlbar':                            'bottom',
        'id':                                    'vf_fidsPlayer',
        '$autostart':                            '$autoval',
        'dock':                                  'true',
        '$vfskin':                               '$vparams->skin',
        'width':                                 '$vparams->playerwidth',
        'height':                                '$vparams->playerheight',
        'bgcolor':                               '000000',
        'bgcolor1':                              '000000',
        'bgcolor2':                              '000000',
        'margin':                                '5', 
        'showstop':                              '1',
        'showvolume':                            '1',
        'showtime':                              '2',
        'showfullscreen':                        '1', 
        'playertimeout':                         '3000',
        'buffermessage':                         '$loading',
        'showiconplay':                          '1',
        '$vlogo':                                '$plogo',
        'controlColor':                          '0x3fd2a3',
        'controlBackColor':                      '0x000000',
        'scaleIfFullScreen':                     'true',
	'showScalingButton':                     'true',
	'showTimecode':                          'true',
	'crop':                                  'false',
	'buffer':                                '4'
      };

      var params =
      {
        'allowfullscreen':                       'true',
        'allowscriptaccess':                     'always',
        'bgcolor':                               '#000000',
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
      
      if ($media->type == 'swf') {

      $embedcode = "
      var flashvars =
      {};

      var params =
      {
        'allowscriptaccess':                     'always',
        'allowfullscreen':                       'true',
        'wmode':                                 'opaque'
      };

      var attributes =
      {
        'id':                                    'vf_fidsPlayer',
        'name':                                  'vf_fidsPlayer'
      };

      swfobject.embedSWF('$media->file', 'vfmediaspace', '$vparams->playerwidth', '$vparams->playerheight', '9', false, flashvars, params, attributes);
      ";

      }

        
  return $embedcode;
  }  
}