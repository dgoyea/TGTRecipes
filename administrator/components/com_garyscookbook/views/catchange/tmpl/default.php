<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access.
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<div class="fltlft">
<form id="garyscookbook-form" action="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=catchange'); ?>" method="post" class="form-validate">
 	<fieldset class="adminform">
 	<legend><?php echo JText::_('COM_GARYSCOOKBOOK_CHANGE_CAT_OF_RECIPE_LABEL');?></legend>
 	<?php echo JText::_('COM_GARYSCOOKBOOK_CHANGE_CAT_OF_RECIPE_LABEL');?><br /><br />
	<div class="clr"></div>
	<ul class="adminformlist">
	 	<li><label id="oldcatlbl" for="" class="hasTip" title="<?php echo JText::_('COM_GARYSCOOKBOOK_OLDCAT_LABEL');?>::<?php echo JText::_('COM_GARYSCOOKBOOK_OLDCAT_DESC');?>"><?php echo JText::_('COM_GARYSCOOKBOOK_OLDCAT_LABEL');?></label>
		<input type="text" name="oldcat" id="oldcat" value="" class="readonly" size="5"/></li>
	 	<li><label id="newcatlbl" for="" class="hasTip" title="<?php echo JText::_('COM_GARYSCOOKBOOK_NEWCAT_LABEL');?>::<?php echo JText::_('COM_GARYSCOOKBOOK_NEWCAT_DESC');?>"><?php echo JText::_('COM_GARYSCOOKBOOK_NEWCAT_LABEL');?></label>
		<input type="text" name="newcat" id="newcat" value="" class="readonly" size="5"/></li>

	</ul>
	<div class="clr"></div>
  <input type="submit" name="SubmitButton" value="<?php echo JText::_('COM_GARYSCOOKBOOK_CHANGE_CAT_ID_LABEL');?>" />
</fieldset>

</form>

</div>

