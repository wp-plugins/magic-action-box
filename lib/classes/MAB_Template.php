<?php

class MAB_Template{
	private $_actionbox_obj = null;
	private $_template_dir = '';
	private $_template_url = '';
	private $_template_file = '';
	private $_template_style_dir = '';
	private $_template_style_url = '';
	private $_is_default = true;
	
	private static $_current_template_dir = '';
	private static $_current_template_url = '';
	private static $_current_template_file = '';
	private static $_current_template_style_dir = '';
	private static $_current_template_style_url = '';
	private static $_current_actionbox_obj = null;
	
	public function getTemplate(){
		$actionBoxObj = $this->_actionbox_obj;
		
		self::setCurrentTemplateVars( $actionBoxObj );
		
		$type = $actionBoxObj->getActionBoxType();
		$template = apply_filters('mab_get_template', '', $type, $actionBoxObj );
		$output = apply_filters('mab_get_template-' . $type, $template, $actionBoxObj );
		
		self::resetCurrentTemplateVars();
		
		return apply_filters('mab_template_output', $output, $actionBoxObj);
	}

	/**
	 * Load Assets
	 */
	function loadAssets(){
		$actionBoxObj = $this->_actionbox_obj;
		
		if( !$actionBoxObj->isConfigured() ) return;
		
		$actionBoxId = $actionBoxObj->getId();
		$meta = $actionBoxObj->getMeta();
		$style = $actionBoxObj->getstyleKey();
		
		if( $style === '' ) return;
		
		switch( $style ){
			case 'user':
				//get user style key
				$userStyleKey = $meta['userstyle'];
				
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
				
				/* TODO: be able to load type specific stylesheets style-{TYPE}.css */
				
				//use one of the preconfigured styles
				//$preconfigured_style = $other_style_location . $style . '.css';
				$preconfigured_style = $this->getTemplateStyleUrl() . "style.css";
				
				//if( file_exists( $preconfigured_style  ) ){ this is a url.. tsk.
					wp_enqueue_style( "mab-preconfigured-style-{$style}", $preconfigured_style , array('mab-base-style'), MAB_VERSION );
				//} else {
					//wp_enqueue_style( "mab-style-default", MAB_ASSETS_URL . 'css/style-default.css', array(), "1.0" );
				//}
				
				//wp_redirect( "{$preconfigured_style}" );
				

				break;
				// ==========================
		}//endswitch
		
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
		
		/** LOAD MISC **/
	}
	
	/**
	 * Get Class Array
	 * @return array classes in array
	 */
	function getClassArray($class=''){
		$actionBoxObj = $this->_actionbox_obj;

		$classes = array();
		
		$classes[] = 'magic-action-box';

		//action box type
		$classes[] = 'mab-type-' . $actionBoxObj->getActionBoxType();
		
		//action box id
		$classes[] = 'mab-id-'.$actionBoxObj->getId();

		$meta = $actionBoxObj->getMeta();
		
		//$meta['style'] will either be 'user' or 'id' of pre-designed style
		$selectedStyle = isset($meta['style']) ? 'mabstyle-'.$meta['style'] : '';//'mab-default';
		$classes[] = $selectedStyle;
		
		//custom user style/design
		if( $selectedStyle == 'mabstyle-user' ){
			$classes[] = 'userstyle-' . $meta['userstyle'];
		}
		
		//fields layout
		if( isset( $meta['optin']['fields-layout'] ) ){
			$classes[] = 'mab-fields-layout-' . $meta['optin']['fields-layout'];
		}
		
		//TODO: aside placement class

		/* from WP's implementation of get_body_class() */
		if ( ! empty( $class ) ) {
			if ( !is_array( $class ) )
				$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}
		
		$classes = array_map( 'esc_attr', $classes );
	
		return apply_filters( 'actionbox_class', $classes, $class );
	}
	
	function getClass( $class = '' ){
		// Separates classes with a single space, collates classes for .magic-action-box
		return 'class="' . implode( ' ', $this->getClassArray( $class ) ) . '"';
	}
	
	function getTemplateFile(){
		return $this->_template_file;
	}
	
	function getTemplateDir(){
		return $this->_template_dir;
	}
	
	function getTemplateUrl(){
		return $this->_template_url;
	}
	
	function getTemplateStyleDir(){
		return $this->_template_style_dir;
	}
	
	function getTemplateStyleUrl(){
		return $this->_template_style_url;
	}
	
	/**
	 * Get Default Action Box Template File
	 * @return string absolute path to template file
	 */
	function getDefaultTemplateFile( $type = '' ){
		$filename = '';
		$viewDir = $this->getDefaultTemplateDir();
		$ext = '.php';
		$actionBoxObj = $this->_actionbox_obj;
		
		$boxes = ProsulumMabCommon::getActionBoxTypes();
		
		if( isset( $boxes[$type] ) ){
			$filename = $viewDir . 'actionbox-' . $type . $ext;
		}
		
		return $filename;
	}

	function getPreDesignedTemplateDir(){
		return MAB_STYLES_DIR;
	}
	
	function getPreDesignedTemplateUrl(){
		return MAB_STYLES_URL;
	}
	
	function getDefaultTemplateDir(){
		return MAB_VIEWS_DIR . 'action-box/';
	}
	
	function getDefaultTemplateUrl(){
		return MAB_VIEWS_URL . 'action-box/';
	}
	
	/**
	 * Sets template paths for the object
	 */
	function setTemplatePaths(){
		$actionBoxObj = $this->_actionbox_obj;
		
		$styleKey = $actionBoxObj->getStyleKey();
		$type = $actionBoxObj->getActionBoxType();

		if( $styleKey == 'user' || $styleKey == 'none' ){
			//default template paths
			$this->_template_dir = $this->getDefaultTemplateDir();
			$this->_template_url = $this->getDefaultTemplateUrl();
			$this->_template_file = $this->getDefaultTemplateFile( $type );
		} else {
			//predesigned template paths
			
			$tempDir = $this->getPreDesignedTemplateDir() . "{$styleKey}/";
			$tempFile = $tempDir . "actionbox-{$type}.php";
			
			if( file_exists( $tempFile ) ){
				//template file exists within the predesigned template directory
				$this->_template_dir = $tempDir;
				$this->_template_url = $this->getPreDesignedTemplateUrl() . "{$styleKey}/";
				$this->_template_file = $tempFile;
				
				$this->_is_default = false;
			} else {
				//fallback to default templates
				$this->_template_dir = $this->getDefaultTemplateDir();
				$this->_template_url = $this->getDefaultTemplateUrl();
				$this->_template_file = $this->getDefaultTemplateFile( $type );
			}
			
			//path to styles and path to templates MAY be different
			$this->_template_style_dir = $tempDir;
			$this->_template_style_url = $this->getPreDesignedTemplateUrl() . "{$styleKey}/";
		}
	}
	
	static function setCurrentTemplateVars($actionBoxObj){
		$templateObj = $actionBoxObj->getTemplateObj();
		self::$_current_template_dir = $templateObj->getTemplateDir();
		self::$_current_template_url = $templateObj->getTemplateUrl();
		self::$_current_template_file = $templateObj->getTemplateFile();
		self::$_current_actionbox_obj = $actionBoxObj;
		self::$_current_template_style_dir = $templateObj->getTemplateStyleDir();
		self::$_current_template_style_url = $templateObj->getTemplateStyleUrl();
	}
	
	static function resetCurrentTemplateVars(){
		self::$_current_template_dir = '';
		self::$_current_template_url = '';
		self::$_current_template_file = '';
		self::$_current_actionbox_obj = null;
		self::$_current_template_style_dir = '';
		self::$_current_template_style_url = '';
	}
	
	static function getCurrentTemplateDir(){
		return self::$_current_template_dir;
	}
	
	static function getCurrentTemplateUrl(){
		return self::$_current_template_url;
	}
	
	static function getCurrentTemplateFile(){
		return self::$_current_template_file;
	}

	static function getCurrentTemplateStyleUrl(){
		return self::$_current_template_style_url;
	}
	
	static function getCurrentTemplateStyleDir(){
		return self::$_current_template_style_dir;
	}
	
	static function getCurrentActionBoxObj(){
		return self::$_current_actionbox_obj;
	}
	
	/**
	 * Use to check if we are using default template or not
	 * Non-default templates are templates found in predesigned style directory
	 */
	function isDefault(){
		if( !$this->_is_default )
			return false;
		else
			return true;
	}
	
	function init($actionBoxObj){
		$this->_actionbox_obj = $actionBoxObj;
		//set up template paths
		$this->setTemplatePaths();
	}
	
	function __construct( $actionBoxObj = null ){
		$this->init( $actionBoxObj );
	}
	
	function MAB_Template( $actionBoxObj = null ){
		$this->__construct($actionBoxObj);
	}


	/**
	 * Get the default templates that came with the system
	 */
	static function loadDefaultTemplate(){
		$actionBoxObj = $this->_actionbox_obj;
		$type = $actionBox->getActionBoxType();
		switch( $type ){
			case 'optin':
				$actionBox = self::getActionBoxOptin( $actionBoxObj );
				break;
			case 'sales-box':
				$actionBox = self::getActionBoxSalesBox( $actionBoxObj );
				break;
			case 'share-box':
				$actionBox = self::getActionBoxShareBox( $actionBoxObj );
				break;
			default:
				return ''; //empty string
				break;
		}
		return $actionBox;
	}
	
	/**
	 * SHARE BOX
	 * @param object $actionBoxObj - MAB_ActionBox object
	 * @return string HTML
	 */
	public static function getActionBoxShareBox( $actionBoxObj ){
		global $MabBase;
		$data = array();
		
		$meta = $actionBoxObj->getMeta();
		$meta['ID'] = $actionBoxObj->getId();
		
		//get Share Box
		$shareBox = self::getShareBox( $meta );

		//get Opt In Form
		$optInForm = self::getOptInForm( $actionBoxObj );
		
		$data['meta'] = $meta;
		$data['sharebox'] = $shareBox;
		$data['form'] = $optInForm;

		$data['action-box-type'] = $actionBoxObj->getActionBoxType();
		$data['mab-html-id'] = $actionBoxObj->getHtmlId();
		
		$data['class'] = $actionBoxObj->getTemplateObj()->getClass();
		
		$mainTemplate = $actionBoxObj->getTemplateObj()->getTemplateFile();
		$actionBox = ProsulumMabCommon::getView( $mainTemplate, $data, '' );
		return $actionBox;
	}
	
	public static function getShareBox( $meta ){
		$viewDir = 'sharebox/';
		$ext = '.php';
		$shareBoxType = isset( $meta['sharebox']['type'] ) ? $meta['sharebox']['type'] : 'large';
		$shareBox = '';
		$data = array();
		
		$data['twitter']['share-text'] = isset( $meta['sharebox']['twitter']['share-text'] ) ? $meta['sharebox']['twitter']['share-text'] : 'Check out this post';
		$data['twitter']['via'] = isset( $meta['sharebox']['twitter']['via'] ) ? $meta['sharebox']['twitter']['via'] : '';
		
		$fileName = $viewDir . $shareBoxType . $ext;
		$shareBox = ProsulumMabCommon::getView( $fileName, $data );
		return $shareBox;
	}
	
	/**
	 * SALES BOX
	 * @param object $actionBoxObj - MAB_ActionBox object
	 * @return string HTML
	 */
	public static function getActionBoxSalesBox( $actionBoxObj ){
		global $MabBase;
		
		$data = array();
		
		$meta = $actionBoxObj->getMeta();
		$meta['ID'] = $actionBoxObj->getId();
		
		$data['meta'] = $meta;
		$data['action-box-type'] = $actionBoxObj->getActionBoxType();
		$data['mab-html-id'] = $actionBoxObj->getHtmlId();
		$data['class'] = $actionBoxObj->getTemplateObj()->getClass();
		
		$mainTemplate = $actionBoxObj->getTemplateObj()->getTemplateFile();
		$actionBox = ProsulumMabCommon::getView( $mainTemplate, $data, '' );

		return $actionBox;
	}

	/**
	 * OPTIN FORM
	 *
	 * @param object $actionBoxObj - MAB_ActionBox object
	 * @return string HTML
	 */
	public static function getActionBoxOptin( $actionBoxObj ){
		global $MabBase;

		$meta = $actionBoxObj->getMeta();
		$meta['ID'] = $actionBoxObj->getId();
		
		//get unique action box id because some optin form providers need this i.e. wysija
		$data['mab-html-id'] = $actionBoxObj->getHtmlId();
		$meta['mab-html-id'] = $data['mab-html-id'];
		
		//get Opt In Form
		$optInForm = self::getOptInForm( $actionBoxObj );
		
		//if form is empty, then there should be no need to show the action box
		if( empty( $optInForm ) ){
			return '';
		}
		
		//$data['meta'] = $meta;
		//convert old optin settings keys to keys used by other action boxes
		$data['meta'] = self::convertOptinKeys( $meta );
		
		$data['form'] = $optInForm;
		
		$data['action-box-type'] = $actionBoxObj->getActionBoxType();
		
		$data['class'] = $actionBoxObj->getTemplateObj()->getClass();
		
		$mainTemplate = $actionBoxObj->getTemplateObj()->getTemplateFile();
		
		$actionBox = ProsulumMabCommon::getView( $mainTemplate, $data, '' );
		return $actionBox;
	}

	
	/**
	 * @applies WP filter mab_optinform_output
	 * how to add your own filters example: add_filter( 'mab_optinform_output', 'public static function_name', 10, 3 );
	 *
	 * @param array $meta action box post type meta data
	 * @return html
	 */
	public static function getOptInForm( $actionBoxObj = null ){
		global $MabBase;
		
		if( empty( $actionBoxObj ) || !$actionBoxObj->isConfigured() ) return '';
		
		$meta = $actionBoxObj->getMeta();
		
		$viewDir = 'optinforms/';
		$form = '';
		
		//get provider
		switch( $meta['optin-provider'] ){
			case 'aweber':
				$settings = $MabBase->get_settings();
				//break if aweber is not allowed
				if( $settings['optin']['allowed']['aweber'] == 0 )
					break;
				
				$filename = $viewDir . 'aweber.php';
				$form = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			case 'mailchimp':
				$settings = $MabBase->get_settings();
				//break if mailchimp is not allowed
				if( $settings['optin']['allowed']['mailchimp'] == 0 )
					break;
				
				//$meta['mc-account'] = $settings['optin']['mailchimp-account-info'];
				$filename = $viewDir . 'mailchimp.php';
				$form = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'constant-contact':
				$settings = $MabBase->get_settings();
				//break if constant contact is not allowed
				if( $settings['optin']['allowed']['constant-contact'] == 0 )
					break;
				
				$filename = $viewDir . 'constant-contact.php';
				$form = ProsulumMabCommon::getView( $filename, $meta );
				break;
				
			case 'manual':
				$settings = $MabBase->get_settings();
				//break if manual is not allowed
				if( $settings['optin']['allowed']['manual'] == 0 )
					break;
				
				$filename = $viewDir . 'manual.php';
				$form = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			case 'wysija':
				//make sure Wysija plugin is activated
				if( !class_exists( 'WYSIJA' ) ) break;
				
				$wysijaView =& WYSIJA::get("widget_nl","view","front");
				
				/** Print wysija scripts **/
				$wysijaView->addScripts();
				
				/** TODO: generate fields using wysija's field generator **/
				
				$meta['subscriber-nonce'] = $wysijaView->secure(array('action' => 'save', 'controller' => 'subscribers'),false,false);
				$meta['mab-html-id'] = $actionBoxObj->getHtmlId();
				
				$filename = $viewDir . 'wysija.php';
				$form = ProsulumMabCommon::getView( $filename, $meta );
				
				break;
				
			default:
				break;
		}
		
		return apply_filters('mab_optin_form_output', $form, $meta['optin-provider'], $actionBoxObj );
	}
	
	/**
	 * to be deprecated @2.8.7
	 */
	public static function convertOptinKeys( $settings ){
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
}
