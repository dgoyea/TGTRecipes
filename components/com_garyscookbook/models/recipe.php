<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');
jimport('joomla.plugin.helper');
/**
 * @package		Joomla.Site
 * @subpackage	com_garyscookbook
 * @since 1.5
 */
class GaryscookbookModelRecipe extends JModelForm
{
	/**
	 * @since	1.6
	 */
	protected $view_item = 'recipe';

	protected $_item = null;

	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_garyscookbook.recipe';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = JRequest::getInt('id');
		$this->setState('garyscookbook.id', $pk);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$user = JFactory::getUser();
		if ((!$user->authorise('core.edit.state', 'com_garyscookbook')) &&  (!$user->authorise('core.edit', 'com_garyscookbook'))){
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}
	}

	/**
	 * Method to get the garyscookbook form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 *
	 *
	 * @param	array	$data		An optional array of data for the form to interrogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_garyscookbook.recipe', 'recipe', array('control' => 'jform', 'load_data' => true));
		if (empty($form)) {
			return false;
		}

		$id = $this->getState('garyscookbook.id');
		$params = $this->getState('params');
		$garyscookbook = $this->_item[$id];
		$params->merge($garyscookbook->params);

		if(!$params->get('show_email_copy', 0)){
			$form->removeField('contact_email_copy');
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_garyscookbook.recipe.data', array());
		return $data;
	}

	/**
	 * Gets a list of contacts
	 * @param array
	 * @return mixed Object or null
	 */
	public function &getItem($pk = null)
	{
		//neu
		require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR. 'helpers'.DIRECTORY_SEPARATOR. 'ingredients.php');
		// aus C:\xampp\htdocs\4010\components\com_garyscookbook\views\recipe

		$dispatcher	= JDispatcher::getInstance();
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('garyscookbook.id');

		if ($this->_item === null) {
			$this->_item = array();
		}

		if (!isset($this->_item[$pk])) {
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);

				$query->select($this->getState('item.select', 'a.*') . ','
				. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
				. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END AS catslug ');
				$query->from('#__garyscookbook AS a');

				// Join on category table.
				$query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access');
				$query->join('LEFT', '#__categories AS c on c.id = a.catid');


				// Join over the categories to get parent category titles
				$query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias');
				$query->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');

				$query->where('a.id = ' . (int) $pk);

				// Filter by start and end dates.
				$nullDate = $db->Quote($db->getNullDate());
				$nowDate = $db->Quote(JFactory::getDate()->toSql());


				// Filter by published state.
				$published = $this->getState('filter.published');
				$archived = $this->getState('filter.archived');
				if (is_numeric($published)) {
					$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
					$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
				}
				$db->setQuery($query);

				$data = $db->loadObject();

				$NewPortion = JRequest::getInt('newportion');
				 $showPortion = $data->portion;
				// Generate Ingredients list
				if ($data->portion != $NewPortion) :
					if ($NewPortion == 0) :
						$NewPortion = $data->portion;
					else:
						$showPortion = $NewPortion;
					endif;

				else :
					$showPortion = $data->portion;
				endif;
				if ($NewPortion == 1 ) :
					$Portbez = JText::_( 'Port' );
				else:
					$Portbez = JText::_( 'Portion' );
				endif;

				if (  $data->ingredients  ) {
					$Itemid = JRequest::getInt('Itemid');
					$print	= JRequest::getBool('print');
					// Execute Plugins  move to above ? to be tested
					$data->text = showAttributeX($data->ingredients, $data->portion, $NewPortion, $data->id, $Itemid, $print,$data->catid );
					JPluginHelper::importPlugin( 'content' );
					$results = $dispatcher->trigger( 'onPrepareContent', array( &$data, &$params, 0 ) );
					//		$C_Grapes = $this->garyscookbook->->text;
					//$igfield = $data->ingredients;
					$igfield = '<div class="gcbDivider"></div>'."\n";
					$igfield .= '<div id="gcbIngredientsl">';
					$igfield .= $data->text;
					$igfield .= '</div>'."\n";
					$data->ingf =$igfield;
				}
				//$results = $dispatcher->trigger( 'onPrepareContent', array( &$item, &$title ) );


				if ($error = $db->getErrorMsg()) {
					throw new JException($error);
				}
				//hier Fehler
				if (empty($data)) {
					throw new JException(JText::_('COM_GARYSCOOKBOOK_ERROR_GARYSCOOKBOOK_NOT_FOUND') , 404);
				}

				// Check for published state if filter set.
				if (((is_numeric($published)) || (is_numeric($archived))) && (($data->published != $published) && ($data->published != $archived)))
				{
					JError::raiseError(404, JText::_('COM_GARYSCOOKBOOK_ERROR_GARYSCOOKBOOK_NOT_FOUND'));
				}

				// Convert parameter fields to objects.
				$registry = new JRegistry;
				$registry->loadString($data->params);
				$data->params = clone $this->getState('params');
				$data->params->merge($registry);

				$registry = new JRegistry;
				$registry->loadString($data->metadata);
				$data->metadata = $registry;

				// Compute access permissions.
				if ($access = $this->getState('filter.access')) {
					// If the access filter has been set, we already know this user can view.
					$data->params->set('access-view', true);
				}
				else {
					// If no access filter is set, the layout takes some responsibility for display of limited information.
					$user = JFactory::getUser();
					$groups = $user->getAuthorisedViewLevels();

					if ($data->catid == 0 || $data->category_access === null) {
						$data->params->set('access-view', in_array($data->access, $groups));
					}
					else {
						$data->params->set('access-view', in_array($data->access, $groups) && in_array($data->category_access, $groups));
					}
				}
				// Technically guest could edit an article, but lets not check that to improve performance a little.
				if (!$user->get('guest')) {
					$userId	= $user->get('id');
					$asset	= 'com_garyscookbook.recipe.'.$data->id;

					// Check general edit permission first.
					if ($user->authorise('core.edit', $asset)) {
						$data->params->set('access-edit', true);
					}
					// Now check if edit.own is available.
					elseif (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
						// Check for a valid user and that they are the owner.
						if ($userId == $data->created_by) {
							$data->params->set('access-edit', true);
						}
					}
				}

				$this->_item[$pk] = $data;
			}
			catch (JException $e)
			{
				$this->setError($e);
				$this->_item[$pk] = false;
			}

		}
		if ($this->_item[$pk])
		{
			if ($extendedData = $this->getGaryscookbookQuery($pk)) {
				$this->_item[$pk]->comments = $extendedData->comments;
				$this->_item[$pk]->myfavorites = $extendedData->myfavorites;
				$this->_item[$pk]->profile = $extendedData->profile;
			}
		}
  		return $this->_item[$pk];

	}

	/**
	 * Increment the hit counter for the recipe.
	 *
	 * @param	int		Optional primary key of the recipe to increment.
	 *
	 * @return	boolean	True if successful; false otherwise and internal error set.
	 */
	public function hit($pk = 0)
	{
		$hitcount = JRequest::getInt('hitcount', 1);

		if ($hitcount)
		{
			// Initialise variables.
			$pk = (!empty($pk)) ? $pk : (int) $this->getState('recipe.id');
			$db = $this->getDbo();

			$db->setQuery(
			        'UPDATE #__garyscookbook' .
			        ' SET imgcounter = imgcounter + 1' .
			        ' WHERE id = '.(int) $pk
			);

			if (!$db->query()) {
				$this->setError($db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	/**
	 * GaryscookbookModelRecipe::getGaryscookbookQuery()
	 *
	 * @param mixed $pk
	 * @return
	 */
	protected function getGaryscookbookQuery($pk = null)
	{
		// TODO: Cache on the fingerprint of the arguments
		$db		= $this->getDbo();
		$user	= JFactory::getUser();
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('garyscookbook.id');

		$query	= $db->getQuery(true);
		if ($pk) {
			$query->select('a.*, cc.access as category_access, cc.title as category_name, '
			. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
			. ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END AS catslug ');

			$query->from('#__garyscookbook AS a');

			$query->join('INNER', '#__categories AS cc on cc.id = a.catid');

			$query->where('a.id = ' . (int) $pk);
			$published = $this->getState('filter.published');
			$archived = $this->getState('filter.archived');
			if (is_numeric($published)) {
				$query->where('a.published IN (1,2)');
				$query->where('cc.published IN (1,2)');
			}
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN ('.$groups.')');

			try {
				$db->setQuery($query);
				$result = $db->loadObject();

				if ($error = $db->getErrorMsg()) {
					throw new Exception($error);
				}

				if (empty($result)) {
						throw new JException(JText::_('COM_GARYSCOOKBOOK_ERROR_GARYSCOOKBOOK_NOT_FOUND') , 404);
				}

			// If we are showing a garyscookbook list, then the garyscookbook parameters take priority
			// So merge the garyscookbook parameters with the merged parameters
				if ($this->getState('params')->get('show_contact_list')) {
					$registry = new JRegistry;
					$registry->loadString($result->params);
					$this->getState('params')->merge($registry);
				}
			} catch (Exception $e) {
				$this->setError($e);
				return false;
			}

			if ($result) {
				$user	= JFactory::getUser();
				$groups	= implode(',', $user->getAuthorisedViewLevels());

				//get the content by the linked user
				$query	= $db->getQuery(true);
				$query->select('*');
				$query->from('#__garyscookbook_comments');
				$query->where('cmtpic = '.(int)$result->id);
				if (!$user->authorise('core.edit.state', 'com_garyscookbook.comment')):
					$query->where('published = 1');
				endif;
				$query->order('cmtdate DESC');
				// filter per language if plugin published
				if (JFactory::getApplication()->getLanguageFilter()) {
					//$query->where('language='.$db->quote(JFactory::getLanguage()->getTag()).' OR language ="*"');
				}
				$db->setQuery($query, 0, 10);
				$comments = $db->loadObjectList();
				$result->comments = $comments;

				$query = 'SELECT m.*, a.*, b.title AS cattitle, b.parent_id AS parent_id1,
		 			c.title AS cattitle1, c.parent_id AS parent_id2, d.title AS cattitle2
					FROM #__gkb_myrecipes AS m
					INNER JOIN #__garyscookbook AS a
					ON m.recipeid = a.id
					INNER JOIN #__categories AS b
					ON a.catid = b.id
					LEFT OUTER JOIN #__categories AS c
					ON b.parent_id = c.id
					LEFT OUTER JOIN #__categories AS d
					ON c.parent_id = d.id
					WHERE m.userid = ('.$user->id.')
					AND a.published = 1
					AND b.published = 1
					AND (c.published = 1 OR c.published is null)
					AND (d.published = 1 OR d.published is null)
					ORDER BY b.lft, imgtitle
					LIMIT 0 , 100';

				$db->setQuery($query);
				$myfavorites = $db->loadObjectList();
				$result->myfavorites = $myfavorites;

				$result->voteing ="{gcbvote}";
				//get the profile information for the linked user
				require_once JPATH_ADMINISTRATOR.'/components/com_users/models/user.php';
				$userModel = JModelLegacy::getInstance('User','UsersModel',array('ignore_request' => true));
					$data = @$userModel->getItem((int)$result->user_id);

				JPluginHelper::importPlugin('user');
				$form = new JForm('com_users.profile');
				// Get the dispatcher.
				$dispatcher	= JDispatcher::getInstance();

				// Trigger the form preparation event.
				$dispatcher->trigger('onContentPrepareForm', array($form, $data));
				// Trigger the data preparation event.
				$dispatcher->trigger('onContentPrepareData', array('com_users.profile', $data));

				// Load the data into the form after the plugins have operated.
				$form->bind($data);
				$result->profile = $form;

				$this->garyscookbook = $result;
				return $result;
			}
		}
	}


}