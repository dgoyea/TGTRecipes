<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die();
?>
<div>
	 <div id="latest-members-nav" class="app-box-filter">
	 	<i class="loading cFloat-R"></i>
		<?php echo implode($htmlFilters, '<b>&middot;</b>')?>
	</div>

	<div class="js-module">
		<div class="app-box-content">
			<div id="latest-members-container"></div>
		</div>
	</div>

	<div class="app-box-footer">
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=search&task=browse' ); ?>" class="app-title-link">
			<?php echo JText::_( 'COM_COMMUNITY_FRONTPAGE_BROWSE_ALL' ); ?>
			<?php 
				if($showTotalMembers){
					echo '('.$totalMembers.')';
				}
			?>
		</a>
	</div>
</div>

<script>
joms.jQuery( document ).ready(function() {
  joms.jQuery('.<?php echo $defaultFilter?>-member').click();
});
</script>