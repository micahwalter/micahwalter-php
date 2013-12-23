<?php

	#################################################################

	function roles_get_by_id($id){
		
		$role = db_single(db_fetch("SELECT * FROM roles WHERE id=".intval($id)));
		
		return $role;
	
	}
	
	#################################################################

	function roles_get_all(){
			
		$rsp = db_fetch("SELECT * FROM roles ORDER BY id DESC");
	
		return $rsp['rows'];
	
	}
	


	#################################################################

	function roles_update_role(&$role_id, $update){

		$hash = array();
		foreach ($update as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_update('roles', $hash, "id={$role_id}");

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
	
	#################################################################

	function roles_delete_role($id){

		$enc_id = AddSlashes($id);
		$sql = "DELETE FROM roles WHERE id='{$enc_id}'";

		$rsp = db_write($sql);
		
		return $rsp;
	}

	