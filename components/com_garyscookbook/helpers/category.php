<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Garyscookbook Component Category Tree
 *
 * @static
 * @package		Garyscookbook.Site
 * @subpackage	com_Garyscookbook
 * @since 2.5
 */
class GaryscookbookCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__garyscookbook';
		$options['extension'] = 'com_garyscookbook';
		$options['statefield'] = 'published';
		parent::__construct($options);
	}
	public static function picpath($pictureorg){
			if (strpos($pictureorg,"/")==False) {
				//Picture without path
				if (file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . "images" .DIRECTORY_SEPARATOR . "garyscookbook" . DIRECTORY_SEPARATOR . $pictureorg)) {
					$picture = JURI::root() ."images/garyscookbook/" . $pictureorg;
				} else {
					$picture = JURI::base() ."components/com_garyscookbook/assets/images/nopicture.jpg";
				}
			} else {
				if (file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . $pictureorg)) {
					$picture = JURI::root() . $pictureorg;
				} else {
					$picture = JURI::base() ."components/com_garyscookbook/assets/images/nopicture.jpg";
				}
			}
		return $picture;
	}
}
