<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// beJ! bejhead used for images and text in Parametersettings

defined('JPATH_BASE') or die;
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldGcbUploadfile extends JFormField
{
	protected $type = 'GcbUploadfile';

	protected function getInput() {

	$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
	$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
	$size	= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : ' size="80"';
	$required = ((int) $this->element['required']) ? (string) $this->element['required'] : '80';


		$html = '<div style="valign:top;width:100%">';
//		$html .= '<input  type="file" name="importfile" id="formfile"  size = "80" class="inputbox required" value=""/>';

		$html .= '<input  type="file" name="'.$this->name.'" id="'.$this->id.'"'.$size.' class="inputbox required" value=""/>';
		$html .= '</div';
	return $html;
	}


}
?>