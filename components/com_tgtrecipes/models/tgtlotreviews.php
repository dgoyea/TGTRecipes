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
 * com_tgtrecipes primary model
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.3.2
 */

class TgtrecipesModelTgtlotreviews extends JModelList
{
	
	 /**
     * construct function for model
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   array $config array to be retreived
     *
     * @return  array
     *
     * @since   1.3.2
     */
	public function __construct($config=array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'lotname', 'a.lotname',
				'venueid', 'a.venueid',
				'venuename', 'c.venuename',
				'eventtype', 'a.eventtype',
				'ordering', 'a.ordering'
			);
		}

		parent::__construct($config);
	}
	
	 /**
     * function to retrieve the list from the db
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   none
     *
     * @return  query $query
     *
     * @since   1.3.2
     */
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.lotname,' .
				'a.venueid, a.eventtype,' .
				'a.ordering'
			)
		);
		$query->from($db->quoteName('#__tgtlotreviews').' AS a');
		
		$query->select('c.venuename AS venuename');
		$query->join('LEFT', '#__tgtlotvenues AS c ON c.id = a.venueid');

		return $query;
	}
}