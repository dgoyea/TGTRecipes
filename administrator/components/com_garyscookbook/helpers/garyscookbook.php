<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Contact component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		if ($vName !='about') {
			if(JVERSION>=3.0)
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES_CP'),
					'index.php?option=com_garyscookbook&view=gcbcp',
					$vName == 'gcbcp'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES'),
					'index.php?option=com_garyscookbook&view=recipes',
					$vName == 'recipes'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_CATEGORIES'),
					'index.php?option=com_categories&extension=com_garyscookbook',
					$vName == 'categories'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_COMMENTS'),
					'index.php?option=com_garyscookbook&view=comments',
					$vName == 'comments'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_MM'),
					'index.php?option=com_garyscookbook&view=gcbimpmm',
					$vName == 'importmm'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_ONE_RECIPE'),
					'index.php?option=com_garyscookbook&view=gcbimpor',
					$vName == 'gcbimpor'
					);
				JHtmlSidebar::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_LANGUAGES'),
					'index.php?option=com_garyscookbook&view=languages',
					$vName == 'language'
					);
				if ($vName=='categories') {
					JToolBarHelper::title(
						JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_garyscookbook')),
						'recipe-categories');
				}

			} else {
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES_CP'),
					'index.php?option=com_garyscookbook&view=gcbcp',
					$vName == 'gcbcp'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES'),
					'index.php?option=com_garyscookbook&view=recipes',
					$vName == 'recipes'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_CATEGORIES'),
					'index.php?option=com_categories&extension=com_garyscookbook',
					$vName == 'categories'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_COMMENTS'),
					'index.php?option=com_garyscookbook&view=comments',
					$vName == 'comments'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_MM'),
					'index.php?option=com_garyscookbook&view=gcbimpmm',
					$vName == 'importmm'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_ONE_RECIPE'),
					'index.php?option=com_garyscookbook&view=gcbimpor',
					$vName == 'gcbimpor'
				);
				JSubMenuHelper::addEntry(
					JText::_('COM_GARYSCOOKBOOK_SUBMENU_LANGUAGES'),
					'index.php?option=com_garyscookbook&view=languages',
					$vName == 'language'
					);
				if ($vName=='categories') {
					JToolBarHelper::title(
						JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_garyscookbook')),
						'recipe-categories');
				}

			}
		}
		if ( $vName =='about') {
			JSubMenuHelper::addEntry(
				JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES_CP'),
				'index.php?option=com_garyscookbook&view=gcbcp',
				$vName == 'gcbcp'
			);
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @param	int		The recipe ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0, $recipeId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($recipeId) && empty($categoryId)) {
			$assetName = 'com_garyscookbook';
		}
		elseif (empty($recipeId)) {
			$assetName = 'com_garyscookbook.category.'.(int) $categoryId;
		}
		else {
			$assetName = 'com_garyscookbook.recipe.'.(int) $recipeId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * resize_image()
	 * Resize Pictures
	 *
	 * @param mixed $src_file
	 * @param mixed $dest_file
	 * @param mixed $new_size
	 * @param mixed $method
	 * @param mixed $dest_qual
	 * @return
	 */
	public function resize_image($src_file, $dest_file, $new_size, $method, $dest_qual)
	{

		$imagetype = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF');
		//echo $src_file;
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) die("ERROR: Source file not found!");

		$imginfo[2] = $imagetype[$imginfo[2]];
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 'JPG' && $imginfo[2] != 'PNG' && $imginfo[2] != 'GIF' && ($method == 'gd1' || $method == 'gd2')) die("ERROR: GD can only handle JPG and PNG files!");
		// height/width
		$srcWidth = $imginfo[0];
		$srcHeight = $imginfo[1];

		//echo "Creating thumbnail from $imginfo[2], $imginfo[0] x $imginfo[1]...<br>";

		$ratio = max($srcWidth, $srcHeight) / $new_size;
		$ratio = max($ratio, 1.0);
		$destWidth = (int)($srcWidth / $ratio);
		$destHeight = (int)($srcHeight / $ratio);
		// Method for thumbnails creation
		switch ($method) {
			case "gd1" :
				if (!function_exists('imagecreatefromjpeg')) {
					die('GD image library not installed!');
				}
				if ($imginfo[2] == 'JPG')
					$src_img = imagecreatefromjpeg($src_file);
				else if ($imginfo[2] == 'PNG')
					$src_img = imagecreatefrompng($src_file);
				else
					$src_img = imagecreatefromgif($src_file);
				if (!$src_img) {
					$ERROR = $lang_errors['invalid_image'];
					return false;
				}
				$dst_img = imagecreate($destWidth, $destHeight);
				imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
				imagejpeg($dst_img, $dest_file, $dest_qual);
				imagedestroy($src_img);
				imagedestroy($dst_img);
				break;

			case "gd2" :

				if (!function_exists('imagecreatefromjpeg')) {
					die('GD image library not installed!');
				}
				if (!function_exists('imagecreatetruecolor')) {
					die('GD2 image library does not support truecolor thumbnailing!');
				}
				if ($imginfo[2] == 'JPG') {
					$src_img = imagecreatefromjpeg($src_file);
				} else if ($imginfo[2] == 'PNG') {
					$src_img = imagecreatefrompng($src_file);
				} else {
					$src_img = imagecreatefromgif($src_file);
				}
				if (!$src_img) {
					$ERROR = $lang_errors['invalid_image'];
					return false;
				}
				$dst_img = imagecreatetruecolor($destWidth, $destHeight);
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
				imagejpeg($dst_img, $dest_file, $dest_qual);
				imagedestroy($src_img);
				imagedestroy($dst_img);
				break;
		}
		// Set mode of uploaded picture
		chmod($dest_file, octdec('755'));
		// We check that the image is valid
		$imginfo = getimagesize($dest_file);

		if ($imginfo == null) {
			return false;
		} else {
			return true;
		}
	}


}
