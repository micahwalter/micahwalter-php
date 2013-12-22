<?php

	#################################################################

	function profile_get_by_username($username){
	
		$user = users_get_by_username($username);
		
		$profile = array(
			'user' => $user
		);		
			
		$rsp = db_single(db_fetch("SELECT * FROM users_profile WHERE user_id=".intval($user['id'])));

		$profile['profile'] = $rsp;
		
		return $profile;
		
	}
		
	