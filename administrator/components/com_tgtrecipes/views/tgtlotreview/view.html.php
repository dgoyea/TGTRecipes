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
 * @since       1.3
 */
class TgtrecipesViewTgtlotreview extends JViewLegacy
{
	 /**
     * Array to store data from the model
     *
     * @var    $item = array
     * @since  1.3
     */
	protected $item;
	
    /**
     * Used to build form
     *
     * @var    $form = Joomla form
     * @since  1.3
     */	
	protected $form;

	/**
	 * Function to display the view, called by default
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
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->setTgtData();
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
		JFactory::getApplication()->input->set('hidemainmenu', true);

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTLOTREVIEW'), '');

		JToolbarHelper::save('tgtlotreview.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('tgtlotreview.cancel');
		}
		else
		{
			JToolbarHelper::cancel('tgtlotreview.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	
    /**
     * Clean up data for Lot Review form
     * 
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   n/a
     * @return  n/a
     * @since   1.3
     */
	protected function setTgtData()
	{
		error_log('TgtrecipesViewTgtlotreview.setTgtData');
		
		$venueid = $this->form->getValue('venueid');
		if ($venueid != 1 or $venueid = null ) 
		{
			error_log('getting in here');
			error_log('venueid = ' . $venueid);
			
			$venuename = $this->form->getValue('venuename', null, null);
			error_log('venuename = ' . $venuename);
			
			// This is a workaround to set the venuename back to the venueid. Otherwise the sql field used in 
			// the view.xml seems to default to the first value found in the DB after the first time a review is created.
			$this->form->setValue('venuename',null,$venueid);
		}
	}
}