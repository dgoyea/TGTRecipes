<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Languages View

defined( '_JEXEC' ) or die();

jimport( 'joomla.application.component.view' );

class GaryscookbookViewLanguages extends JViewLegacy
{
	public function display($tpl = null) {
		$this->state		= $this->get('State');



		// Get the list of available languages.
		$this->languages =  $this->get('files');

		$this->addToolbar();
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolbar() {
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$canDo	= GaryscookbookHelper::getActions($this->state->get('filter.category_id'));
		$this->canDo =$canDo;
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_LANGUAGES_CP'), 'language.png');
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}
		JToolBarHelper::help( 'garyscookbook.help', true );
	}

	protected function setDocument()
	{

		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_FIELD_LANGUAGE'));
	}
}
?>