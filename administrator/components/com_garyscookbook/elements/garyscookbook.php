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

/**
 * Renders a recipe element
 *
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */
class JElementRecipe extends JElement
{
	/**
	 * Element name
	 *
	 * @var		string
	 */
	var	$_name = 'Recipe';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$app		= JFactory::getApplication();
		$db			= JFactory::getDbo();
		$doc		= JFactory::getDocument();
		$template	= $app->getTemplate();
		$fieldName	= $control_name.'['.$name.']';
		$recipe	= JTable::getInstance('recipe');
		if ($value) {
			$recipe->load($value);
		} else {
			$recipe->title = JText::_('COM_CONTENT_SELECT_A_RECIPE');
		}
				$js = "
		function jSelectContact(id, name, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = name;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);
		$link = 'index.php?option=com_garyscookbook&amp;task=element&amp;tmpl=component&amp;object='.$name;

		JHtml::_('behavior.modal', 'a.modal');
		$html = "\n".'<div class="fltlft"><input type="text" id="'.$name.'_name" value="'.htmlspecialchars($recipe->imgtitle, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
//		$html .= "\n &#160; <input class=\"inputbox modal-button\" type=\"button\" value=\"".JText::_('JSELECT')."\" />";
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('COM_CONTENT_SELECT_A_RECIPE').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('JSELECT').'</a></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.(int)$value.'" />';

		return $html;
	}
}
