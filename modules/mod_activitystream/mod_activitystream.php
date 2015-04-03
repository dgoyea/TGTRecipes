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

include_once(JPATH_BASE.'/components/com_community/defines.community.php');
require_once(JPATH_BASE .'/components/com_community/libraries/core.php');
include_once(COMMUNITY_COM_PATH.'/libraries/activities.php');
include_once(COMMUNITY_COM_PATH.'/helpers/time.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root(true).'/components/com_community/assets/modules/module.css');

$config	= CFactory::getConfig();
$js		= 'assets/script-1.2.min.js';
CFactory::attach($js, 'js');

$js     = 'assets/stream.js';
CFactory::attach($js, 'js');

$cwindow = '/assets/window-1.0.min.js';
CFactory::attach($cwindow, 'js');

$cwindowcss = '/assets/window.css';
CFactory::attach($cwindowcss, 'css');

$jVersion = new JVersion();
if (version_compare($jVersion->getShortVersion(), "2.5.999") <= 0) {
	$css = '/assets/bootstrap/css/bootstrap.min.css';
	CFactory::attach($css, 'css');
}

$js = '/assets/bootstrap/bootstrap.min.js';
CFactory::attach($js, 'js');

// Mobile browsers.
$isMobile = preg_match('/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i', $_SERVER['HTTP_USER_AGENT']);
$isIOS = preg_match('/iphone|ipad|ipod/i', $_SERVER['HTTP_USER_AGENT']);

// Rendering issue on iOS browser: http://stackoverflow.com/questions/6890149/remove-3-pixels-in-ios-webkit-textarea
if ( $isIOS ) {
    $css = '<style type="text/css">.textntags-wrapper textarea { left: -3px !important; width: 102% !important; }</style>';
    $document->addCustomTag($css);
}

// Fluid video on small screen.
$css = '<style type="text/css">video { width: 100% !important; height: auto !important; }</style>';
$document->addCustomTag($css);

$js  = '<script>';
$js .= 'joms || (joms = {});';
$js .= 'joms.constants || (joms.constants = {});';
$js .= 'joms.constants.uid = "' . CFactory::getUser()->id . '";';
$js .= 'joms.constants.settings || (joms.constants.settings = {});';
$js .= 'joms.constants.settings.isGroup = 0;';
$js .= 'joms.constants.settings.isEvent = 0;';
$js .= 'joms.language || (joms.language = {});';
$js .= 'joms.language.saving = "' . addslashes( JText::_("COM_COMMUNITY_SAVING") ) . '";';
$js .= 'joms.language.yes = "' . addslashes( JText::_("COM_COMMUNITY_YES") ) . '";';
$js .= 'joms.language.no = "' . addslashes( JText::_("COM_COMMUNITY_NO") ) . '";';
$js .= 'joms.language.stream || (joms.language.stream = {});';
$js .= 'joms.language.stream.remove_comment = "' . addslashes( JText::_("COM_COMMUNITY_COMMENT_REMOVE") ) . '";';
$js .= 'joms.language.stream.remove_comment_message = "' . addslashes( JText::_("COM_COMMUNITY_COMMENT_REMOVE_MESSAGE") ) . '";';
$js .= '</script>';
$document->addCustomTag($js);

// Application configuration.
$js = '<script>' . PHP_EOL;
$js .= 'joms_assets_url = "' . JURI::root(true) . '/components/com_community/assets/_release/js/";' . PHP_EOL;
$js .= '</script>' . PHP_EOL;
$document->addCustomTag($js);

$js = '/assets/_release/js/loader.js';
CFactory::attach($js, 'js');

$activities = new CActivityStream();
$maxEntry = $params->get('max_entry', 10);

$stream = $activities->getHTML('', '', null, $maxEntry, '' );

require( JModuleHelper::getLayoutPath('mod_activitystream') );
