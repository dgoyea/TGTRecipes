<?php

/**
 * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
 * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author iJoomla.com <webmaster@ijoomla.com>
 * @url https://www.jomsocial.com/license-agreement
 * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
 * More info at https://www.jomsocial.com/license-agreement
 */
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_BASE . '/components/com_community/defines.community.php');
require_once(JPATH_BASE . '/components/com_community/libraries/core.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root(true) . '/components/com_community/assets/modules/module.css');

$default = $params->get('default');

$model = CFactory::getModel('Events');
/* Follow component */

$mainframe = JFactory::getApplication();
$jinput = $mainframe->input;

$categoryId = JRequest::getInt('categoryid', 0);
$category = JTable::getInstance('EventCategory', 'CTable');
$category->load($categoryId);

$sorted = $jinput->get->get('sort', 'startdate', 'STRING'); //JRequest::getVar( 'sort' , 'startdate' , 'GET' );
$eventparent = $jinput->get->get('parent', '', 'INT');

$event = JTable::getInstance('Event', 'CTable');
$handler = CEventHelper::getHandler($event);

$categories = $model->getAllCategories();
$categoryIds = CCategoryHelper::getCategoryChilds($categories, $category->id);

$result = $model->getEvents($categoryIds, null, $sorted, null, true, false, null, array('parent' => $eventparent), $handler->getContentTypes(), 0 ,$default);
//$result = $model->getEvents(null, null, null, null, true, false, null, null, CEventHelper::ALL_TYPES, 0, $default);
$events = array();

foreach ($result as $row) {
    $event = JTable::getInstance('Event', 'CTable');
    $event->bind($row);
    $events[] = $event;
}

require( JModuleHelper::getLayoutPath('mod_community_events') );
