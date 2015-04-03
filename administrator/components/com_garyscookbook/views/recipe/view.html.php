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
 * View to edit a recipe.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookViewRecipe extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		// Get the parameters
		$this->params = JComponentHelper::getParams('com_garyscookbook');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$version = new JVersion();
		$currentVersion = $version->getShortVersion();
		$isJoomla30 = version_compare($currentVersion, '3.0', '>=');
		if ($isJoomla30) {
			$tpl = '3';
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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo		= GaryscookbookHelper::getActions($this->item->catid, 0);

		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPE'), 'recipe.png');

		// Build the actions for new and existing records.
		if ($isNew)  {
			// For new records, check the create permission.
			//if ($isNew && (count($user->getAuthorisedCategories('com_garyscookbook', 'core.create')) > 0)) {
				JToolBarHelper::apply('recipe.apply');
				JToolBarHelper::save('recipe.save');
				JToolBarHelper::save2new('recipe.save2new');
			//}

			JToolBarHelper::cancel('recipe.cancel');
		}
		else {
			// Can't save the record if it's checked out.
			if (!$checkedOut) {
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
					JToolBarHelper::apply('recipe.apply');
					JToolBarHelper::save('recipe.save');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create')) {
						JToolBarHelper::save2new('recipe.save2new');
					}
				}
			}

			// If checked out, we can still save
			if ($canDo->get('core.create')) {
				JToolBarHelper::save2copy('recipe.save2copy');
			}

			JToolBarHelper::cancel('recipe.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_RECIPES_RECIPES_EDIT');
	}
}
