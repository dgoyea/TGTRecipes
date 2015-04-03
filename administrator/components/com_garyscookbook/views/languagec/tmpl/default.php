<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
// language copy
defined('_JEXEC') or die('Restricted Access');

	JHTML::_('behavior.tooltip');

$output ='';

$output .='<div style="color:green;background-color:white;" class="hasTip" title="'.JText::_('COM_GARYSCOOKBOOK_LANG_COPY_INFORMATION').'::'.JText::_('COM_GARYSCOOKBOOK_LANG_COPY_INFORMATION_TEXT').'">';
$output .= JHTML::_('image', 'administrator/components/com_garyscookbook/assets/images/32-info.png', 'info' );
$output .= '</div>';

	$output .= '<div>';
	$output .= '<form action="'.JRoute::_('index.php?option=com_garyscookbook&view=languagec').'" method="post" name="adminForm" id="adminForm">';
	$output .= '<fieldset class="adminform" style="width:98%;">';

$output.= '<div class="adminformlist">';
$output.= '<div>'.$this->form->getLabel('langfrom').$this->form->getInput('langfrom').'</div>';
$output.= '<div>'.$this->form->getLabel('langto').$this->form->getInput('langto').'</div>';
$output.= '<div>'.$this->form->getLabel('override').$this->form->getInput('override').'</div>';
$output.= '</div>';
$output.= '</fieldset>';
$output.= '</div>';

	$output .= '<input type="hidden" name="task" value="" />';
	$output .= '<input type="hidden" name="extension" value="com_garyscookbook" />';
	$output .= JHTML::_( 'form.token' );
	$output .= '</fieldset></form></div>';
echo $output;
?>