<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * TGT Recipe Model
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesModelUptgtrecipe extends JModelAdmin
{
	protected $text_prefix = 'COM_TGTRECIPES';

	
	 /**
     * Function to check if user can delete TGT Recipe
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $record = TGT Recipe record
     * @return  boolean?
     * @since   1.0
     */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return;
			}
			$user = JFactory::getUser();

			if ($record->catid)
			{
				return $user->authorise('core.delete', 'com_tgtrecipes.category.'.(int) $record->catid);
			}
			else
			{
				return parent::canDelete($record);
			}
		}
	}

	 /**
     * Function to check if user can edit TGT Recipe
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $record = TGT Recipe record
     * @return  boolean?
     * @since   1.0
     */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
		
		if (!empty($record->catid))
		{
			return $user->authorise('core.edit.state', 'com_tgtrecipes.category.'.(int) $record->catid);
		}
		else
		{
			return parent::canEditState($record);
		}
	}

	 /**
     * Function to get TGT Recipe table
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $type = Table type
     * 			$prefix = Table prefix
     * 			$config = config array
     * @return  JTable instance
     * @since   1.0
     */
	public function getTable($type = 'Tgtrecipes', $prefix = 'TgtrecipesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     * Function to get form for TGT Recipe
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = array for data
     * 			$loadData = boolean
     * @return  form
     * @since   1.0
     */
	public function getForm($data = array(), $loadData = true)
	{

		$form = $this->loadForm('com_tgtrecipes.tgtrecipe', 'tgtrecipe', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

    /**
     * function to load form data
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   
     * @return  $data = array of data
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
     * Function to prepare table for TGT Recipe
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $table
     * @return  
     * @since   1.0
     */	
	protected function prepareTable($table)
	{
		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
	}
}