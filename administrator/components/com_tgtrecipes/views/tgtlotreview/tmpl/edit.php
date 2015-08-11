<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

?>

<?php 
JHtml::_('bootstrap.framework');
?>


<form action="<?php echo JRoute::_('index.php?option=com_tgtrecipes&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">

	<fieldset>
		<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>

			<?php echo JHtml::_('bootstrap.addPanel', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_TGTRECIPES_NEW_TGTLOTREVIEW', true) : JText::sprintf('COM_TGTRECIPES_EDIT_TGTLOTREVIEW', $this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('venuename'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('venuename'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('lotname'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('lotname'); ?></div>
				</div>					
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('eventname'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('eventname'); ?></div>
				</div>
				<div class="hidden-group">
					<div class="controls"><?php echo $this->form->getInput('venueid'); ?></div>
				</div>
			<?php echo JHtml::_('bootstrap.endPanel'); ?>
						
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>

		<?php echo JHtml::_('bootstrap.endPane'); ?>
		</fieldset>
		</div>
	</div>
</form>