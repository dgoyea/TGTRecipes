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
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookViewAbout extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected static $buttons = array();
	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
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
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_ABOUT'), 'gcbrecipes.png');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_ABOUT'));

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_RECIPES_RECIPES');
	}
}
