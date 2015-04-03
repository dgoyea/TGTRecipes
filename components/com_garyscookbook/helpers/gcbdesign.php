<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access
defined('_JEXEC') or die;

abstract class GaryscookbookHelperDesign {
	protected $state = null;


	/**
	 * GaryscookbookHelperDesign::gcbheader()
	 *
	 * @param integer $state
	 * @return
	 */
	public static function gcbheader($params, $state=0)
	{
		//Escape strings for HTML output
		$pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));
		$canEdit	= $params->get('access-edit');

		?>
		<div class="gcb-header<?php echo $pageclass_sfx;?>">
			<h2 class="contentheading"><?php echo $params->get('garyscookbook_name')?></h2>
			<?php if ($params->get('show_header_logo')) { ?>
				<?php if ($params->get('own_header_logo')) { ?>
					<img src="<?php echo JURI::base() . $params->get('own_header_logo'); ?>" hspace="6" border="0" align="middle" alt="Cookbook"/>
				<?php } else { ?>
					<img src="<?php echo GCB_URI_IMAGES. 'home.gif'; ?>" hspace="6" border="0" align="middle" alt="Cookbook"/>
				<?php } ?>
			<?php } ?>

		</div>
		<div class="gcb-toolbar<?php echo $pageclass_sfx;?>">

		</div>
		<?php
		if($params->get('show_recipe_intro_art',0) > 0 ){
			GaryscookbookHelperDesign::showArticle($params->get('show_recipe_intro_art',0));
		}
	}

	/**
	 * GaryscookbookHelperDesign::gcbfooter()
	 *
	 * @param integer $state
	 * @return
	 */
	public static function gcbfooter($params, $state=0)
	{
	//SELECT * FROM `#__extensions` WHERE element ='com_garyscookbook'
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM `#__extensions` WHERE element ='com_garyscookbook'");
		$items = $db->loadObjectList();
		$item = $items[0];
		if (strlen($item->manifest_cache)) {
			$data = json_decode($item->manifest_cache);
			if ($data) {
				foreach($data as $key => $value) {
					if ($key == 'type') {
						// ignore the type field
						continue;
					}
					$item->$key = $value;
				}
			}
		}
		$Version = $item->version;
		//Escape strings for HTML output
		$pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));
		?>
		<div class="gcb-footer<?php echo $pageclass_sfx;?>">
			<?php if ($params->get('show_logo')) { ?>
				<img src="<?php echo GCB_URI_IMAGES . 'garyscookbook.png'; ?>" hspace="6" border="0" align="middle" alt="Cookbook"/>
			<?php } ?>
			<div class="gcbfooterlink">
			<a href="http://www.garyscookbook.de" target="_blank"><b>Powered by Gary´s Cookbook V <?php echo $Version; ?></b></a></div>
		</div>
		<?php

	}

	function showArticle(&$article_id){
		?>
		<div class="com_garyscookbook_article">
		<?php

		if($article_id >0){

			$db= JFactory::getDBO();
			$sql = 'SELECT `introtext`,`fulltext` FROM #__content WHERE id=' . $article_id;
			$db->setQuery($sql);
			$object = $db->loadObject();

			if(isset($object)){
				echo $object->introtext . $object->fulltext;
			}

		}

		?>
		</div>
		<?php
	}

}
?>
