<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Garyscookbook Component HTML Helper
 *
 * @static
 * @package		Joomla.Garyscookbook
 * @subpackage	com_garyscookbook
 * @since 1.5
 */
class JHtmlIcon
{

	static function email($garyscookbook, $params, $attribs = array())
	{
		require_once JPATH_SITE . '/components/com_mailto/helpers/mailto.php';
		$uri	= JURI::getInstance();
		$base	= $uri->toString(array('scheme', 'host', 'port'));
		$link	= $base.JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid) , false);
		$url	= 'index.php?option=com_mailto&tmpl=component&link='.MailToHelper::addLink($link);

		$status = 'width=400,height=350,menubar=yes,resizable=yes';

		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-mail.png', JText::_("COM_GARYSCOOKBOOK_RECIPE_MAIL"), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_("COM_GARYSCOOKBOOK_RECIPE_MAIL") .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-mail.png', JText::_("COM_GARYSCOOKBOOK_RECIPE_MAIL"), 'class="gcbicon"', true). '&#160;'. JText::_("COM_GARYSCOOKBOOK_RECIPE_MAIL");
		}


		$attribs['title']	= JText::_('COM_GARYSCOOKBOOK_RECIPE_MAIL');
		$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";

		$output = JHtml::_('link', JRoute::_($url), $text, $attribs);
		return $output;
	}

	static function share_facebook($garyscookbook, $params, $attribs = array()){
		$link       = JURI::getInstance();
		$link       = $link->toString();

		//https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.vb-dozent.net%2F&t=Home
		$url = "http://www.facebook.com/sharer.php?u=" . $link ."&amp;t=" . $garyscookbook->imgtitle." title=\"" . JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook")  ;
		$status = 'width=400,height=350,menubar=yes,resizable=yes';
		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . 'facebook.png', JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook"), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook") .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . 'facebook.png', JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook"), 'class="gcbicon"', true). '&#160;'. JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook");
		}
		$attribs['title']	= JText::sprintf("COM_GARYSCOOKBOOK_GCB_FACEBOOKBUTTON_SUBMIT", "Facebook");
		$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$attribs['rel']		= 'nofollow';
		$attribs['class']	= 'gcbicon';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);

	}

	static function print_popup($garyscookbook, $params, $attribs = array())
	{
		$url  = GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid);
		$url .= '&tmpl=component&print=1&layout=print&newportion='.$params->get('newportion').'&page='.@ $request->limitstart;

		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-print.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_PRINT'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_PRINT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-print.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_PRINT'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_PRINT');
		}

		$attribs['title']	= JText::_('JGLOBAL_PRINT');
		$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$attribs['rel']		= 'nofollow';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	static function favorit($garyscookbook, $params, $attribs = array())
	{
		//ToDo noch nicht eingebaut Favoriten.
		$url  = GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid);
		$url .= '&task=recipe.addmyrecipe&recid='. $garyscookbook->id;

		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbfavourites.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_MYFAVORIT'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_MYFAVORIT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbfavourites.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_MYFAVORIT'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_MYFAVORIT');
		}

		$attribs['title']	= JText::_('COM_GARYSCOOKBOOK_RECIPE_MYFAVORIT');
		$attribs['rel']		= 'nofollow';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	static function isfavorit($garyscookbook, $params, $attribs = array())
	{
		//ToDo noch nicht eingebaut Favoriten.
		$url  = GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid);
		$url .= '&task=recipe.delmyrecipe&recid='. $garyscookbook->id;

		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbisfavourites.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_ISMYFAVORIT'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_ISMYFAVORIT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbisfavourites.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_ISMYFAVORIT'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_ISMYFAVORIT');
		}

		$attribs['title']	= JText::_('COM_GARYSCOOKBOOK_RECIPE_ISMYFAVORIT');
		$attribs['rel']		= 'nofollow';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	static function export($garyscookbook, $params, $attribs = array())
	{
		//ToDo noch nicht eingebaut Export.
		$url  = GaryscookbookHelperRoute::getGaryscookbookRoute($garyscookbook->slug, $garyscookbook->catid);
		$url .= '&task=recipe.exportrecipe&recid='. $garyscookbook->id;

		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbexport.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_EXPORT'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_EXPORT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . '24-gcbexport.png', JText::_('COM_GARYSCOOKBOOK_RECIPE_EXPORT'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_EXPORT');
		}

		$attribs['title']	= JText::_('COM_GARYSCOOKBOOK_RECIPE_EXPORT');
		$attribs['rel']		= 'nofollow';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	static function edit($garyscookbook, $params, $attribs = array())
	{
		$user = JFactory::getUser();
		$uri = JFactory::getURI();

		if ($params && $params->get('popup')) {
			return;
		}

		if ($garyscookbook->published < 0) {
			return;
		}

		JHtml::_('behavior.tooltip');
		$icon	= $garyscookbook->published ? '24-edit.png' : 'edit_unpublished.png';
		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . $icon, JText::_('COM_GARYSCOOKBOOK_RECIPE_EDIT'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_EDIT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . $icon, JText::_('COM_GARYSCOOKBOOK_RECIPE_EDIT'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_EDIT');
		}

		$url	= GaryscookbookHelperRoute::getFormRoute($garyscookbook->id, base64_encode($uri));

		if ($garyscookbook->published == 0) {
			$overlib = JText::_('JUNPUBLISHED');
		}
		else {
			$overlib = JText::_('JPUBLISHED');
		}

		$date = JHtml::_('date', $garyscookbook->created);
		$author = $garyscookbook->created_by_alias ? $garyscookbook->created_by_alias : $garyscookbook->imgauthor;

		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

		$button = JHtml::_('link', JRoute::_($url), $text);

		$output = '<span class="hasTip" title="'.JText::_('COM_GARYSCOOKBOOK_RECIPE_EDIT').' :: '.$overlib.'">'.$button.'</span>';
		//only Pro Version
		if (file_exists(JPATH_COMPONENT_SITE . "/views/editrecipe/")){
			return $output;
		}
		return '';
	}

	static function add($garyscookbook, $params, $attribs = array())
	{
		$user = JFactory::getUser();
		$uri = JFactory::getURI();

		if ($params && $params->get('popup')) {
			return;
		}

		JHtml::_('behavior.tooltip');
		$icon	= '24-add.png';
		if ($params->get('show_icons')==1) {
			$text = JHtml::_('image', GCB_URI_IMAGES . $icon, JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD'), 'class="gcbicon"', true);
		} elseif ($params->get('show_icons')==0)  {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		} else {
			$text = JHtml::_('image', GCB_URI_IMAGES . $icon, JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD'), 'class="gcbicon"', true). '&#160;'. JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD');
		}

		$url	= GaryscookbookHelperRoute::getFormRoute(false, base64_encode($uri));
		$button = JHtml::_('link', JRoute::_($url), $text);

		$output = '<span class="hasTip" title="'.JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD').' :: '.JText::_('COM_GARYSCOOKBOOK_RECIPE_ADD_DESC').'">'.$button.'</span>';
		//only Pro Version
		if (file_exists(JPATH_COMPONENT_SITE . "/views/editrecipe/")){
			return $output;
		}
		return '';
	}

	static function print_screen($garyscookbook, $params, $attribs = array())
	{
		// checks template image directory for image, if non found default are loaded
		if ($params->get('show_icons')) {
			$text = JHtml::_('image',  GCB_URI_IMAGES . '24-print.png', JText::_('JGLOBAL_PRINT'), NULL, true);
		} else {
			$text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JGLOBAL_PRINT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
		}
		return '<a href="#" onclick="window.print();return false;">'.$text.'</a>';
	}

}
