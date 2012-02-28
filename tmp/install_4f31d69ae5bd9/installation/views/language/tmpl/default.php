<?php
/**
 * @package		Joomla.Installation
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div id="step">
	<div class="far-right">
	<?php if ($this->document->direction == 'ltr') : ?>
		<div class="button1-left"><div class="next"><a href="#" onclick="Install.submitform();" rel="next" title="<?php echo JText::_('JNext'); ?>"><?php echo JText::_('JNext'); ?></a></div></div>
	<?php elseif ($this->document->direction == 'rtl') : ?>
		<div class="button1-right"><div class="prev"><a href="#" onclick="Install.submitform();" rel="next" title="<?php echo JText::_('JNext'); ?>"><?php echo JText::_('JNext'); ?></a></div></div>
	<?php endif; ?>
	</div>
	<h2><?php echo JText::_('INSTL_LANGUAGE_TITLE'); ?></h2>
</div>
<form action="index.php" method="post" id="adminForm" class="form-validate">
	<div id="installer">
		<div class="m">
			<h3><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></h3>
			<div class="install-text">
				<?php echo JText::_('INSTL_SELECT_LANGUAGE_DESC'); ?>
			</div>
			<div class="install-body">
				<div class="m">
				<div style="color:red; font-weight:bold">Some language installations can cause installation errors on certain servers. If you come across any error messages during installation please try keeping the language set to the default English US, you can install a language package from the following location after installation, <a target="blank" href="http://extensions.joomla.org/index.php?option=com_mtree&task=listcats&cat_id=1837&Itemid=2">Language Packs</a>
	</div>
					<fieldset>
						<?php echo $this->form->getInput('language'); ?>
					</fieldset>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<input type="hidden" name="task" value="setup.setlanguage" />
	<?php echo JHtml::_('form.token'); ?>
</form>
