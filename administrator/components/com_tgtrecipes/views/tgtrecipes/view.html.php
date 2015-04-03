<?php
defined('_JEXEC') or die;

class TgtRecipesViewTgtrecipes extends JViewLegacy
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		$canDo	= TgtrecipesHelper::getActions();
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTRECIPES'), '');

		JToolbarHelper::addNew('tgtrecipe.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('tgtrecipe.edit');
		}
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_tgtrecipes');
		}
	}
}