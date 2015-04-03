<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Gcb import MM Model

defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modeladmin');

class GaryscookbookModelGcbimpmm extends JModelAdmin
{
	protected function populateState()
	{

		// Load the component parameters.
		$params	= JComponentHelper::getParams('com_garyscookbook');
		$this->setState('params', $params);

	}
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');
		$component = JApplicationHelper::getComponentName();
		JForm::addFieldPath(JPATH_ADMINISTRATOR.'/components/com_garyscookbook/models/fields');

		// Get the form.
		$form = $this->loadForm($component.'.Gcbimpmm', 'Gcbimpmm', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}


	/**
	 * Override preprocessForm not to load plugin.
	 *
	 * @param	object	A form object.
	 * @param	mixed	The data expected for the form.
	 * @throws	Exception if there is an error in the form event.
	 * @since	1.6
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'user')
	{
	return;
//		parent::preprocessForm($form, $data, 'user');
	}

}