<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// No direct access.
defined('_JEXEC') or die;
$html = JHtml::_('icons.buttons', $this->buttons);
?>
<?php if (!empty($this->sidebar)): ?>
<div class="row-fluid">
	<div class="span2">
		<?php echo $this->sidebar;?>
	</div>
	<div class="span6">
		<div class="well well-small">
			<div class="row-fluid">
				<div class="span12 module-title nav-header">
					<?php echo JText::_("COM_GARYSCOOKBOOK_MANAGER_RECIPES_CP");?>
					<hr class="hr-condensed"/>
				</div>
			</div>
		<div class="row-fluid">
		<?php for ($i = 0; $i <= 2; $i++) { ?>
			<div class="span4">
				<div class="icon gcb_icon">
					<a class="thumbnail btn" href="<?php echo $this->buttons[$i]['link']; ?>">
					<img src="<?php echo $this->buttons[$i]['image']; ?>" alt="<?php echo $this->buttons[$i]['text'];?>"/>
					<span><?php echo $this->buttons[$i]['text'];?></span>
					</a>

				</div>
			</div>

		<?php }   ?>
		</div>
		<div class="row-fluid">
		<?php for ($i = 3; $i <= 5; $i++) { ?>
			<div class="span4">
				<div class="icon gcb_icon">
					<a class="thumbnail btn" href="<?php echo $this->buttons[$i]['link']; ?>">
					<img src="<?php echo $this->buttons[$i]['image']; ?>" alt="<?php echo $this->buttons[$i]['text'];?>"/>
					<span><?php echo $this->buttons[$i]['text'];?></span>
					</a>

				</div>
			</div>

		<?php }   ?>
		</div>
		<div class="row-fluid">
		<?php for ($i = 6; $i <= 8; $i++) { ?>
			<div class="span4">
				<div class="icon gcb_icon">
					<a class="thumbnail btn" href="<?php echo $this->buttons[$i]['link']; ?>">
					<img src="<?php echo $this->buttons[$i]['image']; ?>" alt="<?php echo $this->buttons[$i]['text'];?>"/>
					<span><?php echo $this->buttons[$i]['text'];?></span>
					</a>

				</div>
			</div>

		<?php }   ?>
		</div>

	</div>
	</div>
	<div class="span4">
		<div class="well well-small">
		<?php echo $this->loadTemplate('about'); ?>
		</div>
	</div>
</div>
<?php endif;?>