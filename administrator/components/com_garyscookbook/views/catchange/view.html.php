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
class GaryscookbookViewCatchange extends JViewLegacy
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
		$this->oldcat = JRequest::getInt('oldcat');
		$this->newcat = JRequest::getInt('newcat');
		if ($this->oldcat > 0 && $this->newcat > 0) {
			$this->changeCats();
		}




		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}


	/**
	 * GaryscookbookViewCatchange::addToolbar()
	 *
	 * @return
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';

		$user	= JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_ABOUT'), 'gcbrecipes.png');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_ABOUT'));

		JToolBarHelper::help('JHELP_COMPONENTS_RECIPES_RECIPES');
	}


	/**
	 * GaryscookbookViewCatchange::changeCats()
	 *
	 * @return
	 */
	protected function changeCats(){
		$db = JFactory::getDBO();
		$db->setquery("UPDATE #__garyscookbook SET `catid`='$this->newcat' WHERE `catid`='$this->oldcat';");
		$db->query();
		$db->setquery("UPDATE #__garyscookbook SET `catid2`='$this->newcat' WHERE `catid2`='$this->oldcat';");
		$db->query();
		$db->setquery("UPDATE #__garyscookbook SET `catid3`='$this->newcat' WHERE `catid3`='$this->oldcat';");
		$db->query();
		$db->setquery("UPDATE #__garyscookbook SET `catid4`='$this->newcat' WHERE `catid4`='$this->oldcat';");
		$db->query();
		$db->setquery("UPDATE #__garyscookbook SET `catid5`='$this->newcat' WHERE `catid5`='$this->oldcat';");
		$db->query();

	}
}
