<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default_picture_form.php 242 2010-03-24 19:04:05Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

JHTML::_ ( 'behavior.mootools' );
?>

<?php
$js = 'var jwallpapers_option = "' . $option . '";
var jwallpapers_selectCatMsg = "' . JText::_ ( 'FORM_VAL_SELECT_CAT' ) . '";
var jwallpapers_enterNewCatNameMsg = "' . JText::_ ( 'FORM_VAL_ENTER_CAT_NAME' ) . '";
var jwallpapers_selectFileMsg = "' . JText::_ ( 'FORM_VAL_SELECT_FILE' ) . '";
var jwallpapers_bePatientMsg = "' . JText::_ ( 'FORM_VAL_BE_PATIENT' ) . '";
var jwallpapers_insertValidCodeMsg = "' . JText::_ ( 'FORM_VAL_INSERT_VALID_CODE' ) . '";
var jwallpapers_filesUploadingMsg = "' . JText::_ ( 'FORM_VAL_FILES_UPLOADING' ) . '";
var jwallpapers_upload_boxes = ' . $this->upload_boxes . ';';
$document = & JFactory::getDocument ();
$document->addScriptDeclaration ( $js );
?>

<center><?php
echo JWallpapersHelperLayout::getFormInputType ( 'optional' );
?>:&nbsp<span><?php
echo JTEXT::_ ( 'OPTIONAL' );
?></span>&nbsp&nbsp&nbsp
<?php
echo JWallpapersHelperLayout::getFormInputType ( 'mandatory' );
?>:&nbsp<span><?php
echo JTEXT::_ ( 'MANDATORY' );
?></span></center>
<form action="index.php" id="pictureForm" <?php
echo $this->id_class;
?>
	name="pictureForm" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td width="150px"><strong><?php
		echo JTEXT::_ ( 'PICTURE_TITLE' );
		?>:</strong></td>
		<td colspan="2"><input
			class="text_area<?php
			echo $this->class_suffix;
			?>" type="text"
			name="title" id="title" value="" onkeyup="titleLimiter(this.form);" /><br />
		<script language=javascript>
document.write("<input type='text' name='titleLimit' size='2' readonly style='margin-top: 3px;' value='"+titleCount+"'>");
</script>&nbsp;<?php
echo JText::_ ( 'CHARACTERS_LEFT' );
?></td>
		<td><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'optional' );
		?></td>
	</tr>
	<tr>
		<td><strong><?php
		echo JTEXT::_ ( 'PICTURE_DESCRIPTION' );
		?>:</strong></td>
		<td colspan="2"><textarea
			class="text_area<?php
			echo $this->class_suffix;
			?>" cols="40"
			rows="4" name="description" id="description" value=""
			onkeyup="descriptionLimiter(this.form);"></textarea> <br />
		<script language=javascript>
document.write("<input type='text' name='descriptionLimit' size='4' readonly style='margin-top: 3px;' value='"+descriptionCount+"'>");
</script>&nbsp;<?php
echo JText::_ ( 'CHARACTERS_LEFT' );
?>
			</td>
		<td><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'optional' );
		?></td>
	</tr>
	<tr>
		<td><strong><?php
		echo JText::_ ( 'IS_OWNER' );
		?>:</strong></td>
		<td colspan="2">
<?php
echo $this->is_owner;
?></td>
		<td><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'mandatory' );
		?></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2"><input
			class="text_area<?php
			echo $this->class_suffix;
			?>" type="text"
			name="owner" id="owner" value="" style="display: none;"
			onkeyup="ownerLimiter(this.form);" /></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2" class="form_note<?php
		echo $this->class_suffix;
		?>"><br />
		<span id="owner_note"
			class="form_note<?php
			echo $this->class_suffix;
			?>"
			style="display: none;"><?php
			echo JTEXT::_ ( 'IF_NOT_OWNER' );
			?></span></td>
	</tr>
	<tr>
		<td><strong><?php
		echo JTEXT::_ ( 'CATEGORY' );
		?>:</strong></td>
		<td colspan="2">
		<div id="ajax_category" <?php
		echo $this->id_class;
		?>>
<?php
JWallpapersHelperLayout::getCatSelectLayout ( $this->catList, $this->catPath );
if ($this->show_captcha) {
	$document->addScript ( 'administrator/components/' . $option . '/js/validateForm.js' );
	$document->addScript ( 'administrator/components/' . $option . '/js/ajaxCaptcha.js' );
} else {
	$document->addScript ( 'administrator/components/' . $option . '/js/validateFormNoCaptcha.js' );
}
$document->addScript ( 'administrator/components/' . $option . '/js/ajaxCatSelect.js' );
$document->addScript ( 'administrator/components/' . $option . '/js/commonForm.js' );
$document->addScript ( 'administrator/components/' . $option . '/js/commonPictureForm.js' );
?>
</div>
		</td>
		<td><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'mandatory' );
		?></td>
	</tr>
	<tr>
		<td rowspan="<?php
		echo ceil ( $this->upload_boxes / 2 );
		?>"><strong><?php
		echo JTEXT::_ ( 'SELECT_FILE' )?>:</strong></td>
		<?php
		for($i = 0; $i < $this->upload_boxes; $i ++) {
			?>
			<td><input type="hidden" name="MAX_FILE_SIZE"
			value="<?php
			echo $this->max_upload_size * 1024?>"><input type="file"
			name="picturefile_<?php
			echo $i;
			?>"
			id="picturefile_<?php
			echo $i;
			?>" value=""
			<?php
			echo $this->id_class;
			?> /></td>
			<?php
			if ($i % 2) {
				if ($i == 1) {
					echo '<td rowspan="' . ceil ( $this->upload_boxes / 2 ) . '">' . JWallpapersHelperLayout::getFormInputType ( 'mandatory' ) . '</td>';
				}
				
				echo '</tr><tr>';
			}
			
			
			if ($this->upload_boxes == 1) {
				echo '<td></td><td>' . JWallpapersHelperLayout::getFormInputType ( 'mandatory' ) . '</td>';
			}
		
		}
		?>
	</tr>
	<tr>
		<td></td>
		<td colspan="2" class="form_note<?php
		echo $this->class_suffix;
		?>"><span
			class="form_note<?php
			echo $this->class_suffix;
			?>"><?php
			echo JText::_ ( 'MAX_ALLOWED_FILE_SIZE' ) . ': ' . $this->max_upload_size . ' KB';
			?></span><br /><span class="form_note<?php
		echo $this->class_suffix;
		?>"><?php
		echo JText::_ ( 'MAX_ALLOWED_RESOLUTION' ) . ': ' . $this->max_upload_resolution . ' Mpx (1 Mpx = 1000000 px)';
		?></span><?php
		if ($this->selective_resolution) {
			echo '<br /><span class="form_note' . $this->class_suffix . '">' . JText::_ ( 'ALLOWED_RESOLUTIONS' ) . ': ' . $this->allowedResolutionsString . '</span>';
		}
		?></td>
	</tr>
	<?php
	if ($this->show_captcha) {
		?>
	<tr>
		<td><strong><?php
		echo JTEXT::_ ( 'CAPTCHA' )?>:</strong></td>
		<td colspan="2">
		<div style="width: 120px; height: 60px;" id="captchaImage"
			<?php
		echo $this->id_class;
		?>><img
			src="<?php
		echo $this->kcaptchaURL . DS . 'index.php';
		?>"></div>
		<a href="#" onClick="refreshCaptcha(); return false;"><image
			src="components/<?php
		echo $option;
		?>/images/default/icons/recur.png"
			alt="refresh" title="Refresh" /></a><input type="text" name="keystring" id="keystring"
			<?php
		echo $this->id_class;
		?>/></td>
		<td><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'mandatory' );
		?></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2" class="form_note<?php
		echo $this->class_suffix;
		?>"><span
			class="form_note<?php
		echo $this->class_suffix;
		?>"><?php
		echo JTEXT::_ ( 'INSERT_SEC_CODE' );
		?></span></td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td><input type="hidden" name="user_id"
			value="<?php
			echo $this->user_id;
			?>" />
		<div id="button_container" <?php
		echo $this->id_class;
		?>><input
			type="submit" id="button"
			value="<?php
			echo JTEXT::_ ( 'SUBMIT' );
			?>"
			<?php
			echo $this->id_class;
			?> /></div>
		<div id="uploading_msg_container" <?php
		echo $this->id_class;
		?>></div>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2">
		<center><?php
		echo JWallpapersHelperLayout::getFormInputType ( 'optional' );
		?>:&nbsp<span><?php
		echo JTEXT::_ ( 'OPTIONAL' );
		?></span>&nbsp&nbsp&nbsp
<?php
echo JWallpapersHelperLayout::getFormInputType ( 'mandatory' );
?>:&nbsp<span><?php
echo JTEXT::_ ( 'MANDATORY' );
?></span>
<?php
if ($this->show_credits) {
	?>
		<div class="jw_credits<?php echo $this->class_suffix; ?>"><a href="http://www.wextend.com">Powered by JWallpapers</a></div>
		<?php
}
?>
		</td>
	</tr>
</table>
<?php
if (! $this->show_captcha) {
	
	echo '<input type="hidden" name="keystring" value="" />';
}
?>
<input type="hidden" name="option" value="<?php
echo $option;
?>" /> <input type="hidden" name="task" value="addPictures" /> <input
	type="hidden" name="Itemid" value="<?php
	echo $this->Itemid;
	?>" /><input type="hidden" name="upload_boxes"
	value="<?php
	echo $this->upload_boxes;
	?>" /><input type="hidden" name="signature"
	value="<?php
	echo $this->signature;
	?>" />
	<?php
	echo JHTML::_ ( 'form.token' );
	?>
	</form>