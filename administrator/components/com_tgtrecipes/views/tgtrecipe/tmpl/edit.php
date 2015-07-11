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
JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$document = JFactory::getDocument();
$document->addScript(JUri::root().'media/com_tgtrecipes/js/recipeform.js', 'text/javascript');
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
					<div class="control-label"><?php echo $this->form->getLabel('directions'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('directions'); ?></div>
				</div>	
				
				<!-- Dynamic fields -->
				
				<?php 
				echo "<table style=\"width:30%\" class=\"table table-hover\">";
				echo "<th>#</th>";
				echo "<th>Quantity</th>";
				echo "<th>Measurement</th>";
				echo "<th>Ingredient</th>";				
				
				
				for ($x = 1; $x < 26; $x++) {
					$ingr = "ingredient" . $x;
					$ingrqty = "ingrqty". $x;
					$ingrqtytype = "ingrqtytype". $x;
					
					echo "<tr>";
					echo "<th scope=\"row\">$x</th>";
					echo "<td>";
					echo $this->form->getInput($ingrqty);
					echo "</td>";
					echo "<td>";
					echo $this->form->getInput($ingrqtytype);
					echo "</td>";
					echo "<td>";
					echo $this->form->getInput($ingr);
					echo "</td>";					
					echo "</tr>";
		

				}
				echo "</table>";		
				?>
	
													
			<?php echo JHtml::_('bootstrap.endPanel'); ?>
						
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>

		<?php echo JHtml::_('bootstrap.endPane'); ?>
		</fieldset>
		</div>
	</div>
</form>