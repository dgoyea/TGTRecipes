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
 * Helper for component to check permissions
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesHelper
{

    /**
     * See what permissions current user has
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   categoryId = Current category to check agaisnt
     * @return  $result = JObject
     * @since   1.0
     */	
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId))
		{
			$assetName = 'com_tgtrecipes';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_tgtrecipes.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_tgtrecipes', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}