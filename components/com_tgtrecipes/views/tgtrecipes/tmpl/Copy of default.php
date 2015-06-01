<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;
?>

<div class="mypreview">
	<?php foreach ($this->items as $item) : ?>
		<div class="mytgtrecipe">
			<div class="tgtrecipe_title">
				<a href="<?php echo JRoute::_('index.php?option=com_tgtrecipes&view=tgtrecipe&id='.(int)$item->id); ?>"><?php echo $item->title; ?></a>
			</div>

			<div class="tgtrecipe_element">
				<a href="<?php echo $item->url; ?>" target="_blank"><img src="<?php echo $item->image; ?>" width="150"></a>
			</div>
			<div class="tgtrecipe_element">
				<strong><?php echo JText::_('COM_TGTRECIPE_RECIPE');?></strong><?php echo $item->title; ?>
			</div>
			<div class="tgtrecipe_element">
				<?php echo $item->directions; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>