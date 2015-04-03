<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// Garyscookbook Import MM Controller

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');
jimport( 'joomla.utilities.date' );

class GaryscookbookControllerGcbimpmm extends JControllerAdmin {

	// old variabels -- check if needed

	var $items = array();
	var $item = array();
	var $currentIngredient = array();

	// Define some reg ex parts to look for

	var $rxpHead = '/^(M{5,5}|-{5,5}).*Meal-Master/';
	//var $rxpEnd = '/^(M{5,5}|-{5,5})\s$/';
	// Added to fix bug reported by user, use the previous regex if this fails.
	var $rxpEnd = '/^(M{5,5}|-{5,5})(-{5,5})?\s*$/';

	var $rxpTitle = '/^ *Title: .+/';
	var $rxpCat = '/^ *Categories: .+/';
	var $rxpYield = '/^ *(Yield:|Servings:) +[1-9][0-9]*/';
	var $rxpWhitespaceOnly = '/^\\s+$/';
	// example group line:    MMMMM----------------SAUCE-----------------
	var $rxpGroup = '/^(MMMMM|-----).*(-)+$/';
	// example Source/Author: MMMMM-----------------QUELLE----------------------
	var $rxpSource = '----QUELLE----';
	var $rxpSeparator = '/^(MMMMM|-----)/';

	// new variabels

	var $catid = NULL;		// import to category
	var $file = NULL;		// imported file
	var $params = NULL;		// component parameters
	var $noitems = 0;		// total No of items

	/*
	   * Define the Units and there equiv in this program, they are looked up in unitdefs later
	*/

	var $MMUnits = array(
		'bn' =>  'bunch',
		'c'  =>  'cup',
		'cn' =>  'can',
		'cc' =>  'cubic Centimeter',
		'cg' =>  'centigram',
		'cl' =>  'centiliter',
		'ct' =>  'carton',
		'dl' =>  'deciliter',
		'dr' =>  'drop',
		'ds' =>  'dash',
		'ea' =>  'unit',		//Each
		'fl' =>  'ounce',
		'g'  =>  'gram',
		'ga' =>  'gallon',
		'kg' =>  'kilogram',
		'l'  =>  'liter',
		'lb' =>  'pound',
		'lg' => 'large',
		'md' => 'medium',
		'mg' =>  'milligram',
		'ml' =>  'milliliter',
		'oz' =>  'ounce',
		'pk' =>  'package',
		'pn' =>  'pinch',
		'pt' =>  'pint',
		'qt' =>  'quart',
		'sl' =>  'slice',
		'sm' => 'small',
		't'  =>  'teaspoon',
		'T'  =>  'tablespoon',
		'tb' =>  'tablespoon',
		'ts' =>  'teaspoon',
		'x' =>   'unit'		//Per serving
	);

	public function importmm()	{

	// Check for request forgeries.
	JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Load the component parameters
		$this->params	= JComponentHelper::getParams('com_garyscookbook');

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
			if (strtolower(substr($file["formfile"], -4)) != '.mmf' && strtolower(substr($file["formfile"], -3)) != '.mm' ){
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
				if (!move_uploaded_file($file['formfiletmp'], JPATH_SITE. "/".'tmp'. "/".$file["formfile"])) {
					JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_ERROR_NOIMPORTMOVE').' : '.JPATH_SITE. "/".'tmp'. "/".$file["formfile"].$file['formfiletmp']);
				}else {
					$this->file = JPATH_SITE. "/".'tmp'. "/".$file["formfile"];
					if (!($fp = fopen($this->file, "r"))) {
						JError::raiseWarning(500, JText::_('COM_GARYSCOOKBOOK_ERROR_IMPORTERROR').' : '.$this->file);
						continue;
					}
					$this->readItems($fp);
					fclose($fp); // close the data file
					$nofiles ++;
					$this->importItems();
					unlink($this->file);
					$msgtext = sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOITEMS'),$this->noitems);
					JError::raiseNotice(500, $msgtext);
				}
		}
			$msgtext = sprintf(JText::_('COM_GARYSCOOKBOOK_ERROR_NOFILES'),$nofiles);
			JError::raiseNotice(500, $msgtext);
		}
	}
		// Redirect
		$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=gcbimpmm', false));
		return;
	}

	// get all items in the file
	protected function readItems($fp)
	{
		$i = 0;
		while (!feof($fp)) {
			$data = fgets($fp, 256);
			if (preg_match($this->rxpHead, $data)) {
				//skip the MM header
				$data = fgets($fp, 256);
				$end = false;
				// copy data into internal string list
				while (!$end) {
					$this->items[$i][] = $data;
					if ((preg_match($this->rxpEnd, $data)) || ( feof($fp) ) )
						$end = true;
					else
						$data = fgets($fp, 256);
				}
		$i ++;
			}
		}
	}

	protected function importItems() {
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . "/". 'tables');
		$filterInput = new JFilterInput();
			$step = 0;
		foreach ($this->items as $k=>$item) {
			$this->item = array();
			$this->item['ingredients'] = array();
			$this->item['preparation'] = '';
			$this->item['title'] = '';
			$this->item['catid'] = $this->catid;
			$skipLines = true;
			$ingNo = 0;

//		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . "/". 'tables');
			foreach ($item as $v=>$line) {
				//title
				if (preg_match($this->rxpTitle, $line)) {
					$pos = strpos($line, "Title: ") + strlen("Title: ");
					$this->item['title'] = $filterInput->clean(trim(substr($line, $pos)), 'string');
					$step = 1;
				//echo "Title : " . $this->item['title'] . "<br />";
				//categories
				}elseif (preg_match($this->rxpCat, $line)) {
					$pos = strpos($line, "Categories: ") + strlen("Categories: ");
					$this->item['cattxt'] = JText::_('GARYSCOOKBOOK_MMIMPORT_CATEGORIES').': '.$filterInput->clean(trim(substr($line, $pos)), 'string');
					$step = 2;
				//echo 'Categories : '.$this->item['cattxt'] . "<br />";
				//yield
				}elseif (preg_match($this->rxpYield, $line)) {
					if (strpos($line, "Yield")) {
						$pos = strpos($line, "Yield: ") + strlen("Yield: ");
					} else {
						$pos = strpos($line, "Servings: ") + strlen("Servings: ");
					}
					$yieldStr = trim(substr($line, $pos));
					$this->item['yieldtxt'] = JText::_('GARYSCOOKBOOK_MMIMPORT_YIELD').': '.$filterInput->clean($yieldStr, 'string');
				//	echo 'Yield : '.$this->item['yieldtxt'] . "<br />";
					$this->item['yield'] = intval($yieldStr);
				//	echo 'YieldNo : '.$this->item['yield'] . "<br />";
					$step = 3;
				//ingredient and additional lines
				}elseif ( substr( $line, 7, 1) == ' ' && substr( $line, 10, 1) == ' ' && strlen(rtrim($line)) > 10 && !strpos($line, $this->rxpSource) && $step < 5) {
					//ingredient name additional lines
					if (substr( $line, 11, 2) == '--' && !strpos($line, $this->rxpSource)) {
						$this->item['ingredients'][$ingNo-1]['name'] .= ' '.trim($filterInput->clean(substr( $line, 13), 'string')); // col 13+
					}else {
						$this->item['ingredients'][$ingNo]['quantity'] = '';
						$this->item['ingredients'][$ingNo]['quantity'] = $filterInput->clean(substr( $line, 0, 7), 'string'); // col 0-6
						$this->item['ingredients'][$ingNo]['unit'] = trim($filterInput->clean(substr( $line, 8, 2), 'string')); // col 8-9
						if ($this->item['ingredients'][$ingNo]['unit']) {
							if (isset($this->MMUnits[$this->item['ingredients'][$ingNo]['unit']])) {
								if ($this->MMUnits[$this->item['ingredients'][$ingNo]['unit']]) {
									$this->item['ingredients'][$ingNo]['unit'] = $this->MMUnits[$this->item['ingredients'][$ingNo]['unit']];
								}
							}
						}
						$this->item['ingredients'][$ingNo]['name'] = trim($filterInput->clean(substr( $line, 11), 'string')); // col 11+
						$ingNo ++;
						$step = 4;
				}
				//ingredient group
				}elseif (preg_match($this->rxpGroup, trim($line)) && !strpos($line, $this->rxpSource) ) {
					$this->item['ingredients'][$ingNo]['quantity'] = '';
					$this->item['ingredients'][$ingNo]['unit'] = 'xyz';
					$line = preg_replace( '/^M{5,5}/', "", $line); // remove initial "M"s
					$line = preg_replace( '/^-*/', "", $line); // remove dashes up to group title
					$line = preg_replace( '/-*$/', "", trim($line)); // remove dashes after group title
					$line = trim($line); // cut unwanted whitespaces
					//RKs has uppercase subheadings -> only 1.st char in each word uppercase
					$line = ucwords (strtolower($line));	// group-name
					$this->item['ingredients'][$ingNo]['name'] = $filterInput->clean($line);
					$ingNo ++;
					$step = 4;
				//source when QUELLE in line -- RKs special
				}elseif (strpos($line, $this->rxpSource) ) {
					$this->item['author'] = '';
					$step = 5;
				//source additional lines
				}elseif ($step == 5 && substr( $line, 11, 2) == '--' ) {
					$this->item['author'] .= ' '.trim($filterInput->clean(substr( $line, 13), 'string')); // col 13+
				//preparation and empty lines
				}else {
					//end of item
					if ((empty($line)) || (preg_match($this->rxpEnd, $line))){ 	break; }
					if ($skipLines == true && preg_match($this->rxpWhitespaceOnly, $line)) {
						continue;
					}
					$skipLines = false;
					if (preg_match($this->rxpWhitespaceOnly, $line)) {
						$this->item['preparation'] .= '<br />';
					}else {
							$this->item['preparation'] .= trim($filterInput->clean($line, 'string'));
					}
				}
			}
			//insert item
			if ($this->item['title'] && $this->item['catid'] ) {
				// add misc infos at end of preparation
			if (isset($this->item['cattxt'])) {
				$this->item['preparation'] .= '<br />'.$this->item['cattxt'];
			}
			if (isset($this->item['yieldtxt'])) {
				$this->item['preparation'] .= '<br />'.$this->item['yieldtxt'];
			}
			$this->saveItem();
		}
	}
	}

	protected function cleanIngedients($value, $amount){
		if( ! is_null( $value ) && $value != '' ) {
			if ($amount) {
				$search  = array(';', '|', ',');
				$replace = array('', '', '.');
			} else {
				$search  = array(';', '|');
				$replace = array(',', ',');
			}
			return  trim(str_replace($search,$replace,$value));
		}
	}

	protected function saveItem()
	{
		$this->item['title'] = @iconv('windows-1252//IGNORE', 'UTF-8', $this->item['title']);
		$alias = JFilterOutput::stringURLSafe( $this->item['title'] );
		$this->item['preparation'] = @iconv('windows-1252//IGNORE', 'UTF-8', $this->item['preparation']);
		$this->item['author'] = @iconv('windows-1252//IGNORE', 'UTF-8', $this->item['author']);
		$date	= JDate::getInstance();
		$date_created = $date->toSql();
		$user = JFactory::getUser();
		$userid = $user->get( 'id' );
		$created_by_alias = $user->get( 'name' );
		//check if alias exist
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(	'id' );
		$query->from('#__garyscookbook');
		$query->where('alias = "'. $alias.'"');
		// Setup the query
		$db->setQuery((string) $query);

		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
		}

		$rows = $db->loadObjectList();

			if (count($rows)) {
				$msgtext = JText::_('COM_GARYSCOOKBOOK_ERROR_ITEMEXISTS').' : '.$alias;
				JError::raiseWarning(500, $msgtext);
				return;
		}
		$ingred_txt='<ul>';
		$ingredients ='';
//loop on ingredients

		foreach ($this->item['ingredients'] as $k=>$ingredient) {
			if ($ingredient['unit'] == 'xyz') {
				$ingredients .= ';xyz;' . @iconv('windows-1252//IGNORE', 'UTF-8', $ingredient['name']) .'|';
				$ingred_txt .='<li style="list-style-type: none;"><br/><h3>' . @iconv('windows-1252//IGNORE', 'UTF-8', $ingredient['name']). '</h3></li>';
			}else {
				$ingredients .=	$this->cleanIngedients($ingredient['quantity'],true) . ";" . $this->cleanIngedients(JText::_($ingredient['unit']), false).';'.$this->cleanIngedients(@iconv('windows-1252//IGNORE', 'UTF-8', $ingredient['name']),false).'|';
				//ove changed - not  translated
				$ingred_txt .= "<li>" .$ingredient['quantity']."  ".JText::_($ingredient['unit'])."  ". @iconv('windows-1252//IGNORE', 'UTF-8', $ingredient['name']).'</li>';
			}
		}
		$ingred_txt .="</ul>";
		$newcookbook = $this->getTable();
		$newcookbook->catid = $this->item['catid'];
		$newcookbook->imgtitle = $this->item['title'];
		$newcookbook->alias = $alias;
		//ingredients parameterdependent
		if ($this->params->get('show_grapes') == '1' ) {
			$newcookbook->grapes = $ingred_txt;
		}
		if ($this->params->get('show_ingredients') == '1' ) {
			$newcookbook->ingredients = $ingredients;
			$rearr['attributeX'] = $ingredients;
			JRequest::setVar('attributeX1',$ingredients , 'post');
		}

		$newcookbook->properties = $this->item['preparation'];
		$newcookbook->portion = $this->item['yield'];
		$newcookbook->imgauthor = $this->item['author'] ;
		$newcookbook->published = 0;
		$newcookbook->access = 1;
		$newcookbook->created = $date_created;
		$newcookbook->created_by = $userid;
		$newcookbook->created_by_alias = $created_by_alias;

		if (!$newcookbook->store()) {
			$msgtext = JText::_('COM_GARYSCOOKBOOK_ERROR_ITEMNOTSAVED').' : '.$this->item['title'];
			JError::raiseWarning(500, $msgtext);
			continue;
		}

		$this->noitems ++; //count No of inserted recipes
	}
	public function getTable($type = 'Garyscookbook', $prefix = 'RecipeTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}