<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
 if (isset($this->error)) : ?>
	<div class="garyscookbook-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>
<?php if ($this->params->get('only_registred_comments') && $this->user->name): ?>
<div class="garyscookbook-form">
	<form id="garyscookbook-form" action="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=comment_form&w_id='); ?>" method="post" class="form-validate">
		<fieldset>
			<legend><?php echo JText::_('COM_GARYSCOOKBOOK_FORM_LABEL'); ?></legend>
			<dl>
				<dt><?php echo $this->form->getLabel('garyscookbook_name'); ?></dt>
				<dd><?php echo $this->form->getInput('garyscookbook_name'); ?></dd>
				<dt><?php echo $this->form->getLabel('garyscookbook_comment'); ?></dt>
				<dd><?php echo $this->form->getInput('garyscookbook_comment'); ?></dd>
				<?php //Dynamically load any additional fields from plugins. ?>
			     <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			          <?php if ($fieldset->name != 'garyscookbook'):?>
			               <?php $fields = $this->form->getFieldset($fieldset->name);?>
			               <?php foreach($fields as $field): ?>
			                    <?php if ($field->hidden): ?>
			                         <?php echo $field->input;?>
			                    <?php else:?>
			                         <dt>
			                            <?php echo $field->label; ?>
			                            <?php if (!$field->required && $field->type != "Spacer"): ?>
			                               <span class="optional"><?php echo JText::_('COM_GARYSCOOKBOOK_OPTIONAL') ;?></span>
			                            <?php endif; ?>
			                         </dt>
			                         <dd><?php echo $field->input;?></dd>
			                    <?php endif;?>
			               <?php endforeach;?>
			          <?php endif ?>
			     <?php endforeach;?>
				<dt></dt>
				<dd><button class="button validate" type="submit"><?php echo JText::_('COM_GARYSCOOKBOOK_COMMENT_SEND'); ?></button>
					<input type="hidden" name="option" value="com_garyscookbook" />
					<input type="hidden" name="task" value="recipe.submit" />
					<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
					<input type="hidden" name="id" value="<?php echo $this->garyscookbook->slug; ?>" />
					<?php echo JHtml::_( 'form.token' ); ?>
				</dd>
			</dl>
		</fieldset>
	</form>
</div>
<?php else :  ?>
	<div class="garyscookbook-form">
		<hr /><br />
		<table class="gcbcmt">
			<tr class="sectiontableentry">
				<td class="gcbcmtcol1" valign="top">
					<img class="gcbicon" src="<?php echo GCB_URI_IMAGES . "16-info.png"; ?>" title="<?php echo JTEXT::_('COM_GARYSCOOKBOOK_FIELD_COMMENTS_ONLY_REGISTRED'); ?>" />
				</td>
				<td valign="top">
					<?php echo JText::_('COM_GARYSCOOKBOOK_FIELD_COMMENTS_ONLY_REGISTRED'); ?>
				</td>
			</tr>
		</table>
	</div>
<?php endif; ?>