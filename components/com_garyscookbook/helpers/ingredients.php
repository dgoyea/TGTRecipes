<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die('Restricted access');
//require_once( JPATH_SITE . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_garyscookbook' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'class.inputfilter.php' );
function loadAttributeExtension( $attribute_string = false ) {
global $VM_LANG ;
?>
<input type="hidden" name="js_lbl_title" value="Titel" />
<input type="hidden" name="js_lbl_property" value="<?php echo JText::_('Ingredient'); ?>" />
<input type="hidden" name="js_lbl_property_new" value="<?php echo JText::_('New Ingredients'); ?>" />
<input type="hidden" name="js_lbl_amount" value="<?php echo JText::_('amount1'); ?>" />
<input type="hidden" name="js_lbl_amountname" value="<?php echo JText::_('amount name'); ?>" />
<input type="hidden" name="js_lbl_delete" value="<?php echo JText::_('Ingredient delete'); ?>" />
<?php
if( ! $attribute_string ) {
// product has no attributes
?>
	<table id="attributeX_table_0" cellpadding="0" cellspacing="0" 	border="0" class="adminform" >
		<tbody width="30%">
		<tr>
			<td width="5%" colspan="4" align="left">
				<a href="javascript: newProperty(0)"><?php echo JText::_('New Ingredients'); ?></a>
			</td>
			<td colspan="2" align="left">
			 	&nbsp;
			</td>
		</tr>
		<tr id="attributeX_tr_0_0">
			<td width="5%" align="right">
				<?php echo JText::_('amount1'); ?>
			</td>
			<td align="left" width="10%">
				<input type="text" name="attributeX[0][amount][]" size="3" value="" />
			</td>
			<td align="right" width="5%">
				<?php echo JText::_('amount name'); ?>
			</td>
			<td align="left" width="10%">
				<input type="text" name="attributeX[0][amountname][]" size="4" value="" />
			</td>
			<td width="10%" align="right">
				<?php echo JText::_('Ingredient'); ?>
			</td>
			<td align="left" width="65%">
				<input type="text" name="attributeX[0][value][]" size="45" value="" />
			</td>

		</tr>
		</tbody>
	</table>
<?php
return ;
}

// split multiple attributes
$options = explode( '|', $attribute_string ) ;
$dropdown_name = $options[0] ;

// display each attribute in the first loop...
?>
<table id="attributeX_table_0" cellpadding="0" cellspacing="0" 	border="0" class="adminform" >
	<tbody width="30%">
		<tr>
			<td width="5%" colspan="4" align="left">
				<a href="javascript: newProperty(0)"><?php echo JText::_('New Ingredients'); ?></a>
			</td>
			<td colspan="2" align="left">
			 	&nbsp;
			</td>
		</tr>

<?php $i = 0;
for( $i2 = 0, $n2 = count( $options )-1 ; $i2 < $n2 ; $i2 ++ ) {
$value = $options[$i2] ;
if( explode( ';', $value ) ) {
$value_Ingredients = explode( ';', $value ) ; ?>
		<tr id="attributeX_tr_<?php echo $i . "_" . $i2 ; ?>">
			<td width="5%" align="left">
				<?php echo JText::_('amount1') ;	?>
			</td>
			<td align="left" width="10%">
				<input type="text" name="attributeX[<?php echo $i ;	?>][amount][]" size="3" value="<?php echo $value_Ingredients[0] ; ?>" />
			</td>
			<td align="right" width="5%">
				<?php echo JText::_('amount name'); ?>
			</td>
			<td align="left" width="10%">
				<input type="text" name="attributeX[<?php echo $i ;	?>][amountname][]" size="4" value="<?php echo $value_Ingredients[1] ; ?>" />
			</td>
			<td width="10%" align="right">
				<?php echo JText::_('Ingredient'); ?>
			</td>
			<td align="left" width="65%">
				<input type="text" name="attributeX[<?php echo $i ;	?>][value][]" size="45" value="<?php echo $value_Ingredients[2] ; ?>" />
				<a href="javascript:deleteProperty(<?php echo ($i) ; ?>,'<?php echo $i . "_" . $i2 ;?>');"><?php echo JText::_('Ingredient delete'); ?></a>
			</td>
		</tr>
	<?php
}
}
?>
	</tbody>
</table>
<?php

}


/**
 * formatAttributeX()
 *
 * @return
 */
function formatAttributeX() {
	// request attribute pieces
	$attributeX = GCBGet( $_POST, 'attributeX', array( 0 ) ) ;
	$attribute_string = '' ;

	// no pieces given? then return
	if( empty( $attributeX ) ) {
		return $attribute_string ;
	}

	// erzeugt eine Tabelle mit den Zutaten
	// ; Feldtrenner | Recordtrenner
	foreach( $attributeX as $attributes ) {
		$n2 = count( $attributes['value'] ) ;
		for( $i2 = 0 ; $i2 < $n2 ; $i2 ++ ) {
			$amount = $attributes['amount'][$i2] ;
			$amountname = $attributes['amountname'][$i2] ;
			$value = $attributes['value'][$i2] ;
			if( ! is_null( $value ) && $value != '' ) {
				$search  = array(';', '|');
				$replace = array(',', ',');
				$search1  = array(';', '|', ',');
				$replace1 = array('', '', '.');
				$attribute_string .= trim(str_replace($search1,$replace1,$amount)) . ';' . trim(str_replace($search,$replace , $amountname)) . ';' . trim(str_replace($search,$replace ,  $value )) . '|';
			}
		}

	}
	return trim( $attribute_string );


}

function showAttributeX($attribute_string, $oldPortion = 1, $newPortion, $id, $Itemid, $calButton, $catid) {
// split multiple attributes
$options = explode( '|', $attribute_string ) ;
$dropdown_name = $options[0] ;
$attribut_return = '';
$i = 0;
// display each attribute in the first loop...
$attribut_return .= "<table id=\"attributeX_table_0\" cellpadding=\"3\" cellspacing=\"3\" 	border=\"0\" class=\"ingedientform\" >";
$attribut_return .= "<tbody width=\"50%\">";
	$attribut_return .= "<tr><td colspan = \"3\" class=\"ingfirstrow\"><h4>";
	//http://localhost/gkb17/index.php?option=com_recipe&view=recipe&id=2452:bunt-geschnetzeltes-schweinefleisch-mit-chinakohl&catid=14&Itemid=260

	$link =JRoute::_("index.php?option=com_garyscookbook&&view=recipe&Itemid=$Itemid&id=$id&catid=$catid");
if (!$calButton) {
	$attribut_return .= "<form action=\"" . $link . "\" method=\"post\">";
	$attribut_return .= JText::_('COM_GARYSCOOKBOOK_INGREDIENTS_FOR') . " <input name=\"newportion\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$newPortion\"> ".JText::_('COM_GARYSCOOKBOOK_PORTIONS');
	$attribut_return .= " <input class=\"gcbbutton\"type=\"submit\" value=\"  ". JText::_('COM_GARYSCOOKBOOK_RECAL'). "  \"></form></h4><hr /><br />";
} else {
	$attribut_return .= JText::_('COM_GARYSCOOKBOOK_INGREDIENTS_FOR') . " " . $newPortion . " ".JText::_('COM_GARYSCOOKBOOK_PORTIONS');
}
	$attribut_return .= "</td>";
	$attribut_return .= "				</tr>";

for( $i2 = 0, $n2 = count( $options )-1 ; $i2 < $n2 ; $i2 ++ ) {
	$value = $options[$i2] ;
	if( explode( ';', $value ) ) {
		$value_Ingredients = explode( ';', $value ) ;
		$attribut_return .= "<tr id=\"attributeX_tr_$i"."_$i2\">";

if ($value_Ingredients[1] == "xyz") :
	//Zutatenkategorie
	$attribut_return .= "<td align=\"right\" colspan=\"3\"><h3>";
	$attribut_return .= $value_Ingredients[2] ;
	$attribut_return .= "</h3></td>";
else :
	$attribut_return .= "<td align=\"right\" width=\"30%\">";
	if (is_numeric($value_Ingredients[0]) && $oldPortion > 0 ) :
		$Ingredient =  $value_Ingredients[0]/ $oldPortion * $newPortion ;
		if (strpos($Ingredient, ".")> 0) :
			$attribut_return .= number_format($Ingredient, 2, JText::_('COM_GARYSCOOKBOOK_DEZIMALSEPERATOR'), JText::_('COM_GARYSCOOKBOOK_THOUSANDSEPERATOR'));
		else:
			$attribut_return .= $Ingredient;
		endif;

	else :
		$attribut_return .= "-";
	endif;
	$attribut_return .= "</td>";
	$attribut_return .= "<td align=\"left\" >";
	$attribut_return .= $value_Ingredients[1] ;
	$attribut_return .= "</td>";
	$attribut_return .= "<td align=\"left\" >";
	$attribut_return .= $value_Ingredients[2] ;
	$attribut_return .= "</td>";
endif;
$attribut_return .= "</tr>";

			}
		}
$attribut_return .= "</tbody>";
$attribut_return .= "</table>";

return $attribut_return;
}

/**
 * GCBGet()
 *
 * @param mixed $arr
 * @param mixed $name
 * @param mixed $def
 * @param integer $mask
 * @return
 */
function GCBGet( &$arr, $name, $def=null, $mask=0 ) {
	// Static input filters for specific settings

	static $noHtmlFilter	= null;
	static $safeHtmlFilter	= null;

	$var = GCBGetArrayValue( $arr, $name, $def, '' );

	// If the no trim flag is not set, trim the variable
	if (!($mask & 1) && is_string($var)) {
		$var = trim($var);
	}

	// Now we handle input filtering
	if ($mask & 2) {
		// If the allow raw flag is set, do not modify the variable
		$var = $var;
	} elseif ($mask & 4) {
		// If the allow html flag is set, apply a safe html filter to the variable
		if (is_null($safeHtmlFilter)) {
			$safeHtmlFilter = & gcbInputFilter::getInstance(null, null, 1, 1);
		}
		$var = $safeHtmlFilter->clean($var, 'none');
	} else {
		// Since no allow flags were set, we will apply the most strict filter to the variable
		if (is_null($noHtmlFilter)) {
			$noHtmlFilter = & gcbInputFilter::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
		}
		$var = $noHtmlFilter->clean($var, 'none');
	}
	return $var;
}

/**
 * Utility function to return a value from a named array or a specified default
 *
 * @static
 * @param	array	$array		A named array
 * @param	string	$name		The key to search for
 * @param	mixed	$default	The default value to give if no key found
 * @param	string	$type		Return type for the variable (INT, FLOAT, STRING, WORD, BOOLEAN, ARRAY)
 * @return	mixed	The value from the source array
 * @since	1.1
 */
function GCBGetArrayValue(&$array, $name, $default=null, $type='') {
	// Initialize variables
	$result = null;

	if (isset ($array[$name])) {
		$result = $array[$name];
	}

	// Handle the default case
	if ((is_null($result))) {
		$result = $default;
	}

	// Handle the type constraint
	switch (strtoupper($type)) {
		case 'INT' :
		case 'INTEGER' :
			// Only use the first integer value
			@ preg_match('/-?[0-9]+/', $result, $matches);
			$result = @ (int) $matches[0];
			break;

		case 'FLOAT' :
		case 'DOUBLE' :
			// Only use the first floating point value
			@ preg_match('/-?[0-9]+(\.[0-9]+)?/', $result, $matches);
			$result = @ (float) $matches[0];
			break;

		case 'BOOL' :
		case 'BOOLEAN' :
			$result = (bool) $result;
			break;

		case 'ARRAY' :
			if (!is_array($result)) {
				$result = array ($result);
			}
			break;

		case 'STRING' :
			$result = (string) $result;
			break;

		case 'WORD' :
			$result = (string) preg_replace( '#\W#', '', $result );
			break;

		case 'NONE' :

		default :
			// No casting necessary
			break;
	}
	return $result;
}



?>