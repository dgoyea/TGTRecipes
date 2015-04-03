<?php
/**
 * @version		$Id: default_items.php 21321 2011-05-11 01:05:59Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_bejgcb
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
	$spalten = 3;
	$aktspalte = 0;
?>
<?php foreach($this->items[$this->parent->id] as $id => $item) :
	if($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
	?>

	<!--DIV Tabelle-->
	<?php if ($aktspalte == 0) { ?>
		<div class="gcbrow">
	<?php } ?>
		<div class="gbccelle">
		 	<span class="item-title"><a href="<?php echo JRoute::_(BejgcbHelperRoute::getCategoryRoute($item->id));?>">
		 		<?php echo $this->escape($item->title); ?></a></span>
				<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
					<?php if ($item->description) : ?>
						<div class="category-desc">
							<?php echo JHtml::_('content.prepare', $item->description); ?>
						</div>
					<?php endif; ?>
		        <?php endif; ?>
				<?php if ($this->params->get('show_cat_items_cat') == 1) :?>
					<dl><dt>
						<?php echo JText::_('COM_CONTACT_COUNT'); ?></dt>
						<dd><?php echo $item->numitems; ?></dd>
					</dl>
				<?php endif; ?>
		<?php if(count($item->getChildren()) > 0) :
			$this->items[$item->id] = $item->getChildren();
			$this->parent = $item;
			$this->maxLevelcat--;
			echo $this->loadTemplate('items');
			$this->parent = $item->getParent();
			$this->maxLevelcat++;
		endif; ?>



		 	<?php  $aktspalte += 1;	?>
		</div>
	<?php if ($aktspalte== $spalten) {
		$aktspalte = 0;
		?>
		</div>
	<?php } ?>


	<?php

/*
	if(!isset($this->items[$this->parent->id][$id + 1]))
	{
		$class = ' class="last"';
	}
*/
	?>


	<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>