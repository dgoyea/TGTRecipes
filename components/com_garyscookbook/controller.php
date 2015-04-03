<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */


// Garyscookbook Controller Frontend
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class GaryscookbookController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	2.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Get the document object.
		$document = JFactory::getDocument();

		// Set the default view name and format from the Request.
		$id			= JRequest::getInt('w_id');
		$rid		= JRequest::getInt('r_id');
		$vName		= JRequest::getCmd('view', 'categories');
		$layout		= JRequest::getCmd('layout');

		if ($rid>0 || $layout=="edit"){
			$vName ='editrecipe';
		}
		JRequest::setVar('view', $vName);
//
		$user = JFactory::getUser();

		$safeurlparams = array('catid'=>'INT','id'=>'INT','cid'=>'ARRAY','year'=>'INT','month'=>'INT','limit'=>'INT','limitstart'=>'INT',
		'showall'=>'INT','return'=>'BASE64','filter'=>'STRING','filter_order'=>'CMD','filter_order_Dir'=>'CMD','filter-search'=>'STRING','print'=>'BOOLEAN','lang'=>'CMD');
		// Check for edit form.
		if ($vName == 'recipe' && !$this->checkEditId('com_garyscookbook.edit.comment', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
		}
		if ($vName == 'editrecipe' && !$this->checkEditId('com_garyscookbook.edit.editrecipe', $rid)) {
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $rid));
		}
		parent::display($cachable,$safeurlparams);
		return $this;
	}


}