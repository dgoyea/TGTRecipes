<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (COMMUNITY_COM_PATH.'/libraries/fields/profilefield.php');

class CFieldsCountry extends CProfileField
{
	/**
	 * Method to format the specified value for text type
	 **/
	public function getFieldData( $field )
	{
		$value = $field['value'];
		if( empty( $value ) )
			return $value;

		return $value;
	}

	public function getFieldHTML( $field , $required )
	{
		// If maximum is not set, we define it to a default
		$field->max	= empty( $field->max ) ? 200 : $field->max;

		$class	= ($field->required == 1) ? ' required' : '';

		// @since 2.4 detect language and call current language country list
		if (!defined('COUNTRY_LANG_AVAILABLE')) {
		    define('COUNTRY_LANG_AVAILABLE', 1);
		}

		$lang = JFactory::getLanguage();
		$locale = $lang->getLocale();
		$countryCode = $locale[2];
		$countryLangExtension = "";

		$lang->load( 'com_community.country'); 

		$countryListLanguage =   explode(',', trim(COUNTRY_LIST_LANGUAGE) );
		if(in_array($countryCode,$countryListLanguage)==COUNTRY_LANG_AVAILABLE){
		    $countryLangExtension = "_".$countryCode;
		}
		jimport( 'joomla.filesystem.file' );
		$file	= JPATH_ROOT .'/components/com_community/libraries/fields/countries'.$countryLangExtension.'.xml';

		if( !JFile::exists( $file ) )
		{
			//default country list file
			$file = JPATH_ROOT .'/components/com_community/libraries/fields/countries.xml';
		}

		$contents	= JFile::read( $file );
		$parser		= new SimpleXMLElement($file,NULL,true);
		$document	= $parser->document;
		$countries		= $parser->countries;

		$tooltips		= !empty( $field->tips ) ? ' title="' .  CStringHelper::escape( JText::_( $field->tips ) ) . '"' : '';
		ob_start();

        // build an array with TRANSLATED country names as keys...
        foreach($countries->country as $country){
            $name = (string) $country->name;
            $countriesSorted[$name] = JText::_($name);
        }

        // ...so it can be properly key-value natural-sorted
        uksort($countriesSorted, 'CStringHelper::compareAscii');

        ?>
		<select id="field<?php echo $field->id;?>" name="field<?php echo $field->id;?>" class="<?php echo !empty( $field->tips ) ? 'jomNameTips tipRight ' : '';?>select validate-country<?php echo $class;?>"<?php echo $tooltips;?>>
			<option value=""<?php echo empty($field->value) ? ' selected="selected"' : '';?>><?php echo JText::_('COM_COMMUNITY_SELECT_A_COUNTRY');?></option>
		<?php

		foreach($countriesSorted as $countryCode=>$countryName)
		{
		?>
			<option value="<?php echo $countryCode;?>"<?php echo ($field->value == $countryCode) ? ' selected="selected"' : '';?>><?php echo $countryName;?></option>
		<?php
		}
		?>
		</select>
		<span id="errfield<?php echo $field->id;?>msg" style="display:none;">&nbsp;</span>
<?php
		$html	= ob_get_contents();
		ob_end_clean();

		return $html;
	}

	public function isValid( $value , $required )
	{
		if( $value === 'selectcountry' && $required )
			return false;

		return true;
	}

}