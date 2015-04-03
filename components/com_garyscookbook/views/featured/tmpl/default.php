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

?>
<div class="garyscookbook-category<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->def('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<?php if ($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc">
	<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<img class="gcbcatpic" src="<?php echo $this->category->getParams()->get('image'); ?>"/>
	<?php endif; ?>
	<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
	<div class="gcb-cat-children">
		<h3><?php echo JText::_('JGLOBAL_SUBCATEGORIES') ; ?></h3>
		<?php echo $this->loadTemplate('children'); ?>
	</div>
	<?php endif;?>
	<?php if ($this->params->get('show_description') && $this->category->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->category->description); ?>
	<?php endif; ?>
	<div class="clr"></div>
	</div>
<?php endif; ?>


	$version = new JVersion();
	$currentVersion = $version->getShortVersion();
	$isJoomla30 = version_compare($currentVersion, '3.0', '>=');
	if ($isJoomla30) {
		echo $this->loadTemplate('items_3');
	} else {
		echo $this->loadTemplate('items');
	}
?>


<?php }
GaryscookbookHelperDesign::gcbfooter($this->params, $this->state);
?>
</div>