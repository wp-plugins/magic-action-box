<?php

class MAB_Settings extends MAB_Base{
	protected $metaKey = '_mab_settings';

	function getAll(){
		//get from cache
		$settings = wp_cache_get( $this->metaKey, $this->metaKey );

		if( !$settings || !is_array( $settings ) ){
			$settings = get_option( $this->metaKey );

			if( !is_array( $settings ) )
				$settings = $this->getDefaults();
				
			if( !isset( $settings['optin']['allowed'] ) || !is_array( $settings['optin']['allowed'] ) )
				$settings['optin']['allowed'] = array();
				
			wp_cache_set( $this->metaKey, $settings, $this->metaKey );
		}
		return $settings;
	}

	function save( $settings ){
		if( !is_array( $settings ) )
			return;
		
		update_option( $this->metaKey, $settings );
		wp_cache_set( $this->metaKey, $settings, $this->metaKey, time() + 24*60*60 );//cache for 24 hours
	}

	function getDefaults(){
		$default = array(
			'others' => array(
				'reorder-content-filters' => 0,
				'minify-output' => 0
				),
			'optin' => array(
				'aweber-authorization' => '',
				'mailchimp-api' => '',
				'allowed' => array(
					'manual' => 1
					)
				),
			'global-mab' => array(
				'default' => array(
					'actionbox' => '',
					'placement' => 'bottom'
					),
				'page' => array(
					'actionbox' => '',
					'placement' => 'bottom'
					),
				'post' => array(
					'actionbox' => '',
					'placement' => 'bottom'
					),
				'category' => array()
				)
			);

		return $default;
	}

	/**
	 * Set up default settings if this installation is new
	 * @return [type] [description]
	 */
	public function defaultSettingsIfNew(){
		//$settings = get_option( $MabBase->_metakey_Settings );
		//if( !is_array( $settings ) )
		//	$settings = $MabBase->default_settings();
		
		$settings = $this->getAll();
		
		/*
		if( !isset( $settings['optin']['allowed']['manual'] ) )
			$settings['optin']['allowed']['manual'] = 1;
		*/
		
		$this->save($settings);
	}
}