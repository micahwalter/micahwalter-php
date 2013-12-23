<?php
	include("include/init.php");

	login_ensure_loggedin();
	
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}
		
	$users = users_get_all();
	
	#
	# output
	#

	$smarty->assign('users', $users);
	$smarty->display("page_admin_users.txt");