<?php
/**
 * Based on http://www.aweber.com/faq/questions/396/Can+I+Use+My+Own+Form%3F
 */
$meta = $data;
$redirectUrl = !empty($meta['optin']['aweber']['thank-you']) ? $meta['optin']['aweber']['thank-you'] : 'http://www.aweber.com/thankyou-coi.htm?m=text';
$trackingCode = !empty( $meta['optin']['aweber']['tracking-code'] ) ? $meta['optin']['aweber']['tracking-code'] : ''; 
$actionUrl = !empty( $meta['optin']['aweber']['form-action-url'] ) ? $meta['optin']['aweber']['form-action-url'] : '';
$submitValue = !empty( $meta['optin']['aweber']['submit-value'] ) ? $meta['optin']['aweber']['submit-value'] : 'Submit';
?>
<!-- form method="POST" action="http://www.aweber.com/scripts/addlead.pl" -->
<form method="POST" action="<?php echo $actionUrl; ?>">
	<p class="mab-field">
		<label for="mab-name">Name</label>
		<input type="text" id="mab-name" placeholder="Enter your name" name="name" />
	</p>
	<p class="mab-field">
		<label for="mab-email">Email Address</label>
		<input type="email" id="mab-email" placeholder="Enter your email" name="email" />
	</p>
	<input class="mab-submit" type="submit" value="<?php echo $submitValue; ?>" />
	
	<div class="clear"></div>
	
	<?php 
	//might be usefule later
	//<input type="hidden" name="meta_split_id" value="" />
	//<input type="hidden" name="meta_redirect_onlist" value="http://pogidude.com" /> //redirect to url if user is already subscribed to the list 
	//<input type="hidden" name="meta_message" value="1" /> //the follow up message subscribers will first receive when signing up to the list. In most cases, this is set to "1".
	//<input type="hidden" name="meta_forward_vars" value="1" /> set to "1" to forward all submitted fields to the redirect/thank you page using GET method. ?>
	
	<input type="hidden" name="listname" value="<?php echo $meta['optin']['aweber']['list']; ?>" />
	<?php if( !empty( $redirectUrl ) ): ?>
	<input type="hidden" name="redirect" value="<?php echo $redirectUrl; ?>" />
	<?php endif; ?>
	<?php if( !empty( $meta['optin']['aweber']['tracking-code'] ) ) : ?>
	<input type="hidden" name="meta_adtracking" value="<?php echo $meta['optin']['aweber']['tracking-code']; ?>" />
	<?php endif; ?>
	<input type="hidden" name="meta_message" value="1" />
	
	<?php //maybe have a way to set which fields are required? ?>
	<input type="hidden" name="meta_required" value="name,email" />

</form>
