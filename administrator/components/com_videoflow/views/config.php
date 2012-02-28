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

class VideoflowViewConfig
{
    
  function setConfigToolbar()
	{
    JToolBarHelper::save( 'save' );
    JToolBarHelper::cancel( 'cancel' );
   // JToolBarHelper::preferences('com_videoflow');
    $tbar=& JToolBar::getInstance( 'toolbar' );
    $tbar->appendButton( 'Popup', 'help', JText::_( 'Help' ), 'http://videoflow.fidsoft.com/index.php?option=com_content&tmpl=component&view=article&id=60', 725, 520 );
  }

    
  function listSettings( &$row ) 
  {    
  JHTML::_('behavior.modal', 'a.modal-vfpop');
  self::setConfigToolbar();
  if ($row->prostatus) $type = 'Pro'; else $type = 'Standard';
  jimport('joomla.html.pane');
  $seltab = JRequest::getInt('vtab');
  if (version_compare(JVERSION, '1.6.0') < 0) {
    $vfpress = 'function submitbutton(pressbutton)';
  } else {
  $vfpress = 'Joomla.submitbutton = function(pressbutton)';
  }

  $tabc = 'var vftab = 0;';
  $tabc .= $vfpress;
  $tabc .= '
  {
      if (pressbutton == "save") {
      document.adminForm.vtab.value = vftab;
      }
      submitform(pressbutton);
  }';
   
  $doc =& JFactory::getDocument();
  $doc->addScriptDeclaration($tabc);
  
  
 ?>
	
	<form action="<?php JRoute::_('index.php'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="col100 vfbackend">
	<?php		
  $vfTabs = & JPane::getInstance('tabs', array('startOffset'=>$seltab));
  echo $vfTabs->startPane( 'vftabs' );
  echo $vfTabs->startPanel( JText::_('General Settings'), 'tabone' );
  echo '<span id="tab1" onClick="vftab = 0">';
   ?>  
      <fieldset class="adminform">
	  <legend><?php echo JText::_( 'System Settings' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
	    <label for="mode">
	    <?php echo JText::_( 'System mode' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->selectsys, 'mode', null, 'value', 'text', $row->mode); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="mootools12">
	    <?php echo JText::_( 'Apply Mootools legacy mode' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'mootools12', null, 'value', 'text', $row->mootools12); ?>
	    </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="upsys">
	    <?php echo JText::_( 'Upload system' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->upsysselect, 'upsys', null, 'value', 'text', $row->upsys); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="mediadir">
	    <?php echo JText::_( 'Media directory' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="30" maxsize="80" name="mediadir" value="<?php echo $row->mediadir; ?>" />        
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="autothumb">
	    <?php echo JText::_( 'Generate thumbnail from video' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'autothumb', null, 'value', 'text', $row->autothumb); ?>
            </td>
            </tr>
	    <?php
	    if (!empty($row->autothumb)) {
	    if (empty($row->ffmpegdetected)) {
	    ?>
	    <tr>
            <td class="key">
	    <label for="ffmpegpath">
	    <?php echo JText::_( 'FFMPEG path' ); ?>:
	    </label>
	    </td>
            <td>
	    <div style="float:left; margin-right: 5px; border: none;">  
            <input type="text" size="30" maxsize="80" name="ffmpegpath" value="<?php echo $row->ffmpegpath; ?>" /> 
	    </div>
	    <?php
	    if (empty($row->ffmpegpath)) {
	    echo '<div style="float:left; clear: none; margin: 4px 0px 0px; border: none;"><font color="red">'.JText::_('Warning: FFMPEG not found. It is required for thumbnail generation. Provide a valid FFMPEG path.').'</font></div>';
	    }
	    ?>
	    </td>
            </tr>
	    <?php
	    }
	    ?>
	    <tr>
            <td class="key">
	    <label for="ffmpegsec">
	    <?php echo JText::_( 'Generate thumbnail at seconds' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="ffmpegsec" value="<?php echo $row->ffmpegsec; ?>" /> 
	    </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="ffmpegthumbwidth">
	    <?php echo JText::_( 'Generated thumbnail width' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="ffmpegthumbwidth" value="<?php echo $row->ffmpegthumbwidth; ?>" /> 
	    </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="ffmpegthumbheight">
	    <?php echo JText::_( 'Generated thumbnail height' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="ffmpegthumbheight" value="<?php echo $row->ffmpegthumbheight; ?>" /> 
	    </td>
            </tr>
	    <?php
	    }
	    ?>
	    <tr>
            <td class="key">
	    <label for="commentsys">
	    <?php echo JText::_( 'Comments system' ); ?>:
	    </label>
	    </td>
            <td>
             <?php echo JHTML::_('select.genericlist', $row->selectcomsys, 'commentsys', null, 'value', 'text', $row->commentsys); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbcommentint">
	    <?php echo JText::_( 'Facebook comments integration' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->fbcommintselect, 'fbcommentint', null, 'value', 'text', $row->fbcommentint); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="likebutton">
	    <?php echo JText::_( 'Show Facebook Like Button' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'likebutton', null, 'value', 'text', $row->likebutton); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="adminemail">
	    <?php echo JText::_( 'Admin email' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="80" maxsize="150" name="adminemail" value="<?php echo $row->adminemail; ?>" />
            </td>
            </tr>   
            <tr>
            <td class="key">
	    <label for="uploadlog">
	    <?php echo JText::_( 'Keep upload log' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'uploadlog', null, 'value', 'text', $row->uploadlog); ?>
            </td>
            </tr>
          </table>
        </fieldset>   
        <fieldset class="adminform">
       	<legend><?php echo JText::_( 'Display Settings' ); ?></legend>
        <table class="admintable">
	    <tr>
            <td class="key">
	    <label for="findvmods">
	    <?php echo JText::_( 'Display mode' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->findmods, 'findvmods', null, 'value', 'text', $row->findvmods); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="limit">
	    <?php echo JText::_( 'Items per page' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="limit" value="<?php echo $row->limit; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="titlelimit">
	    <?php echo JText::_( 'Title length' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="titlelimit" value="<?php echo $row->titlelimit; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="shorttitle">
	    <?php echo JText::_( 'Short title length' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="shorttitle" value="<?php echo $row->shorttitle; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="commentlimit">
	    <?php echo JText::_( 'Description length' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="commentlimit" value="<?php echo $row->commentlimit; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="repunderscore">
	    <?php echo JText::_( 'Replace underscore with space' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'repunderscore', null, 'value', 'text', $row->repunderscore); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="slist">
	    <?php echo JText::_( 'Show sidebar' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'slist', null, 'value', 'text', $row->slist); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="slistlimit">
	    <?php echo JText::_( 'Number of sidebar items' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="slistlimit" value="<?php echo $row->slistlimit; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="thumbwidth">
	    <?php echo JText::_( 'Thumbnail width' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="thumbwidth" value="<?php echo $row->thumbwidth; ?>" />
            </td>
            </tr>            
            <tr>
            <td class="key">
	    <label for="thumbheight">
	    <?php echo JText::_( 'Thumbnail height' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="thumbheight" value="<?php echo $row->thumbheight; ?>" />
            </td>
            </tr>            
            <tr>
            <td class="key">
	    <label for="displayname">
	    <?php echo JText::_( 'User name display' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->selectname, 'displayname', null, 'value', 'text', $row->displayname); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="shortname">
	    <?php echo JText::_( 'Short user name length' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="shortname" value="<?php echo $row->shortname; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showpro">
	    <?php echo JText::_( 'Show pro features' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showpro', null, 'value', 'text', $row->showpro); ?>
            </td>
            </tr>            
	    <tr>
            <td class="key">
	    <label for="lightbox">
	    <?php echo JText::_( 'Activate lightbox' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'lightbox', null, 'value', 'text', $row->lightbox); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="lighboxsys">
	    <?php echo JText::_( 'Lightbox system' ); ?>:
	    </label>
	    </td>
            <td>
             <?php echo JHTML::_('select.genericlist', $row->selectlbox, 'lightboxsys', null, 'value', 'text', $row->lightboxsys); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="lightboxfull">
	    <?php echo JText::_( 'Lightbox mode' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->lboxmode, 'lightboxfull', null, 'value', 'text', $row->lightboxfull); ?>
            </td>
            </tr>  
            <tr>
            <td class="key">
	    <label for="lboxh">
	    <?php echo JText::_( 'Lightbox height offset' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="lboxh" value="<?php echo $row->lboxh; ?>" />
            </td>
            </tr> 
            <tr>
            <td class="key">
	    <label for="lboxw">
	    <?php echo JText::_( 'Lightbox width offset' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="lboxw" value="<?php echo $row->lboxw; ?>" />
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="playall">
	    <?php echo JText::_( 'Activate lighbox continuous play' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'playall', null, 'value', 'text', $row->playall); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="catplay">
	    <?php echo JText::_( 'Category view mode' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->catmode, 'catplay', null, 'value', 'text', $row->catplay); ?>
            </td>
            </tr>   
	    <tr>
            <td class="key">
	    <label for="showcredit">
	    <?php echo JText::_( 'Show credit text' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showcredit', null, 'value', 'text', $row->showcredit); ?>
            </td>
            </tr> 
          </table> 
      </fieldset>
       <fieldset class="adminform">
	<legend><?php echo JText::_( 'Player Settings' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
	    <label for="player">
	    <?php echo JText::_( 'Player' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->selectplayer, 'player', null, 'value', 'text', $row->player); ?>
            </td>
            </tr>
            <?php if ($row->player == 'JW') {
            ?>
            <tr>	
            <td class="key">
	    <label for="jwforyoutube">
	    <?php echo JText::_( 'Play YouTube videos in JW Player' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'jwforyoutube', null, 'value', 'text', $row->jwforyoutube); ?>
            </td>
            </tr>
            <?php
            }
            ?>
            <tr>
            <td class="key">
	    <label for="skin">
	    <?php echo JText::_( 'Player skin' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="80" maxsize="150" name="skin" value="<?php echo $row->skin; ?>" />        
            </td>
            </tr>
            <tr>	
            <td class="key">
	    <label for="playerwidth">
	    <?php echo JText::_( 'Player width' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="playerwidth" value="<?php echo $row->playerwidth; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="playerheight">
	    <?php echo JText::_( 'Player height' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="playerheight" value="<?php echo $row->playerheight; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="lplayerwidth">
	    <?php echo JText::_( 'Lightbox player width' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="lplayerwidth" value="<?php echo $row->lplayerwidth; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="lplayerheight">
	    <?php echo JText::_( 'Lightbox player height' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="lplayerheight" value="<?php echo $row->lplayerheight; ?>" />
            </td>
            </tr>
          </table>
        </fieldset>
        <fieldset class="adminform">
	<legend><?php echo JText::_( 'User Settings' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
            <label for="ratings">
	    <?php echo JText::_( 'Rate media' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'ratings', null, 'value', 'text', $row->ratings); ?>
            </td>
            </tr>
            <tr>	
            <td class="key">
            <label for="useradd">
	    <?php echo JText::_( 'Add media from remote sites' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'useradd', null, 'value', 'text', $row->useradd); ?>
            </td>
            </tr>
            <tr>	
            <td class="key">
            <label for="useradd">
	    <?php echo JText::_( 'Auto publish remote media' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'autopubadds', null, 'value', 'text', $row->autopubadds); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
            <label for="userupload">
	    <?php echo JText::_( 'Upload media to server' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'userupload', null, 'value', 'text', $row->userupload); ?>
            </td>
            </tr>
            <?php
            if ($row->userupload) {
            ?>
            <tr>
            <td class="key">
	    <label for="maxmedsize">
	    <?php echo JText::_( 'Largest media file that can be uploaded (MB)' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="maxmedsize" value="<?php echo $row->maxmedsize; ?>" />        
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="maxthumbsize">
	    <?php echo JText::_( 'Largest thumbnail file that can be uploaded (KB)' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="maxthumbsize" value="<?php echo $row->maxthumbsize; ?>" />        
            </td>
            </tr>
            <?php
            }
            ?>
            <tr>	
            <td class="key">
            <label for="useradd">
	    <?php echo JText::_( 'Auto publish uploaded media' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'autopubups', null, 'value', 'text', $row->autopubups); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
            <label for="candelete">
	    <?php echo JText::_( 'Delete own files' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'candelete', null, 'value', 'text', $row->candelete); ?>
            </td>
            </tr>
             <tr>
            <td class="key">
            <label for="useredit">
	    <?php echo JText::_( 'Edit own files' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'useredit', null, 'value', 'text', $row->useredit); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
            <label for="downloads">
	    <?php echo JText::_( 'Download local files' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'downloads', null, 'value', 'text', $row->downloads); ?>
            </td>
            </tr>
          </table>
        </fieldset>
	
	<fieldset class="adminform">
	  <legend><?php echo JText::_( 'Tools Settings' ); ?></legend>
          <table class="admintable">
	    <tr>
            <td class="key">
	    <label for="toolcolour">
	    <?php echo JText::_( 'Tools icon colour' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->tcolour, 'toolcolour', null, 'value', 'text', $row->toolcolour); ?>
            </td>
            </tr>
            <tr>	
            <td class="key">
            <label for="showadd">
	    <?php echo JText::_( 'Show add to my list button' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showadd', null, 'value', 'text', $row->showadd); ?>
            </td>
            </tr>
	    <tr>	
            <td class="key">
            <label for="showemail">
	    <?php echo JText::_( 'Email page to a friend' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showemail', null, 'value', 'text', $row->showemail); ?>
            </td>
            </tr>
            <tr>	
            <td class="key">
            <label for="showshare">
	    <?php echo JText::_( 'Share current page' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showshare', null, 'value', 'text', $row->showshare); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
            <label for="showreport">
	    <?php echo JText::_( 'Flag media' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showreport', null, 'value', 'text', $row->showreport); ?>
            </td>
            </tr>
          </table>
        </fieldset>
        
	
 <?php
   echo '</span>';
   echo $vfTabs->endPanel();
   echo $vfTabs->startPanel( JText::_('Joomla Settings'), 'tabtwo' );
   echo '<span id="tab2" onClick="vftab = 1">';
  ?>
        <fieldset class="adminform">
       	<legend><?php echo JText::_( 'System Settings' ); ?></legend>
        <table class="admintable">  
            <tr>
            <td class="key">
	    <label for="facebook">
	    <?php echo JText::_( 'Activate Facebook Connect' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'facebook', null, 'value', 'text', $row->facebook); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="message">
	    <?php echo JText::_( 'Activate Message Centre' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'message', null, 'value', 'text', $row->message); ?>
            </td>
            </tr>
          </table> 
      </fieldset>
      
        <fieldset class="adminform">
       	<legend><?php echo JText::_( 'Display Settings' ); ?></legend>
        <table class="admintable">        
            <tr>
            <td class="key">
	    <label for="jtemplate">
	    <?php echo JText::_( 'Joomla template' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->selectjtemp, 'jtemplate', null, 'value', 'text', $row->jtemplate); ?>
            </td>
            </tr>
            <?php if ($row->jtemplate == 'grid') {
            ?>
            <tr>	
            <td class="key">
	    <label for="columns">
	    <?php echo JText::_( 'Number of columns' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="columns" value="<?php echo $row->columns; ?>" />
            </td>
            </tr>
            <?php
            }
            ?>
	    <tr>  
            <td class="key">
	    <label for="showtabs">
	    <?php echo JText::_( 'Show tabs' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showtabs', null, 'value', 'text', $row->showtabs); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="sidebarlimit">
	    <?php echo JText::_( 'Items per tab' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="5" maxsize="10" name="sidebarlimit" value="<?php echo $row->sidebarlimit; ?>" />
            </td>
            </tr>   
            <tr>
            <td class="key">
	    <label for="showuser">
	    <?php echo JText::_( 'Show user' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showuser', null, 'value', 'text', $row->showuser); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showviews">
	    <?php echo JText::_( 'Show play count' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showviews', null, 'value', 'text', $row->showviews); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showplaylistcount">
	    <?php echo JText::_( 'Show playlist count' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showplaylistcount', null, 'value', 'text', $row->showplaylistcount); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showrating">
	    <?php echo JText::_( 'Show rating' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showrating', null, 'value', 'text', $row->showrating); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="showvotes">
	    <?php echo JText::_( 'Show number of votes' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showvotes', null, 'value', 'text', $row->showvotes); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="showdownloads">
	    <?php echo JText::_( 'Show number of downloads' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showdownloads', null, 'value', 'text', $row->showdownloads); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="showdate">
	    <?php echo JText::_( 'Show date' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showdate', null, 'value', 'text', $row->showdate); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showcat">
	    <?php echo JText::_( 'Show category' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showcat', null, 'value', 'text', $row->showcat); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="flowid">
	    <?php echo JText::_( 'VideoFlow Itemid (optional)' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="5" maxsize="10" name="flowid" value="<?php echo $row->flowid; ?>" />
            </td>
            </tr>   
        </table> 
      </fieldset>
      
       <fieldset class="adminform">
	  <legend><?php echo JText::_( 'Menu Settings' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
            <label for="menu">
	    <?php echo JText::_( 'Active menu items' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo $row->jmenu; ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="helpid">
	    <?php echo JText::_( 'Help content id' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="helpid" value="<?php echo $row->helpid; ?>" />        
            </td>
            </tr>
          </table>
        </fieldset>
        <fieldset class="adminform">
	<legend><?php echo JText::_( 'System info' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
            <label for="xmlview">
	    <?php echo JText::_( 'Video sitemap link' ); ?>:
	    </label>
	    </td>
            <td>
            <a href="<?php echo JURI::root().'index.php?option=com_videoflow&view=xml'; ?>" target="_blank"><?php echo JURI::root().'index.php?option=com_videoflow&view=xml'; ?></a>
            </td>
            </tr>
          </table>
        </fieldset>
 <?php
  echo '</span>';
  echo $vfTabs->endPanel();
  echo $vfTabs->startPanel( 'Facebook Settings', 'tabthree' );
  echo '<span id="tab3" onClick="vftab = 2">';
  ?>
        <fieldset class="adminform">
       	<legend><?php echo JText::_( 'System Settings' ); ?></legend>
        <table class="admintable">        
            <tr>
            <td class="key">
	    <label for="fbkey">
	    <?php echo JText::_( 'App ID (API key)' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="80" maxsize="150" name="fbkey" value="<?php echo $row->fbkey; ?>" />
            </td>
            </tr>  
            <tr>
            <td class="key">
	    <label for="fbsecret">
	    <?php echo JText::_( 'App secret' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="80" maxsize="150" name="fbsecret" value="<?php echo $row->fbsecret; ?>" />
            </td>
            </tr>   
            <tr>
            <td class="key">
	    <label for="appname">
	    <?php echo JText::_( 'App name' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="30" maxsize="80" name="appname" value="<?php echo $row->appname; ?>" />
            </td>
            </tr>   
            <tr>
            <td class="key">
	    <label for="canvasurl">
	    <?php echo JText::_( 'Canvas URL' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="80" maxsize="150" name="canvasurl" value="<?php echo $row->canvasurl; ?>" />
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="canvasheight">
	    <?php echo JText::_( 'Canvas page height (optional)' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="canvasheight" value="<?php echo $row->canvasheight; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbcomments">
	    <?php echo JText::_( 'Activate comments' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbcomments', null, 'value', 'text', $row->fbcomments); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="wallposts">
	    <?php echo JText::_('Generate wall posts for frontend uploads' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'wallposts', null, 'value', 'text', $row->wallposts); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="bwallposts">
	    <?php echo JText::_('Generate wall posts for backend uploads' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'bwallposts', null, 'value', 'text', $row->bwallposts); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="profile_id">
	    <?php echo JText::_( 'Admin profile ID' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="30" maxsize="80" name="profile_id" value="<?php echo $row->profile_id; ?>" />
            </td>
            </tr> 
           </table> 
      </fieldset>
      
        <fieldset class="adminform">
       	<legend><?php echo JText::_( 'Display Settings' ); ?></legend>
        <table class="admintable">        
            <tr>
            <td class="key">
	    <label for="ftemplate">
	    <?php echo JText::_( 'Facebook template' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->selectftemp, 'ftemplate', null, 'value', 'text', $row->ftemplate); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="dashboard">
	    <?php echo JText::_( 'Show dashboard' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'dashboard', null, 'value', 'text', $row->dashboard); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="fbshowmylist">
	    <?php echo JText::_( 'Show add to my list button' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowmylist', null, 'value', 'text', $row->fbshowmylist); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbshowuser">
	    <?php echo JText::_( 'Show user' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowuser', null, 'value', 'text', $row->fbshowuser); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbshowviews">
	    <?php echo JText::_( 'Show play count' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowviews', null, 'value', 'text', $row->fbshowviews); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbshowplaylists">
	    <?php echo JText::_( 'Show playlist count' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowplaylists', null, 'value', 'text', $row->fbshowplaylists); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbshowrating">
	    <?php echo JText::_( 'Show rating' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowrating', null, 'value', 'text', $row->fbshowrating); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="fshowvotes">
	    <?php echo JText::_( 'Show number of votes' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fshowvotes', null, 'value', 'text', $row->fshowvotes); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="fshowdownloads">
	    <?php echo JText::_( 'Show number of downloads' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fshowdownloads', null, 'value', 'text', $row->fshowdownloads); ?>
            </td>
            </tr>
	    <tr>
            <td class="key">
	    <label for="fbshowdate">
	    <?php echo JText::_( 'Show date' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowdate', null, 'value', 'text', $row->fbshowdate); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="fbshowcategory">
	    <?php echo JText::_( 'Show category' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'fbshowcategory', null, 'value', 'text', $row->fbshowcategory); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="showfull">
	    <?php echo JText::_( 'Show full Joomla articles on Facebook' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo JHTML::_('select.radiolist', $row->bselect, 'showfull', null, 'value', 'text', $row->showfull); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	    <label for="ncatid">
	    <?php echo JText::_( 'Article categories to show' ); ?>:
	    </label>
	    </td>
            <td>
           <input type="text" size="80" maxsize="150" name="ncatid" value="<?php echo $row->ncatid; ?>" />
            </td>
            </tr> 
            <tr>
            <td class="key">
	    <label for="fbhelpid">
	    <?php echo JText::_( 'Help content id' ); ?>:
	    </label>
	    </td>
            <td>
            <input type="text" size="5" maxsize="10" name="fbhelpid" value="<?php echo $row->fbhelpid; ?>" />        
            </td>
            </tr>
          </table> 
      </fieldset>
      
       <fieldset class="adminform">
	  <legend><?php echo JText::_( 'Menu Settings' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td class="key">
            <label for="menu">
	    <?php echo JText::_( 'Active menu items' ); ?>:
	    </label>
	    </td>
            <td>
            <?php echo $row->fmenu; ?>
            </td>
            </tr>
          </table>
        </fieldset>
        
          <input type="hidden" name="fid" value="<?php echo $row->fid; ?>" />
          <input type="hidden" name="option" value="com_videoflow" />
          <input type="hidden" name="task" value="save" />
          <input type="hidden" name="vtab" value="" />	
          <input type="hidden" name="c" value="config" />
          <input type="hidden" name="helplink" value="54#edit" />
  <?php echo JHTML::_( 'form.token' ); ?>
  
 <?php
  echo '</span>';
  echo $vfTabs->endPanel();
  echo $vfTabs->startPanel( JText::_('Pro Updates'), 'tabfour' );
  echo '<span id="tab4" onClick="vftab = 3">';
  if (!$row->prostatus){
  $advisory = JText::_('Pro addons require the pro version of VideoFlow. You are running the standard version or your pro status has not yet been confirmed.');
  $upnow = JText::_('Upgrade to pro now.');
  $uplink = JRoute::_('index.php?option=com_videoflow&c=upgrade');
  echo "<br />".$advisory." <a href='$uplink'>$upnow</a><br /><br />";
  }   
  
  ?>		
      <table class="adminlist">
	<thead>
	<tr>
	<th width="10">
	<?php echo JText::_( 'Num' ); ?>
	</th>
        <th width="10%">
	<?php echo JText::_( 'Name' ); ?>
	</th>
        <th width="10%" nowrap="nowrap" class="title">
	<?php echo JText::_( 'Type' ); ?>
	</th>
	<th nowrap="nowrap">
	<?php echo JText::_( 'Description' ); ?>
	</th>
	<th width="10%" nowrap="nowrap">
	<?php echo JText::_( 'Platform' ); ?>
	</th>
        <th width="10%" nowrap="nowrap">
	<?php echo JText::_( 'Status' ); ?>
	</th>
	<th width="10%" nowrap="nowrap">
	<?php echo JText::_( 'Action' ); ?>
	</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
	<td colspan="12">
	</td>
	</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	$i = 1;
      foreach($row->proadds as $vrow) {	
        if ($vrow->status == 1) {
        $vstatus = JText::_('Installed');
        $vlink = JRoute::_('index.php?option=com_videoflow&c=upgrade&task=autoupdate&action=remove&aid='.$vrow->id.'&aname='.$vrow->name);
        $vdisp = JText::_('Remove');
        } else {
        $vstatus = JText::_('Not Installed');
        $vlink = JRoute::_('index.php?option=com_videoflow&c=upgrade&task=autoupdate&action=install&aid='.$vrow->id.'&aname='.$vrow->name);
        $vdisp = JText::_('Install');
        }
        $vaction = '<a href="'.$vlink.'">'.$vdisp.'</a>'; 
        if (!$row->prostatus) $vaction = $vdisp;			        		    
	?>
	<tr class="<?php echo "row$k"; ?>">
	<td align="center">
	<?php echo $i++; ?>
	</td>
	<td>
	<?php echo $vrow->propername; ?>
	</td>
        <td align="center">
	<?php echo $vrow->type; ?>
	</td>
	<td>
	<?php echo $vrow->desc;?>
	</td>
	<td align="center">
	<?php echo $vrow->platform;?>
	</td>
	<td align="center">
	<?php echo $vstatus;?>
	</td>
	<td align="center">
	<?php echo $vaction;?>
	</td>
        </tr>
	<?php
	$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
       
 <?php
  echo '</span>';
  echo $vfTabs->endPanel();  
  echo $vfTabs->startPanel( JText::_('About VideoFlow'), 'tabfive' );
  echo '<span id="tab5" onClick="vftab = 4">';
  ?>
      
       <fieldset class="adminform">
          <table class="admintable">
            <tr>	
            <td>
           	<?php echo $row->vcredit; ?>
            </td>
            </tr>
         </table>
        </fieldset>

       
 <?php
 echo '</span>';
  echo $vfTabs->endPanel();
  echo $vfTabs->endPane();
 ?>
        <br />
 <?php
    if ($row->message) {
    ?>       
        <fieldset class="adminform">
        	<legend><?php echo JText::_( 'Message Centre' ); ?></legend>
          <table class="admintable">
            <tr>	
            <td>
            <?php echo $row->msg;?>
            </td>
           </tr>
          </table>
        </fieldset>
  <?php
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
      </div>
  </form>
	<div class="clr"></div>
<?php 
}

function donate(){
global $vparams;
  echo 'Upgrading to Pro is a <b>two-step</b> process: <br/><br/>';
  echo '<b>STEP 1.</b> Click the PayPal buttom below to pay $30 (thirty United States dollars) for a one year subscription.<br/><br/>
        During your subscription period, all new plugins, modules and software updates are free.<br />';
  echo 'Your installed VideoFlow software continues to work in pro mode without any limitations when your subscription expires.<br/>';
  echo 'Each subscription is for only ONE domain and, upon request, TWO subdomains. <br/>';
  echo '<a href="http://videoflow.fidsoft.com/index.php?option=com_content&view=article&id=66" target="_blank">Read the terms of subscription</a> before you upgrade.<br/><br/>';


PRINT <<<DONATE
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="PRX6Y33VSEJEU">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
DONATE;

echo '<br/><br/>';

echo '<b>STEP 2.</b> When you have completed the PayPal transaction, click the "Upgrade" button.<br/><br/>';

PRINT <<<UPGRADE
<form action="index.php" method="post" name="adminForm">
Email address (Used only for support) : <input type="text" size="50" maxsize="100" name="email" value=""/>
<input type="hidden" name="option" value="com_videoflow" />
<input type="hidden" name="task" value="processpro" />
<input type="hidden" name="c" value="upgrade" />
<input type="hidden" name="version" value="$vparams->version" />
<input type="hidden" name="vcode" value="$vparams->fkey" />
<input type="hidden" name="prostatus" value="$vparams->prostatus" />
<input type="submit" value="Upgrade">
</form>
<br/>
If support email address is different from your PayPal email, you must send us separate email at <a href="mailto: admin@fidsoft.com"> admin@fidsoft.com </a> indicating your domain name and the PayPal transaction id for us to confirm your upgrade.
UPGRADE;

echo '<br/><br/>';

echo 'To evaluate the pro version, click the upgrade button without paying. You system will run in pro mode for seven days.<br/><br/>';
echo 'A non-exhaustive comparison between Pro and Standard versions is <a href="http://videoflow.fidsoft.com/index.php?option=com_content&view=article&id=62" target="_blank">available here.</a><br/><br/>';
echo 'Visit <a href="http://www.fidsoft.com" target="_blank">fidsoft.com</a> for information about Pro features and support.<br/><br/>';
}
}