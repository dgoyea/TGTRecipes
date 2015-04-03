<?php
/**
 * @package     Garyscookbook
 * @subpackage  com_garyscookbook
 * @copyright   Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube, Merling. All rights reserved.
 * @license             GNU General Public License version 2 or later;
 */

defined('JPATH_PLATFORM') or die;

/**
 * Category Feed View class for Garyscookbook 
 *
 * @package     Garyscookbook
 * @subpackage  com_garyscookbook
 * @since       3.2
 */
class GaryscookbookViewCategory extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @since   3.2
	 */
	public function display($tpl = null)
	{
		$app      = JFactory::getApplication();
		$document = JFactory::getDocument();

		$extension      = $app->input->getString('option');
		$contentType = $extension . '.' . $this->viewName;

		$ucmType = new JUcmType;
		$ucmRow = $ucmType->getTypeByAlias($contentType);
		$ucmMapCommon = json_decode($ucmRow->field_mappings)->common;
		$createdField = null;
		$titleField = null;

		if (is_object($ucmMapCommon))
		{
			$createdField = $ucmMapCommon->core_created_time;
			$titleField = $ucmMapCommon->core_title;
		}
		elseif (is_array($ucmMapCommon))
		{
			$createdField = $ucmMapCommon[0]->core_created_time;
			$titleField = $ucmMapCommon[0]->core_title;
		}

		$document->link = JRoute::_(JHelperRoute::getCategoryRoute($app->input->getInt('id'), $language = 0, $extension));

		$app->input->set('limit', $app->get('feed_limit'));
		$siteEmail        = $app->get('mailfrom');
		$fromName         = $app->get('fromname');
		$feedEmail        = $app->get('feed_email', 'author');
		$document->editor = $fromName;

		if ($feedEmail != 'none')
		{
			$document->editorEmail = $siteEmail;
		}

		// Get some data from the model
		$items    = $this->get('Items');
		$category = $this->get('Category');

		foreach ($items as $item)
		{
			$this->reconcileNames($item);

			// Strip html from feed item title
			if ($titleField)
			{
				$title = $this->escape($item->$titleField);
				$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
			}
			else
			{
				$title = '';
			}

			// URL link to article
			$router = new JHelperRoute;
			$link   = JRoute::_('index.php?option=com_garyscookbook&view=recipe&id=' . $item->id, false);

			// Strip HTML from feed item description text.
			$description = $this->escape($item->imgtext);
			$description = html_entity_decode($description, ENT_COMPAT, 'UTF-8');


// Check whether Multithumb is availble, enabled and option "Multithumb use" in com_garyscookbook is selected
                        $db = JFactory::getDbo();
                        $db->setQuery("SELECT enabled FROM #__extensions WHERE name = 'multithumb'");
                        $is_enabled = $db->loadResult();
// Then parse if value for show_lightbox is set to 1. This signals "Multithumb use" from com_garyscookbook options
                        $app = JFactory::getApplication('site');
                        $componentParams = $app->getParams('com_garyscookbook');
                        $show_lightbox = $componentParams->get('show_lightbox', defaultValue);

                        if ( $is_enabled && $show_lightbox ) {
                                $picture_path = JHTML::_('content.prepare', "{multithumb resize=1 caption_pos=disabled thumb_width=100}" . 
                                     JHTML::_('image', JURI::base() . $item->imgfilename, '', ''), '', 'com_garyscookbook.recipe');              
                                $description = $picture_path . $description;
                        } else { 
                                $description = '<a href=' . $link . '><img style="float:left; width:100px;" src="' . JURI::base() . $item->imgfilename . '"></a>' . $description;
                        }

			$author      = $item->created_by_alias;

			if ($createdField)
			{
				$date = isset($item->$createdField) ? date('r', strtotime($item->$createdField)) : '';
			}
			else
			{
				$date = '';
			}

			// Load individual item creator class.
			$feeditem              = new JFeedItem;
			$feeditem->title       = $item->imgtitle;
			$feeditem->link        = $link;
			$feeditem->description = $description;
			$feeditem->date        = $date;
			$feeditem->category    = $category->title;
			$feeditem->author      = $author;

			// We don't have the author email so we have to use site in both cases.
			if ($feedEmail == 'site')
			{
				$feeditem->authorEmail = $siteEmail;
			}
			elseif ($feedEmail === 'author')
			{
				$feeditem->authorEmail = $item->author_email;
			}

			// Loads item information into RSS array
			$document->addItem($feeditem);
		}
	}

	/**
	 * Method to reconcile non standard names from components to usage in this class.
	 * Typically overriden in the component feed view class.
	 *
	 * @param   object  $item  The item for a feed, an element of the $items array.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	protected function reconcileNames($item)
	{
		if (!property_exists($item, 'title') && property_exists($item, 'imgtitle'))
		{
			$item->title = $item->imgtitle;
		}
	}
}
