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
<?php if (!empty($html)): ?>
	<div class="cpanel">
	<div class="cpanel-left"><?php echo $html;?></div>
	<div class="cpanel-right"><?php echo $this->loadTemplate('about'); ?></div>
	</div>
<?php endif;?>