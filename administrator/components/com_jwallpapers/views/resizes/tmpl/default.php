<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

JToolBarHelper::title ( JText::_ ( 'RESIZES' ), 'jwallpapers_resizes' );


JHTML::_ ( 'behavior.tooltip' );

$js = 'var jwallpapers_regenerateResizesWarn = "' . JText::_ ( 'REGENERATE_RESIZES_WARNING' ) . '";
var jwallpapers_regenerateThumbsWarn = "' . JText::_ ( 'REGENERATE_THUMBS_WARNING' ) . '";

function confirmRegenerate() {
	
	if (confirm ( jwallpapers_regenerateResizesWarn )) {
		return true;
	} else {
		return false;
	}
}

function confirmRegenarateThumbs() {
	
	if (confirm ( jwallpapers_regenerateThumbsWarn )) {
		return true;
	} else {
		return false;
	}
}

function confirmDeleteWaterOrgs() {
	
	if (confirm ( jwallpapers_deleteWaterOrgsWarn )) {
		return true;
	} else {
		return false;
	}
}

';

$document = & JFactory::getDocument ();
$document->addScriptDeclaration ( $js );

?>
<form action="index.php" method="post" id="adminForm" name="adminForm">
<fieldset><legend><?php
echo JText::_ ( 'IMAGES' );
?></legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'RESIZES_IN_ARCHIVE_DESC' );
			?>"><?php
			echo JText::_ ( 'RESIZES_IN_ARCHIVE' );
			?></label></span></td>
		<td>
			<?php
			echo '&nbsp;<span class="green_msg">' . $this->resizes_in_archive . '</span>';
			
			echo '&nbsp;&nbsp;&nbsp;<input type="submit" name="submitButton" value="' . JText::_ ( 'RE_GENERATE_RESIZES' ) . '" onClick="return confirmRegenerate();" />';
			
			echo '&nbsp;<input type="submit" name="submitButton" value="' . JText::_ ( 'DELETE_ALL_RESIZES' ) . '" onClick="return confirmDelete();" />';
			?>
			</td>
	</tr>
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'DELETE_WATER_ORGS_DESC' );
			?>"><?php
			echo JText::_ ( 'DELETE_WATER_ORGS' );
			?></label></span></td>
		<td>
			<?php
			echo '&nbsp;<input type="submit" name="submitButton" value="' . JText::_ ( 'DELETE_WATER_ORGS' ) . '" onClick="return confirmDeleteWaterOrgs();" />';
			?>
			</td>
	</tr>
</table>
</fieldset>
<fieldset><legend><?php
echo JText::_ ( 'THUMBNAILS' );
?></legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'PROCESSING_THUMBS_STATUS_DESC' );
			?>"><?php
			echo JText::_ ( 'PROCESSING_THUMBS_STATUS' );
			?></label></span></td>
		<td class="paramlist_value">
		<?php
		echo '&nbsp;' . $this->thresizes_info;
		?>&nbsp;&nbsp;&nbsp;
		<input type="submit" name="submitButton"
			value="<?php
			echo JText::_ ( 'RE_GENERATE_THUMBS' );
			?>"
			onClick="return confirmRegenarateThumbs();" />&nbsp;<input
			type="submit" name="submitButton"
			value="<?php
			echo JText::_ ( 'DELETE_ALL_THUMBS' );
			?>"
			onClick="return confirmDeleteThumbs();" /></td>
	</tr>
</table>
</fieldset>
<input type="hidden" name="option" value="<?php
echo $option;
?>" /> <input type="hidden" name="controller" value="resizes" /> <input
	type="hidden" name="task" value="processResizesForm" />
<?php
echo JHTML::_ ( 'form.token' );
?>
</form>