<?php
global $MabAdmin;
?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e('Add New Action Box', 'mab' ); ?></h2>

	<p>
		<?php _e('Choose the type of Magic Action Box you wish to create. You cannot change the type of an Action Box after creating it, so choose wisely.', 'mab' )?>
	</p>
	<ul id="mab-type-choice">
		<?php
		global $post;
		$types = $MabAdmin->getAvailableActionBoxTypes();
		foreach($types as $type => $info) {
			?>
			<li>
				<?php
				$query_args = array( 'action' => 'edit', 'post' => $post->ID, 'action_box_set' => 1, 'action_box_type' => $type );
				$url = add_query_arg( $query_args, admin_url('post.php') );
				$url = wp_nonce_url( $url, 'action_box_set' );
				?>
				<?php if( $type === 'optin' ) : ?>
					<a class="mab-type-title" href="<?php echo esc_attr($url); ?>"><?php esc_html_e($info['name'], 'mab' ); ?></a><br />
					<?php esc_html_e($info['description'], 'mab' ); ?>
				<?php else: ?>
					<span class="disabled-type"><?php esc_html_e($info['name'], 'mab' ); ?></span><br />
					<em><small>(Available in <a href="http://www.magicactionbox.com/features/?aff=7" target="_blank">Magic Action Box Pro</a>)</small></em><br />
					<?php esc_html_e($info['description'], 'mab' ); ?><br />
					
				<?php endif; ?>
			</li>
			<?php
		}
		?>
	</ul>
	<div class="mab-ad updated">
		<a href="http://www.magicactionbox.com/features/?aff=7" target="_blank"><img src="<?php echo MAB_ASSETS_URL . 'images/adbox.png'; ?>" alt="" class="mab-ad-img" width="200"/></a>
		<div class="mab-ad-content">
			<p>Get additional action box types by getting <a href="http://www.magicactionbox.com/features/?aff=7" target="_blank">Magic Action Box Pro</a>.</p>
			<h4>Some of the features available in the full version:</h4>
			<ul>
				<li>Use all action box types</li>
				<li>Professional Customer Support</li>
				<li>More pre-configured styles</li>
				<li>Conversion Tips and Advice</li>
				<li>Create and upload your own buttons</li>
				<li><a href="http://www.magicactionbox.com/features/?aff=7" target="_blank">And more...</a></li>
			</ul>
		</div>
	</div>
</div>
