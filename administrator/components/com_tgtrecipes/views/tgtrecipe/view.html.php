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
 * Tgtrecipe view class
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesViewTgtrecipe extends JViewLegacy
{
	 /**
     * Array to store data from the model
     *
     * @var    $item = array
     * @since  1.0
     */
	protected $item;
	
    /**
     * Used to build form
     *
     * @var    $form = Joomla form
     * @since  1.0
     */	
	protected $form;

	/**
	 * Function to display the view, called by default
	 *
	 *
	 * @package Joomla.administrator
	 * @subpackage com_tgtrecipes
	 *
	 * @param   $tpl = null
	 * @return  parent
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

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
	 * @since   1.0
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTRECIPE'), '');

		JToolbarHelper::save('tgtrecipe.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('tgtrecipe.cancel');
		}
		else
		{
			JToolbarHelper::cancel('tgtrecipe.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}