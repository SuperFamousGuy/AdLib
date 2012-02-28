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

class VideoflowFileManager {
	

	function fileUpload($file, $folder, $maxsize=0)
	{		
		global $vparams;
		
  	if( empty($file['name']) ){
		 return JError::raiseWarning( 405, $file['name'].' '.JText::_('COM_VIDEOFLOW_WARN_NOT_FOUND') );
		}	
		if( $maxsize && $file['size'] > $maxsize){
			return JError::raiseWarning(405,  JText::_('COM_VIDEOFLOW_WARN_FILE_LIMIT').' '. $maxsize / 1048576 .'MB' );
		}
		if(!self::checkFile($file)){
			return JError::raiseWarning( 405, JText::_('COM_VIDEOFLOW_FILE_INVALID') );
		}
		$fdetails = self::upload($file, $folder);
		if( empty ($fdetails)) {
			return JError::raiseWarning(405,  JText::_('COM_VIDEOFLOW_UPLOAD_FAILURE') );
		}		
		$flink =  self::genurl(trim($fdetails['fpath']));
	  if( empty ($flink)) {
			return JError::raiseWarning(405,  JText::_('COM_VIDEOFLOW_NO_FILE_URL') );
		}		
    $result = array ("fname"=>$fdetails["fname"], "fpath"=>$fdetails["fpath"], "flink"=>$flink);
    return $result;
  }
  
   
	function upload($file, $folder)
	{	
    global $vparams;
    jimport('joomla.filesystem.file');
		jimport('joomla.client.helper');
		if( !JFolder::exists($folder) ){
			JError::raiseWarning(405, JText::_('COM_VIDEOFLOW_NO_FOLDER'));
			return false;
		}	
    $fname = "vf_".rand(100000000,999999999)."_".$file['name'];
		$fname = JFile::makeSafe($fname);		
		$filepath = JPath::clean($folder.DS.$fname);
    $name = glob($folder.DS."vf_?????????_". substr($fname, 13));
    if (!empty($name)) {  
      return JError::raiseWarning( 405, $file['name'].' '.JText::_('COM_VIDEOFLOW_FILE_EXISTS') );
    } 
    
    if ($vparams->upsys == 'plupload') {
      if (!JFile::move($file['tmp_name'], $filepath)) {
			   JError::raiseWarning(405, JText::_('COM_VIDEOFLOW_UPLOAD_FAILURE') );
			   return false;
		}
		} else {
      if (!JFile::upload($file['tmp_name'], $filepath)) {
			   JError::raiseWarning(405, JText::_('COM_VIDEOFLOW_UPLOAD_FAILURE') );
			   return false;
      }
		}
    if (JFile::exists($filepath)) chmod($filepath, 0644);
    $fdetails = array ('fname'=>$fname, 'fpath'=>$filepath);
		return $fdetails;
	}
	
  function saveRemoteFile($post){
    foreach ($post as $key=>$value){
          $data[$key] = $value;
    }
    $row = & JTable::getInstance ('Media', 'Table');
     if (!$row->bind( $data)) {
    	     JError::raiseWarning( 500, $row->getError() );
    	     return false;
		    }
     $row->id = (int) $row->id;
     $filter = new JFilterInput();
     $row->title = $filter->clean($row->title);
     $row->details = $filter->clean ($row->details);
     $row->tags = $filter->clean($row->tags);
		if (!$row->check()) {
			 JError::raiseWarning( 500, $row->getError() );
			 return false;
		}
     if (!$row->store()) {
          JError::raiseWarning(500, $row->getError());
          return false;
        }
      return $row->id;
  }
  
  function saveXpload(){
  global $vparams;
  JRequest::checkToken('get') or JExit( 'Invalid Token' );
	header('Content-type: text/plain; charset=UTF-8');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
  jimport('joomla.filesystem.file');
  jimport('joomla.filesystem.folder');
  jimport('joomla.client.helper');
	$targetDir = JPATH_COMPONENT_SITE.DS.'tmp';
	$cleanupTargetDir = true; 
	$maxFileAge = 60 * 60; 
	@set_time_limit(5 * 60);
	$chunk = JRequest::getInt('chunk', 0);
	$chunks = JRequest::getInt('chunks', NULL);
	$dname = JRequest::getString ('name', 0);
	$fileName = preg_replace('/[^\w\._]+/', '', $dname);
	if (!JFolder::exists($targetDir)) JFolder::create($targetDir);

	if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
		while (($file = readdir($dir)) !== false) {
			$filePath = $targetDir . DS . $file;
			if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
				JFile::delete($filePath);
		}
		closedir($dir);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');

	$contentType = JRequest::getVar('CONTENT_TYPE', NULL, 'server');
  if (empty($contentType)) $contentType = JRequest::getVar('HTTP_CONTENT_TYPE', NULL, 'server');
	if (strpos($contentType, "multipart") !== false) {
	  $upfile = JRequest::get('files');
		if (isset($upfile['file']['tmp_name']) && is_uploaded_file($upfile['file']['tmp_name'])) {
			$out = fopen($targetDir . DS . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				$in = fopen($upfile['file']['tmp_name'], "rb");
				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				fclose($out);
				JFile::delete($upfile['file']['tmp_name']);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	} else {
    $out = fopen($targetDir . DS . $fileName, $chunk == 0 ? "wb" : "ab");
		if ($out) {
			$in = fopen("php://input", "rb");
			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($out);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	}
	echo '{"jsonrpc" : "2.0", "result" : null, "id" : "id"}';

if ($chunks === NULL || ($chunks > 0 && ($chunk + 1 == $chunks))) {
  $newfile['Filedata']['name'] = $dname;
  $newfile['Filedata']['tmp_name'] = $targetDir.DS.$fileName;
  $newfile['Filedata']['size'] = filesize($targetDir.DS.$fileName); 
  return $newfile;
}
return false;
}

   
  function getStatus($status){
  $db =& JFactory::getDBO();
  $file	= JRequest::getString ( 'file' );
  $cid = JRequest::getInt ('cid');
  $userid = JRequest::getInt('userid');
  $status->message = JText::_('COM_VIDEOFLOW_ERR_UP').' "'.$file.'"';
  $query = "SELECT file FROM #__vflow_data WHERE id =" .(int) $cid. " AND userid =" . (int) $userid;
	$db->setQuery($query);
	$result = $db -> loadResult();
  if (!empty($result)){
    $status->message = $file." ".JText::_("COM_VIDEOFLOW_UPLOAD_SUCCESS"); 
    $status->status = true;
    $status->type = 'message';
    $status->cid = $cid;
    $status->userid = $userid;
  }
  return $status;
  }

  function getContent($link){
    require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php');
    if ($getfile = VideoflowTools::findFunction ('file_get_contents')) {
    $content = (file_get_contents ($link));
    } elseif (!$getfile && VideoflowTools::findFunction ('curl_init') ) {  
    $coptions = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER => false,
      CURLOPT_FOLLOWLOCATION => true, 
      CURLOPT_ENCODING => "", 
      CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0", 
      CURLOPT_AUTOREFERER => true, 
      CURLOPT_CONNECTTIMEOUT => 120, 
      CURLOPT_TIMEOUT => 120, 
      CURLOPT_MAXREDIRS => 10, 
      );

    $ch = curl_init( $link );
    curl_setopt_array( $ch, $coptions );
    $content = curl_exec( $ch );
    curl_close( $ch );
    } else {
      JError::raiseWarning(405, JText::_('COM_VIDEOFLOW_REMOTE_FAIL') );
      return false;
    }    
    return $content; 
  }

  function checkFile ($file) {
   global $vparams;
   jimport('joomla.filesystem.file');
   require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php');
   $ftype = strtolower(JFile::getExt($file['name']));
   switch ($ftype){
          case 'mp3':
          case 'aac':  
          $fext = true;
          $mtype = "audio";
          break;
                  
          case 'flv':
          case 'mp4':
          $fext = true;
          $mtype = "video";
          break;
                    
          case 'swf':
          $fext = true;
          $mtype = "flash";
          break;
          
          case 'jpg':
          case 'gif':
          case 'png':
          $fext = true;
          $mtype = "image";
          break;
          
          default:
          $fext = false;
          break;
        }  
 
  if (!$fext) {
  return false;
  }

  if ($mtype == "image"){
  $minfo = getimagesize($file['tmp_name']);
  $validftype = array ("image/jpeg", "image/png", "image/gif");
      if( $minfo[0] < 10 || $minfo[1] < 10 || !in_array($minfo['mime'], $validftype) ){
        return false;
      }
  }        
 
   $filter = array(".php", ".phtm", ".phtml", ".ph3", ".ph4", ".php3", ".php4", ".pl", ".py", ".htm", ".html", ".shtml", ".shtm", ".js", ".inc", ".txt");
   $stat = new VideoflowTools();
	 $stat->func = 'findSubstring';
	 $stat->param1 = $filter;
	 $stat->param2 = $file['name'];
   if ($stat->runTool()) return false;
   return true;
  }

  function getFileInfo($ext){
    
    switch ($ext){
          case 'mp3':
          $dir = 'audio';
          $mtype = 'audio';
          $mime = 'audio/mpeg';
          break;
          
          case 'aac':
          $dir = 'audio';
          $mtype = 'audio';
          $mime = 'audio/x-aac';
          break;
          
          case 'flv':
          $dir = 'videos';
          $mtype = 'video';
          $mime = 'video/x-flv';
          break;
          
          case 'mp4':
          $dir = 'videos';
          $mtype = 'video';
          $mime = 'video/mp4';
          break;
          
          case 'swf':
          $dir = 'flash';
          $mtype = 'flash';
          $mime = 'application/x-shockwave-flash';
          break;
          
          case 'jpg':
          $dir = 'photos';
          $mtype = 'image';
          $mime = 'image/jpeg';
          break;
          
          case 'gif':
          $dir = 'photos';
          $mtype = 'image';
          $mime = 'image/gif';
          break;
          
          case 'png':
          $dir = 'photos';
          $mtype = 'image';
          $mime = 'image/png';
          break;
          
          default:
          $dir = false;
          $mtype = false;
          $mime = false;
          break;
        }  
        
  return array("dir"=>$dir, "mtype"=>$mtype, "mime"=>$mime);
  }
  
	function genpath($url){
		$conv = array( JURI::root(), '/' );
		$rep = array( JPATH_SITE.DS, DS );
		return str_replace( $conv, $rep, $url );			
	}

	function genurl ($filepath) {
    $realpath = realpath($filepath);
    $dir;
    if (is_file($realpath)) {
        $dir = dirname($realpath);
    }
    elseif (is_dir($realpath)) {
        $dir = $realpath;
    } else {
        JError::raiseWarning( 405, JText::_('COM_VIDEOFLOW_NO_FILE_FOUND').' '.$realpath);
        return false;
    }
  
    if (strlen($dir) < strlen(JPATH_ROOT)){
    JError::raiseWarning( 405, JText::_('COM_VIDEOFLOW_HTTP_ERR'));
    return false;
    }
    $path = JURI::root().ltrim (substr($realpath, strlen(JPATH_ROOT)), DS);  
    if (DIRECTORY_SEPARATOR == '\\')
      $path = str_replace('\\', '/', $path);  
    return $path;
    }
    

  function delete($paths=array(0))
	{
    global $vparams;
    jimport('joomla.filesystem.file');
    $file_array = array();
    if (!is_array($paths)) {
    $paths = array ($paths);
    }
    $paths = self::genpath( $paths );
	     foreach ($paths as $file){
          if (stristr($file, JPATH_ROOT) === FALSE) {
          $ext = strtolower(JFile::getExt($file));  
          $info = self::getFileInfo ($ext);
          $file = JPATH_ROOT.DS.$vparams->mediadir.DS.$info['dir'].DS.$file;
          } 
       $file_array[] = $file;
       }
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');	
		$res = true;
		if (count($file_array) ) {
			jimport('joomla.filesystem.file');
			foreach ($file_array as $path){
				if (is_file($path)) {
					$res = JFile::delete($path) && $res;
				} 
				else{
					$res = false;
				}
			}
			
			return $res;
		}
	} 	
}