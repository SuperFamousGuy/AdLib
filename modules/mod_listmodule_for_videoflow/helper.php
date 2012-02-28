<?php

// VideoFlow List Module //
/**
* @ Version 1.1.1 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow List Module is free software
* @ Requires VideoFlow Multimedia Component available at http://www.videoflow.tv
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/	

// Prevent direct access

defined('_JEXEC') or die('Direct Access to this location is not allowed.');



class ModVideoflowList 
{
    
    var $task = null;
    var $limit = 10;
    var $cats = null;
    var $daycount = 7;
    var $vparams = null;
    
    function getVparams() 
    {
            $db = & JFactory::getDBO();
            $query = 'SELECT * FROM #__vflow_conf';
            $db->setQuery($query);
            return $db->loadObject();
    }
    
    
  
    function getData() 
    {
            if ($this->task == "categories") return $this->getCatList();
            $db = & JFactory::getDBO();
            $query = $this-> buildQuery();
            $db->setQuery($query, 0, $this->limit);
            $data = $db->loadObjectList();
            return $data;
    }


    function buildQuery()
	  {
		    $opt = JRequest::getVar('option');
	      $id = JRequest::getInt('id');
        $where = ' WHERE published = "1"';
        if ($this->task == "featured") $where .= ' AND media.recommended="1"';
        if ($this->task == 'weeklyview'){
        $where .= ' AND DATE_SUB(CURDATE(),INTERVAL '.$this->daycount.' DAY) <= dateadded';
        }
        if (!empty($this->cats)) {
        $cats = explode(',', $this->cats);
        $where .= ' AND media.cat = ' . implode( ' OR media.cat = ', $cats );
        }
        if ($opt == 'com_videoflow' && (!empty($id))) $where .= ' AND media.id !='.(int) $id;
        $orderby = ' ORDER BY';
        if ($this->task == "popular" || $this->task == 'weeklyview') {
        $orderby .= ' media.views DESC';
        } elseif ($this->task == 'hirated'){
        $orderby .= ' media.rating / media.votes DESC, media.votes DESC';
        } elseif ($this->task == 'random') {
        $orderby .= ' RAND()';
        } else {
        $orderby .= ' media.dateadded DESC'; 
        }
        $query = 'SELECT'.$this->getSubquery().
			           $where.
			           $orderby;
        return $query;
	   }
	   
	   function getSubquery(){
        $query = ' media.*, u.name, u.username, c.name AS catname'. 
                 ' FROM #__vflow_data AS media' .
                 ' LEFT JOIN #__users AS u ON u.id = media.userid'.
                 ' LEFT JOIN #__vflow_categories AS c ON c.id = media.cat';
        return $query; 
     }
     
    
    function getCatList(){
    include_once (JPATH_SITE.DS.'components'.DS.'com_videoflow'.DS.'helpers'.DS.'videoflow_category_manager.php');
    $rows = VideoFlowCategoryManager::getCategories();
        if (is_array($rows)){
        $db = &JFactory::getDBO();
        foreach ($rows as $row){
        $row->id = $row->catid;
        $row->title = $row->name;
        $row->views = '';
        $row->catname = $row->name;
        $row->dateadded = '';
        $row->type = '';
        if (empty($row->pixlink)) {
        $query = 'SELECT pixlink FROM #__vflow_data WHERE cat='.(int) $row->id;
        $db->setQuery( $query );
        $pix = $db->loadResult ();
        } else {
        $pix = $row->pixlink;
        }
        if (!empty($pix)) {
          if (stristr($pix, 'http') === FALSE) {  
          $pix = JURI::root().$this->vparams->mediadir.'/_thumbs/'.$pix;
          } else {   
          $pix = $pix;
          }
        } else {
        $pix = JURI::root().'components/com_videoflow/players/vflow.jpg';
        }
        $row->pixlink = $pix;
        }
      }
    if (count($rows)> $this->limit) {
    $rows = array_slice ($rows, 0, $this->limit);
    }
    return $rows;
    }
    
    function getFlowid ()
    {
    $query = "SELECT id FROM #__menu WHERE link LIKE '%com_videoflow%' AND published = '1'";
    $db = &JFactory::getDBO();     
    $db -> setQuery($query);
    return $db -> loadResult();
    } 
    
    
    function getLabel ()
    {
        switch($this->task) {
          
          case 'latest':
          default:
          $label = JText::_('LATEST MEDIA');
          break;
          
          case 'featured':
          $label = JText::_('FEATURED MEDIA');
          break;
          
          case 'popular':
          $label = JText::_('POPULAR MEDIA');
          break;
          
          case 'random':
          $label = JText::_('RANDOM MEDIA');
          break;
          
          case 'hirated':
          $label = JText::_('HIGHLY RATED MEDIA');
          break;
          
          case 'weeklyview':
          $label = JText::_('POPULAR THIS WEEK');
          break;
          
          case 'categories':
          $label = JText::_('LM_CATEGORIES');
          break;
        }
        return $label;
	  }    
}