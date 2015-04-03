<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die;

class JFormRuleContactEmailSubject extends JFormRule
{
	public function test(& $element, $value, $group = null, & $input = null, & $form = null)
	{
		$params = JComponentHelper::getParams('com_garyscookbook');
		$banned = $params->get('banned_subject');

		foreach(explode(';', $banned) as $item){
			if (JString::stristr($item, $value) !== false)
					return false;
		}

		return true;
	}
}
