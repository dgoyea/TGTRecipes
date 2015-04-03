<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

/**
* resize_image()
* Resize Pictures
*
* @param mixed $src_file
* @param mixed $dest_file
* @param mixed $new_size
* @param mixed $method
* @param mixed $dest_qual
* @return
*/

function resize_image($src_file, $dest_file, $new_size, $method, $dest_qual)
	{
	    $imagetype = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF');
	    $imginfo = getimagesize($src_file);
	    if ($imginfo == null) die("ERROR: Source file not found!");

	    $imginfo[2] = $imagetype[$imginfo[2]];
	    // GD can only handle JPG & PNG images
	    if ($imginfo[2] != 'JPG' && $imginfo[2] != 'PNG' && $imginfo[2] != 'GIF' && ($method == 'gd1' || $method == 'gd2')) die("ERROR: GD can only handle JPG and PNG files!");
	    // height/width
	    $srcWidth = $imginfo[0];
	    $srcHeight = $imginfo[1];

	    //echo "Creating thumbnail from $imginfo[2], $imginfo[0] x $imginfo[1]...<br>";

	    $ratio = max($srcWidth, $srcHeight) / $new_size;
	    $ratio = max($ratio, 1.0);
	    $destWidth = (int)($srcWidth / $ratio);
	    $destHeight = (int)($srcHeight / $ratio);
	    // Method for thumbnails creation
	    switch ($method) {
	        case "gd1" :
	            if (!function_exists('imagecreatefromjpeg')) {
	                die('GD image library not installed!');
	            }
	            if ($imginfo[2] == 'JPG')
	                $src_img = imagecreatefromjpeg($src_file);
	            else if ($imginfo[2] == 'PNG')
	                $src_img = imagecreatefrompng($src_file);
	            else
	                $src_img = imagecreatefromgif($src_file);
	            if (!$src_img) {
	                $ERROR = $lang_errors['invalid_image'];
	                return false;
	            }
	            $dst_img = imagecreate($destWidth, $destHeight);
	            imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
	            imagejpeg($dst_img, $dest_file, $dest_qual);
	            imagedestroy($src_img);
	            imagedestroy($dst_img);
	            break;

	        case "gd2" :
	            if (!function_exists('imagecreatefromjpeg')) {
	                die('GD image library not installed!');
	            }
	            if (!function_exists('imagecreatetruecolor')) {
	                die('GD2 image library does not support truecolor thumbnailing!');
	            }
	            if ($imginfo[2] == 'JPG') {
	                $src_img = imagecreatefromjpeg($src_file);
	            } else if ($imginfo[2] == 'PNG') {
	                $src_img = imagecreatefrompng($src_file);
	            } else {
	                $src_img = imagecreatefromgif($src_file);
	            }
	            if (!$src_img) {
	                $ERROR = $lang_errors['invalid_image'];
	                return false;
	            }
	            $dst_img = imagecreatetruecolor($destWidth, $destHeight);
	            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
	            imagejpeg($dst_img, $dest_file, $dest_qual);
	            imagedestroy($src_img);
	            imagedestroy($dst_img);
	            break;
	    }
	    // Set mode of uploaded picture
	    chmod($dest_file, octdec('755'));
	    // We check that the image is valid
	    $imginfo = getimagesize($dest_file);
	    if ($imginfo == null) {
	        return false;
	    } else {
	        return true;
	    }
	}

function gcbrecipepic($expic, $title, $gcb_picwidth, $lightbox_weigth, $quality, $lightbox=FALSE){
	if ($expic) {
		//filename without path
		$filename = basename($expic);
		if (!file_exists(GCB_PATH_RECIPE_THUMBNAIL . "/tn_" .$filename )) {
			//thumbnail erzeugen
			if (strpos($expic,"images/garyscookbook/") === false) {
				$Picpath = JPATH_BASE. "images/garyscookbook/" . $expic;
				$picinkl = $expic;
			} else {
				//Neu bereits mit pfad
				//$picinkl = basename( $expic);
				$picinkl = substr($expic,21 );
			}
			if (file_exists(GCB_PATH_RECIPE_IMAGES .  $picinkl)) {
				resize_image(GCB_PATH_RECIPE_IMAGES .  $picinkl , GCB_PATH_RECIPE_THUMBNAIL . "/tn_" . $filename , $gcb_picwidth,"gd2", $quality);
			}
		}

		$gcbpic = GCB_URI_RECIPE_THUMBNAIL . "/tn_" .$filename;

		$gcbpic1 = GCB_PATH_RECIPE_IMAGES . "/tn_" .$filename;
		$db = JFactory::getDbo();
		$db->setQuery("SELECT enabled FROM #__extensions WHERE name = 'multithumb'");
		$is_enabled = $db->loadResult();

		if ($lightbox && $is_enabled) {
			//Inkl multithumb
			if (stristr(JURI::root() . $expic, GCB_URI_RECIPE_IMAGES)) {
				$picture =JURI::root() . $expic;
			} else {
				$picture = GCB_URI_RECIPE_IMAGES .$expic;
			}
			$showpic ="{multithumb thumb_width=" . $gcb_picwidth . " thumb_height=" . $gcb_picwidth . " thumb_proportions=bestfit resize=1 full_width=" . $lightbox_weigth . " quality=" . $quality . " full_height=" . $lightbox_weigth . " image_proportions=bestfit blog_mode=popup}<img src=\"$picture\" hspace=\"4\" border=\"0\" title=\"$title\"/>";
			$showpic =  JHTML::_('content.prepare', $showpic, '','com_garyscookbook.recipe');
			return $showpic;
		}else{
			return "<img style=\"width:". $gcb_picwidth ."px;\" class=\"gcbpic\" title=\"" . $title . "\" src=\"$gcbpic\"/>";
		}

	} else {
		//Keine Bilder
		$gcbpic = $this->nopic;
		return "<img style=\"width:". $gcb_picwidth ."px;\" class=\"gcbpic\" title=\"$this->escape($title)\" src=\"$gcbpic\"/>";
	}
}

function isexpic($item) {
	if ($item->expic1 || $item->expic2 ||$item->expic3 ||$item->expic4) {
		return true;
	}
	return false;
}

function isinfavorit($userid, $recipeid){
	$db = JFactory::getDBO();
	$query = "Select * FROM #__gkb_myrecipes WHERE userid='$userid' AND recipeid='$recipeid'";
	$db->setquery($query);
	$result=$db->loadObjectList();
	if(count($result)>0) {
		//Errorhandling


		return TRUE;
	}
	return FALSE;


}
?>