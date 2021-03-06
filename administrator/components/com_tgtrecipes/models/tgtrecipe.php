<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
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
	
	 /**
     * prefix for controller messages
     *
     * @var    $text_prefix
     * @since  1.0
     */
	protected $text_prefix = 'COM_TGTRECIPES';

	 /**
     * Call to get the table
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $type = Table type
     * 			$prefix = Component name table
     * 			$config = Array of fields
     * @return  JTable
     * @since   1.0
     */
	public function getTable($type = 'Tgtrecipes', $prefix = 'TgtrecipesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     * Get form data for Tgtrecipe form
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = array for data
     * 			$loadData = boolean
     * @return  $form = form object
     * @since   1.0
     */	
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

    /**
     * Load data into the form for Tgtrecipe form
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   
     * @return  $data = form data
     * @since   1.0
     */	
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_tgtrecipes.edit.tgtrecipe.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

    /**
     * Transform data before display
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $table = table
     * @return  
     * @since   1.0
     */
	protected function prepareTable($table)
	{
		$table->title = htmlspecialchars_decode($table->title, ENT_QUOTES);
	}
}