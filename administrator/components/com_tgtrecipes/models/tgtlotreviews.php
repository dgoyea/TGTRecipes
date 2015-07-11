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
 * Model for Tgtlotreviews admin view
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.3
 */
class TgtrecipesModelTgtlotreviews extends JModelList
{
	
	 /**
     * Sets up array of fields to be used in view
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $config = array
     * @return  $config = array
     * @since   1.3
     */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'lotname', 'a.lotname',
				'venueid', 'a.venueid',
				'eventtype', 'a.eventtype',
				'ordering', 'a.ordering'
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
     * @since   1.3
     */
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.lotname',
				'a.venueid, a.eventtype',
				'a.ordering'
			)
		);
		$query->from($db->quoteName('#__tgtlotreviews').' AS a');

		return $query;
	}
}