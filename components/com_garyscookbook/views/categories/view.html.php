<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Content categories view.
 *
 * @package		Joomla.Site
 * @subpackage	com_garyscookbook
 * @since 1.6
 */
class garyscookbookViewcategories extends JViewLegacy
{
	protected $state = null;
	protected $item = null;
	protected $items = null;
	protected $pagination = null;

	/**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$params		= $app->getParams();

		// Initialise variables
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$parent		= $this->get('Parent');
		$lang = JFactory::getLanguage();
		$LanguageTag = $lang->getTag();
		// CHECK LANGUAGE
		if ( file_exists( GCB_PATH_IMAGES . $LanguageTag . ".nopicture.jpg" ) ) {
			$nopic = GCB_URI_IMAGES .$LanguageTag . ".nopicture.jpg";
		} else {
			$nopic = GCB_URI_IMAGES .'nopicture.jpg';
		}
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		if ($items === false) {
			return JError::raiseError(404, JText::_('J_GLOBAL_CATEGORY_NOT_FOUND'));

		}

		if ($parent == false) {
			return JError::raiseError(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}
		// Prepare the data.
		// Compute the Garyscookbook slug.
		for ($i = 0, $n = count($items); $i < $n; $i++)
		{
			$item		= &$items[$i];
			$temp		= new JRegistry();
			$temp->loadString($item->params);
			$item->params = clone($params);
			$item->params->merge($temp);

			if ($item->params->get('image', 0)) {
				$item->image = trim($item->params->get('image', 0));
			}
		}

		$items = array($parent->id => $items);
		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->assign('maxLevelcat',	$params->get('maxLevelcat', -1));
		$this->assignRef('params',		$params);
		$this->assignRef('parent',		$parent);
		$this->assignRef('items',		$items);
		$this->assignRef('nopic', 		$nopic);
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->def('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_CONTACT_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);
		$this->document->addStyleSheet(GCB_URI_CSS.'gcb.css');
		//Weiche für IE 7
		$browser = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match("/MSIE 7.0/", $browser )) {
			$this->document->addStyleSheet(GCB_URI_CSS.'gcbIE7.css');
		}

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
