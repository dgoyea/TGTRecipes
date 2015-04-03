<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Languages View

	defined('_JEXEC') or die('Restricted Access');

	$canEdit	= $this->canDo->get('core.edit');
?>

	<table class="adminlist"><thead><tr>
		<th><?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGEFILE'); ?></th>
		<th width="15%"><?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGECODE'); ?></th>
		<th width="20%"><?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGELOCATION'); ?></th>
	</tr></thead>
	<tbody>

<?php
	$editpic = JURI::Base().'components/com_garyscookbook/assets/images/16-gcbedit.png';
	foreach($this->languages  as $key => $item):
		 $i = -1;
		//Backend
		if (!isset($item["be"])) {
			$i++; ?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_MISSING_TRANSLATION_BACKEND'); ?>
			</td><td></td><td></td></tr>
		<?php } else {
			$i++; ?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td>
			<?php
			if ($canEdit) { ?>
				<a href="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=language'); ?>&lang=<?php echo $key; ?>&type=be" title="<?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGE_EDIT'); ?> ">
				<?php echo JHTML::_('image', $editpic, 'edit' ); ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["be"]); ?></span></a>
			<?php }else { ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["be"]); ?></span>
				</td>
			<?php }  ?>
			</td>
			<td><?php echo $key; ?></td>
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_BACKEND')?></td>
			</tr>
		<?php }
		//Backend sys
		if (!isset($item["besys"])) {
			$i++;?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td style="color:red;">
			<?php echo JText::_('COM_GARYSCOOKBOOK_MISSING_TRANSLATION_BACKEND'); ?>
			</td><td></td><td></td></tr>
		<?php } else {
			$i++;?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td>
			<?php if ($canEdit) {?>
				<a href="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=language'); ?>&lang=<?php echo $key; ?>&type=besys" title="<?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGE_EDIT'); ?>">
				<?php echo JHTML::_('image', $editpic, 'edit' ); ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["besys"]); ?></span></a>
			<?php } else { ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["besys"]); ?></span>
			<?php  } ?>
			</td>
			<td><?php echo $key; ?></td>
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_BACKEND_SYS'); ?></td>
			</tr>
		<?php }
//admin_override
		if (isset($item["beover"]) && $item["beover"]) {
			$i++; ?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td>
			<?php if ($canEdit) { ?>
				<a href="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=language'); ?>&lang=<?php echo $key; ?>&type=beover" title="<?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGE_EDIT'); ?>">
				<?php echo JHTML::_('image', $editpic, 'edit' ); ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["beover"]); ?></span></a>
			<?php  } else { ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["beover"]); ?></span>
			<?php } ?>
			</td>
			<td><?php echo $key; ?></td>
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_BACKEND_OVER'); ?></td>
			</tr>
		<?php }
		//Frontend
		if (!isset($item["fe"])) {
			$i++; ?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td style="color:red;"><?php echo JText::_('COM_GARYSCOOKBOOK_MISSING_TRANSLATION_FRONTEND'); ?><td></td><td></td></td></tr>
		<?php } else {
			$i++;?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td>
			<?php if ($canEdit) { ?>
				<a href="<?php echo JRoute::_('index.php?option=com_garyscookbook&view=language'); ?>&lang=<?php echo $key; ?>&type=fe" title="<?php echo JText::_('COM_GARYSCOOKBOOK_LANG_EDIT'); ?>">
				<?php  echo JHTML::_('image', $editpic, 'edit' ); ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["fe"]); ?></span></a>
			<?php } else { ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["fe"]); ?></span>
			<?php } ?>
			</td>
			<td><?php echo $key; ?></td>
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_FRONTEND'); ?></td>
			</tr>
		<?php }
//site_override
		if (isset($item["feover"]) && $item["feover"]) {
			$i++; ?>
			<tr class="row<?php echo ($i % 2); ?>">
			<td>
			<?php if ($canEdit) { ?>
				<a href="<?php echo JRoute::_('index.php?option=COM_GARYSCOOKBOOKview=language'); ?>&lang=<?php echo $key; ?>&type=feover" title="<?php echo JText::_('COM_GARYSCOOKBOOK_LANGUAGE_EDIT'); ?>">
				<?php  echo JHTML::_('image', $editpic, 'edit' ); ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["feover"]); ?></span></a>
			<?php } else { ?>
				<span style="margin-left:1em;"><?php echo $this->escape($item["feover"]); ?></span>
			<?php } ?>
			</td>
			<td><?php echo $key; ?></td>
			<td><?php echo JText::_('COM_GARYSCOOKBOOK_FRONTEND_OVER'); ?></td>
			</tr>
		<?php }
		$i ++;
		endforeach; ?>

		</tbody></table>

