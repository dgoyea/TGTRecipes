<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

/**
 * exportRecipe()
 *
 * @param mixed $uid
 * @return
 */
function exportRecipes($catid)
{
	global $mosConfig_db, $mosConfig_sitename, $version, $option, $task, $mosConfig_dbprefix, $id, $ag_pathimages, $ag_makeMM_pic;
	global $ag_pathimages;
	$conf = &JFactory::getConfig();
	$dbGKB = &JFactory::getDBO();
	$query1 = "SELECT min(`id`) as mincad FROM `#__categories` WHERE `section`='com_garyscookbook'";
	$dbGKB->setquery($query1);
	$result = $dbGKB->loadObjectList();
	$mincad = $result[0]->mincad;
	if ($catid > $mincad) {
		$korrektur = $catid - $mincad + 2;
	}	else {
		$korrektur = 0;
	}




	$UserAgent = $_SERVER['HTTP_USER_AGENT'];
	// feststellen welcher Browser verwendet wird
	//if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $UserAgent)) {
	if (stripos($UserAgent, "Opera")){
		$UserBrowser = "Opera";
		//} elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $UserAgent)) {
	} elseif (stripos( $UserAgent,"MSIE")) {
		$UserBrowser = "IE";
	} else {
		$UserBrowser = '';
	}
	$filename = "GCB-Recipedump";
	$filename .= "_" . date("jmYHis") . ".zip";
	$sqlfilename = "gkbimport15";
	$mime_type = 'application/x-zip';
	/* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */
	$tblval = "#__garyscookbook";
	$dbGKB->setQuery("SHOW CREATE table $tblval");
	$dbGKB->query();
	$CreateTable[$tblval] = $dbGKB->loadResultArray(1);


	// Kopf erzeugen
	$OutBuffer = "";
	$OutBuffer .= "#\n";
	$OutBuffer .= "# Garyscookbook Recipes Export for Joomla 2.5 $mincad\n";
	$OutBuffer .= "# http://www.vb-dozent.net\n";
	$OutBuffer .= "#\n";
	$OutBuffer .= "# Host: $mosConfig_sitename\n";
	$OutBuffer .= "# Generation Time:    " . date("M j, Y \a\\t H:i") . "\n";
	$OutBuffer .= "# SQL Server version: " . $dbGKB->getVersion() . "\n";
	$OutBuffer .= "# PHP Version:        " . phpversion() . "\n";
	$OutBuffer .= "# Database :         `" . $conf->getValue('config.db') . "`\n# --------------------------------------------------------\n";
	$pictime = mktime();
	// Benötigte Felder festlegen für Categorien
	//INSERT INTO `jos_categories` (`id`, `parent_id`, `title`, `name`, `alias`, `image`, `section`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `editor`, `ordering`, `access`, `count`, `params`) VALUES
	//(140, 0, 'Torten', 'Torten', 'torten', 'cat-torte.png', 'com_garyscookbook', 'left', '<p><span style="color: #000000">Eine <strong>Torte</strong> (von italienisch <em>torta</em>, aus dem spätlateinischen <em>t?rta</em>, „rundes Brot“, „Brotgebäck“) ist ein feiner, aus mehreren horizontalen Schichten bestehender Kuchen, der nach dem Backen des Teigs mit Creme und/oder Früchten gefüllt und anschließend verziert wird. Bisweilen wird in Rezepten der französische Ausdruck <em>Tarte</em> verwendet.</span></p>\r\n<p><span style="color: #000000">Die meisten Torten basieren auf Biskuit oder Mürbeteig; klassische Torten kombinieren meist einen dünnen Mürbeteigboden (zur Stabilisierung des Tortenbodens) mit Schichten aus Biskuit. Die Füllung besteht häufig aus Cremes auf Grundlage von Butter (Buttercremetorte), geschlagener Sahne (Sahnetorte) oder Quark (z. B. Käsesahnetorte, Cassata), die je nach Rezept mit Zutaten wie Vanille, Kakao, Kaffee, gemahlenen Nüssen und frischen oder kandierten Früchten sowie Spirituosen aromatisiert sind. Auch Marzipan und </span><a href="http://www.garyscookbook.de/wiki/Konfit%C3%BCre" title="Konfitüre"><span style="color: #000000">Konfitüren</span></a><span style="color: #000000"> finden als Füllung Verwendung. Torten sind oft überzogen – mit der Creme, die auch zur Füllung dient, mit Glasur oder Kuvertüre – und mit Creme oder Schlagsahne aus dem Spritzbeutel, mit zu Blättern, Blüten und anderem geformter Marzipanmasse oder Schokolade und Früchten verziert.</span></p>\r\n<p><span style="color: #808080">\r\n<p><span style="font-size: 8pt; color: #808080">Quelle: Wikipedia die frei Enzyklopedie</span></p>\r\n</span></p>', 1, 0, '0000-00-00 00:00:00', NULL, 17, 0, 0, '');



	$tblval = "#__categories";
	$dbGKB->setQuery("SHOW CREATE table $tblval");
	$dbGKB->query();
	$CreateTable[$tblval] = $dbGKB->loadResultArray(1);



	$myfields = "`id`,`parent_id`, `level`, `title`, `alias`, `extension`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `hits`, `params`, `language`";
	$dbGKB->setQuery("SELECT `id`,`parent_id`, `title`, `alias`, `section`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `count`, `params` FROM #__categories WHERE section='com_garyscookbook'");
	$rows = $dbGKB->loadObjectList();
	$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES \n(";
	foreach($rows as $row) {
		$arr = JArrayHelper::fromObject($row);
		foreach($arr as $key => $value) {
			if ($key == 'id'){
				$value += $korrektur;
			}
			if ($key == 'parent_id' && $value > 1){
				$value += $korrektur;
			} elseif ( $key == 'parent_id' && $value ==0) {
				$value = 1;
			}
			if ($key == 'access'){
				$value = 1;
			}

			$value = addslashes($value);
			$value = str_replace("\n", '\r\n', $value);
			$value = str_replace("\r", '', $value);
			if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET")) {
				$InsertDump .= "'$value',";
			} else {
				$InsertDump .= "$value,";
			}
			if ($key=='parent_id') {
				$InsertDump .= "1,";
			}


		}
		$InsertDump .= "'*',";
		$InsertDump = rtrim($InsertDump, ',') . "),\n(";
	}
	$InsertDump .= "|";
	$InsertDump = str_replace('\"', '"', $InsertDump);
	$InsertDump = str_replace(",\n(|", '', $InsertDump);
	$OutBufferCat .= $InsertDump . ";\n";
	$OutBufferCat = $OutBuffer . $OutBufferCat;


   $tblval = "#__garyscookbook";
   $dbGKB->setQuery("SHOW CREATE table $tblval");
   $dbGKB->query();
   $CreateTable[$tblval] = $dbGKB->loadResultArray(1);

	// Benötigte Felder festlegen für Rezepte
	$myfields = "`id`, `catid`, `catid2`, `catid3`, `catid4`, `catid5`, `imgtitle`, `alias`, `imgauthor`, `imgtext`, `created`, `created_by`, `imgcounter`, `imgvotes`, `imgvotesum`, `published`, `access`, `imgfilename`, `imgthumbname`, `checked_out`, `checked_out_time`, `doc`, `vegan`, `price`, `country`, `portion`, `aging`, `years`, `grapes`, `ingredients`, `properties`, `notes`, `expic1`, `expic1_tn`, `expic2`, `expic2_tn`, `expic3`, `expic3_tn`, `expic4`, `expic4_tn`, `laktose`, `diaet`, `gluten`, `amount`, `kcal`, `kjoule`, `fat`, `breadunit`, `protein`, `carbohydrates`, `newdate`, `createuser`, `createip`, `changed_by`, `changeuser`, `changeip`, `ordering`, `metakey`, `metadesc`, `metadata`, `nowebsr`";
	$dbGKB->setQuery("SELECT `id`, `catid`, `catid2`, `catid3`, `catid4`, `catid5`, `imgtitle`, `alias`, `imgauthor`, `imgtext`, `imgdate`, `created_by`, `imgcounter`, `imgvotes`, `imgvotesum`, `published`, `access`, `imgfilename`, `imgthumbname`, `checked_out`, `checked_out_time`, `doc`, `vegan`, `price`, `country`, `portion`, `aging`, `years`, `grapes`, `ingredients`, `properties`, `notes`, `expic1`, `expic1_tn`, `expic2`, `expic2_tn`, `expic3`, `expic3_tn`, `expic4`, `expic4_tn`, `laktose`, `diaet`, `gluten`, `amount`, `kcal`, `kjoule`, `fat`, `breadunit`, `protein`, `carbohydrates`, `newdate`, `createuser`, `createip`, `changed_by`, `changeuser`, `changeip`, `ordering`, `metakey`, `metadesc`, `metadata`, `nowebsr` FROM #__garyscookbook ORDER BY `id`");
	$rows = $dbGKB->loadObjectList();
	$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES \n(";



	foreach($rows as $row) {
		$arr = JArrayHelper::fromObject($row);
		foreach($arr as $key => $value) {
			if ($key == 'catid'){
				$value += $korrektur;
			}
			if ($key == 'catid2' && $value > 0){
				$value += $korrektur;
			}
			if ($key == 'catid3' && $value > 0){
				$value += $korrektur;
			}
			if ($key == 'catid4' && $value > 0){
				$value += $korrektur;
			}
			if ($key == 'catid5' && $value > 0){
				$value += $korrektur;
			}
			if ($key == 'catid6' && $value > 0){
				$value += $korrektur;
			}
			if ($key == 'imgdate' && $value > 0){
				$value = date('Y-m-d H:i:s',$value);
			}

			$value = addslashes($value);
			$value = str_replace("\n", '\r\n', $value);
			$value = str_replace("\r", '', $value);
			if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET")) {
				$InsertDump .= "'$value',";
			} else {
				$InsertDump .= "$value,";
			}
		}
		$InsertDump = rtrim($InsertDump, ',') . "),\n(";
	}
	$InsertDump .= "|";
	$InsertDump = str_replace('\"', '"', $InsertDump);
	$InsertDump = str_replace(",\n(|", '', $InsertDump);
	$OutBufferRec .= $InsertDump . ";\n";
	$OutBufferRec = $OutBuffer .$OutBufferRec;


	$tblval = "#__garyscookbook_comments";
	$dbGKB->setQuery("SHOW CREATE table $tblval");
	$dbGKB->query();
	$CreateTable[$tblval] = $dbGKB->loadResultArray(1);

	// Benötigte Felder festlegen für Kommentare
	$myfields = "`cmtid`, `cmtpic`, `cmtip`, `cmtname`, `cmttext`, `cmtdate`, `published`";
	$dbGKB->setQuery("SELECT `cmtid`, `cmtpic`, `cmtip`, `cmtname`, `cmttext`, `cmtdate`, `published`  FROM #__garyscookbook_comments ORDER BY `cmtid`");
	$rows = $dbGKB->loadObjectList();
	$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES \n(";


	If (count($rows)>0){
		foreach($rows as $row) {
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
			$InsertDump = rtrim($InsertDump, ',') . "),\n(";
		}
	}
	$InsertDump .= "|";
	$InsertDump = str_replace('\"', '"', $InsertDump);
	$InsertDump = str_replace(",\n(|", '', $InsertDump);
	$OutBufferCom .= $InsertDump . ";\n";
	$OutBufferCom = $OutBuffer .$OutBufferCom;

	$tblval = "#__gkb_myrecipes";
	$dbGKB->setQuery("SHOW CREATE table $tblval");
	$dbGKB->query();
	$CreateTable[$tblval] = $dbGKB->loadResultArray(1);

	// Benötigte Felder festlegen für Kommentare
	$myfields = "`id`, `userid`, `recipeid`";
	$dbGKB->setQuery("SELECT `id`, `userid`, `recipeid`  FROM #__gkb_myrecipes ORDER BY `id`");
	$rows = $dbGKB->loadObjectList();
	$InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES \n(";


	If (count($rows)>0){
		foreach($rows as $row) {
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
			$InsertDump = rtrim($InsertDump, ',') . "),\n(";
		}
		$InsertDump .= "|";
		$InsertDump = str_replace('\"', '"', $InsertDump);
		$InsertDump = str_replace(",\n(|", '', $InsertDump);
		$OutBufferMy .= $InsertDump . ";\n";
		$OutBufferMy = $OutBuffer .$OutBufferMy;
	}

	// dump anything in the buffer
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
		include "includes/pcl/zip.lib.php";
		$zipfile = new zipfile();
		$zipfile->addFile($OutBufferCat, $sqlfilename . "cat.sql");
		$zipfile->addFile($OutBufferRec, $sqlfilename . "rec.sql");
		$zipfile->addFile($OutBufferCom, $sqlfilename . "com.sql");
		$zipfile->addFile($OutBufferMy, $sqlfilename . "my.sql");
		if ($ag_makeMM_pic && $picinklude) {
			// 'Hier muß noch das Bild eingefügt werden wenn vorhanden'
			$zipfile->addFile($bindata, $PictureImportname);
		}
		echo $zipfile->file();
		ob_end_flush();
		ob_start();
	}
	// do no more
	exit();
	break;
}

?>