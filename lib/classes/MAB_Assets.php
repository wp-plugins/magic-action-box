<?php

class MAB_Assets extends MAB_Base{

	public static function enqueue(){
		wp_enqueue_script( 'mab-ajax-form' );
		wp_localize_script('mab-ajax-form', 'MabAjax', MAB_Ajax::getAjaxData() );
	}

	/**
	 * Register all our JS and CSS files
	 * @return none
	 */
	public static function register(){

		/** Scripts **/		
		wp_register_script( 'mab-wpautop-fix', MAB_ASSETS_URL . 'js/wpautopfix.js', array( 'jquery' ) );
		wp_register_script( 'mab-actionbox-helper', MAB_ASSETS_URL . 'js/actionbox-helper.js', array('jquery') );
		wp_register_script( 'mab-responsive-videos', MAB_ASSETS_URL . 'js/responsive-videos.js', array('jquery'), MAB_VERSION, true);
		wp_register_script( 'mab-placeholder', MAB_ASSETS_URL . 'js/placeholder.js', array('jquery'), MAB_VERSION, true);
		wp_register_script( 'mab-ajax-form', MAB_ASSETS_URL . 'js/ajax-form.js', array( 'jquery' ), "1.0", true );
		wp_register_script( 'mab-postmatic', MAB_ASSETS_URL . 'js/postmatic.js', array( 'mab-ajax-form'), "1.0", true);
		
		/** ADMIN Scripts **/
		wp_register_script( 'mab-youtube-helpers', MAB_ASSETS_URL . 'js/youtube-helpers.js', array( 'jquery' ), MAB_VERSION );
		wp_register_script( 'mab-admin-script', MAB_ASSETS_URL . 'js/magic-action-box-admin.js', array('jquery', 'mab-youtube-helpers'), MAB_VERSION );
		wp_register_script( 'mab-design-script', MAB_ASSETS_URL . 'js/magic-action-box-design.js', array('farbtastic', 'thickbox' ), MAB_VERSION );		
		
		/** Styles **/
		wp_register_style( 'mab-base-style', MAB_ASSETS_URL . 'css/magic-action-box-styles.css', array() );
		
		/** ADMIN styles **/
		wp_register_style( 'mab-admin-style', MAB_ASSETS_URL . 'css/magic-action-box-admin.css', array(), MAB_VERSION );

		/** Languages **/
		load_plugin_textdomain( 'mab', false,  dirname(MAB_BASENAME) . '/languages/' );

	}

	public function __construct(){

	}
}