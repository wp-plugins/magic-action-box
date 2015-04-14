<?php

add_shortcode( 'magicactionbox', 'mab_get_actionbox_shortcode_wrap' );
add_shortcode( 'mab_button', 'mab_button_shortcode');
add_shortcode( 'mab_load_assets', 'mab_load_assets_shortcode');

function mab_get_actionbox_shortcode_wrap( $atts = array(), $content = '', $code = '' ){
	
	$notice = '<div class="mab-shortcode-notice">Sorry, the <code>[magicactionbox]</code> shortcode is only available in the <a href="http://www.magicactionbox.com/pricing/?pk_campaign=LITE&pk_kwd=shortcode_notice">Pro version</a>.</div>';
	wp_enqueue_style('mab-extras');
	return $notice;
}


/**
 * MAB Button Shortcode
 */
function mab_button_shortcode($atts = array(), $content = '', $code = ''){
	$notice = '<div class="mab-shortcode-notice">Sorry, the <code>[mab_button]</code> shortcode is only available in the <a href="http://www.magicactionbox.com/pricing/?pk_campaign=LITE&pk_kwd=shortcode_notice">Pro version</a>.</div>';
	wp_enqueue_style('mab-extras');
	return $notice;
}

function mab_load_assets_shortcode($atts = array(), $content = '', $code = ''){
	$default = array(
		'id' => null
	);
	extract( shortcode_atts($default, $atts) );

	mab_load_actionbox_assets($id);
}