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

JToolBarHelper::title ( JText::_ ( 'CATEGORIES' ), 'jwallpapers_categories' );
JToolBarHelper::addNew ();
JToolBarHelper::editList ();
JToolBarHelper::deleteList ( JText::_ ( 'DELETE_CAT_CONFIRM' ) ); 
JToolBarHelper::custom ( 'ratingsReset', 'jwallpapers_ratings_reset', 'jwallpapers_ratings_reset_over', JText::_ ( 'RATINGS_RESET' ), true, false );
JToolBarHelper::custom ( 'enableVotes', 'jwallpapers_enable_votes', 'jwallpapers_enable_votes_over', JText::_ ( 'ENABLE_VOTES' ), true, false );
JToolBarHelper::custom ( 'disableVotes', 'jwallpapers_disable_votes', 'jwallpapers_disable_votes_over', JText::_ ( 'DISABLE_VOTES' ), true, false );
JToolBarHelper::custom ( 'enableDownloads', 'jwallpapers_enable_downloads', 'jwallpapers_enable_downloads_over', JText::_ ( 'ENABLE_DOWNLOADS' ), true, false );
JToolBarHelper::custom ( 'disableDownloads', 'jwallpapers_disable_downloads', 'jwallpapers_disable_downloads_over', JText::_ ( 'DISABLE_DOWNLOADS' ), true, false );
JToolBarHelper::custom ( 'enableFrontendUploads', 'jwallpapers_enable_frontend_uploads', 'jwallpapers_enable_frontend_uploads_over', JText::_ ( 'ENABLE_FRONTEND_UPLOADS' ), true, false );
JToolBarHelper::custom ( 'disableFrontendUploads', 'jwallpapers_disable_frontend_uploads', 'jwallpapers_disable_frontend_uploads_over', JText::_ ( 'DISABLE_FRONTEND_UPLOADS' ), true, false );
JToolBarHelper::publishList ();
JToolBarHelper::unpublishList ();

$js = 'function submitbutton(pressbutton) {

	var jwallpapers_ratingsResetWarn = "' . JText::_ ( 'RATINGS_RESET_WARNING' ) . '";

	if (pressbutton == \'ratingsReset\') {
		
		if (confirm(jwallpapers_ratingsResetWarn)) {
			submitform(pressbutton);
		} else {
			return false;
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

$document = & JFactory::getDocument ();
$document->addScriptDeclaration ( $js );

?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%">
		<?php
		echo JText::_ ( 'FILTER' );
		?>:
<input type="text" name="filter_search" id="search"
			value="<?php
			echo $this->lists ['filter_search'];
			?>"
			class="text_area" onchange="document.adminForm.submit();" />

		<button onclick="this.form.submit();"><?php
		echo JText::_ ( 'GO' );
		?></button>
		<button
			onclick="document.adminForm.filter_search.value='';this.form.submit();">
		<?php
		echo JText::_ ( 'RESET' );
		?>
		</button>
		</td>
		<td nowrap="nowrap">
		<?php
		echo $this->lists ['state'];
		echo $this->lists ['filter_by_state_cats'];
		?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td nowrap="nowrap">
		<?php
		echo $this->lists ['filter_deny_access_to'];
		echo $this->lists ['filter_deny_votes_from'];
		echo $this->lists ['filter_deny_downloads_to'];
		echo $this->lists ['filter_deny_tagging_from'];
		echo $this->lists ['filter_deny_uploads_to'];
		?>
		</td>
	</tr>
</table>
<table class="adminlist">
	<thead>
		<tr>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php
				echo count ( $this->rows );
				?>);" /></th>
			<th class="title"><?php
			echo JHTML::_ ( 'grid.sort', 'TITLE', 'title', $this->lists ['order_Dir'], $this->lists ['order'] );
			
			?></th>
			<th width="35%"><?php
			echo JText::_ ( 'DESCRIPTION' );
			?></th>
			<th width="15%"><?php
			echo JText::_ ( 'PARENT' );
			?></th>
			<th width="7%"><?php
			echo JHTML::_ ( 'grid.sort', 'HITS', 'hits', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="5%" nowrap="nowrap"><?php
			echo JText::_ ( 'PUBLISHED' );
			?></th>
			<th><?php
			echo JHTML::_ ( 'grid.sort', 'ID', 'id', $this->lists ['order_Dir'], $this->lists ['order'] );
			
			?></th>

		</tr>
	</thead>
    <?php
				jimport ( 'joomla.filter.output' );
				$k = 0;
				for($i = 0, $n = count ( $this->rows ); $i < $n; $i ++) {
					$row = &$this->rows [$i];
					$checked = JHTML::_ ( 'grid.checkedout', $row, $i );
					$published = JHTML::_ ( 'grid.published', $row, $i );
					$link = JFilterOutput::ampReplace ( 'index.php?option=' . $option . '&task=edit&controller=categories&cid[]=' . $row->id );
					?>
    <tr class="<?php
					echo 'row' . $k;
					?>">
		<td><?php
					echo $checked;
					?></td>
		<td><a href="<?php
					echo $link;
					?>"><?php
					echo $row->title;
					?></a></td>
		<td>
					<?php
					echo $row->description;
					?>
					</td>
		<td align="center"><?php
					echo $row->parentTitle;
					?></td align="center">
		<td align="center"><?php
					echo $row->hits;
					?></td>
		<td align="center"> <?php
					echo $published;
					?></td>
		<td align="center">
					<?php
					echo $row->id;
					?>
					</td>
	</tr>
  <?php
					$k = 1 - $k;
				}
				?>
  <tfoot>
		<td colspan="7"><?php
		echo $this->pagination->getListFooter ();
		?></td>
	</tfoot>
</table>
<?php
echo JHTML::_ ( 'form.token' );
?>
<input type="hidden" name="option" value="<?php
echo $option;
?>" /> <input type="hidden" name="controller" value="categories" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /><input type="hidden" name="filter_order"
	value="<?php
	echo $this->lists ['order'];
	?>" /> <input type="hidden" name="filter_order_Dir" value="" /></form>
