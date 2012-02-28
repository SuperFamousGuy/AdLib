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
jimport( 'joomla.application.component.controller' );
class VideoflowControllerMedia extends JController

{

	/**
	 * Constructor
	 */

	function __construct( $config = array() ) {
		VideoflowUtilities::setVideoflowTitle ('Media Manager', 'vflow.png');
		parent::__construct( $config );
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.manage', 'com_videoflow')) {
				return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'cleanup',	'display' );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'saveremote', 'save');
		$this->registerTask( 'unpublish', 'publish' );
		$this->registerTask( 'unrecommend', 'recommend' );
		$this->registerTask( 'applycats', 'savecats' );
		$this->registerTask( 'addcat',	'editcat' );
	}



	/**

	 * Display media list

	 */


	function display() {
	$app = &JFactory::getApplication();
	self::updatedbase( ); 
	$db =& JFactory::getDBO();
	$context			= 'com_videoflow.media.';
	$filter_order		= $app->getUserStateFromRequest( $context.'filter_order',	'filter_order',	'b.title', 'cmd' );
	$filter_order_Dir	= $app->getUserStateFromRequest( $context.'filter_order_Dir', 'filter_order_Dir',	'', 'word' );
	$filter_cat		= $app->getUserStateFromRequest( $context.'filter_cat', 'filter_cat', '',	'string' );
	$filter_server		= $app->getUserStateFromRequest( $context.'filter_server', 'filter_server', '', 'string' );
	$filter_media_type	= $app->getUserStateFromRequest( $context.'filter_media_type', 'filter_media_type', '', 'string' );
	$filter_featured_state	= $app->getUserStateFromRequest( $context.'filter_featured_state', 'filter_featured_state', '', 'string' );
	$filter_state		= $app->getUserStateFromRequest( $context.'filter_state',	'filter_state',	'', 'string' );
	$search			= $app->getUserStateFromRequest( $context.'search', 'search', '', 'string' );
	$limit			= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
	$limitstart 		= $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
	$vtask = JRequest::getCmd('task'); 
  	$where = array();
	if ( $filter_state ) {
		if ( $filter_state == 'P' ) {
			$where[] = 'b.published = 1';
		} else if ($filter_state == 'U' ) {
			$where[] = 'b.published = 0';
		}
	}
	
	if ( $vtask == 'cleanup'){
		$where[] = 'b.published = -1';
	}
	
	if ( $filter_featured_state ) {
		if ( $filter_featured_state == 'Y' ) {
			$where[] = 'b.recommended = 1';
		} else if ($filter_featured_state == 'N' ) {
			$where[] = 'b.recommended = 0';
		}
	}    
	
	if ($filter_media_type) {
		$where[] = 'b.type = ' .$db->Quote ($db->getEscaped ($filter_media_type, true), false );
	}
	
	if ($filter_cat) {
		$where[] = 'b.cat = ' .$db->Quote ($db->getEscaped ($filter_cat, true), false );
	}
		
	if ($filter_server) {
		$where[] = 'b.server = ' .$db->Quote ($db->getEscaped ($filter_server, true), false );
	}
	
	if ($search) {
		$where[] = 'LOWER(b.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	}
	$where	= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
	$orderby = ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', b.id';

	// Get the total number of records

	$query = 'SELECT COUNT(*)'
		. ' FROM #__vflow_data AS b'
		. $where
		;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = 'SELECT b.*'
		. ' FROM #__vflow_data AS b'
		. $where
		. $orderby
		;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();


	if ($vtask == 'cleanup') {
		if (empty($rows)) {
		JFactory::getApplication()->enqueueMessage( JText::_( 'There are no files to clean up' ), 'message' );
		} else {
		JFactory::getApplication()->enqueueMessage (JText::_('The listed file(s) have errors or have been marked for deletion and can\'t be played back. Edit them to fix the errors or delete them.'), 'error');
		}
	}	


    /**
	 * Build filter lists
	 */

	$javascript = 'onchange="document.adminForm.submit();"';

    // Category filter

	$cats = self::getCatList ();
	$lists['cat']	= JHTML::_('select.genericlist',  $cats, 'filter_cat', 'class="inputbox" size="1"'.$javascript, 'filter_value', 'cat', $filter_cat, '', '');

    // Server filter

	$server = self::genfilter($rows, 'server', 'Select Server');
	$lists['server'] = JHTML::_('select.genericlist',  $server, 'filter_server', 'class="inputbox" size="1"'.$javascript, 'filter_value', 'server', $filter_server, '', '');


    // Media type filter

	$mtype = self::genfilter($rows, 'type', 'Select Media Type');
	$lists['type']	= JHTML::_('select.genericlist',  $mtype, 'filter_media_type', 'class="inputbox" size="1"'.$javascript, 'filter_value', 'type', $filter_media_type, '', '');

    //Featured state filter
	
	$fselect = array (JText::_( 'Featured' )=>'Y', JText::_( 'Not Featured' )=>'N');
	$fstate = self::genfilter(NULL, 'yesno', 'Select Featured State', $fselect);
	$lists['recommended']	= JHTML::_('select.genericlist',  $fstate, 'filter_featured_state', 'class="inputbox" size="1"'.$javascript, 'filter_value', 'yesno', $filter_featured_state, '', '');

    // Published State filter
	
	$pselect = array (JText::_( 'Published' )=>'P', JText::_( 'Unpublished' )=>'U');
	$pstate = self::genfilter(NULL, 'yesno', 'Select Published State', $pselect);
	$lists['state']	= JHTML::_('select.genericlist',  $pstate, 'filter_state', 'class="inputbox" size="1"'.$javascript, 'filter_value', 'yesno', $filter_state, '', '');

    // Table ordering
	
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

    // Search filter
	
	$lists['search']= $search;
	require_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');
	$clist = VideoflowCategoryManager::getCategories();
	require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');
	VideoflowViewMedia::listMedia( $rows, $pageNav, $lists, $clist );
	} 	

	function categorylist() {
	
	$app = &JFactory::getApplication();
   	$context		= 'com_videoflow.categories.';
	$filter_order		= $app->getUserStateFromRequest( $context.'filter_order',	'filter_order',	'v.name', 'cmd' );
	$filter_order_Dir	= $app->getUserStateFromRequest( $context.'filter_order_Dir', 'filter_order_Dir',	'', 'word' );
	$limit			= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
	$limitstart 		= $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );      
	if (stripos($filter_order, 'v.') === false ) $filter_order = 'v.name';
	$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', v.id';
	$db =& JFactory::getDBO();


    // Get the total number of records
	$query = 'SELECT COUNT(*)'
		. ' FROM #__vflow_categories AS v'
		;
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = 'SELECT v.*'
		. ' FROM #__vflow_categories AS v'
		.$orderby 
		;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();

	// Table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');
	VideoflowViewMedia::listCats( $rows, $pageNav, $lists );
	} 


	/**

	 * Update media database

	 */

	 

  function updatedbase () {   
  global $vparams;
  
  jimport('joomla.filesystem.file');
  
  $stored_arr = array();  

 	$db =& JFactory::getDBO();

	$query = "SELECT file FROM #__vflow_data";

	$db->setQuery($query);

	$stored = $db -> loadResultArray();	

  if ($db->getErrorNum()) {

		JError::raiseError( 500, $db->stderr() );

		return false;

	}

  if ($stored){

    foreach ($stored as $stored){

      if (stristr($stored, '/')) $stored = end(explode('/', $stored));
      
      if (stristr($stored, '\\')) $stored = end(explode('\\', $stored));

       $stored_arr[$stored] = $stored; 

    }

  }
  
  if (!is_array ($new = self::getnew())){
  return false;
  }

  $user =& JFactory::getUser();

  $newfile = array_diff_key ($new, $stored_arr);

foreach ($newfile as $key=>$file)

  {

  $title = substr($key, 0, - 4);

  if (preg_match('/^vf_[0-9]{9}_/', $title)){

  $title = ltrim($title, substr($title, 0, 13)); 

  }
  
  if ($vparams->autothumb) {
            
      $uptype = strtolower(JFile::getExt($key));
      
	if ($uptype == 'mp4' || $uptype == 'flv') {
                
		$pixlink = $this->runTool('genThumb', $file, $title.'.jpg');
                
		if (!empty($pixlink)) $pixlink = $pixlink; else $pixlink = '';
                
            }
        }

  $myfile = array('id'    => '', 

                  'cat'   => '',

                  'title' => $title, 

                  'details'=>'',

                  'file'   => $key,

                  'type'   => substr ($key, - 3), 

                  'pixlink' => $pixlink,

                  'server' =>'local',

                  'views' =>'',

                  'dateadded'=> JFactory::getDate()->toFormat(),

                  'published'=>'1',

                  'download'=>'1',

                  'recommended'=>'0',

                  'tags' =>'',

                  'lastclick' => '',

                  'userid' => $user->id );


  $row=& JTable::getInstance('Media', 'Table');

    if (!$row -> bind($myfile)) {

        return JError::raiseWarning(500, $row->getError());

    }


    if (!$row -> store()) {

         return JError::raiseWarning(500, $row->getError());

      }
	
	if (!empty($row->id) && !empty($vparams->appid) && !empty($vparams->bwallposts)) $this->createPost ($row->id);		

    }

  }

  

  function getnew() {
  
  global $vparams;

  $abmediadir = JPATH_ROOT.DS.$vparams->mediadir;  

  $mediafile = new RecursiveDirectoryIterator("$abmediadir");

  $items = array();

  foreach(new RecursiveIteratorIterator($mediafile) as $file)

  {  

  if (!self::isMedia (DS.'_thumbs'.DS, $file) && (self::isMedia ('.flv', $file) || self::isMedia ('.swf', $file) || self::isMedia ('.aac', $file) || self::isMedia ('.mp3', $file) || self::isMedia ('.jpg', $file) || self::isMedia ('.png', $file) || self::isMedia ('.gif', $file) || self::isMedia ('.mp4', $file) || self::isMedia ('.vp6', $file)) ) {

    $file = realpath($file);

    if (stristr ($file, '/') ) {
    
    $xfile = end(explode ('/', $file));
    
    } else if (stristr ($file, '\\')) {
    
     $xfile = end(explode ('\\', $file));
    
    }

    $items[$xfile] = $file;

    }

  }

 return $items; 

}



  function genpath ($filepath) {

    include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

    return videoflowFileManager::genurl($filepath);

  }


function getMedia($id)
    {
       global $vparams;
       $db =& JFactory::getDBO();
       $query = 'SELECT media.*, u.name, u.username, c.name AS catname'. 
                 ' FROM #__vflow_data AS media' .
                 ' LEFT JOIN #__users AS u ON u.id = media.userid'.
                 ' LEFT JOIN #__vflow_categories AS c ON c.id = media.cat'.		
		 ' WHERE published="1" AND media.id = '. (int) $id;
       $db->setQuery($query);
       $media = $db->loadObject(); 
       if ($vparams->repunderscore) {
       $media->title = str_replace('_', ' ', $media->title);
       }
       $media->shorttitle = stripslashes($this->runTool('xterWrap', $media->title, $vparams->shorttitle));
       $media->title = stripslashes($this->runTool('xterWrap', $media->title, $vparams->titlelimit));
       $media->title = str_replace("'", "", $media->title);
       $media->details = stripslashes($this->runTool('xterWrap', $media->details, $vparams->commentlimit));
       if (empty($media->catname)) {
          $media->catname = JText::_('VF_CAT_NONE'); 
       }       
       if (!empty($media->pixlink)) {
         if ($media->server == 'local' && stristr($media->pixlink, 'http') === FALSE) {  
         $media->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->pixlink;
         }
       }
      if ($media->server == 'local' && stristr($media->file, 'http') === FALSE) {
        include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php'); 
        $subdir = VideoflowFileManager::getFileInfo ($media->type);
        $media->file = JURI::root().$vparams->mediadir.'/'.$subdir['dir'].'/'.$media->file;
      }
       $media->shortname = stripslashes($this->runTool('xterWrap', $media->name, $vparams->shortname));
       return $media;
       }
  
    function _buildCode($media, $env = null)
    {
    $server = $media->server;
    if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') {
    return $this->photoCode($media);
    }
      if (empty($server)){
      $server = 'local';
      }
      if ($server != 'local') {
      $xserver = substr($server,0,strpos($server,'.'));
      if (!empty($xserver)) $server = $xserver;
      }
    if (file_exists($codebuilder = JPATH_COMPONENT_SITE.DS.'servers'.DS.'output'.DS.$server.'.php')) {
    require_once ($codebuilder);
    }
    $sclass = 'Videoflow'.ucfirst($server).'Play';
    $pclass = new $sclass;
    return $pclass->buildEmbedcode($media, $env);
    }
    
    function photoCode($media)
    {
    global $vparams;
    $c = JRequest::getCmd ('c');
    if ($c == 'fb') $pwidth = $vparams->fbpwidth; else $pwidth = $vparams->playerwidth;
    $file = $this->genMediaLink ($media, 'photos');
    return '<img src="'.$file.'" width="'.$pwidth.'" / >';
    }
  
        
  function createPost($id) {
  $vfile = JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_fb_tools.php';
  $this->runTool('vfileInc', $vfile, 'vft');
  if (!class_exists('VideoflowFbTools')) return false;
  $media = $this->getMedia($id);
  if (empty($media->favoured)) $media->favoured = '';
  $fv = $this->_buildCode($media, 'fb');
  if (!empty($fv)) {
  $fvc = $fv['player'].'?'.$fv['flashvars'];
  } else {
  $fvc = '';
  }
  $media->fvc = $fvc;
  $vpost = new VideoflowFbTools;
  $vpost->fbwallPost($media);
}


  /**

	 * Generate VideoFlow filters

	 */

  function genfilter($source, $filtertype, $filtertext, $select=NULL) {

  $fids = array(); 

  if (!empty($filtertext)){

  $obj = new stdClass;

  $obj-> filter_value = NULL;

  $obj-> $filtertype = '- '.JText::_($filtertext).' -';

  $fids[] = $obj;

  }

  if (is_array($source)){

  foreach ($source as $source){

  $new [] = $source-> $filtertype;

  } 

  if (!empty($new)) {

  $new = array_unique(array_filter($new));

  foreach ($new as $value){

  $obj = new stdClass;

  $obj -> filter_value = $value;

  $obj -> $filtertype = $value;

  array_push ($fids, $obj);

  }

  }

  } elseif ($filtertype == 'yesno') {

  if (empty ($select)){

  $select = array ('Yes'=>'Y', 'No'=>'N');

  }

  foreach ($select as $key=>$value){

  $obj = new stdClass;

  $obj -> filter_value = $value;

  $obj -> $filtertype = $key;

  array_push ($fids, $obj);

  }

  }

  return $fids;

  }

  

  function getCatList(){

  $db =& JFactory::getDBO();

  $query = 'SELECT * from #__vflow_categories';

  $db->setQuery( $query );

  $clist = $db->loadObjectList();

  $obj = new stdClass();

  $obj -> filter_value = '';

  $obj ->cat = JText::_('- Select Category -');

  $carray = array($obj);

  foreach ($clist as $clist){

  $obj = new stdClass();

  $obj->filter_value = $clist->id;

  $obj->cat = $clist->name;

  array_push($carray, $obj);

  }

  return $carray;

  }

      

  function edit($option='com_videoflow', $uid=NULL) {
	 
  $cid	= JRequest::getVar('cid', array(0), 'method', 'array');
  
  $cid = (int) $cid[0];

   $db =& JFactory::getDBO();

   $row =& JTable::getInstance('Media', 'Table');

   $row->load( $cid );       

   $cat = $row->cat;

   $server = $row->server;

   $query = 'SELECT * FROM #__vflow_data';

   $db->setQuery($query);

   $rows = $db->loadObjectList();

   $catlist = self::getCatList();

   $mlist['catlist'] = JHTML::_('select.genericlist',  $catlist, 'cat', 'class="inputbox" size="1"', 'filter_value', 'cat', $cat, '', '');

   $serverlist = self::genfilter($rows, 'server', 'Select Server');

   $mlist['serverlist'] = JHTML::_('select.genericlist',  $serverlist, 'server', 'class="inputbox" size="1"', 'filter_value', 'server', $server, '', '');

   require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

	 VideoflowViewMedia::editMedia( $option, $row, $mlist );

  }



  function editcat($option='com_videoflow', $uid=NULL) {

	
  $db =& JFactory::getDBO();
  
  $cid	= JRequest::getVar('cid', array(0), 'method', 'array');
  
  $cid = (int) $cid[0];

   $row =& JTable::getInstance('Categories', 'Table');

   $row->load( $cid );       

   require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

	 VideoflowViewMedia::editCat( $option, $row );

  }


  function direct() {
	
   JRequest::checkToken() or jexit( 'Invalid Token' );

   $post = JRequest::get( 'post' );	

    if (array_key_exists('ssubmit', $post)){

    self::vbrowser();

    } else {

    self::save();

    }

  }



 function directc()

  {   

  JRequest::checkToken() or jexit( 'Invalid Token' );

  $post	= JRequest::get( 'post' );	

    if (array_key_exists('ssubmit', $post)){

    self::vbrowserc();

    } elseif (empty($post['serverpix'])) {

    JError::raiseWarning(500, 'No thumnail selected!');

    self::vbrowserc();

    } else {

    self::savecats();

    }

  }





  function cancelcats() {
  $this->setRedirect( 'index.php?option=com_videoflow&task=categorylist' );
  }

  function savecats() {

  global $vparams;

  JRequest::checkToken() or JExit('Invalid Token');

  $post = JRequest::get ('post');

  $newfile = JRequest::get('files');

  $task = JRequest::getCmd ('task');

  $jr = false;

  if (!empty($newfile)) {

  $folder = JPATH_ROOT.DS.$vparams->mediadir; 

  require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

	$status = VideoflowFileManager::fileUpload( $newfile['deskpix'], $folder.DS."_thumbs", $vparams->maxthumbsize*1024);	

	   if($status && (!JError::isError($status))){

	   $post['pixlink'] = $status['fname'];

	   } else {

     $err = JText::_('Error uploading thumbnail.');

     echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload ("'.$err.'");</script>';

     return;  

     }
     
     $jr = true;

  } elseif (!empty($post['serverpix'])) {

  $post['pixlink'] = $post['serverpix'];

  $jr = true;

  }

  $row =& JTable::getInstance('Categories', 'Table');

 	if (!$row->bind( $post)) {

    	return JError::raiseWarning( 500, $row->getError() );

	}

  if (!$row->store()) {

      return JError::raiseWarning(500, $row->getError());

  }

  if ($jr) {

  echo '<script language="javascript" type="text/javascript">window.top.window.closeRefresh("'.$row->id.'", "editcat");</script>';  

  } else {

  $link = 'index.php?option=com_videoflow&task=categorylist';

  if ($task == 'applycats') $link = 'index.php?option=com_videoflow&task=editcat&cid[]='.$row->id;

  $message = JText::_('Category saved.');

  $this->setRedirect ($link, $message, 'message');

  }

  }

  

  	function deletecat()

	{

	// Check for request forgeries

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_videoflow&task=categorylist' );

		$db		=& JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		$n		= count( $cid );

		JArrayHelper::toInteger( $cid );

    

		if ($n)

		{      

      $query = 'DELETE FROM #__vflow_categories'

			. ' WHERE id = ' . implode( ' OR id = ', $cid )

			;

			$db->setQuery( $query );

			if (!$db->query()) {

				JError::raiseWarning( 500, $db->getError() );

			}

    }

		$this->setMessage( JText::sprintf( 'Items removed', $n ) );

	}


function saveXpload(){
    
    global $vparams;
      
    JRequest::checkToken('get') or JExit( 'Invalid Token' );
    
    require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

    $res = VideoflowFileManager::saveXpload();

    if (!empty($res)) {

     self::save($res);

    } 

}



  function save($newfile = null) {

     global $vparams, $fixbrowser, $maxthumbsize, $maxmedsize;  

    jimport('joomla.filesystem.file');
    
    if (empty($newfile)) {

		if (!JRequest::checkToken() && !JRequest::checkToken('get')) jexit( 'Invalid Token' );

		$newfile = JRequest::get( 'files' );
		
		}
		
		$post	= JRequest::get( 'post' );
		
		if (empty($post['media_id'])) $post['media_id'] = JRequest::getInt('media_id');

		$task = JRequest::getCmd( 'task' );

    $date = &JFactory::getDate();

 		$db =& JFactory::getDBO();
	  
    $folder = JPATH_ROOT.DS.$vparams->mediadir; 

    $logfile = JPATH_COMPONENT_SITE.DS.'logs'.DS.'uploadlog.txt';
 
    
    if ($task == 'saveremote') {

    $query = 'SELECT * FROM #__vflow_data WHERE file ='.$db->quote($post['file']).
             ' OR title LIKE '.$db->quote ('%'.$db->getEscaped ($post['title'], true).'%',false );
    
    $db-> setQuery($query);
    
    $mres = $db->loadObject();
    
      if (!empty($mres)) {
     
      return JError::raiseWarning(500, JText::_('This file already exists in the database!'));
     
      } 
    }
  
    if( !empty($newfile['Filedata']['name']) ){

      $uptype = strtolower(JFile::getExt($newfile['Filedata']['name']));

      $user =& JFactory::getUser();

      $newfile['Filedata']['user'] = $user->username;

      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

    	if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

        $contents = fwrite($fp, "===================================================\r\n");

		    $contents = fwrite($fp, JText::_("Single Upload: File details:")." \r\n");

		    $contents = fwrite($fp, print_r($newfile['Filedata'],true));

		    $contents = fwrite($fp, "\r\n");

		    fclose($fp);

	    }

    

      if (!$subdir = self::dirselect($uptype)){

          $status =  JText::_('Unable to determine upload directory');

          $data ['1']['success'] = JText::_("NO");

	        $data ['1']['error'] = $status;

	        $data ['1']['user'] = $user->username;

	        $data ['1']['date'] = $date->toFormat();

	        if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                  fclose($fp);

          }

          jexit();

      }

      $filepath = JPATH_ROOT.DS.$vparams->mediadir.DS.$subdir.DS; 

			    if(!file_exists($filepath)) mkdir($filepath,0777);

			    chmod($filepath,0777);

   			  $status = VideoflowFileManager::fileUpload( $newfile['Filedata'], $folder.DS.$subdir, $vparams->maxmedsize*1024*1024);	

   			  chmod($filepath,0755);

           if (JError::isError($status)){

               $data ['1']['success'] = JText::_("NO");

	             $data ['1']['error'] = $status->message;

	             $data ['1']['user'] = $user->username;

	             $data ['1']['date'] = $date->toFormat();

	                if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                  fclose($fp);

                  }

              jexit();

          }

          

          $query = "SELECT * FROM #__vflow_data WHERE id ='".$post['media_id']."'";

	        $db->setQuery($query);

	        $data = $db -> loadAssocList();

	        $data['0']['file'] = $status['fname'];   
          
		$data['0']['medialink'] = $status['flink']; 

	        $data['0']['userid'] = $user->id;

	        $data['0']['type'] = $uptype;

	        $data['0']['server'] = "local";

	        $data['0']['published'] = 1; 

	        $data['1']['success'] = JText::_("YES");

	        $data['1'] ['location'] = $status['fpath'];

	        $data['1']['user'] = $user->username;

	        $data['1']['date'] = $date->toFormat();



    if (!empty ($data) && (file_exists($status['fpath']))){

        $post = $data['0'];
	
	if (empty($post['pixlink']) && $vparams->autothumb) {
            
	    if ($uptype == 'mp4' || $uptype == 'flv') {
                
		$pixlink = $this->runTool('genThumb', $status['fpath'], JFile::stripExt ($status['fname']).'.jpg');
                
		if (!empty($pixlink)) {
                    
		    $post['pixlink'] = $data['0']['pixlink'] = $pixlink;
                
		}
            
	    }
        
	}


        if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

            $contents = fwrite($fp, JText::_("Media File Details:")." \r\n"); 

            $contents = fwrite($fp, print_r($data['0'], true)." \r\n"); 

            $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

            $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

            fclose($fp);

        }

    } else {

        $data ['2']['success'] = JText::_("NO");

	      $data ['2']['error'] = JText::_("Unknown error");

	      $data ['2']['user'] = $user->username;

	      $data ['2']['date'] = $date->toFormat();

	      if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	       	

              $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

              $contents = fwrite($fp, print_r($data['2'], true)." \r\n"); 

              fclose($fp);

        }

        jexit();

       }

    }  			  

    elseif( !empty($newfile['myfile']['name']) ){  

      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

			$status = VideoflowFileManager::fileUpload( $newfile['myfile'], $folder.DS."_thumbs", $vparams->maxthumbsize*1024);	

			if(!$status || JError::isError($status)){

				$treport = JText::_('Error uploading thumbnail. You can still upload your media file below...');

			} else {

      $post['pixlink'] = $status['fname'];

        if (!JError::isError(self::writedata($post))){

        $treport = JText::_('Thumbnail uploaded successfully. Now upload your media file below...');

        } 

      }

    echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload ("'.$treport.'");</script>';      

    jexit();

    }	

    elseif( !empty($newfile['deskpix']['name']) ){  

      $treport = JText::_('Error uploading thumbnail. Select thumbnail from server below or close this window to continue.');

      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

			$status = VideoflowFileManager::fileUpload( $newfile['deskpix'], $folder.DS."_thumbs", $vparams->maxthumbsize*1024);	

		 	if($status && (!JError::isError($status))){

			$post['pixlink'] = $status['fname'];

			   if (!JError::isError($row = self::writedata($post))){

			   echo '<script language="javascript" type="text/javascript">window.top.window.closeRefresh("'.$row->id.'", "edit");</script>';      

			   jexit();

        }

      }

     echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload ("'.$treport.'");</script>';      

     jexit();

    }

   elseif (!empty ($post['serverpix'])){

    $post['pixlink'] = $post['serverpix'];

    }

    

    if ($task == 'direct' && (empty ($post['pixlink']))){

    	return JError::raiseWarning( 500, JText::_('No thumbnail selected or uploaded.'));

    }

        

    if (!empty($post['newcat'])){

    include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');

    $catid = VideoflowCategoryManager::newCat($post['newcat']);

    $post['cat'] = $catid;

    }

				

    if (JError::isError($row = self::writedata($post))){

        $message = $row;

        } else {

        $message = JText::_( 'Item Saved.' );

        }

   	   

	switch ($task) {

		case 'apply':
		$link = 'index.php?option=com_videoflow&task=edit&cid[]='. $row->id;
		break;
		
		case 'direct':
		echo '<script language="javascript" type="text/javascript">window.top.window.closeRefresh("'.$row->id.'", "edit");</script>';      
		break;
	
		case 'saveremote':
		$link = 'index.php?option=com_videoflow&task=vfembed&tmpl=component';
		break;

		case 'save':
		default:
		$link = 'index.php?option=com_videoflow';
		break;
	}

    

    if (!empty ($link)){

   	$this->setRedirect( $link, $message);

   	}

	}

  

  function writedata($data){

  

    $row =& JTable::getInstance('Media', 'Table');

 	  if (!$row->bind( $data)) {

    	return JError::raiseWarning( 500, $row->getError() );

		}

    if (!$row->store()) {

      return JError::raiseWarning(500, $row->getError());

    }

    return $row;

  }

  

  

  function getstatus(){

  global $vparams;

  require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php');

  $db =& JFactory::getDBO();

  $file	= JRequest::getString ( 'file' );

  $cid = JRequest::getInt ('cid');

  $message = JText::_("ERROR: Unable to upload the file")." ".$file;

  $query = "SELECT file FROM #__vflow_data WHERE id = '$cid'";

	$db->setQuery($query);

	$result = $db -> loadResult();

	$stat = new VideoflowTools();

	$stat->func = 'findSubstring';

	$stat->param1 = $file;

	$stat->param2 = $result;

  if ($stat->runTool()){

    $message = $file." ".JText::_("successfully uploaded and set."); 

  }

  $link = 'index.php?option=com_videoflow&task=edit&cid[]='.$cid;

  $this->setRedirect( $link, $message);

  }

  



  function dirselect($uptype){    

    switch ($uptype){

          case 'mp3':

          case 'aac':

          $dir = 'audio';

          break;

          

          case 'flv':

          case 'mp4':

          case 'swf':

          $dir = 'videos';

          break;

          

          case 'jpg':

          case 'gif':

          case 'png':

          $dir = 'photos';

          break;

          

          default:

          $dir = false;

          break;

        }  

        

  return $dir;

  }

 

  

  function thumbstatus(){

    $message = JText::_( 'New thumbnail set.' );

    $mid = JRequest::getInt('mid');

    $vtask = JRequest::getWord('vtask', 'edit');

    $link = "index.php?option=com_videoflow&task=".$vtask."&cid[]=".$mid;

    $this->setRedirect( $link, $message);

  }



	function cancel()

	{

		$this->setRedirect( 'index.php?option=com_videoflow' );

	}



  

  /**

	 * VideoFlow Browser method

	 */

	 

   function vbrowser() {

   global $vparams;

   require_once(JPATH_COMPONENT_SITE.DS.'helpers/class.navigator.php');

   $base = JPATH_ROOT.DS.$vparams->mediadir."/_thumbs";

   $data = JRequest::get ('get');

   $post	= JRequest::get( 'post' );	

   $obj= new Navigator($base);

   if (empty ($post)) $post['sortby'] = $post ['sortdir'] = null;

   $sortby = $post['sortby'];

   $sorttype = array("By Name"=>"N", "By Date"=>"D", "By Size"=>"S");

   $sorttype = self::genfilter(NULL, 'yesno', '', $sorttype);

   $obj->sortby = JHTML::_('select.genericlist',  $sorttype, 'sortby', 'class="inputbox" size="1"', 'filter_value', 'yesno', $sortby, '', '');

   $sortdir = $post['sortdir'];

   $dirsort = array ("Asc"=>"ASC", "Desc"=>"DESC");

   $dirsort = self::genfilter(NULL, 'yesno', '', $dirsort);

   $obj->sortdir = JHTML::_('select.genericlist',  $dirsort, 'sortdir', 'class="inputbox" size="1"', 'filter_value', 'yesno', $sortdir, '', '');

   $obj->SortListD($post['sortby'],$post['sortdir']);

   $obj->SortListF($post['sortby'],$post['sortdir']);

   if (array_key_exists('source', $data)){

   $qid = $data['id'];

   } else {

   $qid = $post['id'];

   }

   $db =& JFactory::getDBO();

   $query = 'SELECT * FROM #__vflow_data WHERE id = '.$qid;

   $db->setQuery($query);

   $row = $db->loadObject();

   if ($row){

      foreach ( $row as $key => $value ) {

      $obj->$key = $value;

      }

   }   

   require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

   VideoflowViewMedia::popBrowser( $obj );

   }


   function vbrowserc() {

   global $vparams;

   require_once(JPATH_COMPONENT_SITE.DS.'helpers/class.navigator.php');

   $base = JPATH_ROOT.DS.$vparams->mediadir."/_thumbs";

   $data = JRequest::get ('get');

   $post = JRequest::get( 'post' );

   $obj = new Navigator($base);

   $id = JRequest::getInt('id');

   if (empty ($post)) $post['sortby'] = $post ['sortdir'] = null;

   $sortby = $post['sortby'];

   $sorttype = array("By Name"=>"N", "By Date"=>"D", "By Size"=>"S");

   $sorttype = self::genfilter(NULL, 'yesno', '', $sorttype);

   $obj->sortby = JHTML::_('select.genericlist',  $sorttype, 'sortby', 'class="inputbox" size="1"', 'filter_value', 'yesno', $sortby, '', '');

   $sortdir = $post['sortdir'];

   $dirsort = array ("Asc"=>"ASC", "Desc"=>"DESC");

   $dirsort = self::genfilter(NULL, 'yesno', '', $dirsort);

   $obj->sortdir = JHTML::_('select.genericlist',  $dirsort, 'sortdir', 'class="inputbox" size="1"', 'filter_value', 'yesno', $sortdir, '', '');

   $obj->SortListD($post['sortby'],$post['sortdir']);

   $obj->SortListF($post['sortby'],$post['sortdir']);

   $obj->id = $id;  

   require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

   VideoflowViewMedia::popBrowser( $obj );

   }





//Initiate VFlow Flash upload 



  function popupload(){

     global $vparams;

     $id = JRequest::getInt ('id');

     $db =& JFactory::getDBO();

     $query = 'SELECT * FROM #__vflow_data WHERE id = '. (int) $id;

     $db->setQuery($query);    

     if (!$row = $db->loadObject()){

     JError::raiseWarning( 500, JText::_('Database error. Unable to initialise Flash upload.'));

     } else {

     require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

     VideoflowViewMedia::popVbrowser($row);

     }   

  }





	/**

	 * Copies one or more media files

	 */

	

  function copy()

	{

	// Check for request forgeries

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_videoflow' );

		$cid	= JRequest::getVar( 'cid', null, 'post', 'array' );

		$db		=& JFactory::getDBO();

		$table	=& JTable::getInstance('Media', 'Table');

		$user	= &JFactory::getUser();

		$date = &JFactory::getDate();

		$n		= count( $cid );

		if ($n > 0)

		{

			foreach ($cid as $cid)

			{

				if ($table->load( (int)$cid ))

				{

					$table->id = 0;

					$table->title = 'Copy of ' . $table->title;

					$table->views = 0;

					$table->published = 0;

					$table->recommended  = 0;

					$table->lastclick   = null;

					$table->favoured   = 0;

					$table->dateadded = $date->toFormat();

					$table->userid = $user->id;

					if (!$table->store()) {

						return JError::raiseWarning( $table->getError() );

					}

				}

				else {

					return JError::raiseWarning( 500, $table->getError() );

				}

			}

		}

		else {

			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );

		}

		$this->setMessage( JText::sprintf( 'Items copied', $n ) );

	}



  //Toggles publish:Unpublish



	function publish()
	{

	//	 Check for request forgeries

		JRequest::checkToken() or jexit( 'Invalid Token' );



		$this->setRedirect( 'index.php?option=com_videoflow' );



		// Initialize variables

		$db	=& JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		$task	= JRequest::getCmd( 'task' );

		$n	= count( $cid );

		

	switch ($task) {

        case 'publish':

        case 'unpublish':

        $publish	= ($task == 'publish');

        $field = 'published';

        $status = JText::sprintf( $publish ? 'Item(s) published' : 'Items unpublished', $n );

        break;

                

        case 'recommend':

        case 'unrecommend':

        $publish	= ($task == 'recommend');

        $field = 'recommended';

        $status = JText::sprintf( $publish ? 'Item(s) featured' : 'Items unfeatured', $n );

        break;

    }

		

		if (empty( $cid )) {

			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );

		}



		JArrayHelper::toInteger( $cid );

		$cids = implode( ',', $cid );



		$query = 'UPDATE #__vflow_data'

		. ' SET ' . $field . ' = ' . (int) $publish

		. ' WHERE id IN ( '. $cids.'  )'

		;

		$db->setQuery( $query );

		if (!$db->query()) {

			return JError::raiseWarning( 500, $db->getError() );

		}

		$this->setMessage( $status );

	}



	function remove()

	{

	// Check for request forgeries

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_videoflow' );

		$db		=& JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		$n		= count( $cid );

		JArrayHelper::toInteger( $cid );

    

		if ($n)
		{

		$query = 'SELECT file FROM #__vflow_data'

		. ' WHERE id = ' . implode( ' OR id = ', $cid )

		. ' AND server = "local"'

		;

		$db->setQuery ( $query );

		if (!$db->query()) {

			JError::raiseWarning( 500, $db->getError() );

		}

		$files = $db->LoadResultArray();

      if ( !empty($files )) {

      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

      if (!VideoflowFileManager::delete($files)) {

      JError::raiseWarning( 500, JText::_( 'Unable to delete file(s) from media directory. You may delete them with ftp or a file manager component' ) );

      }

      }

      

      $query = 'DELETE FROM #__vflow_data'

			. ' WHERE id = ' . implode( ' OR id = ', $cid )

			;

			$db->setQuery( $query );

			if (!$db->query()) {

				JError::raiseWarning( 500, $db->getError() );

			}

    }

		$this->setMessage( JText::sprintf( 'Items removed', $n ) );

	}



  function recommend() {

  self::publish();
  
  }



  function vhelp() {

  $vlink	= JRequest::getString( 'helplink' );

  if ($vlink){

  $this->setRedirect( 'http://videoflow.fidsoft.com/index.php?option=com_content&view=article&id='.$vlink );

  }	

  }

  function vxupload()
  {
  	JRequest::checkToken('get') or jexit('Invalid Token');
  	
  	require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

    $res = VideoflowFileManager::saveXpload();

    if (!empty($res)) {

     self::vupload($res);

    } 

  }

 

  function vupload ($newfile=null){

    global $vparams;
    
    if (empty($newfile)) {

   	JRequest::checkToken('get') or jexit( 'Invalid Token' );

		$newfile = JRequest::get( 'files' );
		
		}

	  $user =& JFactory::getUser();

    $date = &JFactory::getDate();

	  $folder = JPATH_ROOT.DS.$vparams->mediadir; 

    $logfile = JPATH_COMPONENT_SITE.DS.'logs'.DS.'uploadlog.txt';

    

    if( !empty($newfile['Filedata']['name']) ){

      jimport('joomla.filesystem.file');

      $uptype = strtolower(JFile::getExt($newfile['Filedata']['name']));

      $newfile['Filedata']['user'] = $user->username;

      require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_file_manager.php');

       	if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

        $contents = fwrite($fp, "===================================================\r\n");

		    $contents = fwrite($fp, JText::_("Queue Upload: File details:")." \r\n");

		    $contents = fwrite($fp, print_r($newfile['Filedata'],true));

		    $contents = fwrite($fp, "\r\n");

		    fclose($fp);

	    }


      if (!$subdir = self::dirselect($uptype)){

          $status =  JText::_('Unable to determine upload directory');

          $data ['1']['success'] = JText::_("NO");

	        $data ['1']['error'] = $status;

	        $data ['1']['user'] = $user->username;

	        $data ['1']['date'] = $date->toFormat();

	        if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                  fclose($fp);

          }

          jexit();

      }



      $filepath = JPATH_ROOT.DS.$vparams->mediadir.DS.$subdir.DS; 

			    if(!file_exists($filepath)) mkdir($filepath,0777);

			    chmod($filepath,0777);

   			  $status = VideoflowFileManager::fileUpload( $newfile['Filedata'], $folder.DS.$subdir, $vparams->maxmedsize*1024*1024);	

   			  chmod ($filepath,0755);

          if (JError::isError($status)){

               $data ['1']['success'] = JText::_("NO");

	             $data ['1']['error'] = $status->message;

	             $data ['1']['user'] = $user->username;

	             $data ['1']['date'] = $date->toFormat();

	                if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                  fclose($fp);

                  }

              jexit();

          }

          if (file_exists($status['fname'])){

             $data['1']['success'] = JText::_("YES");

	           $data['1'] ['location'] = $status['fname'];

	           $data['1']['user'] = $user->username;

	           $data['1']['date'] = $date->toFormat(); 

                if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	 

                $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                fclose($fp);

                }

            } else {

            $data ['1']['success'] = JText::_("NO");

	          $data ['1']['error'] = JText::_("Unknown error");

	          $data ['1']['user'] = $user->username;

	          $data ['1']['date'] = $date->toFormat();

	             if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	       	

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

                  fclose($fp);

               }

            }

        } else {

               $data ['1']['success'] = JText::_("NO");

	             $data ['1']['error'] = JText::_("Valid files not found");

	             $data ['1']['user'] = $user->username;

	             $data ['1']['date'] = $date->toFormat();

               if($vparams->uploadlog && ($fp = fopen($logfile,"a+"))) {	       	

                  $contents = fwrite($fp, "===================================================\r\n");

		              $contents = fwrite($fp, JText::_("Queue Upload Failure!")." \r\n");

                  $contents = fwrite($fp, JText::_("Event Summary:")." \r\n"); 

                  $contents = fwrite($fp, print_r($data['1'], true)." \r\n"); 

               fclose($fp);

              } 			  

      }

  }

  

  function vfupload(){

  require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

  VideoflowViewMedia::popVupload();  

  }



  function vembed(){
	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	
	require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

		$embedlink = JRequest::getVar('embedlink');	

		if (empty($embedlink)) {

		  $verror = JText::_('You must provide the media link (URL) to fetch.');

      JError::raiseWarning( 500, JText::_($verror));

      VideoflowViewMedia::popVembed();

      return;

    }

		

		$parselink = parse_url(trim($embedlink));		

		$url = trim($parselink['host'] ? $parselink['host'] : array_shift(explode('/', $parselink['path'], 2)));

		preg_match('/(?P<server>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url, $data);
		
		if ($data['server'] == 'youtu.be') {
                    $data['server'] = 'youtube.com';
                    $embedlink = str_replace ('youtu.be/', 'youtube.com/watch?v=', $embedlink);
                }

		if (file_exists(JPATH_COMPONENT_SITE.DS.'servers'.DS.'input'.DS.$data['server'].'.php')) {

			 require_once (JPATH_COMPONENT_SITE.DS.'servers'.DS.'input'.DS.$data['server'].'.php');

			 include_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_category_manager.php');

			 $videoinfo = VideoflowRemoteProcessor::processLink($embedlink);			 

			 if (!empty($videoinfo)) {

			$user = & JFactory::getUser();
			
			$videoinfo->userid = $user->id;
			
			$videoinfo->dateadded = & JFactory::getDate()->toFormat();
             
		if (!empty($videoinfo->cat)) {
		
		$catid = VideoflowCategoryManager::getCatId($videoinfo->cat);
       
	      } else {
		
		$catid = '';
		
		}
       

       $videoinfo->catlist = JHTML::_('select.genericlist', self::getCatList(), 'cat', 'class="inputbox" size="1"', 'filter_value', 'cat', $catid, '', '');

       VideoflowViewMedia::saveRemote($videoinfo);

       } else {

       $verror = JText::_('An error occurred. Unable to save media file.');

       JError::raiseWarning( 500, JText::_($verror));

       VideoflowViewMedia::popVembed();

       } 

    } else {

      $verror = $data['server'].' '.JText::_('is not a supported server.');

      JError::raiseWarning( 500, JText::_($verror));

      VideoflowViewMedia::popVembed();

    }

  }
 	

  function vfembed(){

  require_once(JPATH_COMPONENT.DS.'views'.DS.'media.php');

  VideoflowViewMedia::popVembed();  

  }


  function printFooter(){

  $db = & JFactory::getDBO();

  $query = 'SELECT * FROM #__vflow_conf';

  $db->setQuery($query);

  $row = $db->loadObject();

  if (!empty($row->prostatus)) $type = 'Pro'; else $type = 'Standard';

  if (!empty($row->message)) {

    ?>       

        <fieldset class="adminform">

        	<legend><?php echo JText::_( 'Message Centre' ); ?></legend>

          <table class="admintable">

            <tr>	

            <td>

            <?php echo $this->getMsg($row);?>

            </td>

           </tr>

          </table>

        </fieldset>

  <?php

      } else {

      echo '<br /><br />';

      }  

    ?>    

        <fieldset class="adminform">

          <table class="admintable" align="center">

            <tr>	

            <td align="center">

            Installation and/or use of this software constitutes acceptance of <a href="<?php echo JRoute::_('index.php?option=com_videoflow&c=config&task=terms&format=raw'); ?>" class="modal-vfpop" rel="{handler: 'iframe', size: {x: 725, y: 520}}">terms and conditions</a>.

            <br />

            <br />

            <a href="http://www.videoflow.tv" target="_blank">VideoFlow</a> <?php echo $row->version.' '.$type;?> 

            <br />

           Copyright: 2008 - 2010 <a href="mailto: fideri@fidsoft.com"> Kirungi F. Fideri</a><br /><a href="http://www.fidsoft.com" target="_blank">fidsoft.com</a>

            </td>

            </tr>

          </table>

        </fieldset>

<?php

  }

  

  function getMsg ($row){

    $vsite = urlencode(JURI::root());

    $url = "http://www.fidsoft.com/index.php?option=com_fidsoft&task=news&vcode=$row->fkey&vmode=$row->vmode&vsite=$vsite&version=$row->version&format=raw";

    $message = $this->runTool('readRemote', $url);

    if (empty($message)) {

    $message = 'There are no new messages at this time.';

    }

    return $message;

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

	

   function isMedia ($type, $file){

    $pos = strpos($file, $type);

    if ($pos === false) {

       return false;

    } else {

       return true;

    }

  }	

}