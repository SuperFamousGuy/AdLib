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

JToolBarHelper::title ( JText::_ ( 'TAGS' ), 'jwallpapers_tags' );

JToolBarHelper::addNew ();
JToolBarHelper::custom ( 'manageTaggedPics', 'jwallpapers_manage_tagged_pics', 'jwallpapers_manage_tagged_pics_over', JText::_ ( 'MANAGE_TAGGED_PICS' ), false, false );
JToolBarHelper::editList ();
JToolBarHelper::deleteList ( JText::_ ( 'DELETE_TAG_CONFIRM' ), 'delete', JText::_ ( 'DELETE' ) ); 
JToolBarHelper::publishList ();
JToolBarHelper::unpublishList ();

$js = 'window
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
		echo JText::_ ( 'FILTER' ) . ' ' . JText::_ ( 'TAGS_TITLE_DRIVEN' );
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
			echo JText::_ ( 'PROPOSED_BY' );
			?></th>
			<th width="10%"><?php
			echo JHTML::_ ( 'grid.sort', 'DATE', 'date', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="10%"><?php
			echo JHTML::_ ( 'grid.sort', 'HITS', 'hits', $this->lists ['order_Dir'], $this->lists ['order'] );
			?></th>
			<th width="5%" nowrap="nowrap"><?php
			echo JText::_ ( 'PUBLISHED' );
			?></th>
			<th width="5%"><?php
			echo JText::_ ( 'ID' );
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
					$link = JFilterOutput::ampReplace ( 'index.php?option=' . $option . '&controller=tags&task=edit&cid[]=' . $row->id );
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

		<td align="center">
      <?php
					echo $row->user;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->date;
					?>
    </td>
		<td align="center">
      <?php
					echo $row->hits;
					?>
    </td>
		<td align="center">
      <?php
					echo $published?>
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
			<td colspan="7"><?php
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
?>" /> <input type="hidden" name="task" value="" /><input type="hidden"
	name="controller" value="tags" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="filter_order"
	value="<?php
	echo $this->lists ['order'];
	?>" /> <input type="hidden" name="filter_order_Dir" value="" /></form>