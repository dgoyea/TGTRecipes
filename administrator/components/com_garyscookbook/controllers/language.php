<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

//Controller language

class GaryscookbookControllerLanguage extends JControllerLegacy
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array() )
	{
		parent::__construct( $default );

		$this->registerTask( 'apply', 'save' );
	}

	/**
	 * Save the languagefile
	 */
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$component	= JApplicationHelper::getComponentName();
		$file["content"]	= JRequest::getVar('content', 'content', '', 'string');
		$file["file"]	= JRequest::getVar('file', 'file', '', 'string');
		$file["lang"]	= JRequest::getVar('lang', 'lang', '', 'string');
		//type = be, besys, fe
		$file["type"]	= JRequest::getVar('type', 'type', '', 'string');

//Write languagefile

		@chmod ($file["file"], 0766);
		if (!is_writable($file["file"])) {
			JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_LANGUAGEFILE_NOT_WRITEABLE').$file["file"]);
			return false;
		}

		if (JFile::write($file["file"], $file["content"])) {
			$msg = JText::_('COM_GARYSCOOKBOOK_LANGUAGEFILE_UPDATED');
			$msgtype="message";
		} else {
			$msg = JText::_('COM_GARYSCOOKBOOK_LANGUAGEFILE_ERROR');
			$msgtype="error";
		}

		if ($this->getTask() != 'apply') {
			// Redirect
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languages', false),$msg,$msgtype);
		}
		else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=language&lang='.$file["lang"].' &type='.$file["type"], false),$msg,$msgtype);
		}
		return ;
	}
	/**
	 * Cancel operation
	 */
	function cancel()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languages', false));
		return ;
	}
}