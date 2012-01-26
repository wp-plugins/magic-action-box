<?php
/**
 * Style Settings Template
 * this template is loaded using php include
 */
?>
<?php $styles = $data['styles']; ?>
<div class="mab-option-box">
	<h4><label for="mab-style"><?php _e('Action Box Style', 'mab' ); ?></label></h4>
	<p>Choose a style for this Action Box. Select <strong>User Settings</strong> to use the design settings specified below.</p>
	<select id="mab-style" class="large-text" name="mab[style]">
		<?php foreach( $styles as $key => $style ): ?>
			<option value="<?php echo $key; ?>" <?php selected( $meta['style'], $key ); ?> ><?php echo $style['name']; ?></option>
		<?php endforeach; ?>
	</select>
	<p class="description">More styles available in <a href="http://magicactionbox.com">Magic Action Box Pro</a>.</p>
	<h4 id="mab-style-preview-heading"><?php _e('Thumbnail Preview','mab'); ?><br />
	<small>Note: This is only a representation of the design and does not reflect the actual look.</small></h4>
	<ul id="mab-style-preview">
		<li id="mab-style-user-preview" style="display:none;"></li>
		<li id="mab-style-none-preview" style="display:none;"><span class="mab-style-caption"><strong>Note:</strong> CSS styles specified in the Custom CSS box <em>(under Design Setting: Others)</em> will still be applied.</span></li>
		<?php foreach( $styles as $key => $style ): ?>
			<?php $styleThumb = $MabAdmin->getActionBoxStyleThumb( $key ); ?>
			<li id="mab-style-<?php echo $key; ?>-preview" <?php if( $key != $meta['style'] ):?> style="display: none;" <?php endif; ?>>
				<div class="mab-style-thumb">
					<?php if( !empty( $styleThumb ) ): ?>
						<img class="mab-style-image" src="<?php echo $styleThumb; ?>" alt="" width="300" />
					<?php else: ?>
						<span class="mab-style-noimage"><strong>No thumbnail image defined</strong></span>
					<?php endif; ?>
					<span class="mab-style-caption">Any CSS styles specified in the Custom CSS box<br /><strong>(Design Settings: Others)</strong> will be applied.</span>
				</div>
				<div class="mab-style-description"><strong>Description:</strong><br /><?php echo !empty( $style['description']) ? $style['description'] : 'None.'; ?></div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
