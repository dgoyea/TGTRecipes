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
 * @package		Joomla.Administrator
 * @subpackage	com_garyscookbook
 */
class RecipeTableGaryscookbook extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db)
	{
		parent::__construct('#__garyscookbook', 'id', $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @since	1.6
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Stores a recipe
	 *
	 * @param	boolean	True to update fields even if they are null.
	 * @return	boolean	True on success, false on failure.
	 * @since	1.6
	 */
	public function store($updateNulls = false)
	{
		require_once(JPATH_ADMINISTRATOR . "/components/com_garyscookbook/helpers/ingredients.php");
		// Transform the params field
		if (is_array($this->params)) {
			$registry = new JRegistry();
			$registry->loadArray($this->params);
			$this->params = (string)$registry;
		}
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();

		if ($this->id) {
			// Existing item
			$this->modified		= $date->toSql();
			$this->modified_by	= $user->get('id');
			$this->changeip	= ( phpversion() <= '4.2.1' ? @getenv( 'REMOTE_ADDR' ) : $_SERVER['REMOTE_ADDR'] );


		} else {
			// New newsfeed. A feed created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!intval($this->created)) {
				$this->created = $date->toSql();

			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
			if (empty($this->createip)) {
				$this->createip	= ( phpversion() <= '4.2.1' ? @getenv( 'REMOTE_ADDR' ) : $_SERVER['REMOTE_ADDR'] );
			}
		}
		$post = JRequest::getVar('attributeX1');
		if (empty($post)) {
			if (strlen(formatAttributeX()>0)) {
				$this->ingredients = formatAttributeX();
			}
		}


//		if (empty($this->ingredients)) {
//			$post = JRequest::getVar('attributeX1');
//			if (empty($post)) {
//				$this->ingredients = formatAttributeX();
//			}
//		}



		/*print "<pre>";
		print_r($data);
		echo JRequest::getVar('imgfilename');
		print "</pre>";
		die;*/
		//Thumbnail erzeugen
		$imgfilename = JRequest::getVar('imgfilename');
		if ($imgfilename) {
			$postfiles[0] = $imgfilename;
		}

		for ($i=1;$i <=4;$i++ ){
			$postfiles[$i]  = JRequest::getVar('expic'.$i);
		}

		if (!empty ($postfiles[0]) ) {
			$this->imgfilename = $postfiles[0];
		}
		//zusatzbilder speichern

		if (!empty ($postfiles[1]) ) {
			$this->expic1 = $postfiles[1];

		}
		if (!empty ($postfiles[2]) ) {
			$this->expic2 = $postfiles[2];

		}
		if (!empty ($postfiles[3]) ) {
			$this->expic3 = $postfiles[3];

		}
		if (!empty ($postfiles[4]) ) {
			$this->expic4 = $postfiles[4];

		}



		// Verify that the alias is unique
		$table = JTable::getInstance('Garyscookbook', 'RecipeTable');
		if ($table->load(array('alias'=>$this->alias, 'catid'=>$this->catid)) && ($table->id != $this->id || $this->id==0)) {
			$this->setError(JText::_('COM_GARYSCOOKBOOK_ERROR_UNIQUE_ALIAS'));
			return false;
		}

		// Attempt to store the data.
		return parent::store($updateNulls);
	}

	/**
	 * Overloaded check function
	 *
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check()
	{
		$this->default_con = intval($this->default_con);



		/** check for valid name */
		if (trim($this->imgtitle) == '') {
			$this->setError(JText::_('COM_GARYSCOOKBOOK_WARNING_PROVIDE_VALID_NAME'));
			return false;
		}
				/** check for existing name */
		$query = 'SELECT id FROM #__garyscookbook WHERE imgtitle = '.$this->_db->Quote($this->imgtitle).' AND catid = '.(int) $this->catid;
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->id)) {
			$this->setError(JText::_('COM_GARYSCOOKBOOK_WARNING_SAME_NAME'));
			return false;
		}

		if (empty($this->alias)) {
			$this->alias = $this->imgtitle;
		}
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format("Y-m-d-H-i-s");
		}
		/** check for valid category */
		if (trim($this->catid) == '') {
			$this->setError(JText::_('COM_GARYSCOOKBOOK_WARNING_CATEGORY'));
			return false;
		}

		// Check the publish down date is not earlier than publish up.
		if (intval($this->publish_down) > 0 && $this->publish_down < $this->publish_up) {
			// Swap the dates.
			$temp = $this->publish_up;
			$this->publish_up = $this->publish_down;
			$this->publish_down = $temp;
		}

		return true;
		// clean up keywords -- eliminate extra spaces between phrases
		// and cr (\r) and lf (\n) characters from string
		if (!empty($this->metakey)) {
			// only process if not empty
			$bad_characters = array("\n", "\r", "\"", "<", ">"); // array of characters to remove
			$after_clean = JString::str_ireplace($bad_characters, "", $this->metakey); // remove bad characters
			$keys = explode(',', $after_clean); // create array using commas as delimiter
			$clean_keys = array();
			foreach($keys as $key) {
				if (trim($key)) {  // ignore blank keywords
					$clean_keys[] = trim($key);
				}
			}
			$this->metakey = implode(", ", $clean_keys); // put array back together delimited by ", "
		}

		// clean up description -- eliminate quotes and <> brackets
		if (!empty($this->metadesc)) {
			// only process if not empty
			$bad_characters = array("\"", "<", ">");
			$this->metadesc = JString::str_ireplace($bad_characters, "", $this->metadesc);
		}
		return true;
	}
}
