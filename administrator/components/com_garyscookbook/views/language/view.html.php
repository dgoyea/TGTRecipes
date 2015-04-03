<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Language View

defined( '_JEXEC' ) or die();

jimport( 'joomla.application.component.view' );

class GaryscookbookViewLanguage extends JViewLegacy
{
	public function display($tpl = null) {

		$this->form		= $this->get('Form');
		if (!$file = $this->get('file')) {
			return false;
		}
		$this->writeable = $file["writeable"];
		$this->file = $file["file"];
		$this->content = $file["content"];
		$this->language = $file["lang"];
		$this->type = $file["type"];

		$this->addToolbar();
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolbar() {
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$this->canDo	= GaryscookbookHelper::getActions();
		$user	= JFactory::getUser();
		JRequest::setVar('hidemainmenu', true);

		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_FIELD_LANGUAGE'), 'language.png');

		// Build the actions
		if ($this->canDo->get('core.edit') && $this->writeable) {
			JToolBarHelper::apply('language.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('language.save', 'JTOOLBAR_SAVE');
		}
			JToolBarHelper::cancel('language.cancel', 'JTOOLBAR_CLOSE');
	}

	protected function setDocument() {

		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_FIELD_LANGUAGE'));
	}
}
?>