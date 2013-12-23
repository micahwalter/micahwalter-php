<?php

	#################################################################

	function roles_get_by_id($id){

		$user = users_get_by_id($id);
	
		$profile = array(
			'user' => $user
		);		
		
		$rsp = db_single(db_fetch("SELECT * FROM users_profile WHERE user_id=".intval($user['id'])));

		$profile['profile'] = $rsp;
	
		return $profile;
	
	}
	
	#################################################################

	function roles_get_all(){
			
		$rsp = db_fetch("SELECT * FROM roles ORDER BY id DESC");
	
		return $rsp['rows'];
	
	}
	


	#################################################################

	function roles_update_role(&$user, $update){
	
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

	function roles_create_role($role){
	
		$hash = array();
		foreach ($role as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_insert('roles', $hash);
		if (!$ret['ok']) return $ret;
	
		return array(
			'ok'	=> 1,
			'rsp' => $ret
		);
	
	}