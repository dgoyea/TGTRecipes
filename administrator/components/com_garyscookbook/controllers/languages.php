<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
// languages Controller
defined('_JEXEC') or die('Restricted access');

class GaryscookbookControllerLanguages extends JControllerLegacy {

	public function __construct($config = array()) {

		parent::__construct($config);

		$this->registerTask( 'duplicate', 'duplicate' );
	}


	/**
	 * Call to languagefile copy
	 */
	function duplicate() {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languagec&extension=com_garyscookbook', false));

		return ;
	}
}