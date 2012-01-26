<?php
	$meta = $data['meta'];
	$assets_url = $data['assets-url'];
?>

<div class="mab-option-box">
	<h4><label for="mab-optin-form-heading"><?php _e('Main Heading','mab' ); ?></label></h4>
	<p><?php _e('Main headline of your opt in form.','mab' ); ?></p>
	<input type="text" class="large-text" id="mab-optin-form-heading" name="mab[optin-heading]" value="<?php echo $meta['optin-heading']; ?>" />
</div>

<div class="mab-option-box">
	<h4><label for="mab-optin-form-subheading"><?php _e('Sub Heading','mab' ); ?></label></h4>
	<p><?php _e('Sub-heading of your opt in form. Will appear below the main heading.','mab' ); ?></p>
	<input type="text" class="large-text" id="mab-optin-form-subheading" name="mab[optin-subheading]" value="<?php echo $meta['optin-subheading']; ?>" />
</div>

<div class="mab-option-box">
	<h4><label for="mab-optin-form-copy"><?php _e('Main Opt In Copy','mab' ); ?></label></h4>
	<p><?php _e('Copy that is displayed before the opt in form.','mab' ); ?></p>
	<textarea id="mab-optin-form-copy" class="large-text" id="mab-optin-form-copy" name="mab[optin-main-copy]" rows="6" cols="60"><?php echo $meta['optin-main-copy']; ?></textarea>
</div>

<div class="mab-option-box">
	<h4><label for="mab-optin-form-image-url">Opt In Box Image</label></h4>
	<p>You can show an image to the side of the opt in form. Just enter a URL that points to the image you wish to show. You can upload one via the <a id="mab-optin-form-image-url-upload" ref="<?php echo admin_url("media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=1&width=640&amp;height=516"); ?>">WordPress uploader</a>.</p>

	<input type="text" class="large-text" id="mab-optin-form-image-url" name="mab[optin-image-url]" value="<?php echo $meta['optin-image-url']; ?>" />
</div>

<div class="mab-option-box">
	<h4>Image Dimensions</h4>
	<p>You can optionally specify the image <code><label for="mab-optin-form-image-width">width</label></code> and <code><label for="mab-optin-form-image-height">height</label></code>. <strong>Example:</strong> <code>200px</code> or <code>4.5em</code>.
	</p>
	<p><strong>Tip:</strong> Specify only the <code><label for="mab-optin-form-image-width">width</label></code> to set height automatically.</p>
	<p>
		<strong><label for="mab-optin-form-image-width">Width</label></strong>
		<input type="text" class="small-text" id="mab-optin-form-image-width" name="mab[optin-image-width]" value="<?php echo $meta['optin-image-width']; ?>" />
		<strong><label for="mab-optin-form-image-height">Height</label></strong>
		<input type="text" class="small-text" id="mab-optin-form-image-height" name="mab[optin-image-height]" value="<?php echo $meta['optin-image-height']; ?>" />
	</p>
</div>

<div class="mab-option-box">
	<h4>Image Placement</h4>
	<p>Where do you want the image in relation to your opt in form?</p>

	<ul id="mab-optin-image-placement-choices" class="mab-placement-choices">
		<li>
			<label for="mab-optin-image-placement-left">
				<img alt="Image Left Placement" src="<?php echo $assets_url; ?>images/optin-image-left.png" />
				<br />
				<input id="mab-optin-image-placement-left" value="left" type="radio" <?php checked(in_array($meta['optin-image-placement'], array('left', '')), true); ?> name="mab[optin-image-placement]" />
				Left Placement
			</label>
		</li>
		<li>
			<label for="mab-optin-image-placement-right">
				<img alt="Image Right Placement" src="<?php echo $assets_url; ?>images/optin-image-right.png" />
				<br />
				<input id="mab-optin-image-placement-right" type="radio" value="right" <?php checked( $meta['optin-image-placement'], 'right'); ?> name="mab[optin-image-placement]"/>
				Right Placement
			</label>
		</li>
		<li>
			<label for="mab-optin-image-placement-top">
				<img alt="Image Top Placement" src="<?php echo $assets_url; ?>images/optin-image-top.png" />
				<br />
				<input id="mab-optin-image-placement-top" value="top" type="radio" <?php checked( $meta['optin-image-placement'], 'top' ); ?> name="mab[optin-image-placement]" />
				Top Placement
			</label>
		</li>
	</ul>
	
</div>

<div class="mab-option-box">
	<h4><label for="mab-optin-form-secondary-copy"><?php _e('Secondary Opt In Copy','mab' ); ?></label></h4>
	<p><?php _e('Copy that is displayed after the opt in form.','mab' ); ?></p>
	<textarea id="mab-optin-form-secondary-copy" class="large-text" id="mab-optin-form-secondary-copy" name="mab[optin-secondary-copy]" rows="6" cols="60"><?php echo $meta['optin-secondary-copy']; ?></textarea>
</div>
