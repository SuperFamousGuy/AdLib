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

jimport( 'joomla.application.component.view');
 
class VideoflowViewXML extends JView
{

  function __construct()
    {
      parent::__construct();
               
      global $vparams;  
    }


    
    function display()
    {
        global $vparams;
        $xparams = &JComponentHelper::getParams( 'com_videoflow' );
        $listorder = (string) $xparams->get('listorder', 'latest');
        JRequest::setVar('task', $listorder);

        $model =& $this->getModel();
        $model-> setState('limit', 0);
        $vlist = $model->getData ();
        if (!empty($vlist)) {
        foreach ($vlist as $media){
        $metaplay = $model->_buildCode($media, 'fb');
        if (!empty($metaplay) && is_array($metaplay)) {
         if (stripos($metaplay['player'], '?') === false) $q = '?'; else $q = '&';
         $media->metaplay = $metaplay['player'].$q.ltrim($metaplay['flashvars'], '&').'&width=470&height=265';
        }
  
        if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') $media->metaplay = false;
        }
        }
        $this->assignRef ('media', $vlist);
        parent::display();
    }
}