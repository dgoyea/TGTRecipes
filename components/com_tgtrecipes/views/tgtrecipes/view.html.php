<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * com_tgtrecipes controller
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.2
 */
 
class TgtrecipesViewTgtrecipes extends JViewLegacy
{
	protected $items;
	
	protected $state;
	
	protected $pagination;	

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');		

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
	}
	
	/**
	 * Sort Fields function to setup fields which can be sorted
	 *
	 *
	 * @package Joomla.administrator
	 * @subpackage com_tgtrecipes
	 *
	 *
	 * @param
	 * @return
	 * @since   1.0
	 */
	protected function getSortFields()
	{
		return array(
				'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
				'a.state' => JText::_('JSTATUS'),
				'a.title' => JText::_('JGLOBAL_TITLE'),
				'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}	
}