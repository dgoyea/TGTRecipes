<?php
defined('_JEXEC') or die;

class TgtrecipesModelTgtrecipe extends JModelAdmin
{
	protected $text_prefix = 'COM_TGTRECIPES';

	public function getTable($type = 'Tgtrecipe', $prefix = 'tgtrecipesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		$form = $this->loadForm('com_tgtrecipes.tgtrecipe', 'tgtrecipe', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_tgtrecipes.edit.tgtrecipe.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	protected function prepareTable($table)
	{
		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
	}
}