<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Garyscookbook Import OR Controller
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');
jimport('joomla.filesystem.archive');

class GaryscookbookControllerGcbimpor extends JControllerAdmin {

	/**
	 * doImport()
	 *
	 * @param mixed $File
	 * @param mixed $uploadedFile
	 * @param mixed $CatId

	 * @return
	 */
	function doImport()
	{
		// JRequest::checkToken überprüft das Form-Token in einer "Request" Variable.

		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Load the component parameters
		// params = Kontextparameter — Liste der Kontextparameter
		// JComponentHelper = Helper class for the JComponent class
		// getParams = Parameter, die von der Aktion ansprechbar sind, bestehen aus einem assoziativen Array mit Schlüssel und Werte Paaren,
		// auf die komplett per getParams() und setParams() oder einzeln per getParam() und setParam() zugegriffen werden kann.
		$this->params	= JComponentHelper::getParams(com_garyscookbook);

		// Get the data from POST
		// JRequest = JRequest stellt dem Framework eine Schnittstelle bereit um auf die sogenannten "Request" Variablen $_POST, $_GET und $_REQUEST zugreifen zu können.
		// Dabei können die Variablen verschiedenen Filtern übergeben werden.
		// getVar = 	Holt eine entsprechende Variable und gibt sie zurück.
		// JREQUEST_ALLOWRAW = Der Parameter JREQUEST_ALLOWRAW steht dafür das HTML erlaubt ist. Also Formatierungen und Schriftarten usw.
		$option	= JRequest::getVar( 'option', '', '', 'string', JREQUEST_ALLOWRAW );
		$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
		$task	= JRequest::getVar( 'task', '', '', 'string', JREQUEST_ALLOWRAW );

		// Get the Formdata from POST
		// $this = $this ist eine Referenz auf das Objekt, zu welchem die Methode gehört, in der es verwendet wird.
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$this->catid = $data['import_category'];

		if (!$this->catid) {
			JError::raiseError(500, JText::_('COM_GARYSCOOKBOOK_ERROR_NOCATEGORY'));
		}else {
			// Get the Formdata from FILES
			$files = JRequest::getVar('jform', array(), 'files', 'array');
			//konvert array from FILES to one per file -- easier way?
			// to be added to library!!!!!
			$i = 0;
			$formfiles = array();
			foreach($files['name'] as $key => $file) {
				$formfiles[$i]["formname"] = $key;
				$formfiles[$i]["formfile"] = $file;
				$formfiles[$i]["formfiletype"] = $files["type"][$key];
				$formfiles[$i]["formfiletmp"] = $files["tmp_name"][$key];
				$formfiles[$i]["formfileerror"] = $files["error"][$key];
				$formfiles[$i]["formfilesize"] = $files["size"][$key];
				//print_r($formfiles);
				$i ++;
			}
			//Check file types and size
			foreach($formfiles as $key => $file) {
				if (strtolower(substr($file["formfile"], -4)) != '.gkb'){
					JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_ERROR_FILETYPE').' : '.$file["formfile"]);
					unset($formfiles[$key]);
					continue;
				}
				$filesize = $file["formfilesize"] / 1048576 ;//in MByte
				if ( $filesize > $this->params->get('maxfilesize') ){
					$msgtext = sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_FILESIZE'),$filesize, $this->params->get('maxfilesize')  );
					JError::raiseWarning(500, $msgtext.' : '.$file["formfile"]);
					unset($formfiles[$key]);
				}
			}
			if (empty($formfiles)) {
				JError::raiseNotice(500, JText::_('COM_GARYSCOOKBOOK_ERROR_NOIMPORT'));
			}else {
				//Import files
				$nofiles = 0;
				foreach($formfiles as $key => $file) {
					JError::raiseNotice(500, JText::_('COM_GARYSCOOKBOOK_ERROR_IMPORTFILE').' : '.$file["formfile"]);
					//move_uploaded_file($src, $dest);
					if (!move_uploaded_file($file['formfiletmp'], JPATH_SITE.'/'.'tmp'.'/'.$file["formfile"].'.zip')) {
						JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_ERROR_NOIMPORTMOVE').' : '.JPATH_SITE.'/'.'tmp'.'/'.$file["formfile"].$file['formfiletmp']);
					}else {
						$this->file = JPATH_SITE.'/'.'tmp'.'/'.$file["formfile"] .'.zip';
						if (!($fp = fopen($this->file , "r"))) {
							JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_ERROR_IMPORTERROR').' : '.$this->file);
							continue;
						}
						$archivename = JPATH_SITE . '/' . 'tmp' . '/' . $this->file;
						$archivename = $this->file;
						$result = JArchive::extract($archivename, JPATH_ROOT."/tmp");

						$this->importsql();

						//$this->readItems($fp);
						fclose($fp); // close the data file
						$nofiles ++;
						//$this->importItems();
						//unlink($this->file);
						$msgtext = sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOITEMS'),$this->noitems);
						JError::raiseNotice(500, $msgtext);
					}
				}
				$msgtext = sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOFILES'),$nofiles);
				JError::raiseNotice(500, $msgtext);

			}

		}
		//print_r($formfiles);


	}

	private function importsql(){

	//Open Zip, allocate Files - Zip Archiv oeffnen, Dateien zuweisen
	$za = new ZipArchive;


	if ($za->open($this->file))
	{
		for($i = 0; $i < $za->numFiles; $i++)
		{
			if (preg_match("/(jpg|png)$/i", $za->getNameIndex($i))) {
				$filenamepicture = $za->getNameIndex($i);
			} else {
				$filenamesql = $za->getNameIndex($i);
			}
		}
	}
	else
	{
		echo 'Error reading zip-archive!' . '<br />';
	}

	//Unzip - Ziparchiv entpacken
	$zip = new ZipArchive;
	$res = $zip->open($this->file);
		if ($res === TRUE) {
			$zip->extractTo(JPATH_SITE.'/'.'tmp');
			$zip->close();
		} else {
			echo 'Error:' . $res;
		}

	//Picture copy - Bilddatei kopieren
	if(empty($filenamepicture)) {

	}
	else {
		copy(JPATH_SITE.'/'.'tmp'.'/'.$filenamepicture , JPATH_SITE .'/'."/images/garyscookbook".'/'.$filenamepicture);
	}

	//Import
	//Daten holen
	$file = JPATH_SITE.'/'.'tmp'.'/'.$filenamesql;
	$content = file_get_contents($file);
	$fh = fopen($file, "r");
	fclose($fh);

		$decodedIn = explode(chr(10), $content);
		$decodedOut = "";
		$queries = 0;
		$conrstring = "'^(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(DATABASE)[[:space:]]+(.+)'";
		foreach ($decodedIn as $rawdata) {
			$rawdata = trim($rawdata);
			if (($rawdata != "") && ($rawdata{0} != "#")) {
				$decodedOut .= $rawdata;
				if (substr($rawdata, -1) == ";") {
					if ((substr($rawdata, -2) == ");") || (strtoupper(substr($decodedOut, 0, 6)) != "INSERT")) {
						if (preg_match($conrstring, $decodedOut)) {
							showGKBAdminMessage("Error! Your input file contains a DROP or CREATE DATABASE statement. Please delete these statements before trying to import the file.</p>", "GKB - Import", $option, $task);
							return;
						}
						// Präfix holen
						$dbpf = JFactory::getDBO();

						//CatID holen
						$data = JRequest::getVar('jform', array(), 'post', 'array');
						$CatId = $this->catid = $data['import_category'];

						//SQL-String umbauen
						$decodedOut = str_replace("'****'", $CatId, $decodedOut);
						$decodedOut = str_replace('#__', $dbpf->getPrefix(), $decodedOut);
						$decodedOut = str_replace("`imgdate`", "`created`",  $decodedOut);

						//SQL ausführen
						$dbsql= JFactory::getDBO();
						$dbsql->setquery($decodedOut);
						$dbsql->query();

						//SQL-Fehlerbehandlung
						if ($dbsql->getErrorNum()){
							echo $dbsql->getErrorMsg();

						} else {
							echo "Der Datensatz wurde eingetragen.";

						}

						echo $decodedOut;

					}
				}
			}
		}
	}
}