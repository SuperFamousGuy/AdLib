<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 358 2010-06-02 09:38:51Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

if ($this->task == 'edit') {
	JToolBarHelper::title ( JText::_ ( 'EDIT_TAG' ), 'jwallpapers_edit_tag' );
	JToolBarHelper::save ();
	JToolBarHelper::apply ();
	JToolBarHelper::custom ( 'manageTaggedPics', 'jwallpapers_manage_tagged_pics', 'jwallpapers_manage_tagged_pics_over', JText::_ ( 'MANAGE_TAGGED_PICS' ), false, false );
	JToolBarHelper::cancel ();
} elseif ($this->task == 'add') {
	JToolBarHelper::title ( JText::_ ( 'ADD_TAG' ), 'jwallpapers_add_tag' );
	JToolBarHelper::save ();
	JToolBarHelper::cancel ();
}

$document = & JFactory::getDocument ();

$js = 'function submitbutton(pressbutton) {
	if (pressbutton == \'save\' || pressbutton == \'apply\') {
		if (document.adminForm.title.value == \'\') {
			alert("' . JText::_ ( 'MISSING_TAG_TITLE' ) . '");
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
		echo JText::_ ( 'PUBLISHED' );
		?>:</td>
		<td>
	  <?php
			echo $this->published;
			?>
	</td>
	</tr>

</table>
</fieldset>
<input type="hidden" name="user_id"
	value="<?php
	echo $this->row->user_id;
	?>" /> <input type="hidden" name="date"
	value="<?php
	echo $this->row->date;
	?>" /> <input type="hidden" name="id"
	value="<?php
	echo $this->row->id;
	?>" /> <input type="hidden" name="option"
	value="<?php
	echo $option;
	?>" /> <input type="hidden" name="controller" value="tags" /> <input
	type="hidden" name="task" value="" />
  <?php
		echo JHTML::_ ( 'form.token' );
		?>
</form>
