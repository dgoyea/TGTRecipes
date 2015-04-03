<?php
defined('_JEXEC') or die;

class TgtrecipesHelper
{
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId))
		{
			$assetName = 'com_tgtrecipes';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_tgtrecipes.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_tgtrecipes', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}