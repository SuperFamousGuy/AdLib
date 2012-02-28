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

jimport ( 'joomla.html.pane' );

JHTML::_ ( 'behavior.tooltip' );
$pane = & JPane::getInstance ( 'tabs' );

JToolBarHelper::title ( JText::_ ( 'SETTINGS' ), 'jwallpapers_settings' );


JToolBarHelper::save ();
JToolBarHelper::apply ();

$document = & JFactory::getDocument ();

$js = 'var jwallpapers_option = "' . $option . '";
var jwallpapers_notIntegerWidth = "' . JText::_ ( 'NOT_INTEGER_WIDTH' ) . '";
var jwallpapers_notIntegerHeight = "' . JText::_ ( 'NOT_INTEGER_HEIGHT' ) . '";
var jwallpapers_deleteConfirm = "' . JText::_ ( 'DELETE_CONFIRMATION' ) . '";
var jwallpapers_apache_chk_success = "' . JText::_ ( 'APACHE_CHK_SUCCESS' ) . '";
var jwallpapers_apache_chk_failure = "' . JText::_ ( 'APACHE_CHK_FAILURE' ) . '";
var jwallpapers_apache_chk_not_conclusive = "' . JText::_ ( 'APACHE_CHK_NOT_CONCLUSIVE' ) . '";
var jwallpapers_thumb_conf_change_alert = "' . JText::_ ( 'THUMB_CONF_CHANGE_ALERT' ) . '";
var jwallpapers_regenerateResizesWarn = "' . JText::_ ( 'REGENERATE_RESIZES_WARNING' ) . '";
var jwallpapers_regeneratingResizes = "' . JText::_ ( 'REGENERATING_RESIZES' ) . '";
var jwallpapers_regenerateResizesSuccess = "' . JText::_ ( 'REGENERATE_RESIZES_SUCCESS' ) . '";
var jwallpapers_regenerateThumbsWarn = "' . JText::_ ( 'REGENERATE_THUMBS_WARNING' ) . '";
var jwallpapers_regeneratingThumbs = "' . JText::_ ( 'REGENERATING_THUMBS' ) . '";
var jwallpapers_regenerateThumbsSuccess = "' . JText::_ ( 'REGENERATE_THUMBS_SUCCESS' ) . '";
var jwallpapers_deleteWaterOrgsWarn = "' . JText::_ ( 'DELETE_WATER_ORGS_WARNING' ) . '";
var jwallpapers_deletingWaterOrgs = "' . JText::_ ( 'DELETING_WATER_ORGS' ) . '";
var jwallpapers_deleteWaterOrgsSuccess = "' . JText::_ ( 'DELETE_WATER_ORGS_SUCCESS' ) . '";

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
$document->addScript ( 'components/' . $option . '/js/common.js' );
$document->addScript ( 'components/' . $option . '/js/availableResizes.js' );
$document->addScript ( 'components/' . $option . '/js/allowedResolutions.js' );
$document->addScript ( 'components/' . $option . '/js/ajaxConfChecks.js' );
$document->addScript ( 'components/' . $option . '/js/thumbConfChangeAlert.js' );
$document->addScript ( 'components/' . $option . '/js/manageResizes.js' );
$document->addScript ( 'components/' . $option . '/js/manageWatermarks.js' );

?>

<form action="index.php" method="post" name="adminForm">

<?php
echo $pane->startPane ( 'menu-pane' );
echo $pane->startPanel ( JText::_ ( 'GENERAL_SETTINGS' ), 'general' );
echo '<fieldset><legend>' . JText::_ ( 'GENERAL' ) . '</legend>';
echo $this->params->render ( 'params', 'GENERAL_SETTINGS' );
?>
	<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'IMAGE_LIBRARIES_DESC' );
			?>"><?php
			echo JText::_ ( 'IMAGE_LIBRARIES' );
			?></label></span></td>
		<td class="paramlist_value"><select name="image_library">
	<?php
	foreach ( $this->image_library_select_opts as $image_library_select_opt ) {
		echo $image_library_select_opt;
	}
	?>
	</select><br />
		<br />
		<fieldset><legend><?php
		echo JText::_ ( 'IMAGE_LIBRARIES_INFO' );
		?></legend>
		<ul>
			<?php
			foreach ( $this->image_libraries_info as $image_library_info ) {
				echo $image_library_info;
			}
			?>
		</ul>
		</fieldset>
		</td>
	</tr>
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'APACHE_CONF_CHECK_DESC' );
			?>"><?php
			echo JText::_ ( 'APACHE_CONF_CHECK' );
			?></label></span></td>
		<td class="paramlist_value">
		<?php
		echo $this->apache_conf_chk_link;
		?>
		<br />
		<br />
		<div id="ajax_apache_conf_check_result"></div>
		</td>
	</tr>
</table>
	<?php
	echo '</fieldset><fieldset><legend>' . JText::_ ( 'VOTES' ) . '</legend>';
	echo $this->params->render ( 'params', 'VOTES_SETTINGS' );
	echo '</fieldset><fieldset><legend>' . JText::_ ( 'LIGHTBOX' ) . '</legend>';
	echo $this->params->render ( 'params', 'LIGHTBOX_SETTINGS' ) . '</fieldset>';
	echo '<fieldset><legend>' . JText::_ ( 'MESSAGING' ) . '</legend>';
	echo $this->params->render ( 'params', 'MESSAGING_SETTINGS' ) . '</fieldset>';
	echo '<fieldset><legend>' . JText::_ ( 'ACCESS_CONTROL' ) . '</legend>';
	echo $this->params->render ( 'params', 'ACCESS_CONTROL' ) . '</fieldset>';
	echo $pane->endPanel ();
	echo $pane->startPanel ( JText::_ ( 'LAYOUT_SETTINGS' ), 'layout' );
	echo '<br /><fieldset><legend>' . JText::_ ( 'DISPLAY' ) . '</legend>';
	echo '<p><b>' . JText::_ ( 'DISPLAY_MODE_TITLE_CLASSIC' ) . '</b>: ' . JText::_ ( 'DISPLAY_MODE_EXPLAIN_CLASSIC' ) . '</p>';
	echo '<p><b>' . JText::_ ( 'DISPLAY_MODE_TITLE_JWALLPAPERS' ) . '</b>: ' . JText::_ ( 'DISPLAY_MODE_EXPLAIN_JWALLPAPERS' ) . '</p>';
	echo $this->params->render ( 'params', 'DISPLAY_SETTINGS' );
	echo '</fieldset><fieldset><legend>' . JText::_ ( 'LAYOUT' ) . '</legend>';
	echo $this->params->render ( 'params', 'LAYOUT_SETTINGS' ) . '</fieldset>';
	echo $pane->endPanel ();
	echo $pane->startPanel ( JText::_ ( 'SEF_SETTINGS' ), 'sef' );
	echo '<br /><fieldset><legend>' . JText::_ ( 'URL' ) . '</legend>' . $this->params->render ( 'params', 'SEF_SETTINGS_URL' ) . '</fieldset>';
	echo '<fieldset><legend>' . JText::_ ( 'META_TAGS' ) . '</legend>' . $this->params->render ( 'params', 'SEF_SETTINGS_META_TAGS' ) . '</fieldset>';
	echo $pane->endPanel ();
	echo $pane->startPanel ( JText::_ ( 'THIRD_PARTY_SETTINGS' ), 'third-party' );
	echo '<br /><fieldset><legend>' . JText::_ ( 'COMMUNITY_BUILDER' ) . '</legend>';
	echo $this->params->render ( 'params', 'THIRD_PARTY_SETTINGS_CB' );
	echo '</fieldset><fieldset><legend>' . Jtext::_ ( 'COMMENT_SYSTEM' ) . '</legend>';
	echo $this->params->render ( 'params', 'THIRD_PARTY_SETTINGS_COMMENT_SYSTEM' );
	echo '</fieldset>';
	echo $pane->endPanel ();
	echo $pane->startPanel ( JText::_ ( 'UPLOAD_SETTINGS' ), 'uploads' );
	echo '<fieldset><legend>' . Jtext::_ ( 'UPLOADS' ) . '</legend>';
	echo $this->params->render ( 'params', 'UPLOAD_SETTINGS' );
	?>
	<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'ALLOWED_RESOLUTIONS_SETTINGS_DESC' );
			?>"><?php
			echo JText::_ ( 'ALLOWED_RESOLUTIONS_SETTINGS' );
			?></label></span></td>
		<td class="paramlist_value">
		<div id="allowedResolutions"><?php
		JWallpapersHelperLayout::getAllowedResolutionsLayout ( $this->allowedResolutions );
		?></div>
		</td>
	</tr>
</table>
	<?php
	echo '</fieldset><fieldset><legend>' . JText::_ ( 'DOWNLOADS' ) . '</legend>';
	echo $this->params->render ( 'params', 'DOWNLOADS_SETTINGS' ) . '</fieldset>';
	echo '<fieldset><legend>' . JText::_ ( 'WATERMARKS' ) . '</legend>';
	echo $this->params->render ( 'params', 'WATERMARKS_SETTINGS' );
	?>
	<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'DELETE_WATER_ORGS_DESC' );
			?>"><?php
			echo JText::_ ( 'DELETE_WATER_ORGS' );
			?></label></span></td>
		<td class="paramlist_value">
			<?php
			echo $this->ajax_delete_water_orgs_link;
			?>
			<span id="delete_water_orgs_status"></span></td>
	</tr>
</table>
<?php
echo '</fieldset>';
echo $pane->endPanel ();
echo $pane->startPanel ( JText::_ ( 'RESIZING_SETTINGS' ), 'resizes' );
?>
	<br />
<span class="red_msg"><?php
echo JText::_ ( 'RESIZES_SETTING_CHANGE_NOTE' );
?></span> <br />
<br />
<fieldset><legend><?php
echo JText::_ ( 'THUMBNAILS' );
?></legend>
	<?php
	echo $this->params->render ( 'params', 'THUMBNAILS_SETTINGS' );
	?>
		<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'REGENERATE_THUMBS_DESC' );
			?>"><?php
			echo JText::_ ( 'REGENERATE_THUMBS' );
			?></label></span></td>
		<td class="paramlist_value">
			<?php
			echo $this->ajax_regenerate_thumbs_link;
			?>
	<span id="regenerate_thumbs_status"></span></td>
	</tr>
</table>
</fieldset>
<fieldset><legend><?php
echo JText::_ ( 'RESIZES' );
?></legend>
	<?php
	echo $this->params->render ( 'params', 'RESIZES_SETTINGS' );
	?>
	<table width="100%" class="paramlist admintable" cellspacing="1">
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'AVAILABLE_RESIZES_SETTINGS_DESC' );
			?>"><?php
			echo JText::_ ( 'AVAILABLE_RESIZES_SETTINGS' );
			?></label></span></td>
		<td class="paramlist_value">
		<div id="availableResizes"><?php
		JWallpapersHelperLayout::getResizeListLayout ( $this->global_resizes );
		?></div>
		</td>
	</tr>
	<tr>
		<td width="40%" class="paramlist_key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'REGENERATE_RESIZES_DESC' );
			?>"><?php
			echo JText::_ ( 'REGENERATE_RESIZES' );
			?></label></span></td>
		<td class="paramlist_value">
			<?php
			echo $this->ajax_regenerate_resizes_link;
			?>
		<span id="regenerate_resizes_status"></span></td>
	</tr>
</table>
</fieldset>
	<?php
	echo $pane->endPanel ();
	echo $pane->startPanel ( JText::_ ( 'TAGS' ), 'tags' );
	?>
	<fieldset><legend><?php
	echo JText::_ ( 'TAGS' );
	?></legend>
<?php
echo $this->params->render ( 'params', 'TAGS' );
?>
</fieldset>
<?php
echo $pane->endPanel ();
echo $pane->endPane ();
?>
<input type="hidden" name="option" value="<?php
echo $option;
?>" /><input type="hidden" name="controller" value="settings" /> <input
	type="hidden" name="task" value="" />
  <?php
		echo JHTML::_ ( 'form.token' );
		?>
</form>