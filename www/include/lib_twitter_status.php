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

		$cache_key = "twitter_status_{$status['twitter_id']}";
		cache_set($cache_key, $status, "cache locally");

		$cache_key = "twitter_status_{$status['id']}";
		cache_set($cache_key, $status, "cache locally");

		return $status;
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

			$cache_key = "twitter_status_{$twitter_status['twitter_id']}";
			cache_unset($cache_key);

			$cache_key = "twitter_status_{$twitter_status['id']}";
			cache_unset($cache_key);
		}

		return $rsp;
	}

	#################################################################

	function twitter_status_get_by_id($id){

		$cache_key = "twitter_status_{$id}";
		$cache = cache_get($cache_key);

		if ($cache['ok']){
			#return $cache['data'];
		}

		$enc_id = AddSlashes($id);

		$sql = "SELECT * FROM TwitterStatus WHERE id='{$enc_id}'";
		$rsp = db_fetch($sql);
		$status = db_single($rsp);

		#cache_set($cache_key, $status, "cache locally");
		return $status;
	}
		
	#################################################################

	function twitter_status_get_from_url() {
		
		if ($id = get_int64("id")){
			$status = twitter_status_get_by_id($id);
		}
				
		else {}

		if (! $status){
			error_404();
		}

		

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
	
	function twitter_status_get_users_latest_status($id, $more=array()) {
		
		$enc_id = AddSlashes($id);
				
		$sql = "SELECT * FROM TwitterStatus WHERE twitter_id='{$enc_id}' ORDER BY id ASC";
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
	

?>