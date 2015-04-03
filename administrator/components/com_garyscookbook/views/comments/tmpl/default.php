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
$this->text_prefix = 'COM_GARYSCOOKBOOK_COMMENTS';
$user		= JFactory::getUser();
$userId		= $user->get('name');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_garyscookbook.comments');
$saveOrder	= $listOrder == 'a.cmtdate';
?>

<form action="<?php echo JRoute::_('index.php?option=com_garyscookbook'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_GARYSCOOKBOOK_SEARCH_IN_NAME'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th align="left">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS', 'a.cmttext', $listDirn, $listOrder); ?>
				</th>
				<th width="15%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_RECIPE', 'ag.imgtitle', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_DATE', 'a.cmtdate', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_USER', 'a.cmtname', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_GARYSCOOKBOOK_COMMENTS_IP', 'a.cmtip', $listDirn, $listOrder); ?>
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
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'comments.', $canChange, 'cb'); ?>
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
</form>
