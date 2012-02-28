<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 354 2010-06-01 10:56:49Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

JHTML::_ ( 'behavior.calendar' );

JHTML::_ ( 'behavior.tooltip' );


$task = JRequest::getVar ( 'task', 'add' );

if ($task == 'edit') {
	JToolBarHelper::title ( JText::_ ( 'EDIT_CATEGORY' ), 'jwallpapers_categories' );
	JToolBarHelper::save ();
	JToolBarHelper::apply ();
	JToolBarHelper::cancel ();
} elseif ($task == 'add') {
	JToolBarHelper::title ( JText::_ ( 'ADD_CATEGORY' ), 'jwallpapers_categories' );
	JToolBarHelper::save ();
	JToolBarHelper::apply ();
	JToolBarHelper::cancel ();
}

$document = & JFactory::getDocument ();

$js = 'var jwallpapers_option = "' . $option . '";
var jwallpapers_adminStepDown="";
var jwallpapers_notIntegerWidth = "' . JText::_ ( 'NOT_INTEGER_WIDTH' ) . '";
var jwallpapers_notIntegerHeight = "' . JText::_ ( 'NOT_INTEGER_HEIGHT' ) . '";
var jwallpapers_deleteConfirm = "' . JText::_ ( 'DELETE_CONFIRMATION' ) . '";

function submitbutton(pressbutton) {
	if (pressbutton == \'save\' || pressbutton == \'apply\') {
		if (document.adminForm.title.value == \'\') {
			alert("' . JText::_ ( 'MISSING_CAT_NAME' ) . '");
		} else {
			submitform(pressbutton);
		}
	} else {
		submitform(pressbutton);
	}
}

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
$document->addScript ( 'components/' . $option . '/js/commonForm.js' );
$document->addScript ( 'components/' . $option . '/js/common.js' );
$document->addScript ( 'components/' . $option . '/js/availableResizes.js' );

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
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
		echo JText::_ ( 'PARENT' );
		?>:</td>
		<td>
		<div id="ajax_category">
	    <?php
					JWallpapersHelperLayout::getParentSelectLayout ( $this->catList, $this->catPath, $this->row->id );
					?>
	  </div>
	  <?php
			$document->addScript ( 'components/' . $option . '/js/ajaxCatParentSelect.js' );
			?>
	
	
	
	
	
	
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
	if ($task == 'edit') {
		?>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
		echo JText::_ ( 'AVAILABLE_RESIZES_CATEGORY_DESC' );
		?>"><?php
		echo JText::_ ( 'AVAILABLE_RESIZES_CATEGORY' );
		?></label></span></td>
		<td>
		<div id="availableResizes"><?php
		echo JWallpapersHelperLayout::getResizeListLayout ( $this->category_resizes );
		?></div>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td width="100" align="right" class="key"><?php
		echo JText::_ ( 'PICTURE' ) . ' ID (' . JText::_ ( 'THUMBNAIL' ) . ')';
		?>:</td>
		<td><input type="text" name="file_id"
			value=" <?php
			echo $this->row->file_id;
			?>" /></td>
	</tr>
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
		echo JText::_ ( 'FRONTEND_UPLOADS_ENABLED' );
		?>:</td>
		<td>
	    <?php
					echo $this->frontend_uploads_en;
					?>
	  </td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'DEFAULT_DOWNLOADABLE_FRONT_PICS_STATUS_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'DEFAULT_DOWNLOADABLE_FRONT_PICS_STATUS' );
			;
			?></label></span></td>
		<td>
	    <?php
					echo $this->def_downloadable_front_pics_stat;
					?>
	  </td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'CATEGORY_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'CATEGORY_DENY_ACL' );
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
			echo JText::_ ( 'CATEGORY_VOTES_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'CATEGORY_VOTES_DENY_ACL' );
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
			echo JText::_ ( 'CATEGORY_DOWNLOADS_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'CATEGORY_DOWNLOADS_DENY_ACL' );
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
			echo JText::_ ( 'CATEGORY_UPLOADS_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'CATEGORY_UPLOADS_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'uploads_deny_acl', $this->row->uploads_deny_acl );
			?>
	</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span class="editlinktip"><label
			class="hasTip"
			title="<?php
			echo JText::_ ( 'CATEGORY_TAGGING_DENY_ACL_DESC' );
			;
			?>"><?php
			echo JText::_ ( 'CATEGORY_TAGGING_DENY_ACL' );
			;
			?></label></span></td>
		<td>
	  <?php
			echo JWallpapersHelperLayout::getGroupList ( 'tagging_deny_acl', $this->row->tagging_deny_acl );
			?>
	</td>
	</tr>
</table>
</fieldset>
    <?php
				echo JHTML::_ ( 'form.token' );
				?>
    <input type="hidden" name="id"
	value="<?php
	echo $this->row->id;
	?>" /> <input type="hidden" name="option"
	value="<?php
	echo $option;
	?>" /> <input type="hidden" name="controller" value="categories" /> <input
	type="hidden" name="task" value="" /></form>
