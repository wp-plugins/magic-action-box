<div class="themes-php">
	<div class="wrap">
		<?php screen_icon('edit-comments'); ?>
		<h2 id="mab-settings-header">Magic Action Box Settings</h2>
		
		<?php
		$messages = $data['messages'];
		if( !empty( $messages ) ){
			if( !empty( $messages['updates'] ) ){
				foreach( $messages['updates'] as $key => $update ){
					?><div id="mab-settings-updated-message-<?php echo $key; ?>" class="updated fade"><p><strong><?php esc_html_e( $update, 'mab' ); ?></strong></p></div><?php
				}
			}
			
			if( !empty( $messages['errors'] ) ){
				foreach( $messages['errors'] as $key => $error ){
					?><div id="mab-settings-error-message-<?php echo $key; ?>" class="error fade"><p><strong><?php esc_html_e($error, 'mab' ); ?></strong></p></div><?php
				}
			}
		}
		?>
		
		<form method="post" action="<?php echo add_query_arg( array() ); ?>">
			<div id="mab-content">
<!-- END HEADER -->

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"></th>
			<td></td>
		</tr>
	</tbody>
</table>

<?php $optin = $data['optin']; 
$others = $data['others']; ?>
<h3>Email Providers</h3>
<p>Action Box integrates with several opt in providers, including Aweber, Constant Contact, and MailChimp. Enter your information below to use this services.</p>

<h4>Aweber</h4>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"><label for="mab-optin-aweber-authorization"><?php _e('AWeber Authorization Code', 'mab' ); ?></label></th>
			<td>
				<input type="text" class="code large-text" name="mab[optin][aweber-authorization]" id="mab-optin-aweber-authorization" value="<?php echo esc_attr($optin['aweber-authorization']); ?>"  /><br />
				<a href="<?php echo $data['_optin_AweberAuthenticationUrl'] . $data['_optin_AweberApplicationId']; ?>" target="_blank"><?php _e('Click here to get your authorization code.','mab' ); ?></a>
			</td>
		</tr>
	</tbody>
</table>

<h4><?php _e('MailChimp', 'mab' ); ?></h4>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"><label for="mab-optin-mailchimp-api"><?php _e('MailChimp API Key', 'mab' ); ?></label></th>
			<td>
				<input type="text" class="code large-text" name="mab[optin][mailchimp-api]" id="mab-optin-mailchimp-api" value="<?php echo esc_attr($optin['mailchimp-api']); ?>" /><br />
				<a href="http://admin.mailchimp.com/account/api-key-popup" target="_blank"><?php _e('Get your API key.', 'mab' ); ?></a>
			</td>
		</tr>
	</tbody>
</table>

<h3><?php _e('Other Settings','mab' ); ?></h3>
<p>Below are advanced settings.</p>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"><?php _e('Clear Cache', 'mab' ); ?></th>
			<td><a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array('page'=>'mab-main', 'mab-clear-cache'=>'true'), admin_url('admin.php' )), 'mab-clear-cache' ) ); ?>" class="button-secondary"><?php _e('Clear Cache.', 'mab' ); ?></a>
				<?php _e('Click on the <strong>Clear Cache</strong> button to clear your cache directory located in <code>wp-content/uploads/magic-action-box</code>.', 'mab' ); ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Reorder post content filter priorities','mab' ); ?></th>
			<td>
				<ul>
					<li>
						<label for="mab-reorder-thecontent-filters">
							<input type="checkbox" id="mab-reorder-thecontent-filters" value="1" name="mab[others][reorder-content-filters]" <?php checked( 1, $others['reorder-content-filters'] ); ?> />
							Force action box to display first
						</label>
					</li>
				</ul>
				<small><?php _e('Check this box if other plugins (i.e. social sharing) are showing up above the action box and you want to show the action box first. BUT, please note that doing so may conflict with other plugins. When that happens, you may deactivate this option.', 'mab' ); ?></small>
				<?php //var_dump( $others['reorder-content-filters'] ); ?>
			</td>
		</tr>
	</tbody>
</table>


<br />
<br />
<br />
<p class="submit">
	<?php wp_nonce_field('save-mab-settings', 'save-mab-settings-nonce' ); ?>
	<input type="submit" class="button-primary" name="save-mab-settings" id="save-mab-settings" value="<?php _e('Save Changes', 'mab' ); ?>" />
</p>

<?php 
//myprint_r( $data );
?>

<!-- START FOOTER -->
			</div><!-- #mab-content -->		
		</form>
	</div>
</div>
