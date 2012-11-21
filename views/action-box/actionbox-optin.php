<?php
$form = $data['form'];
$meta = $data['meta'];
$id = $meta['ID'];
$action_box_type = $data['action-box-type'];

$placement_class = empty( $meta['aside-image-placement'] ) ? '' : 'mab-aside-' . $meta['aside-image-placement'];

$image_width = empty( $meta['aside-image-width'] ) ? '' : 'width="' . $meta['aside-image-width'] . '"';
$image_height = empty( $meta['aside-image-height'] ) ? '' : 'height="' . $meta['aside-image-height'] . '"';

//this to have unique ID of the main containing div in case there is more than action box with the same id
$html_id = $data['mab-html-id'];

$mab_classes = $data['class'];
?>

<div id="mab-<?php echo $html_id; ?>" <?php echo $mab_classes; ?>>
	<div class="mab-pad mab-wrap <?php echo $placement_class; ?>">
		
		<?php if( !empty( $meta['aside-image-url'] ) ) : //ASIDE ?>
		<div class="mab-aside">
			<img src="<?php echo $meta['aside-image-url']; ?>" alt="Opt In Image" <?php echo $image_width; ?> <?php echo $image_height; ?> />
		</div>
		<?php endif; ?>
		
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
			
			<!-- add .mab-elements-pos-stacked or .mab-elements-pos-inline to .mab-main-action-wrap -->
			<div class="mab-main-action-wrap ">
				<?php echo $form; ?>
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
