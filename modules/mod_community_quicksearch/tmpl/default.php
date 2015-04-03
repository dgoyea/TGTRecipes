<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="cModule cFrontPage-Search">

	<div class="app-box-content">
		<form name="search" id="cFormSearch" method="get" action="<?php echo CRoute::_('index.php?option=com_community&view=search');?>">

		  <input type="text" class="input-block-level" id="keyword" name="q" />
			<a class="btn btn-primary" href="javascript:void(0);" onclick="joms.jQuery('#cFormSearch').submit();"><?php echo JText::_('COM_COMMUNITY_SEARCH')?></a>
			<input type="hidden" name="option" value="com_community" />
			<input type="hidden" name="view" value="search" />
		</form>
	</div>
	<div class="app-box-footer">
        <a href="<?php echo CRoute::_('index.php?option=com_community&view=search&task=advancesearch'); ?>"><?php echo JText::_('COM_COMMUNITY_TITLE_CUSTOM_SEARCH'); ?></a>
    </div>
</div>