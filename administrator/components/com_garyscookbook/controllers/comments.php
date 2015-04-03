<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Articles list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since	1.6
 */
class GaryscookbookControllerComments extends JControllerAdmin
{
/**
 * @var		string	The prefix to use with controller messages.
 * @since	1.6
 */
	protected $text_prefix = 'COM_GARYSCOOKBOOK_COMMNENTS';


	/**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	JModelLegacy
	 * @since	1.6
	 */
	public function getModel($name = 'Comments', $prefix = 'GaryscookbookModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return	void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$pks   = $this->input->post->get('cid', array(), 'array');
		$order = $this->input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
}
