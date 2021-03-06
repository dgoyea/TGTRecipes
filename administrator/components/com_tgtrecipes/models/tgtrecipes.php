<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Model for Tgtrecipes admin view
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesModelTgtrecipes extends JModelList
{
	
	 /**
     * Sets up array of fields to be used in view
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $config = array
     * @return  $config = array
     * @since   1.0
     */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
			);
		}

		parent::__construct($config);
	}

    /**
     * Prepare query to get data from db
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   
     * @return  $query = query object
     * @since   1.0
     */
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title'
			)
		);
		$query->from($db->quoteName('#__tgtrecipes').' AS a');

		return $query;
	}
}