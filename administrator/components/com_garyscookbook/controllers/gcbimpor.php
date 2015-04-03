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
	 * Beginning of central directory record.
	 *
	 * @var    string
	 * @since  11.1
	 */
	private $_ctrlDirHeader = "\x50\x4b\x01\x02";

	/**
	 * End of central directory record.
	 *
	 * @var    string
	 * @since  11.1
	 */
	private $_ctrlDirEnd = "\x50\x4b\x05\x06\x00\x00\x00\x00";

	/**
	 * Beginning of file contents.
	 *
	 * @var    string
	 * @since  11.1
	 */
	private $_fileHeader = "\x50\x4b\x03\x04";

	/**
	 * ZIP file data buffer
	 *
	 * @var    string
	 * @since  11.1
	 */
	private $_data = null;

	/**
	 * ZIP file metadata array
	 *
	 * @var    array
	 * @since  11.1
	 */
	private $_metadata = null;


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
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Load the component parameters
		$this->params	= JComponentHelper::getParams(com_garyscookbook);

		// Get the data from POST
		$option	= JRequest::getVar( 'option', '', '', 'string', JREQUEST_ALLOWRAW );
		$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
		$task	= JRequest::getVar( 'task', '', '', 'string', JREQUEST_ALLOWRAW );

		// Get the Formdata from POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$this->catid = $data['import_category'];

		if (!$this->catid) {
			JError::raiseError(500, JText::_('COM_GARYSCOOKBOOK_ERROR_NOCATEGORY'));
		}else {
			// Get the Formdata from FILES
			$files = JRequest::getVar('jform', array(), 'files', 'array');
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
						$archivename = $this->file;
						$result = JArchive::extract($archivename, JPATH_ROOT."/tmp");
						$zfiles = $this->_inculdefiles($archivename);
						$this->importsql($zfiles);
						fclose($fp); // close the data file
						$this->noitems ++;
						$nofiles= count($zfiles);
						$msgtext .= sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOITEMS'),$this->noitems) ."<br/>";
					}
				}
				$msgtext .= sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOFILES'),$nofiles) ."<br/>";
				$msgtype="message";
			}

		}
		$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=gcbimpor', false),$msgtext,$msgtype);
	}

	private function importsql($filesinzip){

	//Open Zip, allocate Files - Zip Archiv oeffnen, Dateien zuweisen
 		foreach($filesinzip as $inklFile) {
 			if (substr($inklFile, -8) == ".gkb.sql") {
 				$filenamesql = JPATH_SITE.'/'.'tmp'.'/'. $inklFile;
 			} else {
 				$filenamepicture = JPATH_SITE.'/'.'tmp'.'/'. $inklFile;
 			}


 		}

	//Picture copy - Bilddatei kopieren
	if(empty($filenamepicture)) {

	}
	else {
		copy(JPATH_SITE.'/'.'tmp'.'/'.$filenamepicture , JPATH_SITE .'/'."/images/garyscookbook".'/'.$filenamepicture);
	}

	//Import
	//Daten holen
		$content = file_get_contents($filenamesql);
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

	/**
	 * Extract a ZIP compressed file to a given path using a php based algorithm that only requires zlib support
	 *
	 * @param   string  $archive      Path to ZIP archive to extract.
	 *
	 * @return  Array  of Files
	 *
	 * @since   11.1
	 */
	private function _inculdefiles($archive)
	{
		// Initialise variables.
		$this->_data = null;
		$this->_metadata = null;

		if (!extension_loaded('zlib'))
		{
			$this->set('error.message', JText::_('JLIB_FILESYSTEM_ZIP_NOT_SUPPORTED'));

			return false;
		}

		if (!$this->_data = JFile::read($archive))
		{
			$this->set('error.message', JText::_('JLIB_FILESYSTEM_ZIP_UNABLE_TO_READ'));

			return false;
		}

		if (!$this->_readZipInfo($this->_data))
		{
			$this->set('error.message', JText::_('JLIB_FILESYSTEM_ZIP_INFO_FAILED'));

			return false;
		}
		$ZFiles = array();
		for ($i = 0, $n = count($this->_metadata); $i < $n; $i++)
		{
			$ZFiles[] = $this->_metadata[$i]['name'];

		}

		return $ZFiles;
	}
	/**
	 * Get the list of files/data from a ZIP archive buffer.
	 *
	 * <pre>
	 * KEY: Position in zipfile
	 * VALUES: 'attr'  --  File attributes
	 * 'crc'   --  CRC checksum
	 * 'csize' --  Compressed file size
	 * 'date'  --  File modification time
	 * 'name'  --  Filename
	 * 'method'--  Compression method
	 * 'size'  --  Original file size
	 * 'type'  --  File type
	 * </pre>
	 *
	 * @param   string  &$data  The ZIP archive buffer.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   11.1
	 */
	private function _readZipInfo(&$data)
	{
		// Initialise variables.
		$entries = array();

		// Find the last central directory header entry
		$fhLast = strpos($data, $this->_ctrlDirEnd);

		do
		{
			$last = $fhLast;
			}
		while (($fhLast = strpos($data, $this->_ctrlDirEnd, $fhLast + 1)) !== false);

		// Find the central directory offset
		$offset = 0;

		if ($last)
		{
			$endOfCentralDirectory = unpack(
				'vNumberOfDisk/vNoOfDiskWithStartOfCentralDirectory/vNoOfCentralDirectoryEntriesOnDisk/' .
				'vTotalCentralDirectoryEntries/VSizeOfCentralDirectory/VCentralDirectoryOffset/vCommentLength',
				substr($data, $last + 4)
			);
			$offset = $endOfCentralDirectory['CentralDirectoryOffset'];
		}

		// Get details from central directory structure.
		$fhStart = strpos($data, $this->_ctrlDirHeader, $offset);
		$dataLength = strlen($data);

		do
		{
			if ($dataLength < $fhStart + 31)
			{
				$this->set('error.message', JText::_('JLIB_FILESYSTEM_ZIP_INVALID_ZIP_DATA'));

				return false;
			}

			$info = unpack('vMethod/VTime/VCRC32/VCompressed/VUncompressed/vLength', substr($data, $fhStart + 10, 20));
			$name = substr($data, $fhStart + 46, $info['Length']);

			$entries[$name] = array(
				'attr' => null,
				'crc' => sprintf("%08s", dechex($info['CRC32'])),
				'csize' => $info['Compressed'],
				'date' => null,
				'_dataStart' => null,
				'name' => $name,
				'method' => $this->_methods[$info['Method']],
				'_method' => $info['Method'],
				'size' => $info['Uncompressed'],
				'type' => null
			);

			$entries[$name]['date'] = mktime(
				(($info['Time'] >> 11) & 0x1f),
				(($info['Time'] >> 5) & 0x3f),
				(($info['Time'] << 1) & 0x3e),
				(($info['Time'] >> 21) & 0x07),
				(($info['Time'] >> 16) & 0x1f),
				((($info['Time'] >> 25) & 0x7f) + 1980)
			);

			if ($dataLength < $fhStart + 43)
			{
				$this->set('error.message', 'Invalid ZIP data');
				return false;
			}

			$info = unpack('vInternal/VExternal/VOffset', substr($data, $fhStart + 36, 10));

			$entries[$name]['type'] = ($info['Internal'] & 0x01) ? 'text' : 'binary';
			$entries[$name]['attr'] = (($info['External'] & 0x10) ? 'D' : '-') . (($info['External'] & 0x20) ? 'A' : '-')
				. (($info['External'] & 0x03) ? 'S' : '-') . (($info['External'] & 0x02) ? 'H' : '-') . (($info['External'] & 0x01) ? 'R' : '-');
			$entries[$name]['offset'] = $info['Offset'];

			// Get details from local file header since we have the offset
			$lfhStart = strpos($data, $this->_fileHeader, $entries[$name]['offset']);

			if ($dataLength < $lfhStart + 34)
			{
				$this->set('error.message', 'Invalid ZIP data');

				return false;
			}

			$info = unpack('vMethod/VTime/VCRC32/VCompressed/VUncompressed/vLength/vExtraLength', substr($data, $lfhStart + 8, 25));
			$name = substr($data, $lfhStart + 30, $info['Length']);
			$entries[$name]['_dataStart'] = $lfhStart + 30 + $info['Length'] + $info['ExtraLength'];

			// Bump the max execution time because not using the built in php zip libs makes this process slow.
			@set_time_limit(ini_get('max_execution_time'));
			}
		while ((($fhStart = strpos($data, $this->_ctrlDirHeader, $fhStart + 46)) !== false));

		$this->_metadata = array_values($entries);

		return true;
	}

}