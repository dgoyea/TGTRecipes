<?php
/**
 * @package	Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube, Merling. All rights reserved.
 * @license	GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;

JHtmlBehavior::framework();
require_once JPATH_COMPONENT.'/helpers/voting.php';

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$recipe_col_width = $this->params->get('recipe_col_width', 220);
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_GARYSCOOKBOOK_NO_ARTICLES'); ?>	 </p>
<?php else : ?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">


<?php if ($this->params->get('show_pagination')) : ?>
<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>
<ul>
	<?php foreach($this->items as $i => $item) : ?>
		<li class="recipebox">
			<div style="width:<?php echo $recipe_col_width ;?>px;">
				<div style="width:<?php echo $recipe_col_width -10 ;?>px;">
				<?php if ($this->items[$i]->published == 0) : ?>
					<span class="system-unpublished cat-list-row<?php echo $i % 2; ?>"></span>
				<?php else: ?>
					<span class="cat-list-row<?php echo $i % 2; ?>" ></span>
				<?php endif; ?>


<?php
				if ($item->imgfilename) {
					//Pfad fürs Bild
					$picture_path = GaryscookbookCategories::picpath($item->imgfilename);

// VCH001 added Multithumb handling for recipe pictures in category view
// First check whether Multithumb is available and enabled
					$db = JFactory::getDbo();
					$db->setQuery("SELECT enabled FROM #__extensions WHERE name = 'multithumb'");
					$is_enabled = $db->loadResult();
// Then parse if value for show_lightbox is set to 1. This signals "Multithumb use" from com_garyscookbook options
					$app = JFactory::getApplication('site');
					$componentParams = $app->getParams('com_garyscookbook');
					$show_lightbox = $componentParams->get('show_lightbox', 0);

					if ( $is_enabled && $show_lightbox ) {
						echo JHTML::_('content.prepare', "{multithumb resize=1 caption_pos=disabled thumb_width=".$this->params->get('pic_width_cat')."}" .
						 JHTML::_('image', $picture_path, $this->escape($item->imgtitle), ''), '', 'com_garyscookbook.recipe');
						echo "<a href=" . JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)) . ">";
					} else { ?>
                                               	<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
                                                <img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="<?php echo $this->escape($item->imgtitle); ?>" src="<?php echo $picture_path; ?>"/></a></p>
					<?php }
				} else { ?>
					<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
					<img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="nopic" src="<?php echo $this->nopic; ?>"/></a></p>
					<?php
				}
				?>
				<p><span class="item-title">
					<a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
						<?php echo $item->imgtitle; ?></a>
				</span></p>
				<p><?php
				if ($item->imgtext) {
					echo substr(strip_tags($item->imgtext),0 , $this->params->get('cat_rec_desc_length')) ; ?>...</p>
				<?php } ?>
				<p><?php echo showstarsonly($item->id,$item->imgvotesum,$item->imgvotes,1,1,'-small');?></p>

				</div>
			</div>
			<?php endforeach; ?>
</ul>




	<?php if ($this->params->get('show_pagination')) : ?>
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php endif; ?>

	</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div class="display-limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<div class="clr" style="height:35px;">&nbsp; </div>

	<?php endif; ?>
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>


<?php endif; ?>
