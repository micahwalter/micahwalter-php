<?php
	
	#################################################################

	function twitter_status_create_status($status){

		$hash = array();

		foreach ($status as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$rsp = db_insert('TwitterStatus', $hash);

		if (!$rsp['ok']){
			return null;
		}

		return $rsp;
	}

	#################################################################

	function twitter_status_update_status(&$twitter_status, $update){

		$hash = array();
		
		foreach ($update as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$enc_id = AddSlashes($twitter_status['id']);
		$where = "id='{$enc_id}'";

		$rsp = db_update('TwitterStatus', $hash, $where);

		if ($rsp['ok']){

			$twitter_status = array_merge($twitter_status, $update);

		}

		return $rsp;
	}

	#################################################################

	function twitter_status_get_by_id($id){

		$enc_id = AddSlashes($id);

		$sql = "SELECT * FROM TwitterStatus WHERE id='{$enc_id}'";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);

		return $status;
	}

	#################################################################

	function twitter_status_get_by_twitter_id($twitter_id){

		$sql = "SELECT * FROM TwitterStatus WHERE twitter_id='{$twitter_id}'";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);

		return $status;
	}
		
	#################################################################
	
	function twitter_status_get_statuses($more=array()) {
				
		$sql = "SELECT * FROM TwitterStatus ORDER BY id DESC";
		return db_fetch_paginated($sql, $more);
	}

	#################################################################
	
	function twitter_status_get_latest_status($more=array()) {
				
		$sql = "SELECT * FROM TwitterStatus ORDER BY id DESC";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);
		
		return $status;
	}

	#################################################################
	
	function twitter_status_get_users_latest_status($twitter_user_id) {
		
		$enc_twitter_user_id = AddSlashes($twitter_user_id);
				
		$sql = "SELECT * FROM TwitterStatus WHERE twitter_user_id='{$enc_twitter_user_id}' ORDER BY twitter_id DESC";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);
		
		return $status;
	}
	
	#################################################################
	
	function twitter_status_get_oldest_status($more=array()) {
				
		$sql = "SELECT * FROM TwitterStatus ORDER BY id ASC";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);
		
		return $status;
	}
	
	function twitter_status_get_users_recent_tweets(){
		
	}
	

?>