<?php

	#################################################################

	function users_roles_get_by_user_id($id){
	
		$roles = db_fetch("SELECT * FROM users_roles WHERE user_id=".intval($id));
	
		$roles_names = array();
		foreach($roles['rows'] as $role){
			$role_name = roles_get_by_id($role['role_id']);
			$role_names[] = $role_name;
		}
	
		return $role_names;

	}


	#################################################################

	function users_roles_user_has_role($user_id, $role_id){

		$rsp = db_single(db_fetch("SELECT * FROM users_roles WHERE user_id=" . intval($user_id) . " AND role_id=" . intval($role_id)));
	
		if ($rsp)
			return TRUE;
		else
			return FALSE;

	}

	#################################################################

	function users_roles_user_has_role_by_name($user_id, $role_name){

		$role = roles_get_by_title($role_name);

		$rsp = db_single(db_fetch("SELECT * FROM users_roles WHERE user_id=" . intval($user_id) . " AND role_id=" . intval($role['id'])));
	
		if ($rsp)
			return TRUE;
		else
			return FALSE;

	}
	
	#################################################################

	function users_roles_update_users_roles($user_id, $update){
		
		### first delete all the users roles, because, stupid...
		$rsp = users_roles_delete_all_users_role($user_id);
		
		### this function creates or deletes ALL the roles for a given user
		if (!isset($update))
			return;
		
		foreach ($update as $role){
			users_roles_create_users_role($user_id, $role);
		} 	 
		
	}
	
	
	#################################################################

	function users_roles_create_users_role($user_id, $role_id){
		
		$role['user_id'] = $user_id;
		$role['role_id'] = $role_id;
		
		$hash = array();
		foreach ($role as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_insert('users_roles', $hash);
		
		if (!$ret['ok']) return $ret;

		$role['id'] = $ret['insert_id'];
		
		return array(
			'ok'	=> 1,
			'role'	=> $role,
		);
		
		
				
	}

	#################################################################

	function users_roles_delete_users_role($user_id, $role_id){
	
		$enc_user_id = AddSlashes($user_id);
		$enc_role_id = AddSlashes($role_id);
		
		$sql = "DELETE FROM users_roles WHERE user_id='{$enc_user_id}' AND role_id='{$enc_role_id}'";

		$rsp = db_write($sql);
		
		return $rsp;
		
	}

	#################################################################

	function users_roles_delete_all_users_role($user_id){
	
		$enc_user_id = AddSlashes($user_id);
		
		$sql = "DELETE FROM users_roles WHERE user_id='{$enc_user_id}'";

		$rsp = db_write($sql);
		
		return $rsp;
		
	}
