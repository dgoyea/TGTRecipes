<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// garyscookbook defines

// No direct access.
defined('_JEXEC') or die;

//Component administrator definitions.

//Defines.
$app		= JFactory::getApplication();
$params		= $app->getParams();
$theme		= $params->get('theme_folder','theme0');
define('GCB_URI_CSS', JURI::root().'components/com_garyscookbook/themes/'.$theme.'/css/');
define('GCB_URI_IMAGES', JURI::root().'components/com_garyscookbook/themes/'.$theme.'/images/');
define('GCB_PATH_IMAGES', JPATH_BASE .'/components/com_garyscookbook/themes/'.$theme.'/images/');
define('GCB_URI_RECIPE_IMAGES',	JURI::root().'images/garyscookbook/');
define('GCB_PATH_RECIPE_IMAGES', JPATH_BASE . '/images/garyscookbook/');
define('GCB_URI_RECIPE_THUMBNAIL', JURI::root().'images/garyscookbook/thumbnail');
define('GCB_PATH_RECIPE_THUMBNAIL', JPATH_BASE . '/images/garyscookbook/thumbnail');
define('COM_GARYSCOOKBOOK_BASE',	JPATH_ROOT.'/'.$params->get($path, 'images'));

