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
require_once JPATH_COMPONENT.'/helpers/voting.php';
$link       = JURI::getInstance();
$link       = $link->toString();
$NewPortion = JRequest::getInt('newportion');
$canEdit	= $this->garyscookbook->params->get('access-edit');
if ($NewPortion == 0) :
	$showPortion = $this->garyscookbook->portion;
else:
	$showPortion = $NewPortion;
endif;
$this->params->set('newportion', $showPortion);
/* marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */

if (strpos($this->garyscookbook->imgfilename, 'images/garyscookbook/')===false) {
	$gcbpic1 = GCB_PATH_RECIPE_IMAGES . $this->garyscookbook->imgfilename;

} else {
	$gcbpic1 = JPATH_BASE .'/' . $this->garyscookbook->imgfilename;
}

if  ($this->garyscookbook->imgfilename) {
	if (file_exists($gcbpic1)) {
		//Containerhöhe berechnen
		$divheight = getimagesize($gcbpic1);
		$Anteil = $divheight[0] / $this->params->get('pic_width');
		$divheight[1] = $divheight[1] / $Anteil;

	} else {
		$divheight = 50;
	}

	$showpic = gcbrecipepic($this->garyscookbook->imgfilename, $this->escape($this->garyscookbook->imgtitle), $this->params->get('pic_width'), $this->params->get('lightbox_width'), $this->params->get('pic_quality'), $this->params->get('show_lightbox'));
} else {
	$divheight[1] = 150;
	$showpic = "<img style=\"width:".  $this->params->get('pic_width') ."px;\" class=\"gcbpic\" title=\"" . $this->garyscookbook->imgtitle . "\" src=\"" . $this->nopic . "\"/>";
}
$style ='';
if ($this->params->get('show_icons')==1) {
	$style = 'style="display: inline;"';
}
?>

<div style="min-height:<?php echo $divheight[1]; ?>px;" class="garyscookbook-details">
	<div  id="gcbpicplace">
	<?php echo $showpic; ?>
	</div>
	<div id="gcbrecipeinfo">
		<ul>
			<li><?php echo showstars( $this->garyscookbook->id,$this->garyscookbook->imgvotesum,$this->garyscookbook->imgvotes,1,1,''); ?></li>
			<?php if (!$this->print) : ?>
				<li>&nbsp;</li>
				<?php if($this->params->get('show_print_icon')) { ?>
					<li <?php echo $style;?>><?php echo JHtml::_('icon.print_popup',  $this->garyscookbook, $this->params); ?></li>
				<?php } ?>
				<?php if($this->params->get('show_email_icon')) { ?>
					<li <?php echo $style;?>><?php echo JHtml::_('icon.email',  $this->garyscookbook, $this->params); ?></li>
				<?php } ?>
				<?php if($this->params->get('show_facebook_icon')) { ?>
					<li <?php echo $style;?>><?php echo JHtml::_('icon.share_facebook',  $this->garyscookbook, $this->params); ?></li>
				<?php } ?>
				<?php if($this->params->get('show_favorit_icon') && $this->user->name) {
					if (isinfavorit($this->user->id, $this->garyscookbook->id)){ ?>
						<li <?php echo $style;?>><?php echo JHtml::_('icon.isfavorit',  $this->garyscookbook, $this->params); ?></li>
					<?php }else { ?>
						<li <?php echo $style;?>><?php echo JHtml::_('icon.favorit',  $this->garyscookbook, $this->params); ?></li>
					<?php }?>


				<?php } ?>
				<?php if($this->params->get('show_export_icon')) { ?>
					<li <?php echo $style;?>><?php echo JHtml::_('icon.export',  $this->garyscookbook, $this->params); ?></li>
				<?php } ?>
				<?php if ($canEdit && $this->params->get('show_edit_icon') && $this->params->get('show_recipe_fp_allow')) : ?>
					<li <?php echo $style;?>><?php echo JHtml::_('icon.edit',  $this->garyscookbook, $this->params); ?></li>
				<?php endif; ?>
			<?php endif; ?>

		</ul>
	</div>
</div>

<div class="gcbtext">
	 <?php echo $this->garyscookbook->imgtext;?>
</div>
<div style="clear: both;"></div>


