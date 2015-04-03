<?php
/**
 * @package		Joomla.Cli
 *
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Joomla 3.2 example CLI script
 * Written by: Nikolay Todorov, nikolay.t [at] siteground.com
 * 05-feb-2014
 * Put this script in the /cli folder in the root of your Joomla 3.2 website
*/
 
// Set flag that this is a parent file.
const _JEXEC = 1;
 
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);
 
// Load system defines
if (file_exists(dirname(__DIR__) . '/defines.php'))
{
	require_once dirname(__DIR__) . '/defines.php';
}
 
if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(__DIR__));
	require_once JPATH_BASE . '/includes/defines.php';
}
 
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
 
/**
 * @package  Joomla.CLI
 * @since    3.0
 */
class Manifest extends JApplicationCli
{
	/**
	 * Entry point for CLI script
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function doExecute()
	{

	// Database connector
	$db = JFactory::getDBO();

        // Attempt to update the table #__schema.
        $pathPart = JPATH_ADMINISTRATOR . '/components/com_admin/sql/updates/mysql/';

	$this->out("$pathPart");
		
        $files = JFolder::files($pathPart, '\.sql$');

        $version = '';

        foreach ($files as $file)
        {
            if (version_compare($version, JFile::stripExt($file)) < 0)
            {
                $version = JFile::stripExt($file);
            }
        }

	$this->out("Version: $version");

        $query = $db->getQuery(true)
            ->insert($db->quoteName('#__schemas'))
            ->columns(
                array(
                    $db->quoteName('extension_id'),
                    $db->quoteName('version_id')
                )
            )
            ->values('700, ' . $db->quote($version));
        $db->setQuery($query);
	$db->execute();

	// Attempt to refresh manifest caches
	$query->clear()
		->select('*')
		->from('#__extensions');

	$db->setQuery($query);

	$extensions = $db->loadObjectList();

	JFactory::$database = $db;
	$installer = JInstaller::getInstance();

	foreach ($extensions as $extension)
	{
		//$this->out("Manifest update for: $extension->name");
		$installer->refreshManifestCache($extension->extension_id);
	}

	}
}
 
JApplicationCli::getInstance('Manifest')->execute();

