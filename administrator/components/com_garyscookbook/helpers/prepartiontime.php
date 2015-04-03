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

$selist2org[] = JText::_('COM_GARYSCOOKBOOK_5_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_10_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_15_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_20_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_25_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_30_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_45_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_1_HOUR');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_1_HOUR_15_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_1_HOUR_30_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_1_HOUR_45_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_2_HOURS');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_2_HOURS_30_MIN');
$selist2org[] = JText::_('COM_GARYSCOOKBOOK_>_2.5_HOURS');

$selist2[] = JHTML::_('select.option', 1, $selist2org[0]);
$selist2[] = JHTML::_('select.option', 2, $selist2org[1]);
$selist2[] = JHTML::_('select.option', 3, $selist2org[2]);
$selist2[] = JHTML::_('select.option', 4, $selist2org[3]);
$selist2[] = JHTML::_('select.option', 5, $selist2org[4]);
$selist2[] = JHTML::_('select.option', 6, $selist2org[5]);
$selist2[] = JHTML::_('select.option', 7, $selist2org[6]);
$selist2[] = JHTML::_('select.option', 8, $selist2org[7]);
$selist2[] = JHTML::_('select.option', 9, $selist2org[8]);
$selist2[] = JHTML::_('select.option', 10, $selist2org[9]);
$selist2[] = JHTML::_('select.option', 11, $selist2org[10]);
$selist2[] = JHTML::_('select.option', 12, $selist2org[11]);
$selist2[] = JHTML::_('select.option', 13, $selist2org[12]);
$selist2[] = JHTML::_('select.option', 14, $selist2org[13]);
?>