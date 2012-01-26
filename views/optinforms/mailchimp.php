<?php
/**
 * Based on http://www.aweber.com/faq/questions/396/Can+I+Use+My+Own+Form%3F
 */
$meta = $data;
//$redirectUrl = !empty($meta['optin']['thank-you']) ? $meta['optin']['thank-you'] : 'http://www.aweber.com/thankyou-coi.htm?m=text';
//$trackingCode = !empty( $meta['optin']['mailchimp']['tracking-code'] ) ? $meta['optin']['mailchimp']['tracking-code'] : ''; 

//$actionUrl = !empty( $meta['optin']['mailchimp']['list-data']['subscribe_url_long'] ) ? $meta['optin']['mailchimp']['list-data']['subscribe_url_long'] : '';
$actionUrl = !empty( $meta['optin']['mailchimp']['form-action-url'] ) ? $meta['optin']['mailchimp']['form-action-url'] : '';
$submitValue = !empty( $meta['optin']['mailchimp']['submit-value'] ) ? $meta['optin']['mailchimp']['submit-value'] : 'Submit';
?>
<form method="POST" action="<?php echo $actionUrl; ?>">
	<p class="mab-field">
		<label for="mab-name">Name</label>
		<input type="text" id="mab-name" placeholder="Enter your name" name="FNAME" />
	</p>
	<p class="mab-field">
		<label for="mab-email">Email Address</label>
		<input type="email" id="mab-email" placeholder="Enter your email" name="EMAIL" />
	</p>
	<input class="mab-submit" type="submit" value="<?php echo $submitValue; ?>" />
	<div class="clear"></div>
</form>
