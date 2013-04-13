<?php
	$meta = $data['meta'];
	$assets_url = $data['assets-url'];
?>

<div class="mab-option-box">
	<h4><label for="mab-sharebox-type"><?php _e('Sharing Buttons','mab' ); ?></label></h4>
	<p><?php _e('Choose the type of sharing buttons you want to display','mab' ); ?></p>
	<?php 
	$shareType = isset( $meta['sharebox']['type'] ) ? $meta['sharebox']['type'] : 'large';
	?>
	<ul>
		<li>
			<label>
				<input value="large" type="radio" <?php checked( $shareType, 'large' ); ?> name="mab[sharebox][type]" /> Large - 32x32 Icons
			</label>
		</li>
		<li>
			<label>
				<input value="small" type="radio" <?php checked( $shareType, 'small' ); ?> name="mab[sharebox][type]" /> Small - 16x16 Icons
			</label>
		</li>
		<li>
			<label>
				<input value="small-counter" type="radio" <?php checked( $shareType, 'small-counter' ); ?> name="mab[sharebox][type]" /> Small Counter
			</label>
		</li>
		<li>
			<label>
				<input value="bubble-counter" type="radio" <?php checked( $shareType, 'bubble-counter' ); ?> name="mab[sharebox][type]" /> Bubble Counter
			</label>
		</li>
	</ul>
</div>

<div class="mab-option-box">
	<h4><label for="mab-aside-placement"><?php _e('Share Box Placement','mab' ); ?></label></h4>
	<p><?php _e('Where do you want to place the share box?','mab' ); ?></p>
	
	<?php $asidePlacement = isset( $meta['aside']['placement'] ) ? $meta['aside']['placement'] : ''; ?>
	<ul class="mab-placement-choices">
		<li>
			<label for="mab-aside-placement-left">
				<img alt="Left Placement" src="<?php echo $assets_url; ?>images/share-icons-left.png" />
				<br />
				<input id="mab-aside-placement-left" value="left" type="radio" <?php checked(in_array($asidePlacement, array('left', '')), true); ?> name="mab[aside][placement]" />
				Left Placement
			</label>
		</li>
		<li>
			<label for="mab-aside-placement-right">
				<img alt="Right Placement" src="<?php echo $assets_url; ?>images/share-icons-right.png" />
				<br />
				<input id="mab-aside-placement-right" type="radio" value="right" <?php checked( $asidePlacement, 'right'); ?> name="mab[aside][placement]"/>
				Right Placement
			</label>
		</li>
		<li>
			<label for="mab-aside-placement-top">
				<img alt="Top Placement" src="<?php echo $assets_url; ?>images/share-icons-top.png" />
				<br />
				<input id="mab-aside-placement-top" value="top" type="radio" <?php checked( $asidePlacement, 'top' ); ?> name="mab[aside][placement]" />
				Top Placement
			</label>
		</li>
	</ul>
</div>

<div class="mab-option-box">
	<h4><label for="mab-sharebox-heading"><?php _e('Share Box Heading','mab' ); ?></label></h4>
	<p><?php _e('Text that will appear before the share buttons.','mab'); ?></p>
	<input type="text" class="large-text" id="mab-sharebox-heading" name="mab[sharebox][heading]" value="<?php echo isset( $meta['sharebox']['heading'] ) ? $meta['sharebox']['heading'] : 'Share This Post'; ?>" />
</div>

<div class="mab-option-box">
	<h4><label for="mab-sharebox-width"><?php _e('Share Box Width','mab'); ?></label></h4>
	<p><?php _e('Specify the width that will be occupied by the share box. Enter <code>auto</code> to set width automatically.','mab' ); ?></p>
	<input type="text" class="small-text code" id="mab-sharebox-width" name="mab[aside][width]" value="<?php echo isset( $meta['aside']['width'] ) ? $meta['aside']['width'] : '200px'; ?>" /> <?php _e('Example: <code>200px</code> or <code>10em</code> or <code>40%</code> or <code>auto</code>','mab' ); ?>
</div>

<div class="mab-option-box">
	<h4><label for="mab-sharebox-twitter-via"><?php _e('Twitter Via Username','mab'); ?></label></h4>
	<p><?php _e('Enter your Twitter username or handle','mab' ); ?></p>
	<?php $twitterVia = !empty( $meta['sharebox']['twitter'] ) ? $meta['sharebox']['twitter']['via'] : ''; ?>
	<input type="text" class="large-text" id="mab-sharebox-twitter-via" name="mab[sharebox][twitter][via]" value="<?php echo $twitterVia; ?>" />
	<br />
	<br />
	<h4><label for="mab-sharebox-twitter-text"><?php _e('Twitter Share Text','mab'); ?></label></h4>
	<textarea id="mab-sharebox-twitter-text" class="large-text" name="mab[sharebox][twitter][share-text]"><?php echo !empty( $meta['sharebox']['twitter']) ? $meta['sharebox']['twitter']['share-text'] : 'Check out this post'; ?></textarea>
	<p><?php _e('Specifying the Twitter Username and Share Text above will result tweet: <strong>[SHARE TEXT] http://shared-url.ly via @[YOUR USERNAME]</strong> when a user retweets a page this action box is attached to.','mab'); ?></p>
</div>