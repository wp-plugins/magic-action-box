<?php
global $post;

$shareBox = $data['sharebox'];
$form = $data['form'];
$meta = $data['meta'];
$id = $meta['ID'];
$action_box_type = $data['action-box-type'];

$placement_class = empty( $meta['aside']['placement'] ) ? 'left' : 'mab-aside-' . $meta['aside']['placement'];

$image_width = empty( $meta['aside-image-width'] ) ? '' : 'width="' . $meta['aside-image-width'] . '"';
$image_height = empty( $meta['aside-image-height'] ) ? '' : 'height="' . $meta['aside-image-height'] . '"';
$aside_width = empty( $meta['aside']['width'] ) ? '' : "width: {$meta['aside']['width']};";

//this to have unique ID of the main containing div in case there is more than action box with the same id
$html_id = $data['mab-html-id'];

$mab_classes = $data['class'];
?>

<div id="mab-<?php echo $html_id; ?>" <?php echo $mab_classes; ?>>
	<div class="mab-pad mab-wrap <?php echo $placement_class; ?>">

		<div class="mab-aside" style="<?php echo $aside_width; ?>">
			<div class="mab-sharebox">
				<?php if( !empty( $meta['sharebox']['heading'] ) ) : ?>
					<h4 class="mab-subheading"><?php echo $meta['sharebox']['heading'];?></h4>
				<?php endif; ?>
				<?php
				$twitterVia = !empty( $meta['sharebox']['twitter']['via'] ) ? "via @{$meta['sharebox']['twitter']['via']}" : '';
				$twitterText = isset( $meta['sharebox']['twitter']['share-text'] ) ? $meta['sharebox']['twitter']['share-text'] : 'Check this out';
				?>
				<script type="text/javascript">
				var addthis_config = {
					"data_track_clickback" : false //disable tracking. removes hashtags on sharing urls
				};
				var addthis_share = {
					templates:{ twitter: "<?php echo "$twitterText {{title}} {{url}} $twitterVia"; ?>" }
				};
				</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=wp-4f974d1e54270e5a"></script>
				<?php echo $shareBox; ?>
				
			</div>
		</div>
		
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
