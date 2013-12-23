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
		
		if (! roles_delete_role($id)){

			$smarty->assign('error_fail', 1);
			$ok = 0;
		}
		
		if ($ok){
			header("location: {$GLOBALS['cfg']['abs_root_url']}admin/roles");
			exit;
		}
	}
	
	$role = roles_get_by_id($id);
	
	#
	# output
	#

	$smarty->assign('role', $role);
	$smarty->display("page_admin_role_delete.txt");
