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
global $vparams;
$xparams = &JComponentHelper::getParams( 'com_videoflow' );
$fileembed = (int) $xparams->get('enableembed', 1);
$newline = "\r"; 
$fileloc = 1;
$thumbloc = 1;

function xmlspecialchars($text) {
   return str_replace('&#039;', '&apos;', htmlspecialchars($text, ENT_QUOTES));
} 


if (!empty($this->media) && is_array ($this->media)){

//Initiate xml format
$xmldoc =& JFactory::getDocument();
$rawdoc = & JDocument::getInstance('raw');
$xmldoc = $rawdoc;
$xmldoc->setMimeEncoding( 'text/xml' );
Header("Content-type: text/xml; charset=UTF-8");
Header("Content-encoding: UTF-8");
$head = '<?xml version="1.0" encoding="UTF-8"?' . '>';
$head .= "\n" . '<?xml-stylesheet type="text/xsl" href="'.JURI::root().'components/com_videoflow/views/xml/tmpl/videoflow_xml.xsl"?' . '>';
$head .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:video="http://www.google.com/schemas/sitemap-video/1.0"' . '>';
echo $head;

//Initiate memory storage and retrieve videos
	  

foreach ($this->media as $vid) {

      // Set thumbnail link
      if (!empty($vid->pixlink)) {
         if (stripos($vid->pixlink, 'http://') === FALSE) {  
         $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->pixlink;
         }
       } else if (empty($vid->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$vid->title.'.jpg')){
       
       $vid->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$vid->title.'.jpg';
       
       } else {
      
      $vid->pixlink = JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/listview/default_thumbnail.gif';
      
      }
      
      $url = xmlspecialchars(JURI::root().'index.php?option=com_videoflow&task=play&id='.$vid->id);
      
      $vid->pixlink = xmlspecialchars($vid->pixlink);
      
      if (empty($vid->medialink) && $vid->server == 'local' && stripos($vid->file, 'http://') !== FALSE) {
         
         $vid->medialink = $vid->file;
      }
      
      if (!empty($vid->metaplay)) $vid->metaplay = xmlspecialchars($vid->metaplay);
      
      if (!empty($vid->medialink)) $vid->medialink = xmlspecialchars($vid->medialink);
      
	           
PRINT  
<<<VIDEO
{$newline}
<url>
   <loc>$url</loc>
   <video:video>
VIDEO;

if ($fileloc == 1 && $vid->server == 'local' && !empty($vid->medialink))
{
PRINT 
<<<FILELOC
{$newline}
      <video:content_loc>$vid->medialink</video:content_loc>
FILELOC;
}

if ($fileembed==1 && !empty($vid->metaplay)) 
{
PRINT 
<<<FILEEMBED
{$newline}
      <video:player_loc allow_embed="yes">$vid->metaplay</video:player_loc>
FILEEMBED;
}

PRINT 
<<<TITLE
{$newline}
      <video:title><![CDATA[$vid->title]]></video:title>
TITLE;

PRINT 
<<<DETAILS
{$newline}
      <video:description><![CDATA[$vid->details]]></video:description>
DETAILS;

if ($thumbloc==1)
{
PRINT 
<<<THUMB
{$newline}
      <video:thumbnail_loc>$vid->pixlink</video:thumbnail_loc>
THUMB;
}


PRINT
<<<ENDVIDEO
{$newline}
   </video:video>
</url>
ENDVIDEO;
}    

PRINT 
<<<FOOT
{$newline}
</urlset>
FOOT;
} 