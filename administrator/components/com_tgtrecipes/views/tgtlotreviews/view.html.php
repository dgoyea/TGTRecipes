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
 * Tgtlotreviews view for com_tgtrecipes controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.3
 */
class TgtRecipesViewTgtlotreviews extends JViewLegacy
{
	
    /**
     * Array of data retrieved from model
     *
     * @var    array
     * @since  1.3
     */	
	protected $items;

    /**
     * Function to display the view, called by default
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $tpl = null
     * @return  parent
     * @since   1.3
     */
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

    /**
     * Adds buttons to the top of the view
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   n/a
     * @return  n/a
     * @since   1.3
     */
	protected function addToolbar()
	{
		$canDo	= TgtrecipesHelper::getActions();
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTRECIPES'), '');

		JToolbarHelper::addNew('tgtlotreview.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('tgtlotreview.edit');
		}
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_tgtrecipes');
		}
	}
}