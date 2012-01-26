<?php
/**
 * Meta boxes for the Action Box post type
 **/
class ProsulumMabMetaBoxes{
	
	function ProsulumMabMetaBoxes( $post ){
		return $this->__construct( $post );
	}
	
	function __construct( $post ){
		global $MabBase;
		
		//get post type name
		$post_type = $MabBase->get_post_type();
		
		//remove unneeded metaboxes
		remove_meta_box( 'commentstatusdiv' , $MabBase->get_post_type() , 'normal' ); //removes comments status
		remove_meta_box( 'commentsdiv' , $MabBase->get_post_type() , 'normal' ); //removes comments
		
		//general design settings
		add_meta_box( 'mab-general-design-settings', __('Design Setting: General', 'mab' ), array( &$this, 'generalDesignSettings' ), $post_type, 'advanced', 'high' );
		
		//heading design settings
		add_meta_box( 'mab-heading-design-settings', __('Design Setting: Headings', 'mab' ), array(&$this, 'headingDesignSettings' ), $post_type, 'advanced', 'high' );
		
		
		//show metaboxes specific to action box type
		$type = $MabBase->get_actionbox_type( $post->ID );
		
		//load metaboxes specific to the action box type
		$this->loadActionBoxSpecificMetaboxes( $type );
		
		//other design settings
		add_meta_box( 'mab-other-design-settings', __('Design Setting: Others', 'mab' ), array(&$this, 'otherDesignSettings' ), $post_type, 'advanced', 'high' );
		
		//this is to allow developers to add their own metaboxes
		do_action( 'mab_loadActionBoxMetabox', $type );

	}
	
	function loadActionBoxSpecificMetaboxes( $type ){
		global $MabBase;

		//get post type name
		$post_type = $MabBase->get_post_type();
		
		switch( $type ){
			case 'optin':
				//optin metaboxes
				add_meta_box( 'mab-optin-settings', __('Opt In Form Settings','mab' ), array( &$this, 'optInSettings' ), $post_type, 'normal', 'high' );
				add_meta_box( 'mab-optin', __( 'Opt In Copy', 'mab' ), array( &$this, 'optIn' ), $post_type, 'normal', 'high' );
				//optin form design settings
				add_meta_box( 'mab-optin-form-design', __("Design Setting: Opt In Form", 'mab' ), array( &$this, 'optinFormDesignSettings' ), $post_type, 'advanced', 'high' );
				//optin form image design settings
				add_meta_box( 'mab-optin-form-image', __('Design Setting: Opt In Form Image', 'mab' ), array(&$this, 'asideDesignSettings' ), $post_type, 'advanced', 'high' );
				
				break; ##BREAK
				
			default:
				add_meta_box( 'mab-aside-design-settings', __('Design Setting: Side Item (Image/Video)', 'mab' ), array(&$this, 'asideDesignSettings' ), $post_type, 'advanced', 'high' );
				break;
		}

	}
	
	/**
	 * The Meta Boxes
	 * ========================== */
	 
	/** GLOBAL DESIGN - applies to all action boxes? **/
	
	/* General Design Settings */
	function generalDesignSettings( $post ){
		mab_general_design_settings( $post );
	}
	
	/* Headings */
	function headingDesignSettings( $post ){
		mab_heading_design_settings( $post );
	}
	
	/* Action Box Aside - usually contains an image */
	function asideDesignSettings( $post ){
		mab_aside_design_settings( $post );
	}
	
	/* Other Design Settings */
	function otherDesignSettings( $post ){
		mab_other_design_settings( $post );
	}
	
	/** ALL ACTION BOXES **/
	/* General Settings */
	function actionBoxSettings( $post ){
		global $MabBase, $MabAdmin;

		$data['meta'] = $MabBase->get_mab_meta( $post->ID );
		$data['assets-url'] = MAB_ASSETS_URL;
		
		//get available action box styles
		$data['styles'] = ProsulumMabCommon::getStyles();
		
		$filename = 'metaboxes/type/actionbox-settings.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	
	/* Content */
	function actionBoxContent( $post ){
		global $MabBase, $MabAdmin;

		$data['meta'] = $MabBase->get_mab_meta( $post->ID );
		$data['assets-url'] = MAB_ASSETS_URL;
		$filename = 'metaboxes/type/actionbox-content.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	
	/* Aside */
	function actionBoxAside( $post ){
		global $MabBase, $MabAdmin;

		$data['meta'] = $MabBase->get_mab_meta( $post->ID );
		$data['assets-url'] = MAB_ASSETS_URL;
		$filename = 'metaboxes/type/actionbox-aside.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	
	/** OPT IN SPECIFIC **/
	function optIn( $post ){
		global $MabBase, $MabAdmin;

		$data['meta'] = $MabBase->get_mab_meta( $post->ID );
		$data['assets-url'] = MAB_ASSETS_URL;
		$filename = 'metaboxes/type/optin.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	
	function optInSettings( $post ){
		global $MabBase, $MabAdmin;

		$data['meta'] = $MabBase->get_mab_meta( $post->ID );
		$data['assets-url'] = MAB_ASSETS_URL;
		
		//get allowed optin providers
		$data['optin-providers'] = $MabAdmin->getAllowedOptinProviders();
		
		//get available action box styles
		$data['styles'] = ProsulumMabCommon::getStyles();
		
		$filename = 'metaboxes/type/optin-settings.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	
	function optinFormDesignSettings( $post ){
		mab_optin_form_design_settings( $post );
	}
	
	
	/** OTHER CUSTOM POST TYPES METABOX **/
	//put metabox in selected content types
	static function postActionBox( $post ){
		global $MabBase;
		
		$data['meta'] = $MabBase->get_mab_meta( $post->ID, 'post' );
		$data['assets-url'] = MAB_ASSETS_URL;
		$filename = 'metaboxes/post-action-box-optin.php';
		$box = ProsulumMabCommon::getView( $filename, $data );
		echo $box;
	}
	

}