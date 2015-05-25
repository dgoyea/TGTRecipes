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
 * Update Recipes Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */

class TgtrecipesControllerUptgtrecipes extends JControllerAdmin 
{
	 /**
     * getModel function for TgtrecipeModel
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   $name = Model name
     * 			$prefix = TgtrecipeModel
     * 			$config = Array of model parameters
     * @return  $model = TgtrecipeModel
     * @since   1.0
     */
	public function getModel($name = 'Tgtrecipe', $prefix = 'TgtrecipeModel', $config = array('ignore_request' => true)) 
	{
		$model = parent::getModel($name, $prefix, $config);
		
		return model;
	}
	
	 /**
     * Save order function
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   
     * @return  $return = $model->saveorder
     * @since   1.0
     */
	
	public function saveOrderAjax() 
	{
		$input = JFactory::getApplication()->input;
		
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');
		
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);
		
		$model = $this->getModel();
		
		$return = $model->saveorder($pks, $order);
		
		if ($return)
		{
			echo "1";
		}
		
		JFactory::getApplication()->close();
	}

}