<?php
	include("include/init.php");
	loadlib('posts');

	login_ensure_loggedin();
	
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}
	
	#
	# update?
	#	
		
	$posts = posts_get_all();
	
	#
	# output
	#

	$smarty->assign('posts', $posts);
	$smarty->display("page_admin_posts.txt");