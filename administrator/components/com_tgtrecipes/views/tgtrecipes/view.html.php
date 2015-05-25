<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * TgtRecipes view for com_tgtrecipes controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtRecipesViewTgtrecipes extends JViewLegacy
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		$canDo	= TgtrecipesHelper::getActions();
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTRECIPES'), '');

		JToolbarHelper::addNew('tgtrecipe.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('tgtrecipe.edit');
		}
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_tgtrecipes');
		}
	}
}