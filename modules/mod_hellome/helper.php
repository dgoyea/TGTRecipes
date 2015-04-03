<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die('Restricted access');

if(!class_exists('modHelloMeHelper'))
{
	class modHelloMeHelper
	{
		function getType()
		{
			$user = JFactory::getUser();
			return (!$user->get('guest')) ? 'logout' : 'login';
		}

		function getReturnURL($params, $type)
		{
			if($itemid =  $params->get($type))
			{
				$menu = JSite::getMenu();
				$item = $menu->getItem($itemid);
				$url = JRoute::_($item->link.'&Itemid='.$itemid, false);
			}
			else
			{
				$url = JURI::base(true);
			}

			return base64_encode($url);
		}

		function isFacebookUser()
		{
			$my		= CFactory::getUser();

			// Script needs to be here if they are

			// Once they reach here, we assume that they are already logged into facebook.
			// Since CFacebook library handles the security we don't need to worry about any intercepts here.
			$connectTable	= JTable::getInstance( 'Connect' , 'CTable' );
			$facebook		= new CFacebook();
			$fbUser			= $facebook->getUser();

			if( !$fbUser )
			{
				return false;
			}

			if(!isset($fbUser['id'])){
				return false;
			}

			$connectTable->load( $fbUser['id'] );
			$isFacebookUser	= ( $connectTable->userid == $my->id ) ? true : false;

			return $isFacebookUser;
		}

		function getHelloMeScript($profileStatus, $isMine)
		{
			$cleanProfileStatus = str_replace( array("\r\n", "\n", "\r"), "", $profileStatus );
			$cleanProfileStatus = addslashes($cleanProfileStatus);

			$profileStatus      = html_entity_decode( $profileStatus );
			$profileStatus      = preg_replace( '/<br\s*\/?>/', '', $profileStatus );
			$profileStatus      = preg_replace( '/\n/', ' ', $profileStatus );
			$profileStatus      = preg_replace( '/<a[^>]*>([^<>]*)<\/a>/', '$1', $profileStatus );
			$profileStatus      = addslashes( $profileStatus );

			$isMineScript       = '';

			if($isMine)
			{
				$isMineScript = '
					if(joms.jQuery(\'#profile-status-message\').length>0)
					{
						joms.jQuery(\'#profile-status-message\').html(inputVal);
					}

					if(joms.jQuery(\'#statustext\').length>0)
					{
						joms.jQuery(\'#statustext\').val(inputVal);
					}';
			}

			$script =<<<SHOWJS
				var helloMe = {
					changeStatus:function(){
						joms.jQuery('#helloMeEdit').show();
						joms.jQuery('#helloMeDisplay').hide();
						joms.jQuery('#editLink').hide();
						joms.jQuery('#saveLink').show();
						cur_status = joms.jQuery('#helloMeStatusText').val();

					},
					saveStatus:function(){
						if ( cur_status != joms.jQuery('#helloMeStatusText').val() ) {
							var inputVal	= joms.jQuery('#helloMeStatusText').val();
							//inputVal = escape(inputVal);
							joms.jQuery('#hellomeLoading').show();
							jax.call('community', 'status,ajaxUpdate', inputVal);
							$isMineScript
							//joms.jQuery('#helloMeStatus').html(inputVal);
							//joms.jQuery('title').val(inputVal);
							cur_status = inputVal;
						}
						joms.jQuery('#helloMeEdit').hide();
						joms.jQuery('#helloMeDisplay').show();
						joms.jQuery('#editLink').show();
						joms.jQuery('#saveLink').hide();
						return false;
					},
					saveChanges:function(e){
						var unicode = e.keyCode? e.keyCode : e.charCode;

						if ( unicode == 13 )
						{
							helloMe.saveStatus();
							return false;
						}
					},
					logout:function(){
						document.hellomelogout.submit();
					}
				};

				joms.jQuery(document).ready( function() {
					joms.jQuery('#helloMeStatus').html('$cleanProfileStatus');
					joms.jQuery('#helloMeStatusText').val('$profileStatus');
				});
SHOWJS;
				return $script;
		}
	}
}