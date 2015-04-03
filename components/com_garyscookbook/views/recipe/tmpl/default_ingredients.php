<?php
/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/helpers/helper.php';

/* marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<?php
	if ($this->params->get('show_grapes')) { ?>
		<div class="gcbtext">
		<?php
			echo $this->garyscookbook->grapes;
		?>
		</div>

	<?php } ?>
		<?php
	if ($this->params->get('show_ingredients')) {?>
		<div class="gcbtext">
	 		<?php echo @$this->garyscookbook->ingf;?>
		</div>
	<?php
}

?>



