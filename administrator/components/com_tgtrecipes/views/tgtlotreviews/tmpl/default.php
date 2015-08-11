<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

$listOrder	= '';
$listDirn	= '';
?>

<form action="<?php echo JRoute::_('index.php?option=com_tgtrecipes&view=tgtlotreviews'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-main-container" class="span10">

		<div class="clearfix"> </div>
		<table class="table table-striped" id="tgtlotreviewsList">
			<thead>
				<tr>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th class="Lot">
						<?php echo JHtml::_('grid.sort', 'Lot', 'a.lotname', $listDirn, $listOrder); ?>
					</th>
					<th class="Venue">
						<?php echo JHtml::_('grid.sort', 'Venue', 'venuename', $listDirn, $listOrder); ?>
					</th>					
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->items as $i => $item) :
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="nowrap has-context">
						<a href="<?php echo JRoute::_('index.php?option=com_tgtrecipes&task=tgtlotreview.edit&id='.(int) $item->id); ?>">
							<?php echo $this->escape($item->lotname); ?>
						</a>
					</td>
					<td class="nowrap has-context">
						<?php echo $this->escape($item->venuename); ?>
					</td>					
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>