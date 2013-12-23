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
