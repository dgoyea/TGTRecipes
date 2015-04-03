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

jimport('joomla.application.component.view');

/**
 * View class for a list of recipes.
 *
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class GaryscookbookViewGcbcp extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $buttons = array();
	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		if (strlen($this->items[0]->manifest_cache)) {
			$data = json_decode($this->items[0]->manifest_cache);
			if ($data) {
				foreach($data as $key => $value) {
					if ($key == 'type') {
						// ignore the type field
						continue;
					}
					$this->items[0]->$key = $value;
				}
			}
		}

		$this->document->addStyleSheet(JURI::base().'components/com_garyscookbook/assets/css/gcb.css');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->buttons = array(
			array(
					'link' => JRoute::_('index.php?option=com_categories&extension=com_garyscookbook'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/icon-48-category.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_CATEGORIES'),
					'access' => array('core.manage', 'com_garyscookbook')
				),
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=recipes'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-gcbrecipes.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_RECIPES'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=comments'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-gcbcomments.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_COMMENTS'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=languages'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-language.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_LANGUAGES'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),

			array(
					'link' => (file_exists(JPATH_COMPONENT .'/views/gcbimpmm')? JRoute::_('index.php?option=com_garyscookbook&view=gcbimpmm'):JRoute::_('index.php?option=com_garyscookbook')),
					'image' => (file_exists(JPATH_COMPONENT .'/views/gcbimpmm')?JURI::base().'components/com_garyscookbook/assets/images/48-gcbimportMM.png' : JURI::base().'components/com_garyscookbook/assets/images/48-onlypro.png'),
					'text' => (file_exists(JPATH_COMPONENT .'/views/gcbimpmm')? JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_MM'): JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_MM_ONLY_PRO')),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),

			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=gcbimprecipes'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-imprecipes15.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORTRECIPES'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),
			// Import Rezept - Neu
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=gcbimpor'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/icon-48-extension.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_IMPORT_ONE_RECIPE'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=catchange'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-catchange.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_CATCHANGE'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				),
			array(
					'link' => JRoute::_('index.php?option=com_garyscookbook&view=about'),
					'image' => JURI::base().'components/com_garyscookbook/assets/images/48-info.png',
					'text' => JText::_('COM_GARYSCOOKBOOK_SUBMENU_ABOUT'),
					'access' => array('core.manage', 'com_garyscookbook', 'core.create', 'com_garyscookbook', )
				)
			);

		//<a class="modal" href="http://localhost/gkb_2_5/administrator/index.php?option=com_config&amp;view=component&amp;component=com_garyscookbook&amp;path=&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
		$this->addToolbar();
		//GaryscookbookHelper::addSubmenu('gcbcp');
		if(JVERSION>=3.0) {
			$this->sidebar = JHtmlSidebar::render();
			parent::display('3');
		} else {
			parent::display($tpl);
		}

	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/garyscookbook.php';
		$canDo	= GaryscookbookHelper::getActions($this->state->get('filter.category_id'));
		$user	= JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_CP'), 'gcbrecipes.png');
		$this->document->setTitle(JText::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_CP'));

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_garyscookbook');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('JHELP_COMPONENTS_RECIPES_RECIPES');
	}
}
