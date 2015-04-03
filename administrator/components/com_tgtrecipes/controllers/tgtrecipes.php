<?php
defined('_JEXEC') or die;

class TgtrecipesControllerTgtrecipes extends JControllerAdmin
{
	public function getModel($name = 'Tgtrecipe', $prefix = 'TgtrecipesModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}