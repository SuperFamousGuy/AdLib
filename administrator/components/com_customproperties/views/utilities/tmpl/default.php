<?php
/**
* Custom Properties for Joomla! 1.5.x
* @package Custom Properties
* @subpackage Component
* version 1.98.3.4
* @revision $Revision: 1.3 $
* @author Andrea Forghieri
* @copyright (C) 2007-2011 Andrea Forghieri, Solidsystem - http://www.solidsystem.it
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL version 2
*/

defined('_JEXEC') or die('Restricted access');

global $option;

$link = "index2.php?option=$option&controller=utilities";

JToolBarHelper::title( JText::_( 'Custom Properties Utilities & Manteinance' ), 'systeminfo.png' );
?>

	<table class="adminform" style="width : 75%;">
	<tr>
		<td style="width: 100px">
			<a href="<?php echo $link."&task=checkdirs";?>"><?php echo JText::_('Check directories');?></a>
		</td>
		<td>
			<p><?php echo JText::_('CHECK_DIRS_DESC');?>.</p>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $link."&task=showce";?>"><?php echo JText::_('Manage content elements');?></a>
		</td>
		<td>
			<p><?php echo JText::_('MANAGE_CE_DESC');?>.</p>
		</td>
	</tr>
	<tr>
		<td style="width: 100px">
			<a href="<?php echo $link."&task=instjf";?>"><?php echo JText::_('Install JoomFish content elements');?>.</a>
		</td>
		<td>
			<p><?php echo JText::_('INSTALL_JF_CE_DESC');?></p>
		</td>
	</tr>
	<tr>
		<td style="width: 100px">
			<a href="<?php echo $link."&task=refreshthumbnails";?>"><?php echo JText::_('Refresh thumbnails');?></a>
		</td>
		<td>
			<p><?php echo JText::_('REFRESH_THUMBS_DESC');?>.</p>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $link."&task=removecptags";?>"><?php echo JText::_('Remove cptags');?></a>
			</td>
			<td>
				<p><?php echo JText::_('REMOVE_CPTAGS_DESC');?>.</p>
			</td>
		</tr>
	</table>