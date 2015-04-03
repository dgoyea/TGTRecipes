<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of comments records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 */
class GaryscookbookModelComments extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JControllerLegacy
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.cmtid',
				'name', 'ag.imgtitle',
				'text', 'a.cmttext',
				'date', 'a.cmtdate',
				'name', 'a.cmtname',
				'publish', 'a.published',
				'ip', 'a.cmtip',
				'id', 'a.cmtid',
				'ordering', 'a.ordering',
			);
			$config['text_prefix'] = 'COM_GARYSCOOKBOOK_COMMENT';
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout')) {
			$this->context .= '.'.$layout;
		}

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState('ag.imgtitle', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.published');


		return parent::getStoreId($id);
	}
	/**
	 * Returns a Table object, always creating it
	 *
	 * @param	type	$type	The table type to instantiate
	 * @param	string	$prefix	A prefix for the table class name. Optional.
	 * @param	array	$config	Configuration array for model. Optional.
	 *
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Comments', $prefix = 'GaryscookbookTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();

		// Select the required fields from the table.
		$query->select('a.*');
		$query->from('#__garyscookbook_comments AS a');

		// Join over the asset groups.
		$query->select('ag.imgtitle');
		$query->join('LEFT', '#__garyscookbook AS ag ON ag.id = a.cmtpic');

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'cmtid:') === 0) {
				$query->where('a.cmtid = '.(int) substr($search, 3));
			}

			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.cmttext LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.cmtdate');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));

		return $query;
	}

public function delete($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Comments','GaryscookbookTable');

		// For all keys
		foreach ($pks as $pk)
		{
			// Delete the row
			if (!$table->delete($pk))
			{
				$this->setError($table->getError());
			}
		}
		return count($this->getErrors())==0;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance proper
	 g. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Comments','GaryscookbookTable');

		// For all keys
		foreach ($pks as $pk)
		{
			// Load the row
			if(!$table->load($pk))
			{
				$this->setError($table->getError());
			}

			// Change the state

			$table->published = $state;

			// Check the row
			$table->check();

			// Store the row
			if (!$table->store())
			{
				$this->setError($table->getError());
			}
		}
		return count($this->getErrors())==0;
	}

}
