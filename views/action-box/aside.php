<?php 
$aside_content = '';

if( isset( $meta['aside'] )){
	//new system
	$aside = $meta['aside'];
	$type = $aside['type'];

	if( 'image' == $type ) {

		$image_url = isset( $aside['image']['url'] ) ? $aside['image']['url'] : '';
		$width = isset( $aside['width'] ) ? 'width="' . $aside['width'] . '"' : '';
		$height = isset( $aside['height'] ) ? 'height="' . $aside['height'] . '"' : '';

		$aside_content = !empty( $image_url ) ? sprintf( '<img src="%s" alt="Opt In Image" %s %s />', $image_url, $width, $height ) : '';

	} elseif( 'video' == $type ) {

		$aside_content = isset( $aside['video']['embed-code'] ) ? $aside['video']['embed-code'] : '';

	}
} else {
	//old system
	if( !empty( $meta['aside-image-url'] ) ){
		$type = 'image';

		$image_url = $meta['aside-image-url'];
		$width = empty( $meta['aside-image-width'] ) ? '' : 'width="' . $meta['aside-image-width'] . '"';
		$height = empty( $meta['aside-image-height'] ) ? '' : 'height="' . $meta['aside-image-height'] . '"';

		$aside_content = sprintf( '<img src="%s" alt="Opt In Image" %s %s />', $image_url, $width, $height );
	}
}


if( !empty( $aside_content ) ) : ?>
	<div class="mab-aside"><?php echo $aside_content; ?></div>
<?php endif; ?>