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

$doc = &JFactory::getDocument();
$fupload = JURI::root().'components/com_videoflow/utilities/js/fupload.js';
$doc->addScript($fupload);

class VideoflowViewMedia
{
    
  function setMediaToolbar()
  {
    $tbar=& JToolBar::getInstance( 'toolbar' );
    JToolBarHelper::publishList();
    JToolBarHelper::unpublishList();
    JToolBarHelper::publishList('recommend', JText::_( 'Feature' ));
    JToolBarHelper::unpublishList('unrecommend', JText::_( 'Unfeature' ));
    JToolBarHelper::editListX();
    JToolBarHelper::addNewX();
    $tbar->appendButton( 'Popup', 'upload', JText::_( 'Upload' ), 'index.php?option=com_videoflow&task=vfupload&tmpl=component', 725, 520 );
    $tbar->appendButton( 'Popup', 'new', JText::_( 'Embed' ), 'index.php?option=com_videoflow&task=vfembed&tmpl=component', 725, 520 );
    $tbar->appendButton( 'Standard', 'trash', JText::_( 'Clean' ), 'cleanup', false);
    JToolBarHelper::deleteListX();  
    $tbar->appendButton( 'Standard', 'copy', JText::_( 'Categories' ), 'categorylist', false);
    $tbar->appendButton( 'Popup', 'help', JText::_( 'Help' ), 'http://videoflow.fidsoft.com/index.php?option=com_content&tmpl=component&view=article&id=61', 725, 520 );
  }

  function listMedia( &$rows, &$pageNav, &$lists, &$clist)
  {
    global $vparams;
    VideoflowViewMedia::setMediaToolbar();
    $user =& JFactory::getUser();
    JHTML::_('behavior.tooltip');
    JHTML::_('behavior.modal', 'a.modal-vfpop');
    if (version_compare(JVERSION, '1.6.0') < 0) {
    $imgpath = 'images/';
    } else {
    $app = &JFactory::getApplication();
    $activetemp = $app->getTemplate();
    $imgpath = 'templates/'.$activetemp.'/images/admin/';  
    }
    ?>
    <form action="index.php?option=com_videoflow" method="post" name="adminForm">
    <table>
      <tr>
	<td align="left" width="100%">
	<?php echo JText::_( 'Filter' ); ?>:
	<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
	<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
	<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_media_type').value='';this.form.getElementById('filter_cat').value='';this.form.getElementById('filter_server').value='';this.form.getElementById('filter_featured_state').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
	<?php
	echo $lists['type'];
	echo $lists['server'];
        echo $lists['cat'];
        echo $lists['recommended'];
	echo $lists['state'];
	?>
	</td>
      </tr>
    </table>

    <table class="adminlist">
    <thead>
      <tr>
	<th width="10">
	<?php echo JText::_( 'Num' ); ?>
	</th>
	<th width="15">
	<input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
	</th>
	<th width="70">
	<?php echo JText::_( 'Image' ); ?>
	</th>
        <th nowrap="nowrap" class="title">
	<?php echo JHTML::_('grid.sort',  'Title', 'b.title', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
	<th width="5%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Type', 'b.type', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
	<th width="10%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Server', 'b.server', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
        <th width="10%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Category', 'b.cat', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
	<th width="8%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Date', 'b.dateadded', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
        <th width="5%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Featured', 'b.recommended', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
	<th width="60">
	<?php echo JHTML::_('grid.sort',   'Views', 'b.views', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
	<th width="5%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'Published', 'b.published', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
        <th width="1%" nowrap="nowrap">
	<?php echo JHTML::_('grid.sort',   'ID', 'b.id', @$lists['order_Dir'], @$lists['order'] ); ?>
	</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
	<td colspan="12">
	<?php echo $pageNav->getListFooter(); ?>
	</td>
      </tr>
    </tfoot>
    <tbody>
    <?php
    $k = 0;
    $cdate = & JFactory::getDate();
    for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row = &$rows[$i];
      if($row->dateadded == '0000-00-00 00:00:00') $row->dateadded = $cdate->toFormat();
	$link = JRoute::_( 'index.php?option=com_videoflow&task=edit&cid[]='. $row->id );
	$published = JHTML::_('grid.published', $row, $i );
	$checked = JHTML::_('grid.id', $i, $row -> id );      
      if (!empty($row->pixlink)) {
         if (stripos($row->pixlink, 'http://') === FALSE) {  
         $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->pixlink;
         } else {
         $pixpreview = $row->pixlink;
         }
       } else if (empty($row->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$row->title.'.jpg')){
       $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->title.'.jpg';
       } else {
      $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
      }
      if ($row->recommended > 0 ){
        $rec = 'unrecommend';
        } else {
        $rec = 'recommend';
        }
      if ($row->published == 0 ){
        $pub = 'publish';
        } elseif ($row->published == 1)  {
        $pub = 'unpublish';
        } else {
        $pub = '';
        } 
	?>
      <tr class="<?php echo "row$k"; ?>">
	<td align="center">
	<?php echo $pageNav->getRowOffset($i); ?>
	</td>
	<td align="center">
	<?php echo $checked; ?>
	</td>
	<td align="center">
	<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit' );?>::<?php echo $row->title; ?>"><a href="<?php echo $link; ?>"> <img src="<?php echo $pixpreview; ?>" width=70 /></a></span>
	</td>
        <td>
	<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit' );?>::<?php echo $row->title; ?>">
	<a href="<?php echo $link; ?>"> <?php echo $row->title; ?></a>
	</span>
	</td>
	<td align="center">
	<?php echo $row->type;?>
	</td>
	<td align="center">
	<?php echo $row->server;?>
	</td>
	<td align="center">
	<?php echo $clist[$row->cat]->name;?>
	</td>
	<td align="center">
	<?php echo JHTML::_('date', $row->dateadded, JText::_('DATE_FORMAT_LC4')); ?>
	</td>
        <td align="center">
	<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $rec; ?>')" title="<?php echo ( $row->recommended ) ? JText::_( 'JYES' ) : JText::_( 'JNO' );?>">
	<img src="<?php echo $imgpath;?><?php echo ( $row->recommended ) ? 'tick.png' : 'publish_x.png' ;?>" width="16" height="16" border="0" alt="<?php echo ( $row->recommended ) ? JText::_( 'JYES' ) : JText::_( 'JNO' );?>" /></a>
	</td>
	<td align="center">
	<?php echo $row->views;?>
	</td>
	<td align="center">
	<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $pub; ?>')" title="<?php echo ( $row->published == 1) ? JText::_( 'JYES' ) : JText::_( 'JNO' );?>">
	<img src="<?php echo $imgpath;?><?php echo ( $row->published == 1 ) ? 'tick.png' : ( $row->published == 0 ? 'publish_x.png' : 'disabled.png' ) ;?>" width="16" height="16" border="0" alt="<?php echo ( $row->published ) ? JText::_( 'JYES' ) : JText::_( 'JNO' );?>" /></a>
	</td>
        <td align="center">
	<?php echo $row->id; ?>
	</td>
      </tr>
      <?php
      $k = 1 - $k;
      }
      ?>
    </tbody>
    </table>
    <input type="hidden" name="c" value="media" />
    <input type="hidden" name="option" value="com_videoflow" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    </form>
    <?php
    $this-> printFooter();
    }

  
  function setCatToolbar()
  {
    $tbar=& JToolBar::getInstance( 'toolbar' );
    JToolBarHelper::addNewX('addcat', JText::_( 'New' ));
    JToolBarHelper::editListX('editcat', JText::_( 'Edit' ));
    JToolBarHelper::customX( 'deletecat', 'delete.png', 'delete_f2.png', JText::_( 'Delete' ) );
    $tbar->appendButton( 'Popup', 'help', JText::_( 'Help' ), 'http://videoflow.fidsoft.com/index.php?option=com_content&tmpl=component&view=article&id=61', 725, 520 );
  }
  
  
  function listCats( &$rows, &$pageNav, &$lists)
  {
    global $vparams;
    VideoflowViewMedia::setCatToolbar();
    JHTML::_('behavior.tooltip');
    JHTML::_('behavior.modal', 'a.modal-vfpop');
    ?>
    <form action="index.php?option=com_videoflow" method="post" name="adminForm">
    <table class="adminlist">
    <thead>
    <tr>
    <th width="10">
    <?php echo JText::_( 'Num' ); ?>
    </th>
    <th width="20">
    <input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
    </th>
    <th width="30">
    <?php echo JText::_( 'Image' ); ?>
    </th>
    <th nowrap="nowrap" class="name">
    <?php echo JHTML::_('grid.sort',  'Name', 'v.name', @$lists['order_Dir'], @$lists['order'] ); ?>
    </th>
    <th width="40%" nowrap="nowrap">
    <?php echo JText::_( 'Description' ); ?>
    </th>
    <th width="10%" nowrap="nowrap">
    <?php echo JHTML::_('grid.sort',   'Date', 'v.date', @$lists['order_Dir'], @$lists['order'] ); ?>
    </th>
    <th width="10%" nowrap="nowrap">
    <?php echo JHTML::_('grid.sort',   'Id', 'v.id', @$lists['order_Dir'], @$lists['order'] ); ?>
    </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
    <td colspan="12">
    <?php echo $pageNav->getListFooter(); ?>
    </td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $k = 0;
    $cdate = & JFactory::getDate();
      for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row = &$rows[$i];
	if($row->date == '0000-00-00 00:00:00') $row->date = $cdate->toFormat();
	$link = JRoute::_( 'index.php?option=com_videoflow&task=editcat&cid[]='. $row->id);
	$checked = JHTML::_('grid.id', $i, $row -> id );
        if (!empty($row->pixlink)) {
         if (stripos($row->pixlink, 'http://') === FALSE) {  
         $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->pixlink;
         } else {
         $pixpreview = $row->pixlink;
         }
       } else if (empty($row->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$row->name.'.jpg')){
       $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->name.'.jpg';
       } else {
      $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
      }  
    ?>
    <tr class="<?php echo "row$k"; ?>">
    <td align="center">
    <?php echo $pageNav->getRowOffset($i); ?>
    </td>
    <td align="center">
    <?php echo $checked; ?>
    </td>
    <td align="center">
    <span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit' );?>::<?php echo $row->name; ?>"><a href="<?php echo $link; ?>"> <img src="<?php echo $pixpreview; ?>" width=70 /></a></span>
    </td>
    <td>
    <span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit' );?>::<?php echo $row->name; ?>">
    <a href="<?php echo $link; ?>"> <?php echo $row->name; ?></a>
    </span>
    </td>
    <td>
    <?php echo $row->desc; ?>					
    </td>
    <td align="center">
    <?php echo JHTML::_('date', $row->date, JText::_('DATE_FORMAT_LC4')); ?>
    </td>
    <td align="center">
    <?php echo $row->id; ?>
    </td>
    </tr>
    <?php
    $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>
    <input type="hidden" name="c" value="media" />
    <input type="hidden" name="option" value="com_videoflow" />
    <input type="hidden" name="task" value="categorylist" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    </form>
    <?php
    $this-> printFooter();
    }

  
  
  function setEditToolbar()
  {
    JToolBarHelper::apply('apply');
    JToolBarHelper::save( 'save' );
    JToolBarHelper::cancel( 'cancel' );
    $tbar=& JToolBar::getInstance( 'toolbar' );
    $tbar->appendButton( 'Popup', 'help', JText::_( 'Help' ), 'http://videoflow.fidsoft.com/index.php?option=com_content&tmpl=component&view=article&id=61', 725, 520 );
  }

  
  
  function editMedia( $option, &$row, $mlist ) 
  {
   global $vparams; 
    JHTML::_('behavior.modal', 'a.modal-vfpop');
    VideoflowViewMedia::setEditToolbar();    
    if (!empty($row->pixlink)) {
         if (stripos($row->pixlink, 'http://') === FALSE) {  
         $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->pixlink;
         } else {
         $pixpreview = $row->pixlink;
         }
       } else if (empty($row->pixlink) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$row->title.'.jpg')){
       $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->title.'.jpg';
       } else {
      $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
      }

    if (empty($row->userid)) {
      $user = &JFactory::getUser();
      $row->userid = $user->id;
    }
    if ($row->id>0){
    $thumbselect = "<a href=\"index.php?option=com_videoflow&task=vbrowser&tmpl=component&source=link&id=$row->id\" class=\"modal-vfpop\" rel=\"{handler: 'iframe', size: {x: 725, y: 520}}\">";
    $vidselect = "<a href=\"index.php?option=com_videoflow&task=popupload&tmpl=component&source=link&id=$row->id\" class=\"modal-vfpop\" rel=\"{handler: 'iframe', size: {x: 725, y: 520}}\">";
    } else {
      if (version_compare(JVERSION, '1.6.0') < 0) $sbutton = 'Apply'; else $sbutton = 'Save';
    $vnotice = JText::_('You must enter a media title and click '.$sbutton.' button before you can select an image');
    $vidnotice = JText::_('You must enter a media title and click '.$sbutton.' button before you can upload a media file');
    $thumbselect = "<a href=\"#\" onClick=\"alert('$vnotice')\">";
    $vidselect = "<a href=\"#\" onClick=\"alert('$vidnotice')\">";			
    }
 ?>

  <script language="javascript" type="text/javascript">
  <!--
  <?php
  if (version_compare(JVERSION, '1.6.0') < 0) {
    echo 'function submitbutton(pressbutton)';
  } else {
    echo 'Joomla.submitbutton = function(pressbutton)';
  }
  ?>
  
  {
   if (pressbutton == "cancel") {
     submitform(pressbutton);
   }
   else {
    var v = document.adminForm;
    if (v.title.value == "") {
    	alert( "<?php echo JText::_( 'You must provide a media title.', true ); ?>" );
    } 
    else { 
      v.task.value = pressbutton;     
      submitform(pressbutton);
    }
   }
  }
  //-->
  </script>

	<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
	<div class="col100 vfbackend">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
          <table class="admintable" style="width:100%;">
            <tr>
            <td class="adminvthumb">
	      <table class="vfctrtable"><tr><td> 
            <img src="<?php echo $pixpreview; ?>" height=75 />
	    </td></tr></table>
            </td>
            </tr>
          </table>
          <table class="admintable">
            <tr>	
            <td class="key">
	    <label for="title">
	    <?php echo JText::_( 'Title' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="70" maxsize="90" name="title" value="<?php echo stripslashes($row->title); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="file">
	    <?php echo JText::_( 'File' ); ?>:
	    </label>
	    </td>
            <td>
	    <div class="vfinleft">
            <input type="text" size="70" maxsize="90" name="file" value="<?php echo $row->file; ?>" />
	    </div>
	    <div class="vfinmiddle">
            <?php echo $vidselect; ?><?php echo JText::_('Upload'); ?></a>
	    </div>
            <div class="vfinright"><a href="index.php?option=com_videoflow&task=edit&cid[]=<?php echo $row->id; ?>"><?php echo JText::_('VF_REFRESH'); ?></a>
	    <div>
	    </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="type">
	    <?php echo JText::_( 'Type' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="30" maxsize="80" name="type" value="<?php echo stripslashes($row->type); ?>" /></td>
            </tr>
            <tr>
             <tr>
            <td class="key">
	    <label for="type">
	    <?php echo JText::_( 'Server' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo $mlist['serverlist']; ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="user id">
	    <?php echo JText::_( 'User Id' ); ?>:
	    </label>
	    </td>
            <td>
            <input size="30" maxsize="80" name="userid" value="<?php echo $row->userid; ?>">
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="thumbnail">
	    <?php echo JText::_( 'Thumbnail' ); ?>:
	    </label>
	    </td>
            <td>
	      <div class="vfinleft">
            <input type="text" size="70" maxsize="90" name="pixlink" value="<?php echo $row->pixlink; ?>">
	      </div>
	      <div class="vfinmiddle">
            <?php echo $thumbselect; ?><?php echo JText::_('Select'); ?></a>
	      </div>
	      <div class="vfinright">
            <a href="index.php?option=com_videoflow&task=edit&cid[]=<?php echo $row->id; ?>"><?php echo JText::_('VF_REFRESH'); ?></a>
	      </div>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="date">
	    <?php echo JText::_( 'Date' ); ?>:
	    </label>
	    </td>
            <td>
            <input size="30" maxsize="80" name="dateadded" value="<?php echo $row->dateadded; ?>">
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="published">
	    <?php echo JText::_( 'Published' ); ?>:
	    </label>
	    </td>
            <td> 
            <?php echo JHTML::_('select.booleanlist',  'published', '', $row->published ); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="featured">
	    <?php echo JText::_( 'Featured' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.booleanlist',  'recommended', '', $row->recommended ); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="category">
	    <?php echo JText::_( 'Category' ); ?>:
	    </label>
	    </td>
            <td>
	      <div class="vfinleft">
            <?php echo $mlist['catlist']; ?>
	      </div>
	      <div class = "vfinmiddle">
            <?php echo JText::_( 'New Category:' ); ?>
	    </div>
	      <div>
	    <input type="text" size="30" maxsize="80" name="newcat" value="" />
	    </div>
	    </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="tags">
	    <?php echo JText::_( 'Tags' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="70" maxsize="90" name="tags" value="<?php echo stripslashes($row->tags); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="description">
	    <?php echo JText::_( 'Description' ); ?>:
	    </label>
	    </td>
            <td>
            <textarea name="details" cols="45" rows="6" value="" wrap="soft"><?php echo stripslashes($row->details); ?></textarea>
            </td>
            </tr>
          </table> 
          <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="task" value="" />
          <input type="hidden" name="helplink" value="54#edit" />
      </fieldset>
  </div>         
 	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<div class="clr"></div>
<?php 
  $this->printFooter();
}

  function setEditCatToolbar()
  {
    JToolBarHelper::apply('applycats');
    JToolBarHelper::save( 'savecats' );
    JToolBarHelper::cancel( 'cancelcats' );
    $tbar=& JToolBar::getInstance( 'toolbar' );
    $tbar->appendButton( 'Popup', 'help', JText::_( 'Help' ), 'http://videoflow.fidsoft.com/index.php?option=com_content&tmpl=component&view=article&id=61', 725, 520 );
  }

  
  
  
  function editCat( $option, &$row ) 
  {
   global $vparams; 
    JHTML::_('behavior.modal', 'a.modal-vfpop');
    VideoflowViewMedia::setEditCatToolbar();
    if (!empty($row->pixlink)) {
         if (stripos($row->pixlink, 'http://') === FALSE) {  
         $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->pixlink;
         } else {
         $pixpreview = $row->pixlink;
         }
       } else if (empty($row->pixlink) && !empty($row->title) && file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$row->title.'.jpg')){
       $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->title.'.jpg';
       } else {
      $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
      }
    $cdate = & JFactory::getDate();
    if($row->date == '0000-00-00 00:00:00') $row->date = $cdate->toFormat();
    if ($row->id>0){
    $thumbselect = "<a href=\"index.php?option=com_videoflow&task=vbrowserc&vtask=directc&tmpl=component&source=link&id=$row->id\" class=\"modal-vfpop\" rel=\"{handler: 'iframe', size: {x: 725, y: 520}}\">";
    } else {
      if (version_compare(JVERSION, '1.6.0') < 0) $sbutton = 'Apply'; else $sbutton = 'Save';
    $vnotice = JText::_('You must enter a category name and click '.$sbutton.' button before you can select an image');
    $thumbselect = "<a href=\"#\" onClick=\"alert('$vnotice')\">";
    }
 ?>

  <script language="javascript" type="text/javascript">
  <!--
    <?php
  if (version_compare(JVERSION, '1.6.0') < 0) {
    echo 'function submitbutton(pressbutton)';
  } else {
    echo 'Joomla.submitbutton = function(pressbutton)';
  }
  ?>
  {
   if (pressbutton == "cancelcats" || pressbutton == 'cancel') {
     submitform(pressbutton);
   } else {
    var v = document.adminForm;
    if (v.name.value == "") {
    alert( "<?php echo JText::_( 'You must provide a category name.', true ); ?>" );
    } else { 
      v.task.value = pressbutton;     
      submitform(pressbutton);
    }
   }
  }
  //-->
  </script>

<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
<div class="col100">
<fieldset class="adminform">
<legend><?php echo JText::_( 'Details' ); ?></legend>
<table class="admintable" style="width:100%;">
<tr>
<td class="adminvthumb">
  <table class="vfctrtable"><tr><td>
<img src="<?php echo $pixpreview; ?>" height=75 />
</td></tr></table>
</td>
</tr>
</table>
<table class="admintable">
<tr>	
<td class="key">
<label for="name">
<?php echo JText::_( 'Name' ); ?>:
</label>
</td>
<td>
<input type="text" size="70" maxsize="90" name="name" value="<?php echo stripslashes($row->name); ?>" />
</td>
</tr>
<tr>
<td class="key">
<label for="thumbnail">
<?php echo JText::_( 'Thumbnail' ); ?>:
</label>
</td>
<td>
  <div class="vfinleft">
<input type="text" size="60" maxsize="80" name="pixlink" value="<?php echo $row->pixlink; ?>">
  </div>
  <div class="vfinmiddle">
<?php echo $thumbselect; ?><?php echo JText::_('Select'); ?></a>
  </div>
  <div class="vfinright">
<a href="index.php?option=com_videoflow&task=editcat&cid[]=<?php echo $row->id; ?>"><?php echo JText::_('VF_REFRESH'); ?></a>
  </div>
</td>
</tr>
<tr>
<td class="key">
<label for="desc">
<?php echo JText::_( 'Description' ); ?>:
</label>
</td>
<td>
<textarea name="desc" cols="45" rows="6" value="" wrap="soft"><?php echo stripslashes($row->desc); ?></textarea>
</td>
</tr>
<tr>
<td class="key">
<label for="date">
<?php echo JText::_( 'Date' ); ?>:
</label>
</td>
<td>
<input size="30" maxsize="80" name="date" value="<?php echo $row->date; ?>">
</td>
</tr>
</table> 
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
</fieldset>
</div>         
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div class="clr"></div>
<?php 
  $this->printFooter();
}



function popManager(&$row){
 JHTML::_('behavior.modal', 'a.modal-vfpop');
?>
      <fieldset class="adminform">
	  <legend><?php echo JText::_( 'Status' ); ?></legend>
          <table class="admintable" style="width:100%;">
            <tr>
            <td>
            <?php echo $row->message; ?>
            <br /><br />
            </td>
            </tr>
            <tr>
            <td class="adminvthumb">
            <img src="<?php echo $row->pixlink; ?>" height=75 />
            </td>
            </tr>
          </table>
      </fieldset>
      </div>
<?php                
}


function popBrowser ($obj)
{
global $vparams;
$task = JRequest::getCmd('task');
if ($task == 'vbrowserc' || $task == 'directc') {
$vtask = 'directc';
$dtask = 'savecats';
} else {
$vtask = 'direct';
$dtask = 'save';
}

$vcon = mt_rand();
  $vbutton = "<button name='psubmit' onclick='document.adminForm.submit()'>".JText::_( "Apply" )."</button>";   

?>

<fieldset class="adminform">
<legend><?php echo JText::_( 'Upload from Desktop' ); ?> </legend>
                <form action="index.php" method="post" enctype="multipart/form-data" target="upload_target" name="uplform" id="uplform">
                     <div id="f1_upload_process" style="text-align:center;">Uploading... Please wait...<br/><img src="<?php echo JURI::root().'administrator/components/com_videoflow/images/loader.gif'; ?>" /></div>
                     <div id="f1_upload_form" style="text-align:center;"><br/>
                         <label>File Name:  
                              <input name="deskpix" id="deskpix" type="file" size="30" title=".JPG, .PNG, .GIF" accept="jpg, png, gif"/>
                         </label>
                         <label>
                            <!-- <input type="submit" name="submitBtn" class="sbtn" value="Upload" /> -->
                             <button onclick="document.uplform.submit(); startUpload(); return false" name="uplsubmit"><?php echo JText::_( 'Upload' ); ?></button>
                             <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $vparams->maxthumbsize; ?>" />
                             <input type="hidden" name="UPLOAD_FILE_TYPE" value="image" />
                             <input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
                             <input type="hidden" name="option" value="com_videoflow" />
                             <input type="hidden" name="task" value="<?php echo $dtask; ?>" />
                         </label>
                     </div>     
                <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 <?php echo JHTML::_( 'form.token' ); ?>
                 </form>
</fieldset>


<form enctype="multipart/form-data" action='index.php?tmpl=component' method='post' name='adminForm'>
<fieldset class="adminform">
<legend><?php echo JText::_( 'Select From Server' ); ?> </legend>
<input type="text" readonly="readonly" id="serverpix" name="serverpix" value="" size="70" />	<?php echo "&nbsp&nbsp"; echo $vbutton; ?>
<br /><br />
<?php 
echo $obj->sortby;
echo "&nbsp";
echo $obj->sortdir;
echo "&nbsp";
?>
<input type="submit" name="ssubmit" value="<?php echo JText::_( "Sort" ); ?>" />
<br /><br />
<table class='adminlist'>
<tr>
<th width='85'>
<?php echo JText::_( 'Image' ); ?>
</th>
<th>
<?php echo JText::_( 'File' ); ?>
</th>
<th>
<?php echo JText::_( 'Date' ); ?>
</th>
<th>
<?php echo JText::_( 'Size' ); ?>
</th>
</tr>
<?php
while($obj->NextFile())
{
$fileurl = JURI::root().$vparams->mediadir.'/_thumbs/'.$obj->FieldName;
$filename = $obj->FieldName;
echo "<tr>";
echo "<td>"; 
echo "<a href='#'><img src='$fileurl' width='80' onClick=\"document.getElementById('serverpix').value='$obj->FieldName'\";  /></a>";
echo '</td>';
echo "<td>";
echo "<a href='#' onClick=\"document.getElementById('serverpix').value='$obj->FieldName'\";>".$obj->FieldName."</a>";
echo "</td>";
echo "<td>".$obj->FieldDate."</td>";
echo "<td>".$obj->FieldSize."</td>";
echo "</tr>";
}
echo "</table>";  
echo '<input type="hidden" name="id" value="'.$obj->id.'" />';
echo '<input type="hidden" name="option" value="com_videoflow" />';
echo '<input type="hidden" name="task" value="'.$vtask.'" />';
echo JHTML::_( 'form.token' );
?>
</form>
</fieldset>
<?php
}


function popVbrowser ($obj=null)
{

global $vparams;
$cmes = JText::_('Continue with step 2...'); 
echo '<script language="javascript" type="text/javascript">var cmes = "'.$cmes.'"; </script>'; 

?>

<fieldset class="adminform">
<legend><?php echo JText::_( 'Thumbnail File' ); ?> </legend>
<br/>
<?php echo JText::_( 'STEP 1: You may upload a thumbnail image for your media file (optional). Browse for thumbnail and click Upload.' ); ?> <br/>
                <form action="index.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                     <div id="f1_upload_process" style="text-align:center;">Uploading... Please wait...<br/><img src="<?php echo JURI::root().'administrator/components/com_videoflow/images/loader.gif'; ?>" /></div>
                     <div id="f1_upload_form" style="text-align:center;"><br/>
                         <label>File Name:  
                              <input name="myfile" id="myfile" type="file" size="30" title=".JPG, .PNG, .GIF" accept="jpg, png, gif"/>
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                             <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $vparams->maxthumbsize; ?>" />
                             <input type="hidden" name="UPLOAD_FILE_TYPE" value="image" />
                             <input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
                             <input type="hidden" name="option" value="com_videoflow" />
                             <input type="hidden" name="task" value="save" />
                         </label>
                     </div>     
                <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 <?php echo JHTML::_( 'form.token' ); ?>
                 </form>
</fieldset>

<?php
if ($vparams->upsys == 'swfupload') self::swfUploadForm($obj); else self::pluploadForm($obj);
}


function swfUploadForm()
{

$session = & JFactory::getSession();
$doc = & JFactory::getDocument();
$swfupload = JURI::root().'components/com_videoflow/utilities/js/swfupload.js';
$doc->addScript($swfupload);

$queue = JURI::root().'components/com_videoflow/utilities/js/swfupload.queue.js';
$doc->addScript($queue);

$fileprocess = JURI::root().'components/com_videoflow/utilities/js/fileprogress.js';
$doc->addScript($fileprocess);

$handlers = JURI::root().'components/com_videoflow/utilities/js/handlers.js';
$doc->addScript($handlers);

$flashinitiate = '
	var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "'.JURI::root().'components/com_videoflow/utilities/swf/swfupload.swf",
				upload_url: "index.php?option=com_videoflow&task=save&'.JUtility::getToken().'=1",
				post_params: {"option" : "com_videoflow", "task" : "save", 
				"media_id" : "'.$obj->id.'", "'.$session->getName().'" : "'.$session->getId().'", "format" : "raw"},
				file_size_limit : "'.$vparams->maxmedsize.'MB",
				file_types : "*.flv; *.mp4; *.swf; *.3g2; *.3gp; *.mov; *.mp3; *.aac; *.jpg; *.gif; *.png",
				file_types_description : "Media Files",
				file_upload_limit : 0,
				file_queue_limit : 1,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					vflowMode : "vRefresh",
					mediaId : "'.$obj->id.'"
				},
				debug: false,
				button_image_url: "'.JURI::root().'components/com_videoflow/utilities/images/uploadimage.png",
				button_width: "100",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: "<span class=\"theFont\">Select File</span>",
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete
			};

			swfu = new SWFUpload(settings);
	     };
    ';
$doc->addScriptDeclaration($flashinitiate);
?>
<fieldset class="adminform">
<legend><?php echo JText::_( 'Media File' ); ?> </legend>
<br />
<?php echo JText::_( 'STEP 2: Select media file to upload.' ); ?> <br />
<br />
<div id="scontent">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
			<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend"><?php echo JText::_( 'Upload Status' ); ?></span>
			</div>
		<div id="divStatus"></div>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="<?php echo JText::_( 'Cancel Uploads' ); ?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>
		 <?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
</fieldset>
<?php
}

function popVupload ()
{
  global $vparams;
  if ($vparams->upsys == 'swfupload') self::qSwfupload(); else self::qPlupload();
}

function qPlupload ()
{
global $vparams;
$app = &JFactory::getApplication();
$session = & JFactory::getSession();
$doc =& JFactory::getDocument();
$vcss = JURI::root().'components/com_videoflow/utilities/plupload/css/plupload.queue.css';
$doc->addStyleSheet( $vcss, 'text/css', null, array() );
$jsapi = 'http://www.google.com/jsapi';
$doc->addScript($jsapi);
$google = 'google.load("jquery", "1.3")'; 
$doc->addScriptDeclaration($google); 
$qcss = '.plupload_scroll .plupload_filelist {
	       height: 280px !important;
        }';
$doc->addStyleDeclaration($qcss);
$upurl = JURI::root().'administrator/index.php?option=com_videoflow&task=vxupload&'.$session->getName().'='.$session->getId().'&'.JUtility::getToken().'=1';
$maxmedsize = $vparams->maxmedsize.'mb';
$app->setUserState( "com_videoflow.media.filter_order", "b.dateadded" );
$app->setUserState( "com_videoflow.media.filter_order_Dir", "desc" );
        
?>
<script type="text/javascript" src="<?php echo JURI::root().'components/com_videoflow/utilities/plupload/js/plupload.full.min.js';?>"></script>
<script type="text/javascript" src="<?php echo JURI::root().'components/com_videoflow/utilities/plupload/js/jquery.plupload.queue.min.js';?>"></script>
<script type="text/javascript">
$(function() {
	$("#vfx_uploader").pluploadQueue({
		// General settings
		runtimes : 'flash,html5,html4',
		url : '<?php echo $upurl; ?>',
		max_file_size : '<?php echo $maxmedsize; ?>',
		chunk_size : '1mb',
		unique_names : false,
		urlstream_upload : true,

	// Resize images on clientside if we can
	//	resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "Media Files", extensions : "jpg,gif,png,mp3,swf,mp4,flv"}
		],

		// Flash URL
		flash_swf_url : '<?php echo JURI::root()."components/com_videoflow/utilities/plupload/js/plupload.flash.swf"; ?>'

		});

    var uploader = $('#vfx_uploader').pluploadQueue();
  
  // Start upload   
     $('#uploadfiles').click(function(e) {
	        uploader.start();
	        e.preventDefault();   
      });
  
  // Exit
    uploader.bind('FileUploaded', function(up, file, res) {
        if(up.total.queued == 0) {
        parent.location.href="index.php?option=com_videoflow";  
        self.close(); 
        }
    });
});
</script>

<fieldset class="vf_forms">
<legend><?php echo JText::_( 'Media Files' ); ?> </legend>
<?php echo JText::_( 'Select files to upload. You may select multiple files to create an upload queue. You will be able to edit the file details once the upload queue is completed.' ); ?> <br />
	<div id="vf_plupload">
        <div id="vfx_uploader" style="height: 380px;">
	<p><?php echo JText::_('Your browser does not have Flash or HTML5 support.');?></p>
	</div>
	<div style="padding:6px 8px";> <?php echo JText::_('Be cool. Upload process may take a few minutes to start.'); ?></div>
	<br style="clear: both" />
    </div>
</fieldset>
<?php
}

function qSwfupload()
{
  global $vparams;
  $queuelen = 10;  
  $session = & JFactory::getSession();
  $doc =& JFactory::getDocument();
  $swfupload = JURI::root().'components/com_videoflow/utilities/js/swfupload.js';
  $doc->addScript($swfupload);

  $queue = JURI::root().'components/com_videoflow/utilities/js/swfupload.queue.js';
  $doc->addScript($queue);

  $fileprocess = JURI::root().'components/com_videoflow/utilities/js/fileprogress.js';
  $doc->addScript($fileprocess);

  $handlers = JURI::root().'components/com_videoflow/utilities/js/handlers.js';
  $doc->addScript($handlers);

$flashinitiate = '
	var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "'.JURI::root().'components/com_videoflow/utilities/swf/swfupload.swf",
				upload_url: "index.php?option=com_videoflow&task=vupload&'.JUtility::getToken().'=1",
				post_params: {"option" : "com_videoflow", "task" : "vupload", 
				"'.$session->getName().'" : "'.$session->getId().'", "format" : "raw"},
				file_size_limit : "'.$vparams->maxmedsize.'MB",
				file_types : "*.flv; *.mp4; *.swf; *.3g2; *.3gp; *.mov; *.mp3; *.aac; *.jpg; *.gif; *.png",
				file_types_description : "Media Files",
				file_upload_limit : 0,
				file_queue_limit : "'.$queuelen.'",
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					vflowMode : "vStatic"
				},
				debug: false,
				button_image_url: "'.JURI::root().'components/com_videoflow/utilities/images/uploadimage.png",
				button_width: "100",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: "<span class=\"theFont\">Select File</span>",
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete
			};

			swfu = new SWFUpload(settings);
	     };
    ';
$doc->addScriptDeclaration($flashinitiate);

?>

<fieldset class="adminform">
<legend><?php echo JText::_( 'Media Files' ); ?> </legend>
<br/>
<?php echo JText::_( 'Select files to upload. You may select multiple files to create an upload queue. You will be able to edit the file details once the upload queue is completed.' ); ?> 
<br/>
<br/>
<br/>
<div id="scontent">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<div class="fieldset flash" id="fsUploadProgress">
		<span class="legend"><?php echo JText::_( 'Upload Status' ); ?></span>
		</div>
		<div id="divStatus"></div>
		<div>
		<span id="spanButtonPlaceHolder"></span>
		<input id="btnCancel" type="button" value="<?php echo JText::_( 'Cancel Uploads' ); ?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
		</div>
	      <?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
</fieldset>
<?php
  }
 
function pluploadForm ($obj=null)
{
global $vparams; 
$session = & JFactory::getSession();
$doc =& JFactory::getDocument();
$vcss = JURI::root().'components/com_videoflow/utilities/plupload/css/plupload.queue.css';
$doc->addStyleSheet( $vcss, 'text/css', null, array() );
$jsapi = 'http://www.google.com/jsapi';
$doc->addScript($jsapi);
$google = 'google.load("jquery", "1.3")'; 
$doc->addScriptDeclaration($google); 
$upurl = JURI::root().'administrator/index.php?option=com_videoflow&task=saveXpload&user_id='.$obj->userid.'&media_id='.$obj->id.'&'.$session->getName().'='.$session->getId().'&'.JUtility::getToken().'=1';
$maxmedsize = $vparams->maxmedsize.'mb';
        
?>
<script type="text/javascript" src="<?php echo JURI::root().'components/com_videoflow/utilities/plupload/js/plupload.full.min.js';?>"></script>
<script type="text/javascript" src="<?php echo JURI::root().'components/com_videoflow/utilities/plupload/js/jquery.plupload.queue.min.js';?>"></script>
<script type="text/javascript">
$(function() {
	$("#vfx_uploader").pluploadQueue({
		// General settings
		runtimes : 'flash,html5,html4',
		url : '<?php echo $upurl; ?>',
		max_file_size : '<?php echo $maxmedsize; ?>',
		chunk_size : '1mb',
		unique_names : false,
		urlstream_upload : true,
		// Specify what files to browse for
		filters : [
			{title : "Media Files", extensions : "jpg,gif,png,mp3,swf,mp4,flv"}
		],
		// Flash URL
		flash_swf_url : '<?php echo JURI::root()."components/com_videoflow/utilities/plupload/js/plupload.flash.swf"; ?>'
		});

    var uploader = $('#vfx_uploader').pluploadQueue();
    
  // autostart
    uploader.bind('FilesAdded', function(up, files) {
      if (up.files.length > 1) {
      var xrem = up.files.length - 1;
      up.files.splice(0,xrem);
      }
      uploader.start();
    });
  // after upload
    uploader.bind('FileUploaded', function(up, file, res) {
        if(up.total.queued == 0) {
        parent.location.href="index.php?option=com_videoflow&task=getStatus&cid=<?php echo $obj->id;?>&userid=<?php echo $obj->userid; ?>&file=" + file.name;  
        self.close(); 
        }
    });
});
</script>

<fieldset class="vf_forms">
<legend><?php echo JText::_( 'Media File' ); ?> </legend>
<?php echo JText::_( 'STEP 2: Select media file to upload.' ); ?> <br />
	<div id="vf_plupload">
        <div id="vfx_uploader" style="height: 200px;">
	<p><?php echo JText::_('Your browser does not have Flash or HTML5 support.');?></p>
	</div>
	<div style="padding:4px 8px";> <?php echo JText::_('Be cool. Upload process may take a few minutes to start.'); ?></div>
	<br style="clear: both" />
    </div>
</fieldset>
<?php
}

 
  
function popVembed ()
{

?>

<fieldset class="adminform">
<legend><?php echo JText::_( 'Embed Remote Media' ); ?> </legend>
<br/>
<?php echo JText::_( 'Paste URL to fetch' ); ?> 
<br/>
<br/>
<br/>
<div>
 <form id="adminForm" name="adminForm" action="index.php?&tmpl=component" method="post">
 <table class="admintable">
            <tr>	
            <td>
	    <input type="text" size="70" maxsize="90" name="embedlink" value="" />	
	    </td>
            <td>
            <button onclick="document.adminForm.submit(); return false" name="vsubmit"><?php echo JText::_( 'Apply' ); ?></button>
            <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><?php echo JText::_( 'Cancel' ); ?></button>
            </td>
            </tr>
  </table> 
  <input type="hidden" name="option" value="com_videoflow" />
  <input type="hidden" name="task" value="vembed" /> 
  <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
</fieldset>
<?php
}  

  
  function saveRemote(&$row) 
  {
    jimport('joomla.application.component.view');
    $v = new JView;
    $pixpreview = stripslashes($row->pixlink);
    if (empty($pixpreview)){
    $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
    }
 ?>

	<form enctype="multipart/form-data" action="index.php?&tmpl=component" method="post" name="adminForm">
	<div class="col100 vfbackend">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Media Details' ); ?></legend>
          <table class="admintable" style="width:100%; text-align:center;">
            <tr>
            <td class="adminvthumb">
	      <table class="vfctrtable"><tr><td>
            <img src="<?php echo $pixpreview; ?>" height=75 />
	      </td></tr></table>
            </td>
            </tr>
          </table>
          <table class="admintable">
            <tr>	
            <td class="key">
	    <label for="title">
	    <?php echo JText::_( 'Title' ); ?>:
	    </label>
	    </td>
             <td>
            <input type="text" size="70" maxsize="90" name="title" value="<?php echo $v->escape(stripslashes($row->title)); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="file">
	    <?php echo JText::_( 'File' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="70" maxsize="90" name="file" value="<?php echo $row->file; ?>" />
            </td>
            </tr>
             <tr>
            <td class="key">
	    <label for="type">
	    <?php echo JText::_( 'Server' ); ?>:
	    </label>
	    </td>
            <td>
            <input size="30" maxsize="80" name="server" value="<?php echo $row->server; ?>">
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="thumbnail">
	    <?php echo JText::_( 'Thumbnail' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="60" maxsize="80" name="pixlink" value="<?php echo $row->pixlink; ?>">
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="date">
	    <?php echo JText::_( 'Date' ); ?>:
	    </label>
	    </td>
            <td>
            <input size="30" maxsize="80" name="dateadded" value="<?php echo $row->dateadded; ?>">
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="published">
	    <?php echo JText::_( 'Published' ); ?>:
	    </label>
	    </td>
            <td> 
            <?php echo JHTML::_('select.booleanlist',  'published', '', 1 ); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="featured">
	    <?php echo JText::_( 'Featured' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.booleanlist',  'recommended', '', 0 ); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="category">
	    <?php echo JText::_( 'Category' ); ?>:
	    </label>
	    </td>
            <td>
	    <div style="float:left; margin-right:10px;">  
            <?php echo $row->catlist; ?>
	    </div>
	    <div style="float:left; clear:none; border:none; margin-top: 4px; margin-right: 4px;">
            <?php echo JText::_( 'New Category:' ); ?>
	    </div>
	    <input type="text" size="30" maxsize="80" name="newcat" value="" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="tags">
	    <?php echo JText::_( 'Tags' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="70" maxsize="90" name="tags" value="<?php echo stripslashes($row->tags); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="description">
	    <?php echo JText::_( 'Description' ); ?>:
	    </label>
	    </td>
            <td>
            <textarea name="details" cols="45" rows="6" value="" wrap="soft"><?php echo $v->escape(stripslashes($row->details)); ?></textarea>
            </td>
            </tr>  
          </table> 
          <table class="admintable" style="width:100%;">
            <tr>
            <td class="adminvthumb">
	      <table style="margin:auto;"><tr><td>
            <button onclick="document.adminForm.submit()" name="submit"><?php echo JText::_( 'Save' ); ?></button>
	    <?php if (version_compare(JVERSION, '1.6.0') < 0) {
	      ?>
            <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><?php echo JText::_( 'Cancel' ); ?></button>
            <?php
	    } else {
	      ?>
	    <button type="button" onclick="window.parent.SqueezeBox.close();"><?php echo JText::_( 'Cancel' ); ?></button>
	    <?php
	    }
	    ?>
	      </td></tr></table>
	    </td>
            </tr>
          </table>
      
          <input type="hidden" name="medialink" value="<?php echo $row->medialink; ?>" />
          <input type="hidden" name="type" value="<?php echo $row->type; ?>" />
          <input type="hidden" name="userid" value="<?php echo $row->userid; ?>" >
          <input type="hidden" name="id" value="0" />
          <input type="hidden" name="option" value="com_videoflow" />
          <input type="hidden" name="task" value="saveremote" />
      </fieldset>
  </div>          
 	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<div class="clr"></div>
<?php 
}
}