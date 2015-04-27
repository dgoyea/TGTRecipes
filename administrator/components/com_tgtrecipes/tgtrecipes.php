<?php
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_tgtrecipes'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$document = JFactory::getDocument();
$cssFile = "/media/com_tgtrecipes/css/site.stylesheet.css";
$document->addStyleSheet($cssFile);

$controller	= JControllerLegacy::getInstance('Tgtrecipes');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();