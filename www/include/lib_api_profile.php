<?php

	loadlib('profile');
	loadlib('api_oauth2_access_tokens');
	
	#################################################################

	function api_profile_getInfo(){
		
		$username = request_str("username");
		
		$profile = profile_get_by_username($username);
				
		$out = array(
			'username' => $username,
		    'profile' => $profile['profile']
		);

		api_output_ok($out);
	}

	#################################################################

	function api_profile_getProfile(){
		
		$access_token = request_str("access_token");

		$user_id = api_oauth2_access_tokens_get_user_by_token($access_token);

		$profile = profile_get_by_id($user_id);
				
		$out = array(
		    'profile' => $profile['profile']
		);

		api_output_ok($out);
	}

	# the end
