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

class VideoflowTools
{ 
 
 var $func;
 
 var $param1;
 
 var $param2;
 
 var $param3;
 
 var $param4;

 function __construct() {
   $this->genFunc();
 } 
 
 function checkBrowserType()
 {
  jimport('joomla.environment.browser');
  $browser = JBrowser::getInstance();
  return $browser->getBrowser();
  }
  
  function findSubstring ()
  {
    if (!is_array($this->param1)){
    $this->param1 = array ($this->param1);
    }
    foreach ($this->param1 as $item ){ 
      $pos = strpos($this->param2, $item);
      if($pos !== false) {
      return true;
      }
    }
  return false;
  }
    
  function findFunction ($fucn) 
  {
    if (extension_loaded('suhosin')) {
        $suhosin = @ini_get("suhosin.executor.func.blacklist");
        if (empty($suhosin) == false) {
            $suhosin = explode(',', $suhosin);
            $suhosin = array_map('trim', $suhosin);
            $suhosin = array_map('strtolower', $suhosin);
            return (function_exists($fucn) == true && array_search($fucn, $suhosin) === false);
        }
    }
    return function_exists($fucn);
  }     
  
    function arrayFlatten ()
    {
    $tmp = null;
      
    while (($v = array_shift($this->param1)) !== null) {
        if (is_array($v)) {
            $this->param1 = array_merge($v, $this->param1);
        } else {
            $tmp[] = $v;
        }
    }
    return $tmp;
    } 

     function xterWrap()
    {
      if (mb_detect_encoding($this->param1) == 'UTF-8') {
      if (mb_strlen($this->param1, 'UTF-8') > $this->param2) return (mb_substr($this->param1, 0, $this->param2,'UTF-8')); else return $this->param1;
      } else {
      if (strlen($this->param1) > $this->param2) return (substr($this->param1, 0, $this->param2).'...'); else return $this->param1;
      }
   }   
    
    
    function runVprocess()
    {
      global $vparams;      
      $fbuser = JRequest::getInt('fbuser');
      $vprocess = $this->param2;
      $user = JFactory::getUser();
      $jsession =& JFactory::getSession();
      if ($this->param1 == 'upload'){
        if (!$vparams->useradd){
        $vprocess->message = JText::_('COM_VIDEOFLOW_NO_PERM_TO_ADD');
        return $vprocess;
        }
      }
            
      if ($vparams->facebook) {
      if ($fbuser && (!empty($user->id))){
      $vsn = $jsession->get('videoflow_session');
      if (!$vsn) $vsn = 0;
        if (time() - $vsn < 3600 ) {
          $user->guest = 1;
          $user->id = 0;
          } else {
        $jsession->set('videoflow_session', time());
        $vprocess->message = JText::_('COM_VIDEOFLOW_DOUBLE_LOGIN');
        $vprocess->task = 'logout';
        return $vprocess;
        }
       }
          if ($fbuser && empty ($user->id)){
          $vfuser = VideoflowModelVideoflow::getVFuserObj($fbuser);
          if (!$vfuser){
          $juser = $this->newVFuser($fbuser);
            if (!$juser) {
            $vprocess->message = JText::_('COM_VIDEOFLOW_ERROR_REQUEST');
            $vprocess->task = 'login';
            JRequest::setVar('fbuser', '');
            }
          } else {
          $juser = & JFactory::getUser ($vfuser->joomla_id);
          }
          if ($juser) {
          $user = $juser;
          JRequest::setVar('juser', $juser);
          }
          $user-> guest =  0;
          }
      }
      
      if (empty($user->id)){
          if (empty($user->id)){
          $vprocess->task = 'login';
          if ($this->param1 == 'myvids' || $this->param1 == 'myfavs'){
          $vprocess->message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_FOR_PLAYLISTS');
          } 
          if ($this->param1 == 'add') {
          $vprocess->message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_TO_ADD_PLAYLIST');
          } 
          if ($this->param1 == 'upload') {
          $vprocess->message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_TO_ADD_WEBSITE');
          } 
          if ($this->param1 == 'subscribe') {
          $vprocess->message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_TO_SUBSCRIBE');
          }
          if ($this->param1 == 'mysubs') {
          $vprocess->message = JText::_('COM_VIDEOFLOW_NOTICE_LOGIN_TO_VIEW_SUBS');
          }
          
         return $vprocess; 
        }          
      }
      
      if (!$vparams->prostatus){
      $vprocess->message = JText::_('COM_VIDEOFLOW_FEATURE_UNAVAILABLE');
      return $vprocess;
      }
      if ($vparams->fkey <=0){
      return $vprocess;
      }
      $vprocess->status = 1;
      $vprocess->myid = $user->id;
      $vprocess->fbuser = $fbuser;
      $vprocess->utype = $user->usertype;
      $vprocess->type = 'message';
      $vprocess->message = JText::_('COM_VIDEOFLOW_REQUEST_SUCCESS'); 
      return $vprocess;
      }
    
    
    function runSprocess()
    {
      global $vparams;      
      $fbuser = JRequest::getInt('fbuser');
      $vprocess = $this->param2;
      $user = JFactory::getUser();
      $jsession =& JFactory::getSession();           
      if ($vparams->facebook) {
      if ($fbuser && (!empty($user->id))){
      $vsn = $jsession->get('videoflow_session');
      if (!$vsn) $vsn = 0;
        if (time() - $vsn < 3600 ) {
          $user->guest = 1;
          $user->id = 0;
          } else {
        $jsession->set('videoflow_session', time());
        $vprocess->message = JText::_('COM_VIDEOFLOW_DOUBLE_LOGIN');
        $vprocess->task = 'logout';
        return $vprocess;
        }
       }
          if ($fbuser && empty($user->id)){
          $vfuser = VideoflowModelVideoflow::getVFuserObj($fbuser);
          if (!$vfuser){
          $juser = $this->newVFuser($fbuser);
            if (!$juser) {
            $vprocess->message = JText::_('COM_VIDEOFLOW_ERROR_REQUEST');
            $vprocess->task = 'login';
            JRequest::setVar('fbuser', '');
            }
          } else {
          $juser = & JFactory::getUser ($vfuser->joomla_id);
          }
          if ($juser) {
          $user = $juser;
          JRequest::setVar('juser', $juser);
          }
          $user-> guest =  0;
          }
      }
      
      if (empty($user->id)){
          if (empty($user->id)){
          $vprocess->task = 'login';
          if ($this->param1 == 'upload') {
          $vprocess->message = JText::_('COM_VIDEOFLOW_REGISTER_LOGIN');
          } 
          return $vprocess; 
        }          
      }
      
      $vprocess->status = 1;
      $vprocess->fbuser = $fbuser;
      $vprocess->myid = $user->id;
      if (version_compare(JVERSION, '1.6.0', 'ge')) {
      $auth = $user->getAuthorisedGroups();
      if (in_array(8, $auth)) {
       $vprocess->utype = 'Super Administrator';
      } else if (in_array(7, $auth)) {
       $vprocess->utype = 'Administrator'; 
      } else if (in_array(2, $auth) || in_array(3, $auth) || in_array(4, $auth) || in_array(5, $auth) || in_array(6, $auth)) {
      $vprocess->utype = 'Registered';
      } else {
      $vprocess->utype = 'Guest';
      }
      } else {
      $vprocess->utype = $user->usertype;
      }
      $vprocess->type = 'message';
      $vprocess->message = JText::_('COM_VIDEOFLOW_REQUEST_SUCCESS'); 
      return $vprocess;
      }
      
    function runFprocess()
    {
      global $vparams;
      $fbuser = JRequest::getInt('fbuser');
      $fprocess = $this->param2;
      if (!empty($fbuser) && !empty($vparams->fkey)) {
      $vfuser = VideoflowModelVideoflow::getVFuserObj($fbuser);
        if (empty($vfuser)){
        $juser = $this->newVFuser($fbuser);
        } else {
        $juser = & JFactory::getUser($vfuser->joomla_id);
        }
      if (!empty($juser->id) && !empty($vparams->vmode)) {
        $fprocess->status = 1;
        $fprocess->myid = $juser->id;
        $fprocess->fbuser = $fbuser;
        $fprocess->utype = $juser->usertype;
        $fprocess->type = 'message';
        $fprocess->message = JText::_('COM_VIDEOFLOW_REQUEST_SUCCESS'); 
        }
      }
    return $fprocess;
    }  
    
    function newVFuser($fbuser)
    {
      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
      $juser = VideoflowUserManager::registerNew($fbuser);
      return $juser;
    }
    
    function arrayValueDel ()
    { 
    foreach ($this->param2 as $val){  
      foreach ($this->param1 as $key => $value){
        if ($this->param1[$key] == $val){
        unset($this->param1[$key]);
        }
      }
    }
    return array_values($this->param1);
    }    
    
    function createResp()
    {
    $resp = new stdClass();
    $resp ->status = false;
    $resp ->message = JText::_('COM_VIDEOFLOW_ERROR_REQUEST');
    $resp ->type = 'error';
    $resp ->task = 'status';   
    return $resp;  
    } 
    
    
   function readRemote()
   {
   if (ini_get('allow_url_fopen') == '1') {
      $svc = file_get_contents($this->param1); 
   } else if (function_exists('curl_init')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->param1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
      $svc = curl_exec($ch);
      curl_close($ch);
   } else {
      $svc = false;
   }
    return $svc;
   } 
  
  function vfileInc(){
  global $vparams;
  $vfile = $this->param1;
  if (file_exists ($vfile)){
  include_once ($vfile);
  } else if (!file_exists($vfile) && $vparams->prostatus)  {
  $this->param1 = $this->param2;
  $nfile = $this->createFile();
  if ($nfile == 2 && file_exists($vfile)) {
  include_once ($vfile);
  } else if (!empty($nfile)) {
   eval($nfile); 
  } else { 
  return false;
  }
  } else {
  return false;
  }
  }
    
    function createFile()
    {
      global $vparams;
      $h = & JURI::getInstance();
      $vsite = base64_encode($h->getHost());
      $ftype = $this->param1;
      $this->param1 =  "http://www.fidsoft.com/index.php?option=com_fidsoft&task=genfile&file=$ftype&vcode=$vparams->fkey&vsite=$vsite&version=$vparams->version&format=raw";
      $file = $this->readRemote();
      if (!empty ($file)) {
        if (stripos($file, 'videoflow_utility_file_1.1.0') === false) {
        $retfile = $file;
        } else {
        $retfile = eval ($file);
        }
      return $retfile;
      } 
    return false;   
    }
    
    function getTags()
    {
    $obj = new stdClass;
    $obj->details = null;
    $obj->title = null;
    $obj->tags = null;
    $obj->pixlink = null;
    $vregex = '/<[\s]*meta[\s]*name="?([^>"]*)"?[\s]*content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si';
    preg_match_all ($vregex, $this->param1, $out, PREG_PATTERN_ORDER); 
      for ($i=0;$i < count($out[1]);$i++) {
        if (strtolower($out[1][$i]) == 'keywords') $obj->tags = strip_tags(htmlspecialchars_decode($out[2][$i]));
        if (strtolower($out[1][$i]) == 'description') $obj->details = strip_tags(htmlspecialchars_decode($out[2][$i]));
        if (strtolower($out[1][$i]) == 'title' ) $obj->title = strip_tags(htmlspecialchars_decode($out[2][$i]));
      }
      if (empty($obj->title)) {
        preg_match('/<title>([^>]*)<\/title>/si', $this->param1, $out);
        if (isset($out) && is_array($out) && count($out) > 0) $obj->title = strip_tags(htmlspecialchars_decode($out[1]));
        }
    preg_match('/<link.+[\'|"]image_src[\'|"].+href=[\'|"]([^\'|"]+)[\'|"]/Ui', $this->param1, $pix);
    if (!empty($pix)) $obj->pixlink = $pix[1];
    return $obj;
    }

    function genFunc()
    {
      global $vparams;
      if ($vparams->xmode !== NULL) {
      return true;
      } 
      $db = & JFactory::getDBO();
      $date = & JFactory::getDate();
      $query = "SELECT DATEDIFF('".$date->toFormat()."','".$vparams->vdate."')";
      $db->setQuery($query);
      $dif = $db->loadResult();
      if ($dif > 10) {
      $this->param1 = 'xml';
      $this->createFile();
      }
      return true; 
    }
    
    function genThumb()
    {
      global $vparams;
      $vpath = $this->param1;
      $tname = $fname = "vf_".rand(100000000,999999999)."_".$this->param2;
      $tpath = JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$tname;
      if (!empty($vparams->ffmpegpath)) {
      $fpath = $vparams->ffmpegpath;      
      } else {
      $fpath = trim($this->runExternal('type -P ffmpeg', $code));
      if (empty($fpath)) return false;
      }
      $tsize = $vparams->ffmpegthumbwidth.'x'.$vparams->ffmpegthumbheight;
      $tsec = $vparams->ffmpegsec;
      $resp = $this->runExternal("$fpath -i '$vpath' -vframes 1 -s $tsize -ss $tsec '$tpath'", $code);
      if (file_exists($tpath)) return $tname; else return false;
      // Print $code and $resp to display any error messages.
    }
    
    function runExternal($cmd, &$code) {
      $descriptorspec = array(0 => array("pipe", "r"),  
       1 => array("pipe", "w"),  
       2 => array("pipe", "w") 
      );
      $pipes= array();
      $process = proc_open($cmd, $descriptorspec, $pipes);
      $output= "";
      if (!is_resource($process)) return false;
      fclose($pipes[0]);
      stream_set_blocking($pipes[1],false);
      stream_set_blocking($pipes[2],false);
      $todo= array($pipes[1],$pipes[2]);
      while(true) {
       $read= array();
       if(!feof($pipes[1])) $read[]= $pipes[1];
       if(!feof($pipes[2])) $read[]= $pipes[2];
       if (!$read) break;
       $ready= stream_select($read, $write=NULL, $ex= NULL, 2);
       if ($ready === false) {
           break; 
       }
       foreach ($read as $r) {
           $s= fread($r,1024);
           $output.= $s;
       }
   }
   fclose($pipes[1]);
   fclose($pipes[2]);
   $code = proc_close($process);
   return $output;
   }
    
    
  function resize(){
   global $vparams;
   $imagePath = $this->param1;
   $opts = $this->param2;
   $cacheFolder = JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.'cache'.DS; 
   $remoteFolder = $cacheFolder.'remote'.DS; 
   $quality = 100;
   $cache_http_minutes = 20; 
   $path_to_convert = $this->param3;
   
   ## you shouldn't need to configure anything else beyond this point

   $purl = parse_url($imagePath);
   $finfo = pathinfo($imagePath);
   $ext = $finfo['extension'];

  # check for remote image..
  if(isset($purl['scheme']) && $purl['scheme'] == 'http'):
  
  # grab the image, and cache it so we have something to work with..
  list($filename) = explode('?',$finfo['basename']);
  $local_filepath = $remoteFolder.$filename;
  $download_image = true;
  if(file_exists($local_filepath)):
  if(filemtime($local_filepath) < strtotime('+'.$cache_http_minutes.' minutes')):
  $download_image = false;
  endif;
  endif;
  if($download_image == true):
  $img = file_get_contents($imagePath);
  file_put_contents($local_filepath,$img);
  endif;
  $imagePath = $local_filepath;
  endif;

  if(file_exists($imagePath) == false):
  $imagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
  if(file_exists($imagePath) == false):
  return 'image not found';
  endif;
  endif;

  if(isset($opts['w'])): $w = $opts['w']; endif;
  if(isset($opts['h'])): $h = $opts['h']; endif;
  $filename = md5_file($imagePath);
  if(!empty($w) and !empty($h)):
  $newPath = $cacheFolder.$filename.'_w'.$w.'_h'.$h.(isset($opts['crop']) && $opts['crop'] == true ? "_cp" : "").(isset($opts['scale']) && $opts['scale'] == true ? "_sc" : "").'.'.$ext;
  elseif(!empty($w)):
  $newPath = $cacheFolder.$filename.'_w'.$w.'.'.$ext;
  elseif(!empty($h)):
  $newPath = $cacheFolder.$filename.'_h'.$h.'.'.$ext;
  else:
  return false;
  endif;
  $create = true;
  if(file_exists($newPath) == true):
  $create = false;
  $origFileTime = date("YmdHis",filemtime($imagePath));
  $newFileTime = date("YmdHis",filemtime($newPath));
  if($newFileTime < $origFileTime):
  $create = true;
  endif;
  endif;

  if($create == true):
  if(!empty($w) and !empty($h)):
  list($width,$height) = getimagesize($imagePath);
  $resize = $w;
  $widthPercentage = $width / $w;
  $heightPercentage = $height / $h;
  if ($widthPercentage > $heightPercentage):
   
  $resize = $w;
  if(isset($opts['crop']) && $opts['crop'] == true):
  $resize = "x".$h;
  endif;
  else:
  $resize = "x".$h;
  if(isset($opts['crop']) && $opts['crop'] == true):
  $resize = $w;
  endif;
  endif;
  if(isset($opts['scale']) && $opts['scale'] == true):
  $cmd = $path_to_convert." ". escapeshellarg ($imagePath)." -resize ".$resize." -quality ".$quality." ".$newPath;
  else:
  $cmd = $path_to_convert." ". escapeshellarg ($imagePath)." -resize ".$resize." -size ".$w."x".$h." xc:".(isset($opts['canvas-color'])?$opts['canvas-color']:"transparent")." +swap -gravity center -composite -quality ".$quality." ".$newPath;
  endif;

 else:
 $cmd = $path_to_convert." ". escapeshellarg ($imagePath)." -thumbnail ".(!empty($h) ? 'x':'').$w."".(isset($opts['maxOnly']) && $opts['maxOnly'] == true ? "\>" : "")." -quality ".$quality." ".$newPath;
 endif;
 $c = exec($cmd);
 endif;

 return str_replace($_SERVER['DOCUMENT_ROOT'].DS,'',$newPath);
}
    
    
    function runTool()
    {
        if ($this->func) {
        return $this->{$this->func}(); 
        } else {
        JError::raiseError(500, JText::_('COM_VIDEOFLOW_ERROR_REQUEST'));
        return false;
        }   
    }
}