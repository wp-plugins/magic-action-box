function hex2rgb(hex) {
  var c, o = [], k = 0, m = hex.match(
    /^#(([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})|([0-9a-f])([0-9a-f])([0-9a-f]))$/i);
      
  if (!m) return {r:0,g:0,b:0};
  for (var i = 2, s = m.length; i < s; i++) {
    if (undefined === m[i]) continue;
    c = parseInt(m[i], 16);
    o[k++] = c + (i > 4 ? c * 16 : 0);
  }
  var obj = {r:o[0], g:o[1], b:o[2]};
  return '' + obj.r + ',' + obj.g + ',' + obj.b + '';
}

jQuery(document).ready(function(){
	
	/**
	 * Sales Box Button Type Select
	 */
	jQuery( '#mab-option-button-type-select input' ).change('keyup keydown change', function(event){
		var $selected_button_type = jQuery( '#mab-option-button-type-select input[type=radio]:checked' ).val();
		
		if( $selected_button_type == 'css3' ){
			jQuery( '.mab-option-box.mab-used-for-image-button' ).hide();
			jQuery( '.mab-option-box.mab-used-for-css3-button:hidden' ).show();
		} else if ( $selected_button_type = 'image' ){
			jQuery( '.mab-option-box.mab-used-for-image-button:hidden' ).show();
			jQuery( '.mab-option-box.mab-used-for-css3-button' ).hide();
		}
		
	}).change();
	
	/**
	 * Button preview for CSS3 button design dropdown
	 */
	jQuery( '#mab-button-select' ).bind('keyup keydown change', function(event){
		var $this = jQuery( this );
		var $key = $this.val();
		var $example = jQuery( '#mab-example-button' );
		//remove all classes
		$example.removeClass();
		//recreate classes
		$example.addClass('mab-example-button mab-button-' + $key );
	}).change();
	
	/**
	 * Button preview for CSS3 Button text
	 */
	jQuery( '#mab-button-text' ).bind('blur keyup', function(event){
		var $button = jQuery( '#mab-example-button' );
		var $this = jQuery( this );
		$button.text( $this.val() );
	}).blur();
	
	/**
	 * Optin Settings
	 */
	//show list for selected email provider
	jQuery( '#mab-optin-provider' ).bind('keyup keydown change', function(event){
		
		//get selected value
		var $this = jQuery( this );
		var val = $this.val();
		
		var $div = jQuery( '#mab-' + val + '-settings' );
		
		//hide all dependent containers
		jQuery( '.mab-optin-list-dependent-container' ).hide();
		
		//show related dependent container
		$div.show('fast');
		
	}).change();
	
	//Force Update Optin Lists from Email Provider servers
	jQuery( '.mab-optin-get-list').click( function(){
	
		var $provider = jQuery( '#mab-optin-provider' );
		var $list = jQuery( this ).siblings( '.mab-optin-list' );
		var $feedback = jQuery( this ).siblings( '.ajax-feedback' );
		
		var val = $provider.val();
		$list.attr('disabled','disabled');
		$feedback.css('visibility','visible');
		
		jQuery.post(
			ajaxurl,
			{
				action: 'mab_optin_get_lists',
				provider: val
			},
			function( data, status){
				$list.removeAttr('disabled');
				$list.empty();
				jQuery.each( data, function( i, val ){
					$item = jQuery( '<option value="' +this.id+ '">' +this.name+ '</option>' );
					$list.append( $item );
				});
				$feedback.css('visibility','hidden');
			},
			'json'
		);

		return false;
	});
	
	//Process manual opt in form code into useable format
	jQuery( '#mab-process-manual-optin-code' ).click( function(){
		var $theCode = jQuery( '#mab-optin-manual-code' ).val();
		var $submitValue = jQuery( '#mab-optin-submit-value' ).val();
		
		jQuery('#mab-optin-process-manual-feedback').css('visibility','visible');
		
		jQuery.post(
			ajaxurl,
			{
				action: 'mab_optin_process_manual_code',
				optinFormCode: $theCode,
				submitValue: $submitValue
			},
			function( data, status ){
				jQuery('#mab-optin-process-manual-feedback').css('visibility','hidden');
				jQuery('#mab-optin-manual-processed-code').val(data);
			},
			'json'
			
		);
		
		return false;
	});
	
	//Show preview for action Box style on change of dropdown
	jQuery( '#mab-style' ).bind('keyup keydown change', function(){
		var $this = jQuery( this );
		var $selectedStyle = $this.val();
		
		if( $selectedStyle == 'none' ){
			jQuery('#mab-style-preview-heading').hide();
			jQuery('#mab-user-style').hide();
		} else if( $selectedStyle == 'user'){
			jQuery('#mab-style-preview-heading').hide();
			jQuery('#mab-user-style').show();
		} else {
			jQuery('#mab-style-preview-heading').show();
			jQuery('#mab-user-style').hide();
		}
		
		//hide all thumbs
		jQuery( '#mab-style-preview li' ).hide();
		//show corresponding thumb
		jQuery( '#mab-style-' + $selectedStyle + '-preview' ).show();
	}).change();
	
	
	
	/**
	 * Other Stuff
	 */
	//remove the "Preview" button. we don't need it and only confuses other users.
	jQuery( '#post-preview' ).remove();

});
