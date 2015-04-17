<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Recipe model for Tailgate Territory
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */

class TgtrecipesModelTgtrecipe extends JModelAdmin
{
	protected $text_prefix = 'COM_TGTRECIPES';

	// $type = view name
	// $prefix = ComponentnameTable
	
	public function getTable($type = 'Tgtrecipes', $prefix = 'TgtrecipesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		$form = $this->loadForm('com_tgtrecipes.tgtrecipe', 'tgtrecipe', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_tgtrecipes.edit.tgtrecipe.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	protected function prepareTable($table)
	{
		$table->title = htmlspecialchars_decode($table->title, ENT_QUOTES);
	}
}