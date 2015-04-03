<?php
defined('_JEXEC') or die;

class TgtrecipesController extends JControllerLegacy
{
	protected $default_view = 'tgtrecipes';

	// The display function is the first default function that is called if no specific 
	// task is executed for the component.

	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/tgtrecipes.php';

		$view   = $this->input->get('view', 'tgtrecipes');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');

		if ($view == 'tgtrecipes' && $layout == 'edit' && !$this->checkEditId('com_tgtrecipes.edit.tgtrecipes', $id))
		{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_tgtrecipes&view=tgtrecipes', false));

			return false;
		}

		parent::display();

		return $this;
	}
}