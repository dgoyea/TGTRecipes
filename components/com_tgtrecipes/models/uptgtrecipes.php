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
 * Update Recipes Model Class
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesModelUptgtrecipes extends JModelList
{
	
    /**
     * Construct function for update recipes model
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   $config = array
     *
     * @return  
     *
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
     * Populate State function to determine ordering of list
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $ordering = int
     * @return  
     * @since   1.0
     */
	
	protected function populateState($ordering = null, $direction = null)
	{
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
	
		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);
	
		parent::populateState('a.ordering', 'asc');
	}
	
	
    /**
     * get List Query function to setup query in model
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     *
     * @param   
     * @return  $query = query object?
     * @since   1.0
     */
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		$query->select(
				$this->getState(
						'list.select',
						'a.id, a.title, a.catid',
						'a.publish_up, a.publish_down, a.ordering'
				)
		);
		$query->from($db->quoteName('#__tgtrecipes').' AS a');
	
		$published = $this->getState('filter.state');
		if (is_numeric($published))
		{
			$query->where('a.state = '.(int) $published);
		} elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}
	
		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
	
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.')');
			}
		}
	
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering')
		{
			$orderCol = 'c.title '.$orderDirn.', a.ordering';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));
	
		return $query;
	}	
}