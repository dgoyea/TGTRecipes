<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 */
abstract class JHtmlGaryscookbook
{
	/**
	 * @param	int $value	The featured value
	 * @param	int $i
	 * @param	bool $canChange Whether the value can be changed or not
	 *
	 * @return	string	The anchor tag to toggle featured/unfeatured recipes.
	 * @since	1.6
	 */
	static function featured($value = 0, $i, $canChange = true)
	{
		// Array of image, task, title, action
		$states	= array(
			0	=> array('disabled.png', 'recipes.featured', 'COM_GARYSCOOKBOOK_UNFEATURED', 'COM_GARYSCOOKBOOK_TOGGLE_TO_FEATURE'),
			1	=> array('featured.png', 'recipes.unfeatured', 'JFEATURED', 'COM_GARYSCOOKBOOK_TOGGLE_TO_UNFEATURE'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image', 'admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'
					. $html .'</a>';
		}

		return $html;
	}
}
