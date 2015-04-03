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

$selist1org[] = JText::_('COM_GARYSCOOKBOOK_VERY_EASY');
$selist1org[] = JText::_('COM_GARYSCOOKBOOK_EASY');
$selist1org[] = JText::_('COM_GARYSCOOKBOOK_MODERATE');
$selist1org[] = JText::_('COM_GARYSCOOKBOOK_DIFFICULT');
$selist1org[] = JText::_('COM_GARYSCOOKBOOK_VERY_DIFFICULT');

$selist1[] = JHTML::_('select.option', 0, $selist1org[0]);
$selist1[] = JHTML::_('select.option', 1, $selist1org[1]);
$selist1[] = JHTML::_('select.option', 2, $selist1org[2]);
$selist1[] = JHTML::_('select.option', 3, $selist1org[3]);
$selist1[] = JHTML::_('select.option', 4, $selist1org[4]);
?>