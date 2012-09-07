<?php

class ProsulumMab{
	
	var $_html_UniqueId = '_mab_html_unique_id';
	private $_defaultActionBoxId = '';
	private $_defaultActionBoxPlacement = 'bottom';
	
	function ProsulumMab(){
		return $this->__construct();
	}
	
	function __construct(){
	//	$this->setUpDefaults();
		$this->add_actions();
		$this->add_filters();
	}
	
	function add_actions(){
		add_action( 'template_redirect', array( &$this, 'registerStyles' ) );
		add_action( 'template_redirect', array( &$this, 'setupContentTypeActionBox' ) );

	}
	
	function add_filters(){
		add_filter( 'mab_optinform_output', array( &$this, 'outputOptInFormHTML' ), 10, 3 );
		//add_filter('the_content', array( &$this, 'showActionBox' ) );
	}
	
	function setUpDefaults(){
		global $MabBase, $wp_query;
		
		$post = $wp_query->get_queried_object();
		
		if( $MabBase->is_allowed_content_type( $post->post_type ) ){
			$context = $this->getContext();
			//$this->_defaultActionBoxId 
			$defaults = $this->getActionBoxDefaultsFromContext( $context );
			$this->_defaultActionBoxId = $defaults['id'];
			$this->_defaultActionBoxPlacement = $defaults['placement'];
		}

	}
	
	function getDefaultActionBoxId(){
		return $this->_defaultActionBoxId;
	}
	
	function getDefaultActionBoxPlacement(){
		return $this->_defaultActionBoxPlacement;
	}
	
	function setupContentTypeActionBox(){
		global $MabBase, $wp_query;
		
		$post = $wp_query->get_queried_object();
		
		//stop if the content type is not supposed to show action box
		if( (!is_object( $post ) || !$MabBase->is_allowed_content_type( $post->post_type ) ) && !( is_home() && $wp_query->post_count == 1) )
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
			
			$this->setUpDefaults();
			
			//TODO: check if page has action box
			//add_action( 'wp_print_styles', array( &$this, 'printStylesScripts' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'printStylesScripts' ) );
			add_filter( "the_content", array( &$this, 'showActionBox'), $mab_priority);
		}
	}
	
	function showActionBox( $content ){
		global $post, $MabBase;
		
		if( !$MabBase->is_allowed_content_type( $post->post_type ) ){
			return $content;
		}
		
		//if( !is_singular() )
		//	return $content;
		
		$defaultActionBoxId = $this->getDefaultActionBoxId();
		$placement = $this->getDefaultActionBoxPlacement();
		
		//get postmeta. NOTE: This is not postmeta from Action Box but
		//from a regular post/CPT where Action Box is to be shown
		$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
		
		//return $content if action box is disabled or placement is set to 'manual'
		/*
		if( !isset( $postmeta['post-action-box'] ) || $postmeta['post-action-box'] === '' || $postmeta['post-action-box-placement'] == 'manual' ){
			return $content;
		}
		*/

		if( $defaultActionBoxId === '' || $placement == 'manual' ){
			return $content;
		}
		
		$actionBox = $this->getActionBox( $defaultActionBoxId );
		//$actionBox = $this->getActionBox( $postmeta['post-action-box'] );
		
		//$content = wptexturize( wpautop( $content ) );
		
		//check placement of action box
		$placement = isset( $placement ) ? $placement : 'bottom';

		if( $placement === 'top' ){
			return $actionBox . "\n" . $content;
		} elseif( $placement === 'bottom' ){
			return $content . "\n" . $actionBox;
		}
		
		//return $content;
	}
	
	/**
	 * Returns current context
	 * @return string 
	 */
	function getContext(){
		if( is_front_page() ){
		//FRONT PAGE
			$context = 'front_page';
		} elseif( is_home() ){
		//BLOG PAGE
			$context = 'blog';
		} elseif ( is_single() ){
		//SINGLE BLOG POST
			$context = 'single';
		} elseif ( is_page() ){
		//SINGLE PAGE
			$context = 'page';
		} elseif( is_category() ){
		//CATEGORY PAGE
			$context = 'category';
		} elseif ( is_tag() ){
		//TAG PAGE
			$context = 'tag';
		} elseif( is_archive() ){
		//ANY DATE-BASED PAGE i.e. category, tags, date
			$context = 'archive';
		} else {
		//DEFAULT
			$context = 'default';
		}
		
		return $context;
	}
	
	/**
	 * @param string $context - single | page | default
	 * @return int|bool Post ID of Action Box or FALSE if actionbox is not specified for a context
	 */
	function getActionBoxDefaultsFromContext( $context = 'default' ){
		global $MabBase;
		
		$settings = $this->getSettings();
		$globalMab = $settings['global-mab'];
		
		$actionBoxId = '';
		
		$default = ( isset( $globalMab['default']['actionbox'] ) && $globalMab['default']['actionbox'] != 'none' ) ? $globalMab['default']['actionbox'] : '';
		
		$defaultPlacement = $placement = isset( $globalMab['default']['placement'] ) ? $globalMab['default']['placement'] : 'bottom';

		switch( $context ){
			case 'single':
				global $post;
				if( !is_object( $post ) ){
					//something's wrong
					$actionBoxId = '';
					break;
				}
				
				/** Single Post Setting **/
				$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
				$singleActionBoxId = isset($postmeta['post-action-box']) ? $postmeta['post-action-box'] : '';
				
				//if $pageActionBoxId is empty string, then action box is not yet set
				if( '' !== $singleActionBoxId && 'default' != $singleActionBoxId ){
					//specific action box set for Post
					$actionBoxId = $singleActionBoxId;
					$placement = isset( $postmeta['post-action-box-placement'] ) ? $postmeta['post-action-box-placement'] : $defaultPlacement;
					
				} else {
					//use global settings
					
					/** Global Single Post Setting **/
					$actionBoxId = isset( $globalMab['post']['actionbox'] ) ? $globalMab['post']['actionbox'] : 'default';
					$placement = isset( $globalMab['post']['placement'] ) ? $globalMab['post']['placement'] : $defaultPlacement;
					
					/** Global Category Setting - will override Global Single Post Setting **/
					$terms = get_the_terms( $post->ID, 'category' );
					if( $terms && !is_wp_error( $terms ) ){
						foreach( $terms as $term ){
							//catch the first category set
							if( isset( $globalMab['category'][$term->term_id]['actionbox'] ) AND $globalMab['category'][$term->term_id]['actionbox'] != 'default' ){
								$actionBoxId = $globalMab['category'][$term->term_id]['actionbox'];
								$placement = $globalMab['category'][$term->term_id]['placement'];
								break; //break out of foreach loop
							}//endif
						}//endforeach
					}//endif
					
				}//endif
				
				break;
			
			case 'page':
				global $post;
				if( !is_object( $post ) ){
					//something's wrong
					$actionBoxId = '';
				}
				
				$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
				$pageActionBoxId = isset($postmeta['post-action-box']) ? $postmeta['post-action-box'] : '';
				
				//if $pageActionBoxId is empty string, then action box is not yet set
				if( '' !== $pageActionBoxId && 'default' != $pageActionBoxId ){
					//specific action box set for Page
					$actionBoxId = $pageActionBoxId;
					$placement = isset( $postmeta['post-action-box-placement'] ) ? $postmeta['post-action-box-placement'] : $defaultPlacement;
					
				} else {
					//use global setting
					$actionBoxId = isset( $globalMab['page']['actionbox'] ) ? $globalMab['page']['actionbox'] : 'default';
					$placement = isset( $globalMab['page']['placement'] ) ? $globalMab['page']['placement'] : $defaultPlacement;
					
				}
				
				break;
			case 'front_page':
				global $wp_query;
				
				//make sure that the front page is set to display a static page
				if( !is_page() ){
					break;
				}
				
				$post = $wp_query->get_queried_object();
				if( !is_object( $post ) ){
					//something's wrong
					$actionBoxId = '';
				}
				
				$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
				$pageActionBoxId = isset($postmeta['post-action-box']) ? $postmeta['post-action-box'] : '';
				
				//if $pageActionBoxId is empty string, then action box is not yet set
				if( '' !== $pageActionBoxId && 'default' != $pageActionBoxId ){
					//specific action box set for Page
					$actionBoxId = $pageActionBoxId;
					$placement = isset( $postmeta['post-action-box-placement'] ) ? $postmeta['post-action-box-placement'] : $defaultPlacement;
					
				} else {
					//use global setting
					$actionBoxId = isset( $globalMab['page']['actionbox'] ) ? $globalMab['page']['actionbox'] : 'default';
					$placement = isset( $globalMab['page']['placement'] ) ? $globalMab['page']['placement'] : $defaultPlacement;
					
				}
				
				break;
			case 'tag':
			case 'archive':
			case 'blog':
			case 'category':
			default: 
				$actionBoxId = '';
				break;
		}//endswitch
		
		if( $actionBoxId == 'default' ){
			$actionBoxId = $default;
		} elseif( $actionBoxId == 'none' ){
			$actionBoxId = '';
		}
		
		return array( 'id' => $actionBoxId, 'placement' => $placement );
		//return $actionBoxId;
	}
	
	function getActionBoxStyle( $actionBoxId ){
		global $MabBase;
		return $MabBase->get_selected_style( $actionBoxId );
	}
	
	/**
	 * @param int $postId ID of post where Action Box is enabled
	 * @return int|string ID of action box used OR "default" OR "none" OR empty string if not yet set
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
			//error_log( serialize( $actionBox ) );
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
		
		//get unique action box id because some optin form providers need this i.e. wysija
		$data['mab-html-id'] = $this->getUniqueId( $actionBoxObj->ID );
		$meta['mab-html-id'] = $data['mab-html-id'];
		
		//get Opt In Form
		$optInForm = $this->getOptInForm( $meta );
		
		//if form is empty, then there should be no need to show the action box
		if( empty( $optInForm ) ){
			return '';
		}
		
		//$data['meta'] = $meta;
		//convert old optin settings keys to keys used by other action boxes
		$data['meta'] = $this->convertOptinKeys( $meta );
		
		$data['form'] = $optInForm;
		
		$data['action-box-type'] = $MabBase->get_mab_meta( $actionBoxObj->ID, 'type' );
		
		$mainTemplate = $this->getActionBoxTemplateLocation('optin');
		$actionBox = ProsulumMabCommon::getView( $mainTemplate, $data );
		return $actionBox;
	}
	
	function convertOptinKeys( $settings ){
		global $MabBase;
		$settingsChanged = false;
		$new = array();
		$meta = $settings;

		if( !empty( $meta['optin-image-url'] ) && empty( $meta['aside-image-url'] ) ){
			$settingsChanged = true;
			$meta['aside-image-url'] = $meta['optin-image-url'];
		}
		if( !empty( $meta['optin-image-width'] ) && empty( $meta['aside-image-width'] ) ){
			$settingsChanged = true;
			$meta['aside-image-width'] = $meta['optin-image-width'];
		}
		if( !empty( $meta['optin-image-height'] ) && empty( $meta['aside-image-height'] ) ){
			$settingsChanged = true;
			$meta['aside-image-height'] = $meta['optin-image-height'];
		}
		if( !empty( $meta['optin-image-placement'] ) && empty( $meta['aside-image-placement'] ) ){
			$settingsChanged = true;
			$meta['aside-image-placement'] = $meta['optin-image-placement'];
		}
		if( !empty( $meta['optin-heading'] ) && empty( $meta['main-heading'] ) ){
			$settingsChanged = true;
			$meta['main-heading'] = $meta['optin-heading'];
		}
		if( !empty( $meta['optin-subheading'] ) && empty( $meta['subheading'] ) ){
			$settingsChanged = true;
			$meta['subheading'] = $meta['optin-subheading'];
		}
		if( !empty( $meta['optin-main-copy'] ) && empty( $meta['main-copy'] ) ){
			$settingsChanged = true;
			$meta['main-copy'] = $meta['optin-main-copy'];
		}
		
		if( $settingsChanged ){
			//save the new settings and return new settings
			$new = $meta;
			unset( $new['ID'] );
			$MabBase->update_mab_meta( $meta['ID'], $new );
			$new['ID'] = $meta['ID'];
			return $new;
		}
		
		return $meta;
	}
	
	/**
	 * @applies WP filter mab_optinform_output
	 * how to add your own filters example: add_filter( 'mab_optinform_output', 'function_name', 10, 3 );
	 *
	 * @param array $meta action box post type meta data
	 * @return html
	 */
	function getOptInForm( $meta ){
		return apply_filters('mab_optinform_output', '', $meta['optin-provider'], $meta );
	}
	
	/**
	 * Filter function to mab_optinform_output filter
	 */
	function outputOptInFormHTML( $optIn, $provider, $meta ){
		global $MabBase;
		
		$viewDir = 'optinforms/';
		$optIn = '';
		
		//get provider
		switch( $meta['optin-provider'] ){
			case 'aweber':
				$settings = $this->getSettings();
				//break if aweber is not allowed
				if( $settings['optin']['allowed']['aweber'] == 0 )
					break;
				
				$filename = $viewDir . 'aweber.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			case 'mailchimp':
				$settings = $this->getSettings();
				//break if mailchimp is not allowed
				if( $settings['optin']['allowed']['mailchimp'] == 0 )
					break;
				
				//$meta['mc-account'] = $settings['optin']['mailchimp-account-info'];
				$filename = $viewDir . 'mailchimp.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'constant-contact':
				$settings = $this->getSettings();
				//break if constant contact is not allowed
				if( $settings['optin']['allowed']['constant-contact'] == 0 )
					break;
				
				$filename = $viewDir . 'constant-contact.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'manual':
				$settings = $this->getSettings();
				//break if manual is not allowed
				if( $settings['optin']['allowed']['manual'] == 0 )
					break;
				
				$filename = $viewDir . 'manual.php';
				$optIn = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			case 'wysija':
				//make sure Wysija plugin is activated
				if( !class_exists( 'WYSIJA' ) ) break;
				
				$wysijaView =& WYSIJA::get("widget_nl","view","front");
				
				/** Print wysija scripts **/
				$wysijaView->addScripts();
				
				/** TODO: generate fields using wysija's field generator **/
				
				$meta['subscriber-nonce'] = $wysijaView->secure(array('action' => 'save', 'controller' => 'subscribers'),false,false);
				
				$filename = $viewDir . 'wysija.php';
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
		$ext = '.php';
		
		$boxes = ProsulumMabCommon::getActionBox();
		
		if( isset( $boxes[$type] ) && isset( $boxes[$type]['template'] ) ){
			$filename = $viewDir . 'actionbox-' . $boxes[$type]['template'] . $ext;
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
		global $post, $MabBase; //this is the current content type object where action boxes are used.
		
		$actionBoxId = $this->getDefaultActionBoxId();
		
		//$actionBoxId = $this->getIdOfActionBoxUsed( $post->ID );
		
		$this->printActionBoxAssets( $actionBoxId );
		
	}
	
	function printActionBoxAssets( $actionBoxId = null ){
		global $post, $MabBase; //this is the current content type object where action boxes are used.
		
		if( null === $actionBoxId ){
			$actionBoxId = $this->getIdOfActionBoxUsed( $post->ID );
		}
		
		//stop if there is no action box
		if( empty( $actionBoxId ) && $actionBoxId !== 0 ){
			return;
		}

		if( empty( $actionBoxId ) )
			return;
		
		//check which style should be used. i.e. 'default', 'user'...
		$style = $this->getActionBoxStyle( $actionBoxId );
		
		$actionBoxMeta = $MabBase->get_mab_meta( $actionBoxId );
		
		switch( $style ){
			case 'user':
				//get user style key
				$userStyleKey = $actionBoxMeta['userstyle'];
				
				//use style set by user
				$mabStylesheet = mab_get_settings_stylesheet_path( $userStyleKey );
				
				//create stylesheet file if its not created yet
				if( !file_exists( $mabStylesheet ) || trim( mab_get_settings_stylesheet_contents( $userStyleKey ) ) == '' ){
					mab_create_stylesheet( $userStyleKey );
				}
				
				if( file_exists( $mabStylesheet ) ){
					//actionbox specific stylesheet
					wp_enqueue_style( 'mab-user-style-'.$userStyleKey, mab_get_settings_stylesheet_url($userStyleKey), array( 'mab-base-style' ), filemtime( $mabStylesheet ) );
				}
				break; 
				// ===================
			
			case 'none':
				break;
				
			default:
				/** LOAD PRECONFIGURED STYLESHEET **/
				//$other_style_location = MAB_ASSETS_URL . 'css/style-';
				
				//use one of the preconfigured styles
				//$preconfigured_style = $other_style_location . $style . '.css';
				$preconfigured_style = MAB_STYLES_URL . "{$style}/style.css";
				
				//if( file_exists( $preconfigured_style  ) ){ this is a url.. tsk.
					wp_enqueue_style( "mab-preconfigured-style-{$style}", $preconfigured_style , array('mab-base-style'), "1.0" );
				//} else {
					//wp_enqueue_style( "mab-style-default", MAB_ASSETS_URL . 'css/style-default.css', array(), "1.0" );
				//}
				
				//wp_redirect( "{$preconfigured_style}" );
				

				break;
				// ==========================
		}//switch
		
		/** LOAD CUSTOM CSS **/
		//get stylesheet which should contain only CSS in Custom CSS box under Design Setting: Custom CSS
		$custom_css_stylesheet = mab_get_actionbox_stylesheet_path( $actionBoxId );
		
		//create stylesheet file if its not created yet
		if( !file_exists( $custom_css_stylesheet ) || trim( mab_get_actionbox_stylesheet_contents( $actionBoxId ) ) == '' ){
			mab_create_actionbox_stylesheet( $actionBoxId );
		}
		
		if( file_exists( $custom_css_stylesheet ) ){
			//actionbox specific stylesheet
			wp_enqueue_style( "mab-actionbox-style-{$actionBoxId}", mab_get_actionbox_stylesheet_url($actionBoxId), array( ), filemtime( $custom_css_stylesheet ) );
		}
		
		/** LOAD BUTTONS CSS **/
		/* create custom buttons stylesheet if its not there */
		if( !file_exists( mab_get_custom_buttons_stylesheet_path() ) ){
			global $MabButton;
			$MabButton->writeConfiguredButtonsStylesheet( $MabButton->getConfiguredButtons(), '' );
		}
		//load buttons stylesheet
		wp_enqueue_style( 'mab-custom-buttons-css', mab_get_custom_buttons_stylesheet_url() );
		
	}
	
	function getSettings(){
		global $MabBase;
		return $MabBase->get_settings();
	}
	
}
