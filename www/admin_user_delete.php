<?php
	include("include/init.php");

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
		
		$user = users_get_by_id($id);
		
		if (! users_delete_user($user)){

			$smarty->assign('error_fail', 1);
			$ok = 0;
		}
		
		if ($ok){
			header("location: {$GLOBALS['cfg']['abs_root_url']}admin/users");
			exit;
		}
	}
	
	$user = users_get_by_id($id);
	
	#
	# output
	#

	$smarty->assign('user', $user);
	$smarty->display("page_admin_user_delete.txt");
