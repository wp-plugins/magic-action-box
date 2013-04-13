<?php
$meta = $data['meta'];
$id = $meta['ID'];
$action_box_type = $data['action-box-type'];

//$placement_class = empty( $meta['aside-image-placement'] ) ? '' : 'mab-aside-' . $meta['aside-image-placement'];

$placement_class = '';
if( !empty( $meta['aside-image-placement'] ) || !empty( $meta['aside']['placement'] ) ){
	$placement_class = 'mab-aside-';
	$placement_class .= empty( $meta['aside']['placement'] ) ? $meta['aside-image-placement'] : $meta['aside']['placement'];
}

if( isset( $meta['aside']['type'] ) ){
	$placement_class .= ' mab-aside-type-' . $meta['aside']['type'];
} else {
	$placement_class .= !empty( $meta['aside-image-url'] ) ? ' mab-aside-type-image' : ' mab-aside-type-none';
}

//this to have unique ID of the main containing div in case there is more than action box with the same id
$html_id = $data['mab-html-id'];

$mab_classes = $data['class'];
?>

<div id="mab-<?php echo $html_id; ?>" <?php echo $mab_classes; ?>>
	<div class="mab-pad mab-wrap <?php echo $placement_class; ?>">
		
		<?php include 'aside.php'; ?>
		
		<div class="mab-content">
			
			<?php if( !empty( $meta['main-heading'] ) ) : //HEADING ?>
			<div class="mab-heading"><?php echo do_shortcode($meta['main-heading']); ?></div>
			<?php endif; ?>
			
			<?php if( !empty( $meta['subheading'] ) ) : ?>
			<div class="mab-subheading"><?php echo do_shortcode($meta['subheading']); //SUBHEADING ?></div>
			<?php endif; ?>
	
			<?php if( !empty( $meta['main-copy'] ) ) : //MAIN COPY ?>
			<div class="mab-main-copy"><?php echo do_shortcode(wpautop($meta['main-copy'])); ?></div>
			<?php endif; ?>
			
			<div class="mab-main-action-wrap">
				<?php 
				$button_class = $meta['main-button-class'];
				$button_style = ($meta['main-button-margin-top'] != '') ? "margin-top: " . intval($meta['main-button-margin-top']) . "px;" : '';
				$button_style .= ($meta['main-button-margin-bottom'] != '') ? "margin-bottom: " . intval($meta['main-button-margin-bottom']) . "px;" : '';
				$button_style .= ($meta['main-button-margin-left'] != '') ? "margin-left: " . intval($meta['main-button-margin-left']) . "px;" : '';
				$button_style .= ($meta['main-button-margin-right'] != '') ? "margin-right: " . intval($meta['main-button-margin-right']) . "px;" : '';
				
				$button_attr = !empty( $meta['main-button-attributes'] ) ? html_entity_decode($meta['main-button-attributes']) : '';
				if( $meta['main-button-type'] == 'image' ): ?>
					<?php
					$button_image_width = empty( $meta['main-button-image-width'] ) ? '' : 'width="' . intval($meta['main-button-image-width']) . '"';
					$button_image_height = empty( $meta['main-button-image-height'] ) ? '' : 'height="' . intval($meta['main-button-image-height']) . '"';
					?>
					<a class="mab-main-button mab-button-type-image <?php echo $button_class; ?>" <?php echo $button_attr; ?> href="<?php echo $meta['main-button-url']; ?>" style="<?php echo $button_style; ?>" >
						<img src="<?php echo $meta['main-button-image']; ?>" alt="" <?php echo $button_image_width; ?> <?php echo $button_image_height; ?> />
					</a>
					
				<?php elseif( $meta['main-button-type'] == 'css3' ): ?>
					<?php $button_class .= " mab-button-{$meta['main-button-key']}"; ?>
					<a class="mab-main-button mab-button-type-css3 <?php echo $button_class; ?>" <?php echo $button_attr; ?> href="<?php echo $meta['main-button-url']; ?>" style="<?php echo $button_style; ?>" ><?php echo $meta['main-button-text']; ?></a>
					
				<?php endif; ?>
				
			</div>
			
			<?php if( !empty( $meta['secondary-copy'] ) ) : //SECONDARY COPY?>
			<div class="mab-secondary-copy"><?php echo do_shortcode(wpautop($meta['secondary-copy'])); ?></div>
			<?php endif; ?>
			
		</div><!-- .mab-content-->
		<?php 
		$clearing_div = '<div class="clear" style="clear:both;"></div>'; 
		echo apply_filters( 'mab_clearing_div', $clearing_div ); ?>
	</div>
</div>

<?php //endif; ?>
