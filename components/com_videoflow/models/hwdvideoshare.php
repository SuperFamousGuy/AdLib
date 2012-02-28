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

define('URL_HWDVS_IMAGES', JURI::root().'components/com_hwdvideoshare/assets/images/');

define ('PATH_HWDVS_DIR', JPATH_SITE.DS.'hwdvideos');

define ('URL_HWDVS_DIR', JURI::root().'hwdvideos');
 
jimport( 'joomla.application.component.model' );
 
class VideoflowModelHWDvideoshare extends JModel
{
   
    var $_total = null;
    
    var $_pagination = null;
    
    var $_seltype = null;
    
    var $_vfvar = null;
        
    function __construct()
    {
        parent::__construct();
        global $vparams;
        $limitstart = JRequest::getInt('limitstart', 0);
        $this->setState('limit', $vparams->limit);
        $this->setState('limitstart', $limitstart);
    }

    
    function getMedia($id) {
      global $vparams, $hwdvs_joinv, $smartyvs;
      require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'config.hwdvideoshare.php');
      require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'helpers'.DS.'initialise.php');
      hwdvsInitialise::mysqlQuery(); 
      $c = hwd_vs_Config::get_instance();     
      include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'dummy.php');
      $smartyvs = new VideoflowDummy();
      $smartyvs->assign();
     
      $where = ' WHERE video.published = 1';
      $where .= ' AND video.id = '.$id;
      $where .= ' AND video.approved = "yes"';
      $where .= 'AND video.public_private = "public"';
      $db = & JFactory::getDBO();
      $query = 'SELECT video.*, number_of_views AS views, video_type AS type, updated_rating AS rating, video_type AS server,'
                . ' category_id AS cat, date_uploaded AS dateadded, u.name, u.username, c.category_name AS catname '
                . ' FROM #__hwdvidsvideos AS video '
                . $hwdvs_joinv
			          . ' LEFT JOIN #__hwdvidscategories AS c ON c.id = video.category_id '
                . $where
                ;
      $db->setQuery($query);
      $media = $db->loadObject();
      if (!empty($media)) {
      $media->details = stripslashes($this->runTool('xterWrap', $media->description, $vparams->commentlimit));
      $media->pixlink = $this->getThumb($media);
      }
      return $media;    
    }
    
    function getRand() {
    $this->_seltype = 'random';
    $this->setState('limit', 4);
    $this->setState('limitstart', 0);
    return $this->getData();
    
    }
    
    function getRelated ($media)
    {
    $this->_seltype = 'related';
    $this->setState('limit', 4);
    $this->setState('limitstart', 0);
    return $this->doSearch ($media->tags);
    }
    
    function getData($id = null)
    {
      global $vparams, $hwdvs_joinv;
      $vid = JRequest::getInt('id');
      require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'config.hwdvideoshare.php');
      require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'helpers'.DS.'initialise.php');
      hwdvsInitialise::mysqlQuery();   
      $cat = JRequest::getInt('cat');
      $vtask = JRequest::getCmd('task');
      $c = hwd_vs_Config::get_instance();
  		$db = & JFactory::getDBO(); 
        $where = ' WHERE video.published = 1 ';
        if (!empty($id)) {
          if (is_array($id)) {
          $where .=  ' AND video.id =' . implode( ' OR video.id = ', $id );
          } else {
          $where .= ' AND video.id = '.(int) $id;
          }
        }    
        
        if (!empty($vid)) $where .= ' AND video.id != ' .(int) $vid;
        
        $where .= ' AND video.approved = "yes"';
        $where .= ' AND video.public_private = "public"';
        
        if ($vtask == 'featured') {
        $where .= ' AND video.featured = 1';
        }
        if ($vtask == 'dosearch' || $this->_seltype == 'related') {
        $where .= ' AND MATCH (title,tags,description) AGAINST (\''.$this->_vfvar.'\')';
        }
        if (!empty($cat)) {
        $where .= ' AND video.category_id = '. (int) $cat;
        }
        $orderby = ' ORDER BY';
        if ($vtask == 'random' || $this->_seltype == 'random') {
        $orderby .= ' RAND()';
        } else if ($vtask == 'popular') {
        $orderby .= ' video.number_of_views DESC';
        } else {
        $orderby .= ' video.date_uploaded DESC';
        }
        
        
        // get video count
        $db->SetQuery( 'SELECT count(*)'
					 . ' FROM #__hwdvidsvideos AS video'
					 . ' LEFT JOIN #__users AS u ON u.id = video.user_id'
					 . ' LEFT JOIN #__hwdvidscategories AS `categories` ON categories.id = video.category_id'
					 . $where
					 );
        $this->_total = $db->loadResult();
        echo $db->getErrorMsg();
        $query = 'SELECT video.*, number_of_views AS views, video_type AS type, updated_rating AS rating, video_type AS server,'
                . ' category_id AS cat, date_uploaded AS dateadded, u.name, u.username, c.category_name AS catname'
                . ' FROM #__hwdvidsvideos AS video'
                . $hwdvs_joinv
			          . ' LEFT JOIN #__hwdvidscategories AS c ON c.id = video.category_id'
                . $where
                . $orderby
                ;
        $db->SetQuery($query, $this->getState('limitstart'), $this->getState('limit'));
        $rows = $db->loadObjectList();     
      return $rows;
    }
    
    function dosearch ($key = null) 
    {
    $pattern = JRequest::getString( 'searchword', $key);
    if (empty($pattern)) {
    echo JText::_('You must enter a search term');
    return;
    }
		$pattern_safe = str_replace("'", "", $pattern);
		$pattern_safe = str_replace('"', "", $pattern_safe);
		$pattern_safe = addslashes($pattern_safe);
		$this->_vfvar = $pattern_safe;
		return $this->getData();
		}
		
		function add($myid)
    {
    global $vparams;
    $id = JRequest::getInt('id');
    $mes = $this->runTool ('createResp');
    $media = $this->getMedia ($id);
    $fbuser = JRequest::getInt('fbuser');
      if (!empty($media)){
        $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
        $this->runTool('vfileInc', $vfile, 'vlm');
        if (!class_exists('VideoflowListManager')) return $mes;  
        try {
        $mes = VideoflowListManager::addToList($id, $myid, $media, $mes); 
        } catch (Exception $e) {
        error_log($e);
        }
        if ($mes->status) {
          if (!empty($fbuser)) {
          $mlink = $vparams->canvasurl.'&task=visit&cid='.$fbuser.'&id='.$media->id.'&vf=1';
          } else {
          $mlink = $vparams->canvasurl.'&task=vplay&id='.$media->id.'&vf=1';
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
        $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_list_manager.php';
        $this->runTool('vfileInc', $vfile, 'vlm');
        if (!class_exists('VideoflowListManager')) return $mes; 
        try {
        $mes = VideoflowListManager::removeFromList ($id, $media, $mes); 
        } catch (Exception $e) {
        error_log($e);
        }
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
  
  if (empty($media->pixlink)) $media->pixlink = URL_HWDVS_IMAGES.'default_thumb.jpg';
  
  $fv = $this->_buildCode($media);
  
  if (!empty($fv)) {
  $fvc = $fv['player'].'?'.$fv['flashvars'];
  } else {
  $fvc = '';
  }  
      $tag_link = $vparams->canvasurl.'&task=dosearch&searchword='.$media->tags.'&vf=1';
      $source_link = $vparams->canvasurl;
      
      $attachment =  array(
      'name' => "$media->title",
      'href' => "$mlink",
      'caption' => "$media->details",
      'description' => "",
      'properties' => array(JText::_('Tags') => array(
                              'text' => "$media->tags",
                              'href' => "$tag_link"),
                              JText::_('Fans') => "$media->favoured",
                              JText::_('Source') =>array (
                              'text' => "$vparams->appname",
                              'href' => "$source_link")
                              ),
      'media' => array(array('type' => 'video',
                    'video_src' => "$fvc",
                    'preview_img' => "$media->pixlink",
                    'video_link' => "$mlink",
                    'video_title' => "$media->title")));
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

    function updateDataFB(&$vlist, $layout = null)
    {
    global $vparams, $smartyvs;
    include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'dummy.php');
    $smartyvs = new VideoflowDummy();
    $smartyvs->assign();
    include_once(JPATH_COMPONENT_SITE.DS.'models'.DS.'videoflow.php');
    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fbook_helper.php');   
    $task = JRequest::getCmd ('task');
    foreach ($vlist as &$data) {
                if (!is_array($data)) { 
                        $data->usrlink = $data -> name;
                        if (empty($data->usrlink)) $data->usrlink = JText::_('Facebook User');
                        $data->sdetails = stripslashes(VideoflowModelVideoflow::runTool('xterWrap', $data->description, $vparams->commentlimit));
                        $data->stitle = stripslashes($this->runTool('xterWrap', $data->title, 32));
                        $data->pixlink = $this->getThumb($data);
                        $data->favoured = $this->countFavs($data->id);
                        $data->file = trim(substr($data->video_id,0,strpos($data->video_id,'.')));
                        $data->sharelink = JURI::root().'index.php?option=com_hwdvideoshare&task=viewvideo&video_id='.$data->id;
                        if ($vparams->showpro) {
                        if ($task == 'myvids') $action = 'remove'; else $action = 'add';
                        $do = JURI::root().'index.php?option=com_videoflow&task='.$action.'&id='.$data->id.'&c=fb&format=raw&vf=1';
                        $data->mylist = '<img class="vf_tools_icons" src="'.JURI::root().'components/com_videoflow/views/videoflow/tmpl/images/tools/'.$vparams->toolcolour.'/'.$action.'.gif" />
                        <a href="#" onClick="showChoice(\''.$do.'\', \''.JText::_('Status message').'\', \''.JText::_('Okay').'\'); return false">'.JText::_('MyList').'</a>';              
                        } else {
                        $data->mylist = '';
                        }
                        if ($layout == 'default') $data->embedcode = $this->_buildCode($data);
                        $data->link = $vparams->canvasurl.'&task=vplay&id='.$data->id.'&vf=1';
                } else {
                        $this->updateDataFB($data);
                }
        }
        return $vlist;
  
  }
 
    function _buildCode($media){
     if (file_exists($codebuilder = JPATH_SITE.DS.'components'.DS.'com_hwdvideoshare'.DS.'hwdvideoshare.class.php')) {
      require_once ($codebuilder);
     } else {
     echo JText::_('VideoFlow is not compatible with your version of HWDvideoshare. Try a newer version of HWDvideoshare.');
     }
    $regex = "#<embed src=['|\"](.*?[^>])['|\"]#i";
    $code = hwd_vs_tools::generateVideoPlayer($media);
    preg_match($regex, $code, $res);
    if (!empty($res[1])) $player = $res[1]; else $player = '';
    $regex = "#flashvars=['|\"](.*?[^>])['|\"]#i";
    preg_match($regex, $code, $vars);
    if (!empty($vars[1])) $flashvars = $vars[1]; else $flashvars = '';
    return array('player'=>$player, 'flashvars'=>$flashvars);
    }
    
    function getThumb($video) {
    if (file_exists($codebuilder = JPATH_SITE.DS.'components'.DS.'com_hwdvideoshare'.DS.'hwdvideoshare.class.php')) {
     require_once ($codebuilder);
     } else {
     echo JText::_('VideoFlow is not compatible with your version of HWDvideoshare. Try a newer version of HWDvideoshare.');
     return;
     }
     return hwd_vs_tools::generateThumbnailURL ($video->id, $video->video_id, $video->video_type, $video->thumbnail, "normal"); 
    }
    
    function countFavs ($mid){
      $db = & JFactory::getDBO();
      $query = 'SELECT COUNT (*) FROM #__vflow_mymedia WHERE mid='.(int) $mid. 'AND component = "hwdvideoshare"';
      $db->setQuery($query);
      return $db->loadResult();
    }
    
    function getMyvidsFB ($userid=null, $faceid=null)
    {
      
    $db = & JFactory::getDBO();
    
    $query = 'SELECT DISTINCT mid FROM #__vflow_mymedia WHERE component = "hwdvideoshare" AND (faceid = '.(int) $faceid;
    
    if (!empty($userid)) $query .= ' OR jid='. (int) $userid;
    
    $query .= ')';
    
    $db -> setQuery ($query);
    
    $res = $db->loadResultArray();
    
    if (!empty($res)) return $this->getData($res); else return false;
    
    }
    
    function getCatList()
    {
      $db = & JFactory::getDBO();
      $query = 'SELECT SQL_CALC_FOUND_ROWS id, category_name AS name, thumbnail AS pixlink, category_description AS `desc` FROM #__hwdvidscategories WHERE published = 1';
      $db->setQuery($query, $this->getState('limitstart'), $this->getState('limit') );
      $res = $db->loadObjectList();
      $db->setQuery('SELECT FOUND_ROWS();');
      $this->_total = $db->loadResult();
      if (!empty($res)) $res = $this->getCatThumb($res);
      return $res;
    }
    
    function getCatName($cat)
    {
      $db = & JFactory::getDBO();
      $query = 'SELECT category_name FROM #__hwdvidscategories WHERE id = '.(int) $cat;
      $db->setQuery($query);
      return $db->loadResult();
    }

    
    function getCatThumb($cat)
    {
    if (file_exists($codebuilder = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_hwdvideoshare'.DS.'config.hwdvideoshare.php')) {
    require_once ($codebuilder);
    } else {
    return $cat;
    }

    $db = & JFactory::getDBO();
    $category = array();
    foreach ($cat as $cat){ 
        if (empty($cat->pixlink)) {
        $query = 'SELECT *'
						. ' FROM #__hwdvidsvideos'
						. ' WHERE category_id = '.$cat->id
						. ' AND published = 1'
						. ' AND approved = "yes"'
						. ' ORDER BY date_uploaded DESC'
						. ' LIMIT 0, 1'
						;
		    $db-> setQuery($query);
        $vid = $db-> loadObject();
        if (!empty($vid)) $cat->pixlink = $this->getThumb($vid);
        if (empty($cat->pixlink)) $cat->pixlink = URL_HWDVS_IMAGES.'default_thumb.jpg';
        }
    array_push($category, $cat);			
	}
	return $category;
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