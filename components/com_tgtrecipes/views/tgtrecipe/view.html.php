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
 * com_tgtrecipes view
 *
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 * @since       1.2
 */
 
class TgtrecipesViewTgtrecipe extends JViewLegacy
{
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
	}
}