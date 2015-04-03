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
jimport( 'joomla.environment.uri' );
require_once JPATH_COMPONENT.'/models/category.php';
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR. 'ingredients.php');
/**
 * HTML Contact View class for the Contact component
 *
 * @package		Joomla.Site
 * @subpackage	com_garyscookbook
 * @since 		1.5
 */
class GaryscookbookViewRecipe extends JViewLegacy
{
	protected $state;
	protected $form;
	protected $item;
	protected $return_page;

	function display($tpl = null)
	{

		$lang = JFactory::getLanguage();
		$LanguageTag = $lang->getTag();
		// CHECK LANGUAGE
		if ( file_exists( GCB_PATH_IMAGES . $LanguageTag . ".nopicture.jpg" ) ) {
			$nopic = GCB_URI_IMAGES .$LanguageTag . ".nopicture.jpg";
		} else {
			$nopic = GCB_URI_IMAGES .'nopicture.jpg';
		}
		// Initialise variables.
		$app			= JFactory::getApplication();
		$user			= JFactory::getUser();
		$state			= $this->get('State');
		$item			= $this->get('Item');
		$this->print	= JRequest::getBool('print');
		$this->form		= $this->get('Form');
		JPluginHelper::importPlugin( 'content' );


		// Get the parameters
		$params = JComponentHelper::getParams('com_garyscookbook');

		if ($item) {
			// If we found an item, merge the item parameters
			$params->merge($item->params);

			// Get Category Model data
			$categoryModel = JModelLegacy::getInstance('Category', 'GaryscookbookModel', array('ignore_request' => true));
			$categoryModel->setState('category.id', $item->catid);
			$categoryModel->setState('list.ordering', 'a.imgtitle');
			$categoryModel->setState('list.direction', 'asc');
			$categoryModel->setState('filter.published', 1);

			$garyscookbooks = $categoryModel->getItems();

		}

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors ));

			return false;
		}

		// check if access is not public
		$groups	= $user->getAuthorisedViewLevels();

		$return = '';

		if ((!in_array($item->access, $groups)) || (!in_array($item->category_access, $groups))) {
			$uri		= JFactory::getURI();
			$return		= (string)$uri;

			JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return;
		}

		$options['category_id']	= $item->catid;
		$options['order by']	= 'a.default_con DESC, a.ordering ASC';
		JHtml::_('behavior.formvalidation');

		// Increment the hit counter of the recipe.
		$model = $this->getModel();
		$model->hit($item->id);
		// Add links to contacts
		if ($params->get('show_garyscookbook_list') && count($garyscookbooks) > 1) {
			foreach($garyscookbooks as &$garyscookbook)
			{
				$garyscookbook->link = JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid));
			}
			$item->link = JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid));
		}
		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));
		//preperationtime
		if($params->get('show_years')) :
			require_once(JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR. 'prepartiontime.php');
		endif;
		if($params->get('show_aging')) :
			require_once(JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR. 'difficult.php');
		endif;

		$this->assignRef('selist1org', 		$selist1org);
		$this->assignRef('selist2org', 		$selist2org);
		$this->assignRef('garyscookbook',	$item);
		$this->assignRef('params',			$params);
		$this->assignRef('return',			$return);
		$this->assignRef('state', 			$state);
		$this->assignRef('item', 			$item);
		$this->assignRef('user', 			$user);
		$this->assignRef('nopic', 			$nopic);
		$this->assignRef('garyscookbooks', 	$garyscookbooks);
		$this->assignRef('igfield', 		$igfield);

		// Override the layout only if this is not the active menu item
		// If it is the active menu item, then the view and item id will match
		$active	= $app->getMenu()->getActive();
		if ((!$active) || ((strpos($active->link, 'view=recipe') === false) || (strpos($active->link, '&id=' . (string) $this->item->id) === false))) {
			if ($layout = $params->get('garyscookbook_layout')) {
				$this->setLayout($layout);
			}
		}
		elseif (isset($active->query['layout'])) {
			// We need to set the layout in case this is an alternative menu item (with an alternative layout)
			$this->setLayout($active->query['layout']);
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$dispatcher = JDispatcher::getInstance();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$_params =array();
		$title 		= null;


		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else {
			$this->params->def('page_heading', JText::_('COM_GARYSCOOKBOOK_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		$id = (int) @$menu->query['id'];

		// if the menu item does not concern this garyscookbook
		if ($menu && ($menu->query['option'] != 'com_garyscookbook' || $menu->query['view'] != 'garyscookbook' || $id != $this->item->id))
		{

			// If this is not a single garyscookbook menu item, set the page title to the garyscookbook title
			if ($this->item->imgtitle > "") {
				$title = $this->item->imgtitle;
			}
			$path = array(array('title' => $this->garyscookbook->imgtitle, 'link' => ''));
			$category = JCategories::getInstance('Garyscookbook')->get($this->garyscookbook->catid);

			while ($category && ($menu->query['option'] != 'com_garyscookbook' || $menu->query['view'] == 'recipe' || $id != $category->id) && $category->id > 1)
			{
				$path[] = array('title' => $category->title, 'link' => GaryscookbookHelperRoute::getCategoryRoute($this->garyscookbook->catid));
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach($path as $item)
			{
				$pathway->addItem($item['title'], $item['link']);
			}
		}

		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		if (empty($title)) {
			$title = $this->item->imgtitle;
		}
		$this->document->setTitle($title);
		$this->document->addStyleSheet(GCB_URI_CSS.'gcb.css');
		//Weiche für IE 7
		$browser = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match("/MSIE 7.0/", $browser )) {
			$this->document->addStyleSheet(GCB_URI_CSS.'gcbIE7.css');
		}
		$this->document->addScript(JURI::base(True) ."/components/com_garyscookbook/assets/scripts/". "gcbvote.js");


/*
//shadowbox
		$headers[$headertype]=1;
		$this->document->addScript( JURI::base(True) .'/components/com_garyscookbook/assets/shadowbox/shadowbox.js' );
		$this->document->addStyleSheet( JURI::base(True) .'/components/com_garyscookbook/assets/shadowbox/shadowbox.css', "text/css", "screen" );
		$this->document->addScriptDeclaration( 'window.onload=function(){
var b = document.getElementsByTagName("head");
var body = b[b.length-1] ;
script2 = document.createElement("script");
script2.type = "text/javascript";
script2.charset="utf-8";
var tt = "Shadowbox.init( {  animate:	           '.$this->params->get('shadowbox_animate', '1').' ,animateFade:           '.$this->params->get('shadowbox_animateFade', '1').' ,animSequence:        \"'.$this->params->get('shadowbox_animSequence', 'sync').'\"  ,autoplayMovies:	       '.$this->params->get('shadowbox_autoplayMovies', '1').'  ,continuous:	           '.$this->params->get('shadowbox_continuous', '0').'  ,counterLimit:	      '.$this->params->get('shadowbox_counterLimit', '10').' ,counterType:	      \"'.$this->params->get('shadowbox_counterType', 'default').'\"    ,displayCounter:	       '.$this->params->get('shadowbox_displayCounter', '1').'  ,displayNav:	          '.$this->params->get('shadowbox_displayNav', '1').' ,enableKeys:	           '.$this->params->get('shadowbox_enableKeys', '1').'  ,fadeDuration:          '.$this->params->get('shadowbox_fadeDuration', '0.35').' ,flashVersion:	      \"'.$this->params->get('shadowbox_flashVersion', '9.0.0').'\"  ,handleOversize:	      \"'.$this->params->get('shadowbox_handleOversize', 'resize').'\"  ,handleUnsupported:	 \"'.$this->params->get('shadowbox_handleUnsupported', 'link').'\"  ,initialHeight:	       '.$this->params->get('shadowbox_initialHeight','160').' ,initialWidth:	       '.$this->params->get('shadowbox_initialWidth', '320').' ,modal:	               '.$this->params->get('shadowbox_modal', '0').'  ,overlayColor:	      \"'.$this->params->get('shadowbox_overlayColor','#000').'\"  ,overlayOpacity:	       '.$this->params->get('shadowbox_overlayOpacity', '0.5').'  ,resizeDuration:	       '.$this->params->get('shadowbox_resizeDuration', '0.35').'  ,showOverlay:	      '.$this->params->get('shadowbox_showOverlay', '1').' ,showMovieControls:	   '.$this->params->get('shadowbox_showMovieControls', '1').' ,slideshowDelay:	      '.$this->params->get('shadowbox_slideshowDelay', '0').' ,viewportPadding:	   '.$this->params->get('shadowbox_viewportPadding', '20').' ,flashVars: {'.$this->params->get('shadowbox_flashVars','').'}    } );"
if (navigator.appName == "Microsoft Internet Explorer") {
	script2.text = tt;
} else {
	script2.appendChild( document.createTextNode(tt) );
}
body.appendChild(script2);
}' );

*/




		if ($this->item->metadesc)
		{
			$this->document->setDescription($this->item->metadesc);
		}
		elseif (!$this->item->metadesc && $this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->item->metakey)
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
		elseif (!$this->item->metakey && $this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}

		$mdata = $this->item->metadata->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v) {
				$this->document->setMetadata($k, $v);
			}
		}
	}
}
