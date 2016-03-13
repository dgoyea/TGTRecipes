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
	
	 /**
     * Add Submenu function
     * Adds link to the categories submenu to create categories for TGT Recipes
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $vName = name of component
     * @return  n/a
     * @since   1.3.3
     */
	public static function addSubmenu($vName = 'tgtrecipes')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_TGTRECIPES_SUBMENU_RECIPES'),
			'index.php?option=com_tgtrecipes&view=tgtrecipes',
			$vName == 'tgtrecipes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_TGTRECIPES_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_tgtrecipes',
			$vName == 'categories'
		);
		if ($vName == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_tgtrecipes')),
				'tgtrecipes-categories');
		}
		JHtmlSidebar::addEntry(
			JText::_('COM_TGTRECIPES_SUBMENU_PREVIEW'),
			'index.php?option=com_tgtrecipes&view=preview',
			$vName == 'preview'
		);
	}
}