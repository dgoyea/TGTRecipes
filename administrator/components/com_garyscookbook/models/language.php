<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Model lang
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
//jimport('joomla.application.component.modeladmin');

class GaryscookbookModelLanguage extends JModelLegacy
{

	/**
	 * Method to get the language file -> name and content
	 */
	public function getfile()
	{
//		jimport('joomla.filesystem.file');
	jimport( 'joomla.filesystem.file' );
	$component	= JApplicationHelper::getComponentName();
	$file = array();

	$file["writeable"] = true;
	$file["lang"]	= JRequest::getVar('lang', 'lang', '', 'string');
	//type = be, besys, beover, fe, feover
	$file["type"]	= JRequest::getVar('type', 'type', '', 'string');

	if ($file["type"] == 'be') {
		$file["file"] = JPATH_ADMINISTRATOR  . '/language/' . $file["lang"] .'/' . $file["lang"] . '.'.$component.'.ini';
	} elseif ($file["type"] == 'besys') {
		$file["file"] = JPATH_ADMINISTRATOR .  '/language/'. $file["lang"] .  '/' . $file["lang"] . '.'.$component.'.sys.ini';
	}elseif ($file["type"] == 'beover') {
		$file["file"] = JPATH_ADMINISTRATOR . '/language/overrides/'  . $file["lang"] . '.override.ini';
	}elseif ($file["type"] == 'feover') {
		$file["file"] = JPATH_SITE . '/language/overrides/' . $file["lang"] . '.override.ini';
	} else {
		$file["file"] = JPATH_SITE . '/language/'. $file["lang"] .  '/' . $file["lang"] . '.'.$component.'.ini';
	}

	if (!JFile::exists($file["file"])) {
		JError::raiseWarning(500, JText::_($component.'_LANGUAGEFILE_NOT_EXISTS').$file["file"]);
	return false;
	}

    //@chmod (!$file["writeable"], 0766);
	if (!is_writable($file["file"])) {
		$file["writeable"] = false;
	}

	//$file["content"] = JFile::read($file["file"]);
	$file["content"] = file_get_contents($file["file"]);
	return $file;
}

}