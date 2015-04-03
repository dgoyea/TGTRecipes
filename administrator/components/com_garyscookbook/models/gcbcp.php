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
 * Methods supporting a list of recipe records.
 *
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 */
class GaryscookbookModelGcbcp extends JModelList
{

	/**
	 * Method to get the database query
	 *
	 * @return	JDatabaseQuery	The database query
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$enabled= $this->getState('filter.enabled');
		$type = $this->getState('filter.type');
		$client = $this->getState('filter.client_id');
		$group = $this->getState('filter.group');
		$hideprotected = $this->getState('filter.hideprotected');
		$query = JFactory::getDBO()->getQuery(true);
		$query->select('*');
		$query->from('#__extensions');
		$query->where('state=0');
		$query->where('name = \'com_garyscookbook\'');
		if ($hideprotected) {
			$query->where('protected!=1');
		}
		if ($enabled != '') {
			$query->where('enabled=' . intval($enabled));
		}
		if ($type) {
			$query->where('type=' . $this->_db->Quote($type));
		}
		if ($client != '') {
			$query->where('client_id=' . intval($client));
		}
		if ($group != '' && in_array($type, array('plugin', 'library', ''))) {

			$query->where('folder=' . $this->_db->Quote($group == '*' ? '' : $group));
		}

		// Filter by search in id
		$search = $this->getState('filter.search');
		if (!empty($search) && stripos($search, 'id:') === 0) {
			$query->where('extension_id = '.(int) substr($search, 3));
		}
		return $query;
	}





}
