<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bejgcb Import One Recipe View template

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
	<fieldset class="adminform">
	<dl>
	<dt><?php echo $this->form->getLabel('uploadedFile');?> </dt>
	<dd><?php echo $this->form->getInput('uploadedFile');?></dd>
	<dt><?php echo $this->form->getLabel('import_category');?></dt>
	<dd><?php echo $this->form->getInput('import_category');?></dd>
	<dt><label> </label></dt>
	<dd><button class="button validate" type="submit"><?php echo JHTML::_('image', JURI::base().'components/com_garyscookbook/assets/images/32-gcbupload.png', 'edit');?>
	<span style="line-height:300%;"><?php echo JText::_('COM_GARYSCOOKBOOK_UPLOAD_IMPORT');?></span>
	</button></dd>
	</dl>
	</fieldset>
	<input type="hidden" name="option" value="com_garyscookbook" />
	<input type="hidden" name="view" value="gcbimpor" />
	<input type="hidden" name="task" value="gcbimpor.doImport" />
	<?php echo  JHtml::_('form.token'); ?>
	</form>
	<?php }; ?>

	</div>
