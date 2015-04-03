<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */



defined('_JEXEC') or die;

/**
 * showstars()
 *
 * @param mixed $id
 * @param mixed $rating_sum
 * @param mixed $rating_count
 * @param integer $counter
 * @param integer $unrated
 * @param string $small for small rating pics use '-small'
 * @return
 */
function showstars( $id, $rating_sum, $rating_count,$counter = 1,$unrated = 1, $small=""){
	global $plgContentExtraVoteAddScript;
	$document = JFactory::getDocument();

	$percent = 0;
	if(!$plgContentExtraVoteAddScript){
		$document->addScriptDeclaration( "var sfolder = '".JURI::base(true)."';
		var gcbvote_text=Array('".JTEXT::_('COM_GCB_NO_AJAX')."','".JTEXT::_('COM_GCB_LOADING')."','".JTEXT::_('COM_GCB_THANKS')."','".JTEXT::_('COM_GCB_LOGIN')."','".JTEXT::_('COM_GCB_RATED')."','".JTEXT::_('COM_GCB_VOTES')."','".JTEXT::_('COM_GCB_VOTE')."');");
		$plgContentExtraVoteAddScript = 1;
	}

	if($rating_count!=0) {
		$percent = number_format((intval($rating_sum) / intval( $rating_count ))*20,2);
	} elseif ($unrated == 0) {
		$counter = -1;
	}

		if ( $counter == 3 ) $counter = 0;
		$br = "<br />";

		$html = "
		<span class=\"gcbvote-container".$small."\">
		  <ul class=\"gcbvote-items".$small."\">
		    <li id=\"rating_".$id."\" class=\"current-rating\" style=\"width:".(int)$percent."%;\"></li>
		    <li><a href=\"javascript:void(null)\" onclick=\"javascript:GCBVoting(".$id.",1,".$rating_sum.",".$rating_count.",".$counter.");\" title=\"".JTEXT::_('COM_GCB_VERY_POOR')."\" class=\"vot-item1\">1</a></li>
		    <li><a href=\"javascript:void(null)\" onclick=\"javascript:GCBVoting(".$id.",2,".$rating_sum.",".$rating_count.",".$counter.");\" title=\"".JTEXT::_('COM_GCB_POOR')."\" class=\"vot-item2\">2</a></li>
		    <li><a href=\"javascript:void(null)\" onclick=\"javascript:GCBVoting(".$id.",3,".$rating_sum.",".$rating_count.",".$counter.");\" title=\"".JTEXT::_('COM_GCB_REGULAR')."\" class=\"vot-item3\">3</a></li>
		    <li><a href=\"javascript:void(null)\" onclick=\"javascript:GCBVoting(".$id.",4,".$rating_sum.",".$rating_count.",".$counter.");\" title=\"".JTEXT::_('COM_GCB_GOOD')."\" class=\"vot-item4\">4</a></li>
		    <li><a href=\"javascript:void(null)\" onclick=\"javascript:GCBVoting(".$id.",5,".$rating_sum.",".$rating_count.",".$counter.");\" title=\"".JTEXT::_('COM_GCB_VERY_GOOD')."\" class=\"vot-item5\">5</a></li>
		  </ul>
		</span>
		  <span id=\"gcbvote_".$id."\" class=\"gcbvote-count\"><small>";
	if ( $counter != -1 ) {
		if ( $counter != 0 ) {
			$html .= "( ";
			if($rating_count!=1) {
				$html .= $rating_count." ".JTEXT::_('COM_GCB_VOTES');
			} else {
				$html .= $rating_count." ".JTEXT::_('COM_GCB_VOTE');
			}
			$html .=" )";
		}
	}
	$html .="</small></span>&nbsp;" . $br;

	return $html;
}

function showstarsonly( $id, $rating_sum, $rating_count,$counter = 1,$unrated = 1, $small=""){
	$percent = 0;
	if($rating_count!=0) {
		$percent = number_format((intval($rating_sum) / intval( $rating_count ))*20,2);
	} elseif ($unrated == 0) {
		$counter = -1;
	}

	if ( $counter == 3 ) $counter = 0;
	$br = "<br />";

	$html = "
		<span class=\"gcbvote-container".$small."\">
		  <ul class=\"gcbvote-items".$small."\">
		    <li id=\"rating_".$id."\" class=\"current-rating\" style=\"width:".(int)$percent."%;\"></li>

		  </ul>
		</span>
		  <span id=\"gcbvote_".$id."\" class=\"gcbvote-count\"><small>";
	if ( $counter != -1 ) {
		if ( $counter != 0 ) {
			$html .= "( ";
			if($rating_count!=1) {
				$html .= $rating_count." ".JTEXT::_('COM_GCB_VOTES');
			} else {
				$html .= $rating_count." ".JTEXT::_('COM_GCB_VOTE');
			}
			$html .=" )";
		}
	}
	$html .="</small></span>&nbsp;" . $br;

	return $html;
}

?>