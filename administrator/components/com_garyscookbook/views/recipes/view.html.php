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
 * View class for a list of recipes.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookViewRecipes extends JViewLegacy
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
		if ($isJoomla30 && $this->_layout !='modal') {
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
		$canDo	= GaryscookbookHelper::getActions($this->state->get('filter.category_id'));
		$user	= JFactory::getUser();
		$version = new JVersion();
		$currentVersion = $version->getShortVersion();
		$isJoomla30 = version_compare($currentVersion, '3.0', '>=');

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES'), 'gcbrecipes.png');

		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_garyscookbook', 'core.create'))) > 0) {
			JToolBarHelper::addNew('recipe.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
			JToolBarHelper::editList('recipe.edit');
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish('recipes.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('recipes.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('recipes.archive');
			JToolBarHelper::checkin('recipes.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'recipes.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('recipes.trash');
			JToolBarHelper::divider();
		}
		if ($isJoomla30) {

			if ($user->authorise('core.edit'))
			{
				JHtml::_('bootstrap.modal', 'collapseModal');
				$title = JText::_('JTOOLBAR_BATCH');
				$dhtml = "<button data-toggle=\"modal\" data-target=\"#collapseModal\" class=\"btn btn-small\">
							<i class=\"icon-checkbox-partial\" title=\"$title\"></i>
							$title</button>";
				$bar->appendButton('Custom', $dhtml, 'batch3');
			}
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}



		if ($isJoomla30) {

			JHtmlSidebar::setAction('index.php?option=com_garyscookbook');

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);

				JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_CATEGORY'),
				'filter_category_id',
				JHtml::_('select.options', JHtml::_('category.options', 'com_garyscookbook'), 'value', 'text', $this->state->get('filter.category_id'))
			);

				JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_ACCESS'),
				'filter_access',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
			);

				JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_LANGUAGE'),
				'filter_language',
				JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'))
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
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.imgtitle' => JText::_('JGLOBAL_TITLE'),
			'category_title' => JText::_('JCATEGORY'),
			'a.featured' => JText::_('JFEATURED'),
			'a.access' => JText::_('JGRID_HEADING_ACCESS'),
			'a.language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
