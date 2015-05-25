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
 * Update TGT Recipe View
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.0
 */
class TgtrecipesViewUptgtrecipe extends JViewLegacy
{
	protected $item;

	protected $form;

	 /**
     * Update TGT Recipe function to display the view
     * 
     *
     * @package Joomla.administrator
     * @subpackage com_tgtrecipes
     *
     * @param   $tpl = the view
     * @return  
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

}