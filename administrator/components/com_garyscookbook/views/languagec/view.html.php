<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
// language copy
defined( '_JEXEC' ) or die();

jimport( 'joomla.application.component.view' );

class GaryscookbookViewLanguagec extends JViewLegacy {

	public function display($tpl = null) {

		$this->form 	= $this->get('Form');

		$this->addToolbar();

		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolbar() {

		JRequest::setVar('hidemainmenu', true);

		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$canDo	= GaryscookbookHelper::getActions();
		$this->canDo = $canDo;
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_TITLE_LANG_COPY'), 'language.png');

		if ($this->canDo->get('core.edit')) {
			JToolBarHelper::save('languagec.save', 'COM_GARYSCOOKBOOK_COPY');
		}
			JToolBarHelper::cancel('languagec.cancel', 'JTOOLBAR_CLOSE');
	}

	protected function setDocument() {
		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_TITLE_LANG_COPY'));
	}
}
?>