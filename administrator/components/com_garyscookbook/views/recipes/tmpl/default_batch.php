<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>
<fieldset class="batch">
	<legend><?php echo JText::_('COM_GARYSCOOKBOOK_BATCH_OPTIONS');?></legend>
	<p><?php echo JText::_('COM_GARYSCOOKBOOK_BATCH_TIP'); ?></p>
	<?php echo JHtml::_('batch.access');?>
	<?php echo JHtml::_('batch.language'); ?>
	<?php echo JHtml::_('batch.user'); ?>

	<?php if ($published >= 0) : ?>
		<?php echo JHtml::_('batch.item', 'com_garyscookbook');?>
	<?php endif; ?>

	<button type="submit" onclick="Joomla.submitbutton('recipe.batch');">
		<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
	</button>
	<button type="button" onclick="document.id('batch-category-id').value='';document.id('batch-access').value='';document.id('batch-language-id').value='';document.id('batch-user-id').value=''">
		<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
	</button>
</fieldset>
