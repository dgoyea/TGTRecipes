<?php

/**
 * @package		Garyscookbook.Site
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
defined('_JEXEC') or die;
?>

<ul>
<li class="lidummy">&nbsp;</li>
<?php if($this->params->get('show_country')) : ?>

	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_COUNTRY_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->country; ?>
				</span>

			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_price')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_COST_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->price ; ?>
				</span>

			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_laktose')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_LACTOSE_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo ($this->garyscookbook->laktose ?  JText::_("JNO") : JText::_("JYES")); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_doc')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_VEGETARIAN_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo ($this->garyscookbook->doc ?  JText::_("JNO") : JText::_("JYES")); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_vegan')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_VEGAN_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo ($this->garyscookbook->vegan ?  JText::_("JNO") : JText::_("JYES")); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_diaet')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_DIET_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo ($this->garyscookbook->diaet ?  JText::_("JNO") : JText::_("JYES")); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_gluten')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_GLUTEN_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo ($this->garyscookbook->gluten ?  JText::_("JNO") : JText::_("JYES")); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_portion')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_PORTIONS_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->portion; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_amount')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_AMOUNT_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->amount; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_years')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_PREPTIME_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php if ($this->garyscookbook->years > 0) {
					echo $this->selist2org[$this->garyscookbook->years - 1];
				} else {
					echo JTEXT::_('COM_GARYSCOOKBOOK_KA');
				}
				?>

				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_kcal')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_KCAL_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->kcal; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_kjoule')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_KJOULE_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->kjoule; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_fat')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_FAT_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->fat; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_breadunit')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_BREADUNIT_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->breadunit; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_protein')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_PROTEIN_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->protein; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_carbohydrates')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_CARBOHYDRATES_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->carbohydrates; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_aging')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_DIFFICULTY_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->selist1org[$this->garyscookbook->aging];  ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_modified')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_MODIFIED_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo JHtml::_('date',$this->garyscookbook->modified, JText::_('DATE_FORMAT_LC3')); ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>
<?php if($this->params->get('show_imgcounter')) : ?>
	<li class="detailbox">
		<div>
			<div>
				<div class="gcb-Detail-title">
				<?php echo JText::_('COM_GARYSCOOKBOOK_CONFIG_COUNTER_LABEL'); ?></div>
				<span class="gcb-Detail-item">
				<?php echo $this->garyscookbook->imgcounter; ?>
				</span>
			</div>
		</div>
	</li>
<?php endif; ?>

</ul>