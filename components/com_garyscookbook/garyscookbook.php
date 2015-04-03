<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';
require_once( JPATH_COMPONENT . '/helpers/defines.php');

$controller = JControllerLegacy::getInstance('Garyscookbook');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
