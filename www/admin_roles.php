<?php
	include("include/init.php");

	login_ensure_loggedin();
	
	### and that we are staff
	
	if ( ! auth_has_role('staff')){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit;
	}
	
	#
	# update?
	#
	$ok = 1;
	
	if (post_str('add')){
		$role	= array(
			'title' => trim(post_str('role'))
		);
				
		$rsp = roles_create_role($role);

		### error check this...

	}
	
		
	$roles = roles_get_all();
	
	#
	# output
	#

	$smarty->assign('roles', $roles);
	$smarty->display("page_admin_roles.txt");