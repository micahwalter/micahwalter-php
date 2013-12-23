<?php

	loadlib('profile');
	
	#################################################################

	function posts_get_by_id($id){

		$post = db_single(db_fetch("SELECT * FROM posts WHERE id=".intval($id)));
		
		$profile = profile_get_by_id($post['user_id']);
		
		$post['profile'] = $profile['profile'];
		$post['profile']['username'] = $profile['user']['username']; 

		return $post;
	}
	
	#################################################################
	
	function posts_get_by_user_id($id){
		
		$posts = db_fetch("SELECT * FROM posts WHERE user_id=".intval($id) . " ORDER BY id DESC");

		return $posts['rows'];
	}
	
	#################################################################
	
	function posts_create_post(&$user, $post){
	
		$post['user_id'] = $user['id'];
		
		$hash = array();
		foreach ($post as $k => $v){
			$hash[$k] = AddSlashes($v);
		}

		$ret = db_insert('posts', $hash);
		if (!$ret['ok']) return $ret;
		
		return array(
			'ok'	=> 1,
			'post'	=> $post,
			'post_id' => $ret['insert_id']
		);
	}
