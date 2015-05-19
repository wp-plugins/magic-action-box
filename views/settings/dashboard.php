<div class="wrap">
<div class="about-wrap mab-page" id="mab-dashboard">
	<h1><?php _e('Magic Action Box', 'mab'); ?> <span class="version"><?php echo MAB_VERSION; ?></span></h1>

	<!--div class="about-text"><?php _e('Thanks for installing Magic Action Box.', 'mab'); ?></div-->

	<h2 class="nav-tab-wrapper">
		<a href="#start" class="nav-tab nav-tab-active">
			<?php _e( 'Start', 'mab' ); ?>
		</a>
		<a href="#support" class="nav-tab">
			<?php _e( 'Support &amp; Documentation', 'mab' ); ?>
		</a>
		<a href="#changelog" class="nav-tab">
			<?php _e( 'Change log', 'mab' ); ?>
		</a>
	</h2>

	<div id="start" class="changelog group">

		<div class="feature-section">
			<h3><?php _e( 'Getting started with Magic Action Box', 'mab' ); ?></h3>
			<ul class="bullet">
				<li><a href="http://www.magicactionbox.com/user-guide/integration/using-magic-action-box-with-built-in-integration/" target="_blank"><?php _e('Create your first opt-in form action box with built-in integration', 'mab'); ?></a></li>
				<li><a href="http://www.magicactionbox.com/user-guide/integration/using-magic-action-box-with-any-custom-html-form/" target="_blank"><?php _e('Create your first opt-in form action box from a provided HTML code', 'mab'); ?></a></li>
				<li><a href="http://www.magicactionbox
				.com/user-guide/getting-started/add-an-action-box-to-a-blog-post-or-page/"
				       target="_blank"><?php _e('How to add an action box to a blog post or page', 'mab'); ?></a></li>
			</ul>
			<h3><?php _e('Shortcuts', 'mab'); ?></h3>
			<ul class="bullet">
				<li><a href="<?php echo admin_url('post-new.php?post_type=action-box'); ?>"><?php _e('Create a new action box', 'mab'); ?></a></li>
				<li><a href="<?php echo admin_url('edit.php?post_type=action-box'); ?>"><?php _e('View all action boxes', 'mab'); ?></a></li>
				<li><a href="<?php echo admin_url('admin.php?page=mab-settings'); ?>"><?php _e('Configure settings and accounts', 'mab'); ?></a></li>
				<li><a href="<?php echo admin_url('admin.php?page=mab-design'); ?>"><?php _e('Configure custom styles, fonts and buttons', 'mab'); ?></a></li>
			</ul>
		</div>

		<div class="feature-section">

			<h3><?php _e('Built-in integration', 'mab'); ?></h3>
			<h4><?php _e('Aweber, Constant Contact, MailChimp, SendReach', 'mab'); ?></h4>
			<p><?php printf(__('To connect Aweber, Constant Contact, MailChimp or SendReach with Magic Action Box, go to <a href="%s">Main
Settings</a>
and click on the Accounts &amp; Integration tab. Follow the instructions for connecting your chosen email list service
provider.', 'mab'), admin_url('admin.php?page=mab-settings')); ?></p>
			<img class="screenshot" src="<?php echo MAB_ASSETS_URL; ?>images/screenshot-accounts.jpg" alt="">
			<h4><?php _e('MailPoet, Contact Form 7 and Gravity Forms', 'mab'); ?></h4>
			<p><?php _e('Magic Action Box automatically connects with MailPoet, Contact Form 7 and Gravity Forms when you install their respective plugins.', 'mab'); ?></p>
			<p><?php printf(__('See the <strong>full guide</strong> to <a href="%s" target="_blank">using Magic Action Box with built-in
integration</a>.', 'mab'), 'http://www.magicactionbox.com/user-guide/integration/using-magic-action-box-with-built-in-integration/'); ?></p>
		</div>
	</div><!-- #start -->

	<div id="support" class="changelog group">
		<div class="feature-section">
			<h3><?php _e('Need help?', 'mab'); ?></h3>
			<p><?php printf(__('You can check out our <a href="%s" target="_blank">documentation</a>, go through our <a
			href="%s" target="_blank">forums</a> or <a href="%s" target="_blank">submit a ticket</a>. We should get back to you within 24 hours.', 'mab'), 'http://www.magicactionbox
			.com/documentation/', 'https://prosulum.zendesk
			.com/forums', 'https://prosulum.zendesk.com'); ?></p>
		</div>
	</div><!-- #support -->

	<div id="changelog" class="changelog group">
		<div class="feature-section">
			<ul class="bullet">
				<li>Fix MailChimp api error when another MailChimp plugin is active</li>
				<li>Improve styling for responsive view</li>
				<li>Added native support for Constant Contact</li>
			</ul>
		</div>
	</div><!-- #changelog -->

</div><!-- #mab-dashboard -->
</div><!-- .wrap -->