<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a generic list of options.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldGcbLanguage extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'GcbLanguage';
	protected static $all = false;
	protected static $alltranslate = false;


	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$attr = '';
		self::$all = false ;
		self::$alltranslate = false ;

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		if ((string) $this->element['all']) {
			self::$all = true;
		}
		if ((string) $this->element['alltranslate'] ) {
			self::$alltranslate = true;
		}
		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
		}
		// Create a regular list.
		else
		{
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return implode($html);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		foreach ($this->element->children() as $option)
		{

			// Only add <option /> elements.
			if ($option->getName() != 'option')
			{
				continue;
			}

			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_(
				'select.option', (string) $option['value'],
				JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
				((string) $option['disabled'] == 'true')
			);

			// Set some option attributes.
			$tmp->class = (string) $option['class'];

			// Set some JavaScript option attributes.
			$tmp->onclick = (string) $option['onclick'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		$languages = (array) $this->getLanguages( self::$all, self::$alltranslate);

		$options = array_merge($options,$languages);

		return $options;
	}

	protected function getLanguages( $all = false, $alltranslate = false) {

	// Get the database object and a new query object.
	$db		= JFactory::getDBO();
	$query	= $db->getQuery(true);

	// Build the query.
	$query->select('a.lang_code AS value, CONCAT_WS(\' / \',a.title_native , a.lang_code) AS text');
	$query->from('#__languages AS a');
	$query->where('a.published >= 0');
	$query->order('a.title_native');

	// Set the query and load the options.
	$db->setQuery($query);
	$languages = $db->loadObjectList();

/* to do: add attributes to options
	$options = array();

		foreach ($languages as $key => $option)
		{

			// Create a new option object
			$tmp = JHtml::_(
				'select.option', (string) $option->value,
				JText::alt(trim((string) $option->text), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
				((string) $option->disabled == 'true')
			);

			// Set some option attributes.
			$tmp->class = (string) $this->element[''] ;


			// Set some JavaScript option attributes.
			$tmp->onclick = (string) $option->onclick;

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

*/

		if ($all)
		{
			array_unshift($options, new JObject(array('value' => '*', 'text' => $alltranslate ? JText::alt('JALL', 'language') : 'JALL_LANGUAGE')));
		}

	// Detect errors
	if ($db->getErrorNum())
	{
		JError::raiseWarning(500, $db->getErrorMsg());
	}

return $languages;

}
}
