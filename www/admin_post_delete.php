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
	# delete?
	#
	$ok = 1;
	
	if (post_str('delete')){
		
		if (! posts_delete_post($id)){

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
	$smarty->display("page_admin_post_delete.txt");
