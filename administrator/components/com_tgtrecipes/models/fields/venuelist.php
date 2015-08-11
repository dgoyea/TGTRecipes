<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

/**
 * Custom Joomla Form Field to support venuelist in the form
 *
 * @package     Joomla.Administrator
 * @subpackage  com_tgtrecipes
 * @since       1.3
 */
class JFormFieldVenueList extends JFormField {

	//The field class must know its own type through the variable $type.
	protected $type = 'VenueList';

	public function getLabel() {
		// code that returns HTML that will be shown as the label
	}

	public function getInput() {
		// code that returns HTML that will be shown as the form field
	}
}