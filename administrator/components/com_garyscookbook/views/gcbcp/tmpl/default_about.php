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
//SELECT * FROM `g1t9u_extensions` WHERE state = 0 and name = 'com_garyscookbook'
?>
	<div class="cpanel">
      		<table border="1" width="100%" class="adminform">
         		<tr>
            		<th class="cpanel" colspan="2">
            			<img src="components/com_garyscookbook/assets/images/32-info.png" align="middle" alt="Info Garyscookbook"/> <?php echo Jtext::_('COM_GARYSCOOKBOOK_MANAGER_RECIPES_ABOUT');?>
            		</th>
         		</tr>
         		<tr>
         			<td bgcolor="#FFFFFF" colspan="2">
         				<br />
      					<div style="width=100%" align="center">
      						<img src="components/com_garyscookbook/assets/images/garyscookbook_gr.png" align="middle" alt="Garyscookbook"/>
      						<br />
      						<br />
      					</div>
      				</td>
      			</tr>
         		<tr>
            		<td width="120" bgcolor="#FFFFFF">
            			<?php echo JText::_('GARYSCOOKBOOK_CURRENT_VERSION');?>:
            		</td>
            		<td bgcolor="#FFFFFF">
            			<?php echo $this->items[0]->version;?>
            		</td>
         		</tr>
         		<tr>
            		<td bgcolor="#FFFFFF">
            			Copyright:
            		</td>
            		<td bgcolor="#FFFFFF">
            		<a href="http://www.garyscookbook.de" target="_blank">
            			&copy; 2003-<?php echo date('Y'); ?> Gerald Berger, Ove Eriksson, Jens Straube www.garyscookbook.de
            		</td>
         		</tr>
         		<tr>
            		<td bgcolor="#FFFFFF">
            			<?php echo JText::_('GARYSCOOKBOOK_LICENSE');?>:
            		</td>
            		<td bgcolor="#FFFFFF">
            			<a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU GPL</a>
            		</td>
         		</tr>
         		<tr>
            		<td valign="top" bgcolor="#FFFFFF">
            			<?php echo JText::_('GARYSCOOKBOOK_DEVELOPER');?>:
            		</td>
            		<td bgcolor="#FFFFFF">
            			Gerald Berger, Ove Eriksson, Jens Straube
            		</td>
         		</tr>
		 		<tr>
		 			<td bgcolor="#FFFFFF">
		 				<?php echo JText::_('GARYSCOOKBOOK_DONATE_DEVELOP');?>:
		 			</td>
					<td bgcolor="#FFFFFF">
						<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="business" value="gerald@vb-dozent.net">
							<input type="hidden" name="item_name" value="Garys Cookbook on <?php echo JURI::base(); ?>">
							<input type="hidden" name="no_shipping" value="2">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="currency_code" value="EUR">
							<input type="hidden" name="tax" value="0">
							<input type="hidden" name="bn" value="PP-DonationsBF">
							<input type="image" src="components/com_garyscookbook/assets/images/paypalbutton.png" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
						</form>
						<br />
						<?php echo JText::_('GARYSCOOKBOOK_DONATION_DESC');?>
					</td>
	 			</tr>
	      </table>
	</div>
