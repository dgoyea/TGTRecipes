<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/helpers/gcbdesign.php';
require_once JPATH_COMPONENT.'/helpers/helper.php';
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$cparams = JComponentHelper::getParams ('com_media');
echo JHtml::_('icon.print_screen',  $this->garyscookbook, $this->params);
GaryscookbookHelperDesign::gcbheader( $this->params);

?>
<div class="garyscookbook<?php echo $this->pageclass_sfx?>">




<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
	<?php if ($this->garyscookbook->imgtitle) : ?>
		<h2>
			<span class="garyscookbook-name"><?php echo $this->garyscookbook->imgtitle; ?></span>
		</h2>
	<?php endif;  ?>
	<?php if ($this->params->get('show_recipe_category') == 'show_no_link') : ?>
		<h3>
			<span class="garyscookbook-category"><?php echo $this->garyscookbook->category_title; ?></span>
		</h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_recipe_category') == 'show_with_link') : ?>
		<?php $garyscookbookLink = GaryscookbookHelperRoute::getCategoryRoute($this->garyscookbook->catid);?>
		<h3>
			<span class="garyscookbook-category"><a href="<?php echo $garyscookbookLink; ?>">
				<?php echo $this->escape($this->garyscookbook->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>
		<?php  echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_DETAILS').'</h3>'; ?>
	<?php echo $this->loadTemplate('recipe'); ?>

	<p></p>
	<?php if ($this->params->get('show_expic') && isexpic($this->garyscookbook)) : ?>
		<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_EXPIC_FORM').'</h3>'; ?>
		<?php echo $this->loadTemplate('expic'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_ingredients') || $this->params->get('show_grapes') ) : ?>
		<?php  echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_INGREDIENTS_FORM').'</h3>';  ?>
		<?php echo $this->loadTemplate('ingredients'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_properties') ) : ?>
		<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_PREPARATIONS_FORM').'</h3>'; ?>
		<?php echo $this->loadTemplate('preparation'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_details') ) : ?>
		<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_DETAILS').'</h3>'; ?>
		<?php echo $this->loadTemplate('details'); ?>
	<?php endif; ?>

	<?php if ($this->garyscookbook->notes && $this->params->get('show_notes')) : ?>
		<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_OTHER_INFORMATION').'</h3>'; ?>
			<div class="garyscookbook-misc">
				<?php echo $this->garyscookbook->notes; ?>
			</div>
	<?php endif; ?>
<?php GaryscookbookHelperDesign::gcbfooter( $this->params);	?>
</div>
