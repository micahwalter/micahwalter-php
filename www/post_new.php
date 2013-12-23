<?php
	include("include/init.php");
	loadlib("posts");
	login_ensure_loggedin();

	#
	# create?
	#
	$ok = 1;
	
	if (post_str('create')){
		$title	= trim(post_str('title'));
		$body	= post_str('body');
		$slug = trim(post_str('slug'));
		
		$post = array(
			'title' => $title,
			'body' => $body,
			'slug' => $slug
		);
		
		$rsp = posts_create_post($GLOBALS['cfg']['user'], $post);
		
		#if (! posts_create_post($GLOBALS['cfg']['user'], $post)){

		#	$smarty->assign('error_fail', 1);
		#	$ok = 0;
		#}
		
		if ($ok){
			header("location: {$rsp['post_id']}");
			exit;
		}
	}

	#
	# output
	#

	$smarty->display("page_post_new.txt");
