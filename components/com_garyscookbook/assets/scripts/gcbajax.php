<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */



// Set flag that this is a parent file
define('_JEXEC', 1);


// no direct access
defined('_JEXEC') or die('Restricted access');

define( 'DS', DIRECTORY_SEPARATOR );

define('JPATH_BASE', dirname(__FILE__).DS.'..'.DS.'..'.DS.'..'.DS.'..' );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

jimport('joomla.database.database');
jimport('joomla.database.table');

$app = JFactory::getApplication('site');
$app->initialise();

$user = JFactory::getUser();

$params = new JRegistry;
//$params->loadJSON($app->params);
$params = $app->getParams();
if ( $params->get('access') == 1 && !$user->get('id') ) {
	echo 'login';
} else {
	$user_rating = JRequest::getInt('user_rating');
	$cid = JRequest::getInt('cid');
	$db  = JFactory::getDBO();
	if (($user_rating >= 1) and ($user_rating <= 5)) {
		$currip = ( phpversion() <= '4.2.1' ? @getenv( 'REMOTE_ADDR' ) : $_SERVER['REMOTE_ADDR'] );
			$query = "SELECT * FROM #__garyscookbook WHERE id = " . $cid;
			$db->setQuery( $query );
			$votesdb = $db->loadObject();
			if ($currip != ($votesdb->used_ips) or  $currip =="::1") {
				$query = "UPDATE #__garyscookbook"
				. "\n SET imgvotes = imgvotes + 1, imgvotesum = imgvotesum + " .   $user_rating . ", used_ips = " . $db->Quote( $currip )
				. "\n WHERE id = " . $cid;
				$db->setQuery( $query );
				$db->query() or die( $db->stderr() );
			} else {
				echo 'voted';
				exit();
			}
		echo 'thanks';
	}
}
?>