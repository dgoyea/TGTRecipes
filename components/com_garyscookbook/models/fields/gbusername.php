<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('text');

// The class name must always be the same as the filename (in camel case)
class JFormFieldGbusername extends JFormField {

//The field class must know its own type through the variable $type.
protected $type = 'Gbusername';

public function getLabel() {
	// code that returns HTML that will be shown as the label
	// Initialize variables.
	$label = '';
	$replace = '';

	// Get the label text from the XML element, defaulting to the element name.
	$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];

	// Build the class for the label.
	$class = !empty($this->description) ? 'hasTip' : '';
	$class = $this->required == true ? $class.' required' : $class;

	// Add the opening label tag and main attributes attributes.
	$label .= '<label id="'.$this->id.'-lbl" for="'.$this->id.'" class="'.$class.'"';

	// If a description is specified, use it to build a tooltip.
	if (!empty($this->description)) {
		$label .= ' title="'.htmlspecialchars(trim(JText::_($text), ':').'::' .
				JText::_($this->description), ENT_COMPAT, 'UTF-8').'"';
	}

	// Add the label text and closing tag.
	$label .= '>'.$replace.JText::_($text).'</label>';
 	if ($this->required) {
 		$label .= '<span class="star">&#160;*</span>';
 	}
	return $label;


}

public function getInput() {
	// code that returns HTML that will be shown as the form field
	// Build the class for the input.
	$user		= JFactory::getUser();
	if ($user->name) {
		$this->value = $user->name;
		$readonly="readonly";
	}
	$class = "";
	$class = $this->required == true ? $class.' required' : $class;
return '<input type="text" id="'.$this->id.'" name="'.$this->name.'" value="' .$this->value .'" class="'. $class.'" size="'.$this->size.'" '. $readonly.' />';

}

}
?>