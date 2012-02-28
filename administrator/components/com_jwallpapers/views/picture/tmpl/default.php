<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 351 2010-06-01 09:32:08Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

JHTML::_ ( 'behavior.mootools' );

JHTML::_ ( 'behavior.tooltip' );

JHTML::_ ( 'behavior.calendar' );



if ($this->task == 'edit') {
	JToolBarHelper::title ( JText::_ ( 'EDIT_PICTURE' ), 'jwallpapers_edit_pictures' );
	JToolBarHelper::save ();
	JToolBarHelper::apply ();
	JToolBarHelper::custom ( 'manageTaggedPics', 'jwallpapers_manage_tagged_pics', 'jwallpapers_manage_tagged_pics_over', JText::_ ( 'MANAGE_TAGGED_PICS' ), false, false );
	JToolBarHelper::cancel ();
} elseif ($this->task == 'add') {
	JToolBarHelper::title ( JText::_ ( 'ADD_PICTURES' ), 'jwallpapers_add_pictures' );
	JToolBarHelper::save ();
	JToolBarHelper::cancel ();
}

$document = & JFactory::getDocument ();

$js = 'var jwallpapers_option = "' . $option . '";
var jwallpapers_pic_id = "' . $this->row->id . '";
var jwallpapers_adminStepDown = "";
var jwallpapers_tagging_pic = "' . JText::_ ( 'TAGGING_PIC' ) . '";
var jwallpapers_pic_tagged = "' . JText::_ ( 'PIC_TAGGED' ) . '";
var jwallpapers_pic_tag_failed = "' . JText::_ ( 'PIC_TAG_FAILED' ) . '";
var jwallpapers_pic_tag_exists = "' . JText::_ ( 'PIC_TAG_EXISTS' ) . '";
var jwallpapers_untagging_pic = "' . JText::_ ( 'UNTAGGING_PIC' ) . '";
var jwallpapers_pic_untagged = "' . JText::_ ( 'PIC_UNTAGGED' ) . '";
var jwallpapers_pic_untag_failed = "' . JText::_ ( 'PIC_UNTAG_FAILED' ) . '";
var jwallpapers_notIntegerWidth = "' . JText::_ ( 'NOT_INTEGER_WIDTH' ) . '";
var jwallpapers_notIntegerHeight = "' . JText::_ ( 'NOT_INTEGER_HEIGHT' ) . '";
var jwallpapers_deleteConfirm = "' . JText::_ ( 'DELETE_CONFIRMATION' ) . '";

window
	.addEvent(\'domready\', function() {
	    $$(\'a.toolbar\')
		    .each( function(el) {
		    	var str = el.innerHTML;
		    	var res = str.match(/<span[\s\S]*?<\/span>/);
		    	if (res) {
		    		el.innerHTML = res;
		    	}
			})
	});';

$document->addScriptDeclaration ( $js );

if ($this->task == 'edit') {
	?>
<div><img src="<?php
	echo $this->picFile;
	?>" alt=""
	style="margin-left: 10px;" /></div>
<?php
	
	$document->addScript ( 'components/' . $option . '/js/ajaxBackendTagUntag.js' );
	$document->addScript ( 'components/' . $option . '/js/common.js' );
	$document->addScript ( 'components/' . $option . '/js/availableResizes.js' );

} else {
	
	
	

	$js = 'function submitbutton(pressbutton) {
	if (pressbutton == \'save\' || pressbutton == \'apply\') {
		if (document.adminForm.picturefile.value == \'\' && document.adminForm.picturefile_server.value == \'\') {
			alert("' . JText::_ ( 'MISSING_UPLOAD_PICTURE' ) . '");
		} else {
			submitform(pressbutton);
		}
	} else {
		submitform(pressbutton);
	}
}';
	
	$document->addScriptDeclaration ( $js );

}
?>

<form action="index.php" method="post" name="adminForm" id="adminForm"
	enctype="multipart/form-data">
<fieldset class="adminform"><legend><?php
echo JText::_ ( 'DETAILS' );
?></legend>
<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'TITLE' );
		?>:</td>
		<td><input class="text_area" type="text" name="title" id="title"
			size="50" maxlength="250"
			value="<?php
			echo htmlspecialchars ( $this->row->title, ENT_QUOTES );
			?>"
			onkeyup="titleLimiter(this.form);" /><br />
		<script language=javascript>
document.write("<input type='text' name='titleLimit' size='2' readonly style='margin-top: 3px;' value='"+titleCount+"'>");
</script>&nbsp;<?php
echo JText::_ ( 'CHARACTERS_LEFT' );
?>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'ALIAS' );
		?>:</td>
		<td><input class="text_area" type="text" name="alias" id="alias"
			size="50" maxlength="250"
			value="<?php
			echo htmlspecialchars ( $this->row->alias, ENT_QUOTES );
			?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'DESCRIPTION' );
		?>:</td>
		<td><textarea class="text_area" cols="20" rows="4" name="description"
			id="description" style="width: 500px"
			onkeyup="descriptionLimiter(this.form);"><?php
			echo htmlspecialchars ( $this->row->description, ENT_QUOTES );
			?></textarea><br />
		<script language=javascript>
document.write("<input type='text' name='descriptionLimit' size='4' readonly style='margin-top: 3px;' value='"+descriptionCount+"'>");
</script>&nbsp;<?php
echo JText::_ ( 'CHARACTERS_LEFT' );
?>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'KEYWORDS' );
		?>:</td>
		<td><textarea class="text_area" cols="20" rows="4" name="keywords"
			id="keywords" style="width: 500px"
			onkeyup="keywordsLimiter(this.form);"><?php
			echo htmlspecialchars ( $this->row->keywords, ENT_QUOTES );
			?></textarea><br />
		<script language=javascript>
document.write("<input type='text' name='keywordsLimit' size='3' readonly style='margin-top: 3px;' value='"+keywordsCount+"'>");
</script>&nbsp;<?php
echo JText::_ ( 'CHARACTERS_LEFT' );
?>
		</td>
	</tr>
	<?php
	if ($this->task == 'edit') {
		?>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
		echo JText::_ ( 'AVAILABLE_RESIZES_FILE_DESC' );
		?>"><?php
		echo JText::_ ( 'AVAILABLE_RESIZES_FILE' );
		?></label></span></td>
		<td>
		<div id="availableResizes">
	<?php
		echo JWallpapersHelperLayout::getResizeListLayout ( $this->file_resizes );
		?>
	</div>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'IS_EP' );
		?>:</td>
		<td><?php
		echo $this->tag_ep;
		?></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'IS_OWNER' );
		?>:</td>
		<td>
	  <?php
			echo $this->is_owner;
			?><br />
		<input class="text_area" type="text" name="owner" id="owner" value="<?php
		echo htmlspecialchars ( $this->row->owner, ENT_QUOTES );
		?>" style="display: <?php
		echo ($this->row->is_owner) ? "none" : ""?>;" onkeyup="ownerLimiter(this.form);"  />
		<br />
		<span id="owner_note" class="form_note" style="display: <?php
		echo ($this->row->is_owner) ? "none" : ""?>;" ><?php
		echo JTEXT::_ ( 'IF_NOT_OWNER' );
		?></span></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'CATEGORY' );
		?>:</td>
		<td>




		<div id="ajax_category">
	    <?php
					JWallpapersHelperLayout::getCatSelectLayout ( $this->catList, $this->catPath );
					?>
	    
	 
	  </div>
	  <?php
			
			$document->addScript ( 'components/' . $option . '/js/ajaxCatSelect.js' );
			$document->addScript ( 'components/' . $option . '/js/commonForm.js' );
			$document->addScript ( 'components/' . $option . '/js/commonPictureForm.js' );
			?>
	  
	</td>
	</tr>
	<?php
	if ($this->task == 'edit') {
		?>
	<tr>
		<td width="100" align="right" class="key">
	<?php
		echo JText::_ ( 'TAGGING' );
		?>:
	</td>
		<td>
	<?php
		$callbacks = array ('"backendAjaxTagFiles();"' );
		echo JWallpapersHelperLayout::getSearchTagLayout ( $callbacks );
		?>
		<div id="tag_pic_status"></div>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key">
	<?php
		echo JText::_ ( 'UNTAGGING' );
		?>:
	</td>
		<td>
		<?php
		echo '<div id="ajax_remove_pic_tags">' . JWallpapersHelperLayout::getUntagPicLayout ( $this->pic_tags, $this->row->id ) . '</div>';
		?>
		<div id="untag_pic_status"></div>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'PUBLISHED' );
		?>:</td>
		<td>
	  <?php
			echo $this->published;
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'VOTES_ENABLED' );
		?>:</td>
		<td>
	  <?php
			echo $this->votes_en;
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'DOWNLOADABLE' );
		?>:</td>
		<td>
	  <?php
			echo $this->downloadable;
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'PICTURE_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'PICTURE_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'item_deny_acl', $this->row->item_deny_acl );
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'PICTURE_VOTES_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'PICTURE_VOTES_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'votes_deny_acl', $this->row->votes_deny_acl );
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'PICTURE_DOWNLOADS_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'PICTURE_DOWNLOADS_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'downloads_deny_acl', $this->row->downloads_deny_acl );
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'PICTURE_TAGGING_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'PICTURE_TAGGING_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'tagging_deny_acl', $this->row->tagging_deny_acl );
			?>
	</td>
	</tr>
      <?php
						if ($this->task == 'add') {
							?> 
      <tr>
		<td width="100" align="right" class="key"><?php
							echo JText::_ ( 'FILE_UPLOAD' );
							?>:<br />
		<?php
							echo JText::_ ( 'FILE_ZIP_BULK' );
							?></td>
		<td><?php
							echo JText::_ ( 'BULK_UPLOAD_WARNING' ) . '<br />';
							?><input type="file" name="picturefile" value="" /> <br />
			<?php
							echo JText::_ ( 'OR' ) . ' ' . JText::_ ( 'FILE_UPLOAD_SERVER' );
							?><br />
		<input class="text_area" type="text" name="picturefile_server"
			id="picturefile_server" size="50" value="" /></td>
	</tr>

      <?php
						}
						?>
    </table>
</fieldset>
<input type="hidden" name="upload_date"
	value="<?php
	echo $this->row->upload_date;
	?>" /> <input type="hidden" name="user_id"
	value="<?php
	echo $this->row->user_id;
	?>" /> <input type="hidden" name="id"
	value="<?php
	echo $this->row->id;
	?>" /> <input type="hidden" name="option"
	value="<?php
	echo $option;
	?>" /> <input type="hidden" name="tag_ep_current"
	value="<?php
	echo $this->tag_ep_current;
	?>" /> <input type="hidden" name="task" value="" />
  <?php
		echo JHTML::_ ( 'form.token' );
		?>
</form>