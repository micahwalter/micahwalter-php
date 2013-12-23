<?php

	loadlib('profile');
	
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

	# the end
