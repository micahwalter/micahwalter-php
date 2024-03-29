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
	
	#################################################################

	function profile_get_by_id($id){
	
		$user = users_get_by_id($id);
		
		$profile = array(
			'user' => $user
		);		
			
		$rsp = db_single(db_fetch("SELECT * FROM users_profile WHERE user_id=".intval($user['id'])));

		$profile['profile'] = $rsp;
		
		return $profile;
		
	}

	
	#################################################################

	function profile_update_profile(&$user, $update){
		
		$hash = array();
		foreach ($update as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_update('users_profile', $hash, "user_id={$user['id']}");

		if (!$ret['ok']) return $ret;

		cache_unset("USER-{$user['id']}");

		return array(
			'ok' => 1,
		);
		
	}

	#################################################################

	function profile_create_empty_profile($id){
		
		$profile['user_id'] = $id;
		
		$hash = array();
		foreach ($profile as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_insert('users_profile', $hash);
		if (!$ret['ok']) return $ret;
		
		return array(
			'ok'	=> 1,
			'rsp' => $ret
		);
		
	}
	