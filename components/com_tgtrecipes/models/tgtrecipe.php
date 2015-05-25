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
 * Model for individual recipe records
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.2
 */


class TgtrecipesModelTgtrecipe extends JModelItem
{
	protected $item;
	
	public function getItem()
	{
		$db = JFactory::getDbo();
		
		// Get recipe id from URL request
		$id = JRequest::getInt('id');
		
		// Create a new query object.
		$query = $db->getQuery(true);
		
		// Build array of table columns
		
		$columns = array('a.id', 'a.title', 'a.image', 'a.directions');
		for ($x = 1; $x < 26; $x++) {
			$ingredient = 'a.ingredient' . $x;
			$ingrqty = 'a.ingrqty' . $x;
			$ingrqtytype = 'a.ingrqtytype' . $x;
			
			array_push($columns, $ingredient, $ingrqty, $ingrqtytype);
		}
		
		//print_r($columns);
		

		$query
		//->select($db->quoteName(array('a.id', 'a.title', 'a.image', 'a.directions')))
		->select($db->quoteName($columns))
		->from($db->quoteName('#__tgtrecipes', 'a'))
		->where($db->quoteName('a.id'). '=' . $id);

		$db->setQuery($query);

		$results = $db->loadObject();		

		return $results;
		
	}
}
