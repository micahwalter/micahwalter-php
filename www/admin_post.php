<?php
	include("include/init.php");
	loadlib('posts');
	
	login_ensure_loggedin();
		
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}

	$id = get_int64('id');
	
	#
	# update?
	#
	$ok = 1;
	
	if (post_str('change')){
		$title	= trim(post_str('title'));
		$body = trim(post_str('body'));
		$slug = trim(post_str('slug'));
		
		$post = array(
			'title' => $title,
			'body' => $body,
			'slug' => $slug
		);

		if (! posts_update_post($id, $post)){

			$smarty->assign('error_fail', 1);
			$ok = 0;
		}
		
		if ($ok){
			header("location: {$GLOBALS['cfg']['abs_root_url']}admin/posts");
			exit;
		}
	}
	
	$post = posts_get_by_id($id);

	#
	# output
	#

	$smarty->assign('post', $post);
	$smarty->display("page_admin_post.txt");
