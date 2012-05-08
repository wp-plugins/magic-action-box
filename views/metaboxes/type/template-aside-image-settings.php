<div class="mab-option-box">
	<h4><label for="mab-aside-image-url">Action Box Image</label></h4>
	<p>You can show an image to the side of the action box. Just enter a URL that points to the image you wish to show. You can upload one via the <a id="mab-aside-image-url-upload" href="<?php echo admin_url("media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=1&width=640&amp;height=516"); ?>">WordPress uploader</a>.</p>

	<input type="text" class="large-text" id="mab-aside-image-url" name="mab[aside-image-url]" value="<?php echo $meta['aside-image-url']; ?>" />
</div>

<div class="mab-option-box">
	<h4>Image Dimensions</h4>
	<p>You can optionally specify the image <code><label for="mab-aside-image-width">width</label></code> and <code><label for="mab-aside-image-height">height</label></code>. <strong>Example:</strong> <code>200px</code> or <code>4.5em</code>.
	</p>
	<p><strong>Tip:</strong> Specify only the <code><label for="mab-aside-image-width">width</label></code> to set height automatically.</p>
	<p>
		<strong><label for="mab-aside-image-width">Width</label></strong>
		<input type="text" class="small-text" id="mab-aside-image-width" name="mab[aside-image-width]" value="<?php echo $meta['aside-image-width']; ?>" />
		<strong><label for="mab-aside-image-height">Height</label></strong>
		<input type="text" class="small-text" id="mab-aside-image-height" name="mab[aside-image-height]" value="<?php echo $meta['aside-image-height']; ?>" />
	</p>
</div>

<div class="mab-option-box">
	<h4>Image Placement</h4>
	<p>Where do you want the image in relation to the other elements in the box??</p>

	<ul id="mab-aside-image-placement-choices" class="mab-placement-choices">
		<li>
			<label for="mab-aside-image-placement-left">
				<img alt="Image Left Placement" src="<?php echo $assets_url; ?>images/optin-image-left.png" />
				<br />
				<input id="mab-aside-image-placement-left" value="left" type="radio" <?php checked(in_array($meta['aside-image-placement'], array('left', '')), true); ?> name="mab[aside-image-placement]" />
				Left Placement
			</label>
		</li>
		<li>
			<label for="mab-aside-image-placement-right">
				<img alt="Image Right Placement" src="<?php echo $assets_url; ?>images/optin-image-right.png" />
				<br />
				<input id="mab-aside-image-placement-right" type="radio" value="right" <?php checked( $meta['aside-image-placement'], 'right'); ?> name="mab[aside-image-placement]"/>
				Right Placement
			</label>
		</li>
		<li>
			<label for="mab-aside-image-placement-top">
				<img alt="Image Top Placement" src="<?php echo $assets_url; ?>images/optin-image-top.png" />
				<br />
				<input id="mab-aside-image-placement-top" value="top" type="radio" <?php checked( $meta['aside-image-placement'], 'top' ); ?> name="mab[aside-image-placement]" />
				Top Placement
			</label>
		</li>
	</ul>
</div>
