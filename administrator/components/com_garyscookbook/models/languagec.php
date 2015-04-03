<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
// language copy modek
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GaryscookbookModelLanguagec extends JModelAdmin {

	public function getForm($data = array(), $loadData = true) 	{

		$user = JFactory::getUser();

		$form = $this->loadForm('com_garyscookbook.languagec', 'languagec', array('control' => 'jform', 'load_data' => false));

		return $form;
	}

}