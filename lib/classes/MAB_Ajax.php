<?php

/**
 * Handles ajax stuff
 */
class MAB_Ajax extends MAB_Base{

    protected static $messages = array();

    public function processOptin(){
        $resultArray = array();

        // TODO: only do this if debugging
        $this->log('AJAX request payload: ' . print_r($_POST,true), 'debug');

        /**
         * NOTES: 'api' is basically the object we want to use (like a controller)
         */
        if(!$_POST || !isset($_POST['optin-provider']) ){
            $resultArray = array('result'=>false);
        }else{
            $data = stripslashes_deep($_POST);
            $provider = sanitize_text_field($_POST['optin-provider']);
            $result = apply_filters("mab_process_{$provider}_optin_submit", false, $data);
            $resultArray['result'] = apply_filters('mab_process_optin_submit', $result, $provider, $data);
        }

        $resultArray['optin-provider'] = $provider;
        // TODO: Get Messages
        $resultArray['msgs'] = $this->getMessages();
        
        //this header will allow ajax request from the home domain, this can be a lifesaver when domain mapping is on
        if(function_exists('home_url')) header('Access-Control-Allow-Origin: '.home_url());

        header('Content-type: application/json');
        $jsonData = json_encode($resultArray);

        print $jsonData;
        
        die();
    }

	/**
	 * Main entry point for all ajax stuff
     * 
	 * @return  json
	 */
	public function process(){
		$resultArray = array();

		// TODO: only do this if debugging
		$this->log('AJAX request payload: ' . print_r($_POST,true), 'debug');

		/**
		 * NOTES: 'api' is basically the object we want to use (like a controller)
		 */
        if(!$_POST || !isset($_POST['task']) || !isset($_POST['api'])){
            $resultArray = array('result'=>false);
        }else{

            $api = $this->MAB($_POST['api']);

            if(is_object($api) && method_exists($api, $_POST['task'])){
            	$resultArray['result'] = $api->$_POST['task']();
            	$this->log("API {$_POST['api']} and Task {$_POST['task']} exists", 'debug');
            } else {
            	// TODO: Set error message
            	// //$this->error('Method "'.$_POST['task'].'" doesn\'t exist for controller : "'.$_POST['api']);
            	$this->log("Method '{$_POST['task']}' does not exist in API '{$_POST['api']}'", 'debug');
            }
        }

        // TODO: Get Messages
       	$resultArray['msgs'] = $this->getMessages();
       	
        //this header will allow ajax request from the home domain, this can be a lifesaver when domain mapping is on
        if(function_exists('home_url')) header('Access-Control-Allow-Origin: '.home_url());

        header('Content-type: application/json');
        $jsonData = json_encode($resultArray);

        print $jsonData;
        
        die();
	}


    /**
     * For use with wp_localize_script()
     * @return array
     */
    public static function getAjaxData(){
        return array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'action' => 'mab-process-optin',
            'spinner' => admin_url('images/wpspin_light.gif')
            );
    }


    /**
     * Setup ajax
     */
    public static function setup(){
        $ajax = MAB('ajax');
        // note: wp ajax is always run in admin context
        add_action( 'wp_ajax_nopriv_mab-process-optin', array($ajax, 'processOptin') );
        add_action( 'wp_ajax_mab-process-optin', array($ajax, 'processOptin'));
    }


	/**
	 * Return ajax messages
	 * @return array
	 */
	public static function getMessages(){
		return self::$messages;
	}


    /**
     * Add to ajax messages
     */
    public static function addMessage($msg){
        self::$messages[] = $msg;
    }
}