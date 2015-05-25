<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tgtrecipes
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;
?>


<?php 

// Create recipe item object
$item = $this->item;

?>

<div class="mypreview">
	<div class="mytgtrecipe">
		<div class="tgtrecipes_title">
			<?php echo $item->title; ?>
		</div>

		<?php for ($x=1; $x<26; $x++) : ?>
			<div class="tgtrecipes_element_full">
			<?php 
				$ingredient = 'ingredient' . $x;
				$ingrqty = 'ingrqty' . $x;
				$ingrqtytype = 'ingrqtytype' . $x;
				if ($item->$ingredient != NULL) {
					echo $item->$ingrqty . ' ' . $item->$ingrqtytype . ' ' . $item->$ingredient;
				}
				else {
					$x = 26;
				}
			?>
			</div>
		
		<?php endfor ?>
		
		<div class="tgtrecipes_element_full">
			<?php echo $item->directions; ?>
		</div>
	
	</div>
</div>
