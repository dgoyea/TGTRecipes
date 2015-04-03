<?php
defined('_JEXEC') or die;

class TgtrecipesViewTgtrecipe extends JViewLegacy
{
	protected $item;

	protected $form;

	public function display($tpl = null)
	{
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

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
		JFactory::getApplication()->input->set('hidemainmenu', true);

		JToolbarHelper::title(JText::_('COM_TGTRECIPES_MANAGER_TGTRECIPE'), '');

		JToolbarHelper::save('tgtrecipe.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('tgtrecipe.cancel');
		}
		else
		{
			JToolbarHelper::cancel('tgtrecipe.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}