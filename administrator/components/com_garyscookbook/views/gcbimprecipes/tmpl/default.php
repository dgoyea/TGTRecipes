<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bejgcb Import MM View template

defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

	if (isset($this->error)) {
		echo '<div class="bej-error">';
		echo $this->error;
		echo '</div>';
	}
	$output = '';?>
	<div class="adminform">

	<?php if ($this->canDo->get('core.create')) { ?>
		<form action="<?php echo JRoute::_('index.php');?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
			<fieldset class="adminform"><dl>
				<h3><?php echo JTEXT::_('COM_GARYSCOOKBOOK_MAXCAD_NUMMER') . " <span style=\"color:red; font-weigth:bold\">" .$this->maxcad;?> </span></h3>
				<dt><?php echo $this->form->getLabel('importfile');?></dt>
				<dd><?php echo $this->form->getInput('importfile');?></dd>
				<dt><label> </label></dt>
				<dd><button class="button validate" type="submit"><?php echo JHTML::_('image', JURI::base().'components/com_garyscookbook/assets/images/32-gcbupload.png', 'edit');?><span style="line-height:300%;"><?php echo JText::_('COM_GARYSCOOKBOOK_UPLOAD_IMPORT');?></span></button></dd>
		</dl>
		</fieldset>
		<input type="hidden" name="option" value="com_garyscookbook" />
		<input type="hidden" name="view" value="gcbimprecipes" />
		<input type="hidden" name="task" value="gcbimprecipes.importrecipes" />
		<?php echo  JHtml::_('form.token'); ?>
		</form>
	<?php }; ?>
	</div>
