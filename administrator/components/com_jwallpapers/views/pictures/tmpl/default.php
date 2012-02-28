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

JToolBarHelper::title ( JText::_ ( 'PICTURES' ), 'jwallpapers_pictures' );

JToolBarHelper::addNew ();
JToolBarHelper::editList ();
JToolBarHelper::deleteList ( JText::_ ( 'DELETE_PIC_CONFIRM' ) ); 
JToolBarHelper::custom ( 'enableVotes', 'jwallpapers_enable_votes', 'jwallpapers_enable_votes_over', JText::_ ( 'ENABLE_VOTES' ), true, false );
JToolBarHelper::custom ( 'disableVotes', 'jwallpapers_disable_votes', 'jwallpapers_disable_votes_over', JText::_ ( 'DISABLE_VOTES' ), true, false );
JToolBarHelper::custom ( 'enableDownloads', 'jwallpapers_enable_downloads', 'jwallpapers_enable_downloads_over', JText::_ ( 'ENABLE_DOWNLOADS' ), true, false );
JToolBarHelper::custom ( 'disableDownloads', 'jwallpapers_disable_downloads', 'jwallpapers_disable_downloads_over', JText::_ ( 'DISABLE_DOWNLOADS' ), true, false );
JToolBarHelper::custom ( 'ratingsReset', 'jwallpapers_ratings_reset', 'jwallpapers_ratings_reset_over', JText::_ ( 'RATINGS_RESET' ), true, false );
JToolBarHelper::publishList ();
JToolBarHelper::unpublishList ();
JToolBarHelper::custom ( 'allRatingsReset', 'jwallpapers_all_ratings_reset', 'jwallpapers_all_ratings_reset_over', JText::_ ( 'ALL_RATINGS_RESET' ), false, false );

$js = 'function submitbutton(pressbutton) {

	var jwallpapers_ratingsResetWarn = "' . JText::_ ( 'RATINGS_RESET_WARNING' ) . '";

	if (pressbutton == \'allRatingsReset\' || pressbutton == \'ratingsReset\') {
		
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
		echo $this->lists ['catid'];
		echo $this->lists ['state'];
		echo $this->lists ['filter_by_state_pics'];
		echo $this->lists ['filter_tag'];
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
			<th width="15%"><?php
			echo JText::_ ( 'FILE_NAME' );
			?></th>
			<th width="10%"><?php
			echo JText::_ ( 'UPLOADED_BY' );
			?></th>
			<th width="10%"><?php
			echo JHTML::_ ( 'grid.sort', 'DATE', 'upload_date', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="7%"><?php
			echo JText::_ ( 'RESOLUTION' );
			?></th>
			<th width="7%"><?php
			echo JHTML::_ ( 'grid.sort', 'VOTES', 'count', $this->lists ['order_Dir'], $this->lists ['order'] );
			
			?></th>
			<th width="7%"><?php
			echo JHTML::_ ( 'grid.sort', 'RATING', 'average', $this->lists ['order_Dir'], $this->lists ['order'] );
			
			?></th>
			<th width="7%"><?php
			echo JHTML::_ ( 'grid.sort', 'HITS', 'hits', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="7%"><?php
			echo JHTML::_ ( 'grid.sort', 'DOWNLOADS', 'downloads', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="7%" nowrap="nowrap"><?php
			echo JText::_ ( 'CATEGORY' );
			?></th>
			<th width="5%"><?php
			echo JText::_ ( 'CAT_PUBLISHED' );
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
					$link = JFilterOutput::ampReplace ( 'index.php?option=' . $option . '&controller=pictures&task=edit&cid[]=' . $row->id );
					?>
    <tr class="<?php
					echo 'row' . $k;
					?>">
		<td>
      <?php
					echo $checked;
					?>
    </td>
		<td><a href="<?php
					echo $link;
					?>"><?php
					echo $row->title;
					?></a></td>

		<td>
      <?php
					echo $row->file_name . '.' . $row->file_ext;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->uploadedBy;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->upload_date;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->width . 'x' . $row->height;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->count;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->average;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->hits;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->downloads;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->catLink;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->isCatPublished;
					?>
    </td>
		<td align="center">
      <?php
					echo $published;
					?>
    </td>
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
		<tr>
			<td colspan="14"><?php
			echo $this->pagination->getListFooter ();
			?></td>
		</tr>
	</tfoot>
</table>
<?php
echo JHTML::_ ( 'form.token' );
?>
<input type="hidden" name="option" value="<?php
echo $option;
?>" /> <input type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="filter_order"
	value="<?php
	echo $this->lists ['order'];
	?>" /> <input type="hidden" name="filter_order_Dir" value="" /></form>