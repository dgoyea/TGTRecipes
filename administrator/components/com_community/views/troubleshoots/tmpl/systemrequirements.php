<?php
defined('_JEXEC') or die('Restricted access');
?>
<table class="table table-condensed">
    <thead>
        <tr>
            <th></th>
            <th><?php echo JText::_('COM_COMMUNITY_TROUBLESHOOTS_MINIMUM_REQUIRED'); ?></th>
            <th><?php echo JText::_('COM_COMMUNITY_TROUBLESHOOTS_RECOMMENDED'); ?></th>
            <th><?php echo JText::_('COM_COMMUNITY_TROUBLESHOOTS_CUREENT'); ?></th>
            <th><?php echo JText::_('COM_COMMUNITY_TROUBLESHOOTS_DESCRIPTION'); ?></th>
            <th><?php echo JText::_('COM_COMMUNITY_TROUBLESHOOTS_HELP'); ?></th>
        </tr>
    </thead>
    <tbody>
        <!--php-->
        <?php foreach ($this->systemRequirements as $name => $systemRequirements) : ?>
            <?php foreach ($systemRequirements as $systemRequirement) : ?>
                <tr class="<?php echo ($systemRequirement['current'][0]) ? '' : 'error'; ?>">
                    <!-- Group -->
                    <td><?php echo $name; ?></td>
                    <?php foreach ($systemRequirement as $key => $value) { ?>
                        <?php if ($key == 'current') { ?>
                            <?php if (count($value) == 2) { ?>
                                <td><?php echo $value[1]; ?> <i class="<?php echo ($value[0]) ? "js-icon-ok" : "js-icon-remove"; ?>"></i></td>
                            <?php } else { ?>
                                <td><i class="<?php echo ($value[0]) ? "js-icon-ok" : "js-icon-remove"; ?>"></i></td>
                            <?php } ?>
                        <?php } else { ?>
                            <td>
                                <?php echo $value; ?>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>
