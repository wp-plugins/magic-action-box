<?php

function mab_process_postmatic_optin_submit($result, $data){
	if(!class_exists('Prompt_Api') || empty($data['postmatic-action'])){
		// postmatic plugin not installed or activated
		MAB_Ajax::addMessage('Something went wrong. Please contact the website owner.');
		return false;
	}

	$user = array('user_email' => $data['email']);

	if(!empty($data['fname']))
		$user['first_name'] = $data['fname'];

	if(!empty($data['lname']))
		$user['last_name'] = $data['lname'];

	if($data['postmatic-action'] == 'unsubscribe'){
		$status = Prompt_Api::unsubscribe($data['email']);

		switch ( $status ) {
			case Prompt_Api::NEVER_SUBSCRIBED:
				$result = false;
				MAB_Ajax::addMessage("Is that address correct? It wasn't ever subscribed.");
				break;
			case Prompt_Api::ALREADY_UNSUBSCRIBED:
				$result = true;
				MAB_Ajax::addMessage("You've already unsubscribed.");
				break;
			case Prompt_Api::CONFIRMATION_SENT:
				$result = true;
				MAB_Ajax::addMessage("You're now unsubscribed, and you'll get one last email confirming this.");
				break;
		}
	} else {
		$status = Prompt_Api::subscribe( $user );

		switch ( $status ) {
			case Prompt_Api::INVALID_EMAIL:
				MAB_Ajax::addMessage('Email address is invalid.');
				$result = false;
				break;
			case Prompt_Api::ALREADY_SUBSCRIBED:
				MAB_Ajax::addMessage("You are already subscribed, but we're glad you wanted to make sure.");
				$result = true;
				break;
			case Prompt_Api::CONFIRMATION_SENT:
				MAB_Ajax::addMessage("You're subscribed. Now check your email for confirmation.");
				$result = true;
				break;
			case Prompt_Api::OPT_IN_SENT:
				MAB_Ajax::addMessage("Great! Now check your email for the final step.");
				$result = true;
				break;
		}
	}

	return $result;
}