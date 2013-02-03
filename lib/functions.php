<?php

/**
 * Register action box
 * 
 * Form the array $box like this:
 * $box = array(
 *    'type'        => 'action-box-type', //use letters, numbers, underscore, dash only
 *    'name'        => 'Human readable name',
 *    'description' => 'Short description about the action box type'
 * );
 * 
 * @param  array  $box required
 * @return none
 */
function mab_register_action_box( $box ){
	global $MabBase;
	$MabBase->register_action_box_type( $box );
}