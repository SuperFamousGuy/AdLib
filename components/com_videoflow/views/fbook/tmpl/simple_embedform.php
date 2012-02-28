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

$row = $this->xdata;  
    $pixpreview = stripslashes($row->pixlink);
    if (empty($pixpreview)){
    $pixpreview = JURI::root().'components/com_videoflow/players/vflow.png';
    }
 ?>

	<form enctype="multipart/form-data" action="&task=saveRemote" method="post" name="adminForm">
	<div class="col100">
			<fieldset class="vf_forms">
				<legend><?php echo JText::_( 'Media Details' ); ?></legend>
          <table class="admintable" style="width:100%;">
            <tr>
            <td class="adminvthumb">
            <img src="<? echo $pixpreview; ?>" height=75 />
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
            <input type="text" size="80" maxsize="110" name="title" value="<?php echo $this->escape($row->title); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
							<label for="published">
								<?php echo JText::_( 'Published' ); ?>:
							</label>
						</td>
            <td> 
            <?php echo JHTML::_('select.genericlist', $row->bselect, 'published', null, 'value', 'text', '1'); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
							<label for="category">
								<?php echo JText::_( 'Category' ); ?>:
							</label>
						</td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->catlist, 'cat', null, 'catid', 'name', $row->selcat); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
							<label for="tags">
								<?php echo JText::_( 'Tags' ); ?>:
							</label>
						</td>
            <td>
            <input type="text" size="80" maxsize="110" name="tags" value="<?php echo $this->escape($row->tags); ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
							<label for="description">
								<?php echo JText::_( 'Description' ); ?>:
							</label>
						</td>
            <td>
            <textarea name="details" cols="45" rows="6" value="" wrap="soft"><?php echo $this->escape(stripslashes($row->details)); ?></textarea>
            </td>
            </tr>  
          </table> 
          <table class="admintable" style="width:100%;">
            <tr>
            <td class="adminvthumb">
            <button onclick="document.adminForm.submit()" name="submit_button"><? echo JText::_( 'Save' ); ?></button> 
            <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><? echo JText::_( 'Cancel' ); ?></button>
            </td>
            </tr>
          </table>
      
          <input type="hidden" name="medialink" value="<?php echo $row->medialink; ?>" />
          <input type="hidden" name="file" value="<?php echo $row->file; ?>" />
          <input type="hidden" name="pixlink" value="<? echo $row->pixlink; ?>">
          <input type="hidden" name="type" value="<?php echo $row->type; ?>" />
          <input type="hidden" name="userid" value="<?php echo $row->userid; ?>" >
          <input type="hidden" name="server" value="<? echo $row->server; ?>">
          <input type="hidden" name="dateadded" value="<? echo $row->dateadded; ?>">
          <input type="hidden" name="id" value="0" />
      </fieldset>
  </div>          
 	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<div class="clr"></div>  