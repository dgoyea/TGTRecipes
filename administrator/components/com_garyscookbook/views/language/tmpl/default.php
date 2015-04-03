<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Language View

defined('_JEXEC') or die('Restricted Access');
jimport( 'joomla.filesystem.file' );
?>
	<div>
	<form action="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=language'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform" style="width:98%;">
	<legend><?php echo JText::_( 'COM_GARYSCOOKBOOK_ADMIN_LANG_EDIT' )?></legend>
	<?php if (!$this->writeable) { ?>
		<div style="color:red;"><?php echo JText::_( 'COM_GARYSCOOKBOOK_LANGUAGEFILE_NOT_WRITEABLE' ); ?></div>
	<?php } ?>
	<div><span style="color:green;font-size: 1.3em"><?php echo JText::_( 'COM_GARYSCOOKBOOK__LANGUAGEFILE_INFO' ); ?></span><br /><br /></div>
	<div><span style="font-size: 1.3em;font-weight:bold;"><?php echo JText::_( 'COM_GARYSCOOKBOOK__ADMIN_LANG_FILE' ); ?></span><span style="font-size: 1.3em;"><?php echo $this->file; ?></span>
	</div>


<div class="clr"></div>
<div class="editor-border">
<textarea name="content" id="content" cols="80" rows="20" style="width:100%;"><?php echo $this->content; ?>
	</textarea>

		</div>
	<div>
	</div>


	<input type="hidden" name="task" value="" />
	<input type="hidden" name="file" value="<?php echo $this->file;?>" />
	<input type="hidden" name="lang" value="<?php echo $this->language; ?>" />
	<input type="hidden" name="type" value="<?php echo $this->type; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</fieldset></form></div>