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
<div class="garyscookbook-comments">

	<table class="gcbcmt">
		<?php foreach ($this->item->comments as $comment) :
			$linecolor = ($line % 2) + 1;
			$rid = $this->garyscookbook->id;
			?>
			<tr class="sectiontableentry<?php echo $linecolor;?>">
			<td class="gcbcmtcol1" valign="top">
				<?php echo $comment->cmtname; ?><br />
				<?php if ($this->user->authorise('core.edit.state', 'com_garyscookbook.comment')): ?>
					<img class="gcbicon" src="<?php echo GCB_URI_IMAGES . "ip.png"; ?>" title="<?php echo $comment->cmtip; ?>" />
					<a href='<?php echo JROUTE::_(GaryscookbookHelperRoute::getGaryscookbookRoute($this->garyscookbook->slug, $this->garyscookbook->catid) . "&amp;task=recipe.cmtdelete&cmtid=$comment->cmtid" ); ?>'>
					<img class="gcbicon" src="<?php echo GCB_URI_IMAGES . "del.png"; ?>" title="<?php echo JTEXT::_('COM_GARYSCOOKBOOK_COMMENT_DELETE'); ?>" /></a>
					<?php if ($comment->published) {?>
						<a href='<?php echo JROUTE::_(GaryscookbookHelperRoute::getGaryscookbookRoute($this->garyscookbook->slug, $this->garyscookbook->catid) . "&amp;task=recipe.cmtpublish&cmtid=$comment->cmtid" ); ?>'>
						<img class="gcbicon" src="<?php echo GCB_URI_IMAGES . "publish.png"; ?>" title="<?php echo JTEXT::_('COM_GARYSCOOKBOOK_COMMENT_UNPUBLISH'); ?>" /></a>
					<?php } else {
						?>
						<a href='<?php echo JROUTE::_(GaryscookbookHelperRoute::getGaryscookbookRoute($this->garyscookbook->slug, $this->garyscookbook->catid) . "&amp;task=recipe.cmtpublish&cmtid=$comment->cmtid" ); ?>'>
						<img class="gcbicon" src="<?php echo GCB_URI_IMAGES . "unpublish.png"; ?>" title="<?php echo JTEXT::_('COM_GARYSCOOKBOOK_COMMENT_PUBLISH'); ?>" /></a>
					<?php } ?>
				<?php endif; ?>
			</td>
			<td valign="top">
				<small><?php echo JHTML::date($comment->cmtdate,JTEXT::_('DATE_FORMAT_LC2')); ?></small><hr />
				<?php echo $comment->cmttext; ?>
			</td>
			</tr>
		<?php
		 $line++;
		endforeach; ?>
	</table>
</div>
<?php endif; ?>
