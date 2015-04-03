<?php
defined('_JEXEC') or die;

class com_TgtrecipesInstallerScript
{
	function install($parent)
	{
		$parent->getParent()->setRedirectURL('index.php?option=com_tgtrecipes');
	}

	function uninstall($parent)
	{
		echo '<p>' . JText::_('COM_TGTRECIPES_UNINSTALL_TEXT') . '</p>';
	}

	function update($parent)
	{
		echo '<p>' . JText::_('COM_TGTRECIPES_UPDATE_TEXT') . '</p>';
	}

	function preflight($type, $parent)
	{
		echo '<p>' . JText::_('COM_TGTRECIPES_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	function postflight($type, $parent)
	{
		echo '<p>' . JText::_('COM_TGTRECIPES_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}