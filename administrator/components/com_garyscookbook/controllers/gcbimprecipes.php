<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Garyscookbook Import MM Controller

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');
jimport('joomla.filesystem.archive');

class GaryscookbookControllerGcbimprecipes extends JControllerAdmin {

	public function importrecipes()	{

	// Check for request forgeries.
	JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Load the component parameters
		$this->params	= JComponentHelper::getParams('com_garyscookbook');

	// Get the data from POST
	$option	= JRequest::getVar( 'option', '', '', 'string', JREQUEST_ALLOWRAW );
	$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
	$task	= JRequest::getVar( 'task', '', '', 'string', JREQUEST_ALLOWRAW );

	// Get the Formdata from FILES
	$files = JRequest::getVar('jform', array(), 'files', 'array');
	//konvert array from FILES to one per file -- easier way?
	// to be added to library!!!!!
		$i = 0;
		$formfiles = array();
		foreach($files['name'] as $key => $file) {
			$formfiles[$i]["formname"] = $key;
			$formfiles[$i]["formfile"] = $file;
			$formfiles[$i]["formfiletype"] = $files["type"][$key];
			$formfiles[$i]["formfiletmp"] = $files["tmp_name"][$key];
			$formfiles[$i]["formfileerror"] = $files["error"][$key];
			$formfiles[$i]["formfilesize"] = $files["size"][$key];
			//print_r($formfiles);
			$i ++;
		}
		$importfile = JPATH_ROOT ."/tmp/" . $formfiles[0]["formfile"];
		$result = move_uploaded_file($formfiles[0]["formfiletmp"], $importfile);
		if ($result === false)
		{
			return false;
		}

		// Do the unpacking of the archive
		$result = JArchive::extract($importfile, JPATH_ROOT."/tmp");
		unlink( $importfile);
		if ($result === false)
		{
			return false;
		}
		//Einlesen Kategorie
		$db= JFactory::getDBO();
		$impstring = file_get_contents(JPATH_ROOT .'/tmp/gkbimport15cat.sql');
		$db->setquery($impstring);
		$db->query();

		if ($db->getErrorNum()){
			echo $db->getErrorMsg();
			//return new Exception($db->getErrorMsg());
		}
		unlink( $impstring);
		//Einlesen Rezepte
		$impstring = file_get_contents(JPATH_ROOT .'/tmp/gkbimport15rec.sql');
		$db->setquery($impstring);
		$db->query();

		if ($db->getErrorNum()){
			echo $db->getErrorMsg();
			//return new Exception($db->getErrorMsg());
		}
		unlink( $impstring);
		//Einlesen Kommentare
		$impstring = file_get_contents(JPATH_ROOT .'/tmp/gkbimport15com.sql');
		$db->setquery($impstring);
		$db->query();

		if ($db->getErrorNum()){
			echo $db->getErrorMsg();
			//return new Exception($db->getErrorMsg());
		}
		unlink( $impstring);
		//Einlesen Meinerezepte
		$impstring = file_get_contents(JPATH_ROOT .'/tmp/gkbimport15my.sql');
		$db->setquery($impstring);
		$db->query();

		if ($db->getErrorNum()){
			echo $db->getErrorMsg();
			//return new Exception($db->getErrorMsg());
		}
		unlink( $impstring);

		// Redirect
		$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=gcbimprecipes', false));
		return;
	}

	public function getTable($type = 'Garyscookbook', $prefix = 'RecipeTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}