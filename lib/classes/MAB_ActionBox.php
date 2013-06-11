<?php

class MAB_ActionBox{
	private $_is_configured = false;
	private $_id = null;
	private $_type = null;
	private $_meta = array();
	private $_html_UniqueId = '_mab_html_unique_id';
	
	/**
	 * Get Action Box
	 *
	 * @filters get_action_box-$type
	 * @uses apply_filters( "get_action_box-$type" );
	 *
	 * @return HTML the actual action box in HTML code
	 */
	function getActionBox( $id = null, $loadAssets = true ){
	
		if( is_null( $id ) || '' === $id ){
			//expect $id to already have been passed when the object was instantiated
			if( !$this->isConfigured() ) return '';
		} else {
			if( !$this->init( $id ) ) return '';
		}
		
		$box = $this->getTemplate();
		
		if( $loadAssets ){ //TODO: load assets only if $box is not empty?
			$this->loadAssets();
		}
		
		return $box;
	}
	
	function getTemplateObj(){
		return $this->_template_obj;
	}
	
	function getTemplate(){
		if( !$this->isConfigured() ) return '';
		return $this->_template_obj->getTemplate();
	}
	
	function loadAssets(){
		if( !$this->isConfigured() ) return;
		
		return $this->_template_obj->loadAssets();
	}
	
	/**
	 * Get HTML Unique ID for each action box
	 */
	function getHtmlId(){
		//this to have unique ID attribute of the main containing div in case there is more 
		//than 1 of the same action box. Cache key is composed of $_htmlUniqueId prefix and 
		//ID of the action box.
		$actionBoxId = $this->getId();
		
		$htmlUniqueId = wp_cache_get( $this->_html_UniqueId . $actionBoxId );
		if( false === $htmlUniqueId ){
			//this is the first
			$htmlUniqueId = 1;
			wp_cache_set( $this->_html_UniqueId . $actionBoxId, $htmlUniqueId );
		} else {
			//another box is already displayed
			$htmlUniqueId++;
			wp_cache_replace( $this->_html_UniqueId . $actionBoxId, $htmlUniqueId );
		}
		
		return $actionBoxId.$htmlUniqueId;
	}
	
	/**
	 * @return TRUE if the action box was configured, FALSE otherwise
	 */
	function init( $id = null ){
		global $MabBase;
		//stop early if $id is empty
		if( $id === '' || is_null( $id ) ) return false;
		
		//make sure action box exists
		$actionbox = get_post( $id );
		
		if( empty( $actionbox ) ){
			return false;
		}
		
		//make sure action box type is registered
		$type = $MabBase->get_mab_meta( $id, 'type' );
		if( !$MabBase->get_registered_action_box_type( $type ) ){
			//error_log($type . ' not registered');
			return false;
		}
		$this->_type = $type;
		
		$this->_id = $id;
		$this->_meta = $MabBase->get_mab_meta( $id );
		
		//set $_is_configured to TRUE indicating that this action box
		//is configured correctly
		$this->_is_configured = true;
		
		$this->_template_obj = new MAB_Template( $this );
		
		return true;
	}
	
	function getStyleKey(){
		if( !$this->isConfigured() || empty( $this->_meta['style'] ) ) return '';
		
		return $this->_meta['style'];
	}
	
	function getActionBoxType(){
		return $this->_type;
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getMeta(){
		return $this->_meta;
	}
	
	/**
	 * @return bool
	 */
	function isConfigured(){
		if( !$this->_is_configured )
			return false;
		else
			return true;
	}
	
	function __construct( $id = null ){
		if( !is_null( $id ) ){
			$this->init( $id );
		}
	}
	function MAB_ActionBox($id = null){
		$this->__construct( $id );
	}
}