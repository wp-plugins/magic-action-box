<?php
	$meta = $data['meta'];
	$assets_url = $data['assets-url'];
	
	//check if settings key from optin form settings is available 
	//and hasn't been imported to new key.
	//This block should only fire on optin type action box
	if( !empty( $meta['optin-image-url'] ) && empty( $meta['aside-image-url'] ) ){
		$meta['aside-image-url'] = $meta['optin-image-url'];
	}
	if( !empty( $meta['optin-image-width'] ) && empty( $meta['aside-image-width'] ) ){
		$meta['aside-image-width'] = $meta['optin-image-width'];
	}
	if( !empty( $meta['optin-image-height'] ) && empty( $meta['aside-image-height'] ) ){
		$meta['aside-image-height'] = $meta['optin-image-height'];
	}
	if( !empty( $meta['optin-image-placement'] ) && empty( $meta['aside-image-placement'] ) ){
		$meta['aside-image-placement'] = $meta['optin-image-placement'];
	}
?>

<?php include_once "template-aside-image-settings.php"; ?>
