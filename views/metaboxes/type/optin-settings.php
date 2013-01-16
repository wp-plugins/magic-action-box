<?php
	global $MabAdmin;
	$meta = !empty( $data['meta'] ) ? $data['meta'] : array();
	$optinMeta = !empty( $meta['optin'] ) && is_array( $meta['optin'] ) ? $meta['optin'] : array();
	$assets_url = $data['assets-url'];
	$optin_providers = $data['optin-providers'];
?>


<div class="mab-option-box">
	<h4><label for="mab-optin-provider"><?php _e('Select Mailing List Provider','mab' ); ?></label></h4>
	<p><?php _e('Magic Action Box has integrated support for Aweber, MailChimp and Wysija Newsletter only as of the moment. But, you may still use other mailing list providers by selecting <em>Others (Copy & Paste)</em> option. <strong>**Note:</strong> you can even use Aweber or MailChimp with the <em>Others (Copy & Paste)</em> option.','mab' ); ?></p>
	<select id="mab-optin-provider" class="large-text" name="mab[optin-provider]" >
		<?php
			$selected_provider = isset( $meta['optin-provider'] ) ? $meta['optin-provider'] : '';
			$allowed_providers = array();
		?>
		<?php foreach( $optin_providers as $provider ) : ?>
			<?php $allowed_providers[ $provider['id'] ] = 1; ?>
			<option value="<?php echo $provider['id']; ?>" <?php selected( $selected_provider, $provider['id'] ); ?> ><?php echo $provider['name']; ?></option>
		<?php endforeach; ?>
	</select>
	
	<!-- ## AWEBER -->
	<?php if( isset( $allowed_providers['aweber'] ) ) : ?>
	<div id="mab-aweber-settings" class="mab-dependent-container mab-optin-list-dependent-container">
		<p class="mab-notice">You selected to use an integrated opt-in form. This form displays two input fields to take the visitor's name and e-mail address. If you wish to use other input field arrangements, <em>(i.e. use only one field for e-mail address)</em>, then select <em>Other (Copy & Paste)</em> in the <label for="mab-optin-provider"><strong>Mailing List Provider</strong></label> select box.</p>
		<h4><label for="mab-optin-aweber-list"><?php _e('List','mab'); ?></label></h4>
		<p><?php _e('Select list to subscribe users to. Click on the Update List button below if you just recently added/removed a list from Aweber.', 'mab' ); ?></p>
		<select id="mab-optin-aweber-list" class="large-text mab-optin-list" name="mab[optin][aweber][list]">
		<?php
			$lists = array();
			$lists = $MabAdmin->getAweberLists();
			$selected_list = !empty($meta['optin']['aweber']['list']) ? $meta['optin']['aweber']['list'] : '';
			foreach( $lists as $list ):
		?>
			<option value="<?php echo $list['id']; ?>" <?php selected( $selected_list, $list['name'] ); ?> ><?php echo $list['name']; ?></option>
		<?php endforeach; ?>
		</select>
		<?php //var_dump( $lists ); ?>
		<a id="mab-optin-aweber-get-list" class="button mab-optin-get-list" href="#">Update List</a>
		<img id="mab-optin-aweber-feedback" class="ajax-feedback" src="<?php echo admin_url('images/wpspin_light.gif'); ?>" alt="" />
		<br />
		<br />
		<?php /* TODO: Add the block below later
		<h4><?php _e( 'Email Opt In Fields', 'mab' ); ?></h4>
		<p><?php _e('Check the fields that you want to be used on the Opt In form.'); ?></p>
		<p>
			<label for="mab-optin-aweber-enable-field-name">
				<input type="checkbox" id="mab-optin-aweber-enable-field-name" name="mab[optin][aweber][fields][name]" <?php checked( $meta['optin']['aweber']['fields']['name'], 1 ); ?> value="1" />
				Name
			</label>
		</p>
		<br />
		*/ ?>
		<h4><label for="mab-optin-aweber-submit-value"><?php _e( 'Text for submit button','mab' ); ?></label></h4>
		<p>You can specify the text for your submit button (ex: "Subscribe" or "Get it now") Leave this blank to use default value. <strong>Default:</strong> Submit
		</p>
		<input id="mab-optin-aweber-submit-value" type="text" name="mab[optin][aweber][submit-value]" value="<?php echo isset( $meta['optin']['aweber']['submit-value'] ) ? $meta['optin']['aweber']['submit-value'] : ''; ?>" />
		
		<br />
		<br />
		<h4><label for="mab-optin-aweber-thankyou"><?php _e('Thank You Page', 'mab' ); ?></label></h4>
		<p><?php _e('Enter URL to thank you page where users will be redirected to after signing up. Leave blank to use default URL used by Aweber.','mab' ); ?></p>
		<input type="text" class="large-text" id="mab-optin-aweber-thankyou" name="mab[optin][aweber][thank-you]" value="<?php echo isset( $meta['optin']['aweber']['thank-you'] ) ? $meta['optin']['aweber']['thank-you'] : ''; ?>" />
		
		<br />
		<br />
		<h4><label for="mab-optin-aweber-tracking-code"><?php _e('Aweber Tracking Code', 'mab' ); ?></label></h4>
		<p><?php _e('The ad tracking value you\'d like assigned to subscribers who use this form (Optional).'); ?></p>
		<input type="text" id="mab-optin-aweber-tracking-code" name="mab[optin][aweber][tracking-code]" value="<?php echo isset( $meta['optin']['aweber']['tracking-code'] ) ? $meta['optin']['aweber']['tracking-code'] : ''; ?>" />
		
	</div>
	<?php endif; ?>
	
	<!-- #MAILCHIMP -->
	<?php if( isset( $allowed_providers['mailchimp'] ) ) : ?>
	<div id="mab-mailchimp-settings" class="mab-dependent-container mab-optin-list-dependent-container">
		<p class="mab-notice">You selected to use an integrated opt-in form. This form displays two input fields to take the visitor's name and e-mail address. If you wish to use other input field arrangements, <em>(i.e. use only one field for e-mail address)</em>, then select <em>Other (Copy & Paste)</em> in the <label for="mab-optin-provider"><strong>Mailing List Provider</strong></label> select box.</p>
		<h4><label for="mab-optin-mailchimp-list"><?php _e('List','mab'); ?></label></h4>
		<p><?php _e('Select list to subscribe users to. Click on the Update List button below if you just recently added/removed a list from MailChimp.', 'mab' ); ?></p>
		<select id="mab-optin-mailchimp-list" class="large-text mab-optin-list" name="mab[optin][mailchimp][list]">
		<?php
			//get lists for mailchimp if provider is allowed
			$lists = array();
			$lists = $MabAdmin->getMailChimpLists( );
			$selected_list = !empty($meta['optin']['mailchimp']['list']) ? $meta['optin']['mailchimp']['list'] : '';
			foreach( $lists as $list ):		
		?>
			<option value="<?php echo $list['id']; ?>" <?php selected( $selected_list, $list['id'] ); ?> ><?php echo $list['name']; ?></option>
		<?php endforeach; ?>
		</select>
		<a id="mab-optin-mailchimp-get-list" class="button mab-optin-get-list" href="#">Update List</a>
		<img id="mab-optin-mailchimp-feedback" class="ajax-feedback" src="<?php echo admin_url('images/wpspin_light.gif'); ?>" alt="" />
		<?php 
		//test output of single list
		//$test = $MabAdmin->getMailChimpListSingle( $meta['optin']['mailchimp']['list'] );
		//myprint_r( $test ); ?>
		<br />
		<br />
		<?php /* TODO: add the block below later
		<h4><?php _e( 'Email Opt In Fields', 'mab' ); ?></h4>
		<p><?php _e('Check the fields that you want to be used on the Opt In form.'); ?></p>
		<p>
			<label for="mab-optin-mailchimp-enable-field-name">
				<input type="checkbox" id="mab-optin-mailchimp-enable-field-name" name="mab[optin][mailchimp][fields][name]" <?php checked( $meta['optin']['mailchimp']['fields']['name'], 1 ); ?> value="1" />
				Name
			</label>
		</p>
		<br />
		*/ ?>
		<h4><label for="mab-optin-mailchimp-submit-value"><?php _e( 'Text for submit button','mab' ); ?></label></h4>
		<p>You can specify the text for your submit button (ex: "Subscribe" or "Get it now") Leave this blank to use default value. <strong>Default value:</strong> Submit.
		</p>
		<input id="mab-optin-mailchimp-submit-value" type="text" name="mab[optin][mailchimp][submit-value]" value="<?php echo isset( $meta['optin']['mailchimp']['submit-value'] ) ? $meta['optin']['mailchimp']['submit-value'] : ''; ?>" />
	</div>
	<?php endif; ?>
	
	<!-- #MANUAL -->
	<?php if( isset( $allowed_providers['manual'] ) ) : ?>
	<div id="mab-manual-settings" class="mab-dependent-container mab-optin-list-dependent-container mab-manual-dependent-container">
		<p class="mab-notice">This option allows you to use just about any autoresponder service or email list provider with Magic Action Box as long as your service allows you to generate an HTML - not Javascript - code for you to copy and paste on your website. To learn more about this feature, <a href="http://www.magicactionbox.com/how-use-magic-action-box-with-any-email-marketing-service/?pk_campaign=LITE&pk_kwd=editScreen-videoTut" target="_blank">watch this video tutorial</a>.</p>
		<h4><label for="mab-optin-manual-code"><?php _e('Opt In Form Code','mab'); ?></label></h4>
		<p>Paste your opt-in form code here. This HTML code is generated by your email service provider for you to place on your website. Make sure this isn't the javascript version, but the full or raw HTML version of the optin form. Then click on the <strong>Process Code</strong> button below.</p>
		<textarea id="mab-optin-manual-code" class="code large-text" name="mab[optin][manual][code]" rows="5"><?php echo isset( $meta['optin']['manual']['code'] ) ? $meta['optin']['manual']['code'] : ''; ?></textarea>
		<br />
		<h4><label for="mab-optin-submit-value"><?php _e( 'Text for submit button','mab' ); ?></label></h4>
		<p>You can specify the text for your submit button (ex: "Subscribe" or "Get it now") Leave this blank to use the value specified in the Opt In Form Code you entered above.
		</p>
		<input id="mab-optin-submit-value" type="text" name="mab[optin][manual][submit-value]" value="<?php echo isset( $meta['optin']['manual']['submit-value'] ) ? $meta['optin']['manual']['submit-value'] : ''; ?>" />
		<br />
		<br />
		<a id="mab-process-manual-optin-code" href="#" class="button-secondary">Process Code</a>
		<img id="mab-optin-process-manual-feedback" class="ajax-feedback" src="<?php echo admin_url('images/wpspin_light.gif'); ?>" alt="" />
		<br />
		<br />
		<h4><label for="mab-optin-manual-processed-code"><?php _e('Processed Opt In Form Code','mab'); ?></label></h4>
		<p>This is the resulting code that will be used in your opt in form. It is generated by placing your email service provider's raw HTML code in the text field above and clicking on the Process Code button.</p>
		<textarea id="mab-optin-manual-processed-code" class="code large-text" name="mab[optin][manual][processed]" rows="5"><?php echo isset( $meta['optin']['manual']['processed'] ) ? $meta['optin']['manual']['processed'] : ''; ?></textarea>
		
		<?php /*TODO: add the following block later 
		<br />
		<br />
		<h4><?php _e( 'Email Opt In Fields', 'mab' ); ?></h4>
		<p><?php _e('<strong>Note:</strong> The fields that appear depend on the fields that you have set up with your email provider. You may use your email provider\'s opt-in form generator/designer to create the necessary number of fields and paste the generated HTML code into the <em>Opt In Form Code</em> field above. Or, edit the <em>Processed Opt In Form Code</em> itself if you are comfortable editing HTML code.'); ?></p>
		*/ ?>
	</div>
	<?php endif; ?>
	
	<!-- #WYSIJA -->
	<?php 
	if( isset( $allowed_providers['wysija'] ) ): 
		/* check if wysija plugin is installed **/
		if( !class_exists( 'WYSIJA' ) ):
		//Wysija plugin is not installed
	?>
		<div id="mab-wysija-settings" class="mab-dependent-container mab-optin-list-dependent-container">
			<p class="mab-notice">You need to install <a href="http://www.wysija.com/?aff=8" title="Wysija Newsletters" target="_blank">Wysija Newsletters plugin</a> in order to use this option as a Mailing List Provider (Don't worry, there is a lite version).</p>
		</div>
		<?php
		else:
		//wysijs plugin is installed
		$modelList = &WYSIJA::get('list','model');
		$wysijaLists = $modelList->get(array('name','list_id'),array('is_enabled'=>1));
		$wysija = !empty( $optinMeta['wysija'] ) ? $optinMeta['wysija'] : array();
		?>
		<div id="mab-wysija-settings" class="mab-dependent-container mab-optin-list-dependent-container">
			<div class="mab-option-box">
				<h4><?php _e('Select List:','mab' ); ?></h4>
				<p><?php _e('Select which newsletter list a user will be subscribed to.','mab' ); ?></p>
				<?php 
				$selectedLists = isset( $wysija['lists'] ) && is_array( $wysija['lists'] ) ? $wysija['lists'] : array(); 
				$lists = $wysijaLists; 
				?>
				<?php foreach( $lists as $list ) : ?>
					<p style="margin: 0 0 5px 0; float: left;"><label for="mab-wys-list-<?php echo $list['list_id']; ?>"><input type="checkbox" id="mab-wys-list-<?php echo $list['list_id']; ?>" name="mab[optin][wysija][lists][]" value="<?php echo $list['list_id']; ?>" <?php checked( true, in_array( $list['list_id'],$selectedLists) ); ?> /> <?php echo $list['name']; ?></label></p>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
			
			<div class="mab-option-box">
				<h4><?php _e('Fields to ask for:','mab' ); ?></h4>
				<?php 
				$fields = isset( $wysija['fields'] ) && is_array( $wysija['fields'] ) ? $wysija['fields'] : array(); 
				?>
				<p style="margin: 0 0 5px 0; float: left;"><label for="mab-wys-field-fname"><input type="checkbox" id="mab-wys-field-fname" name="mab[optin][wysija][fields][]" value="firstname" <?php checked( true, in_array( 'firstname', $fields ) ); ?> /> <?php _e('First name', 'mab'); ?></label></p>
				
				<p style="margin: 0 0 5px 0; float: left;"><label for="mab-wys-field-lname"><input type="checkbox" id="mab-wys-field-lname" name="mab[optin][wysija][fields][]" value="lastname" <?php checked( true, in_array( 'lastname', $fields ) ); ?> /> <?php _e('Last name', 'mab'); ?></label></p>
				
				<div class="clear"></div>
			</div>
			
			<div class="mab-option-box">
				<h4><label for="mab-wysija-button-label"><?php _e('Submit Button Label:','mab' ); ?></label></h4>
				<?php 
				$buttonLabel = isset( $wysija['button-label'] ) ? $wysija['button-label'] : 'Subscribe!'; 
				?>
				<input type="text" id="mab-wysija-button-label" name="mab[optin][wysija][button-label]" value="<?php echo $buttonLabel; ?>" />
				<br />
				<br />
				<h4><label for="mab-wysija-success-message"><?php _e('Success Message:','mab'); ?></label></h4>
				<?php
				$message = isset( $wysija['success-message'] ) ? $wysija['success-message'] : 'You\'ve successfully subscribed. Check your inbox now to confirm your subscription.'; ?>
				<textarea id="mab-wysija-success-message" class="large-text" name="mab[optin][wysija][success-message]"><?php echo $message; ?></textarea>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>

	

</div>

<div class="mab-option-box mab-option-field-labels">
	<h4><?php _e('Outside Field Labels', MAB_DOMAIN); ?></h4>
	<p><?php _e('Specify labels shown above or beside the input fields.', MAB_DOMAIN); ?></p>
	<?php $fieldLabels = isset( $optinMeta['field-labels'] ) ? $optinMeta['field-labels'] : array( 'email' => __('Email', MAB_DOMAIN), 'fname' => __('First Name', MAB_DOMAIN), 'lname' => __('Last Name', MAB_DOMAIN) ); ?>
	<ul>
		<li><label><input type="text" value="<?php echo $fieldLabels['email']; ?>" name="mab[optin][field-labels][email]" /> <?php _e('Email Address', MAB_DOMAIN); ?></label></li>
		<li><label><input type="text" value="<?php echo $fieldLabels['fname']; ?>" name="mab[optin][field-labels][fname]" /> <?php _e('First Name', MAB_DOMAIN); ?></label></li>
		<li><label><input type="text" value="<?php echo $fieldLabels['lname']; ?>" name="mab[optin][field-labels][lname]" /> <?php _e('Last Name', MAB_DOMAIN); ?></label></li>
	</ul>

	<h4><?php _e('In-Field Labels', MAB_DOMAIN); ?></h4>
	<p><?php _e('Specify the description text displayed within the input fields.', MAB_DOMAIN); ?></p>
	<?php $inFieldLabels = isset( $optinMeta['infield-labels'] ) ? $optinMeta['infield-labels'] : array( 'email' => __('Enter your email', MAB_DOMAIN), 'fname' => __('Enter your name', MAB_DOMAIN), 'lname' => __('Enter your last name', MAB_DOMAIN) ); ?>
	<ul>
		<li><label><input type="text" value="<?php echo $inFieldLabels['email']; ?>" name="mab[optin][infield-labels][email]" /> <?php _e('Email Address', MAB_DOMAIN); ?></label></li>
		<li><label><input type="text" value="<?php echo $inFieldLabels['fname']; ?>" name="mab[optin][infield-labels][fname]" /> <?php _e('First Name', MAB_DOMAIN); ?></label></li>
		<li><label><input type="text" value="<?php echo $inFieldLabels['lname']; ?>" name="mab[optin][infield-labels][lname]" /> <?php _e('Last Name', MAB_DOMAIN); ?></label></li>
	</ul>

	<p><?php _e('<strong>Note:</strong> Label settings does not work for custom mailing list providers - when you select &quot;Other (Copy &amp; Paste).', MAB_DOMAIN ); ?></p>
</div><!-- .mab-option-box -->

<div class="mab-option-box">
	<h4>Form Fields Layout</h4>
	<?php $fieldsLayout = isset( $meta['optin']['fields-layout'] ) ? $meta['optin']['fields-layout'] : 'default';?>
	<ul>
		<li><label><input type="radio" value="default" name="mab[optin][fields-layout]" <?php checked( $fieldsLayout, 'default' ); ?>/> Default</label></li>
		<li><label><input type="radio" value="stacked" name="mab[optin][fields-layout]" <?php checked( $fieldsLayout, 'stacked' ); ?>/> Stacked</label></li>
	</ul>
	<p><strong>Note:</strong> Actual support for field layout will depend if the style selected supports it.</p>
	<p><strong>Note 2:</strong> This setting will most probably have no effect if this action box is used on the Action Box Widget.</p>
</div><!-- .mab-option-box -->

<?php /*
<div class="mab-option-box">
	<h4><label for="mab-optin-thankyou"><?php _e('Thank You Page', 'mab' ); ?></label></h4>
	<p><?php _e('Enter URL to thank you page where users will be redirected to after signing up. Leave blank to use default URL depending on email provider.','mab' ); ?></p>
	<input type="text" class="large-text" id="mab-optin-thankyou" name="mab[optin][thank-you]" value="<?php echo $meta['optin']['thank-you']; ?>" />
</div>
*/ ?>
