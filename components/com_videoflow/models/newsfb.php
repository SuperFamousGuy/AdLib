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
 
jimport( 'joomla.application.component.model' );
 
class VideoflowModelNewsfb extends JModel
{
   
    var $_total = null;
    
    var $_pagination = null;
    
    var $_userid = null;
    
    var $_id = null;
    
    
    function __construct()
    {
        parent::__construct();
 
        global $vparams;      
        $limitstart = JRequest::getInt('limitstart', 0);
        $this->setState('limit', $vparams->limit);
        $this->setState('limitstart', $limitstart);
    }


    function getData() 
    {
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
        return $this->_data;
    }

     
    function _buildQuery()
    {
    global $vparams;
    require_once(JPATH_COMPONENT_SITE.DS.'models'.DS.'videoflow.php');
    $fbuser = JRequest::getVar('fbuser');
    if (!empty($fbuser)) {
    $vfuser = VideoflowModelVideoflow::getVFuserObj($fbuser);
    if (!empty($vfuser)){
    $user = & JFactory::getUser ($vfuser->joomla_id);
    }
    } 
    
    if (empty ($user)) $user = & JFactory::getUser();
    $config = &JComponentHelper::getParams( 'com_content' );
		$access		= !$config->get('show_noauth');
		$db = & JFactory::getDBO();
    $nulldate	= $db->getNullDate();
		$aid		= $user->get('aid', 0);
		$date =& JFactory::getDate();
		$now = $date->toMySQL();
    $where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nulldate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nulldate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;
		
	  if (!empty($this->_id)) $where .= ' AND a.id = '. (int) $this->_id; 
		$orderby		= 'a.modified DESC, a.created DESC';
		if (!empty($vparams->ncatid))
		{
			$ids = explode( ',', $vparams->ncatid );
			JArrayHelper::toInteger( $ids );
			$cfilter = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
		}
		if (!empty($vparams->nsecid))
		{
			$ids = explode( ',', $vparams->nsecid );
			JArrayHelper::toInteger( $ids );
			$sfilter = ' AND (s.id=' . implode( ' OR s.id=', $ids ) . ')';
		}

		// Content Items only
		$query = 'SELECT a.*, u.name, u.username, cc.title AS ctitle,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			($vparams->nfront == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			' LEFT JOIN #__users AS u ON u.id = a.created_by' .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			($vparams->ncatid ? $cfilter : '').
			($vparams->nsecid ? $sfilter : '').
			($vparams->nfront == '0' ? ' AND f.content_id IS NULL ' : '').
			' AND s.published = 1' .
			' AND cc.published = 1' .
			' ORDER BY '. $orderby;
    return $query;
    }
    
   function updateData(&$vlist) {
   global $vparams;
   require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
   foreach ($vlist as &$data) {
                if (!is_array($data)) {   
                        $data->introtext = $this->relToAbs($data->introtext);
                        $data->fulltext = $this->relToAbs($data->fulltext);
                        $data->pixlink = $this->findImage($data->introtext.$data->fulltext);
                        $data->introtext = $this->fixImage($data->introtext, 'introtext');
                        $data->fulltext = $this->fixImage ($data->fulltext, 'fulltext');
                        $data->sintro = stripslashes($this->runTool('xterWrap', trim($data->introtext), $vparams->commentlimit));
                        $data->sarticle = stripslashes($this->runTool('xterWrap', trim($data->fulltext), $vparams->commentlimit));
                        $data->sharelink = JRoute::_(ContentHelperRoute::getArticleRoute($data->slug, $data->catslug, $data->sectionid));
                        if (stristr($data->sharelink, 'http') === FALSE) $data->sharelink = JURI::root().ltrim($data->sharelink, '/');
                        if ($vparams->showfull) {
                        $data->link = $vparams->canvasurl.'&task=read&id='.$data->id.'&vf=1';
                        } else {
                        $data->link = $data->sharelink;                
                        }
                } else { 
                        $this->updateData($data);
                }
        }
        return $vlist;
  }
    

    function findImage($text) {
    $regex = "#<img[^>]+src=['|\"](.*?)['|\"][^>]*>#i";
    $image = "";
    if (preg_match($regex, $text, $res)) $image = $res[1];
    return $image;
    }
    
    function fixImage ($text, $type) {
    $task = JRequest::getCmd ('task');
    $regex = "#<img[^>]+src=['|\"](.*?)['|\"][^>]*>#i";
    if ($task == 'news') $rep = ''; else $rep = '<img src="$1" style="max-width:300px; float:left; margin: 0px 10px 10px 0px; padding: 0px; border: 1px solid #aaa;">';
    $text= preg_replace($regex, $rep, $text);
    return $text;
    }
    
       
    function relToAbs($str) {
    $str=preg_replace('#(href|src)="([^:"]*)("|(?:(?:%20|\s|\+)[^"]*"))#','$1="'.JURI::root().'$2$3',$str);
    return $str;
    }


    
    function getTotal()
    {
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
    }
   
    
    function getPagination()
    {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }   
        return $this->_pagination;
    }
    
 
function createResp()
{
  $resp = new stdClass();
  $resp ->status = false;
  $resp ->message = JText::_('An error occured. Unable to process request');
  $resp ->type = 'error';
  $resp ->task = 'status';   
  return $resp;  
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
}