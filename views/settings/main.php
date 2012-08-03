<?php
$globalMab = $data['global-mab'];
$actionBoxesSelect = $data['actionboxList'];
?>
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

<h3 id="mab-settings-tabs" class="nav-tab-wrapper mab-settings-header">
	<a id="mab-general-tab" href="#mab-general" class="nav-tab">General</a>
	<a id="mab-accounts-tab" href="#mab-accounts" class="nav-tab">Accounts</a>
	<a id="mab-default-tab" href="#mab-default" class="nav-tab">Default</a>
	<a id="mab-pages-tab" href="#mab-pages" class="nav-tab">Pages</a>
	<a id="mab-posts-tab" href="#mab-posts" class="nav-tab">Posts</a>
	<a id="mab-category-tab" href="#mab-category" class="nav-tab">Categories</a>
</h3>

<div class="metabox-holder">
<div class="postbox">
<div class="mab-tab-content-wrap">

	<!-- ### GENERAL ### -->
	<div id="mab-general" class="group">
		<h3>General Settings</h3>
		<div class="mab-tab-group-content">
			<?php $others = $data['others']; ?>
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
		</div>
	</div><!-- #mab-general -->
	
	<!-- ### ACCOUNTS ### -->
	<div id="mab-accounts" class="group">
		<h3>Accounts</h3>
		<div class="mab-tab-group-content">
			<?php $optin = $data['optin']; ?>
			<h3>Email Providers</h3>
			<p>Action Box has built-in support for Aweber and MailChimp. Enter your information below to use this services.</p>
			
			<p class="mab-notice">You may still use other e-mail marketing services as long as you are able to generate the HTML code for the form from your provider. In fact, you can even use Aweber or MailChimp without entering any the information below. Just follow the instructions provided when you <a href="<?php echo admin_url('post-new.php?post_type=action-box'); ?>">create an opt-in form type action box</a>.</p>
			
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
		</div>
	</div><!-- #mab-accounts -->
	
	<!-- ### DEFALT ### -->
	<div id="mab-default" class="group">
		<h3>Default Action Box</h3>
		<div class="mab-tab-group-content">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><strong><label for="mab-default-actionbox"><?php _e('Default Action Box','mab'); ?></label></strong></th>
						<td>
							<?php
							$actionBoxesDefaultSelect = $data['actionboxList'];
							//remove default option since not needed for this setting
							unset( $actionBoxesDefaultSelect['default'] ); 
							?>
							<select id="mab-default-actionbox" class="large-text" disabled>
								<?php $defaultActionBox = ''; ?>
								<?php foreach( $actionBoxesDefaultSelect as $boxId => $boxName ): ?>
									<option value="<?php echo $boxId; ?>" <?php selected( $defaultActionBox, $boxId ); ?> ><?php echo $boxName; ?></option>
								<?php endforeach; ?>
							</select>
							<p><?php _e('Default action box to use if no other action box is set for a page/post','mab' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><strong><label for="mab-default-actionbox-placement"><?php _e('Action Box Placement','mab'); ?></label></strong></th>
						<td>
							<?php $defaultActionBoxPlacement = 'bottom'; ?>
							<select id="mab-default-actionbox-placement" class="large-text" disabled>
								<option value="top" <?php selected( $defaultActionBoxPlacement, 'top' ); ?> >Before Content</option>
								<option value="bottom" <?php selected( $defaultActionBoxPlacement, 'bottom' ); ?> >After Content</option>
								<option value="manual" <?php selected( $defaultActionBoxPlacement, 'manual' ); ?> >Manual Placement</option>
							</select>
							<p><?php _e('Action Box Placement will only take effect if corresponding Action Box is set to other values other than <em>Use Default</em>.','mab' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="mab-notice"><a href="http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=mainSettingsTabs">Upgrade to Magic Action Box Pro</a> to be able to assign a default action box for all your Posts and Pages.</p>
		</div>
	</div><!-- #mab-default -->
	
	<!-- ### PAGES ### -->
	<div id="mab-pages" class="group">
		<h3>Pages Action Box</h3>
		<div class="mab-tab-group-content">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><strong><label for="mab-pages-actionbox"><?php _e('Page Action Box','mab'); ?></label></strong></th>
						<td>
							<?php
							$actionBoxesSelect = $data['actionboxList'];
							?>
							<select id="mab-pages-actionbox" class="large-text" disabled>
								<?php $pageActionBox = ''; ?>
								<?php foreach( $actionBoxesSelect as $boxId => $boxName ): ?>
									<option value="<?php echo $boxId; ?>" <?php selected( $pageActionBox, $boxId ); ?> ><?php echo $boxName; ?></option>
								<?php endforeach; ?>
							</select>
							<p><?php _e('Default action box to use for all WP Pages.','mab' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><strong><label for="mab-pages-actionbox-placement"><?php _e('Action Box Placement','mab'); ?></label></strong></th>
						<td>
							<?php $pageActionBoxPlacement = 'bottom'; ?>
							<select id="mab-pages-actionbox-placement" class="large-text" disabled>
								<option value="top" <?php selected( $pageActionBoxPlacement, 'top' ); ?> >Before Content</option>
								<option value="bottom" <?php selected( $pageActionBoxPlacement, 'bottom' ); ?> >After Content</option>
								<option value="manual" <?php selected( $pageActionBoxPlacement, 'manual' ); ?> >Manual Placement</option>
							</select>
							<p><?php _e('Action Box Placement will only take effect if corresponding Action Box is set to other values other than <em>Use Default</em>.','mab' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="mab-notice"><a href="http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=mainSettingsTabs">Upgrade to Magic Action Box Pro</a> to be able to assign a default action box for all WP Pages.</p>
		</div>
	</div><!-- #mab-pages -->
	
	<!-- ### POSTS ### -->
	<div id="mab-posts" class="group">
		<h3>Posts Action Box</h3>
		<div class="mab-tab-group-content">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><strong><label for="mab-posts-actionbox"><?php _e('Post Action Box','mab'); ?></label></strong></th>
						<td>
							<?php
							$actionBoxesSelect = $data['actionboxList'];
							?>
							<select id="mab-post-actionbox" class="large-text" disabled>
								<?php $postActionBox = ''; ?>
								<?php foreach( $actionBoxesSelect as $boxId => $boxName ): ?>
									<option value="<?php echo $boxId; ?>" <?php selected( $postActionBox, $boxId ); ?> ><?php echo $boxName; ?></option>
								<?php endforeach; ?>
							</select>
							<p><?php _e('Can be overriden by category-specific action boxes.','mab' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><strong><label for="mab-post-actionbox-placement"><?php _e('Action Box Placement','mab'); ?></label></strong></th>
						<td>
							<?php $postActionBoxPlacement = 'bottom'; ?>
							<select id="mab-post-actionbox-placement" class="large-text" disabled>
								<option value="top" <?php selected( $postActionBoxPlacement, 'top' ); ?> >Before Content</option>
								<option value="bottom" <?php selected( $postActionBoxPlacement, 'bottom' ); ?> >After Content</option>
								<option value="manual" <?php selected( $postActionBoxPlacement, 'manual' ); ?> >Manual Placement</option>
							</select>
							<p><?php _e('Action Box Placement will only take effect if corresponding Action Box is set to other values other than <em>Use Default</em>.','mab' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="mab-notice"><a href="http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=mainSettingsTabs">Upgrade to Magic Action Box Pro</a> to be able to assign a default action box for all Posts.</p>
		</div>
	</div><!-- #mab-posts -->
	
	<!-- ### CATEGORIES ### -->
	<div id="mab-category" class="group">
		<h3>Categories Action Box</h3>
		<div class="mab-tab-group-content">
			<p><?php _e('Specify an action box to use for blog posts under a specific category. This will take precedence over the default (global) action box set for blog posts.','mab' ); ?></p>
			<p><?php _e('Action Box Placement will only take effect if corresponding Action Box is set to other values other than <em>Use Default</em>.','mab' ); ?></p>
			<p class="mab-notice"><a href="http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=mainSettingsTabs">Upgrade to Magic Action Box Pro</a> to be able to use this feature.</p>
			<table class="widefat">
				<thead>
					<tr>
						<th><strong><?php _e( 'Category Title','mab' ); ?></strong></th>
						<th><strong><?php _e( 'Action Box','mab' ); ?></strong></th>
						<th><strong><?php _e( 'Action Box Placement','mab' ); ?></strong></th>
					</tr>
				</thead>
				<tbody>
					<?php $categories = $data['categories']; 
					$actionBoxesSelect = $data['actionboxList']; ?>
					<?php foreach( $categories as $catId => $catName ) : ?>
					<tr>
						<?php
						$catActionBox = 'default';
						?>
						<th scope="row"><label for="mab-category-<?php echo $catId; ?>-actionbox"><?php echo $catName; ?></label></th>
						<td>
							<select id="mab-pages-actionbox" class="large-text" disabled>
								<?php foreach( $actionBoxesSelect as $boxId => $boxName ): ?>
									<option value="<?php echo $boxId; ?>" <?php selected( $catActionBox, $boxId ); ?> ><?php echo $boxName; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<?php $catActionBoxPlacement = 'bottom'; ?>
							<select id="mab-category-<?php echo $catId; ?>-actionbox-placement" class="large-text" disabled>
								<option value="top" <?php selected( $catActionBoxPlacement, 'top' ); ?> >Before Content</option>
								<option value="bottom" <?php selected( $catActionBoxPlacement, 'bottom' ); ?> >After Content</option>
								<option value="manual" <?php selected( $catActionBoxPlacement, 'manual' ); ?> >Manual Placement</option>
							</select>
						</td>
					</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div><!-- #mab-categories -->

	<div class="mab-tab-settings-submit-wrap">
		<?php wp_nonce_field('save-mab-settings', 'save-mab-settings-nonce' ); ?>
		<input type="submit" class="button-primary" name="save-mab-settings" id="save-mab-settings" value="<?php _e('Save Changes', 'mab' ); ?>" />
	</div>

<?php 
//myprint_r( $data );
?>

</div><!-- .mab-tab-content-wrap -->
</div><!-- .postbox -->
</div><!-- .metabox-holder -->

<!-- START FOOTER -->
			</div><!-- #mab-content -->		
		</form>
	</div>
</div><!-- .themes-php -->
