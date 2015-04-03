<?php
/**
 * @package		Garyscookbook.Site
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
function exportRecipe($uid)
{
    global $mosConfig_db, $mosConfig_sitename, $version, $option, $task, $mosConfig_dbprefix, $id, $ag_pathimages, $ag_makeMM_pic;
    global $ag_pathimages;
    $conf = &JFactory::getConfig();
    $dbGKB = &JFactory::getDBO();
    $query1 = "SELECT id, catid, imgtitle, imgauthor, imgtext, imgdate, imgcounter, imgvotes, imgvotesum, published, imgfilename, imgthumbname, doc, price, country, portion, aging, years, grapes, properties, notes FROM #__garyscookbook  WHERE id = '$uid'";
    $dbGKB->setquery($query1);
    $result = $dbGKB->loadObjectList();
    $row = $result[0];
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
    $filename = preg_replace("[[:punct:]]", "" , $row->imgtitle);
    $filename .= "_" . date("jmYHis") . ".gkb";
    $filename = str_replace(" ", "_" , $filename);
    $filename = str_replace("ä", "ae" , $filename);
    $filename = str_replace("ö", "oe" , $filename);
    $filename = str_replace("ü", "ue" , $filename);
    $filename = str_replace("ß", "ss" , $filename);
    $filename = preg_replace('[^A-Za-z0-9.]', '-', $filename);
    $mime_type = 'application/x-zip';
    /* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */
    // $tblval = $mosConfig_dbprefix;
    $tblval = "#__garyscookbook";
    $dbGKB->setQuery("SHOW CREATE table $tblval");
    $dbGKB->query();
    $CreateTable[$tblval] = $dbGKB->loadResultArray(1);
    $opFile = JPATH_COMPONENT . DIRECTORY_SEPARATOR . GCB_PATHRECIMG . DIRECTORY_SEPARATOR . $row->imgfilename;
    if ($ag_makeMM_pic) {
        // 'Hier muß noch das Bild eingefügt werden wenn vorhanden'
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
    // Kopf erzeugen
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
    if ($ag_makeMM_pic && $picinklude) {
        // Benötigte Felder festlegen
        $myfields = "`catid`, `imgdate`, `imgfilename`, `imgthumbname`, `imgtitle`, `imgauthor`, `imgtext`,  `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes`";
        $dbGKB->setQuery("SELECT  `imgtitle`, `imgauthor`, `imgtext`,  `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes` FROM #__garyscookbook WHERE id='$uid'");
    } else {
        // Benötigte Felder festlegen
        $myfields = "`catid`, `imgdate`, `imgtitle`, `imgauthor`, `imgtext`, `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes`";
        $dbGKB->setQuery("SELECT `imgtitle`, `imgauthor`, `imgtext`, `doc`, `price`, `country`,`portion`,`aging`,`years`,`grapes`,`properties`,`notes` FROM #__garyscookbook WHERE id='$uid'");
    }

    $rows = $dbGKB->loadObjectList();
    if ($ag_makeMM_pic && $picinklude) {
        $InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES ( '****' , '" . $pictime . "'," . "'" . $PictureImportname . "', 'tn_" . $PictureImportname . "',";
    } else {
        $InsertDump = "INSERT INTO $tblval ( $myfields ) VALUES ( '****' , '" . $pictime . "',";
    }
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
    }
    $OutBuffer .= rtrim($InsertDump, ',') . ");\n";
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
        include "administrator/includes/pcl/zip.lib.php";
        $zipfile = new zipfile();
        $zipfile->addFile($OutBuffer, $filename . ".sql");
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