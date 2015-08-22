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

<!--  <div id="j-main-container" class="span10"> -->
<div class="mypreview">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_TGTRECIPES_SEARCH_IN_TITLE');?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_TGTRECIPES_SEARCH_IN_TITLE'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TGTRECIPES_SEARCH_IN_TITLE'); ?>" />
		</div>
		<div class="btn-group pull-left">
			<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
			<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>		
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	</div>
	<div class="clearfix"> </div>
	<table class="table table-striped" id="tgtrecipeList">
		<thead>
			<tr>
				<th class="title">
					<?php echo JText::_('JGLOBAL_TITLE'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>	
		<tbody>
		<?php foreach ($this->items as $item) : ?>
		<tr>
			<td>
				<a href="<?php echo JRoute::_('index.php?option=com_tgtrecipes&view=tgtlotreviews&id='.(int)$item->id); ?>"><?php echo $item->lotname; ?></a>
			</td>
		</tr>
		<?php endforeach; ?>		
		</tbody>
	</table>
</div>

