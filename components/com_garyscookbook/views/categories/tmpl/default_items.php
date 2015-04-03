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
$class = ' class="first"';
if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
$gcb_catlength = $this->params->get('show_cat_items_desc_lenght', 50);;
$gcb_catpicwidth=$this->params->get('show_cat_items_width', 100);
$cat_col_width = $this->params->get('cat_col_width', 220);

?>

<ul>
<?php foreach($this->items[$this->parent->id] as $id => $item) :
	if($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
	?>
		<li class="catbox">
			<div style="width:<?php echo $cat_col_width ;?>px;">
				<div style="width:<?php echo $cat_col_width -10 ;?>px;">
					<span class="gcb-item-title">
						<a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getCategoryRoute($item->id));?>"><?php echo $this->escape($item->title); ?></a>
					</span>
					<?php if (@$item->image) { ?>
						<br /><p><a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getCategoryRoute($item->id));?>">
						<?php if (file_exists($item->image)) { ?>
							<img style="width:<?php echo $gcb_catpicwidth; ?>px;" class="gcbcatpic" title="<?php echo $this->escape($item->title); ?>" src="<?php echo $item->image; ?>"/></a></p>
						<?php } else {?>
							<img style="width:<?php echo $gcb_catpicwidth; ?>px;" class="gcbcatpic" title="<?php echo $this->escape($item->title); ?>" src="<?php echo $this->nopic; ?>"/></a></p>
						<?php } ?>

					<?php } ?>
					<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
						<?php if ($item->description) : ?>
							<div class="gcb-category-desc">
								<?php if (strlen($item->description) > $gcb_catlength) {
									echo substr(strip_tags(JHtml::_('content.prepare', $item->description)),0, $gcb_catlength) . '...<br />'; ?>
									<a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getCategoryRoute($item->id));?>"> <?php echo JText::_('COM_GARYSCOOKBOOK_READ_MORE_TITLE');?></a>
									<?php
								} else {
									echo JHtml::_('content.prepare', $item->description);
								} ?>

							</div>
						<?php endif; ?>
			        <?php endif; ?>
					<?php if ($this->params->get('show_cat_items_cat') == 1) :
						$rcount = GaryscookbookModelCategories::getNumItems($item->id);
						if ($rcount) :?>
							<dl>
								<dd><small>
								<?php
								if ($rcount > 1 ) :
									echo JText::sprintf('COM_GARYSCOOKBOOK_COUNTS', $rcount);
								else:
									echo JText::_('COM_GARYSCOOKBOOK_COUNT');
								endif;?>
								</small></dd>

							</dl>
						<?php endif; ?>

					<?php endif; ?>
				<?php if(count($item->getChildren()) > 0) :
					$this->items[$item->id] = $item->getChildren();
					$this->parent = $item;
					$this->maxLevelcat--;
					//echo $this->loadTemplate('items');
					$this->parent = $item->getParent();
					$this->maxLevelcat++;
				endif; ?>
			</div>
		</div>
	</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>