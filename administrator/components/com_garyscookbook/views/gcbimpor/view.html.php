<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Garyscookbook Import One Recipe

defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );

class GaryscookbookViewGcbimpor extends JViewLegacy {

	protected $form;
	protected $params;
	protected $state;

	public function display($tpl = null) {

		// Get the view data.
		$this->form		= $this->get('Form');
		$this->state	= $this->get('State');
		$this->params	= $this->state->params;
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->canDo	 	= GaryscookbookHelper::getActions();

		// Set the toolbar
		$this->addToolBar();


		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolbar() {
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$user	= JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_IMPORT_ONE_RECIPE'), 'gcbrecipes.png');

		if ($this->canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help( 'bej.help', true );
	}

	protected function setDocument() {
		$this->document->addStyleSheet(JPATH_COMPONENT.'/assets/css/gcb.css');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES'));
	}
}
?>