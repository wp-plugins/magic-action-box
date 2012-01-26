<?php

class ProsulumMabDesign{
	function ProsulumMabDesign(){
		$this->__construct();
	}
	
	function __construct(){
	}
	
	function getDefaultSettings(){
		$defaults = array(
		
		###### General Design
		'main_background_color' => '#F5F5F5',
		'main_background_color_select' => 'hex',
		'main_background_image' => '',
		'main_background_repeat' => 'no-repeat',
		'main_background_align' => 'center',
		'main_border' => '3',
		'main_border_color' => '#CCCCCC',
		'main_border_style' => 'solid',
		'main_margin_bottom' => '20',
		'main_margin_top' => '20',
		'main_padding' => '15',
		'main_corner_radius' => '0',
		'main_width' => '',
		'main_font_color' => '#282828',
		'main_font_family' => "Arial, Helvetica, sans-serif",
		'main_font_size' => '14',
		'main_line_height' => '18',
		## Links
		'main_link_background_select' => 'transparent',
		'main_link_background' => '#FFFFFF',
		'main_link_color' => '#92031a',
		'main_link_decoration' => 'underline',
		'main_link_hover_background_select' => 'transparent',
		'main_link_hover_background' => '#FFFFFF',
		'main_link_hover' => '#ce0021',
		'main_link_hover_decoration' => 'none',
		
		##### HEADING
		'heading_margin_top' => '0',
		'heading_margin_bottom' => '7',
		'heading_align' => 'left',
		'heading_font_color' => '#282828',
		'heading_font_family' => 'inherit',
		'heading_font_size' => '22',
		'heading_font_style' => 'normal',
		'heading_font_weight' => 'bold',
		'heading_text_transform' => 'none',
		
		### SUBHEADING
		'subheading_margin_top' => '0',
		'subheading_margin_bottom' => '10',
		'subheading_align' => 'left',
		'subheading_font_color' => '#555555',
		'subheading_font_family' => 'inherit',
		'subheading_font_size' => '17',
		'subheading_font_style' => 'normal',
		'subheading_font_weight' => 'bold',
		'subheading_text_transform' => 'none',
		
		### ASIDE
		'aside_background_color' => '#FFFFFF',
		'aside_background_color_select' => 'transparent',
		'aside_border' => '1',
		'aside_border_color' => '#CCCCCC',
		'aside_border_style' => 'none',
		'aside_background_shadow' => '',
		'aside_margin_top' => '',
		'aside_margin_bottom' => '',
		'aside_margin_right' => '',
		'aside_margin_left' => '',
		'aside_padding' => '',
		'aside_corner_radius' => '',
		
		### OPTIN FORM
		//labels
		'input_label_font_color' => '#000000',
		'input_label_font_size' => '14',
		'input_label_font_family' => 'Arial, Helvetica, sans-serif',
		'input_label_font_style' => 'normal',
		'input_label_font_weight' => 'bold',
		'input_label_margin_bottom' => '',
		
		//Input
		'input_background_color' => '#FFFFFF',
		'input_background_color_select' => 'hex',
		'input_border' => '1',
		'input_border_color' => '#999999',
		'input_border_style' => 'solid',
		'input_font_color' => '#555555',
		'input_font_family' => 'Arial, Helvetica, sans-serif',
		'input_font_size' => '14',
		'input_font_style' => 'normal',
		'input_width' => '150',
		
		//submit button
		'button_background_color' => '#333333',
		'button_background_color_select' => 'hex',
		'button_background_hover_color' => '#555555',
		'button_background_hover_color_select' => 'hex',
		'button_border' => '1',
		'button_border_color' => '#222222',
		'button_border_style' => 'solid',
		'button_border_hover_color' => '#333333',
		'button_font_color' => '#FFFFFF',
		'button_font_hover_color' => '#FFFFFF',
		'button_text_shadow' => '', //-1px -1px 0 #111111
		'button_text_shadow_hover' => '', //-1px -1px 0 #272727
		'button_font_family' => 'Arial, Helvetica, sans-serif',
		'button_font_size' => '14',
		'button_margin_top' => '15',
		'button_margin_bottom' => '',
		'button_margin_left' => '',
		'button_margin_right' => '',
		'button_padding_top' => '3',
		'button_padding_bottom' => '3',
		'button_padding_right' => '3',
		'button_padding_left' => '3',
		'button_border_radius' => '3',
		'button_text_transform' => 'none',
		
		);
		
		return apply_filters( 'mab_style_defaults', $defaults );
	}
	
	function getSettings( $postId = '' ){
		global $post, $MabBase;
		
		if( empty( $postId ) ){
			$postId = $post->ID;
		}
		//get style settings stored in post metadata
		$settings = $MabBase->get_mab_meta( $postId, 'design' );
		
		if( !is_array( $settings ) ){
			$settings = $this->getDefaultSettings();
		}
		
		return $settings;
	}
	
	function updateSettings( $postId, $meta, $metaKey = '' ){
		global $MabBase;
		$MabBase->update_mab_meta( $postId, $meta, 'design' );
	}
	
	//NOTE: Not to be used?
	function getConfiguredStyle( $key = null ){
		$styles = $this->getSettings();
	}
	
	
	
	
}

global $MabDesign;
$MabDesign = new ProsulumMabDesign();
