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
 * Recipe model for Tgtlotreview
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.3
 */
class TgtrecipesModelTgtlotreview extends JModelAdmin
{
	
	 /**
     * prefix for controller messages
     *
     * @var    $text_prefix
     * @since  1.3
     */
	protected $text_prefix = 'COM_TGTRECIPES';

	/**
	 * variable to store venue id
	 *
	 * @var    $venid = venue id
	 * @since  1.3.1
	 */
	protected $venid = NULL;
	

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
     * @since   1.3
     */
	public function getTable($type = 'Tgtlotreviews', $prefix = 'TgtrecipesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     * Get form data for Tgtlotreview form
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = array for data
     * 			$loadData = boolean
     * @return  $form = form object
     * @since   1.3
     */	
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		$form = $this->loadForm('com_tgtrecipes.tgtlotreview', 'tgtlotreview', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		
		return $form;
	}

    /**
     * Load data into the form for Tgtlotreview form
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   
     * @return  $data = form data
     * @since   1.3
     */	
	protected function loadFormData()
	{
		error_log('TgtrecipesModelTgtlotreview.loadFormData');
		
		$data = JFactory::getApplication()->getUserState('com_tgtrecipes.edit.tgtlotreview.data', array());

    	if (empty($data))
		{
			$data = $this->getItem();
			
			//Get the vunueid from the JObject so we can look up the venue in a separate query
			$venid = $data->venueid;
		}
		
		
		//Only do this stuff if a venueid is present
// 		error_log('venid found: ' . $venid);
// 		if (empty($venid))
// 		{
// 			error_log('No venue id set, must be a new record');
			
// 			//Set database connection
// 			$db		= $this->getDbo();
// 			$query	= $db->getQuery(true);		
			
// 			//Set up a query to get the venuename from its table
// 			$query->select('venuename');
// 			$query->from($db->quoteName('#__tgtlotvenues'));
// 			$query->where('id = ' . $venid);
// 			$db->setQuery($query);
	
// 			//Run the query and grab the results
// 			$results = $db->loadObject();
	

// 			//Get the venue name	
// 			$ven = $results->venuename;
	
// 			//Add venuename & venueid to the $data array
// 			$data->set('venuename', $ven);
// 			$data->set('venueid', $venid);
			
// 		}
		
		error_log("Data available in form:");
		// Converting the $data array to json to make it loggable
		error_log(json_encode($data));

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
     * @since   1.3
     */
	protected function prepareTable($table)
	{
		$table->lotname = htmlspecialchars_decode($table->lotname, ENT_QUOTES);
	}
	
	 /**
     * Override for save function
     * Creating an override save function to handle saving to multiple tables
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = form data
     * @return  n/a
     * @since   1.3.1
     */
	public function save($data)
	{
		// Logging data available to save for troubleshooting
		error_log("Data available for saving:");
		// Converting the $data array to json to make it loggable
		error_log(json_encode($data));
		
// 		if ($data['id'])
// 		{
// 			//Set database connection
// 			$db		= $this->getDbo();
// 			$query	= $db->getQuery(true);
			
// 			// Fields to update
// 			$fields = array(
// 					// Venuename is actually the venueid so we set the venue id to it
// 					// This is because the venuename is looked up in the view xml based on id
// 					$db->quoteName('venueid') . ' = ' . $db->quote($data['venuename'])
// 			);
			
// 			// Conditions for which records should be updated
// 			$conditions = array(
// 				$db->quoteName('id') . ' = ' . $db->quote($data['id'])
// 			);
	
// 			$query->update($db->quoteName('#__tgtlotreviews'))->set($fields)->where($conditions);
			
// 			$db->setQuery($query);
			
// 			error_log($query);
		
// 			// Execute the query
// 			$results = $db->execute();		
// 		}
		
		// Remove the fields that we don't want to be updated by the parent
		$data['venueid'] = $data['venuename'];
		unset($data['venuename']);

		// Logging data available to save for troubleshooting
		error_log("Data to be saved:");
		// Converting the $data array to json to make it loggable
		error_log(json_encode($data));		
		
		//Hand over to the parent function
		return parent::save($data);
	
	}
}