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
