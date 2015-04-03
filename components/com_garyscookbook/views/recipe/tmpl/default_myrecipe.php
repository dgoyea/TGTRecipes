<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
$row = 0;
$line = 0;
?>
<?php if ($this->params->get('show_comments')) : ?>
<div class="garyscookbook-favorits">

	<table class="gcbmyrecipes">
		<?php foreach ($this->item->myfavorites as $favorit) :
			$linecolor = ($line % 2) + 1;
			$rid = $this->garyscookbook->id;
			?>
			<tr class="sectiontableentry<?php echo $linecolor;?>">
				<td valign="top">
					<a href="<?php echo JRoute::_(GaryscookbookHelperRoute::getGaryscookbookRoute($this->item->slug, $this->item->catid)); ?>"><?php echo $favorit->imgtitle; ?></a>
				</td>
				<td>&nbsp;</td>
				<td valign="top">
					<?php
					if ($this->item->imgtext) {
						echo substr(strip_tags($this->item->imgtext),0 , $this->params->get('cat_rec_desc_length')) ; ?>...</p>
					<?php } ?>
				</td>
			</tr>
		<?php
		 $line++;
		endforeach; ?>
	</table>
</div>
<?php endif; ?>
