<?php
/**
 * @package		Garyscookbook.Administrator
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2012 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */


defined('_JEXEC') or die('Restricted access');

class com_garyscookbookInstallerScript {

	function install($parent) {
		// $parent is the class calling this method
		if ( !JFolder::copy( JPATH_SITE."/components/com_garyscookbook/garyscookbook", JPATH_SITE."/images/garyscookbook" ) ) {
			JError::raiseWarning( 1, JText::sprintf( 'JLIB_INSTALLER_ERROR_CREATE_DIRECTORY', JPATH_SITE."/images/garyscookbook" ) );
			return false;
		}
		$parent->getParent()->setRedirectURL('index.php?option=com_garyscookbook');
	}

	function update($parent) {
	// $parent is the class calling this method
	if (!JFolder::exists(JPATH_SITE."/images/garyscookbook")) {
		if ( !JFolder::copy( JPATH_SITE."/components/com_garyscookbook/garyscookbook", JPATH_SITE."/images/garyscookbook" ) ) {
			JError::raiseWarning( 1, JText::sprintf( 'JLIB_INSTALLER_ERROR_CREATE_DIRECTORY', JPATH_SITE."/images/garyscookbook" ) );
			return false;
		}
	}
	$parent->getParent()->setRedirectURL('index.php?option=com_garyscookbook');
}
	function uninstall($parent) {
		echo '<p>Please note that the /images/garyscookbook/ folder was not deleted. </p>';
	}

}
