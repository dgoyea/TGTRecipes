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

if (method_exists('JHtml','core'))
	JHtml::core();
else
	JHtmlBehavior::framework();
;
require_once JPATH_COMPONENT.'/helpers/voting.php';

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$recipe_col_width = $this->params->get('recipe_col_width', 220);
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_GARYSCOOKBOOK_NO_ARTICLES'); ?>	 </p>
<?php else : ?>

<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
<?php if ($this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters">
	<legend class="hidelabeltxt"><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?></legend>

		<div class="display-limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	</fieldset>
<?php endif; ?>
<div id="gcb-favorits">
<?php
//Favoriten
if ($this->params->get('show_fav_description', 0) == 0 || $this->params->get('show_fav_description', 0) == 1) { ?>
	<table class='category' width='100%' border='0' cellspacing='1' cellpadding='4'>
	<tr>
		<th colspan='3' class='sectiontableheader' width='100%'><h4><?php echo JText::_("COM_GARYSCOOKBOOK_MY_FAVORIT_INFORMATION");?></h4></th></tr>
		<?php
		foreach($this->items as $i => $item) :
			if ($item->Art == 0) { ?>
				<tr class="cat-list-row<?php echo $i % 2; ?>">
					<td valign="middle" width="40%">
						<h3><a class="gbk-favlink" href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
							<img src="<?php echo GCB_URI_IMAGES ?>/arrow.png" alt="Arrow"/> <?php echo $item->imgtitle; ?>
						</a></h3>

						<?php if ($item->imgtext) { ?>
							<br /><p style="padding-left: 10px;" ><?php echo substr(strip_tags($item->imgtext),0 , $this->params->get('cat_rec_desc_length')) ; ?>...</p>
						<?php } ?>

					</td>
					<td align="left" valign="middle" width="40%">
							<?php echo $item->cattitle; ?>
					</td>
					<td align="right" valign="middle">
							<?php if ($item->imgfilename) {
								//Pfad fürs Bild
								$picture_path = GaryscookbookCategories::picpath($item->imgfilename);
								?>
								<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
								<img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="<?php echo $this->escape($item->imgtitle); ?>" src="<?php echo $picture_path; ?>"/></a></p>
							<?php } else { ?>
								<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
								<img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="nopic" src="<?php echo $this->nopic; ?>"/></a></p>
							<?php
							} ?>
					</td>
				</tr>
			<?php
			}
			endforeach; ?>
	</table>
<?php }?>



<?php
//Eigene Rezepte
if ($this->params->get('show_fav_description', 0) == 0 || $this->params->get('show_fav_description', 0) == 2) { ?>
	<table class='category' width='100%' border='0' cellspacing='1' cellpadding='4'>
		<tr>
			<th colspan='3' class='sectiontableheader' width='100%'><h4><?php echo JText::_("COM_GARYSCOOKBOOK_MY_OWN_RECIPE_INFORMATION");?></h4></th>
		</tr>
		<?php
	foreach($this->items as $i => $item) :
		if ($item->Art == 1) { ?>
				<tr class="cat-list-row<?php echo $i % 2; ?>">
					<td valign="middle" width="40%">
						<h3><a class="gbk-favlink" href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
							<img src="<?php echo GCB_URI_IMAGES ?>/arrow.png" alt="Arrow"/> <?php echo $item->imgtitle; ?>
						</a></h3>

						<?php if ($item->imgtext) { ?>
							<br /><p style="padding-left: 10px;" ><?php echo substr(strip_tags($item->imgtext),0 , $this->params->get('cat_rec_desc_length')) ; ?>...</p>
						<?php } ?>

					</td>
					<td align="left" valign="middle" width="40%">
							<?php echo $item->cattitle; ?>
					</td>
					<td align="right" valign="middle">
							<?php if ($item->imgfilename) {
								//Pfad fürs Bild
								$picture_path = GaryscookbookCategories::picpath($item->imgfilename);
								?>
								<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
								<img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="<?php echo $this->escape($item->imgtitle); ?>" src="<?php echo $picture_path; ?>"/></a></p>
							<?php } else { ?>
								<p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($item->slug, $item->catid)); ?>">
								<img style="width:<?php echo $this->params->get('pic_width_cat'); ?>px;" class="gcbcatpic" title="nopic" src="<?php echo $this->nopic; ?>"/></a></p>
							<?php
							} ?>
					</td>
				</tr>
			<?php
		}
		endforeach; ?>
	</table>

<?php }?>
</div>





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
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>
<?php endif; ?>