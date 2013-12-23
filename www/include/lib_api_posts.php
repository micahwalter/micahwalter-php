<?php

	loadlib('posts');
	
	#################################################################

	function api_posts_getInfo(){
		
		$id = request_int64("id");
		
		$post = posts_get_by_id($id);
				
		$out = array(
		    'post' => $post
		);

		api_output_ok($out);
	}

	# the end
