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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
require_once(JPATH_ADMINISTRATOR . "/components/com_garyscookbook/helpers/ingredients.php");
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'components/com_garyscookbook/assets/css/gkb.css');
$document->addscript (JURI::root() . 'components/com_garyscookbook/assets/js/product_attributes.js');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'recipe.cancel' || document.formvalidator.isValid(document.id('recipe-form'))) {
			<?php if ($this->params->get('show_imgtext')) {?>
				<?php echo $this->form->getField('imgtext')->save(); ?>
			<?php } ?>
			Joomla.submitform(task, document.getElementById('recipe-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_garyscookbook&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="recipe-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_GARYSCOOKBOOK_NEW_RECIPE') : JText::sprintf('COM_GARYSCOOKBOOK_EDIT_RECIPE', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('imgtitle'); ?>
				<?php echo $this->form->getInput('imgtitle'); ?></li>

				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>

				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid') ; ?><input type="text" name="catid" id="catid" value="<?php echo $this->item->catid;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li><?php echo $this->form->getLabel('catid2'); ?>
				<?php echo $this->form->getInput('catid2'); ?><input type="text" name="catid2" id="catid2" value="<?php echo $this->item->catid2;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li><?php echo $this->form->getLabel('catid3'); ?>
				<?php echo $this->form->getInput('catid3'); ?><input type="text" name="catid3" id="catid3" value="<?php echo $this->item->catid3;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li><?php echo $this->form->getLabel('catid4'); ?>
				<?php echo $this->form->getInput('catid4'); ?><input type="text" name="catid4" id="catid4" value="<?php echo $this->item->catid4;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li><?php echo $this->form->getLabel('catid5'); ?>
				<?php echo $this->form->getInput('catid5'); ?><input type="text" name="catid5" id="catid5" value="<?php echo $this->item->catid5;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li><?php echo $this->form->getLabel('imgfilename'); ?>
				<?php echo $this->form->getInput('imgfilename'); ?></li>


				<li><?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?></li>

				<li><?php echo $this->form->getLabel('access'); ?>
				<?php echo $this->form->getInput('access'); ?></li>

				<li><?php echo $this->form->getLabel('ordering'); ?>
				<?php echo $this->form->getInput('ordering'); ?></li>

				<li><?php echo $this->form->getLabel('featured'); ?>
				<?php echo $this->form->getInput('featured'); ?></li>

				<li><?php echo $this->form->getLabel('language'); ?>
				<?php echo $this->form->getInput('language'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>

			</ul>
			<div class="clr"></div>
			<ul class="adminformlist">
				<li><label id="jform_id-lbl" for="jform_catid" class="hasTip" title="ID::Aufnahmenummer in der Datenbank">CATID</label>
					<input type="text" name="jform[id]" id="jform_id" value="<?php echo $this->item->catid;?>" class="readonly" size="10" readonly="readonly"/></li>

				<li></li>
			</ul>
			<?php if ($this->params->get('show_imgtext')) {?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('imgtext'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('imgtext'); ?>

			<?php } ?>
			<?php if ($this->params->get('show_ingredients')) {?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('ingredients'); ?>
				<div class="clr"></div>
				<?php loadAttributeExtension($this->item->ingredients) ?>
			<?php } ?>
			<?php if ($this->params->get('show_grapes')) {?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('grapes'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('grapes'); ?>
			<?php } ?>
			<?php if ($this->params->get('show_properties')) {?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('properties'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('properties'); ?>
			<?php } ?>
			<?php if ($this->params->get('show_notes')) {?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('notes'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('notes'); ?>
			<?php } ?>




		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<?php echo  JHtml::_('sliders.start', 'recipe-slider'); ?>
			<?php echo JHtml::_('sliders.panel', JText::_('COM_GARYSCOOKBOOK_RECIPE_DETAILS'), 'basic-options'); ?>

			<fieldset class="panelform">
				<p><?php echo empty($this->item->id) ? JText::_('COM_GARYSCOOKBOOK_DETAILS') : JText::sprintf('COM_GARYSCOOKBOOK_EDIT_DETAILS', $this->item->id); ?></p>

				<ul class="adminformlist">
					<?php if ($this->params->get('show_country')) {?>
						<li><?php echo $this->form->getLabel('country'); ?>
						<?php echo $this->form->getInput('country'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_portion')) {?>
						<li><?php echo $this->form->getLabel('portion'); ?>
						<?php echo $this->form->getInput('portion'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_amount')) {?>
						<li><?php echo $this->form->getLabel('amount'); ?>
						<?php echo $this->form->getInput('amount'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_aging')) {?>
						<li><?php echo $this->form->getLabel('aging'); ?>
						<?php echo $this->form->getInput('aging'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_years')) {?>
						<li><?php echo $this->form->getLabel('years'); ?>
						<?php echo $this->form->getInput('years'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_price')) {?>
						<li><?php echo $this->form->getLabel('price'); ?>
						<?php echo $this->form->getInput('price'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_doc')) {?>
						<li><?php echo $this->form->getLabel('doc'); ?>
						<?php echo $this->form->getInput('doc'); ?></li>
					<?php } ?>
					<?php if ($this->params->get('show_vegan')) {?>
						<li><?php echo $this->form->getLabel('vegan'); ?>
						<?php echo $this->form->getInput('vegan'); ?></li>
					<?php } ?>
					<?php if ($this->params->get('show_gluten')) {?>
						<li><?php echo $this->form->getLabel('gluten'); ?>
						<?php echo $this->form->getInput('gluten'); ?></li>
					<?php } ?>
					<?php if ($this->params->get('show_laktose')) {?>
						<li><?php echo $this->form->getLabel('laktose'); ?>
						<?php echo $this->form->getInput('laktose'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_diaet')) {?>
						<li><?php echo $this->form->getLabel('diaet'); ?>
						<?php echo $this->form->getInput('diaet'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_kcal')) {?>
						<li><?php echo $this->form->getLabel('kcal'); ?>
						<?php echo $this->form->getInput('kcal'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_kjoule')) {?>
						<li><?php echo $this->form->getLabel('kjoule'); ?>
						<?php echo $this->form->getInput('kjoule'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_fat')) {?>
						<li><?php echo $this->form->getLabel('fat'); ?>
						<?php echo $this->form->getInput('fat'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_breadunit')) {?>
						<li><?php echo $this->form->getLabel('breadunit'); ?>
						<?php echo $this->form->getInput('breadunit'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_protein')) {?>
						<li><?php echo $this->form->getLabel('protein'); ?>
						<?php echo $this->form->getInput('protein'); ?></li>
					<?php } ?>

					<?php if ($this->params->get('show_carbohydrates')) {?>
						<li><?php echo $this->form->getLabel('carbohydrates'); ?>
						<?php echo $this->form->getInput('carbohydrates'); ?></li>
					<?php } ?>



				</ul>
			</fieldset>

			<?php echo JHtml::_('sliders.panel', JText::_('COM_GARYSCOOKBOOK_FIELDSET_PICTURES'), 'pictures-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<?php if ($this->params->get('show_expic')) {?>
						<li><?php echo $this->form->getLabel('expic1'); ?>
						<?php echo $this->form->getInput('expic1'); ?></li>
						<li><?php echo $this->form->getLabel('expic2'); ?>
						<?php echo $this->form->getInput('expic2'); ?></li>
						<li><?php echo $this->form->getLabel('expic3'); ?>
						<?php echo $this->form->getInput('expic3'); ?></li>
						<li><?php echo $this->form->getLabel('expic4'); ?>
						<?php echo $this->form->getInput('expic4'); ?></li>

					<?php } ?>
				</ul>
			</fieldset>
			<?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">

					<li><?php echo $this->form->getLabel('created_by'); ?>
					<?php echo $this->form->getInput('created_by'); ?></li>
					<?php if ($this->params->get('show_created_by_alias')) {?>
						<li><?php echo $this->form->getLabel('created_by_alias'); ?>
						<?php echo $this->form->getInput('created_by_alias'); ?></li>
					<?php } ?>
					<li><?php echo $this->form->getLabel('created'); ?>
					<?php echo $this->form->getInput('created'); ?></li>

					<li><?php echo $this->form->getLabel('publish_up'); ?>
					<?php echo $this->form->getInput('publish_up'); ?></li>

					<li><?php echo $this->form->getLabel('publish_down'); ?>
					<?php echo $this->form->getInput('publish_down'); ?></li>

					<?php if ($this->item->modified_by) : ?>
						<li><?php echo $this->form->getLabel('modified_by'); ?>
						<?php echo $this->form->getInput('modified_by'); ?></li>

						<li><?php echo $this->form->getLabel('modified'); ?>
						<?php echo $this->form->getInput('modified'); ?></li>
					<?php endif; ?>

						<li><?php echo $this->form->getLabel('imgcounter'); ?>
						<?php echo $this->form->getInput('imgcounter'); ?></li>
					<?php if ($this->params->get('show_created_by_alias')) {?>
						<li><label><?php echo JTEXT::_('COM_GARYSCOOKBOOK_FIELD_VOTING_LABEL')?>
						</label>
						<?php
						if ($this->item->imgvotes > 0) {
							$qs = round($this->item->imgvotesum / $this->item->imgvotes,2);
						} else {
							$qs = JTEXT::_('COM_GARYSCOOKBOOK_FIELD_NOVOTES');
						} ?>
						<input type="text" name="jform[imgvote]" id="jform_imgvote" value="<?php echo $qs ?>" class="readonly" size="22" readonly="readonly"/>
						</li>
					<?php } ?>
				</ul>
			</fieldset>



			<?php echo $this->loadTemplate('params'); ?>

			<?php echo $this->loadTemplate('metadata'); ?>
		<?php echo JHtml::_('sliders.end'); ?>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="clr"></div>
