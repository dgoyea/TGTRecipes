<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// beJ! Extension Help
defined('_JEXEC') or die;

 class Bejaccess {

	public function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
//		$assetName = JApplicationHelper::getComponentName();
//To do - add canCheckin to global setting
// 	$canCheckin	= $user->authorise('core.manage','com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete', 'custom.view'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, BEJCOMPONENT));
		}

		return $result;
	}
}