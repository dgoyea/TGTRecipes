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
 * @since       1.2
 */

class TgtrecipesModelTgtrecipes extends JModelList
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
     * @since   1_2
     */
	public function __construct($config=array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.id',
					'title', 'a.title'
			);
		}
		
		parent::__construct($config);
	}
	
	 /**
     * function to retrieve the list from the db
     *
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   none
     *
     * @return  query $query
     *
     * @since   1_2
     */
	protected function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select(
				$this->getState(
						'list.select',
						'a.id, a.title, a.directions'
				)
		);
		$query->from($db->quoteName('#__tgtrecipes').' AS a');

		$query->where('(a.state IN (0, 1))');
		
		return $query;
	

	}
}