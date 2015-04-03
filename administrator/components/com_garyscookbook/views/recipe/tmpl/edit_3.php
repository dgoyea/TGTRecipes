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
JHtml::_('formbehavior.chosen', 'select');

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
	<div class="row-fluid">



	<div class="span10 form-horizontal">
		<fieldset>
			<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_GARYSCOOKBOOK_NEW_RECIPE') : JText::sprintf('COM_GARYSCOOKBOOK_EDIT_RECIPE', $this->item->id); ?></a></li>
			<li><a href="#publishing" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING');?></a></li>
			<li><a href="#zpic" data-toggle="tab"><?php echo JText::_('COM_GARYSCOOKBOOK_FIELDSET_PICTURES');?></a></li>
			<li><a href="#picdetail" data-toggle="tab"><?php echo JText::_('COM_GARYSCOOKBOOK_DETAILS');?></a></li>
			<?php
				$fieldSets = $this->form->getFieldsets('params');
					foreach ($fieldSets as $name => $fieldSet) :
			?>
			<li><a href="#params-<?php echo $name;?>" data-toggle="tab"><?php echo JText::_($fieldSet->label);?></a></li>
			<?php endforeach; ?>
			<?php
				$fieldSets = $this->form->getFieldsets('metadata');
					foreach ($fieldSets as $name => $fieldSet) :
				?>
					<li><a href="#metadata-<?php echo $name;?>" data-toggle="tab"><?php echo JText::_($fieldSet->label);?></a></li>
					<?php endforeach; ?>
			</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<legend><?php echo empty($this->item->id) ? JText::_('COM_GARYSCOOKBOOK_NEW_RECIPE') : JText::sprintf('COM_GARYSCOOKBOOK_EDIT_RECIPE', $this->item->id); ?></legend>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('imgtitle'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('imgtitle'); ?></div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catid') ; ?> <?php echo $this->item->catid;?> </div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catid2'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catid2'); ?> <?php echo $this->item->catid2;?> </div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catid3'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catid3'); ?> <?php echo $this->item->catid3;?> </div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catid4'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catid4'); ?> <?php echo $this->item->catid4;?> </div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catid5'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catid5'); ?> <?php echo $this->item->catid5;?> </div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('imgfilename'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('imgfilename'); ?></div>
					</div>
								<?php if ($this->params->get('show_imgtext')) {?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getLabel('imgtext'); ?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getInput('imgtext'); ?>

			<?php } ?>
			<?php if ($this->params->get('show_ingredients')) {?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getLabel('ingredients'); ?>
				<div style="clear: both;"></div>
				<?php loadAttributeExtension($this->item->ingredients) ?>
			<?php } ?>
			<?php if ($this->params->get('show_grapes')) {?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getLabel('grapes'); ?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getInput('grapes'); ?>
			<?php } ?>
			<?php if ($this->params->get('show_properties')) {?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getLabel('properties'); ?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getInput('properties'); ?>
			<?php } ?>
			<?php if ($this->params->get('show_notes')) {?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getLabel('notes'); ?>
				<div style="clear: both;"></div>
				<?php echo $this->form->getInput('notes'); ?>
			<?php } ?>

			</div>
			<div class="tab-pane" id="zpic">
				<?php if ($this->params->get('show_expic')) {?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('expic1'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('expic1'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('expic2'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('expic2'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('expic3'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('expic3'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('expic4'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('expic4'); ?></div>
					</div>

				<?php } ?>
			</div>

			<div class="tab-pane" id="picdetail">
				<p><?php echo empty($this->item->id) ? JText::_('COM_GARYSCOOKBOOK_DETAILS') : JText::sprintf('COM_GARYSCOOKBOOK_EDIT_DETAILS', $this->item->id); ?></p>


					<?php if ($this->params->get('show_country')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('country'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('country'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_portion')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('portion'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('portion'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_amount')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('amount'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('amount'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_aging')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('aging'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('aging'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_years')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('years'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('years'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_price')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('price'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('price'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_doc')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('doc'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('doc'); ?></div>
						</div>
					<?php } ?>
					<?php if ($this->params->get('show_vegan')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('vegan'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('vegan'); ?></div>
						</div>
					<?php } ?>
					<?php if ($this->params->get('show_gluten')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('gluten'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('gluten'); ?></div>
						</div>
					<?php } ?>
					<?php if ($this->params->get('show_laktose')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('laktose'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('laktose'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_diaet')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('diaet'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('diaet'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_kcal')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('kcal'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('kcal'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_kjoule')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('kjoule'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('kjoule'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_fat')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('fat'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('fat'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_breadunit')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('breadunit'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('breadunit'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_protein')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('protein'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('protein'); ?></div>
						</div>
					<?php } ?>

					<?php if ($this->params->get('show_carbohydrates')) {?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('carbohydrates'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('carbohydrates'); ?></div>
						</div>
					<?php } ?>

			</div>



			<div class="tab-pane" id="publishing">

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><label id="jform_id-lbl" for="jform_catid" class="hasTip" title="ID::Aufnahmenummer in der Datenbank">CATID</label></div>
					<div class="controls"><input type="text" name="jform[id]" id="jform_id" value="<?php echo $this->item->catid;?>" class="readonly" size="10" readonly="readonly"/></div>
				</div>

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
				</div>
				<?php if ($this->params->get('show_created_by_alias')) {?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
					</div>
				<?php } ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
					</div>

					<?php if ($this->item->modified_by) : ?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
						</div>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
						</div>
					<?php endif; ?>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('imgcounter'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('imgcounter'); ?></div>
					</div>
					<?php if ($this->params->get('show_created_by_alias')) {?>
						<div class="control-group">
							<div class="control-label"><label><?php echo JTEXT::_('COM_GARYSCOOKBOOK_FIELD_VOTING_LABEL')?></label></div>
							<?php
						if ($this->item->imgvotes > 0) {
							$qs = round($this->item->imgvotesum / $this->item->imgvotes,2);
						} else {
							$qs = JTEXT::_('COM_GARYSCOOKBOOK_FIELD_NOVOTES');
						} ?>
							<div class="controls"><input type="text" name="jform[imgvote]" id="jform_imgvote" value="<?php echo $qs ?>" class="readonly" size="22" readonly="readonly"/></div>
						</div>
					<?php } ?>

			</div>
		<?php echo $this->loadTemplate('params_3'); ?>

		<?php echo $this->loadTemplate('metadata_3'); ?>

	</div>

	</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>

	</div>
								<!-- Begin Sidebar -->
	<div class="span2">
		<h4><?php echo JText::_('JDETAILS');?></h4>
		<hr />
		<fieldset class="form-vertical">
			<div class="control-group">
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getValue('imgtitle'); ?>
					</div>
				</div>
				<div class="control-label">
					<?php echo $this->form->getLabel('published'); ?>
				</div>
				<div class="controls">
					<?php echo $this->form->getInput('published'); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('access'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->form->getLabel('featured'); ?>
				</div>
				<div class="controls">
					<?php echo $this->form->getInput('featured'); ?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->form->getLabel('language'); ?>
				</div>
				<div class="controls">
					<?php echo $this->form->getInput('language'); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<!-- End Sidebar -->
	</div>
</form>

