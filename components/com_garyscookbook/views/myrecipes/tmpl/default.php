<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/helpers/gcbdesign.php';
require_once JPATH_COMPONENT.'/helpers/icon.php';
if ($this->params->get('show_recipe_offline')) { ?>
	<div class="categories-list<?php echo $this->pageclass_sfx;?>">
	<?php	GaryscookbookHelperDesign::showArticle($this->params->get('show_recipe_offline_art'));
} else {
GaryscookbookHelperDesign::gcbheader($this->params, $this->state);

//$canEdit	= $this->params->get('access-edit');
$canEdit	= $this->category->getParams()->get('access-edit')
?>
<div class="garyscookbook-category<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->def('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<?php if($this->params->get('show_category_title', 1)) : ?>
<h2>
	<?php switch($this->params->get('show_fav_description', 0)){
		case 1:
			echo JText::_('COM_GARYSCOOKBOOK_MYRECIPES_FAVORITS_ONLY');
			break;
		case 2:
			echo JText::_('COM_GARYSCOOKBOOK_MYRECIPES_ONLY');
			break;
		default:
			echo JText::_('COM_GARYSCOOKBOOK_MYRECIPES_FAVORITS');
	} // switch
	?>
</h2>
<?php endif; ?>

<?php if ($canEdit && $this->params->get('show_add_icon') && $this->params->get('show_recipe_fp_allow')) : ?>
		<div><?php echo JHtml::_('icon.add',  $this->items, $this->params);?></div>
<?php endif; ?>

<?php
	if (count( $this->items)) {
		echo $this->loadTemplate('items');
	}
	if (count( $this->ownrecipes)) {

	echo $this->loadTemplate('ownrecipes');
	}?>
<?php }
GaryscookbookHelperDesign::gcbfooter($this->params, $this->state);
?>
</div>