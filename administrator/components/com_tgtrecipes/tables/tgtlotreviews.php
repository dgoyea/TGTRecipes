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
 * Table file for Tgtlotreviews
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.3
 */
class TgtrecipesTableTgtlotreviews extends JTable
{
	
	 /**
     * Construct function for DB
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $db = database
     * @return  parent
     * @since   1.3
     */
	public function __construct(&$db)
	{
		parent::__construct('#__tgtlotreviews', 'id', $db);
	}

    /**
     * Prepares data before saving to database
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $array = data array
     * 			$ignore = unknown
     * @return  parent
     * @since   1.3
     */
	public function bind($array, $ignore = '')
	{
		return parent::bind($array, $ignore);
	}

    /**
     * Write data to database when saving form
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $updateNulls = boolean on whether or not to update nulls
     * @return  parent
     * @since   1.3
     */
	public function store($updateNulls = false)
	{
		return parent::store($updateNulls);
	}
}