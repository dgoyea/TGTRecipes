<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of comments.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookViewComments extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Preprocess the list of items to find ordering divisions.
		// TODO: Complete the ordering stuff with nested sets
		foreach ($this->items as &$item) {
			$item->order_up = true;
			$item->order_dn = true;
		}

		$this->addToolbar();
		$version = new JVersion();
		$currentVersion = $version->getShortVersion();
		$isJoomla30 = version_compare($currentVersion, '3.0', '>=');
		if ($isJoomla30) {
			$tpl = '3';
			$this->sidebar = JHtmlSidebar::render();
		}
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$canDo	= GaryscookbookHelper::getActions($this->state->get('filter.comment_id'));
		$user	= JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_COMMENTS'), 'gcbcomments.png');

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publish('comments.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('comments.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
		}

		if ( $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'comments.delete');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}
		$version = new JVersion();
		$currentVersion = $version->getShortVersion();
		$isJoomla30 = version_compare($currentVersion, '3.0', '>=');
		if ($isJoomla30) {
			JHtmlSidebar::setAction('index.php?option=com_garyscookbook');

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);

		}
		JToolBarHelper::help('JHELP_COMPONENTS_RECIPES_RECIPES');
	}
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.cmttext' => JText::_('COM_GARYSCOOKBOOK_COMMENTS'),
			'ag.imgtitle' => JText::_('COM_GARYSCOOKBOOK_COMMENTS_RECIPE'),
			'a.cmtdate' => JText::_('COM_GARYSCOOKBOOK_COMMENTS_DATE'),
			'a.cmtname' => JText::_('COM_GARYSCOOKBOOK_COMMENTS_USER'),
			'a.published' => JText::_('JSTATUS'),
			'a.cmtip' => JText::_('JSTATUS'),
			'a.cmtid' => JText::_('JGRID_HEADING_ID'),
		);
	}
}
