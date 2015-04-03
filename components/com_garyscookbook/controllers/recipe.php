<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */


defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class GaryscookbookControllerRecipe extends JControllerForm
{
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('recipe');
		$params = JComponentHelper::getParams('com_garyscookbook');
		$stub	= JRequest::getString('id');
		$id		= (int)$stub;

		// Get the data from POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$recipe = $model->getItem($id);


		$params->merge($recipe->params);

		// Check for a valid session cookie
		if($params->get('validate_session', 0)) {
			if(JFactory::getSession()->getState() != 'active'){
				JError::raiseWarning(403, JText::_('COM_GARYSCOOKBOOK_SESSION_INVALID'));

				// Save the data in the session.
				$app->setUserState('com_garyscookbook.recipe.data', $data);

				// Redirect back to the recipe form.
				$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false));
				return false;
			}
		}

		// Garyscookbook plugins
		JPluginHelper::importPlugin('garyscookbook');
		$dispatcher	= JDispatcher::getInstance();

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		$validate = $model->validate($form, $data);

		if ($validate === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_garyscookbook.recipe.data', $data);

			// Redirect back to the recipe form.
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false));
			return false;
		}

		// Validation succeeded, continue with custom handlers
		$results	= $dispatcher->trigger('onValidateGaryscookbook', array(&$recipe, &$data));

		foreach ($results as $result) {
			if ($result instanceof Exception) {
				return false;
			}
		}

		// Passed Validation: Process the recipe plugins to integrate with other applications
		$results = $dispatcher->trigger('onSubmitGaryscookbook', array(&$recipe, &$data));

		// Send the email
		$sent = false;
		if (!$params->get('custom_reply')) {
			//toDo:Kommentar weg
			//$sent = $this->_sendEmailcomment($data, $recipe);
		}
		$store = $this->savecomment($data, $recipe );
		// Set the success message if it was a success
		if (!JError::isError($sent)) {
			$msg = JText::_('COM_GARYSCOOKBOOK_EMAIL_THANKS_COMMENT');
		}

		// Flush the data from the session
		$app->setUserState('com_garyscookbook.recipe.data', null);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}

		return true;
	}

	private function _sendEmailcomment($data, $recipe)
	{
			$app		= JFactory::getApplication();
			$params 	= JComponentHelper::getParams('com_garyscookbook');
			if ($recipe->email_to == '' && $recipe->user_id != 0) {
				$recipe_user = JUser::getInstance($recipe->user_id);
				$recipe->email_to = $recipe_user->get('email');
			}
			$mailfrom	= $app->getCfg('mailfrom');
			$fromname	= $app->getCfg('fromname');
			$sitename	= $app->getCfg('sitename');

			$name		= $data['garyscookbook_name'];
			$body		= $data['garyscookbook_comment'];
			$cookbookadmin =$params->get('cookbook_mail');
			$subject	= JText::sprintf('COM_GARYSCOOKBOOK_SUBJECT', $recipe->imgtitle, $sitename);

			// Prepare email body
			$prefix = JText::sprintf('COM_GARYSCOOKBOOK_ENQUIRY_TEXT', JURI::base());
			$body	= $prefix."\n".$name.' <'.$email.'>'."\r\n\r\n".stripslashes($body);

			$mail = JFactory::getMailer();
			$mail->addRecipient($cookbookadmin);
			$mail->addReplyTo(array($mailfrom, $fromname));
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($sitename.': '.$subject);
			$mail->setBody($body);
			$sent = $mail->Send();

			return $sent;
	}

	/**
	 * Method to save a record.
	 *
	 * @param	string	$key	The name of the primary key of the URL variable.
	 * @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return	Boolean	True if successful, false otherwise.
	 * @since	1.6
	 */
	public function savecomment($data, $recipe)
	{

	$db = JFactory::getDBO();

		// Check the row in by primary key.
		$query 		= $db->getQuery(true);
		$currip 	= ( phpversion() <= '4.2.1' ? @getenv( 'REMOTE_ADDR' ) : $_SERVER['REMOTE_ADDR'] );
		$cmtpic 	= $recipe->id;
		$name		= $data['garyscookbook_name'];
		$comment	= $data['garyscookbook_comment'];
		$cmtdate	= time();
		if($recipe->params->get('publish_comments')){
			$published	='1';
		} else {
			$published	='0';
		}

		$db->setQuery("INSERT INTO `#__garyscookbook_comments` ( `cmtid` ,  `cmtpic` ,  `cmtip` ,  `cmtname` ,  `cmttext` ,  `cmtdate` ,  `published` ) VALUES ( NULL ,'$cmtpic','$currip','$name','$comment','$cmtdate','$published');");
		// Check for a database error.

		if (!$db->query())
		{
			$e = new JException(JText::sprintf('JLIB_DATABASE_ERROR_HIT_FAILED', get_class($this), $this->_db->getErrorMsg()));
			$this->setError($e);
			return false;
		}
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance proper
	 g. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function cmtpublish($pks = null, $state = 1, $userId = 0)
	{

		// Initialise variables.
		$app		= JFactory::getApplication();
		$model		= $this->getModel('recipe');
		$params 	= JComponentHelper::getParams('com_garyscookbook');
		$stub		= JRequest::getString('id');
		$id			= (int)$stub;
		$cmtid 		= JRequest::getString('cmtid');
		$cmtid		= (int)$cmtid;
		$recipe 	= $model->getItem($id);


		$params->merge($recipe->params);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}


		// Initialise variables.
		$k = $this->_tbl_key;

		$userId = (int) $userId;
		$state  = (int) $state;

		// Get an instance of the table
		$table = JTable::getInstance('Comments','GaryscookbookTable');



	// Load the row
			if(!$table->load($cmtid))
			{
				$this->setError($table->getError());
			}
			$state = !$table->published;
			// Change the state

			$table->published = $state;

			// Check the row
			$table->check();

			// Store the row
			if (!$table->store())
			{
				$this->setError($table->getError());
			}


		return count($this->getErrors())==0;
	}
	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance proper
	 g. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function cmtdelete($pks = null, $state = 1, $userId = 0)
	{

		// Initialise variables.
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$model		= $this->getModel('recipe');
		$params 	= JComponentHelper::getParams('com_garyscookbook');
		$stub		= JRequest::getString('id');
		$id			= (int)$stub;
		$cmtid 		= JRequest::getString('cmtid');
		$cmtid		= (int)$cmtid;
		$recipe 	= $model->getItem($id);

		$params->merge($recipe->params);
		$this->user = $user;
		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}
		// Get an instance of the table
		$table = JTable::getInstance('Comments','GaryscookbookTable');

		if ($this->user->authorise('core.edit.state', 'com_garyscookbook.comment')):
			// Load the row
			if(!$table->load($cmtid))
			{
				$this->setError($table->getError());
			}

			// Store the row
			if (!$table->delete($cmtid))
			{
				$this->setError($table->getError());
			}
		endif;
		return count($this->getErrors())==0;
	}

	public function addmyrecipe(){
		// Initialise variables.
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$model		= $this->getModel('recipe');
		$params 	= JComponentHelper::getParams('com_garyscookbook');
		$stub		= JRequest::getString('id');
		$id			= (int)$stub;
		$recipe 	= $model->getItem($id);
		$params->merge($recipe->params);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__gkb_myrecipes VALUES ('', '$user->id', '$recipe->id')";
		$db->setquery($query);
		if(!$db->query()) {
			//Errorhandling
			JError::raiseWarning( 600, JText::_( 'Error saving to database' ) );
			//$this->redirect( 'index.php?option=com_garyscookbook&func=detail&id=' . $recipeid );
			return;
		}
		JError::raiseNotice( 600, JText::_( 'COM_GARYSCOOKBOOK_ADDED_TO_MY_FAVORIT_RECIPES' ));
		//$this->redirect( 'index.php?option=com_garyscookbook&func=detail&id=' . $recipeid );
		return;
	}

	public function delmyrecipe(){
		// Initialise variables.
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$model		= $this->getModel('recipe');
		$params 	= JComponentHelper::getParams('com_garyscookbook');
		$stub		= JRequest::getString('id');
		$id			= (int)$stub;
		$recipe 	= $model->getItem($id);
		$params->merge($recipe->params);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}
		$db = JFactory::getDBO();
		$query = "DELETE FROM #__gkb_myrecipes WHERE  userid='$user->id' AND RECIPEID='$recipe->id'";
		$db->setquery($query);
		if(!$db->query()) {
			//Errorhandling
			JError::raiseWarning( 600, JText::_( 'Error saving to database' ) );
			//$this->redirect( 'index.php?option=com_garyscookbook&func=detail&id=' . $recipeid );
			return;
		}
		JError::raiseNotice( 600, JText::_( 'COM_GARYSCOOKBOOK_REMOVED_FROM_MY_FAVORIT_RECIPES' ));
		//$this->redirect( 'index.php?option=com_garyscookbook&func=detail&id=' . $recipeid );
		return;
	}

	//Recipt Export for share with other Users, Rezept Export um mit anderen Benutzern zu tauschen
	public function exportrecipe(){
		jimport( 'joomla.filesystem.archive.zip' );
		$model		= $this->getModel('recipe');
		$params 	= JComponentHelper::getParams('com_garyscookbook');
		$stub		= JRequest::getString('id');
		$id			= (int)$stub;
		$recipe 	= $model->getItem($id);
		$params->merge($recipe->params);
		$recipe_pic_yesno 	= $params->get('show_export_recipe_picture');
		$conf = &JFactory::getConfig();
		$dbGKB = &JFactory::getDBO();
		$query1 = "SELECT id, catid, imgtitle, imgauthor, imgtext, created, imgcounter, imgvotes, imgvotesum, published, imgfilename, imgthumbname, doc, price, country, portion, aging, years, grapes, properties, notes FROM #__garyscookbook  WHERE id = '$id'";
		$dbGKB->setquery($query1);
		$result = $dbGKB->loadObjectList();
		$row = $result[0];
		$UserAgent = $_SERVER['HTTP_USER_AGENT'];

		//Which browser is used to determine, feststellen welcher Browser verwendet wird
		if (stripos($UserAgent, "Opera")){
			$UserBrowser = "Opera";
		} elseif (stripos( $UserAgent,"MSIE")) {
			$UserBrowser = "IE";
		} else {
			$UserBrowser = '';
		}

		//Filename
		$filename = preg_replace("/[[:punct:]]/", "" , $row->imgtitle);
		$filename .= "_" . date("jmYHis") . ".gkb";
		$filename = str_replace(" ", "_" , $filename);
		$filename = str_replace("ä", "ae" , $filename);
		$filename = str_replace("ö", "oe" , $filename);
		$filename = str_replace("ü", "ue" , $filename);
		$filename = str_replace("ß", "ss" , $filename);
		$filename = preg_replace('[^A-Za-z0-9.]', '-', $filename);

		$mime_type = 'application/x-zip';
		$tblval = "#__garyscookbook";

		$dbGKB->setQuery("SHOW CREATE table $tblval");
		$dbGKB->query();
		$CreateTable[$tblval] = $dbGKB->loadResultArray(1);

		//Get Picture, Bild holen
		$opFile = JPATH_ROOT. DS . $row->imgfilename;

		//Export with or without Picture, Export mit oder ohne Bild
		if ($recipe_pic_yesno) {
			if (file_exists($opFile) && $row->imgfilename > "") {
				$fp = fopen($opFile , "r");
				$bindata = fread($fp, filesize ($opFile));
				$PictureImportname = "GKB_" . date("jmYHis") . $row->imgfilename;
				fclose($fp);
				$picinklude = True;
			}else{
				$picinklude = False;
			}
		}

		// Create Head, Kopf erzeugen
		$OutBuffer = "";
		$OutBuffer .= "#\n";
		$OutBuffer .= "# Garyscookbook Recipe Export\n";
		$OutBuffer .= "# http://www.vb-dozent.net\n";
		$OutBuffer .= "#\n";
		$OutBuffer .= "# Host: $mosConfig_sitename\n";
		$OutBuffer .= "# Generation Time: " . date("M j, Y \a\\t H:i") . "\n";
		$OutBuffer .= "# Server version: " . $dbGKB->getVersion() . "\n";
		$OutBuffer .= "# PHP Version: " . phpversion() . "\n";
		$OutBuffer .= "# Included Files: " . $PictureImportname. "\n";
		$OutBuffer .= "# Database : `" . $conf->getValue('config.db') . "`\n# --------------------------------------------------------\n";
		$pictime = mktime();

		if ($recipe_pic_yesno && $picinklude){
			//Required fields set, Benötigte Felder festlegen
			$myfields = "`catid`, `created`, `imgfilename`, `imgthumbname`, `imgtitle`, `imgauthor`, `imgtext`,  `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes`";
			$dbGKB->setQuery("SELECT  `imgtitle`, `imgauthor`, `imgtext`,  `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes` FROM #__garyscookbook WHERE id='$uid'");
		} else {
			//Required fields set, Benötigte Felder festlegen
			$myfields = "`catid`, `created`, `imgtitle`, `imgauthor`, `imgtext`, `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes`";
			$dbGKB->setQuery("SELECT `imgtitle`, `imgauthor`, `imgtext`, `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes` FROM #__garyscookbook WHERE id='$uid'");
		}

		$rows = $dbGKB->loadObjectList();

		//String with or withot Picture, String mit oder ohne Bild
		if ($recipe_pic_yesno && $picinklude) {
			$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES ( '****' , '" . $pictime . "'," . "'" . $PictureImportname . "', 'tn_" . $PictureImportname . "',";
		} else {
			$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES ( '****' , '" . $pictime . "',";
		}

		//Get Data and assignment, Daten holen und Zuweisung
		foreach($row as $rows) {
			$arr = JArrayHelper::fromObject($row);
			foreach($arr as $key => $value) {
				$value = addslashes($value);
				$value = str_replace("\n", '\r\n', $value);
				$value = str_replace("\r", '', $value);
				if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET")) {
					$InsertDump .= "'$value',";
				} else {
					$InsertDump .= "$value,";
				}
			}
		}

		$OutBuffer .= rtrim($InsertDump, ',') . ");\n";

		//Change for old Version, fuer alte Version abaendern
		$OutBuffer = str_replace("`created`", "`imgdate`", $OutBuffer);

		//Dump anything in the buffer, alles in den Puffer abladen
			@ob_end_clean();
			ob_start();
			header('Content-Type: ' . $mime_type);
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

			if ($UserBrowser == 'IE') {
				header('Content-Disposition: inline; filename="' . $filename . '"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			} else {
				header('Content-Disposition: attachment; filename="' . $filename . '"');
				header('Pragma: no-cache');
			}

			if (function_exists('gzcompress')) {
				include JPATH_COMPONENT . "/helpers/zip.lib.php";
				$zipfile = new zipfile();
				$zipfile->addFile($OutBuffer, $filename . ".sql");

				if ($recipe_pic_yesno && $picinklude) {
					$zipfile->addFile($bindata, $PictureImportname);
				}
					echo $zipfile->file();
					ob_end_flush();
					ob_start();
				}

		//Output Text, Ausgabetext
		$msg = JText::_("COM_GARYSCOOKBOOK_RECIPE_EXPORTED");

		//Redirect if it is set in the parameters, otherwise redirect back to where we came from
		//Umleiten wenn es in den Parametern eingestellt ist, sonst redirect dorthin zurück wo wir herkommen
		if ($recipe->params->get('redirect')) {
			$this->setRedirect($recipe->params->get('redirect'), $msg);
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=recipe&id='.$stub, false), $msg);
		}

	}
}
