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
 * Controller for update TGT Recipe
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesControllerUpTgtrecipe extends JControllerForm
{
	
	 /**
     * Allow Add function to check permissions to allow adds to TGT Recipes
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = array
     * @return  $allow
     * @since   1.0
     */
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();
		$categoryId = JArrayHelper::getValue($data, 'catid', $this->input->getInt('filter_category_id'), 'int');
		$allow = null;
	
		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = $user->authorise('core.create', $this->option . '.category.' . $categoryId);
		}
	
		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd($data);
		}
		else
		{
			return $allow;
		}
	}

	 /**
     * Allow Edit function to check permissions to allow edits to TGT Recipees
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $data = array
     * 			$key = key to be used for record being checked
     * @return  JFactory::getUser()->authorise()
     * @since   1.0
     */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;
	
		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}
	
		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}
}