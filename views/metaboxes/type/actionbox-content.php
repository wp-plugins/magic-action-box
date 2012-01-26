<?php
	$meta = $data['meta'];
	$assets_url = $data['assets-url'];
?>

<div class="mab-option-box">
	<h4><label for="mab-main-heading"><?php _e('Main Heading','mab' ); ?></label></h4>
	<p><?php _e('Main headline of your action box.','mab' ); ?></p>
	<input type="text" class="large-text" id="mab-main-heading" name="mab[main-heading]" value="<?php echo $meta['main-heading']; ?>" />
</div>

<div class="mab-option-box">
	<h4><label for="mab-subheading"><?php _e('Sub Heading','mab' ); ?></label></h4>
	<p><?php _e('Sub-heading of your action box. Will appear below the main heading.','mab' ); ?></p>
	<input type="text" class="large-text" id="mab-subheading" name="mab[subheading]" value="<?php echo $meta['subheading']; ?>" />
</div>

<div class="mab-option-box">
	<h4><label for="mab-main-copy"><?php _e('Main Copy','mab' ); ?></label></h4>
	<p><?php _e('Copy that is displayed before the main action item (i.e. button, opt-in form).','mab' ); ?></p>
	<textarea id="mab-main-copy" class="large-text" id="mab-main-copy" name="mab[main-copy]" rows="6" cols="60"><?php echo $meta['main-copy']; ?></textarea>
</div>

<div class="mab-option-box">
	<h4><label for="mab-secondary-copy"><?php _e('Secondary Copy','mab' ); ?></label></h4>
	<p><?php _e('Copy that is displayed after the main action item.','mab' ); ?></p>
	<textarea id="mab-secondary-copy" class="large-text" id="mab-secondary-copy" name="mab[secondary-copy]" rows="6" cols="60"><?php echo $meta['secondary-copy']; ?></textarea>
</div>