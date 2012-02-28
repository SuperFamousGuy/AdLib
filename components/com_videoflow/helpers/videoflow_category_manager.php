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

class VideoflowCategoryManager {
  
    
   function newCat ($catname){
    $catid = '';
    $db = & JFactory::getDBO();
    $query = 'SELECT * FROM #__vflow_categories WHERE name = '.$db->Quote ($db->getEscaped ($catname, true), false );
    $db->setQuery($query);
    $cat = $db->loadObject();
    $catid = $cat->id;
    if (!$catid) {
      $newcat = new stdClass();
      $newcat->id = '';
      $newcat->name = $catname;
      $newcat->desc = '';
      $row = & JTable::getInstance ('Categories', 'Table');
        if (!$row->bind( $newcat)) {
    	     JError::raiseWarning( 500, $row->getError() );
    	     return $catid;
		    }
        if (!$row->store()) {
          JError::raiseWarning(500, $row->getError());
          return $catid;
        }
     $catid =  $row->id;
    }
  return $catid;
  }
  
    
    
  function getCategories(){     
    $carray = array();
    $db =& JFactory::getDBO();
    $query = 'SELECT * FROM #__vflow_categories';
    $db->setQuery( $query );
    $cats = $db->loadObjectList();
    if ($cats){
      foreach ($cats as $cat){
        $clist = new stdClass();
        $clist->catid = $cat->id;
        $clist->name = $cat->name;
        $clist->desc = $cat->desc;
        $clist->pixlink = $cat->pixlink;
        $clist->date = $cat->date;
        $carray[$cat->id] = $clist;
      }
    }
  
    $query = 'SELECT * FROM #__vflow_data WHERE cat = "0" AND published = "1"';
    $db->setQuery($query);
    $uncat = $db->loadObject();
    if (!empty($uncat)) {
    $date = & JFactory::getDate();
    $clist = new stdClass();
    $clist->catid = 0;
    $clist->name = JText::_('VF_CAT_NONE');
    $clist->desc = JText::_ ('Uncategorised media');
    $clist->pixlink = '';
    $clist->date = $date->toFormat();
    $carray[0] = $clist;
    }
    return $carray;
  }
  
  function getCatName($id)
  {    
    if (empty($id)) return JText::_('VF_CAT_NONE'); 
    $db =& JFactory::getDBO();
    $query = 'SELECT name FROM #__vflow_categories WHERE id='.(int) $id;
    $db->setQuery( $query );
    return $db->loadResult();
  }

  
  function getCatId($name){
  $db =& JFactory::getDBO();
  $query = 'SELECT id from #__vflow_categories WHERE name='.$db->Quote ($db->getEscaped ($name, true), false );
  $db->setQuery( $query );
  $id = $db->loadResult();
  if (empty($id)) $id = '';
  return $id;
  }

}