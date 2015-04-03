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
<div class="modal hide fade" id="collapseModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3><?php echo JText::_('COM_GARYSCOOKBOOK_BATCH_OPTIONS');?></h3>
	</div>
	<div class="modal-body">
		<p><?php echo JText::_('COM_GARYSCOOKBOOK_BATCH_TIP'); ?></p>
			<div class="control-group">
			<div class="controls">
	<?php echo JHtml::_('batch.access');?>
				</div>
		</div>
		<div class="control-group">
			<div class="controls">
	<?php echo JHtml::_('batch.language'); ?>
				</div>
		</div>
		<div class="control-group">
			<div class="controls">
	<?php echo JHtml::_('batch.user'); ?>
		</div>
		</div>
	<?php if ($published >= 0) : ?>
			<div class="control-group">
			<div class="controls">
		<?php echo JHtml::_('batch.item', 'com_garyscookbook');?>
			</div>
		</div>
	<?php endif; ?>
	</div>
	<div class="modal-footer">
	<button type="submit" onclick="Joomla.submitbutton('recipe.batch');">
		<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
	</button>
	<button type="button" onclick="document.id('batch-category-id').value='';document.id('batch-access').value='';document.id('batch-language-id').value='';document.id('batch-user-id').value=''">
		<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
	</button>
	</div>
</div>
