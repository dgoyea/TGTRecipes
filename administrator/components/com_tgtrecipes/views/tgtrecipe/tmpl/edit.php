<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<form action="<?php echo JRoute::_('index.php?option=com_tgtrecipes&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">

	<fieldset>
		<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>

			<?php echo JHtml::_('bootstrap.addPanel', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_TGTRECIPES_NEW_TGTRECIPE', true) : JText::sprintf('COM_TGTRECIPES_EDIT_TGTRECIPE', $this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('ingredients'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('ingredients'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('directions'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('directions'); ?></div>
				</div>						
			<?php echo JHtml::_('bootstrap.endPanel'); ?>

			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>

		<?php echo JHtml::_('bootstrap.endPane'); ?>
		</fieldset>
		</div>
	</div>
</form>