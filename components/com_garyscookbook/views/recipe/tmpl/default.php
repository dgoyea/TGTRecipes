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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
if ($this->params->get('show_recipe_offline')) { ?>
	<div class="categories-list<?php echo $this->pageclass_sfx;?>">
	<?php	GaryscookbookHelperDesign::showArticle($this->params->get('show_recipe_offline_art'));
} else {
GaryscookbookHelperDesign::gcbheader($this->params, $this->state);
$cparams = JComponentHelper::getParams ('com_media');
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
	<?php if ($this->params->get('show_garyscookbook_list') && count($this->garyscookbooks) > 1) : ?>

		<form action="#" method="get" name="selectForm" id="selectForm">

			<?php echo JText::_('COM_GARYSCOOKBOOK_SELECT_RECIPE'); ?>

			<?php echo JHtml::_('select.genericlist',  $this->garyscookbooks, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'imgtitle', $this->garyscookbook->link);?>

		</form>

	<?php endif; ?>

		<?php  echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_DETAILS').'</h3>'; ?>

	<?php echo $this->loadTemplate('recipe'); ?>



	<p></p>
<?php $start =""; ?>
	<?php if ($this->params->get('show_expic') && isexpic($this->garyscookbook)) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
		<?php $start = 1; ?>
		<?php  echo  JHtml::_($this->params->get('presentation_style').'.start', 'garyscookbook-slider'); ?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_EXPIC_FORM'), 'display-expic'); ?>
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_EXPIC_FORM').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('expic'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_ingredients') || $this->params->get('show_grapes') ) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php if (!$start) {
				$start = 1;
				echo  JHtml::_($this->params->get('presentation_style').'.start', 'garyscookbook-slider');
			}
			?>
		<?php  echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_INGREDIENTS_FORM'), 'display-ingredients');  ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style')=='plain'):?>
			<?php  echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_INGREDIENTS_FORM').'</h3>';  ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate('ingredients'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_properties') ) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php if (!$start) {
				$start = 1;
				echo  JHtml::_($this->params->get('presentation_style').'.start', 'garyscookbook-slider');
			}
			?>
  	<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_PREPARATIONS_FORM'), 'display-preparation'); ?>
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_PREPARATIONS_FORM').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('preparation'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_details') ) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_DETAILS'), 'display-details'); ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_DETAILS').'</h3>'; ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate('details'); ?>
	<?php endif; ?>

	<?php if ($this->garyscookbook->notes && $this->params->get('show_notes')) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'){?>
			<?php if (!$start) {
				$start = 1;
				echo  JHtml::_($this->params->get('presentation_style').'.start', 'garyscookbook-slider');
			}
			?>
		<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_OTHER_INFORMATION'), 'display-misc');} ?>
		<?php if ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_OTHER_INFORMATION').'</h3>'; ?>
		<?php endif; ?>
				<div class="garyscookbook-miscinfo">
					<div class="<?php echo $this->params->get('marker_class'); ?>">
						<?php echo $this->params->get('marker_misc'); ?>
					</div>
					<div class="garyscookbook-misc">
						<?php echo $this->garyscookbook->notes; ?>
					</div>
				</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_comments') ) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_COMMENT_INFORMATION'), 'display-comments'); ?>
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_COMMENT_INFORMATION').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('comment'); ?>
			<?php echo $this->loadTemplate('comment_form'); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_favorit_icon') && $this->garyscookbook->myfavorites) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_GARYSCOOKBOOK_MY_FAVORIT_INFORMATION'), 'display-favorits'); ?>
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_GARYSCOOKBOOK_MY_FAVORIT_INFORMATION').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('myrecipe'); ?>
	<?php endif; ?>
	<?php if ($this->params->get('presentation_style')!='plain'){?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.end');} ?>
<?php
}
GaryscookbookHelperDesign::gcbfooter($this->params, $this->state);	?>
</div>
