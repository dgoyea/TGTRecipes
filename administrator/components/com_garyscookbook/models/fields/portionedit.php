<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class JFormFieldPortionEdit extends JFormFieldList
{
	/**
	 * A flexible category list that respects access controls
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'PortionEdit';

	/**
	 * Method to get a list of categories that respects access controls and can be used for
	 * either category assignment or parent category assignment in edit screens.
	 * Use the parent element to indicate that the field will be used for assigning parent categories.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		require_once(JPATH_ADMINISTRATOR . "/components/com_garyscookbook/helpers/portion.php");
		// Initialise variables.
		$options = array();
		$options = $selist;
		$statopt = new stdClass();
		// Filter on the published state
		$statopt->text =  JText::_('COM_GARYSCOOKBOOK_SELECT_PORTION');
		$statopt->level= "0";
		$statopt->published = "1";
		$statopt->value = "0";
		array_unshift($options,$statopt);
		return $options;
	}
}
