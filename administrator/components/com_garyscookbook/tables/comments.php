<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Table Bej currencies

defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

class GaryscookbookTableComments extends JTable
{

	function __construct(&$db)
	{
		parent::__construct('#__garyscookbook_comments', 'cmtid', $db);
	}

	public function bind($array, $ignore = '')
	{

		return parent::bind($array, $ignore);
	}

	public function store($updateNulls = false)
	{
		return parent::store($updateNulls);
	}

	public function delete($updateNulls = false)
	{
		return parent::delete($updateNulls);
	}

	public function load($pk = null, $reset = true)
	{
	parent::load($pk, $reset);

		if (parent::load($pk, $reset))
		{
			return true;
		}
		else
		{
			return false;
		}

	}


}