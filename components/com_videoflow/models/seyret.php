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

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class VideoflowModelSeyret extends JModel
{
   
    var $_total = null;
    
    var $_pagination = null;
    
    var $_userid = null;
    
    var $_vfvar = null;
    
    
    function __construct()
    {
        parent::__construct();
         
        global $vparams;
        $limitstart = JRequest::getInt('limitstart', 0);
        $this->setState('limit', $vparams->limit);
        $this->setState('limitstart', $limitstart);
    }

    function getData($vtask = null, $vlimit = null)
    {
    require_once (JPATH_SITE.DS.'components'.DS.'com_seyret'.DS.'includes'.DS.'classes'.DS.'seyretapi.class.php');
    if (empty($vtask)) $task = JRequest::getCmd('task'); else $task = $vtask; 
    if ($task == 'popular') {
    $task = 'mostviewed';
    } elseif (!$task)  {
    $task = 'latest';
    }    
    if (empty($vlimit)) $vlimit = $this->getState('limit');
    list ( $videolist, $totalvidrowcount ) = seyretapi::getvideolist ($task, $vlimit, $this->getState('limitstart'));
    $this->_total = $totalvidrowcount;
    return $videolist;
    }
    
    function getMedia($id)
    {
        $db = & JFactory::getDBO();
        $query = 'SELECT * FROM #__seyret_video WHERE id = ' .(int) $id . ' AND published = 1';         
        $db->setQuery($query);
        return $db->loadObject();
    }
    
    function getRand($limit)
    {
    return $this->getData('random', $limit);
    }
    
    
    function dosearch () 
    {
    $pattern = JRequest::getString( 'searchword');
    $id = JRequest::getInt('id');
    if (empty($pattern)) {
    echo JText::_('You must enter a search term');
    return;
    }
		$pattern_safe = str_replace("'", "", $pattern);
		$pattern_safe = str_replace('"', "", $pattern_safe);
		$pattern_safe = addslashes($pattern_safe);
		return $this->getSearchData($pattern, $id);
		}
		
		function getSearchData ($pattern, $id)
		{
        $db = & JFactory::getDBO();
        $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM #__seyret_video WHERE published = 1'.  
                 ' AND (videotags LIKE '.$db->quote ('%'.$db->getEscaped ($pattern, true).'%',false ).
                 ' OR videotitle LIKE '.$db->quote ('%'.$db->getEscaped ($pattern, true).'%',false ).
                 ' OR videodescription LIKE '.$db->quote ('%'.$db->getEscaped ($pattern, true).'%',false ).')'.
                 ' AND id != ' . (int) $id;
        $db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
        $res = $db->loadObjectList(); 
        $db->setQuery('SELECT FOUND_ROWS();');
        $this->_total = $db->loadResult();
        return $res; 
    }
		
		function getMyvidsFB ($userid=null, $faceid=null)
    {
    $db = & JFactory::getDBO();
    $query = 'SELECT DISTINCT mid FROM #__vflow_mymedia WHERE component = "seyret" AND (faceid = '.(int) $faceid;
    if (!empty($userid)) $query .= ' OR jid='. (int) $userid;
    $query .= ')';
    $db -> setQuery ($query);
    $res = $db->loadResultArray();
    if (!empty($res)) return $this->getVids($res); else return false;
    }
    
    
    function getVids($ids)
    {
        $id = JRequest::getInt('id');
        $db = & JFactory::getDBO();
        $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM #__seyret_video WHERE id =' . implode( ' OR id = ', $ids );
        if (!empty($id)) $query .= ' AND id != '.(int) $id;
        $query .= ' AND published = 1';
        $db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
        $res = $db->loadObjectList();
        $db->setQuery('SELECT FOUND_ROWS();');
        $this->_total = $db->loadResult();
        return $res;
    }
		
		function countFavs ($mid){
      $db = & JFactory::getDBO();
      $query = 'SELECT COUNT (*) FROM #__vflow_mymedia WHERE mid='.(int) $mid. ' AND component = "seyret"';
      $db->setQuery($query);
      return $db->loadResult();
    }

		
		
		function add($myid)
    {
    global $vparams;
    $id = JRequest::getInt('id');
    $mes = $this->runTool ('createResp');
    $media = $this->getMedia ($id);
    $fbuser = JRequest::getInt('fbuser');
      if (!empty($media)){
        $media->title = $media->videotitle;
        $media->type = 'syt';
        $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
        $this->runTool('vfileInc', $vfile, 'vlm');
        if (!class_exists('VideoflowListManager')) return $mes;  
        $mes = VideoflowListManager::addToList($id, $myid, $media, $mes);
        if ($mes->status) {
          if (!empty($fbuser)) {
          $mlink = $vparams->canvasurl.'&task=visit&cid='.$fbuser.'&id='.$media->id.'&vf=1';
          } else {
          $mlink = $vparams->canvasurl.'&task=latest&id='.$media->id.'&vf=1';
          }
          $u_action = JText::_('has added "').$media->title.'" '.JText::_('to his/her video channel at ').$vparams->appname;
          $this->createFeed($media, $u_action, $mlink );
        }
        }
      return $mes;
      } 
    
    function remove ()
    {
    $id = JRequest::getInt('id');
    $media = $this->getMedia ($id);
    $mes = $this->runTool ('createResp');
      if (!empty($media)) {
        $media->title = $media->videotitle;
        $media->type = 'syt';
        $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
        $this->runTool('vfileInc', $vfile, 'vlm');
        if (!class_exists('VideoflowListManager')) return $mes;  
        $mes = VideoflowListManager::removeFromList($id, $media, $mes);
        }
    return $mes;
    }
    
 function createFeed($media, $u_action, $mlink) 
 {
  global $vparams;
  $c = JRequest::getCmd('c');
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fb_tools.php';
  $this->runTool('vfileInc', $vfile, 'vft');
  if (!class_exists('VideoflowFbTools')) return false;
  if (empty($media->favoured)) $media->favoured = '';
  $media->details = stripslashes(VideoflowModelVideoflow::runTool('xterWrap', $media->videodescription, $vparams->commentlimit));
  $media->title = $media->videotitle;
  $media->tags = $media->videotags;
  if (empty($media->pixlink)) $media->pixlink = JURI::root().'components/com_videoflow/players/vflow.gif';
      $tag_link = $vparams->canvasurl.'&task=dosearch&searchword='.$media->tags.'&vf=1';
      $source_link = $vparams->canvasurl;
      
      $attachment =  array(
      'name' => "$media->title",
      'href' => "$mlink",
      'caption' => "$media->details",
      'description' => "");
      $action_links = array(
                          array('text' => JText::_('Tune In'),
                            'href' => "$mlink")    
                            );
     VideoflowFbTools::fbnewsfeed ($u_action, $attachment, $action_links);
    }

    function runTool($func=null, $param1=null, $param2=null, $param3=null, $param4=null)
    {
    include_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php';
    $tools = new VideoflowTools();
    $tools->func   = $func;
    $tools->param1 = $param1;
    $tools->param2 = $param2;
    $tools->param3 = $param3;
    $tools->param4 = $param4;
    return $tools->runTool();
    }

    function updateDataFB(&$vlist)
    {
    global $vparams;
    include_once(JPATH_COMPONENT_SITE.DS.'models'.DS.'videoflow.php');
    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php');   
    $task = JRequest::getCmd ('task');
    foreach ($vlist as &$data) {
                if (!is_array($data)) { 
                        $data->usrlink = VideoflowModelVideoflow::getUserName($data->addedby);
                        if (empty($data->usrlink) || $data->usrlink == 'Guest') $data->usrlink = JText::_('Facebook User');
                        $data->sdetails = stripslashes(VideoflowModelVideoflow::runTool('xterWrap', $data->videodescription, $vparams->commentlimit));
                        $data->stitle = stripslashes(VideoflowModelVideoflow::runTool('xterWrap', $data->videotitle, 32));
                        $data->pixlink = $data->videothumbnail;
                        $data->favoured = $this->countFavs($data->id);
                        $data->file = '';
                        $data->server = $data->videoservertype;
                        if (empty($data->videolink)) $data->videolink = JURI::root().'index.php?option=com_seyret&task=view&video='.$data->id;
                        $data->sharelink = $data->videolink;
                        $data->dateadded = $data->addeddate;
                        $data->views = $data->hits;
                        $data->catname = '';
                        $data->title = $data->videotitle;
                        $data->rating = VideoflowModelVideoflow::calRating($data->votetotal, $data->voteclick);
                        if ($vparams->showpro) {
                        if ($task == 'myvids') $action = 'remove'; else $action = 'add';
                        $do = JURI::root().'index.php?option=com_videoflow&task='.$action.'&id='.$data->id.'&c=fb&format=raw&vf=1';
                        $data->mylist = '<img class="vf_tools_icons" src="'.JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/'.$action.'.gif" />
                        <a href="#" onClick="showChoice(\''.$do.'\', \''.JText::_('Status message').'\', \''.JText::_('Okay').'\'); return false">'.JText::_('MyList').'</a>';              
                        } else {
                        $data->mylist = '';
                        }
                        if (!empty($data->plcspfile)) $scode = '&scode='.$data->plcspfile; else $scode = '';
                        $data->link = $vparams->canvasurl.'&task=random&id='.$data->id.$scode.'&vf=1';
                        $data->xplayer = '<fb:iframe src="'.JURI::root().'index.php?option=com_videoflow&task=iplay&id='.$data->id.'&c=fb&format=raw" width="480" height="360" name="ffk'.$data->id.'" frameborder="0" scrolling="no" /></fb:iframe>'; 
                } else {
                        $this->updateDataFB($data);
                }
        }
        return $vlist; 
  }
 
   function genIplay() {
    $id = JRequest::getInt('id');
    $media = $this->getMedia($id);
    $scode = JRequest::getVar('scode', 'plcsp2145bf3n24');
    $pix = $media->videothumbnail;
    $regex = "#^(http\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\/\S*)?(?:[a-zA-Z0-9_])+\.(?:jpg|jpeg|gif|png))$#";
    if (preg_match($regex, $pix)) $pix = $pix; else $pix = JURI::root().'components/com_videoflow/players/preview.jpg';
    $url = JURI::root().'index.php?option=com_seyret&view=video&task=gembedvar&id='.$id; 
    $svc = $this->runTool('readRemote', $url);
    $splay = 
    '<script type="text/javascript">'.$svc.'</script>
    <script src="'.JURI::root().'components/com_seyret/includes/js/seyretvembed.js?plcsp='.$scode.'&videoid='.$id.'&width=464&height=348&thumb='.$pix.'" type="text/javascript"></script>';		
    return $splay;
   } 
        
   
    function getPagination()
    {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->_total, $this->getState('limitstart'), $this->getState('limit') );
        }   
        return $this->_pagination;
    }

        
    function getVFuserObj ($fbuser)
    {
          include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
          return VideoflowUserManager::getVFuserObj($fbuser);
    }
}