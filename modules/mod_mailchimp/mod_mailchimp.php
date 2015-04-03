<?php
/**
*Author: Pankaj Raj
*Mail: rajrajpankaj.89@gmail.com
*License GPL Commercial
*URL:http://www.sphereworldlogic.com
**/

include 'lib/Mailchimp.php';

$apikey = $params->get( 'apikey' );
$list_id = $params->get('listid');
$merge_vars = $params->get('mergevars');
$mergevarslabels = $params->get('mergevarslabels');
$welcome_mail = $params->get('welcome_mail');
$moduleclass_sfx = $params->get('moduleclass_sfx');
$message="";
if(isset($_POST['emailsubscriber_mailchimp']))
{
	try{
			$postvalues=array();
			
			if(isset($_POST['mergevar']))
				$postvalues=$_POST['mergevar'];
	
			$MailChimp = new MailChimp($apikey);
			$result = $MailChimp->call('lists/subscribe', array(
                'id'                => $list_id,
                'email'             => array('email'=>$_POST['emailsubscriber_mailchimp']),
                'merge_vars'        => $postvalues,
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => $welcome_mail,
			));
			
			if(!isset($result['error']))
			{
				$message='You have successfully subscribed to us.';
			}
			else
			{
				$message='Cannot subscribe please recheck submitted data.';
			}
		}
		catch(Exception $e)
		{
				$message='Cannot subscribe please recheck submitted data.';

		}
		
}		
?>
<form name="mailchimpform" id="mailchimpform" method="POST" action="" >
	<span><?php echo $message; ?></span>
	<label>Subscribe:</label><input type="text" name="emailsubscriber_mailchimp" placeholder="Email.." />
	<?php
	
		$merge_vars=explode(',',$merge_vars);
		$mergevarslabels=explode(',',$mergevarslabels);
		$i=0;
		foreach($merge_vars as $merge_var)
		{
	 ?>
			<label><?php echo $mergevarslabels[$i]; ?>:</label> <input type="text" name="mergevar[<?php echo $merge_var; ?>]" />
	 <?php
			$i++;
		}
	
	?>
	<input type="submit" value="Subscribe" />
</form>
