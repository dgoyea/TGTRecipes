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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
$this->text_prefix = 'COM_GARYSCOOKBOOK_COMMENTS';
$user		= JFactory::getUser();
$userId		= $user->get('name');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_garyscookbook.comments');
$saveOrder	= $listOrder == 'a.cmtdate';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_garyscookbook&task=comments.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
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
	<div id="j-main-container" class="span10">
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC');?></label>
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



	<div class="clr"> </div>

	<table class="table table-striped" id="articleList">
		<thead>
			<tr>

				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="3%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th align="left">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS', 'a.cmttext', $listDirn, $listOrder); ?>
				</th>
				<th width="15%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_RECIPE', 'ag.imgtitle', $listDirn, $listOrder); ?>
				</th>
				<th width="15%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_DATE', 'a.cmtdate', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_USER', 'a.cmtname', $listDirn, $listOrder); ?>
				</th>

				<th width="8%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.cmtip', $listDirn, $listOrder); ?>
				</th>
				<th width="1%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.cmtid', $listDirn, $listOrder); ?>
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
			$canCreate	= $user->authorise('core.create',		'com_garyscookbook.category.'.$item->cmtid);
			$canEdit	= $user->authorise('core.edit',			'com_garyscookbook.category.'.$item->cmtid);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
			$canEditOwn	= $user->authorise('core.edit.own',		'com_garyscookbook.category.'.$item->cmtid) && $item->cmtname == $userId;
			$canChange	= $user->authorise('core.edit.state',	'com_garyscookbook.category.'.$item->cmtid) && $canCheckin;
			?>
			<tr class="row<?php echo $i % 2; ?>">

				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->cmtid); ?>
				</td>
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'comments.', $canChange, 'cb'); ?>
				</td>
				<td>
					<?php echo $this->escape($item->cmttext); ?>
				</td>
				<td align="left">
					<?php echo $item->imgtitle;?>
				</td>
				<td align="left">
					<?php echo JHTML::date($item->cmtdate);?>
				</td>

				<td align="left">
					<?php echo $item->cmtname;?>
				</td>

				<td align="left">
					<?php echo $item->cmtip; ?>
				</td>
				<td align="center">
					<?php echo $item->cmtid; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="comments" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</form>
