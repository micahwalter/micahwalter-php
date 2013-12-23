<?php

	#################################################################

	function roles_get_by_id($id){
	
	}
	
	#################################################################

	function roles_get_all(){
			
		$rsp = db_fetch("SELECT * FROM roles ORDER BY id DESC");
	
		return $rsp['rows'];
	
	}
	


	#################################################################

	function roles_update_role(&$user, $update){

	
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

	
	}

	