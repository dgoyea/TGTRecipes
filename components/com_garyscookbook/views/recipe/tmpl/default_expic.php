<?php
/**
	* @package		Garyscookbook.Site
	* @subpackage	com_garyscookbook
	* @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
	* @license		GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;
?>

<?php if ($this->params->get('show_expic')) : ?>
<div class="gcb-pictures">

	<ul>
		<li class="lidummy">&nbsp;</li>
		<?php if($this->garyscookbook->expic1) : ?>
			<li class="detailpicbox"  style="width:<?php echo $this->params->get('expic_width') + 20 ?>;">
				<div>
					<div style="width:<?php echo $this->params->get('expic_width') + 10 ?>;">
						<div class="gcb-PicDetail-title">
							<?php echo gcbrecipepic($this->garyscookbook->expic1, JTEXT::_('COM_GARYSCOOKBOOK_EXPIC'), $this->params->get('expic_width'), $this->params->get('lightbox_width'), $this->params->get('expic_quality'), $this->params->get('show_lightbox')); ?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>
		<?php if($this->garyscookbook->expic2) : ?>
			<li class="detailpicbox"  style="width:<?php echo $this->params->get('expic_width') + 20 ?>;">
				<div>
					<div style="width:<?php echo $this->params->get('expic_width') + 10 ?>;">
						<div class="gcb-PicDetail-title">
							<?php echo gcbrecipepic($this->garyscookbook->expic2, JTEXT::_('COM_GARYSCOOKBOOK_EXPIC'), $this->params->get('expic_width'), $this->params->get('lightbox_width'), $this->params->get('expic_quality'), $this->params->get('show_lightbox')); ?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>
		<?php if($this->garyscookbook->expic3) : ?>
			<li class="detailpicbox"  style="width:<?php echo $this->params->get('expic_width') + 20 ?>;">
				<div style="width:<?php echo $this->params->get('expic_width') + 20 ?>;">
					<div>
						<div class="gcb-PicDetail-title">
							<?php echo gcbrecipepic($this->garyscookbook->expic3, JTEXT::_('COM_GARYSCOOKBOOK_EXPIC'), $this->params->get('expic_width'), $this->params->get('lightbox_width'), $this->params->get('expic_quality'), $this->params->get('show_lightbox')); ?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>
		<?php if($this->garyscookbook->expic4) : ?>
			<li class="detailpicbox"  style="width:<?php echo $this->params->get('expic_width') + 20 ?>;">
				<div>
					<div style="width:<?php echo $this->params->get('expic_width') + 10 ?>;">
						<div class="gcb-PicDetail-title">
							<?php echo gcbrecipepic($this->garyscookbook->expic4, JTEXT::_('COM_GARYSCOOKBOOK_EXPIC'), $this->params->get('expic_width'), $this->params->get('lightbox_width'), $this->params->get('expic_quality'), $this->params->get('show_lightbox')); ?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>

	</ul>
</div>
<?php endif; ?>