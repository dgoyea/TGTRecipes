<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('JPATH_BASE') or die;

/**
 * Supports a modal contact picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @since		1.6
 */
class JFormFieldModal_Recipes extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Recipes';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Load the javascript
		JHtml::_('behavior.framework');
		JHtml::_('behavior.modal', 'a.modal');

		// Build the script.
		$script = array();
		$script[] = '	function jSelectChart_'.$this->id.'(id, imgtitle, object) {';
		$script[] = '		document.id("'.$this->id.'_id").value = id;';
		$script[] = '		document.id("'.$this->id.'_name").value = imgtitle;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		// Get the title of the linked chart
		$db = JFactory::getDBO();
		$db->setQuery(
			'SELECT imgtitle' .
			' FROM #__garyscookbook' .
			' WHERE id = '.(int) $this->value
		);
		$title = $db->loadResult();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}

		if (empty($title)) {
			$title = JText::_('COM_GARYSCOOKBOOK_SELECT_A_RECIPE');
		}

		//$link = 'index.php?option=com_garyscookbook&amp;view=recipes&amp;layout=modal&amp;tmpl=component&amp;function=jSelectChart_'.$this->id;
		$html	= array();
		$link	= 'index.php?option=com_garyscookbook&amp;view=recipes&amp;layout=modal&amp;tmpl=component&amp;function=jSelectChart_' . $this->id;

		//$html = "\n".'<div class="fltlft"><input type="text" id="'.$this->id.'_name" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
		//$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('COM_GARYSCOOKBOOK_CHANGE_RECIPE_BUTTON').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('COM_GARYSCOOKBOOK_CHANGE_RECIPE_BUTTON').'</a></div></div>'."\n";

		// The current contact display field.
		$html[] = '<span class="input-append">';
		$html[] = '<input type="text" class="input-medium" id="' . $this->id . '_name" value="' . $title . '" disabled="disabled" size="35" />';
		$html[] = '<a class="modal btn hasTooltip" title="' . JHtml::tooltipText('COM_GARYSCOOKBOOK_CHANGE_RECIPE_BUTTON') . '"  href="' . $link . '&amp;' . JSession::getFormToken() . '=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> ' . JText::_('JSELECT') . '</a>';

		// The active contact id field.
		if (0 == (int)$this->value) {
			$value = '';
		} else {
			$value = (int)$this->value;
		}

		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}

		//$html .= '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->imgtitle.'" value="'.$value.'" />';

		//return $html;
		$html[] = '<input type="hidden" id="' . $this->id . '_id"' . $class . ' name="' . $this->name . '" value="' . $value . '" />';

		return implode("\n", $html);
	}
}
