<?php 

//VideoFlow - Joomla Multimedia System for Facebook//

/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access'); 
global $vparams;
$Itemid = JRequest::getInt('Itemid', $vparams->flowid);
$lo = JRequest::getCmd('layout', 'listview');
$c = JRequest::getCmd('c');
if ($c == 'fb') {
$target = 'target="_parent"';
$action = $vparams->canvasurl.'&task=search&vs=1';
} else {
  $target = '';
  $action = JRoute::_('index.php');
}
echo '<div id="vfsearch">';
echo '<form id="searchForm" action="'.$action.'" '.$target.' method="get" name="searchForm">';
if ($c != 'fb') {
  ?>
  <input type="hidden" name="option" value="com_videoflow" />
  <input type="hidden" name="task" value="search" />
  <input type="hidden" name="vs" value="1" />
  <input type="hidden" name="layout" value="<?php echo $lo; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
  <?php
}
?>
	    <table class="contentpaneopen">
		<tr>
		    <td nowrap="nowrap">
			<label for="search_searchword">
			  <?php echo JText::_( 'Search Keyword' ); ?>:
			</label>
		    </td>
		    <td nowrap="nowrap">
			<input type="text" name="searchword" id="search_searchword" size="50" maxlength="20" value="" class="inputbox" style="margin:10px" />
		    </td>
		    <td width="100%" nowrap="nowrap">
			<button name="sbtn" onclick="this.form.submit()" class="button"><?php echo JText::_( 'Search' );?></button>
		    </td>
	</tr>
    </table>
 </form>
</div>