<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Bej Languages Model

defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class GaryscookbookModelLanguages extends JModelList
{
	function getfiles()
	{
		$component	= JApplicationHelper::getComponentName();
		$lang = JFactory::getLanguage();
		$frontendlanguage = $lang->getTag();

		jimport('joomla.language.helper');
		$languages	= JLanguageHelper::getLanguages();
		$i = 0;
		foreach($languages as $i => &$language) {
			$i ++;

//admin
			if (file_exists(JPATH_ADMINISTRATOR . '/language/' . $language->lang_code .  '/' . $language->lang_code .'.'. $component.'.ini')) {
				$langlist[$language->lang_code]["filenamebe"] = JPATH_ADMINISTRATOR . '/language/' . $language->lang_code .  '/' .$language->lang_code .'.'. $component.'.ini';
				$langlist[$language->lang_code]["be"] = $language->lang_code .'.'. $component.'.ini';
			}
//admin_sys
			if (file_exists(JPATH_ADMINISTRATOR . '/language/' . $language->lang_code .  '/' . $language->lang_code .'.'. $component.'.sys.ini')) {
				$langlist[$language->lang_code]["filenamebesys"] = JPATH_ADMINISTRATOR .  '/language/' . $language->lang_code .  '/' . $language->lang_code .'.'. $component.'.sys.ini';
				$langlist[$language->lang_code]["besys"] = $language->lang_code .'.'. $component.'.sys.ini';
			}
//admin_override
			if (file_exists(JPATH_ADMINISTRATOR .  '/language/overrides/' . $language->lang_code .'.override.ini')) {
				$langlist[$language->lang_code]["filenamebeover"] = JPATH_ADMINISTRATOR .  '/language/overrides/' . $language->lang_code .'.override.ini';
				$langlist[$language->lang_code]["beover"] = $language->lang_code .'.override.ini';
			}
//site
			if (file_exists(JPATH_SITE .  '/language/'. $language->lang_code .  '/' . $language->lang_code .'.'. $component.'.ini')) {
				$langlist[$language->lang_code]["filenamefe"] = JPATH_SITE .  '/language/' . $language->lang_code .  '/' . $language->lang_code .'.'. $component.'.ini';
				$langlist[$language->lang_code]["fe"] = $language->lang_code .'.'. $component.'.ini';
//site_override
				if (file_exists(JPATH_SITE . '/language/overrides/' . $language->lang_code .'.override.ini')) {
					$langlist[$language->lang_code]["filenamefeover"] = JPATH_SITE . '/language/' . 'overrides'.  '/' .$language->lang_code .'.override.ini';
					$langlist[$language->lang_code]["feover"] = $language->lang_code .'.override.ini';
				}

			}
		}

	return $langlist;

	}
}