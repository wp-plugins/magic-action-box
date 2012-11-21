<?php
/**
 * Wysija Form
 */

/** TODO: stop if no lists selected? **/
$optinMeta = isset( $data['optin'] ) && is_array( $data['optin'] ) ? $data['optin'] : array();
$wysija = isset( $optinMeta['wysija'] ) && is_array( $optinMeta['wysija'] ) ? $optinMeta['wysija'] : array();
$formIdReal = 'mab-wysija-' . $data['mab-html-id'];
?>
<div id="msg-<?php echo $formIdReal; ?>" class="mab-wysija-msg ajax"></div>
<form id="<?php echo $formIdReal; ?>" method="post" action="#wysija" class="widget_wysija form-valid-sub">
	
	<?php /** Create the input fields **/ ?>
	<?php $fields = isset( $wysija['fields'] ) && is_array( $wysija['fields'] ) ? $wysija['fields'] : array(); 
	
	//placeholder text
	if( in_array( 'firstname', $fields ) && in_array('lastname', $fields ) ){
		//first and last name fields are enabled
		$holderFName = 'Enter your first name';
		$holderLName = 'Enter your last name';
	} else {
		//one of the fields are enabled
		$holderFName = 'Enter your name';
		$holderLName = 'Enter your last name';
	}
	?>
	
	<?php if( in_array( 'firstname', $fields ) ): ?>
	<div class="mab-field wysija-p-firstname mab-field-firstname">
		<label for="<?php echo $formIdReal; ?>-firstname">First Name</label>
		<input id="<?php echo $formIdReal; ?>-firstname" class="wysija-firstname validate[required]" type="text" name="wysija[user][firstname]" placeholder="<?php echo $holderFName; ?>" />
	</div>
	<?php endif; ?>
	
	<?php if( in_array( 'lastname', $fields ) ): ?>
	<div class="mab-field wysija-p-lastname mab-field-lastname">
		<label for="<?php echo $formIdReal; ?>-lastname">Last Name</label>
		<input id="<?php echo $formIdReal; ?>-lastname" class="wysija-lastname validate[required]" type="text" name="wysija[user][lastname]" placeholder="<?php echo $holderLName; ?>" />
	</div>
	<?php endif; ?>
	
	<div class="mab-field wysija-p-email mab-field-email">
		<label for="<?php echo $formIdReal; ?>-wysija-to">Email</label>
		<input id="<?php echo $formIdReal; ?>-wysija-to" class="wysija-email validate[required,custom[email]]" type="text" name="wysija[user][email]" placeholder="Enter your email" />
		<?php /** TODO: ask ben@wysija.com what validate[required,custom[email]] class is supposed to do **/ ?>
	</div>
	
	<?php $submit = isset( $wysija['button-label'] ) ? $wysija['button-label'] : ''; ?>
	<div class="mab-field wysija-p-email mab-field-submit">
		<input type="submit" class="wysija-submit wysija-submit-field" name="submit" value="<?php echo esc_attr( $submit ); ?>" />
	</div>
	
	<?php /** Email Lists field **/
	$listExplode = isset( $wysija['lists'] ) && is_array( $wysija['lists'] ) ? esc_attr( implode(', ', $wysija['lists'] ) ) : '';
	?>
	<input type="hidden" name="wysija[user_list][list_ids]" value="<?php echo $listExplode; ?>" />

	<?php /** Success Message **/
	$success = !empty( $wysija['success-message'] ) ? $wysija['success-message'] : ''; ?>
	<input type="hidden" name="message_success" value="<?php echo esc_attr( $success ); ?>" />
	
	<input type="hidden" name="formid" value="<?php echo $formIdReal; ?>" />
	<input type="hidden" name="action" value="save" />
	<input type="hidden" name="controller" value="subscribers" />
	<?php echo $data['subscriber-nonce']; ?>
	<input type="hidden" value="1" name="wysija-page" />
	<input type="hidden" value="<?php echo wp_create_nonce('wysija_ajax'); ?>" id="wysijax" />
	<?php /** TODO: ask ben@wysija why use id="wysijax" coz may have a problem validating when multiple wysija forms are used **/ ?>
	
</form>
