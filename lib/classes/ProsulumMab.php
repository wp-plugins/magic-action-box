<?php

class ProsulumMab{
	
	var $_html_UniqueId = '_mab_html_unique_id';
	
	function ProsulumMab(){
		return $this->__construct();
	}
	
	function __construct(){
		$this->add_actions();
		$this->add_filters();
	}
	
	function add_actions(){
		
		add_action( 'template_redirect', array( &$this, 'registerStyles' ) );
		add_action( 'template_redirect', array( &$this, 'setupContentTypeActionBox' ) );

	}
	
	function add_filters(){
		//add_filter('the_content', array( &$this, 'showActionBox' ) );
	}
	
	function setupContentTypeActionBox(){
		global $post, $MabBase, $wp_query;
		
		//stop if the content type is not supposed to show action box
		if( !$MabBase->is_allowed_content_type( $post->post_type ) )
			return;
		
		//Show Action box only on singular pages or when it is on blog index but set only to show
		//one blog post.
		if( is_singular() || ( is_home() && $wp_query->post_count == 1 ) ){
			
			$mab_priority = 10; //default 10.
			
			//TODO: have option to disable removal of filter
			// Disable WordPress native formatters
			$settings = $MabBase->get_settings();
			
			if( !empty( $settings['others']['reorder-content-filters'] ) ){
				remove_filter( 'the_content', 'wpautop' );
				remove_filter( 'the_content', 'wptexturize' );
				add_filter('the_content', 'wpautop', 8 );
				add_filter('the_content', 'wpautop', 8 );
				$mab_priority = 9;
			}

			//TODO: check if page has action box
			//add_action( 'wp_print_styles', array( &$this, 'printStylesScripts' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'printStylesScripts' ) );
			add_filter( "the_content", array( &$this, 'showActionBox'), $mab_priority);
		}
	}
	
	function showActionBox( $content ){
		global $post, $MabBase;
		
		//if( !is_singular() )
		//	return $content;
		
		//get postmeta. NOTE: This is not postmeta from Action Box but
		//from a regular post/CPT where Action Box is to be shown
		$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
		
		//return $content if action box is disabled or placement is set to 'manual'
		if( !isset( $postmeta['post-action-box'] ) || $postmeta['post-action-box'] === '' || $postmeta['post-action-box-placement'] == 'manual' ){
			return $content;
		}
		
		$actionBox = $this->getActionBox( $postmeta['post-action-box'] );
		
		//$content = wptexturize( wpautop( $content ) );
		
		//check placement of action box
		$placement = $postmeta['post-action-box-placement'];
		
		if( $placement === 'top' ){
			return $actionBox . "\n" . $content;
		} elseif( $placement === 'bottom' ){
			return $content . "\n" . $actionBox;
		}
		
		//return $content;
	}
	
	function getActionBoxStyle( $actionBoxId ){
		global $MabBase;
		return $MabBase->get_selected_style( $actionBoxId );
	}
	
	/**
	 * @param int $postId ID of post where Action Box is enabled
	 */
	function getIdOfActionBoxUsed( $postId = '' ){
		global $post, $MabBase;
		if( $postId == '' ){
			$postId = $post->ID;
		}
		$postmeta = $MabBase->get_mab_meta( $postId, 'post' );
		return isset($postmeta['post-action-box']) ? $postmeta['post-action-box'] : '';
	}
	
	/**
	 * @return string - Action Box HTML on success, Empty string otherwise.
	 */
	function getActionBox( $actionBoxId = '' ){
		
		//check if the specified action box exists
		$actionBoxPost = get_post( $actionBoxId );
		if( !empty( $actionBoxPost ) && !empty( $actionBoxId ) ){
		
			global $MabBase;
			
			//$meta = $MabBase->get_mab_meta( $actionBoxId );
			
			//Determine actionbox type. Then load the appropriate Action Box meta
			$type = get_post_meta( $actionBoxId, $MabBase->get_meta_key('type'), true );
			
			switch( $type ){
				case 'optin':
					$actionBox = $this->getActionBoxOptin( $actionBoxPost );
					break;
				default:
					return ''; //empty string
					break;
			}
			
			return $actionBox;
			
		} else {
			return '';
		}
		
		return ''; //just a safety net
		
	}
	
	/**
	 * ACTION BOXES
	 * =======================* /

	/**
	 * OPTIN FORM
	 *
	 * @param object $actionBoxObj - actually a $post object
	 * @return string HTML
	 */
	function getActionBoxOptin( $actionBoxObj ){
		global $MabBase;
		
		$meta = $MabBase->get_mab_meta( $actionBoxObj->ID );
		$meta['ID'] = $actionBoxObj->ID;
		
		//get Opt In Form
		$optInForm = $this->getOptInForm( $meta );
		
		$data['meta'] = $meta;
		$data['form'] = $optInForm;
		$data['action-box-type'] = $MabBase->get_mab_meta( $actionBoxObj->ID, 'type' );
		
		$data['mab-html-id'] = $this->getUniqueId( $actionBoxObj->ID );
		
		$mainTemplate = $this->getActionBoxTemplateLocation('optin');
		$actionBox = ProsulumMabCommon::getView( $mainTemplate, $data );
		return $actionBox;
	}
	
	/**
	 * @return string HTML on success, EMPTY string otherwise
	 */
	function getOptInForm( $meta ){
		global $MabBase;
		
		$viewDir = 'optinforms/';
		$settings = ProsulumMabCommon::getSettings();
		$optIn = '';
		
		//get provider
		switch( $meta['optin-provider'] ){
			case 'aweber':
				//break if aweber is not allowed
				if( $settings['optin']['allowed']['aweber'] == 0 )
					break;
				
				$filename = $viewDir . 'aweber.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			case 'mailchimp':
				//break if mailchimp is not allowed
				if( $settings['optin']['allowed']['mailchimp'] == 0 )
					break;
				
				//$meta['mc-account'] = $settings['optin']['mailchimp-account-info'];
				$filename = $viewDir . 'mailchimp.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'constant-contact':
				//break if constant contact is not allowed
				if( $settings['optin']['allowed']['constant-contact'] == 0 )
					break;
				
				$filename = $viewDir . 'constant-contact.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'manual':
				//break if manual is not allowed
				if( $settings['optin']['allowed']['manual'] == 0 )
					break;
				
				$filename = $viewDir . 'manual.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			default:
				break;
		}
		
		return $optIn;
	}
	
	/**
	 * Get Action Box Template
	 */
	function getActionBoxTemplateLocation( $type = '' ){
		$filename = '';
		$viewDir = 'action-box/';
		switch( $type ){
			case 'optin':
				$filename = $viewDir . 'actionbox-optin.php';
				break;
			case 'sales-box':
				$filename = $viewDir . 'actionbox-sales-box.php';
				break;
			default:
				//$filename = $viewDir . 'actionbox-optin.php';
				break;
		}
		
		return $filename;
	}

	/**
	 * Get Unique ID for each action box
	 */
	function getUniqueId( $actionBoxId ){
		//this to have unique ID attribute of the main containing div in case there is more 
		//than 1 of the same action box. Cache key is composed of $_htmlUniqueId prefix and 
		//ID of the action box.
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
	 * ASSETS, CSS, JAVASCRIPT
	 * ============================= */
	function registerStyles(){
		wp_register_style( 'mab-base-style', MAB_ASSETS_URL . 'css/magic-action-box-styles.css', array(), "1.0" );
	}
	
	function printStylesScripts(){
		global $post; //this is the current content type object where action boxes are used.
		
		$actionBoxId = $this->getIdOfActionBoxUsed( $post->ID );
		
		if( empty( $actionBoxId ) )
			return;
		
		//check which style should be used. i.e. 'default', 'user'...
		$style = $this->getActionBoxStyle( $actionBoxId );

		//TODO: later on $key will be taken from settings and not from post id
		$key = $actionBoxId;
		
		switch( $style ){
			case 'user':
				//use style set by user
				$mab_stylesheet = mab_get_settings_stylesheet_path( $key );
				
				//create stylesheet file if its not created yet
				if( !file_exists( $mab_stylesheet ) || trim( mab_get_settings_stylesheet_contents( $key ) ) == '' ){
					mab_create_stylesheet( $key );
				}
				
				if( file_exists( $mab_stylesheet ) ){
					//actionbox specific stylesheet
					wp_enqueue_style( 'mab-user-style', mab_get_settings_stylesheet_url($key), array( 'mab-base-style' ), filemtime( $mab_stylesheet ) );
				}
				break; 
				// ===================
			
			case 'none':
				//get stylesheet which should contain only CSS in Custom CSS box under Design Setting: Others
				$mab_stylesheet = mab_get_settings_stylesheet_path( $key );
				
				//create stylesheet file if its not created yet
				if( !file_exists( $mab_stylesheet ) || trim( mab_get_settings_stylesheet_contents( $key ) ) == '' ){
					mab_create_stylesheet( $key, 'custom' );
				}
				
				if( file_exists( $mab_stylesheet ) ){
					//actionbox specific stylesheet
					wp_enqueue_style( 'mab-user-style', mab_get_settings_stylesheet_url($key), array( ), filemtime( $mab_stylesheet ) );
				}
				break;
				
			default:
				/** LOAD PRECONFIGURED STYLESHEET **/
				//$other_style_location = MAB_ASSETS_URL . 'css/style-';
				
				//use one of the preconfigured styles
				//$preconfigured_style = $other_style_location . $style . '.css';
				$preconfigured_style = MAB_STYLES_URL . "{$style}/style.css";
				
				//if( file_exists( $preconfigured_style  ) ){ this is a url.. tsk.
					wp_enqueue_style( "mab-style-{$style}", $preconfigured_style , array('mab-base-style'), "1.0" );
				//} else {
					//wp_enqueue_style( "mab-style-default", MAB_ASSETS_URL . 'css/style-default.css', array(), "1.0" );
				//}
				
				//wp_redirect( "{$preconfigured_style}" );
				
				/** LOAD CUSTOM CSS **/
				//get stylesheet which should contain only CSS in Custom CSS box under Design Setting: Others
				$mab_stylesheet = mab_get_settings_stylesheet_path( $key );
				
				//create stylesheet file if its not created yet
				if( !file_exists( $mab_stylesheet ) || trim( mab_get_settings_stylesheet_contents( $key ) ) == '' ){
					mab_create_stylesheet( $key, 'custom' );
				}
				
				if( file_exists( $mab_stylesheet ) ){
					//actionbox specific stylesheet
					wp_enqueue_style( 'mab-user-style', mab_get_settings_stylesheet_url($key), array( ), filemtime( $mab_stylesheet ) );
				}
				break;
				// ==========================
		}//switch
		
		/* create custom buttons stylesheet if its not there */
		if( !file_exists( mab_get_custom_buttons_stylesheet_path() ) ){
			global $MabButton;
			$MabButton->writeConfiguredButtonsStylesheet( $MabButton->getConfiguredButtons(), '' );
		}
		//load buttons stylesheet
		wp_enqueue_style( 'mab-custom-buttons-css', mab_get_custom_buttons_stylesheet_url() );
		
	}
	
}
