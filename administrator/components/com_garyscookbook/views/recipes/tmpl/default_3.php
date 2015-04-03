<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= $user->authorise('core.edit.state', 'com_garyscookbook.category');
$saveOrder	= $listOrder == 'a.ordering';
$sortFields = $this->getSortFields();
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_garyscookbook&task=recipes.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_garyscookbook'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div class="clr"> </div>
<div id="j-main-container" class="span10">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_GARYSCOOKBOOK_SEARCH_IN_NAME'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_GARYSCOOKBOOK_SEARCH_IN_NAME'); ?>" />
		</div>
		<div class="btn-group pull-left">
			<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
			<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
			<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
				<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
				<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
			</select>
		</div>
		<div class="btn-group pull-right">
			<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
			<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
				<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
				<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
			</select>
		</div>

	</div>
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
				</th>
				<th width="1%" class="nowrap center hidden-phone">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.imgtitle', $listDirn, $listOrder); ?>
				</th>

				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JFEATURED', 'a.featured', $listDirn, $listOrder, NULL, 'desc'); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
				</th>

				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'a.access', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
				</th>
				<th width="1%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
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
		<?php
		$n = count($this->items);
		foreach ($this->items as $i => $item) :
			$ordering	= $listOrder == 'a.ordering';
			$canCreate	= $user->authorise('core.create',		'com_garyscookbook.category.'.$item->catid);
			$canEdit	= $user->authorise('core.edit',			'com_garyscookbook.category.'.$item->catid);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
			$canEditOwn	= $user->authorise('core.edit.own',		'com_garyscookbook.category.'.$item->catid) && $item->created_by == $userId;
			$canChange	= $user->authorise('core.edit.state',	'com_garyscookbook.category.'.$item->catid) && $canCheckin;

			$item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_garyscookbook&task=edit&type=other&id='.$item->catid);
			?>
			<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid?>">
				<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';
						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
							endif; ?>
						<span class="sortable-handler hasTooltip<?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:" name="order[]" size="5"
						value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'recipes.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
				</td>
				<td>
					<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'recipes.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit || $canEditOwn) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_garyscookbook&task=recipe.edit&id='.(int) $item->id); ?>">
						<?php echo $this->escape($item->imgtitle); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->imgtitle); ?>
					<?php endif; ?>
					<p class="smallsub">
						<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?></p>
				</td>

				<td class="center">
					<?php echo JHtml::_('garyscookbook.featured', $item->featured, $i, $canChange); ?>
				</td>
				<td align="center">
					<?php echo $item->category_title; ?>
				</td>

				<td align="center">
					<?php echo $item->access_level; ?>
				</td>
				<td class="center">
					<?php if ($item->language=='*'):?>
						<?php echo JText::alt('JALL', 'language'); ?>
					<?php else:?>
						<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
					<?php endif;?>
				</td>
				<td align="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php //Load the batch processing form. ?>
	<?php echo $this->loadTemplate('batch3'); ?>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="recipes" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</form>
