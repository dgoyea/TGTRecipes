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

jimport('joomla.application.component.controller');

/**
 * Component Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 */
class GaryscookbookController extends JControllerLegacy
{
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'gcbcp';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JControllerLegacy		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';

		// Load the submenu.
		GaryscookbookHelper::addSubmenu(JRequest::getCmd('view', 'gcbcp'));

		$view	= JRequest::getCmd('view', 'gcbcp');
		$layout = JRequest::getCmd('layout', 'default');
		$id		= JRequest::getInt('id');

		// Check for edit form.
		if ($view == 'recipe' && $layout == 'edit' && !$this->checkEditId('com_garyscookbook.edit.recipe', $id)) {

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipes', false));

			return false;
		}

		parent::display();

		return $this;
	}
}
