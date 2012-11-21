<?php

/**
 * Get an action box
 * @param int $actionBoxId - Post ID of action box
 * @param bool $loadAssets - whether to load action box assets or not
 * @param bool $forceShow - default FALSE. USed only if $actionBoxId is not set. 
                            If TRUE will show the action box even if the post
 * it is being shown in has not set the action box to be shown "Manually"
 * @return string - HTML of action box. Or empty string
 */
function mab_get_actionbox( $actionBoxId = null, $loadAssets = true, $forceShow = false ){
	global $post, $MabBase, $Mab;
	$actionBox = '';
	
	if( is_null( $actionBoxId ) || $actionBoxId === '' ){
		/** Get action box used for a post - if it is specified **/
		
		//get postmeta. NOTE: This is not postmeta from Action Box but
		//from a regular post/CPT where Action Box is to be shown
		$postmeta = $MabBase->get_mab_meta( $post->ID, 'post' );
		
		//return nothing if action box is disabled or if placement is not set to 'manual'
		if( !isset( $postmeta['post-action-box'] ) || $postmeta['post-action-box'] === '' ){
			/** Action box is "Disabled" or not set. **/
			return '';
		} elseif( !$forceShow && $postmeta['post-action-box-placement'] != 'manual' ){
			/** Action box must be set to show "manually" **/
			return '';
		}
		
		$actionBoxId = $postmeta['post-action-box'];
	}
	
	$actionBoxObj = new MAB_ActionBox( $actionBoxId );
	
	$actionBox = $actionBoxObj->getActionBox(null, $loadAssets); //also loads assets
	
	return $actionBox;
}
